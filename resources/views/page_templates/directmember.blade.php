@extends('layouts.user_profile')
@section('content')



<div class="content-page">
            <div class="col-md-12">
                <div class="glass-card">
                    <!-- Header -->
                    <div class="card-title-border">
                        <h2 class="card-title">Direct Members</h2>
                    </div>
                    <div class="table-responsive table-wrapper">
                        <table id="example" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>Sl no</th>
                                    <th>Name</th>
                                    <th>Id</th>
                                    <th>Join Date</th>
                                    <th>Active Date</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Country</th>
                                    <th>Status</th>

                                </tr>
                            </thead>


                            <tbody>
                                @if(isset($direct_user))
                                @php($s=1)
                                @foreach($direct_user as $du)
                                <tr>
                                    <td>{{$s}}</td>
                                    <td>{{$du->name}}</td>
                                    <td>{{$du->unique_id}}</td>

                                    <td>{{ date('d-m-Y h:i a',strtotime($du->created_at)) }}</td>
                                    <td>@if($du->status!='inactive') {{ date('d-m-Y h:i
                                        a',strtotime($du->active_date)) }}@else @endif</td>
                                    <td>{{$du->email}}</td>
                                    <td>{{$du->phone}}</td>
                                    <td>{{$du->country}}</td>
                                    <td>@if($du->status=='active')<span class="btn btn-success">{{
                                            ucwords($du->status) }}</span> @else <span class="btn btn-danger">{{
                                            ucwords($du->status)}}</span>@endif</td>

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