<?php 
include 'includes/connect.php';
session_start();

// Function to sanitize input
function clean($str) {
    return trim($str); // No need to use mysqli_real_escape_string with MySQLi here
}

// Sanitize POST values
$login = clean($_POST['username']);
$password = clean($_POST['password']);

// Input validations
$errflag = false;
$errmsg_arr = [];

if (empty($login)) {
    $errmsg_arr[] = 'Username missing';
    $errflag = true;
}

if (empty($password)) {
    $errmsg_arr[] = 'Password missing';
    $errflag = true;
}

// Redirect if there are validation errors
if ($errflag) {
    echo "<script>alert('".implode('\\n', $errmsg_arr)."');</script>";
    echo "<script>window.location.href='sign-in.php';</script>";
    exit();
}

// Debugging Output
echo "Debug: After input validation.<br>";

// Database connection check
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
} else {
    echo "Debug: Database connection successful.<br>";
}

// Prepare MySQLi query to get user details
$qry = "SELECT * FROM agency WHERE username = ?";
$stmt = $db->prepare($qry);

// Check if the query is prepared successfully
if ($stmt === false) {
    echo "Debug: Query preparation failed.<br>";
    die("Query preparation failed: " . $db->error);
} else {
    echo "Debug: Query prepared successfully.<br>";
}

// Bind the parameter and execute the query
$stmt->bind_param("s", $login);  // 's' means string
$stmt->execute();

// Check if execution was successful
if ($stmt->error) {
    echo "Debug: Query execution failed: " . $stmt->error . "<br>";
} else {
    echo "Debug: Query executed successfully.<br>";
}

// Bind result variables to capture the output of the query
$stmt->bind_result($id, $agency_name, $email, $phone_number, $state, $address, $personincharge, $photo, $username, $agency_id, $password_from_db);

// Fetch the result
if ($stmt->fetch()) {
    echo "Debug: User found.<br>";
    echo "Debug: ID: $id, Username: $username, Password: $password_from_db<br>";  // Debugging output

    // Compare the password directly (no hashing involved)
    if ($password == $password_from_db) {
        // Login successful
        session_regenerate_id();
        $_SESSION['SESS_MEMBER_ID'] = $id;
        $_SESSION['SESS_FIRST_NAME'] = $agency_name;
        $_SESSION['SESS_EMAIL'] = $email;
        $_SESSION['SESS_PHONE_NUMBER'] = $phone_number;
        $_SESSION['SESS_STATE'] = $state;
        $_SESSION['SESS_ADDRESS'] = $address;
        $_SESSION['SESS_PERSONINCHARGE'] = $personincharge;
        $_SESSION['SESS_PRO_PIC'] = $photo;
        $_SESSION['SESS_USERNAME'] = $username;
        $_SESSION['SESS_AGENCY_ID'] = $agency_id;

        session_write_close();
        echo "Debug: Redirecting to index.php.<br>";
        header("location: index.php");
        exit();
    } else {
        echo "Debug: Incorrect password.<br>";
        echo '<script language="javascript">';
        echo "alert('Incorrect password');window.location.href='sign-in.php';";
        echo '</script>';
        exit();
    }
} else {
    echo "Debug: No user found.<br>";
    echo '<script language="javascript">';
    echo "alert('Username not found');window.location.href='sign-in.php';";
    echo '</script>';
    exit();
}

?>
