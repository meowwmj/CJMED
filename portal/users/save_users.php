<?php
session_start();
include('includes/connect.php');

$a = $_POST['name'];
$b = $_POST['email'];
$c = $_POST['username'];
$d = $_POST['password'];
$e = $_POST['phone'];
$f = $_POST['user_id'];
$g = $_POST['address'];

// Encryption key (keep this secret)
$encryption_key = "your-secret-key";
$iv = '1234567890123456'; // Must be 16 bytes

// Encrypt the password
$encrypted_password = openssl_encrypt($d, 'aes-256-cbc', $encryption_key, 0, $iv);

// Check if username, email, or phone already exist
$query = "SELECT * FROM users WHERE username = :username OR email = :email OR phone = :phone";
$stmt = $db->prepare($query);
$stmt->execute(array(':username' => $c, ':email' => $b, ':phone' => $e));

if ($stmt->rowCount() > 0) {
    echo "<script>alert('Username, email, or phone number already exists. Please choose a different one.');</script>";
    echo "<script>window.location.href = 'register.php';</script>";
    exit();
}   

// File upload handling
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $file_name = strtolower($_FILES['photo']['name']);
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $prefix = 'users' . md5(time() * rand(1, 9999));
    $file_name_new = $prefix . '.' . $file_ext;
    $path = '../../uploads/' . $file_name_new;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $path)) {
        $sql = "INSERT INTO users (name, email, username, password, phone, user_id, address, photo) 
                VALUES (:a, :b, :c, :d, :e, :f, :g, :h)";
        $q = $db->prepare($sql);
        $q->execute(array(
            ':a' => $a,
            ':b' => $b,
            ':c' => $c,
            ':d' => $encrypted_password,
            ':e' => $e,
            ':f' => $f,
            ':g' => $g,
            ':h' => $file_name_new
        ));
    }
} else {
    $sql = "INSERT INTO users (name, email, username, password, phone, user_id, address) 
            VALUES (:a, :b, :c, :d, :e, :f, :g)";
    $q = $db->prepare($sql);
    $q->execute(array(
        ':a' => $a,
        ':b' => $b,
        ':c' => $c,
        ':d' => $encrypted_password,
        ':e' => $e,
        ':f' => $f,
        ':g' => $g
    ));
}

if ($stmt->execute()) {
    header("Location: success_page.php"); // Redirect to success page
    exit();
} else {
    echo "Error: " . $conn->error;
}

?>
