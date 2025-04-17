<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/pdrr.png">
    <title>CJMED</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
</head>

<body>
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">

                    <form method="post" action="save_users.php" enctype="multipart/form-data" class="form-signin">
                        <div class="account-logo">
                            <a href="/menu.php"><img src="assets/img/pdrr.png" alt=""></a><br>
                            <p>CJMED</p>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="Fullname" required>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="email" placeholder="Email" required>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="password" 
                                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                   title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 characters" 
                                   placeholder="Password" required>
                            <small id="password-strength" style="display: block; margin-top: 5px;">Password strength will appear here</small>
                            <div id="strength-bar" style="height: 8px; width: 100%; background-color: #ddd; margin-top: 5px; border-radius: 4px; overflow: hidden;">
                                <div id="strength-fill" style="height: 100%; width: 0%; background-color: red; transition: width 0.3s;"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" name="confirmpass" id="confirmpass" 
                                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                   placeholder="Confirm Password" required>
                            <small id="confirm-pass-error" style="color: red; display: none;">Passwords do not match.</small>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Contact" maxlength="11" required>
                            <small id="phone-error" style="color: red; display: none;">Invalid contact number. Must start with 09 and be 11 digits long.</small>
                        </div>

                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="date" class="form-control" name="birthday" id="birthday" required>
                        </div>

                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="text" class="form-control" name="age" id="age" readonly>
                        </div>

                        <div class="form-group" hidden>
                            <label>User ID</label>
                            <input type="text" name="user_id" value="<?php echo rand(1000,9999); ?>" class="form-control"> 
                        </div>

                        <!-- Hidden Location Inputs -->
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" name="barangay" id="barangay">
                        <input type="hidden" name="municipality" id="municipality">
                        <input type="hidden" name="province" id="province">

                        <!-- Address Input -->
                        <div class="form-group">
                            <label for="address">Full Address</label>
                            <input type="text" class="form-control" name="address" id="address" readonly>
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

                        <!-- Cropper Modal -->
                        <div id="cropperModal">
                            <div class="modal-content">
                                <div class="cropper-container">
                                    <img id="cropperImage">
                                </div>
                                <button type="button" id="cropButton">Crop</button>
                            </div>
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

    <!-- Scripts -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script>
        // Password strength logic
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
        });

        // Confirm password check
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

        // Phone validation
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

        // Age calculation
        document.getElementById("birthday").addEventListener("change", function () {
            const birthday = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - birthday.getFullYear();
            const m = today.getMonth() - birthday.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthday.getDate())) age--;
            document.getElementById("age").value = age;
        });

        // CropperJS Image Preview
        document.getElementById("photo").addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("cropperModal").style.display = "block";
                    document.getElementById("cropperImage").src = e.target.result;

                    const image = document.getElementById("cropperImage");
                    const cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 1
                    });

                    document.getElementById("cropButton").addEventListener("click", function () {
                        const canvas = cropper.getCroppedCanvas({ width: 150, height: 150 });
                        document.getElementById("previewImg").src = canvas.toDataURL();
                        document.getElementById("cropperModal").style.display = "none";
                        cropper.destroy();
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        // Geolocation + Address Autofill
        window.onload = function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    document.getElementById("latitude").value = lat;
                    document.getElementById("longitude").value = lon;

                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`)
                        .then(response => response.json())
                        .then(data => {
                            const address = data.address;

                            // Extract values for individual hidden fields
                            document.getElementById("barangay").value = address.village || address.suburb || "";
                            document.getElementById("municipality").value = address.city || address.town || address.municipality || "";
                            document.getElementById("province").value = address.state || "";

                            // Build full address string
                            let fullAddress = [
                                address.road,
                                address.neighbourhood,
                                address.suburb || address.village,
                                address.city || address.town || address.municipality,
                                address.state,
                                address.postcode
                            ].filter(Boolean).join(", ");

                            document.getElementById("address").value = fullAddress;
                        })
                        .catch(error => console.error("Error fetching address:", error));
                }, function (error) {
                    console.warn("Geolocation access denied or unavailable.");
                });
            } else {
                console.warn("Geolocation is not supported by this browser.");
            }
        };
    </script>

    <!-- CSS Styles -->
    <style>
        body {
            background: linear-gradient(135deg, rgb(231, 237, 237), #3f97da);
            background-attachment: fixed;
        }

        .account-box {
            background: #fdfdfd;
            display: flex;
            flex-direction: column;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 0 128px 0 rgba(0,0,0,0.1), 0 32px 64px -48px rgba(0,0,0,0.5);
        }

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

        .cropper-container {
            max-width: 250px;
            max-height: 250px;
            overflow: hidden;
            margin: auto;
        }

        #cropButton {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #3f97da;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</body>

</html>
