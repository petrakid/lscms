<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
?>

<div id="slide-out" class="side-nav side-nav-custom">
<ul class="custom-scrollbar">

<li class="logo-sn d-block waves-effect" style="background-color: white; height: 100px;">
<div class="text-center">
<a class="pl-0" href="<?php echo $gbl['site_url'] ?>"><img class="img-fluid" style="height: 100%" src="<?php echo $gbl['site_url'] ?>/ast/site/logo.png" alt="Logo" /><br />
<?php echo $gbl['site_name'] ?></a>
</div>
</li>
<li>
<ul class="collapsible collapsible-accordion">
<?php
$bsql = $db->query("SELECT p_id, menu_name, menu_link, menu_url, menu_target, glyphicon, security_role FROM tbl_admin_pages WHERE parent_id = 0 AND menu_type = 2 AND menu_status = 3 ORDER BY menu_order");
while($bm1 = $bsql->fetch(PDO::FETCH_ASSOC)) {
     if($_SESSION['user']['security'] >= $bm1['security_role']) {
          ?>
          <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-chevron-right"></i> <?php echo $bm1['menu_name'] ?><i class="fas fa-angle-down rotate-icon"></i></a>
          <div class="collapsible-body">
          <ul class="list-unstyled">                    
          <?php
          $bsql2 = $db->query("SELECT p_id, menu_name, menu_link, menu_url, menu_target, glyphicon, security_role FROM tbl_admin_pages WHERE parent_id = $bm1[p_id] AND menu_type = 2 AND menu_status = 3 ORDER BY menu_order");
          while($bm2 = $bsql2->fetch(PDO::FETCH_ASSOC)) {
               if($_SESSION['user']['security'] >= $bm2['security_role']) {
                    $aamenuname = $bm2['menu_name'];
                    if($bm2['menu_url'] == 'aaa') {
                         $url = $bm2['menu_url'];
                    } else {
                         if($bm2['menu_link'] == 'edit-page') {
                              $url = "Admin/". $bm2['menu_link'] ."/&p=$pg[p_id]";
                         } else {
                              $url = "Admin/". $bm2['menu_link'];
                         }
                    }
                    $atarget = $bm2['menu_target'];
                    ?>
                    <li>
                    <a class="waves-effect" href="<?php echo $url ?>" target="<?php echo $atarget ?>"><span class="fas fa-<?php echo $bm2['glyphicon'] ?>"></span> <?php echo $aamenuname ?></a>
                    </li>
                    <?php
               }
          }
          ?>
          </ul>
          </div>
          </li>
          <?php
     }
}
?>
</li>
</ul>
</ul>
</div>

<div class="sidenav-bg mask-strong"></div>
