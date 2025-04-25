<?php include 'includes/head.php';
date_default_timezone_set('Asia/Manila');
?>

<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        <li>
                            <a href="announcement.php"><i class="fa fa-bell"></i> <span>Announcements</span></a>
                        </li>                       
                        <?php
                        // include('../connect.php');
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending'");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){
                        ?>  
                     <li class="active">
                            <a href="view-emergency.php"><i class="fa fa-file"></i> <span>Emergency</span> <span class="badge badge-pill bg-primary float-right"><?php echo $row['total'] ;?></span></a>
                        </li>
                    <?php } ?>
                        <li >
                            <a href="report_history.php"><i class="fa fa-file-text-o"></i> <span>History</span></a>
                        </li>
                        <li class>                          
                            <a href="view-archived-emergencies.php"><i class="fa fa-archive"></i> <span>Archived</span></a>
                        </li>                       
                         

                        <li>
                            <a href="logout.php"><i class="fa fa-power-off"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
                        
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">
            <div class="card">   
                <div class="choice-container">
                    
                    <a href="report_incident.php"><div class="choice-item active" id="reportIncidentText" onclick="setActive(this)">📢 Report an Incident</div></a>
                </div>
                    <form action="save_emergency.php" method="post" enctype="multipart/form-data">
                        <?php if(get("success")):?>
                            <div>
                            <?=App::message("success", "Your request has been successfully submitted help is on the way")?>
                            </div>
                        <?php endif;?>
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Emergency Details -->
                                    <div class="form-group" hidden>
                                        <label>Emergency ID</label>
                                        <input class="form-control" type="text" name="emergency_id" value="<?= rand(1000,9999) ?>" readonly>
                                    </div>
                                    
                                    <div class="form-group" hidden>
                                        <label>User ID</label>
                                        <input class="form-control" type="text" name="user_id" value="<?= rand(1000,9999) ?>" readonly> 
                                    </div>

                                    <div class="form-group">
                                        <label>Patient's Name</label>
                                        <select class="form-control" id="patientSelect" name="patient_select" required="true">
                                            <option value="" selected disabled>Select Patient</option>
                                            <option value="unknown">To be determine</option>
                                            <option value="custom">Enter patient name manually</option>
                                        </select>
                                        <input class="form-control mt-2" type="text" name="patient_name" id="patientNameInput" style="display: none;" placeholder="Enter patient's name">
                                    </div>

                                    <div class="form-group" hidden>
                                        <label>Date & Time</label>
                                        <input class="form-control" value="<?= date('m-d-Y h:i A') ?>" readonly>
                                        <input type="hidden" name="dates" value="<?= date('Y-m-d H:i:s') ?>">
                                    </div> 

                                    <div class="form-group">
                                        <label>Contact</label>
                                        <input class="form-control" type="text" name="phone" value="<?= $_SESSION['SESS_PHONE_NUMBER'] ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Age</label>
                                        <select class="select" name="age">
                                            <option value="#">Select Age Group</option>
                                            <option value="(0-14 years old)">(0-14 years old)</option>
                                            <option value="(15-24 years old)">(15-24 years old)</option>
                                            <option value="(25-64 years old)">(25-64 years old)</option>
                                            <option value="(65 years old and over)">(65 years old and over)</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Injury</label>
                                        <input class="form-control" name="injury" type="text" required="true">
                                    </div>

                                    <div class="form-group">
                                        <label>Emergency Category</label>
                                        <select class="select" name="emergency_category">
                                            <option>Select</option>
                                                <?php
                                                    $result = $db->prepare("SELECT * FROM emergency_type");
                                                    $result->execute();
                                                    while($row = $result->fetch()): ?>
                                                        <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    
                                    
                                    <div class="form-group">
                                        <label>Agency Name</label>
                                        <select class="select" name="agency_id">
                                        <option>Select</option>
                                            <?php
                                            $result = $db->prepare("SELECT * FROM agency");
                                            $result->execute();
                                            while($row = $result->fetch()): ?>
                                                <option value="<?= $row['agency_id'] ?>"><?= $row['agency_name'] ?></option>
                                            <?php endwhile; ?>
                                            </select>
                                        </div>
                                        
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea cols="30" rows="2" name="description" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p><strong>Location:</strong><span id="address" hidden>Fetching address...</span></p>
                                        <div id="map" style="height: 300px; border-radius: 10px; margin-bottom: 10px;"></div>
                                        <input type="hidden" name="address" id="addressInput">
                                        <input type="hidden" name="latitude" id="latitude">
                                        <input type="hidden" name="longitude" id="longitude">
                                    </div>

                                    <div class="form-group">
                                        <label>Barangay</label>
                                        <span id="barangay" class="form-control" readonly></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Municipality</label>
                                        <span id="municipality" class="form-control" readonly></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Province</label>
                                        <span id="province" class="form-control" readonly></span>
                                    </div>  
                                    <div class="form-group" hidden>
                                        <label>User ID</label>
                                        <input type="text" name="user_id"  value="<?php echo rand(1000,9999); ?>" class="form-control"> 
                                    </div>
                                </div>
                            </div>
 
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Rescue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaflet.js for Map -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    let video = document.getElementById('camera');
    let canvas = document.getElementById('snapshot');
    let capturedInput = document.getElementById('capturedPhoto');
    let cameraSection = document.getElementById('cameraSection');
    let stream;

    function openCamera() {
        cameraSection.style.display = 'block';
        navigator.mediaDevices.getUserMedia({ video: true })
        .then((mediaStream) => {
            stream = mediaStream;
            video.srcObject = mediaStream;
        })
        .catch((err) => {
            alert("Unable to access camera.");
            console.error(err);
        });
    }

    function capturePhoto() {
        canvas.style.display = 'block';
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        let imageData = canvas.toDataURL('image/png');
        capturedInput.value = imageData;

        // Stop the stream
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }

        video.srcObject = null;
    }
</script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(async function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;

                        const map = L.map('map').setView([lat, lng], 20);

                        L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                            maxZoom: 18,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                        }).addTo(map);

                        const marker = L.marker([lat, lng], { draggable: false }).addTo(map);

                        async function fetchAddress(lat, lng) {
                            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                            const data = await response.json();
                            const address = data.display_name || 'Address not found';

                            document.getElementById('address').textContent = address;
                            document.getElementById('addressInput').value = address;

                            let barangay = '';
                            let municipality = '';
                            let province = '';

                            if (data.address) {
                                barangay = data.address['suburb'] || data.address['neighbourhood'] || '';
                                municipality = data.address['city'] || data.address['town'] || data.address['village'] || '';
                                province = data.address['state'] || data.address['country'] || '';
                            }

                            document.getElementById('barangay').textContent = barangay || 'Not available';
                            document.getElementById('municipality').textContent = municipality || 'Not available';
                            document.getElementById('province').textContent = province || 'Not available';

                            marker.bindPopup(address).openPopup();
                        }

                        fetchAddress(lat, lng);

                        marker.on('dragend', function() {
                            const pos = marker.getLatLng();
                            document.getElementById('latitude').value = pos.lat;
                            document.getElementById('longitude').value = pos.lng;
                            fetchAddress(pos.lat, pos.lng);
                        });
                    });
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            });
        </script>

<script>
    document.getElementById('age').addEventListener('input', function() {
        const age = parseInt(this.value);
        const error = document.getElementById('ageError');
        if (isNaN(age) || age < 1 || age > 120) {
            error.style.display = 'block';
        } else {
            error.style.display = 'none';
        }
    });
</script>

    <style>
    /* Flexbox for horizontal layout */
    .choice-container {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin: 30px 0;
        background-size: cover; /* Ensures the background covers the whole page */
        background-attachment: fixed; /* Optional: Keeps the background fixed when scrolling */
    }

    /* Base button style */
    .choice-item {
        font-size: 20px;
        font-weight: 600;
        padding: 12px 25px;
        cursor: pointer;
        color: #2c3e50; /* Danger red */
        background: none;
        border: none;
        border-bottom: 3px solid transparent; /* For underline effect */
    }

    /* Hover effect */
    .choice-item:hover {
        color: #721c24; /* Darker red */
    }

    /* Active style (clicked) */
    .choice-item.active {
        color: #dc3545;
        border-bottom: 3px solid #dc3545;
    }
    
    /* Form container */
    .card {
        background: #ffffff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Form fields */
    .form-group label {
        font-weight: 600;
        color: #333;
    }

    /* Input fields */
    .form-control {
        border-radius: 8px;
        padding: 10px;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    /* Input focus effect */
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
    }
#snapshot {
    display: none;
    margin: 0 auto 15px auto;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

    </style> 

    <script>
    // Function to toggle 'active' class
    function setActive(element) {
        // Remove 'active' class from all items
        document.querySelectorAll('.choice-item').forEach(item => {
        item.classList.remove('active');
        });

        // Add 'active' class to clicked item
        element.classList.add('active');
    }
    
    </script>


    <?php include 'includes/message.php'; ?>
            </div>
        </div>
        <div class="sidebar-overlay" data-reff=""></div>
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/select2.min.js"></script>
        <script src="assets/js/moment.min.js"></script>
        <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="assets/js/app.js"></script>


    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Are you sure you want to log out?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        </div>
    </div>
    </div>

    </body>
    </html>


<script>
    document.getElementById('patientSelect').addEventListener('change', function () {
        const input = document.getElementById('patientNameInput');
        if (this.value === 'custom') {
            input.style.display = 'block';
            input.required = true;
        } else {
            input.style.display = 'none';
            input.required = false;
            input.value = this.value === 'unknown' ? 'Unknown' : '';
        }
    });
</script>
