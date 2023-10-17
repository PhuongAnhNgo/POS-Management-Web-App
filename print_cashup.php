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

    include("db_connect.php");
    include("partials/header.php");

    $sql = "SELECT id
    FROM orders
    WHERE status = '0'";
    $resultset = mysqli_query($connect, $sql);

    if(!$resultset)   //SQL-Fehler ausgeben
        die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");

    $anzahl = mysqli_num_rows($resultset);

    if($anzahl >= 1){
        echo "<script>
                alert('Can not cash up! Please solve unpaid orders.');
                window.location.href='cashup.php';
            </script>";
    }
    else{
        //Total sales of the day send through GET 
        $sum = $_GET['sum'];

        //Exstract start time and end time of the shiff 
        $orders = $connect->query("SELECT * FROM orders order by date_created asc limit 1");
        $first_row = $orders->fetch_assoc();
        $start_time = $first_row['date_created'];

        $orders2 = $connect->query("SELECT * FROM orders order by date_created desc limit 1");
        $last_row = $orders2->fetch_assoc();
        $end_time = $last_row['date_created'];

        //Calculate time to add sales volumes in accordingly (monthly) finacial reports
        $year_data = intval(substr(strval($end_time), 0, 4));
        $month_data = intval(substr(strval($end_time), 5, 2));

        $sql = "SELECT id FROM sales WHERE year_data = $year_data AND month_data= $month_data";
        $resultset = mysqli_query($connect, $sql);

        if(!$resultset)   //SQL-Fehler ausgeben
            die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");

        $anzahl = mysqli_num_rows($resultset); 

        if($anzahl <1){ //not exist that month+year in database yet
            $sql5 = "INSERT sales 
                    SET month_data ='$month_data',
                        year_data = '$year_data',
                        total = '$sum'";
            mysqli_query($connect, $sql5); 
        }else{
            $sql6 = "SELECT total 
                    FROM sales
                    WHERE month_data ='$month_data' 
                    AND year_data = '$year_data'";
            $result = mysqli_query($connect, $sql6);
            $row= $result->fetch_assoc();
            $new_total = $sum + $row['total'];

            
            $sql7 = "UPDATE sales
                    SET total = $new_total
                    WHERE month_data ='$month_data' 
                    AND year_data = '$year_data'";
            $result = mysqli_query($connect, $sql7);
        }
        
        $sql1 = "DELETE FROM orders"; //Delete all orders' details after cash up
        mysqli_query($connect, $sql1);

        $sql2 = "DELETE FROM order_items"; //Delete all orders' details after cash up
        mysqli_query($connect, $sql2);

        //Reset Auto increment id of both tables 
        $sql3 = "ALTER TABLE orders AUTO_INCREMENT = 1"; 
        mysqli_query($connect, $sql3);

        $sql4 = "ALTER TABLE order_items AUTO_INCREMENT = 1"; 
        mysqli_query($connect, $sql4);  
    } 
?>

<!-- /////////////////  HTML- PARTS  ////////////////////// -->

<!--    Formular to add new category   -->
<div class="p-5 m-5">
    <h3 class="text-center">CASH-UP</h3>
    <H5>Company X</H5>
    <br>
    <hr>
    <p><b>Opened At: </b><?php echo $start_time ?></p>
    <p><b>Ended At: </b><?php echo $end_time ?></p>
        <br>
        <h4 class="text-end">Total: <?php echo $sum ?></h4>
</div>

<!-- ///////////    FOOTER    //////////// -->
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
        window.print();
            setTimeout(function(){
                location.href='cashup.php';
          },500)
    });
</script>

</script>
</body>
</html>