<div class="form-body">
	


				<div class="row p-t-20">
			<div class="col-md-6">
				
				<label class="control-label"> Ads Type</label>
				<select class="form-control" name="type" onchange="get_fld(this.value)">
				
					<option value="1" @if(isset($video) && $video->type==1) selected @endif>Upload video file</option>
					<option value="2" @if(isset($video) && $video->type==2) selected @endif>Upload youtube embeded link</option>
					<option value="3" @if(isset($video) && $video->type==3) selected @endif>Upload banner</option>
				</select>
                                                


			</div>
		</div>

		<div class="row p-t-20" id="uploads">
			<div class="col-md-6">
				
				<label class="control-label"> File</label>
				 <input class="form-control" type="file"  name="file" id="file" >
@if(isset($video) && $video->type==1)
<video  controls>
  <source src="{{url('/')}}/public/uploads/{{ $video->file }}" type="video/mp4">
</video>
@elseif(isset($video) && $video->type==3)
  <img src="{{url('/')}}/public/uploads/{{ $video->file }}" height="50" width="50">
  @endif


			</div>
		</div>




@if(isset($video) && $video->type==2)
			<div class="row p-t-20" id="link" >
			<div class="col-md-6">
				<label class="control-label">Link</label>
				<input type="text" name="link" class="form-control"  value="@if(isset($video)) {{$video->link}} @endif">
			</div>
		</div>
		@else
		<div class="row p-t-20" id="link" style="display: none;">
			<div class="col-md-6">
				<label class="control-label">Link</label>
				<input type="text" name="link" class="form-control"  value="@if(isset($video)) {{$video->link}} @endif">
			</div>
		</div>
		@endif




			<div class="row p-t-20">
			<div class="col-md-6">
				
				<label class="control-label"> Download link</label>
				 <input class="form-control" type="text"  name="download_link"  value="@if(isset($video)) {{$video->download_link}} @endif" >


			</div>
		</div>

		<div class="row p-t-20">
			<div class="col-md-6">
				
				<label class="control-label"> Download Text</label>
				 <input class="form-control" type="text"  name="download_text"  value="@if(isset($video)) {{$video->download_text}} @endif" >


			</div>
		</div>



		


		</div>
		

@push('custom-js')

<script>

	function get_fld(id){
if(id=='2'){
$('#link').show();
$('#uploads').hide();
}else{
	$('#link').hide();
	$('#uploads').show();
}
}
	





$(document).ready(function() {



        $("#member_unique_id").keyup(function(){
            var token = $('input[name="_token"]').val();
        $.ajax({
    type: 'post',
    url: '{{ route('get_sopnsor_name')}}',
    data : {'_token': token,'sponsor_id':$(this).val()},
   dataType: 'JSON',
    success :  function(data){
                
                   if(data.success){
                   $('#member_name').val(data.success);                    
                   $('#sponsor_id_err').html('')
                   } 
                   if(data.err){
                    $('#sponsor_id_err').html('wrong sponsor id');
                    $('#member_name').val('');
                   }

                }
});


});




    });


</script>
@endpush