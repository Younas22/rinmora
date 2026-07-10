@extends('admin.catalog.layouts.app')

@section('title', 'Notifications')

@section('content')

    @php
        $notifTabs = [
            'system' => ['icon' => 'fa-bell', 'label' => 'System'],
            'customer' => ['icon' => 'fa-paper-plane', 'label' => 'Customer Notifications'],
            'email-logs' => ['icon' => 'fa-envelope-circle-check', 'label' => 'Email Logs'],
        ];
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Notifications</h1>
            <p class="text-black/45 text-sm mt-1">System alerts, customer messaging campaigns, and email delivery logs.</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-[248px_1fr] gap-6 items-start">
        @include('admin.catalog.partials.vertical-tabs', ['tabs' => $notifTabs])

        <div class="min-w-0">
            @include('admin.cms.notifications.partials.system')
            @include('admin.cms.notifications.partials.customer')
            @include('admin.cms.notifications.partials.email-logs')
        </div>
    </div>

@endsection
