<?php

#page to delete account 
require '../user_access_controls/school_admin_plus.php';
require 'db.inc.php';

$id = mysqli_real_escape_string($conn,$_POST['studentID']);

$sql = "DELETE FROM UserLoginData WHERE id = '".$id."';";
mysqli_query($conn,$sql);
header("Location: ../adminPanel.php");
exit();