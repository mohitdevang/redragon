<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-fw fa-edit"></i> Meta Properties <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
            </div>
            <div class="panel-body">
                <h3 class="card-title"> Meta Properties </h3>
                <hr>
                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::open([ 'route' => ['admin.page.meta.element.update', $page->id],'autocomplete'=>'off', 'id'=>'page_meta_property', 'method' => 'PATCH']) !!}
							<div class="row p-t-20">
								<div class="col-md-12">
									<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
									{!! Form::label('meta_title', 'Title',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','title', $page_meta_element->title, [ 'class' => 'form-control','id' => 'meta_title', 'placeholder' => 'Enter post title'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('meta_description', 'Description',[ 'class' => 'control-label']) !!}
									{!! Form::textarea('description', $page_meta_element->description, [ 'class' => 'form-control','id' => 'meta_description', 'rows' => '3', 'placeholder' => 'Enter post description'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('keywords', 'Keywords',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','keywords', $page_meta_element->keywords, [ 'class' => 'form-control','id' => 'keywords', 'placeholder' => 'Enter post keywords'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('robots', 'Robots',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','robots', $page_meta_element->robots, [ 'class' => 'form-control','id' => 'robots', 'placeholder' => 'Enter post robots'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('revisit_after', 'Revisit After',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','revisit_after', $page_meta_element->revisit_after, [ 'class' => 'form-control','id' => 'revisit_after', 'placeholder' => 'Enter post revisit after'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('og_locale', 'Og Locale',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','og_locale', $page_meta_element->og_locale, [ 'class' => 'form-control','id' => 'og_locale', 'placeholder' => 'Enter post og locale'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('og_type', 'Og Type',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','og_type', $page_meta_element->og_type, [ 'class' => 'form-control','id' => 'og_type', 'placeholder' => 'Enter post og type'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('og_image', 'Og Image',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','og_image', $page_meta_element->og_image, [ 'class' => 'form-control','id' => 'og_image', 'placeholder' => 'Enter post og image'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('og_title', 'Og Title',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','og_title', $page_meta_element->og_title, [ 'class' => 'form-control','id' => 'og_title', 'placeholder' => 'Enter post og title'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('og_url', 'Og Url',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','og_url', $page_meta_element->og_url, [ 'class' => 'form-control','id' => 'og_url', 'placeholder' => 'Keep it blank', 'disabled' => true])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('og_description', 'Og Description',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','og_description', $page_meta_element->og_description, [ 'class' => 'form-control','id' => 'og_description', 'placeholder' => 'Enter post og description'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('og_site_name', 'Og Site Name',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','og_site_name', $page_meta_element->og_site_name, [ 'class' => 'form-control','id' => 'og_site_name', 'placeholder' => 'Enter post og site name'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('author', 'Author',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','author', $page_meta_element->author, [ 'class' => 'form-control','id' => 'author', 'placeholder' => 'Enter post author'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('canonical', 'Canonical',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','canonical', $page_meta_element->canonical, [ 'class' => 'form-control','id' => 'canonical', 'placeholder' => 'Keep it blank', 'disabled' => true])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('geo_region', 'Geo Region',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','geo_region', $page_meta_element->geo_region, [ 'class' => 'form-control','id' => 'geo_region', 'placeholder' => 'Enter post geo region'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('geo_placename', 'Geo Placename',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','geo_placename', $page_meta_element->geo_placename, [ 'class' => 'form-control','id' => 'geo_placename', 'placeholder' => 'Enter post geo placename'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('geo_position', 'Geo Position',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','geo_position', $page_meta_element->geo_position, [ 'class' => 'form-control','id' => 'geo_position', 'placeholder' => 'Enter post geo position'])!!} 
									</div>
									<div class="form-group">
									{!! Form::label('ICBM', 'ICBM',[ 'class' => 'control-label']) !!}
									{!! Form::input('text','ICBM', $page_meta_element->ICBM, [ 'class' => 'form-control','id' => 'ICBM', 'placeholder' => 'Enter post ICBM'])!!} 
									</div>
									<div class="form-actions pull-right">
                            			{!! Form::button('<i class="fa fa-check"></i> Update',['type' => 'submit', 'value' => 'update', 'class' => 'btn btn-rounded btn-success']) !!}
                       				</div>
                    			{!! Form::close() !!} 
								</div>
							</div>
                    	{!! Form::close() !!} 
                    </div>
                   </div>
               </div>
            </div>
        </div>
    </div>
</div>
@push('custom-js')
{!!Html::script('public/admin-design/js/jquery.validate.js')!!}
<script>
$(document).ready(function() {

		$("#page_meta_property").validate({

		  errorElement: 'span',
          errorClass: 'error',
          highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error");
          },
          unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass("has-error");
          },
          errorPlacement: function (error, element) {
             error.insertAfter(element);
          },

			rules: {

				title: {
                    
					required: true
                 }

			}
		});

	});

</script>
@endpush