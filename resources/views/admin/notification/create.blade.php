



		@extends('layouts.main')
@section('title') Add Notification @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Add <small> Notification</small>
                        </h1>
                       <ol class="breadcrumb">{{ generateBreadcrumb() }}</ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                      @component('elements.admin.components.flash') @endcomponent   
                    </div>
                </div>
                
            <div class="parent-content-wrapper">
             <div id="content-sortable">    
                
               <div class="row">
                    <div class="col-lg-12">
                      <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-user"></i> Notification <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                            

                            {!! Form::open([ 'route'=> ['admin.notification.set'],'autocomplete'=>'off', 'files'=> true, 'id'=>'page','method' => 'POST']) !!}
                          <div class="form-body">
	
	@if(isset($noti))
	<input type="hidden" name="hid" value="{{$noti->id}}">
	@endif

			<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Notification </label>
			
				<textarea name="text" class="form-control">@if(isset($noti)) {{$noti->text}} @endif</textarea>
			</div>
		</div>


		</div>
		                                 
                                    <div class="form-actions pull-right">
                                      {!! Form::button('<i class="fa fa-check"></i> Save',['name' => 'Submit', 'type' => 'submit', 'value' => 'Add', 'class' => 'btn btn-rounded btn-success']) !!}
                                    
                                    </div>
                            {!! Form::close() !!}
                            </div>
                        </div>
                        
                    </div>
                </div>  
                
                    
            </div>
            </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        
@endsection
