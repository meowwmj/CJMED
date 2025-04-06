<?php 
session_start();
 if(isset($_SESSION['SESS_FIRST_NAME'])){
    header("location: index.php");
    exit();
}

?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/pdrr.png">
    <title>CJMED</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
<div class="main-wrapper account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                    <form method="post" action="process-login.php" class="form-signin">
                        <div class="account-logo text-center">
                            <a href="/portal/admin/sign-in.php">
                                <img src="assets/img/pdrr.png" alt="CJMED Logo" class="img-fluid" style="max-width: 150px;">
                            </a>
                            <h3 class="mt-2">C.J.M.E.D.</h3>
                            <p>Urgent Care Unit (Admin)</p>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters" required>
                        </div>

                        <div class="form-group d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>
                            <a href="#" class="text-muted">Forgot password?</a>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                        </div>
                        <div class="text-center register-link">
                            Login as user? <a href="/portal/users/sign-in.php">Click Here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>


<!-- login23:12-->
</html>

<style>
    body {
        background: linear-gradient(135deg,rgb(231, 237, 237), #3f97da);
    }
    .account-box {
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .account-logo img {
        border-radius: 50%;
    }
    div.account-box {
    background: #fdfdfd;
    display: flex;
    flex-direction: column;
    padding: 25px 25px;
    border-radius: 20px;
    box-shadow: 0 0 128px 0 rgba(0,0,0,0.1),
                0 32px 64px -48px rgba(0,0,0,0.5);
}

div.container {
  padding: 10px;
}
</style>
