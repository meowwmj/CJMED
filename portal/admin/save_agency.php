<?php

session_start();
include('includes/connect.php');

$a = $_POST['agency_name'];
$b = $_POST['phone_number'];
$c = $_POST['email'];
$d = $_POST['personincharge'];
$e = $_POST['username'];
$f = $_POST['password']; // The password from the form
$g = $_POST['address'];
$h = $_POST['agency_id'];

// Encryption key (keep this secret)
$encryption_key = "your-secret-key"; 
$iv = '1234567890123456'; // Must be 16 bytes
$encrypted_password = openssl_encrypt($f, 'aes-256-cbc', $encryption_key, 0, $iv);

// File upload handling
$file_name  = strtolower($_FILES['photo']['name']);
$file_ext = substr($file_name, strrpos($file_name, '.'));
$prefix = 'agency'.md5(time()*rand(1, 9999));
$file_name_new = $prefix.$file_ext;
$path = '../../uploads/'.$file_name_new;

if (move_uploaded_file($_FILES['photo']['tmp_name'], $path)) {

    // Prepare SQL query
    $sql = "INSERT INTO agency (agency_name, phone_number, email, personincharge, username, password, address, agency_id, photo) 
            VALUES (:a, :b, :c, :d, :e, :f, :g, :h, :i)";
    
    // Prepare and execute the query
    try {
        $q = $db->prepare($sql);
        $q->execute(array(
            ':a' => $a,
            ':b' => $b,
            ':c' => $c,
            ':d' => $d,
            ':e' => $e,
            ':f' => $encrypted_password, // Store the encrypted password
            ':g' => $g,
            ':h' => $h,
            ':i' => $file_name_new
        ));

        // Check if the query was successful
        if ($q) {
            header("Location: agency.php?success=true");
        } else {
            header("Location: agency.php?failed=true");
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // File upload failed
    echo "File upload failed.";
}
?>
