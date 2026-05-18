@extends('layouts.user_profile')
@section('content')



<div class="content-page">

    <div class="col-md-12 col-lg-10">
        <div class="glass-card">
            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Change Password</h2>
            </div>
            <form class="d-flex flex-column gap-4" id="change-password-form" action="{{ route('change-password') }}"
                method="post">
                {{ csrf_field() }}

                @if(Session::has('success'))

                <p class="alert alert-success">{!! Session::get('success') !!}</p>
                @elseif(Session::has('danger'))
                <p class="alert alert-danger">{!! Session::get('danger') !!}</p>

                @endif

    
                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-email-input" class="font-14 regular text-white">Old Password</label>
                    <div class="position-relative">
                        <input class="custom-input"  type="text" name="oldpwd"  placeholder="" readonly>
                        <button type="button" class="file-upload-btn border-0" onclick="senf_otp()">send
                            otp
                            to mail</button>
                    </div>
                </div>



                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-text-input" class="font-14 regular text-white">New Password</label>

                    <input class="custom-input" type="text" name="newpwd" id="newpwd">


                </div>

                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-text-input" class="font-14 regular text-white">Confirm
                        Password</label>

                    <input class="custom-input" type="text" name="cpwd">


                </div>

                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-text-input" class="font-14 regular text-white">OTP</label>

                    <input class="custom-input" type="text" name="otp" id="otp">

                </div>



                <button type="submit" class="submit-button w-25  mt-2">Submit</button>
            </form>
        </div>
    </div>

</div>


@endsection
@push('js')

<script>

    $(document).ready(function () {

        $.validator.addMethod("emailRegex", function (value, element) {
            if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) { return true; } else { return false; }
        }, "Please enter a valid Email.");

        $.validator.addMethod("nameRegex", function (value, element) {
            return this.optional(element) || /^([a-zA-Z_-\s]{3,20})$/.test(value);
        }, "Enter valid name");


        $("#change-password-form").validate({

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

                oldpwd: {
                    required: true,

                },

                newpwd: {
                    required: true
                },
                cpwd: {
                    required: true,
                    equalTo: "#newpwd"
                },


            },



        });



    });



    function senf_otp() {
        var token = $('input[name="_token"]').val();
        $.ajax({
            type: 'post',
            url: '{{ route('send_otp')}}',
            data: { '_token': token },
            dataType: 'JSON',
            success: function (data) {

                if (data.success) {

                    alert('OTP sent sucessfully,please check your mail');

                }

            }
        });
    }



</script>


@endpush