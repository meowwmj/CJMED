<?php include 'connect.php'; ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CJMED</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/pdrr.png">
    <link rel="stylesheet" href="plugin/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="plugin/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Page Loader -->
    <div class="load-page">
        <div class="sk-wave">
            <div class="sk-rect sk-rect1"></div>
            <div class="sk-rect sk-rect2"></div>
            <div class="sk-rect sk-rect3"></div>
            <div class="sk-rect sk-rect4"></div>
            <div class="sk-rect sk-rect5"></div>
        </div>
    </div>

    <!-- Main Content Section -->
        <section class="home-section">
            <div class="container">
                <div class="icon-box-container">
                    <a href="portal/admin" class="icon-box-link">
                        <div class="icon-box">
                            <i class="fa fa-user-md"></i>
                            <h4>ADMIN</h4>
                            <span>Login</span>
                        </div>
                    </a>
                    <a href="portal/agency" class="icon-box-link">
                        <div class="icon-box">
                            <i class="fa fa-ambulance"></i>
                            <h4>AGENCY</h4>
                            <span>Login</span>
                        </div>
                    </a>
                    <a href="portal/users" class="icon-box-link">
                        <div class="icon-box">
                            <i class="fa fa-user"></i>
                            <h4>USERS</h4>
                            <span>Login</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- JavaScript files -->
    <script src="plugin/jquery/jquery-2.0.2.min.js"></script>
    <script src="plugin/bootstrap/js/bootstrap.js"></script>
    <script src="js/main.js"></script>
</body>

</html>

<style>
  /* Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg,rgb(231, 237, 237),rgb(142, 191, 227));
    color: #fff;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    animation: fadeIn 1s ease-in;
}

a {
    text-decoration: none;
    color: inherit;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

/* Main Content Section */
.home-section .container {
    text-align: center;
}

.icon-box-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    flex-wrap: nowrap;
    animation: fadeInUp 1s ease-in-out;
}

.icon-box-link {
    display: inline-block;
    width: 100%;
    max-width: 300px; /* Limit the width of each icon box */
}

/* Each individual icon box */
.icon-box {
    background: #fff;
    padding: 40px;
    border-radius: 12px;
    width: 100%;
    transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: relative;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.4s ease, box-shadow 0.4s ease;
}

.icon-box:hover {
    background-color: #3f97da;
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.icon-box i {
    font-size: 50px;
    color: #3f97da;
    margin-bottom: 20px;
    transition: color 0.3s ease;
}

.icon-box:hover i {
    color: #fff;
}

.icon-box h4 {
    font-size: 24px;
    color: #333;
    font-weight: bold;
    margin-bottom: 20px;
}

.icon-box:hover h4 {
    color: #fff;
}

.icon-box span {
    display: inline-block;
    padding: 12px 30px;
    background-color: #3f97da;
    color: #fff;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 500;
    transition: background-color 0.3s ease;
}

.icon-box:hover span {
    background-color:rgb(255, 255, 255);
    color: #3f97da;
}

.icon-box h1 {
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 30px;
}

.icon-box:hover h1 {
    color: #fff;}


/* Mobile Menu */
@media (max-width: 768px) {
    .icon-box-container {
        flex-direction: column;
        gap: 20px;
    }

    .icon-box {
        width: 100%;
    }
}

/* Animations */
@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>
