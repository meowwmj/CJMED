<?php
include '../includes/connect.php'; // Ensure database connection

if (isset($_POST['barangay'])) {
    $barangay = $_POST['barangay'];
    
    $stmt = $conn->prepare("SELECT mdrrmo FROM barangay_mdrrmo WHERE barangay = ?");
    $stmt->bind_param("s", $barangay);
    $stmt->execute();
    $stmt->bind_result($mdrrmo);
    $stmt->fetch();
    
    echo $mdrrmo ? $mdrrmo : "Not Assigned"; // Return MDRRMO or "Not Assigned" if not found
    
    $stmt->close();
    $conn->close();
}
?>
