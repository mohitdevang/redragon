@extends('layouts.main')

@section('title') Seo @endsection

@section('content')

<div id="page-wrapper">



            <div class="container-fluid">



                <!-- Page Heading -->

                <div class="row">

                    <div class="col-lg-12">

                        <h1 class="page-header">

                            Manage <small> Robots & Sitemap</small>

                        </h1>

                    </div>

                </div>

                <!-- /.row -->



                <div class="row">

                    <div class="col-lg-12">

                     <div class="alert alert-info"><b>Please upload manually in mobile version also</b></div>

                     @component('elements.admin.components.flash') @endcomponent 

                    </div>

                </div>



                

                

            <div class="parent-content-wrapper">

             <div id="content-sortable">    

              

                <div class="row">

                    <div class="col-lg-12">

                      <div class="panel panel-default">

                            <div class="panel-heading">

                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Upload Files <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>

                            </div>

                            <div class="panel-body">

                            	{!! Form::open([ 'route'=> ['admin.seo.setting'],'autocomplete'=>'off', 'files'=> true, 'id'=>'seofiles','method' => 'POST']) !!}

                                <div class="col-md-12">

										<div class="form-group {{ $errors->has('sitemap') ? 'has-error' : ''}}">

											<label class="control-label">Upload Sitemap (xml)</label>

												<label class="custom-file d-block">

													<input id="sitemap" class="custom-file-input" name="sitemap" type="file">

													<span class="custom-file-control"></span>

												</label>

												<div class="error">

	                    				@foreach ($errors->get('sitemap') as $error)

	                    					<p>{{ $error }}</p>

	                    				@endforeach

	                							 </div>

										</div>

								</div>

								<div class="col-md-12">

										<div class="form-group {{ $errors->has('robots') ? 'has-error' : ''}}">

											<label class="control-label">Upload Robots (txt)</label>

												<label class="custom-file d-block">

													<input id="robots" class="custom-file-input" name="robots" type="file">

													<span class="custom-file-control"></span>

												</label>

												<div class="error">

	                    				@foreach ($errors->get('robots') as $error)

	                    					<p>{{ $error }}</p>

	                    				@endforeach

	                							 </div>

										</div>

								</div>

								<div class="form-actions pull-right">

                                        {!! Form::button('<i class="fa fa-pencil"></i> Upload',[ 'type' => 'submit','id' =>'upload-seo', 'class' => 'btn btn-info btn-rounded']) !!}

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

@push('custom-js')

{!!Html::script('public/admin-design/js/jquery.validate.js')!!}

{!!Html::script('public/admin-design/js/additional-methods.min.js')!!}

<script>

$(document).ready(function() {



	$.validator.addMethod("validate_file_name1",function(value, element) {

	 var name = element.files[0].name;

	 console.log(name);

	 if (name != 'sitemap.xml')

           {

               return false;

           } else {

               return true;

           }



},"File name is not right");



	$.validator.addMethod("validate_file_name2",function(value, element) {

	

	var name = element.files[0].name;

	console.log(name);

	if (name != 'robots.txt')

           {

              return false;

           } else {

               return true;

           }



},"File name is not right");



		$("#seofiles").validate({

		

		  errorElement: 'span',

          errorClass: 'error',

          highlight: function(element, errorClass, validClass) {

            $(element).closest('.form-group').addClass("has-error");

          },

          unhighlight: function(element, errorClass, validClass) {

            $(element).closest('.form-group').removeClass("has-error");

          },

          errorPlacement: function (error, element) {

            error.appendTo($(element).parent().parent());

          },



			rules: {



				sitemap : {

				

						extension: "xml",

						validate_file_name1: true

				

				},

				robots : {

				

						extension: "txt",

						validate_file_name2: true

				

				}





			},



			messages: {



				sitemap :{

				

					extension: "Not a valid file extension"

				

				},

				robots :{

				

					extension: "Not a valid file extension"

				

				}

			

			}



		});



		



	});



</script>

@endpush