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
    $i=1;
    
    
    //Get price from products-Table
    $sql = "SELECT price FROM products where id = '$item_id' ";
    $resultset = mysqli_query($connect, $sql);
    $result = mysqli_fetch_assoc($resultset);  
    $price = $result['price'];

    
    //Check if order list contain that product already
    $sql1 = "SELECT id,qty FROM order_items where order_id = '$order_id' AND product_id='$item_id' ";
    $res= mysqli_query($connect, $sql1);
    $anzahl = mysqli_num_rows($res);
    
    if($anzahl <1){
        $sql2 = "INSERT order_items
                SET order_id = '$order_id',
                    product_id = '$item_id',
                    qty = '1',
                    price = '$price',
                    amount = '$price' "; 
        mysqli_query($connect, $sql2);
    }
    else{
        $sql3 = "SELECT id, qty
                FROM order_items
                WHERE order_id = '$order_id'
                AND  product_id = '$item_id'";
        $res_ult = mysqli_query($connect, $sql3);
        $quan = mysqli_fetch_assoc($res_ult);
        $new_id = $quan['id'];
        $qty = $quan['qty'] + 1;
        $amount = $price * $qty;

        $sql4 = "UPDATE order_items
                SET qty = '$qty',
                    amount = '$amount'
                where id = '$new_id'";
        mysqli_query($connect, $sql4);
        
    }
    

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
            //$sql = "UPDATE total_amount FROM orders where id = '$id' ";
            
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

     