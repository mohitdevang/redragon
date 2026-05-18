@extends('layouts.user_profile')

@section('content')

           <div class="content-page dashboard-content-page">

            <!-- Start content -->

            <div class="content text-center">

                <div class="container-fluid">

                    <div class="page-title-box">

                        <div class="row align-items-center">

                            <div class="col-sm-6">

                                <h4 class="page-title"></h4>

                            </div>

                            <div class="col-sm-6">

                                <ol class="breadcrumb float-right">

                                    <li class="breadcrumb-item"><a class="text-white" href="javascript:void(0);">Member Panel</a></li>

                                    <li class="breadcrumb-item active text-white">Dashboard</li>

                                </ol>

                            </div>

                        </div>

                        <!-- end row -->

                    </div>

                    <!-- end page-title -->

				<div class="row">



                        <div class="col-sm-12 col-xl-12">

                            <div class="card">

			<marquee onmouseover="this.stop();"

           onmouseout="this.start();"   style="height:60px;" ><h3 class="text-danger">{!!$setting->noti_dashboard!!}</h3></marquee>

 </div> </div> </div>



<!----------------------------------------------------------------- START NEW DIV ---------------------------------------------->

<!----------------------------------------------------------------- START NEW DIV ---------------------------------------------->

<!----------------------------------------------------------------- START NEW DIV ---------------------------------------------->





{{ csrf_field() }}

      @if($message = Session::get('error'))

                <div class="alert alert-danger" role="alert">

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                        <span aria-hidden="true">×</span>

                    </button>

                    <strong>Error!</strong> {{ $message }}

                </div>

            @endif

            {!! Session::forget('error') !!}

            @if($message = Session::get('success'))

                <div class="alert alert-info" role="alert">

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                        <span aria-hidden="true">×</span>

                    </button>

                    <strong>Success!</strong> {{ $message }}

                </div>

            @endif

            {!! Session::forget('success') !!}







<div class="card dashboard-card" id="video_panel">

{{--     @if(Auth::guard()->user()->status=='active')  --}}

 <div class="row">

    <div class="col-md-4">



        

               

    

    </div>

     <div class="col-md-4">

            

             <div id="video_panel" class="ad-panel text-center">

            

               

              <img src="{{url('/')}}/public/design/images/R.jpeg" width="420" height="345">

            

            

             

             <button class="btn btn-rounded btn-success mlrauto  btn-red"  onclick="get_next_video('0')" id="play"> Play</button>

           

             </div>

            

     </div>

    <div class="col-md-4">

        <div class="box-body">

            <div class="d-flex align-items-center justify-content-between">

            <div>

            <h4 class="mb-0 tab-size17">Ads Time</h4>

             <h2 class="mb-0 tab-size17" style="color: #f18179">

            <span id="some_div">{{ $setting->ads_for_time}} Sec</span></h2>

            </div>

           <i class="fa fa-clock" aria-hidden="true"></i>

            </div>

        </div>

        <div class="box-body">

            <div class="d-flex align-items-center justify-content-between">

            <div>

            <h4 class="mb-0 tab-size17"> Video Rs</h4>

             <h2 class="mb-0 tab-size17" style="color: #f18179">Rs.

            <span id="ContentPlaceHolder1_lblVideoIncome">{{ $setting->per_video_income}}</span></h2>

            </div>

           <i class="fas fa-money-bill-alt"></i>

            </div>

        </div>

        

        

    </div>

  </div>

{{--  @else

  

  <h4 class="suscription1-h4">Subscription<sup>₹</sup>{!!$setting->pin_amt!!}<span></span></h4>

  <h4 class="suscription2-h4">Valid Only <span>  {!!$setting->activate_day!!} Days.</span></h4>

  <!--  <h4 class="suscription1-h4"><sup>₹</sup><span class="strike">999</span> <span class="blinker" style="color:#2c8ef3 !important;"> 70% Off</span></h4>

    <h4 class="suscription1-h4 size19">Purchase Now<sup style="color:#5dc321 !important;">₹</sup><span style="color:#5dc321 !important;">300</span> <span style="color:#5dc321 !important;"> Only</span></h4> -->

    

 <!-- <h3 style="color: #354558;">Subscription <span style="font-weight:100;"><span class="rupee-sp">₹</span>999</span> </h3>

  <h4 style="color: #354558;"><span class="strike"><span class="rupee-sp2">₹</span>999 </span> 70% Off</h4

  <h4 style="color: #354558;">Purchase Now <span style="font-weight:100;"> <span class="rupee-sp3">₹</span>300 </span>Only</h4>>-->

  <!--<h4><b>Special off now Rs.{{ $setting->activation_price_rs}} for {{ $setting->activate_day}} days</b></h4>-->

  

<a href="{{url('/')}}/show-my-pin"><button class="btn-rounded btn-success mlrauto blue-btn" type="button">Purchase</button></a>

  @endif  --}}

</div>










 @endsection



@push('js')

<script type="text/javascript">

 var second={{$setting->ads_for_time_in_milsecond}};

    var timeLeft ={{$setting->ads_for_time}};





    

    

    

function play_video(){

    $('#play').hide();



    var elem = document.getElementById('some_div');

    

    var timerId = setInterval(countdown, 1000);

    

    function countdown() {

      if (timeLeft == -1) {

        clearTimeout(timerId);

     

      } else {

        elem.innerHTML = timeLeft + ' seconds';

        timeLeft--;

      }

    }

    

    

    var videoURL = $('#midea_video').prop('src');

videoURL += "&autoplay=1";

$('#midea_video').trigger('play');



   var videoURL = $('#youtube_video').prop('src');

videoURL += "&autoplay=1";

$('#youtube_video').prop('src',videoURL);

 setTimeout(function(){ 



        $('#some_div').fadeOut();

        $('#next_btn').show();



    }, second); 

}





//     $(document).ready(function(){ 

//     setTimeout(function(){ 



//         $('#some_div').fadeOut();

//         $('#next_btn').show();



//     }, second); 

// });





    function  get_next_video(id) {

          $('#next_btn').hide();

         var token = $('input[name="_token"]').val();

        $.ajax({

    type: 'post',

    url: '{{ route('get_next_video')}}',

    data : {'_token': token,'video_id':id},

   dataType: 'JSON',

    success :  function(data){

                

                   if(data.success){

                   

         // $('#video_panel').show();

        

                   

                    $('#video_panel').html(data.success);   



                 //   $('#next_btn').attr('onclick','get_next_video(''+data.id+'")')  ;   

                    

                    $('#total_video_earning').html(data.total_video_earning);

                    $('#total_level_earning').html(data.total_level_earning);

                    $('#video_balance').html(data.video_balance);

                    $('#level_balance').html(data.level_balance);

                    

                    

                    



                                            var timeLeft = {{$setting->ads_for_time}};

    var elem = document.getElementById('some_div');

    

    var timerId = setInterval(countdown, 1000);



     function countdown() {

      if (timeLeft == -1) {

        clearTimeout(timerId);

     

      } else {

        elem.innerHTML = timeLeft + ' seconds';

        timeLeft--;

      }

    }





                       setTimeout(function(){ 



        $('#some_div').fadeOut();

        $('#next_btn').show();



    }, second); 





                   } else if(data.err) {

                       $('#video_panel').html(data.err);

                     

                   }     

                   else if(data.expire){

                    window.location.href='{{url('/')}}';

                   }       







                }

});

    }

</script>

@endpush