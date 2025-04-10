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
                        <li class="">
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
                            <a href="view-emergency.php"><i class="fa fa-file"></i> <span>Emergency</span> <span class="badge badge-pill btn-primary float-right"><?php echo $row['total'] ;?></span></a>                        </li>
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
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">All Agency</h4>
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-agency.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Agency</a>
                    </div>

                </div>
                    
		<div class="row doctor-grid ">
                    <?php if(!isset($_GET["page"])){
                        $_GET["page"] = 1;
                    }
                    $tbl_name="agency"; //your table name

                    $adjacents = 3; // How many adjacent pages should be shown on each side?
  
                            /*$query = "SELECT COUNT(*) as num FROM $tbl_name";
                              $total_pages = mysqli_fetch_array(mysqli_query($conn,$query));
                              $total_pages = $total_pages['num'];
                            */
                    $get_agency = ORM::for_table("$tbl_name")->find_array();
                    $total_pages = count($get_agency);
                    /* Setup vars for query. */
                    $targetpage = "agency.php";   //your file name  (the name of this file)
                    $limit = 10;                //how many items to show per page
                    $page = $_GET['page'];
                    if($page) 
                    $start = ($page - 1) * $limit;      //first item to display on this page

                    else
                    $start = 0;          //if no page var is given, set start to 0
                    /* Get data. */
  
                    $result = $db->prepare("SELECT * FROM agency  ORDER BY id DESC LIMIT $start, $limit");
                    $result->execute();
                                
                                /* Setup page vars for display. */
                    if ($page == 0) $page = 1;          //if no page var is given, default to 1.
                    $prev = $page - 1;              //previous page is page - 1
                    $next = $page + 1;              //next page is page + 1
                    $lastpage = ceil($total_pages/$limit);    //lastpage is = total pages / items per page, rounded up.
                    $lpm1 = $lastpage - 1;            //last page minus 1
                ?>
                    
                            
         <?php  
        for($i=1; $row = $result->fetch(); $i++){
                                    
                  
               ?> <br><br>
                    <div class="col-md-4 col-sm-4  col-lg-3">
                        <div class="agency">
                            <div class="doctor-img">
                                <a class="avatar" href="#"><img alt="" src="../../uploads/<?php echo $row['photo'];?>"></a>
                            </div>
                            <div class="dropdown profile-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                 <div class="dropdown-menu dropdown-menu-right">
                                    
                                    <a class="dropdown-item" href="deleteagency.php?id=<?=$row['id'] ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>                                                                                                                                                                                                                                           
                            <h4 class="doctor-name text-ellipsis"><a href="agency_profile.php?id=<?php echo $row['id'];?>"><?php echo $row['agency_name'];?></a></h4>
                            <div class="doc-prof"><?php echo $row['email'];?>, <?php echo $row['phone_number']; ?></div>
                            <div class="user-country">
                                <i class="fa fa-map-marker"></i> <?php echo $row['address']; ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
				<div class="row">
                    <div class="col-sm-12">
                        <div class="see-all">
                            <span class="see-all-btn">Showing
                                 <?php if($lastpage == $next-1):?>
                                    <?=$total_pages?>
                                <?php else:?>
                                <?=$page * $limit?> 
                            <?php endif;?>
                                of <?=$total_pages?>
                                        </span>
                            
                            <div class="btn-group">
                                <?php if($page != 1):?>
                                <a class="btn btn-default" href="?page=<?=$prev?>"><i class="fa fa-angle-left"></i></a>
                                <?php endif;?>
                                
                                <?php if($lastpage == $next-1):?>
                                
                                <?php else:?>
                                <a class="btn btn-default" href="?page=<?=$next?>"><i class="fa fa-angle-right"></i></a>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'includes/message.php'; ?>
        </div>
		<div id="delete_doctor" class="modal fade delete-modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body text-center">
						<img src="assets/img/sent.png" alt="" width="50" height="46">
						<h3>Are you sure want to delete this Doctor?</h3>
						<div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                            <a href="deleteagency.php?id=<?=$row['id'] ?>" class="btn btn-danger" >Delete</a>
						</div>
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

<style>
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


</body>
</html>
