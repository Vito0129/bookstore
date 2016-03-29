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
?>
<html>
<head>
<title>My order</title>
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
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="vieworder.php">My order</a>
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

<div class='container'>
    <div class='jumbotron'>
        <?php
        $order = "SELECT bookorderlist.id,bookorderlist.orderdate,books.title,bookorderdetail.booknumber,bookorderlist.status,bookorderlist.tot_price FROM books,bookorderlist,bookorderdetail
        WHERE bookorderlist.usermail = '$usermail'
        and bookorderlist.id = bookorderdetail.id
        and books.isbn = bookorderdetail.isbn;";
        $list = mysql_query($order)or die('Error submitting to database:'.mysql_error());
        echo '<table align="center" border="1">';
            echo '<tr><th>订单编号</th><th>日期</th><th>书名</th><th>数量</th><th>订单总价</th><th>状态</th></tr>';
            while ($eachrecord = mysql_fetch_assoc($list)) {
                $id = $eachrecord['id'];
                $date = $eachrecord['orderdate'];
                $status = $eachrecord['status'];
                $title = $eachrecord['title'];
                $tot_price = $eachrecord['tot_price'];
                $number = $eachrecord['booknumber'];
                if ($status == '-1') $status = '已取消';
                if ($status == '0') $status = '待发货';
                if ($status == '1') $status = '已发货';
                if ($status == '2') $status = '已签收';
                echo '<tr><th>' . $id . '</th><th>' . $date . '</th><th>' . $title . '</th><th>' . $number . '</th><th>' . $tot_price . '</th><th>' . $status . '</th></tr>';
            }

            echo '</table>';
        ?>

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
    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</footer>
</html>