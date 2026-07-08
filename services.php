<?php
// ============================================
// 1. DATABASE CONNECTION
// ============================================
// Database configuration
$db_host = '127.0.0.1';
$db_name = '4digisol_db';
$db_user = 'root';
$db_pass = '';

// Create MySQLi connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8mb4");

// ============================================
// 2. SERVICES BACKEND CLASS
// ============================================
class ServicesBackend {
    private $db;
    private $table = 'services';
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getAllServices($category = null, $search = null) {
        $sql = "SELECT * FROM {$this->table} WHERE is_active = 1";
        $params = [];
        $types = "";
        
        if ($category && $category !== 'all') {
            $sql .= " AND category = ?";
            $params[] = $category;
            $types .= "s";
        }
        
        if ($search && !empty($search)) {
            $sql .= " AND (title LIKE ? OR description LIKE ? OR service_id LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types .= "sss";
        }
        
        $sql .= " ORDER BY sort_order ASC, id ASC";
        
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            return [];
        }
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $services = [];
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
        
        return $services;
    }
    
    public function getServiceStats() {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN category = 'seo' THEN 1 ELSE 0 END) as seo_count,
                    SUM(CASE WHEN category = 'development' THEN 1 ELSE 0 END) as dev_count,
                    SUM(CASE WHEN category = 'marketing' THEN 1 ELSE 0 END) as marketing_count
                FROM {$this->table} 
                WHERE is_active = 1";
        
        $result = $this->db->query($sql);
        
        if (!$result) {
            return ['total' => 0, 'seo_count' => 0, 'dev_count' => 0, 'marketing_count' => 0];
        }
        
        return $result->fetch_assoc();
    }
}

// ============================================
// 3. INITIALIZE AND GET DATA
// ============================================
$servicesBackend = new ServicesBackend($conn);

// Get filters from request
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Get services from database
$services = $servicesBackend->getAllServices($category, $search);
$stats = $servicesBackend->getServiceStats();

// Debug - Uncomment to see what's being fetched
// echo '<pre>';
// print_r($services);
// echo '</pre>';
// exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Digital Marketing Agency</title>
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #0a0a0a;
            color: #ffffff;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }
        
        .service-card {
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .tag {
            background: rgba(255,255,255,0.06);
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            color: #aaa;
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        
        .tag:hover {
            background: rgba(166,241,59,0.15);
            color: #A6F13B;
            border-color: rgba(166,241,59,0.2);
        }
        
        .tag.active-filter {
            background: #A6F13B;
            color: #101010;
            border-color: #A6F13B;
        }
        
        .lime {
            color: #A6F13B;
        }
        
        .bg-lime {
            background-color: #A6F13B;
        }
        
        .text-lime {
            color: #A6F13B;
        }
        
        .border-lime {
            border-color: #A6F13B;
        }
        
        .from-lime\/10 {
            --tw-gradient-from: rgba(166, 241, 59, 0.1);
        }
        
        .to-lime\/5 {
            --tw-gradient-to: rgba(166, 241, 59, 0.05);
        }
        
        /* Navbar styles */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 0 1.5rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        @media (min-width: 640px) {
            .navbar {
                height: 84px;
                padding: 0 2rem;
            }
        }
        
        .navbar .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }
        
        .navbar .logo span {
            color: #A6F13B;
        }
        
        .navbar .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .navbar .nav-links a {
            color: #aaa;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s;
        }
        
        .navbar .nav-links a:hover {
            color: #A6F13B;
        }
        
        .navbar .nav-links .btn-primary {
            background: #A6F13B;
            color: #101010;
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
        }
        
        .navbar .nav-links .btn-primary:hover {
            background: #94d935;
        }
    </style>
</head>
<body>

<!-- ============ NAVBAR ============ -->
<nav class="navbar">
    <a href="index.php" class="logo">
        <span>4</span> Digi Sol
    </a>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="services.php" style="color: #A6F13B;">Services</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="contact.php" class="btn-primary">Get Started</a>
    </div>
</nav>

<!-- spacer -->
<div class="pt-[70px] sm:pt-[84px]"></div>

<!-- ============ SERVICES HERO ============ -->
<section class="relative overflow-hidden bg-gradient-to-b from-[#0a0a0a] to-[#0f0f0f] border-b border-white/5">
  <div class="max-w-[1180px] mx-auto px-4 sm:px-6 py-16 sm:py-24">
    <div class="text-center">
      <span class="inline-block text-lime text-sm font-semibold tracking-wider uppercase mb-3">Our Services</span>
      <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold mb-4">
        Solutions That Drive<br>
        <span class="text-lime">Real Results</span>
      </h1>
      <p class="text-gray-400 text-sm sm:text-base max-w-2xl mx-auto">
        From strategy to execution, we deliver comprehensive digital solutions 
        that help businesses grow and succeed online.
      </p>
      
      <!-- Search Bar -->
      <div class="max-w-xl mx-auto mt-8">
        <form method="GET" action="" id="searchForm" class="flex gap-2">
          <div class="flex-1 relative">
            <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500'></i>
            <input 
              type="text" 
              name="search"
              id="searchInput"
              placeholder="Search services..." 
              value="<?php echo htmlspecialchars($search ?? ''); ?>"
              class="w-full bg-[#1a1a1a] border border-white/10 rounded-full py-3 pl-10 pr-4 text-white placeholder-gray-500 focus:outline-none focus:border-lime/50 transition"
            >
          </div>
          <button type="submit" class="bg-lime text-[#101010] font-semibold rounded-full px-6 py-3 hover:brightness-95 transition">
            <i class='bx bx-search'></i> Search
          </button>
          <?php if ($search || $category !== 'all'): ?>
            <a href="services.php" class="bg-white/10 text-white font-semibold rounded-full px-6 py-3 hover:bg-white/20 transition">
              <i class='bx bx-x'></i> Clear
            </a>
          <?php endif; ?>
        </form>
      </div>
      
      <!-- Category Filters -->
      <div class="flex flex-wrap justify-center gap-2 mt-6" id="categoryFilters">
        <a href="services.php" class="tag <?php echo $category === 'all' ? 'active-filter' : ''; ?> transition">
          All Services
        </a>
        <a href="services.php?category=seo" class="tag <?php echo $category === 'seo' ? 'active-filter' : ''; ?> transition">
          SEO
        </a>
        <a href="services.php?category=development" class="tag <?php echo $category === 'development' ? 'active-filter' : ''; ?> transition">
          Development
        </a>
        <a href="services.php?category=marketing" class="tag <?php echo $category === 'marketing' ? 'active-filter' : ''; ?> transition">
          Marketing
        </a>
      </div>
      
      <!-- Results Count -->
      <div class="mt-6 text-sm text-gray-500" id="resultsCount">
        <span id="serviceCount"><?php echo count($services); ?></span> services available
      </div>
    </div>
  </div>
</section>

<!-- ============ SERVICES GRID ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 py-16">
  <?php if (count($services) > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="servicesGrid">
      <?php foreach ($services as $service): ?>
        <div class="service-card group bg-[#0f0f0f] border border-white/5 rounded-2xl p-6 hover:border-lime/30 hover:bg-[#141414] transition-all duration-300">
          <div class="w-14 h-14 rounded-xl bg-lime/10 flex items-center justify-center text-2xl text-lime group-hover:scale-110 transition-transform duration-300">
            <i class='<?php echo htmlspecialchars($service['icon'] ?? 'bx bx-cube'); ?>'></i>
          </div>
          
          <h3 class="text-xl font-bold mt-4 mb-2 group-hover:text-lime transition">
            <?php echo htmlspecialchars($service['title'] ?? 'Untitled Service'); ?>
          </h3>
          
          <p class="text-gray-400 text-sm leading-relaxed line-clamp-3">
            <?php 
            // Check if description exists and is not empty
            if (!empty($service['description'])) {
                echo htmlspecialchars($service['description']);
            } else {
                echo 'No description available.';
            }
            ?>
          </p>
          
          <div class="mt-3">
            <span class="text-xs bg-white/5 px-3 py-1 rounded-full text-gray-400">
              <?php echo ucfirst(htmlspecialchars($service['category'] ?? 'general')); ?>
            </span>
          </div>
          
          <div class="flex items-center justify-between mt-4 pt-4 border-t border-white/5">
            <div class="flex items-center gap-4 text-xs">
              <?php if (!empty($service['projects'])): ?>
                <span class="text-gray-400">
                  <span class="text-lime font-bold"><?php echo htmlspecialchars($service['projects']); ?></span> Projects
                </span>
              <?php endif; ?>
              <?php if (!empty($service['satisfaction'])): ?>
                <span class="text-gray-400">
                  <span class="text-lime font-bold"><?php echo htmlspecialchars($service['satisfaction']); ?></span> Satisfaction
                </span>
              <?php endif; ?>
            </div>
            
            <!-- UPDATED: Link to service-details.php with service_id as parameter -->
            <a href="service-details.php?id=<?php echo htmlspecialchars($service['service_id']); ?>" class="text-lime hover:underline text-sm font-medium">
              Learn More <i class='bx bx-right-arrow-alt'></i>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <!-- No Results -->
    <div class="text-center py-16">
      <div class="text-6xl mb-4">🔍</div>
      <h3 class="text-2xl font-bold mb-2">No Services Found</h3>
      <p class="text-gray-400 mb-4">Try adjusting your search or filter criteria</p>
      <a href="services.php" class="bg-lime text-[#101010] font-semibold rounded-full px-6 py-3 hover:brightness-95 transition inline-block">
        View All Services
      </a>
    </div>
  <?php endif; ?>
</section>

<!-- ============ STATS SECTION ============ -->
<?php if ($stats && $stats['total'] > 0): ?>
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 pb-16">
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="bg-[#0f0f0f] border border-white/5 rounded-2xl p-6 text-center">
      <div class="text-3xl font-bold text-lime"><?php echo $stats['total'] ?? 0; ?></div>
      <div class="text-gray-400 text-sm mt-1">Total Services</div>
    </div>
    <div class="bg-[#0f0f0f] border border-white/5 rounded-2xl p-6 text-center">
      <div class="text-3xl font-bold text-lime"><?php echo $stats['seo_count'] ?? 0; ?></div>
      <div class="text-gray-400 text-sm mt-1">SEO Services</div>
    </div>
    <div class="bg-[#0f0f0f] border border-white/5 rounded-2xl p-6 text-center">
      <div class="text-3xl font-bold text-lime"><?php echo $stats['dev_count'] ?? 0; ?></div>
      <div class="text-gray-400 text-sm mt-1">Development</div>
    </div>
    <div class="bg-[#0f0f0f] border border-white/5 rounded-2xl p-6 text-center">
      <div class="text-3xl font-bold text-lime"><?php echo $stats['marketing_count'] ?? 0; ?></div>
      <div class="text-gray-400 text-sm mt-1">Marketing</div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ CTA SECTION ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 pb-16">
  <div class="relative bg-gradient-to-r from-lime/10 to-lime/5 border border-lime/20 rounded-3xl p-8 sm:p-12 overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-lime/5 rounded-full blur-3xl"></div>
    <div class="relative z-10 text-center">
      <h2 class="text-2xl sm:text-3xl font-bold mb-3">
        Ready to Transform Your Business?
      </h2>
      <p class="text-gray-400 text-sm sm:text-base max-w-2xl mx-auto mb-6">
        Let's discuss how our services can help you achieve your goals. 
        Get a free consultation with our expert team.
      </p>
      <div class="flex flex-wrap justify-center gap-3">
        <a href="contact.php" class="bg-lime text-[#101010] font-semibold rounded-full px-8 py-3 hover:brightness-95 transition">
          Get Started
        </a>
        <a href="about.php" class="border border-white/20 text-white font-semibold rounded-full px-8 py-3 hover:bg-white/10 transition">
          Learn About Us
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="bg-[#0a0a0a] border-t border-white/5 py-12">
  <div class="max-w-[1180px] mx-auto px-4 sm:px-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <div>
        <h3 class="text-xl font-bold mb-4">4 Digi Sol</h3>
        <p class="text-gray-400 text-sm">Empowering brands through creative solutions — web, branding & digital design for over a decade.</p>
      </div>
      <div>
        <h4 class="font-semibold mb-4">Company</h4>
        <ul class="space-y-2 text-sm text-gray-400">
          <li><a href="about.php" class="hover:text-lime transition">About Us</a></li>
          <li><a href="#" class="hover:text-lime transition">Our Team</a></li>
          <li><a href="#" class="hover:text-lime transition">Privacy Policy</a></li>
          <li><a href="#" class="hover:text-lime transition">Terms and Conditions</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold mb-4">Support</h4>
        <ul class="space-y-2 text-sm text-gray-400">
          <li><a href="contact.php" class="hover:text-lime transition">Contact Us</a></li>
          <li><a href="#" class="hover:text-lime transition">FAQs</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold mb-4">Services</h4>
        <ul class="space-y-2 text-sm text-gray-400">
          <?php 
          // Get services for footer (limit to 3)
          $footer_services = array_slice($services, 0, 3);
          foreach ($footer_services as $footer_service): 
          ?>
            <li>
              <a href="service-details.php?id=<?php echo htmlspecialchars($footer_service['service_id']); ?>" class="hover:text-lime transition">
                <?php echo htmlspecialchars($footer_service['title']); ?>
              </a>
            </li>
          <?php endforeach; ?>
          <?php if (count($services) > 3): ?>
            <li><a href="services.php" class="hover:text-lime transition text-lime">View All Services</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <div class="border-t border-white/5 mt-8 pt-8 text-center text-sm text-gray-400">
      <p>© <?php echo date('Y'); ?> 4 Digi Sol. All rights reserved.</p>
    </div>
  </div>
</footer>

<script>
// Live search functionality
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  
  if (searchInput) {
    let timeout = null;
    searchInput.addEventListener('keyup', function(e) {
      clearTimeout(timeout);
      timeout = setTimeout(function() {
        const form = document.getElementById('searchForm');
        if (form) {
          form.submit();
        }
      }, 500);
    });
  }
});
</script>

</body>
</html>