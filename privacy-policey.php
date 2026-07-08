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
        <span class="inline-block bg-lime text-[#101010] text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full">LEGAL</span>
        <h1 class="text-3xl sm:text-4xl md:text-[3.2rem] font-bold leading-[1.15] mt-3">
          Privacy <span class="bg-lime px-3 py-1 rounded-xl inline-block">Policy</span>
        </h1>
        <p class="text-gray-600 text-sm sm:text-base mt-4 max-w-md mx-auto">Your privacy matters to us. Learn how we collect, use, and protect your information.</p>
        <p class="text-gray-500 text-xs mt-2">Last Updated: January 1, 2026</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ PRIVACY POLICY CONTENT ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="grid grid-cols-1 gap-5">
    
    <div class="privacy-section">
      <h3 class="text-lg font-bold mb-2">1. Information We Collect</h3>
      <p class="text-gray-400 text-sm leading-relaxed">We collect information that you provide directly to us, including:</p>
      <ul class="text-gray-400 text-sm leading-relaxed list-disc list-inside space-y-1 mt-2">
        <li>Name and contact information (email, phone number, address)</li>
        <li>Company and business details</li>
        <li>Website and project information</li>
        <li>Communications and feedback</li>
        <li>Payment and billing information</li>
      </ul>
    </div>

    <div class="privacy-section">
      <h3 class="text-lg font-bold mb-2">2. How We Use Your Information</h3>
      <p class="text-gray-400 text-sm leading-relaxed">We use your information to:</p>
      <ul class="text-gray-400 text-sm leading-relaxed list-disc list-inside space-y-1 mt-2">
        <li>Provide and deliver our services</li>
        <li>Communicate with you about projects and updates</li>
        <li>Process payments and transactions</li>
        <li>Improve our services and user experience</li>
        <li>Send marketing communications (with your consent)</li>
        <li>Comply with legal obligations</li>
      </ul>
    </div>

    <div class="privacy-section">
      <h3 class="text-lg font-bold mb-2">3. Information Sharing</h3>
      <p class="text-gray-400 text-sm leading-relaxed">We do not sell, trade, or rent your personal information to third parties. We may share your information with:</p>
      <ul class="text-gray-400 text-sm leading-relaxed list-disc list-inside space-y-1 mt-2">
        <li>Service providers who assist in delivering our services</li>
        <li>Payment processors for transaction processing</li>
        <li>Legal authorities when required by law</li>
        <li>With your explicit consent</li>
      </ul>
    </div>

    <div class="privacy-section">
      <h3 class="text-lg font-bold mb-2">4. Data Security</h3>
      <p class="text-gray-400 text-sm leading-relaxed">We implement appropriate security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction. These include:</p>
      <ul class="text-gray-400 text-sm leading-relaxed list-disc list-inside space-y-1 mt-2">
        <li>Secure servers and data encryption</li>
        <li>Regular security audits and updates</li>
        <li>Access controls and authentication</li>
        <li>Employee training on data protection</li>
      </ul>
    </div>

    <div class="privacy-section">
      <h3 class="text-lg font-bold mb-2">5. Cookies and Tracking</h3>
      <p class="text-gray-400 text-sm leading-relaxed">We use cookies and similar tracking technologies to enhance your experience on our website. This includes:</p>
      <ul class="text-gray-400 text-sm leading-relaxed list-disc list-inside space-y-1 mt-2">
        <li>Essential cookies for website functionality</li>
        <li>Analytics cookies to improve our services</li>
        <li>Marketing cookies for relevant advertising</li>
        <li>You can control cookie preferences in your browser settings</li>
      </ul>
    </div>

    <div class="privacy-section">
      <h3 class="text-lg font-bold mb-2">6. Your Rights</h3>
      <p class="text-gray-400 text-sm leading-relaxed">You have the right to:</p>
      <ul class="text-gray-400 text-sm leading-relaxed list-disc list-inside space-y-1 mt-2">
        <li>Access your personal information</li>
        <li>Correct inaccurate or incomplete data</li>
        <li>Request deletion of your data</li>
        <li>Object to data processing</li>
        <li>Withdraw consent at any time</li>
        <li>Data portability</li>
      </ul>
      <p class="text-gray-400 text-sm leading-relaxed mt-2">To exercise these rights, please contact us at <a href="mailto:privacy@4digisol.com" class="text-lime hover:underline">privacy@4digisol.com</a>.</p>
    </div>

    <div class="privacy-section">
      <h3 class="text-lg font-bold mb-2">7. Data Retention</h3>
      <p class="text-gray-400 text-sm leading-relaxed">We retain your personal information only for as long as necessary to fulfill the purposes outlined in this policy, unless a longer retention period is required or permitted by law.</p>
    </div>

    <div class="privacy-section">
      <h3 class="text-lg font-bold mb-2">8. Third-Party Links</h3>
      <p class="text-gray-400 text-sm leading-relaxed">Our website may contain links to third-party websites. We are not responsible for the privacy practices or content of these external sites. We encourage you to review their privacy policies.</p>
    </div>

    <div class="privacy-section">
      <h3 class="text-lg font-bold mb-2">9. Children's Privacy</h3>
      <p class="text-gray-400 text-sm leading-relaxed">Our services are not directed to individuals under the age of 13. We do not knowingly collect personal information from children. If you believe we have collected such information, please contact us immediately.</p>
    </div>

    <div class="privacy-section">
      <h3 class="text-lg font-bold mb-2">10. Changes to This Policy</h3>
      <p class="text-gray-400 text-sm leading-relaxed">We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page with an updated date. We encourage you to review this policy periodically.</p>
    </div>

    <div class="privacy-section">
      <h3 class="text-lg font-bold mb-2">11. Contact Us</h3>
      <p class="text-gray-400 text-sm leading-relaxed">If you have any questions, concerns, or requests regarding this Privacy Policy, please contact us:</p>
      <ul class="text-gray-400 text-sm leading-relaxed list-none space-y-1 mt-2">
        <li><i class='bx bx-envelope lime inline-block w-5'></i> <a href="mailto:privacy@4digisol.com" class="hover:text-lime transition">privacy@4digisol.com</a></li>
        <li><i class='bx bx-phone lime inline-block w-5'></i> <a href="tel:+923001234567" class="hover:text-lime transition">+92 300 1234567</a></li>
        <li><i class='bx bx-map-pin lime inline-block w-5'></i> 123 Digital Avenue, Tech Park, Lahore, Pakistan</li>
      </ul>
    </div>

    <!-- Call to Action -->
    <div class="bg-lime text-[#101010] rounded-2xl p-6 text-center mt-4">
      <h3 class="text-xl font-bold mb-2">Have Privacy Concerns?</h3>
      <p class="text-sm text-[#1a1a1a]/80 max-w-md mx-auto">We take your privacy seriously. If you have any questions or concerns, please reach out to us.</p>
      <a href="contact.php" class="inline-block mt-3 bg-[#101010] text-white font-semibold rounded-full px-6 py-2.5 text-sm hover:bg-black transition">Contact Our Privacy Team</a>
    </div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<?php include "includes/footer.php" ?>
<?php include "includes/js-links.php" ?>
</body>
</html>