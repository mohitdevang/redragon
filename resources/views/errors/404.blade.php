<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" href="{!! asset('public/uploads/'.$setting->favicon) !!}" type="image/png">
<title>Page not found | {{ $setting->title }}</title>
<meta name="description" content="Sorry - Page not found. Please visit home page." />
<meta name="keywords" content="404, page not found" />
<meta name="robots" content="no index, no follow" />
<link rel="canonical" href="{{ url ('/404') }}"/>
<meta property="og:locale" content="en_GB" />
<meta property="og:type" content="website"/>
<meta property="og:image" content="{!! asset('public/design/images/404.png') !!}" />
<meta property="og:title" content="Page not found | {{ $setting->title }}"  />
<meta property="og:description" content="Sorry - Page not found. Please visit home page." />
<meta property="og:url" content="{{ url ('/404') }}"/>
<meta property="og:site_name" content="{{ $setting->title }}" />
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
  
<link rel="stylesheet" href="{{ asset('design/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('design/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('design/css/responsive.css') }}">


 <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap" rel="stylesheet">

@stack('css')
{!! $setting->google_analytics !!}
</head>

<body>
@include('elements.header')




<!-- htmml section -->




    
@include('elements.footer')
      
<!-- Google recaptcha Code Start -->

    
 <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>



<script src="{{ asset('public/design/js/bootstrap.min.js') }}"></script>
<script>
    if ($('#back-to-top').length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top').addClass('show');
                } else {
                    $('#back-to-top').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('#back-to-top').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }
</script>
@stack('js') 
</body>
</html>


