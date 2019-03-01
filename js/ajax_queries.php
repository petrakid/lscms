<?php
session_start();

include '../ld/db.inc.php';
include '../ld/globals.inc.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['new_slide'])) {
     $db->exec("INSERT INTO tbl_carousel (car_image, car_status, car_caption, car_url, car_order) VALUES ('', 0, '', '', 0)");
     echo 'Slide Created';
}

if(isset($_POST['new_comment'])) {
     $commenttext = addslashes($_POST['comment_text']);
     $db->exec("INSERT INTO tbl_comments (`comment_page_id`, `comment_date`, `comment_name`, `comment_email`, `comment_text`, `comment_status`) VALUES ('$_POST[comment_page]', now(), '$_POST[comment_name]', '$_POST[comment_email]', '$commenttext', 0)");
     $_SESSION['comment_added'] = 1;
     die;
}

if(isset($_POST['delete_comment'])) {
     $db->exec("DELETE FROM tbl_comments WHERE cm_id = $_POST[comment_id]");
     die;
}

if(isset($_POST['approve_comment'])) {
     $db->exec("UPDATE tbl_comments SET comment_status = 1 WHERE cm_id = $_POST[comment_id]");
     die;
}

if(isset($_POST['updateglobals'])) {
     unset($_POST['updateglobals']);
     unset($_POST['id']);
     foreach($_POST AS $key => $val) {
          $val = stripslashes($val);
          $db->exec("UPDATE tbl_globals SET `$key` = '$val' WHERE id = 1");
     }
     echo 'Globals Updated';
}

if(isset($_POST['add_menu'])) {
     $db->exec("INSERT INTO tbl_pages (menu_name, menu_link, menu_status, menu_order, parent_id) VALUES ('New Menu', 'new-menu', 0, 0, 99)");
}

if(isset($_POST['edit_menu'])) {
     $mnu = $db->query("SELECT * FROM tbl_pages WHERE p_id = $_POST[p_id]");
     $mn = $mnu->fetch(PDO::FETCH_ASSOC);
     if($mn['menu_name'] == $gbl['homepage']) {
          echo 'You cannot edit the Homepage menu of the site.  Change the Homepage, or edit another menu.';
     } else {
          ?>
          This will allow the user to edit the menu name, status, and whether or not it's a parent or child.
          <div class="md-form">
          <input type="text" name="newmenu_name" id="newmenu_name" value="<?php echo $mn['menu_name'] ?>" class="form-control" onblur="changeMenuLink(this.value)" />
          <label for="newmenu_name">Menu Name</label>
          </div>
          
          <div class="md-form">
          <input type="text" name="newmenu_link" id="newmenu_link" value="<?php echo $mn['menu_link'] ?>" class="form-control" />
          <label for="newmenu_link">Menu Link</label>
          </div>
          
          <div class="row">
          <div class="col-md-4">
          <b>Menu Status</b>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="newmenu_status" id="newmenu_status1" value="1" <?php if($mn['menu_status'] == 1) { echo 'checked="checked"'; } ?> />
          <label class="form-check-label" for="newmenu_status1">Enabled</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="newmenu_status" id="newmenu_status0" value="0" <?php if($mn['menu_status'] == 0) { echo 'checked="checked"'; } ?> />
          <label class="form-check-label" for="newmenu_status0">Disabled</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="newmenu_status" id="newmenu_status9" value="9" />
          <label class="form-check-label" for="newmenu_status9">Delete</label>
          </div>
          </div>
          
          <div class="col-md-8">
          <b>Menu Type</b>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="newmenu_type" id="newmenu_typeP" value="P" <?php if($mn['parent_id'] == 0) { echo 'checked="checked"';} ?> />
          <label class="form-check-label" for="newmenu_typeP">Parent Menu</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="newmenu_type" id="newmenu_typeC" value="C" <?php if($mn['parent_id'] > 0) { echo 'checked="checked"';} ?> />
          <label class="form-check-label" for="newmenu_typeC">Child Menu</label>
          </div><br />
          
          <b>If this is a Child menu, select its Parent</b>
          <select name="selected_parent" id="selected_parent" class="mdb-select">
          <option selected disabled>Select</option>
          <?php
          $pmn = $db->query("SELECT p_id, menu_name FROM tbl_pages WHERE parent_id = 0 AND menu_status <= 1 AND p_id != $_POST[p_id] ORDER BY menu_order");
          while($pm = $pmn->fetch(PDO::FETCH_ASSOC)) {
               if($pm['p_id'] == $_POST['parent_id']) {
                    echo '<option value="'. $_POST['parent_id'] .'" selected="selected">'. str_replace("_"," ",$pm['menu_name']) .'</option>'."\r\n";
               } else {
                    echo '<option value="'. $pm['p_id'] .'">'. str_replace("_"," ",$pm['menu_name']) .'</option>'."\r\n";
               }
          }
          ?>
          </select>
          </div>
          </div>
          <div class="row">
          <div class="col-md-4">
          <button type="button" class="btn btn-success" onclick="updateMenu(<?php echo $mn['p_id'] ?>)">Update</button>
          </div>
          </div>
          
          <?php
     }
}
if(isset($_POST['update_menu'])) {
     $menu_name = addslashes($_POST['menu_name']);
     if($_POST['parent_id'] == 0) {
          $isparent = 1;
     } else {
          $isparent = 0;
     }
     if($_POST['menu_status'] == 9) {
          $db->exec("UPDATE tbl_pages SET menu_status = 9 WHERE p_id = $_POST[p_id]");
     } else {
          $db->exec("UPDATE tbl_pages SET menu_status = $_POST[menu_status], menu_name = '$menu_name', menu_link = '$_POST[menu_link]', parent_id = $_POST[parent_id], is_parent = $isparent WHERE p_id = $_POST[p_id]");
     }
}

if(isset($_POST['enable_menu'])) {
     $db->exec("UPDATE tbl_pages SET menu_status = 0, parent_id = 99 WHERE p_id = $_POST[p_id]");
}

if(isset($_POST['change_parent_order'])) {
     $i = 0;
     foreach($_POST['data'] AS $value) {
          $db->exec("UPDATE tbl_pages SET menu_order = $i where p_id = $value");
          $i++;
     }
}

if(isset($_POST['change_child_order'])) {
     $i = 0;
     foreach($_POST['data'] AS $value) {
          $db->exec("UPDATE tbl_pages SET menu_order = $i where p_id = $value");
          $i++;
     }
}