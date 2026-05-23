@extends('layouts.main')
@section('title') Dashboard @endsection
@section('content')
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
												<i class="fa fa-tasks fa-5x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">{{$totaluser}}</div>
												<div>Total Member</div>
											</div>
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
												<i class="fa fa-tasks fa-5x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">{{$active_direct_user}}</div>
												<div>Active Member</div>
											</div>
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
												<i class="fa fa-tasks fa-5x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">₹ {{$total_level_view}}</div>
												<div>Total Level Income</div>
											</div>
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
												<i class="fa fa-tasks fa-5x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">₹ {{$total_self_view}}</div>
												<div>Total Self Income</div>
											</div>
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
												<i class="fa fa-tasks fa-5x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">₹ {{$total_onetime_view}}</div>
												<div>Total Onetime Income</div>
											</div>
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
												<i class="fa fa-tasks fa-5x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">₹ {{$total_reward}}</div>
												<div>Total Reward</div>
											</div>
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
												<i class="fa fa-tasks fa-5x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">₹ {{$total_credit}}</div>
												<div>Total amount credited</div>
											</div>
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
												<i class="fa fa-tasks fa-5x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">₹ {{$total_debit}}</div>
												<div>Total amount debited</div>
											</div>
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
												<i class="fa fa-tasks fa-5x"></i>
											</div>
											<div class="col-xs-9 scroll-none text-right">
												<div class="huge">₹ {{$total_balance}}</div>
												<div>Available Balance</div>
											</div>
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