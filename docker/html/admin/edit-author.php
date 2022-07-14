<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

if(isset($_POST['update']))
{
$athrid=intval($_GET['athrid']);
$author=$_POST['author'];
$sql="update  tblauthors set AuthorName=:author where id=:athrid";
$query = $dbh->prepare($sql);
$query->bindParam(':author',$author,PDO::PARAM_STR);
$query->bindParam(':athrid',$athrid,PDO::PARAM_STR);
$query->execute();
$_SESSION['updatemsg']="Author info updated successfully";
header('location:authorlist.php');



}
?>
<!DOCTYPE html>
    <html>
    <head>
        <link href="./css/dashboard.css" rel="stylesheet" />
    </head>
    <body>
    <?php include('includes/header.php');?>
    <?php 
$athrid=intval($_GET['athrid']);
$sql = "SELECT * from  tblauthors where id=:athrid";
$query = $dbh -> prepare($sql);
$query->bindParam(':athrid',$athrid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>    
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
                                        <label for="userName">Book Name</label>
                                        <input type="text" name="author" value="<?php echo htmlentities($result->AuthorName);?>" required>
                                    </div>
                                    
                                    
                                    <div class="text-center">
                                        <button class="signup-btn" name="update" type="submit" required>Update</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }} ?>


</body>
</html>
<?php } ?>
