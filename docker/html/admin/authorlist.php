<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{
if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from tblauthors  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$_SESSION['delmsg']="Author deleted";
header('location:authorlist.php');

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
    Manage Authors
    </h2>
    <div class="search-group">
        <input type="text" name="" id="searchInput" placeholder="Search Author Name" onkeyup="searchAuthorName()" />
        <!-- <label for="text1">Text 1</label> -->
        
      </div>
      <button>
          <a href="addauthor.php">

          New Author 
        </a>
      </button>
            <!-- Responsive table starts here -->
            <!-- For correct display on small screens you must add 'data-title' to each 'td' in your table -->
            <div class="table-responsive-vertical shadow-z-1">
            <!-- Table starts here -->
            <table id="table" class="table table-hover table-mc-light-blue">
              <thead>
                <tr>
                <th>#</th>
                                    <th>Author</th>
                                    <th>Creation Date</th>
                                    <th>Updation Date</th>
                                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php $sql = "SELECT * from  tblauthors";
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
                  <?php echo htmlentities($result->AuthorName);?>
                </td> -->
                <td data-title="Full Name">
                  <?php echo htmlentities($result->AuthorName);?>
                </td>
                <td data-title="Book Name">
                  <?php echo htmlentities($result->creationDate);?>
                </td>
                <td data-title="Issued Date">
                  <?php echo htmlentities($result->UpdationDate);?>
                </td>
                <td data-title="Action">
                        <a href="edit-author.php?athrid=<?php echo htmlentities($result->id);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> 
                                          <a href="authorlist.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button class="btn btn-danger"><i class="fa fa-pencil"></i> Delete</button>
                                           

            </td>
              </tr>
                     <?php $cnt=$cnt+1;}} ?>                                      
    
            </tbody>
          </table>
        </div>
    </div>
    <script>
    const searchAuthorName = () => {
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
    </script>
        </body>
        </html>
    <?php } ?>
