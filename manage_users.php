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
  
  if( $_SESSION['type'] == 2){
    //Not admin => not allow to manage users
    echo "<script>
    alert('You are not allow to access this page! Please contact admin to manage users.');
    window.location.href='home.php';
    </script>";
  } 
  else{
    if(isset($_POST['del_user_id'])){
      $del_user_id = $_POST['del_user_id'];
      if($del_user_id == 1){ //Not allow delete admin
        echo "<script>alert('This user can not be deleted!');</script>";
      }else{
        $del_user_id = mysqli_real_escape_string($connect, $del_user_id);
        $sql = "DELETE 
                FROM users 
                WHERE id='$del_user_id'";
        $resultset = mysqli_query($connect, $sql);

        if(!$resultset) {
            //SQL-Fehler ausgeben
          die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");
        }  
      }

    }
    if( isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) 
      && isset($_POST['type']) && isset($_POST['user_id'])){
        $name = mysqli_real_escape_string($connect, $_POST['name']);
        $username = mysqli_real_escape_string($connect, $_POST['username']);
        $password = mysqli_real_escape_string($connect, $_POST['password']);
        $type = mysqli_real_escape_string($connect, $_POST['type']);
          
        $password = md5($password);

        if($_POST['user_id'] == "NEW"){ //Add new user
          $sql = "INSERT users 
                  SET name ='$name',
                      username = '$username',
                      password = '$password',
                      type = '$type'";

          $resultset = mysqli_query($connect, $sql);
          if(!$resultset){
            die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");
          }

        }else{ //Change user
          $user_id = mysqli_real_escape_string($connect, $_POST['user_id']);
          $sql = "UPDATE users 
                  SET name ='$name',
                      username = '$username',
                      password = '$password',
                      type = '$type'
                  WHERE id='$user_id'";

          $result = mysqli_query($connect, $sql);
          if(!$result){
            die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");
          }
        }
      }
  }
  
?>

<!-- /////////////////  HTML- PARTS  ////////////////////// -->

<!--    Table of users and action buttons   -->
<div class="container-fluid pt-5 px-5 mt-5">
<div class="card">
					<div class="card-header row justify-content-between">
          <div class="col-4"><h3>Users</h3></div>
              <div class="col-5 text-end"><button id="openForm" class="btn btn-primary" type="button" value="NEW">
						<i class="fa fa-plus"></i> Add Users </button></div>
					</div>
					<div class="card-body" style="height:40vh;overflow: scroll;">
						<table class="table table-hover" >
							<thead>
								<tr>
									<th class="py-3">No.</th>
									<th class="py-3">Name</th>
									<th class="py-3">Username</th>
									<th class="py-3">Type*</th>
                  <th class="py-3">Action</th>
								</tr>
							</thead>
              <div id="user_infos">
              <tbody class="table-group-divider">

								<?php 
								$i = 1;
								$users = $connect->query("SELECT * FROM users");
								while($row=$users->fetch_assoc()):
								?>
                <tr>
									<td class="text-left"><?php echo $i++ ?></td>
									<td class=""><?php echo $row['name'] ?></td>
									<td><?php echo $row['username'] ?></td>
                  <td><?php echo $row['type'] ?></td>
									<td class="text-left">
                      <button id="openForm" class="btn btn-sm btn-primary" type="button"  value="<?php echo $row['id']?>"><i class="fa-solid fa-pen-to-square"></i></button>
                      <form action="manage_users.php" method="post">
                      <button class="btn btn-sm btn-danger" type="submit" name="del_user_id" value="<?php echo $row['id']?>"><i class="fa fa-trash-alt"></i></button>
                      </form>
                 
                  		</td>
								</tr>
								
								<?php endwhile; ?>
							</tbody>
                </div>
						</table>
            
					</div>
				</div>    
        <div id ="myForm">
  
        </div>
                  <br>
        <p><em>(*: 1= admin, 2 = staff)</em></p>
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
  $(document).on('click', 'button#openForm', function(event) {
    var user_id = $(this).attr("value");
    $("#myForm").load("load_form.php",{
      userId : user_id
    });
    $("#myForm").css("display", "block");
  });

  $(document).on('click', 'button#closeForm', function(event) {
    $("#myForm").css("display", "none");
  });

});


</script>
</body>
</html>

