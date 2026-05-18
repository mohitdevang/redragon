@extends('layouts.main')
@section('title') Ads @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Ads <small> Overview</small>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Ads <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                                    {!! Form::open([ 'route'=> ['admin.ads.delete'], 'method' => 'DELETE','onsubmit' => 'return datatable_validation()']) !!}
                                  <p><button type="submit" name="bulk_delete" class="btn btn-danger btn-rounded"><i class="fa fa-trash"></i></button><br /></p>
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th width="2%">{!! Form::input('checkbox','chkHeader',null,['id' => 'chkHeader', 'onclick' => 'checkUncheckAll(this)'])!!}</th>
                                                <th width="10%">Sl No.</th>
                                                <th width="30%">Type</th>
                                                <th width="30%">File</th>
                                                <th width="10%">Link</th>
                                                 <th width="10%">Download Link</th>
                                                  <th width="10%">Download Text</th>
                                                 <th width="10%">Create Date</th>
                                                 <th width="10%">Edit</th>
                                             
                
                                          </tr>
                                         </thead>
                                         <tbody>
                    @php ($i = 1)                   
                    @foreach($video as $videos)     
                <tr>
                <td width="2%">{!! Form::input('checkbox','item[]',$videos->id,['class' => 'chkItems', 'onclick' => 'checkUnCheckParent()'])!!}</td>
                <td width="10%">{{ $i++ }}</td>
                <td width="30%">{{ $videos->type }}</td> 
                <td width="30%">{{ $videos->file }}</td> 
                 <td width="30%">{{ $videos->link }}</td> 
                <td width="30%">{{ $videos->download_link }}</td> 
                <td width="30%">{{ $videos->download_text }}</td> 
                <td width="30%">{{date("d-m-Y", strtotime($videos->created_date))   }}</td> 
                <td width="10%">
                <span class="action"><a href="{{ route('admin.ads.video_edit',$videos->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
               
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
