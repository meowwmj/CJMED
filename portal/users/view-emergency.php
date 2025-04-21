<?php include 'includes/head.php'; ?>

<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?> 
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li>
                            <a href="report-emergency.php"><i class="fa fa-heartbeat"></i> <span>Report Emergency</span></a>
                        </li> 
                        <li class="active">
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending' ORDER BY id DESC ");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){ ?>
                        <li class="active"><a href="view-emergency.php"><i class="fa fa-file"></i> <span>Emergency</span> <span class="badge badge-pill bg-primary float-right"><?php echo $row['total'] ;?></span></a></li>
                        <?php } ?>
                        </li>
                        <li>
                            <a href="announcement.php"><i class="fa fa-bell"></i> <span>Announcements</span></a>
                        </li>           
                        <li>
                            <a href="report_history.php"><i class="fa fa-file-text-o"></i> <span>History</span></a>
                        </li>
                         <li>
                            <a href="logout.php"><i class="fa fa-power-off"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
   <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-sm-4 col-3">
                    <h4 class="page-title">Emergency Incident Reports</h4>
                </div>
            </div>

          <!-- Filters Section -->
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control mx-1" name="status" id="status">
                            <option value="">All Status</option>
                            <option value="Pending">Reported</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Resolved">Resolved</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary " id="print-btn" style="margin-top: 3px;"><i class="fa fa-print"></i> Print</button>
                </div>

                <!-- Filters on the right: Year, Month, and Day -->
                <div class="col-md-7">
                    <form method="GET" action="" id="history-form" class="form-inline justify-content-end">
                        <select name="year" id="year" class="form-control mx-1">
                            <option value="">Year</option>
                            <?php
                            for ($y = 2025; $y <= date('Y'); $y++) {
                                echo '<option value="' . $y . '" ' . ($_GET['year'] == $y ? 'selected' : '') . '>' . $y . '</option>';
                            }
                            ?>
                        </select>

                        <select name="month" id="month" class="form-control mx-1">
                            <option value="">Month</option>
                            <?php
                            for ($m = 1; $m <= 4; $m++) {
                                echo '<option value="' . $m . '" ' . ($_GET['month'] == $m ? 'selected' : '') . '>' . date("F", mktime(0, 0, 0, $m, 10)) . '</option>';
                            }
                            ?>
                        </select>

                        <select name="day" id="day" class="form-control mx-1">
                            <option value="">Day</option>
                            <?php
                            for ($d = 1; $d <= 31; $d++) {
                                echo '<option value="' . $d . '" ' . ($_GET['day'] == $d ? 'selected' : '') . '>' . $d . '</option>';
                            }
                            ?>
                        </select>
                    </form>
                </div>
            </div>


            <!-- Emergency Report Table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="table-responsive print-table">
                                <table class="table table-bordered table-striped custom-table datatable mb-0" id="myTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><strong>No.</strong></th>
                                            <th class="text-center"><strong>Case ID</strong></th>
                                            <th class="text-center"><strong>Name</strong></th>
                                            <th class="text-center"><strong>Agency Name</strong></th>
                                            <th class="text-center"><strong>Issue</strong></th>
                                            <th class="text-center"><strong>Address</strong></th>
                                            <th class="text-center"><strong>Status</strong></th>
                                            <th class="text-center"><strong>Date</strong></th>
                                            <th class="text-center"><strong>Action</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody id="emergency-table-body">
                                        <?php
                                        $status = $_GET['status'] ?? '';
                                        $year = $_GET['year'] ?? '';
                                        $month = $_GET['month'] ?? '';
                                        $day = $_GET['day'] ?? '';

                                        $sql = "SELECT e.*, a.agency_name FROM emergency e INNER JOIN agency a ON e.agency_id = a.agency_id WHERE 1=1";
                                        $params = [];

                                        if (!empty($status)) {
                                            $sql .= " AND e.status = :status";
                                            $params[':status'] = $status;
                                        }
                                        if (!empty($year)) {
                                            $sql .= " AND YEAR(e.dates) = :year";
                                            $params[':year'] = $year;
                                        }
                                        if (!empty($month)) {
                                            $sql .= " AND MONTH(e.dates) = :month";
                                            $params[':month'] = $month;
                                        }
                                        if (!empty($day)) {
                                            $sql .= " AND DAY(e.dates) = :day";
                                            $params[':day'] = $day;
                                        }

                                        $stmt = $db->prepare($sql);
                                        $stmt->execute($params);
                                        $i = 1;

                                        while ($row = $stmt->fetch()) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <td class="text-center"><?php echo $row['emergency_id']; ?></td>
                                                <td class="text-center"><?php echo $row['patient_name']; ?></td>
                                                <td class="text-center"><?php echo $row['agency_name']; ?></td>
                                                <td class="text-center"><?php echo $row['emergency_category']; ?></td>
                                                <td class="text-center"><?php echo $row['address']; ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    if ($row['status'] == "Pending") {
                                                        echo "<span class='badge badge-warning'>Reported</span>";
                                                    } elseif ($row['status'] == "Ongoing") {
                                                        echo "<span class='badge badge-danger'>Ongoing</span>";
                                                    } else {
                                                        echo "<span class='badge badge-success'>Resolved</span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center"><?php echo $row['dates']; ?></td>
                                                <td class="text-center">
                                                    <a class="btn btn-primary" href="make_action.php?id=<?php echo $row['id']; ?>"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog"><div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Confirm Logout</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
            <div class="modal-body">Are you sure you want to log out?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div></div>
    </div>

    <!-- JS Scripts -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script>
        $(document).ready(function () {
            function fetchFilteredData() {
                const status = $('#status').val();
                const year = $('#year').val();
                const month = $('#month').val();
                const day = $('#day').val();
                $.get("view-emergency.php", { status, year, month, day }, function (data) {
                    $('#emergency-table-body').html($(data).find('#emergency-table-body').html());
                });
            }

            // Filter triggers
            $('#status, #year, #month, #day').on('change', fetchFilteredData);

            // Auto refresh
            setInterval(fetchFilteredData, 5000);

            // Print
            $('#print-btn').on('click', function () {
                var printContents = document.querySelector('.print-table').innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = `<html><head><title>Print Report</title></head><body>${printContents}</body></html>`;
                window.print();
                document.body.innerHTML = originalContents;
                location.reload();
            });
        });
    </script>

    <style>
        .badge-warning {
            background-color:rgb(232, 37, 40) !important;
            color:rgb(255, 255, 255) !important;
        }

        .badge-danger {
            background-color: #ffbc00 !important;
            color:rgb(255, 255, 255) !important;
        }
    </style>

</body>
</html>
