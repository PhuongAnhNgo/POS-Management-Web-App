<?php
 //----------------------------------------------------------------------------
  //--------            SOFTWARE DEVELOPED BY PHUONG ANH NGO        ------------
  //----------------------------------------------------------------------------
  session_start();
  if(!isset( $_SESSION['benutzer_id'])){
    header("Location:index.php");
  } 
  include("partials/header.php");
  include("partials/sidebar.php");

  include("db_connect.php");
?>

<!-- /////////////////////////////////////////////////////// -->
<div class="container-fluid py-5 px-5 my-4">
  <h1 class="py-2">Welcome to JAZMIN App!</h1>
  <h3>POS Management software developed by Phuong Anh Ngo. </h4>
  <p>Version 2.0 - Responsive</p>
  <br>

  <h4>INSTRUCTIONS:</h4>
  <h6><i class="fa-solid fa-square-up-right"></i> Home:</h6>
  <p>Contains overall informations and instructions of the page.</p>
  <br>
  <h6><i class="fa-solid fa-square-up-right"></i> Orders:</h6>
  <p>Allows users to</p>
  <ul>
    <li>view unpaid orders</li>
    <li>add neu orders</li>
    <li>add items to orders</li>
    <li>delete items from lists</li>
    <li>checkout tables and print receipts</li>
  </ul>
  <br>
  <h6><i class="fa-solid fa-square-up-right"></i> Menu:</h6>
  <p>Users can view menu, add new items, delete items, change details.</p>
  <br>
  <h6><i class="fa-solid fa-square-up-right"></i> Categories:</h6>
  <p>Users can view menu, add new or delete categories, change details.</p>
  <br>
  <h6><i class="fa-solid fa-square-up-right"></i> Manage Users:</h6>
  <p><b>Notice: Only admin is allowed to access to this page!</b></p>
  <p>Admin can delete, add or change users.</p>
  <br>
  <h6><i class="fa-solid fa-square-up-right"></i> History and Cash-up:</h6>
  <p>Allow users to see all transactions (orders) of the day/shiff and print cash-up.</p>
  <br>
  <h6><i class="fa-solid fa-square-up-right"></i> Sales Report:</h6>
  <p>Users can choose year based on their wishes and see report in form of <b>graphics.</b></p>
  <p>Monthly sales are presented in the form of a chart for users to grasp the development trend of the business and make appropriate adjustments and plans.</p>
  

</div>

<footer class="text-center p-4 ">Copyright 2023 All rights reserved.</footer>





<!-- /////////////////////////////////////////////////////// -->

<?php
    include("partials/footer.php");
?>