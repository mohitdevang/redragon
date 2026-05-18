



		@extends('layouts.main')
@section('title') Add Bank Details @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Add <small> Bank Details</small>
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
                                <h3 class="panel-title"><i class="fa fa-user"></i> Bank Details <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                            

                            {!! Form::open([ 'route'=> ['admin.bank_details.set'],'autocomplete'=>'off', 'files'=> true, 'id'=>'page','method' => 'POST']) !!}
                          <div class="form-body">
	
	@if(isset($bank))
	<input type="hidden" name="hid" value="{{$bank->id}}">
	@endif

			<div class="row p-t-20">
			<div class="col-md-6">
				<label class="control-label">Account Holde Name </label>
			
				<input type="text"  class="form-control" name="ac_holder_name" value="@if(isset($bank)) {{$bank->ac_holder_name}} @endif">
			</div>
		</div>


        <div class="row p-t-20">
            <div class="col-md-6">
                <label class="control-label">Bank Name </label>
            
               <input type="text"  class="form-control" name="bank_name" value="@if(isset($bank)) {{$bank->bank_name}} @endif">
            </div>
        </div>


        <div class="row p-t-20">
            <div class="col-md-6">
                <label class="control-label">Account Number </label>
            
                <input type="text"  class="form-control" name="ac_number" value="@if(isset($bank)) {{$bank->ac_number}} @endif">
            </div>
        </div>

        <div class="row p-t-20">
            <div class="col-md-6">
                <label class="control-label">IFSC Code </label>
            
                <input type="text"  class="form-control" name="ifsc" value="@if(isset($bank)) {{$bank->ifsc}} @endif">
            </div>
        </div>

        <div class="row p-t-20">
            <div class="col-md-6">
                <label class="control-label">Paytm Number </label>
            
               <input type="text"  class="form-control" name="paytm" value="@if(isset($bank)) {{$bank->paytm}} @endif">
            </div>
        </div>

        <div class="row p-t-20">
            <div class="col-md-6">
                <label class="control-label">Google Pay Number</label>
            
                <input type="text"  class="form-control" name="googlepay" value="@if(isset($bank)) {{$bank->googlepay}} @endif">
            </div>
        </div>

        <div class="row p-t-20">
            <div class="col-md-6">
                <label class="control-label">PhonePay Number </label>
            
               <input type="text"  class="form-control" name="phonepay" value="@if(isset($bank)) {{$bank->phonepay}} @endif">
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
