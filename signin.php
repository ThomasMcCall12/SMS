<?php
#This page holds the user interface for the sign in system, this is not a db interaction file
	include_once 'header.php';
		
	if(isset($_GET['error'])){
		if($_GET['error'] == "empty"){
			echo '<script>alert("You have left a box empty!")</script>';}
		else if($_GET['error'] == "inputError"){
			echo '<script>alert("You entered incorrect data!")</script>';
		}
		else if($_GET['error'] == "unverified"){
			echo '<script>alert("Your account has not yet been verified by your school admin, please try again later.")</script>';
		}
		else if($_GET['error'] == "success"){
			echo '<script>alert("You are now logged in as: '.$_SESSION['username'].'")</script>';
	}}
	#Creating the form
	echo'
	<div class="signInForm"</div>
	<form action="/includes/signIn.inc.php" method="POST">
	Email: <input type="email" name="Email" placeholder="Click To Type" required></input><br><br><br>
	Password: <input type="password" name="Password" placeholder="Click To Type" required></input><br><br><br>
	Unique Security Number: <input type="password" name="USNum" placeholder="Click To Type" required></input><br><Br>
	<input type="submit" name="submit" style="float:center;"></input>
	</form>
	</div>
	';
	#USN is in place of 2FA
?>

<?php
	include_once 'footer.php';