<div id="panel-email" class="tab-panel space-y-6 {{ request('tab') !== 'email' ? 'hidden' : '' }}">
    <form method="POST" action="{{ route('admin.system.settings.email') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PUT')
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-bold text-sm">SMTP Configuration</h2>
            @if ($smtp['last_tested_at'] ?? null)
                <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Tested {{ \Illuminate\Support\Carbon::parse($smtp['last_tested_at'])->diffForHumans() }}</span>
            @endif
        </div>
        <div class="space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">SMTP Host</label>
                    <input type="text" name="smtp_host" value="{{ $smtp['smtp_host'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">SMTP Port</label>
                    <input type="text" name="smtp_port" value="{{ $smtp['smtp_port'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Encryption</label>
                <select name="smtp_encryption" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    @foreach (['none' => 'None', 'ssl' => 'SSL', 'tls' => 'TLS'] as $val => $label)
                        <option value="{{ $val }}" @selected(($smtp['smtp_encryption'] ?? 'tls') === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">SMTP User</label>
                    <input type="text" name="smtp_user" value="{{ $smtp['smtp_user'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">SMTP Password</label>
                    <input type="password" name="smtp_pass" value="{{ $smtp['smtp_pass'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Sender Name</label>
                    <input type="text" name="sender_name" value="{{ $smtp['sender_name'] ?? 'Rinmora' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Sender Email</label>
                    <input type="email" name="sender_email" value="{{ $smtp['sender_email'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-black/5">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Changes</button>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.system.settings.email.send-test') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf
        <h2 class="font-bold text-sm mb-1">Send Test Email</h2>
        <p class="text-black/40 text-xs mb-4">Sends a real message through the mailer configured in <code class="font-mono">.env</code> (<code class="font-mono">{{ config('mail.default') }}</code> driver).</p>
        <div class="flex items-center gap-3">
            <input type="email" name="test_email" required placeholder="you@example.com" class="flex-1 px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            <button type="submit" class="inline-flex items-center gap-2 bg-ink text-white text-sm font-semibold px-5 py-2.5 rounded-full hover:bg-black/80 transition shrink-0">Send Test Email</button>
        </div>
    </form>
</div>
