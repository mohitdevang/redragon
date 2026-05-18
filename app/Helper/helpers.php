<?php 

use App\Models\Category;
use App\Models\PostCategoryRelationship;

use App\Models\PostMeta;
use App\Models\Menu;
use App\Models\NewMenuItem;
use App\Models\Widget;
use App\Models\User;
use App\Models\UserParent;
use App\Models\CommisionTable;
use App\Models\UserTree;

function generateBreadcrumb(){

for($i = 1; $i <= count(Request::segments()); $i++):?>
    <li>
        <?= Request::segment($i); ?>
    </li>
<?php endfor;

}



function get_package_details($id){
   $post = DB::table('package')->select('package_name')->where('id',$id)->first(); 
   return $post ? $post->package_name : '';
}


function f_generateBreadcrumb(){?>
    <li class="thm-breadcrumb__item"><a href="<?php echo url('/');?>">
        &nbsp;Home 
    </a></li>
<?php for($i = 1; $i <= count(Request::segments()); $i++):
if($i>=count(Request::segments())){?>
<li class="thm-breadcrumb__item"> 

   <?php $post_type = check_post_type(Request::segment($i));
              if($post_type == 'post' || $post_type == 'page'){
                $t = get_post_title_by_slug(Request::segment($i));
              }else{
                $t = get_cat_title_by_slug(Request::segment($i));
              }
        ?>
        <?= $t ?>
    </li>




<?php } else {?>
  <li class="thm-breadcrumb__item"> <a href="<?php echo url('/').'/'.Request::segment($i);?>"> 

       <?php $post_type = check_post_type(Request::segment($i));
              if($post_type == 'post' || $post_type == 'page'){
                $t = get_post_title_by_slug(Request::segment($i));
              }else{
                $t = get_cat_title_by_slug(Request::segment($i));
              }
        ?>
        <?= $t ?>
   </a></li>

<?php } ?>

  
        
       
<?php endfor;

}




function get_investement($id){
  $investment=DB::table('user_invest_amt')->where('user_id',$id)->sum('amount') ?? 0;
   return $investment;
}



function get_user_details($id){
   $post = User::select('name')->where('unique_id',$id)->first(); 
   return $post ? $post->name : '';
}





function get_cat_id_by_slug($slug){
   $category = Category::select('id')->where('slug',$slug)->first(); 
   return $category ? $category->id : NULL;
}

function get_post_meta($post_id,$meta_key){
  if( $post_meta = PostMeta::select('meta_value')->where([['post_id', $post_id],['meta_key', $meta_key]])->first()){

$short_code = array();
$replace   = array();

 $widgets = Widget::get();
      foreach ($widgets as $wid) {
        $short_code[]='['.$wid->title.']';
        $replace[]=$wid->content;          
      }
$content=str_replace($short_code, $replace, $post_meta->meta_value);

  }
  else{
    $content='';
  }
   return $content ? $content : '';
  
}



function get_menu_title($id){
   $menu = NewMenuItem::select('item_name')->where('id',$id)->first(); 
   return $menu ? $menu->item_name : '';
}


function check_post_meta($post_id,$meta_key){
   $post_meta = PostMeta::select('meta_value')->where([['post_id', $post_id],['meta_key', $meta_key]])->first(); 
   return $post_meta ? true : false;
}

function fetchCategoryTreeList($parent = 0, $category_tree_array = '') {

    if (!is_array($category_tree_array))
    $category_tree_array = array();

  $categories = Category::where('parent', '=', $parent)->select('id', 'title', 'parent')->get();
  $category_items = Category::where('parent', $parent)->count();
 
  if ($category_items > 0) {
     $category_tree_array[] = "<ul>";
   foreach($categories as $category){
	  $category_tree_array[] = "<li>". $category->title."</li>";
      $category_tree_array = fetchCategoryTreeList($category->id, $category_tree_array);
    }
	$category_tree_array[] = "</ul>";
  }
  return $category_tree_array;
}

function get_categories_listing($parent = 0, $title='', $spacing = '', $cat = array()) {
        
        $categories = Category::where('parent', '=', $parent)->select('id', 'title', 'post_status')->orderBy('id', 'asc')->get();
        foreach ($categories as $category) {
            $cat_temp = array();
            $cat_temp['id'] = $category->id;
            $cat_temp['post_status'] = $category->post_status;
            $cat_temp['title'] = $spacing . $category->title;
            $cat_temp['post_count'] = PostCategoryRelationship::where('category_id', $category->id)->count();
            if($parent == 0) {
                $cat_temp['cat_tree'] = $title . $category->title;
            } else {
                $cat_temp['cat_tree'] = $title . ' <i class="fa fa-arrow-right" aria-hidden="true"></i> ' . $category->title;
            }
            
            $cat[] = $cat_temp;
            $cat = get_categories_listing($cat_temp['id'], $cat_temp['cat_tree'], $spacing, $cat);
        }

        return $cat;
    
    }

function fetchCategoryTree($parent = 0, $spacing = '', $category_tree_array = '') {

  if (!is_array($category_tree_array))
  $category_tree_array = array();
  $categories = Category::where('parent', '=', $parent)->select('id', 'title', 'parent')->get();
  $category_items = Category::where('parent', $parent)->count();
  if ($category_items > 0) {
    foreach($categories as $category){
      $category_tree_array[] = array("id" => $category->id, "title" => $spacing . $category->title);
      $category_tree_array = fetchCategoryTree($category->id, $spacing . '&nbsp;&nbsp;&nbsp;&nbsp;', $category_tree_array);
    }
  }
  return $category_tree_array;
}


function header_menu($parent = 0, $page_tree_array = '', $count = 0) {



    if (!is_array($page_tree_array))

    $page_tree_array = array();



   $menus= DB::table('menus')->join('posts', function ($join) {

            $join->on('menus.post_id', '=', 'posts.id')->where([['posts.post_type','page'],['posts.status', 1]]);

            })->select('posts.title', 'posts.slug', 'menus.parent_page','menus.post_id','posts.slug_status')

           ->where([['menus.parent_page', '=', $parent],['menus.flag', '=', 0]])->orderBy('menu_order', 'asc')->get();

    

   $sub_items = DB::table('menus')->join('posts', function ($join) {

            $join->on('menus.post_id', '=', 'posts.id')->where([['posts.post_type','page'],['posts.status', 1]]);

            })->select('posts.title', 'posts.slug', 'menus.parent_page','menus.post_id','posts.slug_status')

           ->where([['menus.parent_page', '=', $parent],['menus.flag', '=', 0]])->count();

 

  if ($sub_items > 0) {
	 
	  if($parent == 0){
		$page_tree_array[] = "<ul class='nav navbar-nav main-nav-menu xs-bt nav-fill'>";
	  }else{
	  	$page_tree_array[] = "<ul class='dropdown-menu dropdown-main'>";
	  }
     

   foreach($menus as $menu){

       $sub_items1 = DB::table('menus as a')->join('menus as b', function ($join) use($menu) {

            $join->on('a.post_id', '=', 'b.parent_page')->where('b.parent_page', '=', $menu->post_id);

            })->count();

       if($sub_items1 == 0) {

            $page_tree_array[] = "<li class='nav-item'><a class='nav-link' href='".url($menu->slug)."'><img src='".get_post_meta($menu->post_id,'menu-icon')."'><span>". $menu->title."</span></a>"; 

       }else{
	   
	      $url = ($menu->slug_status == 1)? url( $menu->slug ) : 'javascript:void(0)';
			
			if($menu->parent_page == 0){
				$li_items  = "<li class='nav-item dropdown'><a class='nav-link dropdown-toggle' href='".$url."' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><img src='".get_post_meta($menu->post_id,'menu-icon')."'><span>".$menu->title."</span></a>";
			}else{
				$li_items = "<li><a href='".url($menu->slug)."'>". $menu->title."</a>";
			}

          $page_tree_array[] = $li_items;

       }          

      

      $page_tree_array = header_menu($menu->post_id, $page_tree_array,$count);

    }

	$page_tree_array[] = "</li></ul>";

  }

  return  $page_tree_array;

}

function get_menu($id){

 $result= DB::table('new_menu_items')->where([['menu_id',$id],['parent','0']])->get(); 
 return $result->first() ? $result : null;
}

function get_sub_menu($parent_id){

  $result= DB::table('new_menu_items')->where('parent',$parent_id)->get(); 
  return $result->first() ? $result : null;
}


function get_menu_tree($parent_id,$menu_id) 
{
 
 $menu = "";

 
  $sqlquery = NewMenuItem::where([['parent', $parent_id],['menu_id',$menu_id]])->orderBy('menu_order', 'asc')->get();
foreach($sqlquery as $menus){
  if($menus->page_id!='0'){
    $page_link=get_permalink($menus->page_id);
  }
  else {
     $page_link=$menus->custom_url;
  }

        $check_submenu=NewMenuItem::where([['parent', $menus->id],['menu_id',$menu_id]])->get();
        
        if(isset($check_submenu[0]->id) && $parent_id=='0'){ ////////this is for parent menu with submenu ...
        $li_class='dropdown';
        $a_all='';
        $span='<span class="caret"></span>';
        $toogle_button='<span class="caret-mb dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"></span>';
       }
       else if(isset($check_submenu[0]->id) && $parent_id!='0'){ ////////this is for parent menu Under a submenu ...
        $li_class='dropdown';
        $a_all='';
        $span='';
        $toogle_button='<span class="caret-mb multiC"></span>';
        }

        else if($parent_id=='0'){ ////////////////////////this is for only parent menu...
        $li_class='sbc';
        $a_all='';
         $span='';
 $toogle_button='';
        } 
      else{                         ////////////////////////this is for child menu....
        $li_class='';
        $a_all='';
         $span='';
 $toogle_button='';

        }

     $menu .="<li class='".$li_class."'><a ".$a_all." href='".$page_link."'>".$menus->item_name. $span."</a>".$toogle_button;
              
      if(get_menu_tree($menus->id,$menu_id)){
       $menu .= "<ul class='dropdown-menu sub-menu'>".get_menu_tree($menus->id,$menu_id)."</ul>"; //call  recursively
     }
       
       $menu .= "</li>";
 
    }
    
    return $menu;
} 

function with_short_code($shortcode_content){


$short_code = array();
$replace   = array();

 $widgets = Widget::get();
      foreach ($widgets as $wid) {
        $short_code[]='['.$wid->title.']';
        $replace[]=$wid->content;          
      }
$content=str_replace($short_code, $replace, $shortcode_content);

  
   return $content ? $content : '';
  
}


     function get_direct_member($id){
     
       $direct_user= UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['parent_id',$id],['status','!=','inactive'],['upgrade_status',1]])->count();
        
          return $direct_user ? $direct_user : '0';
    }


function display_children($parent, $level) 
{

 // $result = mysqli_query('SELECT * FROM user_parents WHERE parent_id="'.$parent.'"');
  $count = array(0=>0);
 //  while ($row = mysqli_fetch_array($result))
 //   {


  $get_user= UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.parent_id',$parent],['status','!=','inactive'],['expire_date','>=',date('Y-m-d')]])->get();

   foreach ($get_user as $user) {



    $data=  str_repeat(' ',$level). $user->user_id."\n";
   // echo $data;
    $count[0]++;
    $children= display_children($user->user_id, $level+1);
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
    return $count; 
 }




 
 
 
 
 function display_children_all($parentId, $level = 1, &$s = 1)
{
    // Limit depth if necessary
    if ($level > 15) {
        return;
    }

    // Fetch direct children once
    $children = UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')
        ->where('user_parents.parent_id', $parentId)
        ->select('users.*') // Only fetch needed columns
        ->get();

    foreach ($children as $child) {
        // Render table row
        echo '<tr>
                <td>' . $s++ . '</td>
                <td>Level-' . $level . '</td>
                <td>' . e($child->name) . '</td>
                <td>' . e($child->unique_id) . '</td>
                <td>' . get_total_investment($child->unique_id) . '</td>
                <td>' . date('d-m-Y h:i a', strtotime($child->created_at)) . '</td>
                <td>' . ($child->status === 'active' ? date('d-m-Y h:i a', strtotime($child->active_date)) : '') . '</td>
                <td>' . e($child->country) . '</td>
                <td>' . ($child->status === 'active'
                    ? '<span class="btn btn-success">Active</span>'
                    : '<span class="btn btn-danger">Inactive</span>') . '</td>
              </tr>';

        // Recursive call for this user's downline
        display_children_all($child->unique_id, $level + 1, $s);
    }
}
 
 
function get_total_investment($user_id){

$userIncomes = DB::table('user_invest_amt')
    ->where('user_id', $user_id)
    ->sum('amount');

return $userIncomes;

       
}

function get_active_child($parent_id){
    
    $result=UserParent::join('users','user_parents.user_id', '=','users.unique_id')->where([['users.status','active'],['user_parents.parent_id',$parent_id]])->count();
    
    return $result;
}

function get_level_member($plan_id,$user_id){
    
       $number_of_user=0;

       if($plan_id==50 || $plan_id==51){
         $number_of_user=UserParent::join('users', 'users.unique_id', '=', 'user_parents.user_id')->where([['user_parents.parent_id',$user_id],['current_plan_id',$plan_id]])->count();
       }
       else{
       
        $all_user=UserTree::where([['plan_id',$plan_id],['user_id',$user_id]])->first();
        if($all_user){
          $matched_user=DB::select('SELECT user_trees.* FROM user_trees WHERE plan_id='.$plan_id.'  and id > '.$all_user->id.'  ORDER BY user_trees.id ASC');
          
           $number_of_user=count($matched_user);
        }
    }

           return $number_of_user;
}


function get_commission_credit_details($plan_id,$user_id){
       
            $result=CommisionTable::where([['plan',$plan_id],['member_id',$user_id],['type','credit']])->first();
            return $result;
}
function get_commission_debit_details($plan_id,$user_id){
       
            $result=CommisionTable::where([['plan',$plan_id],['member_id',$user_id],['type','debit']])->first();
            return $result;
}

function get_commission_reward_details($plan_id,$user_id){
       
            $result=CommisionTable::where([['plan',$plan_id],['member_id',$user_id],['type','credit'],['rank','reward']])->first();
            if($result){
                $reward=$result->amount;
            }else{
                 $reward=0;
            }
            
            return $reward;
}


?>