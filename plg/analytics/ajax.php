<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['add_site'])) {
     $db->exec("UPDATE tbl_globals SET analytics_id = $_POST[site_id] WHERE id = 1");
     echo '<div class="alert alert-success">Site Added and Analytics now setup.  Page will now refresh...</div>';
}