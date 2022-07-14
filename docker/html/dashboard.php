<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{?>

<!DOCTYPE html>
<html>

<head>
    <!-- <link href="./assets/css/dashboard.css" rel="stylesheet" /> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link href="admin\css\dashboard.css" rel="stylesheet" />
</head>
<body>
<?php include('includes/header.php');?>

<span class="hero">
<h2>

  Student Dashboard
</h2>
</span>
<div class="container">
  <a href="booklist.php">
    <div class="card">
    <span class="material-icons" id="material-icons">
      library_books
    </span>
    <p>
    <?php 
$sql ="SELECT id from tblbooks ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$listdbooks=$query->rowCount();
?>
<h3><?php echo htmlentities($listdbooks);?></h3>
    <h3>  List of Books
</h3> 
    </p>
    </div>
  </a>
  <a href="#">
    <div class="card">
    <span class="material-icons" id="material-icons">
block
</span>
    </span>
    <p>
    <?php 
$rsts=0;
 $sid=$_SESSION['stdid'];
$sql2 ="SELECT id from tblissuedbookdetails where StudentID=:sid and (RetrunStatus=:rsts || RetrunStatus is null || RetrunStatus='')";
$query2 = $dbh -> prepare($sql2);
$query2->bindParam(':sid',$sid,PDO::PARAM_STR);
$query2->bindParam(':rsts',$rsts,PDO::PARAM_STR);
$query2->execute();
$results2=$query2->fetchAll(PDO::FETCH_OBJ);
$returnedbooks=$query2->rowCount();
?>

                            <h3><?php echo htmlentities($returnedbooks);?></h3>
    <h3>  Books not returned
</h3>
    </p>
    </div>
  </a>
  <a href="issuedbooks.php">
    <div class="card">
    <span class="material-icons" id="material-icons">
      recycling
    </span>
    <p>           <br>           
    <h3>  Issued Books History
</h3>
    </p>
    </div>
  </a>



</div>
</body>

</html>
<?php } ?>