<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('db:backup', function () {
    $database = database_path('database.sqlite');
    if (! file_exists($database)) {
        $this->error('SQLite database not found at '.$database);

        return 1;
    }
    $filename = 'backup_'.date('Ymd_His').'.sqlite';
    $path = 'private/backups/'.$filename;
    Storage::disk('local')->put($path, file_get_contents($database));
    $this->info('Backup tersimpan: storage/app/'.$path);

    return 0;
})->purpose('Backup database SQLite ke storage');
