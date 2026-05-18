<div class="form-body">
		@if(Route::currentRouteName() == 'admin.category.create' || Route::currentRouteName() == 'admin.category.edit')	
		<h3 class="card-title">Category Info</h3>
		<hr>
		<div class="row p-t-20">
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
				{!! Form::label('title', 'Title',[ 'class' => 'control-label']) !!}
				{!! Form::input('text','title', null, [ 'class' => 'form-control','id' => 'title', 'placeholder' => 'e.g Sliders'])!!} 
					<div class="error">
	                    @foreach ($errors->get('title') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
			</div>
			<div class="col-md-12">
			        <div class="form-group {{ $errors->has('parent') ? 'has-error' : ''}}">
						{!! Form::label('parent', 'Parent',[ 'class' => 'control-label']) !!}
						{{ Form::select('parent', [0 => 'None'] + $data['category'], null, ['class' => 'form-control select2','id' => 'parent']) }}
						<div class="error">
		                    @foreach ($errors->get('parent') as $error)
		                    	<p>{{ $error }}</p>
		                    @endforeach
	                	</div>
			        </div>
			    </div>
		</div>
		@endif
		@if(Route::currentRouteName() == 'admin.category.edit')	
		@if($category->id != 1)
		<div class="row">
				<div class="form-group" id="slug-wrapper">
			            <div class="col-md-12">
			                <p class="form-control-static pull-left">Slug : {{ public_path() }}{!! Form::input('text','slug', null,['id' => 'slug']) !!}<a id="edit-slug" class="edit-slug btn-sm" onclick="edit_slug({{ $category->id }})">Edit</a></p>
			            </div>
				</div>
		</div>
		@endif	
		<h3 class="card-title">Description</h3>
		<hr>
			<div class="row">	
				<div class="col-md-12">
				    <div class="form-group">
						{!! Form::label('description', 'Category Description',[ 'class' => 'control-label']) !!}
						{!! Form::textarea('description', null, ['class' => 'ckeditor']) !!} 
				    </div>
			   </div>
			   
			    <div class="col-md-12">
					<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
						<label class="control-label">Image</label>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="{!! asset('public/uploads/'.$category->image) !!}" alt="" /></div>
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
		</div>
		@endif
</div>