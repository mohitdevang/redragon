<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\SiteSettingRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\IncomeEngine;
use App\Support\PackagePurchaseEngine;
use Session;
use File;

class SettingController extends Controller
{
  
    public function __construct()
    {
      // $this->middleware('auth:admin');
    }

    
    public function update(Request $request) {
        if ($request->isMethod('PATCH')) {
        $input = $request->all();
        $input['income_engine_enabled'] = $request->boolean('income_engine_enabled');
        if (\Illuminate\Support\Facades\Schema::hasColumn('settings', 'package_purchase_engine_enabled')) {
            $input['package_purchase_engine_enabled'] = $request->boolean('package_purchase_engine_enabled');
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('settings', 'login_modal_enabled')) {
            $input['login_modal_enabled'] = $request->boolean('login_modal_enabled');
        }
        $setting = Setting::firstOrFail();


        if($request->hasFile('logo'))
        {
            $destinationPath = 'uploads';
            $file = $request->file('logo');
            $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename=time().rand(100,999).$original_name.'.'.$extension;
            
            $file->move(
                config('services.new_root_path').$destinationPath, $filename
            );

            $input['logo'] = $filename;

            if ($setting->logo) {
                
                 File::delete(config('services.new_root_path').'uploads/'.$setting->logo);
                 
            }


        }
        
        
        if($request->hasFile('scanner'))
          {
            $destinationPath = 'uploads';
            $file = $request->file('scanner');
            $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename=time().rand(100,999).$original_name.'.'.$extension;
            
            $file->move(
                config('services.new_root_path').$destinationPath, $filename
            );

            $input['scanner'] = $filename;

            if ($setting->scanner) {
                
                 File::delete(config('services.new_root_path').'uploads/'.$setting->scanner);
                 
            }


        }
        
        

        if($request->hasFile('favicon'))
        {
            $destinationPath = 'uploads';
            $file = $request->file('favicon');
            $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename=time().rand(100,999).$original_name.'.'.$extension;
            
            $file->move(
                config('services.new_root_path').$destinationPath, $filename
            );

            $input['favicon'] = $filename;

            if ($setting->favicon) {
                    File::delete(config('services.new_root_path').'uploads/'.$setting->favicon);
                }


        }

        if($request->hasFile('loginbg'))
        {
            $destinationPath = 'uploads';
            $file = $request->file('loginbg');
            $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename=time().rand(100,999).$original_name.'.'.$extension;
            
            $file->move(
                config('services.new_root_path').$destinationPath, $filename
            );

            $input['loginbg'] = $filename;

            if ($setting->loginbg) {
                    File::delete(config('services.new_root_path').'uploads/'.$setting->loginbg);
                }
        }

        if ($request->hasFile('login_modal_image') && \Illuminate\Support\Facades\Schema::hasColumn('settings', 'login_modal_image')) {
            $destinationPath = 'uploads';
            $file = $request->file('login_modal_image');
            $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = time().rand(100, 999).$original_name.'.'.$extension;
            $file->move(config('services.new_root_path').$destinationPath, $filename);
            $input['login_modal_image'] = $filename;
            if ($setting->login_modal_image) {
                File::delete(config('services.new_root_path').'uploads/'.$setting->login_modal_image);
            }
        }

        if($setting == null){
            $result = Setting::create($input);
        } else {
            $result = $setting->update($input);
        }
        IncomeEngine::flushCache();
        PackagePurchaseEngine::flushCache();

        if($result){
           Session::flash('success', 'Site settings updated successfully'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }
        return redirect()->route('admin.site.setting');
    } else {

        $setting = Setting::firstOrFail();
        return view('admin.settings.edit',compact('setting'));
    }
        
    }


    

}
