<?php include 'includes/head.php'; ?>
<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">

                    	<?php
                            // include('../connect.php');
                            $result = $db->prepare("SELECT count(*) as total FROM emergency");
                            $result->execute();
                            for($i=0; $row = $result->fetch(); $i++){
		                ?>
                         <a href="view-emergency.php"><div class="dash-widget">
							<span class="dash-widget-bg1"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
							<div class="dash-widget-info text-right">
								<h3><?php echo $row['total']; ?></h3>
								<span class="widget-title1">Emergency <i class="fa fa-check" aria-hidden="true"></i></span>
							</div>
                        </div>
                        <?php } ?>
                        </div>
                

                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    	<?php
		                // include('../connect.php');
						$result = $db->prepare("SELECT count(*) as total FROM agency");
						$result->execute();
						for($i=0; $row = $result->fetch(); $i++){
		                ?>
                        <a href="#"><div class="dash-widget">
                            <span class="dash-widget-bg3"><i class="fa fa-user-md" aria-hidden="true"></i></span>
                            <div class="dash-widget-info text-right">
                                <h3><?php echo $row['total'] ;?></h3>
                                <span class="widget-title3">Agency <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                 
                    <div class="col-md-12 col-sm-12 col-lg-12 col-xl-3">	
                    	<?php
		                // include('../connect.php');
						$result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending'");
						$result->execute();
						for($i=0; $row = $result->fetch(); $i++){
		                ?>
                        <a href="view-emergency.php"><div class="dash-widget">
                            <span class="dash-widget-bg4"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                            <div class="dash-widget-info text-right">
                                <h3><?php echo $row['total'] ;?></h3>
                                <span class="widget-title4">Ongoing <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
				
			               ?> 
											<tr>
													<td style="min-width: 200px;">
                                                    <span class="status online"></span></a>
														<h2><a href="#"><?php echo $row['agency_name']; ?> <span><?php echo $row['state']; ?></span></a></h2>
													</td>                 
													<td>
														<h5 class="time-title p-0"><?php echo $row['email']; ?></h5>
														<p><?php echo $row['phone_number']; ?></p>
													</td>
													<td>
														<h5 class="time-title p-0"><?php echo $row['personincharge']; ?></h5>
														<!-- <p>7.00 PM</p> -->
													</td>
													
												</tr>
											<?php } ?>	
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
                    
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card member-panel">
							<div class="card-header bg-white">
								<h4 class="card-title mb-0">USERS</h4>
							</div>
                            <div class="card-body">
			                 	<?php
			                $result = $db->prepare("SELECT * FROM users ");
			                $result->execute();
			                for($i=1; $row = $result->fetch(); $i++){ 
			               
			               ?> 
                                <ul class="contact-list">
                                    <li>
                                        <div class="contact-cont">
                                            <div class="float-left user-img m-r-10">
                                                <a href="#" title="John Doe"><img src="../../uploads/<?php echo $row['photo']; ?>" alt="" class="w-40 rounded-circle"></span></a>
                                            </div>
                                            <div class="contact-info">
                                                <span class="contact-name text-ellipsis"><?php echo $row['username']; ?></span>
                                                <span class="contact-date"><?php echo $row['phone']; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    
                                </ul>
                            <?php } ?>
                            </div>
							
                            <!--<div class="card-footer text-center bg-white">
                                <a href="add_user" class="text-muted">Add Users</a> -->
                            </div>
                        </div>
                    </div>
				</div>
            </div>
            <?php include 'includes/Message.php'; ?>
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
    <script src="assets/js/Chart.bundle.js"></script>
    <script src="assets/js/chart.js"></script>
    <script src="assets/js/app.js"></script>

</body>
</html>

<style>
    .table-responsive {
        max-height: 270px; /* Adjust this height as needed */
        overflow-y: auto;
    }
</style>

