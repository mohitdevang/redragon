@extends('layouts.main')
@section('title') Plans @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Plans <small> Overview</small>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Plan <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                                    {!! Form::open([ 'route'=> ['admin.plan.delete'], 'method' => 'DELETE','onsubmit' => 'return datatable_validation()']) !!}
                                 <!--  <p><button type="submit" name="bulk_delete" class="btn btn-danger btn-rounded"><i class="fa fa-trash"></i></button><br /></p> -->
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                               <!--  <th width="2%">{!! Form::input('checkbox','chkHeader',null,['id' => 'chkHeader', 'onclick' => 'checkUncheckAll(this)'])!!}</th> -->
                                                <th >Sl No.</th>
                                                <th >Plan Name</th>
                                                <th >Direct Member</th>
                                                 <th >Downline Member</th>
                                                  <th >Day</th>

                                                 <th >Commission</th>
                                                <th >Created on </th>
                                                <th >Action</th>
                                             
                
                                          </tr>
                                         </thead>
                                         <tbody>
                    @php ($i = 1)                   
                    @foreach($plan as $plans)     
                <tr>
                <!-- <td width="2%">{!! Form::input('checkbox','item[]',$plans->id,['class' => 'chkItems', 'onclick' => 'checkUnCheckParent()'])!!}</td> -->
                <td >{{ $i++ }}</td>
                <td >{{ $plans->plan_name }}</td> 
                <td >{{ $plans->direct }}</td> 
                 <td >{{ $plans->member }}</td> 
                 <td >{{ $plans->day }}</td> 
                <td >{{ $plans->commision }}</td> 
                <td >{{date("d-m-Y", strtotime($plans->created_at))   }}</td> 
               <td >
                <span class="action"><a href="{{ route('admin.plan.edit',$plans->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
                
                </td>
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
@endsection

@push('custom-js')


@endpush
