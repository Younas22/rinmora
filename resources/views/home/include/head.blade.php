<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <meta name="robots" content="index, follow"> --}}
        <meta name="robots" content="noindex">
        <meta name="keywords" content="{{$keywords}}">
        <meta name="description" content="{{$meta_description}}">
        <meta name="author" content="YounasDev">

        <!-- MEDA FOR SEARCH ENGINES AND SOCIAL PLATFORMS -->
        <meta property="og:locale" content="en_US" />
        <meta property="og:title" content="{{$meta_title}}">
        <meta property="og:description" content="{{$meta_description}}">
        <meta property="og:type" content="website">
        <meta property="og:image" content="{{$image}}">
        <meta property="og:image:width" content="1000" />
        <meta property="og:image:height" content="700" />
        <meta property="og:site_name" content="YounasDev"/>
        <meta property="og:url" content="{{url()->current()}}"/>
        <meta property="og:publisher" content="YounasDev"/>


            <!-- TWITTER CARD -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@'YounasDev' | {{$title}}" />
        <meta name="twitter:title" content="{{$meta_title}}" />
        <meta name="twitter:description" content="{{$meta_description}}" />
        <meta name="twitter:image" content="{{$image}}" />

        <link rel="icon" href="{{url('public/web/images/favicon.png')}}">
        <link rel="canonical" href="{{url()->current()}}" />
        <title>{{$title}}</title>


        <!-- CSS FILES -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
        <link href="{{url('public/web/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{url('public/web/css/bootstrap-icons.css')}}" rel="stylesheet">
        <link href="{{url('public/web/css/magnific-popup.css')}}" rel="stylesheet">
        <link href="{{url('public/web/css/templatemo-first-portfolio-style.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    </head>
    
    <body>
        <section class="preloader">
            <div class="spinner">
                <span class="spinner-rotate"></span>
            </div>
        </section>