@extends('admin.catalog.layouts.app')

@section('title', 'Contact & Support')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Contact &amp; Support</h1>
            <p class="text-black/45 text-sm mt-1">Customer messages, support tickets, and newsletter subscribers.</p>
        </div>
    </div>

    <div class="inline-flex items-center gap-1 bg-white rounded-full shadow-card p-1.5 mb-6">
        <button type="button" class="section-tab-btn {{ $tab === 'messages' ? 'active-section-tab bg-primary/20 text-ink' : 'text-black/50' }} px-5 py-2 rounded-full text-xs font-semibold transition" data-section="messages">
            <i class="fa-solid fa-envelope mr-1.5"></i> Contact Messages
        </button>
        <button type="button" class="section-tab-btn {{ $tab === 'tickets' ? 'active-section-tab bg-primary/20 text-ink' : 'text-black/50' }} px-5 py-2 rounded-full text-xs font-semibold transition" data-section="tickets">
            <i class="fa-solid fa-ticket mr-1.5"></i> Support Tickets
        </button>
        <button type="button" class="section-tab-btn {{ $tab === 'newsletter' ? 'active-section-tab bg-primary/20 text-ink' : 'text-black/50' }} px-5 py-2 rounded-full text-xs font-semibold transition" data-section="newsletter">
            <i class="fa-solid fa-paper-plane mr-1.5"></i> Newsletter Subscribers
        </button>
    </div>

    @include('admin.system.support.partials.messages')
    @include('admin.system.support.partials.tickets')
    @include('admin.system.support.partials.newsletter')

@endsection

@push('scripts')
<script>
  document.querySelectorAll('.section-tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.section-tab-btn').forEach(b => { b.classList.remove('active-section-tab', 'bg-primary/20', 'text-ink'); b.classList.add('text-black/50'); });
      btn.classList.add('active-section-tab', 'bg-primary/20', 'text-ink');
      btn.classList.remove('text-black/50');

      const section = btn.dataset.section;
      document.querySelectorAll('.section-panel').forEach(p => p.classList.add('hidden'));
      document.getElementById('section-' + section).classList.remove('hidden');
    });
  });
</script>
@endpush
