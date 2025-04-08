<?php include 'includes/head.php'; ?>

<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="">
                            <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        <li>
                            <a href="announcement.php"><i class="fa fa-bell"></i> <span>Announcements</span></a>
                        </li>
                        <li class="">
                            <a href="agency.php"><i class="fa fa-user-md"></i> <span>Agency</span></a>
                        </li>
                        <li>
                            <a href="report-emergency.php"><i class="fa fa-heartbeat"></i> <span>Reports Emergency</span></a>
                        </li>
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending'");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){
                        ?>  
                        <li>
                            <a href="view-emergency.php"><i class="fa fa-file"></i> <span>Emergency</span> <span class="badge badge-pill btn-primary float-right"><?php echo $row['total'] ;?></span></a>
                        </li>
                        <?php } ?>

                        <li class="active">
                            <a href="report_history.php"><i class="fa fa-file-text-o"></i> <span>History</span></a>
                        </li>
                        <li>                          
                            <a href="view-archived-emergencies.php"><i class="fa fa-file"></i> <span>Archived</span></a>
                        </li>
                        <li>
                            <a href="users.php"><i class="fa fa-user-plus"></i> <span>Manage Admin</span></a>
                        </li>
                        <li>
                            <a href="users1.php"><i class="fa fa-user"></i> <span>Manage Users</span></a>
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
                <div class="col-sm-4 col-3">
                    <h4 class="page-title">My History</h4>
                </div>

                <!-- Filters on the right: Year, Month, and Day -->
                <div class="col-sm-8 col-9 text-right m-b-20">
                    <form method="GET" action="" id="history-form">
                        <select name="year" class="form-control d-inline-block" style="width: auto;" onchange="this.form.submit()">
                            <option value="">Select Year</option>
                            <?php
                            // Fetch years from your data or set a range
                            for ($y = 2025; $y <= date('Y'); $y++) {
                                echo '<option value="' . $y . '" ' . ($_GET['year'] == $y ? 'selected' : '') . '>' . $y . '</option>';
                            }
                            ?>
                        </select>

                        <select name="month" class="form-control d-inline-block" style="width: auto;" onchange="this.form.submit()">
                            <option value="">Select Month</option>
                            <?php
                            // Fetch months
                            for ($m = 1; $m <= 12; $m++) {
                                echo '<option value="' . $m . '" ' . ($_GET['month'] == $m ? 'selected' : '') . '>' . date("F", mktime(0, 0, 0, $m, 10)) . '</option>';
                            }
                            ?>
                        </select>

                        <select name="day" class="form-control d-inline-block" style="width: auto;" onchange="this.form.submit()">
                            <option value="">Select Day</option>
                            <?php
                            // Generate day options (1 to 31)
                            for ($d = 1; $d <= 31; $d++) {
                                echo '<option value="' . $d . '" ' . ($_GET['day'] == $d ? 'selected' : '') . '>' . $d . '</option>';
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
                            <div class="experience-box">
                            <?php
                            // Get selected year, month, and day
                            $year = isset($_GET['year']) ? $_GET['year'] : '';
                            $month = isset($_GET['month']) ? $_GET['month'] : '';
                            $day = isset($_GET['day']) ? $_GET['day'] : '';

                            // Start building the SQL query
                            $query = "SELECT e.*, a.agency_name FROM emergency e INNER JOIN agency a ON e.agency_id = a.agency_id";

                            // Build the WHERE clause dynamically based on the selected filters
                            $conditions = [];
                            if ($year) {
                                $conditions[] = "YEAR(e.created_at) = :year";
                            }
                            if ($month) {
                                $conditions[] = "MONTH(e.created_at) = :month";
                            }
                            if ($day) {
                                $conditions[] = "DAY(e.created_at) = :day";
                            }

                            // Add the conditions to the query
                            if (!empty($conditions)) {
                                $query .= " WHERE " . implode(' AND ', $conditions);
                            }

                            // Prepare and execute the query
                            $result = $db->prepare($query);

                            // Bind the parameters
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

                            // Display the title based on the selected filters
                            if ($result->rowCount() > 0) {
                                echo '<h3 class="card-title">History for ' . ($year ? $year : '') . ($month ? ' ' . date("F", mktime(0, 0, 0, $month, 10)) : '') . ($day ? ' ' . $day : '') . '</h3>';
                            } else {
                                echo '<h3 class="card-title">No History for selected filters</h3>';
                            }
                            ?>
                            </div>
                        </div>

                        <div class="experience-box">
                            <ul class="experience-list">
                                <?php
                                // If records exist, display them
                                if ($result->rowCount() > 0) {
                                    for ($i = 1; $row = $result->fetch(); $i++) {
                                ?> 
                                        <li>
                                            <div class="experience-user">
                                                <div class="before-circle"></div>
                                            </div>
                                            <div class="experience-content"><?php echo $row['created_at']; ?>
                                                <div class="experience-content">You Reported <?php echo $row['emergency_category']; ?>                        
                                                    <div class="content">at <?php echo $row['agency_name']; ?>
                                                        <div class="content">on <?php echo $row['address']; ?>, Bulacan
                                                            <div class="content"><?php echo date('m/d/Y'); ?></span>
                                                        </div>  
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                <?php } 
                                else { ?>
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
    <script src="assets/js/app.js"></script>
</body>
</html>
