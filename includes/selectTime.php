<?php

#this file uses JS and PHP to select a room to book for the user
#The merge sort is used to select the most often booked room appose to the lesser booked room as these rooms are more likely to be better known to people 

#getting form input data
require 'db.inc.php';

$_SESSION['time'] = mysqli_real_escape_string($conn,$_GET['a']); #getting time info


#creating select option


echo '
	<form>
	How long would you like to book a room for? (Max of 24 hours) : <input type="number" name="length" onchange="selectLength(this.value)"/>
	</form>
	<div id="changeLoc"></div>
	';


