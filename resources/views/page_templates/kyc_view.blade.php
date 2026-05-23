@extends('layouts.user_profile')
@section('content')

<div class="content-page">
    <div class="col-md-12 col-lg-10">
        <div class="glass-card">
            <div class="card-title-border">
                <h2 class="card-title">Update Address</h2>
            </div>

            @if(Session::has('success'))
            <div class="alert alert-success">{!! Session::get('success') !!}</div>
            @elseif(Session::has('danger'))
            <div class="alert alert-danger">{!! Session::get('danger') !!}</div>
            @endif

            <form class="d-flex flex-column gap-4" id="kyc-form" action="{{ route('update-kyc') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="hid" value="{{ $kyc->id ?? '' }}">
                <input type="hidden" name="address_verification_token" id="address_verification_token" value="">

                <div class="form-group d-flex flex-column gap-2">
                    <label class="font-14 regular text-white">USDT (BEP-20) Wallet Address</label>
                    <input class="custom-input" type="text" name="trc_address" id="wallet_input"
                        value="{{ $kyc->trc_address ?? '' }}"
                        {{ $require_address_otp ? 'readonly' : '' }}>
                </div>

                @if($require_address_otp)
                <div id="kyc-otp-section">
                    <div class="otp-hint-row" id="kyc-otp-hint-row">
                        <p class="otp-hint-text font-12 text-warning mb-0">
                            You need to verify OTP before you can update your wallet address. OTP will be sent to {{ $masked_phone }}.
                        </p>
                        <div class="otp-hint-actions">
                            <span class="otp-resend-countdown" id="kyc-otp-resend-countdown"></span>
                            <button type="button" class="submit-button btn-otp-compact" id="btn-address-send-otp">Generate OTP</button>
                        </div>
                    </div>

                    <div id="address-otp-panel" class="otp-panel-hidden">
                        <div class="otp-verify-row">
                            <input type="text" class="custom-input otp-input" id="address_otp" placeholder="Enter OTP" maxlength="10" autocomplete="one-time-code">
                            <button type="button" class="submit-button btn-otp-compact flex-shrink-0" id="btn-address-verify-otp">Verify OTP</button>
                        </div>
                        <div class="otp-feedback" id="kyc-otp-feedback"></div>
                        <div class="otp-expiry-line" id="kyc-otp-expiry-line"></div>
                    </div>
                </div>
                @endif

                <button type="submit" class="submit-button w-25 mt-2" id="btn-save-kyc"
                    {{ $require_address_otp ? 'disabled' : '' }}>Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection
@push('css')
<style>
.otp-hint-row { display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; }
.otp-hint-text { flex:1; min-width:200px; line-height:1.45; }
.otp-hint-actions { display:flex; align-items:center; gap:10px; flex-shrink:0; }
.otp-feedback { font-size:12px; line-height:1.45; min-height:18px; margin-top:8px; word-break:break-word; }
.otp-feedback.is-success { color:#4ade80; }
.otp-feedback.is-danger { color:#f87171; }
.otp-feedback.is-info { color:#fbbf24; }
.otp-resend-countdown { font-size:12px; color:#fbbf24; white-space:nowrap; min-width:88px; text-align:right; }
.btn-otp-compact { width:auto !important; padding:6px 14px !important; font-size:13px !important; min-width:108px; }
.btn-otp-compact.is-loading { opacity:0.85; cursor:wait; }
.btn-otp-compact:disabled { opacity:0.55; cursor:not-allowed; }
.otp-panel-hidden { display:none !important; }
.otp-panel-visible { display:block !important; }
.otp-verify-row { display:flex; gap:8px; align-items:center; margin-top:12px; }
.otp-verify-row .otp-input { flex:1; min-width:0; }
.otp-expiry-line { font-size:12px; color:#94a3b8; margin-top:4px; min-height:18px; }
#wallet_input:read-only { opacity:0.85; }
</style>
@endpush
@push('js')
<script src="{{ url('/') }}/public/admin/assets/js/redragon-json.js"></script>
<script src="{{ url('/') }}/public/admin/assets/js/redragon-otp-ui.js"></script>
<script>
(function(){
    var appBase = @json($app_base ?? '');
    var csrf = $('meta[name="csrf-token"]').attr('content');
    var resendSec = {{ (int) ($otp_resend_seconds ?? 120) }};
    var otpExpiryMin = {{ (int) ($otp_expiry_minutes ?? 5) }};
    var requireOtp = {{ $require_address_otp ? 'true' : 'false' }};
    var verified = false;
    var otpSentOnce = false;
    var $feedback = $('#kyc-otp-feedback');
    var $btnSend = $('#btn-address-send-otp');
    var $btnVerify = $('#btn-address-verify-otp');
    var $otpInput = $('#address_otp');
    var $wallet = $('#wallet_input');
    var $submit = $('#btn-save-kyc');
    var UI = window.RedragonOtpUi;
    var OTP_KEY = 'kyc';

    function apiUrl(path){ return (appBase ? appBase : '') + path; }
    function parseDone(data, xhr){ return UI.parseResponse(data, xhr); }

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        xhrFields: { withCredentials: true }
    });

    function lockVerifiedUI(message){
        verified = true;
        var token = $('#address_verification_token').val();
        if(!token){
            verified = false;
            return;
        }
        $('#address-otp-panel').removeClass('otp-panel-hidden').addClass('otp-panel-visible');
        $wallet.prop('readonly', false).removeAttr('readonly');
        $submit.prop('disabled', false).removeAttr('disabled');
        UI.applyVerifiedState({
            key: OTP_KEY,
            $countdown: $('#kyc-otp-resend-countdown'),
            $expiry: $('#kyc-otp-expiry-line'),
            $btnSend: $btnSend,
            $btnVerify: $btnVerify,
            $otpInput: $otpInput,
            $feedback: $feedback,
            message: message || 'OTP verified. You may submit your wallet address now.'
        });
        $('#kyc-otp-hint-row .otp-hint-actions').remove();
    }

    if(!requireOtp){
        verified = true;
        $submit.prop('disabled', false);
        $wallet.prop('readonly', false);
    }

    $('#btn-address-send-otp').on('click', function(){
        if(verified){ return; }
        verified = false;
        $('#address_verification_token').val('');
        $submit.prop('disabled', true).attr('disabled', 'disabled');
        $wallet.prop('readonly', true).attr('readonly', 'readonly');
        UI.clearFeedback($feedback);
        UI.setButtonLoading($btnSend, true, 'Sending...');
        $.ajax({
            url: apiUrl('/address/send-otp'),
            method: 'POST',
            dataType: 'text',
            data: {}
        }).done(function(data, status, xhr){
            var res = parseDone(data, xhr);
            if(!res || !UI.isSuccess(res)){
                UI.setFeedback($feedback, 'danger', UI.messageFromResponse(res, xhr, 'Failed to send OTP.'));
                UI.setButtonIdle($btnSend, otpSentOnce ? 'Resend OTP' : 'Generate OTP', true);
                return;
            }
            otpSentOnce = true;
            $('#address-otp-panel').removeClass('otp-panel-hidden').addClass('otp-panel-visible');
            $otpInput.prop('readonly', false).prop('disabled', false).removeAttr('readonly disabled').val('');
            if(res.sandbox && res.otp){ $otpInput.val(res.otp); }
            var okMsg = res.sandbox
                ? 'OTP sent successfully (sandbox). Enter the code.'
                : 'OTP sent successfully to your WhatsApp.';
            UI.setFeedback($feedback, 'success', okMsg);
            UI.startResendCooldown({
                key: OTP_KEY,
                $btn: $btnSend,
                $countdown: $('#kyc-otp-resend-countdown'),
                seconds: resendSec,
                resendLabel: 'Resend OTP'
            });
            UI.startExpiryCountdown({
                key: OTP_KEY,
                $el: $('#kyc-otp-expiry-line'),
                expiresAtMs: UI.parseExpiresAt(res, otpExpiryMin)
            });
        }).fail(function(xhr){
            var res = parseDone(null, xhr);
            UI.setFeedback($feedback, 'danger', UI.messageFromResponse(res, xhr, 'Failed to send OTP. Please try again.'));
            UI.setButtonIdle($btnSend, otpSentOnce ? 'Resend OTP' : 'Generate OTP', true);
        });
    });

    $('#btn-address-verify-otp').on('click', function(){
        if(verified){ return; }
        var code = $otpInput.val().trim();
        if(!code){
            UI.setFeedback($feedback, 'danger', 'Please enter the OTP.');
            return;
        }
        UI.setButtonLoading($btnVerify, true, 'Verifying...');
        $.ajax({
            url: apiUrl('/address/verify-otp'),
            method: 'POST',
            dataType: 'text',
            data: { otp: code }
        }).done(function(data, status, xhr){
            var res = parseDone(data, xhr);
            if(!res){
                UI.setButtonIdle($btnVerify, 'Verify OTP', true);
                UI.setFeedback($feedback, 'danger', 'Invalid server response. Please try again.');
                return;
            }
            if(UI.isSuccess(res) && res.verification_token){
                $('#address_verification_token').val(res.verification_token);
                lockVerifiedUI('OTP verified. You may submit your wallet address now.');
                return;
            }
            verified = false;
            $('#address_verification_token').val('');
            UI.setButtonIdle($btnVerify, 'Verify OTP', true);
            UI.setFeedback($feedback, 'danger', UI.messageFromResponse(res, xhr, 'Verification failed. Please try again.'));
        }).fail(function(xhr){
            verified = false;
            $('#address_verification_token').val('');
            UI.setButtonIdle($btnVerify, 'Verify OTP', true);
            var res = parseDone(null, xhr);
            UI.setFeedback($feedback, 'danger', UI.messageFromResponse(res, xhr, 'Invalid OTP. Please check and try again.'));
        });
    });

    $('#kyc-form').on('submit', function(e){
        if(!requireOtp){ return; }
        var token = $('#address_verification_token').val();
        if(!verified || !token){
            e.preventDefault();
            UI.setFeedback($feedback, 'danger', 'Please verify OTP before submitting your wallet address.');
            if(!$feedback.text()){
                alert('Please verify OTP before submitting.');
            }
        }
    });
})();
</script>
@endpush
