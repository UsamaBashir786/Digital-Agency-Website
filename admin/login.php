<?php
// ============================================================
// ADMIN/LOGIN.PHP - Admin Login Page
// ============================================================

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once '../config/connection.php';

// If already logged in, redirect to admin dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit();
}

// Handle login form submission
$login_error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email)) {
        $login_error = 'Please enter your email address.';
    } elseif (empty($password)) {
        $login_error = 'Please enter your password.';
    } else {
        // Query database for admin user
        $sql = "SELECT id, fullname, email, password, role FROM users WHERE email = ? AND role = 'admin'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_email'] = $user['email'];
                $_SESSION['admin_name'] = $user['fullname'];
                
                // Redirect to admin dashboard
                header('Location: index.php');
                exit();
            } else {
                $login_error = 'Invalid email or password. Please try again.';
            }
        } else {
            $login_error = 'Invalid email or password. Please try again.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Admin Login — 4 Digi Sol</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<div class="admin-login-card">
    <!-- Back to home -->
    <div class="flex justify-between items-center mb-4">
        <a href="../index.php" class="back-home">
            <i class='bx bx-arrow-back'></i> Back to Site
        </a>
        <span class="admin-badge">Admin Area</span>
    </div>

    <!-- Admin Logo -->
    <div class="admin-logo">
        <i class='bx bx-shield'></i>
    </div>

    <h2 class="text-xl font-bold text-center text-white mb-1">Admin Login</h2>
    <p class="text-sm text-gray-500 text-center mb-6">Enter your credentials to access the admin panel.</p>

    <!-- Error Message -->
    <?php if ($login_error): ?>
    <div class="error-message">
        <i class='bx bx-error-circle'></i>
        <?php echo htmlspecialchars($login_error); ?>
    </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="mb-4">
            <label for="email" class="block text-xs font-semibold text-gray-400 mb-1.5">Email Address</label>
            <input type="email" id="email" name="email" class="auth-input" placeholder="admin@4digisol.com" value="<?php echo htmlspecialchars($email); ?>" required autofocus />
        </div>
        <div class="mb-5">
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-gray-400">Password</label>
                <a href="forgot-password.php" class="text-xs text-gray-500 hover:text-lime transition">Forgot password?</a>
            </div>
            <input type="password" id="password" name="password" class="auth-input" placeholder="••••••••" required />
        </div>
        
        <button type="submit" class="btn-primary">
            <span>Login to Admin</span>
            <i class='bx bx-log-in text-lg'></i>
        </button>
    </form>

    <!-- Divider -->
    <div class="flex items-center gap-3 my-5">
        <span class="flex-1 h-px bg-white/10"></span>
        <span class="text-[10px] uppercase tracking-wider text-gray-600">Secure Access</span>
        <span class="flex-1 h-px bg-white/10"></span>
    </div>

    <!-- Security Info -->
    <div class="text-center">
        <p class="text-[11px] text-gray-600 leading-relaxed">
            <i class='bx bx-shield-alt text-lime inline-block mr-1'></i>
            This area is restricted to authorized personnel only.
        </p>
    </div>
</div>

</body>
</html>