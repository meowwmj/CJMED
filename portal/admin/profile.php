<?php include 'includes/head.php'; ?>

<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <?php include 'includes/sidebar.php'; ?>    
    </div>
        
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-7 col-6">
                        <h4 class="page-title">My Profile</h4>
                    </div>
               <div class="col-sm-5 col-6 text-right m-b-30">
                        <a href="edit_profile.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i> Edit Profile</a>
                    </div>
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
                                    ?>                                    </div>
                                </div>

                                <div class="profile-basic">                                    
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0"><?php echo $_SESSION['SESS_FIRST_NAME'];?></h3>
                                                <small class="text-muted">Admin</small><br>
                                                <div class="staff-id">ADM-<?php echo $_SESSION['SESS_AGENCY_ID'];?></div>
                                                
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
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html> 
