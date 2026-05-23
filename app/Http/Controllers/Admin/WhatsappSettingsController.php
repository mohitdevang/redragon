<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsappLog;
use App\Models\WhatsappSetting;
use App\Services\WhatsApp\MetaCloudClient;
use Illuminate\Http\Request;
use Session;

class WhatsappSettingsController extends Controller
{
    public function edit()
    {
        $setting = WhatsappSetting::current();

        return view('admin.settings.whatsapp', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = WhatsappSetting::current();

        $data = $request->validate([
            'enabled' => 'nullable|boolean',
            'mode' => 'required|in:sandbox,live',
            'graph_api_version' => 'required|string|max:20',
            'phone_number_id' => 'nullable|string|max:100',
            'access_token' => 'nullable|string',
            'business_account_id' => 'nullable|string|max:100',
            'webhook_verify_token' => 'nullable|string|max:255',
            'otp_template_name' => 'nullable|string|max:120',
            'otp_template_language' => 'required|string|max:20',
            'otp_template_body_variables' => 'required|integer|min:0|max:20',
            'sandbox_default_otp' => 'nullable|string|max:10',
            'otp_expiry_minutes' => 'required|integer|min:1|max:60',
            'otp_max_attempts' => 'required|integer|min:1|max:10',
            'otp_resend_cooldown_seconds' => 'required|integer|min:30|max:600',
            'require_otp_address_update' => 'nullable|boolean',
            'welcome_template_name' => 'nullable|string|max:120',
            'welcome_template_language' => 'nullable|string|max:20',
            'welcome_template_body_variables' => 'nullable|integer|min:1|max:50',
            'welcome_enabled' => 'nullable|boolean',
        ]);

        $data['enabled'] = $request->boolean('enabled');
        $data['require_otp_address_update'] = $request->boolean('require_otp_address_update');
        $data['welcome_enabled'] = $request->boolean('welcome_enabled');

        if ($request->filled('access_token')) {
            $data['access_token'] = $request->access_token;
        } else {
            unset($data['access_token']);
        }

        $setting->update($data);

        Session::flash('success', 'WhatsApp settings updated successfully.');

        return redirect()->route('admin.whatsapp.settings');
    }

    public function testConnection(Request $request)
    {
        $setting = WhatsappSetting::current();
        if ($request->filled('access_token')) {
            $setting->access_token = $request->access_token;
        }
        if ($request->filled('phone_number_id')) {
            $setting->phone_number_id = $request->phone_number_id;
        }
        if ($request->filled('graph_api_version')) {
            $setting->graph_api_version = $request->graph_api_version;
        }

        $client = new MetaCloudClient($setting);
        $result = $client->testConnection();

        return response()->json($result);
    }

    public function logs()
    {
        $logs = WhatsappLog::query()->orderByDesc('id')->get();

        return view('admin.whatsapp.logs', compact('logs'));
    }
}
