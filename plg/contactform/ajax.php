<?php
session_start();

include '../../ld/db.inc.php';

if(isset($_POST['sformdata'])) {
     $resp = '';
     $fieldcnt = count($_POST['sformdata']);
     $sql = $db->query("SELECT * FROM tbl_contactform WHERE f_id = $_POST[sform_id]");
     $frm = $sql->fetch(PDO::FETCH_ASSOC);
     switch($frm['send_type']) {
          case 1:
               $resp = sendEmail($_POST['sformdata'], $frm);
               break;
          case 2:
               $data = '';
               foreach($_POST['sformdata'] AS $key => $val) {
                    $data .= $key .' -> '. $val .',';
               }
               $sql = $db->exec("INSERT INTO tbl_contactform_data (`sub_date`, `sub_data`) VALUES (now(), '$data')");
               $resp = 'Data saved to database';
               break;
          case 3:
               foreach($_POST['sformdata'] AS $key => $val) {
                    $resp .= $key .' -> '. $val .'<br />';
               }
               break;
          default:
               $resp = 'Something didn\'t work';
               break;
     }
     echo $resp;
}

if(isset($_POST['form_id'])) {
     $db->exec("UPDATE tbl_contactform SET form_data = ". $db->quote($_POST['formdata']) ." WHERE f_id = '$_POST[form_id]'");
     echo 'Form Data Saved';
     die;
}


function sendEmail($data, $form)
{
     $subj = $form['to_subject'];
     $to = $form['to_email'];
     $cc = $form['cc_email'];
     $bcc = $form['bcc_email'];
     $from = $form['from_email'];
     $type = $form['email_type'];
     $mtop = $form['to_message_top'];
     $mbottom = $form['to_message_bottom'];
     if($type == 'PLAIN') {
          $msg = '';
          $msg .= $mtop ."\r\n\r\n";
          foreach($data AS $key => $val) {
               $msg .= strtoupper($key) ." -> ". $val ."\r\n\r\n";
          }
          $msg .= $mbottom;
          $headers = "From: ". $from ."\r\n";
          if(mail($to, $subj, $msg, $headers)) {
               echo 'Your message has been sent!';
          } else {
               echo 'There was a problem sending your message.';
          }          
     }
     else if($type == "HTML") {
          $msg = '';
          $msg .= $mtop .'<br /><br />';
          foreach($data AS $key => $val) {
               $msg .= strtoupper($key) .' -> '. $val .'<br /><br />';
          }
          $msg .= $mbottom;
          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
          $headers .= 'From: <'. $from .">\r\n";
          $headers .= 'CC: <'. $cc .">\r\n";
          $headers .= 'BCC: <'. $bcc .">\r\n";
          if(mail($to, $subj, $msg, $headers)) {
               echo 'Your message has been sent!';
          } else {
               echo 'There was a problem sending your message.';
          }          
     }
}

if(isset($_POST['form_settings'] )) {
     $sql = $db->query("SELECT * FROM tbl_contactform WHERE page_id = $_POST[pg_id]");
     $frm = $sql->fetch(PDO::FETCH_ASSOC);
     ?>
     <input type="hidden" name="formid" id="formid" value="<?php echo $frm['f_id'] ?>" />
     <h5 class="h5">These settings affect how the form data is processed.</h5>
     <div class="md-form">
     <input type="email" name="toemail" id="toemail" value="<?php echo $frm['to_email'] ?>" class="form-control" required="required" />
     <label for="toemail">Email Address of person who receives the Form Data</label>
     </div>
     <div class="md-form">
     <input type="text" name="subject" id="subject" value="<?php echo stripslashes($frm['to_subject']) ?>" class="form-control" required="required" />
     <label for="subject">Subject of Email</label>
     </div>
     <div class="md-form">
     <input type="text" name="toptext" id="toptext" value="<?php echo stripslashes($frm['to_message_top']) ?>" class="form-control" />
     <label for="toptext">Text at the top of the email message</label>
     <small class="form-text text-muted">If you want to include some text or a message to whomever receives this email, enter it here.</small>
     </div>
     <div class="md-form">
     <input type="text" name="bottomtext" id="bottomtext" value="<?php echo stripslashes($frm['to_message_bottom']) ?>" class="form-control" />
     <label for="bottomtext">Text at the bottom of the email message</label>
     <small class="form-text text-muted">If you want to include some text or a message to whomever receives this email, enter it here.</small>
     </div>
     <div class="md-form">
     <input type="email" name="ccemail" id="ccemail" value="<?php echo $frm['cc_email'] ?>" class="form-control" />
     <label for="ccemail">Send a Carbon Copy of this email to:</label>
     <small class="form-text text-muted">Not required, but a good way to have another person receive the email.</small>
     </div>
     <div class="md-form">
     <input type="email" name="bccemail" id="bccemail" value="<?php echo $frm['bcc_email'] ?>" class="form-control" required="required" />
     <label for="bccemail">Send a Blind Carbon Copy of this email to:</label>
     <small class="form-text text-muted">Add another receiver to the email, but without anyone knowing.</small>
     </div>
     <div class="md-form">
     <input type="email" name="fromemail" id="fromemail" value="<?php echo $frm['from_email'] ?>" class="form-control" required="required" />
     <label for="fromemail">The "From" Email Address</label>
     <small class="form-text text-muted">Your Administrator should have created a "no reply" or "do not reply" type email address for you which you should enter here.</small>
     </div>
     
     <small class="form-text text-muted">Email Type</small>     
     <select name="emailtype" id="emailtype" class="mdb-select">
     <option selected="selected" value="<?php echo $frm['email_type'] ?>"><?php echo $frm['email_type'] ?></option>
     <option value="HTML">HTML Email</option>
     <option value="PLAIN">Plaintext Email</option>
     </select>
     
     <small class="form-text text-muted">Contact Data Destination</small>
     <select name="sendtype" id="sendtype" class="mdb-select">
     <option selected="selected" value="<?php echo $frm['send_type'] ?>" class="form-control">Leave Unchanged</option>
     <option value="1">Email (using the options above)</option>
     <option value="2">Save to the Database</option>
     <option value="3">Just print on the screen</option>
     </select>
     
     <button type="button" class="btn btn-success btn-block" onclick="saveOptions()">Save Changes</button>
     <?php
}

if(isset($_POST['save_options'])) {
     $formid = $_POST['formid'];
     unset($_POST['formid']);
     unset($_POST['save_options']);
     $_POST['to_subject'] = addslashes($_POST['to_subject']);
     $_POST['to_message_top'] = addslashes($_POST['to_message_top']);
     $_POST['to_message_bottom'] = addslashes($_POST['to_message_bottom']);

     $cnt = 0;
     $sql = "UPDATE tbl_contactform SET ";
     foreach($_POST AS $key => $val) {
          $cnt++;
          if($cnt == 9) {
               $sql .= "$key = '$val' ";
          } else {
               $sql .= "$key = '$val', ";
          }
     }
     $sql .= "WHERE f_id = $formid";
     if($db->exec($sql)) {
          echo 'Form Settings Saved';
     } else {
          echo 'There was a problem saving this data';
     }
}