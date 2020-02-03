<?php

#homework mark as complete code
#This will take the user's session login and the id from the form submission and then mark the homework complete on the link table 

#Gathering the required data
require 'db.inc.php';
session_start();
$id = mysqli_real_escape_string($conn,$_POST['taskid']);

#Updating the db

$sql = "UPDATE HomeworksUserLink SET Status='TRUE' WHERE userID='$_SESSION[id]' AND homeworkID = '".$id."';";
mysqli_query($conn,$sql);

#Sending a email notif

#Gathering homework details
$sql = "SELECT * FROM Homeworks WHERE id='".$id."'";
$row = mysqli_fetch_array(mysqli_query($conn,$sql));
$Recipitant = $_SESSION['email'];
$Subject = "Your homework (due [".$row['dueDate']."]) has been marked as completed";
$Content = "Hello, your homework titled - ".$row['taskname']." has been marked as completed, the homework can still be viewed under the homeworks tab on the website. (all completed homeworks expire after 30 days)";
$Headers = "From: Support@myschoolsystems.co.uk". "\r\n" ;
mail($Recipitant, $Subject, $Content, $Headers);
header("Location: ../index.php");		
exit();
