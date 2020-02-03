<?php
require 'user_access_controls/student_plus.php';
require 'header.php';
require 'includes/db.inc.php';


#Establishing Ajax connection 
echo'
<script>
	function showMessages(str) {
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
	xhttp.open("GET", "/includes/getMessages.php?q="+str, true);
	xhttp.send();
	}
</script>
';
#choice form 
echo '
	<form>
	<select name="messages" onchange="showMessages(this.value)">
	<option value="Non">Select a user to view your messages with</option>';

$sql = "SELECT * FROM UserLoginData INNER JOIN schoolUserLink ON UserLoginData.id = schoolUserLink.userID WHERE schoolID = '".$_SESSION[schoolCode]."' AND id!='".$_SESSION[id]."';";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){

	echo '<option value="'.$row[id].'">View Messages For User: '.$row[username].'</option>';
}
	



echo'
	
	
	
</select>
</form>

<div id="changeLoc">Selected homework tasks will display here</div>

';