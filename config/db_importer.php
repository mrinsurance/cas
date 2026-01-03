<?php
return [
    'secret' => env('DB_IMPORT_SECRET'),

    'path' => storage_path('db-imports'),

    'databases' => [
        'casbalduhak',
        'casbara',
        // all 60 DBs
    ],
];
