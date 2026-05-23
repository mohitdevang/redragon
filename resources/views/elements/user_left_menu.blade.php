<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <img src="{{url('/')}}/public/admin/assets/images/svg/logo.svg" alt="Logo" class="logo-img">
        <div class="user-info d-none">
            <strong>{{ Auth::guard()->user()->name }}</strong><br>
            <small>{{ Auth::guard()->user()->unique_id }}</small>
        </div>
    </div>

    <ul class="nav-menu">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('profile') }}" class="nav-link-list">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                </svg>
                Dashboard
            </a>
        </li>

        <!--  Buy USDT -->
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link-list submenu-toggle">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1" />
                    <circle cx="20" cy="21" r="1" />
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                </svg>
                Buy USDT
                <span class="submenu-arrow"></span>
            </a>
            <ul class="submenu">
                <li class="submenu-item"><a href="{{ route('send_request') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Buy USDT Request</a>
                </li>
                <li class="submenu-item"><a href="{{ route('view_request_status') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Buy USDT History</a></li>
            </ul>
        </li>

        <!-- Members Area -->
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link-list submenu-toggle">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                Members Area
                <span class="submenu-arrow"></span>
            </a>
            <ul class="submenu">
                <li class="submenu-item"><a href="{{ route('direct_member') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Direct Partner</a>
                </li>
                <li class="submenu-item"><a href="{{ route('all_member') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Level Partner</a>
                </li>
                <li class="submenu-item"><a href="{{ route('community_member') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Global Community
                        Upline</a></li>
                <li class="submenu-item"><a href="{{ route('community_member_downline') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Global Community Downline</a></li>
            </ul>
        </li>

        <!-- Income Area -->
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link-list submenu-toggle">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                Income Area
                <span class="submenu-arrow"></span>
            </a>
            <ul class="submenu">
                <li class="submenu-item"><a href="{{ route('video_report') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Direct Partner Bonus</a>
                </li>
                <li class="submenu-item"><a href="{{ route('level_video_report') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Level
                        Partner Bonus</a></li>
                <li class="submenu-item"><a href="{{ route('pool_income_report') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Global Magic Pool
                        Bonus</a></li>
                <li class="submenu-item"><a href="{{ route('community_income_upline') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Community
                        Bonus</a></li>
                <li class="submenu-item"><a href="{{ route('pool_income_report_history') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Magic
                        Pool History</a></li>
                <li class="submenu-item"><a href="{{ route('community_commosion_report_downline') }}"
                        class="submenu-link"> <span class="submenu-dot"></span>Community Bonus Downline</a></li>
            </ul>
        </li>

        <!-- Wallet Area-->
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link-list submenu-toggle">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                    <line x1="1" y1="10" x2="23" y2="10" />
                </svg>
                Wallet Area
                <span class="submenu-arrow"></span>
            </a>
            <ul class="submenu">
                <li class="submenu-item"><a href="{{ route('main_wallet_balance') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Income
                        Wallet</a></li>
                <li class="submenu-item"><a href="{{ route('secondary_wallet_balance') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Topup
                        Wallet</a></li>
                <li class="submenu-item"><a href="{{ route('community_wallet_balance') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Community Wallet</a></li>
                <li class="submenu-item"><a href="{{ route('community_wallet_history') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Community Wallet History</a></li>
                <li class="submenu-item"><a href="{{ route('wallet_transfer_view') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Transfer USDT</a></li>
                <li class="submenu-item"><a href="{{ route('wallet_to_wallet') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Wallet to
                        Wallet</a></li>
                <li class="submenu-item"><a href="{{ route('wallet_to_wallet_transaction_history') }}"
                        class="submenu-link"> <span class="submenu-dot"></span>Transfer History</a></li>
            </ul>
        </li>

        <!-- Package Activation -->
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link-list submenu-toggle">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 11 12 14 22 4" />
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                </svg>
                Package Activation
                <span class="submenu-arrow"></span>
            </a>
            <ul class="submenu">
                <li class="submenu-item"><a href="{{ route('active_pin_from_wallet_view') }}" class="submenu-link">
                        <span class="submenu-dot"></span>Activate ID</a></li>
                <li class="submenu-item"><a href="{{ route('secondary_wallet_transaction_history') }}"
                        class="submenu-link"> <span class="submenu-dot"></span>Activation History</a></li>
            </ul>
        </li>

        <!-- Profile -->
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link-list submenu-toggle">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Profile
                <span class="submenu-arrow"></span>
            </a>
            <ul class="submenu">
                <li class="submenu-item"><a href="{{ route('upload_profile_view') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>My
                        Profile</a></li>
                <li class="submenu-item"><a href="{{ route('upload_kyc_view') }}" class="submenu-link"> <span
                            class="submenu-dot"></span>Update Address</a></li>
            </ul>
        </li>

        <!-- Withdraw Area -->
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link-list submenu-toggle">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
               Withdraw Area
                <span class="submenu-arrow"></span>
            </a>
            <ul class="submenu">
                <li class="submenu-item"><a href="{{ route('withdraw_request_view') }}" class="submenu-link">

                        <span class="submenu-dot"></span>Withdraw
                        Request</a></li>
                <li class="submenu-item"><a href="{{ route('withdraw_history') }}" class="submenu-link">
                        <span class="submenu-dot"></span>Withdraw
                        History</a></li>
            </ul>
        </li>

        <!-- Share Link -->
        <li class="nav-item">
            <a href="{{ route('share_link') }}" class="nav-link-list">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="18" cy="5" r="3" />
                    <circle cx="6" cy="12" r="3" />
                    <circle cx="18" cy="19" r="3" />
                    <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" />
                    <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" />
                </svg>
                Share Link
            </a>
        </li>

        <!-- Change Password -->
        <li class="nav-item">
            <a href="{{ route('changepassword') }}" class="nav-link-list">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                Change Password
            </a>
        </li>

        <!-- Logout -->
        <li class="nav-item">
            <a href="{{ route('userlogout') }}" class="nav-link-list">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                Logout
            </a>
        </li>
    </ul>

</aside>