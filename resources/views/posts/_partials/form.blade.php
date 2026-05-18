<div class="form-body">
		@if(Route::currentRouteName() == 'admin.post.create' || Route::currentRouteName() == 'admin.post.edit')	
		<h3 class="card-title">Post Info</h3>
		<hr>
		<div class="row p-t-20">
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
				{!! Form::label('title', 'Title',[ 'class' => 'control-label']) !!}
				{!! Form::input('text','title', null, [ 'class' => 'form-control','id' => 'title', 'placeholder' => 'Enter post title'])!!} 
					<div class="error">
	                    @foreach ($errors->get('title') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('category_id[]') ? 'has-error' : ''}}">
						{!! Form::label('category_id', 'Category',[ 'class' => 'control-label']) !!}
					@if(Route::currentRouteName() == 'admin.post.create')
						<select id="category_id" class="form-control select2" name="category_id[]" multiple="multiple">
						 @if(!empty($categories))
						 	@foreach($categories as $k => $cat)				 
									 <option value="{{ $cat["id"] }}">{{ $cat["title"] }}</option>
							@endforeach
						 @endif					
                        </select>
						@else
						<select id="category_id" class="form-control select2" name="category_id[]" multiple="multiple">
						 @if(!empty($categories))
						 	@foreach($categories as $k => $cat)	
								 @if (in_array($cat["id"], $post_categories)) 
								 	@php ($cat_selected = "selected")
								 @else 
								 	@php ($cat_selected = "")
								 @endif						 
									 <option value="{{ $cat["id"] }}" {{ $cat_selected }} >{{ $cat["title"] }}</option>
							@endforeach
						 @endif					
                        </select>
                    @endif	 						
					<div class="error">
	                    @foreach ($errors->get('category_id[]') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
             </div>
		</div>
		@endif
		@if(Route::currentRouteName() == 'admin.post.edit')	
		<div class="row">
				<div class="col-md-12">
					<div class="form-group {{ $errors->has('tag_id[]') ? 'has-error' : ''}}">
					{!! Form::label('tag_id', 'Available Tags',[ 'class' => 'control-label']) !!}
					{!! Form::select('tag_id[]', ['' => 'Select Tags'] + $tags, $post_tags, array('id' => 'tag_id', 'class' => 'form-control select2', 'multiple'=> 'multiple')) !!}
						<div class="error">
		                    @foreach ($errors->get('tag_id[]') as $error)
		                    	<p>{{ $error }}</p>
		                    @endforeach
		                </div>
					</div>
				</div>

				<div class="form-group" id="slug-wrapper">
			            <div class="col-md-12">
			                <p class="form-control-static pull-left">Slug : {{ url('/').'/' }} {!! Form::input('text','slug', null,['id' => 'slug']) !!}<a id="edit-slug" class="edit-slug btn-sm" onclick="edit_slug({{ $post->id }})">Edit</a></p>
			            </div>
				</div>
		</div>
		<h3 class="card-title">Description</h3>
		<hr>
			<div class="row">
			    <div class="col-md-12">
					<div class="form-group {{ $errors->has('post_order') ? 'has-error' : ''}}">
					{!! Form::label('post_order', 'Post Order',[ 'class' => 'control-label']) !!}
					{!! Form::input('text','post_order', null, [ 'class' => 'form-control','id' => 'post_order', 'placeholder' => 'Enter post order'])!!} 
						<div class="error">
		                    @foreach ($errors->get('post_order') as $error)
		                    	<p>{{ $error }}</p>
		                    @endforeach
		                </div>
					</div>
				</div>	
				<div class="col-md-12">
				    <div class="form-group">
						{!! Form::label('content', 'Post Description',[ 'class' => 'control-label']) !!}
						{!! Form::textarea('content', null, ['class' => 'ckeditor']) !!} 
				    </div>
			   </div>
			   
			    <div class="col-md-12">
					<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
						<label class="control-label">Image</label>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="{!! asset('public/uploads/'.$post->image) !!}" alt="" /></div>
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
			   
			   <div class="col-md-12">
				<div class="form-group {{ $errors->has('created_at') ? 'has-error' : ''}}">
				{!! Form::label('created_at', 'Date',[ 'class' => 'control-label']) !!}
				{!! Form::input('text','created_at', date('d-m-Y',strtotime($post->created_at)), [ 'class' => 'form-control datepicker','id' => 'created_at', 'placeholder' => 'Select post date'])!!} 
					<div class="error">
	                    @foreach ($errors->get('created_at') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				 </div>
			   </div>

			   <div class="col-md-12">
				<div class="form-group {{ $errors->has('user') ? 'has-error' : ''}}">
					{!! Form::label('user_id', 'Author',[ 'class' => 'control-label']) !!}
					@if(Route::currentRouteName() == 'admin.post.create')
						{{ Form::select('user_id', [ 0 => 'Admin'] + $users, null, ['class' => 'form-control select2','id' => 'user_id']) }}						
	                @else
	                	{{ Form::select('user_id', [ 0 => 'Admin'] + $users, $user_posts, ['class' => 'form-control select2','id' => 'user_id']) }}
	                @endif

	                <div class="error">
	                    @foreach ($errors->get('user_id') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
             </div>
		</div>
		@endif
</div>