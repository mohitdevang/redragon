<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Font Css -->
    <!-- <link href="{{url('/')}}/public/admin/assets/css/stylesheet.css" rel="stylesheet"> -->
    <!-- Custom Css -->
    <link href="{{url('/')}}/public/admin/assets/css/style.css" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{url('/')}}/public/admin/assets/css/bootstrap.min.css" rel="stylesheet">


</head>

<body class="overflow-hidden">
    <!-- Login -->
    <div class="login-page-wrapper">
        <div class="h-100 d-flex login-container">
            <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 m-auto m-auto">
                <div class="login-card d-flex flex-column">
            
                        <form class="d-flex flex-column gap-3" method="POST" action="{{ route('userlogin') }}">

                        @csrf

                        <div class="d-flex flex-column justify-content-center align-items-center scalable-gap-12 ">
                            <img src="{{url('/')}}/public/admin/assets/images/svg/logo.svg" class="logo-img img-fluid">
                            <h3 class="font-16 regular lightColor">Login to your account</h3>
                        </div>
                        <div class="form-group d-flex flex-column gap-2">
                            <label class="font-16 regular lightColor">User ID</label>
                            <input type="text" class="custom-input borderColor"  name="unique_id" value="{{ old('unique_id') }}" required autocomplete="id" autofocus placeholder="Enter User ID">
                        </div>
                        <div class="form-group d-flex flex-column gap-2">
                            <label class="font-16 regular lightColor">Password</label>
                            <input type="password" class="custom-input borderColor"  required=""  name="password" required autocomplete="current-password" placeholder="Enter Password">
                              @error('phone')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                        </div>
            
                         <div class="form-footer">
                            <label class="checkbox-wrapper">
                                <input type="checkbox" class="checkbox-input" id="saveCard" name="remember">
                                <span class="checkbox-label" for="saveCard">Remember me?</span>
                            </label>
                            <a href="{{ route('forgot_password') }}" class="forgot-link">Forgot Password?</a>
                        </div>
                        
                       <a class="d-flex justify-content-center mb-4">
                         <button class="submit-button" type="submit">Sign in</button>
                       </a>
                    </form>
                   <a href="{{ route('register') }}"> <h4 class="font-16 regular mb-0 text-white text-center">Don’t have an account? <span class="primaryColor cursor-pointer">Click here to sign up.</span></h4></a>
                </div>
            </div>
        </div>
    </div>



    <!-- Scripts -->
    <script src="{{url('/')}}/public/admin/assets/js/jquery.js"></script>
    <script src="{{url('/')}}/public/admin/assets/js/bootstrap.bundle.min.js"></script>


</body>

</html>