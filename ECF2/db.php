<?php
/* Database credentials. Assuming you are running MySQL*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'letmein');
define('DB_NAME', 'ecf');

/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME) or die($mysqli>error);