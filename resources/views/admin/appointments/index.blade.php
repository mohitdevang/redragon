@extends('layouts.main')
@section('title') Appointments @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Appointments <small> Overview</small>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Appointments <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th width="7%">Sl No.</th>
                                                <th width="10%">Name</th>
                                                <th width="10%">Email</th>
                                                <th width="10%">Phone</th>
												<th width="15%">Date</th>
												<th width="10%">Time</th>
												<th width="20%">Package</th>
												<th width="10%">Price</th>
												<th width="10%">Client IP</th>
                                                <th width="20%">Created At</th>
                                               
                
                                          </tr>
                                         </thead>
                                         <tbody>
				  @php ($i = 1)
                  @foreach($enquires as $enquiry)     
                <tr>
                <td width="7%">{{ $i++ }}</td>
                <td width="20%">{{ $enquiry->name }}</td> 
                <td width="10%">{{ $enquiry->email }}</td>
                <td width="10%">{{ $enquiry->phone }}</td>
				<td width="20%">{{ $enquiry->select_date }}</td> 
                <td width="10%">{{ $enquiry->select_time }}</td>
                <td width="10%">{{ $enquiry->package }}</td>
				<td width="10%">£ {{ $enquiry->price }}</td>
				<td width="10%">{{ $enquiry->ip }}</td>
                <td width="12%">{{ date("d-m-Y h:i:s", strtotime($enquiry->created_at)) }}</td>      
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
