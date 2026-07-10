{{-- Shared vertical tab nav. Expects $tabs = ['key' => ['icon' => 'fa-...', 'label' => '...']]. --}}
<nav class="lg:sticky lg:top-[88px] bg-white rounded-3xl shadow-card p-3 flex lg:flex-col gap-1 overflow-x-auto lg:overflow-visible">
    @foreach ($tabs as $key => $tab)
        <button type="button" class="tab-btn {{ $loop->first ? 'active-tab bg-primary/20 text-ink font-semibold' : 'text-black/60 font-medium' }} w-full text-left flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm hover:bg-black/5 transition whitespace-nowrap shrink-0" data-tab="{{ $key }}">
            <i class="fa-solid {{ $tab['icon'] }} w-4 text-center"></i> {{ $tab['label'] }}
        </button>
    @endforeach
</nav>

<script>
  (function () {
    document.querySelectorAll('.tab-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => {
          b.classList.remove('active-tab', 'bg-primary/20', 'text-ink', 'font-semibold');
          b.classList.add('text-black/60', 'font-medium');
        });
        btn.classList.add('active-tab', 'bg-primary/20', 'text-ink', 'font-semibold');
        btn.classList.remove('text-black/60', 'font-medium');
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
        document.getElementById('panel-' + btn.dataset.tab)?.classList.remove('hidden');
      });
    });

    const params = new URLSearchParams(window.location.search);
    const wantedTab = params.get('tab');
    if (wantedTab) {
      document.querySelector('.tab-btn[data-tab="' + wantedTab + '"]')?.click();
    }
  })();
</script>
