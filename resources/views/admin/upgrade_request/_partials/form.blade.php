<div class="form-body">
	
		<div class="row p-t-20">
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
		</div>

			<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Enter number of pin</label>
				<input type="text" name="number_of_pin" class="form-control">
			</div>
		</div>
		


		</div>
		
