<?php include 'includes/head.php'; ?>

<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <?php include 'includes/sidebar.php'; ?>    
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li>
                            <a href="report-emergency.php"><i class="fa fa-heartbeat"></i> <span>Report Emergency</span></a>
                        </li> 
                        <li>
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending' ORDER BY id DESC ");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){ ?>
                    <li><a href="view-emergency.php"><i class="fa fa-file"></i> <span>Emergency</span> <span class="badge badge-pill btn-primary float-right"><?php echo $row['total'] ;?></span></a></li>
                    <?php } ?>
                        </li>
                        <li class=active>
                            <a href="announcement.php"><i class="fa fa-bell"></i> <span>Announcements</span></a>
                        </li>           
                        <li>
                            <a href="report_history.php"><i class="fa fa-file-text-o"></i> <span>History</span></a>
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
              <div class="card">   
                <div class="choice-container">

                   <?php
                    // Weather API Key
                    $apiKey = '980c1618e365c5afc9ebbff60fa6781f'; // Replace with your OpenWeatherMap API Key

                    // List of towns in Bulacan with their coordinates (latitude, longitude)
                    $towns = [
                        ['name' => 'Hagonoy', 'lat' => 14.8341, 'lon' => 120.7327],
                        ['name' => 'Malolos', 'lat' => 14.8440, 'lon' => 120.8182],
                        ['name' => 'San Jose del Monte', 'lat' => 14.7777, 'lon' => 121.0437],
                        ['name' => 'Meycauayan', 'lat' => 14.7254, 'lon' => 120.9570],
                        ['name' => 'Balagtas', 'lat' => 14.7833, 'lon' => 120.8500],
                        ['name' => 'Sta. Maria', 'lat' => 14.7701, 'lon' => 120.9604],
                        ['name' => 'Angat', 'lat' => 14.8791, 'lon' => 120.8877],
                        ['name' => 'Bocaue', 'lat' => 14.7554, 'lon' => 120.9672],
                        ['name' => 'Pandi', 'lat' => 14.8583, 'lon' => 120.9516],
                        ['name' => 'Plaridel', 'lat' => 14.7920, 'lon' => 120.7442],
                        ['name' => 'Baliuag', 'lat' => 14.9460, 'lon' => 120.9682],
                        ['name' => 'Norzon', 'lat' => 14.7809, 'lon' => 120.8247],
                        // Add more towns if needed
                    ];

                    // Function to get weather data
                    function getWeatherData($latitude, $longitude, $apiKey) {
                        $url = "https://api.openweathermap.org/data/2.5/weather?lat={$latitude}&lon={$longitude}&appid={$apiKey}&units=metric";
                        $weatherData = file_get_contents($url);
                        return json_decode($weatherData, true);
                    }

                    // Caching mechanism: Cache for 10 minutes
                    $cacheFile = 'weather_cache.json'; // Cache file
                    $cacheTime = 600; // Cache for 10 minutes (600 seconds)

                    if (file_exists($cacheFile) && time() - filemtime($cacheFile) < $cacheTime) {
                        $weatherData = json_decode(file_get_contents($cacheFile), true);
                    } else {
                        // Fetch new weather data from API
                        $weatherData = [];
                        foreach ($towns as $town) {
                            $weatherData[] = getWeatherData($town['lat'], $town['lon'], $apiKey);
                        }

                        // Cache the data for future use
                        file_put_contents($cacheFile, json_encode($weatherData));
                    }

                    ?>
                        <!DOCTYPE html>
                        <html lang="en">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.0/lazysizes.min.js"></script>
                            </head>
                        <body>

                        <h1>Weather Informations</h1>
                            <div class="weather-container" id="weather-container">
                                <!-- Initially Load 8 towns' weather data -->
                            </div>

                        <!-- Show More Button -->
                        <button class="show-more" onclick="showMore()">Show More</button>

                    <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        if (navigator.geolocation) {
                            // Get the user's current location
                            navigator.geolocation.getCurrentPosition(function(position) {
                                const userLat = position.coords.latitude;  // User's latitude
                                const userLon = position.coords.longitude; // User's longitude

                                // Now fetch the weather for the user's location
                                fetchWeatherForUserLocation(userLat, userLon);
                            }, function(error) {
                                console.error("Geolocation error: " + error.message);
                                // Optionally, handle the error (e.g., display a message to the user)
                            });
                        } else {
                            console.log("Geolocation is not supported by this browser.");
                        }
                    });

                    function fetchWeatherForUserLocation(lat, lon) {
                        const apiKey = '980c1618e365c5afc9ebbff60fa6781f'; // Replace with your OpenWeatherMap API key
                        const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`;

                        // Fetch the weather data using the user's location
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                const container = document.getElementById("weather-container");

                                // Get the weather icon URL
                                const iconUrl = `https://openweathermap.org/img/wn/${data.weather[0].icon}.png`;

                                // Construct the weather information HTML
                                const weatherInfo = `
                                    <div class='weather-info'>
                                        <h3>Your Location</h3>
                                        <img class="lazyload" data-src='${iconUrl}' alt='Weather Icon'>
                                        <p class='temp'>${data.main.temp}°C</p>
                                        <p><strong>Condition:</strong> ${data.weather[0].description}</p>
                                        <p><strong>Humidity:</strong> ${data.main.humidity}%</p>
                                        <p><strong>Wind Speed:</strong> ${data.wind.speed} m/s</p>
                                        <div class='more-info'>
                                            <p><strong>Pressure:</strong> ${data.main.pressure} hPa</p>
                                            <p><strong>Visibility:</strong> ${(data.visibility / 1000)} km</p>
                                            <p><strong>Sunrise:</strong> ${new Date(data.sys.sunrise * 1000).toLocaleTimeString()}</p>
                                            <p><strong>Sunset:</strong> ${new Date(data.sys.sunset * 1000).toLocaleTimeString()}</p>
                                        </div>
                                    </div>
                                `;

                                // Display the weather information
                                container.innerHTML = weatherInfo;
                            })
                            .catch(error => {
                                console.error("Error fetching weather data:", error);
                                // Handle error (e.g., show an error message)
                            });
                    }
                    </script>
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


                    <div class="page-wrapper">
                        <div class="content">
                            <div class="card">   
                                <div class="card-header">
                                    <h1 class="card-title d-inline-block">Useful Links</h1></a>
                                </div>
                                    
                        <section class="banners" style="margin-top:10px;">    
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-3 mb-3">
                                    <a href="https://bagong.pagasa.dost.gov.ph/index.php" target="_blank">
                                        <img src="https://pdrrmo.bulacan.gov.ph/wp-content/themes/pdrrmcv1-ais/assets/images/Pagasa Banner.jpg" alt="" class="banner-item">
                                    </a>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <a href="http://prffwc.synthasite.com/status-of-pampanga-river-basin.php" target="_blank">
                                        <img src="https://pdrrmo.bulacan.gov.ph/wp-content/themes/pdrrmcv1-ais/assets/images/Pampanga River.jpg" alt="" class="banner-item">
                                    </a>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <a href="http://prffwc.synthasite.com/hydro-forecast.php" target="_blank">
                                        <img src="https://pdrrmo.bulacan.gov.ph/wp-content/themes/pdrrmcv1-ais/assets/images/Hydrological.jpg" alt="" class="banner-item">
                                    </a>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-4">
                                <div class="col-12 col-md-4 mb-3">
                                    <a href="http://faultfinder.phivolcs.dost.gov.ph/" target="_blank">
                                        <img src="https://pdrrmo.bulacan.gov.ph/wp-content/uploads/2022/01/Fault-Finder.jpg" alt="" class="banner-item">
                                    </a>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <a href="https://www.phivolcs.dost.gov.ph/index.php/earthquake/earthquake-information3" target="_blank">
                                        <img src="https://pdrrmo.bulacan.gov.ph/wp-content/uploads/2022/01/Philvocs.jpg" alt="" class="banner-item">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                    </div>
                </div>
            </div>
        </body>
    </html>
    
