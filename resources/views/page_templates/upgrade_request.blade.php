@extends('layouts.user_profile')
@section('content')



               <div class="content-page">
            <!-- Start content -->
  <div class="content">
                    <div class="container-fluid">
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">Upgrade Request</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $setting->title }}</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Members</a></li>
                                        <li class="breadcrumb-item active">Upgrade Request</li>
                                    </ol>
                                </div>
                            </div> <!-- end row -->
                        </div>
                        <!-- end page-title -->

                 
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">



 <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                  <th>Sl no</th>  
                                                <th>Amount</th>
                                                 <th>Capping of level benifit</th>
                                                 <th>Daily promotion benifit</th>
                                                 <th>Days</th>
                                          
                                              
                                                 <th>Status</th>
                                              
                                            </tr>
                                            </thead>
        
        
                                            <tbody>
                                                @if(isset($upgeade))
                                                 @php($s=1)
                                                @foreach($upgeade as $du)
                                            <tr>
                                                <td>{{$s}}</td>
                                                <td>{{$du->upgrade_amount}}</td>
                                                 <td>{{$du->lavel_income_daily_limit}}</td>
                                        
                                                    <td>{{$du->daily_benifit}}</td>
                                                <td>{{$du->day}}</td>
                                              
                                          
                                                 <td><?php $use=DB::table('user_upgrade_relation')->where([['upgrade_id',$du->updgrade_id],['user_id',Auth::guard()->user()->unique_id]])->first();
                                                 if($use)
                                                 {
                                                  if(DB::table('users')->where([['upgrade',$du->updgrade_id],['unique_id',Auth::guard()->user()->unique_id]])->first()){
                                                    echo 'Running';
                                                  }
                                                  else{
                                                      echo '<p style="color:green">Activated</p>' ;
                                                  }
                                                }else{echo '<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_'.$s.'">Active</a>';}?></td>
                                              
                                            </tr>

                                            <div class="modal fade" id="exampleModal_{{$s}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upgrade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
               <form   action="{{ route('request_upgrade_admin') }}" method="post"  enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="upgrade_id" value="{{$du->updgrade_id}}">
                                   <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-4 col-form-label">Amount</label>
                                            <div class="col-sm-8">
                                               <input class="form-control" type="text"  name="request_amount" id="request_amount" value="{{$du->upgrade_amount}}" readonly>
                                               
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-email-input" class="col-sm-4 col-form-label">Message</label>
                                            <div class="col-sm-8">
                                              
                                                <textarea name="request_message" id="request_message" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label for="example-email-input" class="col-sm-4 col-form-label">Upload reciept</label>
                                            <div class="col-sm-8">
                                              <input class="form-control" type="file"  name="request_file" id="request_file" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-email-input" class="col-sm-4 col-form-label">Transaction ID</label>
                                            <div class="col-sm-8">
                                              <input class="form-control" type="text"  name="transaction_id" id="transaction_id" required>
                                            </div>
                                        </div>

 <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>

</form>
      </div>
    
    </div>
  </div>
</div>
                                            @php($s++)
                                            @endforeach
                                            @endif
                                            
                                            </tbody>
                                        </table>


                               
                                        <hr>


                                        <p>You have to pay at</p>
                                           <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                               <input class="form-control" type="text" value="@if(isset($bank)) {{$bank->ac_holder_name}} @endif"  readonly>
                                               
                                            </div>
                                        </div>
                                           <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-2 col-form-label">Account Number</label>
                                            <div class="col-sm-10">
                                               <input class="form-control" type="text" value="@if(isset($bank)) {{$bank->ac_number}} @endif" readonly>
                                               
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-2 col-form-label">Bank Name</label>
                                            <div class="col-sm-10">
                                               <input class="form-control" type="text" value="@if(isset($bank)) {{$bank->bank_name}} @endif"  readonly>
                                               
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-2 col-form-label">IFSC Code</label>
                                            <div class="col-sm-10">
                                               <input class="form-control" type="text" value="@if(isset($bank)) {{$bank->ifsc}} @endif" readonly>
                                               
                                            </div>
                                        </div>


                                         <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-2 col-form-label">Google Pay</label>
                                            <div class="col-sm-10">
                                               <input class="form-control" type="text" value="@if(isset($bank)) {{$bank->googlepay}} @endif" readonly>
                                               
                                            </div>
                                        </div>



                                         <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-2 col-form-label">Phone Pay</label>
                                            <div class="col-sm-10">
                                               <input class="form-control" type="text" value="@if(isset($bank)) {{$bank->phonepay}} @endif" readonly>
                                               
                                            </div>
                                        </div>


                                         <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-2 col-form-label">Paytm</label>
                                            <div class="col-sm-10">
                                               <input class="form-control" type="text" value="@if(isset($bank)) {{$bank->paytm}} @endif" readonly>
                                               
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                 
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
        

                        
                    </div>
                    <!-- container-fluid -->

                </div>
                <!-- container-fluid -->

            </div>


 @endsection
 @push('js')


 @endpush