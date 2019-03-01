
<footer class="footer page-footer text-center text-md-left pt-4 mt-1 fadeIn footer-custom" id="footBack">
<div class="container-fluid">
<div class="row">

<?php
$f = 1;
$sch = $db->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = 'tbl_layout' AND COLUMN_NAME LIKE 'footer_content_%' ORDER BY COLUMN_NAME ASC");
$c = $sch->rowCount();
$n = 12 / $c;
while($sc = $sch->fetch(PDO::FETCH_ASSOC)) {
     if($f <= $l['footer_columns']) {
          $ftr = $db->query("SELECT `$sc[COLUMN_NAME]` AS footer FROM tbl_layout WHERE l_id = 1");
          $ft = $ftr->fetch(PDO::FETCH_ASSOC);
          ?>
     
          <div class="col-md-<?php echo ceil($n) ?> mx-auto" id="f<?php echo $f ?>">
          <?php echo stripslashes($ft['footer']) ?>
          </div>
          <hr class="w-100 clearfix d-md-none" />
          
          <?php
          $f++;
     }
}
?>

</div>

</div>
<div class="call-to-action text-center my-4" id="ecta">
<hr />
<ul class="list-unstyled list-inline">
<li class="list-inline-item"><h6>Subscribe to our Newsletter!</h6></li>
<li class="list-inline-item"><a href="<?php echo $gbl['site_url'] ?>/Subscribe" class="btn btn-primary">Sign up!</a></li>
</ul>
</div>

<div class="social-section text-center" id="esoc">
<hr />
<ul class="list-unstyled list-inline">
<?php
$subs = $db->query("SELECT show_subscribe FROM tbl_sharing WHERE sh = 1");
$su = $subs->fetch(PDO::FETCH_ASSOC);
?>
<li class="list-inline-item" <?php if($su['show_subscribe'] == 1) { echo 'style="display: inline"';} else { echo 'style="display: none"';} ?> id="subbtn"><a class="btn-floating btn-cyan" target="_self" href="<?php echo $gbl['site_url'] ?>/Subscribe"><i class="fa fa-envelope"></i></a></li>
          
<?php
$socs = $db->query("SELECT COLUMN_NAME AS scolumn FROM information_schema.COLUMNS WHERE TABLE_NAME = 'tbl_sharing' AND COLUMN_NAME LIKE '%_id' ORDER BY COLUMN_NAME");
while($so = $socs->fetch(PDO::FETCH_ASSOC)) {
     $socl = $db->query("SELECT `$so[scolumn]` AS link FROM tbl_sharing WHERE `$so[scolumn]` > ''");
     $sl = $socl->fetch(PDO::FETCH_ASSOC);
     $link = $sl['link'];
     if($link > '') {
          $icon = substr($so['scolumn'], 0, -3);
          switch($icon) {
               case 'facebook':
                    $color = 'btn-fb';
                    break;
               case 'twitter':
                    $color = 'btn-tw';
                    break;
               case 'instagram':
                    $color = 'btn-ins';
                    break;
               case 'linkedin':
                    $color = 'btn-li';
                    break;
               case 'google-plus':
                    $color = 'btn-gplus';
                    break;
               case 'tumblr':
                    $color = 'btn-unique';
                    break;
               case 'flipboard':
                    $color = 'btn-dribble';
                    break;
               case 'yammer':
                    $color = 'btn-vk';
                    break;
               case 'reddit':
                    $color = 'btn-reddit';
                    break;
               default:
                    break;
          }
          ?>
          <li class="list-inline-item" id="<?php echo $so['scolumn'] ?>"><a class="btn-floating <?php echo $color ?>" target="_blank" href="<?php echo $link ?>"><i class="fab fa-<?php echo $icon ?>"></i></a></li>
          
          <?php
     }
}
$lcms = $db->query("SELECT show_lcms FROM tbl_sharing WHERE sh = 1");
$lc = $lcms->fetch(PDO::FETCH_ASSOC);
?>
<li class="list-inline-item" id="lcmsbtn" <?php if($lc['show_lcms'] == 1) { echo 'style="display: inline"';} else { echo 'style="display: none"';} ?>><a class="btn-floating btn-indigo" target="_blank" href="https://www.lcms.org"><i class="fas fa-arrows-alt"></i></a></li>
</ul>
</div>

<div class="footer-copyright text-center py-3">
<?php echo $gbl['copyright'] ?>. All Rights Reserved.<br />
Design by <a href="https://www.luthersites.net">Luthersites&#0153;</a>.
</div>
</footer>

<?php
if($pg['social_links'] == 1) {
     $shr = $db->query("SELECT sharing_api FROM tbl_sharing WHERE sharing_status = 1");
     $sh = $shr->fetch(PDO::FETCH_ASSOC);
     echo $sh['sharing_api'];
}
?>

