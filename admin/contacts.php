<?php
// ============================================================
// ADMIN/CONTACTS.PHP - Manage Contacts Page
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
// HANDLE CONTACT ACTIONS
// ============================================================

$action_message = '';
$action_type = '';

// Update contact status
if (isset($_POST['update_status']) && isset($_POST['contact_id']) && isset($_POST['status'])) {
    $contact_id = intval($_POST['contact_id']);
    $status = $_POST['status'];
    
    $update_sql = "UPDATE contacts SET status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $status, $contact_id);
    
    if ($update_stmt->execute()) {
        $action_message = 'Contact status updated successfully.';
        $action_type = 'success';
    } else {
        $action_message = 'Failed to update contact status.';
        $action_type = 'error';
    }
    $update_stmt->close();
}

// Delete contact
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $contact_id = intval($_GET['delete']);
    
    $delete_sql = "DELETE FROM contacts WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $contact_id);
    
    if ($delete_stmt->execute()) {
        $action_message = 'Contact deleted successfully.';
        $action_type = 'success';
    } else {
        $action_message = 'Failed to delete contact.';
        $action_type = 'error';
    }
    $delete_stmt->close();
}

// Mark as read (single)
if (isset($_GET['mark_read']) && is_numeric($_GET['mark_read'])) {
    $contact_id = intval($_GET['mark_read']);
    
    $update_sql = "UPDATE contacts SET status = 'read' WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $contact_id);
    
    if ($update_stmt->execute()) {
        $action_message = 'Contact marked as read.';
        $action_type = 'success';
    } else {
        $action_message = 'Failed to mark as read.';
        $action_type = 'error';
    }
    $update_stmt->close();
}

// Mark all as read
if (isset($_GET['mark_all_read'])) {
    $update_sql = "UPDATE contacts SET status = 'read' WHERE status = 'unread'";
    if ($conn->query($update_sql)) {
        $action_message = 'All contacts marked as read.';
        $action_type = 'success';
    } else {
        $action_message = 'Failed to mark all as read.';
        $action_type = 'error';
    }
}

// ============================================================
// GET ALL CONTACTS
// ============================================================

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT * FROM contacts WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " AND (fullname LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ssss";
}

if (!empty($status_filter)) {
    $sql .= " AND status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$sql .= " ORDER BY 
    CASE WHEN status = 'unread' THEN 1 ELSE 2 END,
    created_at DESC";

// Prepare statement
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$contacts_result = $stmt->get_result();

// Get counts for badges
$unread_count_query = "SELECT COUNT(*) as total FROM contacts WHERE status = 'unread'";
$unread_count_result = $conn->query($unread_count_query);
$unread_count = $unread_count_result->fetch_assoc()['total'] ?? 0;

// Get total contacts count
$total_query = "SELECT COUNT(*) as total FROM contacts";
$total_result = $conn->query($total_query);
$total_contacts = $total_result->fetch_assoc()['total'] ?? 0;

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Manage Contacts — 4 Digi Sol</title>
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
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
        <h1 class="text-lg font-semibold">Manage Contacts</h1>
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
            <h2 class="text-2xl font-bold">Contacts</h2>
            <p class="text-gray-400 text-sm">Manage all contact form submissions</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500">Total: <?php echo $total_contacts; ?></span>
            <?php if ($unread_count > 0): ?>
            <span class="bg-lime text-[#101010] text-xs font-bold px-3 py-1 rounded-full"><?php echo $unread_count; ?> Unread</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Message Display -->
    <?php if ($action_message): ?>
    <div class="<?php echo $action_type === 'success' ? 'success-message' : 'error-message'; ?>">
        <i class='bx <?php echo $action_type === 'success' ? 'bx-check-circle' : 'bx-error-circle'; ?>'></i>
        <?php echo $action_message; ?>
    </div>
    <?php endif; ?>

    <!-- Filters & Actions -->
    <div class="table-card mb-6">
        <div class="flex flex-wrap items-center gap-4">
            <form method="GET" action="" class="flex flex-wrap items-center gap-3 flex-1">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" class="auth-input" placeholder="Search by name, email, subject..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div>
                    <select name="status" class="status-select" style="padding: 0.6rem 1rem;">
                        <option value="">All Status</option>
                        <option value="unread" <?php echo $status_filter === 'unread' ? 'selected' : ''; ?>>Unread</option>
                        <option value="read" <?php echo $status_filter === 'read' ? 'selected' : ''; ?>>Read</option>
                        <option value="replied" <?php echo $status_filter === 'replied' ? 'selected' : ''; ?>>Replied</option>
                    </select>
                </div>
                <button type="submit" class="btn-sm btn-sm-primary" style="padding: 0.6rem 1.2rem;">Filter</button>
                <a href="contacts.php" class="btn-sm btn-sm-secondary" style="padding: 0.6rem 1.2rem; text-decoration: none;">Reset</a>
            </form>
            <?php if ($unread_count > 0): ?>
            <a href="contacts.php?mark_all_read=1" class="btn-sm btn-sm-success" style="padding: 0.6rem 1.2rem; text-decoration: none;" onclick="return confirm('Mark all contacts as read?')">
                <i class='bx bx-check-double'></i> Mark All Read
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="table-card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($contacts_result && $contacts_result->num_rows > 0): ?>
                        <?php $count = 1; while ($contact = $contacts_result->fetch_assoc()): ?>
                        <tr style="<?php echo $contact['status'] === 'unread' ? 'background: rgba(166, 241, 59, 0.02);' : ''; ?>">
                            <td class="text-xs text-gray-500"><?php echo $count++; ?></td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-lime/20 text-lime flex items-center justify-center text-xs font-bold">
                                        <?php echo strtoupper(substr($contact['fullname'], 0, 1)); ?>
                                    </div>
                                    <?php echo htmlspecialchars($contact['fullname']); ?>
                                    <?php if ($contact['status'] === 'unread'): ?>
                                    <span class="w-2 h-2 rounded-full bg-lime inline-block animate-pulse"></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                            <td><?php echo htmlspecialchars($contact['subject']); ?></td>
                            <td>
                                <span class="message-preview" title="<?php echo htmlspecialchars($contact['message']); ?>">
                                    <?php echo htmlspecialchars(substr($contact['message'], 0, 50)) . (strlen($contact['message']) > 50 ? '...' : ''); ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="" class="inline">
                                    <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
                                    <select name="status" class="status-select" onchange="this.form.submit()">
                                        <option value="unread" <?php echo $contact['status'] === 'unread' ? 'selected' : ''; ?>>Unread</option>
                                        <option value="read" <?php echo $contact['status'] === 'read' ? 'selected' : ''; ?>>Read</option>
                                        <option value="replied" <?php echo $contact['status'] === 'replied' ? 'selected' : ''; ?>>Replied</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <td class="text-xs text-gray-500">
                                <?php echo date('M d, Y', strtotime($contact['created_at'])); ?>
                                <br>
                                <span class="text-[10px] text-gray-600"><?php echo date('h:i A', strtotime($contact['created_at'])); ?></span>
                            </td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <?php if ($contact['status'] === 'unread'): ?>
                                    <a href="contacts.php?mark_read=<?php echo $contact['id']; ?>" class="btn-sm btn-sm-primary" title="Mark as Read">
                                        <i class='bx bx-check'></i>
                                    </a>
                                    <?php endif; ?>
                                    <a href="#" class="btn-sm btn-sm-success" title="View Message" onclick="viewMessage(<?php echo $contact['id']; ?>, '<?php echo addslashes($contact['fullname']); ?>', '<?php echo addslashes($contact['email']); ?>', '<?php echo addslashes($contact['subject']); ?>', '<?php echo addslashes($contact['message']); ?>', '<?php echo $contact['status']; ?>')">
                                        <i class='bx bx-show'></i>
                                    </a>
                                    <a href="contacts.php?delete=<?php echo $contact['id']; ?>" class="btn-sm btn-sm-danger" title="Delete" onclick="return confirm('Delete this message?')">
                                        <i class='bx bx-trash'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-4">
                                <i class='bx bx-envelope-open text-2xl block mb-2'></i>
                                No contacts found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<!-- ============ VIEW MESSAGE MODAL ============ -->
<div id="messageModal" class="fixed inset-0 bg-black/70 z-50 hidden flex items-center justify-center p-4" onclick="closeModal(event)">
    <div class="bg-[#141414] border border-white/10 rounded-2xl max-w-2xl w-full max-h-[80vh] overflow-y-auto p-6" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold" id="modalSubject">Message Subject</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-white text-2xl">&times;</button>
        </div>
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-lime/20 text-lime flex items-center justify-center text-sm font-bold">
                <span id="modalInitial">JD</span>
            </div>
            <div>
                <p class="font-medium" id="modalName">John Doe</p>
                <p class="text-xs text-gray-400" id="modalEmail">john@example.com</p>
            </div>
            <span class="ml-auto text-xs text-gray-500" id="modalStatus">Status</span>
        </div>
        <div class="bg-[#1a1a1a] rounded-xl p-4 mb-4">
            <p class="text-sm text-gray-300 whitespace-pre-wrap" id="modalMessage">Message content here...</p>
        </div>
        <div class="flex gap-2">
            <button onclick="closeModal()" class="btn-sm btn-sm-secondary" style="padding: 0.6rem 1.5rem;">Close</button>
            <a href="#" class="btn-sm btn-sm-primary" style="padding: 0.6rem 1.5rem; text-decoration: none;" id="modalReplyBtn">
                <i class='bx bx-reply'></i> Reply
            </a>
        </div>
    </div>
</div>

<!-- ============ MOBILE SIDEBAR OVERLAY ============ -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden" onclick="closeSidebar()"></div>

<!-- ============ SCRIPTS ============ -->
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

    // View Message Modal
    function viewMessage(id, name, email, subject, message, status) {
        document.getElementById('modalSubject').textContent = subject;
        document.getElementById('modalName').textContent = name;
        document.getElementById('modalEmail').textContent = email;
        document.getElementById('modalMessage').textContent = message;
        document.getElementById('modalInitial').textContent = name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        document.getElementById('modalStatus').textContent = 'Status: ' + status.charAt(0).toUpperCase() + status.slice(1);
        document.getElementById('modalReplyBtn').href = 'mailto:' + email + '?subject=RE: ' + encodeURIComponent(subject);
        document.getElementById('messageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(e) {
        if (e && e.target !== e.currentTarget) return;
        document.getElementById('messageModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>

</body>
</html>