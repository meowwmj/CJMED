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
                        for ($i = 0; $row = $result->fetch(); $i++) {
                        ?>
                            <a href="view-emergency.php">
                                <div class="dash-widget">
                                    <span class="dash-widget-bg1"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                                    <div class="dash-widget-info text-right">
                                        <h3><?php echo $row['total']; ?></h3>
                                        <span class="widget-title1">Emergency <i class="fa fa-check" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>

                    <!-- Users Tile -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM users");
                        $result->execute();
                        for ($i = 0; $row = $result->fetch(); $i++) {
                        ?>
                            <a href="users1.php">
                                <div class="dash-widget">
                                    <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
                                    <div class="dash-widget-info text-right">
                                        <h3><?php echo $row['total']; ?></h3>
                                        <span class="widget-title2">Users <i class="fa fa-check" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>

                    <!-- Agency Tile -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM agency");
                        $result->execute();
                        for ($i = 0; $row = $result->fetch(); $i++) {
                        ?>
                            <a href="agency.php">
                                <div class="dash-widget">
                                    <span class="dash-widget-bg3"><i class="fa fa-user-md" aria-hidden="true"></i></span>
                                    <div class="dash-widget-info text-right">
                                        <h3><?php echo $row['total']; ?></h3>
                                        <span class="widget-title3">Agency <i class="fa fa-check" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>

                    <!-- Ongoing Emergencies Tile -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending'");
                        $result->execute();
                        for ($i = 0; $row = $result->fetch(); $i++) {
                        ?>
                            <a href="view-emergency.php">
                                <div class="dash-widget">
                                    <span class="dash-widget-bg4"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                                    <div class="dash-widget-info text-right">
                                        <h3><?php echo $row['total']; ?></h3>
                                        <span class="widget-title4">Ongoing <i class="fa fa-check" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <!-- Emergencies Per Month -->
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                        <div class="card member-panel">
                            <div class="card-header bg-white">
                                <h4 class="card-title">Emergencies Per Month</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="emergencyChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Agencies vs Users -->
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card member-panel">
                            <div class="card-header bg-white">
                                <h4 class="card-title">Agencies vs Users</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="agencyUserChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Emergency Chart Per Year -->
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Emergencies Per Year</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="emergencyYearChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Logout Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Logout</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">Are you sure you want to log out?</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-overlay" data-reff=""></div>

        <!-- JS Scripts -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/Chart.bundle.js"></script>
        <script src="assets/js/chart.js"></script>
        <script src="assets/js/app.js"></script>

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
                    legend: { display: false }
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
