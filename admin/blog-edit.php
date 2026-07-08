<?php
// ============================================================
// ADMIN/BLOG-EDIT.PHP - Edit Blog Post
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
// CREATE UPLOADS DIRECTORY IF NOT EXISTS
// ============================================================
$upload_dir = '../uploads/blogs/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// ============================================================
// GET BLOG POST DATA
// ============================================================

$blog_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$blog_data = null;

if ($blog_id > 0) {
    $sql = "SELECT * FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $blog_data = $result->fetch_assoc();
    $stmt->close();
}

if (!$blog_data) {
    header('Location: blogs.php');
    exit();
}

// ============================================================
// HANDLE FORM SUBMISSION
// ============================================================

$action_message = '';
$action_type = '';
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = $_POST['content'] ?? '';
    $category = trim($_POST['category'] ?? '');
    $author = trim($_POST['author'] ?? $_SESSION['admin_name'] ?? 'Admin');
    
    // FIXED: Properly handle status - only allow 'published' or 'draft'
    $status = isset($_POST['status']) ? $_POST['status'] : 'draft';
    // Ensure status is only 'published' or 'draft'
    if ($status !== 'published' && $status !== 'draft') {
        $status = 'draft';
    }
    
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $meta_keywords = trim($_POST['meta_keywords'] ?? '');
    
    // Store form data for repopulation
    $form_data = [
        'title' => $title,
        'slug' => $slug,
        'excerpt' => $excerpt,
        'content' => $content,
        'category' => $category,
        'author' => $author,
        'status' => $status,
        'is_featured' => $is_featured,
        'meta_title' => $meta_title,
        'meta_description' => $meta_description,
        'meta_keywords' => $meta_keywords
    ];
    
    // Validation
    $errors = [];
    
    if (empty($title)) {
        $errors['title'] = 'Title is required.';
    }
    
    if (empty($slug)) {
        // Auto-generate slug from title
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $form_data['slug'] = $slug;
    }
    
    // Check if slug already exists (excluding current post)
    $check_sql = "SELECT id FROM blogs WHERE slug = ? AND id != ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("si", $slug, $blog_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $errors['slug'] = 'Slug already exists. Please use a different slug.';
    }
    $check_stmt->close();
    
    if (empty($content)) {
        $errors['content'] = 'Content is required.';
    }
    
    if (empty($category)) {
        $errors['category'] = 'Category is required.';
    }
    
    // Handle featured image upload
    $featured_image = $blog_data['featured_image'];
    $remove_image = isset($_POST['remove_image']) ? true : false;
    
    if ($remove_image && !empty($featured_image)) {
        $image_path = $upload_dir . $featured_image;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        $featured_image = '';
    }
    
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['featured_image'];
        $file_name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file['name']);
        $file_tmp = $file['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        
        if (in_array($file_ext, $allowed_exts)) {
            // Delete old image if exists
            if (!empty($blog_data['featured_image'])) {
                $old_image_path = $upload_dir . $blog_data['featured_image'];
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
            
            if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
                $featured_image = $file_name;
            } else {
                $errors['featured_image'] = 'Failed to upload image.';
            }
        } else {
            $errors['featured_image'] = 'Invalid file type. Allowed: JPG, PNG, GIF, WEBP, SVG.';
        }
    }
    
    // If no errors, update database
    if (empty($errors)) {
        $update_sql = "UPDATE blogs SET 
                       title = ?, 
                       slug = ?, 
                       excerpt = ?, 
                       content = ?, 
                       category = ?, 
                       author = ?, 
                       featured_image = ?, 
                       status = ?, 
                       is_featured = ?,
                       meta_title = ?,
                       meta_description = ?,
                       meta_keywords = ?
                       WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param(
            "ssssssssssssi",
            $title, 
            $slug, 
            $excerpt, 
            $content, 
            $category, 
            $author, 
            $featured_image, 
            $status, 
            $is_featured,
            $meta_title,
            $meta_description,
            $meta_keywords,
            $blog_id
        );
        
        if ($update_stmt->execute()) {
            $action_message = 'Blog post updated successfully!';
            $action_type = 'success';
            // Refresh blog data
            $blog_data['title'] = $title;
            $blog_data['slug'] = $slug;
            $blog_data['excerpt'] = $excerpt;
            $blog_data['content'] = $content;
            $blog_data['category'] = $category;
            $blog_data['author'] = $author;
            $blog_data['featured_image'] = $featured_image;
            $blog_data['status'] = $status;
            $blog_data['is_featured'] = $is_featured;
            $blog_data['meta_title'] = $meta_title;
            $blog_data['meta_description'] = $meta_description;
            $blog_data['meta_keywords'] = $meta_keywords;
        } else {
            $action_message = 'Failed to update blog post. Please try again.';
            $action_type = 'error';
        }
        $update_stmt->close();
    } else {
        $action_message = 'Please fix the errors below.';
        $action_type = 'error';
        // Keep blog data for display
        foreach ($form_data as $key => $value) {
            $blog_data[$key] = $value;
        }
    }
}

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);

// Get total blogs count for sidebar
$total_blogs_query = "SELECT COUNT(*) as total FROM blogs";
$total_blogs_result = $conn->query($total_blogs_query);
$total_blogs = $total_blogs_result->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Edit Blog Post — 4 Digi Sol</title>
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100%;
            background: #101010;
            border-right: 1px solid rgba(255,255,255,0.06);
            padding: 1.5rem 1rem;
            z-index: 100;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: #A6F13B; border-radius: 4px; }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 1rem;
            border-radius: 0.75rem;
            color: #b0b0b0;
            transition: all 0.3s;
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }
        .sidebar-link:hover {
            background: rgba(166, 241, 59, 0.08);
            color: #ffffff;
        }
        .sidebar-link.active {
            background: rgba(166, 241, 59, 0.12);
            color: #A6F13B;
        }
        .sidebar-link i { font-size: 1.2rem; width: 24px; }
        
        .sidebar-divider {
            height: 1px;
            background: rgba(255,255,255,0.06);
            margin: 0.75rem 0;
        }
        
        .main-content {
            margin-left: 260px;
            padding: 1.5rem 2rem;
            padding-top: 80px;
            min-height: 100vh;
        }
        
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
        
        .form-card {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 1.5rem;
            padding: 1.75rem;
        }
        .form-card h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .form-card .subtitle {
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
        .auth-textarea {
            background: #1a1a1a;
            border: 2px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 0.7rem 1rem;
            width: 100%;
            color: #ffffff;
            font-size: 0.9rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            resize: vertical;
            min-height: 300px;
            font-family: 'Poppins', sans-serif;
        }
        .auth-textarea:focus {
            border-color: #A6F13B;
            outline: none;
            box-shadow: 0 0 0 3px rgba(166, 241, 59, 0.1);
        }
        .auth-textarea::placeholder { color: #666; }
        .auth-textarea.error { border-color: #ef4444; }
        
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
            text-decoration: none;
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.2); }
        
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
        
        .category-select {
            background: #1a1a1a;
            border: 2px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 0.7rem 1rem;
            width: 100%;
            color: #ffffff;
            font-size: 0.9rem;
            transition: border-color 0.2s;
            cursor: pointer;
        }
        .category-select:focus { border-color: #A6F13B; outline: none; }
        .category-select.error { border-color: #ef4444; }
        
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
        
        .file-upload {
            border: 2px dashed rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s;
            background: #1a1a1a;
        }
        .file-upload:hover { border-color: #A6F13B; }
        .file-upload i { font-size: 2rem; color: #666; }
        .file-upload p { font-size: 0.85rem; color: #666; margin-top: 0.5rem; }
        #file-name { font-size: 0.8rem; color: #A6F13B; margin-top: 0.5rem; display: none; }
        .current-image { margin-top: 0.5rem; padding: 0.5rem; background: #0c0c0c; border-radius: 8px; display: flex; align-items: center; gap: 1rem; }
        .current-image img { width: 80px; height: 60px; object-fit: cover; border-radius: 6px; }
        .current-image .remove-image { color: #ef4444; cursor: pointer; font-size: 0.8rem; }
        .current-image .remove-image:hover { text-decoration: underline; }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 1rem; padding-top: 70px; }
            .topbar { left: 0; padding: 0.75rem 1rem; }
            .mobile-toggle { display: block; }
            .form-card { padding: 1.25rem; }
        }
    </style>
</head>
<body>

<!-- ============ SIDEBAR ============ -->
<aside class="sidebar" id="sidebar">
    <div class="flex items-center gap-2 font-bold text-lg mb-6 px-2">
        <i class='bx bx-sparkle text-lime'></i>
        <span>4 Digi Sol</span>
        <span class="ml-auto text-[10px] font-medium text-gray-500 bg-white/5 px-2 py-0.5 rounded-full">Admin</span>
    </div>
    
    <nav>
        <a href="index.php" class="sidebar-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">
            <i class='bx bx-grid-alt'></i> Dashboard
        </a>
        <a href="users.php" class="sidebar-link <?php echo $currentPage == 'users.php' ? 'active' : ''; ?>">
            <i class='bx bx-user'></i> Users
        </a>
        <a href="contacts.php" class="sidebar-link <?php echo $currentPage == 'contacts.php' ? 'active' : ''; ?>">
            <i class='bx bx-envelope'></i> Contacts
        </a>
        <a href="blogs.php" class="sidebar-link <?php echo $currentPage == 'blogs.php' || $currentPage == 'blog-edit.php' || $currentPage == 'blog-add.php' ? 'active' : ''; ?>">
            <i class='bx bx-news'></i> Blogs
            <?php if ($total_blogs > 0): ?>
            <span class="ml-auto text-xs text-gray-500"><?php echo $total_blogs; ?></span>
            <?php endif; ?>
        </a>
        <a href="services.php" class="sidebar-link <?php echo $currentPage == 'services.php' || $currentPage == 'edit-service.php' ? 'active' : ''; ?>">
            <i class='bx bx-briefcase'></i> Services
        </a>
        <div class="sidebar-divider"></div>
        <a href="settings.php" class="sidebar-link <?php echo $currentPage == 'settings.php' ? 'active' : ''; ?>">
            <i class='bx bx-cog'></i> Settings
        </a>
        <div class="sidebar-divider"></div>
        <a href="../index.php" class="sidebar-link">
            <i class='bx bx-home'></i> View Site
        </a>
        <a href="../logout.php" class="sidebar-link text-red-400 hover:text-red-300">
            <i class='bx bx-log-out'></i> Logout
        </a>
    </nav>
</aside>

<!-- ============ SIDEBAR OVERLAY (Mobile) ============ -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden" onclick="closeSidebar()"></div>

<!-- ============ TOPBAR ============ -->
<header class="topbar">
    <div class="flex items-center gap-3">
        <button class="mobile-toggle" id="sidebarToggle">
            <i class='bx bx-menu'></i>
        </button>
        <h1 class="text-lg font-semibold">Edit Blog Post</h1>
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
            <h2 class="text-2xl font-bold">Edit Blog Post</h2>
            <p class="text-gray-400 text-sm">Update your blog post</p>
        </div>
        <a href="blogs.php" class="btn-secondary">
            <i class='bx bx-arrow-back'></i> Back to Blogs
        </a>
    </div>

    <!-- Message Display -->
    <?php if ($action_message): ?>
    <div class="<?php echo $action_type === 'success' ? 'success-message' : 'error-message'; ?>">
        <i class='bx <?php echo $action_type === 'success' ? 'bx-check-circle' : 'bx-error-circle'; ?>'></i>
        <?php echo $action_message; ?>
    </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="form-card">
        <form method="POST" action="" enctype="multipart/form-data">
            
            <!-- Title & Slug -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="title" class="block text-xs font-semibold text-gray-400 mb-1.5">Title <span class="text-red-400">*</span></label>
                    <input type="text" id="title" name="title" class="auth-input <?php echo isset($errors['title']) ? 'error' : ''; ?>" placeholder="Enter blog title" value="<?php echo htmlspecialchars($blog_data['title'] ?? ''); ?>" required onkeyup="generateSlug(this.value)">
                    <?php if (isset($errors['title'])): ?>
                    <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['title']; ?></div>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="slug" class="block text-xs font-semibold text-gray-400 mb-1.5">Slug <span class="text-red-400">*</span></label>
                    <input type="text" id="slug" name="slug" class="auth-input <?php echo isset($errors['slug']) ? 'error' : ''; ?>" placeholder="enter-url-slug" value="<?php echo htmlspecialchars($blog_data['slug'] ?? ''); ?>" required>
                    <?php if (isset($errors['slug'])): ?>
                    <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['slug']; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Category & Author -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="category" class="block text-xs font-semibold text-gray-400 mb-1.5">Category <span class="text-red-400">*</span></label>
                    <select id="category" name="category" class="category-select <?php echo isset($errors['category']) ? 'error' : ''; ?>" required>
                        <option value="">Select Category</option>
                        <option value="SEO" <?php echo (isset($blog_data['category']) && $blog_data['category'] === 'SEO') ? 'selected' : ''; ?>>SEO</option>
                        <option value="Local SEO" <?php echo (isset($blog_data['category']) && $blog_data['category'] === 'Local SEO') ? 'selected' : ''; ?>>Local SEO</option>
                        <option value="E-Commerce SEO" <?php echo (isset($blog_data['category']) && $blog_data['category'] === 'E-Commerce SEO') ? 'selected' : ''; ?>>E-Commerce SEO</option>
                        <option value="Content SEO" <?php echo (isset($blog_data['category']) && $blog_data['category'] === 'Content SEO') ? 'selected' : ''; ?>>Content SEO</option>
                        <option value="Technical SEO" <?php echo (isset($blog_data['category']) && $blog_data['category'] === 'Technical SEO') ? 'selected' : ''; ?>>Technical SEO</option>
                        <option value="Web Development" <?php echo (isset($blog_data['category']) && $blog_data['category'] === 'Web Development') ? 'selected' : ''; ?>>Web Development</option>
                        <option value="Digital Marketing" <?php echo (isset($blog_data['category']) && $blog_data['category'] === 'Digital Marketing') ? 'selected' : ''; ?>>Digital Marketing</option>
                        <option value="Branding" <?php echo (isset($blog_data['category']) && $blog_data['category'] === 'Branding') ? 'selected' : ''; ?>>Branding</option>
                        <option value="Web Design" <?php echo (isset($blog_data['category']) && $blog_data['category'] === 'Web Design') ? 'selected' : ''; ?>>Web Design</option>
                    </select>
                    <?php if (isset($errors['category'])): ?>
                    <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['category']; ?></div>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="author" class="block text-xs font-semibold text-gray-400 mb-1.5">Author</label>
                    <input type="text" id="author" name="author" class="auth-input" placeholder="Author name" value="<?php echo htmlspecialchars($blog_data['author'] ?? $_SESSION['admin_name'] ?? 'Admin'); ?>">
                </div>
            </div>
            
            <!-- Featured Image -->
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-400 mb-1.5">Featured Image</label>
                
                <?php if (!empty($blog_data['featured_image'])): ?>
                <div class="current-image">
                    <img src="../uploads/blogs/<?php echo $blog_data['featured_image']; ?>" alt="Current featured image">
                    <div>
                        <p class="text-xs text-gray-400">Current image: <?php echo $blog_data['featured_image']; ?></p>
                        <label class="remove-image">
                            <input type="checkbox" name="remove_image" value="1"> Remove this image
                        </label>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="file-upload" onclick="document.getElementById('featured_image').click()">
                    <i class='bx bx-cloud-upload'></i>
                    <p>Click to upload new featured image<br><span style="font-size: 0.7rem; color: #555;">JPG, PNG, GIF, WEBP up to 5MB</span></p>
                    <div id="file-name"></div>
                </div>
                <input type="file" id="featured_image" name="featured_image" class="hidden" accept="image/*" onchange="displayFileName(this)">
                <?php if (isset($errors['featured_image'])): ?>
                <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['featured_image']; ?></div>
                <?php endif; ?>
            </div>
            
            <!-- Excerpt -->
            <div class="mb-4">
                <label for="excerpt" class="block text-xs font-semibold text-gray-400 mb-1.5">Excerpt / Summary</label>
                <textarea id="excerpt" name="excerpt" class="auth-textarea" rows="2" placeholder="Brief summary of the blog post..." style="min-height: 60px;"><?php echo htmlspecialchars($blog_data['excerpt'] ?? ''); ?></textarea>
            </div>
            
            <!-- Content -->
            <div class="mb-4">
                <label for="content" class="block text-xs font-semibold text-gray-400 mb-1.5">Content <span class="text-red-400">*</span></label>
                <textarea id="content" name="content" class="auth-textarea <?php echo isset($errors['content']) ? 'error' : ''; ?>" rows="12" placeholder="Write your blog content here..."><?php echo htmlspecialchars($blog_data['content'] ?? ''); ?></textarea>
                <?php if (isset($errors['content'])): ?>
                <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['content']; ?></div>
                <?php endif; ?>
            </div>
            
            <!-- SEO Meta Tags -->
            <div class="mb-4">
                <h4 class="text-sm font-semibold text-gray-400 mb-3">SEO Settings</h4>
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <label for="meta_title" class="block text-xs font-medium text-gray-500 mb-1">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" class="auth-input" placeholder="SEO Title (optional)" value="<?php echo htmlspecialchars($blog_data['meta_title'] ?? ''); ?>">
                    </div>
                    <div>
                        <label for="meta_description" class="block text-xs font-medium text-gray-500 mb-1">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" class="auth-textarea" rows="2" placeholder="Meta description (optional)" style="min-height: 60px;"><?php echo htmlspecialchars($blog_data['meta_description'] ?? ''); ?></textarea>
                    </div>
                    <div>
                        <label for="meta_keywords" class="block text-xs font-medium text-gray-500 mb-1">Meta Keywords</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" class="auth-input" placeholder="keyword1, keyword2, keyword3 (optional)" value="<?php echo htmlspecialchars($blog_data['meta_keywords'] ?? ''); ?>">
                    </div>
                </div>
            </div>
            
            <!-- Status & Featured -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="status" class="block text-xs font-semibold text-gray-400 mb-1.5">Status</label>
                    <select id="status" name="status" class="category-select">
                        <option value="published" <?php echo (isset($blog_data['status']) && $blog_data['status'] === 'published') ? 'selected' : ''; ?>>Published</option>
                        <option value="draft" <?php echo (isset($blog_data['status']) && $blog_data['status'] === 'draft') ? 'selected' : ''; ?>>Draft</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1.5">Featured Post</label>
                    <div class="flex items-center gap-3 pt-1">
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_featured" <?php echo (isset($blog_data['is_featured']) && $blog_data['is_featured'] == 1) ? 'checked' : ''; ?>>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="text-sm text-gray-400">Mark as featured post</span>
                    </div>
                </div>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="btn-primary">
                    <i class='bx bx-save'></i> Update Blog
                </button>
                <button type="submit" name="status" value="draft" class="btn-secondary">
                    <i class='bx bx-file'></i> Save as Draft
                </button>
                <a href="blogs.php" class="btn-secondary">
                    <i class='bx bx-x'></i> Cancel
                </a>
            </div>
            
        </form>
    </div>

</main>

<script>
    // Sidebar Toggle for Mobile
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });

    // Generate slug from title
    function generateSlug(title) {
        const slugInput = document.getElementById('slug');
        if (slugInput.value === '' || slugInput.dataset.auto === 'true') {
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            slugInput.value = slug;
            slugInput.dataset.auto = 'true';
        }
    }

    // Display file name on upload
    function displayFileName(input) {
        const fileName = document.getElementById('file-name');
        if (input.files && input.files.length > 0) {
            fileName.textContent = '📸 ' + input.files[0].name;
            fileName.style.display = 'block';
        }
    }

    // Mark slug as manual if user types
    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.auto = 'false';
    });
</script>

</body>
</html>