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
                        <li>
                            <a href="view-emergency.php"><i class="fa fa-file"></i> <span>Emergency</span> <span class="badge badge-pill btn-primary float-right"><?php echo $row['total'] ;?></span></a>
                        </li>
                    <?php } ?>
                        <li >
                            <a href="report_history.php"><i class="fa fa-file-text-o"></i> <span>History</span></a>
                        </li>
                        <li>
                            <a href="profile.php"><i class="fa fa-user"></i> <span>Profile</span></a>
                        </li>
                        
                         <li class="active">
                            <a href="rescue.php"><i class="	fa fa-calendar-o"></i> <span>Rescue</span></a> 
                        </li>

                        <li>
                            <a href="logout.php"><i class="fa fa-power-off"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />


    </head>
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
        
    <body><br>
        <div id="map" style="width:100%; height: 80vh"></div>
        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>



    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

    <!-- Geocoding library -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        // Initialize the map
        var map = L.map('map').setView([14.8443, 120.81039], 15);

        // Add satellite view layer
        L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);

        // Marker icons
        var amb = L.icon({
            iconUrl: 'assets/img/amb.png',
            iconSize: [30, 50]
        });
        var hospital = L.icon({
            iconUrl: 'assets/img/hospital.png',
            iconSize: [30, 30]
        });

        // List of markers
        var markers = [
            { coords: [14.8612, 120.8113], icon: amb, name: "MDRRMO" },
            { coords: [14.8571, 120.8152], icon: amb, name: "PDRRMC" },
            { coords: [14.8369, 120.7335], icon: hospital, name: "Hagonoy Perez" },
            { coords: [14.8589, 120.8169], icon: hospital, name: "Bulacan Medical Center" },
            { coords: [14.8520, 120.8179], icon: hospital, name: "Sacred Heart Hospital of Malolos, Inc." },
            { coords: [14.8539, 120.8114], icon: hospital, name: "Allied Care Experts (ACE)" },
            { coords: [14.8383, 120.8138], icon: hospital, name: "Mary Immaculate Maternity & General Hospital" }
        ];

        // Function to get address from coordinates (reverse geocoding)
        function getAddress(lat, lng, callback) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    callback(data.display_name || "Address not found");
                })
                .catch(error => {
                    console.error('Error fetching address:', error);
                    callback("Address not available");
                });
        }

        // Add markers with address on click
        markers.forEach(marker => {
            L.marker(marker.coords, { icon: marker.icon }).addTo(map)
                .on('click', function () {
                    getAddress(marker.coords[0], marker.coords[1], (address) => {
                        this.bindPopup(`<strong>${marker.name}</strong><br>${address}`).openPopup();
                    });
                });
        });

        // Show user's current location with address
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                map.setView([lat, lng], 15);

                getAddress(lat, lng, (address) => {
                    L.marker([lat, lng]).addTo(map)
                        .bindPopup(`<strong>Your Location</strong><br>${address}`)
                        .openPopup();
                });
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    </script>


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
        <script>
                $(function () {
                    $('#datetimepicker3').datetimepicker({
                        format: 'LT'

                    });
                });
        </script>
    </body>


    <!-- add-appointment24:07-->
    </html>
