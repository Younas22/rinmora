@extends('admin.catalog.layouts.app')

@section('title', 'Activity Logs')

@section('content')

    @php
        $activityTabs = [
            'admin-activity' => ['icon' => 'fa-user-pen', 'label' => 'Admin Activity'],
            'login-history' => ['icon' => 'fa-right-to-bracket', 'label' => 'Login History'],
            'error-logs' => ['icon' => 'fa-bug', 'label' => 'Error Logs'],
        ];
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Activity Logs</h1>
            <p class="text-black/45 text-sm mt-1">Audit trail of admin actions and sign-ins.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Actions Today</p>
            <p class="text-xl font-bold">{{ $stats['actions_today'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Active Admins (24h)</p>
            <p class="text-xl font-bold text-info">{{ $stats['active_admins'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Failed Logins (24h)</p>
            <p class="text-xl font-bold text-danger">{{ $stats['failed_logins_24h'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Open Errors</p>
            <p class="text-xl font-bold text-warning">{{ $stats['open_errors'] }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-[248px_1fr] gap-6 items-start">
        @include('admin.catalog.partials.vertical-tabs', ['tabs' => $activityTabs])

        <div class="min-w-0">
            @include('admin.system.activity.partials.admin-activity')
            @include('admin.system.activity.partials.login-history')
            @include('admin.system.activity.partials.error-logs')
        </div>
    </div>

@endsection
