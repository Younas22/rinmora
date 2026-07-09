<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard') — Rinmora Admin</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: '#CFBAA5', 'primary-dark': '#b89e84', ink: '#000000',
          canvas: '#F8F8F8',
          success: '#22C55E', warning: '#F59E0B', danger: '#EF4444', info: '#3B82F6',
        },
        fontFamily: { sans: ['Inter', 'sans-serif'] },
        borderRadius: { '4xl': '2rem' },
        boxShadow: { soft: '0 20px 60px -15px rgba(0,0,0,0.12)', card: '0 4px 24px -8px rgba(0,0,0,0.08)' },
      },
    },
  };
</script>

<style>
  html { -webkit-tap-highlight-color: transparent; }
  body { font-family: 'Inter', sans-serif; }
  ::-webkit-scrollbar { display: none; }
  * { scrollbar-width: none; -ms-overflow-style: none; }
  .fade-up { animation: fadeUp .5s ease both; }
  @keyframes fadeUp { from { opacity:0; transform: translateY(10px);} to {opacity:1; transform:translateY(0);} }
  .hover-lift { transition: transform .2s ease, box-shadow .2s ease; }
  .hover-lift:hover { transform: translateY(-2px); }

  .sidebar-collapsed .nav-label,
  .sidebar-collapsed .nav-section-label,
  .sidebar-collapsed .sidebar-brand-text,
  .sidebar-collapsed .nav-chevron { display: none; }
  .sidebar-collapsed .submenu { display: none !important; }
</style>
@stack('styles')
</head>

<body class="bg-canvas text-ink antialiased">

@include('admin.catalog.partials.topbar')

<div class="flex">
    @include('admin.catalog.partials.sidebar')

    <main class="flex-1 min-w-0 px-4 md:px-6 py-6">
        <nav aria-label="Breadcrumb" class="text-xs text-black/40 mb-2">
            <span>Admin</span> <i class="fa-solid fa-chevron-right text-[8px] mx-1.5"></i>
            <span class="text-ink font-medium">@yield('title', 'Dashboard')</span>
        </nav>

        @if (session('success'))
            <div class="bg-success/10 text-success text-sm font-medium rounded-2xl px-4 py-3 mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-danger/10 text-danger text-sm font-medium rounded-2xl px-4 py-3 mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-danger/10 text-danger text-sm rounded-2xl px-4 py-3 mb-4">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script>
  const sidebar = document.getElementById('sidebar');
  const sidebarOverlay = document.getElementById('sidebarOverlay');
  const mobileSidebarBtn = document.getElementById('mobileSidebarBtn');
  const collapseSidebarBtn = document.getElementById('collapseSidebarBtn');

  function openSidebar() {
    sidebar.classList.remove('-translate-x-full');
    sidebarOverlay.classList.remove('invisible', 'pointer-events-none', 'bg-black/0');
    sidebarOverlay.classList.add('bg-black/40');
  }
  function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    sidebarOverlay.classList.add('bg-black/0');
    setTimeout(() => sidebarOverlay.classList.add('invisible', 'pointer-events-none'), 200);
  }
  mobileSidebarBtn?.addEventListener('click', openSidebar);
  sidebarOverlay?.addEventListener('click', closeSidebar);
  collapseSidebarBtn?.addEventListener('click', () => document.body.classList.toggle('sidebar-collapsed'));

  document.querySelectorAll('.submenu-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
      const submenu = btn.nextElementSibling;
      const chevron = btn.querySelector('.nav-chevron');
      submenu.classList.toggle('hidden');
      chevron.classList.toggle('rotate-180');
    });
  });

  document.querySelectorAll('[data-dropdown-toggle]').forEach(btn => {
    const menu = document.getElementById(btn.dataset.dropdownToggle);
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      document.querySelectorAll('[id$="Menu"].absolute').forEach(m => { if (m !== menu) m.classList.add('hidden'); });
      menu.classList.toggle('hidden');
    });
  });
  document.addEventListener('click', () => {
    document.querySelectorAll('[id$="Menu"].absolute').forEach(m => m.classList.add('hidden'));
  });
</script>
@stack('scripts')

</body>
</html>
