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
<title>Settings</title>
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

<script>
function closeWindow()
{
     window.close();
}
function submitForm(fieldid, resid, value)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/js/ajax_settings.php',
          type: 'POST',
          data: {
               'field': fieldid,
               'value': value
          },
          success: function(data) {
               //alert(data);
          }
     }); 
}
$(function() {
     $('.mdb-select').materialSelect();
})
function reloadMe(row)
{
     switch(row) {
          case 1:
               window.location.reload();
               break;
          case 2:
               url = '<?php echo $gbl['site_url']?>';
               window.opener.document.location.href = url;
               window.close();
               break;
          case 3:
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/js/ajax_settings.php',
                    type: 'POST',
                    data: {
                         'reloadlogos': '1'
                    },
                    success: function(data) {
                         document.getElementById('logos'+row).innerHTML = data;
                    }
               });
               break;
          default:
               break;
     }
}
</script>
</head>

<body>
<div class="container-fluid">
<div class="row">
<div class="card">
<div class="card-body">
<h2 class="card-title h2">Site Settings</h2>
<p>Data on this page will save as you make changes.  When you are finished, you can click "Finish" and the window will close.  If you make changes to global settings, you may need close your browser and re-load the page to see the changes.</p>
</div>
</div>
</div>
<hr />

<div class="row">
<div class="col-md-12">
<ul class="nav nav-tabs nav-justified md-tabs indigo" role="tablist">
<li class="nav-item active"><a id="orgtab" class="nav-link" href="#org" data-toggle="tab">Organization</a></li>
<li class="nav-item"><a id="settab" class="nav-link" href="#set" data-toggle="tab">Settings</a></li>
<li class="nav-item"><a id="seotab" class="nav-link" href="#seo" data-toggle="tab">SEO</a></li>
<li class="nav-item"><a id="logtab" class="nav-link" href="#log" data-toggle="tab">Logos</a></li>
<li class="nav-item"><a id="slotab" class="nav-link" href="#slo" data-toggle="tab">Slogan</a></li>
<li class="nav-item"><a id="soctab" class="nav-link" href="#soc" data-toggle="tab">Social Sites</a></li>
<li class="nav-item"><a id="ft1tab" class="nav-link" href="#ft1" data-toggle="tab">Left Footer</a></li>
<li class="nav-item"><a id="ft2tab" class="nav-link" href="#ft2" data-toggle="tab">Middle Footer</a></li>
<li class="nav-item"><a id="ft3tab" class="nav-link" href="#ft3" data-toggle="tab">Right Footer</a></li>
<li class="nav-item"><a id="finish" class="nav-link" href="" data-toggle="tab" onclick="reloadMe(2)">Finish</a></li>
</ul>

<div class="tab-content card pt-5">
<div class="tab-pane fade show active" role="tabpanel" id="org"><?php include 'settings/organization.inc.php' ?><br />
<div id="res0"></div>
</div>

<div class="tab-pane fade" id="set"><?php include 'settings/settings.inc.php' ?><br />
<div id="res1"></div>
</div>

<div class="tab-pane fade" id="seo"><?php include 'settings/seo.inc.php' ?><br />
<div id="res2"></div>
</div>

<div class="tab-pane fade" id="log"><?php include 'settings/logo.inc.php' ?><br />
<div id="res3"></div>
</div>

<div class="tab-pane fade" id="slo"><?php include 'settings/slogan.inc.php' ?><br />
<div id="res4"></div>
</div>

<div class="tab-pane fade" id="soc"><?php include 'settings/social.inc.php' ?><br />
<div id="res5"></div>
</div>

<div class="tab-pane fade" id="ft1"><?php include 'settings/footer1.inc.php' ?><br />
<div id="res6"></div>
</div>

<div class="tab-pane fade" id="ft2"><?php include 'settings/footer2.inc.php' ?><br />
<div id="res7"></div>
</div>

<div class="tab-pane fade" id="ft3"><?php include 'settings/footer3.inc.php' ?><br />
<div id="res8"></div>
</div>

</div>
</div>
</div>
</div>

<?php
$jss = $db->query("SELECT * FROM tbl_cdns WHERE cdn_location = 5 ORDER BY cdn_order");
while($js = $jss->fetch(PDO::FETCH_ASSOC)) {
     echo $js['cdn_script'] ."\r\n";
}
?>

</body>
</html>