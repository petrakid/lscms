<?php
if($_GET['p'] >= 1000) {
     if($_SESSION['user']['security'] < 9) {
          echo 'Sorry, this page can only be edited by the Administrator, since it is an administrative page.';
          die;
     }
}
?>

<script>
function loadPageSettings(pid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
          type: 'POST',
          data: {
               'load_page_settings': 1,
               'page': pid
          },
          success: function(data) {
               $('#pagesettingsRes').html(data);
               var ju = $('.jfileUpload').file_upload();
               ju.on('file_upload.beforeClear', function(event, element){
                    return confirm("Are you Sure?");
               });
               ju.on('file_upload.afterClear', function(event, element) {
                    $.ajax({
                         url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
                         type: 'POST',
                         data: {
                              'delete_jumbo': 1,
                              'pid': pid
                         }
                    })
               })               
               var pu = $('.pfileUpload').file_upload();
               pu.on('file_upload.beforeClear', function(event, element){
                    return confirm("Are you Sure?");
               });
               pu.on('file_upload.afterClear', function(event, element) {
                    $.ajax({
                         url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
                         type: 'POST',
                         data: {
                              'delete_pimage': 1,
                              'pid': pid
                         }
                    })
               }) 
               $(function() {
                    $('.jfileUpload').change(function() {
                         var fd = new FormData();
                         var file = $('#jumbotron_image')[0].files[0];
                         fd.append('jfile', file);
                         fd.append('pageid', pid);
                         fd.append('field', 'jumbotron_image');
                         fd.append('upload_image', 1);
                         $.ajax({
                              url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
                              type: 'POST',
                              data: fd,
                              contentType: false,
                              processData: false,
                              success: function(data) {
                                   if(data != 0) {
                                        $('#pjumbotron_image').show();
                                   } else {
                                        toastr.error("Something went wrong, please try again", "Upload Error");
                                   }
                              }
                         })
                    })
               })
               $(function() {
                    $('.pfileUpload').change(function() {
                         var fd = new FormData();
                         var file = $('#page_image')[0].files[0];
                         fd.append('pfile', file);
                         fd.append('pageid', pid);
                         fd.append('field', 'page_image');
                         fd.append('upload_image', 1);
                         $.ajax({
                              url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
                              type: 'POST',
                              data: fd,
                              contentType: false,
                              processData: false,
                              success: function(data) {
                                   if(data != 0) {
                                        $('#ppage_image').show();
                                   } else {
                                        toastr.error("Something went wrong, please try again", "Upload Error");
                                   }
                              }
                         })
                    })
               })
               $(function() {
                    $('.mdb-select').materialSelect();
               });                              
          }
     })
}

function savePageSetting(f,v,i)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
          type: 'POST',
          data: {
               'save_field': 1,
               'f': f,
               'v': v,
               'pid': i 
          },
          success: function(data) {
               $('#p' + f).show();
          }
     })     
}
function loadBlocks(pid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
          type: 'POST',
          data: {
               'load_blocks': 1,
               'page': pid
          },
          success: function(data) {
               $('#blocksettingsRes').html(data);
               $(function() {
                    $('#block_id').materialSelect();
               });
               $(function() {
                    $('.mdb-selectb').materialSelect();
               });                              
          }
     })     
}
function selectBlock(blockid)
{
     $('#selectdiv').css("background-color", "gray");
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
          type: 'POST',
          data: {
               'select_block': 1,
               'b_id': blockid
          },
          success: function(data) {
               $('#blockRes').html(data);
               $(function() {
                    $('.mdb-selectr').materialSelect();
                    $('.mdb-selectg').materialSelect();
               });                 
          }
     })     
}
function addBlock(pageid)
{
   $.ajax({
       url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
       type: 'POST',
       data: {
          'new_block': true,
          'page_id': pageid
       },
       success: function(data) {
          loadBlocks(pageid);
          toastr.success("Block added successfully!", "Success!");
       }
   });     
}
function updateBlock(f, v, b)
{
     if(v == 'check_status') {
          if($('#' + f).prop('checked')) {
               v = 1;
          } else {
               v = 0;
          }
     }
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
          type: 'POST',
          data: {
               'update_block': 1,
               'f': f,
               'v': v,
               'b_id': b
          },
          success: function(data) {
               $('#b' + f).show();
          }
     })
}
function viewHistoric(histid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
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
          url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
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
function updateTest()
{
     trans = $('#transparent').val();
     opc = trans / 100;
     $('#testimage').css('opacity', opc);
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
     $('#menu_link').val(mlink);     
}
</script>

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

<div class="modal-puller">
<a onclick="loadPageSettings(<?php echo $_GET['p'] ?>)" href="#pagesettingsModal" data-toggle="modal" rel="tooltip" data-original-title="Page Settings" data-placement="left" title="Page Settings" class="material-tooltip-main"><i class="fa fa-file-alt fa-2x red-text m-2"></i></a>
</div>
<div class="modal-puller-2">
<a onclick="loadBlocks(<?php echo $_GET['p'] ?>)" href="#blocksettingsModal" data-toggle="modal" rel="tooltip" data-original-title="Block Settings" data-placement="left" title="Block Settings" class="material-tooltip-main"><i class="fa fa-th-large fa-2x blue-text m-2"></i></a>
</div>

<div class="modal fade right" id="pagesettingsModal" tabindex="-1" role="dialog" aria-labelledby="pagesettingsModalL" aria-hidden="true">
<div class="modal-dialog modal-full-height modal-right modal-notify modal-danger" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title w-100" id="pagesettingsModalL">Page Settings</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-file white-text fa-2x m-0 p-0"></i></span></button>
</div>
<div class="modal-body mx-3" id="pagesettingsRes">

</div>
</div>
</div>
</div>

<div class="modal fade right" id="blocksettingsModal" tabindex="-1" role="dialog" aria-labelledby="blocksettingsModalL" aria-hidden="true">
<div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title w-100" id="blocksettingsModalL">Block Settings</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-th-large white-text fa-2x m-0 p-0"></i></span></button>
</div>
<div class="modal-body" id="blocksettingsRes">

</div>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row" style="background-color: transparent !important;">
<?php
$blocks = $db->query("SELECT * FROM tbl_blocks WHERE block_status = 1 AND page_id = $_GET[p] ORDER BY grid_order");
while($block = $blocks->fetch(PDO::FETCH_ASSOC)) {
     $rgb = hex2rgb($block['block_color']);
     $rgb = implode(",", $rgb);     
     ?>
     <div class="col-<?php echo $block['grid_width'] ?> <?php if($block['edge_padding'] == 0) { echo 'no-padding'; } ?>">
     <div class="card" style="background-color: rgba(<?php echo $rgb ?>,<?php echo $block['transparent'] ?>);">
     <div class="card-body <?php if($block['edge_padding'] == 0) { echo 'no-padding'; } ?>" style="opacity: 1.0 !important;">
     <div id="block_content<?php echo $block['b_id'] ?>" contenteditable="true">
     <?php echo $block['block_content'] ?>
     </div>
     <script>
     CKEDITOR.disableAutoInline = true;
     CKEDITOR.inline('block_content<?php echo $block['b_id'] ?>', {
          customConfig: '<?php echo $gbl['site_url'] ?>/js/ckeditor_config.js',
          extraPlugins: 'sourcedialog',
          on: {
               blur: function(e) {
                    var field = 'block_content';
                    var value = e.editor.getData();
                    $.ajax({
                         url: '<?php echo $gbl['site_url'] ?>/plg/editor/ajax.php',
                         type: 'POST',
                         data: {
                              'update_content': 1,
                              'block_id': '<?php echo $block['b_id'] ?>',
                              'content': value
                         },
                         success: function(data) {
                              for(name in CKEDITOR.instances) {
                                   CKEDITOR.instances[name].destroy()
                              }                        
                              toastr.success("Content Saved Successfully", "Saved!");
                              setTimeout(function() {
                                   window.location.reload()
                              }, 2000)
                         }
                    })
               }
          }
     })    
     </script>
     </div>
     </div>
     </div>
     <?php
}
?>
</div>
</div>
