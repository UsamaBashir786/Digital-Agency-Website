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
    <a href="contact.php" class="inline-block mt-4 bg-[#101010] text-white font-bold rounded-full px-8 py-3 text-sm hover:bg-black transition">Get in Touch</a>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<?php include "includes/footer.php" ?>


<?php include "includes/js-links.php" ?>
</body>
</html>