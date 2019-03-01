<?php
$lsql = $db->query("SELECT * FROM $_SESSION[prefix]_logos WHERE logo_status = 1");
$logo = $lsql->fetch(PDO::FETCH_ASSOC);
?>
<script>
function deleteLogo(logoid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/js/ajax_settings.php',
          type: 'POST',
          data: {
               'deletelogo': '1',
               'logoid': logoid
          },
          success: function(data) {
               reloadMe(3);
          }
     });      
}
</script>
<div class="col-xs-6">
<div class="well well-sm">
<h4>Active Logo</h4>
<img src="../ast/site/<?php echo $logo['logo_file'] ?>" id="curlogo" width="<?php echo $logo['logo_width'] ?>" height="<?php echo $logo['logo_height'] ?>" />
</div>
</div>

<div class="col-xs-6">
<div class="well well-sm" id="logos3">
<h4>Available Logos</h4>
<p class="help-block">Click the logo to make it active.</p>
<?php
$asql = $db->query("SELECT * FROM $_SESSION[prefix]_logos ORDER BY l_id");
while($alg = $asql->fetch(PDO::FETCH_ASSOC)) {
     if($alg['logo_status'] == 1) {
          $style = ' style="border: 2px solid red;" ';
     } else {
          $style = ' ';
     }
     ?>
     <img<?php echo $style ?> onclick="submitForm('alogo', 3, <?php echo $alg['l_id'] ?>); document.getElementById('curlogo').src = '<?php echo $gbl['site_url'] ?>/ast/site/<?php echo $alg['logo_file'] ?>'; reloadMe(3);" src="../ast/site/<?php echo $alg['logo_file'] ?>" width="<?php echo $alg['logo_width'] ?>" height="<?php echo $alg['logo_height'] ?>" />
     <?php
     if($alg['logo_status'] == 0) {
          ?>
          <button type="button" class="btn btn-warning" onclick="deleteLogo(<?php echo $alg['l_id'] ?>)"><i class="glyphicon glyphicon-delete"></i> Delete</button>
          <?php
     }
     ?><br /><br />
     <?php
}
?>
</div>
</div>

<div class="col-xs-6">
<div class="well well-sm">
<h4>Upload Logos</h4>
<div id="fileuploader">Upload</div>
<p class="help-block">The Site Logo should be as close to 390px wide by 90px high.</p>
</div>
</div>
<script>
$(document).ready(function()
{
	$("#fileuploader").uploadFile({
          url:"<?php echo $gbl['site_url'] ?>/js/ajax_settings.php",
          multiple:true,
          dragDrop:true,
          fileName:"logo_image",
          acceptFiles:"image/*",
          showPreview:true,
          previewHeight: "90px",
          previewWidth: "390px"
	});
});
</script>
