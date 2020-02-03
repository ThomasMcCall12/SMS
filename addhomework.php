<?php


#Add homework user interface

require 'header.php';
require 'includes/db.inc.php';

#creating form
echo '
	<form action="includes/createHomework.php" method="POST" class="addHomeworkForm">
		<br>Homework Due Date: <input type="date" name="dueDate"/>
		<br><bt>Homework Title: <input type="text" name="homeworkName" placeholder="Click To Enter"/>
		<br><br>Task Details: <br><textarea name="taskDetails" cols="50" rows="10"></textarea> 
		<br><br>Assign To A Class: <select name="classChoice"><option value="N/A">Click to select a class</option>';
		$sql = "SELECT * FROM classDetails INNER JOIN userClassLink ON classDetails.classID = userClassLink.classID WHERE userClassLink.userID = '".$_SESSION[id]."';";
		$result = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_array($result)){
			echo '<option value="'.$row[classID].'">'.$row[className].'</option>';
			
		}
			
		
		echo'
		</select><br>
		Click To Add Homework: <input type="submit" name="submit"/>
	</form>
';
