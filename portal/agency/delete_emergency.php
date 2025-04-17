<?php

include 'includes/connect.php'; 

$id = $_GET['id'];  // Get the emergency ID to be archived

// Start a transaction to ensure data integrity
$db->beginTransaction();

// Step 1: Fetch the emergency data from the `emergency` table
$result = $db->prepare("SELECT * FROM emergency WHERE id = :post_id");
$result->bindParam(':post_id', $id);
$result->execute();
$emergency = $result->fetch(PDO::FETCH_ASSOC);

if ($emergency) {
    // Step 2: Insert the fetched emergency data into the `emergency_history` table
    $insertHistory = $db->prepare("INSERT INTO emergency_history 
        (emergency_category, agency_id, agency_name, address, created_at, deleted_at) 
        VALUES (:emergency_category, :agency_id, :agency_name, :address, :created_at, NOW())");

    // Bind the parameters
    $insertHistory->bindParam(':emergency_category', $emergency['emergency_category']);
    $insertHistory->bindParam(':agency_id', $emergency['agency_id']);
    $insertHistory->bindParam(':agency_name', $emergency['agency_name']);
    $insertHistory->bindParam(':address', $emergency['address']);
    $insertHistory->bindParam(':created_at', $emergency['created_at']);

    // Execute the insert query to archive the emergency
    if ($insertHistory->execute()) {
        // Step 3: Delete the emergency from the `emergency` table
        $deleteStmt = $db->prepare("DELETE FROM emergency WHERE id = :post_id");
        $deleteStmt->bindParam(':post_id', $id);
        $deleteStmt->execute();

        // Commit the transaction
        $db->commit();

        // Redirect to the view-emergency page with a success message
        header("location:view-emergency.php?success=true");
    } else {
        // If insert failed, roll back the transaction
        $db->rollBack();
        header("location:view-emergency.php?failed=true");
    }
} else {
    // If the emergency wasn't found
    header("location:view-emergency.php?failed=true");
}

?>
