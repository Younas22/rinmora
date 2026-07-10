@php
    $productsActive = request()->routeIs('admin.catalog.products.*', 'admin.catalog.categories.*', 'admin.catalog.brands.*', 'admin.catalog.collections.*', 'admin.catalog.attributes.*', 'admin.catalog.reviews.*', 'admin.catalog.inventory.*');
    $ordersActive = request()->routeIs('admin.sales.orders.*');
    $customersActive = request()->routeIs('admin.customers.*');
@endphp

<div id="sidebarOverlay" class="fixed inset-0 bg-black/0 z-30 lg:hidden invisible pointer-events-none transition-colors duration-300"></div>

<aside id="sidebar" class="fixed lg:sticky top-16 left-0 z-30 h-[calc(100vh-4rem)] w-72 bg-white border-r border-black/5 -translate-x-full lg:translate-x-0 transition-all duration-300 ease-out overflow-y-auto shrink-0">
  <nav class="p-4 space-y-1">
    <p class="nav-section-label px-3 pt-2 pb-2 text-[11px] font-semibold uppercase tracking-wider text-black/35">Main</p>

    <a href="{{ route('admin.dashboard.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition {{ request()->routeIs('admin.dashboard.index') ? 'bg-primary/20 text-ink' : 'text-black/65 hover:bg-black/5' }}">
      <i class="fa-solid fa-gauge w-4 text-center"></i> <span class="nav-label">Dashboard</span>
    </a>

    <div>
      <button class="submenu-toggle w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $productsActive ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}">
        <span class="flex items-center gap-3"><i class="fa-solid fa-bag-shopping w-4 text-center"></i> <span class="nav-label">Products</span></span>
        <i class="fa-solid fa-chevron-down nav-chevron text-[10px] transition-transform {{ $productsActive ? 'rotate-180' : '' }}"></i>
      </button>
      <div class="submenu {{ $productsActive ? '' : 'hidden' }} pl-11 space-y-1 mt-1">
        <a href="{{ route('admin.catalog.products.index') }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.catalog.products.index') ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">All Products</a>
        <a href="{{ route('admin.catalog.products.create') }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.catalog.products.create', 'admin.catalog.products.edit') ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">Add Product</a>
        <a href="{{ route('admin.catalog.categories.index') }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.catalog.categories.*') ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">Categories</a>
        <a href="{{ route('admin.catalog.brands.index') }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.catalog.brands.*', 'admin.catalog.collections.*') ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">Brands &amp; Collections</a>
        <a href="{{ route('admin.catalog.attributes.index') }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.catalog.attributes.*') ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">Attributes</a>
        <a href="{{ route('admin.catalog.reviews.index') }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.catalog.reviews.*') ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">Reviews</a>
        <a href="{{ route('admin.catalog.inventory.index') }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.catalog.inventory.*') ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">Inventory</a>
      </div>
    </div>

    <div>
      <button class="submenu-toggle w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $ordersActive ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}">
        <span class="flex items-center gap-3"><i class="fa-solid fa-receipt w-4 text-center"></i> <span class="nav-label">Orders</span></span>
        <i class="fa-solid fa-chevron-down nav-chevron text-[10px] transition-transform {{ $ordersActive ? 'rotate-180' : '' }}"></i>
      </button>
      <div class="submenu {{ $ordersActive ? '' : 'hidden' }} pl-11 space-y-1 mt-1">
        <a href="{{ route('admin.sales.orders.index') }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.sales.orders.index') && !request('tab') ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">All Orders</a>
        <a href="{{ route('admin.sales.orders.index', ['tab' => 'pending']) }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request('tab') === 'pending' ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">Pending</a>
        <a href="{{ route('admin.sales.orders.index', ['tab' => 'shipped']) }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request('tab') === 'shipped' ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">Shipped</a>
        <a href="{{ route('admin.sales.orders.index', ['tab' => 'returned']) }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request('tab') === 'returned' ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">Returned / Refunded</a>
      </div>
    </div>

    <div>
      <button class="submenu-toggle w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $customersActive ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}">
        <span class="flex items-center gap-3"><i class="fa-solid fa-users w-4 text-center"></i> <span class="nav-label">Customers</span></span>
        <i class="fa-solid fa-chevron-down nav-chevron text-[10px] transition-transform {{ $customersActive ? 'rotate-180' : '' }}"></i>
      </button>
      <div class="submenu {{ $customersActive ? '' : 'hidden' }} pl-11 space-y-1 mt-1">
        <a href="{{ route('admin.customers.index') }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.customers.index', 'admin.customers.show', 'admin.customers.create', 'admin.customers.edit') ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">All Customers</a>
        <a href="{{ route('admin.customers.addresses.index') }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.customers.addresses.*') ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">Addresses</a>
        <a href="{{ route('admin.customers.wishlist.index') }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.customers.wishlist.*') ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">Wishlist Reports</a>
        <a href="{{ route('admin.customers.reward-points.index') }}" class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.customers.reward-points.*') ? 'text-ink font-medium bg-black/5' : 'text-black/60 hover:bg-black/5 hover:text-ink' }}">Reward Points</a>
      </div>
    </div>

    <p class="nav-section-label px-3 pt-5 pb-2 text-[11px] font-semibold uppercase tracking-wider text-black/35">Content &amp; Store</p>

    {{-- Phase 2+ items below: static placeholders until those modules are built --}}
    <a href="{{ route('admin.cms.homepage-sections.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.cms.homepage-sections.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-solid fa-file-lines w-4 text-center"></i> <span class="nav-label">CMS</span></a>
    <a href="{{ route('admin.pages.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.pages.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-regular fa-file w-4 text-center"></i> <span class="nav-label">Pages</span></a>
    <a href="{{ route('admin.cms.faqs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.cms.faqs.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-regular fa-circle-question w-4 text-center"></i> <span class="nav-label">FAQs</span></a>
    <a href="{{ route('admin.cms.media.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.cms.media.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-regular fa-images w-4 text-center"></i> <span class="nav-label">Media Manager</span></a>
    <a href="{{ route('admin.sales.shipping.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.sales.shipping.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-solid fa-truck-fast w-4 text-center"></i> <span class="nav-label">Shipping</span></a>
    <a href="{{ route('admin.sales.payments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.sales.payments.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-solid fa-credit-card w-4 text-center"></i> <span class="nav-label">Payments</span></a>
    <a href="{{ route('admin.system.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.system.users.*') || request()->routeIs('admin.system.roles.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-solid fa-user-shield w-4 text-center"></i> <span class="nav-label">Users &amp; Roles</span></a>
    <a href="{{ route('admin.system.reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.system.reports.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-solid fa-chart-line w-4 text-center"></i> <span class="nav-label">Reports</span></a>

    <p class="nav-section-label px-3 pt-5 pb-2 text-[11px] font-semibold uppercase tracking-wider text-black/35">System</p>

    <a href="{{ route('admin.cms.seo.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.cms.seo.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-solid fa-magnifying-glass-chart w-4 text-center"></i> <span class="nav-label">SEO</span></a>
    <a href="{{ route('admin.system.support.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.system.support.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-solid fa-headset w-4 text-center"></i> <span class="nav-label">Contact &amp; Support</span></a>
    <a href="{{ route('admin.cms.notifications.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.cms.notifications.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-solid fa-bell w-4 text-center"></i> <span class="nav-label">Notifications</span></a>
    <a href="{{ route('admin.system.activity.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.system.activity.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-solid fa-clock-rotate-left w-4 text-center"></i> <span class="nav-label">Activity Logs</span></a>

    <p class="nav-section-label px-3 pt-5 pb-2 text-[11px] font-semibold uppercase tracking-wider text-black/35">Account</p>

    <a href="{{ route('admin.system.profile.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.system.profile.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-regular fa-user w-4 text-center"></i> <span class="nav-label">My Profile</span></a>
    <a href="{{ route('admin.system.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('admin.system.settings.*') ? 'text-ink bg-black/5' : 'text-black/65 hover:bg-black/5' }}"><i class="fa-solid fa-gear w-4 text-center"></i> <span class="nav-label">Settings</span></a>
    <form method="POST" action="{{ route('admin.logout') }}">
      @csrf
      <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-black/65 hover:bg-black/5 font-medium text-sm transition text-left">
        <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> <span class="nav-label">Logout</span>
      </button>
    </form>
  </nav>
</aside>
