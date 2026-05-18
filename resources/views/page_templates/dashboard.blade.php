@extends('layouts.user_profile')

@section('content')



<!-- Welcome Banner -->
<div class="glass-card welcome-banner-card">
    <h2 class="welcome-text">“{!!$setting->noti_dashboard!!}”</h2>
</div>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif



<!-- Stats Cards Row 1 -->
<h3 class="section-heading">User Section</h3>
<section class="stats-grid">
    <!-- My Account Status -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>My Account Status</h3>
                <div class="stat-value status-green">Active</div>
            </div>
            <div class="stat-icon success">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Direct Partner -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>Direct Partner</h3>
                <div class="stat-value">3</div>
            </div>
            <div class="stat-icon magenta">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <line x1="19" y1="8" x2="19" y2="14" />
                    <line x1="22" y1="11" x2="16" y2="11" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Direct Partner -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>Active Direct Partner</h3>
                <div class="stat-value">62</div>
            </div>
            <div class="stat-icon purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 11l-2 2-2-2" />
                    <path d="M20 13V7" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Team Partner -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>Team Partner</h3>
                <div class="stat-value">51</div>
            </div>
            <div class="stat-icon cyan">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--primary-light)" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Team Partner -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>Active Team Partner</h3>
                <div class="stat-value">51</div>
            </div>
            <div class="stat-icon cyan">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--primary-light)" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    <circle cx="19" cy="11" r="2" fill="var(--success)" />
                </svg>
            </div>
        </div>
    </div>
</section>


<!-- Welcome Card & Referral Section -->
<section class="content-grid">
    <div class="glass-card welcome-info-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Welcome to <span>RedDragon</span></h2>
                <p class="card-subtitle">Your Dashboard</p>
            </div>
        </div>
        <div class="welcome-details">
            <div class="detail-row">
                <span class="detail-label">Registration Date</span>
                <span class="detail-value">2022-06-15 19:25:45</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Activation Date</span>
                <span class="detail-value">2025-12-23 14:53:54</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">My Rank</span>
                <span class="detail-value highlight">One</span>
            </div>
        </div>
    </div>

    <div class="glass-card referral-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Your <span>Referral Link</span></h2>
                <p class="card-subtitle">Share and earn rewards</p>
            </div>
        </div>
        <?php $url=url('/').'/member-add/'.Auth::guard()->user()->unique_id;?>
        <a class="referral-box text-nowrap" href="{{$url}}">
            <input type="text" value="{{ url('/')}}/member-add/{{Auth::guard()->user()->unique_id}}" id="myInput"
                class="font-20 medium w-100 referral-input">
            <button class="copy-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                </svg>
            </button>
        </a>
        <div class="referral-stats-row">
            <div class="ref-stat">
                <span class="ref-stat-value">0</span>
                <span class="ref-stat-label">Direct Referrals</span>
            </div>
            <div class="ref-stat">
                <span class="ref-stat-value">0</span>
                <span class="ref-stat-label">Active Referrals</span>
            </div>
        </div>
    </div>
</section>


<!-- Welcome Card & Referral Section -->
<section class="content-grid">
    <div class="glass-card welcome-info-card">

        <div class="activity-header">
            <div class="header-left">
                <div class="header-icon">🕐</div>
                <div class="header-text">
                    <h2 class="font-26 bold mb-0">Today Activity</h2>
                    <p class="grayColor font-14 mb-0">Latest transactions</p>
                </div>
            </div>
            <a href="#" class="view-all-btn">View All</a>
        </div>

        <div class="activity-list d-flex flex-column gap-3">
            <div class="activity-item">
                <div class="item-left">
                    <div class="item-icon green">🔒</div>
                    <div class="item-info d-flex flex-column gap-1">
                        <h3 class="mb-0">Today Package Purchase</h3>
                        <p class="mb-0">Package bought today</p>
                    </div>
                </div>
                <div class="item-amount">+$1,000</div>
            </div>

            <div class="activity-item">
                <div class="item-left">
                    <div class="item-icon">💰</div>
                    <div class="item-info d-flex flex-column gap-1">
                        <h3 class="mb-0">Today Investment Amount</h3>
                        <p class="mb-0">Total invested today</p>
                    </div>
                </div>
                <div class="item-amount">+$48.60</div>
            </div>

            <div class="activity-item">
                <div class="item-left">
                    <div class="item-icon">📊</div>
                    <div class="item-info d-flex flex-column gap-1">
                        <h3 class="mb-0">Today ROI Income</h3>
                        <p class="mb-0">Return on investment</p>
                    </div>
                </div>
                <div class="item-amount">+$98.60</div>
            </div>

            <div class="activity-item">
                <div class="item-left">
                    <div class="item-icon">📈</div>
                    <div class="item-info d-flex flex-column gap-1">
                        <h3 class="mb-0">Today Level Income</h3>
                        <p class="mb-0">Level bonus earned</p>
                    </div>
                </div>
                <div class="item-amount">+$48.60</div>
            </div>

            <div class="activity-item">
                <div class="item-left">
                    <div class="item-icon">🏆</div>
                    <div class="item-info d-flex flex-column gap-1">
                        <h3 class="mb-0">Today Reward</h3>
                        <p class="mb-0">Reward earned today</p>
                    </div>
                </div>
                <div class="item-amount">+$48.60</div>
            </div>

            <div class="activity-item">
                <div class="item-left">
                    <div class="item-icon">👥</div>
                    <div class="item-info d-flex flex-column gap-1">
                        <h3 class="mb-0">Today Team Club Bonus</h3>
                        <p class="mb-0">Team bonus earned</p>
                    </div>
                </div>
                <div class="item-amount">+$42.60</div>
            </div>
        </div>

    </div>
    <!-- Quick Actions -->
    <div class="glass-card referral-card">
        <div class="activity-header">
            <div class="header-left">
                <div class="header-icon">⚡</div>
                <div class="header-text">
                    <h2 class="font-26 bold mb-0">Quick Actions</h2>
                    <p class="grayColor font-14 mb-0">Shortcuts for you</p>
                </div>
            </div>
        </div>

        <div class="grid">
            <a href="#" class="action-item">
                <div class="action-icon orange">➕</div>
                <div class="action-title">Deposit</div>
            </a>
            <a href="#" class="action-item">
                <div class="action-icon green">⬇️</div>
                <div class="action-title">Withdraw</div>
            </a>
            <a href="#" class="action-item">
                <div class="action-icon yellow">🔄</div>
                <div class="action-title">Transfer</div>
            </a>
            <a href="#" class="action-item">
                <div class="action-icon orange">🕐</div>
                <div class="action-title">History</div>
            </a>
            <a href="#" class="action-item">
                <div class="action-icon red">👥</div>
                <div class="action-title">Invite</div>
            </a>
            <a href="#" class="action-item">
                <div class="action-icon blue">🎧</div>
                <div class="action-title">Support</div>
            </a>
        </div>
    </div>
</section>

<!-- Wallet & Income Stats -->
<h3 class="section-heading">Income Section</h3>
<section class="stats-grid">
    <!-- Direct Partner Bonus -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>Direct Partner Bonus</h3>
                <div class="stat-value">$0</div>
            </div>
            <div class="stat-icon cyan">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--primary-light)" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Level Partner Bonus -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>Level Partner Bonus</h3>
                <div class="stat-value">$0</div>
            </div>
            <div class="stat-icon magenta">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                    <path d="M3 3v18h18" />
                    <path d="M7 16l4-4 4 4 5-5" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Global Magic Bonus -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>Global Magic Bonus</h3>
                <div class="stat-value">$0</div>
            </div>
            <div class="stat-icon purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                    <polygon
                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Global Community Bonus -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>Global Community Bonus</h3>
                <div class="stat-value">$0</div>
            </div>
            <div class="stat-icon success">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="2" y1="12" x2="22" y2="12" />
                    <path
                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                </svg>
            </div>
        </div>
    </div>
</section>


<!-- Withdrawal Stats -->
<h3 class="section-heading">My Wallet</h3>
<section class="stats-grid">
    <!-- Total Income Wallet -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>Total Income Wallet</h3>
                <div class="stat-value">$0</div>
            </div>
            <div class="stat-icon cyan">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--primary-light)" stroke-width="2">
                    <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4" />
                    <path d="M3 5v14a2 2 0 0 0 2 2h16v-5" />
                    <path d="M18 12a2 2 0 0 0 0 4h4v-4h-4z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Withdrawal -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>Total Withdrawal</h3>
                <div class="stat-value">$0</div>
            </div>
            <div class="stat-icon magenta">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                    <path d="M12 19V5" />
                    <path d="M5 12l7-7 7 7" />
                    <line x1="5" y1="19" x2="19" y2="19" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Available Balance -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>Total Available Balance</h3>
                <div class="stat-value">$0</div>
            </div>
            <div class="stat-icon purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                    <rect x="2" y="6" width="20" height="12" rx="2" />
                    <circle cx="12" cy="12" r="2" />
                    <path d="M6 12h.01M18 12h.01" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Top Up Wallet -->
    <div class="glass-card glass-card-3d stat-card">
        <div class="stat-card-inner">
            <div class="stat-info">
                <h3>Top Up Wallet</h3>
                <div class="stat-value">$0</div>
            </div>
            <div class="stat-icon success">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2">
                    <path d="M12 19V5" />
                    <path d="M19 12l-7-7-7 7" />
                    <circle cx="12" cy="16" r="1" />
                </svg>
            </div>
        </div>
    </div>
</section>




<!-- Withdrawal Stats -->
<h3 class="section-heading">Top Earner</h3>
<!-- Tab Navigation -->
<div class="tab-navigation">
    <button class="tab-btn active" onclick="switchTab('earner')">Top Earner</button>
    <button class="tab-btn" onclick="switchTab('loser')">Top Loser</button>
</div>

<!-- Top Earner Tab -->
<div id="earner-tab" class="tab-content">
    <div class="glass-card glass-card-3d w-100 p-4">
        <div class="d-flex flex-column gap-2">
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#1 John Doe <small class="grayColor">USR001</small></span>
                <span class="text-success">$15,000</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#2 Jane Smith <small class="grayColor">USR002</small></span>
                <span class="text-success">$12,500</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#3 Mike Johnson <small class="grayColor">USR003</small></span>
                <span class="text-success">$10,200</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#4 Sarah Williams <small class="grayColor">USR004</small></span>
                <span class="text-success">$9,800</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#5 David Brown <small class="grayColor">USR005</small></span>
                <span class="text-success">$8,500</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#6 Emily Davis <small class="grayColor">USR006</small></span>
                <span class="text-success">$7,200</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#7 Chris Wilson <small class="grayColor">USR007</small></span>
                <span class="text-success">$6,800</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#8 Lisa Anderson <small class="grayColor">USR008</small></span>
                <span class="text-success">$5,500</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#9 Robert Taylor <small class="grayColor">USR009</small></span>
                <span class="text-success">$4,200</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2">
                <span class="text-white">#10 Amanda Martinez <small class="grayColor">USR010</small></span>
                <span class="text-success">$3,800</span>
            </div>
        </div>
    </div>
</div>

<!-- Top Loser Tab -->
<div id="loser-tab" class="tab-content">
    <div class="glass-card glass-card-3d w-100 p-4">
        <div class="d-flex flex-column gap-2">
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#1 Mark Thompson <small class="grayColor">USR011</small></span>
                <span class="text-danger">-$8,500</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#2 Jessica Lee <small class="grayColor">USR012</small></span>
                <span class="text-danger">-$7,200</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#3 Kevin White <small class="grayColor">USR013</small></span>
                <span class="text-danger">-$6,800</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#4 Rachel Green <small class="grayColor">USR014</small></span>
                <span class="text-danger">-$5,500</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#5 Tom Harris <small class="grayColor">USR015</small></span>
                <span class="text-danger">-$4,900</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#6 Nicole Clark <small class="grayColor">USR016</small></span>
                <span class="text-danger">-$4,200</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#7 Brian Lewis <small class="grayColor">USR017</small></span>
                <span class="text-danger">-$3,800</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#8 Michelle Walker <small class="grayColor">USR018</small></span>
                <span class="text-danger">-$3,200</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <span class="text-white">#9 Daniel Hall <small class="grayColor">USR019</small></span>
                <span class="text-danger">-$2,500</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2">
                <span class="text-white">#10 Laura Allen <small class="grayColor">USR020</small></span>
                <span class="text-danger">-$1,800</span>
            </div>
        </div>
    </div>
</div>


@endsection

@push('js')

<script>

    function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("myInput");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */

    }
</script>
   <script>
        function switchTab(tab) {
            // Remove active class from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            
            // Add active class to selected tab
            if (tab === 'earner') {
                document.querySelector('.tab-btn:first-child').classList.add('active');
                document.getElementById('earner-tab').style.display = 'block';
                document.getElementById('loser-tab').style.display = 'none';
            } else {
                document.querySelector('.tab-btn:last-child').classList.add('active');
                document.getElementById('earner-tab').style.display = 'none';
                document.getElementById('loser-tab').style.display = 'block';
            }
        }
    </script>
@endpush