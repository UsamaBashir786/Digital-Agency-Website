<?php
// ============================================================
// ADMIN/BLOGS.PHP - Manage Blog Posts (With Sidebar Embedded)
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
// GET COUNTS FOR SIDEBAR
// ============================================================

// Get unread contacts count
$unread_count = 0;
if (isset($conn)) {
    $unread_query = "SELECT COUNT(*) as total FROM contacts WHERE status = 'unread'";
    $unread_result = $conn->query($unread_query);
    if ($unread_result) {
        $unread_count = $unread_result->fetch_assoc()['total'] ?? 0;
    }
}

// Get total users count
$total_users = 0;
if (isset($conn)) {
    $users_query = "SELECT COUNT(*) as total FROM users";
    $users_result = $conn->query($users_query);
    if ($users_result) {
        $total_users = $users_result->fetch_assoc()['total'] ?? 0;
    }
}

// Get total blogs count
$total_blogs_sidebar = 0;
if (isset($conn)) {
    $blogs_query = "SELECT COUNT(*) as total FROM blogs";
    $blogs_result = $conn->query($blogs_query);
    if ($blogs_result) {
        $total_blogs_sidebar = $blogs_result->fetch_assoc()['total'] ?? 0;
    }
}

// Get total services count
$total_services = 0;
if (isset($conn)) {
    $services_query = "SELECT COUNT(*) as total FROM services";
    $services_result = $conn->query($services_query);
    if ($services_result) {
        $total_services = $services_result->fetch_assoc()['total'] ?? 0;
    }
}

// ============================================================
// HANDLE BLOG ACTIONS
// ============================================================

$action_message = '';
$action_type = '';

// Delete blog
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $blog_id = intval($_GET['delete']);
    
    // Get image path to delete
    $img_sql = "SELECT featured_image FROM blogs WHERE id = ?";
    $img_stmt = $conn->prepare($img_sql);
    $img_stmt->bind_param("i", $blog_id);
    $img_stmt->execute();
    $img_result = $img_stmt->get_result();
    $blog_img = $img_result->fetch_assoc();
    
    if ($blog_img && !empty($blog_img['featured_image'])) {
        $image_path = '../uploads/blogs/' . $blog_img['featured_image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    $img_stmt->close();
    
    $delete_sql = "DELETE FROM blogs WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $blog_id);
    
    if ($delete_stmt->execute()) {
        $action_message = 'Blog post deleted successfully.';
        $action_type = 'success';
    } else {
        $action_message = 'Failed to delete blog post.';
        $action_type = 'error';
    }
    $delete_stmt->close();
}

// Toggle featured status
if (isset($_GET['toggle_featured']) && is_numeric($_GET['toggle_featured'])) {
    $blog_id = intval($_GET['toggle_featured']);
    
    $toggle_sql = "UPDATE blogs SET is_featured = NOT is_featured WHERE id = ?";
    $toggle_stmt = $conn->prepare($toggle_sql);
    $toggle_stmt->bind_param("i", $blog_id);
    
    if ($toggle_stmt->execute()) {
        $action_message = 'Featured status updated successfully.';
        $action_type = 'success';
    } else {
        $action_message = 'Failed to update featured status.';
        $action_type = 'error';
    }
    $toggle_stmt->close();
}

// Toggle status (draft/published)
if (isset($_GET['toggle_status']) && is_numeric($_GET['toggle_status'])) {
    $blog_id = intval($_GET['toggle_status']);
    
    $toggle_sql = "UPDATE blogs SET status = IF(status = 'published', 'draft', 'published') WHERE id = ?";
    $toggle_stmt = $conn->prepare($toggle_sql);
    $toggle_stmt->bind_param("i", $blog_id);
    
    if ($toggle_stmt->execute()) {
        $action_message = 'Blog status updated successfully.';
        $action_type = 'success';
    } else {
        $action_message = 'Failed to update blog status.';
        $action_type = 'error';
    }
    $toggle_stmt->close();
}

// ============================================================
// GET ALL BLOGS
// ============================================================

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT * FROM blogs WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " AND (title LIKE ? OR content LIKE ? OR author LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

if (!empty($category_filter)) {
    $sql .= " AND category = ?";
    $params[] = $category_filter;
    $types .= "s";
}

if (!empty($status_filter)) {
    $sql .= " AND status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$blogs_result = $stmt->get_result();

// Get counts
$total_query = "SELECT COUNT(*) as total FROM blogs";
$total_result = $conn->query($total_query);
if ($total_result) {
    $total_blogs = $total_result->fetch_assoc()['total'] ?? 0;
} else {
    $total_blogs = 0;
}

$published_query = "SELECT COUNT(*) as total FROM blogs WHERE status = 'published'";
$published_result = $conn->query($published_query);
if ($published_result) {
    $published_count = $published_result->fetch_assoc()['total'] ?? 0;
} else {
    $published_count = 0;
}

$draft_query = "SELECT COUNT(*) as total FROM blogs WHERE status = 'draft'";
$draft_result = $conn->query($draft_query);
if ($draft_result) {
    $draft_count = $draft_result->fetch_assoc()['total'] ?? 0;
} else {
    $draft_count = 0;
}

// Get featured count
$featured_query = "SELECT COUNT(*) as total FROM blogs WHERE is_featured = 1";
$featured_result = $conn->query($featured_query);
if ($featured_result) {
    $featured_count = $featured_result->fetch_assoc()['total'] ?? 0;
} else {
    $featured_count = 0;
}

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Manage Blogs — 4 Digi Sol</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #0a0a0a;
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        /* Sidebar Styles */
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
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
        }

        /* Topbar Styles */
        .topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 260px;
            height: 70px;
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 50;
        }
        @media (max-width: 768px) {
            .topbar {
                left: 0;
            }
        }
        
        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
        }
        
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }
        }
        
        .lime {
            color: #A6F13B;
        }
        .bg-lime {
            background-color: #A6F13B;
        }
        .text-lime {
            color: #A6F13B;
        }
        .border-lime {
            border-color: #A6F13B;
        }
        .accent-lime {
            accent-color: #A6F13B;
        }

        /* Table Styles */
        .table-card {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 1.5rem;
            padding: 1.5rem;
            overflow: hidden;
        }
        .table-card table { width: 100%; border-collapse: collapse; }
        .table-card th {
            text-align: left;
            padding: 0.75rem 1rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #888;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            font-weight: 600;
        }
        .table-card td {
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            color: #d0d0d0;
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }
        .table-card tr:last-child td { border-bottom: none; }
        .table-card tr:hover td { background: rgba(255,255,255,0.02); }
        
        .badge {
            padding: 0.2rem 0.7rem;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 600;
        }
        .badge-published { background: rgba(52, 211, 153, 0.15); color: #34d399; }
        .badge-draft { background: rgba(251, 191, 36, 0.15); color: #fbbf24; }
        .badge-featured { background: rgba(166, 241, 59, 0.15); color: #A6F13B; }
        
        .auth-input {
            background: #1a1a1a;
            border: 2px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 0.6rem 1rem;
            color: #ffffff;
            font-size: 0.85rem;
            transition: border-color 0.2s;
            width: 100%;
            max-width: 300px;
        }
        .auth-input:focus { border-color: #A6F13B; outline: none; box-shadow: 0 0 0 3px rgba(166, 241, 59, 0.1); }
        .auth-input::placeholder { color: #666; }
        
        .btn-sm {
            padding: 0.3rem 0.8rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-sm-primary { background: rgba(166, 241, 59, 0.15); color: #A6F13B; }
        .btn-sm-primary:hover { background: rgba(166, 241, 59, 0.25); }
        .btn-sm-danger { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
        .btn-sm-danger:hover { background: rgba(239, 68, 68, 0.25); }
        .btn-sm-success { background: rgba(52, 211, 153, 0.15); color: #34d399; }
        .btn-sm-success:hover { background: rgba(52, 211, 153, 0.25); }
        .btn-sm-secondary { background: rgba(255,255,255,0.06); color: #b0b0b0; }
        .btn-sm-secondary:hover { background: rgba(255,255,255,0.12); }
        
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
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 8px;
            padding: 0.2rem 0.5rem;
            color: #ffffff;
            font-size: 0.75rem;
            cursor: pointer;
        }
        .category-select:focus { outline: none; border-color: #A6F13B; }
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
        <!-- Dashboard -->
        <a href="index.php" class="sidebar-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">
            <i class='bx bx-grid-alt'></i> Dashboard
        </a>
        
        <!-- Users -->
        <a href="users.php" class="sidebar-link <?php echo $currentPage == 'users.php' ? 'active' : ''; ?>">
            <i class='bx bx-user'></i> Users
            <?php if ($total_users > 0): ?>
            <span class="ml-auto text-xs text-gray-500"><?php echo $total_users; ?></span>
            <?php endif; ?>
        </a>
        
        <!-- Contacts -->
        <a href="contacts.php" class="sidebar-link <?php echo $currentPage == 'contacts.php' ? 'active' : ''; ?>">
            <i class='bx bx-envelope'></i> Contacts
            <?php if ($unread_count > 0): ?>
            <span class="ml-auto bg-lime text-[#101010] text-[10px] font-bold px-2 py-0.5 rounded-full"><?php echo $unread_count; ?></span>
            <?php endif; ?>
        </a>
        
        <!-- Blogs -->
        <a href="blogs.php" class="sidebar-link <?php echo $currentPage == 'blogs.php' || $currentPage == 'blog-add.php' || $currentPage == 'blog-edit.php' ? 'active' : ''; ?>">
            <i class='bx bx-news'></i> Blogs
            <?php if ($total_blogs_sidebar > 0): ?>
            <span class="ml-auto text-xs text-gray-500"><?php echo $total_blogs_sidebar; ?></span>
            <?php endif; ?>
        </a>
        
        <!-- Services -->
        <a href="services.php" class="sidebar-link <?php echo $currentPage == 'services.php' || $currentPage == 'edit-service.php' ? 'active' : ''; ?>">
            <i class='bx bx-briefcase'></i> Services
            <?php if ($total_services > 0): ?>
            <span class="ml-auto text-xs text-gray-500"><?php echo $total_services; ?></span>
            <?php endif; ?>
        </a>
        
        <div class="sidebar-divider"></div>
        
        <!-- Settings -->
        <a href="settings.php" class="sidebar-link <?php echo $currentPage == 'settings.php' ? 'active' : ''; ?>">
            <i class='bx bx-cog'></i> Settings
        </a>
        
        <div class="sidebar-divider"></div>
        
        <!-- View Site -->
        <a href="../index.php" class="sidebar-link">
            <i class='bx bx-home'></i> View Site
        </a>
        
        <!-- Logout -->
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
        <h1 class="text-lg font-semibold">Manage Blogs</h1>
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
            <h2 class="text-2xl font-bold">Blog Posts</h2>
            <p class="text-gray-400 text-sm">Manage all blog posts</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500">Total: <?php echo $total_blogs; ?></span>
            <span class="text-sm text-green-400">Published: <?php echo $published_count; ?></span>
            <span class="text-sm text-yellow-400">Draft: <?php echo $draft_count; ?></span>
            <?php if ($featured_count > 0): ?>
            <span class="text-sm text-lime">Featured: <?php echo $featured_count; ?></span>
            <?php endif; ?>
            <a href="blog-add.php" class="bg-lime text-[#101010] font-semibold rounded-lg px-4 py-2 text-sm hover:brightness-95 transition whitespace-nowrap">
                <i class='bx bx-plus'></i> Add New
            </a>
        </div>
    </div>

    <!-- Message Display -->
    <?php if ($action_message): ?>
    <div class="<?php echo $action_type === 'success' ? 'success-message' : 'error-message'; ?>">
        <i class='bx <?php echo $action_type === 'success' ? 'bx-check-circle' : 'bx-error-circle'; ?>'></i>
        <?php echo $action_message; ?>
    </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="table-card mb-6">
        <div class="flex flex-wrap items-center gap-4">
            <form method="GET" action="" class="flex flex-wrap items-center gap-3 flex-1">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" class="auth-input" placeholder="Search by title, author..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div>
                    <select name="category" class="category-select" style="padding: 0.6rem 1rem;">
                        <option value="">All Categories</option>
                        <option value="SEO" <?php echo $category_filter === 'SEO' ? 'selected' : ''; ?>>SEO</option>
                        <option value="Local SEO" <?php echo $category_filter === 'Local SEO' ? 'selected' : ''; ?>>Local SEO</option>
                        <option value="E-Commerce SEO" <?php echo $category_filter === 'E-Commerce SEO' ? 'selected' : ''; ?>>E-Commerce SEO</option>
                        <option value="Content SEO" <?php echo $category_filter === 'Content SEO' ? 'selected' : ''; ?>>Content SEO</option>
                        <option value="Technical SEO" <?php echo $category_filter === 'Technical SEO' ? 'selected' : ''; ?>>Technical SEO</option>
                        <option value="Web Development" <?php echo $category_filter === 'Web Development' ? 'selected' : ''; ?>>Web Development</option>
                        <option value="Digital Marketing" <?php echo $category_filter === 'Digital Marketing' ? 'selected' : ''; ?>>Digital Marketing</option>
                        <option value="Branding" <?php echo $category_filter === 'Branding' ? 'selected' : ''; ?>>Branding</option>
                        <option value="Web Design" <?php echo $category_filter === 'Web Design' ? 'selected' : ''; ?>>Web Design</option>
                    </select>
                </div>
                <div>
                    <select name="status" class="category-select" style="padding: 0.6rem 1rem;">
                        <option value="">All Status</option>
                        <option value="published" <?php echo $status_filter === 'published' ? 'selected' : ''; ?>>Published</option>
                        <option value="draft" <?php echo $status_filter === 'draft' ? 'selected' : ''; ?>>Draft</option>
                    </select>
                </div>
                <button type="submit" class="btn-sm btn-sm-primary" style="padding: 0.6rem 1.2rem;">Filter</button>
                <a href="blogs.php" class="btn-sm btn-sm-secondary" style="padding: 0.6rem 1.2rem; text-decoration: none;">Reset</a>
            </form>
        </div>
    </div>

    <!-- Blogs Table -->
    <div class="table-card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Views</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($blogs_result && $blogs_result->num_rows > 0): ?>
                        <?php while ($blog = $blogs_result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-xs text-gray-500"><?php echo $blog['id']; ?></td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <?php if (!empty($blog['featured_image'])): ?>
                                    <img src="../uploads/blogs/<?php echo $blog['featured_image']; ?>" class="w-10 h-10 rounded object-cover" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                                    <?php else: ?>
                                    <div class="w-10 h-10 rounded bg-lime/10 flex items-center justify-center text-lime">
                                        <i class='bx bx-image'></i>
                                    </div>
                                    <?php endif; ?>
                                    <span class="font-medium text-sm"><?php echo htmlspecialchars(substr($blog['title'], 0, 40)) . (strlen($blog['title']) > 40 ? '...' : ''); ?></span>
                                </div>
                            </td>
                            <td><span class="text-xs"><?php echo htmlspecialchars($blog['category']); ?></span></td>
                            <td><?php echo htmlspecialchars($blog['author']); ?></td>
                            <td>
                                <span class="badge <?php echo $blog['status'] === 'published' ? 'badge-published' : 'badge-draft'; ?>">
                                    <?php echo ucfirst($blog['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($blog['is_featured']): ?>
                                <span class="badge badge-featured">Featured</span>
                                <?php else: ?>
                                <span class="text-xs text-gray-500">No</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-xs text-gray-500"><?php echo number_format($blog['views']); ?></td>
                            <td class="text-xs text-gray-500"><?php echo date('M d, Y', strtotime($blog['created_at'])); ?></td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <a href="blog-edit.php?id=<?php echo $blog['id']; ?>" class="btn-sm btn-sm-primary" title="Edit">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                    <a href="blog-preview.php?id=<?php echo $blog['id']; ?>" class="btn-sm btn-sm-success" title="Preview" target="_blank">
                                        <i class='bx bx-show'></i>
                                    </a>
                                    <a href="blogs.php?toggle_featured=<?php echo $blog['id']; ?>" class="btn-sm btn-sm-secondary" title="Toggle Featured">
                                        <i class='bx bx-star <?php echo $blog['is_featured'] ? 'text-lime' : ''; ?>'></i>
                                    </a>
                                    <a href="blogs.php?toggle_status=<?php echo $blog['id']; ?>" class="btn-sm btn-sm-secondary" title="Toggle Status">
                                        <i class='bx bx-cloud-upload <?php echo $blog['status'] === 'published' ? 'text-green-400' : 'text-yellow-400'; ?>'></i>
                                    </a>
                                    <a href="blogs.php?delete=<?php echo $blog['id']; ?>" class="btn-sm btn-sm-danger" title="Delete" onclick="return confirm('Delete this blog post?')">
                                        <i class='bx bx-trash'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-gray-500 py-4">
                                <i class='bx bx-news text-2xl block mb-2'></i>
                                No blog posts found. Click "Add New" to create one.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<!-- ============ SIDEBAR JAVASCRIPT ============ -->
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

    // Close sidebar when clicking overlay
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    // Close sidebar on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });

    // Auto-close on window resize (desktop)
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });
</script>

</body>
</html>