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
                        <?php
                        // include('../connect.php');
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending'");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){
                        ?>  
                        <li class="">
                            <a href="view-emergency.php"><i class="fa fa-file"></i> <span>Emergency</span> <span class="badge badge-pill btn-primary float-right"><?php echo $row['total'] ;?></span></a>
                        </li>
                    <?php } ?>
                        <li>
                            <a href="report_history.php"><i class="fa fa-file-text-o"></i> <span>History</span></a>
                        </li>
                        <li>                          
                            <a href="view-archived-emergencies.php"><i class="fa fa-archive"></i> <span>Archived</span></a>
                        </li>
                      <li>
                            <a href="#"><i class="fa fa-users"></i> <span>Manage</span> <span class="menu-arrow"></span></a>
                            <ul class="submenu-list">
                                <li>
                                    <a href="users.php"><i class="fa fa-user-plus"></i> <span>Manage Admin</span></a>
                                </li>
                                <li>
                                    <a href="users1.php"><i class="fa fa-user"></i> <span>Manage Users</span></a>                        
                                </li>
                            </ul>
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

                                // Assuming you want to update the database
                                // You can perform a database update query here to persist the changes
                                // Example:
                                // $update_query = "UPDATE users SET first_name = ?, phone_number = ?, email = ?, address = ?, profile_pic = ? WHERE id = ?";
                                // $stmt = $db->prepare($update_query);
                                // $stmt->execute([$new_first_name, $new_phone_number, $new_email, $new_address, $new_profile_pic, $user_id]);

                                echo '<div class="alert alert-success">Profile updated successfully!</div>';
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<style>
.submenu-list {
    list-style: none;
    padding-left: 20px;
    margin: 0; /* Remove any margin */
    background-color: #2c3e50; /* Ensure the background blends with the sidebar */
}   
.submenu-list li {
    margin: 0;
    background-color: #2c3e50; 
    padding: 0px;
    padding-top: 10px;
}

.submenu-list a {
    background-color: #2c3e50;
    text-decoration: none;
    font-size: 15px;
    padding: 10px;
    display: block;
    border-radius: 25px;
    transition: all 0.3s ease;
}

.submenu-list a:hover,
.submenu-list .active a {
    background-color: #fff;
    color: #2c3e50;
}
</style>
