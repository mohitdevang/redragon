<div class="form-body">
		@if(Route::currentRouteName() != 'admin.change_password')	
		<h3 class="card-title">Person Info</h3>
		<hr>
		<div class="row p-t-20">
			<div class="col-md-6">
				<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
				{!! Form::label('name', 'Name',[ 'class' => 'control-label']) !!}
				{!! Form::input('text','name', null, [ 'class' => 'form-control','id' => 'name', 'placeholder' => 'e.g John Samual Doe'])!!} 
					<div class="error">
	                    @foreach ($errors->get('name') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
				{!! Form::label('email', 'Email',[ 'class' => 'control-label']) !!}
				{!! Form::input('email','email', null, [ 'class' => 'form-control','id' => 'email', 'placeholder' => 'e.g demo@gmail.com'])!!} 
					<div class="error">
	                    @foreach ($errors->get('email') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
			</div>
		</div>

	{{--<h3 class="box-title m-t-40">Image</h3>
	 <hr>
	 <div class="row">
		<div class="col-md-12">
		<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
			<label class="control-label">Profile Picture</label>
			<div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="{!! asset('public/uploads/'.$profile->image) !!}" alt="" /></div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: auto; line-height: 20px;"></div>
                <div>
                    <span class="btn btn-file btn-primary btn-fill btn-sm"><span class="fileupload-new">Select new image</span>
                        <span class="fileupload-exists">Change</span>
                        {!! Form::input('file', 'image', null) !!}
                    	</span>
                    <a href="#" class="btn btn-danger btn-fill btn-sm fileupload-exists" data-dismiss="fileupload">Remove</a>
                </div>
            </div>
		            <div class="error">
						@foreach ($errors->get('image') as $error)
		                	<p>{{ $error }}</p>
		                @endforeach	
			        </div>	
       	</div>
	   	</div>
		</div>--}}
		@endif
		@if(Route::currentRouteName() != 'admin.profile')	
		<h3 class="card-title">Password</h3>
		<hr>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group {{ $errors->has('old_password') ? 'has-error' : ''}}">
 			    {!! Form::label('old_password', 'Current Password',[ 'class' => 'control-label']) !!}
			    {!! Form::input('password','old_password', null, [ 'class' => 'form-control','id' => 'old_password', 'placeholder' => ''])!!}
				    <div class="error">
	                    @foreach ($errors->get('old_password') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
 			    {!! Form::label('password', 'New Password',[ 'class' => 'control-label']) !!}
			    {!! Form::input('password','password', null, [ 'class' => 'form-control','id' => 'password', 'placeholder' => ''])!!}
				    <div class="error">
	                    @foreach ($errors->get('password') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group {{ $errors->has('conf_password') ? 'has-error' : ''}}">
				{!! Form::label('conf_password', 'Confirm Password',[ 'class' => 'control-label']) !!}
			    {!! Form::input('password','conf_password', null, [ 'class' => 'form-control','id' => 'conf_password', 'placeholder' => ''])!!}
				    <div class="error">
	                    @foreach ($errors->get('conf_password') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
			</div>
		</div>
		@endif
</div>