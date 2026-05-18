@extends('layouts.main')
@section('title') Categories @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Categories <small> Overview</small><a class="btn btn-success pull-right" href="{{ route('admin.category.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>
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
              
				<div class="row">
                    <div class="col-lg-12">
					  <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Users <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
			                     <div class="table-responsive">
                                    {!! Form::open([ 'route'=> ['admin.categories.delete'], 'method' => 'DELETE','onsubmit' => 'return datatable_validation()']) !!}
                                  <p><button type="submit" name="bulk_delete" class="btn btn-danger btn-rounded"><i class="fa fa-trash"></i></button><a class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal"> Tree View</a></p>
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th width="2%">{!! Form::input('checkbox','chkHeader',null,['id' => 'chkHeader', 'onclick' => 'checkUncheckAll(this)'])!!}</th>
                                                <th width="10%">Sl No.</th>
                                                <th width="20%">Title</th>
                                                <th width="30%">Tree</th>
                                                <th width="15%">Show Posts</th>
                                                <th width="5%">Posts</th>
                                                <th width="10%">Action</th>
                
                                          </tr>
                                         </thead>
                                         <tbody>
                    @php ($i = 1)                   
                    @foreach($categories as $category)     
                <tr>
                <td width="2%">
                @if($category['id'] != 1){!! Form::input('checkbox','item[]',$category['id'],['class' => 'chkItems', 'onclick' => 'checkUnCheckParent()'])!!}@endif
                </td>
                <td width="10%">{{ $i++ }}</td>
                <td width="20%">{{ $category['title'] }}</td> 
                <td width="30%">{!! $category['cat_tree'] !!}</td>  
                <td width="20%">{!! Form::select('post_status', ['0' => 'No','1' => 'Yes'],$category['post_status'],['class' => 'form-control', 'onchange' => 'changeStatus(this.value,'. $category['id'] .')']) !!} 
                </td>   
                <td width="5%"><a href="{{ route('admin.posts.list',$category['id']) }}">{{ $category['post_count'] }}</a></td>          
                <td width="10%">
                <span class="action"><a href="{{ route('admin.category.edit',$category['id']) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
                </td>
            </tr>  
                   @endforeach                 
                                        </tbody>
                                       </table>
                                       {!! Form::close() !!}
	                              </div>
			                </div>
			         </div>
			      </div>
				  
					<!-- Modal -->
					
					<div class="modal fade" id="myModal" role="dialog">
						<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Category Tree View</h4>
							</div>
							<div class="modal-body">
							
								@foreach ($category_tree as $tree_view)
								
									{!! $tree_view !!}
									
								@endforeach
							
							</div>
						</div>
					</div>
					</div>
					
					<!-- End Modal -->
				</div>
				
				  	
            </div>
		    </div>
            </div>
            <!-- /.container-fluid -->

</div>
@endsection
@push('custom-js')
<script>
function changeStatus(status,categoryID){

  var token = $('input[name="_token"]').val();

  $.ajax({

            type: 'POST',
            url:  '{{ route('admin.category.change_status') }}',
            data : {'_token': token,'status' : status,'id' : categoryID},
            success :  function(response){
                if(response.status === true) {
                    $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-circle" aria-hidden="true"></i> <strong>Success : </strong> &nbsp; '+ response.success +'</div>');
                } else {
                    $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="glyphicon glyphicon-remove-sign"></span> <strong>Success : </strong> &nbsp;'+ response.danger +'</div>');
                }
                setTimeout( function(){
                    $('#info').load(location.href +  ' #info');
                },3000);
            },
            error: function(xhr){
                  console.log("An error occured: " + xhr.status + " " + xhr.statusText);
            }


  });

}
</script>
@endpush
