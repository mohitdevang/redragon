<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Font Css -->
    <!-- <link href="{{url('/')}}/public/admin/assets/css/stylesheet.css" rel="stylesheet"> -->
    <!-- Custom Css -->
    <link href="{{url('/')}}/public/admin/assets/css/style.css" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{url('/')}}/public/admin/assets/css/bootstrap.min.css" rel="stylesheet">


</head>

<body class="">
    <!-- Login -->
    <div class="login-page-wrapper">
        <div class="h-100 d-flex  login-container">
            <div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-5 m-auto m-auto">
                <div class="login-card pb-4 my-4">


                    @if (session()->has('success'))

                    <div class="alert alert-info">

                        {{ session('success') }}

                    </div>

                    @endif



                    @if (session()->has('danger'))

                    <div class="alert alert-info" style="color: red;">

                        {{ session('danger') }}

                    </div>

                    @endif


                    <form class="d-flex flex-column gap-3" id="register-form" action="{{ route('register-form') }}"
                        method="POST">

                        @csrf

                        <!-- Header -->
                        <div class="d-flex flex-column justify-content-center align-items-center scalable-gap-12">
                            <img src="{{url('/')}}/public/admin/assets/images/svg/logo.svg" class="logo-img img-fluid">
                            <h3 class="font-16 regular lightColor">Create your account</h3>
                        </div>

                        <!-- Scroll Area -->
                        <div class="scroll-bar">
                            <div class="row gy-3 signup">

                                <!-- Sponsor ID -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Sponsor ID</label>
                                        <input type="text" class="custom-input borderColor" name="sponsor_id"
                                            id="sponsor_id"
                                            value="@if(isset($sponsor)) {{ $sponsor->unique_id }} @endif"
                                            placeholder="Enter Sponsor ID" required>
                                        <span class="text-danger" id="sponsor_id_err"></span>
                                    </div>
                                </div>

                                <!-- Sponsor Name -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Sponsor Name</label>
                                        <input type="text" class="custom-input borderColor" name="sponsor_name"
                                            id="sponsor_name" value="@if(isset($sponsor)) {{ $sponsor->name }} @endif"
                                            readonly required>
                                    </div>
                                </div>

                                <!-- Full Name -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Full Name</label>
                                        <input type="text" class="custom-input borderColor" name="name"
                                            placeholder="Enter Full Name" required>
                                    </div>
                                </div>

                                <!-- Country -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Country</label>
                                        <select class="custom-input borderColor" name="country">
                                            <option value="India">India</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Email</label>
                                        <input type="email" class="custom-input borderColor" name="email"
                                            placeholder="Enter Email" required>
                                        @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Mobile No.</label>
                                        <div class="position-relative">
                                            <input type="text" class="custom-input borderColor" name="phone"
                                                placeholder="Phone No." required>
                                            <!-- <button type="button" class="file-upload-btn border-0" onclick="senf_otp()">
                                                OTP
                                            </button> -->
                                            @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>

                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <!-- <div class="form-group d-flex flex-column gap-2">
                                    <label for="example-email-input" class="font-14 regular text-white">Old
                                        Password</label>
                                    <div class="position-relative">
                                        <input class="custom-input" type="text" name="oldpwd" placeholder="" readonly>
                                        <button type="button" class="file-upload-btn border-0" onclick="senf_otp()">send
                                            otp
                                            to mail</button>
                                    </div>
                                </div> -->

                                <!-- Password -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Password</label>
                                        <input type="password" class="custom-input borderColor" name="userpwd"
                                            id="userpwd" placeholder="Password" required>

                                        @if ($errors->has('userpwd'))
                                        <span class="text-danger">{{ $errors->first('userpwd') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Confirm Password</label>
                                        <input type="password" class="custom-input borderColor" name="cpws" id="cpws"
                                            placeholder="Confirm Password" required>
                                        <span class="text-danger" id="message"></span>
                                    </div>
                                </div>
                                <!-- OTP -->
                                <!-- <div class="col-md-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">OTP</label>
                                        <input type="text" class="custom-input borderColor" name="otp" id="otp"
                                            placeholder="Enter OTP" maxlength="6" required>
                                        <span class="text-danger" id="otpMessage"></span>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="form-footer">
                            <label class="checkbox-wrapper">
                                <input type="checkbox" class="checkbox-input" id="saveCard" name="remember" required>
                                <span class="checkbox-label" for="saveCard"> I agree with the terms of use</span>
                            </label>
                        </div>
                        <!-- Submit -->
                        <div class="d-flex justify-content-center">
                            <button class="submit-button" type="submit">
                                Sign up
                            </button>
                        </div>

                        <!-- Login -->
                        <h4 class="font-16 regular mb-0 text-white text-center">
                            Already have an Account?
                            <a href="{{ route('userlogin') }}" class="primaryColor semibold">Sign in</a>
                        </h4>

                    </form>


                </div>
            </div>
        </div>
    </div>



    <!-- Scripts -->
    <script src="{{url('/')}}/public/admin/assets/js/jquery.js"></script>
    <script src="{{url('/')}}/public/admin/assets/js/bootstrap.bundle.min.js"></script>


    <script src="{{ asset('public/design/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/design/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/design/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('public/design/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('public/design/js/waves.min.js') }}"></script>
    <script src="{{ asset('public/design/js/app.js') }}"></script>
    <script src="{{ asset('public/design/js/jquery.validate.js') }}"></script>

    <script>



        $(document).ready(function () {



            $.validator.addMethod("emailRegex", function (value, element) {

                if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) { return true; } else { return false; }

            }, "Please enter a valid Email.");



            $.validator.addMethod("nameRegex", function (value, element) {

                return this.optional(element) || /^([a-zA-Z_-\s]{3,20})$/.test(value);

            }, "Enter valid name");





            $("#register-form").validate({



                errorElement: 'span',

                errorClass: 'help-block',

                highlight: function (element, errorClass, validClass) {

                    $(element).addClass("has-error");

                },

                unhighlight: function (element, errorClass, validClass) {

                    $(element).removeClass("has-error");

                },

                errorPlacement: function (error, element) {

                    if (element.attr("type") == "checkbox") {

                        //error.insertAfter($(element).parent());

                    } else {

                        error.insertAfter(element);

                    }

                },



                rules: {



                    name: {

                        required: true,

                        nameRegex: true

                    },



                    email: {

                        required: true,

                        emailRegex: true

                    },



                    userpwd: {

                        required: true

                    },

                    cpws: {

                        required: true,

                        equalTo: "#userpwd"

                    },



                    phone: {

                        required: true,

                        minlength: 10,

                        maxlength: 10,

                        digits: true

                    },





                    sponsor_id: {

                        required: true

                    },



                    sponsor_name: {

                        required: true

                    },



                    country: {

                        required: true

                    },



                },







            });



            $("#sponsor_id").keyup(function () {


                var token = $('input[name="_token"]').val();

                $.ajax({

                    type: 'post',

                    url: '{{ route('get_sopnsor_name')}}',

                    data: { '_token': token, 'sponsor_id': $(this).val() },

                    dataType: 'JSON',

                    success: function (data) {



                        if (data.success) {

                            $('#sponsor_name').val(data.success);

                            $('#sponsor_id_err').html('')

                        }

                        if (data.err) {

                            $('#sponsor_id_err').html('wrong sponsor id');

                            $('#sponsor_name').val('');

                        }



                    }

                });





            });



        });









    </script>
</body>

</html>