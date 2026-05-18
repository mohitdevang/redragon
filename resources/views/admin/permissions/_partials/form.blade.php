<div class="form-body">
		
		<h3 class="card-title">Permission Info</h3>
		<hr>
		<div class="row p-t-20">
			<div class="col-md-4">
				<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
				{!! Form::label('name', 'Name',[ 'class' => 'control-label']) !!}
				{!! Form::input('text','name', null, [ 'class' => 'form-control','id' => 'name', 'placeholder' => 'create.post'])!!} 
					<div class="error">
	                    @foreach ($errors->get('name') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
			</div>
			
			<div class="col-md-4">
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
			
			<div class="col-md-4">
				<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
				{!! Form::label('description', 'Description',[ 'class' => 'control-label']) !!}
				{!! Form::textarea('description', null, ['class' => 'form-control']) !!} 
					<div class="error">
	                    @foreach ($errors->get('description') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
			</div>
			
		</div>
		
</div>