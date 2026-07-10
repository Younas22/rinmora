@php
    $priorityStyle = ['High' => 'danger', 'Medium' => 'warning', 'Low' => 'info'];
@endphp

<div id="panel-system" class="tab-panel space-y-6 {{ request('tab', 'system') !== 'system' ? 'hidden' : '' }}">

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <div>
                <h2 class="font-bold text-sm">Notification Timeline</h2>
                <p class="text-black/40 text-xs mt-0.5">Live snapshot of real system, order, inventory, and review signals — recomputed on every visit.</p>
            </div>
        </div>

        <form method="GET" class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <input type="hidden" name="tab" value="system">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.cms.notifications.index', ['tab' => 'system']) }}" class="text-xs font-semibold px-3.5 py-2 rounded-full transition {{ !request('filter') ? 'bg-ink text-white' : 'bg-black/5 text-black/60 hover:bg-black/10' }}">All</a>
                <a href="{{ route('admin.cms.notifications.index', ['tab' => 'system', 'filter' => 'high']) }}" class="text-xs font-semibold px-3.5 py-2 rounded-full transition {{ request('filter') === 'high' ? 'bg-ink text-white' : 'bg-black/5 text-black/60 hover:bg-black/10' }}">High Priority</a>
            </div>
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <label for="notifSearch" class="sr-only">Search notifications</label>
                <input id="notifSearch" name="notif_search" type="text" value="{{ request('notif_search') }}" placeholder="Search notifications..." class="pl-9 pr-4 py-2 rounded-full bg-black/[0.03] border border-transparent text-xs focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition w-44 md:w-64">
            </div>
        </form>

        <ul class="divide-y divide-black/5">
            @forelse ($systemNotifications as $n)
                <li class="flex items-start gap-4 py-4 px-3 rounded-2xl bg-primary/5">
                    <span class="w-10 h-10 rounded-full bg-{{ $n['color'] }}/15 grid place-items-center shrink-0"><i class="fa-solid {{ $n['icon'] }} text-{{ $n['color'] }} text-sm"></i></span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold mb-0.5">{{ $n['title'] }}</p>
                        <p class="text-black/50 text-xs mb-2">{{ $n['message'] }}</p>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ $n['type'] }}</span>
                            <span class="bg-{{ $priorityStyle[$n['priority']] }}/10 text-{{ $priorityStyle[$n['priority']] }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ $n['priority'] }} Priority</span>
                            <span class="text-black/35 text-xs">{{ $n['time']->diffForHumans() }}</span>
                        </div>
                    </div>
                </li>
            @empty
                <li class="py-10 text-center text-black/40 text-sm">No active alerts right now.</li>
            @endforelse
        </ul>
    </div>

</div>
