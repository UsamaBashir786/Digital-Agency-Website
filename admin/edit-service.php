<?php
// ============================================================
// ADMIN/EDIT-SERVICE.PHP - Edit Service
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
// GET SERVICE DATA
// ============================================================

$service = null;
$service_id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($service_id)) {
    $_SESSION['error'] = "No service ID provided.";
    header('Location: services.php');
    exit();
}

// Fetch service details
$sql = "SELECT * FROM services WHERE service_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $service_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $service = $result->fetch_assoc();
} else {
    $_SESSION['error'] = "Service not found.";
    header('Location: services.php');
    exit();
}

// ============================================================
// HANDLE UPDATE
// ============================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
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
    
    $sql = "UPDATE services SET 
                service_id = ?,
                title = ?,
                description = ?,
                icon = ?,
                category = ?,
                projects = ?,
                satisfaction = ?,
                link = ?,
                meta_title = ?,
                meta_description = ?,
                sort_order = ?,
                is_active = ?
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssiii", 
        $service_id, 
        $title, 
        $description, 
        $icon, 
        $category, 
        $projects, 
        $satisfaction, 
        $link, 
        $meta_title, 
        $meta_description, 
        $sort_order, 
        $is_active, 
        $id
    );
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Service updated successfully!";
        // Refresh service data
        $sql = "SELECT * FROM services WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $service = $result->fetch_assoc();
    } else {
        $_SESSION['error'] = "Failed to update service: " . $conn->error;
        header('Location: edit-service.php?id=' . $service_id);
        exit();
    }
}

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);

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
    <title>Edit Service — 4 Digi Sol</title>
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
        
        .form-group {
            margin-bottom: 1.25rem;
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
            padding: 0.7rem 0.9rem;
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
            min-height: 100px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
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
        
        .preview-card {
            background: #0f0f0f;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }
        .preview-card .service-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(166,241,59,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #A6F13B;
        }
        
        .icon-suggestion {
            display: inline-block;
            background: rgba(255,255,255,0.05);
            padding: 0.2rem 0.6rem;
            border-radius: 4px;
            font-size: 0.7rem;
            color: #888;
            margin: 0.2rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        .icon-suggestion:hover {
            background: rgba(166,241,59,0.15);
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
        <h1 class="text-lg font-semibold">Edit Service</h1>
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

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
        <a href="index.php" class="hover:text-lime transition">Dashboard</a>
        <i class='bx bx-chevron-right text-xs'></i>
        <a href="services.php" class="hover:text-lime transition">Services</a>
        <i class='bx bx-chevron-right text-xs'></i>
        <span class="text-lime">Edit Service</span>
    </div>

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

    <!-- Edit Form -->
    <div class="bg-[#0f0f0f] border border-white/5 rounded-2xl p-6">
        <form method="POST" action="">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($service['id'] ?? ''); ?>">
            
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold"><?php echo htmlspecialchars($service['title'] ?? 'Edit Service'); ?></h2>
                <div>
                    <span class="badge <?php echo ($service['is_active'] ?? 0) ? 'badge-active' : 'badge-inactive'; ?>">
                        <?php echo ($service['is_active'] ?? 0) ? 'Active' : 'Inactive'; ?>
                    </span>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Service ID *</label>
                    <input type="text" name="service_id" value="<?php echo htmlspecialchars($service['service_id'] ?? ''); ?>" required>
                    <small class="text-xs text-gray-500">Unique identifier. Use lowercase and hyphens.</small>
                </div>
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($service['title'] ?? ''); ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" required><?php echo htmlspecialchars($service['description'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Icon Class</label>
                    <input type="text" name="icon" id="iconInput" value="<?php echo htmlspecialchars($service['icon'] ?? 'bx bx-cube'); ?>" placeholder="e.g., bx bx-page">
                    <div class="mt-2">
                        <small class="text-xs text-gray-500">Popular icons:</small>
                        <div class="flex flex-wrap gap-1 mt-1">
                            <span class="icon-suggestion" onclick="setIcon('bx bx-page')">bx bx-page</span>
                            <span class="icon-suggestion" onclick="setIcon('bx bx-link-external')">bx bx-link-external</span>
                            <span class="icon-suggestion" onclick="setIcon('bx bx-cog')">bx bx-cog</span>
                            <span class="icon-suggestion" onclick="setIcon('bx bx-map')">bx bx-map</span>
                            <span class="icon-suggestion" onclick="setIcon('bx bx-cart')">bx bx-cart</span>
                            <span class="icon-suggestion" onclick="setIcon('bx bx-bot')">bx bx-bot</span>
                            <span class="icon-suggestion" onclick="setIcon('bx bx-code-alt')">bx bx-code-alt</span>
                            <span class="icon-suggestion" onclick="setIcon('bx bx-brain')">bx bx-brain</span>
                            <span class="icon-suggestion" onclick="setIcon('bx bx-briefcase')">bx bx-briefcase</span>
                            <span class="icon-suggestion" onclick="setIcon('bx bx-cube')">bx bx-cube</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" required>
                        <option value="seo" <?php echo ($service['category'] ?? '') == 'seo' ? 'selected' : ''; ?>>SEO</option>
                        <option value="development" <?php echo ($service['category'] ?? '') == 'development' ? 'selected' : ''; ?>>Development</option>
                        <option value="marketing" <?php echo ($service['category'] ?? '') == 'marketing' ? 'selected' : ''; ?>>Marketing</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Projects</label>
                    <input type="text" name="projects" value="<?php echo htmlspecialchars($service['projects'] ?? ''); ?>" placeholder="e.g., 150+">
                </div>
                <div class="form-group">
                    <label>Satisfaction</label>
                    <input type="text" name="satisfaction" value="<?php echo htmlspecialchars($service['satisfaction'] ?? ''); ?>" placeholder="e.g., 96%">
                </div>
            </div>
            
            <div class="form-group">
                <label>Link *</label>
                <input type="text" name="link" value="<?php echo htmlspecialchars($service['link'] ?? ''); ?>" required placeholder="e.g., onpage-seo.php">
                <small class="text-xs text-gray-500">The page URL for this service.</small>
            </div>
            
            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title" value="<?php echo htmlspecialchars($service['meta_title'] ?? ''); ?>" placeholder="SEO title for this service">
                <small class="text-xs text-gray-500">Recommended: 50-60 characters</small>
            </div>
            
            <div class="form-group">
                <label>Meta Description</label>
                <textarea name="meta_description" placeholder="SEO description for this service"><?php echo htmlspecialchars($service['meta_description'] ?? ''); ?></textarea>
                <small class="text-xs text-gray-500">Recommended: 150-160 characters</small>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="<?php echo $service['sort_order'] ?? 0; ?>">
                    <small class="text-xs text-gray-500">Lower numbers appear first.</small>
                </div>
                <div class="form-group flex items-center gap-3 pt-6">
                    <input type="checkbox" name="is_active" id="is_active" <?php echo ($service['is_active'] ?? 0) ? 'checked' : ''; ?> class="w-4 h-4 accent-lime">
                    <label for="is_active" class="text-sm text-gray-400">Active</label>
                    <span class="text-xs text-gray-500 ml-2">Inactive services won't show on the frontend.</span>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-3 mt-6 pt-4 border-t border-white/5">
                <button type="submit" class="bg-lime text-[#101010] font-semibold rounded-full px-8 py-2.5 hover:brightness-95 transition">
                    <i class='bx bx-save'></i> Update Service
                </button>
                <a href="services.php" class="bg-white/10 text-white font-semibold rounded-full px-8 py-2.5 hover:bg-white/20 transition">
                    Cancel
                </a>
                <a href="../service-details.php?id=<?php echo htmlspecialchars($service['service_id'] ?? ''); ?>" target="_blank" class="bg-blue-600/20 text-blue-400 font-semibold rounded-full px-8 py-2.5 hover:bg-blue-600/30 transition ml-auto">
                    <i class='bx bx-show'></i> View on Site
                </a>
            </div>
        </form>
    </div>

    <!-- Preview Section -->
    <div class="preview-card">
        <h4 class="font-semibold text-sm mb-3">Live Preview</h4>
        <div class="flex items-start gap-4">
            <div class="service-icon">
                <i class='<?php echo htmlspecialchars($service['icon'] ?? 'bx bx-cube'); ?>' id="previewIcon"></i>
            </div>
            <div>
                <h5 class="font-bold text-lg" id="previewTitle"><?php echo htmlspecialchars($service['title'] ?? 'Untitled Service'); ?></h5>
                <p class="text-gray-400 text-sm mt-1" id="previewDescription">
                    <?php 
                    $desc = $service['description'] ?? 'No description available.';
                    echo htmlspecialchars(substr($desc, 0, 150)) . (strlen($desc) > 150 ? '...' : ''); 
                    ?>
                </p>
                <div class="flex items-center gap-4 mt-2 text-xs">
                    <?php if (!empty($service['projects'])): ?>
                        <span class="text-gray-400"><span class="text-lime font-bold"><?php echo htmlspecialchars($service['projects']); ?></span> Projects</span>
                    <?php endif; ?>
                    <?php if (!empty($service['satisfaction'])): ?>
                        <span class="text-gray-400"><span class="text-lime font-bold"><?php echo htmlspecialchars($service['satisfaction']); ?></span> Satisfaction</span>
                    <?php endif; ?>
                    <span class="text-gray-400">Category: <span class="text-lime"><?php echo ucfirst($service['category'] ?? 'General'); ?></span></span>
                </div>
            </div>
        </div>
    </div>

</main>

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

    // Close sidebar on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });

    // Set icon function
    function setIcon(iconClass) {
        document.getElementById('iconInput').value = iconClass;
        document.getElementById('previewIcon').className = iconClass;
    }

    // Live preview update for icon
    document.getElementById('iconInput').addEventListener('input', function() {
        document.getElementById('previewIcon').className = this.value || 'bx bx-cube';
    });

    // Live preview update for title
    document.querySelector('input[name="title"]').addEventListener('input', function() {
        document.getElementById('previewTitle').textContent = this.value || 'Untitled Service';
    });

    // Live preview update for description
    document.querySelector('textarea[name="description"]').addEventListener('input', function() {
        const previewDesc = document.getElementById('previewDescription');
        const text = this.value || 'No description available.';
        previewDesc.textContent = text.length > 150 ? text.substring(0, 150) + '...' : text;
    });
</script>

</body>
</html>