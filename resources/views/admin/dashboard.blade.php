@extends('layouts.main')
@section('title') Dashboard @endsection
@section('content')
<style>
    #page-wrapper .huge {
        font-size: 30px !important;
    }
</style>
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>	
                        </h1>
                        <ol class="breadcrumb">
                          {{ generateBreadcrumb() }} 
                        </ol>

                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        @component('elements.admin.components.flash') @endcomponent 
                    </div>
                </div>
              
			<div class="parent-content-wrapper">
			 <div id="content-sortable">
				
					
                
                <div class="row">
					<div class="col-lg-12 clearfix" id="containment-wrapper">
						<ul id="interchange">
						
				
					<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-tasks fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">{{$totaluser}}</div>
											</div>
											<div class="col-xs-12">Total Member</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>
							
							<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-tasks fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">{{$active_direct_user}}</div>
											</div>
											<div class="col-xs-12">Active Member</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>
							<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-exchange fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">$ {{ number_format($total_topup_wallet_usage ?? 0, 2, '.', '') }}</div>
											</div>
											<div class="col-xs-12" style="padding:0;">Total Top-Up Wallet Usage</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>
							
							
							
					<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-tasks fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">$ {{ number_format($total_direct_income, 2, '.', '') }}</div>
											</div>
											<div class="col-xs-12">Total Direct Income</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>

							<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-exclamation-triangle fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">$ {{ number_format($total_lapse_income ?? 0, 2, '.', '') }}</div>
											</div>
											<div class="col-xs-12">Total Lapse Income</div>
										</div>
									</div>
								</div>
								</div>
							</li>
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
									<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-tasks fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">$ {{ number_format($total_level_view, 2, '.', '') }}</div>
											</div>
											<div class="col-xs-12">Total Level Income</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>
							
							
									<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-tasks fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">$ {{ number_format($total_magic_income, 2, '.', '') }}</div>
											</div>
											<div class="col-xs-12">Total Magic Income</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>
							
							
									<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-tasks fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">$ {{ number_format($total_community_income, 2, '.', '') }}</div>
											</div>
											<div class="col-xs-12">Total Community Income</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>
							
							
									<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-tasks fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">{{ $pending_withdraw_requests ?? 0 }}</div>
											</div>
											<div class="col-xs-12">Total Withdraw Pending Requests</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>
							
							
									<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-tasks fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">$ {{ number_format($total_withdraw_approved ?? 0, 2, '.', '') }}</div>
											</div>
											<div class="col-xs-12">Total Withdrawal</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>
							
									<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-tasks fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">{{ $total_buy_usdt_requests ?? 0 }}</div>
											</div>
											<div class="col-xs-12">Total Buy USDT Requests</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>
							<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-tasks fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">{{ $pending_buy_usdt_requests ?? 0 }}</div>
											</div>
											<div class="col-xs-12">Total Pending Buy USDT Requests</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>
							<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-tasks fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">{{ $approved_buy_usdt_requests ?? 0 }}</div>
											</div>
											<div class="col-xs-12">Total Approved Buy USDT Requests</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>
							<li>
								<div class="panel_division">
									<div class="panel panel-green">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3 col-md-3">
												<i class="fa fa-tasks fa-4x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">$ {{ number_format($approved_buy_usdt_amount ?? 0, 2, '.', '') }}</div>
											</div>
											<div class="col-xs-12">Total Approved Buy USDT Amount</div>
										</div>
									</div>
									
								</div>
								</div>
							</li>
						
							
						


							
							</li>
							
						
						</ul>
					</div>
                </div>
                <!-- /.row -->

                {{--<div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Area Chart <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-area-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>--}}
                <!-- /.row -->
     
                <!-- /.row -->
            </div>
		    </div>
            </div>
            <!-- /.container-fluid -->

</div>
@endsection