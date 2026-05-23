/**
 * Shared OTP UI helpers.
 */
window.RedragonOtpUi = (function () {
    var resendTimers = {};
    var expiryTimers = {};

    function parseExpiresAt(res, fallbackMinutes) {
        if (res && res.expires_at) {
            var t = new Date(res.expires_at).getTime();
            if (!isNaN(t)) {
                return t;
            }
        }
        var mins = parseInt(fallbackMinutes, 10) || 5;
        return Date.now() + mins * 60 * 1000;
    }

    return {
        parseExpiresAt: parseExpiresAt,

        /** Parse AJAX body — fixes dataType:text returning a string in .done() */
        parseResponse: function (data, xhr) {
            if (data && typeof data === 'object') {
                return data;
            }
            if (typeof data === 'string' && data.length) {
                var fromStr = window.RedragonJson ? RedragonJson.parse(data) : null;
                if (fromStr) {
                    return fromStr;
                }
            }
            if (xhr) {
                return window.RedragonJson ? RedragonJson.parse(xhr) : null;
            }
            return null;
        },

        isSuccess: function (res) {
            if (!res || typeof res !== 'object') {
                return false;
            }
            if (res.success === true || res.success === 1) {
                return true;
            }
            if (res.success === 'true' || res.success === '1') {
                return true;
            }
            return false;
        },

        messageFromResponse: function (res, xhr, fallback) {
            if (res && res.message) {
                return res.message;
            }
            var parsed = xhr && window.RedragonJson ? RedragonJson.parse(xhr) : null;
            if (parsed && parsed.message) {
                return parsed.message;
            }
            return fallback || 'Something went wrong. Please try again.';
        },

        setFeedback: function ($el, type, text) {
            if (!$el || !$el.length) {
                return;
            }
            $el.removeClass('is-success is-danger is-info is-muted')
                .addClass(type ? 'is-' + type : 'is-muted')
                .text(text || '')
                .show();
        },

        clearFeedback: function ($el) {
            if ($el && $el.length) {
                $el.text('').removeClass('is-success is-danger is-info is-muted').hide();
            }
        },

        setButtonLoading: function ($btn, loading, loadingText) {
            if (!$btn || !$btn.length) {
                return;
            }
            if (!$btn.data('label-default')) {
                $btn.data('label-default', $btn.text().trim());
            }
            if (loading) {
                $btn.prop('disabled', true).attr('disabled', 'disabled').addClass('is-loading').text(loadingText || 'Sending...');
            }
        },

        setButtonIdle: function ($btn, label, enabled) {
            if (!$btn || !$btn.length) {
                return;
            }
            $btn.removeClass('is-loading').text(label || $btn.data('label-default') || 'Submit');
            if (enabled) {
                $btn.prop('disabled', false).removeAttr('disabled');
            } else {
                $btn.prop('disabled', true).attr('disabled', 'disabled');
            }
        },

        stopResendCooldown: function (key) {
            if (resendTimers[key]) {
                clearInterval(resendTimers[key]);
                delete resendTimers[key];
            }
        },

        stopExpiryCountdown: function (key) {
            if (expiryTimers[key]) {
                clearInterval(expiryTimers[key]);
                delete expiryTimers[key];
            }
        },

        startResendCooldown: function (opts) {
            var key = opts.key || 'default';
            var $btn = opts.$btn;
            var $countdown = opts.$countdown;
            var seconds = parseInt(opts.seconds, 10) || 120;
            var resendLabel = opts.resendLabel || 'Resend OTP';
            var remaining = seconds;

            this.stopResendCooldown(key);
            $btn.prop('disabled', true).attr('disabled', 'disabled');
            if (!$btn.data('label-default')) {
                $btn.data('label-default', resendLabel);
            }
            $btn.text(resendLabel);
            $countdown.text('Resend in ' + remaining + 's').show();

            resendTimers[key] = setInterval(function () {
                remaining--;
                if (remaining > 0) {
                    $countdown.text('Resend in ' + remaining + 's');
                    $btn.prop('disabled', true).attr('disabled', 'disabled');
                } else {
                    RedragonOtpUi.stopResendCooldown(key);
                    $countdown.text('');
                    $btn.prop('disabled', false).removeAttr('disabled').text(resendLabel);
                    if (typeof opts.onComplete === 'function') {
                        opts.onComplete();
                    }
                }
            }, 1000);
        },

        startExpiryCountdown: function (opts) {
            var key = opts.key || 'default';
            var $el = opts.$el;
            var expiresAt = opts.expiresAtMs;
            var prefix = opts.prefix || 'OTP expires in ';

            this.stopExpiryCountdown(key);

            function tick() {
                var diff = Math.max(0, Math.floor((expiresAt - Date.now()) / 1000));
                if (diff <= 0) {
                    $el.text('OTP expired. Please request a new code.');
                    RedragonOtpUi.stopExpiryCountdown(key);
                    return;
                }
                var m = Math.floor(diff / 60);
                var s = diff % 60;
                $el.text(prefix + (m > 0 ? m + 'm ' : '') + s + 's').show();
            }

            tick();
            expiryTimers[key] = setInterval(tick, 1000);
        },

        /**
         * After successful verification: remove buttons/timers, lock input, show message below input.
         */
        applyVerifiedState: function (opts) {
            var key = opts.key || 'default';
            this.stopResendCooldown(key);
            this.stopExpiryCountdown(key);

            if (opts.$countdown && opts.$countdown.length) {
                opts.$countdown.remove();
            }
            if (opts.$expiry && opts.$expiry.length) {
                opts.$expiry.remove();
            }
            if (opts.$btnSend && opts.$btnSend.length) {
                opts.$btnSend.remove();
            }
            if (opts.$btnVerify && opts.$btnVerify.length) {
                opts.$btnVerify.remove();
            }
            if (opts.$otpInput && opts.$otpInput.length) {
                opts.$otpInput.prop('readonly', true).prop('disabled', true).attr('disabled', 'disabled');
            }
            if (opts.$feedback) {
                this.setFeedback(opts.$feedback, 'success', opts.message || 'OTP verified successfully.');
            }
        }
    };
})();
