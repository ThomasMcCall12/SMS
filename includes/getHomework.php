<?php

#including requireds
require 'db.inc.php';

#table to be shown on page

$taskid = mysqli_real_escape_string($conn,$_GET['q']);
$uID = $_SESSION['id'];
$sql = "SELECT * FROM Homeworks INNER JOIN HomeworksUserLink ON HomeworksUserLink.homeworkID = Homeworks.id  WHERE homeworkID = '".$taskid."' and userID = '".$uID."';";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
echo '
	<table>
	<tr style="boder: solid black 3px; width:75%">
		<th>Information Type</th>
		<th>Information</th>
	</tr>
	<tr style="boder: solid black 3px; width:75%">
		<td>Task ID</td>
		<td>'.$row[id].'</td>
	</tr>
	<tr style="boder: solid black 3px; width:75%">
		<td>Homework Due Date</td>
		<td>'.$row[dueDate].'</td>
	</tr>
	<tr>
	<td>Status</td>
	<td>';
	if($row[Status] != "FALSE"){
		echo 'Completed </td>'; 
		} 
		else { 
		echo'Not Yet Completed</td>';
		}
	echo'
	<tr style="boder: solid black 3px; width:75%">
		<td>Teacher</td>
		<td>'.$row[teacher].'</td>
	</tr>
	<tr style="boder: solid black 3px; width:75%">
		<td>Class Name</td>
		<td>'.$row[className].'</td>
	</tr>
		<tr style="boder: solid black 3px; width:75%">
		<td>taskdetails</td>
		<td>'.$row[taskdetails].'</td>
	</tr>
	</table>
	<form action="/includes/hwremove.php" method="POST">
	<input type="hidden" name="taskid" value="'.$taskid.'"/>
	<input type="submit" name="submit" value="Click to mark as completed"/>
	</form>
';