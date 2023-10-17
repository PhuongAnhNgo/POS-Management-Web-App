
<?php
  //----------------------------------------------------------------------------
  //--------            SOFTWARE DEVELOPED BY PHUONG ANH NGO        ------------
  //----------------------------------------------------------------------------

  ///////////    HEADER + NAVBAR + PHP-Functions    //////////// 
  //Start session, add necessary files
  include("partials/header.php");
  include("partials/sidebar.php");

  include("db_connect.php"); //connect to database

  //Once a year is choosen => return data of that year
  if(isset($_POST['year_data'])){
    $year_data = $_POST['year_data'];
  }else{
    $year_data = date('Y');
  }
  $sql ="SELECT * FROM sales where year_data= $year_data order by month_data asc";
  $result = mysqli_query($connect,$sql);
  $chart_data="";
  while ($row = mysqli_fetch_array($result)) { 
    $month[]  = $row['month_data']  ;
    $sales[] = $row['total'];
}

    $x_axis = ["Jan","Feb", "Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    $y_axis = array_fill(0, 12, 0); //init array of 12 element with 0

   $p = 0;
    for($i = 0; $i< count($month); $i++){
        $y_axis[$month[$i]-1] = $sales[$p++];   
    }

?>

<!-- /////////////////  HTML- PARTS  ////////////////////// -->

<!--    Show graph   -->
<div class="p-5 m-5 text-center" >
<div class="row pb-4">
    <div class="col-md-8">

    </div>
    <div class="col-md-4">
        <form action="graph.php" method="post">
        <div class="row">
    <div class="col">
        <div class="input-group">
            <span class="input-group-text">Choose an year</span>
            <select name="year_data"  class="form-select" aria-label="Default select example" required>
            <?php
                    $years = $connect->query("SELECT DISTINCT year_data FROM sales ");
                    while($row=$years->fetch_assoc()):
            ?> <!-- Loops each categogy to create table of options -->
            <option  value="<?php echo $row['year_data']?>"><?php echo $row['year_data']?></option>
            <?php endwhile;?>
            </select> 
        </div>
    </div>
    <div class="col-3">
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
    <p style="width:70vw; padding-top:4%;"><canvas  id="chartjs_bar"></canvas></p>
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
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js";></script>
<script type="text/javascript">
      var ctx = document.getElementById("chartjs_bar").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels:<?php echo json_encode($x_axis); ?>,
                        datasets: [{
                            backgroundColor: 'rgb(255, 99, 132)',
                            label: "Summe in Euro",
                            data:<?php echo json_encode($y_axis); ?>,
                        }]
                    },
                    options: {
                        plugins: {
                            title: { 
                                display: true,
                                text: "Sales Volume Report",
                                font: {
                                    size: 30 },
                            },
                        },       
                    },
 
 
                });
    </script>
</html>
