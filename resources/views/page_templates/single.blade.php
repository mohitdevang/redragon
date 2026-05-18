@extends('layouts.front')
@section('content')
@php($banner_alt = get_post_meta($post->id,'banner-alt') ?  get_post_meta($post->id,'banner-alt') : $post->title)
@php($banner_content = get_post_meta($post->id,'banner-content') ?  get_post_meta($post->id,'banner-content') : '')

@php($banner_url = url('/').'/public/design/images/inner-banner-bg.png')




<!-- htmml section -->


    @endsection