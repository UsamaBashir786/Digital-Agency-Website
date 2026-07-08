<?php
// ============================================================
// INCLUDES/FOOTER.PHP - Footer with Newsletter Backend
// ============================================================

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get dynamic data from settings
try {
    require_once __DIR__ . '/../config/connection.php';
    
    function getSettingValue($key, $default = '') {
        global $conn;
        try {
            $sql = "SELECT setting_value FROM settings WHERE setting_key = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $key);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return $row['setting_value'];
                }
                $stmt->close();
            }
        } catch (Exception $e) {
            return $default;
        }
        return $default;
    }
    
    // Load all settings
    $site_name = getSettingValue('site_name', '4 Digi Sol');
    $site_tagline = getSettingValue('site_tagline', 'Empowering brands through creative solutions — web, branding & digital design for over a decade.');
    $footer_text = getSettingValue('footer_copyright', '© 2026 4 Digi Sol. All rights reserved.');
    $social_facebook = getSettingValue('social_facebook', '');
    $social_instagram = getSettingValue('social_instagram', '');
    $social_twitter = getSettingValue('social_twitter', '');
    $social_linkedin = getSettingValue('social_linkedin', '');
    $social_youtube = getSettingValue('social_youtube', '');
    $site_email = getSettingValue('site_email', 'hello@4digisol.com');
    $site_phone = getSettingValue('site_phone', '');
    $site_address = getSettingValue('site_address', '');
    
    // ============================================================
    // NEWSLETTER SUBSCRIPTION HANDLER
    // ============================================================
    $newsletter_success = '';
    $newsletter_error = '';
    $newsletter_form_data = [];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscribe_newsletter'])) {
        $email = trim($_POST['newsletter_email'] ?? '');
        $name = trim($_POST['newsletter_name'] ?? '');
        
        // Store for repopulation
        $newsletter_form_data = [
            'email' => $email,
            'name' => $name
        ];
        
        // Validation
        if (empty($email)) {
            $newsletter_error = 'Please enter your email address.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $newsletter_error = 'Please enter a valid email address.';
        } else {
            try {
                // Check if email already exists
                $check_sql = "SELECT id, status FROM subscribers WHERE email = ?";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->bind_param("s", $email);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result();
                
                if ($check_result->num_rows > 0) {
                    $existing = $check_result->fetch_assoc();
                    if ($existing['status'] === 'unsubscribed') {
                        // Reactivate the subscriber
                        $update_sql = "UPDATE subscribers SET status = 'active', unsubscribed_at = NULL WHERE email = ?";
                        $update_stmt = $conn->prepare($update_sql);
                        $update_stmt->bind_param("s", $email);
                        if ($update_stmt->execute()) {
                            $newsletter_success = 'Welcome back! You have been re-subscribed.';
                        } else {
                            $newsletter_error = 'Something went wrong. Please try again.';
                        }
                        $update_stmt->close();
                    } else {
                        $newsletter_error = 'You are already subscribed to our newsletter!';
                    }
                } else {
                    // Get IP and User Agent
                    $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
                    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
                    
                    // Insert new subscriber
                    $insert_sql = "INSERT INTO subscribers (email, name, ip_address, user_agent, status, subscribed_at) VALUES (?, ?, ?, ?, 'active', NOW())";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bind_param("ssss", $email, $name, $ip_address, $user_agent);
                    
                    if ($insert_stmt->execute()) {
                        $newsletter_success = '✅ Thank you for subscribing! You\'ll receive our latest updates.';
                        
                        // ============================================================
                        // OPTIONAL: SEND CONFIRMATION EMAIL
                        // ============================================================
                        /*
                        $to = $email;
                        $subject = "Welcome to " . $site_name . " Newsletter";
                        $headers = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                        $headers .= "From: " . $site_email . "\r\n";
                        
                        $message = "
                        <html>
                        <head><title>Welcome to " . $site_name . "</title></head>
                        <body>
                            <h2>Welcome to " . $site_name . "!</h2>
                            <p>Thank you for subscribing to our newsletter.</p>
                            <p>You'll receive updates about our latest services, offers, and digital marketing insights.</p>
                            <br>
                            <p>Best regards,<br>" . $site_name . " Team</p>
                        </body>
                        </html>
                        ";
                        
                        mail($to, $subject, $message, $headers);
                        */
                        
                        // Clear form data after success
                        $newsletter_form_data = [];
                    } else {
                        $newsletter_error = 'Something went wrong. Please try again.';
                    }
                    $insert_stmt->close();
                }
                $check_stmt->close();
                
            } catch (Exception $e) {
                $newsletter_error = 'Database error. Please try again.';
            }
        }
        
        // Store messages in session for redirect (if needed)
        $_SESSION['newsletter_message'] = $newsletter_success ?: $newsletter_error;
        $_SESSION['newsletter_type'] = $newsletter_success ? 'success' : 'error';
    }
    
    // Check for session messages (if redirected)
    if (isset($_SESSION['newsletter_message']) && empty($newsletter_success) && empty($newsletter_error)) {
        if ($_SESSION['newsletter_type'] === 'success') {
            $newsletter_success = $_SESSION['newsletter_message'];
        } else {
            $newsletter_error = $_SESSION['newsletter_message'];
        }
        unset($_SESSION['newsletter_message']);
        unset($_SESSION['newsletter_type']);
    }
    
} catch (Exception $e) {
    // Fallback to defaults if database connection fails
    $site_name = '4 Digi Sol';
    $site_tagline = 'Empowering brands through creative solutions — web, branding & digital design for over a decade.';
    $footer_text = '© 2026 4 Digi Sol. All rights reserved.';
    $social_facebook = '';
    $social_instagram = '';
    $social_twitter = '';
    $social_linkedin = '';
    $social_youtube = '';
    $site_email = 'hello@4digisol.com';
    $site_phone = '';
    $site_address = '';
    $newsletter_success = '';
    $newsletter_error = '';
    $newsletter_form_data = [];
}
?>
<footer class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16 pb-6" role="contentinfo">
  <div class="bg-lime text-[#101010] rounded-[2rem] p-5 sm:p-9">
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6">
      <div>
        <div class="flex items-center gap-2 font-bold text-xl mb-2">
          <i class='bx bx-sparkle text-xl' aria-hidden="true"></i>
          <span><?php echo htmlspecialchars($site_name); ?></span>
        </div>
        <p class="text-sm max-w-xs text-[#1a1a1a]/80"><?php echo htmlspecialchars($site_tagline); ?></p>
        <div class="flex gap-2 mt-4">
          <?php if (!empty($social_facebook)): ?>
          <a href="<?php echo htmlspecialchars($social_facebook); ?>" target="_blank" rel="noopener noreferrer" class="footer-icon" aria-label="Facebook"><i class='bx bxl-facebook' aria-hidden="true"></i></a>
          <?php endif; ?>
          
          <?php if (!empty($social_instagram)): ?>
          <a href="<?php echo htmlspecialchars($social_instagram); ?>" target="_blank" rel="noopener noreferrer" class="footer-icon" aria-label="Instagram"><i class='bx bxl-instagram' aria-hidden="true"></i></a>
          <?php endif; ?>
          
          <?php if (!empty($social_twitter)): ?>
          <a href="<?php echo htmlspecialchars($social_twitter); ?>" target="_blank" rel="noopener noreferrer" class="footer-icon" aria-label="Twitter"><i class='bx bxl-twitter' aria-hidden="true"></i></a>
          <?php endif; ?>
          
          <?php if (!empty($social_linkedin)): ?>
          <a href="<?php echo htmlspecialchars($social_linkedin); ?>" target="_blank" rel="noopener noreferrer" class="footer-icon" aria-label="LinkedIn"><i class='bx bxl-linkedin' aria-hidden="true"></i></a>
          <?php endif; ?>
          
          <?php if (!empty($social_youtube)): ?>
          <a href="<?php echo htmlspecialchars($social_youtube); ?>" target="_blank" rel="noopener noreferrer" class="footer-icon" aria-label="YouTube"><i class='bx bxl-youtube' aria-hidden="true"></i></a>
          <?php endif; ?>
        </div>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 text-sm">
        <div>
          <p class="font-bold mb-2">Company</p>
          <ul class="space-y-1.5 text-[#1a1a1a]/80">
            <li><a href="about.php" class="hover:underline">About Us</a></li>
            <li><a href="#team" class="hover:underline">Our Team</a></li>
            <li><a href="privacy-policey.php" class="hover:underline">Privacy Policy</a></li>
            <li><a href="terms-and-conditins.php" class="hover:underline">Terms and Conditions</a></li>
          </ul>
        </div>
        <div>
          <p class="font-bold mb-2">Support</p>
          <ul class="space-y-1.5 text-[#1a1a1a]/80">
            <li><a href="contact.php" class="hover:underline">Contact Us</a></li>
            <li><a href="faqs.php" class="hover:underline">FAQs</a></li>
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

      <!-- ============================================================
      NEWSLETTER SUBSCRIPTION FORM
      ============================================================ -->
      <div class="max-w-xs">
        <p class="font-bold mb-2">Subscribe to our newsletter</p>
        
        <!-- Success Message -->
        <?php if ($newsletter_success): ?>
        <div class="bg-green-500/20 text-green-800 rounded-full px-4 py-2 text-xs mb-3 flex items-center gap-2">
          <i class='bx bx-check-circle text-lg'></i>
          <?php echo htmlspecialchars($newsletter_success); ?>
        </div>
        <?php endif; ?>
        
        <!-- Error Message -->
        <?php if ($newsletter_error): ?>
        <div class="bg-red-500/20 text-red-700 rounded-full px-4 py-2 text-xs mb-3 flex items-center gap-2">
          <i class='bx bx-error-circle text-lg'></i>
          <?php echo htmlspecialchars($newsletter_error); ?>
        </div>
        <?php endif; ?>
        
        <form class="flex flex-wrap gap-2" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" aria-label="Newsletter subscription" autocomplete="off">
          <label for="newsletter_name" class="sr-only">Your name (optional)</label>
          <input type="text" id="newsletter_name" name="newsletter_name" placeholder="Your name (optional)" value="<?php echo htmlspecialchars($newsletter_form_data['name'] ?? ''); ?>" class="w-full bg-white/40 placeholder:text-[#1a1a1a]/60 rounded-full px-4 py-2 text-sm outline-none focus:bg-white/60 transition mb-2">
          
          <label for="newsletter_email" class="sr-only">Email address</label>
          <input type="email" id="newsletter_email" name="newsletter_email" required placeholder="Your email" value="<?php echo htmlspecialchars($newsletter_form_data['email'] ?? ''); ?>" class="flex-1 min-w-[150px] bg-white/40 placeholder:text-[#1a1a1a]/60 rounded-full px-4 py-2 text-sm outline-none focus:bg-white/60 transition">
          
          <button type="submit" name="subscribe_newsletter" class="footer-subscribe-btn">
            Subscribe
          </button>
        </form>
        
        <?php if (!empty($site_email)): ?>
        <p class="text-xs text-[#1a1a1a]/60 mt-3 flex items-center gap-1">
          <i class='bx bx-envelope'></i>
          <?php echo htmlspecialchars($site_email); ?>
        </p>
        <?php endif; ?>
        
        <?php if (!empty($site_phone)): ?>
        <p class="text-xs text-[#1a1a1a]/60 flex items-center gap-1">
          <i class='bx bx-phone'></i>
          <?php echo htmlspecialchars($site_phone); ?>
        </p>
        <?php endif; ?>
        
        <p class="text-[10px] text-[#1a1a1a]/40 mt-2">
          We respect your privacy. Unsubscribe at any time.
        </p>
      </div>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-6 pt-5 border-t border-[#1a1a1a]/15 text-xs text-[#1a1a1a]/70">
      <p><?php echo htmlspecialchars($footer_text); ?></p>
      <div class="flex gap-1.5" aria-hidden="true">
        <span class="w-1.5 h-1.5 rounded-full bg-[#101010]"></span>
        <span class="w-1.5 h-1.5 rounded-full bg-[#101010]/40"></span>
        <span class="w-1.5 h-1.5 rounded-full bg-[#101010]/40"></span>
      </div>
    </div>
  </div>
</footer>

<style>
.footer-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  background: rgba(16, 16, 16, 0.08);
  border-radius: 50%;
  color: #101010;
  font-size: 1.1rem;
  transition: all 0.2s ease;
}
.footer-icon:hover {
  background: #101010;
  color: #A6F13B;
  transform: translateY(-2px);
}
.footer-subscribe-btn {
  background: #101010;
  color: white;
  padding: 0.5rem 1.2rem;
  border-radius: 9999px;
  font-size: 0.85rem;
  font-weight: 500;
  border: none;
  cursor: pointer;
  transition: background 0.2s ease;
  white-space: nowrap;
}
.footer-subscribe-btn:hover {
  background: #2a2a2a;
}
/* Message animations */
.bg-green-500\/20, .bg-red-500\/20 {
  animation: fadeInUp 0.5s ease;
}
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>