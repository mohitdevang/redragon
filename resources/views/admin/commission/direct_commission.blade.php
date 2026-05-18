@extends('layouts.main')
@section('title') Direct Commission @endsection
@section('content')

@push('custom-css')

@endpush


<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Direct Commission <small> Overview</small>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Direct Commission <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">

                                
                                 <form method="get" action="{{route('admin.show.direct_commission_report')}}">

     {{ csrf_field() }}
                         <div class="row" style="margin-bottom:10px;margin-top:10px;">
                            <div class="col-md-3 mb-mt10">
                                <input type="text" name="from_date" class="form-control datepicker" placeholder="From Date" autocomplete="off" value="@if(isset($from_date)){{$from_date}}@endif">
                            </div> 
                            <div class="col-md-3 mb-mt10">   
                                <input type="text" name="to_date" class="form-control datepicker" placeholder="To Date" r autocomplete="off" value="@if(isset($to_date)){{$to_date}}@endif">
                            </div> 
                            
                             <div class="col-md-3 mb-mt10">   
                                <input type="text" name="user_name" class="form-control" placeholder="User Name"  autocomplete="off" value="@if(isset($user_name)){{$user_name}}@endif">
                            </div> 
                            <div class="col-md-6 mb-mt10">
                                <button type="submit" name="bulk_delete" class="btn btn-success btn-rounded">search</button>

                                <a href="{{route('admin.show.direct_commission_report')}}"> <button type="button" name="bulk_delete" class="btn btn-danger btn-rounded">cancel search</button></a>
                            </div>     
                        </div>

</form>
                                 <div class="table-responsive">
                                    
                                        <table id="example1" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                              
                                                <th >Sl No.</th>
                                                <th >Member Id</th>
                                                 <th>Name</th>
                                                 <th>Activate On</th>
                                                 <th >Total Direct Income</th>
                                              
                                                             
                                          </tr>
                                         </thead>
                                         <tbody>
                    @php ($i = 1)                   
                    @foreach($users as $user)     

                    <?php 
$total=0;
                    if(isset($from_date) && isset($to_date)){


                     $total=DB::table('commision_tables')->where([['type','credit'],['plan','37'],['member_id',$user->unique_id],['created_at','<=',$to_date],['created_at','>=',$from_date]])->sum('amount');
                    }else{


                     $total=DB::table('commision_tables')->where([['type','credit'],['plan','37'],['member_id',$user->unique_id]])->sum('amount');
                 }

                    ;?>


                <tr>
               
                <td >{{ $i++ }}</td>
                <td >{{ $user->unique_id }}</td> 
                <td >{{ $user->name }}</td> 
                <td >{{ $user->active_date }}</td> 
                <td >{{ $total }}</td> 
               
            </tr>  
        
                   @endforeach                 
                                        </tbody>
                                       </table>
                    {{ $users->links() }}
                                       
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



@endsection

@push('custom-js')

@endpush