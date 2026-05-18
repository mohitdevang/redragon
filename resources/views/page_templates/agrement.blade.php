@extends('layouts.user_profile')
@section('content')



               <div class="content-page">
            <!-- Start content -->
  <div class="content">
                    <div class="container-fluid">
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">Agrement</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $setting->title }}</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Members</a></li>
                                        <li class="breadcrumb-item active">Agrement</li>
                                    </ol>
                                </div>
                            </div> <!-- end row -->
                        </div>
                        <!-- end page-title -->

                 
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                 <form class="form-horizontal m-t-30" id="active-pin-form" action="{{route('submit_agrement')}}" method="post" enctype="multipart/form-data">


        {{ csrf_field() }}
        
       <h3> Terms and Conditions Digital Ads</h3>
<ol>
<li> This is not a mlm platform this is pure advertisement based platform we are here Digital Ads Company Takes advertisement from market and generate revenue and also distributing them among our valuable members</li>


<li>  The Subscription Package we are having in this platform is not Stable we can change it further as per market situation and demand without prior notice</li>

<li> The Income Calculation we are currently having is not stable it may decrease Or increase according to market situation. </li>

<li> Subscription Charge is not refundable once after ID Activation so please read carefully then proceed further</li>
<li> If Company find anything illegal or unwanted activities from your side then company have right to block your id without notice and it can't be unblock in future</li>
<li> For Working In Company on Regular Basis You have to follow company Terms and Conditions</li>
<li> The Subscription Charges We are Taking Is only Valid for 45 days and after that you have purchase new subscription package with in 3 days otherwise your id may get blocked</li>
</ol>

                                        
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Agree</button>
                                 
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
        

                        
                    </div>
                    <!-- container-fluid -->

                </div>
                <!-- container-fluid -->

            </div>


 @endsection
 @push('js')



 @endpush