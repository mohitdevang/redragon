@extends('layouts.front')
@section('content')
<link rel="stylesheet" href="{{url('/')}}/public/design/css/dots-animation.css" />
<style>
.form_input1{
	color:#000!important;
	background:#fff!important;
	padding: 0 1.53846em!important;
    height: 3.23077em!important;
    border-radius: 2em!important;
    border-color: #d7d9db!important;
    font-size: .8125em!important;
}
.blackbtn {
	color:#fff!important;
    display: table!important;
    padding: 0 15px!important;
    min-width: 200px!important;
    height: 38px!important;
    margin: 0 auto!important;
    outline: none!important;
    border-radius: 19px!important;
    background: #f44236!important;
    font-size: 13px!important;
    font-weight: 700!important;
    line-height: 34px!important;
    transition: background .2s ease-in-out!important;
    float: none!important;
}
.logo-login{
    height: 120px;
    margin-left: auto;
    display: block;
    margin-right: auto;
}
.text-theme-dark{
    color:#0f1110 !important;
}
.wrapper {
    height: 100vh;
    width: 100%;
    background: linear-gradient(309deg, rgba(131, 58, 180, 1) 0%, rgba(200, 42, 18, 0.87718837535014) 79%)
}

.wrapper h3 {
    position: relative;
    top: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    opacity: 0.8
}

.boxes div {
    position: absolute;
    width: 40px;
    height: 40px;
    background-color: transparent;
    border: 3px solid #fff;
    color: #fff;
    font-size: 18px;
    text-align: center;
    vertical-align: middle;
    justify-content: center;
    padding: 10px;
}

.boxes div:nth-child(1) {
    top: 70%;
    left: 10%;
    animation: box-animate 10s infinite
}

.boxes div:nth-child(2) {
    top: 20%;
    left: 80%;
    animation: box-animate 9s infinite
}

.boxes div:nth-child(3) {
    top: 50%;
    left: 50%;
    animation: box-animate 6s infinite
}

.boxes div:nth-child(4) {
    top: 80%;
    left: 60%;
    animation: box-animate 15s infinite
}

.boxes div:nth-child(5) {
    top: 30%;
    left: 30%;
    animation: box-animate 9s infinite
}

.boxes div:nth-child(6) {
    top: 90%;
    left: 90%;
    animation: box-animate 12s infinite
}

.boxes div:nth-child(7) {
    top: 80%;
    left: 30%;
    animation: box-animate 2s infinite
}

.boxes div:nth-child(8) {
    top: 40%;
    left: 20%;
    animation: box-animate 2s infinite
}

.boxes div:nth-child(9) {
    top: 50%;
    left: 80%;
    animation: box-animate 2s infinite
}

@keyframes box-animate {
    0% {
        transform: scale(0) translateY(0) rotate(0);
        opacity: 1
    }

    100% {
        transform: scale(1.3) translateY(-90px) rotate(360deg);
        opacity: 0
    }
}
.accountbg {
    background: linear-gradient(
309deg
, rgba(131, 58, 180, 1) 0%, rgba(200, 42, 18, 0.87718837535014) 79%) !important;
   
}
</style>
  <div class="accountbg"></div>
   <div class="boxes">
        <div>W</div>
        <div>E</div>
        <div>L</div>
        <div>C</div>
        <div>O</div>
        <div>M</div>
        <div>E</div>
        <div>J</div>
        <div>I</div>
    </div>         
        <div class="wrapper-page" style="z-index: 3999;">
                <div class="card card-pages shadow-none" style="padding: 0px 1.375em;
    border-radius: 5px;
    background: #d4f6fb;
    color: #fff;
    border: 2px solid #d4f6fb;" >
    
                    <div class="card-body">
                        <div class="text-center m-t-0 m-b-15">
                                 <a href="#" class="logo logo-admin"> <img src="{!! asset('public/uploads/'.$setting->logo) !!}" class="logo-login"></a>
                        </div>
                          @if (session()->has('registersuccess'))
    <div class="alert alert-info">
        {{ session('registersuccess') }}
    </div>

    @elseif (session()->has('danger'))
    <div class="alert alert-danger">
        {{ session('danger') }}
    </div>
@endif

                        <h5 class="font-18 text-center" style="color:#f44236;" >Forgot Password</h5>

    
                               <form class="form-horizontal m-t-30" method="POST" action="{{ route('reset_password') }}">
                        @csrf
    
                            <div class="form-group">
                                <div class="col-12">
                                        <label class="text-theme-dark">Phone Number</label>
                                    <input class="form-control form_input1" type="text" required="" name="phone" value="{{ old('phone') }}" required autocomplete="id" autofocus required>
                                </div>
                                 
                            </div>
    
                       
    
                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary blackbtn btn-block btn-lg waves-effect waves-light" type="submit">Submit</button>
                                </div>
                            </div>
    
                        </form>
                    </div>
    
                </div>
            </div>



 @endsection
 @push('js')

<script>

$(document).ready(function() {

$.validator.addMethod("emailRegex",function(value, element) {
        if(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test( value ))
        { return true;} else{ return false;}    
  },"Please enter a valid Email.");
  
$.validator.addMethod("nameRegex", function (value, element) {
        return this.optional(element) || /^([a-zA-Z_-\s]{3,20})$/.test(value);
    }, "Enter valid name");


        $("#register-form").validate({

          errorElement: 'span',
          errorClass: 'help-block',
          highlight: function(element, errorClass, validClass) {
            $(element).addClass("has-error");
          },
          unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("has-error");
          },
          errorPlacement: function (error, element) {
            if (element.attr("type") == "checkbox") {
                //error.insertAfter($(element).parent());
            }else{ 
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
                cpws:{
                    required: true,
                    equalTo : "#userpwd"
                },

                 phone:{
                     required: true,
                    minlength: 8,
                    maxlength: 13,
                    digits: true    
                },
                 sponsor_id:{
                    required: true
                },

                sponsor_name:{
                    required: true
                },

                country:{
                    required: true
                },

            },

           

        });

    });

</script>


 @endpush