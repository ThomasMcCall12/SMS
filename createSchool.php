<?php

#Create a school

require 'header.php';

echo '
	<div class="createSchoolForm">
		<form method = "POST" action="includes/createSchool.inc.php">
			School Name: <input type="text" name="schoolName" placeholder= "Click To Enter"></input><br><Br><Br>
			School Postcode: <input type="text" name="schoolPostcode" placeholder = "Click To Enter"></input> <br><br><br>
			Phone Number: <input type="text" name="schoolPhoneNumber" placeholder= "Click To Enter"></input> <br><Br><br>
			School Email: <input type="email" name="schoolEmail" placeholder="Click To Enter"></input> <br><br><Br>
			<input type="submit" name="submit"></input>
		</form>
	</div
';