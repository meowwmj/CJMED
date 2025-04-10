<?php include 'includes/head.php'; ?>

<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>                        
                        <li class>
                            <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        <li>
                            <a href="announcement.php"><i class="fa fa-bell"></i> <span>Announcements</span></a>
                        </li>
                        <li class>
                            <a href="agency.php"><i class="fa fa-user-md"></i> <span>Agency</span></a>
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
                            <a href="view-archived-emergencies.php"><i class="fa fa-archive"></i> <span>Archived</span></a>
                        </li>
                        <li class="active">
			<a href="#"><i class="fa fa-users"></i> <span>Manage</span> <span class="menu-arrow"></span></a>
			<ul class="submenu-list">
			    <li>
			        <a href="users.php"><i class="fa fa-user-plus"></i> <span>Manage Admin</span></a>
			    </li>
			    <li>
			        <a href="users1.php"><i class="fa fa-user"></i> <span>Manage Users</span></a>                        
			    </li>
			</ul>
			</li>
                        <li>
                            <a href="rescue.php"><i class="fa fa-calendar-o"></i> <span>Rescue</span></a> 
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
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Add Admin</h4>
                    </div>
                </div>
                <?php if(get("success")):?>
                    <div>
                      <?=App::message("success", "Successful")?>
                    </div>
                    <?php endif;?>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form action="save_admin.php" method="post" enctype="multipart/form-data">      
                        <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input class="form-control" type="text" name="name" required="true">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input class="form-control" type="text" name="phone" required="true">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" type="text" name="email" required="true">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input class="form-control" type="text" name="address" required="true">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input class="form-control" type="text" name="username" required="true">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required="true">
                                        </div>
                                </div>
                            </div>

                            <div class="row">
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
                          
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label>Admin ID</label>
                                        <input class="form-control" type="text" name="agency_id" value="<?php echo rand(1000,9999); ?>" readonly="">
                                    </div>
                                 </div>
                             </div>                          
                                                   
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn">Save</button>
                            </div>
                        </div>
                    </div>
                        </form>
                    </div>
                </div>
                <div class="content">
                <div class="card">
                <div class="card-header">
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">All Admin</h4>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-border table-striped custom-table datatable mb-0" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Pic</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Phone Number</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $loggedInAdminId = $_SESSION['SESS_MEMBER_ID']; // Get the ID of the currently logged-in admin

                                    $result = $db->prepare("SELECT * FROM admin WHERE id <> :loggedInAdminId");
                                    $result->bindParam(':loggedInAdminId', $loggedInAdminId);
                                    $result->execute();

                                    $i = 1;
                                    while ($row = $result->fetch()) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i; ?></td>
                                            <td class="text-center"><img src="../../uploads/<?php echo $row['photo']; ?>" class="rounded-circle m-r-5" width="28" height="28"></td>
                                            <td class="text-center"><?php echo $row['name']; ?></td>
                                            <td class="text-center"><?php echo $row['agency_id']; ?></td>
                                            <td class="text-center"><?php echo $row['phone']; ?></td>
                                            <td class="text-center"><?php echo $row['email']; ?></td>
                                            <td class="text-center"><?php echo $row['address']; ?></td>
                                            <td class="text-center">
                                                 <?php if ($row['status'] == 'active'): ?>
                                                     <a class="btn btn-primary" href="disable_user.php?id=<?php echo $row['id']; ?>"><i fa fa-ban></i> Disable</a>
                                                 <?php else: ?>
                                                    <span class="text-muted">Disabled</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            </div>
            <?php include 'includes/message.php'; ?>
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
.submenu-list {
    list-style: none;
    padding-left: 20px;
    margin: 0; /* Remove any margin */
    background-color: #2c3e50; /* Ensure the background blends with the sidebar */
}   
.submenu-list li {
    margin: 0;
    background-color: #2c3e50; 
    padding: 0px;
    padding-top: 10px;
}

.submenu-list a {
    background-color: #2c3e50;
    text-decoration: none;
    font-size: 15px;
    padding: 10px;
    display: block;
    border-radius: 25px;
    transition: all 0.3s ease;
}

.submenu-list a:hover,
.submenu-list .active a {
    background-color: #fff;
    color: #2c3e50;
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
