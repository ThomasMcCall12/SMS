<?php
require 'user_access_controls/student_plus.php';
require 'header.php';
require 'includes/db.inc.php';


#Establishing Ajax connection 
echo'
<script>
	function showRecipitants(str) {
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
	xhttp.open("GET", "/includes/sendMessage.php?q="+str, true);
	xhttp.send();
	}
</script>
';
#choice form 
echo '
	<form>
	<select name="recipitants" onchange="showRecipitants(this.value)">
	<option value="Non">Select a user to send a message to</option>';
if($_SESSION['accountType'] == "teacher" || $_SESSION['accountType'] == "Admin" || $_SESSION['accountType'] == "webAdmin"){
$sql = "SELECT * FROM UserLoginData INNER JOIN schoolUserLink ON UserLoginData.id = schoolUserLink.userID WHERE schoolID = '".$_SESSION[schoolCode]."' AND id!='".$_SESSION[id]."';";

}
else{
	$sql = "SELECT * FROM UserLoginData INNER JOIN schoolUserLink ON UserLoginData.id = schoolUserLink.userID WHERE schoolID = '".$_SESSION[schoolCode]."' AND id!='".$_SESSION[id]."' AND accountType = 'teacher';";

}

$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){

	echo '<option value="'.$row[id].'">Send a message to: '.$row[username].'</option>';
}
	



echo'
	
	
	
</select>
</form>

<div id="changeLoc">Message options will appear here</div>

';

