<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
  <title>About Us — Creatix SEO & Digital Agency</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --lime: #A6F13B; --lime-dark: #8BD82E; }
    * { font-family: 'Manrope', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
    body { background: #0c0c0c; color: #ffffff; overflow-x: hidden; }
    .lime { color: var(--lime); }
    .bg-lime { background: var(--lime); }
    .pill-nav { background: #101010; border-radius: 9999px; padding: 0.6rem 1.2rem; }
    .footer-icon { background: #101010; color: #ffffff !important; display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; border-radius: 9999px; transition: opacity 0.2s; text-decoration: none; }
    .footer-icon:hover { opacity: 0.8; }
    .footer-icon i { color: #ffffff !important; font-size: 1.1rem; }
    .footer-subscribe-btn { background: #101010; color: #ffffff !important; border-radius: 9999px; padding: 0.5rem 1.2rem; font-size: 0.875rem; font-weight: 600; transition: opacity 0.2s; border: none; cursor: pointer; }
    .footer-subscribe-btn:hover { opacity: 0.85; }
    .value-card { background: #141414; border: 1px solid rgba(255,255,255,0.06); border-radius: 1.5rem; padding: 1.75rem; transition: transform 0.3s ease, border-color 0.3s ease; }
    .value-card:hover { transform: translateY(-4px); border-color: rgba(166, 241, 59, 0.3); }
    .value-icon { background: rgba(166, 241, 59, 0.08); width: 52px; height: 52px; border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; color: #A6F13B; }
    .milestone { text-align: center; padding: 1.5rem; background: #141414; border-radius: 1.5rem; border: 1px solid rgba(255,255,255,0.06); }
    .milestone .number { font-size: 2.5rem; font-weight: 800; color: #A6F13B; }
    .team-card { background: #141414; border: 1px solid rgba(255,255,255,0.06); border-radius: 1.5rem; padding: 1.5rem; transition: transform 0.3s ease; }
    .team-card:hover { transform: translateY(-4px); border-color: rgba(166, 241, 59, 0.2); }
    .dropdown-menu { display: none; position: absolute; top: 100%; left: 0; background: #1a1a1a; border-radius: 1rem; padding: 0.75rem 0; min-width: 200px; border: 1px solid rgba(255,255,255,0.06); box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
    .dropdown-trigger:hover .dropdown-menu { display: block; }
    .dropdown-menu a { display: block; padding: 0.5rem 1.25rem; color: #d0d0d0; font-size: 0.85rem; transition: all 0.2s; text-decoration: none; }
    .dropdown-menu a:hover { color: #A6F13B; background: rgba(166, 241, 59, 0.05); }
    @media (max-width: 768px) { .dropdown-menu { position: relative; top: 0; background: transparent; border: none; box-shadow: none; padding: 0.5rem 0 0 1rem; } .dropdown-trigger:hover .dropdown-menu { display: none; } .dropdown-trigger.active .dropdown-menu { display: block; } }
  </style>
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
          <span class="inline-block bg-lime text-[#101010] text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full">ABOUT US</span>
          <h1 class="text-3xl sm:text-4xl md:text-[3.2rem] font-bold leading-[1.15] mt-3">
            We're <span class="bg-lime px-3 py-1 rounded-xl inline-block">Creatix</span>
          </h1>
          <p class="text-gray-600 text-sm sm:text-base mt-4 max-w-md">A data-driven SEO and digital marketing agency helping businesses rank higher, attract more customers, and grow faster.</p>
          <div class="flex flex-wrap gap-3 mt-6">
            <a href="#team" class="bg-lime text-[#101010] font-bold rounded-full px-6 py-3 text-sm hover:brightness-95 transition">Meet the Team</a>
            <a href="#values" class="border border-gray-300 text-gray-700 font-semibold rounded-full px-6 py-3 text-sm hover:bg-[#101010] hover:text-white hover:border-[#101010] transition">Our Values</a>
          </div>
        </div>
        <div class="flex justify-center">
          <div class="bg-gray-100 rounded-[2rem] overflow-hidden w-full max-w-md aspect-[4/3] shadow-2xl">
            <img src="https://picsum.photos/seed/about-creatix/600/450" alt="Creatix Team" class="w-full h-full object-cover" loading="lazy">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ MISSION & VISION ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div class="bg-[#141414] border border-white/5 rounded-2xl p-6 sm:p-8">
      <div class="bg-lime/10 w-12 h-12 rounded-xl flex items-center justify-center mb-4"><i class='bx bx-target-lock text-2xl lime'></i></div>
      <h3 class="text-xl font-bold">Our Mission</h3>
      <p class="text-gray-400 text-sm mt-2 leading-relaxed">To empower businesses with data-driven SEO and digital strategies that deliver measurable growth, transparency, and long-term success.</p>
    </div>
    <div class="bg-[#141414] border border-white/5 rounded-2xl p-6 sm:p-8">
      <div class="bg-lime/10 w-12 h-12 rounded-xl flex items-center justify-center mb-4"><i class='bx bx-show-alt text-2xl lime'></i></div>
      <h3 class="text-xl font-bold">Our Vision</h3>
      <p class="text-gray-400 text-sm mt-2 leading-relaxed">To become the most trusted SEO and digital marketing agency for businesses worldwide, known for innovation, integrity, and results.</p>
    </div>
  </div>
</section>

<!-- ============ MILESTONES ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-8 sm:mt-10">
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
    <div class="milestone"><span class="number">2016</span><p class="text-xs text-gray-400 mt-1">Founded</p></div>
    <div class="milestone"><span class="number">500+</span><p class="text-xs text-gray-400 mt-1">Projects</p></div>
    <div class="milestone"><span class="number">10+</span><p class="text-xs text-gray-400 mt-1">Years Experience</p></div>
    <div class="milestone"><span class="number">98%</span><p class="text-xs text-gray-400 mt-1">Satisfaction</p></div>
  </div>
</section>

<!-- ============ OUR STORY ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
    <div>
      <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">OUR STORY</span>
      <h2 class="text-2xl sm:text-3xl font-bold mt-3">From Startup to <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Industry Leader</span></h2>
      <p class="text-gray-400 text-sm mt-3 leading-relaxed">Creatix was founded with a simple mission: to help businesses navigate the complex world of SEO and digital marketing with clarity, transparency, and results.</p>
      <p class="text-gray-400 text-sm mt-3 leading-relaxed">What started as a small team of SEO enthusiasts has grown into a full-service digital agency serving clients across Pakistan and internationally. We've helped over 500 businesses — from local startups to established enterprises — achieve their growth goals through data-driven strategies and creative solutions.</p>
      <p class="text-gray-400 text-sm mt-3 leading-relaxed">Today, we continue to innovate, adapt, and lead in the ever-evolving digital landscape, staying true to our core values of integrity, excellence, and client success.</p>
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div class="bg-[#141414] border border-white/5 rounded-2xl p-4 text-center">
        <div class="bg-lime/10 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2"><i class='bx bx-trending-up text-2xl lime'></i></div>
        <p class="text-xs text-gray-400">Data-Driven</p>
      </div>
      <div class="bg-[#141414] border border-white/5 rounded-2xl p-4 text-center">
        <div class="bg-lime/10 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2"><i class='bx bx-heart text-2xl lime'></i></div>
        <p class="text-xs text-gray-400">Client-First</p>
      </div>
      <div class="bg-[#141414] border border-white/5 rounded-2xl p-4 text-center">
        <div class="bg-lime/10 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2"><i class='bx bx-rocket text-2xl lime'></i></div>
        <p class="text-xs text-gray-400">Innovative</p>
      </div>
      <div class="bg-[#141414] border border-white/5 rounded-2xl p-4 text-center">
        <div class="bg-lime/10 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2"><i class='bx bx-shield text-2xl lime'></i></div>
        <p class="text-xs text-gray-400">Trustworthy</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ OUR VALUES ============ -->
<section id="values" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="text-center max-w-3xl mx-auto mb-8">
    <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">OUR VALUES</span>
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mt-3">What <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Drives Us</span></h2>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <div class="value-card"><div class="value-icon mb-3"><i class='bx bx-check-shield'></i></div><h3 class="text-lg font-bold">Integrity</h3><p class="text-gray-400 text-sm leading-relaxed">We believe in honest, transparent work. No black-hat tactics, no shortcuts — just genuine strategies that deliver sustainable results.</p></div>
    <div class="value-card"><div class="value-icon mb-3"><i class='bx bx-bulb'></i></div><h3 class="text-lg font-bold">Innovation</h3><p class="text-gray-400 text-sm leading-relaxed">The digital landscape evolves constantly, and so do we. We stay ahead of the curve with cutting-edge strategies and tools.</p></div>
    <div class="value-card"><div class="value-icon mb-3"><i class='bx bx-group'></i></div><h3 class="text-lg font-bold">Collaboration</h3><p class="text-gray-400 text-sm leading-relaxed">We work hand-in-hand with our clients, treating their success as our own. Your goals become our mission.</p></div>
    <div class="value-card"><div class="value-icon mb-3"><i class='bx bx-bar-chart-alt-2'></i></div><h3 class="text-lg font-bold">Results</h3><p class="text-gray-400 text-sm leading-relaxed">We're obsessed with measurable outcomes. Every strategy is designed to drive real growth and ROI for your business.</p></div>
    <div class="value-card"><div class="value-icon mb-3"><i class='bx bx-heart'></i></div><h3 class="text-lg font-bold">Passion</h3><p class="text-gray-400 text-sm leading-relaxed">We love what we do. Our team brings energy, creativity, and dedication to every project we take on.</p></div>
    <div class="value-card"><div class="value-icon mb-3"><i class='bx bx-support'></i></div><h3 class="text-lg font-bold">Support</h3><p class="text-gray-400 text-sm leading-relaxed">We're with you every step of the way — from strategy to execution and beyond. Your success is our priority.</p></div>
  </div>
</section>

<!-- ============ MEET THE TEAM ============ -->
<section id="team" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="text-center max-w-3xl mx-auto mb-8">
    <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">OUR TEAM</span>
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mt-3">The Minds <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Behind Creatix</span></h2>
    <p class="text-gray-400 text-sm mt-2 max-w-lg mx-auto">A passionate team of SEO experts, developers, designers, and strategists dedicated to your success.</p>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="team-card text-center">
      <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-24 h-24 rounded-full object-cover mx-auto mb-3" alt="Jane Smith" loading="lazy">
      <h4 class="font-bold">Jane Smith</h4>
      <p class="text-xs text-gray-400">CEO & Founder</p>
      <p class="text-xs text-gray-500 mt-1">10+ years in SEO & digital strategy</p>
    </div>
    <div class="team-card text-center">
      <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-24 h-24 rounded-full object-cover mx-auto mb-3" alt="John Doe" loading="lazy">
      <h4 class="font-bold">John Doe</h4>
      <p class="text-xs text-gray-400">Head of SEO</p>
      <p class="text-xs text-gray-500 mt-1">8+ years in technical SEO</p>
    </div>
    <div class="team-card text-center">
      <img src="https://randomuser.me/api/portraits/women/68.jpg" class="w-24 h-24 rounded-full object-cover mx-auto mb-3" alt="Sarah Lee" loading="lazy">
      <h4 class="font-bold">Sarah Lee</h4>
      <p class="text-xs text-gray-400">Content Director</p>
      <p class="text-xs text-gray-500 mt-1">6+ years in content strategy</p>
    </div>
    <div class="team-card text-center">
      <img src="https://randomuser.me/api/portraits/men/45.jpg" class="w-24 h-24 rounded-full object-cover mx-auto mb-3" alt="Mike Chen" loading="lazy">
      <h4 class="font-bold">Mike Chen</h4>
      <p class="text-xs text-gray-400">Lead Developer</p>
      <p class="text-xs text-gray-500 mt-1">7+ years in web development</p>
    </div>
  </div>
</section>

<!-- ============ CTA ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="bg-lime text-[#101010] rounded-[2rem] p-6 sm:p-10 text-center">
    <h2 class="text-2xl sm:text-3xl font-bold">Ready to grow with us?</h2>
    <p class="text-sm sm:text-base max-w-md mx-auto mt-2 text-[#1a1a1a]/80">Let's discuss how our team can help your business achieve its goals.</p>
    <a href="#contact" class="inline-block mt-4 bg-[#101010] text-white font-bold rounded-full px-8 py-3 text-sm hover:bg-black transition">Get in Touch</a>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16 pb-6">
  <div class="bg-lime text-[#101010] rounded-[2rem] p-5 sm:p-9">
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6">
      <div>
        <div class="flex items-center gap-2 font-bold text-xl mb-2">
          <i class='bx bx-sparkle text-xl'></i>
          <span>Creatix</span>
        </div>
        <p class="text-sm max-w-xs text-[#1a1a1a]/80">Data-driven SEO and web development agency helping businesses rank higher and grow faster.</p>
        <div class="flex gap-2 mt-4">
          <a href="#" class="footer-icon"><i class='bx bxl-facebook'></i></a>
          <a href="#" class="footer-icon"><i class='bx bxl-instagram'></i></a>
          <a href="#" class="footer-icon"><i class='bx bxl-twitter'></i></a>
          <a href="#" class="footer-icon"><i class='bx bxl-linkedin'></i></a>
        </div>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 text-sm">
        <div><p class="font-bold mb-2">Services</p><ul class="space-y-1.5 text-[#1a1a1a]/80"><li><a href="#" class="hover:underline">Local SEO</a></li><li><a href="#" class="hover:underline">On-Page SEO</a></li><li><a href="#" class="hover:underline">Web Development</a></li></ul></div>
        <div><p class="font-bold mb-2">Company</p><ul class="space-y-1.5 text-[#1a1a1a]/80"><li><a href="#" class="hover:underline">About Us</a></li><li><a href="#" class="hover:underline">Case Studies</a></li><li><a href="#" class="hover:underline">Blog</a></li></ul></div>
        <div><p class="font-bold mb-2">Support</p><ul class="space-y-1.5 text-[#1a1a1a]/80"><li><a href="#" class="hover:underline">Contact</a></li><li><a href="#" class="hover:underline">FAQs</a></li><li><a href="#" class="hover:underline">Privacy Policy</a></li></ul></div>
      </div>
      <div class="max-w-xs"><p class="font-bold mb-2">Subscribe</p><form class="flex flex-wrap gap-2" onsubmit="return false;"><input type="email" required placeholder="Your email" class="flex-1 min-w-[150px] bg-white/40 placeholder:text-[#1a1a1a]/60 rounded-full px-4 py-2 text-sm outline-none"><button class="footer-subscribe-btn">Subscribe</button></form></div>
    </div>
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-6 pt-5 border-t border-[#1a1a1a]/15 text-xs text-[#1a1a1a]/70"><p>© 2026 Creatix. All rights reserved.</p></div>
  </div>
</footer>

<script>
  // Mobile menu
  const menuBtn = document.getElementById('menuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  const iconOpen = document.getElementById('menuIconOpen');
  const iconClose = document.getElementById('menuIconClose');

  function openMenu(){ mobileMenu.classList.remove('hidden'); iconOpen.classList.add('hidden'); iconClose.classList.remove('hidden'); menuBtn.setAttribute('aria-expanded','true'); }
  function closeMenu(){ mobileMenu.classList.add('hidden'); iconOpen.classList.remove('hidden'); iconClose.classList.add('hidden'); menuBtn.setAttribute('aria-expanded','false'); }
  menuBtn.addEventListener('click', (e) => { e.stopPropagation(); mobileMenu.classList.contains('hidden') ? openMenu() : closeMenu(); });
  document.querySelectorAll('#mobileMenu a:not(#mobileServicesBtn)').forEach(link => link.addEventListener('click', closeMenu));
  document.addEventListener('click', (e) => { if (!mobileMenu.classList.contains('hidden') && !mobileMenu.contains(e.target) && e.target !== menuBtn) closeMenu(); });
  window.addEventListener('resize', () => { if (window.innerWidth >= 1024) closeMenu(); });

  // Mobile services dropdown
  document.getElementById('mobileServicesBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const menu = document.getElementById('mobileServicesMenu');
    const icon = document.getElementById('mobileServicesIcon');
    menu.classList.toggle('hidden');
    icon.classList.toggle('bx-chevron-down');
    icon.classList.toggle('bx-chevron-up');
  });
</script>

</body>
</html>