<<div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li>
                            <a href="report-emergency.php"><i class="fa fa-heartbeat"></i> <span>Report Emergency</span></a>
                        </li> 
                        <li>
                        <?php
                        $result = $db->prepare("SELECT count(*) as total FROM emergency WHERE status = 'Pending' ORDER BY id DESC ");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){ ?>
                    <li><a href="view-emergency.php"><i class="fa fa-file"></i> <span>Emergency</span> <span class="badge badge-pill btn-primary float-right"><?php echo $row['total'] ;?></span></a></li>
                    <?php } ?>
                        </li>
                        <li>
                            <a href="announcement.php"><i class="fa fa-bell"></i> <span>Announcements</span></a>
                        </li>           
                        <li>
                            <a href="report_history.php"><i class="fa fa-file-text-o"></i> <span>History</span></a>
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
    $result = $db->prepare("SELECT * FROM users where id= :post_id");
    $result->bindParam(':post_id', $id);
    $result->execute();
    for($i=0; $row = $result->fetch(); $i++){                        
?>
<form action="update_status.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Admin ID</label>
                                        <input class="form-control" type="text"  value="<?php echo $row['SESS_AGENCY_ID']; ?>" readonly="">
                                    </div>
                                </div>
                                

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Agency Name</label>
                                       <input class="form-control" type="text"  value="<?php echo $row['agency_name']; ?>" readonly="">
                                        
                                    </div>

                                </div>
                            
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label>Case Severity</label>
                                        <input class="form-control" type="text"  value="<?php echo $row['case_severity']; ?>" readonly="">
                                    </div>
                                
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Emergency Category </label>
                                       <input class="form-control" type="text"  value="<?php echo $row['emergency_category']; ?>" readonly="">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input class="form-control" type="text"  value="<?php echo $row['state']; ?>" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Victim Phone Number</label>
                                       <input class="form-control" type="text"  value="<?php echo $row['phone_number']; ?>" readonly="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Victim Name</label>
                                       <input  class="form-control" type="text"  value="<?php echo $row['name']; ?>" readonly="">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Address</label>
                                    <p readonly><?php echo $row['address']; ?></p>
                                
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="select" name="status">
                                            <option value="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></option>
                                            <option value="Processing">Processing</option>
                                            <option value="Delieverd">Delieverd</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                       <input class="form-control" type="text"  value="<?php echo $row['email']; ?>" readonly="">
                                    </div>
                                </div>
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
