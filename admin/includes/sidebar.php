<?php
// ============================================================
// INCLUDES/SIDEBAR.PHP - Admin Sidebar
// ============================================================

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);

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
$total_blogs = 0;
if (isset($conn)) {
    $blogs_query = "SELECT COUNT(*) as total FROM blogs";
    $blogs_result = $conn->query($blogs_query);
    if ($blogs_result) {
        $total_blogs = $blogs_result->fetch_assoc()['total'] ?? 0;
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
?>

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
            <?php if ($total_blogs > 0): ?>
            <span class="ml-auto text-xs text-gray-500"><?php echo $total_blogs; ?></span>
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

<!-- ============ SIDEBAR CSS ============ -->
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
</style>

<!-- ============ SIDEBAR JAVASCRIPT ============ -->
<script>
    // Sidebar Toggle for Mobile
    function initSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (!sidebar || !toggleBtn) return;

        function openSidebar() {
            sidebar.classList.add('open');
            if (overlay) overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            if (overlay) overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        toggleBtn.addEventListener('click', function() {
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

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

        // Expose close function globally
        window.closeSidebar = closeSidebar;
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebar);
    } else {
        initSidebar();
    }
</script>