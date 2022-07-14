<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

if(isset($_POST['add']))
{
$bookname=$_POST['bookname'];
$category=$_POST['category'];
$author=$_POST['author'];
$isbn=$_POST['isbn'];
$price=$_POST['price'];
$bookimg=$_FILES["bookpic"]["name"];
// get the image extension
$extension = substr($bookimg,strlen($bookimg)-4,strlen($bookimg));
// allowed extensions
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
//rename the image file
$imgnewname=md5($bookimg.time()).$extension;
// Code for move image into directory

if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
move_uploaded_file($_FILES["bookpic"]["tmp_name"],"bookimg/".$imgnewname);
$sql="INSERT INTO  tblbooks(BookName,CatId,AuthorId,ISBNNumber,BookPrice,bookImage) VALUES(:bookname,:category,:author,:isbn,:price,:imgnewname)";
$query = $dbh->prepare($sql);
$query->bindParam(':bookname',$bookname,PDO::PARAM_STR);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':author',$author,PDO::PARAM_STR);
$query->bindParam(':isbn',$isbn,PDO::PARAM_STR);
$query->bindParam(':price',$price,PDO::PARAM_STR);
$query->bindParam(':imgnewname',$imgnewname,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Book Listed successfully');</script>";
echo "<script>window.location.href='managebooks.php'</script>";
}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";    
echo "<script>window.location.href='managebooks.php'</script>";
}}
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
                        <div class="frm-login">
                        </div>
                        <div class="frm-signup">
                            <div class="inner">
                                <form role="form" method="post" enctype="multipart/form-data">
                                    <div class="frm-group">
                                        <label for="userName">Book Name</label>
                                        <input type="text" name="bookname"  required>
                                    </div>
                                    
                                    <div class="frm-group">
                                        <label for="author" name="author" >Author</label>
                                        <select class="" name="author" required="required">
                                        <?php 
                                            $sql2 = "SELECT * from  tblauthors ";
                                            $query2 = $dbh -> prepare($sql2);
                                            $query2->execute();
                                            $result2=$query2->fetchAll(PDO::FETCH_OBJ);
                                            if($query2->rowCount() > 0){
                                                foreach($result2 as $ret){           
                                                    if($athrname==$ret->AuthorName){
                                                        continue;
                                                    } else{ ?>  
                                                        <option value="<?php echo htmlentities($ret->id);?>"><?php echo htmlentities($ret->AuthorName);?></option>
                                                    <?php }}} ?> 
                                        </select>
                                    </div>  
                                    <div class="frm-group">
                                        <label for="category" name="category" >Category</label>
                                        <select class="" name="category" required="required">
                                        <?php 
                                            $status=1;
                                            $sql = "SELECT * from  tblcategory where Status=:status";
                                            $query = $dbh -> prepare($sql);
                                            $query -> bindParam(':status',$status, PDO::PARAM_STR);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0){
                                            foreach($results as $result){               ?>  
                                                <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->CategoryName);?></option>
                                            <?php }} ?> 
                                        </select>
                                    </div>  
                                    
                                    <div class="frm-group">
                                        <label for="email">ISBN</label>
                                        <input type="text" name="isbn" required>
                                    </div>
                                    
                                    <div class="frm-group">
                                        <label for="pass">Price</label>
                                        <input type="text" name="price"  required>
                                    </div>
                                    <div class="frm-group">
                                        <label for="bookpicture">Price</label>
                                        <input type="file" name="bookpic"  required>
                                    </div>
                                    <div class="text-center">
                                        <button class="signup-btn" name="add" type="submit">Submit</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>


</body>
</html>
<?php } ?> 