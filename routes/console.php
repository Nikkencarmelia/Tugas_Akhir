<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('users:mark-offline')
    ->everyTwoMinutes()
    ->withoutOverlapping()
    ->description('Mark users as offline if inactive for more than 5 minutes');
