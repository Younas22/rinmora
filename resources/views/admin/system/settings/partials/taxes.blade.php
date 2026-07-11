<div id="panel-taxes" class="tab-panel space-y-6 {{ request('tab') !== 'taxes' ? 'hidden' : '' }}">

    <div class="bg-black/[0.03] rounded-2xl px-4 py-3 text-xs text-black/50">
        <i class="fa-regular fa-circle-question mr-1"></i> Flat tax rule list — separate Tax Classes / Country Tax Rules grids are out of scope for this pass.
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-bold text-sm">Tax Rules</h2>
            <button type="button" id="addTaxRuleBtn" class="inline-flex items-center gap-2 border border-black/10 rounded-full px-3.5 py-2 text-xs font-semibold hover:bg-black/5 transition">
                <i class="fa-solid fa-plus text-[10px]"></i> Add Rule
            </button>
        </div>
        <div class="divide-y divide-black/5">
            @forelse ($taxRules as $rule)
                <div class="flex items-center justify-between gap-4 py-3.5">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold">{{ $rule->name }}</p>
                        <p class="text-black/45 text-xs mt-0.5">Applies to: {{ $rule->applies_to }} &middot; {{ $rule->rate }}%</p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="peer sr-only tax-toggle" data-id="{{ $rule->id }}" data-name="{{ $rule->name }}" data-applies-to="{{ $rule->applies_to }}" data-rate="{{ $rule->rate }}" {{ $rule->is_active ? 'checked' : '' }}>
                            <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                            <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                        </label>
                        <button type="button" class="edit-tax-btn w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"
                            data-id="{{ $rule->id }}" data-name="{{ $rule->name }}" data-applies-to="{{ $rule->applies_to }}" data-rate="{{ $rule->rate }}" data-active="{{ $rule->is_active ? 1 : 0 }}">
                            <i class="fa-solid fa-pen text-xs text-black/40"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.system.settings.tax-rules.destroy', $rule) }}" onsubmit="return confirm('Delete this tax rule?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-full grid place-items-center hover:bg-danger/10 transition"><i class="fa-solid fa-trash-can text-xs text-danger"></i></button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-black/40 text-sm py-6">No tax rules yet.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-1">Tax Summary Preview</h2>
        <p class="text-black/40 text-xs mb-4">Illustrative example only — not tied to real checkout logic.</p>
        @php $exampleRate = $taxRules->firstWhere('is_active', true)?->rate ?? 0; @endphp
        <div class="bg-black/[0.03] rounded-xl p-4 text-sm space-y-1.5">
            <div class="flex justify-between"><span class="text-black/60">Subtotal</span><span>$248.00</span></div>
            <div class="flex justify-between"><span class="text-black/60">Tax ({{ $exampleRate }}%)</span><span>{{ format_price(248 * $exampleRate / 100) }}</span></div>
            <div class="flex justify-between font-bold pt-1.5 border-t border-black/10"><span>Total</span><span>{{ format_price(248 + 248 * $exampleRate / 100) }}</span></div>
        </div>
    </div>
</div>

<!-- Add/Edit Tax Rule Modal -->
<div id="taxRuleModal" class="hidden fixed inset-0 z-50 bg-black/40 grid place-items-center p-4">
    <form method="POST" id="taxRuleForm" class="bg-white rounded-3xl shadow-soft w-full max-w-md p-6">
        @csrf
        <div id="taxRuleMethodField"></div>
        <div class="flex items-center justify-between mb-4">
            <h2 id="taxRuleModalTitle" class="font-bold text-base">Add Tax Rule</h2>
            <button type="button" onclick="document.getElementById('taxRuleModal').classList.add('hidden')" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1.5">Name</label>
                <input type="text" name="name" id="taxRuleName" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Applies To</label>
                <input type="text" name="applies_to" id="taxRuleAppliesTo" placeholder="e.g. All Products" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Rate (%)</label>
                <input type="number" name="rate" id="taxRuleRate" step="0.01" min="0" max="100" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <label class="flex items-center gap-2 text-sm font-medium">
                <input type="checkbox" name="is_active" id="taxRuleActive" value="1" checked class="rounded"> Active
            </label>
            <button type="submit" class="w-full bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition">Save Rule</button>
        </div>
    </form>
</div>

<script>
  (function () {
    const modal = document.getElementById('taxRuleModal');
    function openModal(data) {
      const form = document.getElementById('taxRuleForm');
      form.action = data ? "{{ url('admin/settings/tax-rules') }}/" + data.id : "{{ route('admin.system.settings.tax-rules.store') }}";
      document.getElementById('taxRuleMethodField').innerHTML = data ? '<input type="hidden" name="_method" value="PATCH">' : '';
      document.getElementById('taxRuleModalTitle').textContent = data ? 'Edit Tax Rule' : 'Add Tax Rule';
      document.getElementById('taxRuleName').value = data?.name || '';
      document.getElementById('taxRuleAppliesTo').value = data?.appliesTo || '';
      document.getElementById('taxRuleRate').value = data?.rate || '';
      document.getElementById('taxRuleActive').checked = data ? data.active === '1' : true;
      modal.classList.remove('hidden');
    }
    document.getElementById('addTaxRuleBtn').addEventListener('click', () => openModal(null));
    document.querySelectorAll('.edit-tax-btn').forEach(btn => btn.addEventListener('click', () => openModal(btn.dataset)));

    const csrfToken = "{{ csrf_token() }}";
    document.querySelectorAll('.tax-toggle').forEach(cb => {
      cb.addEventListener('change', () => {
        const params = new URLSearchParams();
        params.append('_method', 'PATCH');
        params.append('_token', csrfToken);
        params.append('name', cb.dataset.name);
        params.append('applies_to', cb.dataset.appliesTo);
        params.append('rate', cb.dataset.rate);
        if (cb.checked) params.append('is_active', '1');
        fetch("{{ url('admin/settings/tax-rules') }}/" + cb.dataset.id, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: params.toString(),
        }).then(() => window.location.reload());
      });
    });
  })();
</script>
