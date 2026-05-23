<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\OtpVerification;
use App\Services\WhatsApp\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrationOtpController extends Controller
{
    public function sendOtp(Request $request, OtpService $otpService)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'phone' => 'required|string|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $country = Country::find($request->country_id);
        $phoneE164 = $otpService->buildE164($country, $request->phone);

        $exists = \App\Models\User::where('phone', preg_replace('/\D+/', '', $request->phone))
            ->orWhere(function ($q) use ($phoneE164) {
                $q->whereRaw("CONCAT(IFNULL(dial_code,''), phone) = ?", [ltrim($phoneE164, '+')]);
            })
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'This mobile number is already registered.'], 422);
        }

        $result = $otpService->send(
            OtpVerification::PURPOSE_REGISTRATION,
            $phoneE164,
            (int) $country->id,
            null,
            $request->ip()
        );

        return response()->json($result, ($result['success'] ?? false) ? 200 : 422);
    }

    public function verifyOtp(Request $request, OtpService $otpService)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'phone' => 'required|string|min:6|max:20',
            'otp' => 'required|string|min:4|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $country = Country::find($request->country_id);
        $phoneE164 = $otpService->buildE164($country, $request->phone);

        $result = $otpService->verify(
            OtpVerification::PURPOSE_REGISTRATION,
            $phoneE164,
            $request->otp,
            $request->ip()
        );

        if (! ($result['success'] ?? false)) {
            return response()->json($result, 422);
        }

        session([
            'registration_otp_verified' => true,
            'registration_phone_e164' => $phoneE164,
            'registration_verification_token' => $result['verification_token'],
            'registration_country_id' => $country->id,
        ]);

        return response()->json($result);
    }
}
