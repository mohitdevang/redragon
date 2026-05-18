@extends('layouts.user_profile')

@section('content')

@push('css')
<style>
    .responsive-container {
        max-width: 100%;
        text-align: center;
    }

    .responsive-image {
        max-width: 100%;
        height: auto;
        display: inline-block;
    }
</style>
@endpush




<div class="content-page">
    <!-- Start content -->
    <div class="col-md-12 col-lg-10">
        <div class="glass-card">
            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Income Wallet</h2>
            </div>

            <div class="card-congratulation-medal  ">
                <div class="card-body bg-new">
                    <h5 class="b-text">{{$wallet_text}}</h5>
                    <h3 class="mb-75 mt-2 pt-50">
                        <a href="#" class="text-white" id="level_balance">@if(isset($balance)) {{$balance}}
                            @else 0
                            @endif</a>
                    </h3>
                    <img src="/assets/img/1.png" class="congratulation-medal" alt="Medal Pic">
                </div>
            </div>
        </div>

    </div>
</div>


@endsection



@push('js')





@endpush