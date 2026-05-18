<div class="form-body">
		
		<h3 class="card-title">Role Info</h3>
		<hr>
		<div class="row p-t-20">
			<div class="col-md-6">
				<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
				{!! Form::label('name', 'Name',[ 'class' => 'control-label']) !!}
				{!! Form::input('text','name', null, [ 'class' => 'form-control','id' => 'name', 'placeholder' => 'Super Admin'])!!} 
					<div class="error">
	                    @foreach ($errors->get('name') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group {{ $errors->has('guard_name') ? 'has-error' : ''}}">
				
					@php($guard_arr = config('auth.guards'))
					@php($guards = array_keys($guard_arr))
					@php($guards = array_combine($guards, $guards))
				
					{!! Form::label('guard_name', 'Guard',[ 'class' => 'control-label']) !!}
					{!! Form::select('guard_name', ['' => 'Select'] + $guards, null,[ 'class' => 'form-control','id' => 'guard_name']) !!}	
					
					<div class="error">
	                    @foreach ($errors->get('guard_name') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
					
				</div>
			</div>
		</div>

</div>