<?php

//
// Testing environment
//
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

$config = [];

// Database
$config['db']['database'] = 'test_dbname';

return $config;
