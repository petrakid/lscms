<body id="pageBack" class="primary <?php echo $l['layout_skin'] ?> body-main <?php if($l['background_fixed'] == 1) { echo 'background-fixed'; } ?> body-custom">

<input type="hidden" id="pageid" value="" />
<header>

<?php
if(isset($_SESSION['isLoggedIn'])) {
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
     $asql = $db->query("SELECT p_id, menu_name, menu_link, menu_url, menu_target, glyphicon, security_role FROM tbl_pages WHERE parent_id = 0 AND menu_type = 2 AND menu_status = 3 ORDER BY menu_order");
     while($am1 = $asql->fetch(PDO::FETCH_ASSOC)) {
          if($_SESSION['user']['security'] >= $am1['security_role']) {
               ?>
               <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-chevron-right"></i> <?php echo $am1['menu_name'] ?><i class="fas fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
               <ul class="list-unstyled">                    
               <?php
               $asql2 = $db->query("SELECT p_id, menu_name, menu_link, menu_url, menu_target, glyphicon, security_role FROM tbl_pages WHERE parent_id = $am1[p_id] AND menu_type = 2 AND menu_status = 3 ORDER BY menu_order");
               while($am2 = $asql2->fetch(PDO::FETCH_ASSOC)) {
                    if($_SESSION['user']['security'] >= $am2['security_role']) {
                         $amenuname = $am2['menu_name'];
                         if($am2['menu_url'] == 'aaa') {
                              $url = $am2['menu_url'];
                         } else {
                              if($am2['menu_link'] == 'edit-page') {
                                   $url = "Admin/". $am2['menu_link'] ."/&p_id=$pg[p_id]";
                              } else {
                                   $url = "Admin/". $am2['menu_link'];
                              }
                         }
                         $target = $am2['menu_target'];
                         ?>
                         <li>
                         <a class="waves-effect" href="<?php echo $url ?>" target="<?php echo $target ?>"><span class="fas fa-<?php echo $am2['glyphicon'] ?>"></span> <?php echo $amenuname ?></a>
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
     
     <?php
}
?>
<nav class="navbar <?php echo $l['menu_location'] ?> navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav navbar-main navbar-custom" id="mainNavigation" style="height: <?php echo $l['menu_height'] ?>px !important">

<?php
if(isset($_SESSION['isLoggedIn'])) {
     ?>
     <div class="float-left mr-2 order-first">
     <a href="#" data-activates="slide-out" class="init"><i class="fas fa-bars"></i></a>
     </div>
     
     <?php
} else {
     ?>
     <div class="float-left mr-2 order-first">
     <a href="#" data-toggle="modal" data-target="#login_Modal"><i class="fas fa-sign-in-alt"></i></a>
     </div>
     
     <?php
}
?>
<button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
<i class="fas fa-bars" style="color: white;"></i>
</button>
<div class="collapse navbar-collapse" id="mainNav">
<span id="navbrand" class="navbar-brand navbar-brand-custom ml-3"><?php echo $gbl['site_name'] ?></span>

<ul class="navbar-nav <?php echo $l['menu_alignment'] ?> navbar-nav-custom" id="mainNavmenu">
<?php
if(isset($_SESSION['isLoggedIn'])) {
     $sql = $db->query("SELECT p_id, menu_name, menu_link, menu_url, menu_status, menu_target FROM tbl_pages WHERE menu_type = 1 AND menu_status <= 3 AND menu_status != 0 AND parent_id = 0 ORDER BY menu_order ASC");          
} else {
     $sql = $db->query("SELECT p_id, menu_name, menu_link, menu_url, menu_status, menu_target FROM tbl_pages WHERE menu_type = 1 AND menu_status = 1 AND parent_id = 0 ORDER BY menu_order ASC");
}
while($tmn = $sql->fetch(PDO::FETCH_ASSOC)) {
     $tmenuname = stripslashes($tmn['menu_name']);
     if(isset($_SESSION['isLoggedIn'])) {
          $sql2 = $db->query("SELECT p_id, menu_name, menu_link, menu_url, menu_status, menu_target FROM tbl_pages WHERE menu_status <= 3 AND menu_status != 9 AND parent_id = $tmn[p_id] ORDER BY menu_order ASC");
     } else {
          $sql2 = $db->query("SELECT p_id, menu_name, menu_link, menu_url, menu_status, menu_target FROM tbl_pages WHERE parent_id = $tmn[p_id] AND menu_status = 1 ORDER BY menu_order ASC");
     }
     if($tmn['menu_link'] == $_GET['page']) {
          echo '<li class="nav-item"><a class="nav-link" href="'. $tmn['menu_link'] .'">'. $tmenuname .'</a></li>'."\n";
     }
     else if($sql2->rowCount() > 1) {
          echo '<li class="nav-item dropdown dropdown-custom"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" id="subMenu_'. $tmn['p_id'] .'" aria-haspopup="true">'. $tmenuname .' <span class="caret"></span></a>'."\n";
          echo '<div class="dropdown-menu dropdown-primary dropdown-menu-custom" aria-labelledby="subMenu_'. $tmn['p_id'] .'">'."\n";
          while($smn = $sql2->fetch(PDO::FETCH_ASSOC)) {
               $smenuname = stripslashes($smn['menu_name']);
               $childlink = $smn['menu_link'];
               echo '<a class="dropdown-item dropdown-item-custom" href="'. $tmn['menu_link'] .'/'. $childlink .'" target="'. $smn['menu_target'] .'">';
               if($smn['menu_status'] == 0) {
                    echo '<i class="fas fa-eye-slash"></i> ';
               }                    
               echo $smenuname .'</a>'."\n";
          }
          echo '</div>'."\n";
          echo '</li>'."\n";
     } else {
          echo '<li class="nav-item">';
          if($tmn['menu_status'] == 0) {
               echo '<span class="fa-li"><i class="fas fa-eye-slash"></i></span>';
          }
          if($tmn['menu_url'] == 'aaa') {
               echo '<a class="nav-link" href="'. $tmn['menu_url'] .'" target="'. $tmn['menu_target'] .'">'. $tmenuname .'</a>'."\n";
          } else {
               echo '<a class="nav-link" href="'. $tmn['menu_link'] .'" target="'. $tmn['menu_target'] .'">'. $tmenuname .'</a>'."\n";                    
          }
          echo '</li>'."\n";
     }
}
?>
     
</ul>     

<form class="form-inline active-cyan-4 ml-2" id="searchForm" <?php if($l['search_form'] == 0) { echo 'style="display: none"';} else { echo 'style="display: inline"';} ?>>
<input type="text" id="sitesearchtext" class="form-control form-control-sm mr-1 w-125" placeholder="Search" aria-label="Search" aria-describedby="basic-addon11" />
<i id="submit_img" class="fa fa-search ml-1" aria-hidden="true" style="cursor: pointer;"></i>
</form>
</div>

</nav>
