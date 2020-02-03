<?php

#adding the user to the class

require 'db.inc.php';
session_start();
$q = mysqli_real_escape_string($conn,$_POST['classid']);
$p = $_SESSION['id'];
$sql = "INSERT INTO userClassLink VALUES('".$p."','".$q."');";

mysqli_query($conn,$sql);

header("Location: ../joinClass.php?join=true");
exit();