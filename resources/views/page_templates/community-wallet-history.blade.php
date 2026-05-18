@extends('layouts.user_profile')
@section('content')



<div class="content-page">
    <div class="col-md-12">

        <div class="glass-card">
            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">History</h2>
            </div>

            @if(Session::has('success'))

            <p class="alert alert-success">{!! Session::get('success') !!}</p>
            @elseif(Session::has('danger'))
            <p class="alert alert-danger">{!! Session::get('danger') !!}</p>

            @endif

            <div class="table-responsive table-wrapper">
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Balance</th>





                        </tr>
                    </thead>


                    <tbody>
                        @if(isset($balance))
                        @foreach($balance as $bal)


                        <tr>
                            <td>{{date("d-m-Y H:i a", strtotime($bal->updated_at)) }}</td>

                            <td>{{$bal->balance }}</td>



                        </tr>
                        @endforeach
                        @else
                        <p>No record found</p>

                        @endif

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


@endsection
@push('js')

<script>

    $(document).ready(function () {

        $.validator.addMethod("emailRegex", function (value, element) {
            if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) { return true; } else { return false; }
        }, "Please enter a valid Email.");

        $.validator.addMethod("nameRegex", function (value, element) {
            return this.optional(element) || /^([a-zA-Z_-\s]{3,20})$/.test(value);
        }, "Enter valid name");


        $("#register-form").validate({

            errorElement: 'span',
            errorClass: 'help-block',
            highlight: function (element, errorClass, validClass) {
                $(element).addClass("has-error");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass("has-error");
            },
            errorPlacement: function (error, element) {
                if (element.attr("type") == "checkbox") {
                    //error.insertAfter($(element).parent());
                } else {
                    error.insertAfter(element);
                }
            },

            rules: {

                name: {
                    required: true,
                    nameRegex: true
                },

                email: {
                    required: true,
                    emailRegex: true
                },

                userpwd: {
                    required: true
                },
                cpws: {
                    required: true,
                    equalTo: "#userpwd"
                },

                phone: {
                    required: true,
                    minlength: 8,
                    maxlength: 13,
                    digits: true
                },
                sponsor_id: {
                    required: true
                },

                sponsor_name: {
                    required: true
                },

                country: {
                    required: true
                },

            },



        });

    });

</script>


@endpush