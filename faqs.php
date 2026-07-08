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
        <span class="inline-block bg-lime text-[#101010] text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full">FAQ</span>
        <h1 class="text-3xl sm:text-4xl md:text-[3.2rem] font-bold leading-[1.15] mt-3">
          Frequently Asked <span class="bg-lime px-3 py-1 rounded-xl inline-block">Questions</span>
        </h1>
        <p class="text-gray-600 text-sm sm:text-base mt-4 max-w-md mx-auto">Find answers to the most common questions about our services, pricing, and processes.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ FAQ CATEGORIES ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-6 sm:mt-8">
  <div class="flex flex-wrap justify-center gap-2">
    <button class="faq-category active" data-category="all">All Questions</button>
    <button class="faq-category" data-category="seo">SEO Services</button>
    <button class="faq-category" data-category="webdev">Web Development</button>
    <button class="faq-category" data-category="pricing">Pricing</button>
    <button class="faq-category" data-category="general">General</button>
  </div>
</section>

<!-- ============ FAQ LIST ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-6 sm:mt-8">
  <div class="max-w-3xl mx-auto space-y-3" id="faqContainer">
    
    <!-- FAQ 1 - SEO -->
    <div class="faq-item" data-category="seo" onclick="this.classList.toggle('open')">
      <div class="flex items-center justify-between">
        <span class="font-semibold text-sm">What is Local SEO and why is it important for my business?</span>
        <i class='bx bx-chevron-down faq-icon text-lime text-xl'></i>
      </div>
      <div class="faq-answer text-gray-400 text-sm leading-relaxed">Local SEO helps your business appear in local search results when customers search for products or services near them. It's crucial because 46% of all Google searches have local intent, and 76% of people who search for something nearby visit a business within a day.</div>
    </div>

    <!-- FAQ 2 - SEO -->
    <div class="faq-item" data-category="seo" onclick="this.classList.toggle('open')">
      <div class="flex items-center justify-between">
        <span class="font-semibold text-sm">How long does it take to see results from SEO?</span>
        <i class='bx bx-chevron-down faq-icon text-lime text-xl'></i>
      </div>
      <div class="faq-answer text-gray-400 text-sm leading-relaxed">SEO is a long-term strategy. Typically, you can start seeing improvements in 3-6 months, with significant results appearing in 6-12 months. However, results depend on factors like competition, industry, and the current state of your website.</div>
    </div>

    <!-- FAQ 3 - Pricing -->
    <div class="faq-item" data-category="pricing" onclick="this.classList.toggle('open')">
      <div class="flex items-center justify-between">
        <span class="font-semibold text-sm">How much do your services cost?</span>
        <i class='bx bx-chevron-down faq-icon text-lime text-xl'></i>
      </div>
      <div class="faq-answer text-gray-400 text-sm leading-relaxed">Our pricing varies based on the scope of work. We offer custom packages starting from $499 for small projects. Contact us for a free consultation and personalized quote tailored to your specific needs.</div>
    </div>

    <!-- FAQ 4 - Web Development -->
    <div class="faq-item" data-category="webdev" onclick="this.classList.toggle('open')">
      <div class="flex items-center justify-between">
        <span class="font-semibold text-sm">What platforms do you use for web development?</span>
        <i class='bx bx-chevron-down faq-icon text-lime text-xl'></i>
      </div>
      <div class="faq-answer text-gray-400 text-sm leading-relaxed">We specialize in WordPress, WooCommerce, Shopify, and custom development using React, Node.js, PHP, and Laravel. We choose the best platform based on your business requirements and goals.</div>
    </div>

    <!-- FAQ 5 - General -->
    <div class="faq-item" data-category="general" onclick="this.classList.toggle('open')">
      <div class="flex items-center justify-between">
        <span class="font-semibold text-sm">Do you offer free consultations?</span>
        <i class='bx bx-chevron-down faq-icon text-lime text-xl'></i>
      </div>
      <div class="faq-answer text-gray-400 text-sm leading-relaxed">Yes! We offer a free, no-obligation consultation to discuss your business goals, challenges, and how we can help. Simply fill out our contact form or give us a call to schedule your consultation.</div>
    </div>

    <!-- FAQ 6 - SEO -->
    <div class="faq-item" data-category="seo" onclick="this.classList.toggle('open')">
      <div class="flex items-center justify-between">
        <span class="font-semibold text-sm">What's the difference between on-page and off-page SEO?</span>
        <i class='bx bx-chevron-down faq-icon text-lime text-xl'></i>
      </div>
      <div class="faq-answer text-gray-400 text-sm leading-relaxed">On-page SEO involves optimizing elements on your website like content, meta tags, and structure. Off-page SEO focuses on building authority through backlinks, citations, and social signals. Both are essential for a successful SEO strategy.</div>
    </div>

    <!-- FAQ 7 - Pricing -->
    <div class="faq-item" data-category="pricing" onclick="this.classList.toggle('open')">
      <div class="flex items-center justify-between">
        <span class="font-semibold text-sm">Do you require a contract or commitment?</span>
        <i class='bx bx-chevron-down faq-icon text-lime text-xl'></i>
      </div>
      <div class="faq-answer text-gray-400 text-sm leading-relaxed">We offer flexible month-to-month options for most services. Some projects may require a minimum commitment to achieve desired results. All terms are clearly outlined in our proposal before we start.</div>
    </div>

    <!-- FAQ 8 - General -->
    <div class="faq-item" data-category="general" onclick="this.classList.toggle('open')">
      <div class="flex items-center justify-between">
        <span class="font-semibold text-sm">What industries do you specialize in?</span>
        <i class='bx bx-chevron-down faq-icon text-lime text-xl'></i>
      </div>
      <div class="faq-answer text-gray-400 text-sm leading-relaxed">We work with businesses across various industries including e-commerce, real estate, healthcare, education, technology, hospitality, and professional services. Our strategies are customized for each industry's unique requirements.</div>
    </div>

    <!-- FAQ 9 - Web Development -->
    <div class="faq-item" data-category="webdev" onclick="this.classList.toggle('open')">
      <div class="flex items-center justify-between">
        <span class="font-semibold text-sm">How long does it take to build a website?</span>
        <i class='bx bx-chevron-down faq-icon text-lime text-xl'></i>
      </div>
      <div class="faq-answer text-gray-400 text-sm leading-relaxed">Timeline depends on complexity. A simple website can take 2-4 weeks, while more complex projects with custom functionality may take 6-12 weeks. We'll provide a detailed timeline during the planning phase.</div>
    </div>

    <!-- FAQ 10 - SEO -->
    <div class="faq-item" data-category="seo" onclick="this.classList.toggle('open')">
      <div class="flex items-center justify-between">
        <span class="font-semibold text-sm">Do you guarantee first page rankings?</span>
        <i class='bx bx-chevron-down faq-icon text-lime text-xl'></i>
      </div>
      <div class="faq-answer text-gray-400 text-sm leading-relaxed">We cannot guarantee specific rankings as search algorithms constantly change. However, we guarantee our efforts and transparency. Our proven strategies have helped many clients achieve significant improvements in their search visibility.</div>
    </div>

    <!-- FAQ 11 - Pricing -->
    <div class="faq-item" data-category="pricing" onclick="this.classList.toggle('open')">
      <div class="flex items-center justify-between">
        <span class="font-semibold text-sm">What payment methods do you accept?</span>
        <i class='bx bx-chevron-down faq-icon text-lime text-xl'></i>
      </div>
      <div class="faq-answer text-gray-400 text-sm leading-relaxed">We accept bank transfers, credit/debit cards, and PayPal. All payment details are provided in our project proposals and invoices.</div>
    </div>

    <!-- FAQ 12 - General -->
    <div class="faq-item" data-category="general" onclick="this.classList.toggle('open')">
      <div class="flex items-center justify-between">
        <span class="font-semibold text-sm">Can you help with existing websites?</span>
        <i class='bx bx-chevron-down faq-icon text-lime text-xl'></i>
      </div>
      <div class="faq-answer text-gray-400 text-sm leading-relaxed">Absolutely! We offer website audits, redesigns, and optimization services for existing websites. We'll analyze your current site and recommend improvements to enhance performance, user experience, and search visibility.</div>
    </div>

  </div>
</section>

<!-- ============ STILL HAVE QUESTIONS ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="bg-lime text-[#101010] rounded-[2rem] p-6 sm:p-10 text-center">
    <i class='bx bx-message-dots text-4xl mb-3 inline-block'></i>
    <h2 class="text-2xl sm:text-3xl font-bold">Still Have Questions?</h2>
    <p class="text-sm sm:text-base max-w-md mx-auto mt-2 text-[#1a1a1a]/80">Can't find the answer you're looking for? We're here to help.</p>
    <div class="flex flex-wrap justify-center gap-3 mt-4">
      <a href="contact.php" class="bg-[#101010] text-white font-bold rounded-full px-6 py-3 text-sm hover:bg-black transition inline-flex items-center gap-2">
        <i class='bx bx-envelope'></i> Contact Us
      </a>
      <a href="tel:+923001234567" class="border border-[#101010] text-[#101010] font-semibold rounded-full px-6 py-3 text-sm hover:bg-[#101010] hover:text-white transition inline-flex items-center gap-2">
        <i class='bx bx-phone'></i> Call Us
      </a>
    </div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<?php include "includes/footer.php" ?>
<?php include "includes/js-links.php" ?>
</body>
</html>