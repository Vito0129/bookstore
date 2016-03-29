<?php
session_start();

if(!$_SESSION['usermail']){
    header("location:login.php");
}
$con = mysql_connect('localhost','root','');
if (!$con)
{
    die("Could not connect to database".mysql_error());
}
mysql_select_db('bookstore')or die('Cannot select database bookstore');
$usermail = $_SESSION['usermail'];
$date = $_POST['date'];
$status = 0;

$cart = "select books.isbn, booknumber from books, shoppingcart where books.isbn=shoppingcart.isbn and usermail='$usermail';";
$list = mysql_query($cart)or die('No:1234 '.mysql_error());

if(mysql_num_rows($list) != 0)
{
    $new = "insert into bookorderlist(usermail,status,orderdate) values('$usermail','$status','$date');";
    mysql_query($new)or die('Error submitting to database: '.mysql_error());
    $order = "select * from bookorderlist where usermail = '$usermail' and orderdate = '$date'";
    $order1 = mysql_query($order)or die('Error submitting to database: '.mysql_error());
    $eachorder = mysql_fetch_assoc($order1);
    $id = $eachorder['id'];
    while ($eachbook = mysql_fetch_assoc($list))
    {
        $isbn = $eachbook['isbn'];
        $number = $eachbook['booknumber'];
        $new = "insert into bookorderdetail(id,isbn,booknumber) values('$id','$isbn','$number');";
        mysql_query($new)or die('Error submitting to database: '.mysql_error());
        $deleter = "delete from shoppingcart where isbn = '$isbn' and usermail = '$usermail'";
        mysql_query($deleter)or die('Error submitting data: '.mysql_error());
    }
    mysql_close($con);
    echo "success";
}
else
{
    mysql_close($con);
    echo "emptycart";
}
?>