
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
?>

<!-- /////////////////  HTML- PARTS  ////////////////////// -->
<!--    Show table of transitions' history   -->
<div id="tableCat" class="container-fluid my-5">
<div class="card">
					<div class="card-header row justify-content-between">
                        <div class="col-4"><h3>History</h3></div>
                        
					</div>
					<div class="card-body" >
						<table class="table table-hover text-center" >
							<thead>
								<tr>
									<th class="py-3">Order No.</th>
                                    <th class="py-3">Time</th>
									<th class="py-3">Total</th>
									<th class="py-3">Paid</th>
								</tr>
							</thead>
              <tbody class="table-group-divider table-striped">
                <!--    Retrieve data from database   -->
								<?php 
								$i = 1;
                                $sum = 0; //var to calculate sum on each line
								$orders = $connect->query("SELECT * FROM orders order by date_created asc");
                                
								while($row=$orders->fetch_assoc()):
								?>
               
                <tr>
									<td><?php echo $i++ ?></td>
                                    <td><?php echo $row['date_created'] ?></td>
									<td><?php echo $row['total_amount'] ?></td>
									<td>
                                        <?php if($row['status'] > 0): ?>
                                            <i class="fa-solid fa-circle-check fa-xl" style="color: #00a31a;"></i>
                                        <?php else: ?>
                                            <i class="fa-solid fa-square-xmark fa-xl" style="color: #b31d2f;"></i>
                                        <?php endif; ?>
                                    </td>  
								</tr>
								<?php   $sum += $row['total_amount'];
                                        endwhile; ?>
							</tbody>
						</table>
            
					</div>
				</div>  
                <br>  
                <div class="row">
                    <div class="col">
                    <h4>Amount: <?php echo $sum ?></h4> <!-- Return calculated total -->
                    </div>
                    <div class="col text-end">
                    <a type="button" id="btn-cashup" class="btn btn-lg btn-success" href="print_cashup.php?sum=<?php echo $sum?>" >
						<i class="fa-solid fa-check" style="color: #fffaf8;"></i> Cash Up</a>
                    </div>
                </div>

</div>

<!-- ///////////    FOOTER    //////////// -->

<?php
    include("partials/footer.php");
?>


