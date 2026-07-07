<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
  <title>Creatix · Services</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet' />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    :root { --lime: #A6F13B; --lime-dark: #8BD82E; }
    * { font-family: 'Manrope', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
    body { background: #0c0c0c; color: #ffffff; overflow-x: hidden; }
    .lime { color: var(--lime); }
    .bg-lime { background: var(--lime); }
    .pill-nav {
      background: #101010;
      border-radius: 9999px;
      padding: 0.6rem 1.2rem;
    }
    .service-card {
      background: #141414;
      border: 1px solid rgba(255,255,255,0.06);
      border-radius: 1.5rem;
      padding: 1.75rem;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .service-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
      border-color: rgba(166, 241, 59, 0.2);
    }
    .service-icon {
      background: rgba(166, 241, 59, 0.08);
      width: 56px;
      height: 56px;
      border-radius: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      color: #A6F13B;
    }
    .tag {
      background: rgba(166, 241, 59, 0.12);
      color: #A6F13B;
      padding: 0.25rem 0.9rem;
      border-radius: 9999px;
      font-size: 0.7rem;
      font-weight: 600;
      letter-spacing: 0.02em;
    }
    @media (max-width: 640px) {
      .service-card { padding: 1.25rem; }
    }
  </style>
</head>
<body>

<!-- ============ FIXED NAVBAR ============ -->
<?php include "includes/navbar.php" ?>

<!-- spacer -->
<div class="pt-[70px] sm:pt-[84px]"></div>

<!-- ============ SERVICES PAGE ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-6">
  <div class="text-center max-w-3xl mx-auto mb-10">
    <span class="tag inline-block mb-3">WHAT WE DO</span>
    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight">
      Our <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Services</span>
    </h1>
    <p class="text-gray-400 text-sm sm:text-base mt-3 max-w-2xl mx-auto">
      We offer a range of creative and digital services designed to help your brand stand out and grow.
    </p>
  </div>

  <!-- Services Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <!-- Service 1: UI/UX Design -->
    <div class="service-card">
      <div class="service-icon mb-4">
        <i class='bx bx-pen'></i>
      </div>
      <div class="flex items-center gap-2 mb-2">
        <h3 class="text-lg font-bold">UI/UX Design</h3>
        <span class="tag text-[10px]">01</span>
      </div>
      <p class="text-gray-400 text-sm leading-relaxed">
        User-centered designs that combine aesthetics with functionality. We create intuitive interfaces that delight users and drive engagement.
      </p>
      <div class="flex flex-wrap gap-1.5 mt-3">
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Wireframing</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Prototyping</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">User Testing</span>
      </div>
    </div>

    <!-- Service 2: Web Development -->
    <div class="service-card">
      <div class="service-icon mb-4">
        <i class='bx bx-code-alt'></i>
      </div>
      <div class="flex items-center gap-2 mb-2">
        <h3 class="text-lg font-bold">Web Development</h3>
        <span class="tag text-[10px]">02</span>
      </div>
      <p class="text-gray-400 text-sm leading-relaxed">
        Custom web solutions built with modern technologies. From landing pages to complex web applications, we deliver scalable and performant websites.
      </p>
      <div class="flex flex-wrap gap-1.5 mt-3">
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">React</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Node.js</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">CMS</span>
      </div>
    </div>

    <!-- Service 3: 3D Designs -->
    <div class="service-card">
      <div class="service-icon mb-4">
        <i class='bx bx-cube'></i>
      </div>
      <div class="flex items-center gap-2 mb-2">
        <h3 class="text-lg font-bold">3D Designs</h3>
        <span class="tag text-[10px]">03</span>
      </div>
      <p class="text-gray-400 text-sm leading-relaxed">
        Immersive 3D visualizations and models that bring your products and ideas to life with stunning realism and detail.
      </p>
      <div class="flex flex-wrap gap-1.5 mt-3">
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Blender</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Rendering</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Animation</span>
      </div>
    </div>

    <!-- Service 4: Motion Graphics -->
    <div class="service-card">
      <div class="service-icon mb-4">
        <i class='bx bx-movie'></i>
      </div>
      <div class="flex items-center gap-2 mb-2">
        <h3 class="text-lg font-bold">Motion Graphics</h3>
        <span class="tag text-[10px]">04</span>
      </div>
      <p class="text-gray-400 text-sm leading-relaxed">
        Dynamic motion graphics that captivate audiences. From explainer videos to animated logos, we create visual stories that engage and inspire.
      </p>
      <div class="flex flex-wrap gap-1.5 mt-3">
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">2D Animation</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">3D Animation</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">VFX</span>
      </div>
    </div>

    <!-- Service 5: Branding -->
    <div class="service-card">
      <div class="service-icon mb-4">
        <i class='bx bx-brush'></i>
      </div>
      <div class="flex items-center gap-2 mb-2">
        <h3 class="text-lg font-bold">Branding</h3>
        <span class="tag text-[10px]">05</span>
      </div>
      <p class="text-gray-400 text-sm leading-relaxed">
        Complete brand identity solutions including logo design, visual identity, typography, and brand guidelines that make your brand memorable.
      </p>
      <div class="flex flex-wrap gap-1.5 mt-3">
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Logo Design</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Identity</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Guidelines</span>
      </div>
    </div>

    <!-- Service 6: Digital Marketing -->
    <div class="service-card">
      <div class="service-icon mb-4">
        <i class='bx bx-trending-up'></i>
      </div>
      <div class="flex items-center gap-2 mb-2">
        <h3 class="text-lg font-bold">Digital Marketing</h3>
        <span class="tag text-[10px]">06</span>
      </div>
      <p class="text-gray-400 text-sm leading-relaxed">
        Data-driven marketing strategies including SEO, PPC, social media management, and content marketing to grow your online presence.
      </p>
      <div class="flex flex-wrap gap-1.5 mt-3">
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">SEO</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">PPC</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Social Media</span>
      </div>
    </div>

    <!-- Service 7: App Design -->
    <div class="service-card">
      <div class="service-icon mb-4">
        <i class='bx bx-mobile-alt'></i>
      </div>
      <div class="flex items-center gap-2 mb-2">
        <h3 class="text-lg font-bold">App Design</h3>
        <span class="tag text-[10px]">07</span>
      </div>
      <p class="text-gray-400 text-sm leading-relaxed">
        Mobile-first app designs that provide seamless user experiences across iOS and Android platforms with intuitive navigation and stunning visuals.
      </p>
      <div class="flex flex-wrap gap-1.5 mt-3">
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">iOS</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Android</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Prototyping</span>
      </div>
    </div>

    <!-- Service 8: Content Creation -->
    <div class="service-card">
      <div class="service-icon mb-4">
        <i class='bx bx-edit-alt'></i>
      </div>
      <div class="flex items-center gap-2 mb-2">
        <h3 class="text-lg font-bold">Content Creation</h3>
        <span class="tag text-[10px]">08</span>
      </div>
      <p class="text-gray-400 text-sm leading-relaxed">
        Compelling content that tells your brand story. From copywriting and blog posts to video scripts and social media content that resonates.
      </p>
      <div class="flex flex-wrap gap-1.5 mt-3">
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Copywriting</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Blog</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Video Script</span>
      </div>
    </div>

    <!-- Service 9: Consulting -->
    <div class="service-card">
      <div class="service-icon mb-4">
        <i class='bx bx-bulb'></i>
      </div>
      <div class="flex items-center gap-2 mb-2">
        <h3 class="text-lg font-bold">Creative Consulting</h3>
        <span class="tag text-[10px]">09</span>
      </div>
      <p class="text-gray-400 text-sm leading-relaxed">
        Strategic creative consulting to help you define your vision, identify opportunities, and build a roadmap for creative success.
      </p>
      <div class="flex flex-wrap gap-1.5 mt-3">
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Strategy</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Workshops</span>
        <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400">Audit</span>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="mt-12 bg-lime text-[#101010] rounded-[2rem] p-6 sm:p-9 text-center">
    <h2 class="text-2xl sm:text-3xl font-bold mb-2">Ready to bring your ideas to life?</h2>
    <p class="text-sm sm:text-base max-w-md mx-auto text-[#1a1a1a]/80">Let's collaborate and create something amazing together.</p>
    <button class="mt-4 bg-[#101010] text-white font-semibold rounded-full px-6 py-3 text-sm hover:bg-black transition">
      Get Started <i class='bx bx-arrow-right ml-1'></i>
    </button>
  </div>
</section>

<!-- ============ MARQUEE ============ -->
<section class="mt-12 border-y border-white/10 bg-lime text-[#101010] py-2.5 overflow-hidden">
  <div class="marquee-track font-bold text-xs sm:text-base" style="display:flex;width:max-content;animation:marquee 22s linear infinite;">
    <div class="flex items-center gap-2 pr-6">
      <span>UX Design</span><i class='bx bx-sparkle text-sm sm:text-base'></i>
      <span>App Design</span><i class='bx bx-sparkle text-sm sm:text-base'></i>
      <span>Dashboard</span><i class='bx bx-sparkle text-sm sm:text-base'></i>
      <span>Wireframe</span><i class='bx bx-sparkle text-sm sm:text-base'></i>
      <span>User Research</span><i class='bx bx-sparkle text-sm sm:text-base'></i>
    </div>
    <div class="flex items-center gap-2 pr-6">
      <span>UX Design</span><i class='bx bx-sparkle text-sm sm:text-base'></i>
      <span>App Design</span><i class='bx bx-sparkle text-sm sm:text-base'></i>
      <span>Dashboard</span><i class='bx bx-sparkle text-sm sm:text-base'></i>
      <span>Wireframe</span><i class='bx bx-sparkle text-sm sm:text-base'></i>
      <span>User Research</span><i class='bx bx-sparkle text-sm sm:text-base'></i>
    </div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-12 pb-6">
  <div class="bg-lime text-[#101010] rounded-[2rem] p-5 sm:p-9">
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6">
      <div>
        <div class="flex items-center gap-2 font-bold text-xl mb-2">
          <i class='bx bx-sparkle text-xl'></i>
          <span>Creatix</span>
        </div>
        <p class="text-sm max-w-xs text-[#1a1a1a]/80">Empowering brands through creative solutions — web, branding & digital design for over a decade.</p>
        <div class="flex gap-2 mt-4">
          <a href="#" class="footer-icon" style="background:#101010;color:#fff;display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;border-radius:9999px;transition:opacity 0.2s;text-decoration:none;"><i class='bx bxl-facebook'></i></a>
          <a href="#" class="footer-icon" style="background:#101010;color:#fff;display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;border-radius:9999px;transition:opacity 0.2s;text-decoration:none;"><i class='bx bxl-instagram'></i></a>
          <a href="#" class="footer-icon" style="background:#101010;color:#fff;display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;border-radius:9999px;transition:opacity 0.2s;text-decoration:none;"><i class='bx bxl-twitter'></i></a>
          <a href="#" class="footer-icon" style="background:#101010;color:#fff;display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;border-radius:9999px;transition:opacity 0.2s;text-decoration:none;"><i class='bx bxl-linkedin'></i></a>
        </div>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 text-sm">
        <div><p class="font-bold mb-2">Company</p><ul class="space-y-1.5 text-[#1a1a1a]/80"><li><a href="#" class="hover:underline">About Us</a></li><li><a href="#" class="hover:underline">Our Team</a></li><li><a href="#" class="hover:underline">Careers</a></li></ul></div>
        <div><p class="font-bold mb-2">Support</p><ul class="space-y-1.5 text-[#1a1a1a]/80"><li><a href="#" class="hover:underline">Help Center</a></li><li><a href="#" class="hover:underline">Contact Us</a></li><li><a href="#" class="hover:underline">FAQs</a></li></ul></div>
        <div><p class="font-bold mb-2">Products</p><ul class="space-y-1.5 text-[#1a1a1a]/80"><li><a href="#" class="hover:underline">Web Design</a></li><li><a href="#" class="hover:underline">Branding</a></li><li><a href="#" class="hover:underline">Motion Graphics</a></li></ul></div>
      </div>
      <div class="max-w-xs"><p class="font-bold mb-2">Subscribe</p><form class="flex flex-wrap gap-2" onsubmit="return false;"><input type="email" required placeholder="Your email" class="flex-1 min-w-[150px] bg-white/40 placeholder:text-[#1a1a1a]/60 rounded-full px-4 py-2 text-sm outline-none"><button class="bg-[#101010] text-white rounded-full px-4 py-2 text-sm font-semibold hover:opacity-85 transition">Subscribe</button></form></div>
    </div>
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-6 pt-5 border-t border-[#1a1a1a]/15 text-xs text-[#1a1a1a]/70"><p>© 2026 Creatix. All rights reserved.</p></div>
  </div>
</footer>

<style>
  @keyframes marquee {
    from { transform: translateX(0); }
    to { transform: translateX(-50%); }
  }
  .marquee-track { display: flex; width: max-content; animation: marquee 22s linear infinite; }
</style>

<script>
  // Mobile menu
  const menuBtn = document.getElementById('menuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  const iconOpen = document.getElementById('menuIconOpen');
  const iconClose = document.getElementById('menuIconClose');

  function openMenu(){ mobileMenu.classList.remove('hidden'); iconOpen.classList.add('hidden'); iconClose.classList.remove('hidden'); menuBtn.setAttribute('aria-expanded','true'); }
  function closeMenu(){ mobileMenu.classList.add('hidden'); iconOpen.classList.remove('hidden'); iconClose.classList.add('hidden'); menuBtn.setAttribute('aria-expanded','false'); }
  menuBtn.addEventListener('click', (e) => { e.stopPropagation(); mobileMenu.classList.contains('hidden') ? openMenu() : closeMenu(); });
  document.querySelectorAll('.mobile-link').forEach(link => link.addEventListener('click', closeMenu));
  document.addEventListener('click', (e) => { if (!mobileMenu.classList.contains('hidden') && !mobileMenu.contains(e.target) && e.target !== menuBtn) closeMenu(); });
  window.addEventListener('resize', () => { if (window.innerWidth >= 768) closeMenu(); });
</script>

</body>
</html>