<?php
return [
    'secret' => env('DB_CLEANER_SECRET'),

    'path' => storage_path('db-imports'),

    'databases' => [
        'casbalduhak',
        'casbara',
        // all 60 DBs
    ],
];
