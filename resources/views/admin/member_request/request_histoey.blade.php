@extends('layouts.main')
@section('title') Member Request @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Pins <small> Overview</small>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Member Request <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body" style="overflow: auto;">
                                 <div class="table-responsive">

                                  <form action="{{ route('admin.member_request.delete') }}" method="POST" onsubmit="return datatable_validation()">
    @csrf
    @method('DELETE')
                                     <p><button type="submit" name="bulk_delete" class="btn btn-danger btn-rounded"><i class="fa fa-trash"></i></button><br /></p>
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th width="2%">   <input type="checkbox" id="chkHeader" onclick="checkUncheckAll(this)"></th>
                                                 <th>Slno</th> 
                                                   <th>Member Id</th> 
                                                <th>Phone</th> 
                                                <th>Name</th> 
                                                <th>Requested pin</th>                                   
                                                <th>Amount</th>
                                                <th>Meggase</th>
                                                 <th>Date</th>
                                                <th>File</th>   
                                                 <th>Transaction Id</th> 
                                                <th>Status</th>
                                                 
                                             
                
                                          </tr>
                                         </thead>
                                         <tbody>
                   @if(isset($request))
                                                @php($s=1)
                                                @foreach($request as $req)
                                                 <?php 
                                                $user=DB::table('users')->where('unique_id',$req->member_id)->first();
                                                if($user->unique_id){
                                                ?>


                                            <tr>
                                               <td width="2%">  <input type="checkbox" name="item[]" value="{{ $req->id }}" class="chkItems" onclick="checkUnCheckParent()"></td>
                                                <td>{{$s}}</td>
                                                 <td>{{$user->unique_id}}</td>
                                                <td>{{$user->phone}}</td>
                                                <td>{{$user->name}}</td>
                                                
                                                <td>{{$req->request_pin}}</td>
                                                <td>{{$req->request_amount}}</td>
                                                 <td>{{$req->request_message}}</td>
                                                 <td>{{date("d-m-Y H:i a", strtotime($req->updated_at))   }}</td>
                                                  <td><img src="{{url('/')}}/public/uploads/{{$req->request_file}}" height="50" width="50"></td>
                                                    <td>{{$req->transaction_id}}</td>
                                                  
                                                     <td>{{$req->status}}</td>     

                                             @php($s++)
                                        <?php  } ?>
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
