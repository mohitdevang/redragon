@extends('layouts.user_profile')
@section('content')



<div class="content-page">
    <div class="col-md-12">
        <div class="glass-card">
            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Withdraw History</h2>
            </div>
            <div class="table-responsive table-wrapper">
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Slno</th>
                            <th>Withdraw amount</th>
                            <th>Net Amount</th>

                            <th>Date</th>
                            <th>Status</th>


                        </tr>
                    </thead>


                    <tbody>
                        @if(isset($history))
                        @php($s=1)
                        @foreach($history as $his)
                        <tr>
                            <td>{{$s}}</td>
                            <td>{{$his->amount}}</td>

                            <td>{{$his->net_payment}}</td>

                            <td>{{ date('d-m-Y h:i a',strtotime($his->updated_at)) }}</td>
                            <td>{{$his->request_status}}</td>


                        </tr>
                        @php($s++)
                        @endforeach
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