<?php include 'includes/head.php'; ?>
<body>
    <div class="main-wrapper">
        <?php include 'includes/navigation.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

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
