<?php
session_start();
require 'includes/db.inc.php';
#--start of php---
#Forces users to use HTTPS, adds security 

if ($_SERVER['HTTPS'] != "on") {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url"); #Forces users to go to the website using https if they did not go to the website using it
    exit(); 
}
$sql = "SELECT * FROM Blacklist WHERE IP = '$_SERVER[REMOTE_ADDR]'";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)){
if ($_SERVER['REMOTE_ADDR'] ==$row['IP']){
	header("Location: ../blacklistedUser");
	exit();
	
}
}
	session_start();
	 
#ensuring that all homeworks which are older than 30 days are deleted 
$sql = "SELECT * from Homeworks WHERE dueDate < NOW() - INTERVAL 30 DAY;";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
	$sqlTest = "SELECT * FROM HomeworksUserLink WHERE homeworkID ='".$row[id]."';";
	$r = mysqli_query($conn,$sqlTest);
	if(mysqli_num_rows($r) >0){
	$sql2 = "DELETE FROM HomeworksUserLink WHERE homeworkID ='".$row[id]."';";
	mysqli_query($conn,$sql2) or die(mysqli_error());
	}
	$sql3 = "DELETE FROM Homeworks WHERE id='".$row[id]."';";
	mysqli_query($conn,$sql3);
}


#--end of php--
?> 

<!--Styles-->
<html>
<!--normalising browser css-->

<link rel="stylesheet" href="reset.css"> <!--Credit - https://necolas.github.io/normalize.css/ -->

<!--adding my own styles sheet-->
<link rel="stylesheet" href="styles.css">


</html>

<!--start of html-->


<html>


<head> 
        <title>My School System</title>
		
        
</head>


<body>
<div class="navbar_frontpage">
<?php if(!empty($_SESSION['id'])){
	echo'
	<h1><br>Welcome to My School System
	<br><br>Click one of the below to navigate the site<br><br>
	 <a href = "/index.php"> Home </a>
	 <a href = "/homeworks.php"> View Homework </a>
	 <a href = "/accountDetails.php"> Account Details </a>
	 <a href = "/passwordchange.php"> Change Your Password </a>
	 <a href = "/joinClass.php"> Join A Class </a>
	 <a href = "/viewClasses.php"> View Classes </a>
	 <a href = "/viewBookings.php"> View Room Bookings </a>
	 <a href = "/roomBooking.php"> Book A Room </a>
	 <a href = "/viewMessages.php">View Your Messages</a>
	 <a href = "/sendMessage.php">Send A Message</a>
	 <a href = "/includes/logout.inc.php"> Sign Out </a></h1>
<br><h1>Logged In As: '.$_SESSION['username']; }
	else if(empty($_SESSION['id'])){
	echo'	
		<h1><br>Welcome to My School System
	<br><br>Click one of the below to navigate the site<br><br>
	 <a href = "/index.php"> Home </a>
	 <a href = "/signin.php"> Sign In </a>
	 <a href = "/signup.php"> Sign Up </a>
	 <a href = "/createSchool.php"> Create A School </a>
	 
	';}
	if($_SESSION['accountType'] == "teacher"){
		echo'
		<br><br>
		<a href = "/addhomework.php"> Create A Homework</a>
		<a href = "/createClass.php"> Create A Class </a>
		<a href = "/createRoom.php"> Create A Room</a>';
		
	}
	if($_SESSION['accountType'] == "Admin"){
		echo '
		<br><br>
		<a href = "/addhomework.php"> Create A Homework</a>
		<a href = "/createClass.php"> Create A Class </a>
		<a href = "/createRoom.php"> Create A Room</a>
		<a href = "/adminPanel.php"> Access Admin Panel</a>
		';
	}


?></h1>
</div>
   
   
   
    

  
 

</body>
</html>
<!--end of html-->