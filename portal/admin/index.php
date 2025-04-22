<?php include 'includes/head.php'; ?>

<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="page-wrapper">
            <div class="content">
                <div class="row">

                    <!-- Admin Tile -->
                 <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM admin");
                        $result->execute();
                        $row = $result->fetch();
                        ?>
                        <a href="users.php">
                            <div class="dash-widget" style="height: 120px;">
                                <span class="dash-widget-bg7"><i class="fa fa-user"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $row['total']; ?></h3>
                                    <span class="widget-title7">Admin <i class="fa fa-check"></i></span>
                                </div>
                            </div>
                        </a>                        
                    </div>
             
                    <!-- Agency Tile -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM agency");
                        $result->execute();
                        $row = $result->fetch();
                        ?>
                        <a href="agency.php">
                            <div class="dash-widget" style="height: 120px;">
                                <span class="dash-widget-bg5"><i class="fa fa-ambulance"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $row['total']; ?></h3>
                                    <span class="widget-title5">Agency <i class="fa fa-check"></i></span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Users Tile -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM users");
                        $result->execute();
                        $row = $result->fetch();
                        ?>
                        <a href="users1.php">
                            <div class="dash-widget" style="height: 120px;">
                                <span class="dash-widget-bg6"><i class="fa fa-user-o"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $row['total']; ?></h3>
                                    <span class="widget-title6">Users <i class="fa fa-check"></i></span>
                                </div>
                            </div>
                        </a>                        
                    </div>

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

                    <!-- Reported Tile -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending'");
                        $result->execute();
                        $row = $result->fetch();
                        ?>
                        <a href="view-emergency.php?status=Pending">
                            <div class="dash-widget">
                                <span class="dash-widget-bg3"><i class="fa fa-user-md"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $row['total']; ?></h3>
                                    <span class="widget-title3">Reported <i class="fa fa-check"></i></span>
                                </div>
                            </div>
                        </a>
                    </div>


                    <!-- Ongoing Emergencies Tile -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Ongoing'");
                        $result->execute();
                        $row = $result->fetch();
                        ?>
                        <a href="view-emergency.php?status=Ongoing">
                            <div class="dash-widget">
                                <span class="dash-widget-bg4"><i class="fa fa-heartbeat"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $row['total']; ?></h3>
                                    <span class="widget-title4">Ongoing <i class="fa fa-check"></i></span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Resolved Tile -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Resolved'");
                        $result->execute();
                        $row = $result->fetch();
                        ?>
                        <a href="view-emergency.php?status=Resolved">
                            <div class="dash-widget">
                                <span class="dash-widget-bg2"><i class="fa fa-check"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $row['total']; ?></h3>
                                    <span class="widget-title2">Resolved <i class="fa fa-check"></i></span>
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
                                <h4 class="card-title">Agencies and Users</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="agencyUserChart" width="800" height="800" style="max-width: 300px; margin: auto;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Emergency Distribution</h4>
                            </div>
                            <div class="card-body">
                                <!-- Match this height with Agencies vs Users -->
                                <canvas id="pieChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
             
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Emergency Reports per Municipality</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="barChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Logout Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">Are you sure you want to log out?</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- JS & Chart Scripts -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

        <script>Chart.register(ChartDataLabels);</script>

        <script>
        // Animated Counters
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

        <!-- Emergencies Per Month -->
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
        new Chart(document.getElementById('emergencyChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,    
                datasets: [{
                    label: 'Emergencies Per Month',
                    data: <?php echo json_encode($totals); ?>,
                    backgroundColor: 'rgba(72, 140, 220, 0.7)',
                    borderColor: 'rgba(72, 140, 220, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { datalabels: { display: false } },
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
        new Chart(document.getElementById('agencyUserChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Agencies', 'Users'],
                datasets: [{
                    data: [<?php echo $agencyCount; ?>, <?php echo $userCount; ?>],
                    backgroundColor: [
                            '#4e73df', '#1cc88a', '#36b9cc',
                            '#f6c23e', '#e74a3b', '#858796', '#5a5c69'
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
            },
            options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: { display: false }, // <-- disables numbers inside pie slices
                        legend: {
                            position: 'right',
                            labels: { color: '#333', usePointStyle: true, pointStyle: 'circle' }
                        }
                    }
                }
            });

        </script>

        <!-- Emergency Reports Per Agency & Distribution -->
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const barCtx = document.getElementById('barChart').getContext('2d');
            const pieCtx = document.getElementById('pieChart').getContext('2d');

            const labels = [];
            const data = [];

            <?php
            $stmt = $db->prepare("SELECT a.agency_name, COUNT(e.id) as total FROM emergency e INNER JOIN agency a ON e.agency_id = a.agency_id GROUP BY a.agency_name");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                echo "labels.push('" . $row['agency_name'] . "');";
                echo "data.push(" . $row['total'] . ");";
            }
            ?>

            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Reports',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        datalabels: { display: false } // <-- disables numbers inside bars
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            '#4e73df', '#1cc88a', '#36b9cc',
                            '#f6c23e', '#e74a3b', '#858796', '#5a5c69'
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: { display: false }, // <-- disables numbers inside pie slices
                        legend: {
                            position: 'right',
                            labels: { color: '#333', usePointStyle: true, pointStyle: 'circle' }
                        }
                    }
                }
            });
        });
        </script>

    </div>
</body>
</html>
