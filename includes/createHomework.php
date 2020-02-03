<?php

#php to create a homework task and add to the database
require 'db.inc.php';

#Gathering data

$dueDate = mysqli_real_escape_string($conn,$_POST['dueDate']);
$homeworkName = mysqli_real_escape_string($conn, $_POST['homeworkName']);
$taskDetails = mysqli_real_escape_string($conn, $_POST['taskDetails']);
$classChoice = mysqli_real_escape_string($conn,$_POST['classChoice']);

#Creating the homework database entry
$sql = "SELECT * FROM classDetails WHERE classID = '$classChoice'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);

$sql = "INSERT INTO Homeworks(dueDate,taskname,classID,taskdetails,className,teacher) VALUES('$dueDate','$homeworkName','$classChoice','$taskDetails','$row[className]','$row[teacherName]');";
mysqli_query($conn,$sql);
#Gathering the id so that the linkings can be done correctly
$insID = mysqli_insert_id($conn);


#Gathering all of the pupils ids

$sql = "SELECT * FROM userClassLink WHERE classID = '$classChoice'";
$result = mysqli_query($conn,$sql);

#Looping through the pupils to add a link to them

while($row = mysqli_fetch_array($result)){
	$sql = "SELECT email FROM UserLoginData where id = '.".$row[userID]."'";
	$row2= mysqli_fetch_array(mysqli_query($conn,$sql));
	$sql = "INSERT INTO HomeworksUserLink(userID,homeworkID) VALUES('".$row[userID]."','".$insID."');";
	#Sending an email to tell students they have a new homework
	$Recipitant = $row2['email'];
	$Subject = "New Homework Set - Due: ".$dueDate;
	$Content = "Hello, you have been set a new peice of homework please go to www.myschoolsystems.co.uk/homeworks.php to view your new homework.";
	$Headers = "From: Support@myschoolsystems.co.uk". "\r\n" ;
	mail($Recipitant, $Subject, $Content, $Headers);
	
	mysqli_query($conn,$sql);
}


#Sending them back to the originating page 

header ("Location: ../addHomework.php?success=true");
exit();

?>