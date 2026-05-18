@extends('layouts.app')
@section('title') Posts @endsection
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Posts <small> Overview</small>{{--<a onclick="return confirm('Are you sure you want delete all the records of the table?');" class="btn btn-inverse pull-right" href="route('admin.posts.delete.all')">Delete All</a>--}}
                        </h1>
                        <ol class="breadcrumb">{{ generateBreadcrumb() }}</ol>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Posts <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                                    {!! Form::open([ 'route'=> ['admin.posts.delete'], 'method' => 'DELETE','onsubmit' => 'return datatable_validation()']) !!}
                                  <p><button type="submit" name="bulk_delete" class="btn btn-danger btn-rounded"><i class="fa fa-trash"></i></button><br /></p>
                                        <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th width="2%">{!! Form::input('checkbox','chkHeader',null,['id' => 'chkHeader', 'onclick' => 'checkUncheckAll(this)'])!!}</th>
                                                <th width="7%">Sl No.</th>
                                                <th width="20%">Title</th>
                                                <th width="20%">Slug</th>
                                                <th width="10%">Author</th>
                                                <th width="20%">Categories</th>
                                                <th width="20%">Tags</th>
                                                <th width="10%">Status</th>
                                                <th width="12%">Date</th>
                                                <th width="10%">Action</th>
                
                                          </tr>
                                         </thead>
                                         <tbody>
                    @php ($i = 1) 
                    @php ($prefix = ' ')                   
                    @foreach($posts as $post)     
                <tr>
                <td width="2%">{!! Form::input('checkbox','item[]',$post->id,['class' => 'chkItems', 'onclick' => 'checkUnCheckParent()'])!!}</td>
                <td width="7%">{{ $i++ }}</td>
                <td width="20%">{{ $post->title }}</td> 
                <td width="20%">{{ $post->slug }}</td> 
                <td width="10%">{{ $post->user->name }}</td>
                <td width="20%">
                    @foreach($post->categories as $category)
                       <a href="{{ route('admin.category.edit',$category->id) }}"> {{$prefix.$category->title }} </a>
                      @php ($prefix = ', ')
                    @endforeach
                      @php ($prefix = ' ')
                </td> 
                <td width="20%">
                  @foreach($post->tags as $tag)
                      <a href="{{ route('admin.tag.edit',$tag->id) }}"> {{$prefix.$tag->title }} </a>
                      @php ($prefix = ', ')
                    @endforeach
                      @php ($prefix = ' ')
                </td>
                <td width="10%">{!! Form::select('status', ['0' => 'Draft','1' => 'Publish'],$post->status,['class' => 'form-control', 'onchange' => 'changePostStatus(this.value,'. $post->id .')']) !!} 
                </td>
                <td width="12%">{{ date("d-m-Y h:i:s", strtotime($post->created_at)) }}</td>              
                <td width="10%">
                <span class="action"><a href="{{ route('admin.post.edit',$post->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
            {{--<span class="action"><a onclick="return confirm('Are you sure you want delete ?');" href="{{ route('admin.post.delete',$post->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>--}}
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

{{---Post Status----}}

<script>
function changePostStatus(status,postID){

  var token = $('input[name="_token"]').val();

  $.ajax({

            type: 'POST',
            url:  '{{ route('admin.post.change.status') }}',
            data : {'_token': token,'status' : status,'id' : postID},
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

{{---End Post Status----}}

@endpush

