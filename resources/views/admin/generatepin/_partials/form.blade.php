<div class="form-body">
	
<!-- 		<div class="row p-t-20">
			<div class="col-md-6">
				
				<label class="control-label">Select Member</label>
				<select class="form-control" name="member_id">
					<option value="">Select </option>
					@if(isset($member))
					@foreach($member as $mem)
					
					<option value="{{$mem->unique_id}}">{{$mem->unique_id}} </option>
					@endforeach
					@endif

					
				</select>


			</div>
		</div> -->


				<div class="row p-t-20">
			<div class="col-md-6">
				
				<label class="control-label"> Member Id</label>
				 <input class="form-control" type="text"  name="member_id" id="member_unique_id">
                                                <span style="color: red;" id='sponsor_id_err' required></span>


			</div>
		</div>

		<div class="row p-t-20">
			<div class="col-md-6">
				
				<label class="control-label"> Member Name</label>
				 <input class="form-control" type="text"  name="member_name" id="member_name" required>


			</div>
		</div>





			<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Enter number of pin</label>
				<input type="text" name="number_of_pin" class="form-control">
			</div>
		</div>
		


		</div>
		

@push('custom-js')

<script>
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