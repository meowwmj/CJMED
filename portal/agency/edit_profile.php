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

                <div class="col-sm-5 col-6 text-right m-b-30">
                    <a href="profile.php" class="btn btn-primary btn-rounded"><i class="fa fa-user"></i> View Profile</a>
                </div>
            </div>

            <?php
            $admin_id = $_SESSION['SESS_MEMBER_ID'];

            $stmt = $db->prepare("SELECT * FROM agency WHERE id = ?");
            $stmt->execute([$admin_id]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$admin) {
                die("Admin not found.");
            }

            // AJAX form handler
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name     = $_POST['agency_name'];
                $email    = $_POST['email'];
                $phone    = $_POST['phone_number'];
                $username = $_POST['username'];
                $address  = $_POST['address'];
                $photo    = $admin['photo']; // Default to existing

                if (!empty($_FILES['photo']['name'])) {
                    $targetDir = "../../uploads/";
                    $fileName = basename($_FILES['photo']['name']);
                    $targetFilePath = $targetDir . $fileName;

                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
                        $photo = $fileName;
                    } else {
                        echo "error"; exit;
                    }
                }

                // Update
                $stmt = $db->prepare("UPDATE agency SET agency_name=?, email=?, phone_number=?, username=?, address=?, photo=? WHERE id=?");
                $stmt->execute([$name, $email, $phone, $username, $address, $photo, $admin_id]);

                // Session
                $_SESSION['SESS_AGENCY_NAME']   = $name;
                $_SESSION['SESS_USERNAME']      = $username;
                $_SESSION['SESS_EMAIL']         = $email;
                $_SESSION['SESS_PHONE_NUMBER']  = $phone;
                $_SESSION['SESS_ADDRESS']       = $address;
                $_SESSION['SESS_PRO_PIC']       = $photo;

                echo "success";
                exit;
            }
            ?>

            <div class="card-box profile-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <?php
                                    $imgSrc = !empty($admin['photo']) ? '../../uploads/' . $admin['photo'] : '../../uploads/default.jpg';
                                    echo '<img id="previewImg" class="rounded-circle" src="' . $imgSrc . '" width="60" height="60">';
                                    ?>
                                </div>
                            </div>

                            <div class="profile-basic">
                                <form id="editProfileForm" method="POST" enctype="multipart/form-data">
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
                                                <input class="form-control" type="file" name="photo" onchange="previewImage(event)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-t-20 text-center">
                                        <button type="submit" class="btn btn-primary submit-btn">Update Profile</button>
                                    </div>

                                    <div id="updateMessage" class="text-center mt-3"></div>
                                </form>
                            </div>
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
    <script src="assets/js/app.js"></script>

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

        #previewImg {
            object-fit: cover;
        }
    </style>
</body>
</html>
