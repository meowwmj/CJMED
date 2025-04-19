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
                    <h4 class="page-title">Edit Profile</h4>
                </div>

                <?php
                $admin_id = $_SESSION['SESS_MEMBER_ID'];

                $stmt = $db->prepare("SELECT * FROM agency WHERE id = ?");
                $stmt->execute([$admin_id]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$admin) {
                    die("Admin not found.");
                }

                // Handle form submission
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $agency_name     = $_POST['agency_name'];
                    $email    = $_POST['email'];
                    $phone_number    = $_POST['phone_number'];
                    $username = $_POST['username'];
                    $address  = $_POST['address'];
                    $photo    = $admin['photo']; // Default to existing photo

                    // File upload
                    if (!empty($_FILES['photo']['name'])) {
                        $targetDir = "../../uploads/";
                        $fileName = basename($_FILES['photo']['name']);
                        $targetFilePath = $targetDir . $fileName;

                        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
                            $photo = $fileName;
                        } else {
                            echo "<div class='alert alert-danger'>Failed to upload photo.</div>";
                        }
                    }

                    // Update agency record
                    $stmt = $db->prepare("UPDATE agency SET agency_name=?, email=?, phone_number=?, username=?, address=?, photo=? WHERE id=?");
                    $stmt->execute([$agency_name, $email, $phone_number, $username, $address, $photo, $admin_id]);

                    // Update session variables
                    $_SESSION['SESS_AGENCY_NAME']   = $agency_name;
                    $_SESSION['SESS_USERNAME']      = $username;
                    $_SESSION['SESS_EMAIL']         = $email;
                    $_SESSION['SESS_PHONE_NUMBER']  = $phone_number;
                    $_SESSION['SESS_ADDRESS']       = $address;
                    $_SESSION['SESS_PRO_PIC']       = $photo;

                    // Redirect to profile page
                    echo "<script>window.location.href = 'profile.php';</script>";
                    exit;
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
                                    if (!empty($admin['photo'])) {
                                        echo '<img class="rounded-circle" src="../../uploads/' . $admin['photo'] . '" width="24" height="24">';
                                    } else {
                                        echo '<img class="rounded-circle" src="../../uploads/default.jpg" width="24" height="24">';
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $result = $db->prepare("SELECT * FROM admin WHERE id = :post_id");
                                $result->bindParam(':post_id', $id);
                                $result->execute();
                                $row = $result->fetch();
                            ?>
                            <div class="profile-basic">
                                <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Agency Name</label>
                                                <input class="form-control" type="text" name="agency_name" value="<?php echo $admin['agency_name']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input class="form-control" type="text" name="username" value="<?php echo $admin['username']; ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input class="form-control" type="text" name="address" value="<?php echo $admin['address']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" type="email" name="email" value="<?php echo $admin['email']; ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input class="form-control" type="text" name="phone_number" value="<?php echo $admin['phone_number']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Profile Picture</label>
                                                <input class="form-control" type="file" name="photo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-t-20 text-center">
                                        <button class="btn btn-primary submit-btn">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/message.php'; ?>
    <div class="sidebar-overlay" data-reff=""></div>

    <!-- JS -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/app.js"></script>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Are you sure you want to log out?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Styles -->
    <style>
        .form-group label {
            font-weight: 400;
            color: #333;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
        }
    </style>
</body>
</html>
