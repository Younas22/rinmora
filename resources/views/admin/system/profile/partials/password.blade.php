<div id="panel-password" class="tab-panel {{ request('tab') !== 'password' ? 'hidden' : '' }}">
    <div class="max-w-lg mx-auto bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-5">Change Password</h2>
        <form method="POST" action="{{ route('admin.system.profile.password') }}" class="space-y-4">
            @csrf @method('PATCH')
            <div>
                <label class="block text-sm font-medium mb-1.5">Current Password</label>
                <input type="password" name="current_password" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">New Password</label>
                <input type="password" name="new_password" required minlength="8" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" required minlength="8" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <div class="bg-black/[0.03] rounded-xl p-3">
                <p class="text-xs font-semibold text-black/50 mb-1.5">Password requirements</p>
                <ul class="text-xs text-black/45 space-y-0.5">
                    <li><i class="fa-solid fa-check text-success mr-1"></i> At least 8 characters</li>
                    <li><i class="fa-solid fa-check text-success mr-1"></i> Matches confirmation</li>
                </ul>
            </div>
            <button type="submit" class="w-full bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition">Update Password</button>
        </form>
    </div>
</div>
