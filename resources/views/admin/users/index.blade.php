@extends('layouts.main')
@section('title') Users @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Users <small> Overview</small>{{--<a onclick="return confirm('Are you sure you want empty the data table?');" class="btn btn-inverse pull-right" href="{{ route('admin.users.truncate') }}">Empty Table</a>--}}
                        </h1>
                        <ol class="breadcrumb">{{ generateBreadcrumb() }}</ol>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Users <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
			                     <div class="table-responsive">
                                    {!! Form::open([ 'route'=> ['admin.users.delete'], 'method' => 'POST','onsubmit' => 'return datatable_validation()']) !!}
                                  <p><button type="submit" name="bulk_delete" class="btn btn-danger btn-rounded"><i class="fa fa-trash"></i></button><br /></p>
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th width="2%">{!! Form::input('checkbox','chkHeader',null,['id' => 'chkHeader', 'onclick' => 'checkUncheckAll(this)'])!!}</th>
                                                <th width="3%">Sl No.</th>
                                                <th width="10%">Name</th>
                                                <th width="10%">Email</th>
                                            {{--<th width="10%">Picture</th>
                                                <th width="15%">Last Login At</th>
                                                <th width="10%">Last Login IP</th>
                                                <th width="10%">Status</th>--}}
                                                <th width="15%">Created At</th>
                                                <th width="12%">Action</th>
                
                                          </tr>
                                         </thead>
                                         <tbody>
                    @php ($i = 1)                   
                    @foreach($users as $user)     
                <tr>
                <td width="2%">{!! Form::input('checkbox','item[]',$user->id,['class' => 'chkItems', 'onclick' => 'checkUnCheckParent()'])!!}</td>
                <td width="3%">{{ $i++ }}</td>
                <td width="10%">{{ $user->name }}</td>
                <td width="10%">{{ $user->email }}</td>
            {{--<td width="10%">
                    @if($user->image)
                        <img src="{!! asset('public/uploads/'.$user->image) !!}" alt="{{ $user->name }}" style="width: 50px; height: 50px;">
                    @else
                        <img src="{!! asset('public/admin-design/images/dummy-profile.png') !!}" alt="{{  $user->name }}" style="width: 50px; height: 50px;">
                    @endif 
                </td>
                <td width="15%">{{ date("d-m-Y h:i:s", strtotime($user->last_login_at)) }}</td>
                <td width="10%">{{ $user->last_login_ip }}</td>
                <td width="10%">{!! Form::select('status', ['0' => 'Inactive','1' => 'Active'],$user->status,['class' => 'form-control', 'onchange' => 'changeStatus(this.value,'. $user->id .')']) !!} 
                </td>--}}
                <td width="15%">{{ date("d-m-Y h:i:s", strtotime($user->created_at)) }}</td>
                <td width="12%">
                @permit('admin.user.edit')
                <span class="action"><a href="{{ route('admin.user.edit',$user->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
                @endpermit
                @permit('admin.user.change_password')
                <span class="action"><a href="{{ route('admin.user.change_password',$user->id) }}"><i class="fa fa-unlock-alt" aria-hidden="true"></i></a></span>
                @endpermit
                @permit('admin.user.show')
                <span class="action"><a href="{{ route('admin.user.show',$user->id) }}"><i class="fa fa-list-ul" aria-hidden="true"></i></a></span>
                @endpermit
                @permit('admin.user.delete')
                <span class="action"><a onclick="return confirm('Are you sure you want delete ?');" href="{{ route('admin.user.delete',$user->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
                @endpermit
                <span class="action"><a onclick="getLocation( '{{ $user->last_login_ip }}' )"><i class="fa fa-map-marker" aria-hidden="true"></i></a></span>
                </td>
            </tr>  
                   @endforeach                 
                                        </tbody>
                                       </table>
                                       {!! Form::close() !!}
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
<!-- Modal -->
                    
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">User Location View</h4>
        </div>
        <div class="modal-body" id="content-area"></div>
    </div>
</div>
</div>

<!-- End Modal -->
@endsection
@push('custom-js')
<script>
function changeStatus(status,userID){

  var token = $('input[name="_token"]').val();

  $.ajax({

            type: 'POST',
            url:  '{{ route('admin.user.change_status') }}',
            data : {'_token': token,'status' : status,'id' : userID},
            success :  function(response){
                if(response.status === true) {
                    $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-circle" aria-hidden="true"></i> <strong>Success : </strong> &nbsp; '+ response.success +'</div>');
                } else {
                    $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="glyphicon glyphicon-remove-sign"></span> <strong>Success : </strong> &nbsp;'+ response.danger +'</div>');
                }
                setTimeout( function(){
                    $('#info').load(location.href +  ' #info');
                },3000);
            },
            error: function(xhr){
                  console.log("An error occured: " + xhr.status + " " + xhr.statusText);
            }


  });

}
</script>
<script>
function getLocation(ip){
    $.ajax({

        type: 'GET',
        url:  'http://ip-api.com/json/'+ip,
        success :  function(response){
            $('#content-area').html('');
            var contentHTML = '';
            $("#myModal").modal();
            if(response.status == 'success'){
                contentHTML = '<p>Country Code : '+ response.countryCode +'</p>';
                contentHTML += '<p>Country : '+ response.country +'</p>';
                contentHTML += '<p>City : '+ response.city +'</p>';
                contentHTML += '<p>ISP : '+ response.isp +'</p>';
                contentHTML += '<p>Logitude : '+ response.lon +'</p>';
                contentHTML += '<p>Lattitude : '+ response.lat +'</p>';
                contentHTML += '<p>Region Name : '+ response.regionName +'</p>';
                contentHTML += '<p>Zip / Postcode : '+ response.zip +'</p>';
                contentHTML += '<p>Timezone : '+ response.timezone +'</p>';
            }else{
                contentHTML = '<p>Message : '+ response.message +'</p>';
                contentHTML += '<p>IP : '+ response.query +'</p>';
                contentHTML += '<p>Status : '+ response.status +'</p>';
            }
             $('#content-area').append(contentHTML);
        },
        error: function(xhr){
              console.log("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    });
}
</script>
@endpush