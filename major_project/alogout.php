<?php
session_start();

if(!isset($_SESSION['login_admin']))
{
	header("location:adminlogin.php");
}
if(isset($_GET['alogout']))
{
	session_destroy();
	unset($_SESSION['login_admin']);
	header("location:adminlogin.php");
}
?>
