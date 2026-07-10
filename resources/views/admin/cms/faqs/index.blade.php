@extends('admin.catalog.layouts.app')

@section('title', 'FAQs')

@section('content')

    @php
        $categoryLabels = [
            'orders' => 'Orders',
            'shipping' => 'Shipping',
            'returns' => 'Returns',
            'payments' => 'Payments',
            'products' => 'Products',
            'account' => 'Account',
        ];
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">FAQs</h1>
            <p class="text-black/45 text-sm mt-1">Manage the questions and answers shown on the storefront FAQ page.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Total FAQs</p>
            <p class="text-xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Visible</p>
            <p class="text-xl font-bold text-success">{{ $stats['visible'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Hidden</p>
            <p class="text-xl font-bold text-warning">{{ $stats['hidden'] }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-[360px_1fr] gap-6 items-start">

        <form method="POST" action="{{ $editing ? route('admin.cms.faqs.update', $editing) : route('admin.cms.faqs.store') }}" class="bg-white rounded-3xl shadow-card p-5 lg:sticky lg:top-[88px]">
            @csrf
            @if ($editing) @method('PUT') @endif

            <h2 class="font-bold text-sm mb-1">{{ $editing ? 'Edit FAQ' : 'Add New FAQ' }}</h2>
            <p class="text-black/40 text-xs mb-5">{{ $editing ? 'Update this question.' : 'Add a question shown on the storefront FAQ page.' }}</p>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5" for="faqCategory">Category</label>
                    <div class="relative">
                        <select id="faqCategory" name="category" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition pr-10">
                            @foreach ($categoryLabels as $value => $label)
                                <option value="{{ $value }}" @selected(old('category', $editing?->category) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="faqQuestion">Question</label>
                    <input id="faqQuestion" name="question" type="text" value="{{ old('question', $editing?->question) }}" placeholder="e.g. How do I track my order?" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="faqAnswer">Answer</label>
                    <textarea id="faqAnswer" name="answer" rows="5" placeholder="Write the answer..." class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none">{{ old('answer', $editing?->answer) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="faqSortOrder">Sort Order</label>
                    <input id="faqSortOrder" name="sort_order" type="number" min="0" value="{{ old('sort_order', $editing?->sort_order) }}" placeholder="Lower shows first" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                </div>

                <div class="flex items-center justify-between gap-4 py-1">
                    <div>
                        <p class="text-sm font-semibold">Visible</p>
                        <p class="text-black/45 text-xs mt-0.5">Shown on the storefront FAQ page.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input type="checkbox" name="is_visible" value="1" class="peer sr-only" @checked(old('is_visible', $editing?->is_visible ?? true))>
                        <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                        <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                    </label>
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition mt-2">
                    <i class="fa-solid fa-{{ $editing ? 'check' : 'plus' }} text-[10px]"></i> {{ $editing ? 'Update FAQ' : 'Add FAQ' }}
                </button>
                @if ($editing)
                    <a href="{{ route('admin.cms.faqs.index') }}" class="block text-center text-xs font-semibold text-black/45 hover:text-ink transition mt-2">Cancel edit</a>
                @endif
            </div>
        </form>

        <div class="bg-white rounded-3xl shadow-card overflow-hidden">
            <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
                <div class="relative flex-1 min-w-[200px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                    <label for="faqSearch" class="sr-only">Search FAQs</label>
                    <input id="faqSearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search FAQs..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
                </div>
                <div class="relative">
                    <select name="category" aria-label="Filter by category" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">All Categories</option>
                        @foreach ($categoryLabels as $value => $label)
                            <option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[720px]">
                    <thead>
                        <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                            <th class="py-3 pl-5 font-medium">Question</th>
                            <th class="py-3 font-medium">Category</th>
                            <th class="py-3 font-medium text-center">Sort</th>
                            <th class="py-3 font-medium">Status</th>
                            <th class="py-3 pr-5 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5">
                        @forelse ($faqs as $faq)
                            <tr class="hover:bg-black/[0.02] transition">
                                <td class="py-3 pl-5">
                                    <p class="font-semibold">{{ $faq->question }}</p>
                                    <p class="text-black/40 text-xs mt-0.5 line-clamp-1">{{ Str::limit($faq->answer, 80) }}</p>
                                </td>
                                <td class="py-3 text-black/55">{{ $categoryLabels[$faq->category] ?? $faq->category }}</td>
                                <td class="py-3 text-center">{{ $faq->sort_order }}</td>
                                <td class="py-3">
                                    @if ($faq->is_visible)
                                        <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Visible</span>
                                    @else
                                        <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">Hidden</span>
                                    @endif
                                </td>
                                <td class="py-3 pr-5 text-right">
                                    <a href="{{ route('admin.cms.faqs.index', ['edit' => $faq->id]) }}" class="text-xs font-semibold text-black/50 hover:text-ink transition mr-3">Edit</a>
                                    <form method="POST" action="{{ route('admin.cms.faqs.destroy', $faq) }}" class="inline" onsubmit="return confirm('Delete this FAQ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-danger hover:text-danger/70 transition">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-black/40 text-sm">No FAQs yet — add your first one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($faqs->hasPages())
                <div class="p-4 md:p-5 border-t border-black/5">
                    {{ $faqs->links('admin.catalog.partials.pagination') }}
                </div>
            @endif
        </div>
    </div>

@endsection
