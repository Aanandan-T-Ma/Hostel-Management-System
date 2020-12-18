<?php
include 'connect.php';
$username=test_input($_POST["username"]);
$password=test_input($_POST["password"]);
$cpassword=test_input($_POST["cpassword"]);
if(!preg_match("/^[a-zA-Z0-9@#_]*$/",$password))
{
  header('Location:student.php?password=pass');
  exit();  
}
if($cpassword!=$password)
{
  header('Location:student.php?password=cpass');
  exit();  
}
if($conn->query("UPDATE users SET password='$password' WHERE username='$username'"))
  header('Location:student.php?password=set');
else
  header('Location:student.php?password=notset');	
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>