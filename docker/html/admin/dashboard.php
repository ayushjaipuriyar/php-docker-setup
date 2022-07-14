<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
  { 
header('location:index.php');
}
else{?>
<!DOCTYPE html>
<html>

<head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link href="./css/dashboard.css" rel="stylesheet" />
</head>
<body>
<?php include('includes/header.php');?>

<span class="hero">
<h2>

  Admin Dashboard
</h2>
</span>
<div class="container">
  <a href="managebooks.php">
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
  <a href="manageissuedbooks.php">
    <div class="card">
    <span class="material-icons" id="material-icons">
      recycling
    </span>
    <p>
    <?php 
$sql2 ="SELECT id from tblissuedbookdetails where (RetrunStatus='' || RetrunStatus is null)";
$query2 = $dbh -> prepare($sql2);
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
  <a href="regstudent.php">
    <div class="card">
    <span class="material-icons" id="material-icons">
people_alt
</span>
<p>
<?php 
$sql3 ="SELECT id from tblstudents ";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
$regstds=$query3->rowCount();
?>
                            <h3><?php echo htmlentities($regstds);?></h3>
<h3>  Registered Users
</h3>
</p>

</div>
    </a>
<a href="authorlist.php">
    <div class="card">
<span class="material-icons" id="material-icons">
person
</span>
<p>
<?php 
$sq4 ="SELECT id from tblauthors ";
$query4 = $dbh -> prepare($sq4);
$query4->execute();
$results4=$query4->fetchAll(PDO::FETCH_OBJ);
$listdathrs=$query4->rowCount();
?>
<h3><?php echo htmlentities($listdathrs);?></h3>
<h3>  Authors list
</h3>
</p>

</div>
    </a>



</div>
</body>

</html>
<?php } ?>