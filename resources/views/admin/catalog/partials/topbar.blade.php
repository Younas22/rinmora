<header class="sticky top-0 z-40 bg-white border-b border-black/5">
  <div class="flex items-center gap-3 h-16 px-4 md:px-6">
    <button id="mobileSidebarBtn" aria-label="Open sidebar" class="lg:hidden w-9 h-9 grid place-items-center rounded-full hover:bg-black/5 transition">
      <i class="fa-solid fa-bars"></i>
    </button>
    <button id="collapseSidebarBtn" aria-label="Collapse sidebar" class="hidden lg:grid w-9 h-9 place-items-center rounded-full hover:bg-black/5 transition">
      <i class="fa-solid fa-bars"></i>
    </button>

    <a href="{{ route('admin.dashboard.index') }}" class="flex items-center gap-2 shrink-0">
      <img src="{{ asset('logo-01.png') }}" alt="Rinmora" class="h-7 w-auto">
      <span class="hidden sm:inline text-[10px] font-semibold uppercase tracking-wider bg-ink text-white px-2 py-0.5 rounded-full">Admin</span>
    </a>

    <div class="flex-1 max-w-xl mx-auto hidden sm:block">
      <div class="relative">
        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-sm"></i>
        <label for="globalSearch" class="sr-only">Global search</label>
        <input id="globalSearch" type="text" placeholder="Search products, categories..." class="w-full pl-11 pr-4 py-2.5 rounded-full bg-black/[0.03] border border-transparent text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
      </div>
    </div>

    <div class="flex items-center gap-1 ml-auto sm:ml-0">
      <div class="relative">
        <button data-dropdown-toggle="quickActionsMenu" class="hidden md:inline-flex items-center gap-2 bg-primary text-ink font-semibold text-xs uppercase tracking-wide px-4 py-2.5 rounded-full hover:bg-primary-dark transition">
          <i class="fa-solid fa-plus text-[10px]"></i> Quick Actions
        </button>
        <div id="quickActionsMenu" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-soft border border-black/5 p-2 z-50">
          <a href="{{ route('admin.catalog.products.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm hover:bg-black/5 transition"><i class="fa-solid fa-bag-shopping w-4 text-black/40"></i> New Product</a>
          <a href="{{ route('admin.catalog.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm hover:bg-black/5 transition"><i class="fa-solid fa-folder w-4 text-black/40"></i> New Category</a>
          <a href="{{ route('admin.sales.orders.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm hover:bg-black/5 transition"><i class="fa-solid fa-receipt w-4 text-black/40"></i> New Order</a>
        </div>
      </div>

      <button aria-label="Toggle theme" class="w-9 h-9 grid place-items-center rounded-full hover:bg-black/5 transition" title="Not wired up yet">
        <i class="fa-regular fa-moon text-sm"></i>
      </button>

      <div class="relative pl-1">
        <button data-dropdown-toggle="profileMenu" class="flex items-center gap-2 pl-1.5 pr-2.5 py-1.5 rounded-full hover:bg-black/5 transition">
          <span class="w-7 h-7 rounded-full bg-primary/30 grid place-items-center text-xs font-semibold">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
          <span class="hidden md:inline text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</span>
          <i class="fa-solid fa-chevron-down text-[10px] text-black/40"></i>
        </button>
        <div id="profileMenu" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-soft border border-black/5 p-2 z-50">
          <span class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-black/30 cursor-not-allowed" title="Coming in a later phase"><i class="fa-regular fa-user w-4"></i> My Profile</span>
          <div class="border-t border-black/5 my-1"></div>
          <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-danger hover:bg-danger/5 transition"><i class="fa-solid fa-right-from-bracket w-4"></i> Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</header>
