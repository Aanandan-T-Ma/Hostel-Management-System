<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<?php
include 'connect.php';
if(array_key_exists('message',$_GET)){
  $query=$conn->prepare("SELECT * FROM staff WHERE username=?");	
  $username=$_GET['message'];	
  $query->bind_param("s",$username);
$query->execute();
$result=$query->get_result();
$row=$result->fetch_assoc();
$_SESSION["id"]=$row["StaffId"];
$_SESSION["name"]=$row["Name"];
$_SESSION["desg"]=$row["Designation"];
$_SESSION["username"]=$row["Username"];
$_SESSION["password"]=$row["Password"];
}
echo "<title>Welcome ".$_SESSION["name"]."!</title>";
if(!isset($_SESSION["username"]))
{
  header('Location:login.php?timedout=Session timed out!');
  exit();	
}	
?>
<style>
  .tab {
  height: 100%;
  width: 160px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

.tab button {
  background-color: #111;
  border:1px #111;
  text-align:center;  
  width:160px;
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
}

.tab button:hover {
  color: #f1f1f1;
}
.tab button.active{
  color: #f1f1f1;
}	
.tabcontent {
  margin-left:200px;
  padding: 0px 12px;
  width: 70%;
  border-left: none;
  height: 300px;
} 
  a
  {
	text-decoration:none;
    margin-top:3000px;	
  }
  a:hover
  {
	color:white;  
  }
  a:active
  {
	color:grey;  
  }
  table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%; 
}

td, th {
  border: 1px solid #aaaaaa;
  text-align: left;
  padding: 15px;
}
tr:hover,th
{
  background-color:#dddddd;	
}
#st th
{
  text-align:center;	
}
input[type=submit]{
  margin:20px 40px;	
  padding:5px 20px;
  font-size:20px;
  margin-left:100px;
  background-color:rgb(85,185,85);
  border-radius: 5px;
  }
  legend{
  font-size:30px;
  }
</style>
</head>
<body>
<div class="tab">
  <button id="defaultOpen" class="tablinks" onclick="openDiv(event,'requests')">Room requests</button>
  <button id="viewstud" class="tablinks" onclick="openDiv(event,'students')">View students</button>
  <button id="viewrooms" class="tablinks" onclick="openDiv(event,'rooms')">View rooms</button>
  <button class="tablinks"><a href="logout.php">Log out</a></button>
</div>

<div id="requests" class="tabcontent">
<fieldset>
<legend>Room Requests</legend>
<?php
include 'connect.php';
$result=$conn->query("SELECT * FROM room_requests");
if($result->num_rows>0)
{
  echo "<br><br><table id=\"st\"><tr><th>Student Regno</th><th>Roomno</th><th>Decision</th></tr>";
  $n=1;  
  while($row=$result->fetch_assoc())
  {
	echo "<tr><td>".$row["student_regno"]."</td><td>".$row["roomno"]."</td><td><input type=\"submit\" value=\"Accept\" form=\"acceptform".$n."\"></input><input type=\"submit\" value=\"Reject\" form=\"rejectform".$n."\"></input></td></tr>";	  
    echo "<form method=\"post\" action=\"decision.php\" id=\"acceptform".$n."\"><input type=\"hidden\" name=\"decision\" value=\"accept\"></input><input type=\"hidden\" name=\"regno\" value=\"".$row["student_regno"]."\"></input><input type=\"hidden\" name=\"roomno\" value=\"".$row["roomno"]."\"></input></form>";
    echo "<form method=\"post\" action=\"decision.php\" id=\"rejectform".$n."\"><input type=\"hidden\" name=\"decision\" value=\"reject\"></input><input type=\"hidden\" name=\"regno\" value=\"".$row["student_regno"]."\"></input><input type=\"hidden\" name=\"roomno\" value=\"".$row["roomno"]."\"></input></form>";
    $n++;
  }
  echo "</table><br><br>";
}
else
  echo "<code><center>No room requests</center></code>";	
if(array_key_exists('decision',$_GET))
  echo "<p><b>".$_GET["decision"]."</b></p>";	
?>
</fieldset>
</div>

<div id="students" class="tabcontent">
<?php
include 'connect.php';
$result=$conn->query("SELECT * FROM students");
if($result->num_rows>0)
{
  echo "<br><br><table><tr id=\"st\"><th colspan=\"11\">Student</th><th colspan=\"4\">Father</th><th colspan=\"4\">Mother</th><th rowspan=\"2\">Room</th></tr>";	
  echo "<tr><th>Regno</th><th>Name</th><th>DOB</th><th>Age</th><th>Gender</th><th>Blood group</th><th>Department</th><th>Year</th><th>Mobile</th><th>Email</th><th>Nativity</th><th>Name</th><th>Occupation</th><th>Mobile</th><th>Email</th><th>Name</th><th>Occupation</th><th>Mobile</th><th>Email</th></tr>";	
  while($row=$result->fetch_assoc())
  {
	$res=$conn->query("SELECT Roomno FROM alloted_rooms WHERE student_regno=".$row["Regno"]);
	if($res->num_rows==0)
	  $roomno="N/A";
    else
    {
	  $x=$res->fetch_assoc();
      $roomno=$x["Roomno"];	  
	}  
	echo "<tr><td>".$row["Regno"]."</td><td>".$row["Name"]."</td><td>".$row["DOB"]."</td><td>".$row["Age"]."</td><td>".$row["Gender"]."</td><td>".$row["Blood_group"]."</td><td>".$row["Dept"]."</td><td>".$row["Year"]."</td><td>".$row["Mobile"]."</td><td>".$row["Email"]."</td><td>".$row["Nativity"]."</td><td>".$row["F_name"]."</td><td>".$row["F_occupation"]."</td><td>".$row["F_mobile"]."</td><td>".$row["F_email"]."</td><td>".$row["M_name"]."</td><td>".$row["M_occupation"]."</td><td>".$row["M_mobile"]."</td><td>".$row["M_email"]."</td><td>".$roomno."</td></tr>";		
  }  	  
  echo "</table>";
}

?>
</div>

<div id="rooms" class="tabcontent">
<?php
include 'connect.php';
$result=$conn->query("SELECT * FROM rooms");
if($result->num_rows>0)
{
  echo "<br><br><table><tr id=\"st\"><th>Roomno</th><th>Hostel</th><th>Capacity</th><th>Occupied</th><th>Type</th><th>Bed Type</th><th>Bathroom</th><th>Gender</th><th colspan=\"4\">Students</th></tr>";	
  while($row=$result->fetch_assoc())
  {
	$stud=array("-","-","-","-");  
    $res=$conn->query("SELECT Name,Regno FROM students WHERE Regno in (SELECT student_regno FROM alloted_rooms WHERE roomno=".$row["Roomno"].")");
    $i=0;
	while($x=$res->fetch_assoc())  
      $stud[$i++]=$x["Name"]."<br>".$x["Regno"];
    echo "<tr><td>".$row["Roomno"]."</td><td>".$row["Hostelname"]."</td><td>".$row["Capacity"]."</td><td>".$row["Occupied"]."</td><td>".$row["Type"]."</td><td>".$row["Bedtype"]."</td><td>".$row["Bathroom"]."</td><td>".$row["Gender"]."</td><td>".$stud[0]."</td><td>".$stud[1]."</td><td>".$stud[2]."</td><td>".$stud[3]."</td></tr>";	    
  }  
  echo "</table><br><br>";
}

?>
</div>

<script>
function openDiv(evt,divName) {
  var i, tabcontent,tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(divName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
<?php
if(array_key_exists('rooms',$_GET))
  echo '<script>document.getElementById("selectrooms").click();</script>';		
else
  echo '<script>document.getElementById("defaultOpen").click();</script>';	 
?> 
</body>
</html>