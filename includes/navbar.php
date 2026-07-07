<nav class="fixed top-0 left-0 right-0 z-50 px-3 sm:px-6 lg:px-10 pt-3 sm:pt-4" role="navigation" aria-label="Main navigation">
  <div class="pill-nav rounded-full flex items-center justify-between px-3 sm:px-5 py-2.5 text-white relative shadow-lg shadow-black/30">
    
    <!-- Left: About & Services Dropdown -->
    <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-200 flex-1">
      <a href="about.php" class="nav-link">About</a>
      
      <!-- Services Dropdown -->
      <div class="dropdown-trigger relative">
        <a href="services.php" class="nav-link flex items-center gap-1 cursor-pointer">
          Services <i class='bx bx-chevron-down text-xs'></i>
        </a>
        <div class="dropdown-menu">
          <a href="local-seo.php">Local SEO</a>
          <a href="ecommerce-seo.php">E-Commerce SEO</a>
          <a href="onpage-seo.php">On-Page SEO</a>
          <a href="offpage-seo.php">Off-Page SEO</a>
          <a href="technical-seo.php">Technical SEO</a>
          <div class="divider"></div>
          <a href="answer-engine-seo.php">Answer Engine Optimization</a>
          <a href="generative-seo.php">Generative SEO</a>
          <div class="divider"></div>
          <a href="web-development.php">Web Development</a>
        </div>
      </div>
    </div>
    
    <!-- Logo -->
    <div class="flex items-center gap-1.5 font-bold text-base sm:text-lg shrink-0" aria-label="Creatix homepage">
      <a href="index.php" class="flex items-center gap-1.5 no-underline text-white">
        <i class='bx bx-sparkle text-xl lime' aria-hidden="true"></i>
        <span>4 Digi Sol</span>
      </a>
    </div>
    
    <!-- Right: Case Studies, Blog, Contact, Auth -->
    <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-200 flex-1 justify-end">
      <a href="case-studies.php" class="nav-link">Case Studies</a>
      <a href="blogs.php" class="nav-link">Blog</a>
      <a href="#contact" class="nav-link">Contact</a>
      <a href="login.php" class="nav-link">Log In</a>
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
    <a href="about.php" class="mobile-link" role="menuitem">About</a>
    
    <!-- Mobile Services Dropdown -->
    <div class="flex flex-col gap-1">
      <button id="mobileServicesBtn" class="flex items-center justify-between w-full py-1 text-left cursor-pointer text-[#d0d0d0] hover:text-white transition">
        Services <i class='bx bx-chevron-down' id="mobileServicesIcon"></i>
      </button>
      <div id="mobileServicesMenu" class="hidden pl-4 flex flex-col gap-1 text-gray-400">
        <a href="local-seo.php" class="mobile-link py-1">Local SEO</a>
        <a href="ecommerce-seo.php" class="mobile-link py-1">E-Commerce SEO</a>
        <a href="onpage-seo.php" class="mobile-link py-1">On-Page SEO</a>
        <a href="offpage-seo.php" class="mobile-link py-1">Off-Page SEO</a>
        <a href="technical-seo.php" class="mobile-link py-1">Technical SEO</a>
        <div class="border-t border-white/10 my-1"></div>
        <a href="answer-engine-seo.php" class="mobile-link py-1">Answer Engine Optimization</a>
        <a href="generative-seo.php" class="mobile-link py-1">Generative SEO</a>
        <div class="border-t border-white/10 my-1"></div>
        <a href="web-development.php" class="mobile-link py-1">Web Development</a>
      </div>
    </div>
    
    <a href="case-studies.php" class="mobile-link" role="menuitem">Case Studies</a>
    <a href="blogs.php" class="mobile-link" role="menuitem">Blog</a>
    <a href="#contact" class="mobile-link" role="menuitem">Contact</a>
    <div class="border-t border-white/10 my-1"></div>
    <a href="login.php" class="mobile-link" role="menuitem">Log In</a>
    <a href="login.php" class="bg-lime text-[#101010] font-semibold rounded-full px-4 py-2 text-center hover:brightness-95 transition">Get Started</a>
  </div>
</nav>