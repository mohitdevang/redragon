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
                                 <div class="table-responsive">

                                  <form action="{{ route('admin.withdraw_request.delete') }}" method="POST" onsubmit="return datatable_validation()">
    @csrf
    @method('DELETE')
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" style="width:1400px;">
                                         <thead>
                                            <tr>
                                                <th width="2%"><input type="checkbox" id="chkHeader" onclick="checkUncheckAll(this)"></th>
                                                 <th>Slno</th> 
                                                  <th>Type</th> 
                                                <th>Member Id</th>
                                                <th>Name</th> 
                                                <th>Date</th>   

                                                <th>Amount</th>
                                                <th>From A/C</th>
                                                 <th>Withdraw type</th>
                                                 <th>Net Amount</th>
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
                                               <td width="2%">    <input type="checkbox" name="item[]" value="{{ $req->comid }}" class="chkItems" onclick="checkUnCheckParent()">
</td>
                                                <td>{{$s}}</td>
                                                  <td>@if($req->in_wallet==1) AUTOPULL @else Level @endif</td>
                                                <td>{{$req->unique_id}}</td>
                                                <td>{{$req->name}}</td>
                                              <td>{{date("d-m-Y H:i a", strtotime($req->comdate))   }}</td>
                                                 <td>{{$req->amount}}</td>
                                                 <td>{{$req->fromac}}</td>
                                                 <td>{{$req->wtype}}</td>
                                                 <td>{{$req->net_payment}}</td>

                                                  <td>{{$req->bank_name}}</td>
                                                  <td>{{$req->ac_holder_name}}</td>
                                                   <td>{{$req->ac_number}}</td>
                                                    <td>{{$req->ifsc}}</td>   
                                                     <td>{{$req->request_status}}</td>                                               
                                                  
                                                       

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




@endpush
