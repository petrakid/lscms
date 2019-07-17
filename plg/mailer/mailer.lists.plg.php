<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
?>
<div class="modal fade" id="listModal" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">List Settings</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body" id="listData">

</div>
<div class="modal-footer">
<button type="button" id="sdeletebutton" class="btn btn-danger btn-sm" onclick="deleteList()">Delete List</button>
<button type="button" id="ssavebutton" class="btn btn-success btn-sm" onclick="saveListSettings()">Save</button>     
<button type="button" id="sclosebutton" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>  
</div>
</div>
</div>
</div>

<div class="modal fade" id="subsModal" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Subscriber Details</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body" id="subsData">

</div>
<div class="modal-footer">
<button type="button" id="subdeletebutton" class="btn btn-danger btn-sm" onclick="deleteSubscriber()">Remove Subscriber</button>
<button type="button" id="subsavebutton" class="btn btn-success btn-sm" onclick="saveSubscriber()">Save Subscriber</button>     
<button type="button" id="subclosebutton" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>  
</div>
</div>
</div>
</div>

<div class="modal fade" id="esubsModal" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Subscriber Details</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body" id="esubsData">

</div>
<div class="modal-footer">
<button type="button" id="esubdeletebutton" class="btn btn-danger btn-sm" onclick="deleteESubscriber()">Remove Subscriber</button>
<button type="button" id="esubsavebutton" class="btn btn-success btn-sm" onclick="saveESubscriber()">Save Subscriber</button>     
<button type="button" id="esubclosebutton" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>  
</div>
</div>
</div>
</div>
<script>
function deleteList()
{
     if(confirm("Are you sure?")) {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
               type: 'POST',
               data: {
                    'delete_list':true,
                    'mail_list_id': document.getElementById('list_id').value
               },
               success: function(data) {
                    document.getElementById('listData').innerHTML = data;
                    document.getElementById('ssavebutton').style.display = "none";
                    document.getElementById('sdeletebutton').style.display = "none";
                    document.getElementById('sclosebutton').innerHTML = "Close";
                    setTimeout(window.location.reload(), 2500);               
               }
          });
     }        
}

function listSettings(list)
{
     $('#sdeletebutton').show();
     $('#ssavebutton').show();
     $('#sclosebutton').html("Cancel");      
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          data: {
               'list_settings':true,
               'list_id': list
          },
          success: function(data) {
               document.getElementById("listData").innerHTML = data;
          }
     });      
}

function saveListSettings()
{
     if($('#listprv').prop('checked')) {
          listprv = 1;
     } else {
          listprv = 0;
     }
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          data: {
               'save_list_settings':true,
               'l_id': document.getElementById('list_id').value,
               's_id': document.getElementById('setting_id').value,
               'from_address': document.getElementById('fromaddr').value,
               'reply_address': document.getElementById('replyto').value,
               'subj_append': document.getElementById('subappend').value,
               'cont_append': document.getElementById('conappend').value,
               'foot_append': document.getElementById('footappend').value,
               'unsub_text': document.getElementById('unsctext').value,
               'unsub_link': document.getElementById('unslink').value,
               'mailer_list_privacy': listprv
          },
          success: function(data) {
               document.getElementById('listData').innerHTML = data;
               $('#sdeletebutton').hide();                
               $('#ssavebutton').hide();
               $('#sclosebutton').html("Close");                
          }
     });   
}

function editSubscriber(subscriber, listid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          data: {
               'edit_subscriber':true,
               's_id': subscriber,
               'l_id': listid
          },
          success: function(data) {
               document.getElementById('subsData').innerHTML = data;
          }
     });      
}

function editESubscriber(subscriber)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          data: {
               'edit_e_subscriber':true,
               's_id': subscriber,
          },
          success: function(data) {
               document.getElementById('esubsData').innerHTML = data;
          }
     });      
}

function saveSubscriber()
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          data: {
               'save_subscriber':true,
               's_id': document.getElementById('sub_id').value,
               'l_id': document.getElementById('slist_id').value,
               's_name': document.getElementById('sub_name').value,
               's_email': document.getElementById('sub_email').value,
          },
          success: function(data) {
               document.getElementById('subsData').innerHTML = data;
               document.getElementById('subsavebutton').style.display = "none";
               document.getElementById('subclosebutton').innerHTML = "Close";
               window.location.reload();               
          }
     });       
}

function saveESubscriber()
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          data: {
               'save_e_subscriber':true,
               's_id': document.getElementById('sub_id').value,
               's_name': document.getElementById('sub_name').value,
               's_email': document.getElementById('sub_email').value,
          },
          success: function(data) {
               document.getElementById('esubsData').innerHTML = data;
               document.getElementById('esubsavebutton').style.display = "none";
               document.getElementById('esubclosebutton').innerHTML = "Close";
               window.location.reload();               
          }
     });       
}

function deleteSubscriber()
{
     if(confirm("Are you sure?")) {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
               type: 'POST',
               data: {
                    'delete_subscriber':true,
                    's_id': document.getElementById('sub_id').value,
                    'l_id': document.getElementById('slist_id').value
               },
               success: function(data) {
                    document.getElementById('subsData').innerHTML = data;
                    document.getElementById('subsavebutton').style.display = "none";
                    document.getElementById('subdeletebutton').style.display = "none";
                    document.getElementById('subclosebutton').innerHTML = "Close";
                    setTimeout(window.location.reload(), 2500);               
               }
          });
     }      
}

function deleteESubscriber()
{
     if(confirm("Are you sure?")) {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
               type: 'POST',
               data: {
                    'delete_subscriber':true,
                    's_id': document.getElementById('sub_id').value,
               },
               success: function(data) {
                    document.getElementById('esubsData').innerHTML = data;
                    document.getElementById('esubsavebutton').style.display = "none";
                    document.getElementById('esubdeletebutton').style.display = "none";
                    document.getElementById('esubclosebutton').innerHTML = "Close";
                    setTimeout(window.location.reload(), 2500);               
               }
          });
     }      
}

function addList()
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          data: {
               'add_list':true,
               'list_name': document.getElementById('newlist').value
          },
          success: function(data) {
               alert(data);
               window.location.reload();
          }
     });     
}
</script>
<div class="row">

<?php
$sqli = $db->query("SELECT * FROM tbl_mailing_lists WHERE list_status = 1 ORDER BY list_name ASC");
while($lst = $sqli->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <div class="col-3">
     <ul class="list-group" style="color: black;">     
     <?php
     $sqlu = $db->query("SELECT * FROM tbl_mailing_subscribers WHERE subscriber_list_id = $lst[l_id] AND subscriber_status = 1 ORDER BY subscriber_name ASC");
     $scount = $sqlu->rowCount();
     ?>
     <li style="cursor: pointer; color: blue;" data-toggle="modal" data-target="#listModal" onclick="listSettings('<?php echo $lst['l_id'] ?>')" class="list-group-item"> <span class="badge badge-danger"><?php echo $scount ?></span> <?php echo stripslashes($lst['list_name']) ?> <?php if($lst['list_privacy'] == 1) { echo '<small class="text-muted">Private</small>';} ?></li>
     <?php
     if($scount > 0) {
          echo '<ul style="list-style: none;">';
          while($sub = $sqlu->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <li style="cursor: pointer; color: fuchsia;" onclick="editSubscriber(<?php echo $sub['s_id'] ?>, <?php echo $lst['l_id'] ?>)" data-toggle="modal" data-target="#subsModal" title="<?php echo $sub['subscriber_email'] ?>"><?php echo $sub['subscriber_name'] ?></li>
               <?php
          }
     }
     ?>
     </ul>
     </div>
     <?php
}
$plg = $db->query("SELECT pl_id FROM tbl_plugins WHERE plugin_file = 'calendars' AND plugin_status = 1");
if($plg->rowCount() > 0) {
     ?>
     <div class="col-3">
     <ul class="list-group">
     <?php
     $sqlc = $db->query("SELECT * FROM tbl_calendars_subscribers WHERE subscriber_status = 1 ORDER BY subscriber_email");
     $ccnt = $sqlc->rowCount();
     ?>
     <li style="cursor: pointer; color: blue;" class="list-group-item"> <span class="badge badge-danger"><?php echo $ccnt ?></span> Events Reminders</li>
     <?php if($ccnt > 0) {
         echo '<ul style="list-style: none">';
         while($cl = $sqlc->fetch(PDO::FETCH_ASSOC)) {
             ?>
             <li style="cursor: pointer; color: fuchsia;" onclick="editESubscriber(<?php echo $cl['s_id'] ?>)" data-toggle="modal" data-target="#esubsModal"><?php echo $cl['subscriber_email'] ?></li>
             <?php
         }
     }
     ?>
     </ul>     
         
     </div>
     <?php
}
?>
</div>
<div class="row">
<div class="col-3">
<small class="form-text text-muted m2" id="listResults">Create a New List</small>
<input type="text" name="newlist" id="newlist" class="form-control" /><br />
<button type="button" class="btn btn-success" onclick="addList()"><i class="fa fa-plus"></i> Add</button>
</div>
</div>
