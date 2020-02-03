<?php

#This file runs the correct file based on the users selection 
require 'db.inc.php';
require '../user_access_controls/school_admin_plus.php';
$opt = mysqli_real_escape_string($conn,$_GET['q']); #make sure to escape string  when getting any data for saftey 

if($opt == "Non"){
	echo '<h1>Please make a selection</h1>';
}
else if ($opt == "addTeacher"){
		$sql = "SELECT * FROM UserLoginData INNER JOIN schoolUserLink on UserLoginData.id = schoolUserLink.userID WHERE schoolID = '".$_SESSION[schoolCode]."' AND accountType != 'Admin' accountType != 'teacher';";
	$res = mysqli_query($conn,$sql);
		if(mysqli_num_rows($res) <1){
		
		echo '<h1>No students were found</h1>';
	}
	else{
				echo '<table><tr>
	<th>Name</th>
	<Th>Email</th>
	<th>Account Type</th>
	<th>Click To Make Account A Teacher Account</th>
	</tr>';
	while($row = mysqli_fetch_assoc($res)){
		echo'<tr>
		<td>'.$row[username].'</td>
		<td>'.$row[email].'</td>
		<Td>.'.$row[accountType].'</td>
		<td><form action="/includes/addTeacher.php" method="POST"><input type="hidden" name="studentID" value="'.$row[id].'"/><input type="submit" value="Upgrade Account To Teacher"/></form></td>
		</tr>';
		
	}
	echo '</table>';
	}
}
else if ($opt == "verifyStudent"){
	$sql = "SELECT * FROM schoolUserLink INNER JOIN UserLoginData ON schoolUserLink.userID = UserLoginData.id WHERE schoolID = '".$_SESSION[schoolCode]."' AND verified != 'TRUE';";
	$res = mysqli_query($conn,$sql);
	if(mysqli_num_rows($res) <1){
		
		echo '<h1>No unverified students were found</h1>';
	}
	else{
	echo '<table><tr>
	<th>Name</th>
	<Th>Email</th>
	<th>Account Type</th>
	<th>Click To Verify Account</th>
	</tr>';
	while($row = mysqli_fetch_assoc($res)){
		echo'<tr>
		<td>'.$row[username].'</td>
		<td>'.$row[email].'</td>
		<Td>.'.$row[accountType].'</td>
		<td><form action="/includes/verifyAccount.php" method="POST"><input type="hidden" name="studentID" value="'.$row[id].'"/><input type="submit" value="Verify Account"/></form></td>
		</tr>';
		
	}
	echo '</table>';	
		
	}
}
else if ($opt == "removeStudent"){
	$sql = "SELECT * FROM UserLoginData INNER JOIN schoolUserLink on UserLoginData.id = schoolUserLink.userID WHERE schoolID = '".$_SESSION[schoolCode]."' AND accountType != 'Admin';";
	$res = mysqli_query($conn,$sql);
		if(mysqli_num_rows($res) <1){
		
		echo '<h1>No students were found</h1>';
	}
	else{
				echo '<table><tr>
	<th>Name</th>
	<Th>Email</th>
	<th>Account Type</th>
	<th>Click To Delete Account</th>
	</tr>';
	while($row = mysqli_fetch_assoc($res)){
		echo'<tr>
		<td>'.$row[username].'</td>
		<td>'.$row[email].'</td>
		<Td>.'.$row[accountType].'</td>
		<td><form action="/includes/removeAccount.php" method="POST"><input type="hidden" name="studentID" value="'.$row[id].'"/><input type="submit" value="Delete Account"/></form></td>
		</tr>';
		
	}
	echo '</table>';
	}
}
else if ($opt == "viewStudents"){
	$sql = "SELECT * FROM UserLoginData INNER JOIN schoolUserLink on UserLoginData.id = schoolUserLink.userID WHERE schoolID = '".$_SESSION[schoolCode]."';";
	$res = mysqli_query($conn,$sql);
		if(mysqli_num_rows($res) <1){
		
		echo '<h1>No students were found</h1>';
	}
	else{
				echo '<table><tr>
	<th>Name</th>
	<Th>Email</th>
	<th>Account Type</th>
	</tr>';
	while($row = mysqli_fetch_assoc($res)){
		echo'<tr>
		<td>'.$row[username].'</td>
		<td>'.$row[email].'</td>
		<Td>.'.$row[accountType].'</td>
		</tr>';
		
	}
	echo '</table>';
	}
}
else if ($opt == "viewSchoolMessages"){
 	$sql = "SELECT * FROM UserLoginData INNER JOIN userMessageLink ON UserLoginData.id = userMessageLink.toID INNER JOIN schoolUserLink ON UserLoginData.id = schoolUserLink.userID INNER JOIN messages ON userMessageLink.messageID = messages.ID WHERE schoolID = '".$_SESSION[schoolCode]."' ORDER BY TIMESTAMP DESC;";
	$res = mysqli_query($conn,$sql);
		if(mysqli_num_rows($res) <1){
		
		echo '<h1>No messages were found</h1>';
	}
	else{
	echo '<table border=1> <tr><th>Person 1</th><th>Person 2</tH><th>Message</th><th>Timestamp</th></tr>';
		while($row = mysqli_fetch_assoc($res)){
			echo '<tr>';
			$sql2 = "SELECT username FROM UserLoginData WHERE id = '".$row[toID]."' OR id = '".$row[fromID]."';";
			$r2 = mysqli_query($conn,$sql2) or die(error_get_last);
			while($row2 = mysqli_fetch_assoc($r2)){
				
			echo '<Td>'.$row2[username].'</td>';
		}
		echo '<td>'.$row[Message].'</td><td>'.$row[TIMESTAMP].'</td></tr>';
		
		}
		echo '</table>';
	}
}
else if ($opt == "viewAllClasses"){
	$sql = "SELECT * FROM classDetails INNER JOIN schoolClassLink ON classDetails.classID = schoolClassLink.classID WHERE schoolID = '".$_SESSION[schoolCode]."';";
	$res = mysqli_query($conn,$sql);

	if(mysqli_num_rows($res) <1){
		
		echo '<h1>No classes were found</h1>';
	}
	else{
		echo '<table><tr>
	<th>Class Name</th>
	<Th>Teachers Name</th>
	</tr>';
	while($row = mysqli_fetch_assoc($res)){
		echo '<Tr>
		<td>'.$row[className].'<td><Td>'.$row[teacherName].'</td></tr>';
	}
	echo '</table>';
}
}


else if ($opt == "viewAllHomeworks"){
	#4 table inner join 
	$sql = "SELECT * FROM HomeworksUserLink INNER JOIN UserLoginData on HomeworksUserLink.userID = UserLoginData.id INNER JOIN Homeworks ON Homeworks.id = HomeworksUserLink.homeworkID INNER JOIN schoolUserLink ON UserLoginData.id = schoolUserLink.userID WHERE schoolID = '".$_SESSION[schoolCode]."' AND accountType != 'teacher' AND accountType != 'Admin';";
	$res = mysqli_query($conn,$sql);
	if(mysqli_num_rows($res) <1){
		
		echo '<h1>No homeworks were found</h1>';
	}
	else{
	echo '<table><tr>
	<th>User Email</th>
	<Th>Homework Name</th>
	<th> Homework Due Date</th>
	<th>Status</th>
	<th>Set By</th>
	</tr>';
while($row = mysqli_fetch_assoc($res)){
	echo ' 
	<tr>
	<td>'.$row[email].'</td>
	<td>'.$row[taskname].'</td>
	<td>'.$row[dueDate].'</td>
	<td>'.$row[Status].'</td>
	<td>'.$row[teacher].'</td>
	</tr>';
	
}
echo '</table>';
	}
}
