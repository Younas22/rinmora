@php
    $builders = [
        'push' => ['icon' => 'fa-bell', 'label' => 'Push Notification'],
        'email' => ['icon' => 'fa-envelope', 'label' => 'Email Notification'],
        'sms' => ['icon' => 'fa-comment-sms', 'label' => 'SMS Notification'],
    ];
    $audienceLabels = ['all' => 'All Customers', 'vip' => 'VIP Customers', 'recent' => 'Recent Purchasers (30d)', 'cart' => 'Abandoned Cart', 'custom' => 'Custom Segment'];
    $channelStyle = ['push' => 'bg-primary/20 text-primary-dark', 'email' => 'bg-info/10 text-info', 'sms' => 'bg-warning/10 text-warning'];
@endphp

<div id="panel-customer" class="tab-panel space-y-6 {{ request('tab') !== 'customer' ? 'hidden' : '' }}">

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        <div class="flex items-center gap-2 mb-6 flex-wrap">
            @foreach ($builders as $key => $b)
                <button type="button" class="builder-tab {{ $loop->first ? 'active-builder-tab bg-ink text-white' : 'text-black/50 hover:bg-black/5' }} text-xs font-semibold px-4 py-2 rounded-full transition" data-builder="{{ $key }}">
                    <i class="fa-solid {{ $b['icon'] }} mr-1.5"></i> {{ $b['label'] }}
                </button>
            @endforeach
        </div>

        @foreach ($builders as $key => $b)
            <form method="POST" action="{{ route('admin.cms.notifications.campaigns.store') }}" id="builder-panel-{{ $key }}" class="builder-panel space-y-5 {{ $loop->first ? '' : 'hidden' }}">
                @csrf
                <input type="hidden" name="channel" value="{{ $key }}">

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="{{ $key }}Title">{{ $key === 'sms' ? 'Internal Campaign Name' : 'Notification Title' }}</label>
                    <input id="{{ $key }}Title" name="title" type="text" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                </div>

                @if ($key === 'email')
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="emailSubject">Subject Line</label>
                        <input id="emailSubject" name="subject" type="text" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="{{ $key }}Body">Message Body</label>
                    <textarea id="{{ $key }}Body" name="message_body" rows="{{ $key === 'sms' ? 3 : ($key === 'email' ? 6 : 4) }}" @if ($key === 'sms') maxlength="160" @endif required class="w-full px-4 py-3 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none"></textarea>
                </div>

                <div>
                    <p class="block text-sm font-medium mb-1.5">Audience</p>
                    <div class="audience-group flex flex-wrap gap-2">
                        @foreach ($audienceLabels as $aKey => $aLabel)
                            <label class="cursor-pointer">
                                <input type="radio" name="audience" value="{{ $aKey }}" class="audience-radio sr-only peer" data-count="{{ $audienceCounts[$aKey] }}" {{ $loop->first ? 'checked' : '' }}>
                                <span class="audience-pill-label text-xs font-semibold px-3.5 py-2 rounded-full bg-black/5 text-black/60 hover:bg-black/10 transition peer-checked:bg-ink peer-checked:text-white">{{ $aLabel }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="audience-count text-black/45 text-xs mt-2.5"><i class="fa-solid fa-users mr-1"></i> {{ number_format($audienceCounts['all']) }} recipients</p>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-2 border-t border-black/5 mt-2">
                    <button type="submit" name="action" value="send" class="inline-flex items-center gap-2 bg-primary-dark text-white font-semibold text-sm px-6 py-2.5 rounded-full hover:bg-ink transition">
                        <i class="fa-solid fa-paper-plane text-xs"></i> Send Now
                    </button>
                    <button type="submit" name="action" value="draft" class="inline-flex items-center gap-2 border border-black/10 font-semibold text-sm px-6 py-2.5 rounded-full hover:bg-black/5 transition">
                        <i class="fa-regular fa-floppy-disk text-xs"></i> Save Draft
                    </button>
                </div>
                <p class="text-black/35 text-[11px]">Demo only — Send Now marks the campaign as sent but does not dispatch a real push/email/SMS.</p>
            </form>
        @endforeach
    </div>

    <!-- History table -->
    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
        <h2 class="font-bold text-sm mb-5">Campaign History</h2>
        <table class="w-full text-sm min-w-[760px]">
            <thead>
                <tr class="text-left text-black/40 text-xs uppercase tracking-wide">
                    <th class="pb-3 font-medium">Campaign</th>
                    <th class="pb-3 font-medium">Channel</th>
                    <th class="pb-3 font-medium">Audience</th>
                    <th class="pb-3 font-medium">Sent</th>
                    <th class="pb-3 font-medium">Status</th>
                    <th class="pb-3 font-medium">Date</th>
                    <th class="pb-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($campaigns as $campaign)
                    <tr class="hover:bg-black/[0.02] transition">
                        <td class="py-3.5 font-semibold">{{ $campaign->title }}</td>
                        <td class="py-3.5"><span class="{{ $channelStyle[$campaign->channel] }} text-[11px] font-semibold px-2.5 py-1 rounded-full capitalize">{{ $campaign->channel }}</span></td>
                        <td class="py-3.5 text-black/60">{{ $audienceLabels[$campaign->audience] ?? $campaign->audience }}</td>
                        <td class="py-3.5 text-black/60">{{ $campaign->sent_count ? number_format($campaign->sent_count) : '—' }}</td>
                        <td class="py-3.5">
                            @if ($campaign->status === 'sent')
                                <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Sent</span>
                            @elseif ($campaign->status === 'scheduled')
                                <span class="bg-warning/10 text-warning text-[11px] font-semibold px-2.5 py-1 rounded-full">Scheduled</span>
                            @else
                                <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">Draft</span>
                            @endif
                        </td>
                        <td class="py-3.5 text-black/45">{{ $campaign->sent_at?->format('M j, Y') ?? '—' }}</td>
                        <td class="py-3.5 text-right">
                            @if ($campaign->status === 'draft')
                                <form method="POST" action="{{ route('admin.cms.notifications.campaigns.send', $campaign) }}">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold border border-black/10 rounded-full px-3.5 py-1.5 hover:bg-black/5 transition">Send Now</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-10 text-center text-black/40 text-sm">No campaigns yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        @if ($campaigns->hasPages())
            <div class="pt-5 mt-5 border-t border-black/5">
                {{ $campaigns->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>

</div>

<script>
  (function () {
    document.querySelectorAll('.builder-tab').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.builder-tab').forEach(b => {
          b.classList.remove('active-builder-tab', 'bg-ink', 'text-white');
          b.classList.add('text-black/50');
        });
        btn.classList.add('active-builder-tab', 'bg-ink', 'text-white');
        btn.classList.remove('text-black/50');
        document.querySelectorAll('.builder-panel').forEach(p => p.classList.add('hidden'));
        document.getElementById('builder-panel-' + btn.dataset.builder).classList.remove('hidden');
      });
    });

    document.querySelectorAll('.audience-group').forEach(group => {
      const countEl = group.closest('form').querySelector('.audience-count');
      group.querySelectorAll('.audience-radio').forEach(radio => {
        radio.addEventListener('change', () => {
          countEl.innerHTML = '<i class="fa-solid fa-users mr-1"></i> ' + Number(radio.dataset.count).toLocaleString() + ' recipients';
        });
      });
    });
  })();
</script>
