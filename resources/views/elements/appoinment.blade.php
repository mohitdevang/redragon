<!-- Modal -->  
 <div class="modal zoom appointment-form" id="appoinment_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title text-center">Book an Appointment Online</h3>
                <button type="button" class="close" data-dismiss="modal" onclick="closeModal()"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <form id="myform" action="{{ route('booking.enquiry') }}" method="post" onsubmit="return checkCaptcha()">
                    {{ csrf_field() }}

      




                    <fieldset id="step2">
                        <h3 class="time-title">Choose The Date</h3>
                        <div class="row">
                            @php 
                            $date_from = strtotime(date("Y-m-d"));
                            $date_to = strtotime('+6 days');
                            @endphp
                            @for($i=$date_from; $i<=$date_to; $i+=86400)
                            @if(date('l',$i)!='Sunday')
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <div class="select-date">
                                    <input id="radio-{{$i}}" type="radio" name="select_date" value="{{ date('l',$i) }} - {{ date('d M Y', $i) }}" onclick="next()">
                                    <label for="radio-{{$i}}" class="select-date-inner">
                                        <h4>Book Now</h4>
                                        @if(strtotime(date("Y-m-d")) == $i)
                                        <p><b>{{ "Today" }}*</b></p>
                                        @else
                                        <p><b>{{ date("l",$i) }}</b></p>
                                        @endif
                                        <p>{{ date("d M Y", $i) }}</p>
                                    </label>
                                </div>
                            </div>
                            @endif
                            @endfor


                        </div>
                        <p class="p_text">*For same day booking please call us on <strong>020 70434316</strong></p>
                    </fieldset>
                    <fieldset id="step3">
                        <div class="text-center">
                            <h3 class="time-title">Choose The Time</h3>
                            <div id="get_result" class="row">
                            </div>
                        </div>
                        <div class="appoinment_footer">
                            <button class="previous pull-left btn" type="button">Previous</button>
                            
                        </div>
                    </fieldset>
                    
                    
                    <fieldset id="step4">
                        <h2 class="time-title">Select Services</h2>
                       <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="services_list">
                                    <input type="checkbox" class="form-check-input" name="services[]" value="Carpet Cleaning" required>
                                    <label class="select-services-inner"><h3>Carpet Cleaning</h3></label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="services_list">
                                    <input type="checkbox" class="form-check-input" name="services[]" value="Sofa Cleaning" required>
                                    <label class="select-services-inner"><h3>Sofa Cleaning</h3></label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="services_list">
                                    <input type="checkbox" class="form-check-input" name="services[]" value="Rug Cleaning" required>
                                    <label class="select-services-inner"><h3>Rug Cleaning</h3></label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="services_list">
                                    <input type="checkbox" class="form-check-input" name="services[]" value="Curtain Cleaning" required>
                                    <label class="select-services-inner"><h3>Curtain Cleaning</h3></label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="services_list">
                                    <input type="checkbox" class="form-check-input" name="services[]" value="Upholstery Cleaning" required>
                                    <label class="select-services-inner"><h3>Upholstery Cleaning</h3></label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="services_list">
                                    <input type="checkbox" class="form-check-input" name="services[]" value="Mattress Cleaning" required>
                                    <label class="select-services-inner"><h3>Mattress Cleaning</h3></label>
                                </div>
                            </div>
                        </div>

                        <div class="appoinment_footer">
                             <button class="submit pull-right btn" type="button"  onclick="next()">Next</button>
                            <button class="previous pull-left btn" type="button">Previous</button>
                        </div>
                    </fieldset>
                    
                    
                    
                    
                    <fieldset id="step5">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <h3 class="time-title">Appointment </h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-selected">
                                            <ul class="list-inline">
                                                <li id="selected-date"><i class="fa fa-calendar"></i></li>
                                            <!--     <li><i class="fa fa-clock-o"></i> Check-up Duration: 1 Hour</li> -->
                                            </ul>
                                        </div>
                                        <div class="single-selected">
                                            <ul class="list-inline">
                                                <li id="selected-time"><i class="fa fa-clock-o"></i> </li>
                                            </ul>
                                        </div>
                                        <div class="selected_services" id="services_div">
                                            <!-- <ul>
                                                <li id="selected-services">Carpet Cleaning</li>
                                                <li id="selected-services">Sofa Cleaning</li>
                                            </ul> -->
                                        </div>
                                 




                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 appointment-form text-left">
                                <h3 class="time-title">Fill Basic Information </h3>
                               
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Email (optional)</label>
                                    <input type="text" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Notes (optional)</label>
                                    <textarea rows="6" class="form-control" name="notes" placeholder=""></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="g-recaptcha modal_captcha" id="recaptcha2"></div>
                                </div>
                                <div class="form-group">
                                    <label>By clicking on submit button you are agreeing with our <a href="#">terms and condition.</a></label>
                                </div>
                                
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="previous pull-left btn" type="button">Previous</button>
                                    <button type="submit" class="submit pull-right btn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    
                    <fieldset id="step6" style="display:none;"> 
                            <div class="row">
                            <div class="col-md-12">
                            <p class="same_day_text">*For same day booking please call us on <strong>020 70434316</strong></p>
                            </div>
                            
                          <div class="col-md-12">
                            <button class="previous pull-left btn" type="button">Previous</button>
                        </div>
                        </div>
                   
                    </fieldset>
                </form>
            </div>
        </div>
        
    </div>
 </div>
@push('js')

<script>




function checkCaptcha(){
  var v2 = grecaptcha.getResponse(recaptcha2);
  if(v2.length == 0 || v2 == ''){ 
    $("#recaptcha2 iframe").addClass("errorClass");
    return false;
  }else{
    $("#recaptcha2 iframe").removeClass("errorClass");
    return true;
  }
}



/////////////////////////////////////////



        function next(){   

        var form = $("#myform");
        form.validate({
            errorElement: 'span',
            errorClass: 'help-block',
            highlight: function (element, errorClass, validClass) {
                $(element).addClass("has-error");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass("has-error");
            },
            errorPlacement: function (error, element) {
                if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
                    error.appendTo($(element).closest('fieldset'));
                } else {
                    //error.insertAfter(element);
                }
            },
                  
            rules: {
                select_date: {
                    required: true
                },

                select_time: {
                    required: true
                },
                
                
                name: {
                    required: true,
                    nameRegex: true
                },
                
                email: {
                    required: false,
                    emailRegex: false
                },
                
                phone: {
                    required: true,
                    minlength: 8,
                    maxlength: 13,
                    digits: true   
                }

            },
            messages: {
            
                select_date: {
                    required: "Please Select  Appointment Date"
                },

                select_time: {
                    required: "Please Select  Appointment Time"
                },
                
                name: {
                    required: "Please Enter Name"
                },
                
                email: {
                    required: "Please Enter Email"
                },
                
                phone: {
                    required: "Please Enter Phone Number"
                }
            }
        });
        if (form.valid() === true) {

        if ($('#step2').is(":visible")) {
            
                current_fs = $('#step2');
                next_fs = $('#step3');
                var token = "{{ csrf_token() }}";
                var select_date = $("input[name='select_date']:checked").val();
                var date = select_date.substring(select_date.indexOf("-") + 1);
                var dt = new Date(date);
                var selectday = dt.getDate();
                
                var Day = new Date();
                var today = Day.getDate();
               
                
                if(selectday==today)
                {
                  next_fs = $('#step6');
                }
                var wday_start='09:00';
                var wday_end='18:00';
                var wend_start='09:00';
                var wend_end='18:00';

              

                $.ajax({
                
                        type: 'POST',
                        url:  '{{ route('get.time.step') }}',
                        data : {'_token': token,'date' : date, 'wday_start' : wday_start,'wday_end' : wday_end,'wend_start' : wend_start,'wend_end' : wend_end},
                        dataType: 'html',
                          beforeSend: function() {
                           
                            $('#get_result').html(' <div id="ajax_loder"  ><img src="public/design/images/giphy.gif"></div>');
                             },
                        success :  function(response){
                            $('#get_result').html(response);
                        },
                        error: function(xhr){
                              console.log("An error occured: " + xhr.status + " " + xhr.statusText);
                        }
                
                
                });
            } else if ($('#step3').is(":visible")) {
                current_fs = $('#step3');
                next_fs = $('#step4');
            } else if ($('#step4').is(":visible")) {
              current_fs = $('#step4');
              next_fs = $('#step5');
            }
            else if ($('#step5').is(":visible")) {
              current_fs = $('#step5');
             
            }
            else if ($('#step6').is(":visible")) {
              current_fs = $('#step6');
             
            }
            next_fs.show();
            current_fs.hide();
        }
        
        if($('#step5').is(":visible")){
            
            var selected_date = $("input[name='select_date']:checked").val();
            var selected_time = $("input[name='select_time']:checked").val();
            var selected_package = $("input[name='package']:checked").val();
            $('#selected-date').html('<i class="fa fa-calendar"></i> ' + selected_date);
            $('#selected-time').html('<i class="fa fa-clock-o"></i> Time: '+selected_time);
            var ul='<ul>';
            $.each($("input[name='services[]']:checked"), function(){
                ul+='<li id="selected-services">'+$(this).val()+'</li>';
            });
           ul+='</ul>';
         $('#services_div').html(ul);

        }
}













    $('.previous').click(function () {
        if ($('#step5').is(":visible")) {
            current_fs = $('#step5');
            next_fs = $('#step4');
        }
        else if ($('#step4').is(":visible")) {
            current_fs = $('#step4');
            next_fs = $('#step3');
        }

        else if ($('#step3').is(":visible")) {
            current_fs = $('#step3');
            next_fs = $('#step2');
        } else if ($('#step2').is(":visible")) {
            current_fs = $('#step2');
            
        } 
        else if ($('#step6').is(":visible")) {
            current_fs = $('#step6');
            next_fs = $('#step2');
            
        } 
        next_fs.show();
        current_fs.hide();
    });

    $("input[name = 'package']").click(function(){
        $('.single-package').removeClass('active');
        $(this).closest('.single-package').addClass('active');
    });

</script>
<script>
function closeModal(){
  window.location.reload(); 
}
</script>
@endpush