@extends('layouts.main')
@section('title') View Admin User @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            View <small> Admin User</small>
                        </h1>
                       <ol class="breadcrumb"></ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
					
					
                    </div>
                </div>
                
			<div class="parent-content-wrapper">
			 <div id="content-sortable">	
                
               <div class="row">
                    <div class="col-lg-12">
					  <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-user"></i> View Admin User <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
							<div class="form-body">
                                        <h3 class="box-title">User Info</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label text-right col-md-3">Name :</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static">{{ $user->name }} </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label text-right col-md-3">Email :</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"> {{ $user->email }} </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <h3 class="box-title">Role Info: </h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label text-right col-md-3">Role :</label>
                                                    <div class="col-md-9">
													    @php ($prefix = ' ')  
                                                        <p class="form-control-static"> 
														@foreach($user->roles as $role)
															{{$prefix.$role->name }}
															@php ($prefix = ', ')
														@endforeach
														@php ($prefix = ' ')
														</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>	
										<h3 class="box-title">User Role Has Permissions</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="row">
                                            <div class="col-md-12">

												<div class="permission-list"> 
												  @foreach($user_role_permissions as $permission)

													<div class="item-list">{{ $permission->name }} <span class="pull-right">( {{ $permission->description }} )</span></div>
													
												  @endforeach
												</div>
                                                
                                            </div>
                                        </div>
										
										<h3 class="box-title">User Has Permissions (Additional Permissons For Perticular User)</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="row">
                                            <div class="col-md-12">
                                                
												@php($guard = 'admin')
												<div class="permission-list"> 
												  @foreach($permissions as $permission)
													@if(in_array($permission->id,$user_permissions))
														@php($checked = 'checked="checked"')
													@else
														@php($checked = '')
													@endif
													<div class="item-list"><input type="checkbox" {{ $checked }} class="chkItems" id="{{ $guard }}-{{ $user->id }}-{{ $permission->id }}" onclick="setUnsetPermmision('{{ $guard }}',{{ $user->id }}, {{ $permission->id }})"> {{ $permission->name }} <span class="pull-right">( {{ $permission->description }} )</span></div>
													
												  @endforeach
												</div>
                                                
                                            </div>
                                        </div>
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

{{---Page Status----}}

<script>
function setUnsetPermmision(guard,user_id,permission_id){

  var checkBox = document.getElementById(guard+'-'+user_id+'-'+permission_id);
  
  if (checkBox.checked == true){
    var isChecked = 'true';
  } else {
    var isChecked = 'false';
  }
  
  var token = $('meta[name="csrf-token"]').attr('content');

  $.ajax({

            type: 'POST',
			async: false,
            url:  '{{ route('admin.adm.user.permissions.manage') }}',
            data : {'_token': token,'guard' : guard, 'user_id' : user_id, 'permission_id' : permission_id,'isChecked' : isChecked},
            success :  function(response){
               
            },
            error: function(xhr){
                  console.log("An error occured: " + xhr.status + " " + xhr.statusText);
            }


  });

}
</script>

{{---End Page Status----}}

@endpush