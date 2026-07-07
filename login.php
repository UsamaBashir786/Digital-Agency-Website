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
  <style>
    :root { --lime: #A6F13B; --lime-dark: #8BD82E; }
    * { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
    body { background: #0c0c0c; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
    .lime { color: var(--lime); }
    .bg-lime { background: var(--lime); }
    .auth-card {
      width: 100%; max-width: 440px;
      border-radius: 2.5rem;
      background: radial-gradient(140% 150% at 10% 0%, #262626 0%, #141414 55%, #0c0c0c 100%);
      border: 1px solid rgba(255,255,255,0.06);
      box-shadow: 0 30px 60px -15px rgba(0,0,0,0.8);
      padding: 2rem 1.75rem;
    }
    .brand-icon { background: #1a1a1a; border-radius: 9999px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; }
    .auth-input { 
      background: #141414; 
      border: 1px solid rgba(255,255,255,0.08); 
      border-radius: 9999px; 
      padding: 0.9rem 1.2rem; 
      width: 100%; 
      color: #ffffff; 
      font-size: 0.95rem; 
      transition: border 0.2s, box-shadow 0.2s; 
    }
    .auth-input:focus { border-color: #A6F13B; outline: none; box-shadow: 0 0 0 3px rgba(166, 241, 59, 0.15); }
    .auth-input::placeholder { color: #888888; }
    .btn-primary { 
      background: #A6F13B; 
      color: #0c0c0c; 
      font-weight: 700; 
      border-radius: 9999px; 
      padding: 0.9rem 1.2rem; 
      width: 100%; 
      border: none; 
      font-size: 1rem; 
      transition: background 0.2s, transform 0.1s; 
      cursor: pointer; 
    }
    .btn-primary:hover { background: #8BD82E; }
    .btn-primary:active { transform: scale(0.98); }
    .auth-link { color: #dddddd; transition: color 0.2s; text-decoration: none; }
    .auth-link:hover { color: #A6F13B; }
    .divider-line { flex: 1; height: 1px; background: rgba(255,255,255,0.08); }
    .social-btn { 
      background: #1a1a1a; 
      border: 1px solid rgba(255,255,255,0.06); 
      border-radius: 9999px; 
      width: 48px; 
      height: 48px; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      color: #ffffff; 
      transition: background 0.2s, border-color 0.2s, transform 0.2s; 
      cursor: pointer; 
    }
    .social-btn:hover { background: #262626; border-color: rgba(166, 241, 59, 0.3); transform: translateY(-2px); }
    .social-btn i { font-size: 1.3rem; }
    .back-home { 
      color: #aaaaaa; 
      transition: color 0.2s; 
      font-size: 0.85rem; 
      display: inline-flex; 
      align-items: center; 
      gap: 4px; 
      text-decoration: none; 
    }
    .back-home:hover { color: #A6F13B; }
    
    /* Nav link underline animation */
    .nav-link {
      position: relative;
      text-decoration: none;
      color: #e5e5e5;
      transition: color 0.3s ease;
      padding-bottom: 2px;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background-color: #A6F13B;
      transition: width 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .nav-link:hover { color: #ffffff; }
    .nav-link:hover::after { width: 100%; }
    
    @media (max-width: 480px) { .auth-card { padding: 1.5rem 1.25rem; } }
  </style>
</head>
<body>

<div class="auth-card">
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