@extends('layouts.main')
@section('title') Resources @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Resources <small> Overview </small>
                            <span class="pull-right"><input type="text" id="myInput" onkeyup="myFunction()" class="form-control" placeholder="Search for names..."></span>
                        </h1>
                        <ol class="breadcrumb">{{ generateBreadcrumb() }}</ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div id="info"></div>
                      @component('elements.admin.components.flash') @endcomponent 
                    </div>
                </div>

                
                
      <div class="parent-content-wrapper">
       <div id="content-sortable">  
              
        <div class="row">
                    <div class="col-lg-12">
              <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Resources <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    {!! Form::open([ 'route'=> ['admin.resources.delete'], 'method' => 'DELETE','onsubmit' => 'return datatable_validation()']) !!}

{{ csrf_field() }}
                                    <div class="col-md-9"><button type="submit" name="bulk_delete" class="btn btn-danger btn-rounded"><i class="fa fa-trash"></i></button><br /></div>
                                    <div class="col-md-3 pull-right">{!! Form::input('checkbox','chkHeader',null,['id' => 'chkHeader', 'onclick' => 'checkUncheckAll(this)'])!!}<label class="control-label resource-select-txt">Select / Unselect All</label></div>
                                </div>
<?php 
$file_display = array('txt','jpg','jpeg','png','ico','gif','pdf','doc','docx','ppt','pptx','pps','ppsx','odt','xls','xlsx','key','zip','tar','gz','rar','mp3','m4a','ogg','wav','mp4','m4v','mov','wmv','avi','mpg','ogv','3gp','3g2');
$destinationPath = 'uploads/metas/';
$dir =  config('services.new_root_path').$destinationPath;

$media_text = array('txt');
$media_doc = array('doc','docx');
$media_portable = array('pdf');
$media_zip = array('zip','tar','gz','rar','key');
$media_microsoft = array('ppt','pptx','pps','ppsx','odt','xls','xlsx');
$media_audio = array('mp3');
$media_image = array('jpg','jpeg','png','ico','gif');
$media_video = array('m4a','ogg','wav','mp4','m4v','mov','wmv','avi','mpg','ogv','3gp','3g2');


    $i=1;
    ?>
 
  <div id="myUL">
   <?php foreach ($pic as $file) {
        $file_type = explode('.', $file->name);?>

         <div class="col-md-3 item">
            <div class="resource-img">
          <?php if (in_array($file_type[1], $media_image)){ 
                  $class = 'image-popup-vertical-fit' ;
                  $target = '';
                }else { 
                  $class = '';
                  $target = 'target="_blank"';
                }?>
                <a class="<?=$class?>" {{ $target }} href="{!! asset('public/uploads/metas/'.$file_type[0].'.'.$file_type[1]) !!}" title="{{ $file_type[0] }}">
            <?php if (in_array($file_type[1], $media_text)){ ?>
                    <img width="140px" height="140px" id="file{{ $i }}" src="{!! asset('public/admin-design/images/txt.png') !!}" />
          <?php }?>
          <?php if (in_array($file_type[1], $media_doc)){ ?>
                    <img width="140px" height="140px" id="file{{ $i }}" src="{!! asset('public/admin-design/images/doc.png') !!}" />
          <?php }?>
          <?php if (in_array($file_type[1], $media_portable)){ ?>
                    <img width="140px" height="140px" id="file{{ $i }}" src="{!! asset('public/admin-design/images/pdf.png') !!}" />
          <?php }?>
          <?php if (in_array($file_type[1], $media_zip)){ ?>
                    <img width="140px" height="140px" id="file{{ $i }}" src="{!! asset('public/admin-design/images/zip.png') !!}" />
          <?php }?>
          <?php if (in_array($file_type[1], $media_microsoft)){ ?>
                    <img width="140px" height="140px" id="file{{ $i }}" src="{!! asset('public/admin-design/images/xls.png') !!}" />
          <?php }?>
          <?php if (in_array($file_type[1], $media_audio)){ ?>
                    <img width="140px" height="140px" id="file{{ $i }}" src="{!! asset('public/admin-design/images/audio.png') !!}" />
          <?php }?>
          <?php if (in_array($file_type[1], $media_image)){ ?>

                    <img width="140px" height="140px" id="file{{ $i }}" src="{!! asset('public/uploads/metas/'.$file_type[0].'.'.$file_type[1]) !!}" />
          <?php }?>
          <?php if (in_array($file_type[1], $media_video)){ ?>
                    <img width="140px" height="140px" id="file{{ $i }}" src="{!! asset('public/admin-design/images/video.png') !!}" />
          <?php }?>
                </a>
                <h2>{{ $file_type[0] }}.{{ $file_type[1] }}</h2>
                <div class="row">
                <div class="col-md-10">
                    <a class="clipboadrd-btn" onclick="copyToClipboard('#file{{ $i }}')">Copy Link</a>
                </div>
                <div class="col-md-2">
                    {!! Form::input('checkbox','item[]',$file_type[0].'.'.$file_type[1],['class' => 'form-control chkItems resource-checkbox', 'onclick' => 'checkUnCheckParent()'])!!}
                </div>

                 <div class="col-md-10">
                    <input type="text" name="alt" id="alt_{{$file->id}}" class="form-control" placeholder="alt">
                </div>
                <div class="col-md-2">
                    <button type="button" class="form-control" onclick="set_alt('{{$file->id}}')">Set</button>
                </div> 


                </div>
            </div>
        </div>  
     <?php  $i++;
    }?>
  </div>
 
{!! Form::close() !!}
                       </div>
                  </div>
            </div>
        </div>
        
            
            </div>
        </div>
            </div>
            <!-- /.container-fluid -->

</div>
@endsection
@push('custom-css')
{!!Html::style('public/admin-design/css/magnificPopup.css')!!}
@endpush
@push('custom-js')
{!!Html::script('public/admin-design/js/jquery.magnific-popup.min.js')!!}
<script>
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).attr('src')).select();
  document.execCommand("copy");
  $temp.remove();
  $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="glyphicon glyphicon-remove-sign"></span> <strong>Error : </strong><span>&nbsp; Link copied to clipboadrd </span></div>');
setTimeout( function(){
$('#info').load(location.href +  ' #info');
},3000);
}
</script>
 <script type="text/javascript">
  $(document).ready(function() {

    $('.image-popup-vertical-fit').magnificPopup({
      type: 'image',
      closeOnContentClick: true,
      mainClass: 'mfp-img-mobile',
      image: {
        verticalFit: true
      }
      
    });

  });
</script>
<script>
function myFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByClassName("item");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("h2")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}


function set_alt(id){
   var token = $('input[name="_token"]').val();
    $.ajax({
    type: 'post',
    url: '{{ route('admin.set_alt')}}',
    data : {'_token': token,'id':id,'alt':$('#alt_'+id).val()},
   dataType: 'JSON',
    success :  function(data){

                
                   if(data.success){
                     alert();

                    
                   } 

                }
});
}

</script>

@endpush
