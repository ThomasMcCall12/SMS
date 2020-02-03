<?php
require '../user_access_controls/student_plus.php';
require 'db.inc.php';

$fromID = mysqli_real_escape_string($conn,$_GET['q']);
$id = $_SESSION['id'];


$sql = "SELECT * FROM userMessageLink INNER JOIN messages on userMessageLink.messageID = messages.ID INNER JOIN UserLoginData on userMessageLink.toID = UserLoginData.id WHERE toID='".$id."' ORDER BY TIMESTAMP DESC;";
$res = mysqli_query($conn,$sql);


	echo '<table><tr><th>To</th><th>Message</th><th>TIMESTAMP</th></tr>';
	while($row = mysqli_fetch_assoc($res)){
			echo '<tr><td>You</td><td>'.$row[Message].'</td><td>'.$row[TIMESTAMP].'</td></tr>';
		
		
	}
	


$sql = "SELECT * FROM userMessageLink INNER JOIN messages on userMessageLink.messageID = messages.ID INNER JOIN UserLoginData on userMessageLink.fromID = UserLoginData.id WHERE toID='".$fromID."' ORDER BY TIMESTAMP DESC;";
$res = mysqli_query($conn,$sql);


	echo '<table><tr><th>From</th><th>Message</th><th>TIMESTAMP</th></tr>';
	while($row = mysqli_fetch_assoc($res)){

		
			echo '<tr><td>You</td><td>'.$row[Message].'</td><td>'.$row[TIMESTAMP].'</td></tr>';
		
	}
	
