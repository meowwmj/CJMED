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
                            <a href="view-emergency.php"><i class="fa fa-file"></i> <span>Emergency</span></a>
                        </li>
                        <li>
                            <a href="announcement.php"><i class="fa fa-bell"></i> <span>Announcements</span></a>
                        </li>           
                        <li>
                            <a href="report_history.php"><i class="fa fa-file-text-o"></i> <span>Reports History</span></a>
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

       <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-7 col-6">
                        <h4 class="page-title">My Profile</h4>
                    </div>
                 <!--<div class="col-sm-5 col-6 text-right m-b-30">
                        <a href="edit_profile.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Edit Profile</a>
                    </div>-->
                </div>
                <div class="card-box profile-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
 				<?php
                                    if (!empty($_SESSION['SESS_PRO_PIC'])) {
                                        echo '<img class="rounded-circle" src="../../uploads/' . $_SESSION['SESS_PRO_PIC'] . '" width="24" height="24">';
                                    } else {
                                        echo '<img class="rounded-circle" src="../../uploads/default.jpg" width="24" height="24">';
                                    }
                                ?>                                   
				    </div>
                                </div>
                                <div class="profile-basic">
                                    
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0"><?php echo $_SESSION['SESS_FIRST_NAME'];?></h3>
                                                <small class="text-muted">Users</small><br>
                                                <div class="staff-id">USER-<?php echo $_SESSION['SESS_AGENCY_ID'];?></div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">

                                                <li>
                                                    <span class="title">Phone:</span>
                                                    <span class="text"><?php echo $_SESSION['SESS_PHONE_NUMBER'];?></a></span>
                                                </li>
                                                <li>
                                                    <span class="title">Username:</span>
                                                    <span class="text"><?php echo $_SESSION['SESS_USERNAME'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Email:</span>
                                                    <span class="text"><?php echo $_SESSION['SESS_EMAIL'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Address:</span>
                                                    <span class="text"><?php echo $_SESSION['SESS_ADDRESS'];?></span>
                                                </li>
                                               
                                            </ul>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
                
				
            </div>
        </div>
    </div>

    <?php include 'includes/message.php'; ?>
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/app.js"></script>


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

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html> 
