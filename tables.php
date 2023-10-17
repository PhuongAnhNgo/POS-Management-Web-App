<?php
  //----------------------------------------------------------------------------
  //--------            SOFTWARE DEVELOPED BY PHUONG ANH NGO        ------------
  //----------------------------------------------------------------------------
  
  ///////////    HEADER + NAVBAR + PHP-Functions    //////////// 
  //Start session, add necessary files
  session_start();
  if(!isset( $_SESSION['benutzer_id'])){
    //Wenn nicht eingeloggt dann muss erstmal einloggen
    header("Location:index.php");
  } 

  include("partials/header.php");
  include("partials/sidebar.php");

  include("db_connect.php");

  if(isset($_POST['table_num'])){
    $table_num = $_POST['table_num'];
    $table_num = mysqli_real_escape_string($connect, $table_num);
    $sql = "SELECT id
            FROM orders
            where table_num = '$table_num'
            and status = '0' ";
    $results = mysqli_query($connect, $sql);

    if(!$results) {
      die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");
    }  
    else{
        $num_rows = mysqli_num_rows($results);
        if($num_rows != 0){
            echo '<script>alert("Invalid! Table is already in use")</script>';
        }
        else{
            $datum = date('Y-m-d H:i:s');
            
            $sql = "INSERT orders
                    SET table_num = '$table_num',
                        total_amount = '0',
                        date_created = '$datum',
                        status = '0' ";
            $res = mysqli_query($connect, $sql);

            if(!$res) {
              die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");
            }  
            else{
                $_SESSION['table_num']= $table_num;
                header("Location: order.php");
            }
    
        }    
    }  
  }  
?>

<!-- /////////////////  HTML- PARTS  ////////////////////// -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add table number</h1>
            </div>
            <div class="modal-body" >
            <form action="tables.php" method="post">
                <label for="table_num">Table number:</label>
                <input type="number" name="table_num" min="1" max="30">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Sumit</button>
            </div>
            </form>
            </div>
        </div>

        
</div>


<div class= "container-fluid p-5 my-5">
    <form action="order.php" method="post" >
        <?php
            $tables = $connect->query("SELECT * FROM orders WHERE status = '0' order by table_num asc ");
            while($row=$tables->fetch_assoc()):
        ?> 
        
            <button id="btn_table" name="table_id" type="submit" class="btn m-3" value="<?php echo $row['id']?>">TABLE <?php echo $row['table_num']?></button>
        
        <?php endwhile; ?>
        <button id="btn_table2" type="button" class="btn m-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="fa-solid fa-plus fa" style="color: #61656e;"></i> Add
        </button>
    </form>
   
    



</div>

<!-- ///////////    FOOTER    //////////// -->
<?php
    include("partials/footer.php");
?>
