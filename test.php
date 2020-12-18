<?php
session_start();
include 'connect.php';
$rooms="";
$regno=$_SESSION["regno"];
$alloted=$conn->query("SELECT * FROM alloted_rooms WHERE student_regno=".$regno);
if($alloted->num_rows>0)
  $rooms="Rooms already allotted!";
$request=$conn->query("SELECT * FROM room_requests WHERE student_regno=".$regno);
if($rooms=="" AND $request->num_rows==3)
  $rooms="Only 3 preferences can be made!";
header('Location:student.php?rooms='.$rooms);
?>