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
use App\Models\MemberRequest;
use App\Services\Wallet\LapseIncomeService;
use Illuminate\Support\Facades\DB;

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

        $data['total_direct_income'] = (float) DB::table('commision_direct')
            ->where('type', 'credit')
            ->sum('taxable_amount');
        $data['total_level_view']=CommisionTable::where([['type','credit'],['income_type','=','level']])->sum('amount');
        $data['total_magic_income'] = (float) DB::table('commision_majic_pool')
            ->where('status', 'closed')
            ->sum('taxable_profit');
        $data['total_community_income'] = (float) DB::table('commision_community')
            ->where('type', 'credit')
            ->sum('taxable_amount');
        
          $data['total_credit']=CommisionTable::where('type','credit')->sum('amount');
          $data['total_debit']=CommisionTable::where('type','debit')->sum('amount');
          $data['net_flow']=$data['total_credit']- $data['total_debit'];
            $withdrawFromLedger = (float) DB::table('wallet_transactions')
                ->where('wallet_type', 'primary')
                ->where('direction', 'debit')
                ->where('transaction_type', 'withdrawal')
                ->sum('amount');
            $withdrawLegacy = (float) CommisionTable::where([['type', 'debit'], ['request_status', 'approve']])->sum('amount');
            $data['total_withdraw_approved'] = $withdrawFromLedger > 0 ? $withdrawFromLedger : $withdrawLegacy;
            $data['total_topup_wallet_usage'] = (float) DB::table('wallet_transactions')
                ->where('wallet_type', 'secondary')
                ->where('direction', 'debit')
                ->sum('amount');
            $data['pending_withdraw_requests'] = CommisionTable::where([['type', 'debit'], ['request_status', 'processing']])->count();
            $data['total_buy_usdt_requests'] = MemberRequest::count();
            $data['pending_buy_usdt_requests'] = MemberRequest::where('status', 'pending')->count();
            $data['approved_buy_usdt_requests'] = MemberRequest::where('status', 'approve')->count();
            $data['approved_buy_usdt_amount'] = (float) MemberRequest::where('status', 'approve')->sum('request_amount');

            $data['total_lapse_income'] = app(LapseIncomeService::class)->totalLapseIncome();

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
