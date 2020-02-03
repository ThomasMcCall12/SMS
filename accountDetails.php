<?php

#Account details page

require 'header.php';

echo '<p style="color: green; font-size: 30px; text-align: center;">The following is your account details: <br><br>

Username: '.$_SESSION["username"].'<br><br>
Email: '.$_SESSION["email"].'<br><br>';
