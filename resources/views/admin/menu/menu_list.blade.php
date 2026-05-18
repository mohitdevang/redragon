@extends('layouts.main')
@section('title') Pages @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Menus <small> Overview</small>{{--<a onclick="return confirm('Are you sure you want delete all the records of the table?');" class="btn btn-inverse pull-right" href="route('admin.pages.delete.all')">Delete All</a>--}}
                        </h1>
                        <ol class="breadcrumb">{{ generateBreadcrumb() }}<img class="pull-right ajax-loader" src="{!! asset('public/admin-design/images/btn-ajax-loader.gif') !!}" /></ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div id="info"></div>
                     @component('elements.admin.components.flash') @endcomponent 
                    </div>
                </div>

                
                
            <div class="parent-content-wrapper">
             <div id="content-sortable">    
              
                <div class="row">
                    <div class="col-lg-12">
                      <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Menus <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                                    {!! Form::open([ 'route'=> ['admin.menu.delete'], 'method' => 'DELETE','onsubmit' => 'return datatable_validation()']) !!}
                                  <p><button type="submit" name="bulk_delete" class="btn btn-danger btn-rounded"><i class="fa fa-trash"></i></button><br /></p>
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th width="2%">{!! Form::input('checkbox','chkHeader',null,['id' => 'chkHeader', 'onclick' => 'checkUncheckAll(this)'])!!}</th>
                                                <th width="10%">Sl No.</th>
                                                <th width="30%">Menu Name</th>
                                                  <th width="10%">Status</th>
                                                <th width="5%">Action</th>
                                                              
                                          </tr>
                                         </thead>
                                         <tbody>
                    @php ($i = 1)                   
                    @foreach($menus as $menu)     
                <tr>
                <td width="2%">{!! Form::input('checkbox','item[]',$menu->id,['class' => 'chkItems', 'onclick' => 'checkUnCheckParent()'])!!}</td>
                <td width="10%">{{ $i++ }}</td>
                <td width="30%">{{ $menu->menu_name }}</td> 

                <td width="10%">{!! Form::select('status', ['0' => 'Draft','1' => 'Publish'],$menu->status,['class' => 'form-control', 'onchange' => 'changeMenuStatus(this.value,'. $menu->id .')']) !!}</td>              
                <td width="10%">
                <span class="action"><a href="{{ route('admin.menu.edit',$menu->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
                {{--<span class="action"><a onclick="return confirm('Are you sure you want delete ?');" href="{{ route('admin.menu.delete',$menu->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>--}}
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

@push('custom-js')


<script>
function changeMenuStatus(status,pageID){

  var token = $('input[name="_token"]').val();

  $.ajax({

            type: 'POST',
            url:  '{{ route('admin.menu.change.status') }}',
            data : {'_token': token,'status' : status,'id' : pageID},
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

{{---End Page Status----}}

@endpush
