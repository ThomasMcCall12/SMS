<?php

#page to upgrade account
require '../user_access_controls/school_admin_plus.php';
require 'db.inc.php';

$id = mysqli_real_escape_string($conn,$_POST['studentID']);

$sql = "UPDATE UserLoginData SET accountType = 'teacher' WHERE id = '".$id."';";
mysqli_query($conn,$sql);
header("Location: ../adminPanel.php");
exit();