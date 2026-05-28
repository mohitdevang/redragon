@extends('layouts.user_profile')

@section('content')

<div class="content-page">

    {{-- @if(Auth::guard()->user()->status!='active')

    <div class="row">
        <div class="col-sm-12 col-xl-12">
            <div class="card">
                <a href="{{url('/')}}/send-request"><button class="btn-rounded btn-success mlrauto blue-btn"
                        type="button">Activate my account</button></a>
            </div>
        </div>
    </div>

    @else --}}

    <div class="glass-card">
        <!-- Header -->
        <div class="card-title-border">
            <h2 class="card-title">Id activation from wallet</h2>
        </div>
        @if(empty($package_purchase_enabled))
        <div class="alert alert-warning">
            Package activation / plan purchase is <strong>disabled</strong> by admin. Please contact support.
        </div>
        @else
        <form class="d-flex flex-column gap-4" id="active-pin-form" action="{{ route('active_pin_from_wallet') }}"
            method="post">
            {{ csrf_field() }}
            @if(Session::has('success'))
            <p class="alert alert-success">{!! Session::get('success') !!}</p>

            @elseif(Session::has('danger'))

            <p class="alert alert-danger">{!! Session::get('danger') !!}</p>
            @endif
            <div class="form-group d-flex flex-column gap-2">
                <label for="example-text-input" class="font-14 regular text-white">Topup Wallet Balance
                </label>
                <div class="col-sm-2">
                    <input class="custom-input" type="text" value="@if(isset($balance)) {{$balance}} @else 0 @endif"
                        name="pin" id="pin" readonly>
                </div>
            </div>

            <div class="form-group d-flex flex-column gap-2">

                <label for="example-search-input" class="font-14 regular text-white">Member Id</label>
                <div class="">
                    <input class="custom-input" type="text" value="" name="member_unique_id" id="member_unique_id">
                    <span style="color: red;" id='sponsor_id_err' required></span>
                </div>
            </div>

            <div class="form-group d-flex flex-column gap-2">
                <label for="example-email-input" class="font-14 regular text-white">Member Name</label>
                <div class="">
                    <input class="custom-input" type="text" name="member_name" id="member_name" required readonly>
                </div>
            </div>
            <div class="form-group d-flex flex-column gap-2">
                <label for="example-text-input" class="font-14 regular text-white">Select Package</label>
                <div class="" id="pack">
                    <select name="pack" id="pack" class="custom-input" required>
                        <option value="">Select Package</option>
                        @if(isset($package_rows))
                        @foreach($package_rows as $row)
                        <option value="{{ $row['package']->id }}"
                            {{ $row['eligible'] ? '' : 'disabled' }}
                            {{ !empty($row['is_next']) ? 'selected' : '' }}>
                            {{ $row['package']->package_name }} — {{ $row['package']->price }} USDT
                            @if(!$row['eligible']) (locked) @endif
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <small class="text-muted">Next eligible: Magic Pool {{ str_pad($next_package_id ?? 1, 2, '0', STR_PAD_LEFT) }}. Spendable topup: {{ $spendable_balance ?? 0 }} USDT</small>
            </div>

            <button type="submit" class="submit-button w-25  mt-2">Submit</button>
        </form>
        @endif

    </div>
    {{-- @endif --}}

</div>





@endsection

@push('js')

<script type="text/javascript">



    $(document).ready(function () {



        $("#member_unique_id").keyup(function () {
            var token = $('input[name="_token"]').val();
            $.ajax({
                type: 'post',
                url: '{{ route('get_sopnsor_name')}}',
                data: { '_token': token, 'sponsor_id': $(this).val() },
                dataType: 'JSON',
                success: function (data) {

                    if (data.success) {
                        $('#member_name').val(data.success);
                        if (data.package) {
                            $('#pack').html(data.package);
                        }
                        $('#sponsor_id_err').html('')
                    }
                    if (data.err) {
                        $('#sponsor_id_err').html('wrong sponsor id');
                        $('#member_name').val('');
                    }

                }
            });


        });


        $("#pack").change(function () {
            // Get the selected value
            var selectedValue = $(this).val();
            if (selectedValue >= 4) {
                $('#auto_renew').show();
            } else {
                $('#auto_renew').hide();
            }

        });

    });




</script>





@endpush