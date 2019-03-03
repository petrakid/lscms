<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die('You do not have permission!');
}

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['update_block'])) {
     if($_POST['block_status'] == 9) {
          $db->exec("UPDATE tbl_blocks SET block_status = 9 WHERE b_id = $_POST[block_id]");
          echo 'Block Deleted';
          die;
     }
     $width = $db->query("SELECT grid_order FROM tbl_blocks WHERE b_id = $_POST[block_id]");
     $w = $width->fetch(PDO::FETCH_ASSOC);
     $_POST['grid_order'] = $w['grid_order'];     
     $db->exec("UPDATE tbl_blocks SET block_status = 0 WHERE b_id = $_POST[block_id]");
     unset($_POST['update_block']);
     unset($_POST['block_id']);
     $_POST['date_added'] = date('Y-m-d h:i:s');
     $sql = "INSERT INTO tbl_blocks (";
     foreach($_POST AS $f => $v) {
          if($f == 'start_datetime') {
               if($v == null || $v == '') {
                    continue;
               }
          }
          if($f == 'end_datetime') {
               if($v == null || $v == '') {
                    continue;
               }
          }
          $sql .= "`$f`, ";
     }
     $sql = rtrim($sql, ", ");
     $sql .= ") VALUES (";
     foreach($_POST AS $f => $v) {
          if($f == 'start_datetime') {
               if($v == null || $v == '') {
                    continue;
               } else {
                    $v = $db->quote($v); 
               }
          }
          if($f == 'end_datetime') {
               if($v == null || $v == '') {
                    continue;
               } else {
                    $v = $db->quote($v);
               }
          }
          switch($f) {
               case 'block_content':
                    $v = $db->quote($v);
                    break;
               case 'block_header':
                    $v = $db->quote($v);
                    break;
               case 'block_plugin':
                    $v = $db->quote($v);
                    break;
               case 'date_added':
                    $v = $db->quote($v);
                    break;
               case 'block_color':
                    $v = $db->quote($v);
                    break;
               default:
                    break;
          }
     $sql .= "$v, ";          
     }
     $sql = rtrim($sql, ", ");
     $sql .= ")";
     $db->exec($sql);
}

if(isset($_POST['view_historic'])) {
     $hist = $db->query("SELECT b_id, block_content FROM tbl_blocks WHERE b_id = $_POST[b_id]");
     $hs = $hist->fetch(PDO::FETCH_ASSOC);
     echo stripslashes($hs['block_content']) .'<br /><br /><button type="button" class="btn btn-primary btn-sm" onclick="enableHistoric('. $hs['b_id'] .')">Restore</button>';
}

if(isset($_POST['restore_historic'])) {
     $page = $db->query("SELECT b_id, page_id, grid_order FROM tbl_blocks WHERE b_id = $_POST[hist_id]");
     $hp = $page->fetch(PDO::FETCH_ASSOC);
     $db->exec("UPDATE tbl_blocks SET block_status = 0 WHERE page_id = $hp[page_id] AND block_status != 9 AND grid_order = $hp[grid_order]");
     $db->exec("UPDATE tbl_blocks SET block_status = 1 WHERE b_id = $hp[b_id]");
}

if(isset($_POST['new_block'])) {
     $db->exec("INSERT INTO tbl_blocks (`page_id`, `grid_width`, `grid_order`, `block_status`, `start_datetime`, `end_datetime`, `date_added`) VALUES ('$_POST[page_id]', '0', '0', '1', '0000-00-00', '0000-00-00', now())");
     echo 'Block Added Successfully';
}

if(isset($_POST['savechanges'])) {
     if($_FILES['page_image']['error'] != 4) {
          $filename = '';
          $imagearray = array("jpeg", "jpg", "png", "gif");
          $ext = pathinfo($_FILES['page_image']['name'], PATHINFO_EXTENSION);
          if(!in_array(strtolower($ext), $imagearray)) {
              echo 'The Page Image you added is not a valid image and will be skipped';
          } else {
               $filename = date('Ymdhis') . rand(0,5).'.'. $ext;
               move_uploaded_file($_FILES['page_image']['tmp_name'], $gbl['doc_root'] .'ast/res/'. $filename); 
          }
          $_POST['page_image'] = $filename;
     } else {
          unset($_POST['page_image']);
     }
     if($_FILES['jumbotron_image']['error'] != 4) {
          $jfilename = '';
          $imagearray = array("jpeg", "jpg", "png", "gif");
          $ext = pathinfo($_FILES['jumbotron_image']['name'], PATHINFO_EXTENSION);
          if(!in_array(strtolower($ext), $imagearray)) {
              echo 'The Page Image you added is not a valid image and will be skipped';
          } else {
               $jfilename = date('Ymdhis') . rand(0,5).'.'. $ext;
               move_uploaded_file($_FILES['jumbotron_image']['tmp_name'], $gbl['doc_root'] .'ast/landings/'. $jfilename); 
          }
          $_POST['jumbotron_image'] = $jfilename;
     } else {
          unset($_POST['jumbotron_image']);
     }     
     
     
     unset($_FILES);
     $page = $_POST['p_id'];
     unset($_POST['p_id']);
     unset($_POST['savechanges']);
     $_POST['menu_name'] = addslashes($_POST['menu_name']);
     $_POST['page_title'] = addslashes($_POST['page_title']);
     $_POST['description'] = addslashes($_POST['description']);
     $_POST['keywords'] = addslashes($_POST['keywords']);
     if($_POST['menu_url'] > '') {
          $_POST['menu_target'] = '_blank';
     }
     $pcount = count($_POST);
     $s1 = 0;
     $sql = "UPDATE tbl_pages SET ";
     foreach($_POST AS $field => $val) {
          $s1++;
          if($s1 < $pcount) {
               $sql .= "`". $field ."` = '". $val ."', ";
          } else {
               $sql .= "`". $field ."` = '". $val ."' WHERE p_id = $page";
          }
     }
     $result = $db->exec($sql);
     if(isset($_POST['page_image'])) {
          echo $_POST['page_image'];
     }
}

if(isset($_POST['ledit_block'])) {
     $lbedit = $db->query("SELECT b_id, block_content FROM tbl_blocks WHERE b_id = $_POST[b_id]");
     $lbe = $lbedit->fetch(PDO::FETCH_ASSOC);
     ?>
     <input type="hidden" id="lb_id" value="<?php echo $lbe['b_id'] ?>" />
     <textarea name="bcontent" id="bcontent"><?php echo $lbe['block_content'] ?></textarea>
     <?php
}

if(isset($_POST['update_lblock'])) {
     $bcontent = addslashes($_POST['block_content']);
     $db->exec("UPDATE tbl_blocks SET block_content = '$bcontent' WHERE b_id = $_POST[b_id]");
     echo 'Updated. Refreshing...';
}

if(isset($_POST['editabledata'])) {
     $exp = explode("_", $_POST['editorID']);
     $bid = $exp[1];
     $db->exec("UPDATE tbl_blocks SET block_content = '$_POST[editabledata]' WHERE b_id = $bid");
}

if(isset($_POST['item'])) {
     $i = 1;
     foreach($_POST['item'] as $value) {
          $db->exec("UPDATE tbl_blocks SET grid_order = $i WHERE b_id = $value");
          $i++;
     }
}
?>