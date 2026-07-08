<?php
// ============================================================
// ADMIN/INDEX.PHP - Admin Dashboard Home (Complete)
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
// GET STATISTICS
// ============================================================

// Total Users
$users_query = "SELECT COUNT(*) as total FROM users";
$users_result = $conn->query($users_query);
$total_users = $users_result->fetch_assoc()['total'] ?? 0;

// New Users (last 30 days)
$new_users_query = "SELECT COUNT(*) as total FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
$new_users_result = $conn->query($new_users_query);
$new_users = $new_users_result->fetch_assoc()['total'] ?? 0;

// Total Contacts
$contacts_query = "SELECT COUNT(*) as total FROM contacts";
$contacts_result = $conn->query($contacts_query);
$total_contacts = $contacts_result->fetch_assoc()['total'] ?? 0;

// Unread Contacts
$unread_query = "SELECT COUNT(*) as total FROM contacts WHERE status = 'unread'";
$unread_result = $conn->query($unread_query);
$unread_contacts = $unread_result->fetch_assoc()['total'] ?? 0;

// Total Admins
$admins_query = "SELECT COUNT(*) as total FROM users WHERE role = 'admin'";
$admins_result = $conn->query($admins_query);
$total_admins = $admins_result->fetch_assoc()['total'] ?? 0;

// ============================================================
// SUBSCRIBER STATISTICS
// ============================================================

// Check if subscribers table exists
$table_check = $conn->query("SHOW TABLES LIKE 'subscribers'");
if ($table_check->num_rows > 0) {
    // Total Subscribers
    $subscribers_query = "SELECT COUNT(*) as total FROM subscribers";
    $subscribers_result = $conn->query($subscribers_query);
    $total_subscribers = $subscribers_result->fetch_assoc()['total'] ?? 0;

    // Active Subscribers
    $active_subscribers_query = "SELECT COUNT(*) as total FROM subscribers WHERE status = 'active'";
    $active_subscribers_result = $conn->query($active_subscribers_query);
    $active_subscribers = $active_subscribers_result->fetch_assoc()['total'] ?? 0;

    // Unsubscribed
    $unsubscribed_query = "SELECT COUNT(*) as total FROM subscribers WHERE status = 'unsubscribed'";
    $unsubscribed_result = $conn->query($unsubscribed_query);
    $unsubscribed = $unsubscribed_result->fetch_assoc()['total'] ?? 0;

    // New Subscribers (last 30 days)
    $new_subscribers_query = "SELECT COUNT(*) as total FROM subscribers WHERE subscribed_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $new_subscribers_result = $conn->query($new_subscribers_query);
    $new_subscribers = $new_subscribers_result->fetch_assoc()['total'] ?? 0;

    // Recent Subscribers
    $recent_subscribers_query = "SELECT * FROM subscribers ORDER BY subscribed_at DESC LIMIT 5";
    $recent_subscribers = $conn->query($recent_subscribers_query);
} else {
    $total_subscribers = 0;
    $active_subscribers = 0;
    $unsubscribed = 0;
    $new_subscribers = 0;
    $recent_subscribers = null;
}

// Recent Contacts
$recent_contacts_query = "SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5";
$recent_contacts = $conn->query($recent_contacts_query);

// Recent Users
$recent_users_query = "SELECT * FROM users ORDER BY created_at DESC LIMIT 5";
$recent_users = $conn->query($recent_users_query);

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);

// Get current time
$current_hour = date('H');
if ($current_hour < 12) {
    $greeting = 'Good Morning';
} elseif ($current_hour < 17) {
    $greeting = 'Good Afternoon';
} else {
    $greeting = 'Good Evening';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Admin Dashboard — 4 Digi Sol</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        /* Additional styles for dashboard */
        .stat-card {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 1rem;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            border-color: rgba(166, 241, 59, 0.2);
            transform: translateY(-2px);
        }
        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 0.75rem;
            background: rgba(166, 241, 59, 0.08);
            color: #A6F13B;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        .table-card {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 1rem;
            padding: 1.25rem;
            overflow: hidden;
        }
        .table-card table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-card th {
            text-align: left;
            padding: 0.5rem 0.25rem;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #888;
            font-weight: 600;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .table-card td {
            padding: 0.5rem 0.25rem;
            font-size: 0.85rem;
            border-bottom: 1px solid rgba(255,255,255,0.03);
        }
        .badge {
            padding: 0.15rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.6rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-unread {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }
        .badge-read {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
        }
        .badge-replied {
            background: rgba(166, 241, 59, 0.15);
            color: #A6F13B;
        }
        .badge-active {
            background: rgba(166, 241, 59, 0.15);
            color: #A6F13B;
        }
        .badge-unsubscribed {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }
        .badge-admin {
            background: rgba(166, 241, 59, 0.15);
            color: #A6F13B;
        }
        .badge-user {
            background: rgba(255,255,255,0.05);
            color: #888;
        }
        .quick-action {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            color: #ffffff;
            text-decoration: none;
        }
        .quick-action:hover {
            border-color: #A6F13B;
            transform: translateY(-2px);
        }
        .quick-action i {
            font-size: 1.3rem;
            color: #A6F13B;
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
        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 1rem; padding-top: 70px; }
            .topbar { left: 0; padding: 0.75rem 1rem; }
            .mobile-toggle { display: block; }
            .stat-card { padding: 0.75rem; }
            .stat-card .text-2xl { font-size: 1.3rem; }
            .table-card { padding: 0.75rem; overflow-x: auto; }
            .table-card table { font-size: 0.75rem; }
            .table-card th, .table-card td { padding: 0.3rem 0.15rem; }
        }
        @media (max-width: 480px) {
            .main-content { padding: 0.75rem; padding-top: 65px; }
            .stat-card { padding: 0.6rem; }
            .stat-card .text-2xl { font-size: 1.1rem; }
            .stat-icon { width: 32px; height: 32px; font-size: 1rem; }
            .quick-action { padding: 0.5rem 0.75rem; font-size: 0.8rem; }
            .quick-action i { font-size: 1rem; }
            .table-card { padding: 0.5rem; }
        }
    </style>
</head>
<body>

<!-- ============ SIDEBAR ============ -->
<?php include "includes/sidebar.php" ?>

<!-- ============ TOPBAR ============ -->
<header class="topbar">
    <div class="flex items-center gap-3">
        <button class="mobile-toggle" id="sidebarToggle">
            <i class='bx bx-menu'></i>
        </button>
        <h1 class="text-lg font-semibold">Dashboard</h1>
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

    <!-- Welcome Message -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold"><?php echo $greeting; ?>, <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?> 👋</h2>
        <p class="text-gray-400 text-sm">Here's what's happening with your website today.</p>
    </div>

    <!-- Stats Grid - Main -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Total Users</p>
                    <p class="text-2xl font-bold mt-1"><?php echo number_format($total_users); ?></p>
                    <p class="text-xs text-gray-500 mt-1">+<?php echo number_format($new_users); ?> new (30d)</p>
                </div>
                <div class="stat-icon"><i class='bx bx-user'></i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Total Contacts</p>
                    <p class="text-2xl font-bold mt-1"><?php echo number_format($total_contacts); ?></p>
                    <p class="text-xs text-gray-500 mt-1"><?php echo number_format($unread_contacts); ?> unread</p>
                </div>
                <div class="stat-icon"><i class='bx bx-envelope'></i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Total Admins</p>
                    <p class="text-2xl font-bold mt-1"><?php echo number_format($total_admins); ?></p>
                    <p class="text-xs text-gray-500 mt-1">Administrators</p>
                </div>
                <div class="stat-icon"><i class='bx bx-shield'></i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">New Users</p>
                    <p class="text-2xl font-bold mt-1 text-lime"><?php echo number_format($new_users); ?></p>
                    <p class="text-xs text-gray-500 mt-1">Last 30 days</p>
                </div>
                <div class="stat-icon"><i class='bx bx-user-plus'></i></div>
            </div>
        </div>
    </div>

    <!-- Stats Grid - Subscribers -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat-card border-l-4 border-lime">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Total Subscribers</p>
                    <p class="text-2xl font-bold mt-1"><?php echo number_format($total_subscribers); ?></p>
                    <p class="text-xs text-gray-500 mt-1">Newsletter list</p>
                </div>
                <div class="stat-icon bg-lime/10 text-lime"><i class='bx bx-mailing-list'></i></div>
            </div>
        </div>
        <div class="stat-card border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Active Subscribers</p>
                    <p class="text-2xl font-bold mt-1 text-green-500"><?php echo number_format($active_subscribers); ?></p>
                    <p class="text-xs text-gray-500 mt-1">Engaged users</p>
                </div>
                <div class="stat-icon bg-green-500/10 text-green-500"><i class='bx bx-user-check'></i></div>
            </div>
        </div>
        <div class="stat-card border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Unsubscribed</p>
                    <p class="text-2xl font-bold mt-1 text-red-500"><?php echo number_format($unsubscribed); ?></p>
                    <p class="text-xs text-gray-500 mt-1">Inactive users</p>
                </div>
                <div class="stat-icon bg-red-500/10 text-red-500"><i class='bx bx-user-x'></i></div>
            </div>
        </div>
        <div class="stat-card border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">New Subscribers</p>
                    <p class="text-2xl font-bold mt-1 text-blue-500"><?php echo number_format($new_subscribers); ?></p>
                    <p class="text-xs text-gray-500 mt-1">Last 30 days</p>
                </div>
                <div class="stat-icon bg-blue-500/10 text-blue-500"><i class='bx bx-user-plus'></i></div>
            </div>
        </div>
    </div>

    <!-- Recent Contacts, Users & Subscribers -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        
        <!-- Recent Contacts -->
        <div class="table-card">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold flex items-center gap-2">
                    <i class='bx bx-envelope text-lime'></i>
                    Recent Contacts
                </h3>
                <a href="contacts.php" class="text-xs text-lime hover:underline flex items-center gap-1">
                    View All <i class='bx bx-chevron-right'></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($recent_contacts && $recent_contacts->num_rows > 0): ?>
                            <?php while ($contact = $recent_contacts->fetch_assoc()): ?>
                            <tr>
                                <td class="font-medium"><?php echo htmlspecialchars($contact['fullname']); ?></td>
                                <td><?php echo htmlspecialchars(substr($contact['subject'], 0, 15)); ?></td>
                                <td>
                                    <span class="badge <?php echo $contact['status'] === 'unread' ? 'badge-unread' : ($contact['status'] === 'read' ? 'badge-read' : 'badge-replied'); ?>">
                                        <?php echo ucfirst($contact['status'] ?? 'Unread'); ?>
                                    </span>
                                </td>
                                <td class="text-xs text-gray-500"><?php echo date('M d', strtotime($contact['created_at'])); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center text-gray-500 py-4 text-sm">No contacts yet</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="table-card">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold flex items-center gap-2">
                    <i class='bx bx-user text-lime'></i>
                    Recent Users
                </h3>
                <a href="users.php" class="text-xs text-lime hover:underline flex items-center gap-1">
                    View All <i class='bx bx-chevron-right'></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($recent_users && $recent_users->num_rows > 0): ?>
                            <?php while ($user = $recent_users->fetch_assoc()): ?>
                            <tr>
                                <td class="font-medium"><?php echo htmlspecialchars($user['fullname']); ?></td>
                                <td><?php echo htmlspecialchars(substr($user['email'], 0, 12)); ?></td>
                                <td>
                                    <span class="badge <?php echo $user['role'] === 'admin' ? 'badge-admin' : 'badge-user'; ?>">
                                        <?php echo ucfirst($user['role'] ?? 'User'); ?>
                                    </span>
                                </td>
                                <td class="text-xs text-gray-500"><?php echo date('M d', strtotime($user['created_at'])); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center text-gray-500 py-4 text-sm">No users yet</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Subscribers -->
        <div class="table-card">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold flex items-center gap-2">
                    <i class='bx bx-mailing-list text-lime'></i>
                    Recent Subscribers
                </h3>
                <a href="subscribers.php" class="text-xs text-lime hover:underline flex items-center gap-1">
                    View All <i class='bx bx-chevron-right'></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($recent_subscribers && $recent_subscribers->num_rows > 0): ?>
                            <?php while ($subscriber = $recent_subscribers->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars(substr($subscriber['email'], 0, 15)); ?></td>
                                <td><?php echo htmlspecialchars($subscriber['name'] ?? '-'); ?></td>
                                <td>
                                    <span class="badge <?php echo $subscriber['status'] === 'active' ? 'badge-active' : 'badge-unsubscribed'; ?>">
                                        <?php echo ucfirst($subscriber['status']); ?>
                                    </span>
                                </td>
                                <td class="text-xs text-gray-500"><?php echo date('M d', strtotime($subscriber['subscribed_at'])); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center text-gray-500 py-4 text-sm">No subscribers yet</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <a href="contacts.php" class="quick-action">
            <i class='bx bx-message-dots'></i>
            <span class="text-sm font-medium">View Messages</span>
            <?php if ($unread_contacts > 0): ?>
            <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full"><?php echo $unread_contacts; ?></span>
            <?php endif; ?>
        </a>
        <a href="users.php" class="quick-action">
            <i class='bx bx-user'></i>
            <span class="text-sm font-medium">Manage Users</span>
            <span class="ml-auto text-xs text-gray-500"><?php echo number_format($total_users); ?></span>
        </a>
        <a href="subscribers.php" class="quick-action">
            <i class='bx bx-mailing-list'></i>
            <span class="text-sm font-medium">Subscribers</span>
            <span class="ml-auto text-xs text-gray-500"><?php echo number_format($total_subscribers); ?></span>
        </a>
        <a href="create-admin.php" class="quick-action">
            <i class='bx bx-user-plus'></i>
            <span class="text-sm font-medium">Create Admin</span>
        </a>
        <a href="../index.php" target="_blank" class="quick-action">
            <i class='bx bx-home'></i>
            <span class="text-sm font-medium">View Website</span>
        </a>
    </div>

    <!-- Footer Info -->
    <div class="mt-8 pt-4 border-t border-white/5 text-center text-xs text-gray-600">
        <p>© <?php echo date('Y'); ?> 4 Digi Sol Admin Panel. All rights reserved.</p>
        <p class="mt-1">Last login: <?php echo date('F j, Y g:i A'); ?></p>
    </div>

</main>

<!-- ============ MOBILE SIDEBAR OVERLAY ============ -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden" onclick="closeSidebar()"></div>

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

    toggleBtn.addEventListener('click', function() {
        if (sidebar.classList.contains('open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    // Auto refresh stats every 5 minutes (optional)
    // setInterval(function() {
    //     location.reload();
    // }, 300000);
</script>

</body>
</html>