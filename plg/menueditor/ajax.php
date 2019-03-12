<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die('You do not have permission!');
}

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['item'])) {
     $i = 0;
     foreach($_POST['item'] AS $val) {
          $db->exec("UPDATE tbl_pages SET menu_order = $i WHERE p_id = $val");
          $i++;
     }
}

if(isset($_POST['new_menu'])) {
     ?>
     <form>
     <div class="form-row">
     <div class="col-12" id="pageurl">
     <?php
     if($_POST['parent_id'] > 0) {
          $pt = $db->query("SELECT menu_link FROM tbl_pages WHERE p_id = $_POST[parent_id]");
          $t = $pt->fetch(PDO::FETCH_ASSOC);
          $url = $gbl['site_url'] .'/'. $t['menu_link'] .'/';
     } else {
          $url = $gbl['site_url'] .'/';
     }
     ?>
     </div>
     </div>
     <div class="form-row">
     <div class="col">
     <div class="md-form mt-0">
     <input type="text" class="form-control" placeholder="Menu Name" name="new_menu_name" id="new_menu_name" required="required" onblur="makeLink('<?php echo $url ?>')" onkeyup="changeMenuLink(this.value)" />
     </div>
     </div>
     <div class="col">
     <div class="md-form mt-0">
     <input type="text" class="form-control" placeholder="Menu Link" name="new_menu_link" id="new_menu_link" required="required" />
     <small class="form-text text-muted">Auto-created</small>
     </div>
     </div>
     </div>
     
     <div class="form-row">
     <div class="col">
     <div class="md-form mt-0">
     <input type="text" class="form-control" placeholder="Page Title" required="required" name="new_page_title" id="new_page_title" />
     </div>
     </div>
     <div class="col">
     <select class="mdb-selecta md-form mt-0" name="new_parent_id" id="new_parent_id" onchange="checkMega(this.value)">
     <option value="0" disabled selected>Choose Parent if Child Menu</option>
     <?php
     $par = $db->query("SELECT p_id, menu_name FROM tbl_pages WHERE parent_id = 0 AND menu_status != 9 AND menu_link != 'home' ORDER BY menu_order");
     while($pr = $par->fetch(PDO::FETCH_ASSOC)) {
          if($pr['p_id'] == $_POST['parent_id']) {
               echo '<option selected="selected" value="'. $pr['p_id'] .'">'. stripslashes($pr['menu_name']) .'</option>'."\n";
          } else {
               echo '<option value="'. $pr['p_id'] .'">'. stripslashes($pr['menu_name']) .'</option>'."\n";               
          }
     }
     ?>
     </select>
     <label class="mt-0-select">Parent Menu</label>     
     </div>
     </div>

     <div class="form-row">
     <div class="col">
     <div class="md-form mt-0">
     <input type="url" class="form-control" placeholder="Custom URL" name="new_menu_url" id="new_menu_url" />
     <small class="form-text text-muted">If the menu should open to a different site</small>
     </div>
     </div>
     <div class="col">
     <select class="mdb-selecta md-form mt-0" name="new_menu_target" id="new_menu_target">
     <option value="" disabled selected>Select Target</option>
     <option value="_self">Same Page/Tab</option>
     <option value="_blank">New Page/Tab</option>
     </select>
     <label class="mt-0-select">URL Target</label>
     </div>
     </div>
     
     <div class="form-row">
     <div class="col">
     <div class="form-check" id="megamenucheck" <?php if($_POST['parent_id'] != 0) { echo 'style="display: none"'; } ?>>
     <input class="form-check-input" type="checkbox" name="new_mega_menu" value="1" id="new_mega_menu" />
     <label class="form-check-label" for="new_mega_menu">Mega Menu (will only work with parent menus)</label>
     </div>
     </div>
     <div class="col">
     <button type="button" onclick="saveNew()" class="btn btn-success"><i class="fa fa-save"></i> Save</button>     
     </div>
     </div>
     </form>
     <?php
}

if(isset($_POST['new_mega'])) {
     echo 'This feature is not yet enabled.  Continue to use the standard menu until further notice.';
}

if(isset($_POST['edit_mega'])) {
     echo 'This feature is not yet enabled.  Continue to use the standard menu until further notice.';     
}

if(isset($_POST['edit_menu'])) {
     $menu = $db->query("SELECT p_id, menu_name, menu_link, page_title, parent_id, menu_url, menu_target, mega_menu, menu_status FROM tbl_pages WHERE p_id = $_POST[pid]");
     $m = $menu->fetch(PDO::FETCH_ASSOC);
     ?>
     <form>
     <input type="hidden" name="p_id" id="p_id" value="<?php echo $m['p_id'] ?>" />
     <div class="form-row">
     <div class="col-12" id="pageurl">
     <?php
     if($m['parent_id'] > 0) {
          $pt = $db->query("SELECT menu_link FROM tbl_pages WHERE p_id = $m[parent_id]");
          $t = $pt->fetch(PDO::FETCH_ASSOC);
          $url = $gbl['site_url'] .'/'. $t['menu_link'] .'/'. $m['menu_link'];
     } else {
          $url = $gbl['site_url'] .'/'. $m['menu_link'];
     }
     ?>
     <small class="form-text text-muted">Page URL: <a href="<?php echo $url ?>"><?php echo $url ?></a></small>
     </div> 
     </div>
     <div class="form-row">
     <div class="col">
     <div class="md-form mt-0">
     <input type="text" class="form-control" placeholder="Menu Name" name="e_menu_name" id="e_menu_name" value="<?php echo stripslashes($m['menu_name']) ?>" required="required" onkeyup="changeMenuLink(this.value)" />
     </div>
     </div>
     <div class="col">
     <div class="md-form mt-0">
     <input type="text" class="form-control" placeholder="Menu Link" name="e_menu_link" id="e_menu_link" value="<?php echo $m['menu_link'] ?>" required="required" readonly="readonly" />
     <small class="form-text text-muted">Auto-created</small>
     </div>
     </div>
     </div>
     
     <div class="form-row">
     <div class="col">
     <div class="md-form mt-0">
     <input type="text" class="form-control" placeholder="Page Title" required="required" name="e_page_title" id="e_page_title" value="<?php echo stripslashes($m['page_title']) ?>"  />
     </div>
     </div>
     <div class="col">
     <select class="mdb-selecta md-form mt-0" name="e_parent_id" id="e_parent_id">
     <option value="0" disabled selected>Choose Parent if Child Menu</option>
     <?php
     $par = $db->query("SELECT p_id, menu_name FROM tbl_pages WHERE parent_id = 0 AND menu_status != 9 AND menu_link != 'home' ORDER BY menu_order");
     while($pr = $par->fetch(PDO::FETCH_ASSOC)) {
          if($pr['p_id'] == $m['parent_id']) {
               echo '<option selected="selected" value="'. $pr['p_id'] .'">'. stripslashes($pr['menu_name']) .'</option>'."\n";
          } else {
               echo '<option value="'. $pr['p_id'] .'">'. stripslashes($pr['menu_name']) .'</option>'."\n";               
          }
     }
     ?>
     </select>
     <label class="mt-0-select">Parent Menu</label>     
     </div>
     </div>

     <div class="form-row">
     <div class="col">
     <div class="md-form mt-0">
     <input type="url" class="form-control" placeholder="Custom URL" name="e_menu_url" id="e_menu_url" value="<?php echo $m['menu_url'] ?>"  />
     <small class="form-text text-muted">If the menu should open to a different site</small>
     </div>
     </div>
     <div class="col">
     <select class="mdb-selecta md-form mt-0" name="e_menu_target" id="e_menu_target">
     <option value="" disabled selected>Select Target</option>
     <option value="_self" <?php if($m['menu_url'] == '_self') { echo 'selected="selected"';} ?>>Same Page/Tab</option>
     <option value="_blank" <?php if($m['menu_url'] == '_blank') { echo 'selected="selected"';} ?>>New Page/Tab</option>
     </select>
     <label class="mt-0-select">URL Target</label>
     </div>
     </div>
     
     <div class="form-row">
     <div class="col">
     <div class="form-check">
     <input class="form-check-input" type="radio" name="e_menu_status" id="e_menu_status0" value="0" <?php if($m['menu_status'] == 0) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="e_menu_status0">Disabled</label>
     </div>
     <div class="form-check">
     <input class="form-check-input" type="radio" name="e_menu_status" id="e_menu_status1" value="1" <?php if($m['menu_status'] == 1) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="e_menu_status1">Enabled</label>
     <small class="form-text text-muted red-text">Enabling will cause the menu to appear to the public</small>
     </div>
     <div class="form-check" id="megamenucheck" <?php if($m['parent_id'] != 0) { echo 'style="display: none"'; } ?>>
     <input class="form-check-input" type="checkbox" name="e_mega_menu" value="1" <?php if($m['mega_menu'] == 1) { echo 'checked="checked"';} ?> id="e_mega_menu" />
     <label class="form-check-label" for="e_mega_menu">Mega Menu (will only work with parent menus)</label>
     </div>     
     </div>
     <div class="col">
     <button type="button" onclick="saveMenu()" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
     <button type="button" onclick="deleteMenu(<?php echo $m['p_id'] ?>)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete Menu</button>     
     </div>
     </div>            
     </form>     
     <?php
}

if(isset($_POST['add_menu'])) {
     unset($_POST['add_menu']);
     $sql = "INSERT INTO tbl_pages (";
     foreach($_POST AS $key => $val) {
          $sql .= "`$key`, ";
     }
     $sql = trim($sql, ", ");
     $sql .= ") VALUES (";
     foreach($_POST AS $key => $val) {
          if($key == 'menu_name' || $key == 'page_title' || $key == 'mega_menu_html' || $key == 'menu_link' || $key == 'menu_url' || $key == 'menu_target') {
               $val = $db->quote($val);
          }
          if($key == 'parent_id') {
               if($val == null) {
                    $val = 0;
               }
          }
          $sql .= "$val, ";
     }
     $sql = rtrim($sql, ", ");
     $sql .= ")";
     $db->exec($sql);
}

if(isset($_POST['update_menu'])) {
     $pid = $_POST['p_id'];
     unset($_POST['update_menu']);
     unset($_POST['p_id']);
     $sql = "UPDATE tbl_pages SET ";
     foreach($_POST AS $key => $val) {
          if($key == 'menu_name' || $key == 'page_title' || $key == 'mega_menu_html' || $key == 'menu_link' || $key == 'menu_url' || $key == 'menu_target') {
               $val = $db->quote($val);
          }
          if($key == 'parent_id') {
               if($val == 'null') {
                    $val = 0;
               }
          }
          $sql .= "`$key` = $val, ";
     }
     $sql = rtrim($sql, ", ");
     $sql .= " WHERE p_id = $pid";
     $db->exec($sql);
}

if(isset($_POST['delete_menu'])) {
     $db->exec("UPDATE tbl_pages SET menu_status = 9 WHERE p_id = $_POST[pid]");
}