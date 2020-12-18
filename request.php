<?php
session_start();
include 'connect.php';
$roomno=test_input($_POST["roomno"]);
$regno=$_SESSION["regno"];
$query=$conn->prepare("INSERT INTO room_requests VALUES (?,?)");
$query->bind_param("ii",$regno,$roomno);
if($query->execute())
  header('Location:student.php?request=Room.No:'.$roomno.' requested');
else
  header('Location:student.php?request=Some Error occurred!');  	
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>