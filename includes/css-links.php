<?php
// ============================================================
// INCLUDES/CSS-LINKS.PHP - CSS & Meta Tags (Dynamic from DB)
// ============================================================

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/../config/connection.php';

// Detect if we're in admin panel
$is_admin = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
$base_path = $is_admin ? '../' : '';

// ============================================================
// FETCH SETTINGS FROM DATABASE
// ============================================================
function getSetting($key, $default = '') {
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
        // If table doesn't exist yet, return default
        return $default;
    }
    return $default;
}

// Load all settings from database
$settings = [];
try {
    $result = $conn->query("SELECT setting_key, setting_value FROM settings");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
} catch (Exception $e) {
    // Settings table might not exist yet, use defaults
}

// ============================================================
// SITE SETTINGS (with database values or defaults)
// ============================================================
$site_name = $settings['site_name'] ?? '4 Digi Sol';
$site_tagline = $settings['site_tagline'] ?? 'Digital Marketing Agency';
$site_email = $settings['site_email'] ?? 'hello@4digisol.com';
$site_phone = $settings['site_phone'] ?? '+92 300 1234567';
$site_address = $settings['site_address'] ?? '';
$footer_text = $settings['footer_copyright'] ?? '© 2026 4 Digi Sol. All rights reserved.';

// Social Settings
$social_facebook = $settings['social_facebook'] ?? 'https://facebook.com/4digisol';
$social_instagram = $settings['social_instagram'] ?? 'https://instagram.com/4digisol';
$social_twitter = $settings['social_twitter'] ?? 'https://twitter.com/4digisol';
$social_linkedin = $settings['social_linkedin'] ?? 'https://linkedin.com/company/4digisol';
$social_youtube = $settings['social_youtube'] ?? 'https://youtube.com/@4digisol';

// SEO Settings
$meta_description_db = $settings['meta_description'] ?? '4 Digi Sol is a digital marketing agency empowering brands through creative solutions. We offer web design, branding, UI/UX, local & e-commerce SEO, and digital marketing services trusted by 2000+ brands.';
$meta_keywords_db = $settings['meta_keywords'] ?? 'digital marketing agency, web design, branding services, UI/UX design, SEO services Pakistan, local SEO, e-commerce SEO, technical SEO, creative agency, brand strategy, web development';
$google_analytics_id = $settings['google_analytics_id'] ?? '';

// System Settings
$maintenance_mode = $settings['maintenance_mode'] ?? '0';
$allow_registration = $settings['allow_registration'] ?? '1';

// ============================================================
// PAGE SPECIFIC TITLE & META
// ============================================================
// Get current page for dynamic title
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$page_title = ucfirst(str_replace(['-', '_'], ' ', $current_page));

// Default title based on page
$site_title = $site_name . ' — ' . $site_tagline;
$page_titles = [
    'index' => $site_name . ' — ' . $site_tagline . ' | Web Design, Branding & SEO Services',
    'about' => 'About Us — ' . $site_name . ' | ' . $site_tagline,
    'services' => 'Services — ' . $site_name . ' | SEO, Web Design & Branding',
    'contact' => 'Contact Us — ' . $site_name . ' | Get in Touch',
    'blogs' => 'Blog — ' . $site_name . ' | Digital Marketing Insights',
    'blog-details' => 'Blog Details — ' . $site_name,
    'case-studies' => 'Case Studies — ' . $site_name . ' | Our Success Stories',
    'login' => 'Login — ' . $site_name,
    'register' => 'Sign Up — ' . $site_name,
    'forgot-password' => 'Forgot Password — ' . $site_name,
    'privacy' => 'Privacy Policy — ' . $site_name,
    'terms' => 'Terms & Conditions — ' . $site_name,
    'faqs' => 'FAQs — ' . $site_name,
    'local-seo' => 'Local SEO Services — ' . $site_name,
    'ecommerce-seo' => 'E-Commerce SEO Services — ' . $site_name,
    'onpage-seo' => 'On-Page SEO Services — ' . $site_name,
    'offpage-seo' => 'Off-Page SEO Services — ' . $site_name,
    'technical-seo' => 'Technical SEO Services — ' . $site_name,
    'answer-engine-seo' => 'Answer Engine Optimization — ' . $site_name,
    'generative-seo' => 'Generative SEO Services — ' . $site_name,
    'web-development' => 'Web Development Services — ' . $site_name
];

// Admin page titles
$admin_titles = [
    'index' => 'Dashboard — ' . $site_name . ' Admin',
    'users' => 'Manage Users — ' . $site_name . ' Admin',
    'contacts' => 'Manage Contacts — ' . $site_name . ' Admin',
    'create-admin' => 'Create Admin — ' . $site_name . ' Admin',
    'settings' => 'Settings — ' . $site_name . ' Admin',
    'login' => 'Admin Login — ' . $site_name
];

if ($is_admin) {
    $title = $admin_titles[$current_page] ?? 'Admin Panel — ' . $site_name;
} else {
    $title = $page_titles[$current_page] ?? $site_title;
}

// Admin-specific meta tags
if ($is_admin) {
    $meta_description = 'Admin panel for ' . $site_name . ' - ' . $site_tagline . '. Manage users, contacts, and site settings.';
    $meta_keywords = 'admin, dashboard, manage users, settings, ' . strtolower(str_replace(' ', '', $site_name));
    $robots = 'noindex, nofollow';
    $canonical = 'https://' . strtolower(str_replace(' ', '', $site_name)) . '.com/admin/' . $current_page . '.php';
} else {
    $meta_description = $meta_description_db;
    $meta_keywords = $meta_keywords_db;
    $robots = 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
    $canonical = 'https://' . strtolower(str_replace(' ', '', $site_name)) . '.com/' . ($current_page != 'index' ? $current_page . '.php' : '');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">

<!-- ============ SEO META TAGS ============ -->
<title><?php echo $title; ?></title>
<meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
<meta name="robots" content="<?php echo $robots; ?>">
<meta name="author" content="<?php echo htmlspecialchars($site_name); ?>">
<meta name="theme-color" content="#0c0c0c">
<link rel="canonical" href="<?php echo $canonical; ?>">

<!-- Favicon -->
<link rel="icon" href="<?php echo $base_path; ?>favicon.ico" sizes="any">
<link rel="icon" href="<?php echo $base_path; ?>favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?php echo $base_path; ?>apple-touch-icon.png">

<!-- ============ GOOGLE ANALYTICS ============ -->
<?php if (!empty($google_analytics_id) && !$is_admin): ?>
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $google_analytics_id; ?>"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '<?php echo $google_analytics_id; ?>');
</script>
<?php endif; ?>

<?php if (!$is_admin): ?>
<!-- ============ OPEN GRAPH ============ -->
<meta property="og:site_name" content="<?php echo htmlspecialchars($site_name); ?>">
<meta property="og:locale" content="en_US">
<meta property="og:title" content="<?php echo $title; ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo $canonical; ?>">
<meta property="og:image" content="<?php echo $base_path; ?>assets/images/og-image.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="<?php echo htmlspecialchars($site_name) . ' - ' . htmlspecialchars($site_tagline); ?>">

<!-- ============ TWITTER CARD ============ -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $title; ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($meta_description); ?>">
<meta name="twitter:image" content="<?php echo $base_path; ?>assets/images/og-image.jpg">
<meta name="twitter:image:alt" content="<?php echo htmlspecialchars($site_name) . ' - ' . htmlspecialchars($site_tagline); ?>">

<!-- ============ SCHEMA.ORG: ORGANIZATION ============ -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "<?php echo htmlspecialchars($site_name); ?>",
  "description": "<?php echo htmlspecialchars($meta_description); ?>",
  "url": "https://<?php echo strtolower(str_replace(' ', '', $site_name)); ?>.com/",
  "logo": "https://<?php echo strtolower(str_replace(' ', '', $site_name)); ?>.com/logo.png",
  "foundingDate": "2016",
  "address": {
    "@type": "PostalAddress",
    "addressCountry": "Pakistan"
  },
  "contactPoint": {
    "@type": "ContactPoint",
    "contactType": "customer service",
    "email": "<?php echo htmlspecialchars($site_email); ?>"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "reviewCount": "150"
  },
  "sameAs": [
    "<?php echo htmlspecialchars($social_facebook); ?>",
    "<?php echo htmlspecialchars($social_instagram); ?>",
    "<?php echo htmlspecialchars($social_linkedin); ?>"
  ]
}
</script>

<!-- ============ SCHEMA.ORG: WEBSITE ============ -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "<?php echo htmlspecialchars($site_name); ?>",
  "url": "https://<?php echo strtolower(str_replace(' ', '', $site_name)); ?>.com/",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://<?php echo strtolower(str_replace(' ', '', $site_name)); ?>.com/search?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>

<!-- ============ SCHEMA.ORG: BREADCRUMB ============ -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://<?php echo strtolower(str_replace(' ', '', $site_name)); ?>.com/" },
    { "@type": "ListItem", "position": 2, "name": "Services", "item": "https://<?php echo strtolower(str_replace(' ', '', $site_name)); ?>.com/services.php" },
    { "@type": "ListItem", "position": 3, "name": "About", "item": "https://<?php echo strtolower(str_replace(' ', '', $site_name)); ?>.com/about.php" }
  ]
}
</script>

<!-- ============ SCHEMA.ORG: SERVICES ============ -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "serviceType": "Digital Marketing and SEO Services",
  "provider": { "@type": "Organization", "name": "<?php echo htmlspecialchars($site_name); ?>", "url": "https://<?php echo strtolower(str_replace(' ', '', $site_name)); ?>.com/" },
  "areaServed": "Worldwide",
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "Digital Marketing Services",
    "itemListElement": [
      { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Local SEO" } },
      { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "E-Commerce SEO" } },
      { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "On-Page SEO" } },
      { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Off-Page SEO" } },
      { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Technical SEO" } },
      { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Web Development" } }
    ]
  }
}
</script>

<!-- ============ MAINTENANCE MODE CHECK ============ -->
<?php if ($maintenance_mode == '1' && !$is_admin): ?>
<style>
body::before {
    content: "🔧 We're currently updating our website. We'll be back soon!";
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.9);
    color: #A6F13B;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 600;
    z-index: 999999;
    padding: 2rem;
    text-align: center;
}
body > * { display: none; }
body::before { display: flex !important; }
</style>
<?php endif; ?>
<?php endif; ?>

<!-- ============ PRECONNECTS ============ -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://unpkg.com">
<link rel="dns-prefetch" href="https://cdn.tailwindcss.com">

<!-- ============ STYLESHEETS ============ -->
<script src="https://cdn.tailwindcss.com"></script>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<!-- ============ CUSTOM STYLES ============ -->
<link rel="stylesheet" href="<?php echo $base_path; ?>assets/styles/styles.css">

<!-- ============ ADMIN SPECIFIC OVERRIDES ============ -->
<?php if ($is_admin): ?>
<style>
    /* Admin panel specific styles */
    body { background: #0c0c0c; color: #ffffff; }
    .auth-card { background: #141414 !important; border: 1px solid rgba(255,255,255,0.06) !important; box-shadow: 0 30px 60px rgba(0,0,0,0.5) !important; }
    .auth-card .text-[#1a1a1a] { color: #ffffff !important; }
    .auth-card .text-[#5f6368] { color: #888888 !important; }
    .auth-card .text-[#1a1a1a]\/80 { color: #aaaaaa !important; }
    .auth-card .bg-[#f0f2f5] { background: #1a1a1a !important; color: #888888 !important; }
    .auth-card .brand-icon { background: #1a1a1a !important; }
    .auth-input { background: #1a1a1a !important; border: 2px solid rgba(255,255,255,0.06) !important; color: #ffffff !important; }
    .auth-input:focus { border-color: #A6F13B !important; box-shadow: 0 0 0 4px rgba(166, 241, 59, 0.1) !important; }
    .auth-input::placeholder { color: #666666 !important; }
    .btn-primary { background: #A6F13B !important; color: #0c0c0c !important; }
    .btn-primary:hover { background: #8BD82E !important; }
    .auth-link { color: #A6F13B !important; }
    .auth-link:hover { color: #8BD82E !important; }
    .divider-line { background: rgba(255,255,255,0.06) !important; }
    .social-btn { background: #1a1a1a !important; border: 2px solid rgba(255,255,255,0.06) !important; color: #ffffff !important; }
    .social-btn:hover { background: #262626 !important; border-color: #A6F13B !important; }
    .back-home { color: #888888 !important; }
    .back-home:hover { color: #A6F13B !important; }
    .error-message { background: rgba(239, 68, 68, 0.1) !important; border: 1px solid rgba(239, 68, 68, 0.2) !important; color: #ef4444 !important; }
    .success-message { background: rgba(166, 241, 59, 0.1) !important; border: 1px solid rgba(166, 241, 59, 0.2) !important; color: #A6F13B !important; }
    .admin-login-card { background: #141414 !important; border: 1px solid rgba(255,255,255,0.06) !important; }
    .admin-logo { background: rgba(166, 241, 59, 0.08) !important; border: 2px solid rgba(166, 241, 59, 0.15) !important; }
    .admin-badge { background: rgba(166, 241, 59, 0.1) !important; border: 1px solid rgba(166, 241, 59, 0.15) !important; color: #A6F13B !important; }
</style>
<?php endif; ?>
</head>
<body>