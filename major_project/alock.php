<?php
session_start();
include_once 'config.php';

if (!isset ($_SESSION['login_admin']))
{
	header("Location:adminlogin.php");
}
$user=$_SESSION['login_admin'];
$qry= $DBcon->query("SELECT * FROM admin WHERE a_id=$user ");
$row=$qry->fetch_array();
echo "WELCOME ";
echo $row['a_name'];
?>