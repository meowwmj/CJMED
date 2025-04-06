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
                        <li>
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending' ORDER BY id DESC ");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){ ?>
                    <li><a href="view-emergency.php"><i class="fa fa-file"></i> <span>Emergency</span> <span class="badge badge-pill btn-primary float-right"><?php echo $row['total'] ;?></span></a></li>
                    <?php } ?>
                        </li>
                        <li>
                            <a href="announcement.php"><i class="fa fa-bell"></i> <span>Announcements</span></a>
                        </li>           
                        <li>
                            <a href="report_history.php"><i class="fa fa-file-text-o"></i> <span>History</span></a>
                        </li>
                        <li class="active">                           
                            <a href="view-archived-emergencies.php"><i class="fa fa-file"></i> <span>Archived</span></a>
                        </li>
                        <li>
                            <a href="rescue.php"><i class="fa fa-file-text-o"></i> <span>Rescue</span></a>
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
                        <h4 class="page-title">Archived Emergencies</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box mb-0">
                            <h3 class="card-title">Archived History</h3>
                            <div class="experience-box">
                                <ul class="experience-list">
                                    <?php
                                    // Query to fetch archived emergencies from the `emergency_history` table
                                    $result = $db->prepare("SELECT e.*, a.agency_name FROM emergency_history e INNER JOIN agency a ON e.agency_id = a.agency_id ORDER BY e.deleted_at DESC");
                                    $result->execute();

                                    // Fetch and display each archived emergency
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
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
                                    </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
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
