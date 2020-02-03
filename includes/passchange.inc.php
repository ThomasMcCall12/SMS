<?php
session_start();


	include_once 'db.inc.php';

    $USN = mysqli_real_escape_string($conn, $_POST['USN']);
    $newpass = mysqli_real_escape_string($conn, $_POST['Password']);

	//Error handlers
	//Check for empty fields
	if(empty($USN) || empty($newpass)){
		header("Location: ../passwordchange.php?error=true");
		exit();
	
	}else{
		$temp = $_SESSION['id'];
		$sql = "SELECT * FROM UserLoginData WHERE id ='".$temp."'";
		$result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);
          $hashedPwdCheck  = password_verify($USN, $row['USN']);
          if($hashedPwdCheck == false){
                header("Location: ../passwordchange.php?error=true");
				exit();
          }else if ($hashedPwdCheck == true){
					$hashedPwd = password_hash($newpass, PASSWORD_DEFAULT);
					$sql = "UPDATE UserLoginData SET password = '$hashedPwd' WHERE id ='".$temp."'";
					mysqli_query($conn, $sql);
					$Recipitant = $_SESSION['email'];
					$Subject = "Account Password Changed - MSS [My School System]";
					$Content = "Hello, we are emailing you to notify you that your password has been changed, if this was not done by you please go to https://myschoolsystems.co.uk/passwordchange.php and change your password in addition please email Support@myschoolsystems in order to request a Unique Security Number Change";
					$Headers = "From: Support@myschoolsystems.co.uk". "\r\n" ;
		
					mail($Recipitant, $Subject, $Content, $Headers);
	                header("Location: ../passwordchange.php?error=false");
	                exit();
}

} 
