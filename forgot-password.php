<?php
// 1. Start session FIRST (before ANY output)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Include database connection
include "config/connection.php";

// 3. Your page logic and code
// ...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/css-links.php" ?>
    <style>
        body { 
            background: #f5f7fa; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 1rem;
        }
       
        .auth-input::placeholder { color: #9aa0a6; }
        
        .btn-primary { 
            background: #A6F13B; 
            color: #0c0c0c; 
            font-weight: 700; 
            border-radius: 12px; 
            padding: 0.9rem 1.2rem; 
            width: 100%; 
            border: none; 
            font-size: 1rem; 
            transition: background 0.2s, transform 0.1s; 
            cursor: pointer; 
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-primary:hover { background: #8BD82E; }
        .btn-primary:active { transform: scale(0.98); }
        
        .auth-link { 
            color: #1a1a1a; 
            transition: color 0.2s; 
            text-decoration: none; 
            font-weight: 500;
        }
        .auth-link:hover { color: #A6F13B; }
        
        .back-home { 
            color: #5f6368; 
            transition: color 0.2s; 
            font-size: 0.85rem; 
            display: inline-flex; 
            align-items: center; 
            gap: 4px; 
            text-decoration: none; 
            font-weight: 500;
        }
        .back-home:hover { color: #A6F13B; }
        
        .message-box {
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .message-box.error {
            background: #fce8e6;
            color: #c62828;
        }
        .message-box.success {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .message-box i {
            font-size: 1.2rem;
            margin-top: 0.05rem;
        }
        
        .reset-icon {
            background: #f0f2f5;
            width: 72px;
            height: 72px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .reset-icon i {
            font-size: 2.5rem;
            color: #A6F13B;
        }
        
        .steps-list {
            list-style: none;
            padding: 0;
            margin: 1rem 0 0.5rem;
        }
        .steps-list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
            font-size: 0.85rem;
            color: #3c4043;
            border-bottom: 1px solid #f0f2f5;
        }
        .steps-list li:last-child { border-bottom: none; }
        .steps-list li .step-num {
            background: #f0f2f5;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            color: #5f6368;
            flex-shrink: 0;
        }
        .steps-list li .step-num.active-step {
            background: #A6F13B;
            color: #0c0c0c;
        }
        
        @media (max-width: 480px) { 
            .auth-card { padding: 1.5rem 1.25rem; } 
        }
    </style>
</head>
<body>

<div class="auth-card">
    <!-- Back to login -->
    <div class="flex justify-between items-center mb-5">
        <a href="login.php" class="back-home">
            <i class='bx bx-arrow-back'></i> Back to Login
        </a>
        <div class="flex items-center gap-2 font-bold text-sm text-[#1a1a1a]">
            <i class='bx bx-sparkle text-lime'></i>
            <span>4 Digi Sol</span>
        </div>
    </div>

    <!-- Reset Icon -->
    <div class="reset-icon">
        <i class='bx bx-key'></i>
    </div>

    <h2 class="text-xl font-semibold text-center text-[#1a1a1a]">Forgot Password?</h2>
    <p class="text-sm text-[#5f6368] text-center mb-5">Enter your email address and we'll send you a link to reset your password.</p>

    <!-- Message Display -->
    <?php if ($message): ?>
    <div class="message-box <?php echo $message_type; ?>">
        <i class='bx <?php echo $message_type === 'success' ? 'bx-check-circle' : 'bx-error-circle'; ?>'></i>
        <span><?php echo htmlspecialchars($message); ?></span>
    </div>
    <?php endif; ?>

    <!-- Reset Form -->
    <?php if ($message_type !== 'success'): ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="mb-4">
            <label for="email" class="block text-xs font-semibold text-[#1a1a1a] mb-1.5">Email address</label>
            <input type="email" id="email" name="email" class="auth-input" placeholder="hello@4digisol.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required />
        </div>
        
        <button type="submit" class="btn-primary">
            <span>Send Reset Link</span>
            <i class='bx bx-envelope text-lg'></i>
        </button>
    </form>
    <?php endif; ?>

    <!-- How It Works -->
    <div class="mt-5 pt-4 border-t border-[#e8eaed]">
        <p class="text-xs font-semibold text-[#5f6368] uppercase tracking-wider mb-2">How it works</p>
        <ul class="steps-list">
            <li>
                <span class="step-num <?php echo $message_type === 'success' ? 'active-step' : ''; ?>">1</span>
                <span>Enter your registered email address</span>
            </li>
            <li>
                <span class="step-num <?php echo $message_type === 'success' ? 'active-step' : ''; ?>">2</span>
                <span>Check your inbox for a reset link</span>
            </li>
            <li>
                <span class="step-num <?php echo $message_type === 'success' ? 'active-step' : ''; ?>">3</span>
                <span>Create a new password and log in</span>
            </li>
        </ul>
    </div>

    <!-- Back to Login Link -->
    <div class="text-center text-sm text-[#5f6368] mt-4">
        Remember your password? <a href="login.php" class="auth-link font-semibold">Log in</a>
    </div>
</div>

</body>
</html>