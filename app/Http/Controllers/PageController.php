<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactFromRequest;
use App\Http\Requests\AppoinmentFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\UserParent;
use Session;
use App\Models\MemberPin;
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


use App\Models\NotificationText;
use App\Models\BankDetail;
use App\Models\UserAd;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Auth;


class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $setting = Setting::firstOrFail();
      $this->setting = $setting;
      $this->site_title = $setting->title;
      $this->emails =  $setting->emails;
      $this->cc_emails = $setting->cc_emails;
      $this->bcc_emails = $setting->bcc_emails;
      $this->secret_key = $setting->secret_key;
      $this->logo = $setting->logo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   

  public function homepage(){

   return view('page_templates.homepage'); 
}


public function show_register_form(){
   
   return view('page_templates.register'); 
}

       public function share_member_add($member_id){
        $user=User::where('unique_id',$member_id)->first();
        $data['sponsor']=$user;
return view('page_templates.register',$data);
    }
    

      public function register_form(Request $request){
$validator = Validator::make(
    $request->all(),
    [
        'email'   => 'required|email|unique:users',
        'phone'   => 'required',
        'userpwd' => 'required|min:6|same:cpws', // or min:8 if you want
        'cpws'    => 'required|min:6',
    ],
    [
        'userpwd.same' => 'Password and Confirm Password must match.',
    ]
);
     if ($validator->fails()) {
            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
        }else{




       $uid=$this->unique_id();
       $seq_pin=$this->sequrity_id();
        
      $exist_user=User::where('unique_id',$request->sponsor_id)->first();
     if($exist_user){
      
      $data = array(
        'unique_id'=>$uid,

        'seq_pin'=>$seq_pin,

        'name' => strip_tags($request->name),

        'email' => strip_tags($request->email),

        'adhar_no' => strip_tags($request->adhar_no),
        
        'phone' => strip_tags($request->phone),

        'country' => strip_tags($request->country),
        'password' => Hash::make($request->cpws),
        'secpwd'=>$request->cpws,
       
      );

      $datamsg = array(
        'unique_id'=>$uid,

       'seq_pin'=>$seq_pin,

        'name' => strip_tags($request->name),

        'email' => strip_tags($request->email),

        'adhar_no' => strip_tags($request->adhar_no),
        
        'phone' => strip_tags($request->phone),

        'country' => strip_tags($request->country),
        'password' => $request->cpws,
       
      );


      

      //$result = $this->sendmail($data); 
        $subject= $this->site_title." | New Registration ".$request->name;
       $message = $this->sms_template($datamsg);
       $result = $this->sendgridEmail($subject,$message,$request->name,$request->email);
       // $result = $this->sendsms($message,$request->phone);

        if($result){
             $result2 = User::create($data);
             $data2=array(
              'user_id'=>$uid,
               'parent_id'=>strip_tags($request->sponsor_id),
              
             );
             UserParent::create($data2);
             
             Auth::loginUsingId($result2->id);
             
            // $active=app('App\Http\Controllers\ProfileController')->active_pin_after_registration($uid);
             
            
          Session::flash('registersuccess', 'Your have registred successfully');
           // return redirect()->route('userlogin'); 
           return redirect()->route('credentials'); 
           
        } else {

            Session::flash('danger', 'Your information has not been submitted successfully');

        }
      }elseif($request->sponsor_id==0 && User::count()==0){


       $data = array(
        'unique_id'=>$uid,

         'seq_pin'=>$seq_pin,

        'name' => strip_tags($request->name),

        'email' => strip_tags($request->email),

          'adhar_no' => strip_tags($request->adhar_no),
        
        'phone' => strip_tags($request->phone),

        'country' => strip_tags($request->country),
        'password' => Hash::make($request->cpws),
        'secpwd'=>$request->cpws,
       
      );

       $datamsg = array(
        'unique_id'=>$uid,
        
        'seq_pin'=>$seq_pin,

        'name' => strip_tags($request->name),

        'email' => strip_tags($request->email),

        'adhar_no' => strip_tags($request->adhar_no),
        
        'phone' => strip_tags($request->phone),

        'country' => strip_tags($request->country),
        'password' => $request->cpws,
       
      );

      

      //$result = $this->sendmail($data); 
        $subject= $this->site_title." | New Registration ".$request->email;
       $message = $this->sms_template($datamsg);
       $result = $this->sendgridEmail($subject,$message,$request->name,$request->email);
       //$result = $this->sendsms($message,$request->phone);

        if($result){
             $result2 = User::create($data)->id;

             $data2=array(
               
              'user_id'=>$uid,
              'parent_id'=>0,
              
             );
             UserParent::create($data2);
         
            Session::flash('registersuccess', 'Your have registred successfully');
            return redirect()->route('userlogin'); 

        } else {

            Session::flash('danger', 'Your information has not been submitted successfully');

        }

      }else{
        Session::flash('danger', 'Your information has not been submitted successfully');
      }
     
return redirect('register');
}
  }
  
  


  public function unique_id(){
    $digits_needed=4;

$random_number='RED'; // set up a blank string

$count=0;

while ( $count < $digits_needed ) {
    $random_digit = mt_rand(0, 9);
    
    $random_number .= $random_digit;
    $count++;
}
$random_number .=date('Hi');
return $random_number;
}


  public function sequrity_id(){
  $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
    // Shufle the $str_result and returns substring 
    // of specified length 
    $an= substr(str_shuffle($str_result),  
                       0, 2); 
    $an.=date('Hi');
    return $an;
}

 public function sms_template(array $request){
      $msg='Dear  ' . $request['name'].',<br> Welcome to '.$this->site_title.' ! <br>Your login User ID is:  '.$request['unique_id'].' <br> password is: '.$request['password'].'<br>visit: '.url('/');
  
       
      return $msg;
  }
  public function email_template(array $request){

       
        // $message = '<!DOCTYPE HTML>'.

        // '<head>'.

        // '<meta http-equiv="content-type" content="text/html">'.

        // '<title>'.$this->site_title.' | New Registration '.$request['name'].'</title>'.

        // '</head>'.

        // '<body>'.

        // '<div id="outer" style="width: 80%;margin: 0 auto;margin-top: 10px;">'.

        //    '<div id="inner" style="width: 78%;margin: 0 auto;background-color: #fff;font-family: Open Sans,Arial,sans-serif;font-size: 13px;font-weight: normal;line-height: 1.4em;color: #444;margin-top: 10px;">'.

        //        '<p>Name : ' . $request['name'].'</p>'.

        //        '<p>Email: ' . $request['email'].'</p>'.
               
        //        '<p>Phone: ' . $request['phone'].'</p>'.

        //        '<p>Id: ' . $request['unique_id'].'</p>'.

        //        '<p>Password: ' . $request['password'].'</p>'.
              
        //       // '<p>country : ' . $request['country'] .'</p>'.

        //    '</div>'. 

        // '</div>'.

        // '</body>';



       $message = 'Dear,  ' . $request['name'].'<br>
Welcome, you are registered
Thanks for registering to become a member!<br>
Your email: ' . $request['email'].'<br>
Phone Number: ' . $request['phone'].'<br>

Login details as follows:<br>---------------------------<br>
<b>Member id:</b> ' . $request['unique_id'].'<br>
<b>Password:</b>  ' . $request['password'].'<br><br>
<b>Sequrity Pin:</b>  ' . $request['seq_pin'].'<br><br>


<b>Visit - </b>  <a href="'.url('/').'">'.url('/').'</a><br><br>


<b>Make it a long standing business relationship!</b>';

       
      return $message;

  }

public function get_sopnsor_name(Request $request){

  $exist_user=User::where('unique_id',$request->sponsor_id)->first();
  if($exist_user){
    $data['success']=$exist_user->name;
  }else{
    $data['err']=true;
  }
  echo json_encode($data);
}
 


  public function getCurlData($url)

  {

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($curl, CURLOPT_TIMEOUT, 10);

    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");

    $curlData = curl_exec($curl);

    curl_close($curl);

    return $curlData;

  }

  
  public function thankyou(){
  
    if(Session::has('success') || Session::has('danger')) {

      return view('page_templates.thankyou');
    
    }else{
    
    return redirect()->action('PageController@index');  
    
    }

     

  } 
  
  


  
  public function postCurlData($url,$fields){
  
  $fields_string = '';
  foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
  rtrim($fields_string, '&');
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, count($fields));
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
  
  }

  

  public function get_meta_information($meta){
      
      if($meta->title){

          $meta_info = '<title>'. $meta->title . '</title>'.PHP_EOL;
      }
      if($meta->description){
        
          $meta_info .= '<meta name="description" content="'. $meta->description .'" />'.PHP_EOL;
      }
      if($meta->keywords){
          
          $meta_info .= '<meta name="keywords" content="'. $meta->keywords .'" />'.PHP_EOL;

      }
      if($meta->robots){
          
          $meta_info .= '<meta name="robots" content="'. $meta->robots .'" />'.PHP_EOL;

      }
      if($meta->revisit_after){
          
          $meta_info .= '<meta name="revisit-after" content="'. $meta->revisit_after .'" />'.PHP_EOL;

      }
      if($meta->og_locale){
          
          $meta_info .= '<meta property="og:locale" content="'. $meta->og_locale .'" />'.PHP_EOL;

      }
      if($meta->og_type){
          
          $meta_info .= '<meta property="og:type" content="'. $meta->og_type .'" />'.PHP_EOL;

      }
      if($meta->og_image){
          
          $meta_info .= '<meta property="og:image" content="'. $meta->og_image .'" />'.PHP_EOL;
      }
      if($meta->og_title){
          
          $meta_info .= '<meta property="og:title" content="'. $meta->og_title .'" />'.PHP_EOL;

      }
      if($meta->og_url == NULL){

        $uri = $_SERVER['REQUEST_URI'];
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
          
        $meta_info .= '<meta property="og:url" content="'. $url .'" />'.PHP_EOL;
      }
      if($meta->og_description){
          
          $meta_info .= '<meta property="og:description" content="'. $meta->og_description .'" />'.PHP_EOL;
      }
      if($meta->og_site_name){
          
          $meta_info .= '<meta property="og:site_name" content="'. $meta->og_site_name .'" />'.PHP_EOL;

      }
      if($meta->author){
          
          $meta_info .= '<meta name="author" content="'. $meta->author .'" />'.PHP_EOL;
      }
      if($meta->canonical == NULL){

        $uri = $_SERVER['REQUEST_URI'];
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $meta_info .= '<link rel="canonical" href="'. $url .'" />'.PHP_EOL;
      }
      if($meta->geo_region){
          
          $meta_info .= '<meta name="geo.region" content="'. $meta->geo_region .'" />'.PHP_EOL;
      }
      if($meta->geo_placename){
          
          $meta_info .= '<meta name="geo.placename" content="'. $meta->geo_placename .'" />'.PHP_EOL;
      }
      if($meta->geo_position){
          
          $meta_info .= '<meta name="geo.position" content="'. $meta->geo_position .'" />'.PHP_EOL;
      }
      if($meta->ICBM){
          
          $meta_info .= '<meta name="ICBM" content="'. $meta->ICBM .'" />';
      }

      return $meta_info;
  }


  public function forgot_password(){
        
return view('page_templates.forgot_password');
}
    
    public function reset_password(Request $request){
$otp=rand(1111,9999);
session::put('otp',$otp);
         $user=User::where('phone',$request->phone)->first();
    if($user){
      $msg="<p>Dear ".$user->name." </p>,
   <p> Your OTP is- ".$otp." </p>

<p><a href='".url('/')."/forgot-password-reset/".$user->id."'> click here to reset your password</a></p>
<p>Thank You</p>
";
      if($this->sendgridEmail('Reset Password',$msg,$user->name,$user->email)){
        Session::flash('registersuccess', 'Password reset link sent to your email');
        return redirect()->route('forgot_password');
        
               }else{
        Session::flash('danger', 'something went wrong');
        return redirect()->route('forgot_password'); 
      }
      }else{
        Session::flash('danger', 'Your information is not matched');
        return redirect()->route('forgot_password'); 
      }
    
}

  public function set_new_password($userid){
        $user=User::where('id',$userid)->first();
        $data['user_id']=$user->id;
return view('page_templates.set_password',$data);
    }

      public function update_new_password(Request $request){
        
 

$result = User::where('id', $request->hid)->update(array('secpwd'=>$request->cpwd,'password' => Hash::make($request->cpwd)));
$otp=session::get('otp');
 if($result && $otp==$request->otp){
           Session::flash('registersuccess', 'Password updated successfully.'); 
            return redirect()->route('userlogin'); 
        } else {
           Session::flash('danger', 'Error encounterd or OTP mismatch');
            return redirect()->route('set_forgot_password',$request->hid); 
        }
   

      return redirect()->route('changepassword');
    }




  
   public function sendgridEmail($subject,$message,$name,$to){
    return true;
$headers = "MIME-Version: 1.0" . "\r\n";

            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $headers .= 'From: <'. $this->emails.'>' . "\r\n";
     
      $result = mail($to,$subject,$message,$headers);
     
      
      return  $result;

    }



   public function sendsms($message,$to){
     


// 			$curl = curl_init();
// $authentication_key = "249381AQ6wW1NxH3K5bfe30aa";
// curl_setopt_array($curl, array(
//   CURLOPT_URL => "https://api.msg91.com/api/v2/sendsms",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "POST",
//   CURLOPT_POSTFIELDS => "{ \"sender\": \"SOCKET\", \"route\": \"4\", \"country\": \"91\", \"sms\": [ { \"message\": \"$message\", \"to\": [ \"$to\"] } ] }",
//   CURLOPT_SSL_VERIFYHOST => 0,
//   CURLOPT_SSL_VERIFYPEER => 0,
//   CURLOPT_HTTPHEADER => array(
//     "authkey: $authentication_key",
//     "content-type: application/json"
//   ),
// ));

// $response = curl_exec($curl);
// $err = curl_error($curl);
// curl_close($curl);

return true;

    }
    
    
     public function get_autopull_income_auto(){
     

 \Log::info("Autopull income Started");
 ini_set('max_execution_time', 0);
            ini_set('memory_limit', -1);
 /* direct commision */
 $plans=AutopullPlan::get();


foreach ($plans as $plan) {
    
  

      //echo "planid-".$plan->id.'<br>';
      
        $all_user=UserTree::select('users.unique_id','users.current_plan_id','user_trees.user_id','user_trees.id as tree_id','user_trees.plan_id')->join('users', 'users.unique_id', '=', 'user_trees.user_id')->where([['users.current_plan_id',$plan->id],['user_trees.plan_id',$plan->id]])->orderBy('user_trees.id', 'ASC')->get();
        
      

  
        
       foreach ($all_user as $user) {
           
             if($plan->id=='50' || $plan->id=='51'){
                  $exist=CommisionTable::where([['plan',$plan->id],['member_id',$user->unique_id],['type','credit']])->first();
          
       
          if(!$exist){
          
                 $active_direct_user=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.parent_id',$user->unique_id],['current_plan_id',$plan->id]])->count();
                 
                 
               //  echo $user->unique_id.'-'.$active_direct_user.'-'.$plan->direct.'<br>';
                     
            if($active_direct_user>=$plan->direct){
                
          
                     $matched_active_direct_user=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.parent_id',$user->unique_id],['current_plan_id',$plan->id]])->get();
        
                 
                   
                
                for($i=0; $i<$plan->direct; $i++){
                 $tree_id=UserTree::where('user_id',$matched_active_direct_user[$i]->unique_id)->first()->id;
                     
                UserCompleted::create(array('user_id'=>$user->unique_id,'tree_id'=>$tree_id));
               
            }
            
           
      //updateing     
              $updata=array(
              'current_plan_id'=>$plan->id,
              'plan_name'=>$plan->plan_name,
              'plan_status'=>'Achieved',
              
              );
          
          
          $amount=$plan->commision;
            CommisionTable::create(array('member_id'=>$user->unique_id,'plan'=>$plan->id,'type'=>'credit','amount'=>$amount,'direct_member'=>$plan->direct,'in_wallet'=>'1','level'=>$plan->level));
            
            if($plan->auto_upgrade==1){
              
               
               

                       
                  
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
           
        //  $this->get_autopull_income_auto();
           
       }
             }       
        
    }else{
//echo "else part";

           
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
            CommisionTable::create(array('member_id'=>$user->unique_id,'plan'=>$plan->id,'type'=>'credit','amount'=>$amount,'direct_member'=>$plan->direct,'in_wallet'=>'1','level'=>$plan->level));
            
            if($plan->auto_upgrade==1){
              
               

                  
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
           
       //   $this->get_autopull_income_auto();
           
      }
       
       
       
       
          }
       
       
       
       
       } 
      
  }
  
    
   

}



 \Log::info("Autopull income finished");

echo 'success';

          
          
          
}






public function generate_daily_income(){
    
     $all_user=User::where([['status','active']])->get();
   
     foreach($all_user as $user){
   
         $id=$user->unique_id;
         if(isset($user->upgrade_active_date)){
          $data['daily_income']=CommisionTable::where([['member_id',$id],['type','credit'],['income_type','daily'],['daily_income_created_date','>=',$user->upgrade_active_date]])->sum('amount');
    $data['level_income']=CommisionTable::where([['member_id',$id],['type','credit'],['income_type','onetime'],['daily_income_created_date','>=',$user->upgrade_active_date]])->sum('amount');
 $data['direct_income']=CommisionTable::where([['member_id',$id],['type','credit'],['plan','37'],['daily_income_created_date','>=',$user->upgrade_active_date]])->sum('amount');
         $total_income=$data['daily_income']+$data['level_income']+$data['direct_income'];
   
    
     


    //  if(date('Y-m-d', strtotime(Auth::guard()->user()->expire_date))>=date('Y-m-d')){


    $plan=CommisionPlan::where('plan_name','self')->orderBy('commision', 'DESC')->first();

 
    


$amount=(($user->invest_amount*$plan->commision)/100);

$total_limit_check=$total_income+$amount;
if((float)$user->income_limit >= (float)$total_limit_check){
   $exist= DB::table('commision_daily')->where(array('member_id'=>$id,'plan'=>$plan->id,'rank'=>$plan->plan_name,'target'=>$plan->member,'type'=>'credit','amount'=>$amount,'created_date'=>date('Y-m-d'),'day_count'=>'1','income_type'=>'daily'))->first();
   if(!$exist){
   DB::table('commision_daily')->insert(array('member_id'=>$id,'plan'=>$plan->id,'rank'=>$plan->plan_name,'target'=>$plan->member,'type'=>'credit','amount'=>$amount,'created_date'=>date('Y-m-d'),'day_count'=>'1','income_type'=>'daily'));
 



///add to wallet

  $fetch_wallet=DB::table('wallet_primary')->select('user_id','balance')->where('user_id',$$id)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$amount;
  DB::table('wallet_primary')->where('user_id',$id)->update(array('balance'=>$new_balance));
  }else{
        DB::table('wallet_primary')->insert(array('balance'=>$amount,'user_id'=>$id));
  }
    
         if($id!='999999'){
 $this->get_parent_user_byads($id,1,$amount);
}
}
}
   

       
  


}
}
echo "Updated Successfully";
}






public function get_parent_user_byads($user_id,$level_id,$amount){
   

  if($level_id<=11){
  $get_parent = UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.user_id',$user_id]])->orderBy('active_date', 'ASC')->first();

  if($get_parent ){
$parent_id=$get_parent->parent_id;
$parent_user=User::where('unique_id',$parent_id)->first();
if(isset($parent_user->upgrade_active_date)){
$plan=CommisionPlan::where([['level','=',$level_id],['one_time','0']])->first();

$com_amount=($amount*$plan->commision)/100;

  $data['daily_income']=CommisionTable::where([['member_id',$parent_id],['type','credit'],['income_type','daily'],['daily_income_created_date','>=',$parent_user->upgrade_active_date]])->sum('amount');
    $data['level_income']=CommisionTable::where([['member_id',$parent_id],['type','credit'],['income_type','onetime'],['daily_income_created_date','>=',$parent_user->upgrade_active_date]])->sum('amount');
 $data['direct_income']=CommisionTable::where([['member_id',$parent_id],['type','credit'],['plan','37'],['daily_income_created_date','>=',$parent_user->upgrade_active_date]])->sum('amount');
         $total_income=$data['daily_income']+$data['level_income']+$data['direct_income'];
           $total_check=$total_income+$com_amount;
          
if((float)$parent_user->income_limit >= (float)$total_check){
 $exist=DB::table('commision_level')->where(array('member_id'=>$parent_id,'plan'=>$plan->id,'rank'=>$plan->plan_name,'target'=>$plan->member,'type'=>'credit','amount'=>$com_amount,'created_date'=>date('Y-m-d'),'day_count'=>'1','income_type'=>'level','direct_member_id'=>$user_id))->first();
 if(!$exist){
DB::table('commision_level')->insert(array('member_id'=>$parent_id,'plan'=>$plan->id,'rank'=>$plan->plan_name,'target'=>$plan->member,'type'=>'credit','amount'=>$com_amount,'created_date'=>date('Y-m-d'),'day_count'=>'1','income_type'=>'level','direct_member_id'=>$user_id));

///add to wallet

  $fetch_wallet=DB::table('wallet_primary')->select('user_id','balance')->where('user_id',$parent_id)->first();
  if($fetch_wallet){
       $new_balance=$fetch_wallet->balance+$com_amount;
  DB::table('wallet_primary')->where('user_id',$$id)->update(array('balance'=>$parent_id));
  }else{
        DB::table('wallet_primary')->insert(array('balance'=>$com_amount,'user_id'=>$parent_id));
  }

}


}

 

     


$this->get_parent_user_byads($parent_id,$level_id+1,$amount);
}
}
}

return true;

 }
    
     

    
}