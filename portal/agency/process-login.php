<?php 
include 'includes/connect.php';
session_start();

// Function to sanitize input
function clean($str) {
    return trim($str);
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

// Prepare MySQLi query to get user details
$qry = "SELECT * FROM agency WHERE username = ?";
$stmt = $db->prepare($qry);
$stmt->bind_param("s", $login); // 's' means string
$stmt->execute();
$result = $stmt->get_result();

// Debugging Output
echo "Debug: Query executed.<br>";

// Verify user credentials
if ($result->num_rows > 0) {
    // Fetch user data
    $row = $result->fetch_assoc();
    echo "Debug: User found.<br>";

    // Check if the password matches directly (no hashing involved)
    if ($password == $row['password']) {  // Direct password comparison
        // Login Successful
        session_regenerate_id();
        $_SESSION['SESS_MEMBER_ID'] = $row['id'];
        $_SESSION['SESS_FIRST_NAME'] = $row['agency_name'];
        $_SESSION['SESS_EMAIL'] = $row['email'];
        $_SESSION['SESS_PHONE_NUMBER'] = $row['phone_number'];
        $_SESSION['SESS_STATE'] = $row['state'];
        $_SESSION['SESS_ADDRESS'] = $row['address'];            
        $_SESSION['SESS_PERSONINCHARGE'] = $row['personincharge'];
        $_SESSION['SESS_PRO_PIC'] = $row['photo'];
        $_SESSION['SESS_USERNAME'] = $row['username'];
        $_SESSION['SESS_AGENCY_ID'] = $row['agency_id'];

        session_write_close();
        echo "Debug: Redirecting to index.php.<br>";
        header("location: index.php");
        exit();
    } else {
        echo '<script language="javascript">';
        echo "alert('Incorrect password');window.location.href='sign-in.php';";
        echo '</script>';
        exit();
    }
} else {
    echo '<script language="javascript">';
    echo "alert('Username not found');window.location.href='sign-in.php';";
    echo '</script>';
    exit();
}
?>
