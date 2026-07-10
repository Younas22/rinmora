@php
    $titleOkPct = $seoMetas->count() ? round($stats['title_ok'] / $seoMetas->count() * 100) : 0;
    $descOkPct = $seoMetas->count() ? round($stats['desc_ok'] / $seoMetas->count() * 100) : 0;
    $altPct = $stats['missing_alt'] > 0 ? min(100, $stats['missing_alt'] * 10) : 0;
    $filterLabels = ['all' => 'All Pages', 'products' => 'Products', 'categories' => 'Categories', 'blog' => 'Blog'];
@endphp

<div id="panel-overview" class="tab-panel space-y-6 {{ request('tab', 'overview') !== 'overview' ? 'hidden' : '' }}">

    <div class="grid md:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <div class="flex items-center gap-3 mb-3">
                <span class="w-9 h-9 rounded-full bg-success/10 grid place-items-center shrink-0"><i class="fa-solid fa-heading text-success text-xs"></i></span>
                <div class="min-w-0">
                    <p class="text-sm font-bold">{{ $stats['title_ok'] }} / {{ $seoMetas->count() }} optimized</p>
                    <p class="text-black/45 text-xs">Meta Titles</p>
                </div>
            </div>
            <div class="h-1.5 rounded-full bg-black/5 overflow-hidden"><div class="h-full bg-success rounded-full" style="width:{{ $titleOkPct }}%"></div></div>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <div class="flex items-center gap-3 mb-3">
                <span class="w-9 h-9 rounded-full bg-warning/10 grid place-items-center shrink-0"><i class="fa-solid fa-align-left text-warning text-xs"></i></span>
                <div class="min-w-0">
                    <p class="text-sm font-bold">{{ $stats['desc_ok'] }} / {{ $seoMetas->count() }} optimized</p>
                    <p class="text-black/45 text-xs">Meta Descriptions</p>
                </div>
            </div>
            <div class="h-1.5 rounded-full bg-black/5 overflow-hidden"><div class="h-full bg-warning rounded-full" style="width:{{ $descOkPct }}%"></div></div>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <div class="flex items-center gap-3 mb-3">
                <span class="w-9 h-9 rounded-full bg-danger/10 grid place-items-center shrink-0"><i class="fa-solid fa-image text-danger text-xs"></i></span>
                <div class="min-w-0">
                    <p class="text-sm font-bold">{{ $stats['missing_alt'] }} images</p>
                    <p class="text-black/45 text-xs">Missing Alt Text</p>
                </div>
            </div>
            <div class="h-1.5 rounded-full bg-black/5 overflow-hidden"><div class="h-full bg-danger rounded-full" style="width:{{ $altPct }}%"></div></div>
        </div>
    </div>

    <!-- Filter pills -->
    <div class="bg-white rounded-2xl shadow-card p-3 flex flex-wrap items-center gap-2">
        @foreach ($filterLabels as $key => $label)
            <a href="{{ route('admin.cms.seo.index', ['tab' => 'overview', 'filter' => $key]) }}" class="text-xs font-semibold px-4 py-2 rounded-full transition {{ $filter === $key ? 'bg-ink text-white' : 'text-black/55 hover:bg-black/5' }}">{{ $label }}</a>
        @endforeach
    </div>

    <!-- Analytics Summary Table -->
    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
        <h2 class="font-bold text-sm mb-5">Analytics Summary</h2>
        <table class="w-full text-sm min-w-[640px]">
            <thead>
                <tr class="text-left text-black/40 text-xs uppercase tracking-wide">
                    <th class="pb-3 font-medium">Page</th>
                    <th class="pb-3 font-medium">SEO Score</th>
                    <th class="pb-3 font-medium">Meta Title</th>
                    <th class="pb-3 font-medium">Meta Description</th>
                    <th class="pb-3 font-medium">Last Checked</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($filteredMetas as $meta)
                    @php
                        $scoreColor = $meta->seo_score >= 80 ? 'success' : ($meta->seo_score >= 60 ? 'warning' : 'danger');
                    @endphp
                    <tr class="hover:bg-black/[0.02] transition">
                        <td class="py-3.5 font-medium">
                            <a href="{{ route('admin.cms.seo.index', ['tab' => 'meta-editor', 'page' => $meta->page_url]) }}" class="hover:underline">{{ $meta->page_label }}</a>
                        </td>
                        <td class="py-3.5"><span class="bg-{{ $scoreColor }}/10 text-{{ $scoreColor }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ $meta->seo_score }}</span></td>
                        <td class="py-3.5">@if ($meta->meta_title_ok)<i class="fa-solid fa-circle-check text-success"></i>@else<i class="fa-solid fa-circle-xmark text-danger"></i>@endif</td>
                        <td class="py-3.5">@if ($meta->meta_description_ok)<i class="fa-solid fa-circle-check text-success"></i>@else<i class="fa-solid fa-circle-xmark text-danger"></i>@endif</td>
                        <td class="py-3.5 text-black/45">{{ $meta->updated_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-10 text-center text-black/40 text-sm">No pages tracked yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
