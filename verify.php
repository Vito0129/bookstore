<?php
session_start();
$usermail = $_POST['mainusermail']; //collect form data from post
$password = $_POST['mainpassword'];
$encpassword = md5($password); //create md5 hash of password
$con = mysql_connect('localhost', 'root', ''); //establish connection
//echo "usermail is ".$usermail;
//echo "<br>encrypted password is ".$encpassword;
if(!$con) //if connection not established
{
	die('Could not connect: '.mysql_error());
}
mysql_select_db('bookstore')or die('cannot select db'); //submit mysql use db query
$finduser = "select ismoderator from accounts where usermail='$usermail' and password='$encpassword';"; //create string = query
$results = mysql_query($finduser); //executes query and returns mysql result set object
$count = mysql_num_rows($results); //returns number of rows from result set
mysql_close($con);
if ($count == 1)
{
	$_SESSION['usermail'] = $usermail;
	header("location:index.php");
}
else
{
	$_SESSION['account'] = '';
	$_SESSION['error'] = "Error! Wrong username and password combination!";
	header("location:login.php");
}
?>