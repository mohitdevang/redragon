@extends('layouts.main')
@section('title') View Category @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            View <small> Category</small>
                        </h1>
                       <ol class="breadcrumb"></ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                    
                    
                    </div>
                </div>
                
            <div class="parent-content-wrapper">
             <div id="content-sortable">    
                
               <div class="row">
                    <div class="col-lg-12">
                      <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-user"></i> View Category<a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                            <div class="form-body">
                                        <h3 class="box-title">Category Info</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Title :</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static">{{ $category->title }} </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <h3 class="box-title">Description</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3"> Description :</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"> {{ $category->description }} </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3"> Image :</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"> @if( $category->image ) <img src="{!! asset('public/uploads/'.$category->image) !!}" alt="{{ $category->title }}" style="width:160px";height="80px" /> @endif</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Created At :</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"> {{ $category->created_at }} </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3"> Updated At :</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"> {{ $category->updated_at }} </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        
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