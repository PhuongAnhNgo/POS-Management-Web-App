<?php
  //----------------------------------------------------------------------------
  //--------            SOFTWARE DEVELOPED BY PHUONG ANH NGO        ------------
  //----------------------------------------------------------------------------
  session_start();
  if(!isset( $_SESSION['benutzer_id'])){
    //Checking if user has already logged in or not
    header("Location:index.php");
  } 

  include("db_connect.php");
  
  include("partials/header.php");
  include("partials/sidebar.php");

  //---- Save id of order and table number in variables ----
  $order_id = "";
  $table_num = "";

  if(isset($_POST['table_id'])){
    $order_id = htmlspecialchars($_POST['table_id']);

    $sql = "SELECT table_num 
            FROM orders 
            WHERE id ='$order_id' ";
    $result = mysqli_query($connect, $sql);

    if(!$result) {
      die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");
    }  
    else{
      $row1 = mysqli_fetch_assoc($result);
      $table_num = $row1['table_num'];
    } 
  }
  elseif(isset($_SESSION['table_num'])){
    $table_num = htmlspecialchars($_SESSION['table_num']);
    $table_num = mysqli_real_escape_string($connect, $table_num);

    $sql = "SELECT id 
            FROM orders 
            WHERE table_num ='$table_num'
            AND status = '0' ";
    $resultset = mysqli_query($connect, $sql);

    if(!$resultset) {
      die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");
    }  
    else{
      $row = mysqli_fetch_assoc($resultset);
      $order_id = $row['id'];
     
    } 
  }  
?>

<!-- /////////////////////////////////////////////////////// -->

  <div class="row px-5 py-5 my-4 ">
    <!-- -- Start Menu Page-- -->
    <div id="content" class = "col-md-5 border border-dark py-3  m-3 rounded" >
        <!-- -- Navi Buttons Categories-- -->
        <?php
          $categories = $connect->query("SELECT id,name FROM categories order by id asc ");
          while($row = $categories->fetch_assoc()):
        ?>
        <button id="category_btn" type="button" class="btn btn-outline-primary m-1" value="<?php echo $row['id']?>" data-value="<?php echo $order_id?>"><?php echo $row['name']?></button>
        <?php endwhile; ?>
        <!-- -- End Navi Buttons Categories-- -->
        <br>
        <!-- -- Products follows categories // AJAX -- -->
        <div id="product_menu" class="py-3" style="height:50vh;overflow: scroll;">
          <?php
            $sql = "SELECT min(id) FROM categories ";
            $result = mysqli_query($connect, $sql);
            $row = mysqli_fetch_assoc($result);
            $category_id = $row['min(id)'];

            $products = $connect->query("SELECT id,name FROM products where category_id= '$category_id' ");
            while($rows = $products->fetch_assoc()):
          ?>
          <button id="btn-items" class="btn btn-warning" type="button" 
                    value="<?php echo $rows['id']?>" data-value="<?php echo $order_id?>"><?php echo $rows['name']?></button>
          
          <?php endwhile; ?>
        </div>
        <!-- -- End Products follows categories-- -->
    </div>
    <!-- -- End Menu Page-- -->

    <!-- -- Start See Details Page -- AJAX -->
    <div id="content" class = "col-md-5 border border-dark py-3 m-3 rounded" >
      <h2>Table <?php echo $table_num?></h2>

           <!-- -- Start See Details -- AJAX -->
          <div id="order_details">
            <div style="height:50vh;overflow: scroll;">
          <table class="table table-hover" >
				<thead>
					<tr>
						<th class="py-3">No.</th>
						<th class="py-3">Name</th>
						<th class="py-3">Qty.</th>
						<th class="py-3">Amount</th>
            <th class="py-3">Action</th>
					</tr>
				</thead>
    
        <tbody class="table-group-divider">
          
            <?php 
              $i = 1;
              $productlist = $connect->query("SELECT * FROM order_items WHERE order_id = '$order_id' ");
              while($row = $productlist->fetch_assoc()):   
            ?>
            <tr>
									<td class="text-left"><?php echo $i++ ?></td>
									<td class="">
                  <?php  
                      $id = $row['product_id'];
                      $sql = "SELECT id, name FROM products where id = '$id' ";
                      $result = mysqli_query($connect, $sql);
                      $res = mysqli_fetch_assoc($result);  
                      echo $res['name']
                    ?>
                  </td>
									<td><?php echo $row['qty'] ?></td>
                  <td><?php echo $row['amount'] ?></td>
									<td class="text-left">    
                  <button id="delete_product" class="btn btn-sm btn-danger" type="button" value="<?php echo $row['product_id']?>" data-value="<?php echo $order_id?>" ><i class="fa fa-trash-alt"></i></button>
                </td>
								</tr>
            <?php endwhile; ?>
            </tbody>
            </table>
            </div>
       
          <!-- -- End See Details -- AJAX -->
        <br>
      

      <!-- -- Start Total -- AJAX -->
      <h3>Total:
      
          <?php
          $sql = "SELECT total_amount FROM orders where id = '$order_id' ";
          $result = mysqli_query($connect, $sql);
          $row = mysqli_fetch_assoc($result);
          
          echo $row['total_amount']
          ?><span>&euro;</span> 
    
      </h3>
      </div>
      <!-- -- End Total -- AJAX -->

      
      <button id="btn-paid" class="btn btn-lg btn-success px-5" name="paid" value="<?php echo $order_id?>" >Paid</button>
     
    </div>
    <!-- -- End See Details Page-- -->
  </div>
  



<!-- /////////////////////////////////////////////////////// -->

<!-- ___________________________________________________
                            FOOTER-CONTAINER 
          ___________________________________________________ -->
          </div>
    </div>
</div>          

         

<!-- JavaScript at the bottom for fast page loading -->
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
  integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD"
  crossorigin="anonymous"
></script>
<script
  src="https://code.jquery.com/jquery-3.6.4.js"
  integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
  crossorigin="anonymous"
></script>
<script src="js/index.js"></script>
<script>

$(document).ready(function(){
  $(document).on('click', 'button#category_btn', function(event) {
    var cat_id = $(this).attr("value");
    var order_id = $(this).attr("data-value");
    $("#product_menu").load("load_items.php",{
      catNewId : cat_id,
      orderId: order_id
    });
  });

  $(document).on('click', 'button#delete_product', function(event) {
    var product_id = $(this).attr("value");
    var order_id = $(this).attr("data-value");

    $("#order_details").load("load_details.php",{
      itemId : product_id,
      orderId : order_id
    });
  });

  $(document).on('click', 'button#btn-items', function(event) {
    var product_id = $(this).attr("value");
    var order_id = $(this).attr("data-value");

    $("#order_details").load("add_details.php",{
      itemId : product_id,
      orderId : order_id
    });
  });

  $(document).on('click', 'button#btn-paid', function(event) {
    var order_id = $(this).attr("value");

    var nw = window.open('./print_bill.php?id='+order_id,"_blank","width=900,height=600");               
    setTimeout(function(){
                                nw.print()
                                setTimeout(function(){
                                    nw.close()
                                    //location.reload()
                                    location.href='tables.php';
                                },500)
                            },500)
  });

});


</script>
</body>
</html>


