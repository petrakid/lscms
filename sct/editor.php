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
<title>Editor: <?php echo $gbl['site_name'] ?></title>
<link href="<?php echo $gbl['site_url'] ?>/" rel="canonical" />

<?php
$css = $db->query("SELECT * FROM tbl_cdns WHERE cdn_location <= 4 AND cdn_location != 0 ORDER BY cdn_location, cdn_order");
while($cs = $css->fetch(PDO::FETCH_ASSOC)) {
     echo $cs['cdn_script'] ."\r\n";
}
?>

<!-- Custom Stylesheet -->
<link rel="stylesheet" href="../css/themes/<?php echo $gbl['theme'] ?>/themestyle.css" />
<link rel="stylesheet" href="../css/themes/style.php" />

<script>
function closeWindow(page)
{
     url = '<?php echo $gbl['site_url']?>/' + page +'';
     window.opener.document.location.href = url;
     window.close();
}
$(function() {
     $('#page_editor').on('submit', function(e) {
          e.preventDefault();
          var form = $('#page_editor')[0];
          var pageData = new FormData(form);
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/sct/ajax/editor.php',
               type: 'POST',
               data: pageData,
               processData: false,
               contentType: false,
               success: function(data) {
                    $('#page_editRes').show();
                    $('#page_editRes').html('Page Updated');
                    var page_image = data;
                    $('#page_image_view').prop('src', '<?php echo $gbl['site_url'] ?>/ast/res/'+ page_image +'?' + new Date().getTime());
               },
               error: function(data) {
                    $('#page_editRes').html(data);                    
               }
          })           
     })
});
function addBlock(pageid)
{
   $.ajax({
       url: '<?php echo $gbl['site_url'] ?>/sct/ajax/editor.php',
       type: 'POST',
       data: {
          'new_block':true,
          'page_id':pageid
       },
       success: function(data) {
          toastr.success('New Block Added!');
          setTimeout(function() {
               window.location.reload();
          }, 2000);
       }
   });     
}
function updateBlock(blockid)
{
     if($('#block_header' + blockid).val() == '') {
          toastr.error('You must supply a Block Title before saving!', 'Warning!', {timeOut: 3000});
     }
     else if ($('#grid_width' + blockid).val() == '') {
          toastr.error('You must select a Block Width before saving!', 'Warning!', {timeOut: 3000});
     } else {
          var ckdata = CKEDITOR.instances["block_content" + blockid].getData();
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/sct/ajax/editor.php',
               type: 'POST',
               data: {
                    'update_block': 1,
                    'block_id': blockid,
                    'page_id': $('#page_id' + blockid).val(),
                    'block_header': $('#block_header' + blockid).val(),
                    'block_status': $('input[name="block_status' + blockid + '"]:checked').val(),
                    'grid_width': $("#grid_width" + blockid).val(),
                    'block_content': ckdata,
                    'block_plugin': $("#block_plugin" + blockid).val(),
                    'scheduled': $('input[name="scheduled' + blockid + '"]:checked').val(),
                    'start_datetime': $("#startdate" + blockid).val(),
                    'end_datetime': $("#enddate" + blockid).val(),
                    'show_header': $('input[name="show_header' + blockid + '"]:checked').val(),
                    'transparent': $('input[name="transparent' + blockid + '"]:checked').val(),
                    'edge_padding': $('input[name="edge_padding' + blockid + '"]:checked').val(),
                    'grid_offset': $("#grid_offset" + blockid).val()
               },
               error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
               },
               success: function(data) {
                    $('#savebutton' + blockid).prop('disabled', true);
                    $('#savebutton' + blockid).html('Saved');
                    setTimeout(function() {
                         window.location.reload()
                    }, 2000);
               }
          })
     }
}
function viewHistoric(histid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/sct/ajax/editor.php',
          type: 'POST',
          data: {
               'view_historic': 1,
               'b_id': histid
          },
          success: function(data) {
               $('#histcontent').html(data);
               $('#historyModal').modal('show');
          }
     })
}
function enableHistoric(histid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/sct/ajax/editor.php',
          type: 'POST',
          data: {
               'restore_historic': 1,
               'hist_id': histid,
          },
          success: function(data) {
               toastr.success('Historic Version restored successfully!', 'Completed!');
               setTimeout(function() {
                    window.location.reload()
               }, 2000)
          }
     })
}
function makeMenuLink(mname)
{
     var mlink;
     mlink = mname.toString();
     mlink = mlink.normalize('NFD');
     mlink = mlink.replace(/[\u0300-\u036f]/g,'');
     mlink = mlink.replace(/\s+/g,'-');
     mlink = mlink.toLowerCase();
     mlink = mlink.replace(/&/g,'-and-');
     mlink = mlink.replace(/[^a-z0-9\-]/g,'');
     mlink = mlink.replace(/-+/g,'-');
     mlink = mlink.replace(/^-*/,'');
     mlink = mlink.replace(/-*$/,'');
     document.getElementById('menu_link').value = mlink;     
}

</script>
</head>
<?php
$sql = $db->query("SELECT * FROM tbl_pages WHERE p_id = $_GET[p_id]");
$pg = $sql->fetch(PDO::FETCH_ASSOC);
?>

<body>
<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="HistoryModalLabel" aria-hidden="true">
<div class="modal-dialog modal-fluid" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title w-100" id="HistoryModelLabel">Historic Block</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body" id="histcontent">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<div class="container-fluid">
<div class="row">
<div class="col-12">
<div class="card-body">
<button type="button" onclick="closeWindow('<?php echo $pg['menu_link'] ?>')" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-check"></i> Finish</button>
</div>
</div>
</div>
<div class="row">
<?php
if(isset($_GET['p_id'])) {
     $sql2 = $db->query("SELECT * FROM tbl_blocks WHERE page_id = $_GET[p_id] AND block_status = 1 ORDER BY grid_order ASC");
     $pagename = $pg['page_title'];
     $menuname = $pg['menu_name'];     
     ?>
     <div class="col-4">     
     <div class="card">
     <h5 class="card-header info-color white-text text-center py-4"><?php echo $gbl['site_name'] ?> Page Editor</h5>
     <div class="card-body px-lg-5 pt-0">
     <h6 class="card-subtitlemb-2 text-muted">You are editing: <?php echo $pagename ?></h6>
     <p class="card-text">
     <small class="form-text text-muted mb-2">Be sure to click Save often as you edit the page.  When you are finished editing, click the Finish button.  To ADD a new page to the site, close this window (press Cancel) and use the Menu Editor.</small>
     
     <form id="page_editor" enctype="multipart/form-data">
     <input type="hidden" name="p_id" value="<?php echo $pg['p_id'] ?>" />
     <input type="hidden" name="savechanges" value="1" />
     
     <div class="md-form">
     <label for="page_title">Page Title</label>
     <input type="text" name="page_title" id="page_title" value="<?php echo $pagename ?>" required="required" class="form-control" />
     </div>
     
     <div class="md-form">
     <label for="menu_name">Menu Name</label>
     <input onblur="makeMenuLink(this.value)" type="text" name="menu_name" id="menu_name" value="<?php echo $menuname ?>" required="required" class="form-control" />
     </div>
      
     <div class="md-form">
     <label for="menu_link">Menu Link</label>
     <input type="text" name="menu_link" id="menu_link" value="<?php echo $pg['menu_link'] ?>" required="required" class="form-control" />
     <small class="form-text text-muted mb-2">Auto-created from the Menu Name, but you can also override here.  Will be formatted for SEO friendliness.</small>
     </div>     
     
     <div class="md-form">
     <label for="menu_url">Page URL</label>
     <input type="url" name="menu_url" id="menu_url" class="form-control" value="<?php echo $pg['menu_url'] ?>" />
     <small class="form-text text-muted mb-2">A url not associated with this website.  This will forward the user to the url you enter in a new page/tab.</small>     
     </div>
     
     <b>Page Status</b>
     <small class="form-text text-muted mb-2">Show, draft or administrative</small>
     <div class="form-check">
     <input class="form-check-input" type="radio" name="menu_status" id="menu_status1" value="1" <?php if($pg['menu_status'] == 1) { echo 'checked="checked"';} ?> required="required" />
     <label for="menu_status1" class="form-check-label">Page Active (public can see it)</label>
     </div>
     <div class="form-check">
     <input class="form-check-input" type="radio" name="menu_status" id="menu_status0" value="0" <?php if($pg['menu_status'] == 0) { echo 'checked="checked"';} ?> />
     <label for="menu_status0" class="form-check-label">Page Draft or Hidden (can be accessed but won't show in menu)</label>     
     </div>
     <div class="form-check">
     <input class="form-check-input" type="radio" name="menu_status" id="menu_status3" value="3" <?php if($pg['menu_status'] == 3) { echo 'checked="checked"';} ?> />
     <label for="menu_status3" class="form-check-label">Page Admin Only (can only be acces by administrators)</label>     
     </div>
     <hr />

     <b>Carousel</b>
     <small class="form-text text-muted mb-2">Show or hide the image carousel for this page.</small>     
     <div class="form-check">
     <input class="form-check-input" type="radio" name="show_slider" id="show_slider1" value="1" <?php if($pg['show_slider'] == 1) { echo 'checked="checked"';} ?> required="required" />
     <label class="form-check-label" for="show_slider1">Carousel Enabled</label>
     </div>
     <div class="form-check">
     <input class="form-check-input" type="radio" name="show_slider" id="show_slider0" value="0" <?php if($pg['show_slider'] == 0) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="show_slider0">Carousel Disabled</label>     
     </div>
     <hr />

     <small class="form-text text-muted mb-2">Landing Image</small> 
     <div class="file-field">
     <div class="btn btn-primary btn-sm float-left">
     <span>Choose file</span>
     <input type="file" id="jumbotron_image" name="jumbotron_image" accept="image/*" />
     </div>
     <div class="file-path-wrapper">
     <input class="file-path validate" type="text" placeholder="Chose image" />
     </div>
     </div>
     <div class="md-form">
     <input type="url" name="jumbotron_url" id="jumbotron_url" value="<?php echo $pg['jumbotron_url'] ?>" class="form-control" />
     <label for="jumbotron_url">Embed URL</label>
     <small class="form-text text-muted">Paste the URL of the image you'd like to use if you do not have one to upload.</small>
     </div>
     <img alt="No Image Added" id="jt_image_view" class="img-fluid hoverable" style="width: 100%" src="<?php if($pg['jumbotron_url'] > '') { echo $pg['jumbotron_url']; } else { echo $gbl['site_url'] ?>/ast/landings/<?php echo $pg['jumbotron_image']; } ?>" />
     <div style="clear:both"></div>
     <hr />

     <b>Social Features</b>
     <small class="form-text text-muted mb-2">To show or hide the social site sharing features.</small>      
     <div class="form-check">
     <input class="form-check-input" type="radio" name="social_links" id="social_links1" value="1" <?php if($pg['social_links'] == 1) { echo 'checked="checked"';} ?> required="required" />
     <label class="form-check-label" for="social_links1">Enable Social Media Fetures</label>
     </div>
     <div class="form-check">
     <input class="form-check-input" type="radio" name="social_links" id="social_links0" value="0" <?php if($pg['social_links'] == 0) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="social_links0">Disable Social Media Fetures</label>
     </div>     
     <hr />
     
     <b>Comments Block</b>
     <small class="form-text text-muted mb-">Enable the user comments system on this page.</small>      
     <div class="form-check">
     <input class="form-check-input" type="radio" name="allow_comments" id="allow_comments0" value="0" <?php if($pg['allow_comments'] == 0) { echo 'checked="checked"';} ?> required="required" />
     <label class="form-check-label" for="allow_comments0">Hide Comments Block (default)</label>
     </div>
     <div class="form-check">     
     <input class="form-check-input" type="radio" name="allow_comments" id="allow_comments1" value="1" <?php if($pg['allow_comments'] == 1) { echo 'checked="checked"';} ?> />     
     <label class="form-check-label" for="allow_comments1">Show Comments Block</label>
     </div>
     <hr />
     
     <b>Security</b>
     <small class="form-text text-muted mb-2">Setting a Security Level will limit who can view or edit the page. Administrators always have full access no matter the level.</small>      
     <select class="mdb-select md-form mb-3 initialized" id="security_role" name="security_role">
     <option value="" disabled>Select a Level</option>
     <?php
     $rol = $db->query("SELECT * FROM tbl_security_roles WHERE role_status = 1");
     while($rl = $rol->fetch(PDO::FETCH_ASSOC)) {
          if($pg['security_role'] == $rl['s_id']) {
               echo '<option value="'. $rl['s_id'] .'" selected>'. $rl['role_name'] .'</option>';
          } else {
               echo '<option value="'. $rl['s_id'] .'">'. $rl['role_name'] .'</option>';
          }
     }
     ?>
     </select>
     <hr />
     
     <div class="md-form">
     <label for="keywords">SEO Keywords</label>
     <input type="text" id="keywords" name="keywords" class="form-control" placeholder="Separate with commas" value="<?php echo $pg['keywords'] ?>" />
     </div>
     
     <div class="md-form">
     <label for="description">SEO Description</label>
     <input type="text" name="description" id="description" placeholder="Brief, 1-sentence description of the page" value="<?php echo $pg['description'] ?>" class="form-control" />
     </div>
     
     <small class="form-text text-muted mb-2">For SEO and Social Media sharing, an image goes a long way!</small> 
     <div class="file-field">
     <div class="btn btn-primary btn-sm float-left">
     <span>Choose file</span>
     <input type="file" id="page_image" name="page_image" accept="image/*" />
     </div>
     <div class="file-path-wrapper">
     <input class="file-path validate" type="text" placeholder="Chose image for SEO" />
     </div>
     </div>
     <img alt="No Image Added" id="page_image_view" class="img-thumbnail hoverable" width="75" src="<?php echo $gbl['site_url'] ?>/ast/res/<?php echo $pg['page_image'] ?>" />
     <div style="clear:both"></div>
     
     <div class="md-form input-group">
     <div class="input-group-prepend">
     <input type="submit" name="savechanges" value="Save" class="btn btn-success" />
     <input type="button" class="btn btn-dark" onclick="closeWindow()" value="Cancel" />
     </div>
     </div>
     </p>
     </form>
     
     <p>Click "Save" before continuing!</p>
     <div id="page_editRes" class="alert alert-success" style="display: none"></div>
     <p>You can add or remove grid blocks from the page and edit the content of each block.  Blocks have a maximum width of 12 and minimum width of 1.  Each row of blocks should add up to 12.  If a row goes over 12, the block will wrap to the next row.  Each block should have header text and content in the block.</p>        
     <p><button type="button" class="btn btn-success" onclick="addBlock('<?php echo $pg['p_id'] ?>')"><i class="glyphicon glyphicon-plus"></i> Add Block</button></p>
     </div>
     </div>
     </div>
     <?php
     if($sql2->rowCount() > 0) {
          ?>
          <div class="col-8">          
          <div class="accordion dragarea" id="accordionEx" role="tablist" aria-multiselectable="false">          
          <?php
          while($blk = $sql2->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <input type="hidden" name="page_id" id="page_id<?php echo $blk['b_id'] ?>" value="<?php echo $pg['p_id'] ?>" />
               <div class="card" draggable="true" id="item-<?php echo $blk['b_id'] ?>">
               <div class="card-header" role="tab" id="block<?php echo $blk['b_id'] ?>">
               <a class="collapsed" data-toggle="collapse" href="#collapseblock<?php echo $blk['b_id'] ?>" aria-expanded="false" aria-controls="collapse<?php echo $blk['b_id'] ?>">
               <h5 class="mb-0">Block <?php echo $blk['grid_order'] ?> <i class="fa fa-angle-down rotate-icon text-blue"></i></h5>
               </a>
               </div>     
               
               <div id="collapseblock<?php echo $blk['b_id'] ?>" class="collapse" role="tabpanel" aria-labelledby="block<?php echo $blk['b_id'] ?>" data-parent="#accordionEx">               
               <div class="card-body">               
               
               <form role="form">
               <table class="table table-bordered table-striped" style="width: 95%;">
               
               <tr>
               <td style="width: 40%">
               <div class="md-form">
               <label for="block_header">Block Title</label>
               <input type="text" name="block_header|<?php echo $blk['b_id'] ?>" id="block_header<?php echo $blk['b_id'] ?>" value="<?php echo $blk['block_header'] ?>" required="required" class="form-control" />
               </div>
               </td>
               
               <td>
               <b>Block Status</b>
               <small class="form-text text-muted mb-2">Show, hide, or remove this block.</small>
               <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="block_status<?php echo $blk['b_id'] ?>" id="block_status1<?php echo $blk['b_id'] ?>" value="1" <?php if($blk['block_status'] == 1) { echo 'checked="checked"';} ?> required="required" />
               <label class="form-check-label" for="block_status1<?php echo $blk['b_id'] ?>">Block Visible</label>
               </div>
               <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="block_status<?php echo $blk['b_id'] ?>" id="block_status0<?php echo $blk['b_id'] ?>" value="0" <?php if($blk['block_status'] == 0) { echo 'checked="checked"';} ?> />
               <label class="form-check-label" for="block_status0<?php echo $blk['b_id'] ?>">Hidden</label>
               </div>
               <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="block_status<?php echo $blk['b_id'] ?>" id="block_status9<?php echo $blk['b_id'] ?>" value="9" />
               <label class="form-check-label" for="block_status9<?php echo $blk['b_id'] ?>">Delete Block</label>
               </div>
               </td>
               </tr>
               
               <tr>
               <td>
               <small class="form-text text-muted mb-2">You can select if this block is scheduled to be active and to deactivate at on certain dates/times.</small>
               <div class="form-check">
               <input class="form-check-input" type="checkbox" name="scheduled<?php echo $blk['b_id'] ?>" id="scheduled<?php echo $blk['b_id'] ?>" value="1" <?php if($blk['scheduled'] == 1) { echo 'checked="checked"';} ?> />
               <label class="form-check-label" for="scheduled<?php echo $blk['b_id'] ?>">Enable Schedule</label>
               </div>

               <div class="md-form">
               <small class="form-text">Scheduled Start Date</small>
               <input type="date" name="startdate|<?php echo $blk['b_id'] ?>" id="startdate<?php echo $blk['b_id'] ?>" value="<?php echo $blk['start_datetime'] ?>" class="form-control" />          
               </div>
               
               <div class="md-form">
               <small class="form-text">Schedule End Date</small>             
               <input type="date" name="enddate|<?php echo $blk['b_id'] ?>" id="enddate<?php echo $blk['b_id'] ?>" value="<?php echo $blk['end_datetime'] ?>" class="form-control" />
               </div>
               </td>
               
               <td>
               <b>Header</b>
               <small class="form-text text-muted mb-2">If you'd like to hide the header of this block, you can do so here.</small>
               <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="show_header<?php echo $blk['b_id'] ?>" id="show_header1<?php echo $blk['b_id'] ?>" value="1" <?php if($blk['show_header'] == 1) { echo 'checked="checked"';} ?> />
               <label class="form-check-label" for="show_header1<?php echo $blk['b_id'] ?>">Yes</label>
               </div>
               <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="show_header<?php echo $blk['b_id'] ?>" id="show_header0<?php echo $blk['b_id'] ?>" value="0" <?php if($blk['show_header'] == 0) { echo 'checked="checked"';} ?> />
               <label class="form-check-label" for="show_header0<?php echo $blk['b_id'] ?>">No</label>
               </div>
               <hr />
               
               <b>Transparent Panel</b>
               <small class="form-text text-muted mb-2">You can make this block's background transparent to further customize its style.</small>
               <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="transparent<?php echo $blk['b_id'] ?>" id="transparent1<?php echo $blk['b_id'] ?>" value="1" <?php if($blk['transparent'] == 1) { echo 'checked="checked"';} ?> />
               <label class="form-check-label" for="transparent1<?php echo $blk['b_id'] ?>">Yes</label>
               </div>
               <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="transparent<?php echo $blk['b_id'] ?>" id="transparent0<?php echo $blk['b_id'] ?>" value="0" <?php if($blk['transparent'] == 0) { echo 'checked="checked"';} ?> />
               <label class="form-check-label" for="transparent0<?php echo $blk['b_id'] ?>">No</label>
               </div>
               <hr />

               <b>Edge Padding?</b>
               <small class="form-text text-muted mb-2">You can display the block with standard edge padding or make it touch the edge of the screen.</small>
               <div class="form-check form-check-inline">               
               <input class="form-check-input" type="radio" name="edge_padding<?php echo $blk['b_id'] ?>" id="edge_padding1<?php echo $blk['b_id'] ?>" value="1" <?php if($blk['edge_padding'] == 1) { echo 'checked="checked"';} ?> />
               <label class="form-check-label" for="edge_padding1<?php echo $blk['b_id'] ?>">Yes</label>
               </div>
               <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="edge_padding<?php echo $blk['b_id'] ?>" id="edge_padding0<?php echo $blk['b_id'] ?>" value="0" <?php if($blk['edge_padding'] == 0) { echo 'checked="checked"';} ?> />
               <label class="form-check-label" for="edge_padding0<?php echo $blk['b_id'] ?>">No</label>
               </div>                               
               </td>
               </tr>
               
               <tr>
               <td>
               <b>Block Width</b>
               <small class="form-text text-muted mb-2">From 1 to 12</small>
               <select name="grid_width|<?php echo $blk['b_id'] ?>" id="grid_width<?php echo $blk['b_id'] ?>" class="mdb-select md-form mb-2 initialized">
               <option value="" disabled>Select</option>               
               <?php
               for($i=1;$i<=12;$i++) {
                    if($i == $blk['grid_width']) {
                         echo '<option value="'. $i .'" selected="selected">'. $i .'</option>';
                    }
                    echo '<option value="'. $i .'">'. $i .'</option>';
               }
               ?>
               </select>
               <b>Block Offset</b>
               <small class="form-text text-muted mb-2">Will "push" the block right by 1 to 12</small>
               <select name="grid_offset|<?php echo $blk['b_id'] ?>" id="grid_offset<?php echo $blk['b_id'] ?>" class="mdb-select md-form mb-2 initialized">
               <option value="" disabled>Select</option>               
               <?php
               for($j=0;$j<=12;$j++) {
                    if($j == $blk['grid_offset']) {
                         echo '<option value="'. $j .'" selected="selected">'. $j .'</option>';
                    }
                    echo '<option value="'. $j .'">'. $j .'</option>';
               }
               ?>
               </select>               
               </td>
               
               <td>
               <b>Block Plugin</b>
               <small class="form-text text-muted mb-2">Includes a plugin after the block content.  You can also include plugins by adding their "shortcode" to the content.</small>
               <select class="mdb-select md-form mb-2 initialized" name="block_plugin|<?php echo $blk['b_id'] ?>" id="block_plugin<?php echo $blk['b_id'] ?>">
               <option value="" <?php if($blk['block_plugin'] == '') { echo 'selected="selected"';} ?>>None</option>
               <?php
               $sqlp = $db->query("SELECT * FROM tbl_plugins WHERE plugin_status = 1");
               while($plg = $sqlp->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="'. $plg['plugin_file'] .'"';
                    if($plg['plugin_file'] == $blk['block_plugin']) {
                         echo ' selected="selected"';
                    }
                    echo '>'. $plg['plugin_name'] .'</option>';
               }
               ?>
               </select>
               </td>
               </tr>
               
               <tr>
               <td colspan="2">
               <b>Block Content</b>
               <textarea name="block_content|<?php echo $blk['b_id'] ?>" class="" id="block_content<?php echo $blk['b_id'] ?>"><?php echo html_entity_decode(htmlspecialchars_decode($blk['block_content'])) ?></textarea>
               <script>
               CKEDITOR.plugins.addExternal('balloontoolbar', 'https://www.stpaulsmilaca.org/js/ckeditor/plugins/balloontoolbar/', 'plugin.js');               
               CKEDITOR.plugins.addExternal('balloonpanel', 'https://www.stpaulsmilaca.org/js/ckeditor/plugins/balloonpanel/', 'plugin.js');
               CKEDITOR.plugins.addExternal('jsplus_font_awesome', 'https://www.stpaulsmilaca.org/js/ckeditor/plugins/jsplus_font_awesome/', 'plugin.js');
               CKEDITOR.plugins.addExternal('jsplusBootstrapEditor', 'https://www.stpaulsmilaca.org/js/ckeditor/plugins/jsplusBootstrapEditor/', 'plugin.js');
               CKEDITOR.plugins.addExternal('jsplusBootstrapTools', 'https://www.stpaulsmilaca.org/js/ckeditor/plugins/jsplusBootstrapTools/', 'plugin.js');
               CKEDITOR.plugins.addExternal('jsplusBootstrapWidgets', 'https://www.stpaulsmilaca.org/js/ckeditor/plugins/jsplusBootstrapWidgets/', 'plugin.js');
               CKEDITOR.plugins.addExternal('jsplusInclude', 'https://www.stpaulsmilaca.org/js/ckeditor/plugins/jsplusInclude/', 'plugin.js');
               CKEDITOR.plugins.addExternal('jsplusTableTools', 'https://www.stpaulsmilaca.org/js/ckeditor/plugins/jsplusTableTools/', 'plugin.js'); 
               CKEDITOR.replace('block_content<?php echo $blk['b_id'] ?>', {
                    extraPlugins: 'balloontoolbar,balloonpanel,jsplus_font_awesome,jsplusBootstrapEditor,jsplusBootstrapTools,jsplusBootstrapWidgets,jsplusInclude,jsplusTableTools',
                    skin: 'bootstrapck, <?php echo $gbl['site_url'] ?>/js/ckeditor/skins/bootstrapck/',
                    height: '350px',
                    filebrowserBrowseUrl : '<?php echo $gbl['site_url'] ?>/js/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                    filebrowserUploadUrl : '<?php echo $gbl['site_url'] ?>/js/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                    filebrowserImageBrowseUrl : '<?php echo $gbl['site_url'] ?>/js/filemanager/dialog.php?type=1&editor=ckeditor&fldr='                    
               });
               </script>
               <hr />
               <b>Page Links</b>
               <small class="form-text text-muted mb-2">Used to insert site page url's into the content.</small>
               <select name="page_link" class="mdb-select md-form mb-2 initialized" id="page_link">
               <option value="" disabled selected>Select a Page</option>
               <optgroup label="Parent Pages"></optgroup>
               <?php
               $pa = $db->query("SELECT p_id, menu_name, menu_link FROM tbl_pages WHERE (menu_status = 1 OR menu_status = 0) AND parent_id = 0 ORDER BY menu_order");
               while($sp0 = $pa->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <option value="<?php echo $gbl['site_url'] ?>/<?php echo $sp0['menu_link'] ?>"><?php echo stripslashes($sp0['menu_name']) ?></option>
                                        
                    <?php
               }               
               $sp = $db->query("SELECT p_id, menu_name, menu_link FROM tbl_pages WHERE (menu_status = 1 OR menu_status = 0) AND parent_id = 0 ORDER BY menu_order");
               while($sp1 = $sp->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <optgroup id="<?php echo $sp1['p_id'] ?>" label="<?php echo stripslashes($sp1['menu_name']) ?>"></optgroup>
                    <?php
                    $sc = $db->query("SELECT p_id, menu_name, menu_link FROM tbl_pages WHERE (menu_status = 1 OR menu_status = 0) AND parent_id = $sp1[p_id] ORDER BY menu_order");
                    while($sp2 = $sc->fetch(PDO::FETCH_ASSOC)) {
                         ?>
                         <option value="<?php echo $gbl['site_url'] ?>/<?php echo $sp1['menu_link'] ?>/<?php echo $sp2['menu_link'] ?>"><?php echo stripslashes($sp2['menu_name']) ?></option>
                         
                         <?php
                    }
               }
               ?>
               </select>
               <div class="md-form">
               <input type="text" name="copied_url" id="copied_url" class="form-control" />
               <small class="form-text text-muted mb-2">CTRL+C the highlighted text and paste (CTRL+P) where you want it.</small>
               </div>
               </td>
               </tr>

               <tr>
               <td colspan="2">
               </td>
               </tr>
               
               <tr>
               <td>
               <button type="button" id="savebutton<?php echo $blk['b_id'] ?>" onclick="updateBlock('<?php echo $blk['b_id'] ?>')" class="btn btn-primary">Update Block</button>
               </td>
               <td>
               <select name="histblocks" id="histblocks" class="mdb-select" onchange="viewHistoric(this.value)">
               <option selected disabled>Select/Restore Historic Version</option>
               <?php
               $his = $db->query("SELECT b_id, date_added, block_header, block_content FROM tbl_blocks WHERE page_id = $pg[p_id] AND block_status = 0 ORDER BY date_added DESC");
               while($hs = $his->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="'. $hs['b_id'] .'">'. date('M j Y, H:i:s', strtotime($hs['date_added'])) .' | '. $hs['block_header'] .' | '. mb_strimwidth(strip_tags($hs['block_content']), 0, 40) . '...</option>'."\n";
               }
               ?>
               </select>
               </td>
               </tr>
               <tr>
               <td colspan="2">
               <div id="res"></div>
               </td>
               </tr>
               </table>        
               </form>
               </div>
               </div>
               </div>

               <?php
          }
          ?>
          </div>
          </div>
          <?php
     }
}
?>
</div>
</div>

<?php
$jss = $db->query("SELECT * FROM tbl_cdns WHERE cdn_location = 5 ORDER BY cdn_order");
while($js = $jss->fetch(PDO::FETCH_ASSOC)) {
     echo $js['cdn_script'] ."\r\n";
}
?>

<script>
$(function() {
     $('.mdb-select').materialSelect();
});
$("#page_link").on("change", function() {
     $('#copied_url').val($(this).val());
     $('#copied_url').focus().select();
     //document.execCommand("copy");
})
$(function() {
     $(".dragarea").sortable({
          cancel: ".not-sortable",
          axis: 'y',
          update: function (event, ui) {
               var data = $(this).sortable('serialize');
               $.ajax({
                    data: data,
                    type: 'POST',
                    url: '<?php echo $gbl['site_url'] ?>/sct/ajax/editor.php',
                    success: function(data) {
                         window.location.reload();
                    }
               });
          }
     });
     $(".dragarea").disableSelection();
});
</script>
</body>
</html>