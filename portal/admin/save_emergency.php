<?php
session_start();
include('includes/connect.php');

// Set UTF-8 encoding if not already set
$db->exec("SET NAMES 'utf8'");

// Sanitize and validate inputs
$emergency_id = filter_input(INPUT_POST, 'emergency_id', FILTER_SANITIZE_STRING);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING);
$patient_name = filter_input(INPUT_POST, 'patient_name', FILTER_SANITIZE_STRING);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
$emergency_category = filter_input(INPUT_POST, 'emergency_category', FILTER_SANITIZE_STRING);
$latitude = filter_input(INPUT_POST, 'latitude', FILTER_VALIDATE_FLOAT);
$longitude = filter_input(INPUT_POST, 'longitude', FILTER_VALIDATE_FLOAT);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$status = $_POST['status'] ?? 'Pending'; // Keep default if not passed
$dates = $_POST['dates'] ?? date('Y-m-d H:i:s'); // Use SQL-friendly datetime format
$injury = filter_input(INPUT_POST, 'injury', FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
$agency_id = filter_input(INPUT_POST, 'agency_id', FILTER_SANITIZE_STRING);

// Check for missing required fields
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
    'dates' => $dates
];

$missingFields = [];
foreach ($requiredFields as $field => $value) {
    if ($value === null || $value === '') {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    http_response_code(400); // Bad request
    die('Error: The following fields are missing or invalid: ' . htmlspecialchars(implode(', ', $missingFields)));
}

// Insert data using prepared statements
$sql = "INSERT INTO emergency (
            emergency_id, patient_name, phone, age, emergency_category,
            latitude, longitude, address, status, dates,
            injury, description, agency_id, user_id
        ) VALUES (
            :emergency_id, :patient_name, :phone, :age, :emergency_category,
            :latitude, :longitude, :address, :status, :dates,
            :injury, :description, :agency_id, :user_id
        )";

try {
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

    $q->execute();

    // Redirect on success
    header("Location: report-emergency.php?success=true");
    exit;

} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    die('Error: Failed to save data. ' . htmlspecialchars($e->getMessage()));
}
?>
