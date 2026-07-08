<?php
// 1. Start session FIRST (before ANY output)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Include database connection
include "config/connection.php";

// 3. Your page logic and code
// ...
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "includes/css-links.php" ?>
</head>
<body>

<!-- ============ NAVBAR ============ -->
<?php include "includes/navbar.php" ?>

<!-- ============ HERO ============ -->
<section class="relative w-full">
  <div class="bg-white text-[#101010] rounded-b-[2rem] sm:rounded-b-[3rem] overflow-hidden">
    <div class="pt-[70px] sm:pt-[84px]"></div>
    <div class="relative px-4 sm:px-8 lg:px-12 pt-8 sm:pt-12 pb-8 sm:pb-12 max-w-[1400px] mx-auto">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <div>
          <span class="inline-block bg-lime text-[#101010] text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full">SERVICE</span>
          <h1 class="text-3xl sm:text-4xl md:text-[3.2rem] font-bold leading-[1.15] mt-3">
            Web <span class="bg-lime px-3 py-1 rounded-xl inline-block">Development</span> Services
          </h1>
          <p class="text-gray-600 text-sm sm:text-base mt-4 max-w-md">Build responsive, SEO-optimized websites that convert visitors into customers. From custom development to CMS solutions, we create websites that drive growth.</p>
          <div class="flex flex-wrap gap-3 mt-6">
            <a href="#contact" class="bg-lime text-[#101010] font-bold rounded-full px-6 py-3 text-sm hover:brightness-95 transition">Get Free Quote</a>
            <a href="#process" class="border border-gray-300 text-gray-700 font-semibold rounded-full px-6 py-3 text-sm hover:bg-[#101010] hover:text-white hover:border-[#101010] transition">Our Process</a>
          </div>
        </div>
        <div class="flex justify-center">
          <div class="service-detail-icon">
            <i class='bx bx-palette'></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ SERVICE OVERVIEW ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="bg-[#141414] border border-white/5 rounded-2xl p-6 text-center">
      <p class="text-3xl font-bold lime">300+</p>
      <p class="text-xs text-gray-400 mt-1">Websites Built</p>
    </div>
    <div class="bg-[#141414] border border-white/5 rounded-2xl p-6 text-center">
      <p class="text-3xl font-bold lime">100%</p>
      <p class="text-xs text-gray-400 mt-1">SEO-Ready Websites</p>
    </div>
    <div class="bg-[#141414] border border-white/5 rounded-2xl p-6 text-center">
      <p class="text-3xl font-bold lime">4.9★</p>
      <p class="text-xs text-gray-400 mt-1">Avg. Client Rating</p>
    </div>
  </div>
</section>

<!-- ============ WHAT WE OFFER ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="text-center max-w-3xl mx-auto mb-8">
    <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">WHAT WE OFFER</span>
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mt-3">Our <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Web Development</span> Services</h2>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="feature-card"><h4 class="font-bold text-base">Custom Website Development</h4><p class="text-gray-400 text-sm mt-1">Tailor-made websites designed specifically for your business needs and goals.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">WordPress Development</h4><p class="text-gray-400 text-sm mt-1">Custom WordPress themes and plugins with full SEO integration.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">E-Commerce Development</h4><p class="text-gray-400 text-sm mt-1">WooCommerce, Shopify, or custom e-commerce solutions with payment integration.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">Responsive Design</h4><p class="text-gray-400 text-sm mt-1">Mobile-first designs that work flawlessly on all devices and screen sizes.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">Speed Optimization</h4><p class="text-gray-400 text-sm mt-1">Lightning-fast loading times with optimized code, images, and caching.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">SEO-Ready Architecture</h4><p class="text-gray-400 text-sm mt-1">Clean, semantic code and structure designed for search engine visibility.</p></div>
  </div>
</section>

<!-- ============ TECH STACK ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="text-center max-w-3xl mx-auto mb-8">
    <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">TECH STACK</span>
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mt-3">Technologies We <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Use</span></h2>
  </div>
  <div class="flex flex-wrap justify-center gap-2">
    <span class="tech-stack">WordPress</span>
    <span class="tech-stack">WooCommerce</span>
    <span class="tech-stack">Shopify</span>
    <span class="tech-stack">React</span>
    <span class="tech-stack">Vue.js</span>
    <span class="tech-stack">Node.js</span>
    <span class="tech-stack">PHP</span>
    <span class="tech-stack">Laravel</span>
    <span class="tech-stack">Tailwind CSS</span>
    <span class="tech-stack">Bootstrap</span>
    <span class="tech-stack">HTML5</span>
    <span class="tech-stack">CSS3</span>
    <span class="tech-stack">JavaScript</span>
    <span class="tech-stack">MySQL</span>
    <span class="tech-stack">MongoDB</span>
    <span class="tech-stack">Docker</span>
    <span class="tech-stack">AWS</span>
    <span class="tech-stack">Elementor</span>
    <span class="tech-stack">Rank Math SEO</span>
    <span class="tech-stack">Yoast SEO</span>
  </div>
</section>

<!-- ============ PROCESS ============ -->
<section id="process" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="text-center max-w-3xl mx-auto mb-8">
    <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">OUR PROCESS</span>
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mt-3">How We <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Build</span></h2>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-[#141414] border border-white/5 rounded-xl p-4 text-center"><span class="inline-block bg-lime text-[#101010] w-8 h-8 rounded-full font-bold text-sm leading-8 mb-2">01</span><h4 class="font-bold text-sm">Discovery</h4><p class="text-xs text-gray-400 mt-1">Understand your requirements and goals</p></div>
    <div class="bg-[#141414] border border-white/5 rounded-xl p-4 text-center"><span class="inline-block bg-lime text-[#101010] w-8 h-8 rounded-full font-bold text-sm leading-8 mb-2">02</span><h4 class="font-bold text-sm">Design</h4><p class="text-xs text-gray-400 mt-1">Create wireframes and UI/UX design</p></div>
    <div class="bg-[#141414] border border-white/5 rounded-xl p-4 text-center"><span class="inline-block bg-lime text-[#101010] w-8 h-8 rounded-full font-bold text-sm leading-8 mb-2">03</span><h4 class="font-bold text-sm">Develop</h4><p class="text-xs text-gray-400 mt-1">Build the website with clean, optimized code</p></div>
    <div class="bg-[#141414] border border-white/5 rounded-xl p-4 text-center"><span class="inline-block bg-lime text-[#101010] w-8 h-8 rounded-full font-bold text-sm leading-8 mb-2">04</span><h4 class="font-bold text-sm">Launch</h4><p class="text-xs text-gray-400 mt-1">Deploy, test, and optimize for SEO</p></div>
  </div>
</section>

<!-- ============ CTA ============ -->
<section id="contact" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="bg-lime text-[#101010] rounded-[2rem] p-6 sm:p-10 text-center">
    <h2 class="text-2xl sm:text-3xl font-bold">Ready to build your website?</h2>
    <p class="text-sm sm:text-base max-w-md mx-auto mt-2 text-[#1a1a1a]/80">Get a free consultation and quote for your next web development project.</p>
    <a href="#" class="inline-block mt-4 bg-[#101010] text-white font-bold rounded-full px-8 py-3 text-sm hover:bg-black transition">Get Free Quote</a>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<?php include "includes/footer.php" ?>
<?php include "includes/js-links.php" ?>
</body>
</html>