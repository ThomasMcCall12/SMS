<?php

require 'db.inc.php';

$option = $_GET['q'];

if(empty($option)){
	header("Location: ../index.php");
	exit();
}
else{
	if($option == "self"){
		$searchVal = $_SESSION['id'];
		$sql = "SELECT * FROM roomsList INNER JOIN roomPupilBookLink ON roomsList.ID = roomPupilBookLink.roomID WHERE userID = '".$searchVal."' ORDER BY dateOfUse DESC;";
		$result = mysqli_query($conn,$sql);
		#using num rows check to return nicer output if no rooms are found
		if(mysqli_num_rows($result) <1){
			echo 'No room bookings where found';
		}
		else{
			echo '<table border = 2><tr>
			<td>Room ID</td>
			<td>Room Name</td>
			<td>Booking Date</td>
			<td>Booking Time</td>
			<td>Booking Length</td>
			<td>Click To Cancel Booking</td>
			</tr>';
			while($row = mysqli_fetch_assoc($result)){
				echo '<tr>
				<td>',$row[roomID].'</td>
				<td>'.$row[roomName].'</td>
				<td>'.$row[dateOfUse].'</td>
				<td>'.$row[timeOfUse].'</td>
				<td>'.$row[length].'</td>
				<td><form action = "/includes/cancelBooking.php" method="POST"><input type="hidden" name="date" value="'.$row[dateOfUse].'"/><input type="hidden" name="time" value="'.$row[timeOfUse].'"/><input type="hidden" value="'.$row[roomID].'" name="roomID"/><input type="submit" value="Click To Cancel"/></form></td>				</tr>';
			}
		echo'
		</table>';
		}
		
		
	}
	else if($option == "school"){
		$searchVal = $_SESSION['schoolCode'];
		$sql = "SELECT * FROM roomsList INNER JOIN roomPupilBookLink ON roomsList.ID = roomPupilBookLink.roomID INNER JOIN UserLoginData ON UserLoginData.id = roomPupilBookLink.userID WHERE schoolCode = '".$searchVal."' ORDER BY dateOfUse DESC;";
		$result = mysqli_query($conn,$sql);
		#using num rows check to return nicer output if no rooms are found
		if(mysqli_num_rows($result) <1){
			echo 'No room bookings where found';
		}
		else{
			echo '<table border = 2><tr>
			<td>Room ID</td>
			<td>Room Name</td>
			<td>Booking Date</td>
			<td>Booking Time</td>
			<td>Booking Length</td>
			<td>Assigned To</td>
			</tr>';
			while($row = mysqli_fetch_assoc($result)){
				echo '<tr>
				<td>',$row[roomID].'</td>
				<td>'.$row[roomName].'</td>
				<td>'.$row[dateOfUse].'</td>
				<td>'.$row[timeOfUse].'</td>
				<td>'.$row[length].'</td>
				<td>'.$row[username].'</td>
				</tr>';
			}
		echo'
		</table>';
		}
		
		
	}
	else if($option == "room"){
		echo'
		
		<form>
		<select name="selectRoom" onchange="searchRoom(this.value)">
		<option value="Non">Select a room to view the bookings for</option>
		';
		$sql = "SELECT * FROM roomsList WHERE schoolCode = '".$_SESSION[schoolCode]."';";
		$result = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($result)){
			echo '<option value="'.$row[ID].'">'.$row[roomName].'</option>';
		}
		echo'
		</select></form>
		<div id="changeLocation2"/>';
	}
}