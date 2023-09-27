<?php
 //----------------------------------------------------------------------------
  //--------            SOFTWARE DEVELOPED BY PHUONG ANH NGO        ------------
  //----------------------------------------------------------------------------
  session_start();
  if(!isset( $_SESSION['benutzer_id'])){
    header("Location:index.php");
  } 
  include("partials/header.php");
  include("partials/sidebar.php");

  include("db_connect.php");

  $alert ="";
  $change_item_id = $_POST['change_item_id'];
  $change_item_id = mysqli_real_escape_string($connect, $change_item_id);

  //Old informations
  $sql1 = "SELECT *
            FROM categories
            WHERE id = '$change_item_id'";
    $infos = mysqli_query($connect, $sql1);
    $prod = mysqli_fetch_assoc($infos);

    if( isset($_POST['category']) && isset($_POST['description']) ){
        $category = $_POST['category'];
        $description = $_POST['description'];
        
        
       
    //SQL-Injection verhindern
    $category = mysqli_real_escape_string($connect, $category);
    $description = mysqli_real_escape_string($connect, $description);
    
    

    //2. SQL-Statement ausführen
    $sql = "UPDATE categories 
            SET name ='$category',
                description = '$description'
            WHERE id='$change_item_id'";

    $resultset = mysqli_query($connect, $sql);

    if(!$resultset) {
        //SQL-Fehler ausgeben
      die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");
    }  
    else{
        $alert = "Category is successfully changed!";
    } 
    }
    
?>

<!-- /////////////////////////////////////////////////////// -->
<div class="container-fluid p-5 mt-5">
<H2 class="py-3">Change category's informations:</H2>
    <form action="change_category.php" method="post" class="form-container" style="width:50%;">
    <div class="input-group mb-3">
    <span class="input-group-text">Category's name</span>
      <input type="text" required="" class="form-control" placeholder="<?php echo $prod['name']?>" name="name" >
    </div>

    <div class="input-group">
      <span class="input-group-text" >Description</span>
      <textarea  required="" class="form-control" name="description" placeholder="<?php echo $prod['description']?>"></textarea>
    </div>

    <br>  
    <button type="submit" name="change_item_id" class="btn btn-primary" value="<?php echo $_POST["change_item_id"]?>">Change</button>
            <button type="button" class="btn btn-secondary cancel" ><a class="link-light" style="text-decoration: none;" href="categories.php">Cancel</a></button>
  </form>
        <br>
        <?php 
            if(!empty($alert))
              echo "<p style=\"color:blue\"><i class=\"fa-solid fa-circle-check fa-beat fa-xl\" style=\"color: #006f1a;\"></i> $alert</p>"; ?>
</div>




<!-- /////////////////////////////////////////////////////// -->

<?php
    include("partials/footer.php");
?>