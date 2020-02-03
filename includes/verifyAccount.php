<?php
require '../user_access_controls/school_admin_plus.php';
require 'db.inc.php';

$id = mysqli_real_escape_string($conn,$_POST['studentID']);

$sql = "UPDATE schoolUserLink SET verified = '0' WHERE userID = '".$id."';";
mysqli_query($conn,$sql);
header("Location: ../adminPanel.php");
exit();