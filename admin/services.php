<?php
// ============================================================
// ADMIN/SERVICES.PHP - Admin Services Management
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
// HANDLE CRUD OPERATIONS
// ============================================================

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);

// Handle Add Service
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $service_id = trim($_POST['service_id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $icon = trim($_POST['icon']);
    $category = $_POST['category'];
    $projects = trim($_POST['projects']);
    $satisfaction = trim($_POST['satisfaction']);
    $link = trim($_POST['link']);
    $meta_title = trim($_POST['meta_title']);
    $meta_description = trim($_POST['meta_description']);
    $sort_order = intval($_POST['sort_order']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    $sql = "INSERT INTO services (service_id, title, description, icon, category, projects, satisfaction, link, meta_title, meta_description, sort_order, is_active) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssii", $service_id, $title, $description, $icon, $category, $projects, $satisfaction, $link, $meta_title, $meta_description, $sort_order, $is_active);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Service added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add service: " . $conn->error;
    }
    header('Location: services.php');
    exit();
}

// Handle Update Service
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = intval($_POST['id']);
    $service_id = trim($_POST['service_id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $icon = trim($_POST['icon']);
    $category = $_POST['category'];
    $projects = trim($_POST['projects']);
    $satisfaction = trim($_POST['satisfaction']);
    $link = trim($_POST['link']);
    $meta_title = trim($_POST['meta_title']);
    $meta_description = trim($_POST['meta_description']);
    $sort_order = intval($_POST['sort_order']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    $sql = "UPDATE services SET service_id=?, title=?, description=?, icon=?, category=?, projects=?, satisfaction=?, link=?, meta_title=?, meta_description=?, sort_order=?, is_active=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssiii", $service_id, $title, $description, $icon, $category, $projects, $satisfaction, $link, $meta_title, $meta_description, $sort_order, $is_active, $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Service updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update service: " . $conn->error;
    }
    header('Location: services.php');
    exit();
}

// Handle Delete Service
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Service deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete service: " . $conn->error;
    }
    header('Location: services.php');
    exit();
}

// Handle Toggle Status
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "UPDATE services SET is_active = NOT is_active WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Service status toggled successfully!";
    } else {
        $_SESSION['error'] = "Failed to toggle status: " . $conn->error;
    }
    header('Location: services.php');
    exit();
}

// ============================================================
// GET SERVICES AND STATS
// ============================================================

// Check if services table exists
$table_check = $conn->query("SHOW TABLES LIKE 'services'");
if ($table_check->num_rows == 0) {
    // Create services table if it doesn't exist
    $create_table = "CREATE TABLE IF NOT EXISTS `services` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `service_id` varchar(50) NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` text NOT NULL,
        `icon` varchar(100) NOT NULL,
        `category` enum('seo','development','marketing') NOT NULL,
        `projects` varchar(50) DEFAULT NULL,
        `satisfaction` varchar(50) DEFAULT NULL,
        `link` varchar(255) NOT NULL,
        `meta_title` varchar(255) DEFAULT NULL,
        `meta_description` text DEFAULT NULL,
        `sort_order` int(11) DEFAULT 0,
        `is_active` tinyint(1) DEFAULT 1,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_service_id` (`service_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($create_table)) {
        // Insert sample data
        $insert_sample = "INSERT IGNORE INTO `services` (`service_id`, `title`, `description`, `icon`, `category`, `projects`, `satisfaction`, `link`, `sort_order`) VALUES
        ('onpage-seo', 'On-Page SEO', 'Optimize your website content, meta tags, and structure to improve search engine rankings and user experience.', 'bx bx-page', 'seo', '150+', '96%', 'onpage-seo.php', 1),
        ('offpage-seo', 'Off-Page SEO', 'Build authority and credibility through strategic link building, guest posting, and online reputation management.', 'bx bx-link-external', 'seo', '120+', '95%', 'offpage-seo.php', 2),
        ('technical-seo', 'Technical SEO', 'Ensure your website is technically sound with proper indexing, site speed optimization, and mobile responsiveness.', 'bx bx-cog', 'seo', '100+', '98%', 'technical-seo.php', 3)";
        $conn->query($insert_sample);
    }
}

// Get all services
$services_query = "SELECT * FROM services ORDER BY sort_order ASC, id ASC";
$services_result = $conn->query($services_query);

// Check if query failed
if (!$services_result) {
    $error = "Database error: " . $conn->error;
    $services_result = null;
}

// Get service stats
$stats_query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN category = 'seo' THEN 1 ELSE 0 END) as seo_count,
                    SUM(CASE WHEN category = 'development' THEN 1 ELSE 0 END) as dev_count,
                    SUM(CASE WHEN category = 'marketing' THEN 1 ELSE 0 END) as marketing_count,
                    SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_count,
                    SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as inactive_count
                FROM services";
$stats_result = $conn->query($stats_query);
$stats = $stats_result ? $stats_result->fetch_assoc() : ['total' => 0, 'seo_count' => 0, 'dev_count' => 0, 'marketing_count' => 0, 'active_count' => 0, 'inactive_count' => 0];

// Display messages
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Manage Services — 4 Digi Sol</title>
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
        
        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(4px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-content {
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            max-width: 800px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            padding: 2rem;
        }
        .modal-content::-webkit-scrollbar {
            width: 6px;
        }
        .modal-content::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
            border-radius: 3px;
        }
        .modal-content::-webkit-scrollbar-thumb {
            background: rgba(166,241,59,0.3);
            border-radius: 3px;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #aaa;
            margin-bottom: 0.25rem;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            background: #0a0a0a;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 8px;
            padding: 0.6rem 0.8rem;
            color: #fff;
            font-size: 0.9rem;
            transition: border-color 0.3s;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: rgba(166,241,59,0.5);
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
        
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .badge-active {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
        }
        .badge-inactive {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }
        .badge-seo {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
        }
        .badge-development {
            background: rgba(168, 85, 247, 0.2);
            color: #a855f7;
        }
        .badge-marketing {
            background: rgba(236, 72, 153, 0.2);
            color: #ec4899;
        }
        
        .service-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(166,241,59,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #A6F13B;
        }

        /* Topbar styles */
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
        
        .stat-card {
            background: #0f0f0f;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 1rem;
        }
        
        .table-card {
            background: #0f0f0f;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 1.5rem;
            overflow-x: auto;
        }
        .table-card table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-card th {
            text-align: left;
            font-size: 0.7rem;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .table-card td {
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.03);
            font-size: 0.875rem;
            vertical-align: middle;
        }
        .table-card tr:last-child td {
            border-bottom: none;
        }
        .table-card tr:hover td {
            background: rgba(255,255,255,0.02);
        }
        
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: #fff;
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
        
        /* Sidebar styles */
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
        <a href="blogs.php" class="sidebar-link <?php echo $currentPage == 'blogs.php' ? 'active' : ''; ?>">
            <i class='bx bx-news'></i> Blogs
        </a>
        <a href="services.php" class="sidebar-link <?php echo $currentPage == 'services.php' ? 'active' : ''; ?>">
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

<!-- ============ TOPBAR ============ -->
<header class="topbar">
    <div class="flex items-center gap-3">
        <button class="mobile-toggle" id="sidebarToggle">
            <i class='bx bx-menu'></i>
        </button>
        <h1 class="text-lg font-semibold">Manage Services</h1>
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

    <!-- Messages -->
    <?php if ($success): ?>
        <div class="bg-green-600/20 border border-green-600/30 text-green-400 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
            <span><i class='bx bx-check-circle'></i> <?php echo htmlspecialchars($success); ?></span>
            <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-300"><i class='bx bx-x'></i></button>
        </div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="bg-red-600/20 border border-red-600/30 text-red-400 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
            <span><i class='bx bx-error-circle'></i> <?php echo htmlspecialchars($error); ?></span>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-300"><i class='bx bx-x'></i></button>
        </div>
    <?php endif; ?>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
        <div class="stat-card">
            <p class="text-xs text-gray-400">Total</p>
            <p class="text-2xl font-bold"><?php echo $stats['total'] ?? 0; ?></p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-400">Active</p>
            <p class="text-2xl font-bold text-green-400"><?php echo $stats['active_count'] ?? 0; ?></p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-400">Inactive</p>
            <p class="text-2xl font-bold text-red-400"><?php echo $stats['inactive_count'] ?? 0; ?></p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-400">SEO</p>
            <p class="text-2xl font-bold text-blue-400"><?php echo $stats['seo_count'] ?? 0; ?></p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-400">Development</p>
            <p class="text-2xl font-bold text-purple-400"><?php echo $stats['dev_count'] ?? 0; ?></p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-400">Marketing</p>
            <p class="text-2xl font-bold text-pink-400"><?php echo $stats['marketing_count'] ?? 0; ?></p>
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div class="flex flex-wrap gap-2">
            <button onclick="openAddModal()" class="bg-lime text-[#101010] font-semibold rounded-full px-5 py-2 hover:brightness-95 transition text-sm">
                <i class='bx bx-plus'></i> Add New Service
            </button>
            <a href="services.php" class="bg-white/10 text-white font-semibold rounded-full px-5 py-2 hover:bg-white/20 transition text-sm">
                <i class='bx bx-refresh'></i> Refresh
            </a>
        </div>
        <div class="text-sm text-gray-400">
            Showing <?php echo $services_result ? $services_result->num_rows : 0; ?> services
        </div>
    </div>

    <!-- Services Table -->
    <div class="table-card">
        <?php if ($services_result && $services_result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Category</th>
                        <th>Projects</th>
                        <th>Status</th>
                        <th>Sort</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    <?php while ($service = $services_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="service-icon">
                                        <i class='<?php echo htmlspecialchars($service['icon'] ?? 'bx bx-cube'); ?>'></i>
                                    </div>
                                    <div>
                                        <div class="font-medium"><?php echo htmlspecialchars($service['title']); ?></div>
                                        <div class="text-xs text-gray-500"><?php echo htmlspecialchars($service['service_id']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo $service['category']; ?>">
                                    <?php echo ucfirst($service['category']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($service['projects'] ?? '-'); ?></td>
                            <td>
                                <span class="badge <?php echo $service['is_active'] ? 'badge-active' : 'badge-inactive'; ?>">
                                    <?php echo $service['is_active'] ? 'Active' : 'Inactive'; ?>
                                </span>
                            </td>
                            <td><?php echo $service['sort_order']; ?></td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="edit-service.php?id=<?php echo $service['service_id']; ?>" class="text-blue-400 hover:text-blue-300 transition" title="Edit">
                                        <i class='bx bx-edit text-lg'></i>
                                    </a>
                                    <a href="?action=toggle&id=<?php echo $service['id']; ?>" onclick="return confirm('Toggle status for this service?')" class="text-yellow-400 hover:text-yellow-300 transition" title="Toggle Status">
                                        <i class='bx bx-power-off text-lg'></i>
                                    </a>
                                    <a href="?action=delete&id=<?php echo $service['id']; ?>" onclick="return confirm('Delete this service permanently?')" class="text-red-400 hover:text-red-300 transition" title="Delete">
                                        <i class='bx bx-trash text-lg'></i>
                                    </a>
                                    <a href="../service-details.php?id=<?php echo htmlspecialchars($service['service_id']); ?>" target="_blank" class="text-lime hover:text-lime/80 transition" title="View">
                                        <i class='bx bx-link-external text-lg'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="text-center py-8 text-gray-400">
                <div class="text-4xl mb-2">📂</div>
                <p>No services found. Click "Add New Service" to create one.</p>
                <?php if (isset($error)): ?>
                    <p class="text-red-400 text-sm mt-2"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quick Tips -->
    <div class="mt-6 bg-[#0f0f0f] border border-white/5 rounded-xl p-4">
        <h4 class="font-semibold text-sm mb-2">💡 Quick Tips</h4>
        <ul class="text-xs text-gray-400 space-y-1">
            <li>• <strong>Service ID</strong> - Unique identifier (e.g., onpage-seo). Use lowercase and hyphens.</li>
            <li>• <strong>Icon</strong> - Use Boxicons class (e.g., bx bx-page). Browse icons at <a href="https://boxicons.com" target="_blank" class="text-lime hover:underline">boxicons.com</a></li>
            <li>• <strong>Sort Order</strong> - Lower numbers appear first in the list.</li>
            <li>• <strong>Status</strong> - Inactive services won't show on the frontend.</li>
        </ul>
    </div>

</main>

<!-- ============ ADD MODAL ============ -->
<div class="modal-overlay" id="addModal">
    <div class="modal-content">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Add New Service</h2>
            <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-white text-2xl">&times;</button>
        </div>
        
        <form method="POST" action="">
            <input type="hidden" name="action" value="add">
            
            <div class="form-row">
                <div class="form-group">
                    <label>Service ID *</label>
                    <input type="text" name="service_id" required placeholder="e.g., onpage-seo">
                </div>
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" required placeholder="e.g., On-Page SEO">
                </div>
            </div>
            
            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" required placeholder="Describe your service..."></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Icon Class</label>
                    <input type="text" name="icon" value="bx bx-cube" placeholder="e.g., bx bx-page">
                </div>
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" required>
                        <option value="seo">SEO</option>
                        <option value="development">Development</option>
                        <option value="marketing">Marketing</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Projects</label>
                    <input type="text" name="projects" placeholder="e.g., 150+">
                </div>
                <div class="form-group">
                    <label>Satisfaction</label>
                    <input type="text" name="satisfaction" placeholder="e.g., 96%">
                </div>
            </div>
            
            <div class="form-group">
                <label>Link *</label>
                <input type="text" name="link" required placeholder="e.g., onpage-seo.php">
            </div>
            
            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title" placeholder="SEO title for this service">
            </div>
            
            <div class="form-group">
                <label>Meta Description</label>
                <textarea name="meta_description" placeholder="SEO description for this service"></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="0">
                </div>
                <div class="form-group flex items-center gap-3 pt-6">
                    <input type="checkbox" name="is_active" id="add_active" checked class="w-4 h-4 accent-lime">
                    <label for="add_active" class="text-sm text-gray-400">Active</label>
                </div>
            </div>
            
            <div class="flex gap-3 mt-4">
                <button type="submit" class="bg-lime text-[#101010] font-semibold rounded-full px-6 py-2 hover:brightness-95 transition">
                    Add Service
                </button>
                <button type="button" onclick="closeModal('addModal')" class="bg-white/10 text-white font-semibold rounded-full px-6 py-2 hover:bg-white/20 transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============ MOBILE SIDEBAR OVERLAY ============ -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden" onclick="closeSidebar()"></div>

<script>
    // Sidebar Toggle
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

    // Modal Functions
    function openAddModal() {
        document.getElementById('addModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close modals on overlay click    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Close sidebar on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });
</script>

</body>
</html>