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
                            <a href="agency.php"><i class="fa fa-user-md"></i> <span>Agency</span></a>
                        </li>                  
                        <?php
                        // include('../connect.php');
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending'");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){
                        ?>  
                        <li class="">
                            <a href="view-emergency.php"><i class="fa fa-file"></i> <span>Emergency</span> <span class="badge badge-pill btn-primary float-right"><?php echo $row['total'] ;?></span></a>
                        </li>
                    <?php } ?>
                        <li>
                            <a href="report_history.php"><i class="fa fa-file-text-o"></i> <span>History</span></a>
                        </li>
                        <li>                          
                            <a href="view-archived-emergencies.php"><i class="fa fa-archive"></i> <span>Archived</span></a>
                        </li>
                       <li>
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
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Emergency Details</h4>
                    </div>
                </div> 
                <?php if(get("success")):?>
                    <div>
                      <?=App::message("success", "Your request has been successfully submitted help is on the way")?>
                    </div>
                    <?php endif;?>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <?php
               $id=$_GET['id'];
    $result = $db->prepare("SELECT * FROM admin where id= :post_id");
    $result->bindParam(':post_id', $id);
    $result->execute();
    for($i=0; $row = $result->fetch(); $i++){                        
?>
<form action="update_admin.php" method="post" enctype="multipart/form-data"> 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Admin ID</label>
                                        <input class="form-control" type="text"  value="<?php echo $_SESSION['SESS_AGENCY_ID']; ?>">
                                    </div>
                                </div>
                                

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                       <input class="form-control" type="text" name="name"  value="<?php echo $row['name']; ?>">
                                        
                                    </div>

                                </div>
                            
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label>Email </label>
                                        <input class="form-control" type="text" name="email" value="<?php echo $row['email']; ?>">
                                    </div>
                                
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number  </label>
                                       <input class="form-control" type="text" name="phone"  value="<?php echo $row['phone']; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input class="form-control" type="text"  value="<?php echo $row['state']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label>Upload image of emergency</label>
                                        <div class="profile-upload">
                                            <div class="upload-img">
                                                <img alt="" src="../../uploads/<?php echo $_SESSION['SESS_PRO_PIC'];?>">
                                            </div>
                                            <div class="upload-input">
                                                <input type="file" name="photo" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                            </div>


                           
                                
                         <div class="form-group">
                            <label>Address</label>
                            <textarea cols="30" rows="4" name="address" class="form-control"><?php echo $row['address']; ?></textarea>
                        </div>

                            

                                
                                <br>
                            


                             
                            
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn">Update Status</button>
                            </div>
                          


                        </form>
                    <?php } ?>
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
</html>
