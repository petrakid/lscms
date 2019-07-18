<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['edit_popup'])) {
     $ppp = $db->query("SELECT * FROM tbl_infopopup WHERE pp_id = $_POST[pp_id] AND popup_status != 9");
     $pp = $ppp->fetch(PDO::FETCH_ASSOC);
     ?>
     <form>
     <input type="hidden" id="epp_id" value="<?php echo $pp['pp_id'] ?>" />
     <b>Popup Title</b><br />
     <input type="text" id="epopup_name" value="<?php echo $pp['popup_name'] ?>" class="form-control" /><br />
     
     <b>Popup Status</b><br />
     <input type="radio" name="epopup_status" id="epopup_status" value="1" <?php if($pp['popup_status'] == 1) { echo 'checked="checked"'; } ?> /> Active<br />
     <input type="radio" name="epopup_status" id="epopup_status" value="0" <?php if($pp['popup_status'] == 0) { echo 'checked="checked"'; } ?> /> Disabled<br />
     <input type="radio" name="epopup_status" id="epopup_status" value="9" /> Delete<br /><br />
     
     <b>Popup Frequency</b><br />
     <input type="radio" name="epopup_frequency" id="epopup_frequency" value="1" <?php if($pp['popup_frequency'] == 1) { echo 'checked="checked"'; } ?> /> 1 Time per Visit<br />     
     <input type="radio" name="epopup_frequency" id="epopup_frequency" value="2" <?php if($pp['popup_frequency'] == 2) { echo 'checked="checked"'; } ?> /> Every Visit<br /><br />
     
     <b>Popup Page</b><br />
     <select id="epopup_page">
     <?php
     $ppag = $db->query("SELECT p_id, menu_name FROM tbl_pages WHERE menu_status = 1 ORDER BY menu_order");
     while($ppg = $ppag->fetch(PDO::FETCH_ASSOC)) {
          if($pp['popup_page'] == $ppg['p_id']) {
               echo '<option value="'. $pp['popup_page'] .'">'. str_replace("_", " ", $ppg['menu_name']) .'</option>';
          } else {
                echo '<option value="'. $ppg['p_id'] .'">'. str_replace("_", " ", $ppg['menu_name']) .'</option>';              
          }
     }
     ?>
     <option value="0">Every Page</option>
     </select><br /><br />
     
     <b>Popup Content</b><br />
     <textarea id="epopup_text"><?php echo $pp['popup_text'] ?></textarea>
     
     </form>
     <?php
}

if(isset($_POST['update_popup'])) {
     if($_POST['pp_status'] == 9) {
          $db->exec("UPDATE tbl_infopopup SET popup_status = 9 WHERE pp_id = $_POST[pp_id]");
          echo 'Popup Deleted';
     } else {
          if($_POST['pp_frequency'] == 2) {
               $_SESSION['popupfrequency'] = 0;
          }
          $db->exec("UPDATE tbl_infopopup SET popup_name = '$_POST[pp_name]', popup_status = '$_POST[pp_status]', popup_frequency = '$_POST[pp_frequency]', popup_page = '$_POST[pp_page]', popup_text = '$_POST[pp_text]' WHERE pp_id = $_POST[pp_id]");
          echo 'Popup Updated';
     }
}

if(isset($_POST['new_popup'])) {
     $db->exec("INSERT INTO tbl_infopopup (popup_name, popup_text) VALUES ('New Popup', 'New Popup')");
     echo 'Popup Created';
}