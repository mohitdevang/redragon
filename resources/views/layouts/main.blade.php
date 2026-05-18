<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{!! asset('public/uploads/'.$setting->favicon) !!}" type="image/png">

    <title>{{ $setting->title }} | @yield('title')</title>

    <style>
      .preloader{
      width:100%;
      height:100%;
      top:0px;
      position:fixed;
      z-index:99999;
      background: url({!! asset('public/public/admin-design/images/loader.gif') !!}) center no-repeat #fff;
      }
    </style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

<!-- CSS -->
<link rel="stylesheet" href="{{ asset('public/admin-design/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin-design/css/sb-admin.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin-design/style.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin-design/plugins/morris.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin-design/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin-design/data-table/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin-design/css/data-table/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin-design/css/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin-design/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin-design/css/bootstrap-fileupload.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin-design/css/summernote.css') }}">




    @stack('custom-css')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

  <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
        </svg>
  </div>

    <div id="wrapper">

      @include('elements.admin.header')
      @include('elements.admin.leftbar')
      @yield('content')  
      @include('elements.admin.footer')

    </div>

 
<!-- JS -->
<script src="{{ asset('public/admin-design/js/jquery.js') }}"></script>
<script src="{{ asset('public/admin-design/js/bootstrap.min.js') }}"></script>

<!-- Morris Charts -->
<script src="{{ asset('public/admin-design/js/plugins/morris/raphael.min.js') }}"></script>
<script src="{{ asset('public/admin-design/js/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('public/admin-design/js/plugins/morris/morris-data.js') }}"></script>

<script src="{{ asset('public/admin-design/js/jquery-ui.js') }}"></script>
<script src="{{ asset('public/admin-design/js/jquery.breadcrumbs-generator.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('public/admin-design/js/data-table/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin-design/js/data-table/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('public/admin-design/js/data-table/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('public/admin-design/js/data-table/buttons.flash.min.js') }}"></script>
<script src="{{ asset('public/admin-design/js/data-table/jszip.min.js') }}"></script>
<script src="{{ asset('public/admin-design/js/data-table/buttons.html5.min.js') }}"></script>
<script src="{{ asset('public/admin-design/js/data-table/buttons.print.min.js') }}"></script>

<!-- Others -->
<script src="{{ asset('public/admin-design/js/select2.full.min.js') }}"></script>
<script src="{{ asset('public/admin-design/js/bootstrap-fileupload.js') }}"></script>
<script src="{{ asset('public/admin-design/js/summernote.js') }}"></script>


    @stack('custom-js')

<script type="text/javascript">
var APP_URL = {!! json_encode(url('/')) !!};
</script> 
  
{{-- --Loader-- --}}

<script>

  $(document).ready(function() {
  $('.ckeditor').summernote();
});

$(function(){

$(".preloader").fadeOut("slow");

});

</script>

{{-- --End Loader-- --}}

{{-- -----inactivity-- --}}

<script>

function idleTimer() {

    var t;

    window.onload = resetTimer;

    window.onmousemove = resetTimer; // catches mouse movements

    window.onmousedown = resetTimer; // catches mouse movements

    window.onclick = resetTimer;     // catches mouse clicks

    window.onscroll = resetTimer;    // catches scrolling

    window.onkeypress = resetTimer;  //catches keyboard actions



    function logout() {

        window.location.href = '{{ route('admin.logout') }}';  //Adapt to actual logout script

    }



   /*function reload() {

          window.location = self.location.href;  //Reloads the current page

   }*/



   function resetTimer() {

        clearTimeout(t);

        t = setTimeout(logout, 900000);  // time is in milliseconds (1000 is 1 second)

        //t= setTimeout(reload, 300000);  // time is in milliseconds (1000 is 1 second)

    }

}

//idleTimer();

</script>

{{-- ---End inactivity-- --}}

{{-- ---Sortable-- --}}

<script>

$( function() {

    $( "#interchange" ).sortable({

    containment:"#containment-wrapper",

    revert:true,

    cancel:".scroll-none"

  });

  $( "#task-panel" ).sortable({

    containment:".parent-task-panel",

    revert : true,

    cancel : "#task-panel .panel-body"

  });

  $( "#task-panel2" ).sortable({

    containment:".parent-task-panel2",

    revert : true,

    cancel : "#task-panel2 .panel-body"

  });

  $( "#content-sortable" ).sortable({

    containment:".parent-content-wrapper",

    revert : true,

    cancel : "#content-sortable .panel-body,#content-sortable .panel-title"

  });

  
}); 

</script>

{{-- ----End Sortable--- --}}

{{-- ---Datatable---- --}} 

<script>

$(function(){

   $('#example').DataTable({

     "pageLength": 10,

      dom: 'Bfrtip',

        buttons: [

            'copy', 'csv', 'excel', 'print'

        ],
    "columnDefs": [ { "targets": 0, "orderable": false} 
    ]

  });
      
});

$(function(){

   $('#example1').DataTable({

    //  "pageLength": 10,
"paging": false,
      dom: 'Bfrtip',

        buttons: [

            'copy', 'csv', 'excel', 'print'

        ],
    "columnDefs": [ { "targets": 0, "orderable": false} 
    ]

  });
      
});

$(function(){

   $('.example').DataTable({

      "pageLength": 10,

      dom: 'Bfrtip',

        buttons: [

            'copy', 'csv', 'excel', 'print'

        ],
    "columnDefs": [ { "targets": 0, "orderable": false} 
    ]

  });
      
});

</script>

{{-- ---End Datatable---- --}} 

{{-- ---tinymce---- --}} 

<script>

$(function() {

        if ($("#mymce").length > 0) {

             tinymce.init({
                selector: "textarea#mymce",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }
    });

</script>

{{-- ---End tinymce---- --}} 

{{-- ---Nice Scroll-- --}}

<script>

$(function(){ 

   $("html").niceScroll({cursorcolor:"#1BBB9C",cursorborder:"none",cursorwidth: "10px"});

   $(".side-nav").niceScroll({cursorcolor:"#1BBB9C",cursorborder:"none"});

});

</script>

{{-- ---End Nice Scroll-- --}}

{{-- ---Slide up-down div--- --}}

<script>

$(function(){

 $('.collapse-link').click(function(){

 var p = $(this).closest('.panel-default').find('.panel-body');

  if(p.is(':visible')){

  p.slideUp(500);

  $(this).html('<i class="fa fa-chevron-down"></i>');

  }

  else {

  p.slideDown(500);

  $(this).html('<i class="fa fa-chevron-up"></i>');

  }

 });
 
});

</script>

{{-- ---End Slide up-down div--- --}}

{{-- ---End datepicker--- --}}

<script>

$( function() {

   $( ".datepicker" ).datepicker({

          dateFormat: "dd-mm-yy",
          changeYear: true,
          changeMonth: true,
          yearRange: '2015:2030'

      });

     });
  
</script>

{{-- ---End datepicker--- --}}

{{-- ----Breadcrumb----- --}}

<script>

$(function() {

  $('.breadcrumb').breadcrumbsGenerator();

});

</script>

{{-- ----End breadcrumb----- --}}

{{-- ----Select2----- --}}

<script>

$(function() {

  $(".select2").select2({

    tags: "true",
    placeholder: "Select an option",
    allowClear: true

  });

});

</script>

{{-- ----End Select2----- --}} 

{{-- ----Validation before multiple delete---- --}}

<script>
  
function datatable_validation(){

var value = $('.chkItems:checked').length;

if(value > 0) {

return confirm('Are you sure you want to delete selected item(s)?');

} else {

$("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="glyphicon glyphicon-remove-sign"></span> <strong>Error : </strong><span>&nbsp; Please select item(s) to delete !</span></div>');
setTimeout( function(){
$('#info').load(location.href +  ' #info');
},5000);

return false;

}

}

</script>

{{-- ------End---- --}}

{{-- ------Check/Uncheck all--- --}}

<script>

function checkUncheckAll(sender) {

            var chkElements = document.getElementsByClassName('chkItems');

            for (var i = 0; i < chkElements.length; i++) {

                chkElements[i].checked = sender.checked;

            }

        
}

</script>

{{-- ----End--- --}}

{{-- -----Check parent---- --}}

<script>

function checkUnCheckParent() {

            var chkHeader = document.getElementById('chkHeader');

            var chkElements = document.getElementsByClassName('chkItems');

            var checkedCount = 0;

            for (var i = 0; i < chkElements.length; i++) {

                if (chkElements[i].checked) {

                    checkedCount += 1;

                }

            }

            chkHeader.checked = (checkedCount === chkElements.length);

        
}

</script>

{{-- ---End--- --}}

{{-- ---Alert msg slideup--- --}}

<script>

$(function(){

 $('#information').delay(5000).slideUp();

});

</script>

{{-- ---End Alert msg slideup--- --}}

{{-- ---Sidebar Menu active---- --}}

<script>

$(function () {

    var url = window.location;

    $('#sidebar-menu a[href="' + url + '"]').parent('li').addClass('current-page');

    $('#sidebar-menu a').filter(function () {

        return this.href == url;

    }).parent('li').addClass('current-page').parent('ul').slideDown().parent().addClass('active');

});

</script>

{{-- ---End Sidebar Menu active ---- --}}

<script>

<!-------Add div------>

var x=1;
function add_element(item_id,controller){
        $('#input_fields_wrap').append('<div class="col-md-12 custom-field"><div class="col-md-3"><input class="form-control" id="add_meta_key'+x+'" name="meta_key" placeholder="key_name" type="text" value=""></div><div class="col-md-8"><textarea id="add_meta_value'+x+'" class="form-control" name="meta_value" placeholder="content goes here.."></textarea></div><div class="col-md-1"><a class="btn btn-success pull-right m-b-10" onclick="insert_meta('+x+','+item_id+',\'' + controller + '\')">Save</a><a class="btn btn-danger pull-right" onclick="remove_element(this)">Remove</a></div></div>'); 
  x++; 
} 

<!------End----->

<!-------Remove div------>

function remove_element(param){ 
        if(confirm('Are you sure you want to delete selected item(s)?')){
    param.closest('.custom-field').remove();
    }
  
}

<!------End----->

<!------Remove Meta---->

function remove_meta(para,meta_id,controller){ 
        if(confirm('Are you sure you want to delete selected item(s)?')){
		 var el = para.closest('.custom-field');
		 var token = $('input[name="_token"]').val();
			$.ajax({
        async: false,
				type: 'delete',
        url: APP_URL + '/admin/' + controller + '/meta/delete/'+ meta_id,
				data : {'_token': token},
				success :  function(response){
				
				   if(response.status === true){
					
					
            el.remove();

				    $('.info').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <span class="glyphicon glyphicon-ok-sign"></span> &nbsp;'+response.success+'</div>').delay(3000).slideUp();
					setTimeout( function(){
				   $('#input_fields_wrap').load(location.href +  ' #input_fields_wrap');
				   $('#meta_sugg_box').load(location.href +  ' #meta_sugg_box');
				   },3000);
								 
				   } else {
				   
				   $('.info').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <span class="glyphicon glyphicon-remove-sign"></span> &nbsp;'+response.danger+'</div>').delay(5000).slideUp();
				   setTimeout( function(){
				   $('#input_fields_wrap').load(location.href +  ' #input_fields_wrap');
				   $('#meta_sugg_box').load(location.href +  ' #meta_sugg_box');
				   },5000);
				  
				 
				   }
				},
				error: function(xhr){

            $('.info').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <span class="glyphicon glyphicon-remove-sign"></span> &nbsp;'+xhr.responseText+'</div>').delay(5000).slideUp();
           setTimeout( function(){
           $('#input_fields_wrap').load(location.href +  ' #input_fields_wrap');
           $('#meta_sugg_box').load(location.href +  ' #meta_sugg_box');
           },5000);
        }

			});
		
		}
	
}

<!------End---->

<!------Insert Meta---->

function insert_meta(slno,item_id,controller){ 
	
	var meta_key = $('#add_meta_key'+slno).val();
	var meta_value = $('#add_meta_value'+slno).val();
	var token = $('input[name="_token"]').val();
	  $.ajax({
        async: false,
				type: 'post',
        url:  APP_URL + '/admin/' + controller + '/meta/create',
				data : {'_token': token,'post_id':item_id,'meta_key':meta_key,'meta_value':meta_value},
				success :  function(response){
				
				   if(response.status === true){

				    $('.info').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <span class="glyphicon glyphicon-ok-sign"></span> &nbsp;' +response.success+ '</div>').delay(3000).slideUp();
					 setTimeout( function(){
				   $('#input_fields_wrap').load(location.href +  ' #input_fields_wrap');
				   $('#meta_sugg_box').load(location.href +  ' #meta_sugg_box');
				   },3000);
					
					 
				   } else {
				   
				   $('.info').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <span class="glyphicon glyphicon-remove-sign"></span> '+response.danger+' </div>').delay(5000).slideUp();
				   setTimeout( function(){
				   $('#input_fields_wrap').load(location.href +  ' #input_fields_wrap');
				   $('#meta_sugg_box').load(location.href +  ' #meta_sugg_box');
				   },5000);
				 
				   }
				},
				error: function(xhr){
                  
                  if(xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, value) {

                    $('.info').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <span class="glyphicon glyphicon-remove-sign"></span> '+value+' </div>').delay(5000).slideUp();
           
                     setTimeout( function(){
                     $('#input_fields_wrap').load(location.href +  ' #input_fields_wrap');
                     $('#meta_sugg_box').load(location.href +  ' #meta_sugg_box');
                     },5000);

                        
                    }); 

                } else {

                    $('.info').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <span class="glyphicon glyphicon-remove-sign"></span> '+xhr.statusText+' </div>').delay(5000).slideUp();
           
           setTimeout( function(){
           $('#input_fields_wrap').load(location.href +  ' #input_fields_wrap');
           $('#meta_sugg_box').load(location.href +  ' #meta_sugg_box');
           },5000);

                }
                }
			});
	

		
}

<!------End---->

<!------Update Meta---->
		
function update_meta(item_id,meta_id,slno,controller){
	var meta_key = $('#meta_key'+slno).val();
	var meta_value = $('#meta_value'+slno).val();
	var token = $('input[name="_token"]').val();
	  $.ajax({
        async: false,
				type: 'patch',
        url:  APP_URL + '/admin/' + controller + '/meta/update/'+ meta_id,
				data : {'_token': token,'post_id':item_id,'meta_key':meta_key,'meta_value':meta_value},
				success :  function(response){


				   if(response.status === true){

				    $('.info').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <span class="glyphicon glyphicon-ok-sign"></span> &nbsp;'+response.success+'</div>').delay(3000).slideUp();
					 setTimeout( function(){
				   $('#input_fields_wrap').load(location.href +  ' #input_fields_wrap');
				   $('#meta_sugg_box').load(location.href +  ' #meta_sugg_box');
				   },3000);

					
					 
				   } else {
				   
				   $('.info').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <span class="glyphicon glyphicon-remove-sign"></span> '+response.danger+' </div>').delay(5000).slideUp();
           
				   setTimeout( function(){
				   $('#input_fields_wrap').load(location.href +  ' #input_fields_wrap');
				   $('#meta_sugg_box').load(location.href +  ' #meta_sugg_box');
				   },5000);
				 
				   }
				},
				error: function(xhr){
                  
                  if(xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, value) {

                    $('.info').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <span class="glyphicon glyphicon-remove-sign"></span> '+value+' </div>').delay(5000).slideUp();
           
                     setTimeout( function(){
                     $('#input_fields_wrap').load(location.href +  ' #input_fields_wrap');
                     $('#meta_sugg_box').load(location.href +  ' #meta_sugg_box');
                     },5000);

                        
                    }); 

                } else {

                    $('.info').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <span class="glyphicon glyphicon-remove-sign"></span> '+xhr.statusText+' </div>').delay(5000).slideUp();
           
           setTimeout( function(){
           $('#input_fields_wrap').load(location.href +  ' #input_fields_wrap');
           $('#meta_sugg_box').load(location.href +  ' #meta_sugg_box');
           },5000);

                }
           		  }
			});
	
	
}



<!------End---->

</script>


  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
   $( ".datepicker" ).datepicker({
  dateFormat: "yy-mm-dd"
});
  } );
  </script>

  <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script type="text/javascript">
    $('.timepicker').timepicker({
    timeFormat: 'HH:mm:ss',
  
});
</script>
</body>

</html>
