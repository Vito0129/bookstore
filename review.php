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
$wishlist = false;
$isbn = $_POST['isbn'];
$score = $_POST['score'];
$review = $_POST['review'];
$new = "insert into review(booknumber,postdate,review,score,usermail) values('$isbn',NOW(),'$review','$score','$usermail');";
mysql_query($new)or die('error submitting to database: '.mysql_error());
mysql_close($con);
//resubmit title value over to viewbook via post to redirect to correct book
$title = $_SESSION['title'];
$_SESSION['title'] = '';
?>
<head>
<script>
window.onload = function(){
  document.forms['returnform'].submit();

}
</script>
</head>
<body>
<?php
echo "<form method='post' action='viewbook.php' name='returnform' id='returnform'><input name='title' type='hidden' value='".$title."'></form>";
?>
</body>