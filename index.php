<?php
	
	include_once 'header.php';
	
	if($_GET['logout'] == "true"){
		echo'
		<script>
			alert("Logout Successful");
		</script>
		';
	}

?>


<?php 
	include_once 'footer.php';
?>