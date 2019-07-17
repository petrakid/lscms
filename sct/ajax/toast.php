<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die('You do not have permission!');
}

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['edit_notif'])) {
     $mst = $db->query("SELECT * FROM tbl_toast_messages WHERE m_id = $_POST[m_id]");
     $m = $mst->fetch(PDO::FETCH_ASSOC);
     $tst = $db->query("SELECT * FROM tbl_toast_options WHERE t_id = 1");
     $t = $tst->fetch(PDO::FETCH_ASSOC);
     ?>
     <form id="editnotifform">
     <input type="hidden" name="m_id" value="<?php echo $_POST['m_id'] ?>" />
     <div class="card">
     <div class="card-header">
     <h2 class="text-uppercase font-weight-bold text-center py-4 mb-0">Notification Manager<br />
     <small class="form-text">Edit Notification</small></h2>
     <small>Some options are global.</small>
     </div>
     
     <div class="card-body mt-3 pb-0">
     <div class="row">
     <div class="col-md-12 col-lg-5 mb-lg-auto mb-5">
     
     <select name="m_pageid" id="m_pageid" class="mdb-select2 md-form">
     <option value="<?php echo $m['m_pageid'] ?>" disabled selected>Current Value</option>
     <option value="0">All Pages</option>
     <?php
     $mpage = $db->query("SELECT p_id, menu_name FROM tbl_pages WHERE menu_status = 1 AND p_id != $m[m_pageid] ORDER BY menu_name ASC");
     while($mp = $mpage->fetch(PDO::FETCH_ASSOC)) {
          echo '<option value="'. $mp['p_id'] .'">'. $mp['menu_name'] .'</option>'."\n";
     }
     ?>
     </select>
     <label>Page to Display the Notification</label>
     
     <div class="md-form">
     <input class="form-control" id="m_title" name="m_title" type="text" value="<?php echo $m['m_title'] ?>" />
     <label class="control-label" for="m_title">Title</label>
     </div>
     
     <div class="md-form">
     <textarea class="md-textarea form-control" rows="3" id="m_message" name="m_message"><?php echo $m['m_message'] ?></textarea>
     <label class="control-label" for="m_message">Message</label>
     </div>
     
     <div class="form-group">
     <input type="checkbox" class="form-check-input filled-in" id="toast_close_button" name="toast_close_button" <?php if($t['toast_close_button'] == 'true') { echo 'checked="checked"'; } ?> />
     <label for="toast_close_button">Close button</label>
     </div>
     
     <div class="form-group">
     <input type="checkbox" class="form-check-input filled-in" id="toast_onclick" name="toast_onclick" <?php if($t['toast_onclick'] == 'true') { echo 'checked="checked"'; } ?>  />
     <label class="form-check-label" for="toast_onclick">Add behavior on toast click</label>
     </div>
     
     <div class="form-group">
     <input type="checkbox" class="form-check-input filled-in" id="toast_debug" name="toast_debug" <?php if($t['toast_debug'] == 'true') { echo 'checked="checked"'; } ?>  />
     <label class="form-check-label" for="toast_debug">Debug</label>
     </div>
     
     <div class="form-group">
     <input type="checkbox" class="form-check-input filled-in" id="toast_prog_bar" name="toast_prog_bar" <?php if($t['toast_prog_bar'] == 'true') { echo 'checked="checked"'; } ?>  />
     <label class="form-check-label" for="toast_prog_bar">Progress Bar</label>
     </div>
      
     <div class="form-group">
     <input type="checkbox" class="form-check-input filled-in" id="toast_prev_dups" name="toast_prev_dups" <?php if($t['toast_prev_dups'] == 'true') { echo 'checked="checked"'; } ?>  />
     <label class="form-check-label" for="toast_prev_dups">Prevent Duplicates</label>
     </div>
     
     <div class="form-group">
     <input type="checkbox" class="form-check-input filled-in" id="toast_new_top" name="toast_new_top" <?php if($t['toast_new_top'] == 'true') { echo 'checked="checked"'; } ?>  />
     <label class="form-check-label" for="toast_new_top">Newest on top</label>
     </div>
     </div>
     
     <div class="col-md-4 col-lg-3 mb-md-auto mb-5">   
     <div class="mb-4" id="toastTypeGroup">
      
     <h5 class="mb-4">Notification Background Color</h5>     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="m_colorg" name="m_color" <?php if($m['m_color'] == 'success') { echo 'checked="checked"';} ?> value="success" />
     <label class="form-check-label" for="m_colorg">Green</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="m_colorb" name="m_color" <?php if($m['m_color'] == 'info') { echo 'checked="checked"';} ?> value="info" />
     <label class="form-check-label" for="m_colorb">Blue</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="m_colory" name="m_color" <?php if($m['m_color'] == 'warning') { echo 'checked="checked"';} ?> value="warning" />
     <label class="form-check-label" for="m_colory">Yellow</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="m_colorr" name="m_color" <?php if($m['m_color'] == 'error') { echo 'checked="checked"';} ?> value="error" />
     <label class="form-check-label" for="m_colorr">Red</label>
     </div>
     </div>
     
     <div class="mb-3" id="positionGroup">
     <h5 class="mb-4">Position</h5>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio8" name="m_location" value="md-toast-top-right" <?php if($m['m_location'] == 'toast-top-right') { echo 'checked';} ?> />
     <label class="form-check-label" for="radio8">Top Right</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio9" name="m_location" value="md-toast-bottom-right" <?php if($m['m_location'] == 'toast-bottom-right') { echo 'checked';} ?> />
     <label class="form-check-label" for="radio9">Bottom Right</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio10" name="m_location" value="md-toast-bottom-left" <?php if($m['m_location'] == 'toast-bottom-left') { echo 'checked';} ?> />
     <label class="form-check-label" for="radio10">Bottom Left</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio11" name="m_location" value="md-toast-top-left" <?php if($m['m_location'] == 'toast-top-left') { echo 'checked';} ?> />
     <label class="form-check-label" for="radio11">Top Left</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio12" name="m_location" value="md-toast-top-full-width" <?php if($m['m_location'] == 'toast-top-full-width') { echo 'checked';} ?> />
     <label class="form-check-label" for="radio12">Top Full Width</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio13" name="m_location" value="md-toast-bottom-full-width" <?php if($m['m_location'] == 'toast-bottom-full-width') { echo 'checked';} ?> />
     <label class="form-check-label" for="radio13">Bottom Full Width</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio14" name="m_location" value="md-toast-top-center" <?php if($m['m_location'] == 'toast-top-center') { echo 'checked';} ?> />
     <label class="form-check-label" for="radio14">Top Center</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio15" name="m_location" value="md-toast-bottom-center" <?php if($m['m_location'] == 'toast-bottom-right') { echo 'checked';} ?> />
     <label class="form-check-label" for="radio15">Bottom Center</label>
     </div>
     </div>
     
     <div class="mb-3" id="statusGroup">
     
     <h5 class="mb-4">Status</h5>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio16" name="m_status" value="1" <?php if($m['m_status'] == '1') { echo 'checked';} ?> />
     <label class="form-check-label" for="radio16">Enabled</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio17" name="m_status" value="0" <?php if($m['m_status'] == '0') { echo 'checked';} ?> />
     <label class="form-check-label" for="radio17">Disabled</label>
     </div>     
     </div>  
     </div>

     <div class="col-md-4 col-lg-2 mb-md-auto mb-5">
     
     <div class="md-form">
     <input data-toggle="tooltip" title="Enter swing or linear" class="form-control" id="showEasing" name="toast_show_eas" type="text" value="<?php echo $t['toast_show_eas'] ?>" />
     <label for="showEasing">Show Easing</label>
     </div>
     
     <div class="md-form">
     <input data-toggle="tooltip" title="Enter swing or linear" class="form-control" id="hideEasing" name="toast_hide_eas" type="text" value="<?php echo $t['toast_hide_eas'] ?>" />
     <label for="hideEasing">Hide Easing</label>
     </div>
     
     <div class="md-form">
     <input data-toggle="tooltip" title="Enter show, fadeIn or slideDown" class="form-control" id="showMethod" name="toast_show_meth" type="text" value="<?php echo $t['toast_show_meth'] ?>" />
     <label for="showMethod">Show Method</label>
     </div>
     
     <div class="md-form">
     <input data-toggle="tooltip" title="Enter show, fadeOut or slideUp" class="form-control" id="hideMethod" name="toast_hide_meth" type="text" value="<?php echo $t['toast_hide_meth'] ?>" />
     <label for="hideMethod">Hide Method</label>   
     </div>
     </div>
     
     <div class="col-md-4 col-lg-2">
     
     <div class="md-form">
     <input data-toggle="tooltip" title="In Seconds" class="form-control" id="showDuration" name="toast_show_dur" type="number" value="<?php echo ($t['toast_show_dur'] / 1000) ?>" />
     <label for="showDuration">Show Duration</label>
     </div>
     
     <div class="md-form">
     <input data-toggle="tooltip" title="In Seconds" class="form-control" id="hideDuration" name="toast_hide_dur" type="number" value="<?php echo ($t['toast_hide_dur'] / 1000) ?>" />
     <label for="hideDuration">Hide Duration</label>
     </div>
     
     <div class="md-form">
     <input data-toggle="tooltip" title="In Seconds" class="form-control" id="timeOut" name="toast_timeout" type="number" value="<?php echo ($t['toast_timeout'] / 1000) ?>" />
     <label for="timeOut">Timeout</label>
     </div>
     
     <div class="md-form">
     <input data-toggle="tooltip" title="In Seconds" class="form-control" id="extendedTimeOut" name="toast_ext_timeout" type="number" value="<?php echo ($t['toast_ext_timeout'] / 1000) ?>" />
     <label for="extendedTimeOut">Extended timeout</label>
     </div>

     <div class="md-form">
     <input placeholder="Select date" type="text" name="m_start" id="m_start" value="<?php echo $m['m_start'] ?>" class="form-control datepicker" required />
     <label for="m_start">Start Date</label>
     </div> 

     <div class="md-form">
     <input placeholder="Select date" type="text" name="m_stop" id="m_stop" value="<?php echo $m['m_stop'] ?>" class="form-control datepicker" required />
     <label for="m_stop">Stop Date</label>
     </div>       
     </div>   
    
     </div>  
     </div> 
     <hr class="w-100" />
     <input type="submit" id="submitupdate" class="btn btn-unique" value="Update" />   
     </div>
     </form>
     <?php
}

if(isset($_POST['new_notif'])) {
     $tst = $db->query("SELECT * FROM tbl_toast_options WHERE t_id = 1");
     $t = $tst->fetch(PDO::FETCH_ASSOC);
     ?>
     <form id="notifform">
     <div class="card">
     <div class="card-header">
     <h2 class="text-uppercase font-weight-bold text-center py-4 mb-0">Notification Manager<br />
     <small class="form-text">New Notification</small></h2>
     <small>Some options are global.</small>
     </div>
     
     <div class="card-body mt-3 pb-0">
     <div class="row">
     <div class="col-md-12 col-lg-5 mb-lg-auto mb-5">
     
     <select name="m_pageid" id="m_pageid" class="mdb-select2 md-form">
     <option value="" disabled selected>Select a page</option>
     <option value="0">All Pages</option>
     <?php
     $mpage = $db->query("SELECT p_id, menu_name FROM tbl_pages WHERE menu_status = 1 ORDER BY menu_name ASC");
     while($mp = $mpage->fetch(PDO::FETCH_ASSOC)) {
          echo '<option value="'. $mp['p_id'] .'">'. $mp['menu_name'] .'</option>'."\n";
     }
     ?>
     </select>
     <label>Page to Display the Notification</label>
     
     <div class="md-form">
     <input class="form-control" id="m_title" name="m_title" type="text" />
     <label class="control-label" for="m_title">Title</label>
     </div>
     
     <div class="md-form">
     <textarea class="md-textarea form-control" rows="3" id="m_message" name="m_message"></textarea>
     <label class="control-label" for="m_message">Message</label>
     </div>
     
     <div class="form-group">
     <input type="checkbox" class="form-check-input filled-in" id="toast_close_button" name="toast_close_button" <?php if($t['toast_close_button'] == 'true') { echo 'checked="checked"'; } ?> />
     <label for="toast_close_button">Close button</label>
     </div>
     
     <div class="form-group">
     <input type="checkbox" class="form-check-input filled-in" id="toast_onclick" name="toast_onclick" <?php if($t['toast_onclick'] == 'true') { echo 'checked="checked"'; } ?>  />
     <label class="form-check-label" for="toast_onclick">Add behavior on toast click</label>
     </div>
     
     <div class="form-group">
     <input type="checkbox" class="form-check-input filled-in" id="toast_debug" name="toast_debug" <?php if($t['toast_debug'] == 'true') { echo 'checked="checked"'; } ?>  />
     <label class="form-check-label" for="toast_debug">Debug</label>
     </div>
     
     <div class="form-group">
     <input type="checkbox" class="form-check-input filled-in" id="toast_prog_bar" name="toast_prog_bar" <?php if($t['toast_prog_bar'] == 'true') { echo 'checked="checked"'; } ?>  />
     <label class="form-check-label" for="toast_prog_bar">Progress Bar</label>
     </div>
      
     <div class="form-group">
     <input type="checkbox" class="form-check-input filled-in" id="toast_prev_dups" name="toast_prev_dups" <?php if($t['toast_prev_dups'] == 'true') { echo 'checked="checked"'; } ?>  />
     <label class="form-check-label" for="toast_prev_dups">Prevent Duplicates</label>
     </div>
     
     <div class="form-group">
     <input type="checkbox" class="form-check-input filled-in" id="toast_new_top" name="toast_new_top" <?php if($t['toast_new_top'] == 'true') { echo 'checked="checked"'; } ?>  />
     <label class="form-check-label" for="toast_new_top">Newest on top</label>
     </div>
     </div>
     
     <div class="col-md-4 col-lg-3 mb-md-auto mb-5">   
     <div class="mb-4" id="toastTypeGroup">
      
     <h5 class="mb-4">Notification Background Color</h5>     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="m_colorg" name="m_color" value="success" checked="checked" />
     <label class="form-check-label" for="m_colorg">Green</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="m_colorb" name="m_color" value="info" />
     <label class="form-check-label" for="m_colorb">Blue</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="m_colory" name="m_color" value="warning" />
     <label class="form-check-label" for="m_colory">Yellow</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="m_colorr" name="m_color" value="error" />
     <label class="form-check-label" for="m_colorr">Red</label>
     </div>
     </div>
     
     <div class="mb-3" id="positionGroup">
     <h5 class="mb-4">Position</h5>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio8" name="m_location" value="toast-top-right" checked="checked" />
     <label class="form-check-label" for="radio8">Top Right</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio9" name="m_location" value="toast-bottom-right" />
     <label class="form-check-label" for="radio9">Bottom Right</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio10" name="m_location" value="toast-bottom-left" />
     <label class="form-check-label" for="radio10">Bottom Left</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio11" name="m_location" value="toast-top-left" />
     <label class="form-check-label" for="radio11">Top Left</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio12" name="m_location" value="toast-top-full-width" />
     <label class="form-check-label" for="radio12">Top Full Width</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio13" name="m_location" value="toast-bottom-full-width" />
     <label class="form-check-label" for="radio13">Bottom Full Width</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio14" name="m_location" value="toast-top-center" />
     <label class="form-check-label" for="radio14">Top Center</label>
     </div>
     
     <div class="form-group mb-1">
     <input type="radio" class="form-check-input with-gap" id="radio15" name="m_location" value="toast-bottom-center" />
     <label class="form-check-label" for="radio15">Bottom Center</label>
     </div>
     </div>  
     </div>

     <div class="col-md-4 col-lg-2 mb-md-auto mb-5">
     
     <div class="md-form">
     <input data-toggle="tooltip" title="Enter swing or linear" class="form-control" id="showEasing" name="toast_show_eas" type="text" value="<?php echo $t['toast_show_eas'] ?>" />
     <label for="showEasing">Show Easing</label>
     </div>
     
     <div class="md-form">
     <input data-toggle="tooltip" title="Enter swing or linear" class="form-control" id="hideEasing" name="toast_hide_eas" type="text" value="<?php echo $t['toast_hide_eas'] ?>" />
     <label for="hideEasing">Hide Easing</label>
     </div>
     
     <div class="md-form">
     <input data-toggle="tooltip" title="Enter show, fadeIn or slideDown" class="form-control" id="showMethod" name="toast_show_meth" type="text" value="<?php echo $t['toast_show_meth'] ?>" />
     <label for="showMethod">Show Method</label>
     </div>
     
     <div class="md-form">
     <input data-toggle="tooltip" title="Enter show, fadeOut or slideUp" class="form-control" id="hideMethod" name="toast_hide_meth" type="text" value="<?php echo $t['toast_hide_meth'] ?>" />
     <label for="hideMethod">Hide Method</label>
     </div> 
     </div>
     
     <div class="col-md-4 col-lg-2">
     
     <div class="md-form">
     <input data-toggle="tooltip" title="In Seconds" class="form-control" id="showDuration" name="toast_show_dur" type="number" value="<?php echo ($t['toast_show_dur'] / 1000) ?>" />
     <label for="showDuration">Show Duration</label>
     </div>
     
     <div class="md-form">
     <input data-toggle="tooltip" title="In Seconds" class="form-control" id="hideDuration" name="toast_hide_dur" type="number" value="<?php echo ($t['toast_hide_dur'] / 1000) ?>" />
     <label for="hideDuration">Hide Duration</label>
     </div>
     
     <div class="md-form">
     <input data-toggle="tooltip" title="In Seconds" class="form-control" id="timeOut" name="toast_timeout" type="number" value="<?php echo ($t['toast_timeout'] / 1000) ?>" />
     <label for="timeOut">Timeout</label>
     </div>
     
     <div class="md-form">
     <input data-toggle="tooltip" title="In Seconds" class="form-control" id="extendedTimeOut" name="toast_ext_timeout" type="number" value="<?php echo ($t['toast_ext_timeout'] / 1000) ?>" />
     <label for="extendedTimeOut" class="mb-2">Extended timeout</label>
     </div>
     
     <div class="md-form">
     <input placeholder="Select date" type="text" name="m_start" id="m_start" class="form-control datepicker" required />
     <label for="m_start">Start Date</label>
     </div>   
          
     <div class="md-form">
     <input placeholder="Select date" type="text" name="m_stop" id="m_stop" class="form-control datepicker" required />
     <label for="m_stop">Stop Date</label>
     </div>    
     </div>   
    
     </div>  
     </div> 
     <hr class="w-100" />
     <input type="submit" id="submitnew" class="btn btn-indigo" value="Create" />   
     </div>
     </form>
     <?php
}

if(isset($_POST['addnotif'])) {
     unset($_POST['addnotif']);
     unset($_POST['submitnew']);
     $db->exec("UPDATE tbl_toast_messages SET m_status = 0 WHERE m_pageid = $_POST[m_pageid]");
     $_POST['m_message'] = addslashes($_POST['m_message']);
     $_POST['m_title'] = addslashes($_POST['m_title']);
     foreach($_POST AS $field => $value) {
          if(strpos($field, 'toast') === 0) {
               switch($field) {
                    case 'toast_close_button':
                    case 'toast_debug':
                    case 'toast_new_top':
                    case 'toast_prog_bar':
                    case 'toast_prev_dups':
                         if($value == 'on') {
                              $value = 'true';
                         } else {
                              $value = 'false';
                         }
                         $db->exec("UPDATE tbl_toast_options SET `$field` = '$value' WHERE t_id = 1");
                         break;
                    case 'toast_show_dur':
                    case 'toast_hide_dur':
                    case 'toast_timeout':
                    case 'toast_ext_timeout':
                         $value = $value .'000';
                         $db->exec("UPDATE tbl_toast_options SET `$field` = '$value' WHERE t_id = 1");
                         break;
                    default:
                         $db->exec("UPDATE tbl_toast_options SET `$field` = '$value' WHERE t_id = 1");
                         break;
               }
          }
     }
     $sql = "INSERT INTO tbl_toast_messages (";     
     foreach($_POST AS $field => $value) {
          if(strpos($field, 'm') === 0) {
               $sql .= "`$field`, ";
          }
     }
     $sql = rtrim($sql, ", ");
     $sql .= ") VALUES (";
     foreach($_POST AS $field => $value) {
          if(strpos($field, 'm') === 0) {
               if($field == 'm_start') {
                    $value = date('Y/m/d', strtotime($value));
               }
               if($field == 'm_stop') {
                    $value = date('Y/m/d', strtotime($value));
               }               
               $sql .= "'$value', ";
          }
     }
     $sql = rtrim($sql, ", ");
     $sql .= ")";
     $db->exec($sql);
     echo 'Notification Created';
}
if(isset($_POST['updatenotif'])) {
     unset($_POST['updatenotif']);
     unset($_POST['submitupdate']);
     $_POST['m_message'] = addslashes($_POST['m_message']);
     $_POST['m_title'] = addslashes($_POST['m_title']);
     $mid = $_POST['m_id'];
     unset($_POST['m_id']);
     foreach($_POST AS $field => $value) {
          if(strpos($field, 'toast') === 0) {
               switch($field) {
                    case 'toast_close_button':
                    case 'toast_debug':
                    case 'toast_new_top':
                    case 'toast_prog_bar':
                    case 'toast_prev_dups':
                         if($value == 'on') {
                              $value = 'true';
                         } else {
                              $value = 'false';
                         }
                         $db->exec("UPDATE tbl_toast_options SET `$field` = '$value' WHERE t_id = 1");
                         break;
                    case 'toast_show_dur':
                    case 'toast_hide_dur':
                    case 'toast_timeout':
                    case 'toast_ext_timeout':
                         $value = $value .'000';
                         $db->exec("UPDATE tbl_toast_options SET `$field` = '$value' WHERE t_id = 1");
                         break;                         
                    default:
                         $db->exec("UPDATE tbl_toast_options SET `$field` = '$value' WHERE t_id = 1");
                         break;
               }
          }
     }
     $sql = "UPDATE tbl_toast_messages SET ";     
     foreach($_POST AS $field => $value) {
          if(strpos($field, 'm') === 0) {
               if($field == 'm_start') {
                    $value = date('Y/m/d', strtotime($value));
               }
               if($field == 'm_stop') {
                    $value = date('Y/m/d', strtotime($value));
               }               
               $sql .= "`$field` = '$value', ";
          }
     }
     $sql = rtrim($sql, ", ");
     $sql .= "WHERE m_id = $mid";
     $db->exec($sql);
     echo 'Notification Updated';
}