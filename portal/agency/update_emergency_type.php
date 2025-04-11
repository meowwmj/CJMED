<?php
include('includes/connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    if ($id <= 0 || empty($name)) {
        $_SESSION['error'] = "Invalid input.";
        header("Location: edit_emergency_type.php?id=$id");
        exit;
    }

    try {
        $stmt = $db->prepare("UPDATE emergency_type SET name = :name, description = :description WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $_SESSION['success'] = "Department updated successfully.";
        header("Location: emergency_type.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error updating department: " . $e->getMessage();
        header("Location: edit_emergency_type.php?id=$id");
        exit;
    }

} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: emergency_type.php");
    exit;
}

?>
