<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
if($_SESSION['user']['security'] <= 1) {
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
<meta name="description" content="<?php echo $gbl['meta_description'] ?>" />
<meta name="generator" content="Rev. Daniel Carlson" />
<meta name="author" content="Rev. Daniel Carlson" />
<title>Carousel:<?php echo $gbl['site_name'] ?></title>
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
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
function closeWindow()
{
     window.opener.location.reload();
     window.close();
}
</script>
<script>
function updateSettings()
{
   $.ajax({
       url: '<?php echo $gbl['site_url'] ?>/js/ajax_settings.php',
       type: 'POST',
       data: {
          'update_carousel':true,
          'interval': document.getElementById('interval').value,
          'pauseonhover': $('input[name="pauseonhover"]:checked').val(),
          'wrapping': $('input[name="wrapping"]:checked').val(),
          'width': document.getElementById('width').value,
          'height': document.getElementById('height').value,
          'captionanimation': document.getElementById('captionanimation').value,
          'linkanimation': document.getElementById('linkanimation').value,
       },
       success: function(data) {
          alert(data);
          window.location.reload();
       }
   });        
}
</script>
<script>
function ajaxFileUpload(slideid)
{
     var form = document.getElementById("uploadform"+slideid);
     var fd = new FormData(form);
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/js/ajax_settings.php',
          type: 'POST',
          processData: false,
          contentType: false,
          data: fd,
          success: function(data) {
               alert(data);
               window.location.reload();
          },
          error: function(jqXHR, textStatus, errorMessage) {
               alert(errorMessage);
          }
     });
}
</script>
<script>
function ajaxSubmit(slideid)
{
   $.ajax({
       url: '<?php echo $gbl['site_url'] ?>/js/ajax_settings.php',
       type: 'POST',
       data: {
          'update_slide':true,
          'slide_id': slideid,
          'status': $('input[name="status['+slideid+']"]:checked').val(),
          'caption': document.getElementById('caption['+slideid+']').value,
          'url': document.getElementById('url['+slideid+']').value,
          'captionsize': document.getElementById('captionsize['+slideid+']').value,
          'order': document.getElementById('order['+slideid+']').value
       },
       success: function(data) {
          alert(data);
          window.location.reload();
       }
   });       
}
</script>
<script>
function createSlide()
{
   $.ajax({
       url: '<?php echo $gbl['site_url'] ?>/js/ajax_settings.php',
       type: 'POST',
       data: {
          'create_slide':true,
          'slide_caption': document.getElementById('caption').value,
          'caption_size': document.getElementById('captionsize').value,
          'slide_url': document.getElementById('url').value,
          'slide_status': $('input[name="status"]:checked').val()
       },
       success: function(data) {
          alert(data);
          window.location.reload();
       }
   });      
}
</script>

</head>

<body>

<div class="container-fluid">
<div class="row" style="margin-top: 10px;">

<div class="col-xs-12">
<div class="panel">
<div class="panel-heading panel-heading-custom"><h4>Carousel Slides and Settings</h4></div>
<div class="panel-body">
<div class="row">
<?php
$sql = $db->query("SELECT c_id, car_order FROM $_SESSION[prefix]_carousel ORDER BY car_order ASC");
$cnt = $sql->rowCount();
$row = 0;
?>
<ul class="nav nav-tabs" role="tablist" id="slideTabs">
<li class="presentation active"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
<?php
while($ul = $sql->fetch(PDO::FETCH_ASSOC)) {
     $row++;
     ?>
     <li><a href="#slide<?php echo $row ?>" aria-controls="slide<?php echo $row ?>" role="tab" data-toggle="tab">Slide <?php echo $row ?></a></li>
     
     <?php     
}
?>
<li><a href="#newslide" aria-controls="newslide" role="tab" data-toggle="tab"><i class="fa fa-plus"></i> New Slide</a></li>
</ul>
</div>
<div class="row" style="padding: 8px;">
<div class="tab-content">
<div role="tabpanel" class="tab-pane fade in active" id="settings">
<?php
$csql = $db->query("SELECT * FROM $_SESSION[prefix]_carousel_settings WHERE cs_id = 1");
$cset = $csql->fetch(PDO::FETCH_ASSOC);
?>
<style>#dropbox { width: <?php echo $cset['width'] ?>px; height: <?php echo $cset['height'] ?>px; }</style>
<h4>Carousel Settings</h4>
<div class="well well-sm" style="width: 33%; float: left;">
<b>Slide Interval</b><br />
<p class="help-block">The length of time (in milliseconds) a slide will remain before switching.</p>
<input type="number" name="interval" id="interval" min="1000" max="10000" maxlength="5" value="<?php echo $cset['interval'] ?>" class="form-control" style="width: 75%;" /><br /><br />

<b>Pause rotation on Hover?</b><br />
<input type="radio" name="pauseonhover" id="pauseonhover" value="0" <?php if($cset['hover_pause'] == 0) { echo "checked='checked'"; } ?> /> No<br />
<input type="radio" name="pauseonhover" id="pauseonhover" value="1" <?php if($cset['hover_pause'] == 1) { echo "checked='checked'"; } ?> /> Yes<br /><br />

<b>Wrap Slides?</b><br />
<p class="help-block">Start the carousel from the beginning after the last slide or stop at the last slide.</p>
<input type="radio" name="wrapping" id="wrapping" value="0" <?php if($cset['wrapping'] == 0) { echo "checked='checked'"; } ?> /> No<br />
<input type="radio" name="wrapping" id="wrapping" value="1" <?php if($cset['wrapping'] == 1) { echo "checked='checked'"; } ?> /> Yes<br /><br />

</div>

<div class="well well-sm" style="width: 33%; float: left; margin-left: 0.5%;">
<b>Carousel Dimensions</b><br />
<div class="help-block">Width</div>
<input type="number" name="width" id="width" min="100" max="1600" maxlength="4" value="<?php echo $cset['width'] ?>" class="form-control" style="width: 75%;" /><br />
<p><small>Set the width to '0' to make it full width.  Height will adjust automatically.</small></p>
<div class="help-block">Height</div>
<input type="number" name="height" id="height" min="100" max="1600" maxlength="4" value="<?php echo $cset['height'] ?>" class="form-control" style="width: 75%;" /><br />
</div>

<div class="well well-sm" style="width: 33%; float: left; margin-left: 0.5%;">
<div style="float: left;">
<b>Animations</b><br />
<div class="help-block">Caption Animation</div>
<select onchange="testAnim(this.value)" name="captionanimation" id="captionanimation" class="form-control">
<option value="<?php echo $cset['caption_animation'] ?>"><?php echo $cset['caption_animation'] ?></option>
<optgroup label="Attention Seekers">
<option value="bounce">bounce</option>
<option value="flash">flash</option>
<option value="pulse">pulse</option>
<option value="rubberBand">rubberBand</option>
<option value="shake">shake</option>
<option value="swing">swing</option>
<option value="tada">tada</option>
<option value="wobble">wobble</option>
<option value="jello">jello</option>
</optgroup>

<optgroup label="Bouncing Entrances">
<option value="bounceIn">bounceIn</option>
<option value="bounceInDown">bounceInDown</option>
<option value="bounceInLeft">bounceInLeft</option>
<option value="bounceInRight">bounceInRight</option>
<option value="bounceInUp">bounceInUp</option>
</optgroup>

<optgroup label="Bouncing Exits">
<option value="bounceOut">bounceOut</option>
<option value="bounceOutDown">bounceOutDown</option>
<option value="bounceOutLeft">bounceOutLeft</option>
<option value="bounceOutRight">bounceOutRight</option>
<option value="bounceOutUp">bounceOutUp</option>
</optgroup>

<optgroup label="Fading Entrances">
<option value="fadeIn">fadeIn</option>
<option value="fadeInDown">fadeInDown</option>
<option value="fadeInDownBig">fadeInDownBig</option>
<option value="fadeInLeft">fadeInLeft</option>
<option value="fadeInLeftBig">fadeInLeftBig</option>
<option value="fadeInRight">fadeInRight</option>
<option value="fadeInRightBig">fadeInRightBig</option>
<option value="fadeInUp">fadeInUp</option>
<option value="fadeInUpBig">fadeInUpBig</option>
</optgroup>

<optgroup label="Fading Exits">
<option value="fadeOut">fadeOut</option>
<option value="fadeOutDown">fadeOutDown</option>
<option value="fadeOutDownBig">fadeOutDownBig</option>
<option value="fadeOutLeft">fadeOutLeft</option>
<option value="fadeOutLeftBig">fadeOutLeftBig</option>
<option value="fadeOutRight">fadeOutRight</option>
<option value="fadeOutRightBig">fadeOutRightBig</option>
<option value="fadeOutUp">fadeOutUp</option>
<option value="fadeOutUpBig">fadeOutUpBig</option>
</optgroup>

<optgroup label="Flippers">
<option value="flip">flip</option>
<option value="flipInX">flipInX</option>
<option value="flipInY">flipInY</option>
<option value="flipOutX">flipOutX</option>
<option value="flipOutY">flipOutY</option>
</optgroup>

<optgroup label="Lightspeed">
<option value="lightSpeedIn">lightSpeedIn</option>
<option value="lightSpeedOut">lightSpeedOut</option>
</optgroup>

<optgroup label="Rotating Entrances">
<option value="rotateIn">rotateIn</option>
<option value="rotateInDownLeft">rotateInDownLeft</option>
<option value="rotateInDownRight">rotateInDownRight</option>
<option value="rotateInUpLeft">rotateInUpLeft</option>
<option value="rotateInUpRight">rotateInUpRight</option>
</optgroup>

<optgroup label="Rotating Exits">
<option value="rotateOut">rotateOut</option>
<option value="rotateOutDownLeft">rotateOutDownLeft</option>
<option value="rotateOutDownRight">rotateOutDownRight</option>
<option value="rotateOutUpLeft">rotateOutUpLeft</option>
<option value="rotateOutUpRight">rotateOutUpRight</option>
</optgroup>

<optgroup label="Sliding Entrances">
<option value="slideInUp">slideInUp</option>
<option value="slideInDown">slideInDown</option>
<option value="slideInLeft">slideInLeft</option>
<option value="slideInRight">slideInRight</option>

</optgroup>
<optgroup label="Sliding Exits">
<option value="slideOutUp">slideOutUp</option>
<option value="slideOutDown">slideOutDown</option>
<option value="slideOutLeft">slideOutLeft</option>
<option value="slideOutRight">slideOutRight</option>

</optgroup>

<optgroup label="Zoom Entrances">
<option value="zoomIn">zoomIn</option>
<option value="zoomInDown">zoomInDown</option>
<option value="zoomInLeft">zoomInLeft</option>
<option value="zoomInRight">zoomInRight</option>
<option value="zoomInUp">zoomInUp</option>
</optgroup>

<optgroup label="Zoom Exits">
<option value="zoomOut">zoomOut</option>
<option value="zoomOutDown">zoomOutDown</option>
<option value="zoomOutLeft">zoomOutLeft</option>
<option value="zoomOutRight">zoomOutRight</option>
<option value="zoomOutUp">zoomOutUp</option>
</optgroup>

<optgroup label="Specials">
<option value="hinge">hinge</option>
<option value="rollIn">rollIn</option>
<option value="rollOut">rollOut</option>
</optgroup>
</select>

<div class="help-block">Slide Image Animation</div>
<select onchange="testAnim(this.value)" name="linkanimation" id="linkanimation" class="form-control">
<option value="<?php echo $cset['link_animation'] ?>"><?php echo $cset['link_animation'] ?></option>
<optgroup label="Attention Seekers">
<option value="bounce">bounce</option>
<option value="flash">flash</option>
<option value="pulse">pulse</option>
<option value="rubberBand">rubberBand</option>
<option value="shake">shake</option>
<option value="swing">swing</option>
<option value="tada">tada</option>
<option value="wobble">wobble</option>
<option value="jello">jello</option>
</optgroup>

<optgroup label="Bouncing Entrances">
<option value="bounceIn">bounceIn</option>
<option value="bounceInDown">bounceInDown</option>
<option value="bounceInLeft">bounceInLeft</option>
<option value="bounceInRight">bounceInRight</option>
<option value="bounceInUp">bounceInUp</option>
</optgroup>

<optgroup label="Bouncing Exits">
<option value="bounceOut">bounceOut</option>
<option value="bounceOutDown">bounceOutDown</option>
<option value="bounceOutLeft">bounceOutLeft</option>
<option value="bounceOutRight">bounceOutRight</option>
<option value="bounceOutUp">bounceOutUp</option>
</optgroup>

<optgroup label="Fading Entrances">
<option value="fadeIn">fadeIn</option>
<option value="fadeInDown">fadeInDown</option>
<option value="fadeInDownBig">fadeInDownBig</option>
<option value="fadeInLeft">fadeInLeft</option>
<option value="fadeInLeftBig">fadeInLeftBig</option>
<option value="fadeInRight">fadeInRight</option>
<option value="fadeInRightBig">fadeInRightBig</option>
<option value="fadeInUp">fadeInUp</option>
<option value="fadeInUpBig">fadeInUpBig</option>
</optgroup>

<optgroup label="Fading Exits">
<option value="fadeOut">fadeOut</option>
<option value="fadeOutDown">fadeOutDown</option>
<option value="fadeOutDownBig">fadeOutDownBig</option>
<option value="fadeOutLeft">fadeOutLeft</option>
<option value="fadeOutLeftBig">fadeOutLeftBig</option>
<option value="fadeOutRight">fadeOutRight</option>
<option value="fadeOutRightBig">fadeOutRightBig</option>
<option value="fadeOutUp">fadeOutUp</option>
<option value="fadeOutUpBig">fadeOutUpBig</option>
</optgroup>

<optgroup label="Flippers">
<option value="flip">flip</option>
<option value="flipInX">flipInX</option>
<option value="flipInY">flipInY</option>
<option value="flipOutX">flipOutX</option>
<option value="flipOutY">flipOutY</option>
</optgroup>

<optgroup label="Lightspeed">
<option value="lightSpeedIn">lightSpeedIn</option>
<option value="lightSpeedOut">lightSpeedOut</option>
</optgroup>

<optgroup label="Rotating Entrances">
<option value="rotateIn">rotateIn</option>
<option value="rotateInDownLeft">rotateInDownLeft</option>
<option value="rotateInDownRight">rotateInDownRight</option>
<option value="rotateInUpLeft">rotateInUpLeft</option>
<option value="rotateInUpRight">rotateInUpRight</option>
</optgroup>

<optgroup label="Rotating Exits">
<option value="rotateOut">rotateOut</option>
<option value="rotateOutDownLeft">rotateOutDownLeft</option>
<option value="rotateOutDownRight">rotateOutDownRight</option>
<option value="rotateOutUpLeft">rotateOutUpLeft</option>
<option value="rotateOutUpRight">rotateOutUpRight</option>
</optgroup>

<optgroup label="Sliding Entrances">
<option value="slideInUp">slideInUp</option>
<option value="slideInDown">slideInDown</option>
<option value="slideInLeft">slideInLeft</option>
<option value="slideInRight">slideInRight</option>

</optgroup>
<optgroup label="Sliding Exits">
<option value="slideOutUp">slideOutUp</option>
<option value="slideOutDown">slideOutDown</option>
<option value="slideOutLeft">slideOutLeft</option>
<option value="slideOutRight">slideOutRight</option>

</optgroup>

<optgroup label="Zoom Entrances">
<option value="zoomIn">zoomIn</option>
<option value="zoomInDown">zoomInDown</option>
<option value="zoomInLeft">zoomInLeft</option>
<option value="zoomInRight">zoomInRight</option>
<option value="zoomInUp">zoomInUp</option>
</optgroup>

<optgroup label="Zoom Exits">
<option value="zoomOut">zoomOut</option>
<option value="zoomOutDown">zoomOutDown</option>
<option value="zoomOutLeft">zoomOutLeft</option>
<option value="zoomOutRight">zoomOutRight</option>
<option value="zoomOutUp">zoomOutUp</option>
</optgroup>

<optgroup label="Specials">
<option value="hinge">hinge</option>
<option value="rollIn">rollIn</option>
<option value="rollOut">rollOut</option>
</optgroup>
</select>

</div>
<div style="float:right;text-align:center">
<img id="animationSandbox" src="../ast/site/secpic.jpg" width="175" />
</div>
</div>
<div style="clear: both"></div>
<div style="text-align: right;">
<button type="button" class="btn btn-primary" onclick="updateSettings()">Update Settings</button>
</div>

</div>
<?php
$sqls = $db->query("SELECT * FROM $_SESSION[prefix]_carousel ORDER BY car_order ASC");
$srow = 0;
while($uls = $sqls->fetch(PDO::FETCH_ASSOC)) {
     $srow++;
     ?>
     <div role="tabpanel" class="tab-pane fade" id="slide<?php echo $srow ?>">     
     <form id="uploadform<?php echo $uls['c_id'] ?>" method="POST" enctype="multipart/form-data">
     <input type="hidden" name="update_slide" value="1" />
     <input type="hidden" name="slide_id" value="<?php echo $uls['c_id'] ?>" />
     <input type="hidden" name="slidewidth" value="<?php echo $cset['width'] ?>" />
     <input type="hidden" name="slideheight" value="<?php echo $cset['height'] ?>" />
     <div id="bkimg_<?php echo $uls['c_id'] ?>" style="float: left; width: 800px; height: 325px; border: 2px dashed gray; background-image: url('../ast/carousel/<?php echo $uls['car_image'] ?>'); background-size: 800px 325px; background-repeat: no-repeat">
     </div>

     <div style="float: left; margin-left: 20px; width: 30%;">
     <b>Replace Image</b> <br />
     <input name="image[<?php echo $uls['c_id'] ?>]" type="file" /><br /><br />
     
     <b>Slide Caption</b><br />
     <div class="help-block">If you include a caption, it will appear on the top left of the slide.</div>
     <input type="text" name="caption[<?php echo $uls['c_id'] ?>]" id="caption[<?php echo $uls['c_id'] ?>]" class="form-control" value="<?php echo $uls['car_caption'] ?>" /><br />
     
     <b>Caption Size</b><br />
     <select name="captionsize[<?php echo $uls['c_id'] ?>]" id="captionsize[<?php echo $uls['c_id'] ?>]">
     <option value="<?php echo $uls['car_caption_size'] ?>">Default</option>
     <option value="h1" class="h1">Heading 1</option>
     <option value="h2" class="h2">Heading 2</option>
     <option value="h3" class="h3">Heading 3</option>
     <option value="h4" class="h4">Heading 4</option>
     <option value="h5" class="h5">Heading 5</option>
     </select><br /><br />
     
     <b>Slide URL</b><br />
     <input type="text" name="url[<?php echo $uls['c_id'] ?>]" id="url[<?php echo $uls['c_id'] ?>]" class="form-control" value="<?php echo $uls['car_url'] ?>" /><br /><br />
     
     <b>Slide Status</b><br />
     <input type="radio" name="status[<?php echo $uls['c_id'] ?>]" id="status[<?php echo $uls['c_id'] ?>]" value="0" <?php if($uls['car_status'] == 0) { echo 'checked="checked"';} ?> /> Disabled<br />
     <input type="radio" name="status[<?php echo $uls['c_id'] ?>]" id="status[<?php echo $uls['c_id'] ?>]" value="1" <?php if($uls['car_status'] == 1) { echo 'checked="checked"';} ?> /> Enabled<br />
     <input type="radio" name="status[<?php echo $uls['c_id'] ?>]" id="status[<?php echo $uls['c_id'] ?>]" value="9" /> Delete Slide<br /><br />
     
     <b>Slide Order</b><br />
     <input type="text" name="order[<?php echo $uls['c_id'] ?>]" id="order[<?php echo $uls['c_id'] ?>]" class="form-control" value="<?php echo $uls['car_order'] ?>" /><br /><br />
     
     <div style="text-align: right;">
     <input type="submit" value="Update Slide" class="btn btn-success" />
     </div>
     </div>
     </form>
     <div style="clear: both"></div>
     </div>
     <script>
     var form = document.getElementById("uploadform<?php echo $uls['c_id'] ?>");
     form.addEventListener("submit", function(e) {
          var len = $('#uploadform<?php echo $uls['c_id'] ?> input[type=file]').get(0).files.length;
          if(len > 0) {
               ajaxFileUpload('<?php echo $uls['c_id'] ?>');
          } else {
               ajaxSubmit('<?php echo $uls['c_id'] ?>');
          }
          e.preventDefault();
          return false;
     }, false);
     </script>     
     <?php
}
?>
<div role="tabpanel" class="tab-pane fade" id="newslide">     

<div style="float: left; border: 2px dashed gray; width: 50%; height: 375px; text-align: center;vertical-align: middle">
You can add the image once you create the slide.
</div>

<div style="float: left; margin-left: 20px; width: 40%;">
<b>Slide Caption</b><br />
<div class="help-block">If you include a caption, it will appear on the top left of the slide.</div>
<input type="text" name="caption" id="caption" class="form-control" value="" /><br />

<b>Caption Size</b><br />
<select name="captionsize" id="captionsize">
<option value="h1" class="h1">Heading 1</option>
<option value="h2" class="h2">Heading 2</option>
<option value="h3" class="h3">Heading 3</option>
<option value="h4" class="h4">Heading 4</option>
<option value="h5" class="h5">Heading 5</option>
</select><br /><br />

<b>Slide URL</b><br />
<input type="text" name="url" id="url" class="form-control" value="" /><br /><br />

<b>Slide Status</b><br />
<input type="radio" name="status" id="status" value="0" /> Disabled<br />
<input type="radio" name="status" id="status" value="1" /> Enabled<br /><br />

<div style="text-align: right;">
<button type="button" class="btn btn-success" onclick="createSlide()">Create Slide</button>
</div>
</div>
<div style="clear: both"></div>
</div>
     
</div>
</div>

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

<script>
$('#slideTabs a').click(function (e) {
     e.preventDefault()
     $(this).tab('show')
})
</script>

<script>
function testAnim(x) {
     $('#animationSandbox').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
          $(this).removeClass();
     });
};
     
$(document).ready(function() {
     $('.js--triggerAnimation').click(function(e) {
          e.preventDefault();
          var anim = $('.js--animations').val();
          testAnim(anim);
     });
     
     $('.js--animations').change(function() {
          var anim = $(this).val();
          testAnim(anim);
     });
});
</script>
