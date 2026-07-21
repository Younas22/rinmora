@php
    $priorityStyle = ['high' => 'danger', 'medium' => 'warning', 'low' => 'info'];
    $canDeleteMessages = auth()->user()->hasPermission('delete-contact-messages');
@endphp

<div id="section-messages" class="section-panel {{ $tab !== 'messages' ? 'hidden' : '' }}">
    <div class="bg-white rounded-3xl shadow-card overflow-hidden">
        <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
            <input type="hidden" name="tab" value="messages">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <input type="text" name="msg_search" value="{{ request('msg_search') }}" placeholder="Search messages..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
            </div>
            <div class="relative">
                <select name="priority" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Priorities</option>
                    <option value="high" @selected(request('priority') === 'high')>High</option>
                    <option value="medium" @selected(request('priority') === 'medium')>Medium</option>
                    <option value="low" @selected(request('priority') === 'low')>Low</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
        </form>

        @if ($canDeleteMessages)
            {{-- Deliberately NOT wrapping the table below: each row already has its
                 own Archive/Delete <form>, and nesting a <form> inside another <form>
                 is invalid HTML that makes browsers close the outer form early,
                 silently dropping every field after the first nested one. Instead
                 this form stays empty/detached and the checkboxes + submit button
                 associate with it via the form="bulkMessageForm" attribute. --}}
            <form id="bulkMessageForm" method="POST" action="{{ route('admin.system.support.messages.bulk-destroy') }}">
                @csrf
            </form>
            <div id="messageBulkBar" class="hidden items-center justify-between gap-3 px-4 py-3 bg-ink text-white text-sm mx-4 md:mx-5 mt-4 rounded-2xl">
                <span><span id="messageSelectedCount">0</span> selected</span>
                <button type="submit" form="bulkMessageForm" onclick="return confirm('Delete selected messages?');" class="text-xs font-semibold px-3 py-1.5 rounded-full bg-danger hover:bg-danger/85 transition">Bulk Delete</button>
            </div>
        @endif

        <div class="overflow-x-auto{{ $canDeleteMessages ? ' mt-4' : '' }}">
            <table class="w-full text-sm min-w-[640px]">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        @if ($canDeleteMessages)
                            <th class="py-3 pl-5 font-medium w-8"><input type="checkbox" id="messageSelectAll"></th>
                        @endif
                        <th class="py-3 font-medium {{ $canDeleteMessages ? '' : 'pl-5' }}">Customer</th>
                        <th class="py-3 font-medium">Subject</th>
                        <th class="py-3 font-medium">Priority</th>
                        <th class="py-3 font-medium">Date</th>
                        <th class="py-3 pr-5 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($messages as $message)
                        <tr class="hover:bg-black/[0.02] transition {{ $message->is_read ? '' : 'bg-primary/[0.03]' }}">
                            @if ($canDeleteMessages)
                                <td class="py-3 pl-5"><input type="checkbox" name="ids[]" value="{{ $message->id }}" class="message-checkbox" form="bulkMessageForm"></td>
                            @endif
                            <td class="py-3 {{ $canDeleteMessages ? '' : 'pl-5' }}">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-8 h-8 rounded-full bg-primary/20 grid place-items-center text-xs font-semibold shrink-0">{{ strtoupper(substr($message->name, 0, 1)) }}</span>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-1.5">
                                            <p class="font-medium truncate">{{ $message->name }}</p>
                                            @if (!$message->is_read)<span class="w-1.5 h-1.5 rounded-full bg-primary-dark shrink-0"></span>@endif
                                        </div>
                                        <p class="text-black/40 text-xs truncate">{{ $message->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-black/70 max-w-[220px] truncate">{{ $message->subject }}</td>
                            <td class="py-3"><span class="bg-{{ $priorityStyle[$message->priority] }}/10 text-{{ $priorityStyle[$message->priority] }} text-[11px] font-semibold px-2.5 py-1 rounded-full capitalize">{{ $message->priority }}</span></td>
                            <td class="py-3 text-black/45 text-xs">{{ $message->created_at->format('M j, Y') }}</td>
                            <td class="py-3 pr-5">
                                <div class="flex items-center justify-end gap-1">
                                    <button type="button" class="reply-msg-btn w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition" aria-label="Reply"
                                        data-name="{{ $message->name }}" data-email="{{ $message->email }}" data-subject="{{ $message->subject }}"
                                        data-message="{{ $message->message }}" data-reply="{{ $message->reply_body }}"
                                        data-action="{{ route('admin.system.support.messages.reply', $message) }}">
                                        <i class="fa-solid fa-reply text-xs text-black/40"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.system.support.messages.archive', $message) }}">
                                        @csrf
                                        <button type="submit" aria-label="Archive" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-box-archive text-xs text-black/40"></i></button>
                                    </form>
                                    @if ($canDeleteMessages)
                                        <form method="POST" action="{{ route('admin.system.support.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" aria-label="Delete" class="w-8 h-8 rounded-full grid place-items-center hover:bg-danger/10 transition"><i class="fa-solid fa-trash-can text-xs text-danger"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ $canDeleteMessages ? 6 : 5 }}" class="py-10 text-center text-black/40 text-sm">No messages.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($messages->hasPages())
            <div class="p-4 md:p-5 border-t border-black/5">
                {{ $messages->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>
</div>

<!-- Reply Modal -->
<div id="replyMsgModal" class="hidden fixed inset-0 z-50 bg-black/40 grid place-items-center p-4">
    <form method="POST" id="replyMsgForm" class="bg-white rounded-3xl shadow-soft w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
        @csrf
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-base">Reply to <span id="replyMsgName"></span></h2>
            <button type="button" onclick="document.getElementById('replyMsgModal').classList.add('hidden')" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <p class="text-black/40 text-xs mb-1">Subject</p>
        <p id="replyMsgSubject" class="text-sm font-medium mb-3"></p>
        <div class="bg-black/[0.03] rounded-xl p-3 text-sm text-black/70 mb-4" id="replyMsgBody"></div>
        <div id="replyMsgExisting" class="hidden bg-primary/5 rounded-xl p-3 text-sm text-black/70 mb-4">
            <p class="text-black/40 text-xs mb-1">Previous reply</p>
            <p id="replyMsgExistingBody"></p>
        </div>
        <label class="block text-sm font-medium mb-1.5">Your Reply</label>
        <textarea name="reply_body" id="replyMsgTextarea" rows="4" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition resize-none"></textarea>
        <button type="submit" class="w-full mt-4 bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition">Send Reply</button>
    </form>
</div>

<script>
  (function () {
    const modal = document.getElementById('replyMsgModal');
    document.querySelectorAll('.reply-msg-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.getElementById('replyMsgForm').action = btn.dataset.action;
        document.getElementById('replyMsgName').textContent = btn.dataset.name;
        document.getElementById('replyMsgSubject').textContent = btn.dataset.subject;
        document.getElementById('replyMsgBody').textContent = btn.dataset.message;
        document.getElementById('replyMsgTextarea').value = '';
        const existingWrap = document.getElementById('replyMsgExisting');
        if (btn.dataset.reply) {
          document.getElementById('replyMsgExistingBody').textContent = btn.dataset.reply;
          existingWrap.classList.remove('hidden');
        } else {
          existingWrap.classList.add('hidden');
        }
        modal.classList.remove('hidden');
      });
    });
  })();

  @if ($canDeleteMessages)
  (function () {
    const selectAll = document.getElementById('messageSelectAll');
    const bar = document.getElementById('messageBulkBar');
    const countEl = document.getElementById('messageSelectedCount');

    function updateBar() {
      const checked = document.querySelectorAll('.message-checkbox:checked').length;
      countEl.textContent = checked;
      bar.classList.toggle('hidden', checked === 0);
      bar.classList.toggle('flex', checked > 0);
    }

    selectAll?.addEventListener('change', () => {
      document.querySelectorAll('.message-checkbox').forEach(cb => { cb.checked = selectAll.checked; });
      updateBar();
    });
    document.querySelectorAll('.message-checkbox').forEach(cb => cb.addEventListener('change', updateBar));
  })();
  @endif
</script>
