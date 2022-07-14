<?php
  session_start();
  error_reporting(0);
  include('includes/config.php');
    if(strlen($_SESSION['alogin'])==0){   
      header('location:index.php');
    }
    else{ 
      if(isset($_GET['del'])){
        $id=$_GET['del'];
        $sql = "delete from tblbooks  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':id',$id, PDO::PARAM_STR);
        $query -> execute();
        $_SESSION['delmsg']="Category deleted scuccessfully ";
        header('location:managebooks.php');
      }?>
    <!DOCTYPE html>
    <html>
      <head>
        <link href="./css/dashboard.css" rel="stylesheet" />
        <link href="./css/table.css" rel="stylesheet" />
        <link href="./css/search.css" rel="stylesheet" />
      </head>
      <body>
        <style>
      
        </style>
        <?php include('includes/header.php');?>
        <div id="demo">
          <h2>
            Book List
          </h2>
          <div class="search-group">
        <input type="text" name="" id="searchInput" placeholder="Search Book Name" onkeyup="searchBookName()" />
        <!-- <label for="text1">Text 1</label> -->
        <input type="text" name="" id="ISBNSearchInput" placeholder="Search ISBN" onkeyup="searchISBN()" />
        <!-- <label for="text1">Text 1</label> -->
      </div>
      <button><a href="addbook.php">
        Add Book
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
            <th>Book Name</th>
            <th>Category</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Price</th>
            <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $sql = "SELECT tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.id as bookid,tblbooks.bookImage from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId";
              $query = $dbh -> prepare($sql);
              $query->execute();
              $results=$query->fetchAll(PDO::FETCH_OBJ);
              $cnt=1;
              if($query->rowCount() > 0){
                foreach($results as $result){               ?>    
          <tr>
            <td data-title="#"><?php echo htmlentities($cnt);?></td>
            <td data-title="Book Name" width="100">
              <img src="bookimg/<?php echo htmlentities($result->bookImage);?>" width="100">
              <br />
              <b><?php echo htmlentities($result->BookName);?></b>
            </td>
            <td data-title="Category">
              <?php echo htmlentities($result->CategoryName);?>
            </td>
            <td data-title="Author Name">
              <?php echo htmlentities($result->AuthorName);?>
            </td>
            <td data-title="ISBN">
              <?php echo htmlentities($result->ISBNNumber);?>
            </td>
            <td data-title="Price">
              <?php echo htmlentities($result->BookPrice);?>
            </td>
            <td data-title="Action">
              <a href="edit-book.php?bookid=<?php echo htmlentities($result->bookid);?>"><button>       Edit</button> 
              <br><br><br><br>
              <a href="managebooks.php?del=<?php echo htmlentities($result->bookid);?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button>Delete</button>
            </td>
          </tr>
                 <?php $cnt=$cnt+1;}} ?>                                      

        </tbody>
      </table>
    </div>
</div>


<script>
    const searchBookName = () => {
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
    const searchISBN = () => {
        let filter = document.getElementById('ISBNSearchInput').value.toUpperCase();
        let table = document.getElementById('table');
        let tr = table.getElementsByTagName('tr');
        for(var i = 0; i<tr.length;i++){
            let td = tr[i].getElementsByTagName('td')[4];
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
