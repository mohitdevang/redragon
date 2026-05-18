@extends('layouts.main')
@section('title') Pages @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             Menu Edit <small> Overview</small>{{--<a onclick="return confirm('Are you sure you want delete all the records of the table?');" class="btn btn-inverse pull-right" href="route('admin.pages.delete.all')">Delete All</a>--}}
                        </h1>
                        <ol class="breadcrumb">{{ generateBreadcrumb() }}<img class="pull-right ajax-loader" src="{!! asset('admin-design/images/btn-ajax-loader.gif') !!}" /></ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div id="info"></div>
                     @component('elements.admin.components.flash') @endcomponent 
                    </div>
                </div>

                
                
            <div class="parent-content-wrapper">
             <div id="content-sortable">    
              
                <div class="row">
                    <div class="col-lg-12">
                      <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Manage Menu <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                   

  <div class="alert alert-info" style="display: none">Updated Successfully<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>

   <div class="alert alert-danger" style="display: none">Error<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>



<form role="form" name="content_form" id="content_form" method="post" enctype="multipart/form-data">


{{ csrf_field() }}
<div class="row">
<div class="col-md-6 pr_5">
 <input type="text" name="menu_name" id="menu_name" class="form-control" value="{{$menu_name}}" disabled>
</div>
<div class="col-md-6 pl_5">

   <div id="manu_name_div"> <button type="button" class="btn btn-primary btn_edit" onclick="edit_menu_name()" ><i class="fa fa-pencil" aria-hidden="true"></i></button></div>
</div>
</div>
<div class="row" id="item" style="overflow-y: scroll;">
 <div class="col-sm-12">

<input type="hidden" name="hmenu_id" id="hmenu_id" value="{{$menu_id}}">

  <table class="table table-striped">
    <thead>
      
      <th>Select Page</th>
      <th>Name</th>
      <th>Menu Order</th>
      <th>css</th>
      <th>Parent</th>
      <th>Action</th>
    </thead>
    <tbody id="tbdy">
      <tr class="tr" id="tr_1">

     @php($slno=1)
        @foreach($all_menus as $menu)
   


        <td>
          <input type="hidden" name="row_menu_id_{{$slno}}" id="row_menu_id_{{$slno}}" value="{{$menu->id}}" >
          <select class="form-control ed" name="page_{{$slno}}" id="page_{{$slno}}" disabled="" onchange="check_custom(this.value,'{{$slno}}')"><option value="{{$menu->page_id}}">{{get_post_title($menu->page_id)?get_post_title($menu->page_id):'Custom URL'}}</option> 

            <?php if(isset($pages)){
            foreach ($pages as $rec) {
              if($menu->page_id!=$rec->id)
             echo '<option value="'.$rec->id.'">'.$rec->title.'</option>';
            }
          }
        ?>
        @if($menu->page_id!=0)
<option value="0">Custom URL</option>
@endif
        </select>
        @if($menu->custom_url!='' || $menu->custom_url!=NULL)
         <input type="text" name="custom_url_{{$slno}}" id="custom_url_{{$slno}}" class="form-control ed" value="{{$menu->custom_url}}" disabled>
         @else 
         <input type="hidden" name="custom_url_{{$slno}}" id="custom_url_{{$slno}}" class="form-control ed"  >
         @endif
      </td>

         <td><input type="text" name="item_name_{{$slno}}" id="item_name_{{$slno}}" class="form-control ed" value="{{$menu->item_name}}" disabled="">
         </td> 

         <td width="10%"><input type="number" name="item_order_{{$slno}}" id="item_order_{{$slno}}" class="form-control ed" value="{{$menu->menu_order}}" disabled=""></td>

          <td><textarea name="item_css_{{$slno}}" id="item_css_{{$slno}}" class="form-control ed" disabled="">{{$menu->css}}</textarea></td>

           <td><select class="form-control ed" name="parent_{{$slno}}" id="parent_{{$slno}}" disabled=""> <option value="{{$menu->parent}}">{{get_menu_title($menu->parent)}}</option> 

             <?php if(isset($parent)){
            foreach ($parent as $prec) {
             echo '<option value="'.$prec->id.'">'.$prec->item_name.'</option>';
            }
          }
        ?>

           </select></td>

            <td id="btn_{{$slno}}">
             <span id="edit_{{$slno}}"> <button type="button" class="btn btn-primary btn_edit" onclick="edit('{{$slno}}')" ><i class="fa fa-pencil" aria-hidden="true"></i></button></span>
             <span id="cancel_{{$slno}}"> <button type="button" class="btn btn-danger btn_dlt" onclick="remove('{{$menu->id}}}')" ><i class="fa fa-trash" aria-hidden="true"></i></button></span>
               </td> 

</tr>

       @php($slno++)
        
@endforeach
 <tr class="tr" id="tr_99">
<td><select class="form-control" name="page_99" id="page_99" onchange="check_custom(this.value,'99')">
          <option value="">Select</option>
          <?php if(isset($pages)){
            foreach ($pages as $rec) {
             echo '<option value="'.$rec->id.'">'.$rec->title.'</option>';
            }
          }
        ?>
        <option value="0">Custom URL</option>
        </select>
         <input type="hidden" name="custom_url_99" id="custom_url_99" class="form-control ed"  > 
      </td>

        <td><input type="text" name="item_name_99" id="item_name_99" class="form-control"></td>
        <td width="10%"><input type="number" name="item_order_99" id="item_order_99" class="form-control" value="0"></td>
        <td><textarea name="item_css_99" id="item_css_99" class="form-control"></textarea></td>
        <td><select class="form-control" name="parent_99" id="parent_99">
          <option value="0">Select</option>
           <?php if(isset($parent)){
            foreach ($parent as $prec) {
             echo '<option value="'.$prec->id.'">'.$prec->item_name.'</option>';
            }
          }
        ?>
       
        </select></td>
         <td id="btn_99"><button type="button" class="btn btn-success btn_add" onclick="add('99')" >Add </button>
</td>
      </tr>

    </tbody>


  </table>
 


</div>
 </div>






  
</form>




    <script>

      function edit(id){
       // alert(id);

       $('.btn_edit').prop('disabled',true);

        $('#edit_'+id).html('<button type="button" class="btn btn-success btn_add" onclick="update(\''+id+'\')" >Save</button>');
          $('#cancel_'+id).html('<button type="button" class="btn btn-danger btn_cancel" onclick="cancel(\''+id+'\')" ><i class="fa fa-times" aria-hidden="true"></i></button>');
        $('.ed').prop('disabled',true);
        $('#page_'+id).prop('disabled',false);
        $('#item_name_'+id).prop('disabled',false);
        $('#item_order_'+id).prop('disabled',false);
        $('#item_css_'+id).prop('disabled',false);
        $('#parent_'+id).prop('disabled',false);
        $('#custom_url_'+id).prop('disabled',false);

   var token = $('input[name="_token"]').val();
var menu_id = $('#hmenu_id').val();     

        $.ajax({
    type: 'post',
    url: '{{ route('admin.menu.getmenuparent')}}',
    data : {'_token': token,'hmenu':menu_id,'current_menu':$('#row_menu_id_'+id).val(),'parent_id':$('#parent_'+id).val()},
   dataType: 'JSON',
    success :  function(data){
                
                   if(data.option){
                    
                   
$('#parent_'+id).html('<option value="0">Select</option>'+data.option+' </select>');
                      // window.location.reload();
                   } 
                }
});



      }






// function add_nemu(){

// var token = $('input[name="_token"]').val();
// var menu_name = $('#nemu_name').val();

//         $.ajax({
//     type: 'post',
//     url: '{{ route('admin.menu.getmenu')}}',
//     data : {'_token': token,'menu_name':menu_name,},
//    dataType: 'JSON',
//     success :  function(data){
                
//                    if(data.success){
//                     $('#showdiv').show();
//                     $('#item').show();
//                      $('#adddiv').hide();
//                     $('#created_nemu').val(data.menu);
//                     $('#hmenu_id').val(data.menu_id);

                     
//                    } 
//                 }
// });
// }


function add(id){
var token = $('input[name="_token"]').val();
var page_id = $('#page_'+id).val();
var item_name = $('#item_name_'+id).val();
var item_order = $('#item_order_'+id).val();
var item_css = $('#item_css_'+id).val();
var parent = $('#parent_'+id).val();
var hmenu=$('#hmenu_id').val();
var customurl=$('#custom_url_'+id).val();
var s=parseInt(id)+1;

var t=1;

if(page_id==''){
  t=0;
  
}
if(page_id==0){
  if(customurl==''){
    t=0;
   
  }
}
if(item_name==''){
  t=0;
  
}
if(t==1){

        $.ajax({
    type: 'post',
    url: '{{ route('admin.menu.addmenu')}}',
    data : {'_token': token,'page_id':page_id,'item_name':item_name,'item_order':item_order,'item_css':item_css,'parent':parent,'hmenu':hmenu,'custom_url':customurl},
   dataType: 'JSON',
    success :  function(data){
                
                   if(data.option){
                    $('#btn_'+id).html('<span id="edit_'+id+'"> <button type="button" class="btn btn-primary btn_edit" onclick="edit(\''+id+'\')" ><i class="fa fa-pencil" aria-hidden="true"></i></button></span><span id="cancel_'+id+'"><button type="button" class="btn btn-danger btn_dlt" onclick="remove(\''+id+'\')" ><i class="fa fa-trash" aria-hidden="true"></i></button></span> <input type="hidden" name="row_menu_id_'+id+'" id="row_menu_id_'+id+'" value="'+data.insid+'" >');
                   
                     $('#tbdy').append('<tr class="tr" id=tr_'+s+'> <td><select class="form-control" name="page_'+s+'" id="page_'+s+'" onchange="check_custom(this.value,\''+s+'\')"> <option value="">Select</option> <?php if(isset($pages)){ foreach ($pages as $rec) { echo '<option value="'.$rec->id.'">'.$rec->title.'</option>'; } } ?> <option value="0">Custom URL</option></select> <input type="hidden" name="custom_url_'+s+'" id="custom_url_'+s+'" class="form-control ed" > </td> <td><input type="text" name="item_name_'+s+'" id="item_name_'+s+'" class="form-control"></td> <td width="10%"><input type="number" name="item_order_'+s+'" id="item_order_'+s+'" class="form-control"  value="0"></td> <td><textarea name="item_css_'+s+'" id="item_css_'+s+'" class="form-control"></textarea></td> <td><select class="form-control" name="parent_'+s+'" id="parent_'+s+'"> <option value="0">Select</option>'+data.option+' </select></td> <td id="btn_'+s+'"><button  type="button" class="btn btn-success btn_add" onclick="add(\''+s+'\')" >Add </button> </td> </tr> ');
                     //$('.ed').prop('disabled',true);

                      $('#page_'+id).prop('disabled',true);
        $('#item_name_'+id).prop('disabled',true);
        $('#item_order_'+id).prop('disabled',true);
        $('#item_css_'+id).prop('disabled',true);
        $('#parent_'+id).prop('disabled',true);
        $('#custom_url_'+id).prop('disabled',true);

                      //window.location.reload();
                   } 
                    if(data.same_menu){
                    alert(data.same_menu);

                   }

                   if(data.same_order){
                    alert(data.same_order);

                   }
                }
});
}
        else{
    alert('Page and Menu name field is required');
}

}





function update(id){
  
var token = $('input[name="_token"]').val();
var page_id = $('#page_'+id).val();
var item_name = $('#item_name_'+id).val();
var item_order = $('#item_order_'+id).val();
var item_css = $('#item_css_'+id).val();
var parent = $('#parent_'+id).val();
var row_menu_id=$('#row_menu_id_'+id).val();
var s=parseInt(id)+1;
var customurl=$('#custom_url_'+id).val();
var hmenu_id=$('#hmenu_id').val();

var t=1;

if(page_id==''){
  t=0;
  
}
if(page_id==0){
  if(customurl==''){
    t=0;
   
  }
}
if(item_name==''){
  t=0;
  
}
if(t==1){

        $.ajax({
    type: 'post',
    url: '{{ route('admin.menu.editmenu')}}',
    data : {'_token': token,'page_id':page_id,'item_name':item_name,'item_order':item_order,'item_css':item_css,'parent':parent,'row_menu_id':row_menu_id,'custom_url':customurl,'hmenu_id':hmenu_id},
   dataType: 'JSON',
    success :  function(data){
                
                   if(data.success){
                     $('.btn_edit').prop('disabled',true);
                   alert('Successfully updated');

                    $('#edit_'+id).html('<button type="button" class="btn btn-primary btn_edit" onclick="edit(\''+id+'\')" ><i class="fa fa-pencil" aria-hidden="true"></i></button>');
                    window.location.reload();

                   } 

                     if(data.same_menu){
                    alert(data.same_menu);

                   }

                   if(data.same_order){
                    alert(data.same_order);

                   }

                }
});

      }
      else{
        alert('Page and Menu name field is required');
      }

}



function remove(id){
 
var token = $('input[name="_token"]').val();
        $.ajax({
    type: 'post',
    url: '{{ route('admin.menu.deletemenu')}}',
    data : {'_token': token,'id':id},
   dataType: 'JSON',
    success :  function(data){
                
                   if(data.success){
                   alert('success');
                   window.location.reload();

                    
                   } 

                }
});




}


function check_custom(this_value,row_id){
  if(this_value==0){

    $('#custom_url_'+row_id).attr('type', 'text');

  }
  else{
     $('#custom_url_'+row_id).attr('type', 'hidden');
      $('#custom_url_'+row_id).val('');

  }
}




function edit_menu_name(){


  $('#menu_name').prop('disabled',false);
  $('#manu_name_div').html('<button  type="button" class="btn btn-success" onclick="change_menu_name()" >Save </button>');
   

}


function change_menu_name(){
   var token = $('input[name="_token"]').val();
          $.ajax({
    type: 'post',
    url: '{{ route('admin.menu.change_menu_name')}}',
    data : {'_token': token,'id':$('#hmenu_id').val(),'name':$('#menu_name').val()},
   dataType: 'JSON',
    success :  function(data){
                
                   if(data.success){
                     $('#manu_name_div').html('<button type="button" class="btn btn-primary btn_edit" onclick="edit_menu_name()" ><i class="fa fa-pencil" aria-hidden="true"></i></button>');
                     $('#menu_name').prop('disabled',true);

                   alert('Successfully updated');
                   window.location.reload();

                    
                   } 

                }
});


}

function cancel(id){
   $('.btn_edit').prop('disabled',false);

        $('#edit_'+id).html('<button type="button" class="btn btn-primary btn_edit" onclick="edit(\''+id+'\')" ><i class="fa fa-pencil" aria-hidden="true"></i></button>');
          $('#cancel_'+id).html(' <button type="button" class="btn btn-danger btn_dlt" onclick="remove(\''+id+'\')" ><i class="fa fa-trash" aria-hidden="true"></i></button>');
}


    </script>



                                  
                                    
                                  </div>
                            </div>
                     </div>
                  </div>
                </div>
                
                    
            </div>
            </div>
            </div>
            <!-- /.container-fluid -->

</div>
@endsection

@push('custom-js')



@endpush
