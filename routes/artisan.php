<?php 
Route::get('/clean', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    return 'Clear Cache Done!'; //Return anything
});
Route::get('/casdown', function() {
    $exitCode = Artisan::call("down --message='Upgrading Software Will Be Back Shortly'");
    return 'Down'; //Return anything
});
Route::get('/casup', function() {
    $exitCode = Artisan::call("up");
    return 'Live'; //Return anything
});

?>