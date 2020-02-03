<?php

#Adding a school to the database

require 'db.inc.php';
session_start();

#Gathering data values from form 

$schoolName = mysqli_real_escape_string($conn,$_POST['schoolName']);
$schoolPostcode = mysqli_real_escape_string($conn,$_POST['schoolPostcode']);
$schoolPhoneNumber = mysqli_real_escape_string($conn,$_POST['schoolPhoneNumber']); 
$schoolEmail = mysqli_real_escape_string($conn,$_POST['schoolEmail']);

#data validation 
#checking to ensure data exists
if(empty($schoolName) || empty($schoolPostcode) || empty($schoolPhoneNumber) || empty($schoolEmail)){
	header("Loaction: ../createSchool.php?error=true");
	exit();
}
#Checking to make sure the school is not already in the database
else{
	$sql = "SELECT * FROM schoolDetails WHERE schoolName ='".$schoolName."' and postcode ='".$schoolPostcode."'";
	$result = mysqli_query($conn, $sql);
	$numberOfRows = mysqli_num_rows($result);
	if($numberOfRows >0){
		header("Location: ../createSchool.php?error=alreadyMade");
		exit();
	}

		#adding data into the data base
		$sql = "INSERT INTO schoolDetails(schoolName, postcode, schoolPhoneNumber, schoolEmail) VALUES('$schoolName','$schoolPostcode','$schoolPhoneNumber','$schoolEmail');";
		mysqli_query($conn,$sql);
		$sql = "SELECT schoolID FROM schoolDetails WHERE schoolName ='".$schoolName."' and postcode ='".$schoolPostcode."'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($result);

		#sending an account createion confirmatrion email
		$Recipitant = $schoolEmail;
		$Subject = "You have create a new school account! [My School System]";
		$Content = "Hello, This email is being sent to notify you that you have successfully made a new school account, the first account to join the school will be made the school admin";
		$Headers = "From: Support@myschoolsystems.co.uk". "\r\n" ;

		header("Location: ../createSchool.php?code=".$row['schoolID']);
		exit();
			
	
}