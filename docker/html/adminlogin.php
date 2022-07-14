<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['alogin']!=''){
$_SESSION['alogin']='';
}
if(isset($_POST['login']))
{
$username=$_POST['username'];
$password=md5($_POST['password']);
$sql ="SELECT UserName,Password FROM admin WHERE UserName=:username and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['username'];
echo "<script type='text/javascript'> document.location ='admin/dashboard.php'; </script>";
} else{
echo "<script>alert('Invalid Details');</script>";
}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<link href="./assets/css/style.css" rel="stylesheet" />
		
	</head>
	<body>
	<?php include('includes/header.php');?>

		<div class="container" id="container">
			<div class="form-container sign-in-container">
			<form role="form" method="post">

			<h1>Sign in</h1>

					<input type="text" placeholder="Email" name="username" required/>
					<input type="password" placeholder="Password" name="password" required/>
					<button type="submit" name="login">Sign In</button>
				</form>
			</div>
			<div class="overlay-container">
				<div class="overlay">
					<div class="overlay-panel overlay-right">
						<h1><div id="greeting"></div></h1>

						<p>Please enter your email and password to enter</p>
						<button class="ghost" id="signUp">
							<a href="signup.php">

								Sign Up
						</a>
					</button>
					</div>
				</div>
			</div>
		</div>
		<!-- <?php include('includes/footer.php');?> -->

	</body>
	<script src="./assets/js/login.js"></script>
</html>
