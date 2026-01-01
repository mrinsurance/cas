<?php 
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/clean', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');

    return 'Clear Cache Done!';
});

Route::get('/casdown', function () {
    Artisan::call('down', [
        '--message' => 'Upgrading Software. Will be back shortly.',
    ]);

    return 'Down';
});

Route::get('/casup', function () {
    Artisan::call('up');

    return 'Live';
});


?>