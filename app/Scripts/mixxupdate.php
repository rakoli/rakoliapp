<?php
//to run this script: php artisan tinker --execute "require app_path('Scripts/mixxupdate.php');"
namespace App\Scripts;

use App\Models\Network;
use App\Models\FinancialServiceProvider;
use Illuminate\Support\Facades\DB;

class MixxUpdate
{
    public function handle()
    {
        DB::beginTransaction();

        try {
            // 1. Update networks table
            $networksUpdated = Network::where('name', 'TIGOPESA Default')
                ->update(['name' => 'MIXXBYYAS Default']);

            echo "Networks updated: {$networksUpdated} record(s)\n";

            // 2. Update financial service providers table
            $providersUpdated = FinancialServiceProvider::where('name', 'TIGOPESA')
                ->update([
                    'name' => 'MIXXBYYAS',
                    'logo' => 'mixxbyyas.svg'
                ]);

            echo "Financial Service Providers updated: {$providersUpdated} record(s)\n";

            DB::commit();
            echo "All updates completed successfully!\n";

        } catch (\Exception $e) {
            DB::rollback();
            echo "Error occurred: " . $e->getMessage() . "\n";
        }
    }
}

// Execute the updates
$updater = new MixxUpdate();
$updater->handle();
