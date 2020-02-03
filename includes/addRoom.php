<?php

#db file for create room

require 'db.inc.php';

#getting data

$roomName = mysqli_real_escape_string($conn,$_POST['roomName']);
$roomSeat = mysqli_real_escape_string($conn,$_POST['roomSeatVal']);
$roomComps = mysqli_real_escape_string($conn,$_POST['roomComps']);
$schoolCode = $_SESSION['schoolCode'];

#adding to db

$sql = "INSERT INTO roomsList(roomName,schoolCode,safeSeatNum,comps,timesBooked) VALUES('".$roomName."','".$schoolCode."','".$roomSeat."','".$roomComps."','0');";
mysqli_query($conn,$sql);

header("Location: ../createRoom?q=true");
exit();
