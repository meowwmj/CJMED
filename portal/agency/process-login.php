<?php 
include 'includes/connect.php';
session_start();

// Encryption key (keep this secret and secure)
$encryption_key = "your-secret-key";
$iv = '1234567890123456'; // Must be 16 bytes

// Function to sanitize input
function clean($str) {
    return trim($str); // No need to use mysqli_real_escape_string with PDO
}

// Sanitize POST values
$login = clean($_POST['username']);
$password = clean($_POST['password']);

// Input validations
$errflag = false;
$errmsg_arr = [];

if (empty($login)) {
    $errmsg_arr[] = 'Username missing';
    $errflag = true;
}

if (empty($password)) {
    $errmsg_arr[] = 'Password missing';
    $errflag = true;
}

// Redirect if there are validation errors
if ($errflag) {
    echo "<script>alert('".implode('\\n', $errmsg_arr)."');</script>";
    echo "<script>window.location.href='sign-in.php';</script>";
    exit();
}

// Prepare query to get user details
$qry = "SELECT * FROM agency WHERE username = :username";
$stmt = $db->prepare($qry);
$stmt->bindParam(':username', $login);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Verify user credentials
if ($row) {
    $decrypted_password = openssl_decrypt($row['password'], 'aes-256-cbc', $encryption_key, 0, $iv);

    if ($password === $decrypted_password) {
        session_regenerate_id(true);
        
        $_SESSION['SESS_MEMBER_ID'] = $row['id'];
        $_SESSION['SESS_AGENCY_ID'] = $row['agency_id'];
        $_SESSION['SESS_FIRST_NAME'] = $row['name'];
        $_SESSION['SESS_EMAIL'] = $row['email'];
        $_SESSION['SESS_PHONE_NUMBER'] = $row['phone'];
        $_SESSION['SESS_STATE'] = $row['state'];
        $_SESSION['SESS_ADDRESS'] = $row['address'];
        $_SESSION['SESS_ACCESS_LEVEL'] = $row['access_level'];
        $_SESSION['SESS_PRO_PIC'] = $row['photo'];
        $_SESSION['SESS_USERNAME'] = $row['username'];

        session_write_close();

        if ($_SESSION['SESS_ACCESS_LEVEL'] == 1) {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        echo "<script>alert('Invalid password. Please try again.');</script>";
        echo "<script>window.location.href='sign-in.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Username not found. Please try again.');</script>";
    echo "<script>window.location.href='sign-in.php';</script>";
    exit();
}
?>
