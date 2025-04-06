<?php
session_start();
include 'includes/connect.php'; // Database connection file

// Check if the admin is logged in and has proper privileges
if (!isset($_SESSION['SESS_MEMBER_ID']) || empty($_SESSION['SESS_MEMBER_ID'])) {
    // Redirect if not logged in
    header("Location: users.php");
    exit();
}

// Get the admin ID to be disabled
if (isset($_GET['id'])) {
    $agency_id = $_GET['id'];

    // Ensure the logged-in admin cannot disable themselves
    if ($_SESSION['SESS_MEMBER_ID'] == $admin_id) {
        $_SESSION['error_message'] = "You cannot disable your own account.";
        header("Location: users.php");
        exit();
    }

    // Disable the admin account
    $stmt = $db->prepare("UPDATE admin SET status = 'disabled' WHERE id = :agency_id");
    $stmt->bindParam(':agency_id', $agency_id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Admin account has been disabled successfully.";
    } else {
        $_SESSION['error_message'] = "There was an error disabling the admin account.";
    }
} else {
    $_SESSION['error_message'] = "No admin ID specified.";
}

// Redirect back to the admin management page
header("Location: users.php");
exit();
?>
