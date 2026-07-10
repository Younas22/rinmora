@extends('admin.catalog.layouts.app')

@section('title', 'Users & Roles')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Users &amp; Roles</h1>
            <p class="text-black/45 text-sm mt-1">Manage staff accounts, roles, and permissions.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" id="addUserBtn" class="section-users-only inline-flex items-center gap-2 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
                <i class="fa-solid fa-user-plus text-[10px]"></i> Add User
            </button>
            <button type="button" id="addRoleBtn" class="section-roles-only hidden inline-flex items-center gap-2 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
                <i class="fa-solid fa-plus text-[10px]"></i> Create Role
            </button>
        </div>
    </div>

    <div class="inline-flex items-center gap-1 bg-white rounded-full shadow-card p-1.5 mb-6">
        <button type="button" class="section-tab-btn active-section-tab px-5 py-2 rounded-full text-xs font-semibold bg-primary/20 text-ink transition" data-section="users">
            <i class="fa-solid fa-users mr-1.5"></i> Admin Users
        </button>
        <button type="button" class="section-tab-btn px-5 py-2 rounded-full text-xs font-semibold text-black/50 hover:text-ink transition" data-section="roles">
            <i class="fa-solid fa-shield-halved mr-1.5"></i> Roles &amp; Permissions
        </button>
    </div>

    <!-- USERS PANEL -->
    <div id="section-users" class="section-panel">
        <div class="bg-white rounded-3xl shadow-card overflow-hidden">
            <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
                <div class="relative flex-1 min-w-[200px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                    <label for="userSearch" class="sr-only">Search users</label>
                    <input id="userSearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search by name or email..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
                </div>
                <div class="relative">
                    <select name="role" aria-label="Filter by role" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">All Roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(request('role') == $role->id)>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[640px]">
                    <thead>
                        <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                            <th class="py-3 pl-5 font-medium">User</th>
                            <th class="py-3 font-medium">Role</th>
                            <th class="py-3 font-medium">Status</th>
                            <th class="py-3 font-medium">Last Login</th>
                            <th class="py-3 pr-5 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5">
                        @forelse ($users as $user)
                            <tr class="hover:bg-black/[0.02] transition">
                                <td class="py-3 pl-5">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-8 h-8 rounded-full bg-primary/20 grid place-items-center text-xs font-semibold shrink-0">{{ strtoupper(substr($user->first_name, 0, 1)) }}</span>
                                        <div class="min-w-0">
                                            <p class="font-medium truncate">{{ $user->full_name }}</p>
                                            <p class="text-black/40 text-xs truncate">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3"><span class="bg-black/5 text-black/60 text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ $user->role->name ?? ucfirst($user->user_type) }}</span></td>
                                <td class="py-3">
                                    @if ($user->status === 'active')
                                        <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Active</span>
                                    @else
                                        <span class="bg-black/5 text-black/45 text-[11px] font-semibold px-2.5 py-1 rounded-full">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-3 text-black/50">{{ $user->getLastLoginLabelAttribute() }}</td>
                                <td class="py-3 pr-5">
                                    <div class="flex items-center justify-end gap-1">
                                        <button type="button" aria-label="Edit user" class="edit-user-btn w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"
                                            data-id="{{ $user->id }}" data-first-name="{{ $user->first_name }}" data-last-name="{{ $user->last_name }}"
                                            data-email="{{ $user->email }}" data-phone="{{ $user->phone }}" data-user-type="{{ $user->user_type }}"
                                            data-role-id="{{ $user->role_id }}" data-status="{{ $user->status }}"
                                            data-action="{{ route('admin.system.users.update', $user) }}">
                                            <i class="fa-solid fa-pen text-xs text-black/40"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.system.users.destroy', $user) }}" onsubmit="return confirm('Remove this staff user?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" aria-label="Delete user" class="w-8 h-8 rounded-full grid place-items-center hover:bg-danger/10 transition"><i class="fa-solid fa-trash-can text-xs text-danger"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-10 text-center text-black/40 text-sm">No staff users yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="p-4 md:p-5 border-t border-black/5">
                    {{ $users->links('admin.catalog.partials.pagination') }}
                </div>
            @endif
        </div>
    </div>

    <!-- ROLES PANEL -->
    <div id="section-roles" class="section-panel hidden">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @foreach ($roles as $role)
                @php
                    $roleIcons = ['super-admin' => 'fa-crown', 'store-manager' => 'fa-store', 'support-staff' => 'fa-headset', 'content-editor' => 'fa-pen-nib'];
                @endphp
                <div class="bg-white rounded-3xl shadow-card p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-10 h-10 rounded-full bg-primary/20 grid place-items-center shrink-0"><i class="fa-solid {{ $roleIcons[$role->slug] ?? 'fa-user-shield' }} text-primary-dark"></i></span>
                        <div class="min-w-0">
                            <p class="font-semibold text-sm truncate">{{ $role->name }}</p>
                            <p class="text-black/40 text-xs">{{ $role->permissions->count() }} permissions &middot; {{ $role->users_count }} user{{ $role->users_count === 1 ? '' : 's' }}</p>
                        </div>
                    </div>
                    <button type="button" class="edit-role-btn w-full text-xs font-semibold border border-black/10 rounded-full py-2 hover:bg-black/[0.03] transition"
                        data-id="{{ $role->id }}" data-name="{{ $role->name }}" data-description="{{ $role->description }}"
                        data-action="{{ route('admin.system.roles.update', $role) }}">Edit Role</button>
                </div>
            @endforeach
        </div>

        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
            <h2 class="font-bold text-sm mb-5">Permission Matrix</h2>
            <table class="w-full text-sm min-w-[640px]">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        <th class="py-3 font-medium">Permission</th>
                        @foreach ($roles as $role)
                            <th class="py-3 font-medium text-center">{{ $role->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @foreach ($permissions as $group => $groupPermissions)
                        <tr class="bg-black/[0.02]"><td colspan="{{ $roles->count() + 1 }}" class="py-1.5 px-1 text-[11px] font-semibold uppercase tracking-wide text-black/40">{{ $group }}</td></tr>
                        @foreach ($groupPermissions as $permission)
                            <tr class="hover:bg-black/[0.02] transition">
                                <td class="py-2.5">{{ $permission->name }}</td>
                                @foreach ($roles as $role)
                                    <td class="py-2.5 text-center">
                                        <input type="checkbox" class="perm-checkbox rounded" data-role-id="{{ $role->id }}"
                                            data-action="{{ route('admin.system.roles.permissions.update', $role) }}"
                                            value="{{ $permission->id }}" {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit User Modal -->
    <div id="userModal" class="hidden fixed inset-0 z-50 bg-black/40 grid place-items-center p-4">
        <form method="POST" id="userForm" class="bg-white rounded-3xl shadow-soft w-full max-w-md p-6 max-h-[90vh] overflow-y-auto">
            @csrf
            <div id="userMethodField"></div>
            <div class="flex items-center justify-between mb-4">
                <h2 id="userModalTitle" class="font-bold text-base">Add User</h2>
                <button type="button" onclick="closeUserModal()" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1.5">First Name</label>
                        <input type="text" name="first_name" id="userFirstName" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Last Name</label>
                        <input type="text" name="last_name" id="userLastName" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Email</label>
                    <input type="email" name="email" id="userEmail" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Phone</label>
                    <input type="text" name="phone" id="userPhone" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Type</label>
                        <select name="user_type" id="userType" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                            <option value="admin">Admin</option>
                            <option value="agent">Agent</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Role</label>
                        <select name="role_id" id="userRoleId" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                            <option value="">None</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="userPasswordWrap">
                    <label class="block text-sm font-medium mb-1.5">Password</label>
                    <input type="password" name="password" id="userPassword" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div id="userStatusWrap" class="hidden">
                    <label class="block text-sm font-medium mb-1.5">Status</label>
                    <select name="status" id="userStatus" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition">Save User</button>
            </div>
        </form>
    </div>

    <!-- Add/Edit Role Modal -->
    <div id="roleModal" class="hidden fixed inset-0 z-50 bg-black/40 grid place-items-center p-4">
        <form method="POST" id="roleForm" class="bg-white rounded-3xl shadow-soft w-full max-w-md p-6">
            @csrf
            <div id="roleMethodField"></div>
            <div class="flex items-center justify-between mb-4">
                <h2 id="roleModalTitle" class="font-bold text-base">Create Role</h2>
                <button type="button" onclick="closeRoleModal()" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Role Name</label>
                    <input type="text" name="name" id="roleName" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Description</label>
                    <input type="text" name="description" id="roleDescription" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <button type="submit" class="w-full bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition">Save Role</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<script>
  document.querySelectorAll('.section-tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.section-tab-btn').forEach(b => { b.classList.remove('active-section-tab', 'bg-primary/20', 'text-ink'); b.classList.add('text-black/50'); });
      btn.classList.add('active-section-tab', 'bg-primary/20', 'text-ink');
      btn.classList.remove('text-black/50');

      const section = btn.dataset.section;
      document.querySelectorAll('.section-panel').forEach(p => p.classList.add('hidden'));
      document.getElementById('section-' + section).classList.remove('hidden');

      document.querySelectorAll('.section-users-only').forEach(el => el.classList.toggle('hidden', section !== 'users'));
      document.querySelectorAll('.section-roles-only').forEach(el => el.classList.toggle('hidden', section !== 'roles'));
    });
  });

  function openUserModal(data = null) {
    const form = document.getElementById('userForm');
    form.action = data ? data.action : "{{ route('admin.system.users.store') }}";
    document.getElementById('userMethodField').innerHTML = data ? '<input type="hidden" name="_method" value="PATCH">' : '';
    document.getElementById('userModalTitle').textContent = data ? 'Edit User' : 'Add User';
    document.getElementById('userFirstName').value = data?.firstName || '';
    document.getElementById('userLastName').value = data?.lastName || '';
    document.getElementById('userEmail').value = data?.email || '';
    document.getElementById('userPhone').value = data?.phone || '';
    document.getElementById('userType').value = data?.userType || 'admin';
    document.getElementById('userRoleId').value = data?.roleId || '';
    document.getElementById('userStatus').value = data?.status || 'active';
    document.getElementById('userPasswordWrap').classList.toggle('hidden', !!data);
    document.getElementById('userPassword').required = !data;
    document.getElementById('userStatusWrap').classList.toggle('hidden', !data);
    document.getElementById('userModal').classList.remove('hidden');
  }
  function closeUserModal() { document.getElementById('userModal').classList.add('hidden'); }
  document.getElementById('addUserBtn').addEventListener('click', () => openUserModal());
  document.querySelectorAll('.edit-user-btn').forEach(btn => btn.addEventListener('click', () => openUserModal(btn.dataset)));

  function openRoleModal(data = null) {
    const form = document.getElementById('roleForm');
    form.action = data ? data.action : "{{ route('admin.system.roles.store') }}";
    document.getElementById('roleMethodField').innerHTML = data ? '<input type="hidden" name="_method" value="PATCH">' : '';
    document.getElementById('roleModalTitle').textContent = data ? 'Edit Role' : 'Create Role';
    document.getElementById('roleName').value = data?.name || '';
    document.getElementById('roleDescription').value = data?.description || '';
    document.getElementById('roleModal').classList.remove('hidden');
  }
  function closeRoleModal() { document.getElementById('roleModal').classList.add('hidden'); }
  document.getElementById('addRoleBtn').addEventListener('click', () => openRoleModal());
  document.querySelectorAll('.edit-role-btn').forEach(btn => btn.addEventListener('click', () => openRoleModal(btn.dataset)));

  const csrfToken = "{{ csrf_token() }}";
  document.querySelectorAll('.perm-checkbox').forEach(cb => {
    cb.addEventListener('change', () => {
      const roleId = cb.dataset.roleId;
      const checked = Array.from(document.querySelectorAll('.perm-checkbox[data-role-id="' + roleId + '"]:checked')).map(c => c.value);
      const params = new URLSearchParams();
      checked.forEach(id => params.append('permission_ids[]', id));
      params.append('_method', 'PUT');
      params.append('_token', csrfToken);
      fetch(cb.dataset.action, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json' },
        body: params.toString(),
      });
    });
  });
</script>
@endpush
