@extends('layouts.main')
@section('title') Edit Member @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Edit <small> Member</small>
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
                                <h3 class="panel-title"><i class="fa fa-user"></i>
                                Edit Member
                                <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                            <form autocomplete="off" id="page" method="POST" action="{{ route('admin.member.update', $member->id) }}">
                                @csrf
                                @method('PATCH')
                                @include('admin.members._partials.form')
                                <div class="form-actions pull-right">
                                    <button name="Submit" type="submit" value="update" class="btn btn-info btn-rounded">
                                        <i class="fa fa-pencil"></i> Update
                                    </button>
                                </div>
                            </form>
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

