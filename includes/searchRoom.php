<?php

$roomID = $_GET['q'];

require 'db.inc.php';


#checking to make sure the input is not empty (needed as get is being used)

if(empty($roomID)){
	header("Location: ../index.php");
	exit();
}
else{
	$sql = "SELECT * FROM roomPupilBookLink INNER JOIN roomsList ON roomPupilBookLink.roomID = roomsList.ID INNER JOIN UserLoginData ON roomPupilBookLink.userID = UserLoginData.id WHERE roomsList.ID = '".$roomID."' ORDER BY dateOfUse DESC;";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result) < 1){
		echo ' No bookings found';
	}
	else{
		echo '<table border = 2>
		<tr>
		<td>Room ID</td>
		<td>Room Name</td>
		<td>Date Of Booking</td>
		<td>Time Of Booking</td>
		<td>Length Of Booking</td>
		<td>Room Assigned To</td>
		</tr>';
		while($row = mysqli_fetch_array($result)){
			echo '<tr>
			<td>'.$row[roomID].'</td>
			<td>'.$row[roomName].'</td>
			<td>'.$row[dateOfUse].'</td>
			<td>'.$row[timeOfUse].'</td>
			<td>'.$row[length].'</td>
			<td>'.$row[username].'</td>
			</tr>';
		}
		echo '</table>';
	}
}
