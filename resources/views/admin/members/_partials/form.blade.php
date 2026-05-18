<div class="form-body">
	
	

			<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Name</label>
				<input type="text" name="name" class="form-control" value="@if(isset($member)) {{$member->name}} @endif" required>
			</div>
		</div>


				<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Email</label>
				<input type="text" name="email" class="form-control" value="@if(isset($member)) {{$member->email}} @endif" required>
			</div>
		</div>
		


				<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Password</label>
				<input type="text" name="secpwd" class="form-control" value="@if(isset($member)) {{$member->secpwd}} @endif" required>
			</div>
		</div>

		<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Mobile</label>
				<input type="text" name="phone" class="form-control" value="@if(isset($member)) {{$member->phone}} @endif" required>
			</div>
		</div>
		


		


		</div>
		
