<?php
  $host="localhost";
  $user="root";
  $pass="mask13260728@mysql";
  $db="hostel";
  $conn=new mysqli($host,$user,$pass,$db);
  if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
?>