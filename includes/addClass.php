<?php

#create class

require 'db.inc.php';
session_start();
#Gathering variables from form 
$className = mysqli_real_escape_string($conn, $_POST['ClassName']);
$teacherName = mysqli_real_escape_string($conn, $_POST['TeacherName']);
$maxClassSize = mysqli_real_escape_string($conn, $_POST['MaxClassSize']);



#if statement to ensure the variables are not empty (added saftey) 
if(empty($className) || empty($teacherName) || empty($maxClassSize)){
	header("Location: ../createClass.php?success=false");
	exit();
}
else{

#(className, teacherName, maxClassSize)
	$sql = "INSERT INTO classDetails(className,teacherName,maxClassSize) VALUES('$className','$teacherName','$maxClassSize');";
	mysqli_query($conn, $sql);
	$b = mysqli_insert_id($conn);
	#Getting school's data and adding a link between school and class
	$sql = "SELECT * FROM schoolUserLink WHERE userID = '".$_SESSION[id]."'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result);

	$a = $row['schoolID'];


	$sql = "INSERT INTO schoolClassLink VALUES('$a','$b');";
	mysqli_query($conn,$sql);
	header("Location: ../createClass.php?success=true");
	exit();
}