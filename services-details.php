<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
  <title>Creatix · Service Details</title>
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

<!-- ============ SERVICE DETAILS ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-6">
  <div class="detail-card">
    <!-- Back button -->
    <a href="services.php" class="back-link mb-4 text-sm">
      <i class='bx bx-arrow-back'></i> Back to services
    </a>

    <!-- Service Header -->
    <div id="serviceContent">
      <div class="flex flex-wrap items-start gap-4">
        <div class="flex-1 min-w-[200px]">
          <div class="flex items-center gap-3 flex-wrap">
            <div class="service-icon-large" id="serviceIcon" style="background:rgba(166,241,59,0.08);width:64px;height:64px;border-radius:1.25rem;display:flex;align-items:center;justify-content:center;font-size:2.2rem;color:#A6F13B;">
              <i class='bx bx-pen'></i>
            </div>
            <div>
              <h2 id="serviceTitle" class="text-2xl sm:text-3xl font-bold">UI/UX Design</h2>
              <span id="serviceTag" class="tag inline-block mt-1">01</span>
            </div>
          </div>
          <p id="serviceDescription" class="text-gray-400 text-sm mt-3 max-w-xl leading-relaxed">
            User-centered designs that combine aesthetics with functionality. We create intuitive interfaces that delight users and drive engagement.
          </p>
        </div>
        <div class="flex gap-2">
          <button class="bg-lime text-[#101010] font-semibold rounded-full px-5 py-2.5 text-sm hover:brightness-95 transition">
            <i class='bx bx-calendar'></i> Book Now
          </button>
          <button class="border border-white/20 text-white font-semibold rounded-full px-5 py-2.5 text-sm hover:bg-white hover:text-[#101010] transition">
            <i class='bx bx-heart'></i>
          </button>
        </div>
      </div>

      <!-- Main Image -->
      <div class="mt-5 rounded-2xl overflow-hidden aspect-[16/6] bg-[#1a1a1a]">
        <img id="serviceImage" src="https://picsum.photos/seed/uiux-design/1200/500" alt="Service detail" class="w-full h-full object-cover" />
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-5">
        <div class="stat-item">
          <p class="stat-number" id="statProjects">150+</p>
          <p class="text-xs text-gray-400 mt-1">Projects Delivered</p>
        </div>
        <div class="stat-item">
          <p class="stat-number" id="statClients">98%</p>
          <p class="text-xs text-gray-400 mt-1">Client Satisfaction</p>
        </div>
        <div class="stat-item">
          <p class="stat-number" id="statTeam">12</p>
          <p class="text-xs text-gray-400 mt-1">Expert Team</p>
        </div>
        <div class="stat-item">
          <p class="stat-number" id="statTime">2.5x</p>
          <p class="text-xs text-gray-400 mt-1">Faster Delivery</p>
        </div>
      </div>

      <!-- Detailed Info -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-5">
        <div class="lg:col-span-2 space-y-4">
          <div>
            <h3 class="text-lg font-bold mb-2">What We Offer</h3>
            <ul id="offerList" class="space-y-2 text-sm text-gray-300">
              <li class="flex items-start gap-2"><i class='bx bx-check-circle text-lime mt-0.5'></i> User research and persona development</li>
              <li class="flex items-start gap-2"><i class='bx bx-check-circle text-lime mt-0.5'></i> Wireframing and interactive prototyping</li>
              <li class="flex items-start gap-2"><i class='bx bx-check-circle text-lime mt-0.5'></i> Visual design and design systems</li>
              <li class="flex items-start gap-2"><i class='bx bx-check-circle text-lime mt-0.5'></i> Usability testing and iteration</li>
            </ul>
          </div>
          <div>
            <h3 class="text-lg font-bold mb-2">Our Process</h3>
            <p id="processText" class="text-sm text-gray-400 leading-relaxed">
              We follow a user-centered design process: Discover → Define → Design → Test → Deliver. 
              Each phase involves close collaboration with you to ensure the final product exceeds expectations.
            </p>
          </div>
        </div>
        <div>
          <h3 class="text-lg font-bold mb-3">Tools & Technologies</h3>
          <div class="flex flex-wrap gap-2" id="toolsList">
            <span class="tag">Figma</span>
            <span class="tag">Sketch</span>
            <span class="tag">Adobe XD</span>
            <span class="tag">InVision</span>
            <span class="tag">Zeplin</span>
            <span class="tag">Miro</span>
          </div>
          
          <div class="mt-4 bg-[#1a1a1a] rounded-xl p-4 border border-white/5">
            <p class="text-xs text-gray-400 mb-1">Estimated Timeline</p>
            <p class="text-sm font-medium" id="timelineText">4-8 weeks</p>
            <p class="text-xs text-gray-400 mt-2">Starting from</p>
            <p class="text-lg font-bold lime" id="priceText">$2,500</p>
          </div>
        </div>
      </div>

      <!-- Related Services -->
      <div class="mt-6 pt-5 border-t border-white/5">
        <h3 class="text-sm font-semibold text-gray-400 mb-3">Related Services</h3>
        <div class="flex flex-wrap gap-2">
          <a href="service-details.php?id=web-dev" class="tag hover:bg-lime hover:text-[#101010] transition cursor-pointer">Web Development</a>
          <a href="service-details.php?id=app-design" class="tag hover:bg-lime hover:text-[#101010] transition cursor-pointer">App Design</a>
          <a href="service-details.php?id=branding" class="tag hover:bg-lime hover:text-[#101010] transition cursor-pointer">Branding</a>
          <a href="service-details.php?id=motion" class="tag hover:bg-lime hover:text-[#101010] transition cursor-pointer">Motion Graphics</a>
        </div>
      </div>
    </div>
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