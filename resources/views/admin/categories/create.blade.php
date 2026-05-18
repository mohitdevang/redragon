@extends('layouts.main')
@section('title') Add Category @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Add <small> Category</small>
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
                                <h3 class="panel-title"><i class="fa fa-user"></i> Add Category <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                            {!! Form::open([ 'route'=> ['admin.category.store'],'autocomplete'=>'off', 'files'=> true, 'id'=>'category','method' => 'POST']) !!}
                            @include('admin.categories._partials.form')                                   
                                    <div class="form-actions pull-right">
                                      {!! Form::button('<i class="fa fa-check"></i> Save',['name' => 'Submit', 'type' => 'submit', 'value' => 'Add', 'class' => 'btn btn-rounded btn-success']) !!}
                                      {!! Form::button('Reset',['name' => 'Reset', 'value' => 'Reset', 'type' => 'reset', 'class' => 'btn btn-rounded btn-inverse']) !!}
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