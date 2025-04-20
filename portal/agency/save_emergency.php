<?php
session_start();
include('includes/connect.php');

// Retrieve and sanitize inputs
$emergency_id = trim($_POST['emergency_id'] ?? '');
$user_id = trim($_POST['user_id'] ?? '');
$patient_name = trim($_POST['patient_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$age = trim($_POST['age'] ?? '');
$emergency_category = trim($_POST['emergency_category'] ?? '');
$latitude = trim($_POST['latitude'] ?? '');
$longitude = trim($_POST['longitude'] ?? '');
$address = trim($_POST['address'] ?? '');
$status = trim($_POST['status'] ?? 'Pending');
$dates = trim($_POST['dates'] ?? date('Y-m-d H:i:s'));
$injury = trim($_POST['injury'] ?? '');
$description = trim($_POST['description'] ?? '');
$agency_id = trim($_POST['agency_id'] ?? '');

// Validate required fields
$requiredFields = [
    'emergency_id' => $emergency_id,
    'user_id' => $user_id,
    'patient_name' => $patient_name,
    'phone' => $phone,
    'age' => $age,
    'emergency_category' => $emergency_category,
    'latitude' => $latitude,
    'longitude' => $longitude,
    'address' => $address,
    'injury' => $injury,
    'description' => $description,
    'agency_id' => $agency_id,
    'dates' => $dates,
];

$missingFields = [];
foreach ($requiredFields as $field => $value) {
    if (empty($value)) {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    die('Error: The following fields are missing or empty: ' . implode(', ', $missingFields));
}

// Insert into the database
try {
    $sql = "INSERT INTO emergency (
                emergency_id, patient_name, phone, age, emergency_category, 
                latitude, longitude, address, status, dates, injury, 
                description, agency_id, user_id
            ) VALUES (
                :emergency_id, :patient_name, :phone, :age, :emergency_category, 
                :latitude, :longitude, :address, :status, :dates, :injury, 
                :description, :agency_id, :user_id
            )";

    $q = $db->prepare($sql);
    $q->bindParam(':emergency_id', $emergency_id);
    $q->bindParam(':user_id', $user_id);
    $q->bindParam(':patient_name', $patient_name);
    $q->bindParam(':phone', $phone);
    $q->bindParam(':age', $age);
    $q->bindParam(':emergency_category', $emergency_category);
    $q->bindParam(':latitude', $latitude);
    $q->bindParam(':longitude', $longitude);
    $q->bindParam(':address', $address);
    $q->bindParam(':status', $status);
    $q->bindParam(':dates', $dates);
    $q->bindParam(':injury', $injury);
    $q->bindParam(':description', $description);
    $q->bindParam(':agency_id', $agency_id);

    if ($q->execute()) {
        header("Location: report-emergency.php?success=true");
        exit;
    } else {
        $errorInfo = $q->errorInfo();
        throw new Exception($errorInfo[2]);
    }

} catch (Exception $e) {
    // Optionally log error to file
    // error_log("DB Error: " . $e->getMessage());

    die('Error: Failed to save data. ' . $e->getMessage());
}
?>
