<?php
include("config.php");

if(isset($_POST['btn-signup']))
{
	$uname=$_POST['username'];
	$ucont=$_POST['usercont'];
	$uemail=$_POST['useremail'];
	$upass=$_POST['password'];
	$uaddress=$_POST['Address'];
	
	$hashed_pass=password_hash($upass,PASSWORD_DEFAULT);
	
	$check_email=$DBcon->query("SELECT * FROM admin WHERE a_email='$uemail' OR a_cont='$ucont'");
	
	$count1=$check_email->num_rows;
	
	if($count1==0)
	{
		$query="INSERT INTO admin(a_name,a_cont,a_email,a_pass,a_address) VALUES('$uname','$ucont','$uemail','$hashed_pass','$uaddress')";
		
		if($DBcon->query($query))
		{
			echo "<script>alert('Successfully Registered');window.location.href='Adminlogin.php';</script>";
		
		}
		else
		{
			$msg="error while registering";
		}
	}
	else
	{
		$msg="sorry email OR Contact already taken";
	}
	
	$DBcon->close();
}

?>

<html>
<head>

</head>

<body>
   <form method="post" id="register-form">
   
   <h2>Sign up</h2><hr />
   
   <?php
   if(isset($msg))
   {
	   echo $msg;
   }
   ?>
   <input type="text" name="username" placeholder="Enter name" required />
   <input type="number" name="usercont" placeholder="Enter Contact" required />
   <input type="text" name="useremail" placeholder="Enter Email" required />
   <input type="password" name="password" placeholder="Enter password" required />
   <input type="text" name="Address" placeholder="Enter Address" required />

   
   <button type="submit" name="btn-signup"> &nbsp;Creat Account </button>
   
   <a href="adminlogin.php" class="btn btn=default" style="float:right;">Log In Here</a>
   
   </form>

</body>

</html>