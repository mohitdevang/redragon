@extends('layouts.main')
@section('title') Pages @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             Content <small> Overview</small>{{--<a onclick="return confirm('Are you sure you want delete all the records of the table?');" class="btn btn-inverse pull-right" href="route('admin.pages.delete.all')">Delete All</a>--}}
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Manage File Content <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                   

  <div class="alert alert-info" style="display: none">Updated Successfully<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>

   <div class="alert alert-danger" style="display: none">Error<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>

<form role="form" name="content_form" id="content_form" method="post" enctype="multipart/form-data">

{{ csrf_field() }}

  <link rel="stylesheet" href="<?php echo url('/');?>/public/admin-design/css/codemirror.css">
  <link rel="stylesheet" href="<?php echo url('/');?>/public/admin-design/css/show-hint.css">

<label class="form-label">Select File</label>
<select onchange="get_file()" id="cfile" name="cfile" class="form-control">
    <option value="">Select</option>

  <option value="css">Style.css</option>
  
<!-- only for view folder -->
<option value="elements@header&">Header</option>
<option value="elements@footer&">Footer</option>
<option value="layouts@front&">Front</option>

<option value="page_templates@blog-detail&">Blog-Detail</option>
<option value="page_templates@blog&">Blog</option>
<option value="page_templates@category&">Category</option>
<option value="page_templates@contact&">Contact</option>
<option value="page_templates@default&">Default</option>
<option value="page_templates@full-width&">Full-Width</option>
<option value="page_templates@home&">Home</option>
<option value="page_templates@thankyou&">ThankYou</option>
<option value="errors@404&">Error 404</option>
<option value="errors@503&">Error 503</option>





  </select>

  <input type="hidden" name="hpath" id="hpath">

  <textarea id="code" name="code">

<?php


//echo file_get_contents(url('/').'/public/design/css/style.css');

?>

</textarea>
<br>

    

     <button type="button"  onclick="save_content()" class="btn btn-info btn-rounded">Save Content</button>
</form>

<script src="<?php echo url('/');?>/public/admin-design/js/codemirror.js"></script>
<script src="<?php echo url('/');?>/public/admin-design/js/css.js"></script>
<script src="<?php echo url('/');?>/public/admin-design/js/show-hint.js"></script>
<script src="<?php echo url('/');?>/public/admin-design/js/css-hint.js"></script>


    <script>
      var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
      extraKeys: {"Ctrl-Space": "autocomplete"},
       lineNumbers: true,
    gutter: true,
    lineWrapping: true,
    
    });



      function  get_file() {
       editor.setValue('');
       var token = $('input[name="_token"]').val();
      var content =$('#cfile').val()

        $.ajax({
    type: 'post',
    url: '{{ route('admin.content.getcontent')}}',
    data : {'_token': token,'content':content,},
   dataType: 'JSON',
    success :  function(response){
                
                   if(response.getcontent){
                    alert();
                 editor.setValue(response.getcontent);
                 $('#hpath').val(response.path);
                     
                   } 
                }
});
        
  

      }



       function save_content(){
        
       var token = $('input[name="_token"]').val();
      var content = editor.getValue();
      var path=$('#hpath').val();

        $.ajax({
    type: 'post',
    url: '{{ route('admin.content.save')}}',
    data : {'_token': token,'code':content,'hpath':path},
   dataType: 'JSON',
    success :  function(response){
                
                   if(response.success){
                    alert('updated Successfully');
$('.alert-info').show();
                     
                   } else{
                    $('.alert-danger').show();

                   }
                }
});


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
