@extends('layouts.user_profile')
@section('content')



<div class="content-page">
    <!-- Start content -->
    <div class="col-md-12 col-lg-10">
        <div class="glass-card">
            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">My Profile</h2>
            </div>
            <form class="d-flex flex-column gap-4" id="active-pin-form" action="{{ route('update-profile') }}"
                method="post" enctype="multipart/form-data">

                {{ csrf_field() }}

                @if(Session::has('success'))

                <p class="alert alert-success">{!! Session::get('success') !!}</p>
                @elseif(Session::has('danger'))
                <p class="alert alert-danger">{!! Session::get('danger') !!}</p>

                @endif
                <input type="hidden" name="hid" value="@if(isset($profile)) {{$profile->id}} @endif">

                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-text-input" class="font-14 regular text-white">Name</label>

                    <input class="custom-input" type="text" value="@if(isset($profile)) {{$profile->name}} @endif"
                        name="name" readonly>


                </div>
                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-text-input" class="font-14 regular text-white">Email</label>

                    <input class="custom-input" type="text" value="@if(isset($profile)) {{$profile->email}} @endif"
                        name="email" readonly>


                </div>


                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-email-input" class="font-14 regular text-white">Mobile</label>

                    <input class="custom-input" type="text" value="@if(isset($profile)) {{$profile->phone}} @endif"
                        name="phone" readonly>

                </div>


                <button type="submit" class="submit-button w-25  mt-2">Submit</button>


        </div>
    </div>
</div>


@endsection
@push('js')



@endpush