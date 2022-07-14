<?php
    session_start();
    error_reporting(0);
    include('includes/config.php');
    if(strlen($_SESSION['alogin'])==0){   
        header('location:index.php');
    }
    else{     ?>
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
              Manage Issued Books 
              <br>
              Not Returned
            </h2>
            <div class="search-group">
        <input type="text" name="" id="studentSearch" placeholder="Search Student Name" onkeyup="searchStudentName()" />
        <!-- <label for="text1">Text 1</label> -->
        <input type="text" name="" id="searchInput" placeholder="Search Book" onkeyup="searchBookName()" />
        <!-- <label for="text1">Text 1</label> -->
        <input type="text" name="" id="ISBNSearchInput" placeholder="Search ISBN" onkeyup="searchISBN()" />
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
                <th>Studnet Name</th>
                <th>Book Name</th>
                <th>ISBN</th>
                <th>Issued Date</th>
                <th>Return Date</th>
                <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                $sql = "SELECT tblstudents.FullName,tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.id as rid from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId order by tblissuedbookdetails.id desc";
                $query = $dbh -> prepare($sql);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);
                $cnt=1;
                if($query->rowCount() > 0){
                    foreach($results as $result){               ?>      
              <tr>
                <td data-title="#"><?php echo htmlentities($cnt);?></td>
                <td data-title="Full Name">
                  <?php echo htmlentities($result->FullName);?>
                </td>
                <td data-title="Book Name">
                  <?php echo htmlentities($result->BookName);?>
                </td>
                <td data-title="ISBN">
                  <?php echo htmlentities($result->ISBNNumber);?>
                </td>
                <td data-title="Issue Date">
                  <?php echo htmlentities($result->IssuesDate);?>
                </td>
                <td data-tittle="Return Date"><?php if($result->ReturnDate=="")
                                            {
                                                echo htmlentities("Not Return Yet");
                                            } else {


                                            echo htmlentities($result->ReturnDate);
}
                                            ?></td>
                <td data-title="Action">
                <a href="managebooks.php?del=<?php echo htmlentities($result->bookid);?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button>Delete</button>

            </td>
              </tr>
                     <?php $cnt=$cnt+1;}} ?>                                      
    
            </tbody>
          </table>
        </div>
    </div>
    <script>
      const searchStudentName = () => {
        let filter = document.getElementById('studentSearch').value.toUpperCase();
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
    const searchBookName = () => {
        let filter = document.getElementById('searchInput').value.toUpperCase();
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
    const searchISBN = () => {
        let filter = document.getElementById('ISBNSearchInput').value.toUpperCase();
        let table = document.getElementById('table');
        let tr = table.getElementsByTagName('tr');
        for(var i = 0; i<tr.length;i++){
            let td = tr[i].getElementsByTagName('td')[3];
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
