<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #fdfdfd, #e3f2fd);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }
        .success-container {
            background: #fff;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .success-container img {
            width: 120px;
            margin-bottom: 20px;
        }
        .success-container h1 {
            color: #28a745;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .success-container p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 2rem;
        }
        .btn-primary {
            padding: 10px 30px;
            font-size: 1rem;
            border-radius: 50px;
        }
        .countdown {
            font-size: 0.9rem;
            color: #888;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <img src="assets/img/success.png" alt="Success">
        <h1>Success!</h1>
        <p>Your registration has been successfully completed. You can now log in and start using CJMED.</p>
        <a href="sign-in.php" class="btn btn-primary">Go to Login</a>
        <p class="countdown">Redirecting to login page in <span id="countdown">5</span> seconds...</p>
    </div>

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
        let countdown = 5;
        const countdownElement = document.getElementById('countdown');
        const interval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = 'sign-in.php';
            }
        }, 1000);
    </script>
</body>
</html>
