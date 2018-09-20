<?php 
session_start();

// Database connection
define("HOST", 'localhost');
define("USER", 'root');
define("PASSWORD", 'ets@123!');
define("DB", 'savor'); 


$config['db'] = new mysqli(HOST,USER ,PASSWORD ,DB); 
if ($config['db'] ->connect_error) {
    die("Connection failed: " . $config['db']->connect_error);
}