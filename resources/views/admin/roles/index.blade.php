@extends('layouts.main')
@section('title') Roles @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Roles <small> Overview</small><a class="btn btn-success pull-right" href="{{ route('admin.role.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>
                        </h1>
                        <ol class="breadcrumb">{{ generateBreadcrumb() }}</ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div id="info">
                        </div>
                     @component('elements.admin.components.flash') @endcomponent 
                    </div>
                </div>

                @php($guard_arr = config('auth.guards'))
				@php($guards = array_keys($guard_arr))
                
			<div class="parent-content-wrapper">
			 <div id="content-sortable">	
              
			  @foreach($guards as $guard)
				
				<div class="row">
                    <div class="col-lg-12">
                      <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> {{ ucwords(str_replace("-"," ",$guard)) }} Guard <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                                   
                                  
                                        <table class="table table-striped table-hover table-bordered example" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th width="7%">Sl No.</th>
                                                <th width="20%">Name</th>
                                                
                                                <th width="10%">Action</th>
                
                                          </tr>
                                         </thead>
										 <tbody>
										 @php ($i = 1)  
										 @php ($roles = \App\Role::where('guard_name',$guard)->get())               
                    					 @foreach($roles as $role)  
										 	<tr>
                                                <td width="7%">{{ $i++ }}</td>
                                                <td width="20%">{{ $role->name }}</td>
                                                
                                                <td width="10%">
													<span class="action"><a href="{{ route('admin.role.edit',$role->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
                          @if($role->id != 1)
													<span class="action"><a onclick="return confirm('Are you sure you want delete ?');" href="{{ route('admin.role.delete',$role->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
                          @endif
													</td>
                
                                          </tr>
										 @endforeach
										 </tbody>
                                       </table>
                                       
                                  </div>
                            </div>
                     </div>
                  </div>
                </div>
				
			  @endforeach
				
				  	
            </div>
		    </div>
            </div>
            <!-- /.container-fluid -->

</div>
@endsection
