<?php 

#Join class page
session_start();
require 'includes/db.inc.php';
require 'header.php';
#Setting up AJAX 

echo'
<script>
	function showClassDetails(str) {
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
	xhttp.open("GET", "/includes/getClass.php?q="+str, true);
	xhttp.send();
	}
</script>
';
#92=D66p257
echo '
	<form>
	<select name="classes" onchange="showClassDetails(this.value)">
	<option value="Non">Select a class to view and join</option>';
#Generating form information from database
$sql = "SELECT * FROM schoolUserLink WHERE userID = '".$_SESSION[id]."'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
	$sql1 = "SELECT * FROM schoolClassLink WHERE schoolID = '".$row[schoolID]."'";
	$result1 = mysqli_query($conn, $sql1);
	while($row1 = mysqli_fetch_array($result1)){
		$sql2 = "SELECT * FROM classDetails WHERE classID = '".$row1[classID]."'";
		$result2 = mysqli_query($conn, $sql2);
		$row2 = mysqli_fetch_array($result2);
		echo '<option value="'.$row2[classID].'">'.$row2[className].'</option>';
}
}
	



echo'
	
	
	
</select>
</form>

<div id="changeLoc">Selected class details will display here</div>

';