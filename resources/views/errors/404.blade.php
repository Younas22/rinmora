<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="HR - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Error 404</title>
    
    <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{url('public/assets/img/favicon.png')}}">
    
    <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{url('public/assets/css/bootstrap.min.css')}}">
    
    <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{url('public/assets/css/font-awesome.min.css')}}">
    
    <!-- Lineawesome CSS -->
        <link rel="stylesheet" href="{{url('public/assets/css/line-awesome.min.css')}}">
    
    <!-- Main CSS -->
        <link rel="stylesheet" href="{{url('public/assets/css/style.css')}}">
    </head>
    <body class="error-page">
    <!-- Main Wrapper -->
        <div class="main-wrapper">
      
      <div class="error-box">
        <h1>404</h1>
        <h3><i class="fa fa-warning"></i> 

            <?php 
            dd($error_message);
            ?>


        <p>
            @if (isset($error_message))
                {{$error_message}} @else {{'Something Wrong!'}}
            @endif
        </p>
        <a href="{{ url('home') }}" class="btn btn-custom">Back to Home</a>
      </div>
    
        </div>
    <!-- /Main Wrapper -->
    
    <!-- jQuery -->
        <script src="{{url('public/assets/js/jquery-3.6.0.min.js')}}"></script>
    
    <!-- Bootstrap Core JS -->
        <script src="{{url('public/assets/js/bootstrap.bundle.min.js')}}"></script>
    
    <!-- Custom JS -->
    <script src="{{url('public/assets/js/app.js')}}"></script>
    
    </body>
</html>