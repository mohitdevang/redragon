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
    <div class="background-img">
        <div class="h-100 d-flex">
            <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 m-auto m-auto">
                <div class="login-card d-flex flex-column">

                    @if (session()->has('registersuccess'))
                    <div class="alert alert-info login-success-btn mb-0">
                        {{ session('registersuccess') }}
                    </div>

                    @endif





                    <h5 class="font-20 text-center themeColor mb-0">Login credentials</h5>

                    <form class="form-horizontal m-t-30 d-flex flex-column justify-content-center align-items-center gap-2" method="POST">
                        <div class="form-group">
                            <div class="col-12">
                                <label class="text-white">User ID :
                                    {{Auth::guard()->user()->unique_id}}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label class="text-white">Password :
                                    {{Auth::guard()->user()->secpwd}}</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-12">
                                <label class="text-white">Name : {{Auth::guard()->user()->name}}</label>
                            </div>
                        </div>

                        <!--  <div class="form-group">

                                <div class="col-12">

                                    <div class="checkbox checkbox-primary">

                                            <div class="custom-control custom-checkbox">

                                                    <input type="checkbox" class="custom-control-input" id="customCheck1">

                                                    <label class="custom-control-label" for="customCheck1"> Remember me</label>

                                                  </div>

                                    </div>

                                </div>

                            </div> -->






                            <!-- Button -->
                            <div class="d-flex justify-content-center mt-4">
                                <a href="{{ route('userlogin') }}" class="text-white font-16 semibold cta-login text-center"
                                >Login</a>
                            </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Scripts -->
    <script src="{{url('/')}}/public/admin/assets/js/jquery.js"></script>
    <script src="{{url('/')}}/public/admin/assets/js/bootstrap.bundle.min.js"></script>


</body>

</html>