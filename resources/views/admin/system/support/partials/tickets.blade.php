@php
    $ticketStatusStyle = ['open' => 'info', 'pending' => 'warning', 'resolved' => 'success', 'closed' => 'black/5'];
    $statusSteps = ['open', 'pending', 'resolved', 'closed'];
    $canDeleteTickets = auth()->user()->hasPermission('delete-support-tickets');
@endphp

<div id="section-tickets" class="section-panel {{ $tab !== 'tickets' ? 'hidden' : '' }}">

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 md:gap-4 mb-5">
        <div class="bg-white rounded-2xl shadow-card p-4"><p class="text-black/45 text-xs mb-1">Open</p><p class="text-lg font-bold text-info">{{ $ticketStats['open'] }}</p></div>
        <div class="bg-white rounded-2xl shadow-card p-4"><p class="text-black/45 text-xs mb-1">Pending</p><p class="text-lg font-bold text-warning">{{ $ticketStats['pending'] }}</p></div>
        <div class="bg-white rounded-2xl shadow-card p-4"><p class="text-black/45 text-xs mb-1">Resolved</p><p class="text-lg font-bold text-success">{{ $ticketStats['resolved'] }}</p></div>
        <div class="bg-white rounded-2xl shadow-card p-4"><p class="text-black/45 text-xs mb-1">Closed</p><p class="text-lg font-bold text-black/50">{{ $ticketStats['closed'] }}</p></div>
    </div>

    <div class="grid lg:grid-cols-[320px_1fr] gap-5">
        <div>
            @if ($canDeleteTickets)
                <form id="bulkTicketForm" method="POST" action="{{ route('admin.system.support.tickets.bulk-destroy') }}">
                    @csrf
                    <div class="flex items-center justify-between gap-2 mb-2 px-1">
                        <label class="flex items-center gap-2 text-xs text-black/50">
                            <input type="checkbox" id="ticketSelectAll"> Select all
                        </label>
                        <div id="ticketBulkBar" class="hidden items-center gap-2">
                            <span class="text-xs text-black/50"><span id="ticketSelectedCount">0</span> selected</span>
                            <button type="submit" onclick="return confirm('Delete selected tickets? This also deletes their conversation history.');" class="text-xs font-semibold px-3 py-1.5 rounded-full bg-danger text-white hover:bg-danger/85 transition">Delete</button>
                        </div>
                    </div>
            @endif

            <div class="bg-white rounded-3xl shadow-card p-3 space-y-1 h-fit">
                @forelse ($tickets as $t)
                    <div class="flex items-center gap-1 rounded-xl transition {{ $selectedTicket && $selectedTicket->id === $t->id ? 'bg-primary/15' : 'hover:bg-black/5' }}">
                        @if ($canDeleteTickets)
                            <input type="checkbox" name="ids[]" value="{{ $t->id }}" class="ticket-checkbox ml-2 shrink-0">
                        @endif
                        <a href="{{ route('admin.system.support.index', ['tab' => 'tickets', 'ticket' => $t->id]) }}" class="flex items-center gap-3 px-3 py-2.5 flex-1 min-w-0">
                            <span class="w-8 h-8 rounded-full bg-primary/20 grid place-items-center text-xs font-semibold shrink-0">{{ strtoupper(substr($t->customer_name, 0, 1)) }}</span>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold truncate">{{ $t->ticket_number }} &middot; {{ $t->subject }}</p>
                                <p class="text-black/40 text-xs truncate">{{ $t->customer_name }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="bg-{{ $ticketStatusStyle[$t->status] }}/10 text-{{ $ticketStatusStyle[$t->status] }} text-[10px] font-semibold px-2 py-0.5 rounded-full capitalize block mb-1">{{ $t->status }}</span>
                                <span class="text-black/35 text-[10px]">{{ $t->updated_at->diffForHumans(null, true) }}</span>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-center text-black/40 text-sm py-6">No tickets yet.</p>
                @endforelse
            </div>

            @if ($canDeleteTickets)
                </form>
            @endif
        </div>

        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
            @if ($selectedTicket)
                <div class="flex items-center gap-2 mb-6">
                    @foreach ($statusSteps as $i => $step)
                        @php $reached = array_search($selectedTicket->status, $statusSteps) >= $i; @endphp
                        <div class="flex items-center gap-2 flex-1">
                            <span class="w-6 h-6 rounded-full grid place-items-center text-[10px] font-bold shrink-0 {{ $reached ? 'bg-primary-dark text-white' : 'bg-black/10 text-black/40' }}">{{ $i + 1 }}</span>
                            <span class="text-xs {{ $reached ? 'text-ink font-semibold' : 'text-black/40' }} capitalize">{{ $step }}</span>
                            @if (!$loop->last)<span class="flex-1 h-px bg-black/10"></span>@endif
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center gap-3 mb-5 pb-5 border-b border-black/5">
                    <span class="w-10 h-10 rounded-full bg-primary/20 grid place-items-center text-sm font-semibold shrink-0">{{ strtoupper(substr($selectedTicket->customer_name, 0, 1)) }}</span>
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-sm">{{ $selectedTicket->customer_name }}</p>
                        <p class="text-black/40 text-xs">{{ $selectedTicket->customer_email }}</p>
                    </div>
                    <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ $selectedTicket->ticket_number }}</span>
                    @if ($canDeleteTickets)
                        <form method="POST" action="{{ route('admin.system.support.tickets.destroy', $selectedTicket) }}" onsubmit="return confirm('Delete this ticket? This also deletes its conversation history.');">
                            @csrf @method('DELETE')
                            <button type="submit" aria-label="Delete ticket" class="w-8 h-8 rounded-full grid place-items-center hover:bg-danger/10 transition"><i class="fa-solid fa-trash-can text-xs text-danger"></i></button>
                        </form>
                    @endif
                </div>

                <div class="space-y-4 mb-5 max-h-[360px] overflow-y-auto pr-1">
                    @foreach ($selectedTicket->messages as $msg)
                        @if ($msg->is_internal_note)
                            <div class="bg-warning/10 rounded-xl p-3 text-sm">
                                <p class="text-warning text-[11px] font-semibold mb-1"><i class="fa-solid fa-lock mr-1"></i> Internal note &mdash; visible to staff only</p>
                                <p class="text-black/70">{{ $msg->body }}</p>
                            </div>
                        @else
                            <div class="flex {{ $msg->sender_type === 'admin' ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[80%] {{ $msg->sender_type === 'admin' ? 'bg-primary/15' : 'bg-black/5' }} rounded-2xl p-3">
                                    <p class="text-sm text-black/80">{{ $msg->body }}</p>
                                    <p class="text-black/35 text-[10px] mt-1">{{ $msg->sender_name }} &middot; {{ $msg->created_at->format('M j, g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <form method="POST" action="{{ route('admin.system.support.tickets.reply', $selectedTicket) }}">
                    @csrf
                    <input type="hidden" name="_redirect_ticket" value="{{ $selectedTicket->id }}">
                    <textarea name="body" rows="3" required placeholder="Type your reply..." class="w-full px-4 py-3 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition resize-none mb-3"></textarea>
                    <div class="flex items-center gap-3">
                        <select name="status" class="flex-1 px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                            @foreach ($statusSteps as $step)
                                <option value="{{ $step }}" @selected($selectedTicket->status === $step)>{{ ucfirst($step) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition shrink-0">
                            <i class="fa-solid fa-paper-plane text-[10px]"></i> Send Reply
                        </button>
                    </div>
                </form>
            @else
                <p class="text-center text-black/40 text-sm py-10">No ticket selected.</p>
            @endif
        </div>
    </div>
</div>

@if ($canDeleteTickets)
<script>
  (function () {
    const selectAll = document.getElementById('ticketSelectAll');
    const bar = document.getElementById('ticketBulkBar');
    const countEl = document.getElementById('ticketSelectedCount');

    function updateBar() {
      const checked = document.querySelectorAll('.ticket-checkbox:checked').length;
      countEl.textContent = checked;
      bar.classList.toggle('hidden', checked === 0);
      bar.classList.toggle('flex', checked > 0);
    }

    selectAll?.addEventListener('change', () => {
      document.querySelectorAll('.ticket-checkbox').forEach(cb => { cb.checked = selectAll.checked; });
      updateBar();
    });
    document.querySelectorAll('.ticket-checkbox').forEach(cb => cb.addEventListener('change', updateBar));
  })();
</script>
@endif
