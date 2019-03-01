<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
include '../ld/db.inc.php';
include '../ld/globals.inc.php';
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>

<base href="<?php echo $gbl['site_url'] ?>/" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $gbl['sitedesc'] ?>" />
<meta name="generator" content="Rev. Daniel Carlson" />
<meta name="author" content="Rev. Daniel Carlson" />
<title>Editor:<?php echo $gbl['sitename'] ?></title>
<link href="<?php echo $gbl['site_url'] ?>/" rel="canonical" />
<link href="/ast/site/favicon.ico" rel="favicon" type="image/vnd.microsoft.icon" />

<?php
$css = $db->query("SELECT * FROM tbl_cdns WHERE cdn_location <= 4 ORDER BY cdn_location, cdn_order");
while($cs = $css->fetch(PDO::FETCH_ASSOC)) {
     echo $cs['cdn_script'] ."\r\n";
}
?>

<!-- Custom Stylesheet -->
<link rel="stylesheet" href="../css/themes/<?php echo $gbl['theme'] ?>/themestyle.css" />
<link rel="stylesheet" href="../css/themes/style.php" />

<!-- ajaxForms -->
<script src="../js/jquery.form.js"></script>

<script>
function closeWindow()
{
     //window.opener.location.reload();
     window.close();
}
</script>
<script>
function updateGlobals()
{
     var form = $('#varform');
     var data = $(form).serialize();     
     $.ajax({
          url: '/js/ajax_queries.php',
          type: 'POST',
          async: true,
          cache: false,
          data: data,
          success: function(data) {
               document.getElementById('result').innerHTML = data;
          }
     });      
}
</script>
</head>

<body>
<div class="container">
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
</body>
</html>

