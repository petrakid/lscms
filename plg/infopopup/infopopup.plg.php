<div id="popupeditor" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Edit Popup</h4>
</div>
<div class="modal-body" id="popup_body">


</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary" id="ppsavebutton" onclick="savePopup()">Save Changes</button>
</div>
</div>
</div>
</div>

<table class="table table-striped table-bordered responsive">
<tr>
<th>Name</th>
<th>Text</th>
<th>Status</th>
<th>Frequency</th>
<th>Page</th>
</tr>
<?php
$pop = $db->query("SELECT * FROM tbl_infopopup WHERE popup_status != 9 ORDER BY pp_id ASC");
while($pp = $pop->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <tr>
     <td><a href="#" data-toggle="modal" data-target="#popupeditor" onclick="editPopup(<?php echo $pp['pp_id'] ?>)" style="text-decoration: none;"><?php echo $pp['popup_name'] ?></a></td>
     <td><?php echo $pp['popup_text'] ?></td>
     <td>
     <?php
     if($pp['popup_status'] == 1) {
          echo 'Active';
     } else {
          echo 'Disabled';
     }
     ?>
     </td>
     <td>
     <?php
     if($pp['popup_frequency'] == 1) {
          echo '1 Time per Visit';
     } else {
          echo 'Every Visit';
     }
     ?>
     </td>
     <td>
     <?php 
     $ppag = $db->query("SELECT menu_name FROM tbl_pages WHERE p_id = $pp[popup_page]"); 
     if($ppag->rowCount() == 0) {
          echo 'All Pages';
     } else {
          $ppg = $ppag->fetch(PDO::FETCH_ASSOC);
          echo $ppg['menu_name'];
     }
     ?>
     </td>
     </tr>
     <?php
}
?>
</table>
<div class="row">
<div class="col-lg-12">
<div class="panel">
<div class="panel-body">
<button type="button" class="btn btn-default" onclick="newPopup()">New Popup</button>
<div id="new_popup_res"></div>
</div>
</div>
</div>
</div>

<script>
function editPopup(popid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/infopopup/ajax.php',
          type: 'POST',
          data: {
               'edit_popup': 1,
               'pp_id': popid
          },
          success: function(data) {
               document.getElementById('popup_body').innerHTML = data;
               CKEDITOR.plugins.addExternal('balloontoolbar', '<?php echo $gbl['site_url'] ?>/js/ckeditor/plugins/balloontoolbar/', 'plugin.js');               
               CKEDITOR.plugins.addExternal('balloonpanel', '<?php echo $gbl['site_url'] ?>/js/ckeditor/plugins/balloonpanel/', 'plugin.js');
               CKEDITOR.plugins.addExternal('jsplus_font_awesome', '<?php echo $gbl['site_url'] ?>/js/ckeditor/plugins/jsplus_font_awesome/', 'plugin.js');
               CKEDITOR.plugins.addExternal('jsplusBootstrapEditor', '<?php echo $gbl['site_url'] ?>/js/ckeditor/plugins/jsplusBootstrapEditor/', 'plugin.js');
               CKEDITOR.plugins.addExternal('jsplusBootstrapTools', '<?php echo $gbl['site_url'] ?>/js/ckeditor/plugins/jsplusBootstrapTools/', 'plugin.js');
               CKEDITOR.plugins.addExternal('jsplusBootstrapWidgets', '<?php echo $gbl['site_url'] ?>/js/ckeditor/plugins/jsplusBootstrapWidgets/', 'plugin.js');
               CKEDITOR.plugins.addExternal('jsplusInclude', '<?php echo $gbl['site_url'] ?>/js/ckeditor/plugins/jsplusInclude/', 'plugin.js');
               CKEDITOR.plugins.addExternal('jsplusTableTools', '<?php echo $gbl['site_url'] ?>/js/ckeditor/plugins/jsplusTableTools/', 'plugin.js');                                                                                          
               CKEDITOR.replace('epopup_text', {
                    extraPlugins: 'balloontoolbar,balloonpanel,jsplus_font_awesome,jsplusBootstrapEditor,jsplusBootstrapTools,jsplusBootstrapWidgets,jsplusInclude,jsplusTableTools',
                    customConfig: '<?php echo $gbl['site_url'] ?>/js/ckeditor/custom-config.js',
                    skin: 'be, <?php echo $gbl['site_url'] ?>/js/ckeditor/skins/be/',
                    filebrowserBrowseUrl : '<?php echo $gbl['site_url'] ?>/js/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                    filebrowserUploadUrl : '<?php echo $gbl['site_url'] ?>/js/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                    filebrowserImageBrowseUrl : '<?php echo $gbl['site_url'] ?>/js/filemanager/dialog.php?type=1&editor=ckeditor&fldr='                    
               });
          }
     });
}
</script>
<script>
function savePopup()
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/infopopup/ajax.php',
          type: 'POST',
          data: {
               'update_popup': 1,
               'pp_id': document.getElementById('epp_id').value,
               'pp_name' : document.getElementById('epopup_name').value,
               'pp_status' : $('input[name="epopup_status"]:checked').val(),
               'pp_frequency' : $('input[name="epopup_frequency"]:checked').val(),
               'pp_page' : document.getElementById('epopup_page').value,
               'pp_text' : CKEDITOR.instances["epopup_text"].getData()              
          },
          success: function(data) {
               document.getElementById('popup_body').innerHTML = data;
               document.getElementById('ppsavebutton').style.display = "none";
          }
     })
}
</script>
<script>
function newPopup()
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/infopopup/ajax.php',
          type: 'POST',
          data: {
               'new_popup': 1
          },
          success: function(data) {
               document.getElementById('new_popup_res').innerHTML = data;
               setTimeout(location.reload(), 2500);
          }
     });
}
</script>
<script>
$('#popupeditor').on('hidden.bs.modal', function () {
  location.reload();
})
</script>