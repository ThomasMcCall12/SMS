<?php

#this file uses JS and PHP to select a room to book for the user
#The merge sort is used to select the most often booked room appose to the lesser booked room as these rooms are more likely to be better known to people 

#getting form input data
require 'db.inc.php';

#creating function to test if the bookings overlap



#uses unix time to compare times 
function testTime($start_time_to_book, $end_time_to_book, $start_time_of_already_booked, $end_time_of_already_booked){
	if($start_time_to_book == $start_time_of_already_booked){ 
	#logic explanation  - IF the start time of the item is equal to the start time of a previously booked booking it would be a double booking
		
		return False;
	}
	if($end_time_of_already_booked <= $start_time_to_book || $start_time_of_already_booked >= $end_time_to_book){
		#if the booking ends before the new booking begins it cannot overlap
		#similarly if the start time of the currently booked time is greater than or equal to the end time to book it cannot ovelap
		return True;
	}
	else{
		return False; #otherwise it will return false, this is a saftey mechanism making double bookings impossible unless done manually as any unaccounted scnarios are accouned for
	}
	
}


#Creating mergesort for weighting
function reverseMergeSort($aList){	
	if (count($aList) <= 1) { #returning lists of len 1 as they are already sorted
		
		return $aList;  

	}		
	else{
		
		$midPointOfList = count($aList)/2; #finding the midpoint, if any problems are found I could try floor or ceil
		//resursivly going through the list to break it up
		$firstHalf = array_slice($aList,0,$midPointOfList); #use slice to get the first half of list, splice would also work but slice keeps the original array in tact, splice could cause some issues
		$secondHalf = array_slice($aList,$midPointOfList); 
		$firstHalf = reverseMergeSort($firstHalf); #recussrion 
		$secondHalf = reverseMergeSort($secondHalf);
		return mergeOfParts($firstHalf ,$secondHalf);
	}
}

function mergeOfParts($firstHalf, $secondHalf){
	$sortedList = array(); 
	while(count($firstHalf) > 0 && count($secondHalf) > 0){ #note for any reader -> sizeof could also be used but as count has less letters I have used count
		
		if ($firstHalf[0] < $secondHalf[0]){ #originally programmed as a regular MS, come here if there are any issues with reverse, they are likely to be near here
			$sortedList[] = $secondHalf[0]; 
			array_shift($secondHalf);#removes the first element from the given list 
			
		}
		else{
			$sortedList[] = $firstHalf[0]; #adding apart to the list of sorted nums
			array_shift($firstHalf); 
		}
		
		
	}
	#Adding the end of the lists when a or b run out of elements 
	while(count($firstHalf) > 0){
		$sortedList[] = $firstHalf[0];
		array_shift($firstHalf); #removing the first item from the list
	}
	
	while(count($secondHalf) > 0){
		$sortedList[] = $secondHalf[0]; #adding the required numbers
		array_shift($secondHalf);		#see above for array shift
	}
	
	return $sortedList;
	
}
	

#change to inner join
$usedIDs = array();
$_SESSION['length'] = ceil($_GET['q']); 
$temp = $_SESSION['date'];
$sql = "
SELECT roomsList.ID, roomsList.schoolCode, roomPupilBookLink.roomID,roomPupilBookLink.dateOfUse,roomPupilBookLink.timeOfUse,roomPupilBookLink.length
FROM roomsList 
INNER JOIN roomPupilBookLink
ON roomsList.ID  = roomPupilBookLink.roomID 
WHERE roomsList.schoolCode = '".$_SESSION[schoolCode]."' and roomPupilBookLink.dateOfUse ='".$temp."'";
$result = mysqli_query($conn,$sql);
$avilRooms = array();
if(mysqli_num_rows($result) <1){
	$newSql = "SELECT * FROM roomsList WHERE schoolCode = '".$_SESSION[schoolCode]."'";
	$newResult = mysqli_query($conn,$newSql);
	while($newRow = mysqli_fetch_array($newResult)){
		array_push($avilRooms,$newRow['ID']);
	}
}
else{
while($row = mysqli_fetch_assoc($result)){
	array_push($usedIDs,$row['ID']); 
	$sTime = strtotime($row['timeOfUse']);
	$eTime = $sTime+($row['length']*60*60);
	$sTimeToBook = strtotime($_SESSION['time']);
	$eTimeToBook = $sTimeToBook + ($_SESSION['length'] *60*60);
	$possible = testTime($sTimeToBook,$eTimeToBook,$sTime,$eTime);
	
	if($possible == True){
		
			array_push($avilRooms,$row['ID']);
		
	}
}
$sql = "SELECT * FROM roomsList WHERE schoolCode = '".$_SESSION[schoolCode]."'";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)){
	if(!in_array($row['ID'],$usedIDs)){
	
	
		array_push($avilRooms,$row['ID']);
	}
}
}


#Weighting the results to recommend the most booked room 
$weight = array();

foreach($avilRooms as $i){
	$sql = "SELECT * FROM roomsList WHERE ID ='".$i."';";
	$result = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_array($result)){
		array_push($weight,$row['timesBooked']);
		
	}
}

$sortedRoomsList = reverseMergeSort($weight);

$timeTemp = $_SESSION['time'];


#sorting the avaliable rooms to start with the highest booked room
$usedIs = array();
$run = True;
echo '<h1>The following rooms are ordered in how highly the system recomends them (the first result is the highest)</h1><table>
<tr> <th>Room ID</th><th>Room Name</th><th>Computers Avaliable?</th><th>The Room Seats</th><th>Click To Book</th></tr>';
foreach($sortedRoomsList as $i){
	if(sizeof($usedIs) > 0){
	foreach($usedIs as $k){
		if ($k == $i){
			$run = False;
		}
		else{
			$run = True; #Works on the basis the list inputed is sorted 
		}
	
	}
	}
	if($run == True){
	array_push($usedIs, $i);
	$sql = "SELECT * FROM roomsList WHERE timesBooked ='".$i."';";
	$result = mysqli_query($conn,$sql);
	while($rows = mysqli_fetch_array($result)){
		if(in_array($rows['ID'],$avilRooms)){
		echo '<tr><td>'.$rows[ID].'</td><td>'.$rows[roomName].'</td>';
		if($rows["comps"] == 1){
			echo'<td>Yes</td>';
			}else{
				echo'<td>No</td>';
				}
				echo '<td>'.$rows[safeSeatNum].'</td><td><form action="/includes/bookRoom.php" method="POST"><input type="hidden" name="roomName" value="'.$rows[roomName].'"/><input type="hidden" name="roomID" value="'.$rows[ID].'"/><input type="hidden" name="date" value="'.$temp.'"/><input type="hidden" name="time" value="'.$timeTemp.'"/><input type="hidden" name="length" value="'.$_SESSION[length].'"/><input type="submit" value="Book"/></form></td></tr>';
	}
	}
	}
}


echo '</table>';
