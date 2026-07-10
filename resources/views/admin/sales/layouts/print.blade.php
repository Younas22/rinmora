<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Print') — Rinmora</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

@php
  $__theme = \App\Models\Setting::getByGroup('theme');
  $__themePrimary = $__theme['primary_color'] ?? '#CFBAA5';
  $__themeSecondary = $__theme['secondary_color'] ?? '#000000';
  $__themeAccent = $__theme['accent_color'] ?? '#3B82F6';
  $__themeBackground = $__theme['background_color'] ?? '#F8F8F8';
@endphp
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: '{{ $__themePrimary }}', 'primary-dark': '{{ darkenHex($__themePrimary) }}', ink: '{{ $__themeSecondary }}',
          canvas: '{{ $__themeBackground }}',
          success: '#22C55E', warning: '#F59E0B', danger: '#EF4444', info: '{{ $__themeAccent }}',
        },
        fontFamily: { sans: ['Inter', 'sans-serif'] },
      },
    },
  };
</script>

<style>
  body { font-family: 'Inter', sans-serif; }
  @media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    .print-card { box-shadow: none !important; border-radius: 0 !important; }
  }
</style>
</head>

<body class="bg-canvas text-ink antialiased">

<div class="no-print sticky top-0 z-40 bg-white border-b border-black/5 flex items-center justify-between px-4 md:px-8 py-4">
  <div class="flex items-center gap-3">
    <a href="{{ url()->previous() }}" class="w-9 h-9 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-arrow-left text-sm"></i></a>
    <span class="text-sm font-semibold">@yield('title', 'Print')</span>
  </div>
  <button onclick="window.print()" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
    <i class="fa-solid fa-print text-[10px]"></i> Print
  </button>
</div>

<div class="max-w-2xl mx-auto px-4 py-8">
  @yield('content')
</div>

</body>
</html>
