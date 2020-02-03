<?php

#Create a class
require 'user_access_controls/teacher_plus.php';
require 'header.php';

echo '
<form action="includes/addClass.php" method="POST">
Class Name: <input type="text" name="ClassName" placeholder="Click to enter" required></input><br><bR>
Teachers Username: <input type="text" name="TeacherName" placeholder = "Click to enter" required></input><Br><bR>
Max class size: <input type="integer" name="MaxClassSize" placeholder ="Click to enter" required></input><bR><bR>
<input type="submit" name="submit"></input>
</form>

';