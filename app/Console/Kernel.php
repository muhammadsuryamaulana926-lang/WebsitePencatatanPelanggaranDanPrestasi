<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\DatabaseBackup::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Daily incremental backup at 00:00
        $schedule->command('db:backup')->daily();
        
        // Weekly full backup (Sunday 02:00)
        $schedule->command('db:backup')->weekly()->sundays()->at('02:00');
        
        // Monthly archive backup (last day of month)
        $schedule->command('db:backup')->monthlyOn(28, '03:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}