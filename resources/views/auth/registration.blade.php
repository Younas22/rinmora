<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="HR - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Login - HRMS admin template</title>
    
    <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{url('public/assets/img/favicon.png')}}">
    
    <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{url('public/assets/css/bootstrap.min.css')}}">
    
    <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{url('public/assets/css/font-awesome.min.css')}}">
    
    <!-- Main CSS -->
        <link rel="stylesheet" href="{{url('public/assets/css/style.css')}}">
    </head>
    <body>
  
    <!-- Main Wrapper -->
        <div class="main-wrapper">
      <div class="account-content">
        <div class="container">
        
          <!-- Account Logo -->
          <div class="account-logo">
            <a href="index.html"><img src="{{url('public/assets/img/logo2.png')}}" alt="Dreamguy's Technologies"></a>
          </div>
          <!-- /Account Logo -->
          
          <div class="account-box">
            <div class="account-wrapper">
              <h3 class="account-title">Register</h3>
              <p class="account-subtitle">Create Employee Account</p>
              
              <!-- Account Form -->
              <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label>Name</label>
                  <input class="form-control" type="text" name="name" required autofocus>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                  <label>Email Address</label>
                  <input class="form-control" type="email" name="email" required autofocus>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col">
                      <label>Password</label>
                    </div>
                  </div>
                  <input class="form-control" type="password" name="password" required>
                      @if ($errors->has('password'))
                          <span class="text-danger">{{ $errors->first('password') }}</span>
                      @endif
                </div>
                <div class="form-group text-center">
                  <button class="btn btn-primary account-btn" type="submit">Register</button>
                </div>
                <div class="account-footer">
                  <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                </div>
              </form>
              <!-- /Account Form -->
              
            </div>
          </div>
        </div>
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


<!--  -->

