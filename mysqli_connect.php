<?php // mysqli_connect.php

// This file contains the database access information. 
// This file also establishes a connection to MySQL 
// and selects the database.

// Set the database access information as constants:
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'techpoli');

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Εξασφάλισε την ορθή εμφάνιση των ελληνικών χαρακτήρων
@mysqli_query($dbc,"SET NAMES 'utf8'");
@mysqli_query($dbc,"SET CHARACTER SET 'utf8'");

?>