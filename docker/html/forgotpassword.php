<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['change']))
{
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$newpassword=md5($_POST['newpassword']);
  $sql ="SELECT EmailId FROM tblstudents WHERE EmailId=:email and MobileNumber=:mobile";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update tblstudents set Password=:newpassword where EmailId=:email and MobileNumber=:mobile";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
$chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
echo "<script>alert('Your Password succesfully changed');</script>";
}
else {
echo "<script>alert('Email id or Mobile no is invalid');</script>"; 
}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<link href="./assets/css/style.css" rel="stylesheet" />
		<script type="text/javascript">
function valid()
{
if(document.signup.password.value!= document.signup.confirmpassword.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.signup.confirmpassword.focus();
return false;
}
return true;
}
</script>
<!-- <script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>    -->
	</head>
	<body>
	<?php include('includes/header.php');?>

		<div class="container" id="container">
			<div class="form-container sign-in-container">
				<form name="chngpwd" onSubmit="return valid();" method="post">

					<h1>Change Password</h1>

					<input  type="email" name="email" required autocomplete="off" placeholder="Email"/>
					<input  type="text" name="mobile" required autocomplete="off" placeholder="Mobile no"/>
					<input type="password" placeholder="Password" name="newpassword" required/>
					<input type="password" placeholder="Password" name="confirmpassword" required/>
					<button type="submit" name="change" >Change Password</button>
				</form>
			</div>
			<div class="overlay-container">
				<div class="overlay">
					<div class="overlay-panel overlay-right">
						<h1><div id="greeting"></div></h1>

						<p>Please use a secure password and dont forget</p>
						<button class="ghost" id="signUp">
							<a href="index.php">
								Sign in
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
