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
  <link rel="stylesheet" href="assets/styles/styles.css">
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
<?php include "includes/footer.php" ?>


<style>
  @keyframes marquee {
    from { transform: translateX(0); }
    to { transform: translateX(-50%); }
  }
  .marquee-track { display: flex; width: max-content; animation: marquee 22s linear infinite; }
</style>
<?php include "includes/js-links.php" ?>
</body>
</html>