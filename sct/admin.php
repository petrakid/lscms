<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
?>

<div class="row">
<div class="col-lg-12">
<div class="panel-body">
<button type="button" onclick="closeWindow()" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-check"></i> Finish</button>
</div>
</div>
</div>
<div class="row">
<div class="col-xs-12">
<div class="panel">
<div class="panel-heading panel-heading-custom"><h3>Site Variables</h3></div>
<div class="panel-body">
<form name="varform" id="varform">
<table id="variables_table" class="table responsive table-bordered table-striped">
<thead>
<th>Setting</th>
<th>Value</th>
</thead>
<tbody>

<?php
$var = $db->query("SELECT * FROM tbl_globals WHERE id = 1");
while($va = $var->fetchAll(PDO::FETCH_ASSOC)) {
     $fld = current($va);
     foreach($fld AS $key => $val) {
          ?>
          <tr>
          <td>
          <?php echo $key ?>
          </td>
          <td>
          <?php
          if($key == 'id') {
               ?>
               <input class="form-control" type="text" disabled="disabled" name="<?php echo $key ?>" value="<?php echo htmlspecialchars($val) ?>" />
               <?php               
          }
          else if($key == 'popup_warning' || $key == 'site_slogan') {
               ?>
               <textarea name="popup_warning" id="popup_warning" class="form-control"><?php echo $val ?></textarea>
               <script>
               CKEDITOR.replace('popup_warning');
               </script>
               <?php
          } else {
               ?>
               <input class="form-control" type="text" name="<?php echo $key ?>" value="<?php echo htmlspecialchars($val) ?>" />
               <?php
          }
          ?>
          </td>
          </tr>
          <?php
     }
}
?>
<tr>
<td colspan="3">
<button type="button" class="btn btn-block btn-success" onclick="updateGlobals()">Update</button><br />
<div id="result"></div>
</td>
</tr>
</tbody>
</table>
<input type="hidden" name="updateglobals" value="1" />
</form>
</div>
</div>
</div>
</div>
</div>
<script>
$(document).ready(function() {
     $('#variables_table').DataTable({
          order: [0,'asc'],
          paging: false
     });
});
</script>

<?php
$jss = $db->query("SELECT * FROM tbl_cdns WHERE cdn_location = 5 ORDER BY cdn_order");
while($js = $jss->fetch(PDO::FETCH_ASSOC)) {
     echo $js['cdn_script'] ."\r\n";
}
?>

