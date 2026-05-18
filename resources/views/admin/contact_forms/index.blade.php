@extends('layouts.main')
@section('title') Enquiries @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Enquiries <small> Overview</small>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Enquiries <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th width="7%">Sl No.</th>
                                                <th width="20%">Name</th>
                                                <th width="10%">Email</th>
                                                <th width="20%">Phone</th>
                                                <th width="20%">Created At</th>
                                                <th width="10%">Action</th>
                
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
                <td width="12%">{{ date("d-m-Y h:i:s", strtotime($enquiry->created_at)) }}</td>      
                <td width="10%">
                <span class="action"><a href="{{ route('admin.contact.form.show',$enquiry->id) }}"><i class="fa fa-list-ul" aria-hidden="true"></i></a></span>
                </td>
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
