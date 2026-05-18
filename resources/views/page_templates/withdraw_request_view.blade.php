@extends('layouts.user_profile')
@section('content')



<div class="content-page">
    <div class="col-md-12 col-lg-10">
        <div class="glass-card">
            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Withdraw Rrequest</h2>
            </div>
            <form class="d-flex flex-column gap-4" id="active-pin-form" action="{{ route('request_withdraw') }}"
                method="post">
                {{ csrf_field() }}

                @if(Session::has('success'))

                <p class="alert alert-success">{!! Session::get('success') !!}</p>
                @elseif(Session::has('danger'))
                <p class="alert alert-danger">{!! Session::get('danger') !!}</p>

                @endif


                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-text-input" class="font-14 regular text-white">Avalable Balance
                    </label>
                    <input class="custom-input" type="text" value="@if(isset($balance)) {{$balance}} @endif" name="pin"
                        id="pin" readonly>
                </div>
                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-search-input" class="font-14 regular text-white" id="amtlevel">Amount </label>
                    <input class="custom-input" type="text" name="amount" id="amount" placeholder="500" required>
                </div>

                <div class="form-group d-flex flex-column gap-2">
                    <label for="example-search-input" class="font-14 regular text-white" id="amtlevel">Net
                        Amount </label>
                    <input class="custom-input" type="text" name="netamount" id="netamount" readonly>
                    <h6 class="font-14 light grayColor mb-0">10% Reduction software maintenance charge</h6>
                </div>

                <p id="deduction"></p>

                <button type="submit" class="submit-button w-25  mt-2">Submit</button>

        </div>
    </div>
</div>


@endsection
@push('js')
<script type="text/javascript">



    function decuct() {
        var wtype = $('input[name=wtype]:checked').val();

        var amount = $('#amount').val() - ($('#amount').val() * (10 / 100));
        $('#deduction').html('10% Deduction admin + Service Charge');

        $('#netamount').val(Math.round(amount));
    }

    $('#amount').keyup(function () {
        decuct();
    });
</script>


@endpush