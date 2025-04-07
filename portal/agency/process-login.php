<?php 

include 'includes/connect.php';
session_start();

$encryption_key = "your-secret-key"; // Same key used for encryption
$iv = '1234567890123456'; // Must match the IV used for encryption

function clean($str) {
    global $conn;
    $str = @trim($str);
    return mysqli_real_escape_string($conn, $str);
}
  
//Sanitize the POST values
$login = clean($_POST['username']);
$password = clean($_POST['password']);

//Input Validations
if ($login == '') {
    $errmsg_arr[] = 'Username missing';
    $errflag = true;
}
if ($password == '') {
    $errmsg_arr[] = 'Password missing';
    $errflag = true; 
}

//Create query
$qry = "SELECT * FROM agency WHERE username='$login'";
$result = mysqli_query($conn, $qry);

//Check whether the query was successful or not
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        //Login Successful
        $member = mysqli_fetch_assoc($result);

        // Decrypt the password from the database
        $decrypted_password = openssl_decrypt($member['password'], 'aes-256-cbc', $encryption_key, 0, $iv);

        // Check if the decrypted password matches the input password
        if ($decrypted_password === $password) {
            session_regenerate_id();
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

            session_write_close();
            header("location: index.php");
            exit();
        } else {
            echo '<script language="javascript">';
            echo "alert('Incorrect password'); window.location.href='sign-in.php';";
            echo '</script>';
            exit();
        }
    } else {
        echo '<script language="javascript">';
        echo "alert('Username not found'); window.location.href='sign-in.php';";
        echo '</script>';
        exit();
    }
} else {
    die("Query failed");
}

?>
