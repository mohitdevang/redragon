<div class="row">
                    <div class="col-lg-12">
					  <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-fw fa-edit"></i> Custom fields <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                               
								<h3 class="card-title">Custom fields <a class="btn btn-success pull-right" id="add_field_button" onclick="add_element({{ $page->id }},'page')"> <i class="fa fa-plus" aria-hidden="true"></i> Add More</a></h3>
								
								<h6 class="card-subtitle">
								<span>Used Meta Keys : </span>
								<ul class="meta_sugg" id="meta_sugg_box">
								@php ($prefix = ' ')       
								@foreach($meta_keys as $meta_key)
								<li>{{ $prefix.$meta_key->meta_key }}</li>
								@php ($prefix = ', ') 
								@endforeach
								@php ($prefix = ' ')
								</ul>
								</h6>
                                <hr>
										
								<div class="row">
								          
										  <div id="input_fields_wrap">
										  <div class="info">
											@if($errors)
											 <ul id="meta_validation_error">
											   @foreach ($errors->all() as $error)
												  <li>{{ $error }}</li>
											  	@endforeach
											 </ul> 
											@endif
										  </div>
										  <?php if(!empty($postmeta)):?>
										  <?php $no=1;?>
										  <?php foreach($postmeta as $meta):?>
										  
										  <div class="col-md-12 custom-field">
										    <div class="col-md-3">
											   <input class="form-control" id="meta_key<?=$no?>" name="meta_key" placeholder="key_name" type="text" value="<?=$meta->meta_key?>">
											</div>
											<div class="col-md-8">
											   <textarea class="form-control" id="meta_value<?=$no?>" name="meta_value" placeholder="content goes here.."><?=$meta->meta_value?></textarea>
											</div>
											<div class="col-md-1">
											   <a class="btn btn-info pull-right m-b-10" onclick="update_meta({{ $page->id }},<?=$meta->id?>,<?=$no?>,'page')">Update</a>
											   <a class="btn btn-danger pull-right" onclick="remove_meta(this,<?=$meta->id?>,'page')">Remove</a>
											</div>
										  </div>
										  <?php $no++;?>
										  <?php endforeach;?>
										  
										  <?php endif;?>
										    
										  </div> 
								 </div>
                            </div>
                        </div>
                        
                    </div>
                </div>