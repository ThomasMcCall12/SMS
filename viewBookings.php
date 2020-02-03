<?php

#page to view current bookings for your account or all school bookings
require 'header.php';
require 'includes/db.inc.php';

#ajax

echo'
<script>
	function showRoomBookings(str) {
		var xhttp;
		if(str == "") {
		document.getElementById("changeLoc").innerHTML = "";
		return;
	}
	
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
	if(this.readyState == 4 && this.status == 200)
	{
	document.getElementById("changeLoc").innerHTML = this.responseText;
	}
	};
	xhttp.open("GET", "/includes/getRoomBookings.php?q="+str, true);
	xhttp.send();
	}
</script>
';

echo'
<script>
	function searchRoom(str) {
		var xhttp;
		if(str == "") {
		document.getElementById("changeLocation2").innerHTML = "";
		return;
	}
	
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
	if(this.readyState == 4 && this.status == 200)
	{
	document.getElementById("changeLocation2").innerHTML = this.responseText;
	}
	};
	xhttp.open("GET", "/includes/searchRoom.php?q="+str, true);
	xhttp.send();
	}
</script>
';
#choice form 
echo '
	<form>
	<select name="showOpt" onchange="showRoomBookings(this.value)">
	<option value="Non">Select a search option</option>
	<option value="self">View your own room bookings</option>
	<option value="school">View all of the bookings in your school</option>
	<option value="room">Search bookings for a specific room</option>

	
	
	
</select>
</form>

<div id="changeLoc">Selected search option will display here</div>

';