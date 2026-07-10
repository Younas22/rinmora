@extends('admin.catalog.layouts.app')

@section('title', 'Pages')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Pages</h1>
            <p class="text-black/45 text-sm mt-1">Manage static content pages (About, Privacy Policy, Terms, etc).</p>
        </div>
        <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-5 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
            <i class="fa-solid fa-plus text-[10px]"></i> Add New Page
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Total Pages</p>
            <p class="text-xl font-bold">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Published</p>
            <p class="text-xl font-bold text-success">{{ number_format($stats['published']) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Draft</p>
            <p class="text-xl font-bold text-warning">{{ number_format($stats['draft']) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Private</p>
            <p class="text-xl font-bold">{{ number_format($stats['private']) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card overflow-hidden">
        <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <label for="pageSearch" class="sr-only">Search pages</label>
                <input id="pageSearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search by name, slug, or content..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
            </div>
            <div class="relative">
                <select name="status" aria-label="Filter by status" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Status</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="private" @selected(request('status') === 'private')>Private</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/5 transition">
                <i class="fa-solid fa-filter text-[10px]"></i> Filter
            </button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[720px]">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        <th class="py-3 pl-5 font-medium">Page</th>
                        <th class="py-3 font-medium">Status</th>
                        <th class="py-3 font-medium">In Menu</th>
                        <th class="py-3 font-medium">Modified</th>
                        <th class="py-3 pr-5 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($pages as $page)
                        <tr class="hover:bg-black/[0.02] transition">
                            <td class="py-3 pl-5">
                                <p class="font-semibold">
                                    {{ $page->name }}
                                    @if ($page->is_homepage)
                                        <span class="bg-primary/20 text-ink text-[10px] font-semibold px-2 py-0.5 rounded-full ml-1">Homepage</span>
                                    @endif
                                </p>
                                <p class="text-black/40 text-xs mt-0.5">/{{ $page->slug }}</p>
                            </td>
                            <td class="py-3">
                                @if ($page->status === 'published')
                                    <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Published</span>
                                @elseif ($page->status === 'draft')
                                    <span class="bg-warning/10 text-warning text-[11px] font-semibold px-2.5 py-1 rounded-full">Draft</span>
                                @else
                                    <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">Private</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if ($page->show_in_menu)
                                    <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Yes</span>
                                @else
                                    <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">No</span>
                                @endif
                            </td>
                            <td class="py-3 text-black/55">
                                {{ $page->updated_at->format('M j, Y') }}
                                <div class="text-black/35 text-xs">{{ $page->updated_at->diffForHumans() }}</div>
                            </td>
                            <td class="py-3 pr-5 text-right whitespace-nowrap">
                                @if ($page->status === 'published')
                                    <a href="{{ $page->url }}" target="_blank" class="text-xs font-semibold text-black/50 hover:text-ink transition mr-3">View</a>
                                @endif
                                <a href="{{ route('admin.pages.edit', $page) }}" class="text-xs font-semibold text-black/50 hover:text-ink transition mr-3">Edit</a>
                                <form method="POST" action="{{ route('admin.pages.duplicate', $page) }}" class="inline mr-3">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold text-black/50 hover:text-ink transition">Duplicate</button>
                                </form>
                                @unless ($page->is_homepage)
                                    <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="inline" onsubmit="return confirm('Delete this page?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-danger hover:text-danger/70 transition">Delete</button>
                                    </form>
                                @endunless
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-black/40 text-sm">No pages found — add your first one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pages->hasPages())
            <div class="p-4 md:p-5 border-t border-black/5">
                {{ $pages->withQueryString()->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>

@endsection
