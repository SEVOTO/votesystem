<?php include 'includes/session.php'; ?>
<?php include 'includes/slugify.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/scripts.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="contenido">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tablero de mando
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Hogar</a></li>
        <li class="active">Tablero de mando</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM positions";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>

              <p>No. de cargos</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a href="positions.php" class="small-box-footer">Mostrar informacion <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM candidates";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>
          
              <p>No. de candidatos</p>
            </div>
            <div class="icon">
              <i class="fa fa-black-tie"></i>
            </div>
            <a href="candidates.php" class="small-box-footer">Mostrar informacion <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM voters";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>
             
              <p>Total Votantes</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="voters.php" class="small-box-footer">Mostrar informacion <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM votes GROUP BY voters_id";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>

              <p>Conteo de votos</p>
            </div>
            <div class="icon">
              <i class="fa fa-edit"></i>
            </div>
            <a href="votes.php" class="small-box-footer">Mostrar informacion <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="row">
        <div class="col-xs-12">
          <h3>Graficas de participacion
            <span class="pull-right">
              <a href="print_acta0.php" class="btn btn-success btn-sm btn-flat"><span class="glyphicon glyphicon-print"></span> Acta de inicializacion en 0</a>
              <button  class="btn btn-success btn-sm btn-flat" onclick="guardarComoPDF()" ><span class="glyphicon glyphicon-download"></span> Descargar PDF</button>

            </span>
          </h3>
        </div>
      </div>



      <?php
      
$sql = "SELECT * FROM positions ORDER BY priority ASC";
$query = $conn->query($sql);
$inc = 2;
while($row = $query->fetch_assoc()){
  $inc = ($inc == 2) ? 1 : $inc+1; 
  if($inc == 1) echo "<div class='row' id='graficas'>";
  echo "
    <div class='col-sm-6'>
      <div class='box box-solid'>
        <div class='box-header with-border'>
          <h4 class='box-title'><b>".$row['description']."</b></h4>
        </div>
        <div class='box-body'>
          <div class='chart'>
            <canvas id='graficaBarras_".$row['id']."' style='height:200px'></canvas>
          </div>
        </div>
      </div>
    </div>
    
    <div class='col-sm-6'>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h4 class='box-title'><b>".$row['description']."</b></h4>
      </div>
      <div class='box-body'>
        <div class='chart'>
          <canvas id='graficaLinea_".$row['id']."' style='height:200px'></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class='col-sm-6'>
  <div class='box box-solid'>
    <div class='box-header with-border'>
      <h4 class='box-title'><b>".$row['description']."</b></h4>
    </div>
    <div class='box-body'>
      <div class='chart'>
        <canvas id='graficaHorizontal_".$row['id']."' style='height:200px'></canvas>
      </div>
    </div>
  </div>
</div>
";
$sql = "SELECT candidates.firstname AS canfirst, candidates.lastname AS canlast, COUNT(votes.candidate_id) AS votecount FROM votes LEFT JOIN candidates ON candidates.id=votes.candidate_id GROUP BY votes.candidate_id ORDER BY votecount DESC";
$query = $conn->query($sql);
echo "
<div class='col-sm-6'>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h4 class='box-title'><b>".$row['description']."</b></h4>
      </div>
      <div class='box-body'>
        <div class='chart'>
        <table class='table table-bordered'>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Votos</th>
        </tr>";
while($row = $query->fetch_assoc()){
    echo "

          <tr>
            <td>".$row['canfirst']."</td>
            <td>".$row['canlast']."</td>
            <td>".$row['votecount']."</td>
          </tr>";
}
echo "</table>

</div>
</div>
</div>
</div>

";
  if($inc == 2) echo "</div>";  
}
if($inc == 1) echo "<div class='col-sm-6'></div></div>";
?>

<?php
$sql = "SELECT * FROM positions ORDER BY priority ASC";
$query = $conn->query($sql);
while($row = $query->fetch_assoc()){
  $sql = "SELECT * FROM candidates WHERE position_id = '".$row['id']."'";
  $cquery = $conn->query($sql);
  $carray = array();
  $varray = array();
  while($crow = $cquery->fetch_assoc()){
    array_push($carray, $crow['lastname']);
    $sql = "SELECT * FROM votes WHERE candidate_id = '".$crow['id']."'";
    $vquery = $conn->query($sql);
    array_push($varray, $vquery->num_rows);
  }
  $carray = json_encode($carray);
  $varray = json_encode($varray);
  ?>
  <script>
  $(function(){
    var rowid = '<?php echo $row['id']; ?>';
    var description = 'graficaBarras_<?php echo $row['id']; ?>';
    var barChartCanvas = $('#'+description).get(0).getContext('2d')
    var barChart = new Chart(barChartCanvas)
    var barChartData = {
      labels  : <?php echo $carray; ?>,
      datasets: [
        {
          label               : 'Votes',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo $varray; ?>
        }
      ]
    }
      var barChartOptions                  = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero        : true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines      : true,
        //String - Colour of the grid lines
        scaleGridLineColor      : 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth      : 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines  : true,
        //Boolean - If there is a stroke on each bar
        barShowStroke           : true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth          : 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing         : 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing       : 1,
        //String - A legend template
        legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        //Boolean - whether to make the chart responsive
        responsive              : true,
        maintainAspectRatio     : true
      }

      barChartOptions.datasetFill = false
      var myChart = barChart.Bar(barChartData, barChartOptions)
      //document.getElementById('legend_'+rowid).innerHTML = myChart.generateLegend();
    });
    </script>
    <?php
  }
?>

<?php
 {
  $sql = "SELECT * FROM positions ORDER BY priority ASC";
  $query = $conn->query($sql);
  while($row = $query->fetch_assoc()){
    $sql = "SELECT * FROM candidates WHERE position_id = '".$row['id']."'";
    $cquery = $conn->query($sql);
    $carray = array();
    $varray = array();
    while($crow = $cquery->fetch_assoc()){
      array_push($carray, $crow['lastname']);
      $sql = "SELECT * FROM votes WHERE candidate_id = '".$crow['id']."'";
      $vquery = $conn->query($sql);
      array_push($varray, $vquery->num_rows);
    }
    $carray = json_encode($carray);
    $varray = json_encode($varray);
    ?>
    <script>
    $(function(){
      var rowid = '<?php echo $row['id']; ?>';
      var description = 'graficaLinea_<?php echo $row['id']; ?>';
      var lineChartCanvas = $('#'+description).get(0).getContext('2d')
      var lineChart = new Chart(lineChartCanvas)
      var lineChartData = {
        labels  : <?php echo $carray; ?>,
        datasets: [
          {
            label               : 'Votes',
            fillColor           : 'rgba(60,141,188,0.9)',
            strokeColor         : 'rgba(60,141,188,0.8)',
            pointColor          : '#3b8bba',
            pointStrokeColor    : '#fff',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : <?php echo $varray; ?>
          }
        ]
      }
        var lineChartOptions                  = {
          //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
          scaleBeginAtZero        : true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines      : true,
          //String - Colour of the grid lines
          scaleGridLineColor      : 'rgba(0,0,0,.05)',
          //Number - Width of the grid lines
          scaleGridLineWidth      : 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines  : true,
          //Boolean - If there is a stroke on each bar
          barShowStroke           : true,
          //Number - Spacing between each of the X value sets
          lineTension             : 0.4,
          //Number - Spacing between data sets within X values
          barDatasetSpacing       : 1,
          //String - A legend template
          legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
          //Boolean - whether to make the chart responsive
          responsive              : true,
          maintainAspectRatio     : true
        }

        lineChartOptions.datasetFill = false
        var myChart = lineChart.Line(lineChartData, lineChartOptions)
        //document.getElementById('legend_'+rowid).innerHTML = myChart.generateLegend();
      });

      
      
      </script>
      <?php
    }
}
?>

<?php
$sql = "SELECT * FROM positions ORDER BY priority ASC";
$query = $conn->query($sql);
while($row = $query->fetch_assoc()){
  $sql = "SELECT * FROM candidates WHERE position_id = '".$row['id']."'";
  $cquery = $conn->query($sql);
  $carray = array();
  $varray = array();
  while($crow = $cquery->fetch_assoc()){
    array_push($carray, $crow['lastname']);
    $sql = "SELECT * FROM votes WHERE candidate_id = '".$crow['id']."'";
    $vquery = $conn->query($sql);
    array_push($varray, $vquery->num_rows);
  }
  $carray = json_encode($carray);
  $varray = json_encode($varray);
  ?>
  <script>
  $(function(){
    var rowid = '<?php echo $row['id']; ?>';
    var description = 'graficaHorizontal_<?php echo $row['id']; ?>';
    var barChartCanvas = $('#'+description).get(0).getContext('2d')
    var barChart = new Chart(barChartCanvas)
    var barChartData = {
      labels  : <?php echo $carray; ?>,
      datasets: [
        {
          label               : 'Votes',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo $varray; ?>
        }
      ]
    }
      var barChartOptions                  = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero        : true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines      : true,
        //String - Colour of the grid lines
        scaleGridLineColor      : 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth      : 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines  : true,
        //Boolean - If there is a stroke on each bar
        barShowStroke           : true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth          : 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing         : 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing       : 1,
        //String - A legend template
        legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        //Boolean - whether to make the chart responsive
        responsive              : true,
        maintainAspectRatio     : true
      }

      barChartOptions.datasetFill = false
      var myChart = barChart.HorizontalBar(barChartData, barChartOptions)
      //document.getElementById('legend_'+rowid).innerHTML = myChart.generateLegend();
    });
    </script>
    <?php
  }
?>
      </section>
      <!-- right col -->
    </div>
  	<?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

              <script>
                function guardarComoPDF() {
                  const divGraficas = document.getElementById('contenido');
                  html2canvas(divGraficas).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jsPDF('p', 'mm', 'a4');
                    const pdfWidth = 210; // Ancho de la página A4 en mm
                    const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
                    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                    pdf.save('graficas.pdf');
                  });
                }
              </script>


</body>
</html>
