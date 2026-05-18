@extends('layouts.main')
@if(Route::currentRouteName() != 'admin.adm.user.change_password')
@section('title') Edit Admin User @endsection
@else
@section('title') Create Admin User Password @endsection
@endif
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                         @if(Route::currentRouteName() != 'admin.adm.user.change_password')
                            Edit <small> User</small>
                         @else
                            Create <small> New Password</small>
                         @endif
                          
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
                                @if(Route::currentRouteName() != 'admin.adm.user.change_password')
                                Edit User   
                                @else 
                                Create Admin User Password
                                @endif
                                <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                            @if(Route::currentRouteName() != 'admin.adm.user.change_password')
                            {!! Form::Model($user,['autocomplete'=>'off','files'=> true,'id'=>'admin_user', 'method' => 'PATCH','route' => ['admin.adm.user.update',$user->id]]) !!}
                            @else 
                            {!! Form::Model($user,['autocomplete'=>'off','files'=> true,'id'=>'admin_user','method' => 'PATCH','route' => ['admin.adm.user.password.create',$user->id]]) !!}
                            @endif
                                    @include('admin.admin_users._partials.form') 
                                    <div class="form-actions pull-right">
                                    @if(Route::currentRouteName() != 'admin.adm.user.change_password')
                                    {!! Form::button('<i class="fa fa-pencil"></i> Update',['name' => 'Submit', 'type' => 'submit', 'value' => 'update', 'class' => 'btn btn-info btn-rounded']) !!}
                                    {!! Form::button('<i class="fa fa-pencil"></i> Save & Continue Edit',['name' => 'Submit', 'type' => 'submit', 'value' => 'edit', 'class' => 'btn btn-info btn-rounded']) !!}
                                    @else
                                    {!! Form::button('<i class="fa fa-check"></i> Create',['name' => 'Submit', 'type' => 'submit', 'value' => 'Edit Password', 'class' => 'btn btn-rounded btn-success']) !!}
                                    {!! Form::button('Reset',['name' => 'Reset', 'value' => 'Reset', 'type' => 'reset', 'class' => 'btn btn-rounded btn-inverse']) !!}
                                    @endif
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