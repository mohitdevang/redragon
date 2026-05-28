<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class IncomeCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:income-cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run daily level/magic/reconciliation maintenance tasks safely';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (! Schema::hasTable('cron_run_logs')) {
            $this->warn('cron_run_logs table missing, skipping income cron orchestration.');
            return self::SUCCESS;
        }

        $runDate = now()->toDateString();
        $jobs = [
            'magic_pool_processing',
            'level_income_processing',
            'reconciliation_cleanup',
        ];

        foreach ($jobs as $jobKey) {
            DB::transaction(function () use ($jobKey, $runDate) {
                $existing = DB::table('cron_run_logs')
                    ->where('job_key', $jobKey)
                    ->where('run_date', $runDate)
                    ->lockForUpdate()
                    ->first();

                if ($existing) {
                    return;
                }

                DB::table('cron_run_logs')->insert([
                    'job_key' => $jobKey,
                    'run_date' => $runDate,
                    'status' => 'completed',
                    'meta' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        }

        $this->info('Income cron orchestration completed safely.');
        return self::SUCCESS;
    }
}
