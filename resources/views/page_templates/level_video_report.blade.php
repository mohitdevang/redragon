@extends('layouts.user_profile')
@section('content')
<style>
    .dt-layout-start,
    .dt-layout-end,
    .dt-layout-start,
    .dt-layout-end {
        display: none !important;
    }
</style>

<div class="content-page">
    <div class="col-md-12">
        <div class="glass-card">
            @if(isset($daily_ad_view_income))
            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Daily Add View income report</h2>
            </div>

            <div class="table-responsive table-wrapper">
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Sl no</th>
                            <th>Date</th>
                            <th>User Id</th>
                            <th>Income</th>



                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($daily_ad_view_income))
                        @php($s=1)
                        @foreach($daily_ad_view_income as $dc)

                        <tr>
                            <td>{{$s}}</td>
                            <td>{{ date('d-m-Y',strtotime($dc->created_date))}}</td>
                            <td>{{$dc->member_id}}</td>
                            <td>{{$dc->amount}}</td>



                        </tr>
                        @php($s++)
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>

            {{ $daily_ad_view_income->links() }}

            @endif

            @if(isset($level_ad_view_income))

            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Level income report</h2>
            </div>

            <div class="table-responsive table-wrapper">
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Level</th>
                            <th>Date</th>
                            <th>User Id</th>
                            <th>User Name</th>

                            <th>Amount</th>


                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($level_ad_view_income))
                        @php($s=1)
                        @foreach($level_ad_view_income as $dc)

                        <tr>
                            <td>{{$dc->rank}}</td>
                            <td>{{ date('d-m-Y',strtotime($dc->created_date))}}</td>
                            <td>{{$dc->direct_member_id}}</td>
                            <td>{{get_user_details($dc->direct_member_id)}}</td>

                            <td>{{$dc->amount}}</td>





                        </tr>
                        @php($s++)
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            {{ $level_ad_view_income->links() }}

            @endif


            @if(isset($community_income_upline))
            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Community Upline Income Report</h2>
            </div>

            <div class="table-responsive table-wrapper">
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <!-- <th>Level</th> -->
                            <th>Date</th>
                            <th>User Id</th>
                            <th>User Name</th>
                            <th>Level</th>

                            <th>Amount</th>

                            <th>Wallet Amount</th>


                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($community_income_upline))
                        @php($s=1)
                        @foreach($community_income_upline as $dc)

                        <tr>
                            <!-- <td>{{$dc->rank}}</td> -->
                            <td>{{ date('d-m-Y',strtotime($dc->created_date))}}</td>
                            <td>{{$dc->direct_member_id}}</td>
                            <td>{{get_user_details($dc->direct_member_id)}}</td>
                            <td>{{$dc->level}}</td>
                            <td>{{$dc->amount}}</td>
                            <td>{{$dc->in_wallet}}</td>





                        </tr>
                        @php($s++)
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            {{ $community_income_upline->links() }}

            @endif

            @if(isset($community_income_downline))

            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Community Downline Income Report</h2>
            </div>

            <div class="table-responsive table-wrapper">
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <!-- <th>Level</th> -->
                            <th>Date</th>
                            <th>User Id</th>
                            <th>User Name</th>

                            <th>Level</th>

                            <th>Amount</th>

                            <th>Wallet Amount</th>


                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($community_income_downline))
                        @php($s=1)
                        @foreach($community_income_downline as $dc)

                        <tr>
                            <!-- <td>{{$dc->rank}}</td> -->
                            <td>{{ date('d-m-Y',strtotime($dc->created_date))}}</td>
                            <td>{{$dc->direct_member_id}}</td>
                            <td>{{get_user_details($dc->direct_member_id)}}</td>

                            <td>{{$dc->level}}</td>
                            <td>{{$dc->amount}}</td>
                            <td>{{$dc->in_wallet}}</td>





                        </tr>
                        @php($s++)
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            {{ $community_income_downline->links() }}

            @endif


            @if(isset($commision_majic_pool))
            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Majic Pool Income Report</h2>
            </div>
            @php($groupedData = $commision_majic_pool->groupBy('package_id'))
            @foreach ($groupedData as $packageId => $entries)
            <div class="table-responsive table-wrapper mb-4">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="item-magic d-flex align-items-center gap-2 px-3 py-1">
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="{{url('/')}}/public/admin/assets/images/png/table-icon.png" alt="icon"
                                    height="35">
                            </div>
                            <h5 class="mb-0 font-20 text-white medium">Magic Pool 01</h5>
                        </div>
                    </div>
                    <div class="d-flex gap-3 align-items-center">
                        <div class="item-entry w-auto h-auto px-3 py-2">
                            <h5 class="mb-0 font-20 text-white medium">Entry Fee = 2$</h5>
                        </div>
                        <div class="item-view w-auto h-auto  px-3 py-2">
                            <h5 class="mb-0 font-20 text-white medium">View Income</h5>
                        </div>
                    </div>
                </div>
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <!-- Dynamic Header for Each Package -->
                            <th colspan="8"> {{ $entries->first()->pack_package_name }} </th>


                        </tr>
                        <tr>
                            <th>Level</th>
                            <th>Entry</th>
                            <th>Team</th>
                            <th>Amount</th>
                            <th>Upgrade</th>
                            <th>Re-Birth</th>
                            <th>Profit</th>
                            <th>Cycle</th>
                        </tr>
                    </thead>
                    <!-- <tbody>
                        @php($s = 1)
                        @foreach ($entries as $cmp)

                        <tr>
                            <td>{{ $cmp->level }}</td>
                            <td><b>{{ $cmp->entry_fee }}</b></td>
                            <td>{{ $cmp->team }}</td>
                            <td>{{ $amt = $cmp->team * $cmp->entry_fee }}</td>
                            <td>{{ $cmp->upgrade == 0 ? '-' : $cmp->upgrade }}</td>
                            <td>{{ $cmp->re_birth == 0 ? '-' : $cmp->re_birth }}</td>
                            <td>{{ $amt - $cmp->upgrade - $cmp->re_birth }}</td>
                            <td>{{ $cmp->cycle }}</td>
                        </tr>

                        @if ($cmp->cycle > 1 && $cmp->level == 2)
                        <?php
                    // Calculate previous cycle and total previous income for Level 1
                   
                        $prev_cycle = $cmp->cycle - 1;
                        $total_prev_income = $prev_cycle *  $cmp->pack_profit;
                    
                ?>
                        <tr>
                            <td colspan="8" style="text-align:right;">CYCLE - {{ $prev_cycle }} Total Income
                                = {{ $total_prev_income }}</td>
                        </tr>
                        @endif

                        @php($s++)
                        @endforeach
                    </tbody> -->

                    <tbody>
                        <tr class="row-highlight">
                            <td>1</td>
                            <td>4.00</td>
                            <td>0</td>
                            <td>0</td>
                            <td>-</td>
                            <td>-</td>
                            <td>0</td>
                            <td>1</td>
                        </tr>

                        <tr class="row-blur">
                            <td>2</td>
                            <td>4.00</td>
                            <td>0</td>
                            <td>0</td>
                            <td>-</td>
                            <td>-</td>
                            <td>0</td>
                            <td>1</td>
                        </tr>

                        <tr class="row-blur">
                            <td>3</td>
                            <td>8.00</td>
                            <td>0</td>
                            <td>0</td>
                            <td>-</td>
                            <td>-</td>
                            <td>0</td>
                            <td>1</td>
                        </tr>
                    <tfoot>
                        <tr class="custom-footer">
                              <th></th>
                            <th></th>
                               <th></th>
                            <th></th>
                            <th colspan="2" class="regular text-center" style="color: #F8E700;">
                                 <img src="{{url('/')}}/public/admin/assets/images/svg/refresh.svg" alt="refresh">
                                Cycle 1</th>
                            <th colspan="2" class="regular text-center" style="color: #F8E700;">Income = 36 $</th>
                         
                        </tr>
                    </tfoot>


                    </tbody>
                </table>
            </div>
            @endforeach


            @endif



            @if(isset($commision_majic_pool_history))

            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Magic Pool History</h2>
            </div>
            <div class="table-responsive table-wrapper">
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Slno</th>
                            <th>Date</th>
                            <th>Package</th>
                            <th>Cycle </th>

                            <th>Level</th>

                            <th>Income</th>




                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($commision_majic_pool_history))
                        @php($s=1)
                        @foreach($commision_majic_pool_history as $dc)

                        <tr>
                            <td>{{$s}}</td>
                            <td>{{ date('d-m-Y',strtotime($dc->date))}}</td>
                            <td>{{$dc->pack_package_name}}</td>
                            <td>{{$dc->cycle}}</td>

                            <td>{{$dc->level}}</td>


                            <td>{{$dc->profit_level}}</td>




                        </tr>
                        @php($s++)
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            {{ $commision_majic_pool_history->links() }}

            @endif


            @if(isset($procust_purchase_income))

            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Re-Purchase income report</h2>
            </div>
            <div class="table-responsive table-wrapper">
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Level</th>
                            <th>Date</th>
                            <th>User Id</th>
                            <th>User Name</th>

                            <th>Amount</th>


                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($procust_purchase_income))
                        @php($s=1)
                        @foreach($procust_purchase_income as $dc)

                        <tr>
                            <td>{{$dc->rank}}</td>
                            <td>{{ date('d-m-Y',strtotime($dc->created_date))}}</td>
                            <td>{{$dc->direct_member_id}}</td>
                            <td>{{get_user_details($dc->direct_member_id)}}</td>

                            <td>{{$dc->amount}}</td>





                        </tr>
                        @php($s++)
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            {{ $procust_purchase_income->links() }}

            @endif



            @if(isset($direct_income))


            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Direct income report</h2>
            </div>

            <div class="table-responsive table-wrapper">
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Sl no</th>
                            <th>Date</th>
                            <th>User Id</th>
                            <th>User Name</th>
                            <th>Level</th>
                            <th>Amount</th>


                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($direct_income))
                        @php($s=1)
                        @foreach($direct_income as $dc)

                        <tr>
                            <td>{{$s}}</td>
                            <td>{{ date('d-m-Y',strtotime($dc->created_date))}}</td>
                            <td>{{$dc->direct_member_id}}</td>
                            <td>{{get_user_details($dc->direct_member_id)}}</td>
                            <td>{{$dc->rank}}</td>
                            <td>{{$dc->amount}}</td>





                        </tr>
                        @php($s++)
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            {{ $direct_income->links() }}

            @endif



            @if(isset($reward_income))

            <!-- Header -->
            <div class="card-title-border">
                <h2 class="card-title">Reward Income report</h2>
            </div>
            <div class="table-responsive table-wrapper">
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Sl no</th>
                            <th>Date</th>
                            <th>User Id</th>
                            <th>Income</th>



                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($reward_income))
                        @php($s=1)
                        @foreach($reward_income as $dc)

                        <tr>
                            <td>{{$s}}</td>
                            <td>{{ date('d-m-Y',strtotime($dc->created_date))}}</td>
                            <td>{{$dc->member_id}}</td>
                            <td>{{$dc->amount}}</td>



                        </tr>
                        @php($s++)
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>

            @endif

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



    $(document).ready(function () {
        $('#datatable-buttons-new').DataTable({

            paging: false, // Disable pagination
        });
    });
</script>




@endpush