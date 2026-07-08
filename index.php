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
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/css-links.php" ?>
</head>
<body>

<!-- ============ NAVBAR WITH UPDATED LINKS ============ -->
<?php include "includes/navbar.php" ?>

<!-- ============ CONVERSION-OPTIMIZED HERO ============ -->
<header class="relative w-full">
  <div class="w-full">
    <div class="bg-white text-[#101010] rounded-b-[2rem] sm:rounded-b-[3rem] overflow-hidden relative">
      <div class="pt-[70px] sm:pt-[84px]"></div>
      <div class="relative px-4 sm:px-8 lg:px-12 pt-5 sm:pt-8 pb-8 sm:pb-12 max-w-[1400px] mx-auto">
        
        <!-- Decorative sparkle -->
        <i class='bx bx-sparkle absolute left-3 sm:left-6 top-3 sm:top-8 text-3xl sm:text-5xl lime opacity-90' aria-hidden="true"></i>

        <div class="grid grid-cols-1 lg:grid-cols-[1.1fr_0.9fr] gap-8 lg:gap-12 items-center max-w-6xl mx-auto">
          
          <!-- LEFT CONTENT -->
          <div class="text-center lg:text-left order-2 lg:order-1">
            <!-- Trust badge -->
            <div class="inline-flex items-center gap-2 bg-[#f0f5ea] rounded-full px-3 py-1.5 mb-4 trust-badge">
              <span class="flex gap-0.5">
                <i class='bx bxs-star text-yellow-400 text-xs' aria-hidden="true"></i>
                <i class='bx bxs-star text-yellow-400 text-xs' aria-hidden="true"></i>
                <i class='bx bxs-star text-yellow-400 text-xs' aria-hidden="true"></i>
                <i class='bx bxs-star text-yellow-400 text-xs' aria-hidden="true"></i>
                <i class='bx bxs-star text-yellow-400 text-xs' aria-hidden="true"></i>
              </span>
              <span class="text-[10px] font-semibold text-gray-700">Trusted by 2000+ brands</span>
            </div>

            <h1 class="text-[2rem] leading-[1.15] sm:text-4xl md:text-[3.4rem] font-bold tracking-tight">
              <span class="block">Empowering Brands</span>
              <span class="block">Through <span class="bg-lime px-2 sm:px-4 py-0.5 rounded-xl inline-block">Creative</span> Solutions</span>
            </h1>
            
            <p class="text-gray-600 text-sm sm:text-base mt-4 max-w-lg mx-auto lg:mx-0 leading-relaxed">
              Digital marketing agency delivering <strong>web design, branding, and SEO</strong> that drives real growth. 
              <span class="block sm:inline">Get a free consultation today.</span>
            </p>

            <!-- CTA Buttons - Conversion Focused -->
            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 mt-6">
              <a href="#contact" class="cta-primary bg-lime text-[#101010] font-bold rounded-full px-6 sm:px-8 py-3.5 text-sm hover:brightness-95 transition inline-flex items-center gap-2">
                <span>Start Your Project</span>
                <i class='bx bx-right-arrow-alt text-lg' aria-hidden="true"></i>
              </a>
              <a href="services.php" class="border border-gray-300 text-gray-700 font-semibold rounded-full px-6 sm:px-8 py-3.5 text-sm hover:bg-[#101010] hover:text-white hover:border-[#101010] transition inline-flex items-center gap-2">
                <i class='bx bx-play-circle text-lg' aria-hidden="true"></i>
                <span>View Services</span>
              </a>
            </div>

            <!-- Social proof / stats -->
            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6 mt-6 pt-5 border-t border-gray-200">
              <div class="flex items-center gap-2">
                <div class="flex -space-x-2">
                  <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-8 h-8 rounded-full border-2 border-white object-cover" alt="Client" loading="lazy">
                  <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-8 h-8 rounded-full border-2 border-white object-cover" alt="Client" loading="lazy">
                  <img src="https://randomuser.me/api/portraits/women/68.jpg" class="w-8 h-8 rounded-full border-2 border-white object-cover" alt="Client" loading="lazy">
                  <div class="w-8 h-8 rounded-full border-2 border-white bg-lime text-[#101010] flex items-center justify-center text-[10px] font-bold">+150</div>
                </div>
                <span class="text-xs text-gray-500">Happy clients</span>
              </div>
              <div class="flex items-center gap-2">
                <i class='bx bx-check-circle text-lime text-lg' aria-hidden="true"></i>
                <span class="text-xs text-gray-500">98% satisfaction rate</span>
              </div>
              <div class="flex items-center gap-2">
                <i class='bx bx-time-five text-lime text-lg' aria-hidden="true"></i>
                <span class="text-xs text-gray-500">10+ years experience</span>
              </div>
            </div>
          </div>

          <!-- RIGHT - HERO IMAGE WITH OVERLAY -->
          <div class="order-1 lg:order-2 flex justify-center">
            <div class="relative">
              <div class="hero-blob bg-gray-100 w-full max-w-[340px] sm:max-w-md aspect-[4/3.4] sm:aspect-[4/3] overflow-hidden mx-auto shadow-2xl">
                <img src="https://i.pinimg.com/736x/0a/3d/11/0a3d11bc1ca961016b339047941b9987.jpg" alt="Digital marketing agency team member" class="w-full h-full object-cover" loading="lazy">
              </div>
              <!-- Floating badge -->
              <div class="absolute -bottom-2 -right-2 sm:-bottom-4 sm:-right-4 bg-[#101010] text-white rounded-2xl px-4 py-2.5 shadow-xl flex items-center gap-3">
                <div class="flex items-center gap-1">
                  <i class='bx bx-star text-yellow-400 text-sm' aria-hidden="true"></i>
                  <span class="font-bold text-sm">4.9</span>
                </div>
                <span class="text-[10px] text-gray-400">Avg. Rating</span>
              </div>
              <!-- Floating badge 2 -->
              <div class="absolute -top-2 -left-2 sm:-top-4 sm:-left-4 bg-white rounded-2xl px-3 py-2 shadow-xl flex items-center gap-2">
                <i class='bx bx-trophy text-lime text-lg' aria-hidden="true"></i>
                <span class="text-[10px] font-bold text-[#101010]">Award Winning</span>
              </div>
            </div>
          </div>

        </div>

        <!-- Mobile CTA -->
        <div class="lg:hidden flex flex-wrap items-center justify-center gap-3 mt-6 sm:mt-8">
          <a href="#contact" class="bg-lime text-[#101010] font-bold rounded-full px-6 py-3.5 text-sm hover:brightness-95 transition inline-flex items-center gap-2 w-full sm:w-auto justify-center">
            <span>Start Your Project</span>
            <i class='bx bx-right-arrow-alt text-lg' aria-hidden="true"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- ============ STATS BAR ============ -->
<section class="max-w-[1180px] mx-auto px-3 sm:px-6 mt-4 sm:mt-6" aria-label="Company statistics">
  <div class="noise-card border border-white/5 rounded-[1.75rem] px-4 sm:px-8 py-5 sm:py-7 grid grid-cols-2 sm:grid-cols-4 gap-y-4 text-center" style="background: radial-gradient(120% 140% at 15% 0%, #262626 0%, #141414 55%, #0c0c0c 100%);">
    <div class="border-r border-white/10 sm:border-r sm:pr-3">
      <p class="text-2xl sm:text-3xl font-bold">2000<span class="lime">+</span></p>
      <p class="text-[10px] sm:text-xs text-gray-400 mt-0.5">Companies Served</p>
    </div>
    <div class="sm:border-r sm:border-white/10 sm:pr-3">
      <p class="text-2xl sm:text-3xl font-bold">10<span class="lime">+</span></p>
      <p class="text-[10px] sm:text-xs text-gray-400 mt-0.5">Years Experience</p>
    </div>
    <div class="border-r border-white/10 sm:border-r sm:pr-3">
      <p class="text-2xl sm:text-3xl font-bold">800<span class="lime">+</span></p>
      <p class="text-[10px] sm:text-xs text-gray-400 mt-0.5">Projects Delivered</p>
    </div>
    <div>
      <p class="text-2xl sm:text-3xl font-bold">150M<span class="lime">+</span></p>
      <p class="text-[10px] sm:text-xs text-gray-400 mt-0.5">Revenue Generated</p>
    </div>
  </div>
</section>

<!-- ============ ABOUT US ============ -->
<section id="about" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16" aria-labelledby="about-heading">
  <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 sm:gap-6">
    <h2 id="about-heading" class="text-2xl sm:text-3xl md:text-4xl font-bold leading-tight max-w-sm">Turning Ideas Into <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Masterpieces</span></h2>
    <p class="text-gray-400 text-sm max-w-sm leading-relaxed">We may be a compact team, but our creativity knows no bounds. By staying agile and working hand-in-hand with our clients, we transform ideas into cutting-edge designs that make a lasting impression.</p>
  </div>

  <div class="relative mt-6 grid grid-cols-1 sm:grid-cols-[1.5fr_1fr] gap-3 sm:gap-5">
    <i class='bx bx-sparkle absolute -left-2 -top-5 text-xl lime hidden sm:block' aria-hidden="true"></i>
    <div class="relative rounded-3xl overflow-hidden aspect-[16/11] sm:aspect-[16/12]">
      <img src="https://picsum.photos/seed/creatix-team-work/900/650" alt="Digital marketing agency team collaborating on creative project" class="w-full h-full object-cover grayscale" loading="lazy">
      <div class="absolute bottom-3 left-3 right-3 flex flex-wrap items-center gap-2">
        <span class="bg-lime text-[#101010] text-[10px] sm:text-xs font-bold px-3 py-1.5 rounded-md tracking-wide">A CREATIVE DESIGN AGENCY</span>
        <div class="flex gap-1 items-end h-5" aria-hidden="true">
          <span class="w-1 bg-lime h-3 rounded-sm"></span>
          <span class="w-1 bg-lime h-5 rounded-sm"></span>
          <span class="w-1 bg-lime h-4 rounded-sm"></span>
        </div>
      </div>
    </div>
    <div class="rounded-3xl overflow-hidden aspect-[16/11] sm:aspect-auto relative">
      <img src="https://picsum.photos/seed/creatix-designer-think/600/650" alt="Creative designer brainstorming ideas for branding project" class="w-full h-full object-cover grayscale" loading="lazy">
      <i class='bx bx-lightbulb absolute top-3 right-3 text-xl text-white/70' aria-hidden="true"></i>
    </div>
  </div>
</section>

<!-- ============ OUR SERVICES ============ -->
<section id="services" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16" aria-labelledby="services-heading">
  <div class="text-center max-w-3xl mx-auto mb-8">
    <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">WHAT WE DO</span>
    <h2 id="services-heading" class="text-2xl sm:text-3xl md:text-4xl font-bold mt-3">Our <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Services</span></h2>
    <p class="text-gray-400 text-sm mt-2 max-w-lg mx-auto">We offer a range of creative and digital services designed to help your brand stand out and grow.</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <a href="local-seo.php" class="service-card no-underline text-white block">
      <div class="service-icon mb-3" aria-hidden="true"><i class='bx bx-map-pin'></i></div>
      <h3 class="text-lg font-bold">Local SEO</h3>
      <p class="text-gray-400 text-sm mt-1 leading-relaxed">Dominate local search results and Google Maps. Attract more customers from your area.</p>
    </a>
    <a href="ecommerce-seo.php" class="service-card no-underline text-white block">
      <div class="service-icon mb-3" aria-hidden="true"><i class='bx bx-store'></i></div>
      <h3 class="text-lg font-bold">E-Commerce SEO</h3>
      <p class="text-gray-400 text-sm mt-1 leading-relaxed">Optimize your online store to drive more traffic, increase conversions, and boost revenue.</p>
    </a>
    <a href="onpage-seo.php" class="service-card no-underline text-white block">
      <div class="service-icon mb-3" aria-hidden="true"><i class='bx bx-code-alt'></i></div>
      <h3 class="text-lg font-bold">On-Page SEO</h3>
      <p class="text-gray-400 text-sm mt-1 leading-relaxed">Optimize meta tags, content, and structure to rank higher in search results.</p>
    </a>
    <a href="offpage-seo.php" class="service-card no-underline text-white block">
      <div class="service-icon mb-3" aria-hidden="true"><i class='bx bx-link-alt'></i></div>
      <h3 class="text-lg font-bold">Off-Page SEO</h3>
      <p class="text-gray-400 text-sm mt-1 leading-relaxed">Build authority with high-quality backlinks and white-hat link building strategies.</p>
    </a>
    <a href="technical-seo.php" class="service-card no-underline text-white block">
      <div class="service-icon mb-3" aria-hidden="true"><i class='bx bx-cog'></i></div>
      <h3 class="text-lg font-bold">Technical SEO</h3>
      <p class="text-gray-400 text-sm mt-1 leading-relaxed">Fix speed issues, crawl errors, and indexing problems for optimal performance.</p>
    </a>
    <a href="answer-engine-seo.php" class="service-card no-underline text-white block">
      <div class="service-icon mb-3" aria-hidden="true"><i class='bx bx-bot'></i></div>
      <h3 class="text-lg font-bold">Answer Engine Optimization</h3>
      <p class="text-gray-400 text-sm mt-1 leading-relaxed">Optimize for AI-powered search and featured snippets to capture voice search traffic.</p>
    </a>
    <a href="generative-seo.php" class="service-card no-underline text-white block">
      <div class="service-icon mb-3" aria-hidden="true"><i class='bx bx-brain'></i></div>
      <h3 class="text-lg font-bold">Generative SEO</h3>
      <p class="text-gray-400 text-sm mt-1 leading-relaxed">Leverage AI to scale your content strategy and automate SEO growth at scale.</p>
    </a>
    <a href="web-development.php" class="service-card no-underline text-white block">
      <div class="service-icon mb-3" aria-hidden="true"><i class='bx bx-palette'></i></div>
      <h3 class="text-lg font-bold">Web Development</h3>
      <p class="text-gray-400 text-sm mt-1 leading-relaxed">Build responsive, SEO-optimized websites that convert visitors into customers.</p>
    </a>
  </div>
</section>

<!-- ============ WHY CHOOSE US ============ -->
<section id="why-us" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16" aria-labelledby="why-heading">
  <div class="text-center max-w-3xl mx-auto mb-8">
    <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">WHY CHOOSE US</span>
    <h2 id="why-heading" class="text-2xl sm:text-3xl md:text-4xl font-bold mt-3">Why <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Choose Creatix</span></h2>
    <p class="text-gray-400 text-sm mt-2 max-w-lg mx-auto">We combine creativity, strategy, and technology to deliver exceptional results for your brand.</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <div class="why-card">
      <div class="why-icon mb-3" aria-hidden="true"><i class='bx bx-rocket'></i></div>
      <h3 class="text-lg font-bold mb-1">Innovative Solutions</h3>
      <p class="text-gray-400 text-sm leading-relaxed">We push creative boundaries to deliver unique solutions that set your brand apart from the competition.</p>
    </div>
    <div class="why-card">
      <div class="why-icon mb-3" aria-hidden="true"><i class='bx bx-group'></i></div>
      <h3 class="text-lg font-bold mb-1">Client-Centric Approach</h3>
      <p class="text-gray-400 text-sm leading-relaxed">Your vision is our priority. We collaborate closely with you to ensure every detail aligns with your goals.</p>
    </div>
    <div class="why-card">
      <div class="why-icon mb-3" aria-hidden="true"><i class='bx bx-bolt'></i></div>
      <h3 class="text-lg font-bold mb-1">Fast & Reliable</h3>
      <p class="text-gray-400 text-sm leading-relaxed">We deliver high-quality work on time, every time. Our agile process ensures efficiency without compromise.</p>
    </div>
    <div class="why-card">
      <div class="why-icon mb-3" aria-hidden="true"><i class='bx bx-data'></i></div>
      <h3 class="text-lg font-bold mb-1">Data-Driven Results</h3>
      <p class="text-gray-400 text-sm leading-relaxed">We use analytics and insights to inform our decisions, ensuring your campaigns deliver measurable ROI.</p>
    </div>
    <div class="why-card">
      <div class="why-icon mb-3" aria-hidden="true"><i class='bx bx-heart'></i></div>
      <h3 class="text-lg font-bold mb-1">Passionate Team</h3>
      <p class="text-gray-400 text-sm leading-relaxed">Our team lives and breathes creativity. We bring passion and dedication to every project we undertake.</p>
    </div>
    <div class="why-card">
      <div class="why-icon mb-3" aria-hidden="true"><i class='bx bx-support'></i></div>
      <h3 class="text-lg font-bold mb-1">Ongoing Support</h3>
      <p class="text-gray-400 text-sm leading-relaxed">We're with you every step of the way. From strategy to launch and beyond, we're here to support your growth.</p>
    </div>
  </div>
</section>

<!-- ============ OUR TEAM ============ -->
<section id="team" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16" aria-labelledby="team-heading">
  <div class="text-center max-w-3xl mx-auto mb-8">
    <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">OUR TEAM</span>
    <h2 id="team-heading" class="text-2xl sm:text-3xl md:text-4xl font-bold mt-3">Meet <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">the Team</span></h2>
    <p class="text-gray-400 text-sm mt-2 max-w-lg mx-auto">The creative minds behind Creatix, dedicated to bringing your vision to life.</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <div class="team-card bg-white text-[#101010] rounded-2xl p-4 relative">
      <span class="absolute top-3 right-3 w-6 h-6 rounded-full bg-[#101010] text-white flex items-center justify-center" aria-label="LinkedIn profile"><i class='bx bxl-linkedin text-sm' aria-hidden="true"></i></span>
      <div class="flex items-center gap-3 mb-3">
        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-12 h-12 rounded-full object-cover" alt="Jane Smith - CEO and Founder" loading="lazy">
        <div>
          <p class="font-bold text-sm">Jane Smith</p>
          <p class="text-xs text-gray-500">CEO and Founder</p>
        </div>
      </div>
      <p class="text-xs text-gray-500 leading-relaxed">10+ years of experience in brand strategy and creative direction, leading Creatix's vision and growth.</p>
    </div>

    <div class="team-card bg-white text-[#101010] rounded-2xl p-4 relative">
      <span class="absolute top-3 right-3 w-6 h-6 rounded-full bg-[#101010] text-white flex items-center justify-center" aria-label="LinkedIn profile"><i class='bx bxl-linkedin text-sm' aria-hidden="true"></i></span>
      <div class="flex items-center gap-3 mb-3">
        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-12 h-12 rounded-full object-cover" alt="John Doe - Director of Operations" loading="lazy">
        <div>
          <p class="font-bold text-sm">John Doe</p>
          <p class="text-xs text-gray-500">Director of Operations</p>
        </div>
      </div>
      <p class="text-xs text-gray-500 leading-relaxed">8+ years of experience in project management and operations, keeping every campaign running smoothly.</p>
    </div>

    <div class="team-card bg-white text-[#101010] rounded-2xl p-4 relative">
      <span class="absolute top-3 right-3 w-6 h-6 rounded-full bg-[#101010] text-white flex items-center justify-center" aria-label="LinkedIn profile"><i class='bx bxl-linkedin text-sm' aria-hidden="true"></i></span>
      <div class="flex items-center gap-3 mb-3">
        <img src="https://randomuser.me/api/portraits/men/54.jpg" class="w-12 h-12 rounded-full object-cover" alt="Michael Brown - SEO Specialist" loading="lazy">
        <div>
          <p class="font-bold text-sm">Michael Brown</p>
          <p class="text-xs text-gray-500">SEO Specialist</p>
        </div>
      </div>
      <p class="text-xs text-gray-500 leading-relaxed">6+ years of experience in SEO, driving organic growth with data-backed strategies that work.</p>
    </div>

    <div class="team-card bg-white text-[#101010] rounded-2xl p-4 relative">
      <span class="absolute top-3 right-3 w-6 h-6 rounded-full bg-[#101010] text-white flex items-center justify-center" aria-label="LinkedIn profile"><i class='bx bxl-linkedin text-sm' aria-hidden="true"></i></span>
      <div class="flex items-center gap-3 mb-3">
        <img src="https://randomuser.me/api/portraits/women/26.jpg" class="w-12 h-12 rounded-full object-cover" alt="Emily Johnson - PPC Manager" loading="lazy">
        <div>
          <p class="font-bold text-sm">Emily Johnson</p>
          <p class="text-xs text-gray-500">PPC Manager</p>
        </div>
      </div>
      <p class="text-xs text-gray-500 leading-relaxed">5+ years of experience in paid advertising, turning every click into measurable results.</p>
    </div>

    <div class="team-card bg-white text-[#101010] rounded-2xl p-4 relative">
      <span class="absolute top-3 right-3 w-6 h-6 rounded-full bg-[#101010] text-white flex items-center justify-center" aria-label="LinkedIn profile"><i class='bx bxl-linkedin text-sm' aria-hidden="true"></i></span>
      <div class="flex items-center gap-3 mb-3">
        <img src="https://randomuser.me/api/portraits/men/76.jpg" class="w-12 h-12 rounded-full object-cover" alt="Brian Williams - Social Media Specialist" loading="lazy">
        <div>
          <p class="font-bold text-sm">Brian Williams</p>
          <p class="text-xs text-gray-500">Social Media Specialist</p>
        </div>
      </div>
      <p class="text-xs text-gray-500 leading-relaxed">4+ years of experience in social media, crafting content that connects and engages audiences.</p>
    </div>

    <div class="team-card bg-white text-[#101010] rounded-2xl p-4 relative">
      <span class="absolute top-3 right-3 w-6 h-6 rounded-full bg-[#101010] text-white flex items-center justify-center" aria-label="LinkedIn profile"><i class='bx bxl-linkedin text-sm' aria-hidden="true"></i></span>
      <div class="flex items-center gap-3 mb-3">
        <img src="https://randomuser.me/api/portraits/women/12.jpg" class="w-12 h-12 rounded-full object-cover" alt="Sarah Kim - Content Creator" loading="lazy">
        <div>
          <p class="font-bold text-sm">Sarah Kim</p>
          <p class="text-xs text-gray-500">Content Creator</p>
        </div>
      </div>
      <p class="text-xs text-gray-500 leading-relaxed">3+ years of experience crafting stories, delivering content that resonates across every channel.</p>
    </div>
  </div>
</section>

<!-- ============ GET IN TOUCH ============ -->
<section id="contact" class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16" aria-labelledby="contact-heading">
  <div class="grid grid-cols-1 sm:grid-cols-[1.3fr_1fr] gap-6 items-center">
    <div>
      <span class="inline-block bg-[#1a1a1a] text-lime text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full border border-white/10">GET IN TOUCH</span>
      <h2 id="contact-heading" class="text-2xl sm:text-4xl font-bold mt-2 mb-3">Let's Create Something <span class="bg-lime text-[#101010] px-3 py-1 rounded-full">Amazing</span></h2>
      <p class="text-gray-400 text-sm max-w-md mb-5">Transform your ideas into exceptional digital experiences. Whether you're looking for a complete rebrand, a stunning website, or a fresh creative direction — we're ready to help.</p>
      <form class="flex flex-wrap gap-2 max-w-md" onsubmit="return false;" aria-label="Contact form">
        <label for="email-input" class="sr-only">Email address</label>
        <input type="email" id="email-input" required placeholder="Enter your email" class="focus-ring flex-1 min-w-[180px] bg-[#141414] border border-white/10 rounded-full px-4 py-3 text-sm outline-none placeholder:text-gray-500 text-white">
        <button type="submit" class="bg-lime text-[#101010] font-semibold rounded-full px-5 py-3 text-sm whitespace-nowrap hover:brightness-95 transition">Contact Us</button>
      </form>
    </div>
    <div class="rounded-3xl overflow-hidden aspect-[4/3] sm:aspect-square">
      <img src="https://i.pinimg.com/736x/58/f4/bf/58f4bf387456ed7d5bb68ec011880800.jpg" alt="Digital marketing agency team member smiling" class="w-full h-full object-cover" loading="lazy">
    </div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<?php include "includes/footer.php" ?>
<?php include "includes/js-links.php" ?>
</body>
</html>