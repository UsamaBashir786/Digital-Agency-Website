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
            Generative <span class="bg-lime px-3 py-1 rounded-xl inline-block">SEO</span> Services
          </h1>
          <p class="text-gray-600 text-sm sm:text-base mt-4 max-w-md">Leverage AI to scale your content strategy. Create programmatic content that ranks, drives traffic, and automates your SEO growth at scale.</p>
          <div class="flex flex-wrap gap-3 mt-6">
            <a href="#contact" class="bg-lime text-[#101010] font-bold rounded-full px-6 py-3 text-sm hover:brightness-95 transition">Get Free Audit</a>
            <a href="#process" class="border border-gray-300 text-gray-700 font-semibold rounded-full px-6 py-3 text-sm hover:bg-[#101010] hover:text-white hover:border-[#101010] transition">Our Process</a>
          </div>
        </div>
        <div class="flex justify-center">
          <div class="service-detail-icon">
            <i class='bx bx-brain'></i>
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
      <p class="text-3xl font-bold lime">1,000+</p>
      <p class="text-xs text-gray-400 mt-1">AI-Optimized Pages</p>
    </div>
    <div class="bg-[#141414] border border-white/5 rounded-2xl p-6 text-center">
      <p class="text-3xl font-bold lime">200%</p>
      <p class="text-xs text-gray-400 mt-1">Traffic Growth</p>
    </div>
    <div class="bg-[#141414] border border-white/5 rounded-2xl p-6 text-center">
      <p class="text-3xl font-bold lime">50%</p>
      <p class="text-xs text-gray-400 mt-1">Cost Reduction</p>
    </div>
  </div>
</section>

<!-- ============ WHAT WE OFFER ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="text-center max-w-3xl mx-auto mb-8">
    <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">WHAT WE OFFER</span>
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mt-3">Our <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Generative SEO</span> Services</h2>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="feature-card"><h4 class="font-bold text-base">AI Content Strategy</h4><p class="text-gray-400 text-sm mt-1">Develop a scalable content strategy powered by AI to create high-quality content at scale.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">Programmatic SEO</h4><p class="text-gray-400 text-sm mt-1">Create thousands of optimized pages using data-driven programmatic content generation.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">Entity-Based SEO</h4><p class="text-gray-400 text-sm mt-1">Build entity relationships and topical authority to improve search visibility.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">Automated Content Generation</h4><p class="text-gray-400 text-sm mt-1">Leverage AI tools to automate content creation, saving time and reducing costs.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">Topic Clustering</h4><p class="text-gray-400 text-sm mt-1">Build comprehensive topic clusters to establish authority and improve rankings.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">Scalable SEO Solutions</h4><p class="text-gray-400 text-sm mt-1">Enterprise-level SEO solutions designed to grow with your business.</p></div>
  </div>
</section>

<!-- ============ PROCESS ============ -->
<section id="process" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="text-center max-w-3xl mx-auto mb-8">
    <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">OUR PROCESS</span>
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mt-3">How We <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Work</span></h2>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-[#141414] border border-white/5 rounded-xl p-4 text-center"><span class="inline-block bg-lime text-[#101010] w-8 h-8 rounded-full font-bold text-sm leading-8 mb-2">01</span><h4 class="font-bold text-sm">Strategy</h4><p class="text-xs text-gray-400 mt-1">Define content and keyword strategy</p></div>
    <div class="bg-[#141414] border border-white/5 rounded-xl p-4 text-center"><span class="inline-block bg-lime text-[#101010] w-8 h-8 rounded-full font-bold text-sm leading-8 mb-2">02</span><h4 class="font-bold text-sm">Create</h4><p class="text-xs text-gray-400 mt-1">Generate AI-optimized content</p></div>
    <div class="bg-[#141414] border border-white/5 rounded-xl p-4 text-center"><span class="inline-block bg-lime text-[#101010] w-8 h-8 rounded-full font-bold text-sm leading-8 mb-2">03</span><h4 class="font-bold text-sm">Optimize</h4><p class="text-xs text-gray-400 mt-1">Refine content for search engines</p></div>
    <div class="bg-[#141414] border border-white/5 rounded-xl p-4 text-center"><span class="inline-block bg-lime text-[#101010] w-8 h-8 rounded-full font-bold text-sm leading-8 mb-2">04</span><h4 class="font-bold text-sm">Scale</h4><p class="text-xs text-gray-400 mt-1">Scale content production and track results</p></div>
  </div>
</section>

<!-- ============ CTA ============ -->
<section id="contact" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="bg-lime text-[#101010] rounded-[2rem] p-6 sm:p-10 text-center">
    <h2 class="text-2xl sm:text-3xl font-bold">Ready to scale your SEO with AI?</h2>
    <p class="text-sm sm:text-base max-w-md mx-auto mt-2 text-[#1a1a1a]/80">Get a free generative SEO consultation and discover how AI can transform your content strategy.</p>
    <a href="#" class="inline-block mt-4 bg-[#101010] text-white font-bold rounded-full px-8 py-3 text-sm hover:bg-black transition">Get Free Consultation</a>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<?php include "includes/footer.php" ?>
<?php include "includes/js-links.php" ?>
</body>
</html>