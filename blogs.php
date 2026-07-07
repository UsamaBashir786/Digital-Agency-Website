<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
  <title>Blog — Creatix SEO & Digital Marketing Insights</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/styles/styles.css">
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
        <span class="inline-block bg-lime text-[#101010] text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full">BLOG</span>
        <h1 class="text-3xl sm:text-4xl md:text-[3.2rem] font-bold leading-[1.15] mt-3">
          Insights & <span class="bg-lime px-3 py-1 rounded-xl inline-block">Strategies</span>
        </h1>
        <p class="text-gray-600 text-sm sm:text-base mt-4 max-w-md mx-auto">Expert tips, SEO strategies, and digital marketing insights to help your business grow.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ FEATURED POST ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-6 sm:mt-8">
  <div class="featured-blog">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
      <div class="aspect-[16/10] md:aspect-auto overflow-hidden">
        <img src="https://picsum.photos/seed/featured-blog/800/500" alt="Featured Blog Post" class="w-full h-full object-cover" loading="lazy">
      </div>
      <div class="p-6 sm:p-8 flex flex-col justify-center">
        <span class="tag inline-block w-fit mb-3">Featured</span>
        <span class="text-xs text-gray-400">March 15, 2026</span>
        <h2 class="text-xl sm:text-2xl font-bold mt-2">The Ultimate Guide to Local SEO in 2026</h2>
        <p class="text-gray-400 text-sm mt-2 leading-relaxed">Learn how to dominate local search results, optimize your Google Business Profile, and attract more customers from your area.</p>
        <div class="flex items-center gap-3 mt-4">
          <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-8 h-8 rounded-full object-cover" alt="Author" loading="lazy">
          <div>
            <p class="text-xs font-medium">John Doe</p>
            <p class="text-[10px] text-gray-500">SEO Specialist</p>
          </div>
        </div>
        <a href="#" class="inline-flex items-center gap-2 text-lime text-sm font-semibold mt-4 hover:underline">Read Full Article <i class='bx bx-arrow-right'></i></a>
      </div>
    </div>
  </div>
</section>

<!-- ============ CATEGORIES ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-6 sm:mt-8">
  <div class="flex flex-wrap justify-center gap-2">
    <button class="category-btn active" data-filter="all">All</button>
    <button class="category-btn" data-filter="seo">SEO</button>
    <button class="category-btn" data-filter="local">Local SEO</button>
    <button class="category-btn" data-filter="content">Content</button>
    <button class="category-btn" data-filter="webdev">Web Development</button>
    <button class="category-btn" data-filter="marketing">Digital Marketing</button>
  </div>
</section>

<!-- ============ BLOG GRID ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-6 sm:mt-8">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="blogGrid">
    
    <!-- Post 1 -->
    <article class="blog-card" data-category="seo local">
      <div class="aspect-[16/10] overflow-hidden">
        <img src="https://picsum.photos/seed/blog-seo-1/600/400" alt="SEO Tips" class="w-full h-full object-cover" loading="lazy">
      </div>
      <div class="p-4">
        <span class="tag">Local SEO</span>
        <span class="text-[10px] text-gray-500 ml-2">April 10, 2026</span>
        <h3 class="text-base font-bold mt-2">10 Local SEO Tips for Small Businesses</h3>
        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Actionable strategies to help small businesses rank higher in local search results.</p>
        <a href="#" class="inline-flex items-center gap-1 text-lime text-xs font-semibold mt-3 hover:underline">Read More <i class='bx bx-arrow-right'></i></a>
      </div>
    </article>

    <!-- Post 2 -->
    <article class="blog-card" data-category="content seo">
      <div class="aspect-[16/10] overflow-hidden">
        <img src="https://picsum.photos/seed/blog-content/600/400" alt="Content Strategy" class="w-full h-full object-cover" loading="lazy">
      </div>
      <div class="p-4">
        <span class="tag">Content SEO</span>
        <span class="text-[10px] text-gray-500 ml-2">April 8, 2026</span>
        <h3 class="text-base font-bold mt-2">Content Strategy That Drives SEO Results</h3>
        <p class="text-gray-400 text-xs mt-1 leading-relaxed">How to create content that ranks, engages, and converts visitors into customers.</p>
        <a href="#" class="inline-flex items-center gap-1 text-lime text-xs font-semibold mt-3 hover:underline">Read More <i class='bx bx-arrow-right'></i></a>
      </div>
    </article>

    <!-- Post 3 -->
    <article class="blog-card" data-category="webdev">
      <div class="aspect-[16/10] overflow-hidden">
        <img src="https://picsum.photos/seed/blog-webdev/600/400" alt="Web Development" class="w-full h-full object-cover" loading="lazy">
      </div>
      <div class="p-4">
        <span class="tag">Web Development</span>
        <span class="text-[10px] text-gray-500 ml-2">April 5, 2026</span>
        <h3 class="text-base font-bold mt-2">Why Website Speed Matters for SEO</h3>
        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Learn how page speed affects your rankings and how to optimize your website.</p>
        <a href="#" class="inline-flex items-center gap-1 text-lime text-xs font-semibold mt-3 hover:underline">Read More <i class='bx bx-arrow-right'></i></a>
      </div>
    </article>

    <!-- Post 4 -->
    <article class="blog-card" data-category="seo technical">
      <div class="aspect-[16/10] overflow-hidden">
        <img src="https://picsum.photos/seed/blog-technical/600/400" alt="Technical SEO" class="w-full h-full object-cover" loading="lazy">
      </div>
      <div class="p-4">
        <span class="tag">Technical SEO</span>
        <span class="text-[10px] text-gray-500 ml-2">April 2, 2026</span>
        <h3 class="text-base font-bold mt-2">Technical SEO Checklist for 2026</h3>
        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Essential technical SEO tasks to ensure your website is fully optimized for search engines.</p>
        <a href="#" class="inline-flex items-center gap-1 text-lime text-xs font-semibold mt-3 hover:underline">Read More <i class='bx bx-arrow-right'></i></a>
      </div>
    </article>

    <!-- Post 5 -->
    <article class="blog-card" data-category="marketing">
      <div class="aspect-[16/10] overflow-hidden">
        <img src="https://picsum.photos/seed/blog-marketing/600/400" alt="Digital Marketing" class="w-full h-full object-cover" loading="lazy">
      </div>
      <div class="p-4">
        <span class="tag">Digital Marketing</span>
        <span class="text-[10px] text-gray-500 ml-2">March 28, 2026</span>
        <h3 class="text-base font-bold mt-2">SEO vs. PPC: Which Is Right for Your Business?</h3>
        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Compare the pros and cons of SEO and PPC to make an informed decision for your marketing budget.</p>
        <a href="#" class="inline-flex items-center gap-1 text-lime text-xs font-semibold mt-3 hover:underline">Read More <i class='bx bx-arrow-right'></i></a>
      </div>
    </article>

    <!-- Post 6 -->
    <article class="blog-card" data-category="seo local">
      <div class="aspect-[16/10] overflow-hidden">
        <img src="https://picsum.photos/seed/blog-gmb/600/400" alt="Google Business Profile" class="w-full h-full object-cover" loading="lazy">
      </div>
      <div class="p-4">
        <span class="tag">Local SEO</span>
        <span class="text-[10px] text-gray-500 ml-2">March 25, 2026</span>
        <h3 class="text-base font-bold mt-2">How to Optimize Your Google Business Profile</h3>
        <p class="text-gray-400 text-xs mt-1 leading-relaxed">Step-by-step guide to optimizing your GMB profile for maximum visibility and engagement.</p>
        <a href="#" class="inline-flex items-center gap-1 text-lime text-xs font-semibold mt-3 hover:underline">Read More <i class='bx bx-arrow-right'></i></a>
      </div>
    </article>

  </div>
</section>

<!-- ============ NEWSLETTER ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="bg-[#141414] border border-white/5 rounded-[2rem] p-6 sm:p-10 text-center">
    <i class='bx bx-envelope text-3xl lime mb-3'></i>
    <h2 class="text-2xl sm:text-3xl font-bold">Subscribe to Our Newsletter</h2>
    <p class="text-gray-400 text-sm max-w-md mx-auto mt-2">Get the latest SEO tips, strategies, and insights delivered straight to your inbox.</p>
    <form class="flex flex-wrap justify-center gap-3 mt-4 max-w-md mx-auto" onsubmit="return false;">
      <input type="email" required placeholder="Enter your email" class="flex-1 min-w-[200px] bg-[#0c0c0c] border border-white/10 rounded-full px-4 py-3 text-sm outline-none placeholder:text-gray-500 text-white focus:border-lime">
      <button type="submit" class="bg-lime text-[#101010] font-semibold rounded-full px-6 py-3 text-sm whitespace-nowrap hover:brightness-95 transition">Subscribe</button>
    </form>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<?php include "includes/footer.php" ?>

<?php include "includes/js-links.php" ?>
</body>
</html>