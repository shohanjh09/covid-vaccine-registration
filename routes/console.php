<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule the vaccination reminder job to run every day at 9 PM.
Schedule::command('vaccination:reminders')->dailyAt('21:00');

// Schedule the vaccination job dispatcher to run every minute.
// It will more delay in production. We set it for development purposes.
Schedule::command('vaccination:schedule')->everyMinute();
