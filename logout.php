<?php
// ============================================================
// LOGOUT.PHP - User Logout Script with JavaScript Alert
// ============================================================

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Unset all session variables
$_SESSION = array();

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            background: #0c0c0c;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logout-card {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 2rem;
            padding: 3rem;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .spinner {
            width: 48px;
            height: 48px;
            border: 4px solid rgba(166, 241, 59, 0.1);
            border-top-color: #A6F13B;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1.5rem;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="logout-card">
    <div class="spinner"></div>
    <h2 class="text-xl font-bold text-white mb-2">Logging Out...</h2>
    <p class="text-gray-400 text-sm">You are being securely logged out.</p>
    <p class="text-gray-500 text-xs mt-4">Redirecting to home page...</p>
</div>

<script>
    // Redirect after 2 seconds
    setTimeout(function() {
        window.location.href = 'index.php?logout=success';
    }, 2000);
</script>

</body>
</html>