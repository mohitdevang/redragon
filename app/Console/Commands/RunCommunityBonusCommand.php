<?php

namespace App\Console\Commands;

use App\Services\Income\CommunityBonusService;
use Illuminate\Console\Command;

class RunCommunityBonusCommand extends Command
{
    protected $signature = 'redragon:community-bonus {--date=}';

    protected $description = 'Distribute global community bonus (50 serial up + 50 down)';

    public function handle(CommunityBonusService $service): int
    {
        $date = $this->option('date') ?: date('Y-m-d');
        $ran = $service->run($date);
        $this->info($ran ? 'Community bonus completed.' : 'Skipped (disabled or already ran).');

        return self::SUCCESS;
    }
}
