<?php
session_start();
include('includes/connect.php');

// Collect and sanitize POST inputs
$a = $_POST['name'] ?? '';
$b = $_POST['email'] ?? '';
$c = $_POST['username'] ?? '';
$d = $_POST['password'] ?? '';
$e = $_POST['phone'] ?? '';
$f = $_POST['user_id'] ?? '';
$birthday = $_POST['birthday'] ?? '';
$age = $_POST['age'] ?? '';
$latitude = $_POST['latitude'] ?? '';
$longitude = $_POST['longitude'] ?? '';
$barangay = $_POST['barangay'] ?? '';
$municipality = $_POST['municipality'] ?? '';
$province = $_POST['province'] ?? '';
$address = $_POST['address'] ?? '';

// Encryption
$encryption_key = "your-secret-key"; // Replace with actual secure key in config
$iv = '1234567890123456'; // 16 bytes
$encrypted_password = openssl_encrypt($d, 'aes-256-cbc', $encryption_key, 0, $iv);

// Check for duplicates
try {
    $query = "SELECT 1 FROM users WHERE username = :username OR email = :email OR phone = :phone";
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':username' => $c,
        ':email' => $b,
        ':phone' => $e
    ]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Username, email, or phone number already exists.'); window.location.href = 'register.php';</script>";
        exit();
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// File upload
$photo_filename = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true); // Ensure directory exists
    }

    $file_name = strtolower(basename($_FILES['photo']['name']));
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $unique_prefix = 'users' . md5(uniqid(rand(), true));
    $photo_filename = $unique_prefix . '.' . $file_ext;
    $destination = $upload_dir . $photo_filename;

    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
        die("Failed to upload photo.");
    }
}

// Insert into database
try {
    $sql = "INSERT INTO users (
                name, email, username, password, phone, user_id,
                birthday, age, latitude, longitude,
                barangay, municipality, province, address, photo
            ) VALUES (
                :name, :email, :username, :password, :phone, :user_id,
                :birthday, :age, :latitude, :longitude,
                :barangay, :municipality, :province, :address, :photo
            )";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':name' => $a,
        ':email' => $b,
        ':username' => $c,
        ':password' => $encrypted_password,
        ':phone' => $e,
        ':user_id' => $f,
        ':birthday' => $birthday,
        ':age' => $age,
        ':latitude' => $latitude,
        ':longitude' => $longitude,
        ':barangay' => $barangay,
        ':municipality' => $municipality,
        ':province' => $province,
        ':address' => $address,
        ':photo' => $photo_filename
    ]);

    header("Location: success_page.php");
    exit();

} catch (PDOException $e) {
    die("Database insert error: " . $e->getMessage());
}
?>
