<?php
  //----------------------------------------------------------------------------
  //--------            SOFTWARE DEVELOPED BY PHUONG ANH NGO        ------------
  //----------------------------------------------------------------------------

  ///////////    HEADER + NAVBAR + PHP-Functions    //////////// 
  //Start session, add necessary files
    session_start();
    if(!isset( $_SESSION['benutzer_id'])){
        //Checking if user has already logged in or not
        header("Location:index.php");
    } 

    include("db_connect.php"); //connect to database
    include("partials/header.php");

    $id = $_GET['id'];

    $sql = "SELECT * FROM orders where id = '$id' ";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
   
    $total = $row['total_amount'];
    $datum = $row['date_created'];
    $table = $row['table_num'];

    $sql1 = "UPDATE orders 
            SET status ='1'
            WHERE id='$id'";

    $resultset = mysqli_query($connect, $sql1);

    if(!$resultset) {
        die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");
    }  
    
?>

<!-- /////////////////  HTML- PARTS  ////////////////////// -->

<!--    Bill Sample   -->
<div class="p-4">
<h3 class="text-center">Bill</h3>
<br>
<p><b>Bill Number: </b> <?php echo $id ?></p>
<p><b>Date: </b><?php echo $datum ?></p>
<p><b>Table: </b><?php echo $table ?></p>
<table class="table table-hover " >
				<thead>
					<tr>
						<th class="py-3">No.</th>
						<th class="py-3">Name</th>
						<th class="py-3">Qty.</th>
						<th class="py-3">Amount</th>
					</tr>
				</thead>
    
        <tbody class="table-group-divider">
          
            <?php 
              $i = 1;
              $productlist = $connect->query("SELECT * FROM order_items WHERE order_id = '$id' ");
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
								</tr>
            <?php endwhile; ?>
            </tbody>
            </table>
    <br>
    <h4 class="text-end">Total: <?php echo $total ?></h4>
</div>

<!-- ///////////    FOOTER    //////////// -->
<?php include("partials/footer.php"); ?>