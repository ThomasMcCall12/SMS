<?php

#The db effecting file for the room booking system, all data validation should have already be done before the data gets here
require 'db.inc.php';
session_start();

$roomName = mysqli_real_escape_string($conn,$_POST['roomName']);
$roomID = mysqli_real_escape_string($conn,$_POST['roomID']);
$date = mysqli_real_escape_string($conn,$_POST['date']);
$time = mysqli_real_escape_string($conn,$_POST['time']); #time will be in correct format for db not in unix form
$length = mysqli_real_escape_string($conn,$_POST['length']);

#Adding booking link 

$sql = "INSERT INTO roomPupilBookLink VALUES ('".$_SESSION[id]."','".$roomID."','".$date."','".$time."','".$length."');";
mysqli_query($conn,$sql) or die(mysqli_error($conn));

				$Recipitant = $_SESSION['email'];
				$Subject = "Room Successfully Booked - ".$date;
				$Content = "Hello, You have successfully booked a room with the details that follow. You can cancel a booking by going to the website. \n Details - \n Room Name: ".$roomName."\nDate - ".$date."\n Time: ".$time;
				$Headers = "From: Support@myschoolsystems.co.uk". "\r\n" ;
		
				mail($Recipitant, $Subject, $Content, $Headers);
				$sql = "UPDATE roomsList SET timesBooked = timesBooked+1 WHERE ID ='".$roomID."';";
				mysqli_query($conn,$sql);
					header("Location: ../roomBooking?booked=true");
					exit();