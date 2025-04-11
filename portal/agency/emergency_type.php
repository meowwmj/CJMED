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
                        <h4 class="page-title">Add Department</h4>
                    </div>
                </div>
                <?php
                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                    $id = $_GET['id'];

                    $result = $db->prepare("SELECT * FROM emergency_type WHERE id = :post_id");
                    $result->bindParam(':post_id', $id);
                    $result->execute();

                    if ($row = $result->fetch()) {
                ?>
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <form method="POST" action="update_emergency_type.php">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="form-group">
                                    <label>Department Name</label>
                                    <input class="form-control" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" type="text" required>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" cols="30" rows="4" class="form-control"><?php echo htmlspecialchars($row['description']); ?></textarea>
                                </div>

                                <div class="m-t-20 text-center">
                                    <button class="btn btn-primary submit-btn">Update Department</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                    } else {
                        echo "<div class='alert alert-warning'>No department found with that ID.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Invalid access. No ID provided.</div>";
                }
                ?>

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
    <script src="assets/js/app.js"></script>

</body>
</html>
