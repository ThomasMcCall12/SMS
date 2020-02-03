<?php
#Creats database connection 
$dbServername ="db5000145007.hosting-data.io";
$dbUsername ="dbu97693";
$dbPassword = "redacted";
$dbname ="dbs140308";

$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbname);
	
if (mysqli_connect_error()) {
    die("Database connection failed: " . mysqli_connect_error() . "Please contact support team");
}

session_start();