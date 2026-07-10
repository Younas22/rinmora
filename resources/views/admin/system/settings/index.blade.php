@extends('admin.catalog.layouts.app')

@section('title', 'Settings')

@section('content')

    @php
        $settingsTabs = [
            'general' => ['icon' => 'fa-sliders', 'label' => 'General'],
            'store-info' => ['icon' => 'fa-building', 'label' => 'Store Information'],
            'logo-favicon' => ['icon' => 'fa-image', 'label' => 'Logo & Favicon'],
            'theme-colors' => ['icon' => 'fa-palette', 'label' => 'Theme Colors'],
            'email' => ['icon' => 'fa-envelope', 'label' => 'Email Settings'],
            'sms' => ['icon' => 'fa-comment-sms', 'label' => 'SMS Settings'],
            'social' => ['icon' => 'fa-share-nodes', 'label' => 'Social Media'],
            'seo' => ['icon' => 'fa-magnifying-glass-chart', 'label' => 'SEO Settings'],
            'currency' => ['icon' => 'fa-coins', 'label' => 'Currency'],
            'taxes' => ['icon' => 'fa-percent', 'label' => 'Taxes'],
            'language' => ['icon' => 'fa-language', 'label' => 'Language'],
            'timezone' => ['icon' => 'fa-clock', 'label' => 'Timezone'],
        ];
    @endphp

    <div class="mb-6">
        <h1 class="text-xl md:text-2xl font-bold">Settings</h1>
        <p class="text-black/45 text-sm mt-1">Store-wide configuration for Rinmora.</p>
    </div>

    <div class="grid lg:grid-cols-[248px_1fr] gap-6 items-start">
        @include('admin.catalog.partials.vertical-tabs', ['tabs' => $settingsTabs])

        <div class="min-w-0">
            @include('admin.system.settings.partials.general')
            @include('admin.system.settings.partials.store-info')
            @include('admin.system.settings.partials.logo')
            @include('admin.system.settings.partials.theme')
            @include('admin.system.settings.partials.email')
            @include('admin.system.settings.partials.sms')
            @include('admin.system.settings.partials.social')
            @include('admin.system.settings.partials.seo')
            @include('admin.system.settings.partials.currency')
            @include('admin.system.settings.partials.taxes')
            @include('admin.system.settings.partials.language')
            @include('admin.system.settings.partials.timezone')
        </div>
    </div>

@endsection
