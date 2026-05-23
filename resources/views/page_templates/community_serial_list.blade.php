@extends('layouts.user_profile')
@section('content')
<div class="content-page">
    <div class="col-md-12">
        <div class="glass-card">
            <div class="card-title-border">
                <h2 class="card-title">{{ $type }}</h2>
                <p class="grayColor font-14 mb-0">Up to 50 members by registration serial.</p>
            </div>
            <div class="table-responsive table-wrapper">
                <table id="example" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Sl no</th>
                            <th>Serial</th>
                            <th>Name</th>
                            <th>Id</th>
                            <th>Join Date</th>
                            <th>Active Date</th>
                            <th>Country</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $index => $member)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $member->registration_serial ?? '—' }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->unique_id }}</td>
                            <td>{{ $member->created_at ? date('d-m-Y h:i a', strtotime($member->created_at)) : '—' }}</td>
                            <td>
                                @if($member->status === 'active' && $member->active_date)
                                    {{ date('d-m-Y h:i a', strtotime($member->active_date)) }}
                                @endif
                            </td>
                            <td>{{ $member->country ?? '—' }}</td>
                            <td>
                                @if($member->status === 'active')
                                    <span class="btn btn-success">{{ ucwords($member->status) }}</span>
                                @else
                                    <span class="btn btn-danger">{{ ucwords($member->status ?? 'inactive') }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No members found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
