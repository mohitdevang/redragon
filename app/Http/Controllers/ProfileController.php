<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactFromRequest;
use App\Http\Requests\AppoinmentFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\UserParent;
use App\Models\MemberPin;
use Session;
use App\Models\CommisionPlan;
use App\Models\AutopullPlan;

use App\Models\CommisionTable;
use App\Models\MemberRequest;
use App\Models\UpgradeRequest;

use App\Models\RewardPlan;
use App\Models\Setting;
use App\Models\UserTree;
use App\Models\UserCompleted;

use App\Models\Award;
use App\Models\Upgrade;
use Illuminate\Support\Facades\Log;


use App\Models\NotificationText;
use App\Models\BankDetail;
use App\Models\UserAd;
use DateTime;
use PHPMailer\PHPMailer;
use Carbon\Carbon;
use App\Support\IncomeEngine;
use App\Support\PackagePurchaseEngine;
use App\Services\CommunitySerialMembers;
use App\Models\WhatsappSetting;
use App\Services\WhatsApp\OtpService;
class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->setting = Setting::firstOrFail();

   // $this->middleware('auth:web');



    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
    {

     

     $id=Auth::guard()->user()->unique_id;
     
 
    $data['status']=User::where('unique_id',$id)->first();
    $data['id']=$id;



 $data['community_income']=DB::table('commision_community')->where([['member_id',$id],['type','credit']])->sum('taxable_amount');

    $data['pool_income']=DB::table('commision_majic_pool')->where('user_id',$id)->sum('taxable_profit');

    $data['direct_income']=DB::table('commision_direct')->where([['member_id',$id],['type','credit'],['plan','37']])->sum('taxable_amount');
    
    $data['level_income']=DB::table('commision_level')->where([['member_id',$id],['type','credit']])->sum('taxable_amount');

    $data['total_balance']=$data['community_income']+
$data['pool_income']+
$data['direct_income']+
$data['level_income'];

$avl_balance=DB::table('wallet_primary')->where('user_id',$id)->first();
if($avl_balance){
    $data['available_balance']=$avl_balance->balance;
}else{
     $data['available_balance']=0;
}


 $data['pool_income_actual']=DB::table('commision_majic_pool')->where('user_id',$id)->sum('profit_level');
 
$Topup_balance=DB::table('wallet_secondary')->where('user_id',$id)->first();
if($Topup_balance){
    $data['Topup_balance']=$Topup_balance->balance;
}else{
     $data['Topup_balance']=0;
}


$Community_balance=DB::table('wallet_community')->where('user_id',$id)->first();
if($Community_balance){
    $data['Community_balance']=$Community_balance->balance;
}else{
     $data['Community_balance']=0;
}



 $data['active_direct_user']=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['parent_id',$id],['status','!=','inactive']])->count();

      $data['direct_partner_count'] = UserParent::query()->where('parent_id', $id)->count();

      $myParentRow = UserParent::query()->where('user_id', $id)->first();
      if ($myParentRow) {
          $teamQuery = UserParent::query()
              ->join('users', 'users.unique_id', '=', 'user_parents.user_id')
              ->where('user_parents.id', '>', $myParentRow->id);
          $data['total_team_partner'] = (clone $teamQuery)->count();
          $data['active_team_partner'] = (clone $teamQuery)->where('users.status', 'active')->count();
      } else {
          $data['total_team_partner'] = 0;
          $data['active_team_partner'] = 0;
      }

      $data['active_downline_user']=array_sum($this->display_children(Auth::guard()->user()->unique_id,0));


      return view('page_templates.dashboard',$data); 
        
    }
     public function credentials(){
      
     return view('page_templates.credentials');
 }

public function video_report()
{
      
       $data['direct_income']=DB::table('commision_direct')->where([['member_id',Auth::guard()->user()->unique_id],['type','credit'],['plan',37]])->orderby('id','desc')->paginate(10);
       
      return view('page_templates.level_video_report',$data); 
}
public function level_video_report()
{
     
       $data['level_ad_view_income']=DB::table('commision_level')->where([['member_id',Auth::guard()->user()->unique_id],['type','credit']])->orderby('created_date','desc')->paginate(10);
       return view('page_templates.level_video_report',$data); 
}

public function community_income_upline()
{
     
       $data['community_income_upline']=DB::table('commision_community')->where([['member_id',Auth::guard()->user()->unique_id],['type','credit'],['rank','community-upline']])->orderby('created_date','desc')->paginate(10);
       return view('page_templates.level_video_report',$data); 
}

public function community_commosion_report_downline()
{
     
       $data['community_income_downline']=DB::table('commision_community')->where([['member_id',Auth::guard()->user()->unique_id],['type','credit'],['rank','community-downline']])->orderby('created_date','desc')->paginate(10);
       return view('page_templates.level_video_report',$data); 
}


public function pool_income_report()
{
     
      $data['commision_majic_pool'] = DB::table('commision_majic_pool')
    ->select(
        'commision_majic_pool.*',
        'package.id as package_id',   // Aliased the column to avoid ambiguity
        'package.profit as pack_profit',
        'package.price as pack_price',
         'package.package_name as pack_package_name',
   

    )
    ->join('package', 'package.id', '=', 'commision_majic_pool.packg_id')
    ->where('commision_majic_pool.user_id', Auth::guard()->user()->unique_id)
    ->where('commision_majic_pool.cycle', function($query) {
        $query->select(DB::raw('MAX(cycle)'))
              ->from('commision_majic_pool')
              ->where('commision_majic_pool.user_id', Auth::guard()->user()->unique_id)
              ->whereColumn('commision_majic_pool.packg_id', 'package.id');
    })
->orderBy('entry_fee')

    ->get();
       return view('page_templates.level_video_report',$data); 
}


public function pool_income_report_history()
{
     
      $data['commision_majic_pool_history'] = DB::table('commision_majic_pool')
    ->select(
        'commision_majic_pool.*',
        'package.id as package_id',   // Aliased the column to avoid ambiguity
        'package.profit as pack_profit',
        'package.profit as pack_profit',
        'package.upgrade_charge as pack_upgrade_charge',
         'package.package_name as pack_package_name',
         
   

    )
    ->join('package', 'package.id', '=', 'commision_majic_pool.packg_id')
    ->where([['commision_majic_pool.user_id', Auth::guard()->user()->unique_id],['commision_majic_pool.status','closed']])   
->orderBy('entry_fee')

    ->paginate(50);
       return view('page_templates.level_video_report',$data); 
}


public function get_next_video(Request $request){
  

    if(strtotime(date('H:i:s')) < strtotime($this->setting->ads_end_time) && strtotime(date('H:i:s')) > strtotime($this->setting->ads_start_time) ){


     if(date('Y-m-d', strtotime(Auth::guard()->user()->expire_date))>=date('Y-m-d')){
$id=Auth::guard()->user()->unique_id;

UserAd::where([['user_id',$id],['create_date','<',date('Y-m-d')]])->delete();

$data=array(
'ads_id'=>$request->video_id,
'user_id'=>$id,
'create_date'=>date('Y-m-d'),
);




  //$active_direct_user=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.parent_id',$id],['status','!=','inactive'],['expire_date','>=',date('Y-m-d')]])->count();




            $dStart =  new DateTime(Auth::guard()->user()->active_date);
    $dEnd = new DateTime(date("Y-m-d"));
   $dDiff = $dStart->diff($dEnd);
  $days= $dDiff->format('%r%a'); 
  

if(Auth::guard()->user()->expire_date>=date('Y-m-d') && $request->video_id!=0){
 
    $plan=CommisionPlan::where('plan_name','self')->orderBy('commision', 'DESC')->first();

 
    
    if($id!='999999' && IncomeEngine::enabled()){
 $this->get_parent_user_byads($id,1);
}


 $level_no=$this->display_children(Auth::guard()->user()->unique_id, 0) ;
 $caping='2000';
if(isset($level_no[0]) && $level_no[0]>=50 ){
    $caping='4000';
}
if(isset($level_no[1]) &&$level_no[1]>=300 ){
    $caping='8000';
}
if(isset($level_no[2]) &&$level_no[2]>=1000 ){
    $caping='20000';
}


      $cdata=array(
    'member_id'=>Auth::guard()->user()->unique_id,
    'type'=>'credit',
    'created_date'=>date('Y-m-d')    
);
   $amount = CommisionTable::where($cdata)->sum('amount');
   if($amount<$caping){
   CommisionTable::create(array('member_id'=>$id,'plan'=>$plan->id,'rank'=>$plan->plan_name,'target'=>$plan->member,'type'=>'credit','amount'=>$plan->commision,'created_date'=>date('Y-m-d'),'day_count'=>'1','income_type'=>'video'));
       
   }

    UserAd::create($data);
}
//}



 





    $data['status']=User::where('unique_id',$id)->first();
    if($data['status']->status=='active'){
        $sql="SELECT * FROM videos WHERE videos.id NOT IN (SELECT ads_id FROM user_ads WHERE user_id='".$id."' and create_date = '".date('Y-m-d')."') limit 1";

$video=DB::select($sql);

$html=' <div class="row">
    <div class="col-md-4">

        ';
          if(isset($video[0]) && $video[0]->download_link!=''){
            if(isset($video[0]->download_text) && $video[0]->download_text!=''){
                $download_text=$video[0]->download_text;
            }else{
                $download_text='Click here to download';
            }
           $html.='    <a class="download-btn mt50" target="_blank" href="'.$video[0]->download_link.'"> '.$download_text.'</a>';
             }
   $html.='  </div>
     <div class="col-md-4">';
             if(isset($video[0])) {
               $html.='  <div id="video_panel" class="ad-panel text-center">';
            
                if(isset($video[0]) && $video[0]->type==1){
           $html.='  <video width="420" height="345" controls autoplay >
              <source id="midea_video" src="'.url('/').'/public/uploads/'.$video[0]->file.'" type="video/mp4">
            </video>';
        }elseif(isset($video[0]) && $video[0]->type==3){
             $html.='   <img src="'.url('/').'/public/uploads/'. $video[0]->file.'" width="420" height="345">';
         }
              elseif(isset($video[0]) && $video[0]->type==2){
              
              
             $html.=' <iframe id="youtube_video" width="420" height="345" src="https://www.youtube.com/embed/'.$video[0]->link.'?autoplay=1&mute=1">
            </iframe>';
              }
            
             
            $html.=' </div>';
          }
    $html.=' </div>
    <div class="col-md-4">
        <div class="box-body">
            <div class="d-flex align-items-center justify-content-between">
            <div>
            <h4 class="mb-0"> Video Rs</h4>
             <h2 class="mb-0" style="color: #f18179">Rs.
            <span id="ContentPlaceHolder1_lblVideoIncome">6</span></h2>
            </div>
           <i class="fas fa-money-bill-alt"></i>
            </div>
        </div>
        <div class="box-body">
            <div class="d-flex align-items-center justify-content-between">
            <div>
            <h4 class="mb-0">Ads Time</h4>
             <h2 class="mb-0" style="color: #f18179">
            <span id="some_div">'.$this->setting->ads_for_time.' Sec</span></h2>
            </div>
           <i class="fa fa-clock" aria-hidden="true"></i>
            </div>
        </div>';
           if(isset($video[0])) {
        $html.=' <button style="display:none;" class="btn btn-rounded btn-success mlrauto btn-red" id="next_btn" onclick="get_next_video(\''.$video[0]->id.'\')"> Get Payment</button>
    ';
           }
   $html.=' </div>
  </div>';

  
 if(isset($video[0]->id)){
         $data['id']=$video[0]->id;
        $data['success']=$html;
    }else{
         $data['err']='No more video for today, next video coming soon';
    }

    }else{
         $data['err']='Please activate your account';
    }

   

     $data['total_video_earning']=CommisionTable::where([['member_id',Auth::guard()->user()->unique_id],['type','credit'],['plan','16']])->sum('amount');
    $data['total_level_earning']=CommisionTable::where([['member_id',Auth::guard()->user()->unique_id],['type','credit'],['plan','!=','16']])->sum('amount');
  
       
    $video_debit=CommisionTable::where([['member_id',Auth::guard()->user()->unique_id],['type','debit'],['plan','16'],['request_status','approve']])->sum('amount');

    $level_debit=CommisionTable::where([['member_id',Auth::guard()->user()->unique_id],['type','debit'],['plan','!=','16'],['request_status','approve']])->sum('amount');

 $data['video_balance']=$data['total_video_earning']-$video_debit;
 $data['level_balance']=$data['total_level_earning']-$level_debit;

}else{

     $data['expire']=true;
}
}else{
      $data['err']='Ads comming soon';
}
    echo json_encode($data);

}

 public  function dateDiffInDays($date1, $date2)  
{ 
    // Calculating the difference in timestamps 
    $diff = strtotime($date2) - strtotime($date1); 
      
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 
    return abs(round($diff / 86400)); 
} 
  
    public function direct_member(){
     
        $id=Auth::guard()->user()->unique_id;
        $data['direct_user']=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where('parent_id',$id)->get();
         return view('page_templates.directmember',$data); 
    }

     public function all_member(){
        $id = Auth::guard()->user()->unique_id;
        $data['all_user'] = \App\Services\LevelPartnerMembers::downlineWithLevels($id);

        return view('page_templates.allmember', $data);
    }

       public function community_member(){
         $user = Auth::guard()->user();
         $data['type'] = 'Global Community Upline';
         $data['members'] = CommunitySerialMembers::upline($user, 50);

         return view('page_templates.community_serial_list', $data);
    }


     public function community_member_downline(){
         $user = Auth::guard()->user();
         $data['type'] = 'Global Community Downline';
         $data['members'] = CommunitySerialMembers::downline($user, 50);

         return view('page_templates.community_serial_list', $data);
    }
    

       public function show_my_pin(){
        $data['pin']=MemberPin::where([['member_id',Auth::guard()->user()->unique_id],['status','inactive'],['type',1]])->get();
        return view('page_templates.show_pin',$data);
    }
         public function show_my_pin_history(){
        $data['pin']=MemberPin::where([['member_id',Auth::guard()->user()->unique_id],['status','active'],['type',1]])->get();
        return view('page_templates.show_pin_history',$data);
    }
    
    
    public function show_my_autopull_pin(){
        $data['pin']=MemberPin::where([['member_id',Auth::guard()->user()->unique_id],['status','inactive'],['type',2]])->get();
        return view('page_templates.show_pin_autopull',$data);
    }
         public function show_my_pin_autopull_history(){
        $data['pin']=MemberPin::where([['member_id',Auth::guard()->user()->unique_id],['status','active'],['type',2]])->get();
        return view('page_templates.show_pin_history_autopull',$data);
    }
    
    public function share_link(){
        return view('page_templates.share_link');
    }

 


    public function active_pin_view($pinid){

         $data['pin']=MemberPin::where('id',$pinid)->first();

      
return view('page_templates.active_pin_view',$data);
    }
 

    public function active_pin(Request $request){
        if (! PackagePurchaseEngine::enabled()) {
            Session::flash('danger', 'Package activation / plan purchase is disabled by admin.');

            return redirect()->back();
        }

        $pin = MemberPin::where('id','=',$request->hpinid)->first();
if($pin->type==1){
         $search = User::where('unique_id','=',$request->member_unique_id)->first();
         if($search->status=='inactive'){
            
           // $after7day=strtotime("+2 day", strtotime($search->created_at));
            // $after7daydate=date('Y-m-d', $after7day);
            
           //if(date('Y-m-d')<=$after7daydate){
     
       $data=array(
'status'=>'active',
'activate_for'=>$request->member_unique_id,
'activated_by'=>Auth::guard()->user()->unique_id,
       );

       $expdate=date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$this->setting->activate_day.' days'));
       
      

        $result = MemberPin::where('id','=',$request->hpinid)->update($data);
         $result2 = User::where('unique_id','=',$request->member_unique_id)->update(array('status'=>'active','active_date'=>date('Y-m-d H:i:s'),'expire_date'=>$expdate));


$this->get_parent_user($request->member_unique_id,1);
$this->get_parent_user_for_reward($request->member_unique_id,1);

       
        if($result2){
           Session::flash('success', 'Member id activated successfully.'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }
//     }
//     else{
     
//      Session::flash('danger', 'Activation after 2 days of joining is not alowed');
// }

}
    else{
        Session::flash('danger', 'Member aleready active');
    }

         
          return redirect()->route('show_my_pin');
}else{
         $data=array(
'status'=>'active',
'activate_for'=>$request->member_unique_id,
'activated_by'=>Auth::guard()->user()->unique_id,
       );

     $result = MemberPin::where('id','=',$request->hpinid)->update($data);
     UserTree::create(array('user_id'=>Auth::guard()->user()->unique_id,'plan_id'=>'1','plan_name'=>'SILVER INCOME'));
                      
                       $updata=array(
              'current_plan_id'=>1,
              'plan_name'=>'SILVER INCOME',
              'plan_status'=>'Pending',
              
              );
                  
                      
                  

                  User::where('unique_id',Auth::guard()->user()->unique_id)->update($updata);
    $this->get_autopull_income($request->member_unique_id,1);
     return redirect()->route('show_my_autopull_pin');
}
    }




 /* ------------------ */


 public function get_parent_user($user_id,$level_id){
  if (! IncomeEngine::enabled()) {
      return true;
  }
  if($level_id<=9){
  $get_parent = UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.user_id',$user_id],['status','!=','inactive'],['expire_date','>=',date('Y-m-d')]])->orderBy('active_date', 'ASC')->first();

  if($get_parent && $get_parent->parent_id!=0){
$parent_id=$get_parent->parent_id;


  

  // $active_direct_user=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.parent_id',$parent_id],['status','!=','inactive'],['expire_date','>=',date('Y-m-d')]])->count();
$plan=CommisionPlan::where([['level','=',$level_id],['one_time','1']])->first();
//if($active_direct_user>=$plan->direct){

 $level_no=$this->display_children($parent_id, 0) ;
 $caping='2000';
if(isset($level_no[0]) && $level_no[0]>=50 ){
    $caping='4000';
}
if(isset($level_no[1]) &&$level_no[1]>=300 ){
    $caping='8000';
}
if(isset($level_no[2]) &&$level_no[2]>=1000 ){
    $caping='20000';
}


      $cdata=array(
    'member_id'=>$parent_id,
    'type'=>'credit',
    'created_date'=>date('Y-m-d')    
);
   $amount = CommisionTable::where($cdata)->sum('amount');
   if($amount<$caping){
CommisionTable::create(array('member_id'=>$parent_id,'plan'=>$plan->id,'rank'=>$plan->plan_name,'target'=>$plan->member,'type'=>'credit','amount'=>$plan->commision,'created_date'=>date('Y-m-d'),'day_count'=>'1','direct_member_id'=>Auth::guard()->user()->unique_id,'income_type'=>'onetime'));
       
   }
//}



 

     


$this->get_parent_user($parent_id,$level_id+1);

}
}

return true;

 }



 //************************.

 

  //************************.

 public function get_parent_user_for_reward($user_id,$level_id){
  if (! IncomeEngine::enabled()) {
      return true;
  }
  if($level_id<=9){
  $get_parent = UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.user_id',$user_id],['status','!=','inactive'],['expire_date','>=',date('Y-m-d')]])->orderBy('active_date', 'ASC')->first();

  if($get_parent && $get_parent->parent_id!=0){
$parent_id=$get_parent->parent_id;


  

   $active_direct_user=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.parent_id',$parent_id],['status','!=','inactive'],['expire_date','>=',date('Y-m-d')]])->count();
$plan=RewardPlan::where('level','=',$level_id)->first();
if($active_direct_user>=$plan->member){

 $exist_plan=CommisionTable::where([['member_id',$parent_id],['plan',$plan->id],['rank','reward']])->first();
    if($exist_plan){
        $err='alrady credited';
    }else{
        
        

CommisionTable::create(array('member_id'=>$parent_id,'plan'=>$plan->id,'rank'=>'reward','target'=>$plan->member,'type'=>'credit','amount'=>$plan->rewards,'created_date'=>date('Y-m-d'),'day_count'=>'1','direct_member'=>$active_direct_user,'income_type'=>'rewards'));
}
}


 

     


$this->get_parent_user_for_reward($parent_id,$level_id+1);

}
}

return true;

 }



public function get_level_member($user_id,$level_id){
for ($i=1; $i <=$level_id ; $i++) { 
   

  $get_parent= UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.user_id',$user_id],['status','!=','inactive'],['expire_date','>=',date('Y-m-d')]])->orderBy('active_date', 'ASC')->first();

  if($get_parent && $get_parent->parent_id!=0){
$parent_id=$get_parent->parent_id;


  

  $active_direct_user=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.parent_id',$parent_id],['status','!=','inactive'],['expire_date','>=',date('Y-m-d')]])->count();
$plan=CommisionPlan::where([['level','=',$level_id],['id','!=','16'],['id','!=','15']])->orderBy('commision', 'DESC')->first();
if($active_direct_user>=$plan->direct){


CommisionTable::create(array('member_id'=>$parent_id,'plan'=>$plan->id,'rank'=>$plan->plan_name,'target'=>$plan->member,'type'=>'credit','amount'=>$plan->commision,'created_date'=>date('Y-m-d'),'day_count'=>'1','direct_member'=>$active_direct_user,'direct_member_id'=>Auth::guard()->user()->unique_id));
}



 

     


$this->get_parent_user($parent_id,$level_id+1);

}
}

return true;

 }
 
 public function get_autopull_income($member_id){
  if (! IncomeEngine::enabled()) {
      return true;
  }
     
$member=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_id',$member_id],['status','!=','inactive']])->first();


 /* direct commision */
 $plans=AutopullPlan::get();


foreach ($plans as $plan) {


      
      
        $all_user=UserTree::select('users.*','user_trees.*','user_trees.id as tree_id')->join('users', 'users.unique_id', '=', 'user_trees.user_id')->where([['users.current_plan_id',$plan->id],['status','!=','inactive'],['user_trees.plan_id',$plan->id]])->orderBy('user_trees.id', 'ASC')->get();
        
      

  
        
       foreach ($all_user as $user) {
           
          $exist=CommisionTable::where([['plan',$plan->id],['member_id',$user->unique_id],['type','credit']])->first();
          
       
          if(!$exist){
     
            
          
          $matched_user=DB::select('SELECT user_trees.* FROM user_trees WHERE plan_id='.$plan->id.' and id > '.$user->tree_id.' and id NOT IN(SELECT user_completeds.tree_id FROM user_completeds WHERE user_completeds.user_id="'.$user->unique_id.'") ORDER BY user_trees.id ASC');
          
           $number_of_user=count($matched_user);
    
            if($number_of_user>=$plan->direct){
                
                for($i=0; $i<$plan->direct; $i++){
                
                     
                UserCompleted::create(array('user_id'=>$user->unique_id,'tree_id'=>$matched_user[$i]->id));
               
            }
            
           
       //updateing     
              $updata=array(
              'current_plan_id'=>$plan->id,
              'plan_name'=>$plan->plan_name,
              'plan_status'=>'Achieved',
              
              );
          
          
          $amount=$plan->commision;
            CommisionTable::create(array('member_id'=>$user->unique_id,'plan'=>$plan->id,'type'=>'credit','amount'=>$amount,'direct_member'=>$plan->direct,'in_wallet'=>'0','level'=>$plan->level));
            
            if($plan->auto_upgrade==1){
              
               
               
                  
                   CommisionTable::where([['plan',$plan->id],['member_id',$user->unique_id],['type','credit'],['level','1']])->update(array('in_wallet'=>'1'));
                  
                        
$start_date = date_create($user->active_date);

$end_date   = date_create(date('Y-m-d'));

$diff = date_diff($start_date,$end_date);

 $diff=$diff->format("%a");
                        
                       
                  
                  $new_plans=AutopullPlan::where('id','>',$plan->id)->orderby('id','ASC')->first();
                  if($new_plans){
                      
                      UserTree::create(array('user_id'=>$user->unique_id,'plan_id'=>$new_plans->id,'plan_name'=>$new_plans->plan_name));
                      
                       $updata=array(
              'current_plan_id'=>$new_plans->id,
              'plan_name'=>$new_plans->plan_name,
              'plan_status'=>'Pending',
              
              );
                  }
                      
                  }

                  User::where('unique_id',$user->unique_id)->update($updata);
           
           
           
       }
       } 
      
  }
  
    
   

}


return true;
          
          
          
}

public function reward_check($member_id){
  if (! IncomeEngine::enabled()) {
      return true;
  }

   $reward_plan=RewardPlan::get();
foreach ($reward_plan as $rplan) {
   



  $exist_plan=CommisionTable::where([['member_id',$member_id],['plan',$rplan->id],['rank','reward']])->first();
    if($exist_plan){
        $err='alrady credited';
    }else{
    
 

 $level=($rplan->level)-1;
  $result=$this->display_children($user->unique_id, 0) ;
if(isset($result[$level])){
 

 
 
   if($result[$level]>=$rplan->member ){
  

     CommisionTable::create(array('member_id'=>$member_id,'plan'=>$rplan->id,'rank'=>'reward','type'=>'credit','rewards'=>$rplan->rewards,'direct_member'=>$rplan->member));
  }


}
}

}
return true;

}










public function direct_commosion_view(){
 $data['direct_commision']=CommisionTable::join('users', 'users.unique_id', '=', 'commision_tables.direct_member')->where([['member_id',Auth::guard()->user()->unique_id],['plan','2'],['commision_tables.rank','!=','reward'],['commision_tables.rank','!=','daily']])->orderBy('direct', 'ASC')->get();
 return view('page_templates.direct_commision',$data);

}


public function autopull_commosion_view(){
 $data['plan']=AutopullPlan::orderBy('id', 'ASC')->get();

    $data['user_id']=Auth::guard()->user()->unique_id;
 return view('page_templates.autopull-commission',$data);

}


public function rewards_view(){
  $data['reward']=Award::get();
 return view('page_templates.reward',$data);
 

}

public function level_commosion_view(){
    $data['user_id']=Auth::guard()->user()->unique_id;
 $data['plan']=CommisionPlan::get();




 return view('page_templates.level_commision',$data);

}




public function send_request(){
  $data['bank']=BankDetail::first();
     return view('page_templates.send_request',$data);
}

public function send_autopull_request(){
  $data['bank']=BankDetail::first();
     return view('page_templates.send_request_autopull',$data);
}

public function send_upgrade_request(){
  $data['bank']=BankDetail::first();
   $data['upgeade']=Upgrade::get();
  

     return view('page_templates.upgrade_request',$data);
}
public function view_request_status(){
   $data['request']=MemberRequest::where([['member_id',Auth::guard()->user()->unique_id],['type',1]])->get();
     return view('page_templates.send_request_status',$data);
}


public function view_request_autopull_status(){
    $data['request']=MemberRequest::where([['member_id',Auth::guard()->user()->unique_id],['type',2]])->get();
     return view('page_templates.send_request_autopull_status',$data);
}


public function view_upgrade_request_status(){
    $data['request']=UpgradeRequest::where('member_id',Auth::guard()->user()->unique_id)->get();
     return view('page_templates.upgrade_request_status',$data);
}

public function request_admin(Request $request){
$data=array(
   
    'request_amount'=>$request->request_amount,
    'request_message'=>$request->request_message,
    'member_id'=>Auth::guard()->user()->unique_id,
    'transaction_id'=>$request->transaction_id,
    
    'status'=>'pending'

);

       if($request->hasFile('request_file'))
        {
            $destinationPath = 'uploads';
            $file = $request->file('request_file');
            $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename=time().rand(100,999).$original_name.'.'.$extension;
            
            $file->move(
                config('services.new_root_path').$destinationPath, $filename
            );

            $data['request_file'] = $filename;

        }

        $result=MemberRequest::create($data);

         return redirect()->route('view_request_status');
}


public function request_autopull_admin(Request $request){
$data=array(
    'request_pin'=>$request->request_pin,
    'request_amount'=>$request->request_amount,
    'request_message'=>$request->request_message,
    'member_id'=>Auth::guard()->user()->unique_id,
    'transaction_id'=>$request->transaction_id,
     'type'=>2,
    'status'=>'pending'

);

       if($request->hasFile('request_file'))
        {
            $destinationPath = 'uploads';
            $file = $request->file('request_file');
            $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename=time().rand(100,999).$original_name.'.'.$extension;
            
            $file->move(
                config('services.new_root_path').$destinationPath, $filename
            );

            $data['request_file'] = $filename;

        }

        $result=MemberRequest::create($data);

         return redirect()->route('view_request_status');
}



public function request_upgrade_admin(Request $request){
$data=array(

    'request_amount'=>$request->request_amount,
    'request_message'=>$request->request_message,
    'member_id'=>Auth::guard()->user()->unique_id,
    'transaction_id'=>$request->transaction_id,
    'upgrade_id'=>$request->upgrade_id,
    'type'=>2,
    'status'=>'pending'

);

       if($request->hasFile('request_file'))
        {
            $destinationPath = 'uploads';
            $file = $request->file('request_file');
            $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename=time().rand(100,999).$original_name.'.'.$extension;
            
            $file->move(
                config('services.new_root_path').$destinationPath, $filename
            );

            $data['request_file'] = $filename;

        }

        $result=UpgradeRequest::create($data);

         return redirect()->route('view_upgrade_request_status');
}




public function transfer_pin(){
       $data['total_pin'] = MemberPin::where([['member_id','=',Auth::guard()->user()->unique_id],['status','inactive']])->count();
 return view('page_templates.transfer_pin',$data);
}

public function transfer_pin_member(Request $request){

         $total_pin = MemberPin::where([['member_id','=',Auth::guard()->user()->unique_id],['status','inactive']])->count();
         if($request->number_of_pin<=$total_pin ){

            if($request->member_unique_id!=Auth::guard()->user()->unique_id){

 $all_pin = MemberPin::where([['member_id','=',Auth::guard()->user()->unique_id],['status','inactive']])->limit($request->number_of_pin)->get();
           foreach ($all_pin as $pin) {
            
            
     
       $data=array(
'member_id'=>$request->member_unique_id,
       );

        $result = MemberPin::where('id','=',$pin->id)->update($data);
         

}
        if($result){
           Session::flash('success', $request->number_of_pin .' Pin transfer to '.$request->member_unique_id.' successfully.'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }


        }
    else{
        Session::flash('danger', 'Please check member id');
    }

    }
    else{
        Session::flash('danger', 'Your request pin is grater than you have');
    }

         
          return redirect()->route('transfer_pin');
}



public function upload_kyc_view(){
$data['kyc']=User::where('unique_id',Auth::guard()->user()->unique_id)->first();
$user = $data['kyc'];
$dial = preg_replace('/\D+/', '', (string) ($user->dial_code ?? ''));
$phone = preg_replace('/\D+/', '', (string) ($user->phone ?? ''));
$full = $dial.$phone;
$data['masked_phone'] = $full ? ('+'.substr($full, 0, max(0, strlen($full) - 5)).str_repeat('X', min(5, strlen($full)))) : '';
$data['whatsapp_settings'] = WhatsappSetting::current();

// Always require a fresh OTP verification on each visit before wallet update.
session()->forget(['address_otp_verified', 'address_otp_verified_at', 'address_verification_token']);
$data['address_otp_verified'] = false;
$data['require_address_otp'] = (bool) $data['whatsapp_settings']->require_otp_address_update;
$data['otp_resend_seconds'] = (int) ($data['whatsapp_settings']->otp_resend_cooldown_seconds ?? 120);
$data['otp_expiry_minutes'] = (int) ($data['whatsapp_settings']->otp_expiry_minutes ?? 5);
$data['app_base'] = rtrim(request()->getBasePath(), '/');

 return view('page_templates.kyc_view',$data);

}

public function upload_profile_view(){
$data['profile']=User::where('unique_id',Auth::guard()->user()->unique_id)->first();

 return view('page_templates.profile_view',$data);

}



public function update_kyc(Request $request){
    $user = Auth::guard()->user();
    $settings = WhatsappSetting::current();
    $token = trim((string) $request->input('address_verification_token', ''));
    if ($settings->require_otp_address_update) {
        $otpService = app(OtpService::class);
        if (! $token || ! $user || ! $otpService->assertAddressToken($user->unique_id, $token)) {
            session()->forget(['address_otp_verified', 'address_otp_verified_at', 'address_verification_token']);
            Session::flash('danger', 'Please verify OTP before updating your wallet address.');

            return redirect()->route('upload_kyc_view');
        }
    }

    if (! is_string($request->trc_address) || trim($request->trc_address) === '') {
        Session::flash('danger', 'USDT (BEP-20) wallet address is required.');

        return redirect()->route('upload_kyc_view');
    }

    $data = [
        'trc_address' => strip_tags(trim($request->trc_address)),
    ];



         if (! $user || (int) $request->hid !== (int) $user->id) {
             Session::flash('danger', 'Invalid update request.');

             return redirect()->route('upload_kyc_view');
         }

         $result = User::where('id', $user->id)->update($data);

          if($result){
           if ($settings->require_otp_address_update && ! empty($token)) {
               app(OtpService::class)->consumeAddressToken($user->unique_id, $token);
           }
           session()->forget(['address_otp_verified', 'address_otp_verified_at', 'address_verification_token']);
           Session::flash('success', 'Wallet address updated successfully.'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }

           return redirect()->route('upload_kyc_view');

}


public function agrement(Request $request){
     return view('page_templates.agrement');
}

public function submit_agrement(Request $request){
   
         $result = User::where('id',Auth::guard()->user()->unique_id)->update(array('agrement'=>'Yes'));
     return view('page_templates.active_type');
         
}


public function send_otp(){
    $otp=rand(1111,9999);
    session::put('otp',$otp);
    
     $msg="<p>Dear ".Auth::guard()->user()->name." </p>,
   <p> Your OTP is below </p>

<p>".$otp."</p>
<p>Thank You</p>
";


      $result=$this->sendgridEmail('OTP',$msg,Auth::guard()->user()->email);
      if($result){
          $data['success']=true;
      }
      
      echo json_encode($data);
}



public function update_profile(Request $request){

    $data=array(
      
           'moninee'=>$request->moninee,
            'address'=>$request->address,
             'city'=>$request->city,  
             'state'=>$request->state,       
             'pincode'=>$request->pincode,         

    );








         $result = User::where('id','=',$request->hid)->update($data);

          if($result){
           Session::flash('success', 'Profile Updated successfully.'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }

           return redirect()->route('upload_profile_view');

}




public function withdraw_request_view(){


$balance=DB::table('wallet_primary')->where('user_id',Auth::guard()->user()->unique_id)->first();
if($balance){
    $data['balance']=$balance->balance;
}
else{
    $data['balance']=0;
}


 return view('page_templates.withdraw_request_view',$data);
}


public function request_withdraw(Request $request){

    //  if(strtotime(date('H:i:s')) < strtotime($this->setting->withdraw_end_time) && strtotime(date('H:i:s')) > strtotime($this->setting->withdraw_start_time) ){

    if( Auth::guard()->user()->status=='active'){

        $data=array(
    'member_id'=>Auth::guard()->user()->unique_id,
    'type'=>'debit',
    'created_date'=>date('Y-m-d')    
);
   $exist = CommisionTable::where($data)->first();
   if($exist){
     Session::flash('danger', 'Only one withdraw can be done in same day');
     return redirect()->route('withdraw_request_view');
   }else{
  

   $balance=DB::table('wallet_primary')->where('user_id',Auth::guard()->user()->unique_id)->first();
if($balance){
    $balance=$balance->balance;
}
else{
    $balance=0;
}



     $kyc = User::where('unique_id','=',Auth::guard()->user()->unique_id)->first();

   
    
    
 $active_direct_user=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['parent_id',Auth::guard()->user()->unique_id],['status','!=','inactive'],['expire_date','>=',date('Y-m-d')]])->count();

if($balance>=$request->amount  && $kyc->kys_status=='active'){


                $amount=$request->amount-($request->amount*(10/100));
                $taxable_amount=$request->amount*(10/100);
          

$amount=round($amount);
$data=array(
    'member_id'=>Auth::guard()->user()->unique_id,
    'type'=>'debit',
    'amount'=>$request->amount,
    'request_status'=>'processing',
    'tax'=>'10%',
    'taxable_amount'=>$taxable_amount,
    'net_payment'=>$amount,
    
    'created_date'=>date('Y-m-d'),
);
   $result = CommisionTable::create($data);
    if($result){
           Session::flash('success', 'Withdraw request sent successfully.'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }

}else{
    Session::flash('danger', 'Should upload KYC <br>4> Not more than your balance and must activate account');
}


  return redirect()->route('withdraw_request_view');
}
}else{
      Session::flash('danger', '1>Must activate account');
   return redirect()->route('withdraw_request_view');
}
// }else{
//      Session::flash('danger', 'Withdraw can be done from '.$this->setting->withdraw_start_time.' to '.$this->setting->withdraw_end_time);
//     return redirect()->route('withdraw_request_view');
// }
}


public function withdraw_history(){

    $data['history']=CommisionTable::where([['member_id',Auth::guard()->user()->unique_id],['type','debit']])->get();
   
 return view('page_templates.withdraw_history',$data);
}
 
public function changepassword(){
    return view('page_templates.change_password');
}


 public function change_password(Request $request){
    $user=User::where('unique_id',Auth::guard()->user()->unique_id)->first();
    $session_otp=session::get('otp');
    if($user->secpwd==$request->oldpwd && $request->otp==$session_otp){

$result = User::where('unique_id', Auth::guard()->user()->unique_id)->update(array('secpwd'=>$request->cpwd,'password' => Hash::make($request->cpwd)));

 if($result){
           Session::flash('success', 'Password updated successfully.'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }
    }else{
         Session::flash('danger', 'Old Password or OTP not matched');
    }

      return redirect()->route('changepassword');

 }


 public function count_level($parent){

   $get_user= UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.parent_id',$parent],['status','!=','inactive'],['expire_date','>=',date('Y-m-d')]])->get();

   foreach ($get_user as $user) {
     # code...
   }
 }



 function display_children($parent, $level) 
{

 // $result = mysqli_query('SELECT * FROM user_parents WHERE parent_id="'.$parent.'"');
  $count = array(0=>0);
 //  while ($row = mysqli_fetch_array($result))
 //   {
if($level<6){

  $get_user= UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.parent_id',$parent],['status','!=','inactive']])->get();

   foreach ($get_user as $user) {



    $data=  str_repeat(' ',$level). $user->user_id."\n";
   // echo $data;
    $count[0]++;
    $children= $this->display_children($user->user_id, $level+1);
    $index=1;
    foreach ($children as $child)
    {
     if ($child==0)
      continue;
     if (isset($count[$index]))
      $count[$index] += $child;
     else    
      $count[$index] = $child;
     $index++;
    }
   }  
   }
    return $count; 
 
}



 function display_children_details($parent, $level) 
{

 // $result = mysqli_query('SELECT * FROM user_parents WHERE parent_id="'.$parent.'"');
  $count = array(0=>0);
 //  while ($row = mysqli_fetch_array($result))
 //   {
if($level<6){

  $get_user= UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.parent_id',$parent],['status','!=','inactive'],['expire_date','>=',date('Y-m-d')]])->get();

   foreach ($get_user as $user) {



    $data=  str_repeat(' ',$level). $user->user_id."\n";
   // echo $data;
    $count[0]++;
    $children= $this->display_children($user->user_id, $level+1);
    $index=1;
    foreach ($children as $child)
    {
     if ($child==0)
      continue;
     if (isset($count[$index]))
      $count[$index] += $child;
     else    
      $count[$index] = $child;
     $index++;
    }
   }  
   
   
   
   
   }
    return $data; 
 
}

 public function main_wallet_balance(){
    $wallet=DB::table('wallet_primary')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
    if($wallet){
        $data['balance']= $wallet->balance;
    }else{
        $data['balance']= 0;
    }
    $data['wallet_text']='Main wallet balance';
     return view('page_templates.wallet',$data);
}

public function community_wallet_balance(){
        $wallet=DB::table('wallet_community')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
    if($wallet){
        $data['balance']= $wallet->balance;
    }else{
        $data['balance']= 0;
    }
     $data['wallet_text']='Community wallet balance';
     return view('page_templates.wallet',$data);
}

public function secondary_wallet_balance(){
        $wallet=DB::table('wallet_secondary')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
    if($wallet){
        $data['balance']= $wallet->balance;
    }else{
        $data['balance']= 0;
    }
     $data['wallet_text']='Secondary wallet balance';
     return view('page_templates.wallet',$data);
}


public function community_wallet_history(){
        $wallet=DB::table('wallet_community')->where('user_id',Auth::guard()->user()->unique_id)->get();
    
        $data['balance']= $wallet;
   
     return view('page_templates.community-wallet-history',$data);
}

public function wallet_transfer_view(){
 
       $data['wallet']=DB::table('wallet_primary')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
      if($data['wallet']){
      $data['balance']=$data['wallet']->balance;
      }else{
           $data['balance']=0;
      }
      
      
 return view('page_templates.wallet_transfer',$data);
}

public function active_multiple_user($slug,$pack){
    $alluser=User::limit(20)->get();
 $package=DB::table('package')->where('id',1)->first(); 
    foreach ($alluser as $au) {
          $search = User::where('unique_id','=',$au->unique_id)->first();

              
           if($search->status=='inactive'){
                  DB::table('wallet_secondary')->insert(array('balance'=>100000,'user_id'=>$au->unique_id));
                        $wallet=DB::table('wallet_secondary')->select('user_id','balance')->where('user_id',$au->unique_id)->first();
      if($wallet){
      $balance=$wallet->balance;
      }else{
           $balance=0;
      }
       
       
                 if($package->price<=$balance){
                 
                     


      // DB::beginTransaction();
      

      
         $result2 =  User::where('unique_id','=',$au->unique_id)->update(array('status'=>'active','active_date'=>date('Y-m-d H:i:s'),'package_id'=>$package->id));
         
         
           
  //wallet Deduct.....
   $fetch_primary_wallet=DB::table('wallet_secondary')->select('user_id','balance')->where('user_id',$au->unique_id)->first();
  if($fetch_primary_wallet){
       $new_balance_primary=$fetch_primary_wallet->balance-$package->price;
        DB::table('wallet_secondary')->where('user_id',$au->unique_id)->update(array('balance'=>$new_balance_primary));
        
  }
  // finish add wallet
  
  
  $data=array(
    'member_id'=>$au->unique_id,
    'type'=>'debit',
    'amount'=>$package->price,
    'tax'=>'0',
    'taxable_amount'=>0,
    'net_payment'=>$package->price,
    'plan'=>$package->id,
    'created_date'=>date('Y-m-d'),
    'remark'=>'To activate account',
     'wallet_type'=>'s',
     'downline_member'=>$au->unique_id
    
);

   $result = CommisionTable::create($data);
   
  
  



  
 if (IncomeEngine::enabled()) {
     $this->get_direct_income($au->unique_id, $package->price, $package->id);
     $this->get_parent_user_byads($au->unique_id, 1, $package->price, $package->id);
     for ($i = 2; $i < 5; $i++) {
         $this->entry_magic_pool($au->unique_id, $i, 1, 1);
     }
 }

   //DB::commit();


       
        if($result2){
           Session::flash('success', 'Member id activated successfully...'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }



    
                 }else{
                    Session::flash('danger', 'You have not enough balane for this activation');  
                 }
    /////////////////////////////////////////////////////////////
    
         
         }
    else{
        Session::flash('danger', 'Member aleready active');
    }
}
}

public function active_pin_from_wallet(Request $request){
    if (! PackagePurchaseEngine::enabled()) {
        Session::flash('danger', 'Package activation / plan purchase is disabled by admin.');

        return redirect()->route('active_pin_from_wallet_view');
    }
        
               $package=DB::table('package')->where('id',$request->pack)->first(); 

              
      
   if($request->pack!=1){
    User::where('unique_id', $request->member_unique_id)->update([
        'package_id' => $package->id,
        'status' => 'active',
        'active_date' => date('Y-m-d H:i:s'),
    ]);
    if (IncomeEngine::enabled()) {
        $result = $this->entry_magic_pool($request->member_unique_id, $package->id, 1, 1);
    } else {
        $result = true;
    }

    if ($result) {
       Session::flash('success', 'Member id activated successfully...'); 
    }
}else{
         $search = User::where('unique_id','=',$request->member_unique_id)->first();
              
           if($search->status!='active'){
                 
                        $wallet=DB::table('wallet_secondary')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
      if($wallet){
      $balance=$wallet->balance;
      }else{
           $balance=0;
      }
       
       
                 if($package->price<=$balance){
                 
                     


      // DB::beginTransaction();
      

      
        $result2 = User::where('unique_id', '=', $request->member_unique_id)->update([
            'status' => 'active',
            'active_date' => date('Y-m-d H:i:s'),
            'package_id' => $package->id,
        ]);
           
  //wallet Deduct.....
   $fetch_primary_wallet=DB::table('wallet_secondary')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
  if($fetch_primary_wallet){
       $new_balance_primary=$fetch_primary_wallet->balance-$package->price;
        DB::table('wallet_secondary')->where('user_id',Auth::guard()->user()->unique_id)->update(array('balance'=>$new_balance_primary));
        
  }
  // finish add wallet
  
  
  $data=array(
    'member_id'=>Auth::guard()->user()->unique_id,
    'type'=>'debit',
    'amount'=>$package->price,
    'tax'=>'0',
    'taxable_amount'=>0,
    'net_payment'=>$package->price,
    'plan'=>$package->id,
    'created_date'=>date('Y-m-d'),
    'remark'=>'To activate account',
     'wallet_type'=>'s',
     'downline_member'=>$request->member_unique_id
    
);

   $result = CommisionTable::create($data);
   
  
  



  
 if (IncomeEngine::enabled()) {
     $this->get_direct_income($request->member_unique_id, $package->price, $package->id);
     $this->get_parent_user_byads($request->member_unique_id, 1, $package->price, $package->id);
     $result = $this->entry_magic_pool($request->member_unique_id, $package->id, 1, 1);
 } else {
     $result = (bool) $result2;
 }

       
        if($result){
           Session::flash('success', 'Member id activated successfully...'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }



    
                 }else{
                    Session::flash('danger', 'You have not enough balane for this activation');  
                 }
    /////////////////////////////////////////////////////////////
    
         
         }
    else{
        Session::flash('danger', 'Member aleready active');
    }
}
          return redirect()->route('active_pin_from_wallet_view');

    }


public function entry_magic_pool($user_id, $pack_id, $level, $cycle)
{
    if (! PackagePurchaseEngine::enabled()) {
        return false;
    }

    if (! IncomeEngine::enabled()) {
        return true;
    }

    $package = DB::table('package')->where('id', $pack_id)->first();
    

    $exist = DB::table('pool_quee')->where([['user_id', $user_id],['pack_id',$pack_id]])->first();
    if($exist){
 Session::flash('danger', 'This Package already activated');
        return redirect()->route('active_pin_from_wallet_view');
    }

        $last_id = DB::table('pool_quee')->insertGetId([
            'user_id' => $user_id,
            'pack_id' => $pack_id,
            'level'   => $level,
            'cycle'   => $cycle
        ]);


        User::where('unique_id', $user_id)->update([
            'package_id' => $pack_id,
            'cycle'      => $cycle
        ]);


if($level==1){
        DB::table('commision_majic_pool')->insert([
            'user_id'   => $user_id,
            'packg_id'  => $pack_id,
            'level'     => $level,
            'entry_fee' => $package->entry_fee_level_1,
            'team'      => 0,
            'amount'    => 0,
            'upgrade'   => 0,
            're_birth'  => 0,
            'profit'    => 0,
            'cycle'     => $cycle,
            'date'      => date('Y-m-d'),
            'time'      => date('H:i:s'),
            'status'    => 'open'
        ]);


        DB::table('commision_majic_pool')->insert([
            'user_id'   => $user_id,
            'packg_id'  => $pack_id,
            'level'     => 2,
            'entry_fee' => $package->entry_fee_level_2,
           'team'      => 0,
            'amount'    => 0,
            'upgrade'   => 0,
            're_birth'  => 0,
            'profit'    => 0,
            'cycle'     => $cycle,
            'date'      => date('Y-m-d'),
            'time'      => date('H:i:s'),
            'status'    => 'open'
        ]);


        DB::table('commision_majic_pool')->insert([
            'user_id'   => $user_id,
            'packg_id'  => $pack_id,
            'level'     => 3,
            'entry_fee' => $package->entry_fee_level_3,
           'team'      => 0,
            'amount'    => 0,
            'upgrade'   => 0,
            're_birth'  => 0,
            'profit'    => 0,
            'cycle'     => $cycle,
            'date'      => date('Y-m-d'),
            'time'      => date('H:i:s'),
            'status'    => 'open'
        ]);
    }


      

             if ($level == 1) {
                $required_mem = $package->level_1_team;


            } if ($level == 2) {
                $required_mem = $package->level_2_team;


            }else {
                $required_mem = $package->level_3_team;
            }


$get_free_count = DB::table('pool_quee')
            ->where([['id', '<=', $last_id], ['pack_id', $pack_id], ['level', $level],['count',0]])
            ->count();

echo ' Level-'.$level.' free member-'.$get_free_count.'<br>';
                if($get_free_count>=$required_mem){
                     $get_parent = DB::table('pool_quee')
            ->where([['pack_id', $pack_id], ['level', $level]])
            ->orderBy('id','asc')
            ->first();
                    $p_user=$get_parent;
                }
if(isset($p_user)){
    echo 'Parent user '.$p_user->user_id.'<br>';
            $total_down_mem = DB::table('pool_quee')
                ->where([['id', '>', $p_user->id], ['pack_id', $pack_id], ['level', $level],['count',0]])->limit($required_mem)->pluck('user_id');
                
echo 'total_down-'.count($total_down_mem).'<br>'.json_encode($total_down_mem).'Required-'.$required_mem.'<br>';
$total_level_mem=count($total_down_mem);


          if((int)count($total_down_mem)>=(int)$required_mem){

           echo 'matched down-'.count($total_down_mem).'<br>';

//update count.........
                DB::table('pool_quee')
    ->whereIn('user_id', $total_down_mem)
    ->where([['pack_id', $pack_id], ['level', $level]])
    ->update(['count' => 1]);

     if ($level == 1) {
$level_profit=$package->profit_level_1;
}else if ($level == 2) {
$level_profit=$package->profit_level_2;
}
else{
    $level_profit=$package->profit_level_3;
}

    $amount_t=($level_profit-($level_profit*20)/100);
 $comm_wallet=($level_profit*20)/100;

              
                $data_update = [
                    'team'    => $required_mem,
                    'amount'  => $package->entry_fee_level_1*$required_mem,
                    'upgrade' => $package->upgrade_charge*$level,
                    'profit'  => $level_profit,
                    'taxable_profit'=>$amount_t,
                    'date'    => date('Y-m-d'),
                    'time'    => date('H:i:s'),
                    'status'  => 'closed',
                    'for_ids'=>json_encode($total_down_mem),
                ];





                                    $del=1;
                                    $pool_ent=1;
                
                $open_pool_user_details= DB::table('commision_majic_pool')
                ->where([['user_id', $p_user->user_id], ['level', $level], ['status', 'open'],['packg_id',$pack_id]])->first();

                if ($level == 1) {
                    //$this->entry_magic_pool($p_user->user_id, $pack_id, 2, $cycle);
                    $l_user=$p_user->user_id;
                    $l_pk=$pack_id; 
                    $l_level=2;
                     $l_cycle=$open_pool_user_details->cycle;

                      $data_update['profit_level']=$package->profit_level_1;

                }else if ($level == 2) {
                    //$this->entry_magic_pool($p_user->user_id, $pack_id, 2, $cycle);
                    $l_user=$p_user->user_id;
                    $l_pk=$pack_id; 
                    $l_level=3;
                     $l_cycle=$open_pool_user_details->cycle;

                      $data_update['profit_level']=$package->profit_level_2;

                }
                 else {
                    $user_details = DB::table('commision_majic_pool')
                ->where([['user_id', $p_user->user_id], ['cycle', $open_pool_user_details->cycle],['packg_id',$pack_id]])->first();
                    $next_cycle = (int)$user_details->cycle + 1;
                   // User::where('unique_id', $p_user->user_id)->update(['cycle' => $next_cycle]);

                   

                   // $this->entry_magic_pool($p_user->user_id, $pack_id, 1, $next_cycle);
                      $l_user=$p_user->user_id;
                    $l_pk=$pack_id; 
                    $l_level=1;
                     $l_cycle=$next_cycle;
                    $data_update['re_birth'] = $package->re_birth_chrage;
                     $data_update['upgrade'] =0;
                      $data_update['profit_level']=$package->profit_level_3;
                     $next=1;
                }
            //update
                     DB::table('commision_majic_pool')
                ->where([['user_id', $p_user->user_id], ['level', $level], ['status', 'open'],['packg_id',$pack_id]])
                ->update($data_update);


///add to community_wallet
 $fetch_wallet=DB::table('wallet_community')->select('user_id','balance')->where('user_id',$p_user->user_id)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$comm_wallet;
  DB::table('wallet_community')->where('user_id',$p_user->user_id)->update(array('balance'=>$new_balance));
  }else{
        DB::table('wallet_community')->insert(array('balance'=>$comm_wallet,'user_id'=>$p_user->user_id));
  }


  ///add to wallet

  $fetch_wallet=DB::table('wallet_primary')->select('user_id','balance')->where('user_id',$p_user->user_id)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$amount_t;
  DB::table('wallet_primary')->where('user_id',$p_user->user_id)->update(array('balance'=>$new_balance));
  }else{
        DB::table('wallet_primary')->insert(array('balance'=>$amount_t,'user_id'=>$p_user->user_id));
  }
 


            

       

                 if(isset($del) && $del==1){
                     DB::table('pool_quee')->where([['user_id', $p_user->user_id],['pack_id', $pack_id]])->delete();
                }

                 if(isset($pool_ent) && $pool_ent==1){
                     $this->entry_magic_pool($l_user, $l_pk, $l_level, $l_cycle);
                }

}
               

        
    }

    return true;
}


      public function get_direct_income($user_id,$price,$package_id){
  if (! IncomeEngine::enabled()) {
      return true;
  }

  $get_parent = UserParent::where('user_parents.user_id',$user_id)->first();
$user=User::where([['unique_id',$get_parent->parent_id],['status','active']])->first();


$plan=CommisionPlan::where('id',37)->first();
  if($user){
 



 $amount=(($price*$plan->commision)/100);
 $comm_wallet=($amount*20)/100;

 $amount=$amount-$comm_wallet;


$exist=DB::table('commision_direct')->where([['member_id',$get_parent->parent_id],['direct_member_id',$user_id]])->first();
if(!$exist){
    DB::beginTransaction();

    if($user->package_id<$package_id){
       $result=DB::table('commision_direct')->insert(array('member_id'=>$get_parent->parent_id,'plan'=>$plan->id,'rank'=>$plan->plan_name,'target'=>$plan->member,'type'=>'not','amount'=>$amount,'taxable_amount'=>0,'created_date'=>date('Y-m-d'),'day_count'=>'1','income_type'=>'level','direct_member_id'=>$user_id,'status'=>'Not Achieved','direct_user_package'=>$package_id)); 



    }else{
    
$result=DB::table('commision_direct')->insert(array('member_id'=>$get_parent->parent_id,'plan'=>$plan->id,'rank'=>$plan->plan_name,'target'=>$plan->member,'type'=>'credit','amount'=>$plan->commision,'taxable_amount'=>$amount,'created_date'=>date('Y-m-d'),'day_count'=>'1','income_type'=>'level','direct_member_id'=>$user_id,'status'=>'Achieved'));




///add to community_wallet
 $fetch_wallet=DB::table('wallet_community')->select('user_id','balance')->where('user_id',$get_parent->parent_id)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$comm_wallet;
  DB::table('wallet_community')->where('user_id',$get_parent->parent_id)->update(array('balance'=>$new_balance));
  }else{
        DB::table('wallet_community')->insert(array('balance'=>$comm_wallet,'user_id'=>$get_parent->parent_id));
  }

  
 ///add to wallet

  $fetch_wallet=DB::table('wallet_primary')->select('user_id','balance')->where('user_id',$get_parent->parent_id)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$amount;
  DB::table('wallet_primary')->where('user_id',$get_parent->parent_id)->update(array('balance'=>$new_balance));
  }else{
        DB::table('wallet_primary')->insert(array('balance'=>$amount,'user_id'=>$get_parent->parent_id));
  }
 }

  // finish add wallet
  
  DB::commit();
}


}



return true;

 }






 public function get_parent_user_byads($user_id,$level_id,$price,$package_id){
  if (! IncomeEngine::enabled()) {
      return true;
  }
  if($level_id<=10){

       $get_parent = UserParent::select('parent_id','user_id')->where([['user_id',$user_id]])->first();

  if($get_parent ){

$parent_ids=$get_parent->parent_id;

$usr=User::where('unique_id',$parent_ids)->first();
    
if(isset($usr) && ($usr->status=='active')){


  $exist=DB::table('commision_level')->select('member_id','created_date','direct_member_id')->where([['member_id',$parent_ids],['created_date',date('Y-m-d')],['direct_member_id',Auth::guard()->user()->unique_id]])->first();
  
      if(!$exist){

$plan=CommisionPlan::where('level','=',$level_id)->first();

 $amount=(($price*$plan->commision)/100);
 $comm_wallet=($amount*20)/100;

 $amount=$amount-$comm_wallet;


 if($usr->package_id<$package_id){
    /// not achieved..

DB::table('commision_level')->insert(array('member_id'=>$parent_ids,'plan'=>$plan->id,'rank'=>$plan->plan_name,'target'=>$plan->member,'type'=>'not','amount'=>$amount,'taxable_amount'=>$amount,'created_date'=>date('Y-m-d'),'day_count'=>'1','income_type'=>'level','direct_member_id'=>Auth::guard()->user()->unique_id,'status'=>'Not Achieved'));


 }else{

DB::table('commision_level')->insert(array('member_id'=>$parent_ids,'plan'=>$plan->id,'rank'=>$plan->plan_name,'target'=>$plan->member,'type'=>'not','amount'=>$amount,'taxable_amount'=>$amount,'created_date'=>date('Y-m-d'),'day_count'=>'1','income_type'=>'level','direct_member_id'=>Auth::guard()->user()->unique_id));



//add to community_wallet
 $fetch_wallet=DB::table('wallet_community')->select('user_id','balance')->where('user_id',$parent_ids)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$comm_wallet;
  DB::table('wallet_community')->where('user_id',$parent_ids)->update(array('balance'=>$new_balance));
  }else{
        DB::table('wallet_community')->insert(array('balance'=>$comm_wallet,'user_id'=>$parent_ids));
  }


  ///add to wallet

  $fetch_wallet=DB::table('wallet_primary')->select('user_id','balance')->where('user_id',$parent_ids)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$amount;
  DB::table('wallet_primary')->where('user_id',$parent_ids)->update(array('balance'=>$new_balance));
  }else{
        DB::table('wallet_primary')->insert(array('balance'=>$amount,'user_id'=>$parent_ids));
  }

}


}
$this->get_parent_user_byads($parent_ids,$level_id+1,$price,$package_id);
}

  }

     



}
return true;
}


function get_community_bonus(){
    if (! IncomeEngine::enabled()) {
        \Log::info('Community bonus skipped — income engine disabled.');

        return;
    }
    \Log::info("Community bonus Upload started..");
    $wallet=DB::table('wallet_community')->where('balance','>',0)->get();
    foreach ($wallet as $wall) {

        DB::table('wallet_community_history')->insert(array('user_id'=>$wall->user_id,'balance'=>$wall->balance,'updated_at'=>date('Y-m-d')));

 
        $amount=($wall->balance*(1/100));

         $usr = User::select('parent_id')->where('unique_id', $wall->user_id)->first();

$this->get_upline_member($wall->user_id,50,$amount,$wall->user_id,$wall->balance,$usr->package_id);



$this->get_downline_member($wall->user_id,50,$amount,$wall->user_id,$wall->balance,$usr->package_id);

DB::table('wallet_community')->where('user_id',$wall->user_id)->update(array('balance'=>0));
       
    }
        \Log::info("Community bonus Upload finished..");


}


public function get_downline_member($user_unique_id, $level, $amount, $from, $total_balance,$package_id)
{
    echo 'from ' . $from . '<br>';

    $usr = User::where('unique_id', $user_unique_id)->first();
    if (! $usr || ! $usr->registration_serial) {
        return false;
    }

    $users = User::where('registration_serial', '>', $usr->registration_serial)
        ->where('status', 'active')
        ->orderBy('registration_serial', 'asc')
        ->limit($level)
        ->get();

    $slno = 1;

    foreach ($users as $us) {

        echo 'member_id ' . $us->unique_id . '<br>';

if($package_id==1){
    $pay=1;
}else if($package_id <= $us->package_id){
    $pay=1;
}else{
    $pay=0;
}

if($pay==0){
            DB::table('commision_community')->insert([
                'member_id'        => $us->unique_id,
                'rank'             => 'community-downline',
                'level'            => $slno,
                'target'           => '',
                'type'             => 'not',
                'amount'           => $amount,
                'created_date'     => date('Y-m-d'),
                'in_wallet'        => $total_balance,
                'income_type'      => 'community',
                'direct_member_id' => $from
            ]);

      continue;
}
        $exist = DB::table('commision_community')
            ->where([
                ['member_id', $us->unique_id],
                ['created_date', date('Y-m-d')],
                ['direct_member_id', $from],
                ['rank', 'community-downline']
            ])->first();

        if (!$exist) {

            echo $slno . '<br>';

            DB::table('commision_community')->insert([
                'member_id'        => $us->unique_id,
                'rank'             => 'community-downline',
                'level'            => $slno,
                'target'           => '',
                'type'             => 'credit',
                'amount'           => $amount,
                'created_date'     => date('Y-m-d'),
                'in_wallet'        => $total_balance,
                'income_type'      => 'community',
                'direct_member_id' => $from
            ]);

            $wallet = DB::table('wallet_primary')
                ->where('user_id', $us->unique_id)
                ->first();

            if ($wallet) {
                DB::table('wallet_primary')
                    ->where('user_id', $us->unique_id)
                    ->increment('balance', $amount);
            } else {
                DB::table('wallet_primary')->insert([
                    'user_id' => $us->unique_id,
                    'balance' => $amount
                ]);
            }
        }

        $slno++;

        if ($slno > $level) break; // safety limit
    }

    return true;
}
public function get_upline_member($user_unique_id, $level, $amount, $from, $total_balance,$package_id)
{
    echo 'from ' . $from . '<br>';

    $usr = User::where('unique_id', $user_unique_id)->first();
    if (! $usr || ! $usr->registration_serial) {
        return false;
    }

    $users = User::where('registration_serial', '<', $usr->registration_serial)
        ->where('status', 'active')
        ->orderBy('registration_serial', 'desc')
        ->limit($level)
        ->get();

    $slno = 1;

    foreach ($users as $us) {

        echo 'member_id ' . $us->unique_id . '<br>';

if($package_id==1){
    $pay=1;
}else if($package_id <= $us->package_id){
    $pay=1;
}else{
    $pay=0;
}

if($pay==0){
 DB::table('commision_community')->insert([
                'member_id'        => $us->unique_id,
                'rank'             => 'community-upline',
                'level'            => $slno,
                'target'           => '',
                'type'             => 'not',
                'amount'           => $amount,
                'created_date'     => date('Y-m-d'),
                'in_wallet'        => $total_balance,
                'income_type'      => 'community',
                'direct_member_id' => $from
            ]);
      continue;
}
        // Prevent duplicate entry (same day)
        $exist = DB::table('commision_community')
            ->where([
                ['member_id', $us->unique_id],
                ['created_date', date('Y-m-d')],
                ['direct_member_id', $from],
                ['rank', 'community-upline']
            ])->first();

        if (!$exist) {

            echo $slno . '<br>';

            // Insert commission record
            DB::table('commision_community')->insert([
                'member_id'        => $us->unique_id,
                'rank'             => 'community-upline',
                'level'            => $slno,
                'target'           => '',
                'type'             => 'credit',
                'amount'           => $amount,
                'created_date'     => date('Y-m-d'),
                'in_wallet'        => $total_balance,
                'income_type'      => 'community',
                'direct_member_id' => $from
            ]);

            // ✅ CREDIT WALLET TO UPLINE USER
            $wallet = DB::table('wallet_primary')
                ->where('user_id', $us->unique_id)
                ->first();

            if ($wallet) {
                DB::table('wallet_primary')
                    ->where('user_id', $us->unique_id)
                    ->increment('balance', $amount);
            } else {
                DB::table('wallet_primary')->insert([
                    'user_id' => $us->unique_id,
                    'balance' => $amount
                ]);
            }
        }

        $slno++;

        // Safety break
        if ($slno > $level) break;
    }

    return true;
}


  



public function get_upline_total_member($user_id,$level_id){
  if($level_id<=10){

       $get_parent = UserParent::select('parent_id','user_id')->where([['user_id',$user_id]])->first();

  if($get_parent ){

$parent_ids=$get_parent->parent_id;

$usr=User::where('unique_id',$parent_ids)->first();
    
if(!empty($usr->expire_date) && $usr->expire_date >= date('Y-m-d')){

echo '<tr>
<td>'.$usr->unique_id.'</td>
<td>'.$usr->name.'</td>
<td>'.$usr->active_date.'</td><tr>';


$this->get_upline_member($parent_ids,$level_id+1);
}

  }

     



}

}

 function get_level_income($parent, $level,$date,$earner,$max_level) 
{
  if (! IncomeEngine::enabled()) {
      return;
  }

$plan=CommisionPlan::where('level','=',$level)->first();


    
     $usesrs = UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.parent_id',$parent]])->get();

//dd($usesrs );
if(isset($usesrs[0])){
        foreach($usesrs as $user)
        {






$amount=($plan->commision-($plan->commision*20)/100);
 $comm_wallet=($plan->commision*20)/100;

 


DB::table('commision_level')->insert(array('member_id'=>$earner,'plan'=>$plan->id,'rank'=>$plan->plan_name,'target'=>$plan->member,'type'=>'credit','amount'=>$amount,'created_date'=>$date,'day_count'=>'1','income_type'=>'level','direct_member_id'=>$user->unique_id));
     // echo 'downline-'.$user->unique_id.','.$parent,'-',$active_direct_user.'<br>';


///add to community_wallet
 $fetch_wallet=DB::table('wallet_community')->select('user_id','balance')->where('user_id',$earner)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$comm_wallet;
  DB::table('wallet_community')->where('user_id',$earner)->update(array('balance'=>$new_balance));
  }else{
        DB::table('wallet_community')->insert(array('balance'=>$comm_wallet,'user_id'=>$earner));
  }


  ///add to wallet

  $fetch_wallet=DB::table('wallet_primary')->select('user_id','balance')->where('user_id',$earner)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$amount;
  DB::table('wallet_primary')->where('user_id',$earner)->update(array('balance'=>$new_balance));
  }else{
        DB::table('wallet_primary')->insert(array('balance'=>$amount,'user_id'=>$earner));
  }
 
                                               if($level<$max_level){
    $this->get_level_income($user->user_id, $level+1,$date,$earner,$max_level);
    }
        }
}
//}
}

 

 public function active_pin_from_wallet_view(Request $request){
       $data['pack']=DB::table('package')
    ->where('id', '>', Auth::guard()->user()->package_id)
    ->where(function ($q) {
        $q->where('status', 'active')->orWhereNull('status');
    })
    ->orderBy('id')
    ->limit(1)
    ->get();
           $wallet=DB::table('wallet_secondary')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
           
           
      if($wallet){
      $data['balance']=$wallet->balance;
      }else{
           $data['balance']=0;
      }

      $data['package_purchase_enabled'] = PackagePurchaseEngine::enabled();
      
     

       
       return view('page_templates.active_from_wallet',$data);
       
     }

    public function dismissLoginModal(Request $request)
    {
        $request->session()->put('user_login_modal_dismissed', true);

        return response()->json(['success' => true]);
    }
     
    
    public function secondary_wallet_transaction_history(){

    $data['history']=CommisionTable::where([['member_id',Auth::guard()->user()->unique_id],['type','debit'],['wallet_type','s'],['transaction_type','!=','wtw']])->get();
   
 return view('page_templates.wallet_to_id_activation_history',$data);
}
 

 public function request_withdraw_tran(Request $request){
    $data['wallet']=DB::table('wallet_primary')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
      if($data['wallet']){
      $balance=$data['wallet']->balance;
      }else{
           $balance=0;
      }

if($balance>=$request->amount){


                $amount=$request->amount;
                $taxable_amount=0;
                $net_payment=$amount-$taxable_amount;
                
          


$data=array(
    'member_id'=>Auth::guard()->user()->unique_id,
    'type'=>'debit',
    'amount'=>$request->amount,
    'request_status'=>'approve',
    'tax'=>'25%',
    'taxable_amount'=>$taxable_amount,
    'net_payment'=>$net_payment,
    
    'created_date'=>date('Y-m-d'),
    'remark'=>'Transfer to secondary wallet',
    'wallet_type'=>'p',
);

    DB::beginTransaction();

   $result = CommisionTable::create($data);
   
   

   ///add to wallet
  $fetch_wallet=DB::table('wallet_secondary')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$net_payment;
  DB::table('wallet_secondary')->where('user_id',Auth::guard()->user()->unique_id)->update(array('balance'=>$new_balance));
  }else{
        DB::table('wallet_secondary')->insert(array('balance'=>$net_payment,'user_id'=>Auth::guard()->user()->unique_id));
  }
  
  
  //Deduct.....
   $fetch_primary_wallet=DB::table('wallet_primary')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
  if($fetch_primary_wallet){
       $new_balance_primary=$fetch_primary_wallet->balance-$request->amount;
        DB::table('wallet_primary')->where('user_id',Auth::guard()->user()->unique_id)->update(array('balance'=>$new_balance_primary));
  }
  

  // finish add wallet
  
   DB::commit();
   
    if($result){
           Session::flash('success', 'Withdraw request sent successfully.'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }

}else{
    Session::flash('danger', '1> Not more than your balance and must activate account ');
}


  return redirect()->route('wallet_transfer_view');

}





  public function wallet_to_wallet(Request $request){
       
           $wallet=DB::table('wallet_secondary')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
           
           
      if($wallet){
      $data['balance']=$wallet->balance;
      }else{
           $data['balance']=0;
      }


       
       return view('page_templates.wallet_to_wallet',$data);
       
     }
    
       
             public function wallet_to_wallet_transfer(Request $request){
        
      
    if(Auth::guard()->user()->status=='active'){

  
            $wallet=DB::table('wallet_secondary')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
      if($wallet){
      $balance=$wallet->balance;
      }else{
           $balance=0;
}
 

    
    
//  $active_direct_user=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['parent_id',Auth::guard()->user()->unique_id],['status','!=','inactive'],['expire_date','>=',date('Y-m-d')]])->count();
// if($active_direct_user>=$direct){
if($balance>=$request->amount){


                $amount=$request->amount;
                $taxable_amount=0;
          


$net_payment=$amount;
$data=array(
    'member_id'=>$request->member_unique_id,
    'type'=>'credit',
    'amount'=>$request->amount,
    'request_status'=>'approve',
    'tax'=>'0',
    'taxable_amount'=>$taxable_amount,
    'net_payment'=>$net_payment,
    'plan'=>0,
    'created_date'=>date('Y-m-d'),
    'remark'=>'Credited for wallet to wallet Transfer',
    'downline_member'=>Auth::guard()->user()->unique_id,
    'wallet_type'=>'s',
     'transaction_type'=>'wtw',
);

    DB::beginTransaction();

   $result = CommisionTable::create($data);
   
   

   ///add to wallet
  $fetch_wallet=DB::table('wallet_secondary')->select('user_id','balance')->where('user_id',$request->member_unique_id)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$net_payment;
  DB::table('wallet_secondary')->where('user_id',$request->member_unique_id)->update(array('balance'=>$new_balance));
  }else{
        DB::table('wallet_secondary')->insert(array('balance'=>$net_payment,'user_id'=>$request->member_unique_id));
  }
  
  
  
  
  $data2=array(
    'member_id'=>Auth::guard()->user()->unique_id,
    'type'=>'debit',
    'amount'=>$request->amount,
    'request_status'=>'approve',
    'tax'=>'0',
    'taxable_amount'=>$taxable_amount,
    'net_payment'=>$net_payment,
    'plan'=>0,
    'created_date'=>date('Y-m-d'),
    'remark'=>'Debited for wallet to wallet Transfer',
    'downline_member'=>$request->member_unique_id,
    'wallet_type'=>'s',
    'transaction_type'=>'wtw',
);
$result = CommisionTable::create($data2);
  //Deduct.....
   $fetch_primary_wallet=DB::table('wallet_secondary')->select('user_id','balance')->where('user_id',Auth::guard()->user()->unique_id)->first();
  if($fetch_primary_wallet){
       $new_balance_primary=$fetch_primary_wallet->balance-$net_payment;
        DB::table('wallet_secondary')->where('user_id',Auth::guard()->user()->unique_id)->update(array('balance'=>$new_balance_primary));
  }
  // finish add wallet
  
   DB::commit();
   
    if($result){
           Session::flash('success', 'Wallet to Wallet Transfer done successfully.'); 
        } else {
           Session::flash('danger', 'Error encounterd');
        }

}else{
    Session::flash('danger', '1> Not more than your balance and must activate account ');
}
// }else{
//     Session::flash('danger', '1>Amount should be grater than or equal 100 & less than 55000 .<br> 2> 3 active direct member must for withdraw<br>  3>Should upload KYC <br>4> Not more than your balance and must activate account
//     <br>5> Upgrade your package by activating PIN');
// }

  return redirect()->route('wallet_to_wallet');
}


else{
     Session::flash('danger', 'Please activate your account first');
   return redirect()->route('wallet_to_wallet');
}

    }  


  public function wallet_to_wallet_transaction_history(){

    $data['history']=CommisionTable::where([['member_id',Auth::guard()->user()->unique_id],['transaction_type','wtw']])->get();
   
 return view('page_templates.wallet_to_wallet_history',$data);
}
 
 
    public function sendgridEmail($subject,$message,$to){

$headers = "MIME-Version: 1.0" . "\r\n";

            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $headers .= 'From: <info@digitalads.com>' . "\r\n";
        
     

      $result = mail($to,$subject,$message,$headers);
     
      
      return  $result;


    }
    
}