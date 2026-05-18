<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{!! asset('public/uploads/'.$setting->favicon) !!}" type="image/png">

    <title>{{ $setting->title }} | @yield('title')</title>
    

<link rel="stylesheet" href="{{ asset('public/design/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/design/css/metismenu.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/design/css/icons.css') }}">
<link rel="stylesheet" href="{{ asset('public/design/css/animate.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/design/css/style.css') }}">




  
@stack('css')
{!! $setting->google_analytics !!}
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8123618447885113"
     crossorigin="anonymous"></script>
</head>
<body>
	
	@include('elements.header')
    @yield('content')  

    @include('elements.footer')


<!-- Google recaptcha Code Start -->

<script src="https://www.google.com/recaptcha/api.js?onload=homesCallBack&render=explicit" async defer></script> 
<script type="text/javascript">

      var recaptcha1;
      var recaptcha2;
      var recaptcha3;

      var homesCallBack = function() {
      
    //Render the recaptcha1 on the element with ID "recaptch1"
	
    if($("#recaptcha1").length > 0 ){
       recaptcha1 = grecaptcha.render('recaptcha1', {
        
            'sitekey' : '{{$setting->site_key}}',        
          	'theme' : 'light'
          });
    }

    //Render the recaptcha2 on the element with ID "recaptcha2"
	
    if( $("#recaptcha2").length > 0 ){
       recaptcha2 = grecaptcha.render('recaptcha2', {
        
            'sitekey' : '{{$setting->site_key}}', 
            'theme' : 'light'
          });
    }

     if( $("#recaptcha3").length > 0 ){
       recaptcha3 = grecaptcha.render('recaptcha3', {
        
            'sitekey' : '{{$setting->site_key}}', 
            'theme' : 'light'
          });
    }
  };

</script>






<script src="{{ asset('public/design/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/design/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/design/js/metismenu.min.js') }}"></script>
<script src="{{ asset('public/design/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('public/design/js/waves.min.js') }}"></script>
<script src="{{ asset('public/design/js/app.js') }}"></script>
<script src="{{ asset('public/design/js/jquery.validate.js') }}"></script>





 {{-- Active class script  --}}
<script>

$(function () {

    var url = window.location;
    
    var home_url = "{{ url('/') }}";

    if( url == (home_url+'/')) {
    
    $('#main_menu').find('li:first').addClass('active');  
        
    } else {
      
    $('#main_menu a[href="' + url + '"]').parent('li').addClass('active');
    $('#main_menu a[href="' + url + '"]').closest('li.dropdown').addClass('active');
    }
    

});

</script>


  
@stack('js') 
</body>
</html>




