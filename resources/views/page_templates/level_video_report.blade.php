@extends('layouts.user_profile')
@section('content')
<style>
    .dt-layout-start,
    .dt-layout-end {
        display: none !important;
    }

    .pool-cell-hidden {
        filter: blur(1.8px);
        opacity: 0.45;
        pointer-events: none;
        user-select: none;
    }

    .pool-dynamic-table th,
    .pool-dynamic-table td {
        color: #ffffff !important;
    }

    .pool-dynamic-table thead tr:first-child th {
        background: linear-gradient(0deg, #8f0d10 0%, #ff3b3ec4 100%) !important;
        color: #ffffff !important;
        font-weight: 600;
    }

    .pool-dynamic-table thead tr:nth-child(2) th {
        background: linear-gradient(0deg, #730c0d 0%, #a810127a 100%) !important;
        color: #ffffff !important;
        font-weight: 600;
    }

    .pool-dynamic-table tbody td {
        background-color: #19191A !important;
    }

    .pool-dynamic-table .custom-footer th {
        color: #F8E700 !important;
    }
</style>

<div class="content-page">
    <div class="col-md-12">
        <div class="glass-card">
            @isset($daily_ad_view_income)
                <div class="card-title-border"><h2 class="card-title">Daily Add View Income Report</h2></div>
                <div class="table-responsive table-wrapper">
                    <table class="table table-striped table-bordered w-100">
                        <thead><tr><th>Sl no</th><th>Date</th><th>User Id</th><th>Income</th></tr></thead>
                        <tbody>
                        @foreach($daily_ad_view_income as $i => $dc)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ date('d-m-Y', strtotime($dc->created_date)) }}</td>
                                <td>{{ $dc->member_id }}</td>
                                <td>{{ number_format((float) $dc->amount, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $daily_ad_view_income->links() }}
            @endisset

            @isset($level_ad_view_income)
                <div class="card-title-border"><h2 class="card-title">Level Income Report</h2></div>
                <div class="table-responsive table-wrapper">
                    <table id="example" class="table table-striped table-bordered w-100">
                        <thead><tr><th>Sl no</th><th>Level</th><th>Date</th><th>User Id</th><th>User Name</th><th>Amount</th></tr></thead>
                        <tbody>
                        @foreach($level_ad_view_income as $i => $dc)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $dc->rank }}</td>
                                <td>{{ date('d-m-Y', strtotime($dc->created_date)) }}</td>
                                <td>{{ $dc->direct_member_id }}</td>
                                <td>{{ get_user_details($dc->direct_member_id) }}</td>
                                <td>{{ number_format((float) $dc->amount, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $level_ad_view_income->links() }}
            @endisset

            @isset($community_income_upline)
                <div class="card-title-border"><h2 class="card-title">Community Upline Income Report</h2></div>
                <div class="table-responsive table-wrapper">
                    <table id="example" class="table table-striped table-bordered w-100">
                        <thead><tr><th>Sl no</th><th>Date</th><th>User Id</th><th>User Name</th><th>Level</th><th>Amount</th><th>Wallet Amount</th></tr></thead>
                        <tbody>
                        @foreach($community_income_upline as $i => $dc)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ date('d-m-Y', strtotime($dc->created_date)) }}</td>
                                <td>{{ $dc->direct_member_id }}</td>
                                <td>{{ get_user_details($dc->direct_member_id) }}</td>
                                <td>{{ $dc->level }}</td>
                                <td>{{ number_format((float) $dc->amount, 2, '.', '') }}</td>
                                <td>{{ number_format((float) $dc->in_wallet, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $community_income_upline->links() }}
            @endisset

            @isset($community_income_downline)
                <div class="card-title-border"><h2 class="card-title">Community Downline Income Report</h2></div>
                <div class="table-responsive table-wrapper">
                    <table id="example" class="table table-striped table-bordered w-100">
                        <thead><tr><th>Sl no</th><th>Date</th><th>User Id</th><th>User Name</th><th>Level</th><th>Amount</th><th>Wallet Amount</th></tr></thead>
                        <tbody>
                        @foreach($community_income_downline as $i => $dc)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ date('d-m-Y', strtotime($dc->created_date)) }}</td>
                                <td>{{ $dc->direct_member_id }}</td>
                                <td>{{ get_user_details($dc->direct_member_id) }}</td>
                                <td>{{ $dc->level }}</td>
                                <td>{{ number_format((float) $dc->amount, 2, '.', '') }}</td>
                                <td>{{ number_format((float) $dc->in_wallet, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $community_income_downline->links() }}
            @endisset

            @isset($commision_majic_pool)
                <div class="card-title-border"><h2 class="card-title">Magic Pool Income Report</h2></div>
                @php
                    $groupedData = collect($commision_majic_pool)->groupBy('package_id');
                @endphp
                @forelse($groupedData as $packageId => $entries)
                    @php
                        $byLevel = $entries->keyBy('level');
                        $firstRow = $entries->first();
                        $level1 = $byLevel->get(1);
                        $level2 = $byLevel->get(2);
                        $level3 = $byLevel->get(3);
                        $level1Team = (int) ($level1->team ?? 0);
                        $level2Team = (int) ($level2->team ?? 0);
                        $level3Team = (int) ($level3->team ?? 0);

                        $level2Unlocked = $level1Team >= 2;
                        $level3Unlocked = $level2Team >= 4;

                        $level1Completed = $level1Team >= 2;
                        $level2Completed = $level2Team >= 4;
                        $level3Completed = $level3Team >= 8;
                        $completedCycles = \Illuminate\Support\Facades\DB::table('commision_majic_pool')
                            ->where('user_id', Auth::guard()->user()->unique_id)
                            ->where('packg_id', $packageId)
                            ->where('level', 3)
                            ->where('status', 'closed')
                            ->count();
                        $packageIncome = \Illuminate\Support\Facades\DB::table('commision_majic_pool')
                            ->where('user_id', Auth::guard()->user()->unique_id)
                            ->where('packg_id', $packageId)
                            ->where('status', 'closed')
                            ->sum('taxable_profit');
                    @endphp
                    <div class="table-responsive table-wrapper mb-4">
                        <div class="d-flex justify-content-between">
                            <div class="item-magic d-flex align-items-center gap-2 px-3 py-1">
                                <img src="{{url('/')}}/public/admin/assets/images/png/table-icon.png" alt="icon" height="35">
                                <h5 class="mb-0 font-20 text-white medium">{{ $firstRow->pack_package_name }}</h5>
                            </div>
                            <div class="d-flex gap-3 align-items-center">
                                <div class="item-entry w-auto h-auto px-3 py-2">
                                    <h5 class="mb-0 font-20 text-white medium">Entry Fee = {{ number_format((float) $firstRow->pack_price, 2, '.', '') }} $</h5>
                                </div>
                                <a href="{{ route('pool_income_report_history') }}" class="item-view w-auto h-auto px-3 py-2" style="text-decoration:none;">
                                    <h5 class="mb-0 font-20 text-white medium">View Income</h5>
                                </a>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered w-100 pool-dynamic-table">
                            <thead>
                                <tr><th colspan="8">{{ $firstRow->pack_package_name }}</th></tr>
                                <tr><th>Level</th><th>Entry</th><th>Team</th><th>Amount</th><th>Upgrade</th><th>Re-Birth</th><th>Profit</th><th>Cycle</th></tr>
                            </thead>
                            <tbody>
                                <tr class="row-highlight">
                                    <td>1</td>
                                    <td>{{ number_format((float) ($level1->entry_fee ?? $firstRow->entry_fee_level_1 ?? 0), 2, '.', '') }}</td>
                                    <td class="{{ $level1Team > 0 ? '' : 'pool-cell-hidden' }}">{{ $level1->team ?? 0 }}</td>
                                    <td class="{{ $level1Completed ? '' : 'pool-cell-hidden' }}">{{ number_format((float) ($level1->amount ?? 0), 2, '.', '') }}</td>
                                    <td class="{{ $level1Completed ? '' : 'pool-cell-hidden' }}">{{ (float) ($level1->upgrade ?? 0) > 0 ? number_format((float) $level1->upgrade, 2, '.', '') : '-' }}</td>
                                    <td class="{{ $level1Completed ? '' : 'pool-cell-hidden' }}">{{ (float) ($level1->re_birth ?? 0) > 0 ? number_format((float) $level1->re_birth, 2, '.', '') : '-' }}</td>
                                    <td class="{{ $level1Completed ? '' : 'pool-cell-hidden' }}">{{ number_format((float) ($level1->profit_level ?? 0), 2, '.', '') }}</td>
                                    <td class="{{ $level1Completed ? '' : 'pool-cell-hidden' }}">{{ $level1->cycle ?? 0 }}</td>
                                </tr>
                                <tr class="{{ $level2Unlocked ? 'row-highlight' : 'row-blur' }}">
                                    <td>2</td>
                                    <td>{{ number_format((float) ($level2->entry_fee ?? $firstRow->entry_fee_level_2 ?? 0), 2, '.', '') }}</td>
                                    <td class="{{ ($level2Unlocked && $level2Team > 0) ? '' : 'pool-cell-hidden' }}">{{ $level2->team ?? 0 }}</td>
                                    <td class="{{ ($level2Unlocked && $level2Completed) ? '' : 'pool-cell-hidden' }}">{{ number_format((float) ($level2->amount ?? 0), 2, '.', '') }}</td>
                                    <td class="{{ ($level2Unlocked && $level2Completed) ? '' : 'pool-cell-hidden' }}">{{ (float) ($level2->upgrade ?? 0) > 0 ? number_format((float) $level2->upgrade, 2, '.', '') : '-' }}</td>
                                    <td class="{{ ($level2Unlocked && $level2Completed) ? '' : 'pool-cell-hidden' }}">{{ (float) ($level2->re_birth ?? 0) > 0 ? number_format((float) $level2->re_birth, 2, '.', '') : '-' }}</td>
                                    <td class="{{ ($level2Unlocked && $level2Completed) ? '' : 'pool-cell-hidden' }}">{{ number_format((float) ($level2->profit_level ?? 0), 2, '.', '') }}</td>
                                    <td class="{{ ($level2Unlocked && $level2Completed) ? '' : 'pool-cell-hidden' }}">{{ $level2->cycle ?? 0 }}</td>
                                </tr>
                                <tr class="{{ $level3Unlocked ? 'row-highlight' : 'row-blur' }}">
                                    <td>3</td>
                                    <td>{{ number_format((float) ($level3->entry_fee ?? $firstRow->entry_fee_level_3 ?? 0), 2, '.', '') }}</td>
                                    <td class="{{ ($level3Unlocked && $level3Team > 0) ? '' : 'pool-cell-hidden' }}">{{ $level3->team ?? 0 }}</td>
                                    <td class="{{ ($level3Unlocked && $level3Completed) ? '' : 'pool-cell-hidden' }}">{{ number_format((float) ($level3->amount ?? 0), 2, '.', '') }}</td>
                                    <td class="{{ ($level3Unlocked && $level3Completed) ? '' : 'pool-cell-hidden' }}">{{ (float) ($level3->upgrade ?? 0) > 0 ? number_format((float) $level3->upgrade, 2, '.', '') : '-' }}</td>
                                    <td class="{{ ($level3Unlocked && $level3Completed) ? '' : 'pool-cell-hidden' }}">{{ (float) ($level3->re_birth ?? 0) > 0 ? number_format((float) $level3->re_birth, 2, '.', '') : '-' }}</td>
                                    <td class="{{ ($level3Unlocked && $level3Completed) ? '' : 'pool-cell-hidden' }}">{{ number_format((float) ($level3->profit_level ?? 0), 2, '.', '') }}</td>
                                    <td class="{{ ($level3Unlocked && $level3Completed) ? '' : 'pool-cell-hidden' }}">{{ $level3->cycle ?? 0 }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="custom-footer">
                                    <th></th><th></th><th></th><th></th>
                                    <th colspan="2" class="regular text-center" style="color: #F8E700;">
                                        <img src="{{url('/')}}/public/admin/assets/images/svg/refresh.svg" alt="refresh"> Cycle {{ $completedCycles }}
                                    </th>
                                    <th colspan="2" class="regular text-center" style="color: #F8E700;">Income = {{ number_format((float) $packageIncome, 2, '.', '') }} $</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @empty
                    <p class="text-white">No magic pool data found.</p>
                @endforelse
            @endisset

            @isset($commision_majic_pool_history)
                <div class="card-title-border"><h2 class="card-title">Magic Pool History</h2></div>
                <div class="table-responsive table-wrapper">
                    <table id="example" class="table table-striped table-bordered w-100">
                        <thead><tr><th>Slno</th><th>Date</th><th>Package</th><th>Cycle</th><th>Level</th><th>Income</th></tr></thead>
                        <tbody>
                        @foreach($commision_majic_pool_history as $i => $dc)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ date('d-m-Y', strtotime($dc->date)) }}</td>
                                <td>{{ $dc->pack_package_name }}</td>
                                <td>{{ $dc->cycle }}</td>
                                <td>{{ $dc->level }}</td>
                                <td>{{ number_format((float) $dc->profit_level, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $commision_majic_pool_history->links() }}
            @endisset

            @isset($procust_purchase_income)
                <div class="card-title-border"><h2 class="card-title">Re-Purchase Income Report</h2></div>
                <div class="table-responsive table-wrapper">
                    <table class="table table-striped table-bordered w-100">
                        <thead><tr><th>Level</th><th>Date</th><th>User Id</th><th>User Name</th><th>Amount</th></tr></thead>
                        <tbody>
                        @foreach($procust_purchase_income as $dc)
                            <tr>
                                <td>{{ $dc->rank }}</td>
                                <td>{{ date('d-m-Y', strtotime($dc->created_date)) }}</td>
                                <td>{{ $dc->direct_member_id }}</td>
                                <td>{{ get_user_details($dc->direct_member_id) }}</td>
                                <td>{{ number_format((float) $dc->amount, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $procust_purchase_income->links() }}
            @endisset

            @isset($direct_income)
                <div class="card-title-border"><h2 class="card-title">Direct Income Report</h2></div>
                <div class="table-responsive table-wrapper">
                    <table id="example" class="table table-striped table-bordered w-100">
                        <thead><tr><th>Sl no</th><th>Date</th><th>User Id</th><th>User Name</th><th>Level</th><th>Amount</th></tr></thead>
                        <tbody>
                        @foreach($direct_income as $i => $dc)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ date('d-m-Y', strtotime($dc->created_date)) }}</td>
                                <td>{{ $dc->direct_member_id }}</td>
                                <td>{{ get_user_details($dc->direct_member_id) }}</td>
                                <td>{{ $dc->rank }}</td>
                                <td>{{ number_format((float) $dc->amount, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $direct_income->links() }}
            @endisset

            @isset($reward_income)
                <div class="card-title-border"><h2 class="card-title">Reward Income Report</h2></div>
                <div class="table-responsive table-wrapper">
                    <table class="table table-striped table-bordered w-100">
                        <thead><tr><th>Sl no</th><th>Date</th><th>User Id</th><th>Income</th></tr></thead>
                        <tbody>
                        @foreach($reward_income as $i => $dc)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ date('d-m-Y', strtotime($dc->created_date)) }}</td>
                                <td>{{ $dc->member_id }}</td>
                                <td>{{ number_format((float) $dc->amount, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $reward_income->links() }}
            @endisset
        </div>
    </div>
</div>
@endsection
