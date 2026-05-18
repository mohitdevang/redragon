<div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-menu">
            
            
            
                <ul class="nav navbar-nav side-nav">
                <div class="profile clearfix">
                    <div class="profile_pic">
                    @if(Auth::guard('admin')->user()->image)
                    <img src="{!! asset('public/uploads/'.Auth::guard('admin')->user()->image) !!}" alt="{{ Auth::guard('admin')->user()->name }}" class="img-circle profile_img">
                    @else
                    <img src="{!! asset('public/admin-design/images/dummy-profile.png') !!}" alt="{{  Auth::guard('admin')->user()->name }}" class="img-circle profile_img">
                    @endif 
                    </div>
                    <div class="profile_info">
                    <span>Welcome,</span>
                    <h2>{{ Auth::guard('admin')->user()->name }}</h2>
                    </div>
                    </div>
                    
                    <li>
                        <a href="{{ route('admin.dashboard') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#collapse2"><i class="fa fa-bars" aria-hidden="true"></i>
 Members <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="collapse2" class="collapse left-design">
                            <li>
                                <a href="{{ route('admin.show.member') }}">All Members</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.show.member.kyc') }}">Members KYC</a>
                            </li>
                        </ul>
                      
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#memreq"><i class="fa fa-bars" aria-hidden="true"></i>
 Members  Request<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="memreq" class="collapse left-design">
                            <li>
                                <a href="{{ route('admin.show.member_request') }}">Show Wallet Request</a>
                            </li>

                            <!-- <li>-->
                            <!--    <a href="{{ route('admin.show.upgrade_request') }}">Show Upgrade Request</a>-->
                            <!--</li>-->


                             <li>
                                <a href="{{ route('admin.show.member_request_history') }}">Request History</a>
                            </li>
                        </ul>
                      
                    </li>


                        <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#withdraw"><i class="fa fa-bars" aria-hidden="true"></i>
Withdraw<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="withdraw" class="collapse left-design">
                            <li>
                                <a href="{{ route('admin.show.withdraw_request') }}">Show Withdraw Request</a>
                            </li>

                             <li>
                                <a href="{{ route('admin.show.withdraw_request_history') }}">Withdraw Request History</a>
                            </li>
                        </ul>
                      
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#collapse3"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Pin Generation <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="collapse3" class="collapse left-design">
                            <li>
                                <a href="{{ route('admin.generate.pin') }}">Generate pin</a>
                            </li>
                             <li>
                                <a href="{{ route('admin.view.pin') }}">View pin</a>
                            </li>
                             
                        </ul>
                      
                    </li>


                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#collapseads"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Ads Management <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="collapseads" class="collapse left-design">
                            <li>
                                <a href="{{ route('admin.ads.videocreateview') }}">Generate Ads</a>
                            </li>
                             <li>
                                <a href="{{ route('admin.ads.view') }}">View Ads</a>
                            </li>
                             
                        </ul>
                      
                    </li>



                  <!--   <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#collapse4"><i class="fa fa-bars" aria-hidden="true"></i>
                     Level Plan <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="collapse4" class="collapse left-design">
                            <li>
                                <a href="{{ route('admin.generate.commission') }}">Generate Commission Plan</a>
                            </li>
                             <li>
                                <a href="{{ route('admin.view.plan') }}">View plan</a>
                            </li>
                        </ul>
                      
                    </li>
 -->
                    <!--<li>-->
                    <!--    <a href="javascript:;" data-toggle="collapse" data-target="#rewardsplan"><i class="fa fa-bars" aria-hidden="true"></i>-->
                    <!-- Rewards Plan <i class="fa fa-fw fa-caret-down"></i></a>-->
                    <!--    <ul id="rewardsplan" class="collapse left-design">-->
                    <!--        <li>-->
                    <!--            <a href="{{ route('admin.generate.rewards') }}">Generate Rewards Plan</a>-->
                    <!--        </li>-->
                    <!--         <li>-->
                    <!--            <a href="{{ route('admin.view.rewardplan') }}">View plan</a>-->
                    <!--        </li>-->
                    <!--    </ul>-->
                      
                    <!--</li>-->



                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#commreport"><i class="fa fa-bars" aria-hidden="true"></i>
                     Commission Report <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="commreport" class="collapse left-design">
                            <li>
                                <a href="{{ route('admin.show.direct_commission_report') }}">Self Ads income Report</a>
                            </li>
                             <li>
                                <a href="{{ route('admin.show.level_commission_report') }}">Level Commission report</a>
                            </li>
                            
                        </ul>
                      
                    </li>


<!-- 
                      <li>
                        <a href="{{ route('admin.notification') }}" ><i class="fa fa-bars" aria-hidden="true"></i>
                     Notification </a>
                 
                      
                    </li>
 -->

                      <li>
                        <a href="{{ route('admin.bank_details') }}" ><i class="fa fa-bars" aria-hidden="true"></i>
                     Bank Details </a>
                 
                      
                    </li>

                    
                         <li>
                            <a href="{{ route('admin.site.setting') }}"><i class="fa fa-cogs" aria-hidden="true"></i>
General Settings</a>
                            </li>

                </ul>
            </div>
            
        </nav>