<?php include 'includes/head.php'; ?>

<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <!-- Emergency Tile -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM emergency");
                        $result->execute();
                        $row = $result->fetch();
                        ?>
                        <a href="view-emergency.php">
                            <div class="dash-widget">
                                <span class="dash-widget-bg1"><i class="fa fa-stethoscope"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $row['total']; ?></h3>
                                    <span class="widget-title1">Emergency <i class="fa fa-check"></i></span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Users Tile -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM users");
                        $result->execute();
                        $row = $result->fetch();
                        ?>
                        <a href="users1.php">
                            <div class="dash-widget">
                                <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $row['total']; ?></h3>
                                    <span class="widget-title2">Users <i class="fa fa-check"></i></span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Agency Tile -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM agency");
                        $result->execute();
                        $row = $result->fetch();
                        ?>
                        <a href="agency.php">
                            <div class="dash-widget">
                                <span class="dash-widget-bg3"><i class="fa fa-user-md"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $row['total']; ?></h3>
                                    <span class="widget-title3">Agency <i class="fa fa-check"></i></span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Ongoing Emergencies Tile -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending'");
                        $result->execute();
                        $row = $result->fetch();
                        ?>
                        <a href="view-emergency.php">
                            <div class="dash-widget">
                                <span class="dash-widget-bg4"><i class="fa fa-heartbeat"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $row['total']; ?></h3>
                                    <span class="widget-title4">Ongoing <i class="fa fa-check"></i></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card member-panel">
                            <div class="card-header bg-white">
                                <h4 class="card-title">Emergencies Per Month</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="emergencyChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card member-panel">
                            <div class="card-header bg-white">
                                <h4 class="card-title">Agencies vs Users</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="agencyUserChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Emergencies Per Year</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="emergencyYearChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- JS Scripts -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

        <script>
            // Register plugin for Chart.js v3+
            Chart.register(ChartDataLabels);
        </script>

        <script>
            // Animated Tile Counters
            $(document).ready(function () {
                $('.dash-widget-info h3').each(function () {
                    let $this = $(this);
                    let countTo = $this.text();
                    $this.text('0');
                    $({ countNum: 0 }).animate({ countNum: countTo }, {
                        duration: 1000,
                        easing: 'swing',
                        step: function () {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function () {
                            $this.text(this.countNum);
                        }
                    });
                });
            });
        </script>

     <!-- Emergencies Per Month Chart -->
     <script>
        <?php
            $query = $db->prepare("SELECT YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total FROM emergency GROUP BY YEAR(created_at), MONTH(created_at) ORDER BY year ASC, month ASC");
            $query->execute();
            $emergencyData = $query->fetchAll(PDO::FETCH_ASSOC);

            $months = [];
            $totals = [];
            foreach ($emergencyData as $row) {
                $months[] = date('F Y', strtotime($row['year'] . '-' . $row['month'] . '-01'));
                $totals[] = $row['total'];
            }
        ?>
        var months = <?php echo json_encode($months); ?>;
        var emergencyCounts = <?php echo json_encode($totals); ?>;
        var ctx = document.getElementById('emergencyChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Emergencies Per Month',
                    data: emergencyCounts,
                    backgroundColor: 'rgba(72, 140, 220, 0.7)',
                    borderColor: 'rgba(72, 140, 220, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        display: false // Disable numbers inside the bar chart
                    }
                },
                scales: {
                    x: { ticks: { font: { size: 14 }, color: '#555' }, grid: { display: false } },
                    y: { beginAtZero: true, ticks: { font: { size: 14 }, color: '#555' } }
                }
            }
        });
        </script>

        <!-- Emergencies Per Year Chart -->
        <script>
        <?php
            $yearQuery = $db->prepare("SELECT YEAR(created_at) as year, COUNT(*) as total FROM emergency GROUP BY YEAR(created_at) ORDER BY year ASC");
            $yearQuery->execute();
            $yearData = $yearQuery->fetchAll(PDO::FETCH_ASSOC);

            $years = [];
            $yearTotals = [];
            foreach ($yearData as $row) {
                $years[] = $row['year'];
                $yearTotals[] = $row['total'];
            }
        ?>
        var yearLabels = <?php echo json_encode($years); ?>;
        var yearCounts = <?php echo json_encode($yearTotals); ?>;
        var ctxYear = document.getElementById('emergencyYearChart').getContext('2d');
        new Chart(ctxYear, {
            type: 'bar',
            data: {
                labels: yearLabels,
                datasets: [{
                    label: 'Emergencies Per Year',
                    data: yearCounts,
                    backgroundColor: 'rgba(255, 165, 0, 0.7)',
                    borderColor: 'rgba(255, 165, 0, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        display: false // Disable numbers inside the bar chart
                    }
                },
                scales: {
                    x: { ticks: { font: { size: 14 }, color: '#555' }, grid: { display: false } },
                    y: { beginAtZero: true, ticks: { font: { size: 14 }, color: '#555' } }
                }
            }
        });
        </script>

        <!-- Agencies vs Users Chart -->
        <script>
        <?php
            $agencyQuery = $db->prepare("SELECT COUNT(*) as total FROM agency");
            $agencyQuery->execute();
            $agencyCount = $agencyQuery->fetch()['total'];

            $userQuery = $db->prepare("SELECT COUNT(*) as total FROM users");
            $userQuery->execute();
            $userCount = $userQuery->fetch()['total'];
        ?>
        var ctxAgencyUser = document.getElementById('agencyUserChart').getContext('2d');
        new Chart(ctxAgencyUser, {
            type: 'pie',
            data: {
                labels: ['Agencies', 'Users'],
                datasets: [{
                    data: [<?php echo $agencyCount; ?>, <?php echo $userCount; ?>],
                    backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        display: false // Disable numbers inside the pie chart
                    },
                    legend: {
                        display: true
                    }
                }
            }
        });
        </script>

        <style>
            .table-responsive {
                max-height: 250px;
                overflow-y: auto;
            }
        </style>
    </div>
</body>
</html>
