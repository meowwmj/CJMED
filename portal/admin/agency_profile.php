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
                        <li class="">
                            <a href="announcement.php"><i class="fa fa-bell"></i> <span>Announcements</span></a>
                        </li>
                        <li class="active">
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
                            <a href="logout.php"><i class="fa fa-power-off"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>    
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-7 col-6">
                        <h4 class="page-title">Agency Profile</h4>
                    </div>
                  <div class="col-sm-7 col-6 text-left m-b-30">
                        <div class="card member-panel">
							<div class="card-header bg-blue">
                                
              
            <tbody>
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
                            $result = $db->prepare("SELECT * FROM agency where id= :post_id");
                            $result->bindParam(':post_id', $id);
                            $result->execute();
                            for($i=0; $row = $result->fetch(); $i++){                        
                        ?>
                   

                                <tr><br>
												<td style="min-width: 200px;">
													 <a href="#" title=""><img src="../../uploads/<?php echo $row['photo']; ?>" alt="" class="w-40 rounded-circle"></a><br>
													<br><h4><?php echo $row['agency_name']; ?><br><span><?php echo $row['address']; ?></span></a></h4>
												</td>                 
												<td>
													<h5 class="time-title p-0"><?php echo $row['email']; ?></h5>
													<p><?php echo $row['phone_number']; ?></p>
												</td>
												<td>
													<h5 class="time-title p-0">Person in Charge: <span><?php echo $row['personincharge']; ?></span></h5>
													<!-- <p>7.00 PM</p> -->
												</td>
												
											</tr><br>

                        </form>
                    <?php } ?><br><br>
                    </div>
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


<style>

div.member-panel {
    background: #fdfdfd;
    flex-direction: column;
    padding: 25px 25px;
    border-radius: 20px;
    box-shadow: 0 0 128px 0 rgba(0,0,0,0.1),
                0 32px 64px -48px rgba(0,0,0,0.5);
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
