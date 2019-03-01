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
$asql = $db->query("SELECT a_id, a_menu_name, a_menu_link, a_menu_url, a_menu_target, a_icon, a_security_role FROM tbl_admin_pages WHERE a_parent_id = 0 AND a_menu_type = 2 AND a_menu_status = 3 ORDER BY a_menu_order");
while($am1 = $asql->fetch(PDO::FETCH_ASSOC)) {
     if($_SESSION['user']['security'] >= $am1['a_security_role']) {
          ?>
          <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-chevron-right"></i> <?php echo $am1['a_menu_name'] ?><i class="fas fa-angle-down rotate-icon"></i></a>
          <div class="collapsible-body">
          <ul class="list-unstyled">                    
          <?php
          $asql2 = $db->query("SELECT a_id, a_menu_name, a_menu_link, a_menu_url, a_menu_target, a_icon, a_security_role FROM tbl_admin_pages WHERE a_parent_id = $am1[p_id] AND a_menu_type = 2 AND a_menu_status = 3 ORDER BY a_menu_order");
          while($am2 = $asql2->fetch(PDO::FETCH_ASSOC)) {
               if($_SESSION['user']['security'] >= $am2['a_security_role']) {
                    $amenuname = $am2['a_menu_name'];
                    if($am2['a_menu_url'] == 'aaa') {
                         $url = $am2['a_menu_url'];
                    } else {
                         if($am2['a_menu_link'] == 'edit-page') {
                              $url = "Admin/". $am2['a_menu_link'] ."/&p_id=$pg[p_id]";
                         } else {
                              $url = "Admin/". $am2['a_menu_link'];
                         }
                    }
                    $target = $am2['a_menu_target'];
                    ?>
                    <li>
                    <a class="waves-effect" href="<?php echo $url ?>" target="<?php echo $target ?>"><span class="fas fa-<?php echo $am2['a_icon'] ?>"></span> <?php echo $amenuname ?></a>
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
