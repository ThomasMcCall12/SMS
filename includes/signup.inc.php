<?php
#7c5c5cf043834dbfb713df08d5351e17
#Sign up account system

	require 'db.inc.php';
	$email = mysqli_real_escape_string($conn,$_POST['Email']);
	$pass = mysqli_real_escape_string($conn,$_POST['Password']);
	$username = mysqli_real_escape_string($conn,$_POST['Username']);
	$schoolJoinCode = mysqli_real_escape_string($conn, $_POST['SchoolJoinCode']);
	
	
	#Testing password security,, placeholder

	#Making sure the email is not already on record 
	$sql = "SELECT * FROM UserLoginData WHERE email ='".$email."'";
	$result = mysqli_query($conn,$sql);
	$numRows = mysqli_num_rows($result);
	if($numRows >0){
		header("Location: ../signUp.php?error=taken");
		exit();
	}
	#generating security code
		$value1 = rand(1,rand(2,400));
		$value2 = rand(1,rand(2,200));
		$value3 = rand(1,56);
		$value4 = chr(rand(32,127));
		$value5 = chr(rand(32,127));
		$value6 = chr(rand(32,127));
	#generating random numbers
	while(TRUE){
		if($value1 == "#" || $value2 == "#" || $value3 == "#" || $value4 == "#" || $value5 == "#" || $value6 == "#"){ 
		$value1 = rand(1,rand(2,400));
		$value2 = rand(1,rand(2,200));
		$value3 = rand(1,56);
		$value4 = chr(rand(32,127));
		$value5 = chr(rand(32,127));
		$value6 = chr(rand(32,127));
		}
		else{
			break;
		}
		
	}
	#converting values 4,5,6 to ascii

	
	#Making the generation of the code as random as possible
	if((($value2 + $value1 + $value3) * rand(1,100)) % rand(1,4) == 0){
		$secCode = $value1.$value4.$value5.$value2.$value6.$value3.rand(0,9);
	}
	elseif((($value1 + $value3) / rand(1,100))*53 % rand(1,4) == 0){
		$secCode = rand(0,9).$value3.$value1.$value5.$value2.$value6.$value4;
	}
	else{
		$secCode =$value6.$value2.rand(32,100).$value3.rand(0,9).$value5.$value4.$value1;
	}
	
	#Error handling
	
	#Checking for empty inputs 
	if(empty($email) || empty($pass) || empty($username) || empty($schoolJoinCode)){
		header("Location: ../signUp.php?error=empty");
		exit();
	}
	else{
		$hashedpassword = password_hash($pass,PASSWORD_DEFAULT);
		$hashedusn = password_hash($secCode,PASSWORD_DEFAULT);
		$sql = "SELECT * FROM schoolDetails WHERE schoolEmail = '".$email."' and schoolID = '".$schoolJoinCode."';";
		$res = mysqli_query($conn,$sql);
		if(mysqli_num_rows($res) >0){
			$sql = "INSERT INTO UserLoginData(username, email, password, USN, accountType) VALUES('$username','$email','$hashedpassword','$hashedusn','Admin');";
		
		}
		else{
		$sql = "INSERT INTO UserLoginData(username, email, password, USN) VALUES('$username','$email','$hashedpassword','$hashedusn');";
		}
		mysqli_query($conn,$sql);
		
		#Adding pupil to school
		$sql = "SELECT id FROM UserLoginData WHERE username = '".$username."' and email ='".$email."'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($result);
		$id = $row['id'];
		$sql = "INSERT INTO schoolUserLink VALUES('$id','$schoolJoinCode','0');";
		mysqli_query($conn,$sql);
		#Sending sign up email
		$Recipitant = $email;
		$Subject = "New Account Creation - MSS [My School System]";
		$Content = "Hello, This email is being sent to confirm that you have successfully created an account with My School System (https://myschoolsystems.co.uk/), if this has been done in error or not by you/your system admin please email Support@myschoolsystems.co.uk	immediatly";
		$Headers = "From: Support@myschoolsystems.co.uk". "\r\n" ;
		
		mail($Recipitant, $Subject, $Content, $Headers);
		
		header("Location: ../signUp.php?Code=".$secCode);
		exit();
	}
