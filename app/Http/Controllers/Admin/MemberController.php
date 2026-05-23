<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Post;
use App\Models\User;
use App\Models\PostMeta;
use App\Models\PostMetaElement;
use App\Models\Menu;
use Session;
use File;

use App\Models\UserParent;
use App\Models\MemberPin;
use App\Models\CommisionPlan;
use App\Models\MemberRequest;
use App\Models\UpgradeRequest;
use App\Models\CommisionTable;
use App\Models\RewardPlan;
use App\Models\NotificationText;
use App\Models\BankDetail;
use App\Models\Video;

class MemberController extends Controller
{
  
    public function __construct()
    {
       //$this->middleware('auth:admin');
    }
 
    public function index() {

        $data['member']=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->get();
        return view('admin.members.index',$data);
        
    }

    public function member_kyc(){
        $data['member'] = User::query()
            ->select('id', 'name', 'unique_id', 'registration_serial', 'trc_address')
            ->orderByDesc('registration_serial')
            ->orderByDesc('id')
            ->get();

        return view('admin.members.member_kyc',$data);
    }

    public function notification(){
$data['noti']=NotificationText::first();
 return view('admin.notification.create',$data);
    }

    public function notification_set(Request $request){
   $result = NotificationText::where('id',$request->hid)->update(array('text'=>$request->text));
           if($result)
      {
        Session::flash('success', 'Notification Updated successfully');
        } 
         
  return redirect()->route('admin.notification');
    }



     public function bank_details(){
$data['bank']=BankDetail::first();
 return view('admin.bank_details.create',$data);
    }

    public function bank_details_set(Request $request){
      $data=array(
        'ac_holder_name'=>$request->ac_holder_name,
        'bank_name'=>$request->bank_name,
        'ac_number'=>$request->ac_number,
        'ifsc'=>$request->ifsc,
        'paytm'=>$request->paytm,
        'googlepay'=>$request->googlepay,
        'phonepay'=>$request->phonepay,
      );
   $result = BankDetail::where('id',$request->hid)->update($data);
           if($result)
      {
        Session::flash('success', 'Bank details Updated successfully');
        } 
         
  return redirect()->route('admin.bank_details');
    }




    public function generate_commission(){
    
        
        return view('admin.generate_commission.create');
    }
      public function generate_rewards(){
         $data['plan']=CommisionPlan::where('id','!=','1')->get();
        return view('admin.generate_reward.create',$data);
    }

     public function generatepin(){
        $data['member']=User::get();
        return view('admin.generatepin.create',$data);
    }

  //video management section

    public function view_video(){
        $data['video']=Video::get();
        return view('admin.generate_video.index',$data);
    }

     public function videocreateview(){
   
        return view('admin.generate_video.create');
    }

    public function generate_video(Request $request){
       
      
            $data=array(
                'type'=>$request->type,
                 'file'=>$request->file,
                  'link'=>$request->link,
                   'download_link'=>$request->download_link,
                   'download_text'=>$request->download_text,
                    'created_date'=>$request->created_date,

            );


             if($request->hasFile('file'))
        {
            $destinationPath = 'uploads';
            $file = $request->file('file');
            $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename=time().rand(100,999).$original_name.'.'.$extension;
            
            $file->move(
                config('services.new_root_path').$destinationPath, $filename
            );

            $data['file'] = $filename;

            
        }





           $result = Video::create($data);
           if($result)
      {
        Session::flash('success', 'Plan created successfully');
        } 
         
       return redirect()->route('admin.ads.view');


   
    }
    public function video_edit($planid){

        $data['video']=Video::where('id',$planid)->first();
        return view('admin.generate_video.edit',$data);
    }

    public function video_update(Request $request,$planid){
        $page = Video::findOrFail($planid);
            $data=array(
                'type'=>$request->type,                
                  'link'=>$request->link,
                   'download_link'=>$request->download_link,
                   'download_text'=>$request->download_text,
                    'created_date'=>$request->created_date,

            );


             if($request->hasFile('file'))
        {
            $destinationPath = 'uploads';
            $file = $request->file('file');
            $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename=time().rand(100,999).$original_name.'.'.$extension;

            if ($page->file) {
                    File::delete(config('services.new_root_path').'uploads/'.$page->file);
                    
                }
            
            $file->move(
                config('services.new_root_path').$destinationPath, $filename
            );

            $data['file'] = $filename;

            
        }
           $result = Video::where('id','=',$planid)->update($data);
           if($result)
      {
        Session::flash('success', 'Plan created successfully');
        } 
         
       return redirect()->route('admin.ads.view');


    }

     public function multiple_ads_delete(Request $request) {

       
        $items = $request->only('item');

        foreach ($items['item'] as $ite) {
             $page = Video::findOrFail($ite);
  if ($page->file) {
                    File::delete(config('services.new_root_path').'uploads/'.$page->file);
                    
                }
        }

        $result = Video::destroy($items['item']);
      
        if($result){
           Session::flash('success', count($items['item']).' Ads(s) deleted successfully'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }
       return redirect()->route('admin.ads.view');


    }

/*** video end*//////
   

      public function view_pin(){
        $data['pin']=MemberPin::get();
        return view('admin.generatepin.index',$data);
    }

      public function view_plan(){
        $data['plan']=CommisionPlan::get();
        return view('admin.generate_commission.index',$data);
    }


      public function view_rewardplan(){
        $data['plan']=RewardPlan::join('commision_plans', 'commision_plans.id', '=', 'reward_plans.plan_id')->get();
        return view('admin.generate_reward.index',$data);
    }

      public function plan_edit($planid){

        $data['plan']=CommisionPlan::where('id',$planid)->first();
        return view('admin.generate_commission.edit',$data);
    }

     public function member_edit($memberid){

        $data['member']=User::where('id',$memberid)->first();
        return view('admin.members.edit',$data);
    }


       public function rewardplan_edit($planid){
         $data['plan']=CommisionPlan::where('id','!=','1')->get();
        $data['selected_plan']=RewardPlan::where('rewards_id',$planid)->first();
        return view('admin.generate_reward.edit',$data);
    }


    

     public function pin_store(Request $request){
        for ($i=0; $i <$request->number_of_pin ; $i++) { 
            $data=array(
                'member_id'=>$request->member_id,
                'pin'=>$this->unique_id(),

            );
           MemberPin::create($data);
        }
        Session::flash('success', 'Pin created successfully'); 
         $data['member']=User::get();
        return view('admin.generatepin.create',$data);


    }
     public function plan_store(Request $request){
      
            $data=array(
                'plan_name'=>$request->plan_name,
                 'direct'=>$request->direct,
                  'member'=>$request->member,
                   'commision'=>$request->commision,
                   'day'=>$request->day,

            );
           CommisionPlan::create($data);
      
        Session::flash('success', 'Plan created successfully'); 
         
        return redirect()->route('admin.view.plan');



    }


     public function reward_store(Request $request){
      
            $data=array(
                'number_of_direct_member'=>$request->number_of_direct_member,
                 'days_limit'=>$request->days_limit,
                  'amount'=>$request->amount,
                   'plan_id'=>$request->plan_id,

            );
           RewardPlan::create($data);
      
        Session::flash('success', 'Plan created successfully'); 
         
        return redirect()->route('admin.view.rewardplan');



    }

    public function plan_update(Request $request,$planid ){
      
            $data=array(
                'plan_name'=>$request->plan_name,
                 'direct'=>$request->direct,
                  'member'=>$request->member,
                   'commision'=>$request->commision,
                    'day'=>$request->day,

            );
           $result = CommisionPlan::where('id','=',$planid)->update($data);
           if($result)
      {
        Session::flash('success', 'Plan created successfully');
        } 
         
       return redirect()->route('admin.view.plan');


    }

     public function member_update(Request $request,$memberid ){
      
            $data=array(
                'name'=>$request->name,
                 'email'=>$request->email,
                  'secpwd'=>$request->secpwd,
                   'password'=> Hash::make($request->secpwd),
                   'phone'=>$request->phone,
                    

            );
           $result = User::where('id','=',$memberid)->update($data);
           if($result)
      {
        Session::flash('success', 'Member Uodated successfully');
        } 
         
       return redirect()->route('admin.show.member');


    }


     public function rewardplan_update(Request $request,$planid ){
      
          $data=array(
                'number_of_direct_member'=>$request->number_of_direct_member,
                 'days_limit'=>$request->days_limit,
                  'amount'=>$request->amount,
                   'plan_id'=>$request->plan_id,

            );
           $result = RewardPlan::where('rewards_id','=',$planid)->update($data);
           if($result)
      {
        Session::flash('success', 'Plan Updated successfully');
        } 
         
       return redirect()->route('admin.view.rewardplan');


    }

  


  public function unique_id(){
    $digits_needed=4;

$random_number=''; // set up a blank string

$count=0;

while ( $count < 2 ) {
    $random_digit = mt_rand(0, 9);
    
    $random_number .= $random_digit;
    $count++;
}
$random_number .= substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 4)), 0, 4);
while ( $count < 2 ) {
    $random_digit = mt_rand(0, 9);
    
    $random_number .= $random_digit;
    $count++;
}
return $random_number;
}

  

      public function multiple_pin_delete(Request $request) {

        
        $items = $request->only('item');
        $result = MemberPin::destroy($items['item']);
      
        if($result){
           Session::flash('success', count($items['item']).' Page(s) deleted successfully'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }
        return redirect()->route('admin.view.pin');


    }

   

        public function multiple_plan_delete(Request $request) {

        
        $items = $request->only('item');
        $result = CommisionPlan::destroy($items['item']);
      
        if($result){
           Session::flash('success', count($items['item']).' Plan(s) deleted successfully'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }
         return redirect()->route('admin.view.plan');



    }

       public function multiple_rewardplan_delete(Request $request) {

        
        $items = $request->only('item');
        $result = RewardPlan::destroy($items['item']);
      
        if($result){
           Session::flash('success', count($items['item']).' Plan(s) deleted successfully'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }
         return redirect()->route('admin.view.plan');



    }

    


        public function multiple_member_delete(Request $request) {

        
        $items = $request->only('item');
        $result = User::destroy($items['item']);
      
        if($result){
           Session::flash('success', count($items['item']).' Page(s) deleted successfully'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }
        return redirect()->route('admin.show.member');


    }

         public function multiple_member_request_delete(Request $request) {

        
        $items = $request->only('item');
        $result = MemberRequest::destroy($items['item']);
      
        if($result){
           Session::flash('success', count($items['item']).' Request deleted successfully'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }
        return redirect()->route('admin.show.member_request');


    }


     public function multiple_member_upgrade_delete(Request $request) {

        
        $items = $request->only('item');
        $result = UpgradeRequest::destroy($items['item']);
      
        if($result){
           Session::flash('success', count($items['item']).' Request deleted successfully'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }
        return redirect()->route('admin.show.upgrade_request');


    }


         public function multiple_withdraw_request_delete(Request $request) {

        
        $items = $request->only('item');
        $result = CommisionTable::destroy($items['item']);
      
        if($result){
           Session::flash('success', count($items['item']).' withdraw Request deleted successfully'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }
        return redirect()->route('admin.show.withdraw_request');


    }

    

    


public function member_request(Request $request){
   $data['request']=MemberRequest::where('status','pending')->get();
    return view('admin.member_request.index',$data);

}

public function member_request_history(Request $request){
   $data['request']=MemberRequest::get();
    return view('admin.member_request.request_histoey',$data);

}



public function member_upgrade_request(Request $request){
   $data['request']=UpgradeRequest::where('status','pending')->get();
    return view('admin.upgrade_request.index',$data);

}

public function member_upgrade_request_history(Request $request){
   $data['request']=UpgradeRequest::get();
    return view('admin.upgrade_request.request_histoey',$data);

}

public function request_change_status(Request $request){
    if ($request->ajax()) {
       
            $id = $request->id;
             $type=MemberRequest::where('id','=',$id)->first();
             

                  if($request->input('status')=='approve'){
              ///add to wallet
  $fetch_wallet=DB::table('wallet_secondary')->select('user_id','balance')->where('user_id',$type->member_id)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$type->request_amount;
  DB::table('wallet_secondary')->where('user_id',$type->member_id)->update(array('balance'=>$new_balance));
  }else{
        DB::table('wallet_secondary')->insert(array('balance'=>$type->request_amount,'user_id'=>$type->member_id));
  }
 
      }
           
            $result2 = MemberRequest::where('id','=',$id)->update(['status' => $request->input('status')]);
            if($result2) {
                return response()->json(['status' => true, 'success' => 'Request status  updated successfully']);
                } else {
                return response()->json(['status' => false, 'danger' => 'Error encounterd']);
            }
        } 
}




public function upgradet_change_status(Request $request){
    if ($request->ajax()) {
            $id = $request->id;

                  if($request->input('status')=='approve'){


                    User::where('unique_id',$request->member_id)->update(['upgrade' => $request->input('upgrade_id')]);


                    
                     DB::table('user_upgrade_relation')->insert(array('user_id'=>$request->member_id,'upgrade_id'=>$request->input('upgrade_id')));

      }
           
            $result2 = UpgradeRequest::where('id','=',$id)->update(['status' => $request->input('status')]);
            if($result2) {
                return response()->json(['status' => true, 'success' => 'Request status  updated successfully']);
                } else {
                return response()->json(['status' => false, 'danger' => 'Error encounterd']);
            }
        } 
}

public function show_withdraw_request(){
  $data['request']=CommisionTable::join('users', 'users.unique_id', '=', 'commision_tables.member_id')->where([['request_status','processing'],['type','debit']])->select('users.*','commision_tables.*','commision_tables.updated_at as comdate','commision_tables.id as comid')->get();
    return view('admin.withdraw_request.index',$data);
}


public function show_withdraw_request_bydate(Request $request){

    $from_date= date('Y-m-d',strtotime($request->from_date));
$to_date=  date('Y-m-d',strtotime($request->to_date));

 $data['from_date']= $from_date;
$data['to_date']= $to_date;

  $data['request']=CommisionTable::join('users', 'users.unique_id', '=', 'commision_tables.member_id')->where([['request_status','processing'],['type','debit'],['commision_tables.created_at','<=',$to_date],['commision_tables.created_at','>=',$from_date]])->select('users.*','commision_tables.*','commision_tables.updated_at as comdate','commision_tables.id as comid')->get();
    return view('admin.withdraw_request.index',$data);
}

public function request_change_withrraw_status(Request $request){
     if ($request->ajax()) {
            $id = $request->id;

            if($request->status=='approve'){
                $commision=CommisionTable::where('id',$id)->first();
                $user=User::where('unique_id',$commision->member_id)->first();
                 


$beneficiary_account_no=$user->ac_number;
$beneficiary_mobile_no=$user->phone;
$beneficiary_ifsc=$user->ifsc;
$beneficiary_name=$e_type = str_replace(' ', '%20', $user->ac_holder_name);
$amount=round($commision->net_payment);
$purpose='OTHERS';

$remarks='withdraw from realdealsmarketing Total Rs.'.$commision->amount.' and net payment Rs.'.$commision->net_payment ;

$mobileno=$user->phone;

$myorderid= $user->unique_id;



//$url='https://zozowallet.com/api/payout/transfer?api_token=OntLAuAwcspa2yvR5ZZCTECnyMgdqVscm5Sqf8l6c687ksDc0Im47QuzguWO&beneficiary_name='.$beneficiary_name.'&account_number='.$beneficiary_account_no.'&ifsc='.$beneficiary_ifsc.'&mobile_number='.$beneficiary_mobile_no.'&amount='.$amount.'&client_id='.$myorderid.'';



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
  ),
));

$result = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
  
echo $result;

if($result){

$jsondata = json_decode($result, true);
$rcstatus = $jsondata['status'];




if($rcstatus=='success'){

$data=array(
'user_id'=>$commision->member_id,
'txid'=>$jsondata['orderid'],
'amount'=>$amount,
'commission_table_id'=>$commision->id,
'status'=>$jsondata['status'],
);

 $fetch_wallet=DB::table('wallet_primary')->select('user_id','balance')->where('user_id',$commision->member_id)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance-$commision->amount;
  DB::table('wallet_primary')->where('user_id',$commision->member_id)->update(array('balance'=>$new_balance));
  }


 $result2 = CommisionTable::where('id','=',$id)->update(array('request_status' => $request->input('status')));
DB::table('imps_withdrawl')->insert($data);

}else{
    $data=array(
'user_id'=>$commision->member_id,
//'txid'=>$jsondata['orderid'],
'amount'=>$amount,
'commission_table_id'=>$commision->id,
'status'=>$jsondata['status'],
);



DB::table('imps_withdrawl')->insert($data);

 
}


}else{
    
    return response()->json(['status' => false, 'danger' => 'Something went wrong']);
}
}else{
     $result2 = CommisionTable::where('id','=',$id)->update(array('request_status' => $request->input('status')));
}
          
           
           
            if($result2) {
                return response()->json(['status' => true, 'success' => 'Withdraw Request status  updated successfully']);
                } else {
                return response()->json(['status' => false, 'danger' => 'Error encounterd']);
            }
        } 
}



  public function postCurlData($fields,$url){
  
  $ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($ch, CURLOPT_HTTPHEADER, 0);
$file_contents = curl_exec ($ch); // execute
$err = curl_error($ch);
curl_close($ch);
    return $file_contents;

  }



public function withdraw_request_history(){
   $data['request']=CommisionTable::join('users', 'users.unique_id', '=', 'commision_tables.member_id')->where('type','debit')->select('users.*','commision_tables.*','commision_tables.updated_at as comdate','commision_tables.id as comid')->get();
    return view('admin.withdraw_request.history',$data);

}

public function direct_commission_report(){
 $data['user']=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where('status','!=','inactive')->get();
 return view('admin.commission.direct_commission',$data);
}

public function direct_commission_report_datewise(Request $request){
$data['from_date']=date('Y-m-d',strtotime($request->from_date));
$data['to_date']=  date('Y-m-d',strtotime($request->to_date));


 $data['user']=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where('status','!=','inactive')->get();
 return view('admin.commission.direct_commission',$data);
}



public function level_commission_report(){
 $data['user']=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where('status','!=','inactive')->get();
 return view('admin.commission.level_commission',$data);
}


public function level_commission_report_bydate(Request $request){
  $data['from_date']=date('Y-m-d',strtotime($request->from_date));
$data['to_date']=  date('Y-m-d',strtotime($request->to_date));

 $data['user']=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where('status','!=','inactive')->get();
 return view('admin.commission.level_commission',$data);
}



public function reward_report(){
  $data['user']=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where('status','!=','inactive')->get();
 return view('admin.commission.reward',$data);
}
public function level_history($userid){
  $data['total_video_earning']=CommisionTable::where([['member_id',Auth::guard()->user()->unique_id],['type','credit'],['plan','!=','16']])->get();

 return view('admin.commission.level_commission_history',$data);
}

  
 public function update_bstatus(Request $request) {

       if ($request->ajax()) {
            $id = $request->id;
           
            $result2 = User::where('id', $id)->update(['bstatus' => $request->status]);
            if($result2) {
                return response()->json(['status' => true, 'success' => 'status information updated successfully']);
                } else {
                return response()->json(['status' => false, 'danger' => 'Error encounterd']);
            }
        }       
    } 

}
