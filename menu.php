
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
  include("db_connect.php");

  include("partials/header.php");
  include("partials/sidebar.php");


  //Once delete button is clicked => make delete request database
  if( isset($_POST['del_item']) ){
    $id = $_POST['del_item'];
   
    $id = mysqli_real_escape_string($connect, $id);

    $sql = "DELETE 
            FROM products 
            WHERE id='$id'";
    
    $resultset = mysqli_query($connect, $sql);
  }
?>

<!-- /////////////////  HTML- PARTS  ////////////////////// -->

<!--    Navi of categories and table of products' details   -->
<div class="text-end" style="padding: 100px 3% 0% 3%;">
<a class="btn btn-primary" href="add_products.php" >
						<i class="fa fa-plus"></i> Add Product </a>
</div>
<!-- ////////////    SPYSCROLL PART     ///////// -->
<div class="wrapper">
<div class="row" style="padding: 2% 3%;" >
  <div class="col-4">
    <div id="list-example" class="list-group">
      <?php
        $categories = $connect->query("SELECT id, name FROM categories ");
        while($row=$categories->fetch_assoc()):
      ?>
      <a class="list-group-item list-group-item-action" href="#<?php echo $row['name']?>"><?php echo $row['name'] ?></a>
      <?php endwhile; ?>
    </div>
  </div>
  
  <div class="col-8" >
    <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" class="scrollspy-example" style="max-height: 80vh; overflow:scroll;" tabindex="0">
    <?php
          $categories = $connect->query("SELECT id, name FROM categories ");
            while($row=$categories->fetch_assoc()):
    ?> <!-- Loops each categogy -->
    <div class="p-3 my-4 border border-dark rounded" style="max-width:100%; overflow-x:scroll;">
    <h4 id="<?php echo $row['name']?>"><?php echo $row['name']?></h4>
    <br>
    <?php $id = mysqli_real_escape_string($connect, $row['id']);
        
        $products = $connect->query("SELECT * FROM products WHERE category_id = '$id' ");
        $num = mysqli_num_rows($products);
        if($num >0):?>
    <table class="table table-hover">
      <div style="max-width: 65vw; overflow:scroll;">
		<thead>
			<tr>
				<th>No.</th>
				<th>Name</th>
				<th>Description</th>
				<th>Price</th>
                <th>Instock</th>
                <th>Actions</th>
				</tr>
		</thead>
        <!-- ////////////// -->
        <tbody>
        <?php
        $i = 1;
        
                while($row_product=$products->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td>
                                        <p> <?php echo $row_product['name'] ?></p>
                                    </td>
                                    <td>
                                        <p> <?php echo $row_product['description'] ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo $row_product['price'] ?></p>
                                    </td>
                                    <td class="text-center">
                                        <?php if($row_product['status'] > 0): ?>
                                            <i class="fa-solid fa-circle-check fa-xl" style="color: #00a31a;"></i>
                                        <?php else: ?>
                                            <i class="fa-solid fa-square-xmark fa-xl" style="color: #b31d2f;"></i>
                                        <?php endif; ?>
                                    </td>  
                                    <td class="text-left">
                                    <form action="change_products.php" method="post" >
                                      <button class="btn btn-sm btn-primary open-button" type="submit" name="change_item_id" value="<?php echo $row_product['id']?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                    </form>
                                    <form action="menu.php" method="post" >
                                      <button class="btn btn-sm btn-danger" type="submit" name="del_item" value="<?php echo $row_product['id']?>"><i class="fa fa-trash-alt"></i></button>
                                    </form>             
										</td> 
                                </tr>
                                <?php endwhile; ?>
                    <?php else: ?>
                        <p>No result founded</p>
                        <?php endif; ?>
        </tbody>
        </div>
      </table> <!-- End Loops each categogy -->
      </div>
      <?php endwhile; ?>
      
    </div>
  </div>
  </div>
</div>

<!-- ///////////    FOOTER    //////////// -->
<?php
    include("partials/footer.php");
?>


