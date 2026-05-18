@extends('layouts.front')
@section('content')

  @if($page->image)
    @php($banner_url = url('/').'/public/uploads/'.$page->image)
@else
    @php($banner_url = url('/').'/public/design/images/inner-banner-bg.png')
@endif



<!-- htmml section -->


 @endsection