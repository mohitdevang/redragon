@extends('layouts.user_profile')
@section('content')



               <div class="content-page">
            <!-- Start content -->
  <div class="content">
                    <div class="container-fluid">
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">Agrement</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $setting->title }}</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Members</a></li>
                                        <li class="breadcrumb-item active">Agrement</li>
                                    </ol>
                                </div>
                            </div> <!-- end row -->
                        </div>
                        <!-- end page-title -->

                 
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">

                                         @if($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Error!</strong> {{ $message }}
                </div>
            @endif
            {!! Session::forget('error') !!}
            @if($message = Session::get('success'))
                <div class="alert alert-info alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Success!</strong> {{ $message }}
                </div>
            @endif
            {!! Session::forget('success') !!}
                                 <form action="{!!route('payment')!!}" method="POST" >    

        {{ csrf_field() }}
        
       <h3>Purchase by</h3>
     <a href="{{url('/')}}/show-my-pin">  <button type="button" class="btn btn-primary waves-effect waves-light">Pin</button></a>

                                        
<!-- 
                                         <script src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{$setting->RAZOR_KEY}}"
                                data-amount="{{$setting->activation_price_paysa }}"
                                data-buttontext="Pay {{$setting->activation_price_rs }} INR online"
                                data-name="{{$setting->title}}"
                                data-description="Payment"
                                data-image="{!! asset('public/uploads/'.$setting->logo) !!}"
                                data-prefill.name="{{$setting->title}}"
                                data-prefill.email="{{$setting->email}}"
                                data-theme.color="#d60202">
                        </script> -->
                        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                                       
                                 
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