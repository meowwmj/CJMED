<div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="active">
                            <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        <li>
                            <a href="announcement.php"><i class="fa fa-bell"></i> <span>Announcements</span></a>
                        </li>
                        <li class="">
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
