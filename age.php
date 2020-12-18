<?php


if(array_key_exists("message",$_GET)){
  $msg=$_GET['message'];
  echo "<p><b>".$msg."</b></p>";
}
$dateOfBirth = "26-feb-2001";
$today = date("Y-m-d");
$diff = date_diff(date_create($dateOfBirth), date_create($today));
$x=$diff->format('%y');
echo 'Age is '.$x;
include 'connect.php';
$result=$conn->query("SELECT DOB FROM students WHERE Name='aanandan'");
$row=$result->fetch_assoc();
$dob=$row["DOB"];
?>
<!DOCTYPE html>
<html>
<body>
<label for="dob">DOB</label>
<input type="date" id="dob" name="dob" value="<?php echo $dob; ?>" required><br>
 </body>
 </html> 