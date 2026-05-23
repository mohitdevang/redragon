<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign Up</title>
    <link href="{{url('/')}}/public/admin/assets/css/style.css" rel="stylesheet">
    <link href="{{url('/')}}/public/admin/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('public/admin-design/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .phone-row { display:flex; gap:8px; align-items:stretch; flex-wrap:nowrap; }
        .phone-field-error { display:block; width:100%; margin-top:4px; font-size:12px; line-height:1.4; }
        .dial-preview { width:55px; text-align:center; padding:10px 5px; }
        .phone-input { flex:1; min-width:0; }
        .otp-toolbar { display:flex; align-items:center; justify-content:flex-end; gap:10px; margin-top:8px; min-height:38px; }
        .otp-feedback { font-size:12px; word-break:break-word; }
        .otp-feedback.is-success { color:#4ade80; }
        .otp-feedback.is-danger { color:#f87171; }
        .otp-feedback.is-info { color:#fbbf24; }
        .otp-toolbar-right { display:flex; align-items:center; gap:10px; flex-shrink:0; }
        .otp-resend-countdown { font-size:12px; color:#fbbf24; white-space:nowrap; min-width:88px; text-align:right; }
        .btn-otp-compact { width:auto !important; padding:6px 14px !important; font-size:13px !important; min-width:108px; }
        .btn-otp-compact.is-loading { opacity:0.85; cursor:wait; }
        .otp-verify-row { display:none; margin-top:10px; }
        .otp-verify-row.active { display:flex; gap:8px; align-items:center; }
        .otp-verify-row .otp-input { flex:1; min-width:0; }
        .otp-expiry-line { font-size:12px; color:#94a3b8; }
        .select2-container { width:100% !important; }
        .select2-container .select2-selection--single { height:42px; border:1px solid rgba(255,255,255,.2); background:transparent; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height:40px; color:#fff; }
        .select2-dropdown { background:#1c1c28 !important; border:1px solid rgba(255,255,255,.15) !important; color:#fff !important; }
        .select2-results__option { color:#fff !important; }
        .select2-results__option--highlighted { background:#c41e3a !important; color:#fff !important; }
        .select2-search__field { color:#fff !important; background:#12121a !important; }
        #reg-api-alert { font-size:13px; }
    </style>
</head>

<body class="">
    <div class="login-page-wrapper">
        <div class="h-100 d-flex login-container">
            <div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-5 m-auto">
                <div class="login-card pb-4 my-4">

                    @if (session()->has('success'))
                    <div class="alert alert-info">{{ session('success') }}</div>
                    @endif
                    @if (session()->has('danger'))
                    <div class="alert alert-danger">{{ session('danger') }}</div>
                    @endif

                    <form class="d-flex flex-column gap-3" id="register-form" action="{{ route('register-form') }}" method="POST">
                        @csrf

                        <div class="d-flex flex-column justify-content-center align-items-center scalable-gap-12">
                            <img src="{{url('/')}}/public/admin/assets/images/svg/logo.svg" class="logo-img img-fluid">
                            <h3 class="font-16 regular lightColor">Create your account</h3>
                        </div>

                        <div class="scroll-bar">
                            <div class="row gy-3 signup">

                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Sponsor ID</label>
                                        <input type="text" class="custom-input borderColor" name="sponsor_id" id="sponsor_id"
                                            value="@if(isset($sponsor)){{ $sponsor->unique_id }}@endif" placeholder="Enter Sponsor ID" required>
                                        <span class="text-danger" id="sponsor_id_err"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Sponsor Name</label>
                                        <input type="text" class="custom-input borderColor" name="sponsor_name" id="sponsor_name"
                                            value="@if(isset($sponsor)){{ $sponsor->name }}@endif" readonly required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Full Name</label>
                                        <input type="text" class="custom-input borderColor" name="name" placeholder="Enter Full Name" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Country</label>
                                        <select class="custom-input borderColor" name="country_id" id="country_id" required>
                                            <option value="">Search country...</option>
                                            @foreach($countries ?? [] as $c)
                                            @php $dial = \App\Support\CountryDial::normalize($c->dial_code); $flag = \App\Support\CountryDial::flagEmoji($c->iso_code); @endphp
                                            <option value="{{ $c->id }}" data-dial="{{ $dial }}" {{ old('country_id') == $c->id ? 'selected' : '' }}>
                                                {{ $flag ? $flag.' ' : '' }}{{ $c->name }} ({{ $dial }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Email</label>
                                        <input type="email" class="custom-input borderColor" name="email" placeholder="Enter Email" required>
                                        @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Mobile No.</label>
                                        <div class="phone-row">
                                            <span class="custom-input borderColor dial-preview" id="dial_preview">+91</span>
                                            <input type="text" class="custom-input borderColor phone-input" name="phone" id="phone"
                                                placeholder="Phone No." required value="{{ old('phone') }}">
                                        </div>
                                        <div class="phone-field-errors">
                                        @if ($errors->has('phone'))
                                        <span class="text-danger phone-field-error">{{ $errors->first('phone') }}</span>
                                        @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-0" id="reg-otp-block">
                                    <div class="otp-toolbar" id="reg-otp-toolbar">
                                        <div class="otp-toolbar-right">
                                            <span class="otp-resend-countdown" id="otp-resend-countdown"></span>
                                            <button type="button" class="submit-button btn-otp-compact" id="btn-send-otp">Generate OTP</button>
                                        </div>
                                    </div>
                                    <div class="otp-verify-row" id="otp-verify-row">
                                        <input type="text" class="custom-input borderColor otp-input" id="reg_otp" placeholder="Enter OTP" maxlength="10" autocomplete="one-time-code">
                                        <button type="button" class="submit-button btn-otp-compact flex-shrink-0" id="btn-verify-otp">Verify OTP</button>
                                    </div>
                                    <div class="otp-feedback" id="otp-feedback"></div>
                                    <div class="otp-expiry-line" id="otp-expiry-line"></div>
                                    <input type="hidden" name="registration_verification_token" id="registration_verification_token" value="{{ old('registration_verification_token') }}">
                                </div>

                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Password</label>
                                        <input type="password" class="custom-input borderColor" name="userpwd" id="userpwd" placeholder="Password" required>
                                        @if ($errors->has('userpwd'))
                                        <span class="text-danger">{{ $errors->first('userpwd') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column gap-2">
                                        <label class="font-16 regular lightColor">Confirm Password</label>
                                        <input type="password" class="custom-input borderColor" name="cpws" id="cpws" placeholder="Confirm Password" required>
                                        <span class="text-danger" id="message"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-footer">
                            <label class="checkbox-wrapper">
                                <input type="checkbox" class="checkbox-input" id="saveCard" name="remember" required>
                                <span class="checkbox-label" for="saveCard"> I agree with the terms of use</span>
                            </label>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button class="submit-button" type="submit">Sign up</button>
                        </div>

                        <h4 class="font-16 regular mb-0 text-white text-center">
                            Already have an Account?
                            <a href="{{ route('userlogin') }}" class="primaryColor semibold">Sign in</a>
                        </h4>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{url('/')}}/public/admin/assets/js/jquery.js"></script>
    <script src="{{url('/')}}/public/admin/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public/admin-design/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/design/js/jquery.validate.js') }}"></script>
    <script src="{{ url('/') }}/public/admin/assets/js/redragon-json.js"></script>
    <script src="{{ url('/') }}/public/admin/assets/js/redragon-otp-ui.js"></script>

    <script>
    (function(){
        var appBase = @json($app_base ?? '');
        var csrf = $('meta[name="csrf-token"]').attr('content');
        var resendSec = {{ (int) (($whatsapp_settings->otp_resend_cooldown_seconds ?? 120)) }};
        var otpExpiryMin = {{ (int) (($whatsapp_settings->otp_expiry_minutes ?? 5)) }};
        var searchUrl = @json(url('countries/search'));
        var otpVerified = !!$('#registration_verification_token').val();
        var otpSentOnce = false;
        var $feedback = $('#otp-feedback');
        var $btnSend = $('#btn-send-otp');
        var $btnVerify = $('#btn-verify-otp');
        var $otpInput = $('#reg_otp');
        var UI = window.RedragonOtpUi;
        var OTP_KEY = 'reg';

        function apiUrl(path){ return (appBase ? appBase : '') + path; }

        function parseDone(data, xhr){ return UI.parseResponse(data, xhr); }

        function lockVerifiedUI(message){
            otpVerified = true;
            $('#otp-verify-row').addClass('active');
            UI.applyVerifiedState({
                key: OTP_KEY,
                $countdown: $('#otp-resend-countdown'),
                $expiry: $('#otp-expiry-line'),
                $btnSend: $btnSend,
                $btnVerify: $btnVerify,
                $otpInput: $otpInput,
                $feedback: $feedback,
                message: message || 'OTP verified successfully. You can sign up now.'
            });
        }

        if(otpVerified){
            lockVerifiedUI('Mobile number verified. You can sign up now.');
        }

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            xhrFields: { withCredentials: true },
            dataType: 'text',
            converters: {
                'text json': function(text) {
                    var parsed = RedragonJson.parse(text);
                    if (!parsed) { throw new Error('Invalid JSON'); }
                    return parsed;
                }
            }
        });

        function select2AjaxTransport(params, success, failure) {
            var $request = $.ajax($.extend({}, params, { dataType: 'text' }));
            $request.then(function(data, textStatus, jqXHR) {
                var parsed = RedragonJson.parse(jqXHR) || (typeof data === 'object' ? data : RedragonJson.parse(data));
                if (parsed) { success(parsed); } else { failure(); }
            });
            $request.fail(function(xhr) {
                var parsed = RedragonJson.parse(xhr);
                if (parsed && parsed.results) { success(parsed); } else { failure(xhr); }
            });
            return $request;
        }

        $('#country_id').select2({
            placeholder: 'Search country...',
            allowClear: true,
            minimumInputLength: 0,
            ajax: {
                url: searchUrl,
                delay: 250,
                transport: select2AjaxTransport,
                data: function(params){ return { q: params.term || '' }; },
                processResults: function(data){ return data || { results: [] }; },
                cache: true
            }
        });

        function updateDial(){
            var dial = $('#country_id').find(':selected').data('dial') || '';
            if(!dial && $('#country_id').select2('data')[0]){
                dial = $('#country_id').select2('data')[0].dial_code || '';
            }
            $('#dial_preview').text(dial || '+');
        }
        $('#country_id').on('change select2:select', updateDial);
        updateDial();

        $('#btn-send-otp').on('click', function(){
            if(otpVerified){ return; }
            if(!$('#country_id').val() || !$('#phone').val()){
                UI.setFeedback($feedback, 'danger', 'Select country and enter mobile number first.');
                return;
            }
            UI.clearFeedback($feedback);
            UI.setButtonLoading($btnSend, true, 'Sending...');
            $.ajax({
                url: apiUrl('/register/send-otp'),
                method: 'POST',
                dataType: 'text',
                data: { country_id: $('#country_id').val(), phone: $('#phone').val() }
            }).done(function(data, status, xhr){
                var res = parseDone(data, xhr);
                if(!res || !UI.isSuccess(res)){
                    UI.setFeedback($feedback, 'danger', UI.messageFromResponse(res, xhr, 'Failed to send OTP.'));
                    UI.setButtonIdle($btnSend, otpSentOnce ? 'Resend OTP' : 'Generate OTP', true);
                    return;
                }
                otpSentOnce = true;
                otpVerified = false;
                $('#registration_verification_token').val('');
                $('#otp-verify-row').addClass('active');
                $otpInput.prop('readonly', false).prop('disabled', false).removeAttr('readonly disabled');
                if(res.sandbox && res.otp){ $otpInput.val(res.otp); }
                var okMsg = res.sandbox
                    ? 'OTP sent successfully (sandbox). Enter the code.'
                    : 'OTP sent successfully to your WhatsApp.';
                UI.setFeedback($feedback, 'success', okMsg);
                UI.startResendCooldown({
                    key: OTP_KEY,
                    $btn: $btnSend,
                    $countdown: $('#otp-resend-countdown'),
                    seconds: resendSec,
                    resendLabel: 'Resend OTP'
                });
                UI.startExpiryCountdown({
                    key: OTP_KEY,
                    $el: $('#otp-expiry-line'),
                    expiresAtMs: UI.parseExpiresAt(res, otpExpiryMin)
                });
            }).fail(function(xhr){
                var res = parseDone(null, xhr);
                UI.setFeedback($feedback, 'danger', UI.messageFromResponse(res, xhr, 'Failed to send OTP. Please try again.'));
                UI.setButtonIdle($btnSend, otpSentOnce ? 'Resend OTP' : 'Generate OTP', true);
            });
        });

        $('#btn-verify-otp').on('click', function(){
            if(otpVerified){ return; }
            var code = $otpInput.val().trim();
            if(!code){
                UI.setFeedback($feedback, 'danger', 'Please enter the OTP.');
                return;
            }
            UI.setButtonLoading($btnVerify, true, 'Verifying...');
            $.ajax({
                url: apiUrl('/register/verify-otp'),
                method: 'POST',
                dataType: 'text',
                data: { country_id: $('#country_id').val(), phone: $('#phone').val(), otp: code }
            }).done(function(data, status, xhr){
                var res = parseDone(data, xhr);
                if(!res){
                    UI.setButtonIdle($btnVerify, 'Verify OTP', true);
                    UI.setFeedback($feedback, 'danger', 'Invalid server response. Please try again.');
                    return;
                }
                if(UI.isSuccess(res)){
                    $('#registration_verification_token').val(res.verification_token || '');
                    lockVerifiedUI('OTP verified successfully. You can sign up now.');
                    return;
                }
                UI.setButtonIdle($btnVerify, 'Verify OTP', true);
                UI.setFeedback($feedback, 'danger', UI.messageFromResponse(res, xhr, 'Verification failed. Please try again.'));
            }).fail(function(xhr){
                UI.setButtonIdle($btnVerify, 'Verify OTP', true);
                var res = parseDone(null, xhr);
                UI.setFeedback($feedback, 'danger', UI.messageFromResponse(res, xhr, 'Invalid OTP. Please check and try again.'));
            });
        });

        $('#register-form').on('submit', function(e){
            if(!otpVerified || !$('#registration_verification_token').val()){
                e.preventDefault();
                UI.setFeedback($feedback, 'danger', 'Please verify OTP before signing up.');
            }
        });

        $.validator.addMethod("emailRegex", function (value) {
            return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
        }, "Please enter a valid Email.");

        $.validator.addMethod("nameRegex", function (value, element) {
            return this.optional(element) || /^([a-zA-Z_-\s]{3,20})$/.test(value);
        }, "Enter valid name.");

        $("#register-form").validate({
            errorElement: 'span',
            errorClass: 'help-block text-danger',
            errorPlacement: function (error, element) {
                if (element.attr('name') === 'phone') {
                    error.addClass('phone-field-error');
                    error.appendTo(element.closest('.form-group').find('.phone-field-errors'));
                    return;
                }
                if (element.attr('name') === 'country_id') {
                    error.insertAfter(element.closest('.form-group').find('.select2-container'));
                    return;
                }
                error.insertAfter(element);
            },
            highlight: function (element) {
                $(element).addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).removeClass('has-error');
            },
            rules: {
                name: { required: true, nameRegex: true },
                email: { required: true, emailRegex: true },
                userpwd: { required: true },
                cpws: { required: true, equalTo: "#userpwd" },
                phone: { required: true, minlength: 6, maxlength: 15, digits: true },
                sponsor_id: { required: true },
                sponsor_name: { required: true },
                country_id: { required: true }
            }
        });

        $("#sponsor_id").keyup(function () {
            $.ajax({
                type: 'post',
                url: apiUrl('/get-sopnsor-name'),
                data: { '_token': csrf, 'sponsor_id': $(this).val() },
                dataType: 'JSON',
                success: function (data) {
                    if (data.success) {
                        $('#sponsor_name').val(data.success);
                        $('#sponsor_id_err').html('');
                    }
                    if (data.err) {
                        $('#sponsor_id_err').html('wrong sponsor id');
                        $('#sponsor_name').val('');
                    }
                }
            });
        });
    })();
    </script>
</body>
</html>
