<?php include 'includes/head.php'; ?>

<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <?php include 'includes/sidebar.php'; ?>    
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
                            <a href="rescue.php"><i class="	fa fa-calendar-o"></i> <span>Rescue</span></a> 
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">All</option>
                            <option value="Pending">Ongoing</option>
                            <option value="Resolved">Resolved</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary" id="print-btn"><i class="fa fa-print"></i> Print</button>
                    </div>
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
                                            $statusFilter = isset($_GET['status']) ? $_GET['status'] : ''; // Get the status filter from GET request
                                            $sql = "SELECT e.*, a.agency_name FROM emergency e INNER JOIN agency a ON e.agency_id = a.agency_id";

                                            if ($statusFilter) {
                                                $sql .= " WHERE e.status = :status";
                                            }

                                            $stmt = $db->prepare($sql);
                                            if ($statusFilter) {
                                                $stmt->bindParam(':status', $statusFilter);
                                            }
                                            $stmt->execute();
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
                                                        echo "<span class='badge badge-danger'>Ongoing</span>";
                                                    } else {
                                                        echo "<span class='badge badge-success'>Resolved</span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center"><?php echo $row['created_at']; ?></td>
                                                <td class="text-center"> 
                                                    <a class="btn btn-primary" href="make_action.php?id=<?php echo $row['id'];?>"><i class="fa fa-eye"></i></a> 
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

    <!-- Include JS Files -->
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
            $('#status').change(function () {
                var status = $(this).val();

                $.ajax({
                    url: 'view-emergency.php',
                    type: 'GET',
                    data: { status: status },
                    success: function (response) {
                        $('#emergency-table-body').html($(response).find('#emergency-table-body').html());
                    },
                    error: function () {
                        alert('Error retrieving search results.');
                    }
                });
            });
        });
    </script>
</body>
</html>
