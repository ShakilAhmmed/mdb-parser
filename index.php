<?php

require __DIR__ . "/vendor/autoload.php";


use Shakilahmmed\MdbParser\Support\AttendanceRead;
use Shakilahmmed\MdbParser\Support\AttendanceSync;

$config = require __DIR__ . "/config/mdb-parser.php";

$mdbRows = AttendanceRead::make()->setFile($config['attendance_machine']['file_path'])
    ->setTableName($config['attendance_machine']['table_name'])
    ->getRows();


$connection = $config['connections']['mysql'];

AttendanceSync::sync()
    ->setServerName($connection['host'])
    ->setUserName($connection['username'])
    ->setPassword($connection['password'])
    ->setDbName($config['attendance_machine']['sync_db'])
    ->setTableName($config['attendance_machine']['sync_table'])
    ->store($mdbRows);