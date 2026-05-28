<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (! Schema::hasColumn('users', 'unlocked_package_id')) {
                    $table->unsignedTinyInteger('unlocked_package_id')->default(1)->after('package_id');
                }
                if (! Schema::hasColumn('users', 'max_purchased_package_id')) {
                    $table->unsignedTinyInteger('max_purchased_package_id')->default(0)->after('unlocked_package_id');
                }
            });
        }

        foreach (['wallet_primary', 'wallet_secondary', 'wallet_community'] as $walletTable) {
            if (Schema::hasTable($walletTable) && ! Schema::hasColumn($walletTable, 'hold_balance')) {
                Schema::table($walletTable, function (Blueprint $table) {
                    $table->decimal('hold_balance', 16, 2)->default(0)->after('balance');
                });
            }
        }

        if (! Schema::hasTable('wallet_transactions')) {
            Schema::create('wallet_transactions', function (Blueprint $table) {
                $table->id();
                $table->string('transaction_uid', 64)->unique();
                $table->string('user_id', 32)->nullable()->index();
                $table->string('wallet_type', 16)->index();
                $table->string('direction', 8);
                $table->decimal('amount', 16, 2);
                $table->decimal('balance_before', 16, 2);
                $table->decimal('balance_after', 16, 2);
                $table->decimal('hold_before', 16, 2)->default(0);
                $table->decimal('hold_after', 16, 2)->default(0);
                $table->string('income_type', 32)->nullable()->index();
                $table->string('transaction_type', 32)->nullable()->index();
                $table->unsignedTinyInteger('package_id')->nullable();
                $table->string('source_user_id', 32)->nullable()->index();
                $table->string('counterparty_user_id', 32)->nullable();
                $table->string('reference_type', 64)->nullable();
                $table->unsignedBigInteger('reference_id')->nullable();
                $table->string('idempotency_key', 128)->nullable()->unique();
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('admin_lapse_wallet')) {
            Schema::create('admin_lapse_wallet', function (Blueprint $table) {
                $table->id();
                $table->decimal('balance', 16, 2)->default(0);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('lapse_income_transactions')) {
            Schema::create('lapse_income_transactions', function (Blueprint $table) {
                $table->id();
                $table->string('reference_uid', 64)->unique();
                $table->string('income_type', 32)->index();
                $table->decimal('amount', 16, 2);
                $table->string('trigger_user_id', 32)->index();
                $table->string('beneficiary_user_id', 32)->index();
                $table->unsignedTinyInteger('package_id')->nullable();
                $table->string('reason', 500);
                $table->string('status', 32)->default('credited');
                $table->unsignedBigInteger('wallet_transaction_id')->nullable();
                $table->unsignedBigInteger('commission_reference_id')->nullable();
                $table->string('commission_reference_type', 64)->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('cron_run_logs')) {
            Schema::create('cron_run_logs', function (Blueprint $table) {
                $table->id();
                $table->string('job_key', 64)->index();
                $table->date('run_date')->index();
                $table->string('status', 32)->default('completed');
                $table->text('meta')->nullable();
                $table->timestamps();
                $table->unique(['job_key', 'run_date']);
            });
        }

        if (Schema::hasTable('admin_lapse_wallet') && DB::table('admin_lapse_wallet')->count() === 0) {
            DB::table('admin_lapse_wallet')->insert([
                'balance' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cron_run_logs');
        Schema::dropIfExists('lapse_income_transactions');
        Schema::dropIfExists('admin_lapse_wallet');
        Schema::dropIfExists('wallet_transactions');

        foreach (['wallet_primary', 'wallet_secondary', 'wallet_community'] as $walletTable) {
            if (Schema::hasTable($walletTable) && Schema::hasColumn($walletTable, 'hold_balance')) {
                Schema::table($walletTable, function (Blueprint $table) {
                    $table->dropColumn('hold_balance');
                });
            }
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                foreach (['unlocked_package_id', 'max_purchased_package_id'] as $col) {
                    if (Schema::hasColumn('users', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
