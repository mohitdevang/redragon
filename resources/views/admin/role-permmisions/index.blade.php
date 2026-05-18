@extends('layouts.main')
@section('title') Role based permmisions @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Role & Permmisions <small> Overview</small>
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
                                 
										 <tbody>
										 @php ($i = 1)  
										 @php ($roles = \App\Role::where('guard_name',$guard)->get())               
                     @foreach($roles as $role)  
										    
                        <h2>{{ $role->name }}</h1>
                        <div class="permission-list"> 
                          @php ($permissions = \App\Permission::where('guard_name',$guard)->get())   
                          @foreach($permissions as $permission)
						  @php($permmision_arr = is_array($role->getPermIdsAttribute()) ? $role->getPermIdsAttribute() : array())
						  @if(in_array($permission->id,$permmision_arr))
						  	@php($checked = 'checked="checked"')
						  @else
						  	@php($checked = '')
						  @endif
                          <div class="item-list"><input type="checkbox" {{ $checked }} class="chkItems" id="{{ $guard }}-{{ $role->id }}-{{ $permission->id }}" onclick="setUnsetPermmision('{{ $guard }}',{{ $role->id }},{{ $permission->id }})"> {{ $permission->name }} <span class="pull-right">( {{ $permission->description }} )</span></div>
                          @endforeach
                        </div>

										 @endforeach

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
@push('custom-js')

{{---Page Status----}}

<script>
function setUnsetPermmision(guard,role_id,permission_id){

  var checkBox = document.getElementById(guard+'-'+role_id+'-'+permission_id);
  
  if (checkBox.checked == true){
    var isChecked = 'true';
  } else {
    var isChecked = 'false';
  }
  
  var token = $('meta[name="csrf-token"]').attr('content');

  $.ajax({

            type: 'POST',
			async: false,
            url:  '{{ route('admin.role.permissions.manage') }}',
            data : {'_token': token,'guard' : guard,'role_id' : role_id,'permission_id' : permission_id,'isChecked' : isChecked},
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