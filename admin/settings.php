<?php
// ============================================================
// ADMIN/SETTINGS.PHP - Admin Settings Page (with Database)
// ============================================================

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once '../config/connection.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// ============================================================
// FUNCTIONS
// ============================================================

function getSetting($key, $default = '') {
    global $conn;
    $sql = "SELECT setting_value FROM settings WHERE setting_key = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['setting_value'];
    }
    return $default;
}

function updateSetting($key, $value) {
    global $conn;
    $sql = "UPDATE settings SET setting_value = ? WHERE setting_key = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $value, $key);
    return $stmt->execute();
}

// ============================================================
// HANDLE SETTINGS ACTIONS
// ============================================================

$action_message = '';
$action_type = '';

// Update Site Settings
if (isset($_POST['update_site_settings'])) {
    $site_name = trim($_POST['site_name'] ?? '');
    $site_tagline = trim($_POST['site_tagline'] ?? '');
    $site_email = trim($_POST['site_email'] ?? '');
    $site_phone = trim($_POST['site_phone'] ?? '');
    $site_address = trim($_POST['site_address'] ?? '');
    $footer_text = trim($_POST['footer_text'] ?? '');
    $contact_email = trim($_POST['contact_email'] ?? '');
    $contact_phone = trim($_POST['contact_phone'] ?? '');
    $contact_address = trim($_POST['contact_address'] ?? '');
    
    // Update settings
    updateSetting('site_name', $site_name);
    updateSetting('site_tagline', $site_tagline);
    updateSetting('site_email', $site_email);
    updateSetting('site_phone', $site_phone);
    updateSetting('site_address', $site_address);
    updateSetting('footer_copyright', $footer_text);
    updateSetting('contact_email', $contact_email);
    updateSetting('contact_phone', $contact_phone);
    updateSetting('contact_address', $contact_address);
    
    $action_message = 'Site settings updated successfully.';
    $action_type = 'success';
}

// Update Social Settings
if (isset($_POST['update_social_settings'])) {
    $facebook = trim($_POST['social_facebook'] ?? '');
    $instagram = trim($_POST['social_instagram'] ?? '');
    $twitter = trim($_POST['social_twitter'] ?? '');
    $linkedin = trim($_POST['social_linkedin'] ?? '');
    $youtube = trim($_POST['social_youtube'] ?? '');
    
    updateSetting('social_facebook', $facebook);
    updateSetting('social_instagram', $instagram);
    updateSetting('social_twitter', $twitter);
    updateSetting('social_linkedin', $linkedin);
    updateSetting('social_youtube', $youtube);
    
    $action_message = 'Social settings updated successfully.';
    $action_type = 'success';
}

// Update SEO Settings
if (isset($_POST['update_seo_settings'])) {
    $meta_description = trim($_POST['meta_description'] ?? '');
    $meta_keywords = trim($_POST['meta_keywords'] ?? '');
    $google_analytics = trim($_POST['google_analytics_id'] ?? '');
    
    updateSetting('meta_description', $meta_description);
    updateSetting('meta_keywords', $meta_keywords);
    updateSetting('google_analytics_id', $google_analytics);
    
    $action_message = 'SEO settings updated successfully.';
    $action_type = 'success';
}

// Update Admin Profile
if (isset($_POST['update_profile'])) {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    
    if (empty($fullname)) {
        $action_message = 'Full name is required.';
        $action_type = 'error';
    } elseif (empty($email)) {
        $action_message = 'Email address is required.';
        $action_type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $action_message = 'Please enter a valid email address.';
        $action_type = 'error';
    } else {
        $update_sql = "UPDATE users SET fullname = ?, email = ?, phone = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssi", $fullname, $email, $phone, $_SESSION['admin_id']);
        
        if ($update_stmt->execute()) {
            $_SESSION['admin_name'] = $fullname;
            $_SESSION['admin_email'] = $email;
            $action_message = 'Profile updated successfully.';
            $action_type = 'success';
        } else {
            $action_message = 'Failed to update profile.';
            $action_type = 'error';
        }
        $update_stmt->close();
    }
}

// Update Password
if (isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($current_password)) {
        $action_message = 'Current password is required.';
        $action_type = 'error';
    } elseif (empty($new_password)) {
        $action_message = 'New password is required.';
        $action_type = 'error';
    } elseif (strlen($new_password) < 6) {
        $action_message = 'Password must be at least 6 characters.';
        $action_type = 'error';
    } elseif ($new_password !== $confirm_password) {
        $action_message = 'Passwords do not match.';
        $action_type = 'error';
    } else {
        $verify_sql = "SELECT password FROM users WHERE id = ?";
        $verify_stmt = $conn->prepare($verify_sql);
        $verify_stmt->bind_param("i", $_SESSION['admin_id']);
        $verify_stmt->execute();
        $verify_result = $verify_stmt->get_result();
        $user_data = $verify_result->fetch_assoc();
        
        if (password_verify($current_password, $user_data['password'])) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $hashed_password, $_SESSION['admin_id']);
            
            if ($update_stmt->execute()) {
                $action_message = 'Password updated successfully.';
                $action_type = 'success';
            } else {
                $action_message = 'Failed to update password.';
                $action_type = 'error';
            }
            $update_stmt->close();
        } else {
            $action_message = 'Current password is incorrect.';
            $action_type = 'error';
        }
        $verify_stmt->close();
    }
}

// Update System Settings
if (isset($_POST['update_system_settings'])) {
    $maintenance_mode = isset($_POST['maintenance_mode']) ? '1' : '0';
    $allow_registration = isset($_POST['allow_registration']) ? '1' : '0';
    
    updateSetting('maintenance_mode', $maintenance_mode);
    updateSetting('allow_registration', $allow_registration);
    
    $action_message = 'System settings updated successfully.';
    $action_type = 'success';
}

// Get current admin data
$admin_sql = "SELECT * FROM users WHERE id = ?";
$admin_stmt = $conn->prepare($admin_sql);
$admin_stmt->bind_param("i", $_SESSION['admin_id']);
$admin_stmt->execute();
$admin_result = $admin_stmt->get_result();
$admin_data = $admin_result->fetch_assoc();
$admin_stmt->close();

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);

// Get all settings for display
$settings = [];
$settings_result = $conn->query("SELECT setting_key, setting_value FROM settings");
while ($row = $settings_result->fetch_assoc()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Settings — 4 Digi Sol</title>
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* Additional page-specific styles */
        .main-content {
            margin-left: 260px;
            padding: 1.5rem 2rem;
            padding-top: 80px;
            min-height: 100vh;
        }
        
        .settings-card {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 1.5rem;
            padding: 1.75rem;
            transition: border-color 0.3s ease;
        }
        .settings-card:hover {
            border-color: rgba(166, 241, 59, 0.2);
        }
        .settings-card h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .settings-card .subtitle {
            font-size: 0.85rem;
            color: #888;
            margin-bottom: 1.25rem;
        }
        
        .auth-input {
            background: #1a1a1a;
            border: 2px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 0.7rem 1rem;
            width: 100%;
            color: #ffffff;
            font-size: 0.9rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .auth-input:focus {
            border-color: #A6F13B;
            outline: none;
            box-shadow: 0 0 0 3px rgba(166, 241, 59, 0.1);
        }
        .auth-input::placeholder { color: #666; }
        .auth-input.error { border-color: #ef4444; }
        .auth-input:disabled { opacity: 0.5; cursor: not-allowed; }
        
        .btn-primary {
            background: #A6F13B;
            color: #0c0c0c;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.7rem 1.5rem;
            border: none;
            font-size: 0.9rem;
            transition: background 0.2s, transform 0.1s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-primary:hover { background: #8BD82E; }
        .btn-primary:active { transform: scale(0.98); }
        
        .btn-secondary {
            background: transparent;
            color: #ffffff;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 0.7rem 1.5rem;
            font-size: 0.9rem;
            transition: all 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.2); }
        
        .topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 260px;
            z-index: 50;
            background: rgba(12, 12, 12, 0.9);
            backdrop-filter: blur(12px);
            padding: 0.75rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
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
        
        .toggle-switch {
            position: relative;
            width: 50px;
            height: 28px;
            display: inline-block;
        }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #333;
            border-radius: 9999px;
            transition: 0.3s;
        }
        .toggle-slider:before {
            content: "";
            position: absolute;
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background: white;
            border-radius: 50%;
            transition: 0.3s;
        }
        .toggle-switch input:checked + .toggle-slider { background: #A6F13B; }
        .toggle-switch input:checked + .toggle-slider:before { transform: translateX(22px); }
        
        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 1rem; padding-top: 70px; }
            .topbar { left: 0; padding: 0.75rem 1rem; }
            .mobile-toggle { display: block; }
            .settings-card { padding: 1.25rem; }
        }
    </style>
</head>
<body>

<!-- ============ SIDEBAR ============ -->
<?php include 'includes/sidebar.php'; ?>

<!-- ============ TOPBAR ============ -->
<header class="topbar">
    <div class="flex items-center gap-3">
        <button class="mobile-toggle" id="sidebarToggle">
            <i class='bx bx-menu'></i>
        </button>
        <h1 class="text-lg font-semibold">Settings</h1>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-xs text-gray-400 hidden sm:block"><?php echo date('l, F j, Y'); ?></span>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-lime text-[#101010] flex items-center justify-center text-xs font-bold">
                <?php echo strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)); ?>
            </div>
            <span class="text-sm font-medium hidden sm:block"><?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?></span>
        </div>
    </div>
</header>

<!-- ============ MAIN CONTENT ============ -->
<main class="main-content">

    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold">Settings</h2>
            <p class="text-gray-400 text-sm">Manage your site settings and profile</p>
        </div>
    </div>

    <!-- Message Display -->
    <?php if ($action_message): ?>
    <div class="<?php echo $action_type === 'success' ? 'success-message' : 'error-message'; ?>">
        <i class='bx <?php echo $action_type === 'success' ? 'bx-check-circle' : 'bx-error-circle'; ?>'></i>
        <?php echo $action_message; ?>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- ============ SITE SETTINGS ============ -->
        <div class="settings-card">
            <h3><i class='bx bx-globe text-lime'></i> Site Settings</h3>
            <p class="subtitle">Update your website's basic information</p>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="site_name" class="block text-xs font-semibold text-gray-400 mb-1.5">Site Name</label>
                    <input type="text" id="site_name" name="site_name" class="auth-input" value="<?php echo htmlspecialchars($settings['site_name'] ?? '4 Digi Sol'); ?>">
                </div>
                <div class="mb-3">
                    <label for="site_tagline" class="block text-xs font-semibold text-gray-400 mb-1.5">Tagline</label>
                    <input type="text" id="site_tagline" name="site_tagline" class="auth-input" value="<?php echo htmlspecialchars($settings['site_tagline'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="site_email" class="block text-xs font-semibold text-gray-400 mb-1.5">Support Email</label>
                    <input type="email" id="site_email" name="site_email" class="auth-input" value="<?php echo htmlspecialchars($settings['site_email'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="site_phone" class="block text-xs font-semibold text-gray-400 mb-1.5">Phone Number</label>
                    <input type="text" id="site_phone" name="site_phone" class="auth-input" value="<?php echo htmlspecialchars($settings['site_phone'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="site_address" class="block text-xs font-semibold text-gray-400 mb-1.5">Address</label>
                    <input type="text" id="site_address" name="site_address" class="auth-input" value="<?php echo htmlspecialchars($settings['site_address'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="footer_text" class="block text-xs font-semibold text-gray-400 mb-1.5">Footer Copyright Text</label>
                    <input type="text" id="footer_text" name="footer_text" class="auth-input" value="<?php echo htmlspecialchars($settings['footer_copyright'] ?? '© 2026 4 Digi Sol. All rights reserved.'); ?>">
                </div>
                <button type="submit" name="update_site_settings" class="btn-primary w-full justify-center">
                    <i class='bx bx-save'></i> Save Site Settings
                </button>
            </form>
        </div>

        <!-- ============ SOCIAL SETTINGS ============ -->
        <div class="settings-card">
            <h3><i class='bx bx-share-alt text-lime'></i> Social Settings</h3>
            <p class="subtitle">Update your social media links</p>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="social_facebook" class="block text-xs font-semibold text-gray-400 mb-1.5">Facebook</label>
                    <input type="url" id="social_facebook" name="social_facebook" class="auth-input" placeholder="https://facebook.com/..." value="<?php echo htmlspecialchars($settings['social_facebook'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="social_instagram" class="block text-xs font-semibold text-gray-400 mb-1.5">Instagram</label>
                    <input type="url" id="social_instagram" name="social_instagram" class="auth-input" placeholder="https://instagram.com/..." value="<?php echo htmlspecialchars($settings['social_instagram'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="social_twitter" class="block text-xs font-semibold text-gray-400 mb-1.5">Twitter / X</label>
                    <input type="url" id="social_twitter" name="social_twitter" class="auth-input" placeholder="https://twitter.com/..." value="<?php echo htmlspecialchars($settings['social_twitter'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="social_linkedin" class="block text-xs font-semibold text-gray-400 mb-1.5">LinkedIn</label>
                    <input type="url" id="social_linkedin" name="social_linkedin" class="auth-input" placeholder="https://linkedin.com/..." value="<?php echo htmlspecialchars($settings['social_linkedin'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="social_youtube" class="block text-xs font-semibold text-gray-400 mb-1.5">YouTube</label>
                    <input type="url" id="social_youtube" name="social_youtube" class="auth-input" placeholder="https://youtube.com/..." value="<?php echo htmlspecialchars($settings['social_youtube'] ?? ''); ?>">
                </div>
                <button type="submit" name="update_social_settings" class="btn-primary w-full justify-center">
                    <i class='bx bx-save'></i> Save Social Settings
                </button>
            </form>
        </div>

        <!-- ============ SEO SETTINGS ============ -->
        <div class="settings-card">
            <h3><i class='bx bx-search-alt text-lime'></i> SEO Settings</h3>
            <p class="subtitle">Update your SEO meta tags and analytics</p>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="meta_description" class="block text-xs font-semibold text-gray-400 mb-1.5">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" class="auth-input" rows="2" placeholder="Enter meta description..." style="resize: vertical; min-height: 60px;"><?php echo htmlspecialchars($settings['meta_description'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="meta_keywords" class="block text-xs font-semibold text-gray-400 mb-1.5">Meta Keywords</label>
                    <input type="text" id="meta_keywords" name="meta_keywords" class="auth-input" placeholder="keyword1, keyword2, keyword3" value="<?php echo htmlspecialchars($settings['meta_keywords'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="google_analytics_id" class="block text-xs font-semibold text-gray-400 mb-1.5">Google Analytics ID</label>
                    <input type="text" id="google_analytics_id" name="google_analytics_id" class="auth-input" placeholder="UA-XXXXXXXXX-X" value="<?php echo htmlspecialchars($settings['google_analytics_id'] ?? ''); ?>">
                </div>
                <button type="submit" name="update_seo_settings" class="btn-primary w-full justify-center">
                    <i class='bx bx-save'></i> Save SEO Settings
                </button>
            </form>
        </div>

        <!-- ============ SYSTEM SETTINGS ============ -->
        <div class="settings-card">
            <h3><i class='bx bx-cog text-lime'></i> System Settings</h3>
            <p class="subtitle">Configure system-wide settings</p>
            
            <form method="POST" action="">
                <div class="flex items-center justify-between py-2 border-b border-white/5">
                    <div>
                        <label class="text-sm font-medium">Maintenance Mode</label>
                        <p class="text-xs text-gray-500">Disable site access for non-admin users</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="maintenance_mode" <?php echo (isset($settings['maintenance_mode']) && $settings['maintenance_mode'] == '1') ? 'checked' : ''; ?>>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-white/5">
                    <div>
                        <label class="text-sm font-medium">Allow User Registration</label>
                        <p class="text-xs text-gray-500">Enable or disable new user signups</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="allow_registration" <?php echo (isset($settings['allow_registration']) && $settings['allow_registration'] == '1') ? 'checked' : ''; ?>>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <button type="submit" name="update_system_settings" class="btn-primary w-full justify-center mt-3">
                    <i class='bx bx-save'></i> Save System Settings
                </button>
            </form>
        </div>

        <!-- ============ PROFILE SETTINGS ============ -->
        <div class="settings-card lg:col-span-2">
            <h3><i class='bx bx-user text-lime'></i> Profile Settings</h3>
            <p class="subtitle">Update your personal information</p>
            
            <form method="POST" action="" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="fullname" class="block text-xs font-semibold text-gray-400 mb-1.5">Full Name</label>
                    <input type="text" id="fullname" name="fullname" class="auth-input" placeholder="John Doe" value="<?php echo htmlspecialchars($admin_data['fullname'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-400 mb-1.5">Email Address</label>
                    <input type="email" id="email" name="email" class="auth-input" placeholder="admin@4digisol.com" value="<?php echo htmlspecialchars($admin_data['email'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="phone" class="block text-xs font-semibold text-gray-400 mb-1.5">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="auth-input" placeholder="+92 300 1234567" value="<?php echo htmlspecialchars($admin_data['phone'] ?? ''); ?>">
                </div>
                <div class="md:col-span-3">
                    <button type="submit" name="update_profile" class="btn-primary w-full justify-center">
                        <i class='bx bx-user-check'></i> Update Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- ============ CHANGE PASSWORD ============ -->
        <div class="settings-card lg:col-span-2">
            <h3><i class='bx bx-lock text-lime'></i> Change Password</h3>
            <p class="subtitle">Update your password to keep your account secure</p>
            
            <form method="POST" action="" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="current_password" class="block text-xs font-semibold text-gray-400 mb-1.5">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="auth-input" placeholder="••••••••" required>
                </div>
                <div>
                    <label for="new_password" class="block text-xs font-semibold text-gray-400 mb-1.5">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="auth-input" placeholder="••••••••" required>
                </div>
                <div>
                    <label for="confirm_password" class="block text-xs font-semibold text-gray-400 mb-1.5">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="auth-input" placeholder="••••••••" required>
                </div>
                <div class="md:col-span-3">
                    <button type="submit" name="update_password" class="btn-primary w-full justify-center">
                        <i class='bx bx-key'></i> Change Password
                    </button>
                </div>
            </form>
        </div>

        <!-- ============ ACCOUNT INFORMATION ============ -->
        <div class="settings-card lg:col-span-2">
            <h3><i class='bx bx-info-circle text-lime'></i> Account Information</h3>
            <p class="subtitle">Details about your account</p>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Account ID</p>
                    <p class="text-sm font-medium">#<?php echo $admin_data['id'] ?? 'N/A'; ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Role</p>
                    <p class="text-sm font-medium"><span class="badge badge-admin">Administrator</span></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Member Since</p>
                    <p class="text-sm font-medium"><?php echo date('M d, Y', strtotime($admin_data['created_at'] ?? 'now')); ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Last Updated</p>
                    <p class="text-sm font-medium"><?php echo date('M d, Y', strtotime($admin_data['updated_at'] ?? 'now')); ?></p>
                </div>
            </div>
        </div>

    </div>

</main>

</body>
</html>