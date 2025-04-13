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
                        <div class="card-header">
                                <h4 class="card-title">Emergencies Per Month</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="emergencyChart" width="400" height="200"></canvas>
                            </div>
                                </div>
                            </div>
                        </div>


                        <!-- Agencies vs Users -->
                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                            <div class="card member-panel">
                                <div class="card-header bg-white">
                                <div class="card-header">
                                    <h4 class="card-title">Agencies vs Users</h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="agencyUserChart" height="100"></canvas>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

               <!-- Emergency Chart Section -->
               <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Emergencies Per Month</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="emergencyChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

        <!-- Logout Confirmation Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to log out?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-overlay" data-reff=""></div>

        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/Chart.bundle.js"></script>
        <script src="assets/js/chart.js"></script>
        <script src="assets/js/app.js"></script>

        <script>
            // PHP query to get the number of emergencies per month
            <?php
                // Query to fetch count of emergencies grouped by month and year
                $query = $db->prepare("SELECT YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total FROM emergency GROUP BY YEAR(created_at), MONTH(created_at) ORDER BY year ASC, month ASC");
                $query->execute();
                $emergencyData = $query->fetchAll(PDO::FETCH_ASSOC);

                // Prepare the data for the chart
                $months = [];
                $totals = [];
                foreach ($emergencyData as $row) {
                    $months[] = date('F Y', strtotime($row['year'] . '-' . $row['month'] . '-01')); // Format date as "Month Year"
                    $totals[] = $row['total'];
                }   
            ?>

            // Prepare the data for the chart
            var months = <?php echo json_encode($months); ?>;
            var emergencyCounts = <?php echo json_encode($totals); ?>;

            var ctx = document.getElementById('emergencyChart').getContext('2d');

            // Create the Chart
            var emergencyChart = new Chart(ctx, {
    type: 'bar',  // Changed from 'line' to 'bar'
    data: {
        labels: months,
        datasets: [{
            label: 'Emergencies Per Month',
            data: emergencyCounts,
            backgroundColor: 'rgba(72, 140, 220, 0.7)',  // Slightly more solid for bars
            borderColor: 'rgba(72, 140, 220, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                footerColor: '#fff',
            }
        },
        scales: {
            x: {
                ticks: {
                    font: {
                        family: 'Arial, sans-serif',
                        weight: 'bold',
                        size: 14
                    },
                    color: '#555',
                },
                grid: {
                    display: false,
                }
            },
            y: {
                ticks: {
                    font: {
                        family: 'Arial, sans-serif',
                        size: 14,
                        weight: 'bold'
                    },
                    color: '#555',
                    beginAtZero: true,
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)',
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                }
            }
        },
        layout: {
            padding: {
                top: 20,
            }
        }
    }
});
</script>
    
<script>
    <?php
        // Fetch the count of agencies
        $agencyQuery = $db->prepare("SELECT COUNT(*) as total FROM agency");
        $agencyQuery->execute();
        $agencyCount = $agencyQuery->fetch()['total'];

        // Fetch the count of users
        $userQuery = $db->prepare("SELECT COUNT(*) as total FROM users");
        $userQuery->execute();
        $userCount = $userQuery->fetch()['total'];
    ?>

    // Prepare chart data
    var ctxAgencyUser = document.getElementById('agencyUserChart').getContext('2d');
    var agencyUserChart = new Chart(ctxAgencyUser, {
        type: 'pie',
        data: {
            labels: ['Agencies', 'Users'],
            datasets: [{
                label: 'Count',
                data: [<?php echo $agencyCount; ?>, <?php echo $userCount; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)', // Red
                    'rgba(54, 162, 235, 0.6)'  // Blue
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>


</body>
</html>

<style>
    .table-responsive {
        max-height: 250px; /* Adjust this height as needed */
        overflow-y: auto;
    }
</style>
