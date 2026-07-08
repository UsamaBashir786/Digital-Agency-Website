<?php
// ============================================================
// CONTACT.PHP - Contact Page with Backend (Dynamic Data)
// ============================================================

// 1. Start session FIRST (before ANY output)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Include database connection
include "config/connection.php";

// 3. Variables for form handling
$errors = [];
$success_message = '';
$form_data = [];

// 4. Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Store form data for repopulation
    $form_data = [
        'fullname' => $fullname,
        'email' => $email,
        'subject' => $subject,
        'message' => $message
    ];
    
    // Validation
    if (empty($fullname)) {
        $errors['fullname'] = 'Full name is required.';
    } elseif (strlen($fullname) < 2) {
        $errors['fullname'] = 'Name must be at least 2 characters.';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }
    
    if (empty($subject)) {
        $errors['subject'] = 'Subject is required.';
    }
    
    if (empty($message)) {
        $errors['message'] = 'Message is required.';
    } elseif (strlen($message) < 10) {
        $errors['message'] = 'Message must be at least 10 characters.';
    }
    
    // If no errors, process the contact form
    if (empty($errors)) {
        // Option 1: Save to database
        $sql = "INSERT INTO contacts (fullname, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $fullname, $email, $subject, $message);
        
        if ($stmt->execute()) {
            $success_message = '✅ Thank you! Your message has been sent. We\'ll get back to you within 24 hours.';
            
            // Clear form data after successful submission
            $form_data = [];
            $_POST = [];
        } else {
            $errors['general'] = 'Something went wrong. Please try again.';
        }
        $stmt->close();
    }
}

// ============================================================
// FETCH DYNAMIC DATA FROM DATABASE (via settings table)
// ============================================================
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

// Load dynamic settings
$site_name = getSettingValue('site_name', '4 Digi Sol');
$site_email = getSettingValue('site_email', 'hello@4digisol.com');
$site_phone = getSettingValue('site_phone', '+92 300 1234567');
$site_address = getSettingValue('site_address', '123 Digital Avenue, Tech Park, Lahore, Pakistan');
$contact_email = getSettingValue('contact_email', $site_email);
$contact_phone = getSettingValue('contact_phone', $site_phone);
$contact_address = getSettingValue('contact_address', $site_address);

// Also get social links for footer
$social_facebook = getSettingValue('social_facebook', 'https://facebook.com/4digisol');
$social_instagram = getSettingValue('social_instagram', 'https://instagram.com/4digisol');
$social_twitter = getSettingValue('social_twitter', 'https://twitter.com/4digisol');
$social_linkedin = getSettingValue('social_linkedin', 'https://linkedin.com/company/4digisol');
$social_youtube = getSettingValue('social_youtube', 'https://youtube.com/@4digisol');

// For backward compatibility - if contact specific settings are empty, use site settings
if (empty($contact_email)) $contact_email = $site_email;
if (empty($contact_phone)) $contact_phone = $site_phone;
if (empty($contact_address)) $contact_address = $site_address;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/css-links.php" ?>
    <title>Contact Us — <?php echo htmlspecialchars($site_name); ?></title>
    <style>
        body { 
            background: #0c0c0c; 
            color: #ffffff;
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
        .auth-input:focus {
            border-color: #A6F13B;
            outline: none;
            box-shadow: 0 0 0 3px rgba(166, 241, 59, 0.15);
        }
        .auth-input::placeholder { color: #888888; }
        .auth-input.error {
            border-color: #ef4444;
        }
        .auth-input.error:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
        }
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
        .auth-textarea:focus {
            border-color: #A6F13B;
            outline: none;
            box-shadow: 0 0 0 3px rgba(166, 241, 59, 0.15);
        }
        .auth-textarea::placeholder { color: #888888; }
        .auth-textarea.error {
            border-color: #ef4444;
        }
        .auth-textarea.error:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
        }
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
        .contact-card {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 1.5rem;
            padding: 1.75rem;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }
        .contact-card:hover {
            transform: translateY(-4px);
            border-color: rgba(166, 241, 59, 0.3);
        }
        .contact-icon {
            background: rgba(166, 241, 59, 0.08);
            width: 56px;
            height: 56px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: #A6F13B;
        }
        .field-error {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .success-message {
            background: rgba(166, 241, 59, 0.1);
            border: 1px solid rgba(166, 241, 59, 0.2);
            color: #A6F13B;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .social-link {
            color: #888;
            transition: color 0.2s, transform 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .social-link:hover {
            color: #A6F13B;
            transform: translateY(-2px);
        }
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
      
      <!-- Success Message -->
      <?php if ($success_message): ?>
      <div class="success-message">
        <i class='bx bx-check-circle'></i>
        <?php echo $success_message; ?>
      </div>
      <?php endif; ?>
      
      <!-- General Error -->
      <?php if (isset($errors['general'])): ?>
      <div class="error-message">
        <i class='bx bx-error-circle'></i>
        <?php echo $errors['general']; ?>
      </div>
      <?php endif; ?>
      
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
          <div>
            <label for="fullname" class="block text-xs font-medium text-gray-300 mb-1.5">Full Name <span class="text-red-400">*</span></label>
            <input type="text" id="fullname" name="fullname" class="auth-input <?php echo isset($errors['fullname']) ? 'error' : ''; ?>" placeholder="John Doe" value="<?php echo htmlspecialchars($form_data['fullname'] ?? ''); ?>" required />
            <?php if (isset($errors['fullname'])): ?>
            <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['fullname']; ?></div>
            <?php endif; ?>
          </div>
          <div>
            <label for="email" class="block text-xs font-medium text-gray-300 mb-1.5">Email Address <span class="text-red-400">*</span></label>
            <input type="email" id="email" name="email" class="auth-input <?php echo isset($errors['email']) ? 'error' : ''; ?>" placeholder="hello@4digisol.com" value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>" required />
            <?php if (isset($errors['email'])): ?>
            <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['email']; ?></div>
            <?php endif; ?>
          </div>
        </div>
        <div class="mb-4">
          <label for="subject" class="block text-xs font-medium text-gray-300 mb-1.5">Subject <span class="text-red-400">*</span></label>
          <input type="text" id="subject" name="subject" class="auth-input <?php echo isset($errors['subject']) ? 'error' : ''; ?>" placeholder="Project Inquiry" value="<?php echo htmlspecialchars($form_data['subject'] ?? ''); ?>" required />
          <?php if (isset($errors['subject'])): ?>
          <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['subject']; ?></div>
          <?php endif; ?>
        </div>
        <div class="mb-5">
          <label for="message" class="block text-xs font-medium text-gray-300 mb-1.5">Message <span class="text-red-400">*</span></label>
          <textarea id="message" name="message" class="auth-textarea <?php echo isset($errors['message']) ? 'error' : ''; ?>" placeholder="Tell us about your project..." required><?php echo htmlspecialchars($form_data['message'] ?? ''); ?></textarea>
          <?php if (isset($errors['message'])): ?>
          <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['message']; ?></div>
          <?php endif; ?>
        </div>
        <button type="submit" class="btn-primary flex items-center justify-center gap-2">
          <span>Send Message</span>
          <i class='bx bx-send text-lg'></i>
        </button>
      </form>
    </div>

    <!-- Contact Info - DYNAMIC DATA FROM DATABASE -->
    <div class="space-y-4">
      <div class="contact-card">
        <div class="contact-icon mb-3"><i class='bx bx-map-pin'></i></div>
        <h3 class="text-lg font-bold">Visit Us</h3>
        <p class="text-gray-400 text-sm mt-1 leading-relaxed">
          <?php 
          $address_lines = explode(',', $contact_address);
          foreach ($address_lines as $line) {
              echo htmlspecialchars(trim($line)) . '<br>';
          }
          ?>
        </p>
      </div>
      
      <div class="contact-card">
        <div class="contact-icon mb-3"><i class='bx bx-envelope'></i></div>
        <h3 class="text-lg font-bold">Email Us</h3>
        <?php 
        // Split emails if multiple
        $emails = explode(',', $contact_email);
        foreach ($emails as $email_addr) {
            $email_addr = trim($email_addr);
            if (!empty($email_addr)) {
                echo '<a href="mailto:' . htmlspecialchars($email_addr) . '" class="text-gray-400 text-sm hover:text-lime transition block">' . htmlspecialchars($email_addr) . '</a>';
            }
        }
        ?>
      </div>
      
      <div class="contact-card">
        <div class="contact-icon mb-3"><i class='bx bx-phone'></i></div>
        <h3 class="text-lg font-bold">Call Us</h3>
        <?php 
        // Split phone numbers if multiple
        $phones = explode(',', $contact_phone);
        foreach ($phones as $phone_num) {
            $phone_num = trim($phone_num);
            if (!empty($phone_num)) {
                $clean_phone = preg_replace('/[^0-9+]/', '', $phone_num);
                echo '<a href="tel:' . htmlspecialchars($clean_phone) . '" class="text-gray-400 text-sm hover:text-lime transition block">' . htmlspecialchars($phone_num) . '</a>';
            }
        }
        ?>
      </div>

      <div class="contact-card">
        <div class="contact-icon mb-3"><i class='bx bx-time'></i></div>
        <h3 class="text-lg font-bold">Working Hours</h3>
        <p class="text-gray-400 text-sm mt-1">Mon - Fri: 9:00 AM - 6:00 PM<br>Sat - Sun: Closed</p>
      </div>

      <!-- Social Links - DYNAMIC FROM DATABASE -->
      <div class="contact-card">
        <div class="contact-icon mb-3"><i class='bx bx-share-alt'></i></div>
        <h3 class="text-lg font-bold">Follow Us</h3>
        <div class="flex flex-wrap gap-3 mt-2">
          <?php if (!empty($social_facebook)): ?>
          <a href="<?php echo htmlspecialchars($social_facebook); ?>" target="_blank" class="social-link text-sm">
            <i class='bx bxl-facebook-circle text-xl'></i> Facebook
          </a>
          <?php endif; ?>
          
          <?php if (!empty($social_instagram)): ?>
          <a href="<?php echo htmlspecialchars($social_instagram); ?>" target="_blank" class="social-link text-sm">
            <i class='bx bxl-instagram text-xl'></i> Instagram
          </a>
          <?php endif; ?>
          
          <?php if (!empty($social_twitter)): ?>
          <a href="<?php echo htmlspecialchars($social_twitter); ?>" target="_blank" class="social-link text-sm">
            <i class='bx bxl-twitter text-xl'></i> Twitter
          </a>
          <?php endif; ?>
          
          <?php if (!empty($social_linkedin)): ?>
          <a href="<?php echo htmlspecialchars($social_linkedin); ?>" target="_blank" class="social-link text-sm">
            <i class='bx bxl-linkedin text-xl'></i> LinkedIn
          </a>
          <?php endif; ?>
          
          <?php if (!empty($social_youtube)): ?>
          <a href="<?php echo htmlspecialchars($social_youtube); ?>" target="_blank" class="social-link text-sm">
            <i class='bx bxl-youtube text-xl'></i> YouTube
          </a>
          <?php endif; ?>
        </div>
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
        <p class="text-xs text-gray-600"><?php echo htmlspecialchars($contact_address); ?></p>
      </div>
    </div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<?php include "includes/footer.php" ?>

<?php include "includes/js-links.php" ?>
</body>
</html>