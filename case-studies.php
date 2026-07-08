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
      <div class="text-center max-w-3xl mx-auto">
        <span class="inline-block bg-lime text-[#101010] text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full">CASE STUDIES</span>
        <h1 class="text-3xl sm:text-4xl md:text-[3.2rem] font-bold leading-[1.15] mt-3">
          Results That <br><span class="bg-lime px-3 py-1 rounded-xl inline-block">Speak for Themselves</span>
        </h1>
        <p class="text-gray-600 text-sm sm:text-base mt-4 max-w-md mx-auto">Real success stories from real clients. See how we've helped businesses grow through data-driven SEO and digital marketing strategies.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ FILTERS ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-6 sm:mt-8">
  <div class="flex flex-wrap justify-center gap-2">
    <button class="filter-btn active" data-filter="all">All</button>
    <button class="filter-btn" data-filter="seo">SEO</button>
    <button class="filter-btn" data-filter="local">Local SEO</button>
    <button class="filter-btn" data-filter="ecom">E-Commerce</button>
    <button class="filter-btn" data-filter="webdev">Web Development</button>
    <button class="filter-btn" data-filter="content">Content</button>
  </div>
</section>

<!-- ============ CASE STUDIES GRID ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-6 sm:mt-8">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-5" id="caseGrid">
    
    <!-- Case 1: Local SEO -->
    <div class="case-card" data-category="local seo">
      <div class="relative aspect-[16/9] overflow-hidden">
        <img src="https://picsum.photos/seed/local-seo-case/600/350" alt="Local SEO Case Study" class="w-full h-full object-cover" loading="lazy">
        <div class="absolute top-3 left-3 bg-lime text-[#101010] text-[10px] font-bold px-3 py-1 rounded-full">Local SEO</div>
      </div>
      <div class="p-5">
        <h3 class="text-lg font-bold">Local Bakery Chain · 300% Increase in Store Visits</h3>
        <p class="text-gray-400 text-sm mt-1 leading-relaxed">Helped a local bakery chain dominate Google Maps and local search results across 5 cities.</p>
        <div class="grid grid-cols-3 gap-2 mt-4">
          <div class="result-stat"><span class="number">300%</span><p class="text-[10px] text-gray-400 mt-0.5">Store Visits</p></div>
          <div class="result-stat"><span class="number">#1</span><p class="text-[10px] text-gray-400 mt-0.5">Map Ranking</p></div>
          <div class="result-stat"><span class="number">150+</span><p class="text-[10px] text-gray-400 mt-0.5">Reviews</p></div>
        </div>
        <a href="#" class="inline-block mt-4 text-lime text-sm font-semibold hover:underline">Read Full Case Study →</a>
      </div>
    </div>

    <!-- Case 2: E-Com SEO -->
    <div class="case-card" data-category="ecom seo">
      <div class="relative aspect-[16/9] overflow-hidden">
        <img src="https://picsum.photos/seed/ecom-seo-case/600/350" alt="E-Com SEO Case Study" class="w-full h-full object-cover" loading="lazy">
        <div class="absolute top-3 left-3 bg-lime text-[#101010] text-[10px] font-bold px-3 py-1 rounded-full">E-Com SEO</div>
      </div>
      <div class="p-5">
        <h3 class="text-lg font-bold">Online Fashion Store · 450% Revenue Growth</h3>
        <p class="text-gray-400 text-sm mt-1 leading-relaxed">Optimized product pages, category structure, and technical SEO for a fashion e-commerce store.</p>
        <div class="grid grid-cols-3 gap-2 mt-4">
          <div class="result-stat"><span class="number">450%</span><p class="text-[10px] text-gray-400 mt-0.5">Revenue</p></div>
          <div class="result-stat"><span class="number">2.8x</span><p class="text-[10px] text-gray-400 mt-0.5">Conversion Rate</p></div>
          <div class="result-stat"><span class="number">120+</span><p class="text-[10px] text-gray-400 mt-0.5">Keywords</p></div>
        </div>
        <a href="#" class="inline-block mt-4 text-lime text-sm font-semibold hover:underline">Read Full Case Study →</a>
      </div>
    </div>

    <!-- Case 3: Technical SEO -->
    <div class="case-card" data-category="seo technical">
      <div class="relative aspect-[16/9] overflow-hidden">
        <img src="https://picsum.photos/seed/technical-seo-case/600/350" alt="Technical SEO Case Study" class="w-full h-full object-cover" loading="lazy">
        <div class="absolute top-3 left-3 bg-lime text-[#101010] text-[10px] font-bold px-3 py-1 rounded-full">Technical SEO</div>
      </div>
      <div class="p-5">
        <h3 class="text-lg font-bold">SaaS Platform · 200% Organic Traffic Increase</h3>
        <p class="text-gray-400 text-sm mt-1 leading-relaxed">Fixed speed issues, crawl errors, and implemented schema markup for a B2B SaaS platform.</p>
        <div class="grid grid-cols-3 gap-2 mt-4">
          <div class="result-stat"><span class="number">200%</span><p class="text-[10px] text-gray-400 mt-0.5">Organic Traffic</p></div>
          <div class="result-stat"><span class="number">2.1s</span><p class="text-[10px] text-gray-400 mt-0.5">Load Time</p></div>
          <div class="result-stat"><span class="number">50+</span><p class="text-[10px] text-gray-400 mt-0.5">Backlinks</p></div>
        </div>
        <a href="#" class="inline-block mt-4 text-lime text-sm font-semibold hover:underline">Read Full Case Study →</a>
      </div>
    </div>

    <!-- Case 4: Web Development -->
    <div class="case-card" data-category="webdev">
      <div class="relative aspect-[16/9] overflow-hidden">
        <img src="https://picsum.photos/seed/webdev-case/600/350" alt="Web Development Case Study" class="w-full h-full object-cover" loading="lazy">
        <div class="absolute top-3 left-3 bg-lime text-[#101010] text-[10px] font-bold px-3 py-1 rounded-full">Web Development</div>
      </div>
      <div class="p-5">
        <h3 class="text-lg font-bold">Real Estate Agency · 180% Lead Generation Boost</h3>
        <p class="text-gray-400 text-sm mt-1 leading-relaxed">Built a responsive, SEO-optimized website with property listings and lead capture forms.</p>
        <div class="grid grid-cols-3 gap-2 mt-4">
          <div class="result-stat"><span class="number">180%</span><p class="text-[10px] text-gray-400 mt-0.5">Leads</p></div>
          <div class="result-stat"><span class="number">40%</span><p class="text-[10px] text-gray-400 mt-0.5">Bounce Rate</p></div>
          <div class="result-stat"><span class="number">4.8★</span><p class="text-[10px] text-gray-400 mt-0.5">User Rating</p></div>
        </div>
        <a href="#" class="inline-block mt-4 text-lime text-sm font-semibold hover:underline">Read Full Case Study →</a>
      </div>
    </div>

    <!-- Case 5: Content SEO -->
    <div class="case-card" data-category="content seo">
      <div class="relative aspect-[16/9] overflow-hidden">
        <img src="https://picsum.photos/seed/content-seo-case/600/350" alt="Content SEO Case Study" class="w-full h-full object-cover" loading="lazy">
        <div class="absolute top-3 left-3 bg-lime text-[#101010] text-[10px] font-bold px-3 py-1 rounded-full">Content SEO</div>
      </div>
      <div class="p-5">
        <h3 class="text-lg font-bold">Health & Wellness Blog · 350% Traffic Growth</h3>
        <p class="text-gray-400 text-sm mt-1 leading-relaxed">Developed a content strategy with pillar pages, topic clusters, and SEO-optimized articles.</p>
        <div class="grid grid-cols-3 gap-2 mt-4">
          <div class="result-stat"><span class="number">350%</span><p class="text-[10px] text-gray-400 mt-0.5">Traffic</p></div>
          <div class="result-stat"><span class="number">#1</span><p class="text-[10px] text-gray-400 mt-0.5">Featured Snippets</p></div>
          <div class="result-stat"><span class="number">80+</span><p class="text-[10px] text-gray-400 mt-0.5">Articles</p></div>
        </div>
        <a href="#" class="inline-block mt-4 text-lime text-sm font-semibold hover:underline">Read Full Case Study →</a>
      </div>
    </div>

    <!-- Case 6: Local SEO -->
    <div class="case-card" data-category="local seo">
      <div class="relative aspect-[16/9] overflow-hidden">
        <img src="https://picsum.photos/seed/local-seo-case-2/600/350" alt="Local SEO Case Study" class="w-full h-full object-cover" loading="lazy">
        <div class="absolute top-3 left-3 bg-lime text-[#101010] text-[10px] font-bold px-3 py-1 rounded-full">Local SEO</div>
      </div>
      <div class="p-5">
        <h3 class="text-lg font-bold">Plumbing Company · 500% Increase in Calls</h3>
        <p class="text-gray-400 text-sm mt-1 leading-relaxed">Optimized Google Business Profile and local citations for a service-based business.</p>
        <div class="grid grid-cols-3 gap-2 mt-4">
          <div class="result-stat"><span class="number">500%</span><p class="text-[10px] text-gray-400 mt-0.5">Phone Calls</p></div>
          <div class="result-stat"><span class="number">#2</span><p class="text-[10px] text-gray-400 mt-0.5">Map Pack</p></div>
          <div class="result-stat"><span class="number">25+</span><p class="text-[10px] text-gray-400 mt-0.5">Citations</p></div>
        </div>
        <a href="#" class="inline-block mt-4 text-lime text-sm font-semibold hover:underline">Read Full Case Study →</a>
      </div>
    </div>

  </div>
</section>

<!-- ============ CTA ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="bg-lime text-[#101010] rounded-[2rem] p-6 sm:p-10 text-center">
    <h2 class="text-2xl sm:text-3xl font-bold">Ready to write your success story?</h2>
    <p class="text-sm sm:text-base max-w-md mx-auto mt-2 text-[#1a1a1a]/80">Let's discuss how we can help your business achieve similar results.</p>
    <a href="#" class="inline-block mt-4 bg-[#101010] text-white font-bold rounded-full px-8 py-3 text-sm hover:bg-black transition">Get Free Consultation</a>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<?php include "includes/footer.php" ?>

<?php include "includes/js-links.php" ?>
</body>
</html>