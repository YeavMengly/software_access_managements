<?php

namespace App\Console;

use App\Models\Code\Year;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->call(function () {
        //     $currentYear = now()->year;

        //     // Update expired years to inactive
        //     Year::where('date_year', '<', $currentYear . '-01-01')
        //         ->where('status', '!=', 'inactive')
        //         ->update(['status' => 'inactive']);

        //     // Activate the current year
        //     Year::where('date_year', $currentYear . '-01-01')
        //         ->where('status', '!=', 'active')
        //         ->update(['status' => 'active']);
        // })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
