<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
?>
<script>
function editMailer(mid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          data: {
               'edit_mailer':true,
               'mailer_id': mid
          },
          success: function(data) {
               document.getElementById("mailResults").innerHTML = data;
               CKEDITOR.replace('em_content');
               $(function() {
                    $('#edatetimepicker'+mid).datetimepicker({
                         format: 'MM/DD/YYYY'
                    });
               });
               document.getElementById('savebutton').style.display = "inline";
               document.getElementById('closebutton').innerHTML = "Cancel";
          }
     });   
}
</script>
<script>
function saveMailer(mid)
{
     for (instance in CKEDITOR.instances) {
          CKEDITOR.instances[instance].updateElement();
     }
     content = CKEDITOR.instances.em_content.getData();     
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          data: {
               'save_mailer':true,
               'mailer_id': document.getElementById('emid').value,
               'mailer_subject': document.getElementById('em_subject').value,
               'mailer_date': document.getElementById('em_date').value,
               'mailer_list': document.getElementById('em_list').value,
               'mailer_content': content
          },
          success: function(data) {
               document.getElementById('mailResults').innerHTML = data;
               document.getElementById('savebutton').style.display = "none";
               document.getElementById('closebutton').innerHTML = "Close";               
          }
     });   
}
</script>
<script>
function delMailer(mid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          data: {
               'delete_mailer':true,
               'mailer_id': mid
          },
          success: function(data) {
               document.getElementById("mailer"+mid).style.display = "none";
          }
     });      
}
</script>
<!-- Edit Modal -->
<div id="edit_Modal" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Cancel"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Edit Mailing</h4>
</div>     
<div class="modal-body" id="mailResults">
     
</div>     
<div class="modal-footer">
<button type="button" id="savebutton" class="btn btn-success" onclick="saveMailer()">Save/Publish</button>     
<button type="button" id="closebutton" class="btn btn-unique" data-dismiss="modal">Cancel</button>     
</div>     
</div><!-- /.modal-content -->     
</div><!-- /.modal-dialog -->     
</div><!-- /.modal -->
  
<table class="table responsive table-striped table-bordered">
<thead>
<tr>
<th>Mailing Subject</th>
<th>Mailing List</th>
<th>Status</th>
<th>Options</th>
</tr>
</thead>

<tbody>
<?php
$sqla = $db->query("SELECT * FROM tbl_mailings WHERE mailing_status != 9 ORDER BY mailing_date DESC");
while($ml = $sqla->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <tr id="mailer<?php echo $ml['m_id'] ?>">
     <td><?php echo stripslashes($ml['mailing_subject']) ?></td>
     <td>
     <?php
     $sqll = $db->query("SELECT list_name FROM tbl_mailing_lists WHERE l_id = $ml[mailing_list_id]");
     $lst = $sqll->fetch(PDO::FETCH_ASSOC);
     echo stripslashes($lst['list_name']);
     ?>
     </td>
     <td>
     <?php
     switch($ml['mailing_status']) {
          case 0:
               echo '<i>Draft</i>';
               break;
          case 1:
               echo '<b>Published</b>';
               break;
          case 2:
               echo '<em>Scheduled</em>';
               break;
          case 3:
               echo '<em>Pending...</em>';
               break;
          default:
               break;
     }
     ?>
     </td>
     <td>
     <a href="#" data-toggle="modal" data-target="#edit_Modal" onclick="editMailer('<?php echo $ml['m_id'] ?>')"><button type="button" class="btn btn-sm btn-pink" title="Edit"><i class="fa fa-pencil"></i></button></a>
     <button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="delMailer('<?php echo $ml['m_id'] ?>')"><i class="fa fa-times"></i></button>
     </td>
     </tr>
     <?php
}
?>
</tbody>

</table>