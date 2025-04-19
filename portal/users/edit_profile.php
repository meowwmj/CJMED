<?php
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/sidebar.php';

session_start();
require_once '../../includes/db.php'; // adjust if needed

$admin_id = $_SESSION['SESS_MEMBER_ID'] ?? null;

if (!$admin_id) {
    die("Session expired. Please login again.");
}

// Fetch current user details
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    die("User not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $phone    = $_POST['phone'] ?? '';
    $username = $_POST['username'] ?? '';
    $address  = $_POST['address'] ?? '';
    $photo    = $admin['photo']; // Use current photo by default

    // Handle file upload
    if (!empty($_FILES['photo']['name'])) {
        $targetDir = "../../uploads/";
        $fileName = basename($_FILES['photo']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
            $photo = $fileName;
        } else {
            echo "<div class='alert alert-danger'>Photo upload failed.</div>";
        }
    }

    // Update user info
    $stmt = $db->prepare("UPDATE users SET name=?, email=?, phone=?, username=?, address=?, photo=? WHERE id=?");
    $success = $stmt->execute([$name, $email, $phone, $username, $address, $photo, $admin_id]);

    if ($success) {
        // Update session
        $_SESSION['SESS_FIRST_NAME']   = $name;
        $_SESSION['SESS_USERNAME']     = $username;
        $_SESSION['SESS_EMAIL']        = $email;
        $_SESSION['SESS_PHONE_NUMBER'] = $phone;
        $_SESSION['SESS_ADDRESS']      = $address;
        $_SESSION['SESS_PRO_PIC']      = $photo;

        echo "<script>window.location.href = 'profile.php';</script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Update failed. Please try again.</div>";
    }
}
?>

<body>
    <div class="main-wrapper">
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

                <div class="card-box profile-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <img class="rounded-circle" src="../../uploads/<?php echo $_SESSION['SESS_PRO_PIC'] ?? 'default.jpg'; ?>" width="80" height="80">
                                    </div>
                                </div>

                                <div class="profile-basic">
                                    <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input class="form-control" type="text" name="name" value="<?php echo $admin['name']; ?>" required>
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
                                                    <input class="form-control" type="text" name="phone" value="<?php echo $admin['phone']; ?>" required>
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

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include 'includes/message.php'; ?>
    <div class="sidebar-overlay" data-reff=""></div>

    <!-- Scripts -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/app.js"></script>

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
