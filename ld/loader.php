<?php
session_start();
include 'ld/db.inc.php';
if(!empty($_COOKIE['remlog']) && $_COOKIE['remlog'] == TRUE) {
     $usr = $db->query("SELECT * FROM tbl_users WHERE cookie_hash = '$_COOKIE[remlog]' AND account_status = 1");
     if($usr->rowCount() == 1) {
          $row = $usr->fetch(PDO::FETCH_ASSOC);
          $_SESSION['isLoggedIn'] = 1;
          $_SESSION['user'] = $row;
          $_SESSION['upload_year'] = date("Y");
     }
}
include 'ld/globals.inc.php';
include 'ld/addins.inc.php';
if($gbl['maintenance_mode'] == 1 && !isset($_SESSION['isLoggedIn'])) {
     header('location:maintenance.php');
     die;
}
include 'ld/cron_script.php';
$year = date("Y");
if(!file_exists($gbl['doc_root'] ."ast/res/$year")) {
     mkdir($gbl['doc_root'] ."ast/res/$year");
}
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
$editable = $pg['editable'];
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