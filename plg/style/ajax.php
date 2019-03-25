<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die('You do not have permission!');
}

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['change_skin'])) {
     $db->exec("UPDATE tbl_layout SET layout_skin = '$_POST[new_skin]' WHERE l_id = 1");
}
if(isset($_POST['set_default'])) {
     $_POST['class'] = $_POST['class'] .'_color';
     $db->exec("UPDATE tbl_layout SET `$_POST[class]` = '' WHERE l_id = 1");
}
if(isset($_POST['set_transparent'])) {
     $_POST['class'] = $_POST['class'] .'_color';
     $db->exec("UPDATE tbl_layout SET `$_POST[class]` = 'transparent' WHERE l_id = 1");     
}
if(isset($_POST['change_color'])) {
     $_POST['class'] = $_POST['class'] .'_color';
     $db->exec("UPDATE tbl_layout SET `$_POST[class]` = '$_POST[color]' WHERE l_id = 1");
}
if(isset($_POST['add_graphic'])) {
     $root = $gbl['doc_root'] .'ast/layout/';
     if($_FILES['background_image']['error'] == 0) {
          $ext = pathinfo(strtolower($_FILES['background_image']['name']), PATHINFO_EXTENSION);
          $allowed = array('jpg', 'jpeg', 'png', 'gif');
          if(!in_array($ext, $allowed)) {
               echo '<div class="alert alert-danger">This is NOT a valid image file type.  Only jpg (jpeg), png, and gif images accepted!</div>';
               die;
          }
          $filename = date('Ymdhis') . rand(1,5) .'.'. $ext;
          if(move_uploaded_file($_FILES['background_image']['tmp_name'], $root . $filename)) {
               $i = 1;
               foreach(glob($gbl['doc_root'] .'ast/layout/*') AS $graphic) {
                    ?>
                    <img id="drag_graphic_<?php echo $i ?>" style="cursor: move;" data-id="<?php echo basename($graphic) ?>" draggable="draggable" src="<?php echo $gbl['site_url'] .'/ast/layout/'. basename($graphic) ?>" class="img-thumbnail float-left" width="80" />
                    
                    <?php
               }               
          }
     }
}
if(isset($_POST['update_graphic'])) {
     $_POST['graphic_location'] = $_POST['graphic_location'] .'_image';
     $db->exec("UPDATE tbl_layout SET `$_POST[graphic_location]` = '$_POST[graphic_file]', `$_POST[graphic_location]_repeat` = 'no-repeat' WHERE l_id = 1");
     echo $gbl['site_url'] .'/ast/layout/'. $_POST['graphic_file'];
}
if(isset($_POST['change_repeat'])) {
     if($_POST['val'] == '0') {
          $_POST['location'] = $_POST['location'] .'_image';
          $sql = "UPDATE tbl_layout SET `$_POST[location]` = NULL, `$_POST[location]_repeat` = NULL WHERE l_id = 1";
          $db->exec($sql);
     } else {
          $_POST['location'] = $_POST['location'] .'_image_repeat';
          $sql2 = "UPDATE tbl_layout SET `$_POST[location]` = '$_POST[val]' WHERE l_id = 1";
          $db->exec($sql2);
     }
}
if(isset($_POST['change_mshadow'])) {
     $db->exec("UPDATE tbl_layout SET menu_shadow = $_POST[checked] WHERE l_id = 1");
}
if(isset($_POST['delete_image'])) {
     unlink($gbl['doc_root'] .'ast/layout/'. $_POST['filename']);
}
if(isset($_POST['update_font'])) {
     if($_POST['psd'] == 'title_font') {
          $_POST['psd'] = 'title_font_size';
     } else {
          $_POST['psd'] = $_POST['psd'] .'_font';
          $_POST['family'] = $db->quote($_POST['family']);          
     }
     $sql = "UPDATE tbl_layout SET `$_POST[psd]` = ". $_POST['family'] ." WHERE l_id = 1";
     $db->exec($sql);
}
if(isset($_POST['change_layout'])) {
     $db->exec("UPDATE tbl_layout SET `$_POST[field]` = '$_POST[value]' WHERE l_id = 1");
}
if(isset($_POST['change_fixed'])) {
     $db->exec("UPDATE tbl_layout SET background_fixed = $_POST[checked] WHERE l_id = 1");
}
?>