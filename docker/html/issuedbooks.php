<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 



    ?>
<!DOCTYPE html>
<html>
<head>
    <link href="./assets/css/dashboard.css" rel="stylesheet" />
    <link href="./assets/css/search.css" rel="stylesheet" />
    <link href="./assets/css/table.css" rel="stylesheet" />
    
</head>
<body>
<style>
    .container{
        display: flex;
        padding: 5%;
  justify-content: center;
  margin: 10% 0% 0% 15%;
  align-items: center;
        border-radius: 30%;
        background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 14px 28px rgb(0 0 0 / 25%), 0 10px 10px rgb(0 0 0 / 22%);
    width: 70%;
    }
</style>

<?php include('includes/header.php');?>
<div id="demo">
          <h2>
            Issued Book List
          </h2>
          <div class="search-group">
        <input type="text" name="" id="searchInput" placeholder="Search Book Name" onkeyup="searchBookName()" />
        <!-- <label for="text1">Text 1</label> -->
        <input type="text" name="" id="ISBNSearchInput" placeholder="Search ISBN" onkeyup="searchISBN()" />
        <!-- <label for="text1">Text 1</label> -->
      </div>
            
        <!-- Responsive table starts here -->
        <!-- For correct display on small screens you must add 'data-title=""' to each 'td' in your table -->
        <div class="table-responsive-vertical shadow-z-1">
        <!-- Table starts here -->
        <table id="table" class="table table-hover table-mc-light-blue">
          <thead>
            <tr>
            <th>#</th>
            <th>Book Name</th>
            <th>ISBN</th>
            <th>Issued Date</th>
            <th>Reg Date</th>
            <th>Fine</th>
            </tr>
          </thead>
          <tbody>
                <?php 
$sid=$_SESSION['stdid'];
$sql="SELECT tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.id as rid,tblissuedbookdetails.fine from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId where tblstudents.StudentId=:sid order by tblissuedbookdetails.id desc";
$query = $dbh -> prepare($sql);
$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
                <tr >
                                            <td data-title="#"><?php echo htmlentities($cnt);?></td>
                                            <td data-title="Book Name"><?php echo htmlentities($result->BookName);?></td>
                                            <td data-title="ISBN"><?php echo htmlentities($result->ISBNNumber);?></td>
                                            <td data-title="Issue Date"><?php echo htmlentities($result->IssuesDate);?></td>
                                            <td data-title="Returned Date"><?php if($result->ReturnDate=="")
                                            {?>
                                            <span style="color:red">
                                             <?php   echo htmlentities("Not Return Yet"); ?>
                                                </span>
                                            <?php } else {
                                            echo htmlentities($result->ReturnDate);
                                        }
                                            ?></td>
                                              <td data-title="Fine"><?php echo htmlentities($result->fine);?></td>
                                         
                                        </tr>
 <?php $cnt=$cnt+1;}} ?>                                      
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- <?php include('includes/footer.php');?> -->
<script>
    const searchBookName = () => {
        let filter = document.getElementById('searchInput').value.toUpperCase();
        let myTable = document.getElementById('table');
        let tr = myTable.getElementsByTagName('tr');
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
    const searchISBN = () => {
        let filter = document.getElementById('ISBNSearchInput').value.toUpperCase();
        let myTable = document.getElementById('table');
        let tr = myTable.getElementsByTagName('tr');
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
