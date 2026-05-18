@extends('layouts.main')
@section('title') Level Commission History @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Level Commission History <small> Overview</small>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Level Commission History <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                                 
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th>Sl no</th>  
                                                <th>Date</th>                                                 
                                                 <th>Earn amount</th>
                                                  <th>Level</th>
                                                  <th>Id</th>
                                                 
                                                             
                                          </tr>
                                         </thead>
                                           <tbody>
                                                @if(isset($total_video_earning))
                                                  @php($s=1)
                                                @foreach($total_video_earning as $dc)
                                                
                                            <tr>
                                                  <td>{{$s}}</td>
                                                <td>{{ date('d-m-Y',strtotime($dc->created_date))}}</td>
                                                 <td>{{$dc->amount}}</td>
                                                 <td>{{$dc->rank}}</td>
                                                 <td>{{$dc->direct_member_id}}</td>
                                               
                                        
                                                  
                                            </tr>
                                            @php($s++)
                                            @endforeach
                                            @endif
                                            
                                            </tbody>
                                       </table>
                                      
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
