<div class="form-body">
		@if(Route::currentRouteName() == 'admin.page.create' || Route::currentRouteName() == 'admin.page.edit')	
		<h3 class="card-title">Page Info</h3>
		<hr>
		<div class="row p-t-20">
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
				{!! Form::label('title', 'Title',[ 'class' => 'control-label']) !!}
				{!! Form::input('text','title', null, [ 'class' => 'form-control','id' => 'title', 'placeholder' => 'Enter page title'])!!} 
					<div class="error">
	                    @foreach ($errors->get('title') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
			</div>
		</div>
		@endif
		@if(Route::currentRouteName() == 'admin.page.edit')	
		@if($page->slug != '')
		<div class="row">
				<div class="form-group" id="slug-wrapper">
			            <div class="col-md-12">
			                <p class="form-control-static pull-left">Slug : {{ url('/').'/' }}{!! Form::input('text','slug', null,['id' => 'slug']) !!}<a id="edit-slug" class="edit-slug btn-sm" onclick="edit_slug({{ $page->id }})">Edit</a></p>
			            </div>
				</div>
		</div>
       @endif
		<h3 class="card-title">Menu</h3>
		<hr>
        <div class="row">
            <div class="col-md-3">
				<div class="form-group">
						{!! Form::label('flag', 'Menu Type',[ 'class' => 'control-label']) !!}
                         @php($menu_flags = array('0' => 'Header Menu','1' => 'Sidebar Menu','2' => 'Footer Menu'));
						{!! Form::select('flag', $menu_flags, $menu->flag,[ 'class' => 'form-control','id' => 'flag']) !!}	
				</div>
			 </div>
            <div class="col-md-3">
				<div class="form-group">
						{!! Form::label('parent_page', 'Parent Page',[ 'class' => 'control-label']) !!}
						{!! Form::select('parent_page', [0 => 'Select'] + $all_pages, $menu->parent_page,[ 'class' => 'form-control','id' => 'parent_page']) !!}
				</div>
			 </div>
		    <div class="col-md-3">
				<div class="form-group">
						{!! Form::label('menu_order', 'Menu Order',[ 'class' => 'control-label']) !!}
						{!! Form::input('text','menu_order', null, [ 'class' => 'form-control','id' => 'menu_order'])!!} 
				</div>
			 </div>
			 <div class="col-md-3">
				<div class="form-group">
						{!! Form::label('slug_status', 'Slug Status',[ 'class' => 'control-label']) !!}
						@php($slug_status = array('0' => 'No','1' => 'Yes'))
						{!! Form::select('slug_status', $slug_status, null,[ 'class' => 'form-control','id' => 'slug_status']) !!}		 
				</div>
			 </div>
        </div>
        <h3 class="card-title">Template</h3>
		<hr>
        <div class="row">
            <div class="col-md-4">
				<div class="form-group">
						{!! Form::label('template', 'Page Template',[ 'class' => 'control-label']) !!}
                         @php($template_flags = array('1' => 'Home Page','2' => 'Default Page','4' => 'Contact Page','5' => 'Blog Page', '6' => 'Full Width Page', '7' => 'Appointment Page','8' => 'Register'));
						{!! Form::select('template', $template_flags, null,[ 'class' => 'form-control select2','id' => 'template']) !!}	
				</div>
			 </div>
        </div>
		<h3 class="card-title">Description</h3>
		<hr>
			<div class="row">	
				<div class="col-md-12">
				    <div class="form-group">
						{!! Form::label('content', 'Page Description',[ 'class' => 'control-label']) !!}
						{!! Form::textarea('content', null, ['class' => 'ckeditor']) !!} 
				    </div>
			   </div>
			   
			    <div class="col-md-12">
					<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
						<label class="control-label">Image</label>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="{!! asset('public/uploads/'.$page->image) !!}" alt="" /></div>
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
					<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
						<label class="control-label">Mobile Banner</label>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="{!! asset('public/uploads/'.$page->mobile_banner) !!}" alt="" /></div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: auto; line-height: 20px;"></div>
						<div>
							<span class="btn btn-file btn-primary btn-fill btn-sm"><span class="fileupload-new">Select new image</span>
							<span class="fileupload-exists">Change</span>
								{!! Form::input('file', 'mobile_banner', null) !!}
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






			  {{-- <div class="col-md-12">
				<div class="form-group {{ $errors->has('user') ? 'has-error' : ''}}">
						{!! Form::label('user_id', 'Author',[ 'class' => 'control-label']) !!}
						{{ Form::select('user_id', $users, null, ['class' => 'form-control select2','id' => 'user_id']) }}						
					<div class="error">
	                    @foreach ($errors->get('user_id') as $error)
	                    	<p>{{ $error }}</p>
	                    @endforeach
	                </div>
				</div>
             </div> --}}
		</div>
		@endif
</div>