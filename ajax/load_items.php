<!-- AJAX load orders' details (used in order.php)-->
<?php
    include("db_connect.php");
    
    $catNew_id = $_POST['catNewId'];
    $order_id = $_POST['orderId'];
    
    $products = $connect->query("SELECT id,name FROM products where category_id= '$catNew_id' ");
    while($rows = $products->fetch_assoc()):
?>
    <button id="btn-items" class="btn btn-warning" type="button" value="<?php echo $rows['id']?>" data-value="<?php echo $order_id?>"><?php echo $rows['name']?></button>
                 
<?php endwhile; ?>

