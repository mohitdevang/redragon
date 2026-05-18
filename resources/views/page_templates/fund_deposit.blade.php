@extends('layouts.user_profile')
@section('content')



    <div class="col-md-12 col-lg-10">
        <div class="glass-card d-flex flex-column">
            <!-- Header -->
            <div class="cardHeading">
                <h3 class="mb-0 font-24 medium  card-title ">Select Mode of Payment</h3>
            </div>
            <!-- card list -->
            <div class="summary-card-content">
                <a href="{{ route('send_request')}}"
                    class="d-flex align-items-center scalable-gap-30 flex-wrap justify-content-md-start justify-content-center">
                    <div class="deposit-card">
                        <img src="{{url('/')}}/public/admin/assets/images/png/semi-auto.png">
                    </div>
                    <h3 class="font-34 medium themeColor mb-0">Semi-Automatic
                    </h3>
                </a>
            </div>
            <div class="d-flex flex-column gap-3 deposit-content mt-4">
                <div class="d-flex flex-column">
                    <p class="grayColor font-20 medium mb-0">For semi-automatic deposits, after
                        transferring
                        USDT, please manually copy and paste the transaction hash code and submit it for
                        verification.</p>
                    <p class="grayColor font-20 medium mb-0">You may use Binance or any other
                        exchange/wallet that supports USDT (BEP-20).eposit
                        processing time: approximately 2 minutes.</p>
                </div>
                <p class="grayColor font-20 medium mb-0">For instant/automatic deposits on
                    mobile, open the Metafxgold.com website within Trust
                    Wallet, MetaMask browser, or any other wallet that supports USDT (BEP-20). Connect your
                    wallet, sign in, confirm, and complete the transfer.</p>
            </div>
        </div>
    </div>







@endsection