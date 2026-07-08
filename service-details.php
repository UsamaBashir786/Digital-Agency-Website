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
// 2. GET SERVICE DETAILS
// ============================================
// Get service ID from URL
$service_id = isset($_GET['id']) ? $_GET['id'] : '';

// If no service ID, redirect to services page
if (empty($service_id)) {
    header('Location: services.php');
    exit;
}

// Fetch service details
$service = null;
$sql = "SELECT * FROM services WHERE service_id = ? AND is_active = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $service_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $service = $result->fetch_assoc();
} else {
    // Service not found, redirect to services page
    header('Location: services.php');
    exit;
}

// Get related services (same category, excluding current)
$related_services = [];
$sql = "SELECT * FROM services WHERE category = ? AND service_id != ? AND is_active = 1 ORDER BY sort_order ASC LIMIT 3";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $service['category'], $service_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $related_services[] = $row;
}

// Get service statistics
$stats_sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN category = 'seo' THEN 1 ELSE 0 END) as seo_count,
                SUM(CASE WHEN category = 'development' THEN 1 ELSE 0 END) as dev_count,
                SUM(CASE WHEN category = 'marketing' THEN 1 ELSE 0 END) as marketing_count
              FROM services 
              WHERE is_active = 1";
$stats_result = $conn->query($stats_sql);
$stats = $stats_result->fetch_assoc();

// Set page title
$page_title = $service['meta_title'] ?? $service['title'] . ' | 4 Digi Sol';
$meta_description = $service['meta_description'] ?? $service['description'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    
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
        
        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(166, 241, 59, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #A6F13B;
            flex-shrink: 0;
        }
        
        .stat-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .stat-box:hover {
            border-color: rgba(166, 241, 59, 0.3);
            background: rgba(166, 241, 59, 0.05);
        }
        
        .stat-box .number {
            font-size: 2rem;
            font-weight: 700;
            color: #A6F13B;
        }
        
        .stat-box .label {
            color: #aaa;
            font-size: 0.875rem;
            margin-top: 0.25rem;
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
        
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #aaa;
        }
        
        .breadcrumb a {
            color: #aaa;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #A6F13B;
        }
        
        .breadcrumb .current {
            color: #A6F13B;
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

<!-- ============ BREADCRUMB ============ -->
<div class="max-w-[1180px] mx-auto px-4 sm:px-6 py-4">
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <i class='bx bx-chevron-right text-xs'></i>
        <a href="services.php">Services</a>
        <i class='bx bx-chevron-right text-xs'></i>
        <span class="current"><?php echo htmlspecialchars($service['title']); ?></span>
    </div>
</div>

<!-- ============ SERVICE HERO ============ -->
<section class="relative overflow-hidden bg-gradient-to-b from-[#0a0a0a] to-[#0f0f0f] border-b border-white/5">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-6 py-12 sm:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-lime/10 flex items-center justify-center text-3xl text-lime">
                        <i class='<?php echo htmlspecialchars($service['icon'] ?? 'bx bx-cube'); ?>'></i>
                    </div>
                    <span class="text-xs bg-white/5 px-3 py-1 rounded-full text-gray-400 uppercase">
                        <?php echo ucfirst(htmlspecialchars($service['category'] ?? 'general')); ?>
                    </span>
                </div>
                
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold mb-4">
                    <?php echo htmlspecialchars($service['title']); ?>
                </h1>
                
                <p class="text-gray-400 text-base sm:text-lg leading-relaxed">
                    <?php echo htmlspecialchars($service['description'] ?? 'No description available.'); ?>
                </p>
                
                <div class="flex flex-wrap gap-6 mt-6">
                    <?php if (!empty($service['projects'])): ?>
                        <div>
                            <div class="text-2xl font-bold text-lime"><?php echo htmlspecialchars($service['projects']); ?></div>
                            <div class="text-xs text-gray-400">Projects Completed</div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($service['satisfaction'])): ?>
                        <div>
                            <div class="text-2xl font-bold text-lime"><?php echo htmlspecialchars($service['satisfaction']); ?></div>
                            <div class="text-xs text-gray-400">Client Satisfaction</div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="flex flex-wrap gap-3 mt-8">
                    <a href="contact.php" class="bg-lime text-[#101010] font-semibold rounded-full px-8 py-3 hover:brightness-95 transition">
                        Get Started
                    </a>
                    <a href="services.php" class="border border-white/20 text-white font-semibold rounded-full px-8 py-3 hover:bg-white/10 transition">
                        All Services
                    </a>
                </div>
            </div>
            
            <!-- Right Content - Stats -->
            <div class="grid grid-cols-2 gap-4">
                <div class="stat-box">
                    <div class="number"><?php echo $stats['total'] ?? 0; ?></div>
                    <div class="label">Total Services</div>
                </div>
                <div class="stat-box">
                    <div class="number"><?php echo $stats['seo_count'] ?? 0; ?></div>
                    <div class="label">SEO Services</div>
                </div>
                <div class="stat-box">
                    <div class="number"><?php echo $stats['dev_count'] ?? 0; ?></div>
                    <div class="label">Development</div>
                </div>
                <div class="stat-box">
                    <div class="number"><?php echo $stats['marketing_count'] ?? 0; ?></div>
                    <div class="label">Marketing</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ SERVICE FEATURES ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold mb-3">Why Choose Our <?php echo htmlspecialchars($service['title']); ?>?</h2>
        <p class="text-gray-400 max-w-2xl mx-auto">
            We deliver exceptional results through our proven strategies and dedicated approach.
        </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Feature 1 -->
        <div class="bg-[#0f0f0f] border border-white/5 rounded-2xl p-6 hover:border-lime/30 transition">
            <div class="feature-icon mb-4">
                <i class='bx bx-target-lock'></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Strategic Approach</h3>
            <p class="text-gray-400 text-sm">We develop customized strategies tailored to your specific business goals and target audience.</p>
        </div>
        
        <!-- Feature 2 -->
        <div class="bg-[#0f0f0f] border border-white/5 rounded-2xl p-6 hover:border-lime/30 transition">
            <div class="feature-icon mb-4">
                <i class='bx bx-line-chart'></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Data-Driven Results</h3>
            <p class="text-gray-400 text-sm">We use advanced analytics and data insights to optimize performance and maximize ROI.</p>
        </div>
        
        <!-- Feature 3 -->
        <div class="bg-[#0f0f0f] border border-white/5 rounded-2xl p-6 hover:border-lime/30 transition">
            <div class="feature-icon mb-4">
                <i class='bx bx-support'></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Dedicated Support</h3>
            <p class="text-gray-400 text-sm">Our team provides ongoing support and guidance to ensure your success every step of the way.</p>
        </div>
    </div>
</section>

<!-- ============ RELATED SERVICES ============ -->
<?php if (!empty($related_services)): ?>
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 pb-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold mb-3">Related Services</h2>
        <p class="text-gray-400 max-w-2xl mx-auto">
            Explore our other services that complement <?php echo htmlspecialchars($service['title']); ?>.
        </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php foreach ($related_services as $related): ?>
            <a href="service-details.php?id=<?php echo htmlspecialchars($related['service_id']); ?>" class="service-card group bg-[#0f0f0f] border border-white/5 rounded-2xl p-6 hover:border-lime/30 hover:bg-[#141414] transition-all duration-300 no-underline">
                <div class="w-12 h-12 rounded-xl bg-lime/10 flex items-center justify-center text-2xl text-lime group-hover:scale-110 transition-transform duration-300">
                    <i class='<?php echo htmlspecialchars($related['icon'] ?? 'bx bx-cube'); ?>'></i>
                </div>
                
                <h3 class="text-lg font-bold mt-4 mb-2 group-hover:text-lime transition">
                    <?php echo htmlspecialchars($related['title']); ?>
                </h3>
                
                <p class="text-gray-400 text-sm line-clamp-3">
                    <?php echo htmlspecialchars($related['description'] ?? 'No description available.'); ?>
                </p>
                
                <div class="mt-4 text-lime text-sm font-medium group-hover:underline">
                    Learn More <i class='bx bx-right-arrow-alt'></i>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ============ CTA SECTION ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 pb-16">
    <div class="relative bg-gradient-to-r from-lime/10 to-lime/5 border border-lime/20 rounded-3xl p-8 sm:p-12 overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-lime/5 rounded-full blur-3xl"></div>
        <div class="relative z-10 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold mb-3">
                Ready to Get Started with <?php echo htmlspecialchars($service['title']); ?>?
            </h2>
            <p class="text-gray-400 text-sm sm:text-base max-w-2xl mx-auto mb-6">
                Let's discuss how our <?php echo htmlspecialchars($service['title']); ?> can help you achieve your goals. 
                Get a free consultation with our expert team today.
            </p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="contact.php" class="bg-lime text-[#101010] font-semibold rounded-full px-8 py-3 hover:brightness-95 transition">
                    Get Started
                </a>
                <a href="services.php" class="border border-white/20 text-white font-semibold rounded-full px-8 py-3 hover:bg-white/10 transition">
                    View All Services
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
                    <li><a href="services.php?category=seo" class="hover:text-lime transition">Local SEO</a></li>
                    <li><a href="services.php?category=seo" class="hover:text-lime transition">On-Page SEO</a></li>
                    <li><a href="services.php?category=development" class="hover:text-lime transition">Web Development</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/5 mt-8 pt-8 text-center text-sm text-gray-400">
            <p>© <?php echo date('Y'); ?> 4 Digi Sol. All rights reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>