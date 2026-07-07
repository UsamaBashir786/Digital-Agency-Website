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
<?php include "includes/footer.php" ?>

<?php include "includes/js-links.php" ?>
</body>
</html>