<?php
if($pg['menu_status'] == 3 && !isset($_SESSION['isLoggedIn'])) {
     die;
}
$sqlr = $db->query("SELECT * FROM tbl_blocks WHERE page_id = '$pg[p_id]' AND block_status = 1 ORDER BY grid_order ASC");
?>
<main>
<div class="container-fluid fill">
<?php
if($pg['jumbotron_image'] > '' || $pg['jumbotron_url'] > '') {
     ?>
     <div class="jumbotron p-0" id="landingimg">
     <div class="view overlay rounded-top">
     <img src="<?php if($pg['jumbotron_url'] > '') { echo $pg['jumbotron_url']; } else { echo $gbl['site_url'] ?>/ast/landings/<?php echo $pg['jumbotron_image']; } ?>" class="img-fluid" alt="" width="100%" />
     <a href="javascript:void(0)">
     <div class="mask rgba-white-slight"></div>
     </a>
     </div>
     </div>
     
     <?php
}
if($pg['menu_url'] > '') {
     if($pg['menu_target'] == '_top' || $pg['menu_target'] == '_blank') {
          ?>
          <section class="mt-1 wow fadeIn">
          <div class="row">
          <div class="col">
          <div class="card">
          <div class="card-header card-header-custom">Popup Warning</div>
          <div class="card-body">
          <h5 class="h5 mb-2">Please wait.  Your popup blocker may need to allow this site to load new windows or tabs.  Disable your popup blocker and reload this page.</h5>
          </div>
          </div>
          </div>
          </div>
          </section>
          <?php
          $string = '';
          if(isset($_GET)) {
               foreach($_GET AS $var => $val) {
                    switch($var) {
                         case 'p_id':
                              $string .= "?p_id=$val";
                              break;
                         default:
                              break;
                    }
               }
               $fwdurl = $pg['menu_url'] . $string;
          } else {
               $fwdurl = $pg['menu_url'];
          }
          ?>
          <script>
          url = '<?php echo $fwdurl ?>';
          setTimeout(function(){window.open(url, 'New Window')}, 1500);     
          </script>
          <?php
     } else {
          ?>
          <section class="mt-1 wow fadeIn">
          <div class="row">
          <div class="col-12">
          <div class="card">
          <div class="card-body">          
          <?php
          include($gbl['doc_root'] . $pg['menu_url']);
          ?>
          </div>
          </div>
          </div>
          </div>
          </div>
          <?php
     }
} elseif($sqlr->rowCount() == 0) {
     ?>
     <section class="mt-1 wow fadeIn">
     <div class="row">
     
     <?php   
     if($pg['menu_link'] == 'log-out') {
          ?>
          <script>
          $(function() {
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/js/ajax_login.php',
                    type: 'POST',
                    data: {
                         'logout_user':true,
                    },
                    success: function(data) {
                         window.location.href = "<?php echo $gbl['site_url'] ?>";
                    }
               }); 
          });
          </script>
          <?php
          die;
     } elseif($pg['parent_id'] != 0) {
          ?>
          <div class="col-3">
          <div class="card">
          <div class="card-header card-header-custom">Pages</div>
          <div class="card-body">
          <p>Child Menus for <?php echo $pg['menu_name'] ?></p>
          <ul>
          <?php
          $lst = $db->query("SELECT menu_name, menu_link, p_id FROM tbl_pages WHERE parent_id = $pg[p_id] AND (menu_status != 0 AND menu_status != 0) ORDER BY menu_order ASC");
          while($ls = $lst->fetch(PDO::FETCH_ASSOC)) {
               echo '<li><a href="'. $gbl['site_url'] .'/'. $pg['menu_link'] .'/'. $ls['menu_link'] .'">'. $ls['menu_name'] .'</a></li>';
          }
          ?>
          </ul>
          </div>
          </div>
          </div>
          <?php
     } elseif(isset($_SESSION['isLoggedIn']) && $pg['menu_url'] == '') {
          ?>
          <div class="col">
          <div class="card">
          <div class="card-header card-header-custom">No Content</div>
          <div clas="card-body">
          <a href="<?php echo $gbl['site_url'] .'/sct/editor.php?p_id='. $pg['p_id'] ?>" target="_blank">
          <button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Add Content</button></a> 
          </div>
          </div>
          </div>
          
          <?php
     } else {
          // nothing else to do
     }
     ?>
     </div>
     </section>
     
     <?php          
} else {
     ?>
     <section class="mt-1 wow fadeIn">
     <div class="row">
     <?php
     $totalblock = 0;
     while($row = $sqlr->fetch(PDO::FETCH_ASSOC)) {
          $showblock = 1;
          if($row['scheduled'] == 1) {
               if(new DateTime() <= new DateTime($row['start_datetime'])) {
                    $showblock = 0;
               }
               elseif(new DateTime() >= new DateTime($row['end_datetime'])) {
                    $showblock = 0;
               } else {
                    $showblock = 1;
               }
          }
          if($showblock == 1) {
               $totalblock = $totalblock + $row['grid_width'];
               if($totalblock > 12) {
                    echo '</div></section><section class="mt-2 wow fadeIn"><div class="row">'."\n";
                    $totalblock = 0;
               }
               ?>
               <div class="col-md-<?php echo $row['grid_width'] ?> col-md-offset-<?php echo $row['grid_offset'] ?> <?php if($row['edge_padding'] == 0) { echo 'no-padding'; } ?>">
               <div class="card <?php if($row['transparent'] == 1) { echo 'card-transparent'; } ?>">
               <?php
               if($row['show_header'] == 1) {
                    ?>
                    <div class="card-header card-header-custom"><?php echo $row['block_header'] ?></div>
                    <?php
               }
               ?>
               <div class="card-body">
               <?php
               if($row['block_link'] > 0) {
                    $sqll = $db->query("SELECT block_content FROM tbl_blocks WHERE b_id = $row[block_link]");
                    $lnk = $sqll->fetch(PDO::FETCH_ASSOC);
                    echo stripslashes($lnk['block_content']);
               }
               elseif(strpos($row['block_content'], '[addin-')) {
                    $addin = getAddin($row['block_content']);
                    $q = explode(",", $addin);
                    include 'plg/'. $q[0] .'/'. $q[0] .'.plg.php';
               } else {
                    ?>
                    <div data-editable data-name="block_<?php echo $row['b_id'] ?>">
                    <?php echo stripslashes($row['block_content']) ?>
                    </div>
                    
                    <?php
               }
               if($row['block_plugin'] > '') {
                    include 'plg/'. strtok($row['block_plugin'], '.') .'/'. $row['block_plugin'].'.plg.php';
               }
               ?>
               </div>
               </div>
               </div>
               <?php
               unset($showblock);
          }
     }
     ?>
     </div>
     </section>
     <?php
}
?>

<section class="mt-2 wow fadeIn">
<hr />
<div class="row">
<div class="col-md-12">
<nav aria-label="breadcrumb" class="navbar mb-2 breadcrumbbar breadcrumb-custom">
<ol class="breadcrumb" id="breadcrumbss" <?php if($l['breadcrumbs'] == 0) { echo 'style="display:none;"'; } else { echo 'style="display:inherit;"';} ?>>
     
<?php
$bc = $_SERVER['REQUEST_URI'];
$spl = trim($bc, "/");
$bc = explode("/", $spl);
if(!isset($bc[0]) || $bc[0] == '') {
     echo '<li class="breadcrumb-item"><a href="Home">Home</a></li>';
     $_SESSION['breadcrumb'] = 'Home';
}
if(isset($bc[0]) && $bc[0] > '') {
     echo '<li class="breadcrumb-item"><a href="'. $bc[0] .'">'. urldecode($bc[0]) .'</a></li>';
     $_SESSION['breadcrumb'] = urldecode($bc[0]);          
}
if(isset($bc[1]) && $bc[1] > '') {
     echo '<li class="breadcrumb-item"><a href="'. $bc[0] .'/'. $bc[1] .'">'. urldecode($bc[1]) .'</a></li>';
     $_SESSION['breadcrumb'] = urldecode($bc[1]);          
}
?>
</ol>

<script>var pfHeaderImgUrl = '';var pfHeaderTagline = '';var pfdisableClickToDel = 0;var pfHideImages = 0;var pfImageDisplayStyle = 'right';var pfDisablePDF = 0;var pfDisableEmail = 0;var pfDisablePrint = 0;var pfCustomCSS = '';var pfBtVersion='1';(function(){var js, pf;pf = document.createElement('script');pf.type = 'text/javascript';if ('https:' === document.location.protocol){js='https://pf-cdn.printfriendly.com/ssl/main.js'}else{js='http://cdn.printfriendly.com/printfriendly.js'}pf.src=js;document.getElementsByTagName('head')[0].appendChild(pf)})();</script>
<span class="navbar-text" id="printfriendly" <?php if($l['print_friendly'] == 1) { echo 'style="display:inline;"'; } else { echo 'style="display:none;"';} ?>>
<a href="https://www.printfriendly.com" style="color:#6D9F00;text-decoration:none;" class="printfriendly" onclick="window.print();return false;" title="Printer Friendly and PDF"><img style="border:none;-webkit-box-shadow:none;box-shadow:none;" src="https://cdn.printfriendly.com/buttons/printfriendly-pdf-button-nobg-md.png" alt="Print Friendly and PDF"/></a>
</span>
</nav>

</div>
</div>
</section>

</div>
</main>
