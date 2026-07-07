<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
  <title>Creatix · Register</title>
  <!-- Tailwind + Boxicons (same as landing) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet' />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    :root {
      --lime: #A6F13B;
      --lime-dark: #8BD82E;
    }
    * { font-family: 'Manrope', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
    body { 
      background: #0c0c0c; 
      min-height: 100vh; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      padding: 1rem; 
    }
    .lime { color: var(--lime); }
    .bg-lime { background: var(--lime); }
    .noise-card {
      background: radial-gradient(120% 140% at 15% 0%, #262626 0%, #141414 55%, #0c0c0c 100%);
    }
    .focus-ring:focus-visible { outline: 2px solid var(--lime); outline-offset: 2px; }
    .auth-card {
      width: 100%;
      max-width: 440px;
      border-radius: 2.5rem;
      background: radial-gradient(140% 150% at 10% 0%, #262626 0%, #141414 55%, #0c0c0c 100%);
      border: 1px solid rgba(255,255,255,0.06);
      box-shadow: 0 30px 60px -15px rgba(0,0,0,0.8);
      padding: 2rem 1.75rem;
    }
    .brand-icon {
      background: #1a1a1a;
      border-radius: 9999px;
      width: 48px;
      height: 48px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .auth-input {
      background: #141414;
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 9999px;
      padding: 0.9rem 1.2rem;
      width: 100%;
      color: #ffffff;
      font-size: 0.95rem;
      transition: border 0.2s;
    }
    .auth-input:focus {
      border-color: #A6F13B;
      outline: none;
      box-shadow: 0 0 0 3px rgba(166, 241, 59, 0.15);
    }
    .auth-input::placeholder { color: #aaaaaa; }
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
    .auth-link { color: #dddddd; transition: color 0.2s; }
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
      transition: background 0.2s, border-color 0.2s;
      cursor: pointer;
    }
    .social-btn:hover { background: #262626; border-color: rgba(166, 241, 59, 0.3); }
    .social-btn i { font-size: 1.3rem; }
    .back-home {
      color: #cccccc;
      transition: color 0.2s;
      font-size: 0.9rem;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }
    .back-home:hover { color: #A6F13B; }
    .text-white-force { color: #ffffff !important; }
    .text-gray-light { color: #e0e0e0; }
    @media (max-width: 480px) {
      .auth-card { padding: 1.5rem 1.25rem; }
    }
  </style>
</head>
<body>

<div class="auth-card">
  <!-- back to landing (subtle) -->
  <div class="flex justify-end mb-1">
    <a href="#" class="back-home" onclick="alert('🔙 Navigate to landing page (index.php)'); return false;">
      <i class='bx bx-arrow-back'></i> Back
    </a>
  </div>

  <!-- brand header -->
  <div class="flex items-center gap-3 mb-6">
    <div class="brand-icon">
      <i class='bx bx-sparkle text-2xl lime'></i>
    </div>
    <span class="text-xl font-bold tracking-tight text-white">Creatix</span>
    <span class="ml-auto text-[10px] font-medium uppercase tracking-wider text-white/40 border border-white/10 rounded-full px-3 py-0.5">register</span>
  </div>

  <!-- welcome -->
  <h1 class="text-2xl font-bold tracking-tight mb-1 text-white">Create account</h1>
  <p class="text-sm text-gray-300 mb-6">Start your creative journey with Creatix.</p>

  <!-- register form -->
  <form onsubmit="event.preventDefault(); alert('✅ Registration successful (demo)');">
    <div class="mb-4">
      <label for="fullname" class="block text-xs font-medium text-gray-200 mb-1.5">Full name</label>
      <input type="text" id="fullname" class="auth-input" placeholder="John Doe" required />
    </div>
    <div class="mb-4">
      <label for="email" class="block text-xs font-medium text-gray-200 mb-1.5">Email address</label>
      <input type="email" id="email" class="auth-input" placeholder="hello@creatix.design" required />
    </div>
    <div class="mb-4">
      <label for="password" class="block text-xs font-medium text-gray-200 mb-1.5">Password</label>
      <input type="password" id="password" class="auth-input" placeholder="Create a strong password" required />
    </div>
    <div class="mb-5">
      <label for="confirm" class="block text-xs font-medium text-gray-200 mb-1.5">Confirm password</label>
      <input type="password" id="confirm" class="auth-input" placeholder="Confirm your password" required />
    </div>

    <button type="submit" class="btn-primary mt-1">
      <span>Create account</span>
      <i class='bx bx-user-plus ml-1.5 text-lg align-middle'></i>
    </button>
  </form>

  <!-- divider -->
  <div class="flex items-center gap-3 my-6">
    <span class="divider-line"></span>
    <span class="text-[11px] uppercase tracking-wider text-gray-400">or sign up with</span>
    <span class="divider-line"></span>
  </div>

  <!-- social signup -->
  <div class="flex justify-center gap-3">
    <button class="social-btn" aria-label="Google" onclick="alert('🔓 Google signup (demo)')">
      <i class='bx bxl-google'></i>
    </button>
    <button class="social-btn" aria-label="GitHub" onclick="alert('🔓 GitHub signup (demo)')">
      <i class='bx bxl-github'></i>
    </button>
    <button class="social-btn" aria-label="Apple" onclick="alert('🔓 Apple signup (demo)')">
      <i class='bx bxl-apple'></i>
    </button>
  </div>

  <!-- login link -->
  <div class="text-center text-sm text-gray-300 mt-6">
    Already have an account?
    <a href="#" class="auth-link font-medium" onclick="alert('🔑 Navigate to Login page (login.php)'); return false;">Log in</a>
  </div>

  <!-- extra: demo hint -->
  <div class="mt-5 pt-4 border-t border-white/5 text-[10px] text-center text-gray-400/70 flex items-center justify-center gap-2">
    <i class='bx bx-info-circle'></i>
    <span>Demo registration · any credentials work</span>
  </div>
</div>

</body>
</html>