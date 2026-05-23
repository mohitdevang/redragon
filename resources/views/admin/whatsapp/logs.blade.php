@extends('layouts.main')
@section('title', 'WhatsApp Logs')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    WhatsApp Message Logs
                    <a class="btn btn-default pull-right" href="{{ route('admin.whatsapp.settings') }}"><i class="fa fa-cog"></i> Settings</a>
                </h1>
                <ol class="breadcrumb">{{ generateBreadcrumb() }}</ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                @component('elements.admin.components.flash') @endcomponent
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-whatsapp fa-fw"></i> Message log <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="12%">Type</th>
                                        <th width="12%">Mobile</th>
                                        <th width="14%">User ID</th>
                                        <th width="14%">Template</th>
                                        <th width="8%">Status</th>
                                        <th width="12%">Sent At</th>
                                        <th width="23%">Error</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                    <tr>
                                        <td>{{ $log->id }}</td>
                                        <td>{{ $log->message_type }}</td>
                                        <td>{{ $log->mobile_number ?: '—' }}</td>
                                        <td>{{ $log->user_id ?: '—' }}</td>
                                        <td>{{ $log->template_name ?: '—' }}</td>
                                        <td>
                                            @if($log->status === 'sent')
                                                <span class="label label-success">sent</span>
                                            @else
                                                <span class="label label-danger">{{ $log->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $log->sent_at ? $log->sent_at->format('Y-m-d H:i:s') : '—' }}</td>
                                        <td title="{{ $log->error_message }}">{{ Str::limit($log->error_message, 100) ?: '—' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-js')
<script>
$(window).on('load', function () {
    var $table = $('#example');
    if ($table.length && $.fn.DataTable && $.fn.DataTable.isDataTable($table)) {
        $table.DataTable().order([0, 'desc']).draw();
    }
});
</script>
@endpush
