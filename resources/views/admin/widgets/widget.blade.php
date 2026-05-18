@extends('layouts.main')
@section('title') Widgets @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Widgets <small> overview</small><a class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>                       
                        </h1>
                        <div class="row">
						<div class="col-lg-8">
                         <ol class="breadcrumb">{{ generateBreadcrumb() }}</ol>
						</div> 
		                <div class="col-lg-4">
		                 {{--<a onclick="return confirm('Are you sure you want empty the data table?');" class="btn btn-inverse pull-right" href="{{ route('admin.widgets.truncate') }}">Empty Table</a>--}}
						</div>
						</div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                         @component('elements.admin.components.flash') @endcomponent 
                    </div>
                </div>
				
				<div class="modal fade" id="myModal" role="dialog">
				<div class="modal-dialog">
				
				  <!-- Modal content-->
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Add Widget</h4>
					</div>
					<div class="modal-body">
					  {!! Form::open([ 'route'=> ['admin.widgets'],'autocomplete'=>'off', 'files'=> true, 'id'=>'widget_add', 'method' => 'POST']) !!}
							<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
								{!! Form::label('title', 'Title',[ 'class' => 'control-label']) !!}
								{!! Form::input('text','title', null, [ 'class' => 'form-control','id' => 'title', 'placeholder' => 'Enter a title','required' => 'required'])!!} 
								<div class="error">
									@foreach ($errors->get('title') as $error)
									<p>{{ $error }}</p>
									@endforeach
								</div>
							</div>
							<div class="form-group">
								 {!! Form::label('description', 'Description',[ 'class' => 'control-label']) !!}
								 {!! Form::input('text','description', null, [ 'class' => 'form-control','id' => 'description', 'placeholder' => 'Enter description'])!!}
							</div>
							<div class="form-group">
								{!! Form::label('content', 'Content',[ 'class' => 'control-label']) !!}
								{!! Form::textarea('content', null, ['class' => 'form-control','id' => 'content','size' => '30x5', 'placeholder' => 'Content goes here..']) !!}
							</div>			
					</div>
					<div class="modal-footer">
						<div class="form-actions pull-right">
							{!! Form::button('<i class="fa fa-check"></i> Add',['name' => 'Submit', 'type' => 'submit', 'value' => 'Add', 'class' => 'btn btn-success']) !!}
                            {!! Form::button('Reset',['name' => 'Reset', 'value' => 'Reset', 'type' => 'reset', 'class' => 'btn btn-inverse']) !!}
						</div>
					{!! Form::close() !!}
					</div>
				  </div>
				</div>
			  </div>
			  
			 @if(empty($widgets))
				<p class="text-center empty-msg">No widgets are there yet</p>
			 @else 
                
			<div class="parent-content-wrapper">
			 <div id="content-sortable">
			 
			 	<div class="row">
					<div class="parent-task-panel clearfix">
				  		<div id="task-panel">
				  		@php($i=1)	
                		@foreach($widgets as $widget)
							<div class="col-lg-4 child">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title"><lavel id="cart-badge" class="badge badge-warning">{{ $widget->id }}</lavel> {{ $widget->title }} <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
										</div>
										<div class="panel-body">
										 <p class="widget-description"></p>
										 {!! Form::open(['autocomplete'=>'off', 'method' => 'PATCH','route' => ['admin.widgets']]) !!}
										 {!! Form::input('hidden','widget_id',$widget->id)!!}
											<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
												{!! Form::label('title'.$i, 'Title',[ 'class' => 'control-label']) !!}
												{!! Form::input('text','title', $widget->title, [ 'class' => 'form-control','id' => 'title'.$i, 'placeholder' => 'Enter a title','required' => 'required'])!!} 
												<div class="error">
													@foreach ($errors->get('title') as $error)
													<p>{{ $error }}</p>
													@endforeach
												</div>
											</div>
											<div class="form-group">
												 {!! Form::label('description'.$i, 'Description',[ 'class' => 'control-label']) !!}
												 {!! Form::input('text','description', $widget->description, [ 'class' => 'form-control','id' => 'description'.$i, 'placeholder' => 'Enter description'])!!}
											</div>
											<div class="form-group">
												{!! Form::label('content'.$i, 'Content',[ 'class' => 'control-label']) !!}
												{!! Form::textarea('content',  $widget->content, ['class' => 'form-control','id' => 'content'.$i,'size' => '30x5', 'placeholder' => 'Content goes here..']) !!}
											</div>
											<div class="form-actions pull-right">
											{!! Form::button('<i class="fa fa-pencil"></i> Update',['name' => 'Submit', 'type' => 'submit', 'value' => 'Edit'.$i, 'class' => 'btn btn-info']) !!}
											{!! Form::close() !!}	
											{!! Form::open(['method' => 'DELETE','route' => ['admin.widget.delete', $widget->id],'style'=>'display:inline']) !!}	
											{!! Form::button('Delete',['name' => 'Submit', 'type' => 'submit', 'value' => 'Delete'.$i, 'class' => 'btn btn-danger btn-fill btn-sm', 'onclick' => 'return confirm("Are you sure you want to delete this item?")']) !!}
											{!! Form::close() !!}
												</div>
										
										</div>
									</div>
									
								</div>
						@php ($i++) 
						@endforeach	
							</div>	
							
						</div>	
				     </div>	
                	
           	 </div>
		   </div>
		   @endif
            </div>
            <!-- /.container-fluid -->

        </div>
        
@endsection
@push('custom-js')
{!!Html::script('public/admin-design/js/jquery.validate.js')!!}
<script>
$(document).ready(function() {

		$("#widget_add").validate({

			rules: {

				title: {
                    
					required: true
                 }

			},

			messages: {

				title: {
				
					required: "Please enter a widget title"
				
				}
			
			}

		});

		

	});

</script>
@endpush