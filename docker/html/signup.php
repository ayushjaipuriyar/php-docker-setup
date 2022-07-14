<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(isset($_POST['signup']))
{
 
//Code for student ID
$count_my_page = ("studentid.txt");
$hits = file($count_my_page);
$hits[0] ++;
$fp = fopen($count_my_page , "w");
fputs($fp , "$hits[0]");
fclose($fp); 
$StudentId= $hits[0];   
$fname=$_POST['fullname'];
$mobileno=$_POST['mobileno'];
$email=$_POST['email']; 
$password=md5($_POST['password']); 
$status=1;
$sql="INSERT INTO  tblstudents(StudentId,FullName,MobileNumber,EmailId,Password,Status) VALUES(:StudentId,:fname,:mobileno,:email,:password,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':StudentId',$StudentId,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo '<script>alert("Your Registration successfull and your student id is  "+"'.$StudentId.'")</script>';
}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";
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
			<form name="signup" onSubmit="return valid();" method="post">

			<h1>Sign Up</h1>

			<input type="test" placeholder="Name" name="fullname" required/>
			<input type="test" placeholder="Mobile Number" name="mobileno" maxlength="10" required/>
			<!-- <input type="email" placeholder="Email" name="emailid" onBlur="checkAvailability()" required/> -->
			<input type="email" placeholder="Email" name="email" required/>
			<span id="user-availability-status" style="font-size:12px;"></span> 
			<input type="password" placeholder="Password" name="password" required/>
					<input type="password" placeholder="Password" name="confirmpassword" required/>
					<button type="submit" name="signup" >Register</button>
				</form>
			</div>
			<div class="overlay-container">
				<div class="overlay">
					<div class="overlay-panel overlay-right">
						<h1><div id="greeting"></div></h1>

						<p>Please provide the following details to register</p>
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
