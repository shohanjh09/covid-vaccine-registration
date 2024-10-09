<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command('vaccination:reminders')->dailyAt('21:00');

// Schedule the vaccination job dispatcher to run every day at midnight
Schedule::command('vaccination:schedule')->dailyAt('00:00');
