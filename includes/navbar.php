<?php
// ============================================================
// ACTIVE PAGE DETECTION FUNCTION
// This function checks if the current page matches the link
// and adds an 'active' class if it does
// ============================================================

function isActive($pageName) {
    // Get the current file name from the URL
    $currentPage = basename($_SERVER['PHP_SELF']);
    
    // Check if the current page matches the provided page name
    if ($currentPage == $pageName) {
        return 'active';
    }
    return '';
}

function isActiveDropdown($pages) {
    // For dropdown items - check if any of the pages in the array match
    $currentPage = basename($_SERVER['PHP_SELF']);
    
    if (in_array($currentPage, $pages)) {
        return 'active';
    }
    return '';
}

// Get current page for conditional logic
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="fixed top-0 left-0 right-0 z-50 px-3 sm:px-6 lg:px-10 pt-3 sm:pt-4" role="navigation" aria-label="Main navigation">
  <div class="pill-nav rounded-full flex items-center justify-between px-3 sm:px-5 py-2.5 text-white relative shadow-lg shadow-black/30">
    
    <!-- Left: About & Services Dropdown -->
    <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-200 flex-1">
      <a href="about.php" class="nav-link <?php echo isActive('about.php'); ?>">About</a>
      
      <!-- Services Dropdown -->
      <div class="dropdown-trigger relative <?php echo isActiveDropdown(['services.php', 'local-seo.php', 'ecommerce-seo.php', 'onpage-seo.php', 'offpage-seo.php', 'technical-seo.php', 'answer-engine-seo.php', 'generative-seo.php', 'web-development.php']); ?>">
        <a href="services.php" class="nav-link flex items-center gap-1 cursor-pointer <?php echo isActive('services.php'); ?>">
          Services <i class='bx bx-chevron-down text-xs'></i>
        </a>
        <div class="dropdown-menu">
          <a href="local-seo.php" class="<?php echo isActive('local-seo.php'); ?>">Local SEO</a>
          <a href="ecommerce-seo.php" class="<?php echo isActive('ecommerce-seo.php'); ?>">E-Commerce SEO</a>
          <a href="onpage-seo.php" class="<?php echo isActive('onpage-seo.php'); ?>">On-Page SEO</a>
          <a href="offpage-seo.php" class="<?php echo isActive('offpage-seo.php'); ?>">Off-Page SEO</a>
          <a href="technical-seo.php" class="<?php echo isActive('technical-seo.php'); ?>">Technical SEO</a>
          <div class="divider"></div>
          <a href="answer-engine-seo.php" class="<?php echo isActive('answer-engine-seo.php'); ?>">Answer Engine Optimization</a>
          <a href="generative-seo.php" class="<?php echo isActive('generative-seo.php'); ?>">Generative SEO</a>
          <div class="divider"></div>
          <a href="web-development.php" class="<?php echo isActive('web-development.php'); ?>">Web Development</a>
        </div>
      </div>
    </div>
    
    <!-- Logo -->
    <div class="flex items-center gap-1.5 font-bold text-base sm:text-lg shrink-0" aria-label="4 Digi Sol homepage">
      <a href="index.php" class="flex items-center gap-1.5 no-underline text-white">
        <i class='bx bx-sparkle text-xl lime' aria-hidden="true"></i>
        <span>4 Digi Sol</span>
      </a>
    </div>
    
    <!-- Right: Case Studies, Blog, Contact, Auth -->
    <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-200 flex-1 justify-end">
      <a href="case-studies.php" class="nav-link <?php echo isActive('case-studies.php'); ?>">Case Studies</a>
      <a href="blogs.php" class="nav-link <?php echo isActive('blogs.php'); ?>">Blog</a>
      <a href="contact.php" class="nav-link <?php echo isActive('contact.php'); ?>">Contact</a>
      <a href="login.php" class="nav-link <?php echo isActive('login.php'); ?>">Log In</a>
      <a href="login.php" class="bg-lime text-[#101010] font-semibold rounded-full px-4 py-2 text-sm hover:brightness-95 transition">Get Started</a>
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
      <button id="mobileServicesBtn" class="flex items-center justify-between w-full py-1 text-left cursor-pointer text-[#d0d0d0] hover:text-white transition <?php echo isActiveDropdown(['services.php', 'local-seo.php', 'ecommerce-seo.php', 'onpage-seo.php', 'offpage-seo.php', 'technical-seo.php', 'answer-engine-seo.php', 'generative-seo.php', 'web-development.php']); ?>">
        Services <i class='bx bx-chevron-down' id="mobileServicesIcon"></i>
      </button>
      <div id="mobileServicesMenu" class="hidden pl-4 flex flex-col gap-1 text-gray-400">
        <a href="local-seo.php" class="mobile-link py-1 <?php echo isActive('local-seo.php'); ?>">Local SEO</a>
        <a href="ecommerce-seo.php" class="mobile-link py-1 <?php echo isActive('ecommerce-seo.php'); ?>">E-Commerce SEO</a>
        <a href="onpage-seo.php" class="mobile-link py-1 <?php echo isActive('onpage-seo.php'); ?>">On-Page SEO</a>
        <a href="offpage-seo.php" class="mobile-link py-1 <?php echo isActive('offpage-seo.php'); ?>">Off-Page SEO</a>
        <a href="technical-seo.php" class="mobile-link py-1 <?php echo isActive('technical-seo.php'); ?>">Technical SEO</a>
        <div class="border-t border-white/10 my-1"></div>
        <a href="answer-engine-seo.php" class="mobile-link py-1 <?php echo isActive('answer-engine-seo.php'); ?>">Answer Engine Optimization</a>
        <a href="generative-seo.php" class="mobile-link py-1 <?php echo isActive('generative-seo.php'); ?>">Generative SEO</a>
        <div class="border-t border-white/10 my-1"></div>
        <a href="web-development.php" class="mobile-link py-1 <?php echo isActive('web-development.php'); ?>">Web Development</a>
      </div>
    </div>
    
    <a href="case-studies.php" class="mobile-link <?php echo isActive('case-studies.php'); ?>" role="menuitem">Case Studies</a>
    <a href="blogs.php" class="mobile-link <?php echo isActive('blogs.php'); ?>" role="menuitem">Blog</a>
    <a href="contact.php" class="mobile-link <?php echo isActive('contact.php'); ?>" role="menuitem">Contact</a>
    <div class="border-t border-white/10 my-1"></div>
    <a href="login.php" class="mobile-link <?php echo isActive('login.php'); ?>" role="menuitem">Log In</a>
    <a href="login.php" class="bg-lime text-[#101010] font-semibold rounded-full px-4 py-2 text-center hover:brightness-95 transition">Get Started</a>
  </div>
</nav>

<!-- ============================================================
     ADD THIS CSS TO YOUR STYLE SECTION FOR ACTIVE STATE
     ============================================================ -->
<style>
    /* Active state for nav links - the underline stays visible */
    .nav-link.active {
        color: #ffffff;
    }
    .nav-link.active::after {
        width: 100%;
    }
    
    /* Active state for mobile links */
    .mobile-link.active {
        color: #A6F13B !important;
    }
    .mobile-link.active::after {
        width: 100%;
        background-color: #A6F13B;
    }
    
    /* Active state for dropdown items */
    .dropdown-menu a.active {
        color: #A6F13B;
        background: rgba(166, 241, 59, 0.08);
    }
    
    /* Active state for Services dropdown trigger */
    .dropdown-trigger.active .nav-link {
        color: #ffffff;
    }
    .dropdown-trigger.active .nav-link::after {
        width: 100%;
    }
</style>