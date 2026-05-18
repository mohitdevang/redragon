<div class="form-body">
	
	

			<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Plan Name</label>
				<input type="text" name="plan_name" class="form-control" value="@if(isset($plan)) {{$plan->plan_name}} @endif">
			</div>
		</div>


				<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Direct Member</label>
				<input type="text" name="direct" class="form-control" value="@if(isset($plan)) {{$plan->direct}} @endif">
			</div>
		</div>
		


				<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Downline Member</label>
				<input type="text" name="member" class="form-control" value="@if(isset($plan)) {{$plan->member}} @endif">
			</div>
		</div>

		<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Day</label>
				<input type="text" name="day" class="form-control" value="@if(isset($plan)) {{$plan->day}} @endif">
			</div>
		</div>
		


				<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Commision</label>
				<input type="text" name="commision" class="form-control" value="@if(isset($plan)) {{$plan->commision}} @endif">
			</div>
		</div>
		
		


		</div>
		
