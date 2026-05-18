@extends('layouts.user_profile')
@section('content')



<div class="content-page">
    <!-- Start content -->
    <div class="col-md-12 col-lg-10">
        <div class="glass-card">
            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Send Request</h2>
            </div>
            <form class="d-flex flex-column gap-4" id="active-pin-form" action="{{ route('request_admin') }}"
                method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-search-input" class="font-14 regular text-white">Amount(USDT)</label>
                    <input class="custom-input" type="text" name="request_amount" id="request_amount">
                </div>
                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-email-input" class="font-14 regular text-white">Message</label>
                    <textarea name="request_message" id="request_message" class="custom-input" required></textarea>
                </div>
                <!-- <div class="form-group d-flex flex-column gap-2">
                    <label for="example-email-input" class="font-14 regular text-white">Upload
                        reciept</label>
                    <input class="custom-input" type="file" name="request_file" id="request_file" required>
                </div> -->
                <!-- File Upload Section -->
                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-email-input" class="font-14 regular text-white">Upload receipt</label>
                    <div class="position-relative">
                        <input class="custom-input" type="text" id="file-display" placeholder="No file chosen" readonly>
                        <label for="request_file" class="file-upload-btn">Choose File</label>
                        <input type="file" name="request_file" id="request_file" required style="display: none;">
                    </div>
                </div>
                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-email-input" class="font-14 regular text-white">Transaction
                        ID</label>
                    <input class="custom-input" type="text" name="transaction_id" id="transaction_id" required>
                </div>
                <button type="submit" class="submit-button w-25  mt-2">Submit</button>
                <hr>
                <div class="qr-container">
                    <!-- QR Code Image -->
                    <a download>
                        <img class="qr-img" src="{{url('/')}}/public/uploads/{{$setting->scanner}}" width="200"
                            height="200" alt="QR Code">
                    </a>

                    <!-- Wallet Address Box with Copy Button -->
                    <div class="wallet-address-box">
                        <span class="wallet-address" id="walletAddress">TXYZabc123def456ghi789jkl012mno345pqr678</span>
                        <button class="copy-btn" id="copyBtn" onclick="copyWalletAddress()">
                            <svg class="copy-icon" id="copyIcon" viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                    </div>
                </div>


                <!--   <div class="form-group row">
                                            <label for="example-search-input" class="font-14 regular text-white">Name</label>
                                            <div class="col-sm-10">
                                               <input class="custom-input" type="text" value="@if(isset($bank)) {{$bank->ac_holder_name}} @endif"  readonly>
                                               
                                            </div>
                                        </div>
                                           <div class="form-group row">
                                            <label for="example-search-input" class="font-14 regular text-white">Account Number</label>
                                            <div class="col-sm-10">
                                               <input class="custom-input" type="text" value="@if(isset($bank)) {{$bank->ac_number}} @endif" readonly>
                                               
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label for="example-search-input" class="font-14 regular text-white">Bank Name</label>
                                            <div class="col-sm-10">
                                               <input class="custom-input" type="text" value="@if(isset($bank)) {{$bank->bank_name}} @endif"  readonly>
                                               
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-search-input" class="font-14 regular text-white">IFSC Code</label>
                                            <div class="col-sm-10">
                                               <input class="custom-input" type="text" value="@if(isset($bank)) {{$bank->ifsc}} @endif" readonly>
                                               
                                            </div>
                                        </div>


                                         <div class="form-group row">
                                            <label for="example-search-input" class="font-14 regular text-white">Google Pay</label>
                                            <div class="col-sm-10">
                                               <input class="custom-input" type="text" value="@if(isset($bank)) {{$bank->googlepay}} @endif" readonly>
                                               
                                            </div>
                                        </div>



                                         <div class="form-group row">
                                            <label for="example-search-input" class="font-14 regular text-white">Phone Pay</label>
                                            <div class="col-sm-10">
                                               <input class="custom-input" type="text" value="@if(isset($bank)) {{$bank->phonepay}} @endif" readonly>
                                               
                                            </div>
                                        </div>


                                         <div class="form-group row">
                                            <label for="example-search-input" class="font-14 regular text-white">Paytm</label>
                                            <div class="col-sm-10">
                                               <input class="custom-input" type="text" value="@if(isset($bank)) {{$bank->paytm}} @endif" readonly>
                                               
                                            </div>
                                        </div>
-->
           
        </div>
    </div>
</div>


@endsection