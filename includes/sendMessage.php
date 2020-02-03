<?php

require '../user_access_controls/student_plus.php';
require 'db.inc.php'; #needed to escape string

$toID = mysqli_real_escape_string($conn,$_GET['q']);

echo '<form action="/includes/db.sendMessage.php" method="POST">
<input type ="hidden" name="toID" value="'.$toID.'"/>
Please enter your message here: <br><textarea name="messageContent" cols="50" rows="10"></textarea> 
<br><input type="submit" value="Click to send message"/></form>
';

