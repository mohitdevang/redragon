@extends('layouts.main')
@section('title') 403 access denied @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            403 <small> access denied</small>
                        </h1>
                        <ol class="breadcrumb">{{ generateBreadcrumb() }}</ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div id="info">
                            <div class="error">
                                @foreach ($errors->get('item[]') as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                     @component('elements.admin.components.flash') @endcomponent 
                    </div>
                </div>

                
                
			<div class="parent-content-wrapper">
			 <div id="content-sortable">	
              
				<img src="{!! asset('public/admin-design/images/access-denied.jpg') !!}" class="img-responsive" alt="403">
				
				  	
            </div>
		    </div>
            </div>
            <!-- /.container-fluid -->

</div>
@endsection

