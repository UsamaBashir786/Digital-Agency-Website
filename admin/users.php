<?php
// ============================================================
// ADMIN/USERS.PHP - Manage Users Page
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
// HANDLE USER ACTIONS (Delete, Role Update)
// ============================================================

$action_message = '';
$action_type = '';

// Delete user
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    
    // Prevent admin from deleting themselves
    if ($user_id == $_SESSION['admin_id']) {
        $action_message = 'You cannot delete your own account.';
        $action_type = 'error';
    } else {
        $delete_sql = "DELETE FROM users WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $user_id);
        
        if ($delete_stmt->execute()) {
            $action_message = 'User deleted successfully.';
            $action_type = 'success';
        } else {
            $action_message = 'Failed to delete user.';
            $action_type = 'error';
        }
        $delete_stmt->close();
    }
}

// Update user role
if (isset($_POST['update_role']) && isset($_POST['user_id']) && isset($_POST['role'])) {
    $user_id = intval($_POST['user_id']);
    $role = $_POST['role'];
    
    // Prevent admin from changing their own role
    if ($user_id == $_SESSION['admin_id']) {
        $action_message = 'You cannot change your own role.';
        $action_type = 'error';
    } else {
        $update_sql = "UPDATE users SET role = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $role, $user_id);
        
        if ($update_stmt->execute()) {
            $action_message = 'User role updated successfully.';
            $action_type = 'success';
        } else {
            $action_message = 'Failed to update user role.';
            $action_type = 'error';
        }
        $update_stmt->close();
    }
}

// ============================================================
// GET ALL USERS
// ============================================================

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$role_filter = isset($_GET['role']) ? $_GET['role'] : '';

$sql = "SELECT * FROM users WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " AND (fullname LIKE ? OR email LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ss";
}

if (!empty($role_filter)) {
    $sql .= " AND role = ?";
    $params[] = $role_filter;
    $types .= "s";
}

$sql .= " ORDER BY created_at DESC";

// Prepare statement
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$users_result = $stmt->get_result();

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Manage Users — 4 Digi Sol</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<!-- ============ SIDEBAR ============ -->
<?php include "includes/sidebar.php" ?>

<!-- ============ TOPBAR ============ -->
<header class="topbar">
    <div class="flex items-center gap-3">
        <button class="mobile-toggle" id="sidebarToggle"><i class='bx bx-menu'></i></button>
        <h1 class="text-lg font-semibold">Manage Users</h1>
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
                    <input type="text" name="search" class="auth-input" placeholder="Search by name or email..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div>
                    <select name="role" class="role-select" style="padding: 0.6rem 1rem;">
                        <option value="">All Roles</option>
                        <option value="admin" <?php echo $role_filter === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="user" <?php echo $role_filter === 'user' ? 'selected' : ''; ?>>User</option>
                    </select>
                </div>
                <button type="submit" class="btn-sm btn-sm-primary" style="padding: 0.6rem 1.2rem;">Filter</button>
                <a href="users.php" class="btn-sm" style="padding: 0.6rem 1.2rem; background: #1a1a1a; color: #b0b0b0; text-decoration: none; border-radius: 8px;">Reset</a>
            </form>
            <a href="create-admin.php" class="bg-lime text-[#101010] font-semibold rounded-lg px-4 py-2 text-sm hover:brightness-95 transition whitespace-nowrap">
                <i class='bx bx-user-plus'></i> Add User
            </a>
        </div>
    </div>

    <!-- Users Table -->
    <div class="table-card">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold">All Users</h3>
            <span class="text-xs text-gray-500">Total: <?php echo $users_result->num_rows; ?></span>
        </div>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users_result && $users_result->num_rows > 0): ?>
                        <?php while ($user = $users_result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-xs text-gray-500"><?php echo $user['id']; ?></td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-lime/20 text-lime flex items-center justify-center text-xs font-bold">
                                        <?php echo strtoupper(substr($user['fullname'], 0, 1)); ?>
                                    </div>
                                    <?php echo htmlspecialchars($user['fullname']); ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone'] ?? '-'); ?></td>
                            <td>
                                <?php if ($user['id'] == $_SESSION['admin_id']): ?>
                                    <span class="badge badge-admin">You</span>
                                <?php else: ?>
                                    <form method="POST" action="" class="inline">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <select name="role" class="role-select" onchange="this.form.submit()">
                                            <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                        </select>
                                        <input type="hidden" name="update_role" value="1">
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td class="text-xs text-gray-500"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="#" class="text-blue-400 hover:text-blue-300 text-sm" title="View Profile">
                                        <i class='bx bx-show'></i>
                                    </a>
                                    <?php if ($user['id'] != $_SESSION['admin_id']): ?>
                                    <a href="users.php?delete=<?php echo $user['id']; ?>" 
                                       class="text-red-400 hover:text-red-300 text-sm" 
                                       title="Delete User"
                                       onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                        <i class='bx bx-trash'></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-4">
                                <i class='bx bx-user-x text-2xl block mb-2'></i>
                                No users found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination (Simple) -->
        <?php if ($users_result && $users_result->num_rows > 10): ?>
        <div class="pagination">
            <a href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">Next →</a>
        </div>
        <?php endif; ?>
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

    toggleBtn.addEventListener('click', function() {
        if (sidebar.classList.contains('open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });
</script>

</body>
</html>