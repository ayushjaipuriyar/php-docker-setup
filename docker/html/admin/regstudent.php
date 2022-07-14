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
        <link href="./css/search.css" rel="stylesheet" />


        </head>
        <body>
        <?php include('includes/header.php');?>
        <div id="demo">
            <h2>
              Registered Students
            </h2>
            <div class="search-group">
        <input type="text" name="" id="searchInput" placeholder="Search Student ID" onkeyup="searchStudentID()" />
        <!-- <label for="text1">Text 1</label> -->
        <input type="text" name="" id="ISBNSearchInput" placeholder="Search Student Name" onkeyup="searchStudentName()" />
        <!-- <label for="text1">Text 1</label> -->
      </div>

            <!-- Responsive table starts here -->
            <!-- For correct display on small screens you must add 'data-title' to each 'td' in your table -->
            <div class="table-responsive-vertical shadow-z-1">
            <!-- Table starts here -->
            <table id="table" class="table table-hover table-mc-light-blue">
              <thead>
                <tr>
                <th>#</th>
                <th>Studnet ID</th>
                <th>Student Name</th>
                <th>Email ID</th>
                <th>Mobile Number</th>
                <th>Reg Date</th>
                <th>Valid/Invalid</th>
                <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php $sql = "SELECT * from tblstudents";
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
                <td data-title="Student ID">
                  <?php echo htmlentities($result->StudentId);?>
                </td>
                <td data-title="Full Name">
                  <?php echo htmlentities($result->FullName);?>
                </td>
                <td data-title="Email ID">
                  <?php echo htmlentities($result->EmailId);?>
                </td>
                <td data-title="Mobile Number">
                  <?php echo htmlentities($result->MobileNumber);?>
                </td>
                <td data-title="RegDate">
                  <?php echo htmlentities($result->RegDate);?>
                </td>
                <td class="center"><?php if($result->Status==1)
                                            {
                                                echo htmlentities("Active");
                                            } else {


                                            echo htmlentities("Blocked");
}
                                            ?></td>
                <td data-title="Action">
                <?php if($result->Status==1)
 {?>
                <a href="regstudent.php?inid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to block this student?');" >  <button class="btn btn-danger"> Inactive</button>
<?php } else {?>

<a href="regstudent.php?id=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to active this student?');"><button class="btn btn-primary"> Active</button> 
                                            <?php } ?>

<a href="studenthistory.php?stdid=<?php echo htmlentities($result->StudentId);?>"><button class="btn btn-success"> Books Issued</button> 


            </td>
              </tr>
                     <?php $cnt=$cnt+1;}} ?>                                      
    
            </tbody>
          </table>
        </div>
    </div>
    
<script>
    const searchStudentID = () => {
        let filter = document.getElementById('searchInput').value.toUpperCase();
        let table = document.getElementById('table');
        let tr = table.getElementsByTagName('tr');
        for(var i = 0; i<tr.length;i++){
            let td = tr[i].getElementsByTagName('td')[1];
            if(td){
                let textValue = td.textContent || td.innerHTML;
                if(textValue.toUpperCase().indexOf(filter) > -1){
                    tr[i].style.display = "";
                }
                else{
                    tr[i].style.display = "none";
                }
            }
        }
    }
    const searchStudentName = () => {
        let filter = document.getElementById('ISBNSearchInput').value.toUpperCase();
        let table = document.getElementById('table');
        let tr = table.getElementsByTagName('tr');
        for(var i = 0; i<tr.length;i++){
            let td = tr[i].getElementsByTagName('td')[2];
            if(td){
                let textValue = td.textContent || td.innerHTML;
                if(textValue.toUpperCase().indexOf(filter) > -1){
                    tr[i].style.display = "";
                }
                else{
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
        </body>
        </html>
    <?php } ?>
