@extends('layouts.main')
@section('title') Edit Category @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Edit <small> Category</small>
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
                                Edit Category
                                <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                            {!! Form::Model($category,['autocomplete'=>'off','files'=> true,'id'=>'category', 'method' => 'PATCH','route' => ['admin.category.update',$category->id]]) !!}
                                    @include('admin.categories._partials.form') 
                                    <div class="form-actions pull-right">
                                        {!! Form::button('<i class="fa fa-pencil"></i> Update',['name' => 'Submit', 'type' => 'submit', 'value' => 'update', 'class' => 'btn btn-info btn-rounded']) !!}
                                        {!! Form::button('<i class="fa fa-pencil"></i> Save & Continue Edit',['name' => 'Submit', 'type' => 'submit', 'value' => 'edit', 'class' => 'btn btn-info btn-rounded']) !!}
                                    </div>
                            {!! Form::close() !!}
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

{!!Html::script('public/admin-design/js/ckeditor/adapters/jquery.js')!!}

{{---Slug----}}
<script>
function edit_slug(id){
value = $('#slug').val();
var token = $('input[name="_token"]').val();
$.ajax({
    type: 'put',
    url: '{{ route('admin.category.update.slug')}}',
    data : {'_token': token,'id':id,'value':value},
    success :  function(response){
                
                   if(response.status === true){
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
{{---End Slug----}}
@endpush