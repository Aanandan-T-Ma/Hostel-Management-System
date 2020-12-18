<?php
  session_start();  
  include 'connect.php';
  $dob=test_input($_POST["dob"]);
  $blood=test_input($_POST["bloodgroup"]);
  $mob=test_input($_POST["mob"]);
  $fmob=test_input($_POST["fmob"]);
  $mmob=test_input($_POST["mmob"]);
  $email=test_input($_POST["email"]);
  $femail=test_input($_POST["femail"]);
  $memail=test_input($_POST["memail"]);
  $today = date("Y-m-d");
  $diff = date_diff(date_create($dob), date_create($today));
  $age=$diff->format('%y');
  if($age<17)
    header('Location:student.php?doberr=Invalid DOB!Age less than 17!');	  
  elseif(!preg_match("/^(A|B|O|AB)(\+|\-)ve$/",$blood))
    header('Location:student.php?blooderr=Invalid blood group');	  
  elseif(!preg_match("/^[0-9]{10}$/",$mob))
    header('Location:student.php?moberr=Invalid student mobile number');  
  elseif(!preg_match("/^[0-9]{10}$/",$fmob))
    header('Location:student.php?fmoberr=Invalid father mobile number');
  elseif(!preg_match("/^[0-9]{10}$/",$mmob))
    header('Location:student.php?mmoberr=Invalid mother mobile number');	
  else{	
  $regno=$_SESSION["regno"];
  $username=$_SESSION["username"];  
  $query=$conn->prepare("UPDATE students SET DOB=?,Blood_group=?,Mobile=?,Email=?,F_mobile=?,F_email=?,M_mobile=?,M_email=? WHERE Regno=?");
  $query->bind_param("ssisisisi",$dob,$blood,$mob,$email,$fmob,$femail,$mmob,$memail,$regno);
  if($query->execute())
     header('Location: student.php?message='.$username);
  else
  {
	echo '<script>alert("Update failed!Try again")</script>';
    header('Location:student.php');	
  }	
  }
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>