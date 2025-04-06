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
$sql = "SELECT * FROM users WHERE username = ?";
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

        // Store user data in session
        $_SESSION['SESS_MEMBER_ID'] = $user['id'];
        $_SESSION['SESS_FIRST_NAME'] = $user['name'];
        $_SESSION['SESS_EMAIL'] = $user['email'];
        $_SESSION['SESS_PHONE_NUMBER'] = $user['phone'];
        $_SESSION['SESS_STATE'] = $user['state'];
        $_SESSION['SESS_ADDRESS'] = $user['address'];
        $_SESSION['SESS_PRO_PIC'] = $user['photo'];
        $_SESSION['SESS_USERNAME'] = $user['username'];
        $_SESSION['SESS_USERS_ID'] = $user['user_id'];

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
