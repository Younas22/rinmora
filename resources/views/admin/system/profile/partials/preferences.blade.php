@php
    $prefList = [
        'email_notifications' => ['label' => 'Email Notifications', 'desc' => 'Receive account and store updates by email.'],
        'sms_notifications' => ['label' => 'SMS Notifications', 'desc' => "Get urgent alerts sent to your mobile number."],
        'push_notifications' => ['label' => 'Push Notifications', 'desc' => "Browser push alerts while you're signed in."],
        'marketing_emails' => ['label' => 'Marketing Emails', 'desc' => 'Product launches, promotions, and newsletters.'],
        'security_alerts' => ['label' => 'Security Alerts', 'desc' => 'Sign-ins, password changes, and suspicious activity.'],
        'order_notifications' => ['label' => 'Order Notifications', 'desc' => 'New orders, cancellations, and refund requests.'],
    ];
@endphp

<div id="panel-preferences" class="tab-panel {{ request('tab') !== 'preferences' ? 'hidden' : '' }}">
    <div class="max-w-lg mx-auto bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-5">Notification Preferences</h2>
        <form method="POST" action="{{ route('admin.system.profile.preferences') }}">
            @csrf @method('PATCH')
            <div class="divide-y divide-black/5">
                @foreach ($prefList as $key => $p)
                    <div class="flex items-center justify-between gap-4 py-3.5">
                        <div>
                            <p class="text-sm font-semibold">{{ $p['label'] }}</p>
                            <p class="text-black/45 text-xs mt-0.5">{{ $p['desc'] }}</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" name="{{ $key }}" value="1" class="peer sr-only" {{ ($preferences[$key] ?? false) ? 'checked' : '' }}>
                            <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                            <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                        </label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="w-full mt-4 bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition">Save Preferences</button>
        </form>
    </div>
</div>
