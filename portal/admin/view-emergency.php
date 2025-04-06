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
                        <li>
                            <a href="agency.php"><i class="fa fa-user-md"></i> <span>Agency</span></a>
                        </li>
                        <li>
                            <a href="report-emergency.php"><i class="fa fa-heartbeat"></i> <span>Reports Emergency</span></a>
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
                            <a href="rescue.php"><i class="	fa fa-calendar-o"></i> <span>Rescue</span></a> 
                        </li>
                        <li>
                            <a href="logout.php"><i class="fa fa-power-off"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>    
    </div>

         <!-- Page Wrapper -->
         <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Emergency Incident Reports</h4> <!-- Updated Title -->
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
                            <button class="btn btn-primary" id="search-btn"><i class="fa fa-search"></i> Search</button>
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
                                            <th class="text-center"><strong>No.</th>
                                            <th class="text-center"><strong>Case ID</th>
                                            <th class="text-center"><strong>Name</th>
                                            <th class="text-center"><strong>Agency Name</th>
                                            <th class="text-center"><strong>Issue</th>
                                            <th class="text-center"><strong>Address</th>
                                            <th class="text-center"><strong>Status</th>
                                            <th class="text-center"><strong>Date</th>
                                            <th class="text-center"><strong>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php
                                            $result = $db->prepare("SELECT e.*, a.agency_name FROM emergency e INNER JOIN agency a ON e.agency_id = a.agency_id");
                                            $result->execute();
                                            for($i=1; $row = $result->fetch(); $i++){ 
                                        ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i; ?></td>
                                                <td class="text-center"><?php echo $row['emergency_id']; ?></td>
                                                <td class="text-center"><?php echo $row['patient_name']; ?></td>
                                                <td class="text-center"><?php echo $row['agency_name']; ?></td>
                                                <td class="text-center"><?php echo $row['emergency_category']; ?></td>
                                                <td class="text-center"><?php echo $row['address']; ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    if($row['status'] == "Pending"){
                                                        echo "<span class='badge badge-danger'>Ongoing</span>";   
                                                    } else {
                                                        echo "<span class='badge badge-success'>Resolved</span>";
                                                    }     
                                                    ?>   
                                                </td>
                                                <td class="text-center"><?php echo date('m/d/Y'); ?></td>
                                                <td class="text-center"> 
                                                    <a class="btn btn-primary" href="make_action.php?id=<?php echo $row['id'];?>"><i class="fa fa-eye"></i></a> 
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-danger" href="delete_emergency.php?id=<?php echo $row['id']; ?>"><i class="fa fa-trash-o"></i></a>
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
        $('#print-btn').click(function () {
            var printContents = $('.table-responsive').clone();
            printContents.find('.text-right').remove();
            printContents.find('.dataTables_paginate').remove();
            printContents.find('.dataTables_info').remove();
            printContents.find('label').remove();
            printContents.find('.dataTables_length').remove();

            var originalContents = $('body').html();
            var printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write('<link rel="stylesheet" href="assets/css/bootstrap.min.css">');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<div class="col-md-12">');
            printWindow.document.write('<h2 class="emergency-heading">Emergency Incident Reports</h2>'); <!-- Updated Heading -->
            printWindow.document.write('<div class="table-responsive">');
            printWindow.document.write(printContents.html());
            printWindow.document.write('</div></div></body></html>');
            printWindow.document.close();

            printWindow.onload = function () {
                printWindow.print();
                printWindow.close();
            };
        });
    });
    </script>

</body>
</html>
