<<div class="sidebar" id="sidebar">
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
                        <h4 class="page-title">Edit Profile</h4>
                    </div>

                    <?php
                            // Fetch current user details from the session or database
                            $user_id = $_SESSION['SESS_MEMBER_ID'];
                            $first_name = $_SESSION['SESS_FIRST_NAME'];
                            $phone_number = $_SESSION['SESS_PHONE_NUMBER'];
                            $email = $_SESSION['SESS_EMAIL'];
                            $address = $_SESSION['SESS_ADDRESS'];
                            $profile_pic = $_SESSION['SESS_PRO_PIC'];

                            // Handle form submission for updating profile
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                // Sanitize and process form input data
                                $new_first_name = htmlspecialchars($_POST['first_name']);
                                $new_phone_number = htmlspecialchars($_POST['phone_number']);
                                $new_email = htmlspecialchars($_POST['email']);
                                $new_address = htmlspecialchars($_POST['address']);

                                // Handle profile picture upload (if a new image is uploaded)
                                if ($_FILES['profile_pic']['error'] == 0) {
                                    $target_dir = "uploads/";
                                    $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
                                    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file);
                                    $new_profile_pic = basename($_FILES["profile_pic"]["name"]);
                                } else {
                                    $new_profile_pic = $profile_pic;
                                }

                                // Update session variables
                                $_SESSION['SESS_FIRST_NAME'] = $new_first_name;
                                $_SESSION['SESS_PHONE_NUMBER'] = $new_phone_number;
                                $_SESSION['SESS_EMAIL'] = $new_email;
                                $_SESSION['SESS_ADDRESS'] = $new_address;
                                $_SESSION['SESS_PRO_PIC'] = $new_profile_pic;

                                // $update_query = "UPDATE users SET first_name = ?, phone_number = ?, email = ?, address = ?, profile_pic = ? WHERE id = ?";
                                // $stmt = $db->prepare($update_query);
                                // $stmt->execute([$new_first_name, $new_phone_number, $new_email, $new_address, $new_profile_pic, $user_id]);
                            }
                        ?>


                    <div class="col-sm-5 col-6 text-right m-b-30">
                        <a href="profile.php" class="btn btn-primary btn-rounded"><i class="fa fa-user"></i> View Profile</a>
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
                                    ?>                                
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input class="form-control" type="text" name="first_name" value="<?php echo $first_name; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <input class="form-control" type="text" name="phone_number" value="<?php echo $phone_number; ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input class="form-control" type="email" name="email" value="<?php echo $email; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input class="form-control" type="text" name="address" value="<?php echo $address; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Profile Picture</label>
                                            <input class="form-control" type="file" name="profile_pic">
                                        </div>
                                            </div></div>

                                        <div class="m-t-20 text-center">
                                            <button class="btn btn-primary submit-btn">Update Profile</button>
                                        </div>
                                    </form>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html> 
