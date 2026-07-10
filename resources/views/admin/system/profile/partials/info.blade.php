<div id="panel-profile" class="tab-panel space-y-6 {{ request('tab', 'profile') !== 'profile' ? 'hidden' : '' }}">

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        <div class="flex flex-wrap items-center gap-5">
            <div class="relative shrink-0">
                <div class="w-20 h-20 rounded-full bg-primary/20 grid place-items-center overflow-hidden">
                    @if ($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->full_name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-2xl font-bold text-primary-dark">{{ strtoupper(substr($user->first_name, 0, 1)) }}</span>
                    @endif
                </div>
                <label class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-ink text-white grid place-items-center cursor-pointer hover:bg-black/80 transition" aria-label="Change profile photo">
                    <i class="fa-solid fa-camera text-[10px]"></i>
                    <form id="avatarForm" method="POST" action="{{ route('admin.system.profile.avatar') }}" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="file" name="avatar" id="avatarInput" accept="image/*">
                    </form>
                </label>
            </div>
            <div class="min-w-0">
                <p class="font-bold text-base">{{ $user->full_name }}</p>
                <span class="inline-block bg-primary/20 text-primary-dark text-[11px] font-semibold px-2.5 py-1 rounded-full mt-1">{{ $user->role->name ?? ucfirst($user->user_type) }}</span>
                <p class="text-black/45 text-xs mt-1">{{ $user->email }}</p>
            </div>
            <div class="ml-auto grid grid-cols-3 gap-4 text-center">
                <div><p class="text-lg font-bold">{{ number_format($stats['orders_processed']) }}</p><p class="text-black/40 text-[11px]">Orders Processed</p></div>
                <div><p class="text-lg font-bold">{{ number_format($stats['products_managed']) }}</p><p class="text-black/40 text-[11px]">Products Managed</p></div>
                <div><p class="text-lg font-bold">{{ number_format($stats['tickets_resolved']) }}</p><p class="text-black/40 text-[11px]">Tickets Resolved</p></div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.system.profile.update') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PATCH')
        <h2 class="font-bold text-sm mb-5">Personal Information</h2>
        <div class="space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">First Name</label>
                    <input type="text" name="first_name" value="{{ $user->first_name }}" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Last Name</label>
                    <input type="text" name="last_name" value="{{ $user->last_name }}" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ $user->email }}" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Phone Number</label>
                    <input type="text" name="phone" value="{{ $user->phone }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Role</label>
                <input type="text" value="{{ $user->role->name ?? ucfirst($user->user_type) }}" disabled class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-black/[0.03] text-sm text-black/50">
                <p class="text-black/40 text-xs mt-1.5">Contact a Super Admin to change your role.</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Address</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition resize-none">{{ $user->address }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Bio</label>
                <textarea name="bio" rows="3" placeholder="A short line about you..." class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition resize-none">{{ $user->bio }}</textarea>
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-black/5">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Changes</button>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.system.profile.update') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PATCH')
        <input type="hidden" name="first_name" value="{{ $user->first_name }}">
        <input type="hidden" name="last_name" value="{{ $user->last_name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <h2 class="font-bold text-sm mb-1">Social Links</h2>
        <p class="text-black/40 text-xs mb-5">Your personal profile links (internal directory only).</p>
        <div class="grid sm:grid-cols-2 gap-4">
            <div class="relative">
                <i class="fa-solid fa-globe absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <input type="text" name="social_website" value="{{ $user->social_website }}" placeholder="Website" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <div class="relative">
                <i class="fa-brands fa-linkedin absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <input type="text" name="social_linkedin" value="{{ $user->social_linkedin }}" placeholder="LinkedIn" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <div class="relative">
                <i class="fa-brands fa-x-twitter absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <input type="text" name="social_twitter" value="{{ $user->social_twitter }}" placeholder="X / Twitter" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <div class="relative">
                <i class="fa-brands fa-instagram absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <input type="text" name="social_instagram" value="{{ $user->social_instagram }}" placeholder="Instagram" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-black/5">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Changes</button>
        </div>
    </form>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-4">Recent Activity</h2>
        <ol class="space-y-3">
            @forelse ($recentActivity as $log)
                <li class="flex items-start gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-dark mt-1.5 shrink-0"></span>
                    <div class="min-w-0">
                        <p class="text-sm text-black/70">{{ $log->action }}</p>
                        <p class="text-black/35 text-xs">{{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </li>
            @empty
                <li class="text-black/40 text-sm">No activity recorded yet.</li>
            @endforelse
        </ol>
    </div>
</div>

<script>
  (function () {
    const cameraLabel = document.querySelector('label[aria-label="Change profile photo"]');
    const avatarInput = document.getElementById('avatarInput');
    const avatarForm = document.getElementById('avatarForm');
    cameraLabel?.addEventListener('click', (e) => { e.preventDefault(); avatarInput.click(); });
    avatarInput?.addEventListener('change', () => { if (avatarInput.files.length) avatarForm.submit(); });
  })();
</script>
