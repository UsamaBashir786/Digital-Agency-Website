<?php
// ============================================================
// ADMIN/LOGOUT.PHP - Admin Logout with UI
// ============================================================

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all admin session variables
unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_id']);
unset($_SESSION['admin_email']);
unset($_SESSION['admin_name']);

// Also clear user sessions
unset($_SESSION['user_logged_in']);
unset($_SESSION['user_id']);
unset($_SESSION['user_email']);
unset($_SESSION['user_name']);

// Delete session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy session
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/css-links.php'; ?>
    <title>Logging Out — Admin</title>
    <style>
        body {
            background: #0c0c0c;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logout-container {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 2rem;
            padding: 3rem;
            text-align: center;
            max-width: 420px;
            width: 100%;
        }
        .logout-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(166, 241, 59, 0.08);
            border: 2px solid rgba(166, 241, 59, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        .logout-icon i {
            font-size: 2.5rem;
            color: #A6F13B;
        }
        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(166, 241, 59, 0.1);
            border-top-color: #A6F13B;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 1.5rem auto;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .btn-primary {
            background: #A6F13B;
            color: #0c0c0c;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.7rem 1.5rem;
            border: none;
            font-size: 0.9rem;
            transition: background 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .btn-primary:hover { background: #8BD82E; }
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
        .btn-secondary:hover { background: rgba(255,255,255,0.05); }
    </style>
</head>
<body>

<div class="logout-container">
    <div class="logout-icon">
        <i class='bx bx-log-out'></i>
    </div>
    
    <h2 class="text-xl font-bold text-white">Logged Out</h2>
    <p class="text-gray-400 text-sm mt-1">You have been successfully logged out of the admin panel.</p>
    
    <div class="spinner"></div>
    
    <div class="flex gap-3 justify-center mt-2">
        <a href="login.php" class="btn-primary">
            <i class='bx bx-log-in'></i> Login Again
        </a>
        <a href="../index.php" class="btn-secondary">
            <i class='bx bx-home'></i> Home
        </a>
    </div>
    
    <p class="text-xs text-gray-500 mt-4">Redirecting to login in <span id="countdown">5</span> seconds...</p>
</div>

<script>
    // Auto redirect after 5 seconds
    let seconds = 5;
    const countdownEl = document.getElementById('countdown');
    
    const interval = setInterval(() => {
        seconds--;
        countdownEl.textContent = seconds;
        if (seconds <= 0) {
            clearInterval(interval);
            window.location.href = 'login.php';
        }
    }, 1000);
</script>

</body>
</html>