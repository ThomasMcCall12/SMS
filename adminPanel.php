<?php 

#Admin panel
#check to make sure only admins access
require 'user_access_controls/school_admin_plus.php';
session_start();


require 'header.php';


echo'
<script>
	function selectAdminOpt(str) {
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
	xhttp.open("GET", "/includes/getAdminOption.php?q="+str, true);
	xhttp.send();
	}
</script>
';

#Allowing school admin to select admin option they want to use 

echo '
<form>
<select name="adminOpt" onchange="selectAdminOpt(this.value)">
<option value="Non">Select An Option</option>
<option value="addTeacher">Make a user account a school teacher</option>
<option value="verifyStudent">Verify a students account</option>
<option value="removeStudent">Remove a student from your school</option>
<option value="viewStudents">View all student data</option>
<option value="viewSchoolMessages">View all saved messages between staff and students</option>
<option value="viewAllClasses">View all classess</option>
<option value="viewAllHomeworks">View all homeworks</option>
</select>
</form>

<div id="changeLoc">Selected option will appear here</div>
';

require 'footer.php';


