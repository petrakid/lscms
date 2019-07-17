<?php
session_start();

if(is_file('inst/install.php')) {
     include 'inst/install.php';
     die;
} else {
     include 'ld/db.inc.php';
}

if(!empty($_COOKIE['remlog'])) {
     $usr = $db->query("SELECT * FROM tbl_users WHERE cookie_hash = '$_COOKIE[remlog]' AND account_status = 1");
     if($usr->rowCount() < 1) {
          //echo 'User not found or disabled, or you cleared your browser\'s cache and cleared cookies.';
     } else {
          $row = $usr->fetch(PDO::FETCH_ASSOC);               
          $_SESSION['isLoggedIn'] = 1;
          $_SESSION['user'] = $row;
          $_SESSION['upload_year'] = date("Y");
     }
}

include 'ld/globals.inc.php';
include 'ld/addins.inc.php';

// before we go any further, we want to check and see if maintenance mode is enabled, and if so, load the maintenance page
if($gbl['maintenance_mode'] == 1 && !isset($_SESSION['isLoggedIn'])) {
     header('location:maintenance.php');
     die;
}

// load the cron system
include 'ld/cron_script.php';

// check to see if resources directory exists, and if not, create it
$year = date("Y");
if(!file_exists($gbl['doc_root'] ."ast/res/$year")) {
     mkdir($gbl['doc_root'] ."ast/res/$year");
}

// Load the page data into an array
if(!isset($_GET['page']) || $_GET['page'] == '') {
     $_GET['page'] = $gbl['homepage'];
}

if(strpos($_GET['page'], "/") !== false) {
     $_SESSION['fullpage'] = $_GET['page'];
     $var = explode("/", $_GET['page']);
     $_GET['page'] = $var[1];
     $_GET['page'] = str_replace("'", "", $_GET['page']);
} else {
     $_SESSION['fullpage'] = $_GET['page'];
}

$sql = $db->query("SELECT * FROM tbl_pages WHERE menu_link = '$_GET[page]'");
if($sql->rowCount() == 0) {
     $sql = $db->query("SELECT * FROM tbl_admin_pages WHERE menu_link = '$_GET[page]'");
     if($sql->rowCount() == 0) {
          header("location:". $gbl['site_url'] .'/'. $gbl['homepage']);
          die;
     }     
}
$pg = $sql->fetch(PDO::FETCH_ASSOC);
$_SESSION['page'] = $pg;

include 'lo/head.inc.php';
if(isset($_SESSION['isLoggedIn'])) {
     include 'lo/side_admin.inc.php';
}
include 'lo/top_menu.inc.php';
include 'lo/carousel.inc.php';
include 'lo/body.inc.php';
include 'lo/foot.inc.php';
include 'lo/end.inc.php';
?>