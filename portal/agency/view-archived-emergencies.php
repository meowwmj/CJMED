<?php include 'includes/head.php'; ?>

<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        <li>
                            <a href="announcement.php"><i class="fa fa-bell"></i> <span>Announcements</span></a>
                        </li>
                        <li>
                            <a href="report-emergency.php"><i class="fa fa-heartbeat"></i> <span>Report Emergency</span></a>
                        </li>
                        <?php
                            // include('../connect.php');
                            $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending'");
                            $result->execute();
                            for($i=0; $row = $result->fetch(); $i++){
                            ?>  
                            <li>
                                <a href="view-emergency.php"><i class="fa fa-file"></i> <span>Emergency</span> <span class="badge badge-pill btn-primary float-right"><?php echo $row['total'] ;?></span></a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="report_history.php"><i class="fa fa-file-text-o"></i> <span>History</span></a>
                        </li>
                        <li class="active">                          
                            <a href="view-archived-emergencies.php"><i class="fa fa-archive"></i> <span>Archived</span></a>
                        </li>
                        <li>
                            <a href="profile.php"><i class="fa fa-user"></i> <span>Profile</span></a>
                        </li>
                        <li>
                            <a href="rescue.php"><i class="fa fa-calendar-o"></i> <span>Rescue</span></a> 
                        </li>
                        <li>
                            <a href="logout.php"><i class="fa fa-power-off"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
            <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-7 col-6">
                        <h3 class="page-title">Archived Emergencies</h3>
                    </div>

                    <!-- Filters: Year, Month, Day -->
                    <div class="col-sm-5 col-6 text-right m-b-20">
                        <form method="GET" action="" id="history-form">
                            <!-- Year Filter -->
                            <select name="year" class="form-control d-inline-block" style="width: auto;" onchange="this.form.submit()">
                                <option value="">Select Year</option>
                                <option value="<?php echo date('Y'); ?>" <?php echo (isset($_GET['year']) && $_GET['year'] == date('Y') ? 'selected' : ''); ?>><?php echo date('Y'); ?></option>
                            </select>

                            <!-- Month Filter -->
                            <select name="month" class="form-control d-inline-block" style="width: auto;" onchange="this.form.submit()">
                                <option value="">Select Month</option>
                                <?php
                                for ($m = 1; $m <= 12; $m++) {
                                    echo '<option value="' . $m . '" ' . (isset($_GET['month']) && $_GET['month'] == $m ? 'selected' : '') . '>' . date("F", mktime(0, 0, 0, $m, 10)) . '</option>';
                                }
                                ?>
                            </select>

                            <!-- Day Filter -->
                            <select name="day" class="form-control d-inline-block" style="width: auto;" onchange="this.form.submit()">
                                <option value="">Select Day</option>
                                <?php
                                for ($d = 1; $d <= 31; $d++) {
                                    echo '<option value="' . $d . '" ' . (isset($_GET['day']) && $_GET['day'] == $d ? 'selected' : '') . '>' . $d . '</option>';
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Archived History</h3>
                            </div>
                            <div class="experience-box">
                                <ul class="experience-list">
                                    <?php
                                    // Use isset() to check if the key exists before accessing
                                    $year = isset($_GET['year']) ? $_GET['year'] : '';
                                    $month = isset($_GET['month']) ? $_GET['month'] : '';
                                    $day = isset($_GET['day']) ? $_GET['day'] : '';

                                    // Build the SQL query with dynamic filtering for year, month, and day
                                    $query = "SELECT e.*, a.agency_name FROM emergency_history e INNER JOIN agency a ON e.agency_id = a.agency_id";

                                    // Add filters based on the selected year, month, and day
                                    $conditions = [];
                                    if ($year) {
                                        $conditions[] = "YEAR(e.deleted_at) = :year";
                                    }
                                    if ($month) {
                                        $conditions[] = "MONTH(e.deleted_at) = :month";
                                    }
                                    if ($day) {
                                        $conditions[] = "DAY(e.deleted_at) = :day";
                                    }

                                    if (!empty($conditions)) {
                                        $query .= " WHERE " . implode(' AND ', $conditions);
                                    }

                                    // Prepare and execute the query
                                    $result = $db->prepare($query);

                                    // Bind parameters if filters are selected
                                    if ($year) {
                                        $result->bindParam(':year', $year, PDO::PARAM_INT);
                                    }
                                    if ($month) {
                                        $result->bindParam(':month', $month, PDO::PARAM_INT);
                                    }
                                    if ($day) {
                                        $result->bindParam(':day', $day, PDO::PARAM_INT);
                                    }

                                    $result->execute();

                                    // Check if any records exist for the selected filters
                                    if ($result->rowCount() > 0) {
                                        // Fetch and display each archived emergency
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <li>
                                            <div class="experience-user">
                                                <div class="before-circle"></div>
                                            </div>
                                            <div class="experience-content"><?php echo $row['deleted_at']; ?>
                                                <div class="experience-content">You Reported <?php echo $row['emergency_category']; ?>                        
                                                    <div class="content">at <?php echo $row['agency_name']; ?>
                                                        <div class="content">on <?php echo $row['address']; ?>, Bulacan
                                                            <div class="content"><?php echo date('m/d/Y'); ?></span>
                                                        </div>  
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php
                                        }
                                    } else { ?>
                                        <li>
                                            <div class="experience-user">
                                                <div class="before-circle"></div>
                                            </div>
                                            <div class="experience-content">
                                                <p>No history found for this selection.</p>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
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

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
