@extends('layouts.main')

@section('title') 301 Redirect @endsection

@section('content')

<div id="page-wrapper">



            <div class="container-fluid">



                <!-- Page Heading -->

                <div class="row">

                    <div class="col-lg-12">

                        <h1 class="page-header">

                            Manage <small> 301 Redirect</small> <a class="btn btn-success pull-right" onclick="add_redirect_element()"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>

                        </h1>

                    </div>

                </div>

                <!-- /.row -->

                <div class="row">

                    <div class="col-lg-12">

                     @component('elements.admin.components.flash') @endcomponent 

                      <div class="alert alert-info">
						<strong>
							1. To redirect home page just put '/' in the first field.<br/>
							2. Do not put '/' before any slug other than home in first field.
						</strong>
					</div>

                    </div>

                </div>



                

                

            <div class="parent-content-wrapper">

             <div id="content-sortable">    

              

                <div class="row">

                    <div class="col-lg-12">

                      <div class="panel panel-default">

                            <div class="panel-heading">

                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> 301 Redirect <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>

                            </div>

                            <div class="panel-body" id="wrapper-body">
									@php($sl = 1)
									@foreach($redirects as $redirect)
                            		<div class="wrapper-red">
										<div class="col-md-5">
										   <input class="form-control" placeholder="/abc/def" type="text" id="from_url{{ $sl }}" name="from_url" value="{{ $redirect->from_url }}">
										</div>
										<div class="col-md-5">
										   <input class="form-control" placeholder="https://www.newdoamin.com" id="to_url{{ $sl }}" name="to_url" type="text" value="{{ $redirect->to_url }}">
										</div>
										<div class="col-md-1">
										   <a class="btn btn-info pull-right" onclick="update_redirect({{$sl}},{{ $redirect->id }})">Update</a>
										</div>
										<div class="col-md-1">
											<a class="btn btn-danger pull-right" onclick="remove_redirect(this,{{$redirect->id}})">Remove</a>
										</div>
									</div>
									@php($sl++)
									@endforeach

                            </div>

                     </div>

                  </div>

                </div>

                

                    

            </div>

            </div>

            </div>

            <!-- /.container-fluid -->



</div>     
<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Error Response</h4>
        </div>
        <div class="modal-body" id="content-area"></div>
    </div>
</div>
</div>
@endsection

@push('custom-js')

<script>
var x=1;
function add_redirect_element(){

var contentHTML = '';
contentHTML += '<div class="wrapper-red">';
	contentHTML += '<div class="col-md-5">';
	   contentHTML +='<input class="form-control" placeholder="/abc/def" type="text" id="from_url_q'+ x +'" name="from_url" value="">';
	contentHTML +='</div>';
	contentHTML +='<div class="col-md-5">';
	   contentHTML +='<input class="form-control" placeholder="https://www.newdoamin.com" id="to_url_q'+ x + '" name="to_url" type="text" value="">';
	contentHTML +='</div>';
	contentHTML +='<div class="col-md-1">';
	   contentHTML +='<a class="btn btn-success pull-right" onclick="save_redirect('+x+')">Save</a>';
	contentHTML +='</div>';
	contentHTML +='<div class="col-md-1">';
		contentHTML +='<a class="btn btn-danger pull-right" onclick="remove_el(this)">Remove</a>';
	contentHTML +='</div>';
contentHTML +='</div>';

        $('#wrapper-body').append(contentHTML); 
  x++; 
} 

function remove_el(param){ 

    if(confirm('Are you sure you want to delete selected item ?')){
    	param.closest('.wrapper-red').remove();
    }
  
}
function save_redirect(slno){
	var from_url = $('#from_url_q'+slno).val();
	var to_url = $('#to_url_q'+slno).val();
	var token = '{{ csrf_token() }}';
	  $.ajax({
        async: false,
		type: 'POST',
        url:  '{{ route('admin.301.redirect') }}',
		data : {'_token': token,'from_url':from_url,'to_url':to_url},
		success :  function(response){
			if(response.status){
				alert(response.success);
				setTimeout( function(){
				   $('#content-sortable').load(location.href +  ' #content-sortable');
				},1000);
			}else{
				$('#content-area').html('');
				$("#myModal").modal();
				var err_response = '';
				err_response = '<ul>';
               
				if(response.danger.from_url) {
					var count_i = Object.keys(response.danger.from_url).length;
					for(var i=0 ; i < count_i ; i++){
						err_response += '<li>'+ response.danger.from_url[i] +'</li>';
					}
				}
				
				if(response.danger.to_url){
					var count_j = Object.keys(response.danger.to_url).length;
					for(var j=0 ; j < count_j ; j++){
						err_response += '<li>'+ response.danger.to_url[j] +'</li>';
					}
				}
				
				err_response += '</ul>';
				$('#content-area').append(err_response);
				
				setTimeout( function(){
				   $('#content-sortable').load(location.href +  ' #content-sortable');
				},2000);
			}
			
			
		},
		error: function(xhr){
		  
		  	console.log("An error occured: " + xhr.status + " " + xhr.statusText);
		  
		}
	});
}

function update_redirect(slno,id){
	var from_url = $('#from_url'+slno).val();
	var to_url = $('#to_url'+slno).val();
	var token = '{{ csrf_token() }}';
	  $.ajax({
        async: false,
		type: 'PATCH',
        url:  '{{ route('admin.301.redirect') }}',
		data : {'_token': token,'from_url':from_url,'to_url':to_url,'id':id},
		success :  function(response){
			if(response.status){
				alert(response.success);
			}else{
				$('#content-area').html('');
				$("#myModal").modal();
				var err_response = '';
				err_response = '<ul>';
               
				if(response.danger.from_url) {
					var count_i = Object.keys(response.danger.from_url).length;
					for(var i=0 ; i < count_i ; i++){
						err_response += '<li>'+ response.danger.from_url[i] +'</li>';
					}
				}
				
				if(response.danger.to_url){
					var count_j = Object.keys(response.danger.to_url).length;
					for(var j=0 ; j < count_j ; j++){
						err_response += '<li>'+ response.danger.to_url[j] +'</li>';
					}
				}
				
				if(response.danger.id){
					var count_k = Object.keys(response.danger.id).length;
					for(var k=0 ; k < count_k ; k++){
						err_response += '<li>'+ response.danger.to_url[k] +'</li>';
					}
				}
				
				err_response += '</ul>';
				$('#content-area').append(err_response);
				
			}
			
			setTimeout( function(){
			   $('#content-sortable').load(location.href +  ' #content-sortable');
			},2000);
		
			 
		},
		error: function(xhr){
		  
		  	console.log("An error occured: " + xhr.status + " " + xhr.statusText);
		  
		}
	});
}
function remove_redirect(param,id){
	if(confirm('Are you sure you want to delete selected item ?')){

		var token = '{{ csrf_token() }}';
		  $.ajax({
			async: false,
			type: 'DELETE',
			url:  '{{ route('admin.301.redirect') }}',
			data : {'_token': token,'id':id},
			success :  function(response){
				if(response.status){
					alert(response.success);
					param.closest('.wrapper-red').remove();
				}else{
					$('#content-area').html('');
					$("#myModal").modal();
					var err_response = '';
					err_response = '<ul>';
				   
					if(response.danger.id){
						var count_k = Object.keys(response.danger.id).length;
						for(var k=0 ; k < count_k ; k++){
							err_response += '<li>'+ response.danger.to_url[k] +'</li>';
						}
					}
					
					err_response += '</ul>';
					$('#content-area').append(err_response);
				}
				
				 
			},
			error: function(xhr){
			  
				console.log("An error occured: " + xhr.status + " " + xhr.statusText);
			  
			}
		});
		
	}
}
</script>

@endpush

@push('custom-css')
<style>
.wrapper-red{
	margin-bottom: 10px;
	display: inline-block;
	width: 100%;
}
</style>

@endpush