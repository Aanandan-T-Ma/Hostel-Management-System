<?php
include 'connect.php';
$regno=test_input($_POST["regno"]);
$roomno=test_input($_POST["roomno"]);
$dec=test_input($_POST["decision"]);
if($dec=="accept")
{	
  if($conn->query("DELETE FROM room_requests WHERE student_regno=".$regno))
  {
    if($conn->query("INSERT INTO alloted_rooms VALUES (".$regno.",".$roomno.")"))
    {
	  $conn->query("UPDATE rooms SET Occupied=Occupied+1 WHERE Roomno=".$roomno);	
	  header('Location:staff.php?decision=Room.No:'.$roomno.' allotted for Reg.No:'.$regno);
	}  
    else
      header('Location:staff.php?decision=Some Error occurred!'); 		
  }
  else
	header('Location:staff.php?decision=Some Error occurred!');   
}
else
{
  if($conn->query("DELETE FROM room_requests WHERE student_regno=".$regno." AND roomno=".$roomno))
    header('Location:staff.php?decision=Room.No:'.$roomno.' rejected for Reg.No:'.$regno);
  else
	header('Location:staff.php?decision=Some Error occurred!');	  
}	
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>