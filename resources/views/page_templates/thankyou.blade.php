<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"> 
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Thank You | {{ $setting->title }}</title>
<meta name="description" content="Thank You" />
<link rel="shortcut icon" type="image/png" href="{!! asset('public/uploads/'.$setting->favicon) !!}"> 

{!!Html::style('public/design/css/bootstrap.min.css')!!}
{!!Html::style('public/design/css/style.css')!!}
{!!Html::style('public/design/css/responsive.css')!!}

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

{!!Html::script('public/design/js/bootstrap.min.js')!!}

@stack('js') 
</body>
</html>

