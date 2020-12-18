<?php
session_start();
include 'connect.php';
$regno=$_SESSION["regno"];
$alloted=$conn->query("SELECT * FROM alloted_rooms WHERE student_regno=".$regno);
if($alloted->num_rows>0)
{
  header('Location:student.php?rooms=Rooms already alloted!');
  exit();
}
$request=$conn->query("SELECT * FROM room_requests WHERE student_regno=".$regno);
if($request->num_rows==3)
{
  header('Location:student.php?rooms=Only 3 preferences can be made!');
  exit();  
}  
$q=$conn->prepare("SELECT * FROM rooms WHERE Capacity=? AND Type=? AND Bedtype=? AND Bathroom=? AND Gender=? AND Occupied<Capacity");
$capacity=test_input($_POST["capacity"]);
$type=test_input($_POST["type"]);
$bedtype=test_input($_POST["bedtype"]);
$bathroom=test_input($_POST["bathroom"]);
$gender=test_input($_POST["gender"]);	
$q->bind_param("issss",$capacity,$type,$bedtype,$bathroom,$gender);
$q->execute();
$res=$q->get_result();
if($res->num_rows==0)
  header('Location:student.php?rooms=No rooms available for the given preferences!');	
else{	
  $rows=0;
  $rooms=array();
  while($row=$res->fetch_assoc())
  {
	array_push($rooms,$row);
	$rows++;	
  }	   	  
  $_SESSION["rooms"]=$rooms;
  $_SESSION["rows"]=$rows;
  header('Location:student.php?rooms=available');   	
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>