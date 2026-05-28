@extends('layouts.main')
@section('title') Lapse Income History @endsection
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Lapse Income <small>Audit Overview</small>
                </h1>
                <ol class="breadcrumb">
                    {{ generateBreadcrumb() }}
                </ol>
            </div>
        </div>

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
                            <div class="panel-heading clearfix">
                                <h3 class="panel-title">
                                    <i class="fa fa-history"></i> Lapse Income History
                                    <span class="pull-right">Total Lapse Income: <strong>{{ number_format($total_lapse, 2) }} USDT</strong></span>
                                </h3>
                            </div>
                            <div class="panel-body" style="overflow-x:auto;">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered" style="min-width: 1100px;">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Income Type</th>
                                                <th>Amount (USDT)</th>
                                                <th>Original Beneficiary</th>
                                                <th>Trigger User</th>
                                                <th>Package</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                                <th>Reference ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rows as $row)
                                            <tr>
                                                <td>{{ $row->created_at }}</td>
                                                <td>{{ strtoupper($row->income_type) }}</td>
                                                <td>{{ number_format($row->amount, 2) }}</td>
                                                <td>{{ $row->beneficiary_user_id }}</td>
                                                <td>{{ $row->trigger_user_id }}</td>
                                                <td>{{ $row->package_id ?? '-' }}</td>
                                                <td>{{ $row->reason }}</td>
                                                <td>{{ ucfirst($row->status) }}</td>
                                                <td>{{ $row->reference_uid }}</td>
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
    </div>
</div>
@endsection
