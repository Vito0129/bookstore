<?php session_start();

// Check if the user has logged in
if( !empty($_SESSION['usermail']) ){
  //header("location:index.php");
}
?>
<html>
<head>
<meta charset='utf-8'>
<title>Vito's Bookstore: Login Page</title>
<!-- <link href="css/style.css" rel="stylesheet" /> -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<link href="css/bookstore.css" rel="stylesheet" />
<!-- external css-->
<link href="css/bookstore.css" rel="stylesheet" />
<script src="js/bookstore.js"></script>
<link href="css/shop-item.css" rel="stylesheet">
<link href="css/simple-sidebar.css" rel="stylesheet">
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/bookstore.js"></script>
</head>

<body>
<!--login format courtesy of getbootstrap.com-->
<center>
<div class='container'>
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
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<center>
<div>
<?php
if (!empty($_SESSION['error']))
{
	echo "<div class='container error'><div class='alert alert-danger'>".$_SESSION['error']."</div></div><br>";
	$_SESSION['error'] = '';
}
if (!empty($_SESSION['account']))
{
	echo "<div class='container error'><div class='alert alert-success'>".$_SESSION['account']."</div></div><br>";
	$_SESSION['account'] = '';
}
?>
<div>
<div class='panel panel-default'>
<div class='panel-heading'><h2 class='panel-title'><strong>Log In</strong></h2></div>
<form role='form' class='form-signin' name='login' id='login' method='post' action='verify.php' onsubmit='return validateLogin();'>
<div class='panel-body'>
<div class='form-group'><input type='email' class='form-control input-sm chat-input' id='mainusermail' placeholder='Email' name='mainusermail'></div>
<div class='form-group'><input type='password' class='form-control input-sm chat-input' id='mainpassword' placeholder='Password' name='mainpassword'></div>
<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>
</div>
</div>
</div>

<br>

<div>
<div class='panel panel-default'>
<div class='panel-heading'><h2 class='panel-title'><strong>Sign Up</strong></h2></div>
<form class='form-signin' name='register' id='register' method='post' action='register.php' onsubmit='return validateRegistration();'>
<div class='panel-body'>
<div class='form-group'><input type='email' class='form-control input-sm chat-input' id='usermail' placeholder='Email' name='usermail'></div>
<div class='form-group'><input type='password' class='form-control input-sm chat-input' id='password' placeholder='Password' name='password'></div>
<div class='form-group'><input type='password' class='form-control input-sm chat-input' id='checkpassword' placeholder='Reenter Password' name='checkpassword'></div>
<button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
</form>
</div>
</div>
</div>

</div>
</center>

</div>
</body>
</html>