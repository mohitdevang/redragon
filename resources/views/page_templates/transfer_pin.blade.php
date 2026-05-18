@extends('layouts.user_profile')
@section('content')



               <div class="content-page">
            <!-- Start content -->
  <div class="content">
                    <div class="container-fluid">
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">Transfer Pin</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $setting->title }}</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Members</a></li>
                                        <li class="breadcrumb-item active">Transfer Pin</li>
                                    </ol>
                                </div>
                            </div> <!-- end row -->
                        </div>
                        <!-- end page-title -->

                 
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                 <form class="form-horizontal m-t-30" id="active-pin-form" action="{{ route('transfer.pin') }}" method="post">
        {{ csrf_field() }}

        
    @if(Session::has('success')) 
    
    <p class="alert alert-success">{!! Session::get('success') !!}</p>
    @elseif(Session::has('danger')) 
    <p class="alert alert-danger">{!! Session::get('danger') !!}</p>
    
    @endif
               

         <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Total Trasnferable Pin</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="@if(isset($total_pin)){{$total_pin}} @endif" readonly >
                                              
                                            </div>
                                        </div>
                                       
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Number of Pin you transfer</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text"  name="number_of_pin" >
                                              
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-2 col-form-label">Member Id</label>
                                            <div class="col-sm-10">
                                               <input class="form-control" type="text" value="{{Auth::guard()->user()->unique_id}}"  name="member_unique_id" id="member_unique_id">
                                                <span style="color: red;" id='sponsor_id_err' required></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-email-input" class="col-sm-2 col-form-label">Member Name</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{Auth::guard()->user()->name}}"  name="member_name" id="member_name" required>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                 
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

<script>
$(document).ready(function() {



        $("#member_unique_id").keyup(function(){
            var token = $('input[name="_token"]').val();
        $.ajax({
    type: 'post',
    url: '{{ route('get_sopnsor_name')}}',
    data : {'_token': token,'sponsor_id':$(this).val()},
   dataType: 'JSON',
    success :  function(data){
                
                   if(data.success){
                   $('#member_name').val(data.success);                    
                   $('#sponsor_id_err').html('')
                   } 
                   if(data.err){
                    $('#sponsor_id_err').html('wrong sponsor id');
                    $('#member_name').val('');
                   }

                }
});


});




    });


</script>


 @endpush