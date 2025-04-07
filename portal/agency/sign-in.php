<?php 
session_start();
if(isset($_SESSION['SESS_FIRST_NAME'])){
    header("location: report-emergency.php");
    exit();
}
$errorMessage = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : "";
unset($_SESSION['login_error']); // Clear error after displaying
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/pdrr.png">
    <title>CJMED - Sign In</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                    <form method="post" action="process-login.php" class="form-signin">
                        <div class="account-logo text-center">
                            <a href="/menu.php">
                                <img src="assets/img/pdrr.png" alt="CJMED Logo" class="img-fluid" style="max-width: 150px;">
                            </a>
                            <h3 class="mt-2">C.J.M.E.D.</h3>
                            <p>Urgent Care Unit (Agency)</p>
                        </div>

                        <!-- ERROR MESSAGE DISPLAY -->
                        <?php if (!empty($errorMessage)) : ?>
                            <div class="alert alert-danger text-center"><?php echo $errorMessage; ?></div>
                        <?php endif; ?>
                        <!-- END ERROR MESSAGE -->

                        <div class="form-group">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
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
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>

<style>
   body {
    background: linear-gradient(135deg, rgb(231, 237, 237), #3f97da);
    background-size: cover;
    background-attachment: fixed;
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
