<?php

return [
    'attendance_machine' => [
        'file_path' => 'C:\xampp\htdocs\att2000.mdb',
        'sync_db' => 'attendance_db',
        'sync_table' => 'hr_attendance_raw_data',
        'table_name' => 'CHECKINOUT',
    ],

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'url' => '',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => '',
            'username' => '',
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'engine' => null,
        ],
    ]

];