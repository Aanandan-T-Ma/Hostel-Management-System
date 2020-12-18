<!DOCTYPE html>
<html>
<head>
 <title>Sign Up</title>
 <style>
  legend{
  font-size:30px;
  }
  select,input[type=text],[type=password],[type=number],[type=email],[type=submit],[type=date]{
  width:25%;
  padding: 12px 20px;
  margin: 20px 40px;
  border: 1px solid;
  border-radius: 5px;
  }
  input:focus{
  background-color:lightblue;
  }
  input[type=radio]{
   margin-left:70px;
  }
  input[type=submit]{
  background-color:rgb(85,185,85);
  color:White;
  border-color:black;
  font-size:20px;
  display:inline-block;
  }
  input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}
  label
  {
    font-weight:bold;
	font-size:20px;
    display:inline-block;
	width:140px;
	text-align:left;
  }
  .error {color: #FF0000;}
 </style>
</head>
<body>
<?php
$name=$dob=$regno=$fname=$mname=$mob=$fmob=$mmob=$email=$femail=$memail=$uname=$password=$cpass="";
$nameerr=$doberr=$regnoerr=$fnameerr=$mnameerr=$moberr=$fmoberr=$mmoberr=$unameerr=$passerr=$cpasserr="";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
   $name=test_input($_POST["name"]);
   if(!preg_match("/^[a-zA-Z ]*$/",$name))
     $nameerr = "* Only letters and white space allowed";  
   $regno=test_input($_POST["regno"]);
   if(!preg_match("/^[0-9]{10}$/",$regno))
     $regnoerr = "* Only exactly 10 digits allowed";
   $fname=test_input($_POST["fname"]);
   if(!preg_match("/^[a-zA-Z ]*$/",$fname))
     $fnameerr = "* Only letters and white space allowed";
   $mname=test_input($_POST["mname"]);
   if(!preg_match("/^[a-zA-Z ]*$/",$mname))
     $mnameerr = "* Only letters and white space allowed";
   $mob=test_input($_POST["mob"]);
   if(!preg_match("/^[0-9]{10}$/",$mob))
     $moberr = "* Invalid mobile number";
   $fmob=test_input($_POST["fmob"]);
   if(!preg_match("/^[0-9]{10}$/",$fmob))
     $fmoberr = "* Invalid mobile number";
   $mmob=test_input($_POST["mmob"]);
   if(!preg_match("/^[0-9]{10}$/",$mmob))
     $mmoberr = "* Invalid mobile number";
   $uname=test_input($_POST["username"]);
   if(!preg_match("/^[a-zA-Z0-9]*$/",$uname))
     $unameerr = "* Only letters and numbers allowed";
   $password=test_input($_POST["password"]);
   if(!preg_match("/^[a-zA-Z0-9@#_]*$/",$password))
     $passerr = "* Password can contain only letters,numbers,@,#,_";
   $cpass=test_input($_POST["cpassword"]);
   if($passerr=="" AND $cpass!=$password)
     $cpasserr="* Passwords don't match";	   
   $dob =test_input($_POST["dob"]);
     $today = date("Y-m-d");
     $diff = date_diff(date_create($dob), date_create($today));
     $age=$diff->format('%y');
   if($age<17)
     $doberr="* Invalid DOB!Age less than 17";	   
   $email=test_input($_POST["email"]);
   $femail=test_input($_POST["femail"]);
   $memail=test_input($_POST["memail"]);
   if($nameerr=="" AND $doberr=="" AND $regnoerr=="" AND $fnameerr=="" AND $mnameerr=="" AND $moberr=="" AND $fmoberr=="" AND $mmoberr=="" AND $unameerr=="" AND $passerr=="" AND $cpasserr=="")
   {
	 include 'connect.php';
	 
	 $result1=$conn->query("SELECT * FROM students WHERE Regno in (SELECT student_regno FROM users WHERE username='".$uname."')");
	 $result2=$conn->query("SELECT * FROM students WHERE Regno in (SELECT student_regno FROM users WHERE password='".$password."')"); 
     $result3=$conn->query("SELECT * FROM users WHERE student_regno=".$regno);	 
     if($result1->num_rows==0 AND $result2->num_rows==0 AND $result3->num_rows==0){
	 $gender=test_input($_POST["gender"]);
	 $dept=test_input($_POST["dept"]);
	 $year=test_input($_POST["year"]);
	 $blood=test_input($_POST["bloodgroup"]);
	 $nativity=test_input($_POST["country"]);
	 $foccu=test_input($_POST["foccu"]);
     $moccu=test_input($_POST["moccu"]);
	 $query=$conn->prepare("INSERT INTO students VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
     $query->bind_param("ississisisssisssiss",$regno,$name,$dob,$age,$gender,$dept,$year,$blood,$mob,$email,$nativity,$fname,$fmob,$femail,$foccu,$mname,$mmob,$memail,$moccu);	
     $query->execute();
	 $res=$conn->query("INSERT INTO users VALUES (".$regno.",'".$uname."','".$password."')");
	 header('Location: login.php?message=Account successfully created!');		       	  
   }
   elseif($result3->num_rows>0)
     $regnoerr="* Already registered Regno!";
   elseif($result1->num_rows>0)
	 $unameerr="* Username already registered";
   else
     $passerr="* Existing password!Try an alternate";	   
   }	   
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<h1 style="font-size:50px;"><center>Registration Form</h1>
<hr>
<form id="regform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <fieldset>
   <legend>Personal Details</legend>
  <label for="name">Name</label>
  <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><span class="error"><?php echo $nameerr; ?></span><br>
  <label for="dob">DOB</label>
  <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>" required><span class="error"><?php echo $doberr; ?></span><br>
  <label for="gender">Gender</label>
  <input type="radio" id="gender" name="gender" value="Male" checked><b>Male</b>
  <input type="radio" id="gender" name="gender" value="Female"><b> Female</b>
  <input type="radio" id="gender" name="gender" value="Other"> <b>Other</b><br>
  <label for="bloodgroup">Blood Group</label>
  <select id="bloodgroup" name="bloodgroup" required>
      <option value=""></option>
      <option value="A+ve">A+ve</option>
	  <option value="A-ve">A-ve</option>
      <option value="B+ve">B+ve</option>
      <option value="B-ve">B-ve</option>
      <option value="AB+ve">AB+ve</option>
	  <option value="AB-ve">AB-ve</option>
      <option value="O+ve">O+ve</option>
      <option value="O-ve">O-ve</option>
  </select><br>
  <label for="country">Nativity</label>
  <select id="country" name="country" required>
      <option value=""></option>
      <option value="Australia">Australia</option>
	  <option value="Afghanisthan">Afghanistan</option>
      <option value="Canada">Canada</option>
      <option value="Chine">China</option>
      <option value="Denmark">Denmark</option>
      <option value="England">England</option>
      <option value="India">India</option>
	  <option value="Pakisthan">Pakisthan</option>
      <option value="USA">USA</option>
  </select>
  </fieldset>
  <fieldset>
  <legend>Academic Details</legend>
  <label for="regno">Reg.No</label>
  <input type="number" id="regno" name="regno" value="<?php echo $regno; ?>" required><span class="error"><?php echo $regnoerr; ?></span><br>
  <label for="dept">Department</label>
  <select id="dept" name="dept" required>
      <option value=""></option>
      <option value="Aeronautical Engineering">Aeronautical Engineering</option>
	  <option value="Automobile Engineering">Automobile Engineering</option>
      <option value="Computer Technology">Computer Technology</option>
      <option value="Electronics & Communication Engineering">Electronics & Communication Engineering</option>
      <option value="Electronics & Electrical Engineering">Electronics & Electrical Engineering</option>
      <option value="Electronics & Instrumentation Engineering">Electronics & Instrumentation Engineering</option>
      <option value="Information Technology">Information Technology</option>
	  <option value="Mechanical Engineering">Mechanical Engineering</option>
	  <option value="Mechatronics">Mechatronics</option>
      <option value="Production Technology">Production Technology</option>
      <option value="Rubber & Plastic Technology">Rubber & Plastic Technology</option>
  </select><br>
  <label for="year">Year</label>
  <select id="year" name="year" required>
      <option value=""></option>
      <option value="1">1</option>
	  <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
  </select><br>
  </fieldset>
    <fieldset>
        <legend>Parent Details</legend>
       <label for="fname">Father Name</label>
       <input type="text" id="fname" name="fname" value="<?php echo $fname; ?>" required><span class="error"><?php echo $fnameerr; ?></span><br>
       <label for="foccu">Occupation</label>
       <select id="foccu" name="foccu" required>
        <option value=""></option>
        <option value="Public service">Public service</option>
        <option value="Private employee">Private employee</option>
	    <option value="Teacher">Teacher</option>
	    <option value="Doctor">Doctor</option>
        <option value="Farmer">Farmer</option>
        <option value="Business">Business</option>
		<option value="Self employed">Self employed</option>
		<option value="Home maker">Home maker</option>
		<option value="Other">Other</option>
      </select><br>
       <label for="fmob">Mobile.no</label>
       <input type="number" id="fmob" name="fmob" value="<?php echo $fmob; ?>" required><span class="error"><?php echo $fmoberr; ?></span><br>
      <label for="femail">E-mail</label>
      <input type="email" id="femail" name="femail" value="<?php echo $femail; ?>"><br>
       <label for="mname">Mother Name</label>
       <input type="text" id="mname" name="mname" value="<?php echo $mname; ?>" required><span class="error"><?php echo $mnameerr; ?></span><br>
       <label for="moccu">Occupation</label>
       <select id="moccu" name="moccu" required>
        <option value=""></option>
        <option value="Public service">Public service</option>
        <option value="Private employee">Private employee</option>
	    <option value="Teacher">Teacher</option>
	    <option value="Doctor">Doctor</option>
        <option value="Farmer">Farmer</option>
        <option value="Business">Business</option>
		<option value="Self employed">Self employed</option>
		<option value="Home maker">Home maker</option>
		<option value="Other">Other</option>
      </select><br>
       <label for="mmob">Mobile.no</label>
       <input type="number" id="mmob" name="mmob" value="<?php echo $mmob; ?>"><span class="error"><?php echo $mmoberr; ?></span><br>
      <label for="memail">E-mail</label>
      <input type="email" id="memail" name="memail" value="<?php echo $memail; ?>"><br>
    </fieldset>
    <fieldset>
        <legend>Contact Details</legend>
      <label for="mob">Mobile.no</label>
      <input type="number" id="mob" name="mob" value="<?php echo $mob; ?>"><span class="error"><?php echo $moberr; ?></span><br>
      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br>
    </fieldset>
	<fieldset>
	    <legend>Account Details</legend>
      <label for="username">Username</label>
      <input type="text" id="username" name="username" value="<?php echo $uname; ?>" required><span class="error"><?php echo $unameerr; ?></span><br>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" value="<?php echo $password; ?>" required><span class="error"><?php echo $passerr; ?></span><br>
	  <label for="cpassword">Confirm Password</label>
      <input type="password" id="cpassword" name="cpassword" value="<?php echo $cpass; ?>" required><span class="error"><?php echo $cpasserr; ?></span><br>
	</fieldset>
	<center><input type="submit" value="Submit" form="regform"></center>
</form>
</body>
</html>
