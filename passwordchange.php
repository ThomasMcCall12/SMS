<?php

#Password changing 

require 'header.php';

if(isset($_GET['error'])){
		if($_GET['error'] == "true"){
			echo '<script>alert("An error has occured please try again")</script>';}
		else if($_GET['error'] == "false"){
			echo '<script>alert("Password successfully changed!")</script>';
		}
}
	
	echo'
	<div class="passChangeForm"</div>
	<form action="/includes/passchange.inc.php" method="POST">
	Your Unique Security Number: <input type="password" name="USN" placeholder="Click To Type" required></input><br><br><br>
	Your NEW Password: <input type="password" name="Password" placeholder="Click To Type" required></input><br><br><br>
	<input type="submit" name="submit" style="float:center;"></input>
	</form>
	</div>
	';
	#USN is in place of 2FA
?>

<?php
	include_once 'footer.php';