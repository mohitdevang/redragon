<div class="form-body">
	
	

			<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Commission Plan Name</label>
				
				<select class="form-control" name="plan_id">
					<option value="">Select</option>
					@foreach($plan as $plans)
					<option value="{{$plans->id}}" @if(isset($selected_plan) && ($selected_plan->plan_id==$plans->id)) selected @endif>{{$plans->plan_name}}</option>
					@endforeach
				</select>
			</div>
		</div>


				<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Number of direct member</label>
				<input type="text" name="number_of_direct_member" class="form-control" value="@if(isset($selected_plan)) {{$selected_plan->number_of_direct_member}} @endif">
			</div>
		</div>
		


				<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Days limit</label>
				<input type="text" name="days_limit" class="form-control" value="@if(isset($selected_plan)) {{$selected_plan->days_limit}} @endif">
			</div>
		</div>
		


				<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Amount</label>
				<input type="text" name="amount" class="form-control" value="@if(isset($selected_plan)) {{$selected_plan->amount}} @endif">
			</div>
		</div>
		
		


		</div>
		
