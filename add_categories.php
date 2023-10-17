<?php
  //----------------------------------------------------------------------------
  //--------            SOFTWARE DEVELOPED BY PHUONG ANH NGO        ------------
  //----------------------------------------------------------------------------

  ///////////    HEADER + NAVBAR + PHP-Functions    //////////// 
  //Start session, add necessary files
  session_start();
  if(!isset( $_SESSION['benutzer_id'])){
    header("Location:index.php");
  } 

  include("partials/header.php");
  include("partials/sidebar.php");

  include("db_connect.php"); //connect to database

  $alert = ""; //To return alert when error occurs

  //Once formular is fully filled and submit => send request (add new data) to database
  if( isset($_POST['cat_name']) && isset($_POST['cat_description'])){
    $category = htmlspecialchars(trim($_POST['cat_name']));
    $description = htmlspecialchars(trim($_POST['cat_description']));

    $category = mysqli_real_escape_string($connect, $category);
    $description = mysqli_real_escape_string($connect, $description);
    $sql = "INSERT categories
            SET name = '$category',
            description = '$description' "; 

    mysqli_query($connect, $sql);

    if($sql_fehler = mysqli_error($connect)){
      echo $sql_fehler;
    }
    else{
      $alert = "Data is successfully added!";
    }
  }
  

  
?>

<!-- /////////////////  HTML- PARTS  ////////////////////// -->

<!--    Formular to add new category   -->
<div class="container-fluid p-5 mt-5">
  <h2 class ="py-3">Add new categoty</h1>
  <br><br>
    <form action="add_categories.php" method="post">
    <div class="row g-3">  
            <div class="col-6">
              <label for="cat_name" class="form-label">Category's name</label>
              <div class="input-group has-validation">
                <input type="text" class="form-control" id="cat_name" name="cat_name"  required="" >
              <div class="invalid-feedback">
                  A name is required!
                </div>
              </div>
            </div>

                  
          </div>
      <br>
          <div class="row gy-3">
            <div class="col-6">
              <label for="cc-name" class="form-label">Description</label>
              <input type="textarea" class="form-control" name="cat_description"  required="">
              
              <div class="invalid-feedback">
                Description is required!
              </div>
            </div>
          </div>
          
<br>
          <div class="col-2">
          <button class="w-100 btn btn-primary" type="submit" ><i class="fa fa-plus"></i> Add</button>
          </div>

          <br>
          <?php 
            if(!empty($alert))
              echo "<p style=\"color:blue\"><i class=\"fa-solid fa-circle-check fa-beat fa-xl\" style=\"color: #006f1a;\"></i> $alert</p>"; ?>

    </form>
</div>

<!-- ///////////    FOOTER    //////////// -->
<?php
    include("partials/footer.php");
?>
