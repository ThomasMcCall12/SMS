<?php 

#This page establishes the user ui for the room booking system
require 'includes/db.inc.php';
require 'header.php';
session_start();

#Starting ajax system 

echo'
<script>
	function selectDate(str) {
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
	xhttp.open("GET", "/includes/selectDate.php?q="+str, true);
	xhttp.send();
	}
</script>
<script>
	
function selectTime(str) {
		var xhttp;
		if(str == "") {
		document.getElementById("changeLocation").innerHTML = "";
		return;
	}
	
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
	if(this.readyState == 4 && this.status == 200)
	{
	document.getElementById("changeLocation").innerHTML = this.responseText;
	}
	};
	xhttp.open("GET", "/includes/selectTime.php?a="+str, true);
	xhttp.send();
}
</script>
<script>
function selectLength(str) {
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
	xhttp.open("GET", "/includes/selectLength.php?q="+str, true);
	xhttp.send();
	}
</script>
';


#creating select option


echo '
	<form>
	Please enter the date you wish to book a room for: <input type="date" name="date" onchange="selectDate(this.value)"/>
	</form>
	<div id="changeLoc"></div>
	';
#Generating form information from db



