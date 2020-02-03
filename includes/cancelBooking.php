<?php

require 'db.inc.php';

$roomID = mysqli_real_escape_string($conn, $_POST['roomID']);
$date = mysqli_real_escape_string($conn, $_POST['date']);
$time = mysqli_real_escape_string($conn,$_POST['time']);
$userID = $_SESSION['id'];

$sql = "DELETE FROM roomPupilBookLink WHERE roomID = '".$roomID."' and dateOfUse = '".$date."' and timeOfUse = '".$time."' and userID = '".$userID."';";
mysqli_query($conn,$sql);

$email = $_SESSION['email'];
$subject = "Room booking canceled"; 
$content = "You have successfully canceled your room booking for ".$date." at ".$time;
$Headers = "From: Support@myschoolsystems.co.uk". "\r\n" ;
mail($email, $subject, $content, $Headers);

header("Location: ../viewBookings.php");
exit();