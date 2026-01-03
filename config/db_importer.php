<?php

return [
    'secret' => env('DB_CLEANER_SECRET'),

    'path' => storage_path('db-imports'), // where .sql.gz files are

    'databases' => [
        'casadarsh',
        'casbalduhak',
        'casbara',
        // add all DBs
    ],
];
