<?php
session_start();

if(!isset($_SESSION['isLoggedIn'])) {
     die;
}

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['update_seo'])) {
     $db->exec("UPDATE tbl_seo SET `$_POST[field]` = '$_POST[value]' WHERE seo = 1");
     echo 'Updated Successfully';
}
if(isset($_POST['update_tag'])) {
     if($_POST['value'] == '') {
          $db->exec("DELETE FROM tbl_meta_tags WHERE m_id = $_POST[m_id]");
          echo 'Tag Deleted';
     } else {
          $db->exec("UPDATE tbl_meta_tags SET meta_tag = '$_POST[value]' WHERE m_id = $_POST[m_id]");
          echo 'Tag Updated';
     }
}
if(isset($_POST['update_sharing'])) {
     $db->exec("UPDATE tbl_sharing SET `$_POST[field]` = '$_POST[value]' WHERE sh = 1");
     echo 'Sharing Setting Updated.';
}