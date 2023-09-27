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
                FROM products
                WHERE id = '$change_item_id'";
  $infos = mysqli_query($connect, $sql1);
  $prod = mysqli_fetch_assoc($infos);

  if( isset($_POST['category_id']) && isset($_POST['name'])
        && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['stock']) ){
       
        $category_id = $_POST['category_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
       
    //SQL-Injection verhindern
    
    $category_id = mysqli_real_escape_string($connect, $category_id);
    $name = mysqli_real_escape_string($connect, $name);
    $description = mysqli_real_escape_string($connect, $description);
    $price = mysqli_real_escape_string($connect, $price);
    $stock = mysqli_real_escape_string($connect, $stock);
    
    //2. SQL-Statement ausführen
    $sql = "UPDATE products 
            SET category_id ='$category_id',
                name = '$name',
                description = '$description',
                price = '$price',
                status = '$stock'
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
<H2 class="py-3">Change products's informations:</H2>
  <form action="change_products.php" method="post" class="form-container" style="width:50%;">
    <div class="input-group mb-3">
    <span class="input-group-text">Name</span>
      <input type="text" required="" class="form-control" placeholder="<?php echo $prod['name']?>" name="name" >
    </div>

    <div class="input-group mb-3">
    <span class="input-group-text">Price</span>
      <input type="text" required="" class="form-control" placeholder="<?php echo $prod['price']?>" name="price">
      <span class="input-group-text">&euro;</span>
    </div>

    <div class="input-group">
      <span class="input-group-text">Description</span>
      <textarea class="form-control" required="" name="description" placeholder="<?php echo $prod['description']?>"></textarea>
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
      <?php
        $categories = $connect->query("SELECT id,name FROM categories ");
        while($row=$categories->fetch_assoc()):
      ?> <!-- Loops each categogy to create table of options -->

      <option  value="<?php echo $row['id']?>"><?php echo $row['name']?></option>
      <?php endwhile;?>
    </select> 
    </div>

    <br>  
      <button id="button_change" type="submit" name="change_item_id" class="btn btn-primary" value="<?php echo $_POST["change_item_id"]?>">Change</button> 
      <button type="button" class="btn btn-secondary cancel" ><a class="link-light" style="text-decoration: none;" href="menu.php">Cancel</a></button>
        
      
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


