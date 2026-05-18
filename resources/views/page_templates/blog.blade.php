@extends('layouts.front')
@section('content')
@php($banner_alt = get_post_meta($page->id,'banner-alt') ?  get_post_meta($page->id,'banner-alt') : $page->title)
@php($banner_content = get_post_meta($page->id,'banner-content') ?  get_post_meta($page->id,'banner-content') : '')

@if($page->image)
@php($banner_url = url('/').'/public/uploads/'.$page->image)
@else
@php($banner_url = url('/').'/public/design/images/inner-banner-bg.png')
@endif





<!-- htmml section -->










@endsection


{{-- @push('js')
{!!Html::script('public/design/js/jquery.paginate.js')!!}

 <script>
  
 $('#simple-pagination').paginate({
useHashLocation: false,
perPage: 8
});

</script>
@endpush --}}