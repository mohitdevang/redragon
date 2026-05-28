<?php

namespace App\Http\Controllers;

use App\Models\CommisionTable;
use App\Models\Setting;
use App\Models\User;
use App\Services\PackageProgressionService;
use App\Services\Wallet\WalletService;
use App\Support\IncomeEngine;
use App\Support\PackagePurchaseEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class PackageActivationController extends Controller
{
    public function __construct(
        protected PackageProgressionService $packageProgression,
        protected WalletService $wallets
    ) {
        $this->middleware('auth:web');
    }

    public function view(Request $request)
    {
        $user = Auth::guard()->user();
        $secondary = $this->wallets->getBalance($user->unique_id, WalletService::SECONDARY);

        return view('page_templates.active_from_wallet', [
            'setting' => Setting::first(),
            'balance' => $secondary['balance'],
            'spendable_balance' => $secondary['spendable'],
            'package_rows' => $this->packageProgression->packagesForUi($user),
            'package_purchase_enabled' => PackagePurchaseEngine::enabled(),
            'next_package_id' => $this->packageProgression->nextPurchasablePackageId($user),
        ]);
    }

    public function activate(Request $request, ProfileController $profile)
    {
        if (! PackagePurchaseEngine::enabled()) {
            Session::flash('danger', 'Package activation / plan purchase is disabled by admin.');

            return redirect()->route('active_pin_from_wallet_view');
        }

        $packId = (int) $request->pack;
        $buyer = Auth::guard()->user();

        $pendingWithdraw = CommisionTable::where([
            ['member_id', $buyer->unique_id],
            ['type', 'debit'],
            ['request_status', 'processing'],
        ])->exists();
        if ($pendingWithdraw) {
            Session::flash('danger', 'Cannot purchase a package while a withdrawal request is pending.');

            return redirect()->route('active_pin_from_wallet_view');
        }

        $member = User::where('unique_id', $request->member_unique_id)->first();

        if (! $member) {
            Session::flash('danger', 'Invalid member ID.');

            return redirect()->route('active_pin_from_wallet_view');
        }

        $check = $this->packageProgression->canPurchase($member, $packId);
        if (! $check['allowed']) {
            Session::flash('danger', $check['message']);

            return redirect()->route('active_pin_from_wallet_view');
        }

        $package = $check['package'];
        $price = (float) $package->price;
        $spendable = $this->wallets->getBalance($buyer->unique_id, WalletService::SECONDARY)['spendable'];

        if ($price > $spendable) {
            Session::flash('danger', 'Insufficient Topup Wallet balance. Required: '.$price.' USDT, Available: '.$spendable.' USDT.');

            return redirect()->route('active_pin_from_wallet_view');
        }

        try {
            DB::transaction(function () use ($buyer, $member, $price, $packId, $profile) {
                $memberLocked = User::where('id', $member->id)->lockForUpdate()->firstOrFail();
                $recheck = $this->packageProgression->canPurchase($memberLocked, $packId);
                if (! $recheck['allowed']) {
                    throw new \RuntimeException($recheck['message']);
                }

                $this->wallets->debit(
                    $buyer->unique_id,
                    WalletService::SECONDARY,
                    $price,
                    [
                        'transaction_type' => 'package_purchase',
                        'package_id' => $packId,
                        'counterparty_user_id' => $member->unique_id,
                        'remarks' => 'Package purchase',
                    ],
                    'package:purchase:'.$buyer->unique_id.':'.$member->unique_id.':'.$packId.':'.date('YmdHis'),
                    false
                );

                CommisionTable::create([
                    'member_id' => $buyer->unique_id,
                    'type' => 'debit',
                    'amount' => $price,
                    'request_status' => 'approve',
                    'plan' => $packId,
                    'created_date' => date('Y-m-d'),
                    'remark' => 'Package purchase',
                    'wallet_type' => 's',
                    'downline_member' => $member->unique_id,
                ]);

                User::where('unique_id', $member->unique_id)->update([
                    'status' => 'active',
                    'active_date' => date('Y-m-d H:i:s'),
                    'package_id' => $packId,
                ]);

                $this->packageProgression->recordPurchase($memberLocked, $packId);

                if (IncomeEngine::enabled()) {
                    $profile->get_direct_income($member->unique_id, $price, $packId);
                    $profile->get_parent_user_byads($member->unique_id, 1, $price, $packId);
                    $profile->entry_magic_pool($member->unique_id, $packId, 1, 1);
                }
            });

            Session::flash('success', 'Package activated successfully.');
        } catch (\Throwable $e) {
            Session::flash('danger', $e->getMessage());
        }

        return redirect()->route('active_pin_from_wallet_view');
    }
}
