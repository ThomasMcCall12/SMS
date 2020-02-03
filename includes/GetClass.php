<?php

#getClass information for joining 


#including requireds
require 'db.inc.php';
session_start();
#table to be shown on page

$classid = $_GET['q'];

$sql = "SELECT * FROM classDetails WHERE classID = '".$classid."'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
echo '
	<table>
	<tr style="boder: solid black 3px; width:75%">
		<th>Information Type</th>
		<th>Information</th>
	</tr>
	<tr style="boder: solid black 3px; width:75%">
		<td>Class ID</td>
		<td>'.$row[classID].'</td>
	</tr>
	<tr style="boder: solid black 3px; width:75%">
		<td>Class Name</td>
		<td>'.$row[className].'</td>
	</tr>
	<tr style="boder: solid black 3px; width:75%">
		<td>Teacher</td>
		<td>'.$row[teacherName].'</td>
	</tr>
	</table><br><Br>
	<form action="/includes/classJoin.php" method="POST">
		<input type="hidden" name="classid" value="'.$classid.'"/><input type="submit" value="Click to join class"/>
	</form>
';


