<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

// code for block student    
if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$status=0;
$sql = "update tblstudents set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:regstudent.php');
}



//code for active students
if(isset($_GET['id']))
{
$id=$_GET['id'];
$status=1;
$sql = "update tblstudents set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:regstudent.php');
}


    ?>
    <!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <link href="./css/dashboard.css" rel="stylesheet" />
        <link href="./css/table.css" rel="stylesheet" />

        </head>
        <body>
        <?php include('includes/header.php');?>
        <div id="demo">
        <?php $sid=$_GET['stdid']; ?>
            <h2>
                #<?php echo $sid;?> Book Issued History
            </h2>
            <!-- Responsive table starts here -->
            <!-- For correct display on small screens you must add 'data-title' to each 'td' in your table -->
            <div class="table-responsive-vertical shadow-z-1">
            <!-- Table starts here -->
            <table id="table" class="table table-hover table-mc-light-blue">
              <thead>
                <tr>
                <th>#</th>
                <!-- <th>Studnet ID</th> -->
                <th>Student Name</th>
                <th>Book Name</th>
                <th>Issued Date</th>
                <th>Returned Date</th>
                <th>Fine</th>
                </tr>
              </thead>
              <tbody>
              <?php 

$sql = "SELECT tblstudents.StudentId ,tblstudents.FullName,tblstudents.EmailId,tblstudents.MobileNumber,tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.id as rid,tblissuedbookdetails.fine,tblissuedbookdetails.RetrunStatus,tblbooks.id as bid,tblbooks.bookImage from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId where tblstudents.StudentId='$sid' ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>       
              <tr>
                <td data-title="#"><?php echo htmlentities($cnt);?></td>
                <!-- <td data-title="Student ID">
                  <?php echo htmlentities($result->StudentId);?>
                </td> -->
                <td data-title="Full Name">
                  <?php echo htmlentities($result->FullName);?>
                </td>
                <td data-title="Book Name">
                  <?php echo htmlentities($result->BookName);?>
                </td>
                <td data-title="Issued Date">
                  <?php echo htmlentities($result->IssuesDate);?>
                </td>
                <td data-title="Returned Date">
                    <?php 
                        if($result->ReturnDate==''): echo "Not returned yet";
                        else: echo htmlentities($result->ReturnDate); endif;?>
                </td>
                <td data-tilte="Fine">
                    <?php 
                        if($result->ReturnDate==''): echo "Not returned yet";
                        else: echo $result->fine; endif;?>
                </td>
              </tr>
                     <?php $cnt=$cnt+1;}} ?>                                      
    
            </tbody>
          </table>
        </div>
    </div>
        </body>
        </html>
    <?php } ?>
