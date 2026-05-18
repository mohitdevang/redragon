<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminProfileRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Post;
use App\Models\PostCategoryRelationship;
use App\Models\PostMeta;
use App\Models\ContactForm;
use App\Models\AppoinmentRequest;
use Session;
use File;
use App\Models\User;
use App\Models\CommisionTable;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:admin');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['totaluser']=User::count();

        $data['active_direct_user']=User::where('status','!=','inactive')->count();

        $data['total_level_view']=CommisionTable::where([['type','credit'],['income_type','=','level']])->sum('amount');
        
         $data['total_self_view']=CommisionTable::where([['type','credit'],['income_type','=','video']])->sum('amount');
         
         $data['total_onetime_view']=CommisionTable::where([['type','credit'],['income_type','=','onetime']])->sum('amount');
         
         $data['total_reward']=CommisionTable::where([['type','credit'],['rank','=','reward']])->sum('amount');
         
         
          $data['total_credit']=CommisionTable::where('type','credit')->sum('amount');
          
           $data['total_debit']=CommisionTable::where('type','debit')->sum('amount');
           
            $data['total_balance']=$data['total_credit']- $data['total_debit'];

       
   

        return view('admin.dashboard',$data);
    }

    public function profile(AdminProfileRequest $request)
    {
        if ($request->isMethod('PATCH')) {
            $input = $request->all();
            $profile = Admin::where('id',Auth::guard('admin')->user()->id)->firstOrFail();
                /*if($request->hasFile('image'))
                {
                    $destinationPath = 'uploads';
                    $file = $request->file('image');
                    $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $filename=time().rand(100,999).$original_name.'.'.$extension;
                    
                    $file->move(
                        config('services.new_root_path').$destinationPath, $filename
                    );

                    $input['image'] = $filename;

                    if ($profile->image) {
                            
                            File::delete(config('services.new_root_path').'uploads/'.$profile->image);
                        }
                }*/
            $result = $profile->update($input);
        
            if($result){
               Session::flash('success', 'Admin profile updated successfully'); 
            } else {
               Session::flash('danger', 'Error encounterd');
            }
               return redirect()->route('admin.profile');
            } else {
            $profile = Admin::where('id',Auth::guard('admin')->user()->id)->firstOrFail();
           
            return view('admin.profile.edit',compact('profile'));
        }
        
    }

    public function change_password(AdminProfileRequest $request)
    {
       if ($request->isMethod('PATCH')) {
            $user = Admin::where('id',Auth::guard('admin')->user()->id)->firstOrFail();
            $check = Hash::check($request->old_password, $user->password);
            if($check){
                $user->password = Hash::make($request->input('password'));
                $result = $user->update();
                if($result){
                   Session::flash('success', 'Admin password updated Successfully'); 
                } else {
                   Session::flash('danger', 'Error Encounterd');
                }
             } else{
                Session::flash('warning', 'Your current password is not mathching'); 
             }
             return redirect()->route('admin.change_password');
        }else {
            $user = Admin::where('id',Auth::guard('admin')->user()->id)->firstOrFail();
            return view('admin.profile.edit',compact('user'));
        }
        
    }
}
