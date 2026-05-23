@extends('layouts.main')
@section('title') Members KYC @endsection
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Members KYC <small>USDT Wallet</small></h1>
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
                        <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Member wallet addresses</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Member ID</th>
                                        <th>USDT (BEP-20) Wallet Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($member as $i => $mem)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $mem->registration_serial ?? '—' }}</td>
                                        <td>{{ $mem->name }}</td>
                                        <td>{{ $mem->unique_id }}</td>
                                        <td>{{ $mem->trc_address ?: '—' }}</td>
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
