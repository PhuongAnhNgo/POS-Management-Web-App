<?php
  //----------------------------------------------------------------------------
  //--------            SOFTWARE DEVELOPED BY PHUONG ANH NGO        ------------
  //----------------------------------------------------------------------------
  session_start();
  if(!isset( $_SESSION['benutzer_id'])){
    
    header("Location:index.php");
  } 
  include("db_connect.php");

 
  if( isset($_POST['del_item']) ){
    $id = $_POST['del_item'];
   
    $id = mysqli_real_escape_string($connect, $id);

    $sql = "DELETE 
            FROM categories 
            WHERE id='$id'";
    $resultset = mysqli_query($connect, $sql);

    if(!$resultset) {
      die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");
    }  
    else{
        header("Refresh:0");
    } 
  }

  include("partials/header.php");
  include("partials/sidebar.php");

  
?>

<!-- /////////////////////////////////////////////////////// -->
<div id="tableCat" class="container-fluid my-5">
<div class="card">
					<div class="card-header row justify-content-between">
                        <div class="col-4"><b>Category List</b></div>
                        <div class="col-4 text-end"><a class="btn btn-primary" href="add_categories.php" >
						<i class="fa fa-plus"></i> Add Category </a></div>
					</div>
					<div class="card-body" >
						<table class="table table-hover" >
							<thead>
								<tr>
									<th class="py-3">No.</th>
									<th class="py-3">Name</th>
									<th class="py-3">Description</th>
									<th class="py-3">Delete</th>
								</tr>
							</thead>
              <tbody class="table-group-divider">

								<?php 
								$i = 1;
								$category = $connect->query("SELECT * FROM categories order by id asc");
								while($row=$category->fetch_assoc()):
								?>
               
                <tr>
									<td class="text-left"><?php echo $i++ ?></td>
									<td class=""><?php echo $row['name'] ?></td>
									<td><?php echo $row['description'] ?></td>
									<td class="text-left">
                  <form action="change_category.php" method="post" >
                      <button class="btn btn-sm btn-primary" type="submit" name="change_item_id" value="<?php echo $row['id']?>"><i class="fa-solid fa-pen-to-square"></i></button>
                  </form>
                     
                      
                  <form action="categories.php" method="post">
                      <button class="btn btn-sm btn-danger" type="submit" name="del_item" value="<?php echo $row['id']?>"><i class="fa fa-trash-alt"></i></button>
                  </form>
                  		</td>
								</tr>
                
								
								<?php endwhile; ?>
							</tbody>
						</table>
            
					</div>
				</div>    

</div>

<!-- /////////////////////////////////////////////////////// -->

<?php
    include("partials/footer.php");
?>