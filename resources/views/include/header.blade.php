<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="HR - Bootstrap Admin Template">
        <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Dashboard - Younas Dev</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{url('public/web/images/favicon.png')}}">
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{url('public/assets/css/bootstrap.min.css')}}">
        
        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{url('public/assets/css/font-awesome.min.css')}}">
        
        <!-- Lineawesome CSS -->
        <link rel="stylesheet" href="{{url('public/assets/css/line-awesome.min.css')}}">

        <!-- Select2 CSS -->
        <link rel="stylesheet" type="text/css" href="{{url('public/assets/css/select2.min.css')}}">

        <!-- Datetimepicker CSS -->
        <link rel="stylesheet" href="{{url('public/assets/plugins/datetimepicker/css/tempusdominus-bootstrap-4.min.css')}}">
        
        <!-- Calendar CSS -->
        <link rel="stylesheet" href="{{url('public/assets/css/fullcalendar.min.css')}}">
        
        <!-- Main CSS -->
        <link rel="stylesheet" href="{{url('public/assets/css/style.css')}}">
        
                
    </head>
     
    <body>
        <!-- Main Wrapper -->
        <div class="main-wrapper">
        
            <!-- Header -->
            <div class="header">
            
                <!-- Logo -->
                <div class="header-left">
                    <?php if (auth()->user()->roll == 'user') { ?>
                        <a href="{{ route('employee-dashboard') }}" class="logo">
                            <img src="{{url('public/web/images/favicon.png')}}" width="40" height="40" alt="">
                        </a>
                    <?php }else{ ?>
                        <a href="{{ route('hr-dashboard') }}" class="logo">
                            <img src="{{url('public/web/images/favicon.png')}}" width="40" height="40" alt="">
                        </a>
                    <?php } ?>
                </div>
                <!-- /Logo -->
                
                <a id="toggle_btn" href="javascript:void(0);">
                    <span class="bar-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>
                
                <!-- Header Search -->
                <div class="page-search-box d-none">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /Header Search -->
                
                <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
                
                <!-- Header Menu -->
                <ul class="nav user-menu">
                
                    <!-- Notifications -->
                    <li class="nav-item dropdown">
                        @if (auth()->user()->roll == 'hr')
                        <a href="{{route('notifications')}}" class="nav-link">
                            <i class="fa fa-bell-o"></i> <span class="badge badge-pill">3</span>
                        </a>
                        @endif

                        <div class="dropdown-menu notifications d-none">
                            <div class="topnav-dropdown-header">
                                <span class="notification-title">Notifications</span>
                                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                            </div>
                            <div class="noti-content">
                                <ul class="notification-list">
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="{{url('public/assets/img/profiles/avatar-02.jpg')}}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
                                                    <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="{{url('public/assets/img/profiles/avatar-03.jpg')}}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
                                                    <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="{{url('public/assets/img/profiles/avatar-06.jpg')}}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
                                                    <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="{{url('public/assets/img/profiles/avatar-17.jpg')}}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
                                                    <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="{{url('public/assets/img/profiles/avatar-13.jpg')}}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
                                                    <p class="noti-time"><span class="notification-time">2 days ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="topnav-dropdown-footer">
                                <a href="activities.html">View all Notifications</a>
                            </div>
                        </div>
                    </li>
                    <!-- /Notifications -->

                    <li class="nav-item dropdown has-arrow main-drop">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <span class="user-img"><img src="@if (empty(auth()->user()->profile_image)){{url('public/assets/img/profiles/avatar-21.jpg')}}
                                @else
                                {{url('public/profile_image').'/'.auth()->user()->profile_image}}
                                @endif" alt="">
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('profile') }}">My Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </div>
                    </li>
                </ul>
                <!-- /Header Menu -->
                
                <!-- Mobile Menu -->
                <div class="dropdown mobile-user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('profile') }}">My Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </div>
                <!-- /Mobile Menu -->
                
            </div>
            <!-- /Header -->
<!-- Page Wrapper -->
<div class="page-wrapper">

@include('include.sidebar')
            

