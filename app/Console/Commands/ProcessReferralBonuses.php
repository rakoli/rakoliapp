<?php

namespace App\Console\Commands;

use App\Jobs\ProcessReferralBonusesJob;
use Illuminate\Console\Command;

class ProcessReferralBonuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'referrals:process-bonuses
                            {--force : Force processing even if already run today}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically process referral bonuses for eligible users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting referral bonus processing...');

        // Dispatch the job
        ProcessReferralBonusesJob::dispatch();

        $this->info('Referral bonus processing job dispatched successfully!');

        return 0;
    }
}
