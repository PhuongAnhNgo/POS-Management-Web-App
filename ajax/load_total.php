<!-- AJAX load orders' total (used in order.php)-->
<?php
    include("db_connect.php");
    
    $order_id = $_POST['orderId']; 
    $sql = "SELECT total_amount FROM orders where id = '$order_id' ";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
          
    echo $row['total_amount']
?><span>&euro;</span> 