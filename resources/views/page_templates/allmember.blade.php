@extends('layouts.user_profile')
@section('content')
<div class="content-page">
    <div class="col-md-12">
        <div class="glass-card">
            <div class="card-title-border">
                <h2 class="card-title">Level Partner</h2>
            </div>
            <div class="table-responsive table-wrapper">
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Sl no</th>
                            <th>Level</th>
                            <th>Name</th>
                            <th>Id</th>
                            <th>Join Date</th>
                            <th>Active Date</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($all_user))
                        @php($s = 1)
                        @php($level = 1)
                        @foreach($all_user as $du)
                        <tr>
                            <td>{{ $s }}</td>
                            <td>Level-{{ $level }}</td>
                            <td>{{ $du->name }}</td>
                            <td>{{ $du->unique_id }}</td>
                            <td>{{ date('d-m-Y h:i a', strtotime($du->created_at)) }}</td>
                            <td>
                                @if($du->status != 'inactive' && $du->active_date)
                                    {{ date('d-m-Y h:i a', strtotime($du->active_date)) }}
                                @endif
                            </td>
                            <td>{{ $du->email }}</td>
                            <td>{{ $du->phone }}</td>
                            <td>{{ $du->country }}</td>
                            <td>
                                @if($du->status == 'active')
                                    <span class="btn btn-success">{{ ucwords($du->status) }}</span>
                                @else
                                    <span class="btn btn-danger">{{ ucwords($du->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @php($s++)
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
