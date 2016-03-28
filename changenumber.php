<?php
/**
 * Created by PhpStorm.
 * User: vito
 * Date: 3/28/16
 * Time: 1:13 PM
 */
$con = mysql_connect('localhost','root','');
if (!$con)
{
    die("Could not connect to database".mysql_error());
}
mysql_select_db('bookstore')or die('Cannot select database bookstore');
$isbn = $_POST['isbn'];
$usermail = $_POST['user'];
$number = $_POST['number'];
$changer = "update shoppingcart set booknumber='$number' where isbn = '$isbn' and usermail = '$usermail';";
mysql_query($changer)or die('Error submitting data: '.mysql_error());
mysql_close($con);
?>