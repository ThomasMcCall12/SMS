<?php 

#View current homeworks
#gathering required files
require 'user_access_controls/student_plus.php';
require 'header.php';
require 'includes/db.inc.php';

#Establishing Ajax connection 
echo'
<script>
	function showHomework(str) {
		var xhttp;
		if(str == "") {
		document.getElementById("changeLoc").innerHTML = "";
		return;
	}
	
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
	if(this.readyState == 4 && this.status == 200)
	{
	document.getElementById("changeLoc").innerHTML = this.responseText;
	}
	};
	xhttp.open("GET", "/includes/getHomework.php?q="+str, true);
	xhttp.send();
	}
</script>
';
#choice form 
echo '
	<form>
	<select name="homework" onchange="showHomework(this.value)">
	<option value="Non">Select a homework task to view</option>';
#Generating form information from database
$sql = "SELECT * FROM HomeworksUserLink WHERE userID = '".$_SESSION[id]."'";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
	$sql = "SELECT * FROM Homeworks WHERE id = '".$row[homeworkID]."'";
	$result1 = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result1);
	echo '<option value="'.$row[id].'">'.$row[taskname].'</option>';
}
	



echo'
	
	
	
</select>
</form>

<div id="changeLoc">Selected homework tasks will display here</div>

';
