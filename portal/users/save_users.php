<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('includes/connect.php');

$name = $_POST['name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password']; 
$phone = $_POST['phone'];
$address = $_POST['address'];
$user_id = $_POST['user_id'];

// Encryption key (keep this secret)
$encryption_key = "your-secret-key"; 
$iv = '1234567890123456'; // Must be 16 bytes
$encrypted_password = openssl_encrypt($password, 'aes-256-cbc', $encryption_key, 0, $iv);

// File upload handling
$photo = $_FILES['photo']['name'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($photo);
move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);

// Insert user into the database with encrypted password
$sql = "INSERT INTO users (user_id, name, email, username, password, phone, address, photo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $user_id, $name, $email, $username, $encrypted_password, $phone, $address, $photo);

if ($stmt->execute()) {
    header("Location: success_page.php"); // Redirect to success page
    exit();
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();

?>
