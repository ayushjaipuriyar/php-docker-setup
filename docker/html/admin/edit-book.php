<?php
    session_start();
    error_reporting(0);
    include('includes/config.php');
    if(strlen($_SESSION['alogin'])==0){   
        header('location:index.php');
    }
    else{ 
    if(isset($_POST['update'])){
        $bookname=$_POST['bookname'];
        $category=$_POST['category'];
        $author=$_POST['author'];
        $isbn=$_POST['isbn'];
        $price=$_POST['price'];
        $bookid=intval($_GET['bookid']);
        $sql="update  tblbooks set BookName=:bookname,CatId=:category,AuthorId=:author,BookPrice=:price where id=:bookid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookname',$bookname,PDO::PARAM_STR);
        $query->bindParam(':category',$category,PDO::PARAM_STR);
        $query->bindParam(':author',$author,PDO::PARAM_STR);
        $query->bindParam(':price',$price,PDO::PARAM_STR);
        $query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Book info updated successfully');</script>";
        echo "<script>window.location.href='managebooks.php'</script>";
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
                        <?php 
                                $bookid=intval($_GET['bookid']);
                                $sql = "SELECT tblbooks.BookName,tblcategory.CategoryName,tblcategory.id as cid,tblauthors.AuthorName,tblauthors.id as athrid,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.id as bookid,tblbooks.bookImage from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId where tblbooks.id=:bookid";
                                $query = $dbh -> prepare($sql);
                                $query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=1;
                                if($query->rowCount() > 0){
                                    foreach($results as $result){               ?> 
                            <div class="inner">
                                <img src="bookimg/<?php echo htmlentities($result->bookImage);?>" width="100" class="frm_user_avatar">
                                    <!-- <a href="change-bookimg.php?bookid=<?php echo htmlentities($result->bookid);?>">Change Book Image</a> -->
                            </div>
                        </div>
                        <div class="frm-signup">
                            <div class="inner">
                                <form role="form" method="post">
                                    <div class="frm-group">
                                        <label for="userName">Book Name</label>
                                        <input type="text" name="bookname" value="<?php echo htmlentities($result->BookName);?>" required>
                                    </div>
                                    
                                    <div class="frm-group">
                                        <label for="author" name="author" >Author</label>
                                        <select class="" name="author" required="required">
                                        <option value="<?php echo htmlentities($result->athrid);?>"><?php echo htmlentities($arthname=$result->AuthorName);?></option>
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
                                        <label for="cateogry" name="cateogry" >Cateogry</label>
                                        <select class="" name="cateogry" required="required">
                                        <option value="<?php echo htmlentities($result->athrid);?>"><?php echo htmlentities($arthname=$result->AuthorName);?></option>
                                        <?php 
                                            $status=1;
                                            $sql1 = "SELECT * from  tblcategory where Status=:status";
                                            $query1 = $dbh -> prepare($sql1);
                                            $query1-> bindParam(':status',$status, PDO::PARAM_STR);
                                            $query1->execute();
                                            $resultss=$query1->fetchAll(PDO::FETCH_OBJ);
                                            if($query1->rowCount() > 0){
                                                foreach($resultss as $row){           
                                                    if($catname==$row->CategoryName){
                                                        continue;
                                                    }
                                                    else{   ?>  
                                            <option value="<?php echo htmlentities($row->id);?>"><?php echo htmlentities($row->CategoryName);?></option>
                                            <?php }}} ?> 
                                        </select>
                                    </div>  
                                    

                                    <div class="frm-group">
                                        <label for="email">ISBN</label>
                                        <input type="text" name="isbn" value="<?php echo htmlentities($result->ISBNNumber);?>"  readonly required>
                                    </div>
                                    
                                    <div class="frm-group">
                                        <label for="pass">Price</label>
                                        <input type="text" name="price" value="<?php echo htmlentities($result->BookPrice);?>" required>
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
