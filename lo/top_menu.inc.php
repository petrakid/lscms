
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
     $sql = $db->query("SELECT p_id, menu_name, menu_link, menu_url, menu_status, menu_target FROM tbl_pages WHERE menu_type = 1 AND menu_status <= 2 AND parent_id = 0 ORDER BY menu_order ASC");          
} else {
     $sql = $db->query("SELECT p_id, menu_name, menu_link, menu_url, menu_status, menu_target FROM tbl_pages WHERE menu_type = 1 AND menu_status = 1 AND parent_id = 0 ORDER BY menu_order ASC");
}
while($tmn = $sql->fetch(PDO::FETCH_ASSOC)) {
     $tmenuname = stripslashes($tmn['menu_name']);
     if(isset($_SESSION['isLoggedIn'])) {
          $sql2 = $db->query("SELECT p_id, menu_name, menu_link, menu_url, menu_status, menu_target FROM tbl_pages WHERE menu_status <= 2 AND parent_id = $tmn[p_id] ORDER BY menu_order ASC");
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
