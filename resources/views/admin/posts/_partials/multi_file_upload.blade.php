<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-fw fa-edit"></i> Multiple Image Upload <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
            </div>
            <div class="panel-body">
                <h3 class="card-title">Post Images </h3>
                <hr>
                <div class="row">
                    <div class="col-lg-12">
                        @php($level_text = ($postfiles) ? 'Add Images' : 'Add More Images')
                        {!! Form::open([ 'route' => ['admin.post.files.store'],'autocomplete'=>'off', 'files'=> true,'id'=>'post_files', 'method' => 'POST']) !!}
                        {!! Form::input('hidden','post_id', $post->id)!!} 
                        <div class="form-group">
                            {!! Form::label('id-input-file-3', $level_text,[ 'class' => 'control-label']) !!}
                            {!! Form::input('file', 'images[]', null, ['id' => 'id-input-file-3','multiple' => 'multiple']) !!} 
                            <div class="error">
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="form-actions pull-right">
                            {!! Form::button('<i class="fa fa-check"></i> Upload',['type' => 'submit', 'value' => 'Add', 'class' => 'btn btn-rounded btn-success']) !!}
                        </div>
                    {!! Form::close() !!} 
                    </div>
                    <hr>  
                    @if($postfiles)
                    <div class="col-lg-12">
                        <div class="form-group">
                            {!! Form::label('', 'Existing Images',[ 'class' => 'control-label']) !!}
                            <ul class="ace-thumbnails clearfix">   
                                @foreach ($postfiles as $file)
                                <li>
                                    <a href="{!! asset('public/uploads/'.$file->file) !!}" data-rel="colorbox">
                                        <img width="Auto" height="120px" alt="150x150" src="{!! asset('public/uploads/'.$file->file) !!}" />
                                    </a>
                                    <div class="tools tools-bottom">                                              
                                        <a href="#" data-record-id="{{ $file->id }}" data-toggle="modal" data-target="#confirm-delete{{ $file->id }}">
                                            <i class="ace-icon fa fa-times red"></i>
                                        </a>                                                
                                    </div>
                                    <div class="modal fade" id="confirm-delete{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" style="width: 32%;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>You are about to delete <b><i class="title"></i></b> record, this procedure is irreversible.</p>
                                                    <p>Do you want to proceed?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-danger btn-ok" href="{{ route('admin.post.file.delete',$file->id) }}">Delete</a>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                   </div>
               </div>
            </div>
        </div>
    </div>
</div>