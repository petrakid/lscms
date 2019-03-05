<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>

<title><?php echo $pg['page_title'] ?></title>

<?php
$meta = $db->query("SELECT * FROM tbl_meta_tags WHERE meta_tag_status = 1 ORDER BY meta_tag_order");
while($mt = $meta->fetch(PDO::FETCH_ASSOC)) {
     echo $mt['meta_tag'] ."\r\n";
}
echo "\r\n";
$meta2 = $db->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = 'tbl_seo' AND COLUMN_NAME LIKE '%_id' ORDER BY COLUMN_NAME");
while($m2 = $meta2->fetch(PDO::FETCH_ASSOC)) {
     $mt2 = $db->query("SELECT `$m2[COLUMN_NAME]` AS metaseo FROM tbl_seo WHERE seo = 1");
     $m = $mt2->fetch(PDO::FETCH_ASSOC);
     echo $m['metaseo'] ."\n";
}
echo "\r\n";

if(isset($pg['plugin']) && $pg['plugin'] == 'Sermon Manager') {
     if(isset($_GET['selected_id'])) {
          $s = $db->query("SELECT * FROM tbl_sermons WHERE s_id = $_GET[selected_id]");
          $m = $s->fetch(PDO::FETCH_ASSOC);
          ?>
          
<meta property="og:url" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" />
<meta property="og:image" content="<?php echo $gbl['site_url'] .'/ast/sermons/'. $m['sermon_image'] ?>" />
<meta property="og:description" content="<?php echo $m['sermon_desc'] ?>" />
<meta property="og:title" content="<?php echo $m['sermon_title'] ?>" />
<meta property="og:site_name" content="<?php echo $gbl['site_name'] ?>" />
<meta property="og:see_also" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" />
<meta property="og:type" content="article" />

<meta name="twitter:card" content="summary" />
<meta name="twitter:url" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" />
<meta name="twitter:title" content="<?php echo $m['sermon_title'] ?>" />
<meta name="twitter:description" content="<?php echo $m['sermon_desc'] ?>" />
<meta name="twitter:image" content="<?php echo $gbl['site_url'] .'/ast/sermons/'. $m['sermon_image'] ?>" />                    

<meta itemprop="name" content="<?php echo $m['sermon_title'] ?>" />
<meta itemprop="description" content="<?php echo $m['sermon_desc'] ?>" />
<meta itemprop="image" content="<?php echo $gbl['site_url'] .'/ast/sermons/'. $m['sermon_image'] ?>" />
           
          <?php
     }
}
else if(isset($pg['plugin']) && $pg['plugin'] == 'calendars') {
     if(isset($_GET['eventid'])) {
          $s = $db->query("SELECT * FROM tbl_calendars_events WHERE e_id = $_GET[eventid]");
          $m = $s->fetch(PDO::FETCH_ASSOC);
          ?>
          
<meta property="og:url" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" />
<meta property="og:image" content="<?php echo $gbl['site_url'] .'/ast/res/'. $m['event_image'] ?>" />
<meta property="og:description" content="<?php echo $m['event_subtitle'] ?>" />
<meta property="og:title" content="<?php echo $m['event_title'] ?>" />
<meta property="og:site_name" content="<?php echo $gbl['site_name'] ?>" />
<meta property="og:see_also" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" />
<meta property="og:type" content="article" />

<meta name="twitter:card" content="summary" />
<meta name="twitter:url" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" />
<meta name="twitter:title" content="<?php echo $m['event_title'] ?>" />
<meta name="twitter:description" content="<?php echo $m['event_subtitle'] ?>" />
<meta name="twitter:image" content="<?php echo $gbl['site_url'] .'/ast/res/'. $m['event_image'] ?>" />                    

<meta itemprop="name" content="<?php echo $m['event_title'] ?>" />
<meta itemprop="description" content="<?php echo $m['event_subtitle'] ?>" />
<meta itemprop="image" content="<?php echo $gbl['site_url'] .'/ast/res/'. $m['event_image'] ?>" />
           
          <?php
     }     
} else {
     ?>
     
<meta name="image" content="<?php echo $gbl['site_url'] ?>/ast/res/<?php echo $pg['page_image'] ?>" />
<meta name="description" content="<?php echo $pg['description'] ?>" />
<meta name="keywords" content="<?php echo $pg['keywords'] ?>" />          
<link href="<?php echo $gbl['site_url'] ?>/<?php echo $_SESSION['fullpage'] ?>" rel="canonical" />

<meta property="og:url" content="<?php echo $gbl['site_url'] ?>/<?php echo $_SESSION['fullpage'] ?>" />
<meta property="og:image" content="<?php echo $gbl['site_url'] ?>/ast/res/<?php echo $pg['page_image'] ?>" />
<meta property="og:description" content="<?php echo $pg['description'] ?>" />
<meta property="og:title" content="<?php echo $pg['page_title'] ?>" />
<meta property="og:site_name" content="<?php echo $gbl['site_name'] ?>" />
<meta property="og:see_also" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" />
<meta property="og:type" content="article" />

<meta name="twitter:card" content="summary" />
<meta name="twitter:url" content="<?php echo $gbl['site_url'] ?>/<?php echo $_SESSION['fullpage'] ?>" />
<meta name="twitter:title" content="<?php echo $pg['page_title'] ?>" />
<meta name="twitter:description" content="<?php echo $pg['description'] ?>" />
<meta name="twitter:image" content="<?php echo $gbl['site_url'] ?>/ast/res/<?php echo $pg['page_image'] ?>" />                    

<meta itemprop="name" content="<?php echo $pg['page_title'] ?>" />
<meta itemprop="description" content="<?php echo $pg['description'] ?>" />
<meta itemprop="image" content="<?php echo $gbl['site_url'] ?>/ast/res/<?php echo $pg['page_image'] ?>" />     
     
     <?php
}
$layout = $db->query("SELECT * FROM tbl_layout WHERE l_id = 1");
$l = $layout->fetch(PDO::FETCH_ASSOC);

echo "\n\n<!-- Stylesheets loaded from CDN-->\n";

$csss = $db->query("SELECT cdn_script FROM tbl_cdns WHERE cdn_location = 1 ORDER BY cdn_order");
while($css = $csss->fetch(PDO::FETCH_ASSOC)) {
     echo $css['cdn_script'] ."\r\n";
}
echo "\r\n";

if(isset($_SESSION['isLoggedIn'] )) {
     $cssa = $db->query("SELECT cdn_script FROM tbl_cdns WHERE cdn_location = 2 ORDER BY cdn_order");
     while($csa = $cssa->fetch(PDO::FETCH_ASSOC)) {
          echo $csa['cdn_script'] ."\r\n";
     }     
}
echo "\r\n";

$sctj = $db->query("SELECT cdn_script FROM tbl_cdns WHERE cdn_location = 3 ORDER BY cdn_order");
while($scj = $sctj->fetch(PDO::FETCH_ASSOC)) {
     echo $scj['cdn_script'] ."\n";
}
echo "\r\n";

if(isset($_SESSION['isLoggedIn'])) {
     $scta = $db->query("SELECT cdn_script FROM tbl_cdns WHERE cdn_location = 4 ORDER BY cdn_order");
     while($sca = $scta->fetch(PDO::FETCH_ASSOC)) {
          echo $sca['cdn_script'] ."\n";
     }
}
echo "\r\n";
$tsm = $db->query("SELECT * FROM tbl_toast_messages WHERE m_status = 1 AND m_pageid = $pg[p_id]");
if($tsm->rowCount() > 0) {
     $tm = $tsm->fetch(PDO::FETCH_ASSOC);
     $tst = $db->query("SELECT * FROM tbl_toast_options WHERE t_id = 1");
     $today = date('Y/m/d');
     $today = date('Y/m/d', strtotime($today));
     $start = date('Y/m/d', strtotime($tm['m_start']));
     $stop  = date('Y/m/d', strtotime($tm['m_stop']));
     if(($today >= $start) && ($today <= $stop)) {
          $ts = $tst->fetch(PDO::FETCH_ASSOC);
          ?>
          <script>
          $(function() {
               toastr.options = {
                    "closeButton": <?php echo $ts['toast_close_button'] ?>,
                    "debug": <?php echo $ts['toast_debug'] ?>,
                    "newestOnTop": <?php echo $ts['toast_new_top'] ?>,
                    "progressBar": <?php echo $ts['toast_prog_bar'] ?>,
                    "positionClass": "<?php echo $tm['m_location'] ?>",
                    "preventDuplicates": <?php echo $ts['toast_prev_dups'] ?>,
                    <?php
                    if($ts['toast_onclick'] > '') {
                         ?>
                         "onclick": "<?php echo $ts['toast_onclick'] ?>",
                         <?php
                    } else {
                         ?>
                         "onclick": null,
                         <?php     
                    }
                    ?>
                    
                    "showDuration": <?php echo $ts['toast_show_dur'] ?>,
                    "hideDuration": <?php echo $ts['toast_hide_dur'] ?>,
                    "timeOut": <?php echo $ts['toast_timeout'] ?>,
                    "extendedTimeOut": <?php echo $ts['toast_ext_timeout'] ?>,
                    "showEasing": "<?php echo $ts['toast_show_eas'] ?>",
                    "hideEasing": "<?php echo $ts['toast_hide_eas'] ?>",
                    "showMethod": "<?php echo $ts['toast_show_meth'] ?>",
                    "hideMethod": "<?php echo $ts['toast_hide_meth'] ?>"
               }
               toastr.<?php echo $tm['m_color'] ?>("<?php echo addslashes($tm['m_message']) ?>", "<?php echo $tm['m_title'] ?>");          
          });
          </script>
          
          <?php
     }
}
$head = 1;
include 'plg/analytics/analytics.plg.php';
?>

</head>

<body id="pageBack" class="primary <?php echo $l['layout_skin'] ?> body-main <?php if($l['background_fixed'] == 1) { echo 'background-fixed'; } ?> body-custom">

<input type="hidden" id="pageid" value="" />
<header>
