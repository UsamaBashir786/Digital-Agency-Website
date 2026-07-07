<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
  <title>Contact Us — 4 Digi Sol</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    :root { --lime: #A6F13B; --lime-dark: #8BD82E; }
    * { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
    body { background: #0c0c0c; color: #ffffff; overflow-x: hidden; }
    .lime { color: var(--lime); }
    .bg-lime { background: var(--lime); }
    .pill-nav { background: #101010; border-radius: 9999px; padding: 0.6rem 1.2rem; }
    .footer-icon { background: #101010; color: #ffffff !important; display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; border-radius: 9999px; transition: opacity 0.2s; text-decoration: none; }
    .footer-icon:hover { opacity: 0.8; }
    .footer-icon i { color: #ffffff !important; font-size: 1.1rem; }
    .footer-subscribe-btn { background: #101010; color: #ffffff !important; border-radius: 9999px; padding: 0.5rem 1.2rem; font-size: 0.875rem; font-weight: 600; transition: opacity 0.2s; border: none; cursor: pointer; }
    .footer-subscribe-btn:hover { opacity: 0.85; }
    .contact-card { background: #141414; border: 1px solid rgba(255,255,255,0.06); border-radius: 1.5rem; padding: 1.75rem; transition: transform 0.3s ease, border-color 0.3s ease; }
    .contact-card:hover { transform: translateY(-4px); border-color: rgba(166, 241, 59, 0.3); }
    .contact-icon { background: rgba(166, 241, 59, 0.08); width: 56px; height: 56px; border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; color: #A6F13B; }
    
    /* Nav link underline animation */
    .nav-link {
      position: relative;
      text-decoration: none;
      color: #e5e5e5;
      transition: color 0.3s ease;
      padding-bottom: 2px;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background-color: #A6F13B;
      transition: width 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .nav-link:hover { color: #ffffff; }
    .nav-link:hover::after { width: 100%; }
    .nav-link.active { color: #ffffff; }
    .nav-link.active::after { width: 100%; }
    
    .mobile-link {
      position: relative;
      text-decoration: none;
      color: #d0d0d0;
      transition: color 0.3s ease;
      padding-bottom: 2px;
      display: inline-block;
      width: fit-content;
    }
    .mobile-link::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background-color: #A6F13B;
      transition: width 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .mobile-link:hover { color: #ffffff; }
    .mobile-link:hover::after { width: 100%; }
    
    .dropdown-menu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background: #1a1a1a;
      border-radius: 1rem;
      padding: 0.75rem 0;
      min-width: 220px;
      border: 1px solid rgba(255,255,255,0.06);
      box-shadow: 0 20px 40px rgba(0,0,0,0.5);
      z-index: 100;
    }
    .dropdown-trigger:hover .dropdown-menu { display: block; }
    .dropdown-menu a {
      display: block;
      padding: 0.45rem 1.25rem;
      color: #d0d0d0;
      font-size: 0.8rem;
      transition: all 0.2s;
      text-decoration: none;
    }
    .dropdown-menu a:hover { color: #A6F13B; background: rgba(166, 241, 59, 0.05); }
    .dropdown-menu .divider { height: 1px; background: rgba(255,255,255,0.06); margin: 0.25rem 0.75rem; }
    
    @media (max-width: 768px) {
      .dropdown-menu { position: relative; top: 0; background: transparent; border: none; box-shadow: none; padding: 0.3rem 0 0 1rem; }
      .dropdown-trigger:hover .dropdown-menu { display: none; }
      .dropdown-trigger.active .dropdown-menu { display: block; }
      .dropdown-menu a { padding: 0.3rem 0.75rem; font-size: 0.8rem; color: #b0b0b0; }
    }
    
    .auth-input {
      background: #141414;
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 9999px;
      padding: 0.9rem 1.2rem;
      width: 100%;
      color: #ffffff;
      font-size: 0.95rem;
      transition: border 0.2s, box-shadow 0.2s;
    }
    .auth-input:focus { border-color: #A6F13B; outline: none; box-shadow: 0 0 0 3px rgba(166, 241, 59, 0.15); }
    .auth-input::placeholder { color: #888888; }
    .auth-textarea {
      background: #141414;
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 1.5rem;
      padding: 0.9rem 1.2rem;
      width: 100%;
      color: #ffffff;
      font-size: 0.95rem;
      transition: border 0.2s, box-shadow 0.2s;
      resize: vertical;
      min-height: 120px;
      font-family: 'Poppins', sans-serif;
    }
    .auth-textarea:focus { border-color: #A6F13B; outline: none; box-shadow: 0 0 0 3px rgba(166, 241, 59, 0.15); }
    .auth-textarea::placeholder { color: #888888; }
    
    .btn-primary {
      background: #A6F13B;
      color: #0c0c0c;
      font-weight: 700;
      border-radius: 9999px;
      padding: 0.9rem 1.2rem;
      width: 100%;
      border: none;
      font-size: 1rem;
      transition: background 0.2s, transform 0.1s;
      cursor: pointer;
    }
    .btn-primary:hover { background: #8BD82E; }
    .btn-primary:active { transform: scale(0.98); }
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
      <div class="text-center max-w-3xl mx-auto">
        <span class="inline-block bg-lime text-[#101010] text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full">CONTACT US</span>
        <h1 class="text-3xl sm:text-4xl md:text-[3.2rem] font-bold leading-[1.15] mt-3">
          Let's <span class="bg-lime px-3 py-1 rounded-xl inline-block">Connect</span>
        </h1>
        <p class="text-gray-600 text-sm sm:text-base mt-4 max-w-md mx-auto">Have a project in mind? We'd love to hear from you. Let's create something amazing together.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ CONTACT SECTION ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="grid grid-cols-1 lg:grid-cols-[1.3fr_0.7fr] gap-8">
    
    <!-- Contact Form -->
    <div class="bg-[#141414] border border-white/5 rounded-2xl p-6 sm:p-8">
      <h2 class="text-2xl font-bold mb-2">Send Us a Message</h2>
      <p class="text-gray-400 text-sm mb-6">Fill out the form below and we'll get back to you within 24 hours.</p>
      
      <form onsubmit="event.preventDefault(); alert('✅ Thank you! Your message has been sent. We\'ll get back to you soon.');">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
          <div>
            <label for="fullname" class="block text-xs font-medium text-gray-300 mb-1.5">Full Name</label>
            <input type="text" id="fullname" class="auth-input" placeholder="John Doe" required />
          </div>
          <div>
            <label for="email" class="block text-xs font-medium text-gray-300 mb-1.5">Email Address</label>
            <input type="email" id="email" class="auth-input" placeholder="hello@4digisol.com" required />
          </div>
        </div>
        <div class="mb-4">
          <label for="subject" class="block text-xs font-medium text-gray-300 mb-1.5">Subject</label>
          <input type="text" id="subject" class="auth-input" placeholder="Project Inquiry" required />
        </div>
        <div class="mb-5">
          <label for="message" class="block text-xs font-medium text-gray-300 mb-1.5">Message</label>
          <textarea id="message" class="auth-textarea" placeholder="Tell us about your project..." required></textarea>
        </div>
        <button type="submit" class="btn-primary flex items-center justify-center gap-2">
          <span>Send Message</span>
          <i class='bx bx-send text-lg'></i>
        </button>
      </form>
    </div>

    <!-- Contact Info -->
    <div class="space-y-4">
      <div class="contact-card">
        <div class="contact-icon mb-3"><i class='bx bx-map-pin'></i></div>
        <h3 class="text-lg font-bold">Visit Us</h3>
        <p class="text-gray-400 text-sm mt-1 leading-relaxed">123 Digital Avenue,<br>Tech Park, Lahore,<br>Pakistan</p>
      </div>
      
      <div class="contact-card">
        <div class="contact-icon mb-3"><i class='bx bx-envelope'></i></div>
        <h3 class="text-lg font-bold">Email Us</h3>
        <a href="mailto:hello@4digisol.com" class="text-gray-400 text-sm hover:text-lime transition">hello@4digisol.com</a><br>
        <a href="mailto:support@4digisol.com" class="text-gray-400 text-sm hover:text-lime transition">support@4digisol.com</a>
      </div>
      
      <div class="contact-card">
        <div class="contact-icon mb-3"><i class='bx bx-phone'></i></div>
        <h3 class="text-lg font-bold">Call Us</h3>
        <a href="tel:+923001234567" class="text-gray-400 text-sm hover:text-lime transition">+92 300 1234567</a><br>
        <a href="tel:+92421234567" class="text-gray-400 text-sm hover:text-lime transition">+92 42 1234567</a>
      </div>

      <div class="contact-card">
        <div class="contact-icon mb-3"><i class='bx bx-time'></i></div>
        <h3 class="text-lg font-bold">Working Hours</h3>
        <p class="text-gray-400 text-sm mt-1">Mon - Fri: 9:00 AM - 6:00 PM<br>Sat - Sun: Closed</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ MAP / LOCATION ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="bg-[#141414] border border-white/5 rounded-2xl overflow-hidden">
    <div class="aspect-[16/6] bg-[#1a1a1a] flex items-center justify-center">
      <div class="text-center text-gray-500">
        <i class='bx bx-map text-4xl lime mb-2 block'></i>
        <p class="text-sm">Interactive Map Location</p>
        <p class="text-xs text-gray-600">123 Digital Avenue, Tech Park, Lahore, Pakistan</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16 pb-6" role="contentinfo">
  <div class="bg-lime text-[#101010] rounded-[2rem] p-5 sm:p-9">
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6">
      <div>
        <div class="flex items-center gap-2 font-bold text-xl mb-2">
          <i class='bx bx-sparkle text-xl' aria-hidden="true"></i>
          <span>4 Digi Sol</span>
        </div>
        <p class="text-sm max-w-xs text-[#1a1a1a]/80">Empowering brands through creative solutions — web, branding & digital design for over a decade.</p>
        <div class="flex gap-2 mt-4">
          <a href="#" class="footer-icon" aria-label="Facebook"><i class='bx bxl-facebook' aria-hidden="true"></i></a>
          <a href="#" class="footer-icon" aria-label="Instagram"><i class='bx bxl-instagram' aria-hidden="true"></i></a>
          <a href="#" class="footer-icon" aria-label="Twitter"><i class='bx bxl-twitter' aria-hidden="true"></i></a>
          <a href="#" class="footer-icon" aria-label="LinkedIn"><i class='bx bxl-linkedin' aria-hidden="true"></i></a>
        </div>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 text-sm">
        <div>
          <p class="font-bold mb-2">Company</p>
          <ul class="space-y-1.5 text-[#1a1a1a]/80">
            <li><a href="about.php" class="hover:underline">About Us</a></li>
            <li><a href="#team" class="hover:underline">Our Team</a></li>
            <li><a href="contact.php" class="hover:underline">Contact</a></li>
          </ul>
        </div>
        <div>
          <p class="font-bold mb-2">Legal</p>
          <ul class="space-y-1.5 text-[#1a1a1a]/80">
            <li><a href="#" class="hover:underline">Privacy Policy</a></li>
            <li><a href="#" class="hover:underline">Terms & Conditions</a></li>
          </ul>
        </div>
        <div>
          <p class="font-bold mb-2">Services</p>
          <ul class="space-y-1.5 text-[#1a1a1a]/80">
            <li><a href="local-seo.php" class="hover:underline">Local SEO</a></li>
            <li><a href="onpage-seo.php" class="hover:underline">On-Page SEO</a></li>
            <li><a href="web-development.php" class="hover:underline">Web Development</a></li>
          </ul>
        </div>
      </div>

      <div class="max-w-xs">
        <p class="font-bold mb-2">Subscribe to our newsletter</p>
        <form class="flex flex-wrap gap-2" onsubmit="return false;" aria-label="Newsletter subscription">
          <label for="footer-email" class="sr-only">Email address</label>
          <input type="email" id="footer-email" required placeholder="Your email" class="flex-1 min-w-[150px] bg-white/40 placeholder:text-[#1a1a1a]/60 rounded-full px-4 py-2 text-sm outline-none">
          <button type="submit" class="footer-subscribe-btn">Subscribe</button>
        </form>
      </div>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-6 pt-5 border-t border-[#1a1a1a]/15 text-xs text-[#1a1a1a]/70">
      <p>&copy; 2026 4 Digi Sol. All rights reserved.</p>
      <div class="flex gap-3">
        <a href="#" class="hover:underline">Privacy Policy</a>
        <span>|</span>
        <a href="#" class="hover:underline">Terms & Conditions</a>
      </div>
    </div>
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
  document.querySelectorAll('.mobile-link').forEach(link => link.addEventListener('click', closeMenu));
  document.addEventListener('click', (e) => { if (!mobileMenu.classList.contains('hidden') && !mobileMenu.contains(e.target) && e.target !== menuBtn) closeMenu(); });
  window.addEventListener('resize', () => { if (window.innerWidth >= 768) closeMenu(); });

  // Mobile Services Dropdown
  const mobileServicesBtn = document.getElementById('mobileServicesBtn');
  const mobileServicesMenu = document.getElementById('mobileServicesMenu');
  const mobileServicesIcon = document.getElementById('mobileServicesIcon');

  mobileServicesBtn.addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    mobileServicesMenu.classList.toggle('hidden');
    mobileServicesIcon.classList.toggle('bx-chevron-down');
    mobileServicesIcon.classList.toggle('bx-chevron-up');
  });
</script>

</body>
</html>