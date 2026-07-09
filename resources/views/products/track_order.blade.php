<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Successfully Created</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <style type="text/css">
    </style>
  </head>
  <body style="background-color: black_;">
    <!-- Add orders Modal -->
    <div class="container">
      @if (Auth::check())
      @if (auth()->user()->roll == 'hr' && $created_by == 'admin' || auth()->user()->roll == 'hr' && $created_by == 'self')
      <div class="row">
        <div class="col-md-12">
          <div class="success-section p-5 text-center">
            <h1  class="text-center">Order Successfully Created</h1><hr>
            <p class="mt-5">Order ID: #{{$order_details->order_id}}</p>
            <p>Your order has been created successfully. You can track your order by clicking <br><a href="{{route('all-orders.index')}}" class="btn btn-danger text-center m-3">Go To order</a><button class="btn btn-success text-center m-3" onclick="myFunction('{{route('track.order',$order_details->order_id)}}')">Click to Copy</button></p>
            
          </div>
        </div>
      </div>
      @endif

      @if (auth()->user()->roll == 'user' &&  $created_by == 'self' || auth()->user()->roll == 'user' && $created_by == 'admin')
      <div class="row">
        <div class="col-md-12">
          <div class="success-section p-5 text-center">
            <h1  class="text-center">Order Successfully Created</h1><hr>
            <p class="mt-5">Order ID: #{{$order_details->order_id}}</p>
            <p>Your order has been created successfully. You can track your order by clicking <br><a href="{{route('all-orders.index')}}" class="btn btn-danger text-center mt-3">Go To order</a></p>
          </div>
        </div>
      </div>
      @endif

      @else
      <div class="row">
        <div class="col-md-12">
          <div class="success-section p-5">
            <h1  class="text-center">Order Successfully Created</h1>
            <p>Order ID: #{{$order_details->order_id}}</p>
            <p>Your order has been created successfully. You can track your order by logging into your dashboard. <br><b>You can save this login details for more orders!</b></p>
            <hr>
          </div>
        </div>
      </div>
      <div class="row">




        <div class="col-md-6 offset-md-3">

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif


          <form class="bg-light p-3" action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="email">Email</label>
              <input type="hidden" name="back_url" value="all-orders">
              <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{$email}}">
              @if ($errors->has('email'))
                  <span class="text-danger">{{ $errors->first('email') }}</span>
              @endif
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="text" class="form-control" id="password" placeholder="Password" name="password" value="{{$password}}">
              @if ($errors->has('password'))
                  <span class="text-danger">{{ $errors->first('password') }}</span>
              @endif
            </div>
            <button type="submit" class="btn btn-success">Login</button>
          </form>
        </div>
      </div>
      @endif
    </div>
    <!-- /Add orders Modal -->
    <script>
    function myFunction(url) {
    navigator.clipboard.writeText(url);
    }
    </script>
  </body>
</html>