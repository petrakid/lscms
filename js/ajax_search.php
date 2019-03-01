<?php
session_start();

include '../ld/db.inc.php';
include '../ld/globals.inc.php';

if(!isset($_POST['site_search'])) {
     die;
}
$keyword = $_POST['string'];
$pages = $db->query("SELECT p_id, menu_name, menu_link, menu_status, menu_type, page_image FROM tbl_pages WHERE (find_in_set('$keyword', keywords) > 0) AND menu_status = 1 AND menu_type = 1 ORDER BY menu_name");
if($pages->rowCount() > 0) {
     while($pres = $pages->fetch(PDO::FETCH_ASSOC)) {
          if($pres['menu_status'] == 1 && $pres['menu_type'] == 1) {
               echo '<p><h5 class="h5 mb-1" style="text-decoration: underline"><a href="'. $gbl['site_url'] .'/'. $pres['menu_link'] .'"><img src="'. $gbl['site_url'] .'/ast/res/'. $pres['page_image'] .'" class="thumbnail float-left mr-2" width="60" alt=" " />'. stripslashes($pres['menu_name']) .'</a></h5></p><div class="clearfix"></div>';
          }
     }
}

$content = $db->query("SELECT page_id, block_content FROM tbl_blocks WHERE block_status = 1 AND block_content LIKE '%". $keyword ."%' ORDER BY b_id");
if($content->rowCount() > 0) {
     while($cont = $content->fetch(PDO::FETCH_ASSOC)) {
          $link = strip_tags($cont['block_content']);
          $link = mb_strimwidth($link, 0, 150, '...');
          $sel = $db->query("SELECT menu_name, menu_link, menu_status, menu_type, page_image FROM tbl_pages WHERE p_id = $cont[page_id]");
          $sl = $sel->fetch(PDO::FETCH_ASSOC);
          if($sl['menu_status'] == 1 && $sl['menu_type'] == 1) {
               echo '<p><a href="'. $gbl['site_url'] .'/'. $sl['menu_link'] .'"><h5 class="h5 mb-1" style="text-decoration: underline"><img src="'. $gbl['site_url'] .'/ast/res/'. $sl['page_image'] .'" class="thumbnail float-left mr-2" width="60" alt=" " />'. stripslashes($sl['menu_name']) .'</h5><small class="text-muted">'. stripslashes($link) .'</small></a></p><div class="clearfix"></div>';
          }
     }
}

$sermons = $db->query("SELECT s_id, sermon_title, sermon_desc FROM tbl_sermons WHERE sermon_title LIKE '%". $keyword ."%' OR sermon_desc LIKE '%". $keyword ."%' OR sermon_scripture LIKE '%". $keyword ."%' AND sermon_status = 1 ORDER BY sermon_date DESC");
if($sermons->rowCount() > 0) {
     $res = 1;
     while($sm = $sermons->fetch(PDO::FETCH_ASSOC)) {
          echo '<p><a href="'. $gbl['site_url'] .'/resources/Sermon/&selected_id='. $sm['s_id'] .'"><h5 class="h5 mb-1" style="text-decoration: underline">'. $sm['sermon_title'] .'</h5><small class="text-muted">'. $sm['sermon_desc'] .'</small></a></p>';
     }
}
?>