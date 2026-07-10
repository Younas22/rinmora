<div id="panel-sms" class="tab-panel space-y-6 {{ request('tab') !== 'sms' ? 'hidden' : '' }}">
    <div class="bg-black/[0.03] rounded-2xl px-4 py-3 text-xs text-black/50">
        <i class="fa-regular fa-circle-question mr-1"></i> No SMS provider is integrated in this app — fields persist for real, but "Test SMS" and the stats below are demo/static.
    </div>

    <form method="POST" action="{{ route('admin.system.settings.sms') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PUT')
        <h2 class="font-bold text-sm mb-5">SMS Provider</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1.5">Provider</label>
                <select name="sms_provider" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    @foreach (['Twilio', 'Nexmo', 'Custom'] as $p)
                        <option value="{{ $p }}" @selected(($sms['sms_provider'] ?? 'Twilio') === $p)>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Sender ID</label>
                    <input type="text" name="sms_sender" value="{{ $sms['sms_sender'] ?? 'RINMORA' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">API Key</label>
                    <input type="password" name="sms_api_key" value="{{ $sms['sms_api_key'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
            </div>
            <div class="flex items-center justify-between gap-4 py-1">
                <p class="text-sm font-semibold">Enable SMS Notifications</p>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" name="sms_enabled" value="1" class="peer sr-only" {{ ($sms['sms_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
                    <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                    <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                </label>
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-black/5">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Changes</button>
        </div>
    </form>

    <div class="grid sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow-card p-5"><p class="text-black/45 text-xs mb-1">Delivery Rate</p><p class="text-lg font-bold">98.2%</p></div>
        <div class="bg-white rounded-2xl shadow-card p-5"><p class="text-black/45 text-xs mb-1">Messages Sent This Month</p><p class="text-lg font-bold">1,240</p></div>
        <div class="bg-white rounded-2xl shadow-card p-5"><p class="text-black/45 text-xs mb-1">Balance</p><p class="text-lg font-bold">$42.00</p></div>
    </div>

    <form method="POST" action="{{ route('admin.system.settings.sms.send-test') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6 flex items-center justify-between gap-4">
        @csrf
        <p class="text-sm font-semibold">Test SMS</p>
        <button type="submit" class="text-xs font-semibold border border-black/10 rounded-full px-4 py-2.5 hover:bg-black/5 transition">Send Test SMS</button>
    </form>
</div>
