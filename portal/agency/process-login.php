<?php
include 'includes/connect.php';
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the connection is valid
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize input
function clean($str) {
    global $conn;
    $str = @trim($str);
    return mysqli_real_escape_string($conn, $str);
}

// Sanitize the POST values
$login = clean($_POST['username']);
$password = clean($_POST['password']);

// Input validations
if ($login == '') {
    $errmsg_arr[] = 'Username missing';
    $errflag = true;
}
if ($password == '') {
    $errmsg_arr[] = 'Password missing';
    $errflag = true;
}

// If there are input validations, return to the login form
if (isset($errflag) && $errflag) {
    echo '<script language="javascript">';
    echo "alert('Please fill in all fields');window.location.href='sign-in.php'";
    echo '</script>';
    exit();
}

// Check if the 'agency' table exists
$table_check = "SHOW TABLES LIKE 'agency'";
$table_result = mysqli_query($conn, $table_check);

if (mysqli_num_rows($table_result) == 0) {
    die('Error: The "agency" table does not exist.');
}

// Create query to select the user
$qry = "SELECT * FROM agency WHERE username='$login'";
$result = mysqli_query($conn, $qry);

// Check if query executed successfully
if (!$result) {
    die('Error in SQL query: ' . mysqli_error($conn));
}

// Check if any user was found
if (mysqli_num_rows($result) > 0) {
    $member = mysqli_fetch_assoc($result);
    
    // Verify password (make sure passwords are hashed in the database)
    if (password_verify($password, $member['password'])) {
        // Password is correct, login successful
        session_regenerate_id();
        
        // Set session variables
        $_SESSION['SESS_MEMBER_ID'] = $member['id'];
        $_SESSION['SESS_FIRST_NAME'] = $member['agency_name'];
        $_SESSION['SESS_EMAIL'] = $member['email'];
        $_SESSION['SESS_PHONE_NUMBER'] = $member['phone_number'];
        $_SESSION['SESS_STATE'] = $member['state'];
        $_SESSION['SESS_ADDRESS'] = $member['address'];            
        $_SESSION['SESS_PERSONINCHARGE'] = $member['personincharge'];
        $_SESSION['SESS_PRO_PIC'] = $member['photo'];
        $_SESSION['SESS_USERNAME'] = $member['username'];
        $_SESSION['SESS_AGENCY_ID'] = $member['agency_id'];
        
        // Close session write
        session_write_close();
        
        // Redirect to the home page after successful login
        header("location: index.php");
        exit();
    } else {
        // Password incorrect
        echo '<script language="javascript">';
        echo "alert('Incorrect password, please try again.');window.location.href='sign-in.php'";
        echo '</script>';
        exit();
    }
} else {
    // No user found
    echo '<script language="javascript">';
    echo "alert('Username not found, please try again.');window.location.href='sign-in.php'";
    echo '</script>';
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
