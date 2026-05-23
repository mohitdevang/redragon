<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpVerification;
use App\Models\WhatsappSetting;
use App\Services\WhatsApp\OtpService;
use App\Support\CountryDial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressOtpController extends Controller
{
    protected function userPhoneE164($user): string
    {
        $dial = CountryDial::digits($user->dial_code);
        $phone = preg_replace('/\D+/', '', (string) $user->phone);

        return '+'.$dial.$phone;
    }

    public function sendOtp(Request $request, OtpService $otpService)
    {
        $user = Auth::guard()->user();
        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $settings = WhatsappSetting::current();
        if (! $settings->require_otp_address_update) {
            session(['address_otp_verified' => true, 'address_otp_verified_at' => now()->timestamp]);

            return response()->json(['success' => true, 'message' => 'OTP not required.', 'skipped' => true]);
        }

        session()->forget(['address_otp_verified', 'address_otp_verified_at', 'address_verification_token']);

        $phoneE164 = $this->userPhoneE164($user);

        $result = $otpService->send(
            OtpVerification::PURPOSE_ADDRESS_UPDATE,
            $phoneE164,
            $user->country_id,
            $user->unique_id,
            $request->ip()
        );

        return response()->json($result, ($result['success'] ?? false) ? 200 : 422);
    }

    public function verifyOtp(Request $request, OtpService $otpService)
    {
        $user = Auth::guard()->user();
        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $request->validate(['otp' => 'required|string|min:4|max:10']);

        $phoneE164 = $this->userPhoneE164($user);

        $result = $otpService->verify(
            OtpVerification::PURPOSE_ADDRESS_UPDATE,
            $phoneE164,
            $request->otp,
            $request->ip()
        );

        if (! ($result['success'] ?? false)) {
            return response()->json($result, 422);
        }

        session([
            'address_otp_verified' => true,
            'address_otp_verified_at' => now()->timestamp,
            'address_verification_token' => $result['verification_token'],
        ]);

        return response()->json($result);
    }
}
