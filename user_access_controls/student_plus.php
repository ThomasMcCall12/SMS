<?php

#UAC for student plus

session_start();

if(empty($_SESSION['id'])){
	#replaces the current window with the homepage
	echo '
	<script>
		alert("Sorry, only logged in users can view this webpage");
		location.replace("https://myschoolsystems.co.uk/index.php?access=student");
	</script>
	';
} 


