<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Admin Controllers
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MemberController;

// User / Front Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\User\Auth\LoginController as UserLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ErrorHandlerController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\Admin\WhatsappSettingsController;
use App\Http\Controllers\Auth\RegistrationOtpController;
use App\Http\Controllers\Auth\AddressOtpController;



Route::get('/clear-cache', function () {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    return 'Cache is cleared';
});

Route::prefix('admin')
    ->as('admin.')
    ->middleware('prevent-back-history')
    ->group(function () {

        /* ---------------- AUTH (NO auth:admin) ---------------- */
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
        Route::post('/logout', [AdminLoginController::class, 'adminLogout'])->name('logout');

        /* ---------------- PROTECTED ROUTES ---------------- */
        Route::middleware('auth:admin')->group(function () {

            Route::get('/', [AdminController::class, 'index'])->name('dashboard');
             Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

            Route::match(['get','patch'], '/settings', [SettingController::class, 'update'])->name('site.setting');
            Route::get('/whatsapp-settings', [WhatsappSettingsController::class, 'edit'])->name('whatsapp.settings');
            Route::patch('/whatsapp-settings', [WhatsappSettingsController::class, 'update'])->name('whatsapp.settings.update');
            Route::post('/whatsapp-settings/test-connection', [WhatsappSettingsController::class, 'testConnection'])->name('whatsapp.test_connection');
            Route::get('/whatsapp-logs', [WhatsappSettingsController::class, 'logs'])->name('whatsapp.logs');
            Route::match(['get','patch'], '/profile', [AdminController::class, 'profile'])->name('profile');
            Route::match(['get','patch'], '/change_password', [AdminController::class, 'change_password'])->name('change_password');

            /* ---------------- MEMBERS ---------------- */
            Route::get('/members/showmember', [MemberController::class, 'index'])->name('show.member');
            Route::get('/member-edit/{memberid}', [MemberController::class, 'member_edit'])->name('member.edit');
            Route::patch('/member-update/{memberid}', [MemberController::class, 'member_update'])->name('member.update');
            Route::post('/member/update/status', [MemberController::class, 'update_bstatus'])->name('member.change.bstatus');

            Route::get('/members/showmember-kyc', [MemberController::class, 'member_kyc'])->name('show.member.kyc');
            Route::delete('/members/delete', [MemberController::class, 'multiple_member_delete'])->name('member.delete');

            /* ---------------- PIN ---------------- */
            Route::get('/generate-pin', [MemberController::class, 'generatepin'])->name('generate.pin');
            Route::post('/pin-store', [MemberController::class, 'pin_store'])->name('store.pin');
            Route::get('/view-pin', [MemberController::class, 'view_pin'])->name('view.pin');
            Route::delete('/pin/delete', [MemberController::class, 'multiple_pin_delete'])->name('pin.delete');

            /* ---------------- COMMISSION / PLAN ---------------- */
            Route::get('/generate-commission', [MemberController::class, 'generate_commission'])->name('generate.commission');
            Route::post('/plan-store', [MemberController::class, 'plan_store'])->name('store.plan');
            Route::get('/view-plan', [MemberController::class, 'view_plan'])->name('view.plan');
            Route::get('/plan-edit/{planid}', [MemberController::class, 'plan_edit'])->name('plan.edit');
            Route::patch('/plan-update/{planid}', [MemberController::class, 'plan_update'])->name('plan.update');
            Route::delete('/plan/delete', [MemberController::class, 'multiple_plan_delete'])->name('plan.delete');

            /* ---------------- ADS MANAGEMENT ---------------- */
            Route::get('/ads-management', [MemberController::class, 'view_video'])->name('ads.view');
            Route::get('/ads-videocreateview', [MemberController::class, 'videocreateview'])->name('ads.videocreateview');
            Route::post('/ads-generate', [MemberController::class, 'generate_video'])->name('ads.generate_video');
            Route::get('/ads-edit/{planid}', [MemberController::class, 'video_edit'])->name('ads.video_edit');
            Route::patch('/ads-update/{planid}', [MemberController::class, 'video_update'])->name('ads.video_update');
            Route::delete('/ads/delete', [MemberController::class, 'multiple_ads_delete'])->name('ads.delete');

            /* ---------------- REWARDS ---------------- */
            Route::get('/generate-rewards', [MemberController::class, 'generate_rewards'])->name('generate.rewards');
            Route::post('/plan-rewards', [MemberController::class, 'reward_store'])->name('store.rewardplan');
            Route::get('/view-reward-plan', [MemberController::class, 'view_rewardplan'])->name('view.rewardplan');
            Route::get('/rewardplan-edit/{planid}', [MemberController::class, 'rewardplan_edit'])->name('rewardplan.edit');
            Route::patch('/rewardplan-update/{planid}', [MemberController::class, 'rewardplan_update'])->name('rewardplan.update');
            Route::delete('/rewardplan/delete', [MemberController::class, 'multiple_rewardplan_delete'])->name('rewardplan.delete');

            /* ---------------- MEMBER REQUEST ---------------- */
            Route::get('/show-member-request', [MemberController::class, 'member_request'])->name('show.member_request');
            Route::get('/member-request-history', [MemberController::class, 'member_request_history'])->name('show.member_request_history');
            Route::post('/request-change-status', [MemberController::class, 'request_change_status'])->name('request.change.status');
            Route::delete('/member-request-delete', [MemberController::class, 'multiple_member_request_delete'])->name('member_request.delete');

            /* ---------------- UPGRADE REQUEST ---------------- */
            Route::get('/show-upgrade-request', [MemberController::class, 'member_upgrade_request'])->name('show.upgrade_request');
            Route::get('/member-upgrade-request-history', [MemberController::class, 'member_upgrade_request_history'])->name('show.member_upgrade_request_history');
            Route::post('/upgrade-change-status', [MemberController::class, 'upgradet_change_status'])->name('upgrade_request.change.status');
            Route::delete('/upgrade-request-delete', [MemberController::class, 'multiple_member_upgrade_delete'])->name('upgrade_request.delete');

            /* ---------------- WITHDRAW REQUEST ---------------- */
            Route::get('/show-withdraw-request', [MemberController::class, 'show_withdraw_request'])->name('show.withdraw_request');
            Route::post('/show-withdraw-request', [MemberController::class, 'show_withdraw_request_bydate'])->name('show.withdraw_request');
            Route::get('/show-withdraw-request-history', [MemberController::class, 'withdraw_request_history'])->name('show.withdraw_request_history');
            Route::post('/withdraw-request-change-status', [MemberController::class, 'request_change_withrraw_status'])->name('request.change.withrraw_status');
            Route::delete('/withdraw-request-delete', [MemberController::class, 'multiple_withdraw_request_delete'])->name('withdraw_request.delete');

            /* ---------------- REPORTS ---------------- */
            Route::get('/direct-commission-report', [MemberController::class, 'direct_commission_report'])->name('show.direct_commission_report');
            Route::post('/direct-commission-report', [MemberController::class, 'direct_commission_report_datewise'])->name('show.direct_commission_report');

            Route::get('/level-commission-report', [MemberController::class, 'level_commission_report'])->name('show.level_commission_report');
            Route::post('/level-commission-report', [MemberController::class, 'level_commission_report_bydate'])->name('show.level_commission_report');

            Route::get('/show-level-history/{userid}', [MemberController::class, 'level_history'])->name('show_level_history');

            Route::get('/reward-report', [MemberController::class, 'reward_report'])->name('show.rewards_report');

            /* ---------------- NOTIFICATION ---------------- */
            Route::get('/notification', [MemberController::class, 'notification'])->name('notification');
            Route::post('/notification-set', [MemberController::class, 'notification_set'])->name('notification.set');

            /* ---------------- BANK ---------------- */
            Route::get('/bank-details', [MemberController::class, 'bank_details'])->name('bank_details');
            Route::post('/bank-details-set', [MemberController::class, 'bank_details_set'])->name('bank_details.set');

        });
    });



Route::middleware(['prevent-back-history'])->group(function () {
 Route::get('/', [PageController::class, 'homepage'])->name('home-page');
    Route::get('active-multiple-user/{slug}/{pack?}', [ProfileController::class, 'active_multiple_user'])
        ->name('active_multiple_user');
   Route::get('credentials', [ProfileController::class, 'credentials'])->name('credentials');
    // Wallets
    Route::get('main-wallet-balance', [ProfileController::class, 'main_wallet_balance'])->name('main_wallet_balance');
    Route::get('secondary-wallet-balance', [ProfileController::class, 'secondary_wallet_balance'])->name('secondary_wallet_balance');
    Route::get('community-wallet-balance', [ProfileController::class, 'community_wallet_balance'])->name('community_wallet_balance');
    Route::get('community-wallet-balance-history', [ProfileController::class, 'community_wallet_history'])->name('community_wallet_history');

    Route::get('wallet-transfer-request', [ProfileController::class, 'wallet_transfer_view'])->name('wallet_transfer_view');

    Route::get('wallet-to-wallet', [ProfileController::class, 'wallet_to_wallet'])->name('wallet_to_wallet');
    Route::post('wallet-to-wallet-transfer', [ProfileController::class, 'wallet_to_wallet_transfer'])->name('wallet_to_wallet_transfer');
    Route::get('wallet-to-wallet-history', [ProfileController::class, 'wallet_to_wallet_transaction_history'])
        ->name('wallet_to_wallet_transaction_history');

    Route::get('active-pin-from-wallet-view', [ProfileController::class, 'active_pin_from_wallet_view'])
        ->name('active_pin_from_wallet_view');
    Route::post('active-pin-from-wallet', [ProfileController::class, 'active_pin_from_wallet'])
        ->name('active_pin_from_wallet');
    Route::post('login-modal/dismiss', [ProfileController::class, 'dismissLoginModal'])
        ->name('user.login_modal.dismiss');

    Route::get('secondary-wallet-transaction-history', [ProfileController::class, 'secondary_wallet_transaction_history'])
        ->name('secondary_wallet_transaction_history');

    Route::post('request-withdraw-transfer', [ProfileController::class, 'request_withdraw_tran'])
        ->name('request_withdraw_tran');

    Route::get('get-community-bonus', [ProfileController::class, 'get_community_bonus'])->name('get_community_bonus');
    Route::get('get-community-bonus-cron', [PageController::class, 'get_community_bonus_cron'])
        ->name('get_community_bonus_cron');

    // Auth / Pages

    //Route::get('/userlogin', [UserLoginController::class, 'showuserLoginForm'])->name('home-page');
    Route::post('contact-form', [PageController::class, 'contact_form'])->name('contact-form');

    Route::get('register', [PageController::class, 'show_register_form'])->name('register');
    Route::get('countries/search', [PageController::class, 'search_countries'])->name('countries.search');
    Route::post('register/send-otp', [RegistrationOtpController::class, 'sendOtp'])->name('register.send_otp');
    Route::post('register/verify-otp', [RegistrationOtpController::class, 'verifyOtp'])->name('register.verify_otp');
    Route::post('register-form', [PageController::class, 'register_form'])->name('register-form');

    Route::get('create-dummy-user', [PageController::class, 'create_dummy_user'])->name('create_dummy_user');

    Route::get('userlogin', [UserLoginController::class, 'showuserLoginForm'])->name('userlogin');
    Route::post('userlogin', [UserLoginController::class, 'login'])->name('userlogin');

    Route::get('forgot-password', [PageController::class, 'forgot_password'])->name('forgot_password');
    Route::post('reset-password', [PageController::class, 'reset_password'])->name('reset_password');

    Route::get('forgot-password-reset/{userid}', [PageController::class, 'set_new_password'])
        ->name('set_forgot_password');
    Route::post('update-new-password', [PageController::class, 'update_new_password'])
        ->name('update_new_password');

    Route::post('get-sopnsor-name', [PageController::class, 'get_sopnsor_name'])->name('get_sopnsor_name');
    Route::post('send-otp', [ProfileController::class, 'send_otp'])->name('send_otp');

    Route::get('userlogout', [UserLoginController::class, 'logout'])->name('userlogout');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');

    Route::post('get-next-video', [ProfileController::class, 'get_next_video'])->name('get_next_video');

    Route::get('direct-member', [ProfileController::class, 'direct_member'])->name('direct_member');
    Route::get('all-member', [ProfileController::class, 'all_member'])->name('all_member');
    Route::get('community-member', [ProfileController::class, 'community_member'])->name('community_member');
    Route::get('community-member-downline', [ProfileController::class, 'community_member_downline'])
        ->name('community_member_downline');

    Route::get('show-my-pin', [ProfileController::class, 'show_my_pin'])->name('show_my_pin');
    Route::get('show-my-pin-history', [ProfileController::class, 'show_my_pin_history'])
        ->name('show_my_pin_history');

    Route::get('show-my-pin-autopull', [ProfileController::class, 'show_my_autopull_pin'])
        ->name('show_my_autopull_pin');
    Route::get('show-my-pin-history-autopull', [ProfileController::class, 'show_my_pin_autopull_history'])
        ->name('show_my_pin_autopull_history');

    Route::get('active-pin/{pinid}', [ProfileController::class, 'active_pin_view'])->name('active_pin_view');
    Route::post('active-pin', [ProfileController::class, 'active_pin'])->name('active-pin');

    Route::get('transfer-pin', [ProfileController::class, 'transfer_pin'])->name('transfer_pin');
    Route::post('transfer-pin', [ProfileController::class, 'transfer_pin_member'])->name('transfer.pin');

    Route::get('upload-kyc', [ProfileController::class, 'upload_kyc_view'])->name('upload_kyc_view');
    Route::get('upload-profile', [ProfileController::class, 'upload_profile_view'])->name('upload_profile_view');
    Route::post('update-kyc', [ProfileController::class, 'update_kyc'])->name('update-kyc');
    Route::post('address/send-otp', [AddressOtpController::class, 'sendOtp'])->name('address.send_otp');
    Route::post('address/verify-otp', [AddressOtpController::class, 'verifyOtp'])->name('address.verify_otp');
    Route::post('update-profile', [ProfileController::class, 'update_profile'])->name('update-profile');

    Route::get('withdraw-request', [ProfileController::class, 'withdraw_request_view'])
        ->name('withdraw_request_view');
    Route::post('request-withdraw', [ProfileController::class, 'request_withdraw'])->name('request_withdraw');
    Route::get('withdraw-history', [ProfileController::class, 'withdraw_history'])->name('withdraw_history');

    Route::get('view-agrement', [ProfileController::class, 'agrement'])->name('agrement');
    Route::post('submit-agrement', [ProfileController::class, 'submit_agrement'])->name('submit_agrement');

    Route::get('share-link', [ProfileController::class, 'share_link'])->name('share_link');
    Route::get('member-add/{slug}', [PageController::class, 'share_member_add'])->name('share_member_add');

    Route::get('direct-commosion', [ProfileController::class, 'direct_commosion_view'])
        ->name('direct_commosion_view');
    Route::get('level-commosion', [ProfileController::class, 'level_commosion_view'])
        ->name('level_commosion_view');
    Route::get('autopull-commosion', [ProfileController::class, 'autopull_commosion_view'])
        ->name('autopull_commosion_view');

    Route::get('rewards', [ProfileController::class, 'rewards_view'])->name('reward_view');

    Route::get('direct-income-report', [ProfileController::class, 'video_report'])->name('video_report');
    Route::get('level-income-report', [ProfileController::class, 'level_video_report'])->name('level_video_report');
    Route::get('pool-income-report', [ProfileController::class, 'pool_income_report'])->name('pool_income_report');
    Route::get('pool-income-report-history', [ProfileController::class, 'pool_income_report_history'])
        ->name('pool_income_report_history');

    Route::get('community-commosion-upline', [ProfileController::class, 'community_income_upline'])
        ->name('community_income_upline');
    Route::get('community-commosion-downline', [ProfileController::class, 'community_commosion_report_downline'])
        ->name('community_commosion_report_downline');

    Route::get('send-request', [ProfileController::class, 'send_request'])->name('send_request');
    Route::get('view-request-status', [ProfileController::class, 'view_request_status'])
        ->name('view_request_status');

    Route::get('send-autopull-request', [ProfileController::class, 'send_autopull_request'])
        ->name('send_autopull_request');
    Route::get('view-request-autopull-status', [ProfileController::class, 'view_request_autopull_status'])
        ->name('view_request_autopull_status');

    Route::get('send-upgrade-request', [ProfileController::class, 'send_upgrade_request'])
        ->name('send_upgrade_request');
    Route::get('view-upgrade-request-status', [ProfileController::class, 'view_upgrade_request_status'])
        ->name('view_upgrade_request_status');

    Route::post('request-admin', [ProfileController::class, 'request_admin'])->name('request_admin');
    Route::post('request-autopull-admin', [ProfileController::class, 'request_autopull_admin'])
        ->name('request_autopull_admin');
    Route::post('request-upgrade-admin', [ProfileController::class, 'request_upgrade_admin'])
        ->name('request_upgrade_admin');

    Route::post('subscribe-form', [PageController::class, 'subscribe_form'])->name('subscribe-form');

    Route::post('change-password', [ProfileController::class, 'change_password'])->name('change-password');
    Route::get('change-password', [ProfileController::class, 'changepassword'])->name('changepassword');

    Route::get('404', [ErrorHandlerController::class, 'errorCode404'])->name('404');
    Route::get('thank-you', [PageController::class, 'thankyou'])->name('thankyou');

    Route::post('booking', [PageController::class, 'booking_enquiry'])->name('booking.enquiry');
    Route::post('get-time-step', [PageController::class, 'generate_time_step'])->name('get.time.step');

    Route::get('{parent}/{slug}', [PageController::class, 'othersub'])->name('sub');
    Route::get('{slug}', [PageController::class, 'other']);

    Route::get('verify/{email}/{verifyToken}', [RegisterController::class, 'sendEmailDone'])
        ->name('sendEmailDone');

    Route::get('razorpay', [RazorpayController::class, 'razorpay'])->name('razorpay');
    Route::post('razorpaypayment', [RazorpayController::class, 'payment'])->name('payment');
});
