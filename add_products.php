<?php
 /*----------------------------------------------------------------------------
   --------            SOFTWARE DEVELOPED BY PHUONG ANH NGO        ------------
   ----------------------------------------------------------------------------*/

  ///////////    HEADER + NAVBAR + PHP-Functions    //////////// 
  //Start session, add necessary files
  session_start();
  if(!isset( $_SESSION['benutzer_id'])){
    header("Location:index.php");
  } 
  include("partials/header.php");
  include("partials/sidebar.php");

  include("db_connect.php"); //connect to database

  $alert =""; //To return alert when error occurs
  
  //Once formular is fully filled and submit => send request (add new data) to database
    if( isset($_POST['category_id']) && isset($_POST['name'])
        && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['stock']) ){
        $category_id = $_POST['category_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
       
    $category_id = mysqli_real_escape_string($connect, $category_id);
    $name = mysqli_real_escape_string($connect, $name);
    $description = mysqli_real_escape_string($connect, $description);
    $price = mysqli_real_escape_string($connect, $price);
    $stock = mysqli_real_escape_string($connect, $stock);
    
    $sql = "INSERT products 
            SET category_id ='$category_id',
                name = '$name',
                description = '$description',
                price = '$price',
                status = '$stock'";

    $resultset = mysqli_query($connect, $sql); 

    //result
    if(!$resultset) {
      die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");
    }  
    else{
        $alert = "Category is successfully added!";
    } 
    }
    
?>

<!-- /////////////////  HTML- PARTS  ////////////////////// -->

<!--    Formular to add new product's infos   -->
<div class="container-fluid p-5 my-5">
    <h2 class ="py-3">Add a new product</h2>
  <form action="add_products.php" method="post" class="form-container" style="width:50%;">
    <div class="input-group mb-3 ">
    <span class="input-group-text">Name</span>
      <input type="text" class="form-control" placeholder="New name" name="name" required="">
    </div>

    <div class="input-group mb-3 ">
    <span class="input-group-text">Price</span>
      <input type="text" class="form-control" name="price" required="">
      <span class="input-group-text">&euro;</span>
      
    </div>

    <div class="input-group mb-3 ">
      <span class="input-group-text ">Description</span>
      <textarea class="form-control" name="description" required=""></textarea>
    </div>
<br>
    <div class="input-group">
    <span class="input-group-text">Status</span>
    <select name="stock"  class="form-select" aria-label="Default select example" required>
      <option  value="1">Instock</option>
      <option  value="0">Outstock</option>
    </select> 
    </div>
<br>

<div class="input-group">
    <span class="input-group-text">Category</span>
    <select name="category_id"  class="form-select" aria-label="Default select example" required>
      <!-- Loops each categogy to create table of options -->
      <?php 
        $categories = $connect->query("SELECT id,name FROM categories ");
        while($row=$categories->fetch_assoc()):
      ?> 

      <option  value="<?php echo $row['id']?>"><?php echo $row['name']?></option>
      <?php endwhile;?>
    </select> 
    </div>

    <br>  
      <button id="button_change" type="submit"  class="btn btn-primary" >Sumit</button> 
      <button type="button" class="btn btn-secondary cancel" ><a class="link-light" style="text-decoration: none;" href="menu.php">Cancel</a></button>
        
      
  </form>
            <br>
  <?php 
    if(!empty($alert))
        echo "<p style=\"color:blue\"><i class=\"fa-solid fa-circle-check fa-beat fa-xl\" style=\"color: #006f1a;\"></i> $alert</p>"; ?>
</div>

<!-- ///////////    FOOTER    //////////// -->
<?php
    include("partials/footer.php");
?>


