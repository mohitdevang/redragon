@extends('layouts.main')
@section('title') Pages @endsection
@section('content')




            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             Menu <small> Overview</small>{{--<a onclick="return confirm('Are you sure you want delete all the records of the table?');" class="btn btn-inverse pull-right" href="route('admin.pages.delete.all')">Delete All</a>--}}
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
<div class="row" id="adddiv" >
<div class="col-sm-4">
  <input type="text" name="nemu_name" id="nemu_name" class="form-control" placeholder="Menu Name" required>
</div>
<div class="col-sm-2">
<button type="button" class="btn btn-success btn_add" onclick="add_nemu()">Add </button>
</div>
</div>
<div class="row" id="showdiv" style="display: none;">
  <div class="col-sm-4">
  <input type="text" name="created_nemu" id="created_nemu" class="form-control" readonly="">
  
  <input type="hidden" name="hmenu_id" id="hmenu_id">

   </div>
</div>

<div class="row" id="item" style="display: none;overflow-y: scroll;">
 <div class="col-sm-12">


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
       
        <td><select class="form-control ed" name="page_1" id="page_1" onchange="check_custom(this.value,'1')">
          <option value="">Select</option>
          <?php if(isset($pages)){
            foreach ($pages as $rec) {
             echo '<option value="'.$rec->id.'">'.$rec->title.'</option>';
            }
          }
        ?>
        <option value="0">Custom URL</option>
        </select>
        <input type="hidden" name="custom_url_1" id="custom_url_1" class="form-control ed" > 
      </td>

        <td><input type="text" name="item_name_1" id="item_name_1" class="form-control ed"></td>
        <td width="10%"><input type="number" name="item_order_1" id="item_order_1" class="form-control ed" value="0"></td>
        <td><textarea name="item_css_1" id="item_css_1" class="form-control edl"></textarea></td>
        <td><select class="form-control ed" name="parent_1" id="parent_1">
          <option value="0">Select</option>
       
        </select></td>
         <td id="btn_1"><button type="button" class="btn btn-success btn_add" onclick="add('1')" >Add </button>
</td>

      </tr>

    </tbody>


  </table>
 


</div>
 </div>





  
</form>

<!-- <div id="app">
<p>Using mustaches: @{{ rawHtml }}</p>
<p>Using v-html directive: <span v-html="rawHtml"></span></p>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script >
  Vue.component('todo-item', {
  props: ['todoo'],
  template: '<li>@{{ todoo }}</li>'
})
var app = new Vue({
  el: '#app',
data: {
    groceryList: [
      { id: 0, text: 'Vegetables' },
      { id: 1, text: 'Cheese' },
      { id: 2, text: 'Whatever else humans are supposed to eat' }
    ]
  }
})
</script> -->




    <script>


function add_nemu(){

var token = $('input[name="_token"]').val();
var menu_name = $('#nemu_name').val();

        $.ajax({
    type: 'post',
    url: '{{ route('admin.menu.getmenu')}}',
    data : {'_token': token,'menu_name':menu_name,},
   dataType: 'JSON',
    success :  function(data){
                
                   if(data.success){
                    window.location.href='{{url("/")}}/admin/menu/edit/'+data.menu_id;

                    // $('#showdiv').show();
                    // $('#item').show();
                    //  $('#adddiv').hide();
                    // $('#created_nemu').val(data.menu);
                    // $('#hmenu_id').val(data.menu_id);


                     
                   } else{
                    alert('This menu name already exist, please try with another name');
                   }
                }
});
}


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
                     $('.ed').prop('disabled',true);
                    $('#btn_'+id).html('<span id="edit_'+id+'"><button type="button" class="btn btn-primary btn_edit" onclick="edit(\''+id+'\')" ><i class="fa fa-pencil" aria-hidden="true"></i></button></span><button type="button" class="btn btn-danger btn_dlt" onclick="remove(\''+data.insid+'\')" ><i class="fa fa-times" aria-hidden="true"></i></button><input type="hidden" name="row_menu_id_'+id+'" id="row_menu_id_'+id+'" value="'+data.insid+'" >');
                   
                     $('#tbdy').append('<tr class="tr" id=tr_'+s+'> <td><select class="form-control ed" name="page_'+s+'" id="page_'+s+'" onchange="check_custom(this.value,\''+s+'\')"> <option value="">Select</option> <?php if(isset($pages)){ foreach ($pages as $rec) { echo '<option value="'.$rec->id.'">'.$rec->title.'</option>'; } } ?> <option value="0">Custom URL</option></select><input type="hidden" name="custom_url_'+s+'" id="custom_url_'+s+'" class="form-control ed" > </td> <td><input type="text" name="item_name_'+s+'" id="item_name_'+s+'" class="form-control ed"></td> <td width="10%"><input type="number" name="item_order_'+s+'" id="item_order_'+s+'" class="form-control ed" value="0"></td> <td><textarea name="item_css_'+s+'" id="item_css_'+s+'" class="form-control ed"></textarea></td> <td><select class="form-control ed" name="parent_'+s+'" id="parent_'+s+'"> <option value="0">Select</option>'+data.option+' </select></td> <td id="btn_'+s+'"><button  type="button" class="btn btn-success btn_add" onclick="add(\''+s+'\')" >Add </button> </td> </tr>  ');

                    
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



 function edit(id){      
   $('.btn_edit').prop('disabled',true);

        $('#edit_'+id).html('<button type="button" class="btn btn-success btn_add" onclick="update(\''+id+'\')" >Save</button>');
        $('.ed').prop('disabled',true);
        $('#page_'+id).prop('disabled',false);
        $('#item_name_'+id).prop('disabled',false);
        $('#item_order_'+id).prop('disabled',false);
        $('#item_css_'+id).prop('disabled',false);
        $('#parent_'+id).prop('disabled',false);

           var token = $('input[name="_token"]').val();
          var menu_id = $('#hmenu_id').val();     

          $.ajax({
          type: 'post',
          url: '{{ route('admin.menu.getmenuparent')}}',
          data : {'_token': token,'hmenu':menu_id,'current_menu':$('#row_menu_id_'+id).val(),'parent_id':$('#parent_'+id).val()},
          dataType: 'JSON',
          success :  function(data){

          if(data.option){


          $('#parent_'+id).html('<option value="0">Select</option>'+data.option+' </select>')
          // window.location.reload();
          } 
          }
          });

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


        $.ajax({
    type: 'post',
    url: '{{ route('admin.menu.editmenu')}}',
    data : {'_token': token,'page_id':page_id,'item_name':item_name,'item_order':item_order,'item_css':item_css,'parent':parent,'row_menu_id':row_menu_id,'custom_url':customurl,'hmenu_id':hmenu_id},
   dataType: 'JSON',
    success :  function(data){
                
                   if(data.success){
                   alert('success');

                    $('#edit_'+id).html('<button type="button" class="btn btn-primary btn_edit" onclick="edit(\''+id+'\')" ><i class="fa fa-pencil" aria-hidden="true"></i></button>');
                    $('.btn_edit').prop('disabled',false);
                   // window.location.reload();

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



function remove(id){
 alert();
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
  }
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
