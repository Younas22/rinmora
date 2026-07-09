@extends('admin.catalog.layouts.app')

@section('title', 'Attributes')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Attributes</h1>
            <p class="text-black/45 text-sm mt-1">Attributes power variant selection on the product page.</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-[320px_1fr] gap-6 items-start">

        <form method="POST" action="{{ $editing ? route('admin.catalog.attributes.update', $editing) : route('admin.catalog.attributes.store') }}" id="attributeForm" class="bg-white rounded-3xl shadow-card p-5 lg:sticky lg:top-[88px]">
            @csrf
            @if ($editing) @method('PUT') @endif

            <h2 class="font-bold text-sm mb-1">{{ $editing ? 'Edit Attribute' : 'Add New Attribute' }}</h2>
            <p class="text-black/40 text-xs mb-5">Attributes power variant selection on the product page.</p>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5" for="attrName">Attribute Name</label>
                    <input id="attrName" name="name" type="text" value="{{ old('name', $editing?->name) }}" placeholder="e.g. Strap Length" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="attrType">Display Type</label>
                    <div class="relative">
                        <select id="attrType" name="display_type" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition pr-10">
                            @foreach (['dropdown' => 'Dropdown', 'color_swatch' => 'Color Swatch', 'button' => 'Button / Chip', 'text' => 'Text'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('display_type', $editing?->display_type) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="attrValueInput">Values</label>
                    <div id="valueChips" class="flex flex-wrap items-center gap-1.5 px-3 py-2 rounded-xl border border-black/10 focus-within:ring-2 focus-within:ring-primary transition">
                        <input id="attrValueInput" type="text" placeholder="Type and press Enter..." class="flex-1 min-w-[90px] py-1 text-xs bg-transparent focus:outline-none">
                    </div>
                    <p class="text-black/35 text-[11px] mt-1.5">Press Enter or comma to add a value.</p>
                </div>

                <label class="flex items-center justify-between gap-4 py-1 cursor-pointer">
                    <div>
                        <p class="text-sm font-semibold">Use for Variants</p>
                        <p class="text-black/45 text-xs mt-0.5">Allow this attribute to generate SKUs.</p>
                    </div>
                    <span class="relative inline-flex items-center shrink-0">
                        <input type="checkbox" name="use_for_variants" value="1" class="peer sr-only" @checked(old('use_for_variants', $editing?->use_for_variants ?? true))>
                        <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                        <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                    </span>
                </label>

                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition mt-2">
                    <i class="fa-solid fa-{{ $editing ? 'check' : 'plus' }} text-[10px]"></i> {{ $editing ? 'Update Attribute' : 'Add Attribute' }}
                </button>
                @if ($editing)
                    <a href="{{ route('admin.catalog.attributes.index') }}" class="block text-center text-xs font-semibold text-black/45 hover:text-ink transition mt-2">Cancel edit</a>
                @endif
            </div>
        </form>

        <div class="space-y-4">
            @forelse ($attributes as $attribute)
                <div class="bg-white rounded-3xl shadow-card p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-full bg-primary/20 grid place-items-center shrink-0">
                                <i class="fa-solid fa-{{ ['dropdown' => 'list', 'color_swatch' => 'palette', 'button' => 'layer-group', 'text' => 'font'][$attribute->display_type] }} text-primary-dark text-sm"></i>
                            </span>
                            <div>
                                <p class="font-semibold text-sm">{{ $attribute->name }}</p>
                                <p class="text-black/40 text-xs mt-0.5">{{ ['dropdown' => 'Dropdown', 'color_swatch' => 'Color Swatch', 'button' => 'Button / Chip', 'text' => 'Text'][$attribute->display_type] }} &middot; {{ $attribute->values->count() }} values</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 shrink-0">
                            <a href="{{ route('admin.catalog.attributes.index', ['edit' => $attribute->id]) }}" aria-label="Edit attribute" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition text-black/40"><i class="fa-solid fa-pen text-xs"></i></a>
                            <form method="POST" action="{{ route('admin.catalog.attributes.destroy', $attribute) }}" onsubmit="return confirm('Delete this attribute?');">
                                @csrf @method('DELETE')
                                <button type="submit" aria-label="Delete attribute" class="w-8 h-8 rounded-full grid place-items-center hover:bg-danger/5 transition text-black/40 hover:text-danger"><i class="fa-solid fa-trash-can text-xs"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4">
                        @forelse ($attribute->values as $value)
                            <span class="bg-black/[0.04] rounded-full px-3 py-1.5 text-xs font-medium">{{ $value->value }}</span>
                        @empty
                            <span class="text-black/30 text-xs">No values yet.</span>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl shadow-card p-10 text-center text-black/40 text-sm">No attributes yet — add your first one.</div>
            @endforelse
        </div>
    </div>

@endsection

@push('scripts')
<script>
  const chipContainer = document.getElementById('valueChips');
  const chipInput = document.getElementById('attrValueInput');
  const initialValues = @json($editing?->values->pluck('value') ?? []);

  function addChip(value) {
    value = value.trim();
    if (!value) return;
    const chip = document.createElement('span');
    chip.className = 'inline-flex items-center gap-1.5 bg-black/[0.04] rounded-full pl-2.5 pr-1.5 py-1 text-xs font-medium';
    chip.innerHTML = `<span>${value}</span> <button type="button" aria-label="Remove value" class="text-black/30 hover:text-danger"><i class="fa-solid fa-xmark text-[9px]"></i></button> <input type="hidden" name="values[]" value="${value.replace(/"/g, '&quot;')}">`;
    chip.querySelector('button').addEventListener('click', () => chip.remove());
    chipContainer.insertBefore(chip, chipInput);
  }

  initialValues.forEach(addChip);

  chipInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ',') {
      e.preventDefault();
      addChip(chipInput.value);
      chipInput.value = '';
    }
  });
  chipInput.addEventListener('blur', () => {
    if (chipInput.value.trim()) { addChip(chipInput.value); chipInput.value = ''; }
  });
</script>
@endpush
