<!-- AJAX load orders' details -->
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
    include("db_connect.php");
    $item_id = $_POST['itemId'];
    $order_id = $_POST['orderId']; 
    $total = 0;
    $i = 1;   
    $connect->query("DELETE FROM order_items WHERE product_id = '$item_id' ");
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
    <td>
        <?php
            // (3)
            $total = $total +  $row['amount'];
            echo $row['amount'] ?>
        </td>
	<td class="text-left">    
    <button id="delete_product" class="btn btn-sm btn-danger" type="button" value="<?php echo $row['product_id']?>" data-value="<?php echo $order_id?>" ><i class="fa fa-trash-alt"></i></button>
    </td>
	</tr>
    <?php endwhile; ?>
    </tbody>
</table>



        </div>
        <h3>Total:
    <?php
        $sql5 = "UPDATE orders SET total_amount = '$total' where id = '$order_id' ";
        mysqli_query($connect, $sql5);
        echo $total;
    ?><span>&euro;</span> 
</h3>