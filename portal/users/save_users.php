<?php
session_start();
include('includes/connect.php');

$a = $_POST['name'];
$b = $_POST['email'];
$c = $_POST['username'];
$d = $_POST['password'];
$e = $_POST['phone'];
$f = $_POST['user_id'];
$birthday = $_POST['birthday'];
$age = $_POST['age'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$barangay = $_POST['barangay'];
$municipality = $_POST['municipality'];
$province = $_POST['province'];
$address = $_POST['address']; // Full address

// Encryption key (keep this secret securely!)
$encryption_key = "your-secret-key";
$iv = '1234567890123456'; // 16-byte IV

// Encrypt the password
$encrypted_password = openssl_encrypt($d, 'aes-256-cbc', $encryption_key, 0, $iv);

// Check for duplicate username/email/phone
$query = "SELECT * FROM users WHERE username = :username OR email = :email OR phone = :phone";
$stmt = $db->prepare($query);
$stmt->execute([
    ':username' => $c,
    ':email' => $b,
    ':phone' => $e
]);

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
        $sql = "INSERT INTO users (name, email, username, password, phone, user_id, photo, birthday, age, latitude, longitude, barangay, municipality, province, address) 
                VALUES (:a, :b, :c, :d, :e, :f, :i, :g, :h, :lat, :lon, :barangay, :municipality, :province, :address)";
        $q = $db->prepare($sql);
        $q->execute([
            ':a' => $a,
            ':b' => $b,
            ':c' => $c,
            ':d' => $encrypted_password,
            ':e' => $e,
            ':f' => $f,
            ':g' => $birthday,
            ':h' => $age,
            ':i' => $file_name_new,
            ':lat' => $latitude,
            ':lon' => $longitude,
            ':barangay' => $barangay,
            ':municipality' => $municipality,
            ':province' => $province,
            ':address' => $address
        ]);
    }
} else {
    $sql = "INSERT INTO users (name, email, username, password, phone, user_id, birthday, age, latitude, longitude, barangay, municipality, province, address) 
            VALUES (:a, :b, :c, :d, :e, :f, :g, :h, :lat, :lon, :barangay, :municipality, :province, :address)";
    $q = $db->prepare($sql);
    $q->execute([
        ':a' => $a,
        ':b' => $b,
        ':c' => $c,
        ':d' => $encrypted_password,
        ':e' => $e,
        ':f' => $f,
        ':g' => $birthday,
        ':h' => $age,
        ':lat' => $latitude,
        ':lon' => $longitude,
        ':barangay' => $barangay,
        ':municipality' => $municipality,
        ':province' => $province,
        ':address' => $address
    ]);
}

// Redirect to success page
header("Location: success_page.php");
exit();
?>
