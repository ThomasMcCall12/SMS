<?php
#This file processes the log in system
require "db.inc.php";
session_start();
#Gather userinputed data 

if(isset($_POST['submit'])){
	
	#Data gathering
	$email = mysqli_real_escape_string($conn, $_POST['Email']);
	$pass = mysqli_real_escape_string($conn, $_POST['Password']);
	$secCode = mysqli_real_escape_string($conn, $_POST['USNum']);
	

		
	
	#Error Handling 
	if(empty($email) || empty($pass) || empty($secCode)){
		header("Location: ../signin.php?error=empty");
		exit();
	}
	else{
		$sql = "SELECT * FROM UserLoginData INNER JOIN schoolUserLink ON UserLoginData.id = schoolUserLink.userID  WHERE email ='".$email."'";
		$result = mysqli_query($conn, $sql);
		$resultNum = mysqli_num_rows($result);
		if($resultNum != 1){
			header("Location: ../signin.php?error=tooMany");
			exit();
		}
		
		#Password Handling
		else{
				#Sending a login attempt email to account email 
				$Recipitant = $email;
				$Subject = "Account Login (/Attempt) - MSS [My School System]";
				$Content = "Hello, This email is being sent to notify you that someone has logged into or attempted to log into your account, we recommend that you change your password at https://myschoolsystems.co.uk/passwordchange.php and email Support@myschoolsystems in order to request a Unique Security Number Change";
				$Headers = "From: Support@myschoolsystems.co.uk". "\r\n" ;
		
	// mail($Recipitant, $Subject, $Content, $Headers);
			if($row = mysqli_fetch_assoc($result)){
				if($row['verified'] == "1"){
						header("Location: ../signin.php?error=unverified");
						exit();					
				}
				$sql= "SELECT * FROM lockedAccounts WHERE ID = $row[id]";
				$result = mysqli_query($conn,$sql);
				$numrows = mysqli_num_rows($result);
				if($numrows>0){
					header("Location: ../accountLocked.php");
					exit();
				}
				if($row['failed_logins'] >10){
					$sql = "INSERT INTO lockedAccounts VALUES('$row[id]')";
					mysqli_query($conn,$sql);
					header("Location: ../accountLocked.php");
					exit();
				}
				else{
				#hasing inputs
				$hashedPass = password_verify($pass,$row['password']);
				$hashedSecCode = password_verify($secCode,$row['USN']);
				#Checking Values
				}if($hashedPass == false || $hashedSecCode == false){
					$temp = $row['failed_logins']+1;
					$sql = "UPDATE UserLoginData SET failed_logins='$temp' WHERE email='$row[email]';";
					mysqli_query($conn,$sql);
					header("Location: ../signin.php?error=inputError");
					exit();
					}
				elseif($hashedPass == true && $hashedSecCode == true){
						#Saving login info in session data
						$_SESSION['id'] = $row['id'];
						$_SESSION['username'] = $row['username'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['accountType'] = $row['accountType'];
						$sql = "SELECT * FROM schoolUserLink WHERE userID = '".$_SESSION[id]."'";
						$row2 = mysqli_fetch_array(mysqli_query($conn,$sql));
						$_SESSION['schoolCode'] = $row2['schoolID'];
						$sql = "UPDATE UserLoginData SET failed_logins='0' WHERE email='$row[email]';";
						mysqli_query($conn,$sql);
						header("Location: ../signin.php?error=success");
						exit();
				}
			}}

		}
	}

header("Location: ../signin.php?error=inputError");
exit();