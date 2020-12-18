<!DOCTYPE html>
<html>
<head>
<title>Hostel-login</title>
<style>
body
{
  margin:30px 100px;
}
input[type=text],input[type=password]
{
  padding: 10px 20px;
  margin: 20px 40px;
  border: 1px solid;
  border-radius: 5px;	
}
select 
{
  margin:20px 40px;
  padding:5px 20px;
}
input[type=submit]{
  margin:20px 40px;	
  padding:5px 20px;
  font-size:20px;
  margin-left:100px;
  background-color:rgb(85,185,85);
  border-radius: 5px;
  }
  #img
  {
	float:right;  
	background-image:url('https://www.bimhrdpune.com/wp-content/uploads/2018/12/hostel.jpg');
    width:780px;
    height:500px;	
  }
  #form
  {
	height:500px;  
  }
  .error {color: #FF0000;}
</style>
<script>
function showpass()
{
  var x=document.getElementById("password");
  if(x.type=="password")
    x.type="text";
  else
	x.type="password";  
}
</script>
</head>
<body>

<h1><center>ABC Hostels</h1>
<?php	
$invalid="";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
  include 'connect.php';	
  $username=test_input($_POST["username"]);
  $password=test_input($_POST["password"]);
  $category=test_input($_POST["category"]);
  
  if($category=="student")
   $query=$conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
  else
   $query=$conn->prepare("SELECT * FROM staff WHERE username=? AND password=?");	  
  $query->bind_param("ss",$username,$password);
  $query->execute();  
  $result=$query->get_result();
  if($result->num_rows==0)
    $invalid="Invalid username or password!";	
  elseif($category=="student")
    header('Location: student.php?message='.$username);
  else
	header('Location: staff.php?message='.$username);  
  $query->close();	
  $conn->close();	
}	
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<hr>
<div id="img"></div>
<div id="form">
<form id="lform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
<fieldset style="width:360px">
<legend>Login</legend>
<label for="username"><b>Username</b></label>
<input type="text" id="username" name="username" required><br>
<label for="password"><b>Password</b></label>
<input type="password" id="password" name="password" required><br>
<input type="checkbox" onclick="showpass()" id="showp" name="showp">
<label for="showp">Show password</label><br>
<label for="category"><b>Category</b></label>
  <select id="category" name="category" required>
      <option value=""></option>
      <option value="student">Student</option>
	  <option value="staff">Staff</option>
  </select>
<div class="error"><?php echo $invalid; ?></div>  
<input type="submit" form="lform" value="Login"></input>
<?php
if(array_key_exists("message",$_GET)){
  $msg=$_GET['message'];
  echo "<p><b>".$msg."</b></p>";
}
elseif(array_key_exists("timedout",$_GET)){
  $msg=$_GET['timedout'];
  echo "<p style=\"background-color:color: #FF0000\"><b>".$msg."</b></p>";
}
elseif(array_key_exists("logout",$_GET)){
  $msg=$_GET['logout'];
  echo "<p style=\"background-color:color: #00FF00\"><b>".$msg."</b></p>";
}
?>
</fieldset>
</form>
<br>
<a href="signup.php">New Student?Signup</a>
</div>
<hr>
</body>
</html>