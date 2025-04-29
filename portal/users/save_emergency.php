<?php
session_start();
include('includes/connect.php');

// Debug log to see what's being submitted
error_log("POST data received: " . print_r($_POST, true));
error_log("FILES data received: " . print_r($_FILES, true));

// Create uploads directory if it doesn't exist
$upload_dir = 'uploads/emergency_photos/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

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

// Handle patient name selection
$patient_select = trim($_POST['patient_select'] ?? '');
if ($patient_select === 'unknown') {
    $patient_name = 'Unknown';
} elseif ($patient_select !== 'custom' && empty($patient_name)) {
    $patient_name = $patient_select;
}

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

// Process photo upload
$photo_path = null;
$upload_error = null;

// First, check if a file was uploaded via file input
if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES['photo'];
    
    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $file_type = $file['type'];
    
    if (!in_array($file_type, $allowed_types)) {
        $upload_error = "Invalid file type. Only JPG, PNG, GIF, and WEBP images are allowed.";
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        // Check for other upload errors
        switch ($file['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $upload_error = "File is too large. Maximum size allowed is " . ini_get('upload_max_filesize');
                break;
            case UPLOAD_ERR_PARTIAL:
                $upload_error = "The file was only partially uploaded.";
                break;
            default:
                $upload_error = "An error occurred during file upload.";
        }
    } else {
        // Generate unique filename to prevent overwriting
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = $emergency_id . '_' . time() . '_' . uniqid() . '.' . $file_extension;
        $destination = $upload_dir . $new_filename;
        
        // Move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $photo_path = $destination;
        } else {
            $upload_error = "Failed to save the uploaded file.";
        }
    }
} 
// Then check if a base64 image was uploaded via camera capture
elseif (isset($_POST['photoInput']) && !empty($_POST['photoInput'])) {
    try {
        $base64_image = $_POST['photoInput'];
        
        // Extract the base64 encoded binary data
        $base64_parts = explode(',', $base64_image, 2);
        if (count($base64_parts) < 2) {
            throw new Exception("Invalid base64 image format");
        }
        
        // Extract the image format (e.g., png, jpeg)
        $image_format = '';
        if (preg_match('/data:image\/([a-zA-Z]+);base64/', $base64_parts[0], $matches)) {
            $image_format = $matches[1];
        } else {
            throw new Exception("Could not determine image format");
        }
        
        // Validate image format
        if (!in_array($image_format, ['jpeg', 'jpg', 'png', 'gif', 'webp'])) {
            throw new Exception("Invalid image format. Only JPG, PNG, GIF, and WEBP images are allowed.");
        }
        
        // Convert base64 data to binary
        $image_data = base64_decode($base64_parts[1]);
        if ($image_data === false) {
            throw new Exception("Failed to decode base64 image data");
        }
        
        // Create a unique filename
        $new_filename = $emergency_id . '_' . time() . '_' . uniqid() . '.' . $image_format;
        $destination = $upload_dir . $new_filename;
        
        // Save the file
        if (file_put_contents($destination, $image_data) !== false) {
            $photo_path = $destination;
            error_log("Camera photo saved successfully to: " . $photo_path);
        } else {
            throw new Exception("Failed to save the captured image");
        }
    } catch (Exception $e) {
        $upload_error = "Error processing camera image: " . $e->getMessage();
        error_log("Camera photo error: " . $e->getMessage());
    }
}

// If there's an upload error, log it but continue with the form submission
if ($upload_error) {
    // For production, you might want to log this error
    error_log("Photo upload error: $upload_error");
}

// Log what we have for debugging
error_log("Photo path before database insert: " . ($photo_path ?? 'None'));

// Insert into the database
try {
    // Add the photo field to the SQL query
    $sql = "INSERT INTO emergency (
                emergency_id, patient_name, phone, age, emergency_category, 
                latitude, longitude, address, status, dates, injury, 
                description, agency_id, user_id, photo
            ) VALUES (
                :emergency_id, :patient_name, :phone, :age, :emergency_category, 
                :latitude, :longitude, :address, :status, :dates, :injury, 
                :description, :agency_id, :user_id, :photo
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
    $q->bindParam(':photo', $photo_path); // Bind the photo path

    if ($q->execute()) {
        // Redirect with success message
        header("Location: report-emergency.php?success=true");
        exit;
    } else {
        $errorInfo = $q->errorInfo();
        throw new Exception($errorInfo[2]);
    }

} catch (Exception $e) {
    // If photo was uploaded but database insert failed, attempt to delete the uploaded file
    if ($photo_path && file_exists($photo_path)) {
        unlink($photo_path);
    }
    
    // Optionally log error to file
    error_log("DB Error: " . $e->getMessage());

    die('Error: Failed to save data. ' . $e->getMessage());
}
?>
