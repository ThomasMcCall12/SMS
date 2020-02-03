<?php

#UAC for teacher plus 

session_start();

if($_SESSION['accountType'] != "teacher" && $_SESSION['accountType'] != "Admin" && $_SESSION['accountType'] != "webAdmin"  ){
	#replaces the current window with the homepage
	echo '
	<script>
		alert("Sorry, only teachers (or higher) can view this webpage");
		location.replace("https://myschoolsystems.co.uk/index.php?access=teacher");
	</script>
	';

}