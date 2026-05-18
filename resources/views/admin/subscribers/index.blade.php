@extends('layouts.main')
@section('title') Subscribers @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Subscribers <small> Overview</small>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Subscribers <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th width="7%">Sl No.</th>
                                                <th width="20%">Email</th>
												<th width="20%">Status</th>
                                                <th width="20%">Created At</th>
                
                                          </tr>
                                         </thead>
                                         <tbody>
				  @php ($i = 1)
                  @foreach($subscribers as $subscriber)     
                <tr>
                <td width="7%">{{ $i++ }}</td>
                <td width="20%">{{ $subscriber->email }}</td>
				<td width="20%">{{ ($subscriber->status == 1)? 'Subscribed' : 'Unsubscribed' }}</td>
                <td width="12%">{{ date("d-m-Y h:i:s", strtotime($subscriber->created_at)) }}</td>      
            	</tr>  
                   @endforeach                 
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
