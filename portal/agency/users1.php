<?php include 'includes/head.php'; ?>

<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <?php include 'includes/sidebar.php'; ?>
         
        <div class="page-wrapper">
            <div class="content">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-4 col-3">
                                <h4 class="page-title">All Users</h4>
                            </div> 
                            <div class="col-sm-8 col-9 text-right m-b-20">
                                <h4 class="card-title d-inline-block"></h4> <a href="#" class="btn btn-primary">Import</a>
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
                                    <th class="text-center">Phone Number</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $loggedInAdminId = $_SESSION['SESS_MEMBER_ID']; // Get the ID of the currently logged-in admin

                                    $result = $db->prepare("SELECT * FROM users WHERE id <> :loggedInAdminId");
                                    $result->bindParam(':loggedInAdminId', $loggedInAdminId);
                                    $result->execute();

                                    $i = 1;
                                    while ($row = $result->fetch()) {
                                    ?>
                                        <tr>
                                        <td class="text-center"><?php echo $i; ?></td>
                                            <td class="text-center"><img src="../../uploads/<?php echo $row['photo']; ?>" class="rounded-circle m-r-5" width="28" height="28"></td>
                                            <td class="text-center"><?php echo $row['name']; ?></td>
                                            <td class="text-center"><?php echo $row['phone']; ?></td>
                                            <td class="text-center"><?php echo $row['email']; ?></td>
                                            <td class="text-center"><span id="emergency-address"><?php echo $row['address']; ?></span></td>
                                        <td class="text-center">
                                                <a class="btn btn-primary" href="delete_users1.php?id=<?php echo $row['id']; ?>"><i class="fa fa-trash-o"></i></a>
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

