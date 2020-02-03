<?php

#this file uses JS and PHP to select a room to book for the user
#The merge sort is used to select the most often booked room appose to the lesser booked room as these rooms are more likely to be better known to people 

#getting form input data
require 'db.inc.php';

$_SESSION['date'] = mysqli_real_escape_string($conn,$_GET['q']); #getting date info



echo '
	<form>
	Please enter the time you wish to book a room for: <input type="time" name="time" onchange="selectTime(this.value)"/>
	</form>
	<div id="changeLocation"></div>
	';




