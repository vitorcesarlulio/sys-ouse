<?php

define('HOST', '127.0.0.1');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'celke');

$conn = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';', USER, PASS);