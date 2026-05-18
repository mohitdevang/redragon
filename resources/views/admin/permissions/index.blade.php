@extends('layouts.main')
@section('title') Permissions @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Permissions <small> Overview</small><a class="btn btn-success pull-right" href="{{ route('admin.permission.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>
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
                                                
												<th width="20%">Description</th>
                                                <th width="10%">Action</th>
                
                                          </tr>
                                         </thead>
										 <tbody>
										 @php ($i = 1)  
										 @php ($permissions = \App\Permission::where('guard_name',$guard)->get())               
                    					 @foreach($permissions as $permission)  
										 	<tr>
                                                <td width="7%">{{ $i++ }}</td>
                                                <td width="20%">{{ $permission->name }}</td>
                                               
												<td width="30%">{{ $permission->description }}</td>
                                                <td width="10%">
													<span class="action"><a href="{{ route('admin.permission.edit',$permission->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
													<span class="action"><a onclick="return confirm('Are you sure you want delete ?');" href="{{ route('admin.permission.delete',$permission->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
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
