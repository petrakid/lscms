<?php
session_start();

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['add_form'])) {
     $chk = $db->query("SELECT f_id FROM tbl_forms_data WHERE form_name = '$_POST[form_name]' AND form_status != 9");
     if($chk->rowCount() > 0) {
          echo 'The Name you used for the form is already taken.  Please rename and save again.';
     } else {
          $formname = addslashes($_POST['form_name']);
          $formdata = addslashes($_POST['form_data']);
          $formsubject = addslashes($_POST['form_subject']);
          $headingtext = addslashes($_POST['form_heading_text']);
          $footertext = addslashes($_POST['form_footer_text']);
          $db->exec("INSERT INTO tbl_forms_data (form_name, form_data, form_status, form_from_email, form_to_email, form_subject, form_heading_text, form_footer_text) VALUES ('$formname', '$formdata', '1', '$_POST[form_from_email]', '$_POST[form_to_email]', '$formsubject', '$headingtext', '$footertext')");
     }
}

if(isset($_POST['get_fdata'])) {
     $form = $db->query("SELECT form_data FROM tbl_forms_data WHERE f_id = $_POST[f_id]");
     $f = $form->fetch(PDO::FETCH_ASSOC);
     echo $f['form_data'];     
}

if(isset($_POST['edit_form'])) {
     $form = $db->query("SELECT * FROM tbl_forms_data WHERE f_id = $_POST[form_id]");
     $f = $form->fetch(PDO::FETCH_ASSOC);
     ?>
     <ul class="nav md-pills pills-secondary">
     <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">Form Editor</a></li>
     <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panel2" role="tab">Settings</a></li>
     </ul>
     
     <div class="tab-content pt-0">
     <div class="tab-pane fade in show active" id="panel1" role="tabpanel">
     <div class="row">
     <div class="col-md-12">
     <div class="card">
     <div class="card-body">
     <h5 class="card-title">Form Creator</h5>
     <p>Use the following options to modify your form, dragging and dropping items where you'd like in the form.  You can add as many fields as you like.  BE SURE to provide all of the required information for each field, as well
     as the Form Submission information.  When finished, click "Save Form".</p>
       
     <hr />
     <div class="row">
     <div class="col-md-12">
     <div id="form-editor">
     
     </div>
     </div>
     </div>
     </div>
     </div>
     </div>
     </div>
     </div>
     
     <div class="tab-pane fade in show" id="panel2" role="tabpanel">
     <div class="row">
     <div class="col-md-6">
     <input type="hidden" name="form-id" id="form-id" value="<?php echo $f['f_id'] ?>" />
     <div class="md-form">
     <input type="text" name="form-name" id="form-name" class="form-control" value="<?php echo stripslashes($f['form_name']) ?>" />
     <label for="form-name" class="active">Give this form a name</label>
     </div>
     
     <div class="md-form">
     <input type="text" name="form-subject" id="form-subject" class="form-control" value="<?php echo stripslashes($f['form_subject']) ?>" />
     <label for="form-subject" class="active">Subject for Email</label>
     </div>
     
     <div class="md-form">
     <textarea name="form-heading" id="form-heading" class="md-textarea form-control" rows="4" cols="100%"><?php echo stripslashes($f['form_heading_text']) ?></textarea>
     <label for="form-heading" class="active">Text to prepend to email</label>
     </div>
     
     <div class="md-form">
     <textarea name="form-footer" id="form-footer" class="md-textarea form-control" rows="4" cols="100%"><?php echo stripslashes($f['form_footer_text']) ?></textarea>
     <label for="form-footer" class="active">Text to append to email</label>
     </div>     
     
     
     </div>
     <div class="col-md-6">
     <div class="md-form">
     <input type="email" name="form-from-email" id="form-from-email" class="form-control" aria-labeled-by="senderhelp" value="<?php echo $f['form_from_email'] ?>" />
     <label for="form-from-email" class="active">Sender Email Address</label>
     <small id="senderhelp" class="form-text text-muted">If you leave this field blank, the sender email address will be the email address entered by the form user.</small>
     </div>
     
     <div class="md-form">
     <input type="email" name="form-to-email" id="form-to-email" class="form-control" value="<?php echo $f['form_to_email'] ?>" />
     <label for="form-to-email" class="active">Receiver Email Address</label>
     </div>
     
     </div>
     </div>
     </div>
     </div>     
     
     <?php
}

if(isset($_POST['update_form'])) {
     $formname = addslashes($_POST['form_name']);
     $formdata = addslashes($_POST['form_data']);
     $formsubject = addslashes($_POST['form_subject']);
     $headingtext = addslashes($_POST['form_heading_text']);
     $footertext = addslashes($_POST['form_footer_text']);
     $db->exec("UPDATE tbl_forms_data SET form_name = '$formname', form_data = '$formdata', form_from_email = '$_POST[form_from_email]', form_to_email = '$_POST[form_to_email]', form_subject = '$formsubject', form_heading_text = '$headingtext', form_footer_text = '$footertext' WHERE f_id = $_POST[f_id]");
     echo 'Form Updated Successfully';
}

if(isset($_POST['select_form'])) {
     $db->exec("UPDATE tbl_forms_data SET form_block_id = $_POST[block_id] WHERE f_id = $_POST[form_id]");
}

if(isset($_POST['load_form'])) {
     $frm = $db->query("SELECT form_data FROM tbl_forms_data WHERE form_block_id = $_POST[block_id] AND form_status != 9");
     $fm = $frm->fetch(PDO::FETCH_ASSOC);
     echo $fm['form_data'];
}

if(isset($_POST['sformdata'])) {
     $resp = '';
     $fieldcnt = count($_POST['sformdata']);
     $sql = $db->query("SELECT * FROM tbl_forms_data WHERE form_block_id = $_POST[block_id] AND form_status != 9");
     $frm = $sql->fetch(PDO::FETCH_ASSOC);
     $resp = sendEmail($_POST['sformdata'], $frm);
}

function sendEmail($data, $form)
{
     $subj = $form['form_subject'];
     $to = $form['form_to_email'];
     $mtop = $form['form_heading_text'];
     $mbottom = $form['form_footer_text'];
     $msg = '';
     $msg .= $mtop .'<br />';
     foreach($data AS $key => $val) {
          if($key == 'contact-email-address') {
               if($form['form_from_email'] == '') {
                    $from = $val;
                    $msg .= strtoupper($key) .' -> '. $val .'<br /><br />';
               } else {
                    $from = $form['form_from_email'];
                    $msg .= strtoupper($key) .' -> '. $form['form_from_email'] .'<br /><br />';
               }
          } else {
               $msg .= strtoupper($key) .' -> '. $val .'<br /><br />';
          }
     }
     $msg .= $mbottom;
     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= 'From: <'. $from .">\r\n";
     if(mail($to, $subj, $msg, $headers)) {
          echo '<div class="alert alert-success">Your message has been sent!</div>';
     } else {
          echo '<div class="alert alert-danger">There was a problem sending your message.</div>';
     }          
}
?>