@extends('admin.catalog.layouts.app')

@section('title', 'My Profile')

@section('content')

    @php
        $profileTabs = [
            'profile' => ['icon' => 'fa-user', 'label' => 'My Profile'],
            'password' => ['icon' => 'fa-lock', 'label' => 'Change Password'],
            'preferences' => ['icon' => 'fa-bell', 'label' => 'Notification Preferences'],
        ];
    @endphp

    <div class="mb-6">
        <h1 class="text-xl md:text-2xl font-bold">My Profile</h1>
        <p class="text-black/45 text-sm mt-1">Manage your account details, security, and preferences.</p>
    </div>

    <div class="grid lg:grid-cols-[248px_1fr] gap-6 items-start mb-6">
        @include('admin.catalog.partials.vertical-tabs', ['tabs' => $profileTabs])

        <div class="min-w-0">
            @include('admin.system.profile.partials.info')
            @include('admin.system.profile.partials.password')
            @include('admin.system.profile.partials.preferences')
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 flex items-center justify-between gap-4">
        <div>
            <p class="font-bold text-sm">Sign Out</p>
            <p class="text-black/45 text-xs mt-0.5">End your current admin session on this device.</p>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 text-danger border border-danger/20 rounded-full px-5 py-2.5 text-xs font-semibold hover:bg-danger/5 transition">
                <i class="fa-solid fa-right-from-bracket text-[10px]"></i> Logout
            </button>
        </form>
    </div>

@endsection
