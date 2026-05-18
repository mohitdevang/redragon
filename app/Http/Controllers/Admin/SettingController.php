<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\SiteSettingRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Setting;
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

            //dd($request->logo->store('uploads','public'));

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

            //dd($request->logo->store('uploads','public'));

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

        if($setting == null){
            $result = Setting::create($input);
        } else {
            $result = $setting->update($input);
        }
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
