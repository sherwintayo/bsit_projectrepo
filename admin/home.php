<?php 
include 'timezone.php'; 	
?>
<h2>Welcome to <?php echo $_settings->info('name') ?></h2>
<hr class="border-info">
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Program List</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `program_list` where status = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-scroll"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Curriculum List</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `curriculum_list` where `status` = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Verified Students</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `student_list` where `status` = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Not Verified Students</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `student_list` where `status` = 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-archive"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Verified Archives</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `archive_list` where `status` = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-dark elevation-1"><i class="fas fa-archive"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Not Verified Archives</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `archive_list` where `status` = 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
	<hr class="border-info">
</br>
</br>
  <div class="row">
      <!-- Bar Chart for Various Counts -->
      <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Summary Bar Chart</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body">
                <canvas id="summaryBarChart" style="min-height: 150px; height: 180px; max-height: 200px; max-width: 100%; margin: 10vh;
                 padding: 0 130px 0 0;"></canvas>
            </div>
        </div>
    </div>
  </div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Archive per Curriculum</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Top Picks</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Most Keyword searched</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Keyword</th>
                            <th style="width: 40px">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            // Check if the table exists
                            if ($conn->query("SHOW TABLES LIKE 'keyword_search_counter'")->num_rows > 0) {
                                $keywordCollection = $conn->query("SELECT keyword, COUNT(keyword) as kcount FROM `keyword_search_counter` GROUP BY keyword ORDER BY kcount DESC LIMIT 10");
                                if($keywordCollection->num_rows > 0):
                                    $cc = 0;
                                    foreach($keywordCollection as $_keywordCollection):
                                        $cc += 1;
                                    ?>
                                        <tr>
                                            <td><?php echo $cc; ?>.</td>
                                            <td><?php echo $_keywordCollection["keyword"]; ?></td>
                                            <td><span class="badge bg-grey"><?php echo $_keywordCollection["kcount"]; ?></span></td>
                                        </tr>
                                    <?php
                                    endforeach;
                                else:
                                ?>
                                    <tr>
                                        <td colpsan="3">No Data Available!</td>
                                    </tr>
                                <?php
                                endif;
                            } else {
                                echo "<tr><td colspan='3'>Table 'keyword_search_counter' does not exist!</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
	
	<div class="col-12 col-sm-12 col-md-12 col-lg-12">
			<!-- BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Published / Unpublish </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
		</div>
</div>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>


     <!-- SUMMARRY BAR GRAPH -->
     <?php
  // Fetch counts for summary bar chart
  $program_count = $conn->query("SELECT * FROM `program_list` WHERE status = 1")->num_rows;
  $curriculum_count = $conn->query("SELECT * FROM `curriculum_list` WHERE `status` = 1")->num_rows;
  $verified_students_count = $conn->query("SELECT * FROM `student_list` WHERE `status` = 1")->num_rows;
  $unverified_students_count = $conn->query("SELECT * FROM `student_list` WHERE `status` = 0")->num_rows;
  $verified_archives_count = $conn->query("SELECT * FROM `archive_list` WHERE `status` = 1")->num_rows;
  $unverified_archives_count = $conn->query("SELECT * FROM `archive_list` WHERE `status` = 0")->num_rows;

  $counts = [
      "Program List" => $program_count,
      "Curriculum List" => $curriculum_count,
      "Verified Students" => $verified_students_count,
      "Unverified Students" => $unverified_students_count,
      "Verified Archives" => $verified_archives_count,
      "Unverified Archives" => $unverified_archives_count
  ];

  $counts = json_encode($counts);
?>

<script>
$(function () {
    // Summary Bar Chart
    var summaryBarChartCanvas = $('#summaryBarChart').get(0).getContext('2d');
    var counts = <?php echo $counts; ?>;
    var labels = Object.keys(counts);
    var data = Object.values(counts);

    var summaryBarChartData = {
        labels: labels,
        datasets: [{
            label: 'Count',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            data: data
        }]
    };

    var summaryBarChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    };

    new Chart(summaryBarChartCanvas, {
        type: 'bar',
        data: summaryBarChartData,
        options: summaryBarChartOptions
    });
});
</script>

<?php
  $months = array();
  $published = array();
  $unpublish = array();
  $titles = array();
  $notitles = array();
  for( $m = 1; $m <= 12; $m++ ) {
    $sql = "SELECT * FROM archive_list WHERE MONTH(date_created) = '$m' AND status = 1 ";
    $pquery = $conn->query($sql);
    array_push($published, $pquery->num_rows);

    $sql = "SELECT * FROM archive_list WHERE MONTH(date_created) = '$m' AND status = 0 ";
    $uquery = $conn->query($sql);
    array_push($unpublish, $uquery->num_rows);
	
	

    $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
    $month =  date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month);
  }
  
  $titles = array();
  $tsql = "SELECT title, COUNT(title) as count FROM archive_list WHERE status = 1 GROUP BY title";
  $tquery = $conn->query($tsql);
  while($row = $tquery->fetch_assoc()) {
      $titles[] = $row;
  }
    

  $months = json_encode($months);
  $published = json_encode($published);
  $unpublish = json_encode($unpublish);
  $titles = json_encode($titles);
?>


<?php
// Fetch the counts for the pie chart
$sql = "
    SELECT c.name as curriculum_name, COUNT(a.id) as count
    FROM archive_list a
    JOIN curriculum_list c ON a.curriculum_id = c.id
    WHERE a.status = 1
    GROUP BY c.name
";
$result = $conn->query($sql);

// Prepare the data for the chart
$curriculum_counts = array();
while ($row = $result->fetch_assoc()) {
    $curriculum_counts[] = $row;
}

$curriculum_counts = json_encode($curriculum_counts);
?>


<script>
$(function () {
    // Bar Chart
    var barChartCanvas = $('#barChart').get(0).getContext('2d');
    var barChartData = {
        labels: <?php echo $months; ?>,
        datasets: [
            {
                label: 'Published',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                data: <?php echo $published; ?>
            },
            {
                label: 'Unpublish',
                backgroundColor: 'rgba(210, 214, 222, 1)',
                borderColor: 'rgba(210, 214, 222, 1)',
                data: <?php echo $unpublish; ?>
            }
        ]
    };
    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    };
    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    });

    // Pie Chart
    // var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    // var titles = <?php echo $titles; ?>;
    // var labels = titles.map(function (title) { return title.title; });
    // var data = titles.map(function (title) { return title.count; });
    // var pieData = {
    //     labels: labels,  
    //     datasets: [{
    //         data: data,
    //         backgroundColor: poolColors(data.length)
    //     }]
    // };
    // var pieOptions = {
    //     maintainAspectRatio: false,
    //     responsive: true
    // };
    // new Chart(pieChartCanvas, {
    //     type: 'pie',
    //     data: pieData,
    //     options: pieOptions
    // });

    // function dynamicColors() {
    //     var r = Math.floor(Math.random() * 255);
    //     var g = Math.floor(Math.random() * 255);
    //     var b = Math.floor(Math.random() * 255);
    //     return "rgba(" + r + "," + g + "," + b + ", 0.5)";
    // }

    // function poolColors(a) {
    //     var pool = [];
    //     for (var i = 0; i < a; i++) {
    //         pool.push(dynamicColors());
    //     }
    //     return pool;
    //}
});
</script>
<script>
$(function () {
    // Pie Chart
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var curriculumCounts = <?php echo $curriculum_counts; ?>;
    
    var labels = curriculumCounts.map(function (item) { return item.curriculum_name; });
    var data = curriculumCounts.map(function (item) { return item.count; });
    
    var pieData = {
        labels: labels,
        datasets: [{
            data: data,
            backgroundColor: poolColors(data.length)
        }]
    };
    
    var pieOptions = {
        maintainAspectRatio: false,
        responsive: true
    };
    
    new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
    });

    function dynamicColors() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgba(" + r + "," + g + "," + b + ", 0.5)";
    }

    function poolColors(a) {
        var pool = [];
        for (var i = 0; i < a; i++) {
            pool.push(dynamicColors());
        }
        return pool;
    }
});
</script>
