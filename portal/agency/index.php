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

                <!-- Agency Table -->
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                      <div class="card member-panel">
                        <div class="card-header bg-white">
                                    <h4 class="card-title d-inline-block">Agency</h4> <a href="agency.php" class="btn btn-primary float-right">View all</a>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Agency</th>
                                                    <th>Contact</th>
                                                    <th>Person In Charge</th>
                                                </tr>   
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = $db->prepare("SELECT * FROM agency ORDER BY id DESC LIMIT 5");
                                            $result->execute();
                                            for ($i = 1; $row = $result->fetch(); $i++) {
                                            ?>
                                                <tr>
                                                    <td style="min-width: 200px;">
                                                        <h2><a href="#"><?php echo $row['agency_name']; ?> <span><?php echo $row['state']; ?></span></a></h2>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0"><?php echo $row['email']; ?></h5>
                                                        <p><?php echo $row['phone_number']; ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0"><?php echo $row['personincharge']; ?></h5>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card member-panel">
                            <div class="card-header bg-white">
                                    <h4 class="card-title d-inline-block">Users</h4></a>
                                </div>
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <?php
                                    $result = $db->prepare("SELECT * FROM users");
                                    $result->execute();
                                    for ($i = 1; $row = $result->fetch(); $i++) {
                                    ?>
                                        <ul class="contact-list">
                                            <li>
                                                <div class="contact-cont">
                                                    <div class="float-left user-img m-r-10">
                                                        <a href="#" title="John Doe"><img src="../../uploads/<?php echo $row['photo']; ?>" class="rounded-circle m-r-5" width="28" height="28"></a>
                                                    </div>
                                                    <div class="contact-info">
                                                        <span class="contact-name text-ellipsis"><?php echo $row['username']; ?></span>
                                                        <span class="contact-date"><?php echo $row['phone']; ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    <?php } ?>
                                </table>
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

                <?php include 'includes/Message.php'; ?>
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
                type: 'line',  // Line chart to visualize trends
                data: {
                    labels: months,  // These labels will be displayed on the X-axis
                    datasets: [{
                        label: 'Emergencies Per Month',
                        data: emergencyCounts,  // This will be plotted on the Y-axis
                        backgroundColor: 'rgba(72, 140, 220, 0.2)',  // Light blue background
                        borderColor: 'rgba(72, 140, 220, 1)',        // Dark blue border
                        borderWidth: 2,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)', // Dark background for tooltip
                            titleColor: '#fff', // White title color
                            bodyColor: '#fff', // White body color
                            footerColor: '#fff', // White footer color
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
                                color: '#555', // Subtle gray text
                            },
                            grid: {
                                display: false, // No grid lines for X-axis
                            }
                        },
                        y: {
                            ticks: {
                                font: {
                                    family: 'Arial, sans-serif',
                                    size: 14,
                                    weight: 'bold'
                                },
                                color: '#555', // Subtle gray text for Y-axis labels
                                beginAtZero: true,
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)', // Very light grid lines
                                borderColor: 'rgba(0, 0, 0, 0.1)', // Light border color
                            }
                        }
                    },
                    elements: {
                        line: {
                            tension: 0.4, // Smooth curve for the line chart
                        },
                        point: {
                            radius: 5, // Size of the points on the chart
                            hoverRadius: 7, // Larger point on hover
                        }
                    },
                    layout: {
                        padding: {
                            top: 20, // Add some padding for better spacing
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
