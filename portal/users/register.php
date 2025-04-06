<!DOCTYPE html>
<html lang="en">


<!-- register24:03-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/pdrr.png">
    <title>CJMED</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
</head>

<body>
    <div class="main-wrapper  account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">

                    <form method="post" action="save_users.php" enctype="multipart/form-data" class="form-signin">
						<div class="account-logo">
                            <a href="/hiraya/portal/users/sign-in.php"><img src="assets/img/pdrr.png" alt=""></a><br>
                            <p>CJMED</p>
                        </div>
                            
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Fullname" required="true">
                        </div>
                      
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" required="true">
                        </div>
                         <div class="form-group">
                           <input type="text" class="form-control" name="username" id="username" placeholder="Username" required="true">
                        </div>
                        <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Password" required="true">
                        <small id="password-strength" style="display: block; margin-top: 5px;">Password strength will appear here</small>
                            <div id="strength-bar" style="height: 8px; width: 100%; background-color: #ddd; margin-top: 5px; border-radius: 4px; overflow: hidden;">
                                <div id="strength-fill" style="height: 100%; width: 0%; background-color: red; transition: width 0.3s;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                        <input type="password" class="form-control" name="confirmpass" id="confirmpass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Confirm Password" required="true">
                        <small id="confirm-pass-error" style="color: red; display: none;">Passwords do not match.</small>
                        </div>
                        <div class="form-group">
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Contact" maxlength="11" required="true">
                        <small id="phone-error" style="color: red; display: none;">Invalid contact number. Must start with 09 and be 11 digits long.</small>
                        </div>
                        <div class="form-group">
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" required="true">
                        </div>
                        <div class="form-group" hidden>
                            <label>User ID</label>
                            <input type="text" name="user_id"  value="<?php echo rand(1000,9999); ?>" class="form-control"> 
                        </div>


                            <!-- Profile Picture Upload -->
                        <div class="form-group">
                            <label>Picture</label>
                            <div class="profile-upload">
                                <div class="upload-img">
                                    <img id="previewImg" src="assets/img/user.jpg" alt="Profile Picture">
                                </div>
                                <div class="upload-input">
                                    <input type="file" name="photo" class="form-control" id="photo">
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Cropping -->
                        <div id="cropperModal">
                            <div class="modal-content">
                                <div class="cropper-container">
                                    <img id="cropperImage">
                                </div>
                                <button type="button" id="cropButton">Crop</button>
                            </div>
                        </div>                         
                        <div class="form-group checkbox">
                            
                        </div>
                        <div class="form-group text-center">
                       <input type="submit" name="login" class="btn btn-primary btn-user btn-block" value="Signup">
                        </div>
                        <div class="text-center login-link">
                            Already have an account? <a href="sign-in.php">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Password Strength Indicator
        document.getElementById("password").addEventListener("input", function () {
            const password = this.value;
            const strengthText = document.getElementById("password-strength");
            const strengthFill = document.getElementById("strength-fill");
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            switch (strength) {
                case 0:
                case 1:
                    strengthText.textContent = "Weak (must be 8+ characters)";
                    strengthText.style.color = "red";
                    strengthFill.style.width = "20%";
                    strengthFill.style.backgroundColor = "red";
                    break;
                case 2:
                case 3:
                    strengthText.textContent = "Medium (add numbers, uppercase & special chars)";
                    strengthText.style.color = "orange";
                    strengthFill.style.width = "60%";
                    strengthFill.style.backgroundColor = "orange";
                    break;
                case 4:
                case 5:
                    strengthText.textContent = "Strong!";
                    strengthText.style.color = "green";
                    strengthFill.style.width = "100%";
                    strengthFill.style.backgroundColor = "green";
                    break;
            }

            // Contact Number Validation
        document.getElementById("phone").addEventListener("input", function () {
            const phone = this.value;
            const phoneError = document.getElementById("phone-error");
            const isValid = /^09\d{9}$/.test(phone);

            if (isValid || phone === "") {
                phoneError.style.display = "none";
                this.style.borderColor = "";
            } else {
                phoneError.style.display = "block";
                this.style.borderColor = "red";
            }
        });
        });
         // Image Preview
         document.getElementById("photo").addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("previewImg").src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
        
        document.getElementById("confirmpass").addEventListener("input", function () {
        const password = document.getElementById("password").value;
        const confirmPassword = this.value;
        const error = document.getElementById("confirm-pass-error");

        if (confirmPassword !== password) {
            error.style.display = "block";
            this.style.borderColor = "red";
        } else {
            error.style.display = "none";
            this.style.borderColor = "green";
        }
    });
        </script>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
<script>
document.getElementById("photo").addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("cropperModal").style.display = "block";
            document.getElementById("cropperImage").src = e.target.result;

            // Initialize Cropper
            const image = document.getElementById("cropperImage");
            const cropper = new Cropper(image, {
                aspectRatio: 1, // Square crop
                viewMode: 1,
                autoCropArea: 1
            });

            // Crop and Preview
            document.getElementById("cropButton").addEventListener("click", function () {
                const canvas = cropper.getCroppedCanvas({
                    width: 150, // Adjust size for better preview
                    height: 150
                });

                document.getElementById("previewImg").src = canvas.toDataURL();
                document.getElementById("cropperModal").style.display = "none";
                cropper.destroy(); // Cleanup cropper instance
            });
        };
        reader.readAsDataURL(file);
    }
});
</script>

<!-- register24:03-->
</html>

<style>
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

/* Modal Styling */
#cropperModal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    z-index: 1000;
    text-align: center;
}

/* Cropper Image Container */
.cropper-container {
    max-width: 250px; /* Smaller Size */
    max-height: 250px;
    overflow: hidden;
    margin: auto;
}

/* Crop Button */
#cropButton {
    margin-top: 10px;
    padding: 8px 15px;
    border: none;
    background: #007bff;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}
</style>