<?php include 'includes/head.php'; ?>

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
                        <li>
                            <a href="report-emergency.php"><i class="fa fa-heartbeat"></i> <span>Report Emergency</span></a>
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
                            <a href="view-archived-emergencies.php"><i class="fa fa-file"></i> <span>Archived</span></a>
                        </li>
                        <li>
                            <a href="profile.php"><i class="fa fa-user"></i> <span>Profile</span></a>
                        </li>
                        <li>
                            <a href="rescue.php"><i class="	fa fa-calendar-o"></i> <span>Rescue</span></a> 
                        </li>
                        <li>
                            <a href="logout.php"><i class="fa fa-power-off"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>  

        <div class="page-wrapper">
       <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-title text-center">Emergency Details</h4>
            </div>
        </div> 

        <?php if(get("success")):?>
            <div class="alert alert-success text-center">
                <?=App::message("success", "Your request has been successfully submitted. Help is on the way!")?>
            </div>
        <?php endif;?>

        <div class="row">
            <?php
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $result = $db->prepare("SELECT * FROM emergency WHERE id = :post_id");
                    $result->bindParam(':post_id', $id);
                    $result->execute();
                    $row = $result->fetch();
            ?>
            <form action="update_status.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" class="w-100">
                <div class="row">
                    <!-- Emergency Details on the Left -->
                    <div class="col-md-6">
                        <div class="card p-4 shadow">
                            <h5>Emergency Information</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Emergency ID:</strong> <?php echo $row['emergency_id']; ?></li>
                                <li class="list-group-item"><strong>Name:</strong> <?php echo $row['patient_name']; ?></li>
                                <li class="list-group-item"><strong>Emergency Category:</strong> <?php echo $row['emergency_category']; ?></li>
                                <li class="list-group-item"><strong>Address:</strong> <span id="emergency-address"><?php echo $row['address']; ?></span></li>
                                <li class="list-group-item"><strong>Phone Number:</strong> <?php echo $row['phone']; ?></li>
                                <li class="list-group-item"><strong>Email:</strong> <?php echo $_SESSION['SESS_EMAIL']; ?></li>
                                <li class="list-group-item"><strong>Age:</strong> <?php echo $row['age']; ?></li>
                                <li class="list-group-item"><strong>Status:</strong>
                                    <select class="select form-control" name="status">
                                        <option value="Pending">Ongoing</option>
                                        <option value="Resolved">Resolved</option>
                                    </select>
                                </li>                             
                                <li class="list-group-item"><strong>Injury:</strong> <?php echo $row['injury']; ?></li>
                                <li class="list-group-item"><strong>Description:</strong> <?php echo $row['description']; ?></li>
                            </ul>
                            <div class="mt-3 text-center">
                                <button class="btn btn-primary submit-btn">Update Status</button>
                            </div>
                        </div>
                    </div>

                    <!-- Map on the Right -->
                    <div class="col-md-6">
                        <div class="card p-4 shadow">
                            <h5>Location on Map</h5>
                            <div id="map" style="height: 585px; border-radius: 10px;"></div>
                        </div>
                    </div>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</div>


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


    <div class="sidebar-overlay" data-reff=""></div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/app.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var address = document.getElementById("emergency-address").innerText.trim();
            if (!address) {
                alert("No address available.");
                return;
            }
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        alert("Location not found!");
                        return;
                    }
                    var lat = parseFloat(data[0].lat);
                    var lon = parseFloat(data[0].lon);
                    var map = L.map('map').setView([lat, lon], 15);
                    L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                        maxZoom: 20,
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                    }).addTo(map);
                    L.marker([lat, lon]).addTo(map)
                        .bindPopup("<b>Emergency Location</b><br>" + address)
                        .openPopup();
                })
                .catch(error => console.error("Error fetching location:", error));
        });
    </script>
</body>
</html>
