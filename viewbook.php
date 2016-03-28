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
$title = $_POST['title'];
$_SESSION['title'] = $title;
$books = "select isbn, title, author, image, category, summary, price, dateadded from books where title='".$title."' limit 1;";
$result = mysql_query($books)or die("Error fetching data".mysql_error());
$bookrow = mysql_fetch_assoc($result);	//create associative array from results based on column name
$reviews = "select usermail, title, score, review, postdate from books, review where books.isbn=review.booknumber and title='$title' order by postdate;";
$result2 = mysql_query($reviews);
$usermail = $_SESSION['usermail'];
?>
<html>
<head>
<title><?php echo $title; ?> </title>
<!-- <link href="css/style.css" rel="stylesheet" /> -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<link href="css/bookstore.css" rel="stylesheet" />
<script src="js/bookstore.js"></script>
<link href="css/shop-item.css" rel="stylesheet">
<link href="css/simple-sidebar.css" rel="stylesheet">
	
	<!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="//code.jquery.com/jquery-1.8.3.min.js"></script>
	<script>
		$(document).ready(function() {
		$tmp = $("#tmp").get(0);
		
		$("#sortable").sortable({
			start: function(event, ui) {
			},
			stop: function(event, ui) { 
				console.log("isNew : ", jQuery.data($tmp, "isNew"));
				console.log("resultHTML : ", jQuery.data($tmp, "resultHTML"));
			}
		});

		$("#draggable li").draggable({
			connectToSortable: "#sortable",
			start: function(event, ui) {    

				//Store info in a tmp div         
				jQuery.data($tmp, "isNew", true);
				jQuery.data($tmp, "resultHTML", "<b>Here I will add some custom html to EVENT data</b>");
				
			},
			helper: function(event) {
				return "<div class='custom-helper'>Custom helper for " + $(this).context.innerHTML + "</div>";   
			},
			revert: "invalid"
		});
	});
	</script>

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
						<a href="index.php">Home</a>
					</li>
					<li>
						<a href="#menu-toggle"  id="menu-toggle">Shopping Cart</a>
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
		<form action='checkout.php' method='POST' id = 'checkout' name = 'checkout'>
			<button class='close' onclick='javascript: checkout'>checkout</button><h3>&nbsp;&nbsp;&nbsp;&nbsp;Cart</h3>
		</form>
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

<div class='container'>
<div class='jumbotron'>
<h1><?php echo $title; ?></h1>
<?php
$isbn = $bookrow['isbn'];
?>
<p class='lead'>By <?php echo $bookrow['author']."  Category: ".$bookrow['category']; ?></p>
<?php echo "<div id='".$bookrow['image']."'draggable='true' droppable='true' ondragstart='drag(event);'><img src='img/".$bookrow['image']."' width='150' height='200' id='viewImage'></div>";?>
<p><?php echo $bookrow['summary'];?></p>
<p>$<?php echo $bookrow['price'];?></p>
<small>Added on <?php echo $bookrow['dateadded'];?></small><br>
<?php echo "<button type='button' class='btn btn-info' onclick='addto(\"$isbn\",\"$usermail\",\"$title\")'>Add to Shopping Cart</button>"; ?>
<br><br>
<p>Reviews for <?php echo $title;?></p>
<?php
while ($reviewrow = mysql_fetch_assoc($result2))
{
	echo "<ul>".$reviewrow['review']."</ul>";
	echo "<ul>This user gave this book a score of ".$reviewrow['score']."/10</ul>";
	echo "<ul>By ".$reviewrow['usermail']." on ".$reviewrow['postdate']."</ul><br>";
}
mysql_close($con);
?>
<br><br><br>
<label>Submit a review</label>
<form id='comment' method='post' action='review.php'>
<textarea class='form-control' name='review' id='review'></textarea>
<label for='score'>Score</label>
<select id='score' name='score'>
    <option value='1'>1</option>
    <option value='2'>2</option>
    <option value='3'>3</option>
    <option value='4'>4</option>
    <option selected='selected' value='5'>5</option>
    <option value='6'>6</option>
    <option value='7'>7</option>
    <option value='8'>8</option>
    <option value='9'>9</option>
    <option value='10'>10</option>
</select>
<?php echo "<input type='hidden' name='isbn' id='isbn' value='".$bookrow['isbn']."'>"; ?>
<button class='btn btn-default' type='submit'>Submit</button>
</form>
</div>
</div>

</body>
<footer>
		<div class="container">
			<hr>
            <div class="row">
                <div class="col-lg-12">
					<p>Copyright &copy; Vito Huang 2016</p>
                </div>
            </div>
		</div>
	
		<!-- jQuery -->
		<script src="js/jquery.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>

		<!-- Menu Toggle Script -->
		<script>
		$("#menu-toggle").click(function(e) {
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
		});
		</script>
</footer>
</html>