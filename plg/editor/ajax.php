<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['update_content'])) {
     $content = addslashes($_POST['content']);
     $id = $_POST['block_id'];
     $db->exec("UPDATE tbl_blocks SET block_content = '$content', date_added = now() WHERE b_id = $id");
}

if(isset($_POST['save_field'])) {
     $db->exec("UPDATE tbl_pages SET `$_POST[f]` = '$_POST[v]' WHERE p_id = $_POST[pid]");
}

if(isset($_POST['load_blocks'])) {
     $block = $db->query("SELECT * FROM tbl_blocks WHERE page_id = $_POST[page] AND block_status != 9");
     if($block->rowCount() == 0) {
          ?>
          <b>Click New Block</b>
          <div id="blockRes">
          <button class="btn btn-unique btn-rounded" onclick="addBlock(<?php echo $_POST['page'] ?>)"><i class="fa fa-plus"></i> New Block</button>     
          </div>          
          <?php                    
     } else {
          $b = $block->fetch(PDO::FETCH_ASSOC);
          ?>
          <hr />
          <div id="blockRes">
     
          <div class="md-form">
          <i id="bblock_header" class="fas fa-check green-text prefix" style="display: none"></i>      
          <input onblur="updateBlock('block_header', this.value, <?php echo $b['b_id'] ?>)" type="text" name="block_header" id="block_header" value="<?php echo $b['block_header'] ?>" required="required" class="form-control" />
          <label class="active" for="block_header">Block Title</label>
          </div>
     
          <i id="bshow_header" class="fas fa-check green-text prefix" style="display: none"></i>     
          <b>Display Title?</b>
          <small class="form-text text-muted mb-2">If you'd like to hide the title of this block, you can do so here.</small>
          <div class="form-check form-check-inline">
          <input onclick="updateBlock('show_header', 1, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="show_header" id="show_header1" value="1" <?php if($b['show_header'] == 1) { echo 'checked="checked"';} ?> />
          <label class="form-check-label" for="show_header1">Yes</label>
          </div>
          <div class="form-check form-check-inline">
          <input onclick="updateBlock('show_header', 0, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="show_header" id="show_header0" value="0" <?php if($b['show_header'] == 0) { echo 'checked="checked"';} ?> />
          <label class="form-check-label" for="show_header0">No</label>
          </div><br /><br />
     
          <i id="bblock_status" class="fas fa-check green-text prefix" style="display: none"></i> 
          <b>Block Status</b>
          <small class="form-text text-muted mb-2">Show, hide, or delete this block.</small>
          <div class="form-check form-check-inline">
          <input onclick="updateBlock('block_status', 1, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="block_status" id="block_status1" value="1" <?php if($b['block_status'] == 1) { echo 'checked="checked"';} ?> required="required" />
          <label class="form-check-label" for="block_status1">Visible</label>
          </div>
          <div class="form-check form-check-inline">
          <input onclick="updateBlock('block_status', 0, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="block_status" id="block_status0" value="0" <?php if($b['block_status'] == 0) { echo 'checked="checked"';} ?> />
          <label class="form-check-label" for="block_status0">Hidden</label>
          </div>
          <div class="form-check form-check-inline">
          <input onclick="updateBlock('block_status', 9, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="block_status" id="block_status9" value="9" />
          <label class="form-check-label" for="block_status9">Delete Block</label>
          </div>           
          <hr />
          
          <small class="form-text text-muted mb-2">You can select if this block is scheduled to be active and to deactivate at on certain dates/times.</small>
          <div class="form-check">
          <input onclick="updateBlock('scheduled', 'check_status', <?php echo $b['b_id'] ?>)" class="form-check-input" type="checkbox" name="scheduled" id="scheduled" value="1" <?php if($b['scheduled'] == 1) { echo 'checked="checked"';} ?> />
          <label class="form-check-label" for="scheduled">Enable Schedule</label>
          </div>
     
          <div class="md-form">
          <i id="bstartdate" class="fas fa-check green-text prefix" style="display: none"></i>      
          <input onblur="updateBlock('startdate', this.value, <?php echo $b['b_id'] ?>)" type="date" name="startdate" id="startdate" value="<?php echo $b['start_datetime'] ?>" class="form-control" />          
          <label class="active" for="startdate">Scheduled Start Date</label>
          </div>
          
          <div class="md-form">
          <i id="benddate" class="fas fa-check green-text prefix" style="display: none"></i>                
          <input onblur="updateBlock('enddate', this.value, <?php echo $b['b_id'] ?>)" type="date" name="enddate" id="enddate" value="<?php echo $b['end_datetime'] ?>" class="form-control" />
          <label class="active" for="enddate">Schedule End Date</label>      
          </div>
          <hr />
          
          <b>Panel Background Color</b>
          <small class="form-text text-muted">The default color is white.  You can select a different color here</small>
          <div class="md-form">
          <i id="bblock_color" class="fas fa-check green-text prefix" style="display: none"></i>     
          <input onblur="updateBlock('block_color', this.value, <?php echo $b['b_id'] ?>)" class="color-picker" type="color" name="block_color" id="block_color" value="<?php echo $b['block_color'] ?>" />
          </div><br />
          
          <i id="btransparent" class="fas fa-check green-text prefix" style="display: none"></i>     
          <b>Panel Transparency (Opacity)</b>
          <small class="form-text text-muted mb-2">You can adjust this block's background transparency to further customize its style.</small>
          <div class="md-form range-field">   
          <input onblur="updateBlock('transparent', this.value, <?php echo $b['b_id'] ?>)" type="range" min="0" max="100" id="transparent" value="<?php echo $b['transparent'] * 100 ?>" onchange="updateTest()" />
          <small class="form-text text-muted">Drag to the right to reduce transparancy.</small>
          </div>
          <img class="img-fluid hoverable" src="<?php echo $gbl['site_url'] ?>/ast/site/test_image.jpg" style="opacity: <?php echo $b['transparent'] ?>;" width="150" id="testimage" />
          <hr />     
     
          <i id="bedge_padding" class="fas fa-check green-text prefix" style="display: none"></i>
          <b>Edge Padding?</b>
          <small class="form-text text-muted mb-2">You can display the block with standard edge padding or make it touch the edge of the screen.</small>
          <div class="form-check form-check-inline">               
          <input onclick="updateBlock('edge_padding', 1, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="edge_padding" id="edge_padding1" value="1" <?php if($b['edge_padding'] == 1) { echo 'checked="checked"';} ?> />
          <label class="form-check-label" for="edge_padding1">Yes</label>
          </div>
          <div class="form-check form-check-inline">
          <input onclick="updateBlock('edge_padding', 0, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="edge_padding" id="edge_padding0" value="0" <?php if($b['edge_padding'] == 0) { echo 'checked="checked"';} ?> />
          <label class="form-check-label" for="edge_padding0">No</label>
          </div>
          <hr />
           
          <i id="bblock_plugin" class="fas fa-check green-text prefix" style="display: none"></i>     
          <b>Block Plugin</b>
          <small class="form-text text-muted mb-2">Includes a plugin after the block content.  You can also include plugins by adding their "shortcode" to the content.</small>
          <select class="mdb-select mdb-selectr md-form mb-2 initialized" name="block_plugin" id="block_plugin" onchange="updateBlock('block_plugin', this.value, <?php echo $b['b_id'] ?>)">
          <option value="" <?php if($b['block_plugin'] == '') { echo 'selected="selected"';} ?>>None</option>
          <?php
          $sqlp = $db->query("SELECT * FROM tbl_plugins WHERE plugin_status = 1");
          while($plg = $sqlp->fetch(PDO::FETCH_ASSOC)) {
               echo '<option value="'. $plg['plugin_file'] .'"';
               if($plg['plugin_file'] == $b['block_plugin']) {
                    echo ' selected="selected"';
               }
               echo '>'. $plg['plugin_name'] .'</option>';
          }
          ?>
          </select>            
          </div>          
          <?php
     }
}

if(isset($_POST['select_block'])) {
     $block = $db->query("SELECT * FROM tbl_blocks WHERE b_id = $_POST[b_id]");
     $b = $block->fetch(PDO::FETCH_ASSOC);
     ?>
     
     <div class="md-form">
     <i id="bblock_header" class="fas fa-check green-text prefix" style="display: none"></i>      
     <input onblur="updateBlock('block_header', this.value, <?php echo $b['b_id'] ?>)" type="text" name="block_header" id="block_header" value="<?php echo $b['block_header'] ?>" required="required" class="form-control" />
     <label class="active" for="block_header">Block Title</label>
     </div>

     <i id="bshow_header" class="fas fa-check green-text prefix" style="display: none"></i>     
     <b>Display Title?</b>
     <small class="form-text text-muted mb-2">If you'd like to hide the title of this block, you can do so here.</small>
     <div class="form-check form-check-inline">
     <input onclick="updateBlock('show_header', 1, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="show_header" id="show_header1" value="1" <?php if($b['show_header'] == 1) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="show_header1">Yes</label>
     </div>
     <div class="form-check form-check-inline">
     <input onclick="updateBlock('show_header', 0, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="show_header" id="show_header0" value="0" <?php if($b['show_header'] == 0) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="show_header0">No</label>
     </div><br /><br />

     <i id="bblock_status" class="fas fa-check green-text prefix" style="display: none"></i> 
     <b>Block Status</b>
     <small class="form-text text-muted mb-2">Show, hide, or delete this block.</small>
     <div class="form-check form-check-inline">
     <input onclick="updateBlock('block_status', 1, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="block_status" id="block_status1" value="1" <?php if($b['block_status'] == 1) { echo 'checked="checked"';} ?> required="required" />
     <label class="form-check-label" for="block_status1">Visible</label>
     </div>
     <div class="form-check form-check-inline">
     <input onclick="updateBlock('block_status', 0, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="block_status" id="block_status0" value="0" <?php if($b['block_status'] == 0) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="block_status0">Hidden</label>
     </div>
     <div class="form-check form-check-inline">
     <input onclick="updateBlock('block_status', 9, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="block_status" id="block_status9" value="9" />
     <label class="form-check-label" for="block_status9">Delete Block</label>
     </div>           
     <hr />
     
     <small class="form-text text-muted mb-2">You can select if this block is scheduled to be active and to deactivate at on certain dates/times.</small>
     <div class="form-check">
     <input onclick="updateBlock('scheduled', 'check_status', <?php echo $b['b_id'] ?>)" class="form-check-input" type="checkbox" name="scheduled" id="scheduled" value="1" <?php if($b['scheduled'] == 1) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="scheduled">Enable Schedule</label>
     </div>

     <div class="md-form">
     <i id="bstartdate" class="fas fa-check green-text prefix" style="display: none"></i>      
     <input onblur="updateBlock('startdate', this.value, <?php echo $b['b_id'] ?>)" type="date" name="startdate" id="startdate" value="<?php echo $b['start_datetime'] ?>" class="form-control" />          
     <label class="active" for="startdate">Scheduled Start Date</label>
     </div>
     
     <div class="md-form">
     <i id="benddate" class="fas fa-check green-text prefix" style="display: none"></i>                
     <input onblur="updateBlock('enddate', this.value, <?php echo $b['b_id'] ?>)" type="date" name="enddate" id="enddate" value="<?php echo $b['end_datetime'] ?>" class="form-control" />
     <label class="active" for="enddate">Schedule End Date</label>      
     </div>
     <hr />
     
     <b>Panel Background Color</b>
     <small class="form-text text-muted">The default color is white.  You can select a different color here</small>
     <div class="md-form">
     <i id="bblock_color" class="fas fa-check green-text prefix" style="display: none"></i>     
     <input onblur="updateBlock('block_color', this.value, <?php echo $b['b_id'] ?>)" class="color-picker" type="color" name="block_color" id="block_color" value="<?php echo $b['block_color'] ?>" />
     </div><br />
     
     <i id="btransparent" class="fas fa-check green-text prefix" style="display: none"></i>     
     <b>Panel Transparency (Opacity)</b>
     <small class="form-text text-muted mb-2">You can adjust this block's background transparency to further customize its style.</small>
     <div class="md-form range-field">   
     <input onblur="updateBlock('transparent', this.value, <?php echo $b['b_id'] ?>)" type="range" min="0" max="100" id="transparent" value="<?php echo $b['transparent'] * 100 ?>" onchange="updateTest()" />
     <small class="form-text text-muted">Drag to the right to reduce transparancy.</small>
     </div>
     <img class="img-fluid hoverable" src="<?php echo $gbl['site_url'] ?>/ast/site/test_image.jpg" style="opacity: <?php echo $b['transparent'] ?>;" width="150" id="testimage" />
     <hr />     

     <i id="bedge_padding" class="fas fa-check green-text prefix" style="display: none"></i>
     <b>Edge Padding?</b>
     <small class="form-text text-muted mb-2">You can display the block with standard edge padding or make it touch the edge of the screen.</small>
     <div class="form-check form-check-inline">               
     <input onclick="updateBlock('edge_padding', 1, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="edge_padding" id="edge_padding1" value="1" <?php if($b['edge_padding'] == 1) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="edge_padding1">Yes</label>
     </div>
     <div class="form-check form-check-inline">
     <input onclick="updateBlock('edge_padding', 0, <?php echo $b['b_id'] ?>)" class="form-check-input" type="radio" name="edge_padding" id="edge_padding0" value="0" <?php if($b['edge_padding'] == 0) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="edge_padding0">No</label>
     </div>
     <hr />
   
     <i id="bblock_plugin" class="fas fa-check green-text prefix" style="display: none"></i>     
     <b>Plugin</b>
     <small class="form-text text-muted mb-2">Includes a plugin after the block content.  You can also include plugins by adding their "shortcode" to the content.</small>
     <select class="mdb-select mdb-selectr md-form mb-2 initialized" name="block_plugin" id="block_plugin" onchange="updateBlock('block_plugin', this.value, <?php echo $b['b_id'] ?>)">
     <option value="" <?php if($b['block_plugin'] == '') { echo 'selected="selected"';} ?>>None</option>
     <?php
     $sqlp = $db->query("SELECT * FROM tbl_plugins WHERE plugin_status = 1");
     while($plg = $sqlp->fetch(PDO::FETCH_ASSOC)) {
          echo '<option value="'. $plg['plugin_file'] .'"';
          if($plg['plugin_file'] == $b['block_plugin']) {
               echo ' selected="selected"';
          }
          echo '>'. $plg['plugin_name'] .'</option>';
     }
     ?>
     </select>     
     <?php
}
if(isset($_POST['new_block'])) {
     $db->exec("INSERT INTO tbl_blocks (page_id, block_header, date_added) VALUES ($_POST[page_id], 'New Panel', now())");
}
if(isset($_POST['update_block'])) {
     if($_POST['f'] == 'transparent') {
          $_POST['v'] = $_POST['v'] / 100;
     }
     $db->exec("UPDATE tbl_blocks SET `$_POST[f]` = '$_POST[v]' WHERE b_id = $_POST[b_id]");
}

if(isset($_POST['load_page_settings'])) {
     $pset = $db->query("SELECT * FROM tbl_pages WHERE p_id = $_POST[page]");
     $ps = $pset->fetch(PDO::FETCH_ASSOC);
     ?>     
     <div class="md-form">
     <i id="ppage_title" class="fas fa-check green-text prefix" style="display: none"></i>     
     <input onblur="savePageSetting('page_title', this.value, <?php echo $ps['p_id'] ?>)" type="text" name="page_title" id="page_title" value="<?php echo stripslashes($ps['page_title']) ?>" required="required" class="form-control" />
     <label class="active" for="page_title">Page Title</label>        
     </div>     

     <div class="md-form">
     <i id="pmenu_name" class="fas fa-check green-text prefix" style="display: none"></i>     
     <input onkeyup="makeMenuLink(this.value)" onblur="savePageSetting('menu_name', this.value, <?php echo $ps['p_id'] ?>)" type="text" name="menu_name" id="menu_name" value="<?php echo stripslashes($ps['menu_name']) ?>" required="required" class="form-control" />
     <label class="active" for="menu_name">Menu Name</label>
     </div>
     
     <div class="md-form">
     <i id="pmenu_link" class="fas fa-check green-text prefix" style="display: none"></i>     
     <input oninput="savePageSetting('menu_link', this.value, <?php echo $ps['p_id'] ?>)" onblur="savePageSetting('menu_link', this.value, <?php echo $ps['p_id'] ?>)" type="text" name="menu_link" id="menu_link" value="<?php echo $ps['menu_link'] ?>" required="required" class="form-control" />
     <label class="active" for="menu_link">Menu Link</label>
     <small class="form-text text-muted mb-2">Auto-created from the Menu Name, but you can also override here.  Will be formatted for SEO friendliness.</small>
     </div>
     
     <div class="md-form">
     <i id="pmenu_url" class="fas fa-check green-text prefix" style="display: none"></i>     
     <input onblur="savePageSetting('menu_url', this.value, <?php echo $ps['p_id'] ?>)" type="url" name="menu_url" id="menu_url" class="form-control" value="<?php echo $ps['menu_url'] ?>" />
     <label class="active" for="menu_url">Page URL</label>
     <small class="form-text text-muted mb-2">A url not associated with this website.  This will forward the user to the url you enter in a new page/tab.</small>     
     </div>
     
     <i id="ppage_status" class="fas fa-check green-text prefix" style="display: none;"></i>
     <b>Page Status</b>
     <small class="form-text text-muted mb-2">Show, hidden or draft</small>
     <div class="form-check">
     <input onclick="savePageSetting('menu_status', 1, <?php echo $ps['p_id'] ?>)" class="form-check-input" type="radio" name="menu_status" id="menu_status1" value="1" <?php if($ps['menu_status'] == 1) { echo 'checked="checked"';} ?> required="required" />
     <label for="menu_status1" class="form-check-label">Page Active (in menu)</label>
     </div>
     <div class="form-check">
     <input onclick="savePageSetting('menu_status', 2, <?php echo $ps['p_id'] ?>)" class="form-check-input" type="radio" name="menu_status" id="menu_status0" value="0" <?php if($ps['menu_status'] == 0) { echo 'checked="checked"';} ?> />
     <label for="menu_status0" class="form-check-label">Page Hidden (non-menu, accessible)</label>     
     </div>
     <div class="form-check">
     <input onclick="savePageSetting('menu_status', 0, <?php echo $ps['p_id'] ?>)" class="form-check-input" type="radio" name="menu_status" id="menu_status3" value="3" <?php if($ps['menu_status'] == 3) { echo 'checked="checked"';} ?> />
     <label for="menu_status3" class="form-check-label">Draft (accessible by &GreaterEqual; Editors only)</label>     
     </div>
     <hr />
     
     <i id="pshow_slider" class="fas fa-check green-text prefix" style="display: none;"></i>
     <b>Carousel</b>
     <small class="form-text text-muted mb-2">Show or hide the image carousel for this page.</small>     
     <div class="form-check">
     <input onclick="savePageSetting('show_slider', 1, <?php echo $ps['p_id'] ?>)" class="form-check-input" type="radio" name="show_slider" id="show_slider1" value="1" <?php if($ps['show_slider'] == 1) { echo 'checked="checked"';} ?> required="required" />
     <label class="form-check-label" for="show_slider1">Carousel Enabled</label>
     </div>
     <div class="form-check">
     <input onclick="savePageSetting('show_slider', 0, <?php echo $ps['p_id'] ?>)" class="form-check-input" type="radio" name="show_slider" id="show_slider0" value="0" <?php if($ps['show_slider'] == 0) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="show_slider0">Carousel Disabled</label>     
     </div>
     <hr />

     <i id="pjumbotron_image" class="fas fa-check green-text prefix" style="display: none;"></i>     
     <b>Landing Image</b>
     <small class="form-text text-muted mb-2">Displays in leu of the carousel</small>
     <div class="file-upload-wrapper">     
     <input type="file" id="jumbotron_image" name="jumbotron_image" class="jfileUpload" accept="image/*" data-show-remove="true" data-default-file="<?php echo $gbl['site_url'] ?>/ast/landings/<?php echo $ps['jumbotron_image'] ?>" />
     </div>
     <div style="clear:both"></div>
     <hr />
     
     <i id="psocial_links" class="fas fa-check green-text prefix" style="display: none;"></i>
     <b>Social Features</b>
     <small class="form-text text-muted mb-2">To show or hide the social site sharing features.</small>      
     <div class="form-check">
     <input onclick="savePageSetting('social_links', 1, <?php echo $ps['p_id'] ?>)" class="form-check-input" type="radio" name="social_links" id="social_links1" value="1" <?php if($ps['social_links'] == 1) { echo 'checked="checked"';} ?> required="required" />
     <label class="form-check-label" for="social_links1">Enable Social Media Features</label>
     </div>
     <div class="form-check">
     <input onclick="savePageSetting('social_links', 0, <?php echo $ps['p_id'] ?>)" class="form-check-input" type="radio" name="social_links" id="social_links0" value="0" <?php if($ps['social_links'] == 0) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="social_links0">Disable Social Media Features</label>
     </div>     
     <hr />
     
     <i id="psecurity_role" class="fas fa-check green-text prefix" style="display: none;"></i>     
     <b>Security</b>
     <small class="form-text text-muted mb-2">Setting a Security Level will limit who can view or edit the page. Administrators always have full access no matter the level.</small>
     <select class="mdb-select md-form mb-3 initialized" id="security_role" name="security_role" onchange="savePageSetting('security_role', this.value, <?php echo $ps['p_id'] ?>)">
     <option value="" disabled>Select a Level</option>
     <?php
     $rol = $db->query("SELECT * FROM tbl_security_roles WHERE role_status = 1");
     while($rl = $rol->fetch(PDO::FETCH_ASSOC)) {
          if($ps['security_role'] == $rl['s_id']) {
               echo '<option value="'. $rl['s_id'] .'" selected>'. $rl['role_name'] .'</option>';
          } else {
               echo '<option value="'. $rl['s_id'] .'">'. $rl['role_name'] .'</option>';
          }
     }
     ?>
     </select>
     <hr />
     
     <div class="md-form">
     <i id="pkeywords" class="fas fa-check green-text prefix" style="display: none"></i>
     <input onblur="savePageSetting('keywords', this.value, <?php echo $ps['p_id'] ?>)" type="text" id="keywords" name="keywords" class="form-control" placeholder="Separate with commas" value="<?php echo $ps['keywords'] ?>" />
     <label class="active" for="keywords">SEO Keywords</label>
     </div>
     
     <div class="md-form">
     <i id="pdescription" class="fas fa-check green-text prefix" style="display: none"></i>     
     <input onblur="savePageSetting('description', this.value, <?php echo $ps['p_id'] ?>)" type="text" name="description" id="description" placeholder="Brief, 1-sentence description of the page" value="<?php echo $ps['description'] ?>" class="form-control" />
     <label class="active" for="description">SEO Description</label>
     </div><br />
     
     <i id="ppage_image" class="fas fa-check green-text prefix" style="display: none;"></i>     
     <b>Social Media Image</b> 
     <small class="form-text text-muted mb-2">For SEO and Social Media sharing</small>
     <div class="file-upload-wrapper">
     <input type="file" id="page_image" name="page_image" class="pfileUpload" accept="image/*" data-show-remove="true" data-default-file="<?php echo $gbl['site_url'] ?>/ast/res/<?php echo $ps['page_image'] ?>" />
     </div>
     <div style="clear:both"></div>
   
     <?php
}

if(isset($_POST['upload_image'])) {
     if(isset($_FILES['jfile'])) {
          $tempfile = $_FILES['jfile']['tmp_name'];
          $filename = $_FILES['jfile']['name'];
          $location = $gbl['doc_root'] .'ast/landings/';         
     }
     if(isset($_FILES['pfile'])) {
          $tempfile = $_FILES['pfile']['tmp_name'];
          $filename = $_FILES['pfile']['name'];
          $location = $gbl['doc_root'] .'ast/res/';         
     }
     $uploadOk = 1;
     $imageFileType = pathinfo($filename, PATHINFO_EXTENSION);
     $valid_extensions = array("jpg", "jpeg", "png");
     if(!in_array(strtolower($imageFileType), $valid_extensions)) {
          $uploadOk = 0;
     }
     $filename = date('Ymdhis'). rand(0,4) .'.'. $imageFileType;
     
     if($uploadOk == 0) {
          echo 0;
     } else {
          if(move_uploaded_file($tempfile, $location . $filename)) {
               $db->exec("UPDATE tbl_pages SET `$_POST[field]` = '$filename' WHERE p_id = $_POST[pageid]");
          } else {
               echo 0;
          }
     }
}
if(isset($_POST['delete_jumbo'])) {
    $db->exec("UPDATE tbl_pages SET jumbotron_image = NULL WHERE p_id = $_POST[pid]");
}
if(isset($_POST['delete_pimage'])) {
     $db->exec("UPDATE tbl_pages SET page_image = NULL WHERE p_id = $_POST[pid]");
}