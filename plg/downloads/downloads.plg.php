<script type="text/javascript" src="/js/jquery.jplayer.js"></script>
<script>
$(document).ready(function() {
  $('#sortable').DataTable();
});
</script>
<link type="text/css" href="/css/jplayer.blue.monday.css" rel="stylesheet" />
<link rel="stylesheet" href="/css/bootstrap-datepicker3.min.css" />
<script src="/js/bootstrap-datepicker.js"></script>
<?php
if(isset($_SESSION['isLoggedIn'])) {
     echo '<button type="button" class="btn btn-warning btn-block new_download" data-toggle="modal" data-target="#add_download_modal">Add Downloadable</button>';
}
?>
<div class="table-responsive">
<table class="table table-hover" id="sortable">
<thead>
<tr>
<?php
if(isset($_SESSION['isLoggedIn'])) {
     ?>
     <th></th>
     <?php
}
?>
<th>Title</th>
<th>Author</th>
<th>Description</th>
<th>File</th>
</tr>
</thead>

<tfoot>
<tr>
<?php
if(isset($_SESSION['isLoggedIn'])) {
     ?>
     <th></th>
     <?php
}
?>
<th>Title</th>
<th>Author</th>
<th>Description</th>
<th>File</th>
</tr>
</tfoot>

<tbody>
<?php
$sql = $db->query("SELECT * FROM $_SESSION[prefix]_downloads WHERE download_status = 1 AND page_id = $pg[p_id] ORDER BY download_date DESC");
while($dln = $sql->fetch(PDO::FETCH_ASSOC)) {
     echo '<tr>';
     if(isset($_SESSION['isLoggedIn'])) {
          ?>
          <td>
          <button type="button" class="btn btn-default get_data" data-id="<?php echo $dln['d_id'] ?>" data-toggle="modal" data-target="#download_editor_modal">Edit</button>
          <button type="button" class="btn btn-danger get_datad" data-id="<?php echo $dln['d_id'] ?>" data-toggle="modal" data-target="#download_editor_modal">Delete</button>
          </td>
          <?php
     }
     ?>
     <td><?php echo stripslashes($dln['download_title']) ?></td>
     <td><?php echo stripslashes($dln['download_author']) ?></td>
     <td><?php echo stripslashes($dln['download_description']) ?></td>
     <td>
     <?php
     if($dln['download_filetype'] == 'Mp3 Audio') {
          ?>
          <script type="text/javascript">
          $(document).ready(function(){
               $("#jquery_jplayer_<?php echo $dln['d_id'] ?>").jPlayer({
                    ready: function () {
                         $(this).jPlayer("setMedia", {
                              mp3: '<?php echo $gbl['site_url'] ?>/ast/res/<?php echo date('Y', strtotime($dln['download_date'])) ?>/<?php echo $dln['download_filename'] ?>'
                         });
                    },
                    cssSelectorAncestor: "#jp_container_<?php echo $dln['d_id'] ?>",
                    swfPath: "<?php echo $gbl['site_url'] ?>/plg/downloads",
                    supplied: "mp3",
                    useStateClassSkin: true,
                    autoBlur: false,
                    smoothPlayBar: true,
                    keyEnabled: true,
                    remainingDuration: true,
                    toggleDuration: true,
               });
          });
          </script>
          <div id="jquery_jplayer_<?php echo $dln['d_id'] ?>" class="jp-jplayer"></div>
          <div id="jp_container_<?php echo $dln['d_id'] ?>" class="jp-audio" role="application" aria-label="media player">
          <div class="jp-type-single">
          <div class="jp-gui jp-interface">
          <div class="jp-volume-controls">
          <button class="jp-mute" role="button" tabindex="0">mute</button>
          <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
          <div class="jp-volume-bar">
          <div class="jp-volume-bar-value"></div>
          </div>
          </div>
          <div class="jp-controls-holder">
          <div class="jp-controls">
          <button class="jp-play" role="button" tabindex="0">play</button>
          <button class="jp-stop" role="button" tabindex="0">stop</button>
          </div>
          <div class="jp-progress">
          <div class="jp-seek-bar">
          <div class="jp-play-bar"></div>
          </div>
          </div>
          <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
          <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
          <div class="jp-toggles">
          <button class="jp-repeat" role="button" tabindex="0">repeat</button>
          </div>
          </div>
          </div>
          <div class="jp-details">
          <div class="jp-title" aria-label="title"><a href="<?php echo $gbl['site_url'] ?>/ast/res/<?php echo date('Y', strtotime($dln['download_date'])) ?>/<?php echo $dln['download_filename'] ?>" target="_blank" data-tooltip="Right-click to Download" data-toggle="tooltip"><?php echo $dln['download_title'] ?> - Download</a></div>
          </div>
          <div class="jp-no-solution">
          <span>Update Required</span>
          To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
          </div>
          </div>
          </div>                     
          <?php
     }
     if($dln['download_filetype'] == 'Embedded Resource') {
          ?>
          <br /><iframe width="560" height="315" src="<?php echo $dln['download_embed_url'] ?>" frameborder="0" allowfullscreen></iframe><br />
          <?php
     }
     if($dln['download_filetype'] == 'Adobe PDF') {
          echo '<br /><a style="text-decoration: none; color: white;" href="'. $gbl['site_url'] .'/ast/res/'. date('Y', strtotime($dln['download_date'])) .'/'. $dln['download_filename'] .'" target="_blank"><button class="btn btn-primary">Download PDF</button></a>';
     }
     if($dln['download_filetype'] == 'Document') {
          echo '<br /><a style="text-decoration: none; color: white;" href="'. $gbl['site_url'] .'/ast/res/'. date('Y', strtotime($dln['download_date'])) .'/'. $dln['download_filename'] .'" target="_blank"><button class="btn btn-primary">Download Document</button></a>';
     }
     if($dln['download_filetype'] == 'Powerpoint') {
          echo '<br /><a style="text-decoration: none; color: white;" href="'. $gbl['site_url'] .'/ast/res/'. date('Y', strtotime($dln['download_date'])) .'/'. $dln['download_filename'] .'" target="_blank"><button class="btn btn-primary">Download Powerpoint</button></a>';
     }          
     ?>
     </td>
     </tr>
     <?php
}
?>
</tbody>
</table>
</div>

<?php
if(isset($_SESSION['isLoggedIn'])) {
     ?>
     <h3>Deleted Downloadables</h3>
     <div class="table-responsive">
     <table class="table table-hover">
     <thead>
     <tr>
     <?php
     if(isset($_SESSION['isLoggedIn'])) {
          ?>
          <th></th>
          <?php
     }
     ?>
     <th>Date</th>
     <th>Title</th>
     <th>Author</th>
     <th>Description</th>
     <th>File</th>
     </tr>
     </thead>
     
     <tfoot>
     <tr>
     <?php
     if(isset($_SESSION['isLoggedIn'])) {
          ?>
          <th></th>
          <?php
     }
     ?>
     <th>Date</th>
     <th>Title</th>
     <th>Author</th>
     <th>Description</th>
     <th>File</th>
     </tr>
     </tfoot>
     
     <tbody>
     <?php
     $sql2 = $db->query("SELECT * FROM $_SESSION[prefix]_downloads WHERE download_status = 0 AND page_id = $pg[p_id] ORDER BY download_date DESC");
     while($dln2 = $sql2->fetch(PDO::FETCH_ASSOC)) {
          echo '<tr>';
          if(isset($_SESSION['isLoggedIn'])) {
               ?>
               <td>
               <button type="button" class="btn btn-default get_data" data-id="<?php echo $dln2['d_id'] ?>" data-toggle="modal" data-target="#download_editor_modal">Edit</button>
               <button type="button" class="btn btn-danger get_datar" data-id="<?php echo $dln2['d_id'] ?>" data-toggle="modal" data-target="#download_editor_modal">Restore</button>
               </td>
               <?php
          }
          ?>
          <td><?php echo date('M j Y', strtotime($dln2['download_date'])) ?></td>
          <td><?php echo stripslashes($dln2['download_title']) ?></td>
          <td><?php echo stripslashes($dln2['download_author']) ?></td>
          <td><?php echo stripslashes($dln2['download_description']) ?></td>
          <td>
          <?php
          if($dln2['download_filetype'] == 'Mp3 Audio') {
               ?>
               <script type="text/javascript">
               $(document).ready(function(){
                    $("#jquery_jplayer_<?php echo $dln2['d_id'] ?>").jPlayer({
                         ready: function () {
                              $(this).jPlayer("setMedia", {
                                   mp3: '<?php echo $gbl['site_url'] ?>/ast/res/<?php echo date('Y', strtotime($dln2['download_date'])) ?>/<?php echo $dln2['download_filename'] ?>'
                              });
                         },
                         cssSelectorAncestor: "#jp_container_<?php echo $dln2['d_id'] ?>",
                         swfPath: "<?php echo $gbl['site_url'] ?>/plg/downloads",
                         supplied: "mp3",
                         useStateClassSkin: true,
                         autoBlur: false,
                         smoothPlayBar: true,
                         keyEnabled: true,
                         remainingDuration: true,
                         toggleDuration: true,
                    });
               });
               </script>
               <div id="jquery_jplayer_<?php echo $dln2['d_id'] ?>" class="jp-jplayer"></div>
               <div id="jp_container_<?php echo $dln2['d_id'] ?>" class="jp-audio" role="application" aria-label="media player">
               <div class="jp-type-single">
               <div class="jp-gui jp-interface">
               <div class="jp-volume-controls">
               <button class="jp-mute" role="button" tabindex="0">mute</button>
               <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
               <div class="jp-volume-bar">
               <div class="jp-volume-bar-value"></div>
               </div>
               </div>
               <div class="jp-controls-holder">
               <div class="jp-controls">
               <button class="jp-play" role="button" tabindex="0">play</button>
               <button class="jp-stop" role="button" tabindex="0">stop</button>
               </div>
               <div class="jp-progress">
               <div class="jp-seek-bar">
               <div class="jp-play-bar"></div>
               </div>
               </div>
               <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
               <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
               <div class="jp-toggles">
               <button class="jp-repeat" role="button" tabindex="0">repeat</button>
               </div>
               </div>
               </div>
               <div class="jp-details">
               <div class="jp-title" aria-label="title"><a href="<?php echo $gbl['site_url'] ?>/ast/res/<?php echo date('Y', strtotime($dln2['download_date'])) ?>/<?php echo $dln2['download_filename'] ?>" target="_blank" data-tooltip="Right-click to Download" data-toggle="tooltip"><?php echo $dln2['download_title'] ?> - Download</a></div>
               </div>
               <div class="jp-no-solution">
               <span>Update Required</span>
               To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
               </div>
               </div>
               </div>                     
               <?php
          }
          if($dln2['download_filetype'] == 'Embedded Resource') {
               ?>
               <br /><iframe width="560" height="315" src="<?php echo $dln2['download_embed_url'] ?>" frameborder="0" allowfullscreen></iframe><br />
               <?php
          }
          if($dln2['download_filetype'] == 'Adobe PDF') {
               echo '<br /><a style="text-decoration: none; color: white;" href="'. $gbl['site_url'] .'/ast/res/'. date('Y', strtotime($dln2['download_date'])) .'/'. $dln2['download_filename'] .'" target="_blank"><button class="btn btn-primary">Download PDF</button></a>';
          }
          if($dln2['download_filetype'] == 'Document') {
               echo '<br /><a style="text-decoration: none; color: white;" href="'. $gbl['site_url'] .'/ast/res/'. date('Y', strtotime($dln2['download_date'])) .'/'. $dln2['download_filename'] .'" target="_blank"><button class="btn btn-primary">Download Document</button></a>';
          }
          if($dln2['download_filetype'] == 'Powerpoint File') {
               echo '<br /><a style="text-decoration: none; color: white;" href="'. $gbl['site_url'] .'/ast/res/'. date('Y', strtotime($dln2['download_date'])) .'/'. $dln2['download_filename'] .'" target="_blank"><button class="btn btn-primary">Download Powerpoint</button></a>';
          }          
          ?>
          </td>
          </tr>
          <?php
     }
     ?>
     </tbody>
     </table>
     </div>
     <?php
}
?>

<!-- Download Adding Modal -->
<div class="modal fade" id="add_download_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">New Downloadable</h4>
      </div>
      <div class="modal-body" id="add_download_modal_body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Download Editor Modal -->
<div class="modal fade" id="download_editor_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Download Editor</h4>
      </div>
      <div class="modal-body" id="download_editor_modal_body">
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$('#download_editor_modal').on('hidden.bs.modal', function () {
    window.location.reload();
});
</script>
<script>
$(document).ready(function() {
    $(document).on("click",".get_data", function(){
       var downloadid = $(this).attr("data-id");    
       $.ajax({
            url: '<?php echo $gbl['site_url'] ?>/plg/downloads/ajax.php',
            type: "POST",
            data: {
               'd_id': downloadid,
               'page_id': <?php echo $pg['p_id'] ?>,
               'edit': '1',
               'callback': '<?php echo $_SESSION['fullpage'] ?>'             
            },
            dataType: "HTML",
            async: false,
            success: function(data) {
               $('#download_editor_modal_body').html(data);          
           }
         }); 
     });
});
</script>
<script>
$(document).ready(function() {
    $(document).on("click",".get_datad", function(){
       var downloadid = $(this).attr("data-id");    
       $.ajax({
            url: '<?php echo $gbl['site_url'] ?>/plg/downloads/ajax.php',
            type: "POST",
            data: {
               'd_id': downloadid,
               'del': '1'
            },
            dataType: "HTML",
            async: false,
            success: function(data) {
               $('#download_editor_modal_body').html(data);          
           }
         }); 
     });
});
</script>
<script>
$(document).ready(function() {
    $(document).on("click",".get_datar", function(){
       var downloadid = $(this).attr("data-id");    
       $.ajax({
            url: '<?php echo $gbl['site_url'] ?>/plg/downloads/ajax.php',
            type: "POST",
            data: {
               'd_id': downloadid,
               'res': '1'
            },
            dataType: "HTML",
            async: false,
            success: function(data) {
               $('#download_editor_modal_body').html(data);          
           }
         }); 
     });
});
</script>
<script>
$(document).ready(function() {
    $(document).on("click",".new_download", function(){
       $.ajax({
            url: '<?php echo $gbl['site_url'] ?>/plg/downloads/ajax.php',
            type: "POST",
            data: {
               'new_download': '1',
               'page_id': <?php echo $pg['p_id'] ?>,
               'callback': '<?php echo $_SESSION['fullpage'] ?>'
            },
            dataType: "HTML",
            async: false,
            success: function(data) {
               $('#add_download_modal_body').html(data);          
           }
         }); 
     });
});
</script>