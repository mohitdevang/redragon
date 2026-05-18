@extends('layouts.app')
@section('title') Edit Post @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Edit <small> Post</small>
                        </h1>
                       <ol class="breadcrumb">{{ generateBreadcrumb() }}</ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                         @component('elements.admin.components.flash') @endcomponent 
                    </div>
                </div>
                
            <div class="parent-content-wrapper">
             <div id="content-sortable">    
                
               <div class="row">
                    <div class="col-lg-12">
                      <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-user"></i>
                                Edit Post
                                <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                            {!! Form::Model($post,['autocomplete'=>'off','files'=> true,'id'=>'post', 'method' => 'PATCH','route' => ['admin.post.update',$post->id]]) !!}
                                    @include('admin.posts._partials.form') 
                                    <div class="form-actions pull-right">
                                        {!! Form::button('<i class="fa fa-pencil"></i> Update',['name' => 'Submit', 'type' => 'submit', 'value' => 'update', 'class' => 'btn btn-info btn-rounded']) !!}
                                        {!! Form::button('<i class="fa fa-pencil"></i> Save & Continue Edit',['name' => 'Submit', 'type' => 'submit', 'value' => 'edit', 'class' => 'btn btn-info btn-rounded']) !!}
                                    </div>
                            {!! Form::close() !!}
                            </div>
                        </div>
                        
                    </div>
                </div> 
				
			   @include('admin.posts._partials.meta')
               @include('admin.posts._partials.multi_file_upload') 
			   @include('admin.posts._partials.meta_element')
                
                    
            </div>
            </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        
@endsection

@push('custom-css')

{!!Html::style('admin-design/css/ace.min.css')!!}

@endpush

@push('custom-js')


{!!Html::script('public/admin-design/js/ckeditor/adapters/jquery.js')!!}

{{---Slug----}}
<script>
function edit_slug(id){
value = $('#slug').val();
var token = $('input[name="_token"]').val();
$.ajax({
    type: 'put',
    url: '{{ route('admin.post.update.slug')}}',
    data : {'_token': token,'id':id,'value':value},
    success :  function(response){
                
                   if(response.status == true){
                   $('#slug').fadeOut(1000);
                     setTimeout( function(){
                   $('#slug-wrapper').load(location.href +  ' #slug-wrapper');
                   },800);
                   $('#slug').fadeIn(2000);
                     
                   } else {
                   $('#slug').fadeOut(1000);
                   setTimeout( function(){
                   $('#slug-wrapper').load(location.href +  ' #slug-wrapper');
                   },800);
                   $('#slug').fadeIn(2000);
                 
                   }
                }
});
}
</script>
{!!Html::script('public/admin-design/js/ace-elements.min.js')!!}
{!!Html::script('public/admin-design/js/ace.min.js')!!}
<script>
            $('#id-input-file-3').ace_file_input({
                style: 'well',
                btn_choose: 'Drop images here or click to choose',
                btn_change: null,
                no_icon: 'ace-icon fa fa-picture-o',
                droppable: true,
                thumbnail: 'small',
                whitelist_ext: ["jpeg", "jpg", "png", "gif", "bmp"],
                whitelist_mime: ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"],
                preview_error: function (filename, error_code) {
                }

            }).on('change', function () {
            });
</script>
{!!Html::script('public/admin-design/js/jquery.validate.js')!!}
{!!Html::script('public/admin-design/js/additional-methods.min.js')!!}
{!!Html::script('public/admin-design/js/jquery.validate.file.js')!!}
<script>
$(document).ready(function() {

        $("#post_files").validate({

            rules: {

                "images[]" : {
                
                    required: true,
                    accept: "image/*",
                    extension: "jpg|jpeg|png|ico|gif",
                    maxFileSize: {
                        "unit": "MB",
                        "size": 2
                    }
                
                },

            },

            messages: {

                "images[]" :{
                
                    required: "Please select atleast one image",
                    accept: "Only images are allowed",
                    extension: "Not A valid Extension"
                
                },
            
            }

        });

        

    });

</script>
{{---End Slug----}}
@endpush