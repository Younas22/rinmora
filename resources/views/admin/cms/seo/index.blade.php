@extends('admin.catalog.layouts.app')

@section('title', 'SEO')

@section('content')

    @php
        $tabs = [
            'overview' => ['icon' => 'fa-gauge-high', 'label' => 'Overview'],
            'meta-editor' => ['icon' => 'fa-pen-to-square', 'label' => 'Meta Editor'],
            'sitemap-robots' => ['icon' => 'fa-sitemap', 'label' => 'Sitemap & Robots'],
            'redirects' => ['icon' => 'fa-arrows-turn-right', 'label' => 'Redirects'],
            'schema' => ['icon' => 'fa-code', 'label' => 'Schema Markup'],
        ];
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">SEO</h1>
            <p class="text-black/45 text-sm mt-1">Monitor search visibility and manage on-page SEO across your store.</p>
        </div>
    </div>

    <!-- KPI Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-gauge-high text-primary-dark text-xs"></i></span>
            <p class="text-xl font-bold">{{ $stats['avg_score'] }}<span class="text-black/30 text-sm font-semibold">/100</span></p>
            <p class="text-black/45 text-xs mt-0.5">Avg. SEO Score <span title="Heuristic estimate based on title/description length and focus keyword presence — not a real crawl score."><i class="fa-regular fa-circle-question text-black/25"></i></span></p>
        </div>
        <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-file-circle-check text-primary-dark text-xs"></i></span>
            <p class="text-xl font-bold">{{ $stats['indexed_pages'] }}</p>
            <p class="text-black/45 text-xs mt-0.5">Pages Tracked</p>
        </div>
        <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
            <span class="w-9 h-9 rounded-full bg-danger/10 grid place-items-center mb-3"><i class="fa-solid fa-link-slash text-danger text-xs"></i></span>
            <p class="text-xl font-bold">{{ $stats['broken_links'] }}</p>
            <p class="text-black/45 text-xs mt-0.5">404s Logged</p>
        </div>
        <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
            <span class="w-9 h-9 rounded-full bg-danger/10 grid place-items-center mb-3"><i class="fa-solid fa-image text-danger text-xs"></i></span>
            <p class="text-xl font-bold">{{ $stats['missing_alt'] }}</p>
            <p class="text-black/45 text-xs mt-0.5">Images Missing Alt Text</p>
        </div>
    </div>

    <!-- Tab Nav + Panels -->
    <div class="grid lg:grid-cols-[248px_1fr] gap-6 items-start">
        @include('admin.catalog.partials.vertical-tabs', ['tabs' => $tabs])

        <div class="min-w-0">
            @include('admin.cms.seo.partials.overview')
            @include('admin.cms.seo.partials.meta-editor')
            @include('admin.cms.seo.partials.sitemap-robots')
            @include('admin.cms.seo.partials.redirects')
            @include('admin.cms.seo.partials.schema')
        </div>
    </div>

@endsection
