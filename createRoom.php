<?php

#Add room to school form

require 'header.php';

#form
echo'
<form action="/includes/addRoom.php" method="POST">

Room name: <input type="text" name="roomName" placeholder="Click to enter" required /><br>
How many people can the room seat?: <input type="text" name="roomSeatVal" placeholder="Click to enter" required /><br>
Does the room have computers in it?: <input type="checkbox" name="roomComps" value="1" placeholder="Click to enter" /><br>
<input type="submit" value="Click To Add Room"/>
</form>

';

require 'footer.php';