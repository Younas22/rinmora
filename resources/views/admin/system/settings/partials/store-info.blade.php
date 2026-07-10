@php
    $daysList = ['mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday'];
@endphp

<div id="panel-store-info" class="tab-panel {{ request('tab') !== 'store-info' ? 'hidden' : '' }}">
    <form method="POST" action="{{ route('admin.system.settings.store-info') }}" class="space-y-6">
        @csrf @method('PUT')

        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
            <h2 class="font-bold text-sm mb-5">Business Information</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Business Name</label>
                    <input type="text" name="biz_name" value="{{ $storeInfo['biz_name'] ?? 'Rinmora Leather Goods LLC' }}" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Business Phone</label>
                        <input type="text" name="biz_phone" value="{{ $storeInfo['biz_phone'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Business Email</label>
                        <input type="email" name="biz_email" value="{{ $storeInfo['biz_email'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Support Phone</label>
                        <input type="text" name="support_phone" value="{{ $storeInfo['support_phone'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Support Email</label>
                        <input type="email" name="support_email" value="{{ $storeInfo['support_email'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Business Address</label>
                    <textarea name="biz_address" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition resize-none">{{ $storeInfo['biz_address'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Store Description</label>
                    <textarea name="store_desc" rows="4" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition resize-none">{{ $storeInfo['store_desc'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
            <h2 class="font-bold text-sm mb-5">Business Hours</h2>
            <div class="space-y-2.5">
                @foreach ($daysList as $key => $label)
                    @php $day = $businessHours[$key] ?? ['open' => $key !== 'sun', 'from' => '10:00 AM', 'to' => '8:00 PM']; @endphp
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="w-24 text-sm font-medium shrink-0">{{ $label }}</span>
                        <input type="text" name="hours_{{ $key }}_from" value="{{ $day['from'] }}" class="w-28 px-3 py-2 rounded-lg border border-black/10 text-xs focus:outline-none focus:ring-2 focus:ring-primary transition">
                        <span class="text-black/40 text-xs">to</span>
                        <input type="text" name="hours_{{ $key }}_to" value="{{ $day['to'] }}" class="w-28 px-3 py-2 rounded-lg border border-black/10 text-xs focus:outline-none focus:ring-2 focus:ring-primary transition">
                        <label class="relative inline-flex items-center cursor-pointer ml-auto">
                            <input type="checkbox" name="hours_{{ $key }}_open" value="1" class="peer sr-only" {{ $day['open'] ? 'checked' : '' }}>
                            <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                            <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Changes</button>
        </div>
    </form>
</div>
