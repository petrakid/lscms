<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die('You do not have permission!');
}

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['change_settings'])) {
     $val = $db->quote($_POST['v']);
     $db->exec("UPDATE tbl_globals SET `$_POST[f]` = $val WHERE id = 1");
}
if(isset($_POST['change_plugins'])) {
     $db->exec("UPDATE tbl_plugins SET plugin_status = $_POST[v] WHERE pl_id = $_POST[p]");
}