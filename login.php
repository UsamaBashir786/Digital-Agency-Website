<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
  <title>Login — 4 Digi Sol</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/styles/styles.css">
  <style>
    <link rel="stylesheet" href="assets/styles/styles.css">
<style>
  html, body {
    height: auto;
    min-height: 100%;
    margin: 0;
  }
  body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    overflow-y: auto;
  }
  .auth-card {
    margin: auto;
  }
</style>
  </style>
</head>
<body>

<div class="auth-card" style="">
  <!-- Back to home -->
  <div class="flex justify-between items-center mb-4">
    <a href="index.php" class="back-home"><i class='bx bx-arrow-back'></i> Back</a>
    <div class="flex items-center gap-1.5 font-bold text-sm">
      <i class='bx bx-sparkle text-lime'></i>
      <span class="text-white">4 Digi Sol</span>
    </div>
  </div>

  <!-- Brand Header -->
  <div class="flex items-center gap-3 mb-6">
    <div class="brand-icon"><i class='bx bx-sparkle text-2xl lime'></i></div>
    <span class="text-xl font-bold tracking-tight text-white">Welcome Back</span>
    <span class="ml-auto text-[10px] font-medium uppercase tracking-wider text-white/30 border border-white/10 rounded-full px-3 py-0.5">login</span>
  </div>

  <h2 class="text-xl font-semibold mb-1 text-white">Log in to your account</h2>
  <p class="text-sm text-gray-400 mb-6">Access your dashboard and continue creating.</p>

  <!-- Login Form -->
  <form onsubmit="event.preventDefault(); alert('✅ Login successful! Redirecting to dashboard...');">
    <div class="mb-4">
      <label for="email" class="block text-xs font-medium text-gray-300 mb-1.5">Email address</label>
      <input type="email" id="email" class="auth-input" placeholder="hello@4digisol.com" required />
    </div>
    <div class="mb-5">
      <div class="flex items-center justify-between mb-1.5">
        <label for="password" class="block text-xs font-medium text-gray-300">Password</label>
        <a href="#" class="text-xs text-gray-500 hover:text-lime transition" onclick="alert('🔐 Password reset link sent to your email.'); return false;">Forgot password?</a>
      </div>
      <input type="password" id="password" class="auth-input" placeholder="••••••••" required />
    </div>
    <button type="submit" class="btn-primary flex items-center justify-center gap-2">
      <span>Log In</span>
      <i class='bx bx-log-in text-lg'></i>
    </button>
  </form>

  <!-- Divider -->
  <div class="flex items-center gap-3 my-6">
    <span class="divider-line"></span>
    <span class="text-[11px] uppercase tracking-wider text-gray-500">or continue with</span>
    <span class="divider-line"></span>
  </div>

  <!-- Social Login -->
  <div class="flex justify-center gap-3">
    <button class="social-btn" onclick="alert('🔓 Google login (demo)')"><i class='bx bxl-google'></i></button>
    <button class="social-btn" onclick="alert('🔓 GitHub login (demo)')"><i class='bx bxl-github'></i></button>
    <button class="social-btn" onclick="alert('🔓 Apple login (demo)')"><i class='bx bxl-apple'></i></button>
  </div>

  <!-- Register Link -->
  <div class="text-center text-sm text-gray-400 mt-6">
    Don't have an account? <a href="register.php" class="auth-link font-medium">Sign up free</a>
  </div>

  <!-- Demo Hint -->
  <div class="mt-5 pt-4 border-t border-white/5 text-[10px] text-center text-gray-500/60 flex items-center justify-center gap-2">
    <i class='bx bx-info-circle'></i>
    <span>Demo login · any credentials work</span>
  </div>
</div>

</body>
</html>