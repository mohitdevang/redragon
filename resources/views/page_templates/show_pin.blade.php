@extends('layouts.user_profile')
@section('content')



               <div class="content-page">
            <!-- Start content -->
  <div class="content">
                    <div class="container-fluid">
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">Data Table</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $setting->title }}</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Members</a></li>
                                        <li class="breadcrumb-item active">My Pins</li>
                                    </ol>
                                </div>
                            </div> <!-- end row -->
                        </div>
                        <!-- end page-title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
        
                                        <h4 class="mt-0 header-title">Pins</h4>


    @if(Session::has('success')) 
    
    <p class="alert alert-success">{!! Session::get('success') !!}</p>
    @elseif(Session::has('danger')) 
    <p class="alert alert-danger">{!! Session::get('danger') !!}</p>
    
    @endif

    <a href="{{ route('send_request')}}"><button class="btn btn-info" type="button">Send Pin Request</button> </a>
                                        
        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Pin</th>                                   
                                                <th>Activation Date</th>                                         
                                                
                                                <th>Action</th>

                                                
                                              
                                            </tr>
                                            </thead>
        
        
                                            <tbody>
                                                @if(isset($pin))
                                                @foreach($pin as $pins)


                                            <tr>
                                                <td>{{$pins->pin}}</td>
                            
                                                <td>{{date("d-m-Y H:i a", strtotime($pins->updated_at))   }}</td>

                                              

                                             
                                               <td width="10%">
                                                @if($pins->status=='inactive')
                <span class="btn btn-info"><a style="color:#fff;" href="{{ route('active_pin_view',$pins->id ) }}">Active</a></span>
                @else
                Activated
                @endif
            
                </td>
                                                
                                              
                                            </tr>
                                            @endforeach
                                            @else
                                            <p>No active record found</p>

                                            @endif
                                            
                                            </tbody>
                                        </table>
        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
        

                        
                    </div>
                    <!-- container-fluid -->

                </div>
                <!-- container-fluid -->

            </div>


 @endsection
 @push('js')

<script>

$(document).ready(function() {

$.validator.addMethod("emailRegex",function(value, element) {
        if(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test( value ))
        { return true;} else{ return false;}    
  },"Please enter a valid Email.");
  
$.validator.addMethod("nameRegex", function (value, element) {
        return this.optional(element) || /^([a-zA-Z_-\s]{3,20})$/.test(value);
    }, "Enter valid name");


        $("#register-form").validate({

          errorElement: 'span',
          errorClass: 'help-block',
          highlight: function(element, errorClass, validClass) {
            $(element).addClass("has-error");
          },
          unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("has-error");
          },
          errorPlacement: function (error, element) {
            if (element.attr("type") == "checkbox") {
                //error.insertAfter($(element).parent());
            }else{ 
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
                cpws:{
                    required: true,
                    equalTo : "#userpwd"
                },

                 phone:{
                     required: true,
                    minlength: 8,
                    maxlength: 13,
                    digits: true    
                },
                 sponsor_id:{
                    required: true
                },

                sponsor_name:{
                    required: true
                },

                country:{
                    required: true
                },

            },

           

        });

    });

</script>


 @endpush