<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

if(isset($_POST['create']))
{
$author=$_POST['author'];
$sql="INSERT INTO  tblauthors(AuthorName) VALUES(:author)";
$query = $dbh->prepare($sql);
$query->bindParam(':author',$author,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$_SESSION['msg']="Author Listed successfully";
header('location:authorlist.php');
}
else 
{
$_SESSION['error']="Something went wrong. Please try again";
header('location:authorlist.php');
}

}
?>
<!DOCTYPE html>
    <html>
    <head>
        <link href="./css/dashboard.css" rel="stylesheet" />
    </head>
    <body>  
    <?php include('includes/header.php');?>

                <div class="frm-container">
                    <div class="frm-container_flex">
                        <div class="author-login frm-login">
                            <div class="inner">
                                <img src="./user.png" width="100" class="author_icon frm_user_avatar">
                            </div>
                        </div>
                        <div class="frm-signup">
                            <div class="inner">
                                <form role="form" method="post">
                                    <div class="frm-group">
                                        <label for="userName">Author Name</label>
                                        <input type="text" name="author" required>
                                    </div>
                                    
                                    
                                    <div class="text-center">
                                        <button class="signup-btn" name="create" type="submit" required>Add</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

</body>
</html>
<?php } ?>
