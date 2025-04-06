Norman Paraiso
<?php

$db_host     = "srv1637.hstgr.io";
$db_user     = "u665838367_cjmedDB";
$db_pass     = "DBcjmed_2025!";
$db_database = "u665838367_cjmed";

include "idiorm.php";

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error()); // if connection fails, stop the script
}

/* ORM config */
ORM::configure("mysql:host=".$db_host.";dbname=".$db_database);
ORM::configure("username", $db_user);
ORM::configure("password", $db_pass);

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_database", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

/* Optional class */
class App {
    public static function message($type, $message, $code = '') {
        $alertClass = $type === 'error' ? 'alert-danger' : 'alert-success';
        return '<div class="alert '.$alertClass.' alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    '.$message.' <a class="alert-link" href="#">'.$code.'</a>.
                </div>';
    }
}

function get($val) {
    return @$_GET[$val];
}
