<?php
session_start();
include('includes/connect.php');

// Retrieve and sanitize inputs
$emergency_id = $_POST['emergency_id'] ?? null;
$user_id = $_POST['user_id'] ?? null; 
$patient_name = $_POST['patient_name'] ?? null;
$phone = $_POST['phone'] ?? null;
$age = $_POST['age'] ?? null;
$emergency_category = $_POST['emergency_category'] ?? null;
$latitude = $_POST['latitude'] ?? null;
$longitude = $_POST['longitude'] ?? null;
$address = $_POST['address'] ?? null;
$status = $_POST['status'] ?? 'Pending';
$dates = $_POST['dates'] ?? date('Y-m-d');
$injury = $_POST['injury'] ?? null;
$description = $_POST['description'] ?? null;
$agency_id = $_POST['agency_id'] ?? null;

// Validate inputs
$missingFields = [];
foreach (['emergency_id' => $emergency_id, 'patient_name' => $patient_name, 'phone' => $phone, 'age' => $age, 'emergency_category' => $emergency_category, 'latitude' => $latitude, 'longitude' => $longitude, 'address' => $address, 'injury' => $injury, 'description' => $description, 'agency_id' => $agency_id, 'dates' => $dates, 'user_id' => $user_id] as $field => $value) {
    if (empty($value)) $missingFields[] = $field;
}
if (!empty($missingFields)) {
    die('Error: The following fields are missing: ' . implode(', ', $missingFields));
}

// Insert into the database
$sql = "INSERT INTO emergency (emergency_id, patient_name, phone, age, emergency_category, latitude, longitude, address, status, dates, injury, description, agency_id, user_id) 
        VALUES (:emergency_id, :patient_name, :phone, :age, :emergency_category, :latitude, :longitude, :address, :status, :dates, :injury, :description, :agency_id, :user_id)";
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
    die('Error: Failed to save data. ' . $errorInfo[2]);
}
?>
