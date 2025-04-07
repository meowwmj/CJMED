<?php 
include 'includes/connect.php';
session_start();

// Function to sanitize input
function clean($str) {
    return trim($str); // No need to use mysqli_real_escape_string with PDO
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

// Prepare query to get user details
$qry = "SELECT * FROM agency WHERE username = :username";
$stmt = $db->prepare($qry);
$stmt->bindParam(':username', $login);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Verify user credentials
//Check whether the query was successful or not
	if($result) {
		if(mysqli_num_rows($result) > 0) {
			//Login Successful
			session_regenerate_id();
			$member = mysqli_fetch_assoc($result);
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
		}else {
			
  echo '<script language = "javascript">';
  // echo "window.location.href='login.php'"; 
  echo "alert('Something went wrong, Enter correct details');window.location.href='sign-in.php'";
   echo '</script>';
    exit;
   // echo "<script language = 'javascript'> alert('Wrong Details');'</script>";
                       
                       
                    }
	}else {
		die("Query failed");
	}
?>

