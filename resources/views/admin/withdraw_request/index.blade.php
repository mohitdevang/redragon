@extends('layouts.main')
@section('title') Withdraw Request @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Withdraw Request <small> Overview</small>
                        </h1>
                        <ol class="breadcrumb">{{ generateBreadcrumb() }}<img class="pull-right ajax-loader" src="{!! asset('public/admin-design/images/btn-ajax-loader.gif') !!}" /></ol>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Withdraw Request <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body" style="overflow: auto;">


                                  <form method="post" action="{{route('admin.show.withdraw_request')}}">

     {{ csrf_field() }}
                                <input type="text" name="from_date" class="from-control datepicker" placeholder="From Date" required="" autocomplete="off" value="@if(isset($from_date)){{$from_date}}@endif">
                                <input type="text" name="to_date" class="from-control datepicker" placeholder="To Date" required="" autocomplete="off" value="@if(isset($to_date)){{$to_date}}@endif">

                                <button type="submit" name="bulk_delete" class="btn btn-success btn-rounded">search</button>

                                <a href="{{route('admin.show.withdraw_request')}}"> <button type="button" name="bulk_delete" class="btn btn-danger btn-rounded">cancel search</button></a>

</form>



                                 <div class="table-responsive">

                                 <form action="{{ route('admin.withdraw_request.delete') }}" method="POST" onsubmit="return datatable_validation()">
    @csrf
    @method('DELETE')

    <!-- Example submit button -->
    <button type="submit" class="btn btn-danger">Delete Selected</button>
</form>

                                   
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" style="width:1400px;">
                                         <thead>
                                            <tr>
                                                <th width="2%"><input type="checkbox" name="chkHeader" id="chkHeader" onclick="checkUncheckAll(this)">
</th>
                                                 <th>Slno</th> 
                                                 <th>Type</th> 
                                                <th>Member Id</th>
                                                <th>Name</th> 
                                                <th>Date</th>   

                                                <th>Amount Request</th>
                                              
                                                 <th>Net Payable Amount</th>
                                                 <th>Bank Name </th>
                                                 <th>A/c holder Name </th>
                                                 <th>Account Number</th>
                                                 <th>IFSC</th>
                                                 <th>Action</th>
                                                 
                                                
                                                 
                                             
                
                                          </tr>
                                         </thead>
                                         <tbody>
                   @if(isset($request))
                                                @php($s=1)
                                                @foreach($request as $req)


                                            <tr>
                                               <td width="2%"><input type="checkbox" name="item[]" value="{{ $req->comid }}" class="chkItems" onclick="checkUnCheckParent()">
</td>
                                                <td>{{$s}}</td>
                                                 <td>@if($req->in_wallet==1) AUTOPULL @else Level @endif</td>
                                                 <td>{{$req->unique_id}}</td>
                                               
                                                <td>{{$req->name}}</td>
                                              <td>{{date("d-m-Y H:i a", strtotime($req->comdate))   }}</td>
                                                 <td>{{$req->amount}}</td>
                                                 
                                                 <td>{{$req->net_payment}}</td>

                                                  <td>{{$req->bank_name}}</td>
                                                  <td>{{$req->ac_holder_name}}</td>
                                                   <td>{{$req->ac_number}}</td>
                                                    <td>{{$req->ifsc}}</td>                                               
                                                  
                                                     <td ><select name="status" class="form-control" onchange="changerequestStatus(this.value, {{ $req->comid }}, '{{ $req->unique_id }}')">
    <option value="approve" {{ $req->request_status == 'approve' ? 'selected' : '' }}>Approve</option>
    <option value="processing" {{ $req->request_status == 'processing' ? 'selected' : '' }}>Processing</option>
</select></td>     

                                             @php($s++)
                                            @endforeach
                                            @else
                                            <p>No active record found</p>

                                            @endif
                                            
                                        </tbody>
                                       </table>
                                      </form>
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

<script type="text/javascript">
  
  function changerequestStatus(status,pageID,user_id){

  var token = $('input[name="_token"]').val();

  $.ajax({

            type: 'POST',
            url:  '{{ route('admin.request.change.withrraw_status') }}',
            data : {'_token': token,'status' : status,'id' : pageID,'user_id' : user_id},
            dataType: 'JSON',
            success :  function(response){
               
                if(response.status == true) {
                    
                    $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-circle" aria-hidden="true"></i> <strong>Success : </strong> &nbsp; '+ response.success +'</div>');
                    location.reload();
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


@endpush
