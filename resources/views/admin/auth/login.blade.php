<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login - Rinmora</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

@php
  $__theme = \App\Models\Setting::getByGroup('theme');
  $__themePrimary = $__theme['primary_color'] ?? '#CFBAA5';
  $__themeSecondary = $__theme['secondary_color'] ?? '#000000';
@endphp
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: { primary: '{{ $__themePrimary }}', 'primary-dark': '{{ darkenHex($__themePrimary) }}', ink: '{{ $__themeSecondary }}' },
        fontFamily: { sans: ['Poppins', 'sans-serif'], body: ['Manrope', 'sans-serif'] },
        borderRadius: { '4xl': '2rem', '5xl': '2.5rem' },
        boxShadow: { soft: '0 20px 60px -15px rgba(0,0,0,0.15)', card: '0 10px 40px -12px rgba(0,0,0,0.12)' },
      },
    },
  };
</script>

<style>
  html { -webkit-tap-highlight-color: transparent; }
  body { font-family: 'Manrope', sans-serif; }
  .font-display { font-family: 'Poppins', sans-serif; }
  .fade-up { animation: fadeUp .6s cubic-bezier(.16,1,.3,1) both; }
  @keyframes fadeUp { from { opacity:0; transform: translateY(16px);} to {opacity:1; transform:translateY(0);} }
  .btn-ripple { position: relative; overflow: hidden; }
  .btn-ripple span.ripple { position: absolute; border-radius: 9999px; transform: scale(0); animation: ripple .6s linear; background: rgba(0,0,0,0.15); pointer-events: none; }
  @keyframes ripple { to { transform: scale(3); opacity: 0; } }
</style>
</head>

<body class="bg-white text-ink antialiased min-h-screen">

<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-black/5">
  <div class="max-w-7xl mx-auto px-5 md:px-8 lg:px-10">
    <div class="flex items-center justify-between h-16 md:h-20">
      <span class="select-none">
        <img src="{{ asset('public/logo-01.png') }}" alt="Rinmora" class="h-10 md:h-12 w-auto">
      </span>
      <span class="font-display text-xs font-semibold uppercase tracking-wide text-black/40">
        Admin Portal
      </span>
    </div>
  </div>
</header>

<main class="lg:grid lg:grid-cols-2 min-h-[calc(100vh-64px)] lg:min-h-[calc(100vh-80px)]">

  <div class="hidden lg:block relative">
    <img src="https://picsum.photos/seed/rinmora-admin-login/900/1200" alt="Rinmora handbag collection" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/0 to-black/0"></div>
    <div class="absolute bottom-10 left-10 right-10 text-white">
      <p class="font-display text-2xl font-semibold leading-snug">"Elegance you can carry, every day."</p>
      <p class="text-white/70 text-sm mt-2">— Rinmora Admin</p>
    </div>
  </div>

  <div class="flex items-center justify-center px-5 md:px-8 py-12 md:py-16">
    <div class="w-full max-w-sm fade-up">
      <div class="text-center mb-9">
        <span class="font-display text-xs tracking-[0.25em] uppercase text-primary-dark font-semibold">Welcome Back</span>
        <h1 class="font-display text-2xl md:text-3xl font-semibold mt-2">Sign In</h1>
        <p class="text-black/50 text-sm mt-2">Sign in to manage products, orders, and your storefront.</p>
      </div>

      @if (session('success'))
        <p class="text-sm text-green-700 bg-green-50 border border-green-100 rounded-xl px-4 py-3 mb-5">
          {{ session('success') }}
        </p>
      @endif

      @if ($errors->any())
        <p class="text-sm text-red-600 bg-red-50 border border-red-100 rounded-xl px-4 py-3 mb-5">
          @foreach ($errors->all() as $error)
            {{ $error }}@if (!$loop->last)<br>@endif
          @endforeach
        </p>
      @endif

      <form method="POST" action="{{ route('admin.signin.post') }}" class="space-y-5">
        @csrf
        <div>
          <label for="email" class="block text-xs font-display font-medium text-black/50 mb-2">Email Address</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com" class="w-full px-5 py-3.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
        </div>

        <div>
          <label for="password" class="block text-xs font-display font-medium text-black/50 mb-2">Password</label>
          <div class="relative">
            <input id="password" type="password" name="password" required placeholder="Enter your password" class="w-full px-5 py-3.5 pr-12 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            <button type="button" class="password-toggle absolute right-4 top-1/2 -translate-y-1/2 text-black/35 hover:text-ink transition" aria-label="Show password" data-target="password">
              <i class="fa-regular fa-eye text-sm"></i>
            </button>
          </div>
        </div>

        <div class="flex items-center text-sm">
          <label class="flex items-center gap-2.5 text-black/60 cursor-pointer">
            <input type="checkbox" name="remember" value="1" class="w-4 h-4 rounded">
            Remember Me
          </label>
        </div>

        <button type="submit" class="btn-ripple w-full bg-primary text-ink font-display font-semibold text-sm uppercase tracking-wide py-4 rounded-full hover:bg-primary-dark transition">
          Sign In to Dashboard
        </button>
      </form>

      <p class="flex items-center justify-center gap-2 text-[11px] text-black/40 mt-8">
        <i class="fa-solid fa-lock"></i>
        Secure admin access for authorized personnel only.
      </p>
    </div>
  </div>
</main>

<script>
  document.querySelectorAll('.password-toggle').forEach(btn => {
    btn.addEventListener('click', function () {
      const input = document.getElementById(this.dataset.target);
      const icon = this.querySelector('i');
      const isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    });
  });

  document.querySelectorAll('.btn-ripple').forEach(btn => {
    btn.addEventListener('click', function (e) {
      const rect = this.getBoundingClientRect();
      const ripple = document.createElement('span');
      ripple.className = 'ripple';
      const size = Math.max(rect.width, rect.height);
      ripple.style.width = ripple.style.height = size + 'px';
      ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
      ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
      this.appendChild(ripple);
      setTimeout(() => ripple.remove(), 650);
    });
  });
</script>

</body>
</html>
