<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="keywords" content="{{ $seo['keywords'] }}">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:image" content="{{ $seo['img'] }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="icon" type="image/jpeg" href="{{ asset('public/assets/images/personal/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('public/assets/images/personal/logo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { 'brand': '#B1E78E' } } }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">


    @include('common.analytics')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #000; color: #fff; margin: 0; }
        :root { --brand: #B1E78E; }

        .btn-brand {
            background: #B1E78E; color: #000; font-weight: 700; border: none; cursor: pointer;
            transition: opacity .2s, transform .15s; display: inline-flex; align-items: center;
            justify-content: center; gap: 8px; text-decoration: none; border-radius: 10px;
            padding: 14px 28px; font-size: 1rem;
        }
        .btn-brand:hover { opacity: .88; transform: translateY(-2px); }

        .btn-outline {
            background: transparent; color: #fff; font-weight: 600; border: 2px solid #333;
            cursor: pointer; transition: background .2s, color .2s, border-color .2s;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            text-decoration: none; border-radius: 10px; padding: 12px 26px; font-size: 1rem;
        }
        .btn-outline:hover { background: #fff; color: #000; border-color: #fff; }

        .btn-ghost {
            background: rgba(255,255,255,0.06); color: #fff; font-weight: 600;
            border: 1px solid rgba(255,255,255,0.12); cursor: pointer; transition: background .2s;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            text-decoration: none; border-radius: 10px; padding: 12px 26px; font-size: 1rem;
        }
        .btn-ghost:hover { background: rgba(255,255,255,0.11); }

        .wa-float {
            position: fixed; bottom: 28px; right: 28px; z-index: 9999;
            width: 56px; height: 56px; border-radius: 50%; background: #25D366;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 20px rgba(37,211,102,.5); transition: transform .2s;
        }
        .wa-float:hover { transform: scale(1.1); }

        .section-line { border-color: #1a1a1a; }
        nav { background: #000; border-bottom: 1px solid #1a1a1a; }

        .hero-img {
            width: 100%; height: calc(100vh - 64px);
            object-fit: contain; object-position: top center; display: block;
        }
        @media (max-width: 1023px) { .hero-img { height: 300px; } }

        .proof-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(177,231,142,0.08); border: 1px solid rgba(177,231,142,0.2);
            color: #B1E78E; padding: 5px 14px; border-radius: 100px;
            font-size: 0.75rem; font-weight: 600;
        }

        .service-card {
            background: #0a0a0a; border: 1px solid #1e1e1e; border-radius: 16px;
            padding: 28px; transition: border-color .25s, transform .2s; position: relative; overflow: hidden;
        }
        .service-card:hover { border-color: #B1E78E; transform: translateY(-4px); }
        .service-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent, #B1E78E, transparent);
            opacity: 0; transition: opacity .25s;
        }
        .service-card:hover::before { opacity: 1; }

        .tag-pill {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);
            color: #9ca3af; padding: 5px 12px; border-radius: 100px; font-size: 0.72rem; font-weight: 500;
        }

        .glow-green { box-shadow: 0 0 50px rgba(177,231,142,0.12); }

        @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:.35;} }
        .pulse-dot { animation: pulse-dot 1.6s infinite; }

        .social-link {
            color: #6b7280; text-decoration: none; font-size: .85rem; font-weight: 500;
            display: inline-flex; align-items: center; gap: 5px; transition: color .2s;
        }
        .social-link:hover { color: #B1E78E; }

        .hero-bio a { border-bottom: 1px solid rgba(177,231,142,0.35); transition: border-color .2s; }
        .hero-bio a:hover { border-color: #B1E78E; }
    </style>
</head>
<body>


    @include("common.navbar")
