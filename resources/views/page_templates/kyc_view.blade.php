@extends('layouts.user_profile')
@section('content')



<div class="content-page">
    <div class="col-md-12 col-lg-10">
        <div class="glass-card">
            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Update Address</h2>
            </div>
            <form class="d-flex flex-column gap-4" id="active-pin-form" action="{{ route('update-kyc') }}" method="post"
                enctype="multipart/form-data">
                {{ csrf_field() }}

                @if(Session::has('success'))

                <p class="alert alert-success">{!! Session::get('success') !!}</p>
                @elseif(Session::has('danger'))
                <p class="alert alert-danger">{!! Session::get('danger') !!}</p>

                @endif
                <input type="hidden" name="hid" value="@if(isset($kyc)) {{$kyc->id}} @endif">

                <div class="form-group d-flex flex-column gap-2">
                    <label class="font-14 regular text-white">USDT (BEP-20) Wallet Address</label>
                    <input class="custom-input" type="text" placeholder="0x5cA85EBD0b281a42Bb16E561a04A869d6Da2d0D0"
                        value=" abc 3534 " name="trc_address" required="">
                </div>

                <button type="submit" class="submit-button w-25  mt-2">Submit</button>

        </div>
    </div>
</div>


@endsection
@push('js')



@endpush