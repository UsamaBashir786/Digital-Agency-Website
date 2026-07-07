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
  <link rel="stylesheet" href="style.css">
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