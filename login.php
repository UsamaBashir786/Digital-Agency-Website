<?php
// ============================================================
// LOGIN.PHP - Light Theme Login Page with Redirect
// ============================================================

// Check if user is already logged in, redirect to dashboard
session_start();
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header('Location: dashboard.php');
    exit();
}

// Handle login form submission
$login_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Demo credentials (in real app, check against database)
    $valid_email = 'demo@4digisol.com';
    $valid_password = 'password123';
    
    if ($email === $valid_email && $password === $valid_password) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = 'Demo User';
        header('Location: dashboard.php');
        exit();
    } else {
        $login_error = 'Invalid email or password. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Login — 4 Digi Sol</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { 
            background: #f5f7fa; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 1rem;
        }
    </style>
    <link rel="stylesheet" href="assets/styles/styles.css">
</head>
<body>

<div class="auth-card">
    <!-- Back to home -->
    <div class="flex justify-between items-center mb-5">
        <a href="index.php" class="back-home">
            <i class='bx bx-arrow-back'></i> Back to Home
        </a>
        <div class="flex items-center gap-2 font-bold text-sm text-[#1a1a1a]">
            <i class='bx bx-sparkle text-lime'></i>
            <span>4 Digi Sol</span>
        </div>
    </div>

    <!-- Brand Header -->
    <div class="flex items-center gap-3 mb-5">
        <span class="text-xl font-bold tracking-tight text-[#1a1a1a]">Welcome Back</span>
        <span class="ml-auto text-[10px] font-medium uppercase tracking-wider text-[#5f6368] bg-[#f0f2f5] rounded-full px-3 py-0.5">login</span>
    </div>

    <h2 class="text-xl font-semibold mb-1 text-[#1a1a1a]">Log in to your account</h2>
    <p class="text-sm text-[#5f6368] mb-5">Access your dashboard and manage your projects.</p>

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
            <label for="email" class="block text-xs font-semibold text-[#1a1a1a] mb-1.5">Email address</label>
            <input type="email" id="email" name="email" class="auth-input" placeholder="hello@4digisol.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required />
        </div>
        <div class="mb-4">
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-[#1a1a1a]">Password</label>
                <a href="forgot-password.php" class="text-xs text-[#5f6368] hover:text-lime transition font-medium">Forgot password?</a>
            </div>
            <input type="password" id="password" name="password" class="auth-input" placeholder="••••••••" required />
        </div>
        
        <button type="submit" class="btn-primary">
            <span>Log In</span>
            <i class='bx bx-log-in text-lg'></i>
        </button>
    </form>

    <!-- Divider -->
    <div class="flex items-center gap-3 my-5">
        <span class="divider-line"></span>
        <span class="text-[11px] uppercase tracking-wider text-[#9aa0a6] font-medium">or continue with</span>
        <span class="divider-line"></span>
    </div>

    <!-- Social Login -->
    <div class="flex justify-center gap-3">
        <button class="social-btn" onclick="alert('🔓 Google login (demo)')"><i class='bx bxl-google'></i></button>
    </div>

    <!-- Register Link -->
    <div class="text-center text-sm text-[#5f6368] mt-5">
        Don't have an account? <a href="register.php" class="auth-link font-semibold">Sign up free</a>
    </div>

</div>

</body>
</html>