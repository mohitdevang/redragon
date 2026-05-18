@extends('layouts.user_profile')
@section('content')



               <div class="content-page">
            <!-- Start content -->
  <div class="content">
                    <div class="container-fluid">
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">Autopull Membership Request</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $setting->title }}</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Members</a></li>
                                        <li class="breadcrumb-item active">Send Request</li>
                                    </ol>
                                </div>
                            </div> <!-- end row -->
                              <!-- end page-title -->
				<div class="row" style="margin-top:20px;">

                        <div class="col-sm-12 col-xl-12">
                            <div class="card">
			<marquee onmouseover="this.stop();"
           onmouseout="this.start();"   style="height:60px;" ><h3 class="text-danger">{!!$setting->noti_pin!!}</h3></marquee>
 </div> </div> </div>
                        </div>
                        <!-- end page-title -->

                 
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                 <form class="form-horizontal m-t-30" id="active-pin-form" action="{{ route('request_autopull_admin') }}" method="post"  enctype="multipart/form-data">
        {{ csrf_field() }}
                                       
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Number of pin</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="number" name="request_pin" id="request_pin" >
                                              
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-2 col-form-label">Amount(INR)</label>
                                            <div class="col-sm-10">
                                               <input class="form-control" type="text"  name="request_amount" id="request_amount" readonly>
                                               
                                            </div>
                                        </div>
                                        
                                         <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-2 col-form-label">Amount(USD)</label>
                                            <div class="col-sm-10">
                                               <input class="form-control" type="text"  name="request_amount_usd" id="request_amount_usd" readonly>
                                               
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-email-input" class="col-sm-2 col-form-label">Message</label>
                                            <div class="col-sm-10">
                                              
                                                <textarea name="request_message" id="request_message" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label for="example-email-input" class="col-sm-2 col-form-label">Upload reciept</label>
                                            <div class="col-sm-10">
                                              <input class="form-control" type="file"  name="request_file" id="request_file" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-email-input" class="col-sm-2 col-form-label">Transaction ID</label>
                                            <div class="col-sm-10">
                                              <input class="form-control" type="text"  name="transaction_id" id="transaction_id" required>
                                            </div>
                                        </div>


 <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> 


                                        <hr>


                                        <p>You have to pay at : <b></b><input type="text" class="form-control" value="TVx6tshA1QwBmZhWWM1mGmLQn9Z555TLwa" readonly></p> OR
                                       
                                        <img class="qr-img" src="{{url('/')}}/public/design/images/WhatsApp Image 2022-08-01 at 9.39.03 PM.jpeg" width="500" height="500">
                                         <!--   <div class="form-group row">
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
-->
                                       
                                 
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

<script>

// $( "#request_pin" ).bind('keyup mouseup', function () {
// var value = $(this).val();
// if(value<10){
//     $("#request_pin").val(10);
//     $('#request_amount').val($(this).val()*300);
// }
// })




$(document).ready(function() {

$("#request_pin").keyup(function(){
 $('#request_amount').val($(this).val()*700);
  $('#request_amount_usd').val($(this).val()*12);
});


        $("#member_unique_id").keyup(function(){
            var token = $('input[name="_token"]').val();
        $.ajax({
    type: 'post',
    url: '{{ route('get_sopnsor_name')}}',
    data : {'_token': token,'sponsor_id':$(this).val()},
   dataType: 'JSON',
    success :  function(data){
                
                   if(data.success){
                   $('#member_name').val(data.success);                    
                   $('#sponsor_id_err').html('')
                   } 
                   if(data.err){
                    $('#sponsor_id_err').html('wrong sponsor id');
                    $('#member_name').val('');
                   }

                }
});


});




    });


</script>


 @endpush