@extends('layouts.main')
@section('title') Tags @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Tags <small> Overview</small><a onclick="return confirm('Are you sure you want empty the data table?');" class="btn btn-inverse pull-right" href="{{ route('admin.tags.truncate') }}">Empty Table</a>
                        </h1>
                        <ol class="breadcrumb">{{ generateBreadcrumb() }}</ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div id="info">
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
                                    {!! Form::open([ 'route'=> ['admin.tags.delete'], 'method' => 'DELETE','onsubmit' => 'return datatable_validation()']) !!}
                                  <p><button type="submit" name="bulk_delete" class="btn btn-danger btn-rounded"><i class="fa fa-trash"></i></button><a class="btn btn-success pull-right" href="{{ route('admin.tag.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a></p>
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th width="2%">{!! Form::input('checkbox','chkHeader',null,['id' => 'chkHeader', 'onclick' => 'checkUncheckAll(this)'])!!}</th>
                                                <th width="10%">Sl No.</th>
                                                <th width="30%">Title</th>
												<th width="5%">Posts</th>
                                                <th width="10%">Action</th>
                
                                          </tr>
                                         </thead>
                                         <tbody>
                    @php ($i = 1)                   
                    @foreach($tags as $tag)     
                <tr>
                <td width="2%">
                {!! Form::input('checkbox','item[]',$tag->id,['class' => 'chkItems', 'onclick' => 'checkUnCheckParent()'])!!}
                </td>
                <td width="10%">{{ $i++ }}</td>
                <td width="30%">{{ $tag->title }}</td>  
				<th width="5%"><a href="{{ route('admin.posts.list',['cat_id' => null,'tag_id' => $tag->id]) }}">{{ count($tag->posts) }}</a></th>             
                <td width="10%">
                <span class="action"><a href="{{ route('admin.tag.edit',$tag->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
                <span class="action"><a onclick="return confirm('Are you sure you want delete ?');" href="{{ route('admin.tag.delete',$tag->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
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
				</div>
				
				  	
            </div>
		    </div>
            </div>
            <!-- /.container-fluid -->

</div>
@endsection
