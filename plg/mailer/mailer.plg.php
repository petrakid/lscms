<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
?>

<div class="col-4">
<select name="m_list" id="m_list" class="mdb-select md-form" required="required">
<option value="" disabled selected>Select a List</option>
<?php
$sqll = $db->query("SELECT l_id, list_name FROM tbl_mailing_lists WHERE list_status = 1 ORDER BY list_name ASC");
while($lst = $sqll->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <option value="<?php echo $lst['l_id'] ?>"><?php echo stripslashes($lst['list_name']) ?></option>
     <?php
}
?>
</select>
<small class="form-text text-muted">You can create a new List under the Mailing Lists Manager.</small>
</div>

<div class="col-4">
<div class="md-form">
<small class="form-text mb-0">Date of Mailing</small>
<input type="date" name="m_date" id="m_date" onblur="theDate()" value="<?php echo date('Y-m-d') ?>" onemptied="theDate()" class="form-control mt-0" required="required" />
<small class="form-text text-muted mb-4">Past dates will be sent immediately, future dates will be scheduled and sent on the date entered.</small>
</div>
</div>

<div class="md-form">
<input type="text" name="m_subject" id="m_subject" class="form-control" required="required" />
<label for="m_subject">Subject for Mailing</label>
<small class="form-text text-muted mb-4">Required.  Will be the subject line in the Email.</small>
</div>

<b>Mailing Content</b><br />
<textarea name="m_content" id="m_content" required="required"></textarea>
<script>
CKEDITOR.replace('m_content', {
     customConfig: '<?php echo $gbl['site_url'] ?>/js/ckeditor_config.js'                   
});
</script>
<small class="form-text text-muted mb-4">You may include any HTML (rich text, images, embeds, tables, etc.) in the content.</small>

<input type="button" name="publish" id="publish" value="Enter a Date" onclick="submitMailer()" disabled="disabled" class="btn btn-success" />
<input type="button" name="saveDraft" id="saveDraft" onclick="saveDraft()" value="Save Draft" class="btn btn-warning" />
<div id="m_result"></div>
<script>
$(function() {
     var setdate = $('#m_date').val();
     var myDate = new Date(setdate);
     var today = new Date();
     if(myDate == '') {
          document.getElementById('publish').value = "Enter a Date";
          document.getElementById('publish').disabled = true;
          document.getElementById('publish').setAttribute('name', '');
     }
     if(myDate <= today) {
          document.getElementById('publish').value = "Publish";
          document.getElementById('publish').disabled = false;
          document.getElementById('publish').setAttribute('name', 'publish');                   
     }
     if(myDate > today) {
          document.getElementById('publish').value = "Schedule";
          document.getElementById('publish').disabled = false;
          document.getElementById('publish').setAttribute('name', 'schedule');                              
     }
})
function theDate()
{
     var setdate = $('#m_date').val();
     var myDate = new Date(setdate);
     var today = new Date();
     if(myDate == '') {
          document.getElementById('publish').value = "Enter a Date";
          document.getElementById('publish').disabled = true;
          document.getElementById('publish').setAttribute('name', '');
     }
     if(myDate <= today) {
          document.getElementById('publish').value = "Publish";
          document.getElementById('publish').disabled = false;
          document.getElementById('publish').setAttribute('name', 'publish');                   
     }
     if(myDate > today) {
          document.getElementById('publish').value = "Schedule";
          document.getElementById('publish').disabled = false;
          document.getElementById('publish').setAttribute('name', 'schedule');                              
     }    
}
function submitMailer()
{
     for(instance in CKEDITOR.instances)
          CKEDITOR.instances[instance].updateElement();
     $('#publish').prop('disabled', true);
     $('#publish').val('Please wait...');
     $('#saveDraft').hide();   
     m_date = $('#m_date').val();
     m_subject = $('#m_subject').val();
     content = CKEDITOR.instances.m_content.getData();
     m_list = $('#m_list').val();
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          data: {
               'publish': 1,
               'm_date': m_date,
               'm_subject': m_subject,
               'm_content': content,
               'm_list': m_list
          },
          error: function (xhr, ajaxOptions, thrownError) {
               alert(xhr.status);
               alert(thrownError);
          },          
          success: function(data) {
               if(data == '0') {
                    $('#m_result').html('<div class="alert alert-danger">There was an issue storing the data and the mailing was not sent.</div>');
                    $('#publish').show();                                        
               } else {
                    $('#publish').hide();
                    $('#m_result').html(data);
                    setTimeout(function() {
                         window.location.reload()
                    }, 2000)
               }
          }
     })
}

function saveDraft()
{
     alert('off for now');
} 
</script>