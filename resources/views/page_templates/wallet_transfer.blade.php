@extends('layouts.user_profile')

@section('content')



<div class="content-page">
    <!-- Start content -->
    <div class="col-md-12 col-lg-10">
        <div class="glass-card">
            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Wallet Transfer</h2>
            </div>
            <form class="d-flex flex-column gap-4" id="active-pin-form" action="{{ route('request_withdraw_tran') }}"
                method="post">
                {{ csrf_field() }}
                @if(Session::has('success'))
                <p class="alert alert-success">{!! Session::get('success') !!}</p>
                @elseif(Session::has('danger'))
                <p class="alert alert-danger">{!! Session::get('danger') !!}</p>
                @endif
                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-text-input" class="font-14 regular text-white">Wallet Balance
                    </label>
                    <input class="custom-input" type="text" value="@if(isset($balance)) {{$balance}} @else 0 @endif"
                        name="pin" id="pin" readonly>
                </div>
                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-search-input" class="font-14 regular text-white" id="amtlevel">Amount </label>
                    <input class="custom-input" type="text" name="amount" id="amount" placeholder="100" required>
                </div>
                <p id="deduction"></p>
                <button type="submit" class="submit-button w-25  mt-2">Submit</button>
          
        </div>
    </div>
</div>





@endsection