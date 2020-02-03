<?php
#This page holds the user interface for the sign up system, this is not a db interaction file
	include_once 'header.php';
	
	if(isset($_GET['error'])||isset($_GET['Code'])){
		if($_GET['error'] == "empty"){
			echo'<script>alert("Error - You failed to fill all boxes")</script>';}
		else if($_GET['error'] == "taken"){
			echo'<script>alert("Error - The details you entered are already taken")</script>';}
		else{
			echo'<script>alert("Account Created - Your Unique Security Number is: '.$_GET['Code'].'")</script>';
			
		}
	}
	
	#Creating the form
	echo'
	<div class="signUpForm"</div>
	<form action="/includes/signup.inc.php" method="POST">
	Username: <input type="text" name="Username" placeholder="Click To Type" required></input><br><br><br>
	Email: <input type="email" name="Email" placeholder="Click To Type" required></input><br><br><br>
	Password: <input type="password" name="Password" placeholder="Click To Type" required></input><br><br><br>
	School Joining Code: <input type="text" name="SchoolJoinCode" placeholder="Click To Type" required></input><br><Br><br>
	<input type="submit" name="submit" style="float:center;"></input>
	</form>
	</div>
	';
	#USN is in place of 2FA
?>

<?php
	include_once 'footer.php';