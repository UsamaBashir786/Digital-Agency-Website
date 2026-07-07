<?php
// ============================================================
// REGISTER.PHP - User Registration Page
// ============================================================

session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header('Location: dashboard.php');
    exit();
}

// Registration form variables
$errors = [];
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $agree_terms = isset($_POST['agree_terms']) ? true : false;

    // Store form data for repopulation
    $form_data = [
        'fullname' => $fullname,
        'email' => $email,
        'phone' => $phone
    ];

    // Validation
    if (empty($fullname)) {
        $errors['fullname'] = 'Full name is required.';
    } elseif (strlen($fullname) < 2) {
        $errors['fullname'] = 'Name must be at least 2 characters.';
    }

    if (empty($email)) {
        $errors['email'] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters.';
    }

    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Please confirm your password.';
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    if (!empty($phone) && !preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
        $errors['phone'] = 'Please enter a valid phone number.';
    }

    if (!$agree_terms) {
        $errors['agree_terms'] = 'You must agree to the Terms & Conditions.';
    }

    // If no errors, process registration
    if (empty($errors)) {
        // In a real application, you would:
        // 1. Check if email already exists in database
        // 2. Hash the password using password_hash()
        // 3. Insert user into database
        // 4. Send welcome email
        // 5. Redirect to login or dashboard
        
        // Demo - always success
        $_SESSION['registration_success'] = true;
        $_SESSION['registration_email'] = $email;
        header('Location: login.php?registered=success');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Sign Up — 4 Digi Sol</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/styles.css">
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
        <span class="text-xl font-bold tracking-tight text-[#1a1a1a]">Create Account</span>
        <span class="ml-auto text-[10px] font-medium uppercase tracking-wider text-[#5f6368] bg-[#f0f2f5] rounded-full px-3 py-0.5">register</span>
    </div>

    <h2 class="text-xl font-semibold mb-1 text-[#1a1a1a]">Join 4 Digi Sol</h2>
    <p class="text-sm text-[#5f6368] mb-5">Create your free account and start growing your business.</p>

    <!-- Registration Form -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        
        <!-- Full Name -->
        <div class="mb-4">
            <label for="fullname" class="block text-xs font-semibold text-[#1a1a1a] mb-1.5">Full Name</label>
            <input type="text" id="fullname" name="fullname" class="auth-input <?php echo isset($errors['fullname']) ? 'error' : ''; ?>" placeholder="John Doe" value="<?php echo htmlspecialchars($form_data['fullname'] ?? ''); ?>" required />
            <?php if (isset($errors['fullname'])): ?>
                <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['fullname']; ?></div>
            <?php endif; ?>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-xs font-semibold text-[#1a1a1a] mb-1.5">Email Address</label>
            <input type="email" id="email" name="email" class="auth-input <?php echo isset($errors['email']) ? 'error' : ''; ?>" placeholder="hello@4digisol.com" value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>" required />
            <?php if (isset($errors['email'])): ?>
                <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['email']; ?></div>
            <?php endif; ?>
        </div>

        <!-- Phone (Optional) -->
        <div class="mb-4">
            <label for="phone" class="block text-xs font-semibold text-[#1a1a1a] mb-1.5">Phone Number <span class="text-[#9aa0a6] font-normal">(optional)</span></label>
            <input type="tel" id="phone" name="phone" class="auth-input <?php echo isset($errors['phone']) ? 'error' : ''; ?>" placeholder="+92 300 1234567" value="<?php echo htmlspecialchars($form_data['phone'] ?? ''); ?>" />
            <?php if (isset($errors['phone'])): ?>
                <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['phone']; ?></div>
            <?php endif; ?>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-xs font-semibold text-[#1a1a1a] mb-1.5">Password</label>
            <input type="password" id="password" name="password" class="auth-input <?php echo isset($errors['password']) ? 'error' : ''; ?>" placeholder="Create a strong password" required />
            <?php if (isset($errors['password'])): ?>
                <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['password']; ?></div>
            <?php endif; ?>
            <!-- Password strength indicator (visual only) -->
            <div class="password-strength" id="passwordStrength">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <p class="password-strength-text" id="passwordStrengthText">Use at least 6 characters</p>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="confirm_password" class="block text-xs font-semibold text-[#1a1a1a] mb-1.5">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="auth-input <?php echo isset($errors['confirm_password']) ? 'error' : ''; ?>" placeholder="Confirm your password" required />
            <?php if (isset($errors['confirm_password'])): ?>
                <div class="field-error"><i class='bx bx-error-circle'></i> <?php echo $errors['confirm_password']; ?></div>
            <?php endif; ?>
        </div>

        <!-- Terms & Conditions -->
        <div class="mb-5">
            <div class="checkbox-wrapper <?php echo isset($errors['agree_terms']) ? 'border-2 border-red-500 rounded-lg p-2 -mx-2' : ''; ?>">
                <input type="checkbox" id="agree_terms" name="agree_terms" <?php echo isset($_POST['agree_terms']) ? 'checked' : ''; ?> />
                <label for="agree_terms">
                    I agree to the <a href="terms.php" target="_blank">Terms & Conditions</a> and <a href="privacy.php" target="_blank">Privacy Policy</a>
                </label>
            </div>
            <?php if (isset($errors['agree_terms'])): ?>
                <div class="field-error mt-1"><i class='bx bx-error-circle'></i> <?php echo $errors['agree_terms']; ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-primary">
            <span>Create Account</span>
            <i class='bx bx-user-plus text-lg'></i>
        </button>
    </form>

    <!-- Divider -->
    <div class="flex items-center gap-3 my-5">
        <span class="divider-line"></span>
        <span class="text-[11px] uppercase tracking-wider text-[#9aa0a6] font-medium">or sign up with</span>
        <span class="divider-line"></span>
    </div>

    <!-- Social Login -->
    <div class="flex justify-center gap-3">
        <button class="social-btn" onclick="alert('🔓 Google signup (demo)')"><i class='bx bxl-google'></i></button>
    </div>

    <!-- Login Link -->
    <div class="text-center text-sm text-[#5f6368] mt-5">
        Already have an account? <a href="login.php" class="auth-link font-semibold">Log in</a>
    </div>
</div>

<script>
// ============================================================
// PASSWORD STRENGTH INDICATOR
// ============================================================
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const bars = document.querySelectorAll('#passwordStrength .bar');
    const text = document.getElementById('passwordStrengthText');
    
    let strength = 0;
    let label = 'Use at least 6 characters';
    let colorClass = '';
    
    if (password.length >= 6) {
        strength = 1;
        label = 'Weak';
        colorClass = 'weak';
        
        // Check for mixed case
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
            strength = 2;
            label = 'Medium';
            colorClass = 'medium';
        }
        
        // Check for numbers and special characters
        if (strength >= 2 && /[0-9]/.test(password) && /[^a-zA-Z0-9]/.test(password)) {
            strength = 3;
            label = 'Strong';
            colorClass = 'strong';
        } else if (strength >= 2 && (/[0-9]/.test(password) || /[^a-zA-Z0-9]/.test(password))) {
            strength = 2;
            label = 'Medium';
            colorClass = 'medium';
        }
    }
    
    // Update bars
    bars.forEach((bar, index) => {
        bar.className = 'bar';
        if (index < strength) {
            bar.classList.add(colorClass);
        }
    });
    
    text.textContent = password.length >= 6 ? label : 'Use at least 6 characters';
});
</script>

</body>
</html>