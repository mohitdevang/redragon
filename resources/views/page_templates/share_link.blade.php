@extends('layouts.user_profile')
@section('content')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


@endpush

<div class="content-page">
  <div class="col-md-12 col-lg-10">
    <!-- Start content -->
    <div class="glass-card">
      <!-- Header -->
      <div class="card-title-border">
        <h2 class="card-title">Share Link</h2>
      </div>
      <input type="text" value="{{ url('/')}}/member-add/{{Auth::guard()->user()->unique_id}}" id="myInput"
        class="custom-input">
      <br>
      <button onclick="myFunction()" class="copy-btn w-auto text-white font-14 medium mt-4">Copy link</button>
      <?php $url=url('/').'/member-add/'.Auth::guard()->user()->unique_id;?>

      <a target="_blank" href="https://www.facebook.com/sharer.php?u={{$url}}" class="fa fa-facebook fa-5x"></a>
      <a target="_blank" href="https://twitter.com/share?url={{$url}}&text={{ $setting->title }}"
        class="fa fa-twitter fa-5x"></a>

      <a target="_blank" href="https://www.linkedin.com/shareArticle?url={{$url}}&title={{ $setting->title }}"
        class="fa fa-linkedin fa-5x"></a>

      <a target="_blank"
        href="https://pinterest.com/pin/create/bookmarklet/?url={{$url}}&description={{ $setting->title }}"
        class="fa fa-pinterest fa-5x"></a>


      <a target="_blank" href="https://api.whatsapp.com/send?text={{ $setting->title }} {{$url}}"
        class="fa fa-whatsapp fa-5x"></a>

    </div>
  </div>
</div>



@endsection
@push('js')

<script>

  function myFunction() {
    /* Get the text field */
    var copyText = document.getElementById("myInput");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/

    /* Copy the text inside the text field */
    document.execCommand("copy");

    /* Alert the copied text */

  }
</script>


@endpush