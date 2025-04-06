<?php include 'includes/head.php'; ?>

<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="">
                            <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        <li>
                            <a href="announcement.php"><i class="fa fa-bell"></i> <span>Announcements</span></a>
                        </li>
                        <li class="active">
                            <a href="agency.php"><i class="fa fa-user-md"></i> <span>Agency</span></a>
                        </li>
                        <li>
                            <a href="report-emergency.php"><i class="fa fa-heartbeat"></i> <span>Reports Emergency</span></a>
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
                        
                        <li>
                            <a href="report_history.php"><i class="fa fa-file-text-o"></i> <span>History</span></a>
                        </li>
                        <li>                          
                            <a href="view-archived-emergencies.php"><i class="fa fa-file"></i> <span>Archived</span></a>
                        </li>
                        <li>
                            <a href="users.php"><i class="fa fa-user-plus"></i> <span>Manage Admin</span></a>
                        </li>
                        <li>
                            <a href="users1.php"><i class="fa fa-user"></i> <span>Manage Users</span></a>
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
        </div>

        
        <div class="page-wrapper">
            <div class="content">                
                        <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Add Agency</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form action="save_agency.php" method="post" enctype="multipart/form-data">      
                        <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                   
                                    <div class="form-group">
                                        <label>Agency Name</label>
                                        <input class="form-control" name="agency_name" type="text" required="true">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Emergency Number</label>
                                        <input class="form-control" name="phone_number" type="text" required="true">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" name="email" type="email" required="true">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Person in Charge</label>
                                        <input class="form-control" name="personincharge" type="text" required="true">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                <div class="form-group">
                                <label>Address </label>
                                <input class="form-control" name="address" type="text" required="true">                 
                            </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input class="form-control" name="username" type="text" required="true">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" id="password" required="true">
                                    </div>
                                </div>								
                              
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                      <label>Picture</label>
                                     <div class="profile-upload">
                                    <div class="upload-img">
                                       <img id="previewImg" alt="" src="assets/img/user.jpg">
                                      </div>
                                  <div class="upload-input">
                                    <input type="file" name="photo" class="form-control" id="photo">
                                  </div>
										</div>
									</div>
                                </div>
                            </div>
				 <div class="col-sm-6">
					<div class="form-group"hidden>
                                        <label>Agency ID</label>
                                        <input class="form-control" type="text" name="agency_id" value="<?php echo rand(1000,9999); ?>" readonly="">
                                    </div>
                                </div>
                                
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn">Add Agency</button>
                            </div>
                        </form>
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


<script>
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
</script>


<style>

/* Form fields */
.form-group label {
    font-weight: 400;
    color: #333;
}

/* Input fields */
.form-control {
    border-radius: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    transition: all 0.3s ease;
}

/* Input focus effect */
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
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

</body>
</html>
