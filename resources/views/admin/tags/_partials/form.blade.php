<div class="form-body">
		@if(Route::currentRouteName() == 'admin.tag.create' || Route::currentRouteName() == 'admin.tag.edit')	
		<h3 class="card-title">Tag Info</h3>
		<hr>
		<div class="row p-t-20">
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
				{!! Form::label('title', 'Title',[ 'class' => 'control-label']) !!}
				{!! Form::input('text','title', null, [ 'class' => 'form-control','id' => 'title', 'placeholder' => 'laravel#5'])!!} 
					<div class="error">
	                    @foreach ($errors->get('title') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
			</div>
		</div>
		@endif
		@if(Route::currentRouteName() == 'admin.tag.edit')	
		<div class="row">
				<div class="form-group" id="slug-wrapper">
			            <div class="col-md-12">
			                <p class="form-control-static pull-left">Slug : {{ public_path() }}{!! Form::input('text','slug', null,['id' => 'slug']) !!}<a id="edit-slug" class="edit-slug btn-sm" onclick="edit_slug({{ $tag->id }})">Edit</a></p>
			            </div>
				</div>
		</div>
		<h3 class="card-title">Description</h3>
		<hr>
			<div class="row">	
				<div class="col-md-12">
				    <div class="form-group">
						{!! Form::label('description', 'Tag Description',[ 'class' => 'control-label']) !!}
						{!! Form::textarea('description', null, ['class' => 'ckeditor']) !!} 
				    </div>
			   </div>					    
			</div>
		@endif
</div>