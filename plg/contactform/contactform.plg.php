<link rel="stylesheet" href="css/form-render.css" />

<div class="modal fade" id="submit_form" tabindex="-1" role="dialog">
<div class="modal-dialog modal-sm" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Submission Successful!</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body" id="form_submit_modal_body">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<script type="text/javascript" src="js/form-render.js"></script>
<?php
if(isset($_SESSION['isLoggedIn'])) {
     $sqlf = $db->query("SELECT f_id, form_data FROM $_SESSION[prefix]_contactform WHERE page_id = $pg[p_id]");
     if($sqlf->rowCount() == 0) {
          $db->exec("INSERT INTO $_SESSION[prefix]_contactform (page_id) VALUES ('$pg[p_id]')");
          $sqlf = $db->query("SELECT f_id, form_data FROM $_SESSION[prefix]_contactform WHERE page_id = $pg[p_id]");          
     }
     $frmd = $sqlf->fetch(PDO::FETCH_ASSOC);
     ?>
     <link rel="stylesheet" href="css/form-builder.css" />     
     <div class="modal fade" id="manage_forms" tabindex="-1" role="dialog">
       <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title">Form Management</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           </div>
           <div class="modal-body" id="form_manage_modal_body">
           <div class="formBuilder" id="formBuilder"></div>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
         </div>
       </div>
     </div>

     <div class="modal fade" id="form_settings" tabindex="-1" role="dialog">
       <div class="modal-dialog" role="document">
         <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title">Form Settings</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           </div>
           <div class="modal-body" id="form_settings_modal_body">

           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
         </div>
       </div>
     </div>    
     <script>
     $(document).ready(function() {
         $(document).on("click",".get_fsettings", function(){                
            $.ajax({
                 url: '<?php echo $gbl['site_url'] ?>/plg/contactform/ajax.php',
                 type: "POST",
                 data: {
                    'form_settings': '1',
                    'pg_id': <?php echo $pg['p_id'] ?>
                 },
                 dataType: "HTML",
                 async: false,
                 success: function(data) {
                    $('#form_settings_modal_body').html(data);
                    $('.mdb-select').materialSelect();          
                }
              }); 
          });
     });
     </script>     
     <script>
     function saveOptions()
     {
          $.ajax({
                 url: '<?php echo $gbl['site_url'] ?>/plg/contactform/ajax.php',
                 type: "POST",
                 data: {
                    'save_options': '1',
                    'formid': document.getElementById('formid').value,                    
                    'to_email': document.getElementById('toemail').value,
                    'to_subject': document.getElementById('subject').value,
                    'to_message_top': document.getElementById('toptext').value,
                    'to_message_bottom': document.getElementById('bottomtext').value,
                    'cc_email': document.getElementById('ccemail').value,
                    'bcc_email': document.getElementById('bccemail').value,
                    'email_type': document.getElementById('emailtype').value,
                    'send_type': document.getElementById('sendtype').value,
                    'from_email': document.getElementById('fromemail').value
                 },
                 dataType: "HTML",
                 async: false,
                 success: function(data) {
                    $('#form_settings_modal_body').html(data);          
                 }
          }); 
     }
     </script>
     <script>
     function reloadMe()
     {
          window.location.reload();
     }
     </script>
     <script>
     jQuery(document).ready(function($) {
          var $fbEditor = $(document.getElementById('formBuilder'));
          var formData = `<?php echo $frmd['form_data'] ?>`,
          fbOptions = {
               
          };
          if(formData) {
               fbOptions.formData = formData;
          }
          $fbEditor.formBuilder(fbOptions);
          var saveBtn = document.querySelector('.form-builder-save');
          saveBtn.onclick = function() {
               window.sessionStorage.setItem('contFormData', $fbEditor.data('formBuilder').formData);
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/plg/contactform/ajax.php',
                    type: "POST",
                    data: {
                         'form_id': <?php echo $frmd['f_id'] ?>,
                         'formdata': window.sessionStorage.getItem('contFormData')
                    },
                    dataType: "HTML",
                    async: false,
                    success: function(data) {
                         $('#form_manage_modal_body').html(data);
                         reloadMe();          
                    }
               }); 
          };
     });
     </script>
     <script type="text/javascript" src="js/form-builder.js"></script>          
     <?php
     echo '<button type="button" class="btn btn-default manage_forms" data-toggle="modal" data-target="#manage_forms">Manage Form Fields</button>';
     echo '<button type="button" class="btn btn-indigo get_fsettings" data-toggle="modal" data-target="#form_settings">Submit Settings</button>';
}
$sqlg = $db->query("SELECT f_id, form_data FROM tbl_contactform WHERE page_id = $pg[p_id]");
$grmd = $sqlg->fetch(PDO::FETCH_ASSOC);
?>
<script>
jQuery(document).ready(function($) {
     var fbRender = document.getElementById('fb-render'),
     formData = `<?php echo $grmd['form_data'] ?>`;
     var formRenderOpts = {
          formData: formData
     };
$(fbRender).formRender(formRenderOpts);
});
</script>
<form class="fb-render" id="fb-render"></form>
<script>
$('.fb-render').submit(function(event) {
     var o = {};
     var a = $(".fb-render :input").serializeArray();
     $.each(a, function () {
          if(o[this.name] !== undefined) {
              if(!o[this.name].push) {
                  o[this.name] = [o[this.name]];
              }
              o[this.name].push(this.value || '');
          } else {
              o[this.name] = this.value || '';
          }
     });
     $.ajax({          
          url: '<?php echo $gbl['site_url'] ?>/plg/contactform/ajax.php',
          type: "POST",
          data: {
               'sform_id': '<?php echo $grmd['f_id'] ?>',
               'sformdata': o
          },
          dataType: "HTML",
          async: false,
          success: function(data) {
               $(".fb-render").hide();               
               $('#submit_form').modal('show');
               $('#submit_form').on('shown.bs.modal', function() {
                    $(document).off('focusin.modal');
               });                
               $('#form_submit_modal_body').html(data);
          }
     });
     event.preventDefault();
});
</script>
