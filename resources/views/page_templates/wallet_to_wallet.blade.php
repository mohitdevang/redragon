@extends('layouts.user_profile')

@section('content')







               <div class="content-page">

            <!-- Start content -->

  <div class="content">

                    <div class="container-fluid">

                        <div class="page-title-box">

                            <div class="row align-items-center">

                                <div class="col-sm-6">

                                    <h4 class="page-title">Wallet to Wallet Transfer</h4>

                                </div>

                                <div class="col-sm-6">

                                    <ol class="breadcrumb float-right">

                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $setting->title }}</a></li>

                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Members</a></li>

                                        <li class="breadcrumb-item active">Wallet to Wallet Transfer</li>

                                    </ol>

                                </div>

                            </div> <!-- end row -->

                        </div>

                        <!-- end page-title -->
                        
                        
 <!--                       <div class="row">-->







 <!--                       <div class="col-sm-12 col-xl-12">-->



 <!--                           <div class="card">-->



	<!-- <h1> Coming Soon... </h1>-->



 <!--</div> </div> </div>-->
                        
                        
                        
  
                        
@if(Auth::guard()->user()->status!='active')

                        

                        

                        

                 	<div class="row">







                        <div class="col-sm-12 col-xl-12">



                            <div class="card">



	 <a href="{{url('/')}}/send-request"><button class="btn-rounded btn-success mlrauto blue-btn" type="button">Activate my account</button></a>



 </div> </div> </div>

 @else



                 

                        <div class="row">

                            <div class="col-12">

                                <div class="card m-b-30">

                                    <div class="card-body">

                                 <form class="form-horizontal m-t-30" id="active-pin-form" action="{{ route('wallet_to_wallet_transfer') }}" method="post">

        {{ csrf_field() }}

        

    @if(Session::has('success')) 

    

    <p class="alert alert-success">{!! Session::get('success') !!}</p>

    @elseif(Session::has('danger')) 

    <p class="alert alert-danger">{!! Session::get('danger') !!}</p>

    

    @endif

    

                                      

                       

                               

                                        

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-2 col-form-label">Topup Wallet Balance </label>

                                            <div class="col-sm-2">

                                                <input class="form-control" type="text" value="@if(isset($balance)) {{$balance}} @else 0 @endif"  name="pin"  id="pin" readonly>

                                            </div>
                                            
                                       

                                        </div>

                                        

                                        

                                        

                                   

                
                                        
                                        
                          
                                           <div class="form-group row">
                                            
                                            <label for="example-search-input" class="col-sm-2 col-form-label">Send To (Member Id)</label>
                                            <div class="col-sm-10">
                                               <input class="form-control" type="text" value="" name="member_unique_id" id="member_unique_id" >
                                                <span style="color: red;" id='sponsor_id_err' required></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="example-email-input" class="col-sm-2 col-form-label">Member Name</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value=""  name="member_name" id="member_name" required readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="example-email-input" class="col-sm-2 col-form-label">Amount To Send</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text"  name="amount" id="amount" required>
                                            </div>
                                        </div>

                 
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>

                                 

                                    </div>

                                </div>

                            </div> 

                        </div>

        



                        

                    </div>

                    <!-- container-fluid -->



                </div>

                @endif
                
              

                <!-- container-fluid -->



            </div>





 @endsection

 @push('js')

<script type="text/javascript">

$("#active-pin-form").submit(function(){
    $('button[type="submit"]').prop('disabled', true);
$('button[type="submit"]').html('Please wait...');

 
 
});

$(document).ready(function() {



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