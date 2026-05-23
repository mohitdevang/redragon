@extends('layouts.main')

@section('title', 'Pages')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Members <small>Overview</small>
                </h1>
                <ol class="breadcrumb">
                    {{ generateBreadcrumb() }}
                    <img class="pull-right ajax-loader" src="{{ asset('admin-design/images/btn-ajax-loader.gif') }}" />
                </ol>
            </div>
        </div>

        <!-- Flash -->
        <div class="row">
            <div class="col-lg-12">
                <div id="info"></div>
                @component('elements.admin.components.flash') @endcomponent
            </div>
        </div>

        <div class="parent-content-wrapper">
            <div id="content-sortable">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-bar-chart-o"></i> Member
                            <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a>
                        </h3>
                    </div>

                    <div class="panel-body" style="overflow:auto;">
                        <div class="table-responsive">

                            {{-- 🔍 Search --}}
                            <form method="GET" action="{{ route('admin.show.member') }}">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <input type="text" name="from_date" class="form-control datepicker"
                                            placeholder="From Date" value="{{ request('from_date') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <input type="text" name="to_date" class="form-control datepicker"
                                            placeholder="To Date" value="{{ request('to_date') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <input type="text" name="user_name" class="form-control"
                                            placeholder="User Name" value="{{ request('user_name') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <button class="btn btn-success btn-rounded">Search</button>
                                        <a href="{{ route('admin.show.member') }}" class="btn btn-danger btn-rounded">
                                            Cancel Search
                                        </a>
                                    </div>
                                </div>
                            </form>

                            {{-- 🗑 Bulk Delete --}}
                            <form method="POST"
                                  action="{{ route('admin.member.delete') }}"
                                  onsubmit="return datatable_validation();">
                                @csrf
                                @method('DELETE')

                                <p>
                                    <button class="btn btn-danger btn-rounded">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </p>

                                <table id="example1" class="table table-striped table-bordered" style="width:1400px;">
                                    <thead>
                                        <tr>
                                            <th width="30">
                                                <input type="checkbox" id="chkHeader"
                                                    onclick="checkUncheckAll(this)">
                                            </th>
                                            <th>Sl No.</th>
                                            <th>Name</th>
                                            <th>ID</th>
                                            <th>Password</th>
                                            <th>Sponsor ID</th>
                                            <th>Join Date</th>
                                            <th>Active Date</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Country</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            <th>Block / Unblock</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($member as $i => $mem)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="item[]"
                                                        value="{{ $mem->id }}"
                                                        class="chkItems"
                                                        onclick="checkUnCheckParent()">
                                                </td>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $mem->name }}</td>
                                                <td>{{ $mem->unique_id }}</td>
                                                <td>{{ $mem->secpwd }}</td>
                                                <td>{{ $mem->parent_id }}</td>
                                                <td>{{ $mem->created_at }}</td>
                                                <td>
                                                   {{$mem->status}}
                                                </td>
                                                <td>{{ $mem->phone }}</td>
                                                <td>{{ $mem->email }}</td>
                                                <td>{{ $mem->country }}</td>
                                                <td>{{ $mem->status }}</td>
                                                <td>
                                                    <a href="{{ route('admin.member.edit', $mem->id) }}">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <select class="form-control"
                                                        onchange="changePageStatus(this.value, {{ $mem->id }})">
                                                        <option value="0" {{ $mem->bstatus == 0 ? 'selected' : '' }}>
                                                            Active
                                                        </option>
                                                        <option value="1" {{ $mem->bstatus == 1 ? 'selected' : '' }}>
                                                            Block
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
