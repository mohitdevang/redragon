@extends('layouts.main')
@section('title') Members KYC @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Members KYC<small> Overview</small>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Members KYC <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body" style="overflow: auto;">
                                 <div class="table-responsive">
                                   <form
    action="{{ route('admin.member.delete') }}"
    method="POST"
    onsubmit="return datatable_validation()"
>
    @csrf
    @method('DELETE')
                                  <p><button type="submit" name="bulk_delete" class="btn btn-danger btn-rounded"><i class="fa fa-trash"></i></button><br /></p>
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" style="width:1400px;">
                                         <thead>
                                            <tr>
                                                <th width="2%"><input
    type="checkbox"
    name="chkHeader"
    id="chkHeader"
    onclick="checkUncheckAll(this)"
>
</th>
                                                <th>Sl No.</th>
                                                <th>Name</th>
                                                 <th>Id</th>
                                                 <th>Bank Name</th>
                                                 <th>A/c holder name</th>
                                                <th >a/c number</th>
                                                <th >IFSC</th>
                                                <th >Cheque</th>
                                                <th >Pan Number</th>
                                                <th >Pan photo</th>
                                                 <th >Aadhaar Number</th>
                                                <th >Aadhaar photo</th>
                                                             
                                          </tr>
                                         </thead>
                                         <tbody>
                    @php ($i = 1)                   
                    @foreach($member as $mem)     
                <tr>
               <td width="2%">
    <input
        type="checkbox"
        name="item[]"
        value="{{ $mem->id }}"
        class="chkItems"
        onclick="checkUnCheckParent()"
    >
</td>

                <td>{{ $i++ }}</td>
                <td >{{ $mem->name }}</td> 
                <td>{{ $mem->unique_id }}</td> 
                <td >{{ $mem->bank_name }}</td> 
                <td >{{ $mem->ac_holder_name }}</td> 
                <td >{{ $mem->ac_number }}</td> 
                <td >{{ $mem->ifsc }}</td> 
                  <td ><a href="{{url('/')}}/public/uploads/{{$mem->payment_prf}}" target="_blank"> <i class="fa fa-eye" aria-hidden="true"></i></a></td> 
                <td >{{ $mem->pan_no }}</td> 
                <td ><a href="{{url('/')}}/public/uploads/{{$mem->pan_photo}}" target="_blank"> <i class="fa fa-eye" aria-hidden="true"></i></a></td> 
                 <td >{{ $mem->country }}</td> 
                <td><a href="{{url('/')}}/public/uploads/{{$mem->aadhar_photo}}" target="_blank"> <i class="fa fa-eye" aria-hidden="true"></i></a></td> 
     
            </tr>  
                   @endforeach                 
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



<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Generate Pin</h4>
        </div>
        <div class="modal-body">
          <form>
            <input type="text" name="number" class="form-control" placeholder="Enter Number">
            
          </form>
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('custom-js')

@endpush
