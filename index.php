<?php 
session_start();

if ($_SESSION['usermail'] == '')
{
	header("location:login.php");
}
$_SESSION['title'] = '';
$usermail = $_SESSION['usermail'];
$con = mysql_connect('localhost','root','');
if (!$con)
{
	die("Could not connect to database".mysql_error());
}
mysql_select_db('bookstore')or die('Cannot select database bookstore');
?>
<html>
	
	<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>Vito's Bookstore</title>


		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bookstore.css" rel="stylesheet">
    	<link href="css/shop-item.css" rel="stylesheet">
		<link href="css/simple-sidebar.css" rel="stylesheet">
		<script src="js/jquery.js"></script>
		<script src="js/bookstore.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/bootstrap.min.js"></script>

	</head>
	<body>
	<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Vito's Bookstore</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Home</a>
                    </li>
					<li>
						<a href="vieworder.php">My order</a>
					</li>
                    <li>
                        <a href="#menu-toggle" id="menu-toggle">Shopping Cart</a>
                    </li>
					<li>
						<a href="logout.php">Log Out</a>
					</li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	<div id="wrapper" class=''>
	<!-- Sidebar -->
		<div id="sidebar-wrapper">
			<div><button class='close' onclick='javascript: checkout()'>checkout</button><h3>&nbsp;&nbsp;&nbsp;&nbsp;Cart</h3></div>
            <ul class="sidebar-nav111">
				<?php
				$cart = "select books.isbn, title, booknumber from books, shoppingcart where books.isbn=shoppingcart.isbn and usermail='$usermail';";
				$list = mysql_query($cart)or die('No: '.mysql_error());
				while ($eachbook = mysql_fetch_assoc($list))
				{
					$title = $eachbook['title'];
					$number = $eachbook['booknumber'];
					$subtitle = substr($title,0,16);
					$count = 1;
					if(strlen($title) > 16){
						$subtitle = $subtitle . '...';
					}
					$isbn = $eachbook['isbn'];
					echo "<li id=\"$isbn\"><button class='close' onclick='removefrom(\"$isbn\",\"$usermail\",\"$title\");'>X&nbsp;</button>";
					echo "<select style='float:right' onchange='changenumber(\"$isbn\",\"$usermail\",this.value);'>";
					while($count < 10){
						if($number == $count){
							echo"<option value='$count' selected='selected'>$count</option>";
						}else{
							echo"<option value='$count'>$count</option>";
						}
						$count = $count + 1;
					}
					echo"</select>";
					echo "<label>".$subtitle."</label></li>";
				}
				?>
				<div id='shoppingCartBar'></div>
            </ul>
        </div>
	</div>
	<div id="page-content-wrapper">
		<div class='jumbotron'>
			<div class='container'>
				<div align='center'>
				<?php
				$getbooks = "Select isbn, title, image, price, category from books order by dateadded";
				$result = mysql_query($getbooks)or die("Error querying database: ".mysql_error());
				$incre = 1;
				while ($books = mysql_fetch_assoc($result))
				{
					$isbn = $books['isbn'];
					$title = $books['title'];
					echo "<div class='panel panel-default' align='center'>";
					echo "<form action='viewbook.php' method='POST' id = 'myForm".$incre."' name = 'myForm".$incre."'>";
					echo "<input type = 'hidden' value = '".$books['title']."' name = 'title'></form> ";
					echo "<p class='lead'><a href='javascript: getTitle(".$incre.")'>".$books['title']."</a></p>";
					echo "<p>Category: ".$books['category']."</p>";
					echo "<div id= '".$books['image']."' name='$title' draggable='true' droppable='true' ondragstart='drag(event);'><img src='img/".$books['image']."' width='150' height='200' alt='a book'></div>";
					echo "<p>Price: $".$books['price']."</p>";
					echo "<button class='btn btn-info' onclick='addto(\"$isbn\",\"$usermail\",\"$title\")'>Add to Shopping Cart</button><br><br>";
					echo "</div>";
					$incre++;
				}
				?>
				</div>
				<?php
				mysql_close($con);
				?>
			</div>
		</div>
		<footer>
		<div class="container">
        <hr>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Vito Huang 2016</p>
                </div>
            </div>
		</div>

		<!-- Menu Toggle Script -->
		<script>
		$("#menu-toggle").click(function(e) {
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
		});
		</script>
		
		</footer>
		</div>
	</body>
</html>
