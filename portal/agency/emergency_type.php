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
                        <h4 class="page-title">Add Emergency Category</h4>
                    </div>
                </div>
                     
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form method="post" action="save_type.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" name="name" type="text">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea cols="30" rows="4" name="description" class="form-control"></textarea>
                            </div>
                            
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-sm-5 col-5">
                        <h4 class="page-title">All Emergency Categories</h4>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $result = $db->prepare("SELECT * FROM emergency_type ");
                                        $result->execute();
                                        for($i=1; $row = $result->fetch(); $i++){ 
                                    
                                    ?> 
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $row['name']; ?></td>
										<td><?php echo $row['description']; ?></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit_emergency_type.php?id=<?php echo $row['id'];?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="delete_type.php?id=<?=$row['id'] ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'includes/message.php'; ?>
        </div>
		<div id="delete_department" class="modal fade delete-modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body text-center">
						<img src="assets/img/sent.png" alt="" width="50" height="46">
						<h3>Are you sure want to delete this Emergency type?</h3>
						<div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                            <a href="delete_type.php?id=<?=$row['id'] ?>" class="btn btn-danger">Delete</a>
							
						</div>
					</div>
				</div>
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
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/app.js"></script>

</body>
</html>
