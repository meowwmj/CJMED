<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('includes/connect.php');

$encryption_key = "your-secret-key"; // Same key used for encryption
$iv = '1234567890123456'; // Must match the IV used for encryption

function clean($str) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($str));
}

// Sanitize inputs
$username = clean($_POST['username']);
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = "Username and password are required.";
    header("Location: sign-in.php");
    exit();
}

// Prepare secure query to fetch user data
$sql = "SELECT * FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    // Decrypt the stored password
    $decrypted_password = openssl_decrypt($user['password'], 'aes-256-cbc', $encryption_key, 0, $iv);
    
    if ($password === $decrypted_password) {
        // Regenerate session ID to prevent session fixation
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
        
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: sign-in.php");
        exit();
    }
} else {
    $_SESSION['login_error'] = "User not found.";
    header("Location: sign-in.php");
    exit();
}

$stmt->close();
$conn->close();

?>
