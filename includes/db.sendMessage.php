<?php


require '../user_access_controls/student_plus.php';
require 'db.inc.php'; 

$toID = mysqli_real_escape_string($conn,$_POST['toID']);
$Message = mysqli_real_escape_string($conn,$_POST['messageContent']);
$fromID = $_SESSION['id'];

#adding the message to the db

$sql = "INSERT INTO messages(Message) VALUES('".$Message."');";
mysqli_query($conn,$sql);
$b = mysqli_insert_id($conn); 

$sql = "INSERT INTO userMessageLink VALUES('".$toID."','".$fromID."','".$b."');";
mysqli_query($conn,$sql);

header("Location: ../sendMessage.php");
exit();