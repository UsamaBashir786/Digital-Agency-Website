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
            E-Commerce <span class="bg-lime px-3 py-1 rounded-xl inline-block">SEO</span> Services
          </h1>
          <p class="text-gray-600 text-sm sm:text-base mt-4 max-w-md">Optimize your online store to drive more traffic, increase conversions, and boost revenue with our proven e-commerce SEO strategies.</p>
          <div class="flex flex-wrap gap-3 mt-6">
            <a href="#contact" class="bg-lime text-[#101010] font-bold rounded-full px-6 py-3 text-sm hover:brightness-95 transition">Get Free Audit</a>
            <a href="#process" class="border border-gray-300 text-gray-700 font-semibold rounded-full px-6 py-3 text-sm hover:bg-[#101010] hover:text-white hover:border-[#101010] transition">Our Process</a>
          </div>
        </div>
        <div class="flex justify-center">
          <div class="service-detail-icon">
            <i class='bx bx-store'></i>
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
      <p class="text-3xl font-bold lime">200+</p>
      <p class="text-xs text-gray-400 mt-1">Online Stores Optimized</p>
    </div>
    <div class="bg-[#141414] border border-white/5 rounded-2xl p-6 text-center">
      <p class="text-3xl font-bold lime">450%</p>
      <p class="text-xs text-gray-400 mt-1">Average Revenue Growth</p>
    </div>
    <div class="bg-[#141414] border border-white/5 rounded-2xl p-6 text-center">
      <p class="text-3xl font-bold lime">2.8x</p>
      <p class="text-xs text-gray-400 mt-1">Average Conversion Rate</p>
    </div>
  </div>
</section>

<!-- ============ WHAT WE OFFER ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="text-center max-w-3xl mx-auto mb-8">
    <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">WHAT WE OFFER</span>
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mt-3">Our <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">E-Commerce SEO</span> Services</h2>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="feature-card"><h4 class="font-bold text-base">Product Page Optimization</h4><p class="text-gray-400 text-sm mt-1">Optimize product titles, descriptions, images, and URLs for better visibility.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">Category Page SEO</h4><p class="text-gray-400 text-sm mt-1">Optimize category structure and content for improved search rankings.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">Schema Markup</h4><p class="text-gray-400 text-sm mt-1">Add product schema, reviews, and structured data for rich snippets.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">Technical SEO</h4><p class="text-gray-400 text-sm mt-1">Fix site speed, crawl errors, and indexing issues for better performance.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">Content Strategy</h4><p class="text-gray-400 text-sm mt-1">Create SEO-optimized content that drives traffic and conversions.</p></div>
    <div class="feature-card"><h4 class="font-bold text-base">Link Building</h4><p class="text-gray-400 text-sm mt-1">Build high-quality backlinks to increase domain authority.</p></div>
  </div>
</section>

<!-- ============ PROCESS ============ -->
<section id="process" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="text-center max-w-3xl mx-auto mb-8">
    <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">OUR PROCESS</span>
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mt-3">How We <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Work</span></h2>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-[#141414] border border-white/5 rounded-xl p-4 text-center"><span class="inline-block bg-lime text-[#101010] w-8 h-8 rounded-full font-bold text-sm leading-8 mb-2">01</span><h4 class="font-bold text-sm">Audit</h4><p class="text-xs text-gray-400 mt-1">Analyze your store's SEO performance</p></div>
    <div class="bg-[#141414] border border-white/5 rounded-xl p-4 text-center"><span class="inline-block bg-lime text-[#101010] w-8 h-8 rounded-full font-bold text-sm leading-8 mb-2">02</span><h4 class="font-bold text-sm">Strategy</h4><p class="text-xs text-gray-400 mt-1">Create a custom e-commerce SEO plan</p></div>
    <div class="bg-[#141414] border border-white/5 rounded-xl p-4 text-center"><span class="inline-block bg-lime text-[#101010] w-8 h-8 rounded-full font-bold text-sm leading-8 mb-2">03</span><h4 class="font-bold text-sm">Execution</h4><p class="text-xs text-gray-400 mt-1">Implement optimizations and content</p></div>
    <div class="bg-[#141414] border border-white/5 rounded-xl p-4 text-center"><span class="inline-block bg-lime text-[#101010] w-8 h-8 rounded-full font-bold text-sm leading-8 mb-2">04</span><h4 class="font-bold text-sm">Monitor</h4><p class="text-xs text-gray-400 mt-1">Track rankings and revenue growth</p></div>
  </div>
</section>

<!-- ============ CTA ============ -->
<section id="contact" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="bg-lime text-[#101010] rounded-[2rem] p-6 sm:p-10 text-center">
    <h2 class="text-2xl sm:text-3xl font-bold">Ready to grow your online store?</h2>
    <p class="text-sm sm:text-base max-w-md mx-auto mt-2 text-[#1a1a1a]/80">Get a free e-commerce SEO audit and discover how we can help you sell more.</p>
    <a href="#" class="inline-block mt-4 bg-[#101010] text-white font-bold rounded-full px-8 py-3 text-sm hover:bg-black transition">Get Free Audit</a>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<?php include "includes/footer.php" ?>

<?php include "includes/js-links.php" ?>
</body>
</html>