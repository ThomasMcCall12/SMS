<?php

#getClassesForViewing

#including requireds
require 'db.inc.php';

#table to be shown on page

$classid = $_GET['q'];

$sql = "SELECT * FROM classDetails WHERE classID = '".$classid."'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
echo '
	<table>
	<tr style="border: solid black 3px; width:75%">
		<th>Information Type</th>
		<th>Information</th>
	</tr>
	<tr style="border: solid black 3px; width:75%">
		<td>Class ID</td>
		<td>'.$row[classID].'</td>
	</tr>
	<tr style="border: solid black 3px; width:75%">
		<td>Class Name</td>
		<td>'.$row[className].'</td>
	</tr>
	<tr style="border: solid black 3px; width:75%">
		<td>Teacher</td>
		<td>'.$row[teacherName].'</td>
	</tr>
	</table><br><Br>
';

