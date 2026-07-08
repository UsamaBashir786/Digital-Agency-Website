<?php
// ============================================================
// INCLUDES/NAVBAR.PHP - Main Navigation
// ============================================================


// Check if user is logged in
$is_logged_in = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
$user_name = $_SESSION['user_name'] ?? 'User';
$user_email = $_SESSION['user_email'] ?? '';

// Get current page for active state
$current_page = basename($_SERVER['PHP_SELF']);

function isActive($page) {
    global $current_page;
    return $current_page == $page ? 'active' : '';
}

function isActiveDropdown($pages) {
    global $current_page;
    return in_array($current_page, $pages) ? 'active' : '';
}

// Fetch all active services from database
$services = [];
if (isset($conn) && $conn) {
    $services_query = "SELECT service_id, title FROM services WHERE is_active = 1 ORDER BY sort_order ASC";
    $services_result = $conn->query($services_query);
    if ($services_result && $services_result->num_rows > 0) {
        while ($row = $services_result->fetch_assoc()) {
            $services[] = $row;
        }
    }
}

// Create array of service page names for dropdown active state
$service_pages = array_column($services, 'service_id');
$service_pages[] = 'services.php';
$service_pages[] = 'service-details.php';
?>

<nav class="fixed top-0 left-0 right-0 z-50 px-3 sm:px-6 lg:px-10 pt-3 sm:pt-4" role="navigation" aria-label="Main navigation">
  <div class="pill-nav rounded-full flex items-center justify-between px-3 sm:px-5 py-2.5 text-white relative shadow-lg shadow-black/30">
    
    <!-- Left: About & Services Dropdown -->
    <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-200 flex-1">
      <a href="about.php" class="nav-link <?php echo isActive('about.php'); ?>">About</a>
      
      <!-- Services Dropdown -->
      <div class="dropdown-trigger relative <?php echo isActiveDropdown($service_pages); ?>">
        <a href="services.php" class="nav-link flex items-center gap-1 cursor-pointer <?php echo isActive('services.php'); ?>">
          Services <i class='bx bx-chevron-down text-xs'></i>
        </a>
        <div class="dropdown-menu">
          <?php if (!empty($services)): ?>
            <?php foreach ($services as $service): ?>
              <!-- UPDATED: Link to service-details.php with id parameter -->
              <a href="service-details.php?id=<?php echo htmlspecialchars($service['service_id']); ?>" class="<?php echo isActive($service['service_id'] . '.php'); ?>">
                <?php echo htmlspecialchars($service['title']); ?>
              </a>
              <?php if ($service['service_id'] === 'technical-seo'): ?>
                <div class="divider"></div>
              <?php endif; ?>
              <?php if ($service['service_id'] === 'generative-seo'): ?>
                <div class="divider"></div>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <a href="services.php" class="text-gray-400">No services available</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    <!-- Logo -->
    <div class="flex items-center gap-1.5 font-bold text-base sm:text-lg shrink-0" aria-label="4 Digi Sol homepage">
      <a href="index.php" class="flex items-center gap-1.5 no-underline text-white">
        <i class='bx bx-sparkle text-xl lime' aria-hidden="true"></i>
        <span>
          <img width="120" src="assets/imgs/logo.png" alt="">
        </span>
      </a>
    </div>
    
    <!-- Right: Case Studies, Blog, Contact, Auth -->
    <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-200 flex-1 justify-end">
      <a href="case-studies.php" class="nav-link <?php echo isActive('case-studies.php'); ?>">Case Studies</a>
      <a href="blogs.php" class="nav-link <?php echo isActive('blogs.php'); ?>">Blog</a>
      <a href="contact.php" class="nav-link <?php echo isActive('contact.php'); ?>">Contact</a>
      
      <?php if ($is_logged_in): ?>
        <!-- Logged In - Show User Dropdown -->
        <div class="dropdown-trigger relative">
          <a href="#" class="nav-link flex items-center gap-2 cursor-pointer">
            <div class="w-7 h-7 rounded-full bg-lime text-[#101010] flex items-center justify-center text-xs font-bold">
              <?php echo strtoupper(substr($user_name, 0, 1)); ?>
            </div>
            <span class="text-sm font-medium"><?php echo htmlspecialchars($user_name); ?></span>
            <i class='bx bx-chevron-down text-xs'></i>
          </a>
          <div class="dropdown-menu" style="min-width: 180px; right: 0; left: auto;">
            <div class="px-4 py-2 border-b border-white/10">
              <p class="text-xs text-gray-400">Signed in as</p>
              <p class="text-sm font-medium text-white"><?php echo htmlspecialchars($user_name); ?></p>
              <p class="text-xs text-gray-400"><?php echo htmlspecialchars($user_email); ?></p>
            </div>
            <a href="dashboard.php" class="flex items-center gap-2">
              <i class='bx bx-grid-alt'></i> Dashboard
            </a>
            <a href="profile.php" class="flex items-center gap-2">
              <i class='bx bx-user'></i> My Profile
            </a>
            <a href="settings.php" class="flex items-center gap-2">
              <i class='bx bx-cog'></i> Settings
            </a>
            <div class="divider"></div>
            <a href="logout.php" class="flex items-center gap-2 text-red-400 hover:text-red-300">
              <i class='bx bx-log-out'></i> Logout
            </a>
          </div>
        </div>
      <?php else: ?>
        <!-- Logged Out - Show Login & Get Started -->
        <a href="login.php" class="nav-link <?php echo isActive('login.php'); ?>">Log In</a>
        <a href="login.php" class="bg-lime text-[#101010] font-semibold rounded-full px-4 py-2 text-sm hover:brightness-95 transition">Get Started</a>
      <?php endif; ?>
    </div>
    
    <!-- Mobile Menu Toggle -->
    <button id="menuBtn" aria-label="Toggle navigation menu" aria-expanded="false" class="md:hidden w-8 h-8 flex items-center justify-center text-xl">
      <i class='bx bx-menu' id="menuIconOpen" aria-hidden="true"></i>
      <i class='bx bx-x hidden' id="menuIconClose" aria-hidden="true"></i>
    </button>
  </div>
  
  <!-- Mobile Menu -->
  <div id="mobileMenu" class="hidden md:hidden mt-2 bg-[#101010] text-white rounded-2xl px-5 py-4 flex flex-col gap-3 text-sm origin-top shadow-lg shadow-black/30" role="menu">
    <a href="about.php" class="mobile-link <?php echo isActive('about.php'); ?>" role="menuitem">About</a>
    
    <!-- Mobile Services Dropdown -->
    <div class="flex flex-col gap-1">
      <button id="mobileServicesBtn" class="flex items-center justify-between w-full py-1 text-left cursor-pointer text-[#d0d0d0] hover:text-white transition <?php echo isActiveDropdown($service_pages); ?>">
        Services <i class='bx bx-chevron-down' id="mobileServicesIcon"></i>
      </button>
      <div id="mobileServicesMenu" class="hidden pl-4 flex flex-col gap-1 text-gray-400">
        <?php if (!empty($services)): ?>
          <?php 
          $mobile_service_count = 0;
          foreach ($services as $service): 
            $mobile_service_count++;
            $is_last_group = ($service['service_id'] === 'technical-seo' || $service['service_id'] === 'generative-seo' || $service['service_id'] === 'web-development');
          ?>
            <!-- UPDATED: Link to service-details.php with id parameter -->
            <a href="service-details.php?id=<?php echo htmlspecialchars($service['service_id']); ?>" class="mobile-link py-1 <?php echo isActive($service['service_id'] . '.php'); ?>">
              <?php echo htmlspecialchars($service['title']); ?>
            </a>
            <?php if ($is_last_group && $mobile_service_count < count($services)): ?>
              <div class="border-t border-white/10 my-1"></div>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php else: ?>
          <a href="services.php" class="mobile-link py-1 text-gray-400">No services available</a>
        <?php endif; ?>
      </div>
    </div>
    
    <a href="case-studies.php" class="mobile-link <?php echo isActive('case-studies.php'); ?>" role="menuitem">Case Studies</a>
    <a href="blogs.php" class="mobile-link <?php echo isActive('blogs.php'); ?>" role="menuitem">Blog</a>
    <a href="contact.php" class="mobile-link <?php echo isActive('contact.php'); ?>" role="menuitem">Contact</a>
    <div class="border-t border-white/10 my-1"></div>
    
    <?php if ($is_logged_in): ?>
      <!-- Mobile Logged In -->
      <div class="flex items-center gap-3 py-1">
        <div class="w-8 h-8 rounded-full bg-lime text-[#101010] flex items-center justify-center text-xs font-bold">
          <?php echo strtoupper(substr($user_name, 0, 1)); ?>
        </div>
        <div>
          <p class="text-sm font-medium text-white"><?php echo htmlspecialchars($user_name); ?></p>
          <p class="text-xs text-gray-400"><?php echo htmlspecialchars($user_email); ?></p>
        </div>
      </div>
      <a href="dashboard.php" class="mobile-link">Dashboard</a>
      <a href="profile.php" class="mobile-link">My Profile</a>
      <a href="settings.php" class="mobile-link">Settings</a>
      <a href="logout.php" class="mobile-link text-red-400">Logout</a>
    <?php else: ?>
      <!-- Mobile Logged Out -->
      <a href="login.php" class="mobile-link <?php echo isActive('login.php'); ?>" role="menuitem">Log In</a>
      <a href="login.php" class="bg-lime text-[#101010] font-semibold rounded-full px-4 py-2 text-center hover:brightness-95 transition">Get Started</a>
    <?php endif; ?>
  </div>
</nav>