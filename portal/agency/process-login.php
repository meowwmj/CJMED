<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('includes/connect.php'); // This already sets $db as PDO

$encryption_key = "your-secret-key"; // Same key used for encryption
$iv = '1234567890123456'; // Must match the IV used for encryption

function clean($str) {
    return trim($str); // No need for mysqli_real_escape_string when using prepared statements
}

// Sanitize inputs
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    $_SESSION['login_error'] = "Username and password are required.";
    header("Location: sign-in.php");
    exit();
}

$username = clean($_POST['username']);
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = "Username and password are required.";
    header("Location: sign-in.php");
    exit();
}

try {
    // Prepare secure query to fetch user data
    $stmt = $db->prepare("SELECT * FROM agency WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Decrypt the stored password
        $decrypted_password = openssl_decrypt($user['password'], 'aes-256-cbc', $encryption_key, 0, $iv);
        
        if ($password === $decrypted_password) {
            session_regenerate_id(true);
            
            // Use $user instead of $member
            $_SESSION['SESS_MEMBER_ID'] = $user['id'];
            $_SESSION['SESS_FIRST_NAME'] = $user['agency_name'];
            $_SESSION['SESS_EMAIL'] = $user['email'];
            $_SESSION['SESS_PHONE_NUMBER'] = $user['phone_number'];
            $_SESSION['SESS_STATE'] = $user['state'];
            $_SESSION['SESS_ADDRESS'] = $user['address'];            
            $_SESSION['SESS_PERSONINCHARGE'] = $user['personincharge'];
            $_SESSION['SESS_PRO_PIC'] = $user['photo'];
            $_SESSION['SESS_USERNAME'] = $user['username'];
            $_SESSION['SESS_AGENCY_ID'] = $user['agency_id'];

            header("Location: index.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid username or password.";
        }
    } else {
        $_SESSION['login_error'] = "User not found.";
    }

} catch (PDOException $e) {
    $_SESSION['login_error'] = "Database error: " . $e->getMessage();
}

header("Location: sign-in.php");
exit();
