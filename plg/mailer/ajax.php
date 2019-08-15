<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['edit_subscriber'])) {
     $sub = $db->query("SELECT * FROM tbl_mailing_subscribers WHERE s_id = $_POST[s_id] AND subscriber_list_id = $_POST[l_id]");
     $sb = $sub->fetch(PDO::FETCH_ASSOC);
     ?>
     <form>
     <input type="hidden" name="sub_id" id="sub_id" value="<?php echo $sb['s_id'] ?>" />
     <input type="hidden" name="slist_id" id="slist_id" value="<?php echo $sb['subscriber_list_id'] ?>" />
     <b>Subscriber Name</b><br />
     <input type="text" name="sub_name" id="sub_name" value="<?php echo $sb['subscriber_name'] ?>" class="form-control" /><br /><br />
     <b>Subscriber Email</b><br />
     <input type="email" name="sub_email" id="sub_email" value="<?php echo $sb['subscriber_email'] ?>" class="form-control" />
     </form>
     <?php
}

if(isset($_POST['edit_e_subscriber'])) {
     $sub = $db->query("SELECT * FROM tbl_calendars_subscribers WHERE s_id = $_POST[s_id]");
     $sb = $sub->fetch(PDO::FETCH_ASSOC);
     ?>
     <form>
     <input type="hidden" name="slist_id" id="slist_id" value="<?php echo $sb['subscriber_list_id'] ?>" />
     <input type="hidden" name="sub_id" id="sub_id" value="<?php echo $sb['s_id'] ?>" />
     <b>Subscriber Name</b><br />
     <input type="text" name="sub_name" id="sub_name" value="<?php echo $sb['subscriber_name'] ?>" class="form-control" /><br /><br />
     <b>Subscriber Email</b><br />
     <input type="email" name="sub_email" id="sub_email" value="<?php echo $sb['subscriber_email'] ?>" class="form-control" />
     </form>
     <?php
}


if(isset($_POST['save_subscriber'])) {
     $db->exec("UPDATE tbl_mailing_subscribers SET subscriber_name = '$_POST[s_name]', subscriber_email = '$_POST[s_email]' WHERE s_id = $_POST[s_id] AND subscriber_list_id = $_POST[l_id]");
     echo 'Subscriber Updated';
}

if(isset($_POST['save_e_subscriber'])) {
     $db->exec("UPDATE tbl_calendars_subscribers SET subscriber_name = '$_POST[s_name]', subscriber_email = '$_POST[s_email]' WHERE s_id = $_POST[s_id]");
     echo 'Subscriber Updated';
}


if(isset($_POST['delete_subscriber'])) {
     $db->exec("UPDATE tbl_mailing_subscribers SET subscriber_status = 0, unsubscribe_date = now() WHERE s_id = '$_POST[s_id]' AND subscriber_list_id = '$_POST[l_id]'");
     echo 'Subscriber Removed from this list.';
}

if(isset($_POST['delete_e_subscriber'])) {
     $db->exec("UPDATE tbl_calendars_subscribers SET subscriber_status = 0, unsubscribe_date = now() WHERE s_id = $_POST[s_id]");
     echo 'Subscriber Removed from this list.';
}

if(isset($_POST['delete_list'])) {
     $db->exec("UPDATE tbl_mailing_lists SET list_status = 0 WHERE l_id = $_POST[mail_list_id]");
     $db->exec("UPDATE tbl_mailing_subscribers SET subscriber_status = 0, unsubscribe_date = now() WHERE subscriber_list_id = $_POST[mail_list_id]");
     $db->exec("UPDATE tbl_mailings SET mailing_status = 9 WHERE mailing_list_id = $_POST[mail_list_id]");
     echo 'List deleted successfully and subscribers removed.  All mailings for the list have been disabled.';
}

if(isset($_POST['publish'])) {
     $sql = 'INSERT INTO tbl_mailings (mailing_subject, mailing_date, mailing_list_id, mailing_creator, mailing_status, mailing_content) VALUES (:subject, :date, :list, :creator, 1, :content)';
     $sqld = $db->prepare($sql);
     $sqld->bindValue(':subject', addslashes($_POST['m_subject']));
     $sqld->bindValue(':date', date('Y-m-d', strtotime($_POST['m_date'])));
     $sqld->bindValue(':list', $_POST['m_list']);
     $sqld->bindValue(':creator', $db->quote($_SESSION['user']['username']));
     $sqld->bindValue(':content', addslashes($_POST['m_content']));
     if($sqld->execute()) {
          // we need to send the email, so we grab all the subscribers from this list, along with the content of the email, and send it to a function
          $sub = $db->query("SELECT * FROM tbl_mailing_subscribers WHERE subscriber_list_id = '$_POST[m_list]'");
          // we also grab the mailer settings
          $stg = $db->query("SELECT * FROM tbl_mailing_settings WHERE mailer_list_id = '$_POST[m_list]'");
          if(sendMailer($sub, $stg, $_POST) === true) {
               echo '<div class="alert alert-success">The Mailing has been successfully published and sent to the subscribers on the list!</div>';
          } else {
               echo '<div class="alert alert-danger">There was a problem sending the mailing.  The mailing was saved, but you may need to try and send again.</div>';
          }
     } else {
          echo '0';
     }
}

if(isset($_POST['schedule'])) {
     $list = $_POST['m_list'];
     $subject = $db->quote($_POST['m_subject']);
     $date = date('Y-m-d', strtotime($_POST['m_date']));
     $content = $db->quote($_POST['m_content']);
     $status = 2;
     $db->exec("INSERT INTO tbl_mailings (mailing_subject, mailing_date, mailing_list_id, mailing_creator, mailing_status, mailing_content) VALUES (". $subject .", '$date', '$list', '". $_SESSION['user']['username'] ."', '$status', ". $content .")");     
     echo 'The Mailing has been scheduled and will be sent on the date you selected.';
}

if(isset($_POST['save'])) {
     $list = $_POST['m_list'];
     $subject = $db->quote($_POST['m_subject']);
     $date = date('Y-m-d', strtotime($_POST['m_date']));
     $content = $db->quote($_POST['m_content']);
     $status = 0;
     $db->exec("INSERT INTO tbl_mailings (mailing_subject, mailing_date, mailing_list_id, mailing_creator, mailing_status, mailing_content) VALUES (". $subject .", '$date', '$list', '". $_SESSION['user']['username'] ."', '$status', ". $content .")");     
     echo 'Your Mailing has been saved as a draft and can be found in the Archive.';
}

if(isset($_POST['add_list'])) {
     $list = addslashes($_POST['list_name']);
     $db->exec("INSERT INTO tbl_mailing_lists (list_name, list_status) VALUES ('$list', 1)");
     $insertId = $db->lastInsertId();
     $db->exec("INSERT INTO tbl_mailing_settings (mailer_list_id) VALUES ($insertId)");
     echo 'List Added Succesfully';
}

if(isset($_POST['edit_mailer'])) {
     $esql = $db->query("SELECT * FROM tbl_mailings WHERE m_id = $_POST[mailer_id]");
     while($eml = $esql->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <form>
          <input type="hidden" name="emid" id="emid" value="<?php echo $eml['m_id'] ?>" />
          <b>Select a Mailing List</b><br />
          <select name="em_list" id="em_list" class="form-control" style="width: 375px" required="required">
          <option value="<?php echo $eml['mailing_list_id'] ?>">Leave Unchanged</option>
          <?php
          $esqll = $db->query("SELECT l_id, list_name FROM tbl_mailing_lists WHERE list_status = 1 AND l_id != $eml[mailing_list_id] ORDER BY list_name ASC");
          while($elst = $esqll->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <option value="<?php echo $elst['l_id'] ?>"><?php echo stripslashes($elst['list_name']) ?></option>
               <?php
          }
          ?>
          </select>
          <p class="help-block">You can create a new List under the Mailing Lists Manager.</p>
          
          <b>Mailing Subject</b><br />
          <input type="text" name="em_subject" id="em_subject" value="<?php echo stripslashes($eml['mailing_subject']) ?>" class="form-control" required="required" />
          <p class="help-block">Required.  Will be the subject line in the Email.</p>
          
          <b>Mailing Date</b><br />
          <div class="col-sm-4">
          <div class='input-group date' id='edatetimepicker<?php echo $eml['m_id'] ?>'>
          <input type="date" name="em_date" id="em_date" value="<?php echo $eml['mailing_date'] ?>" onblur="theDate()" onemptied="theDate()" class="form-control datepicker" required="required" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
          </div>
          </div><br /><br />
          <p class="help-block">Past dates will be sent immediately, future dates will be scheduled and sent at midnight on the date entered.</p>
          
          <b>Mailing Content</b><br />
          <textarea name="em_content" id="em_content" required="required"><?php echo stripslashes($eml['mailing_content']) ?></textarea>
          <p class="help-block">You may include any HTML (rich text, images, embeds, tables, etc.) in the content.</p>
          <p class="help-block">If you changed the publication date to a future date, it will change the status to "Scheduled".  If you changed the publish date to today, it will publish immediately.</p>
          </form>     
          <?php
     }
}

if(isset($_POST['save_mailer'])) {
     $list = $_POST['mailer_list'];
     $subject = $db->quote($_POST['mailer_subject']);
     $date = date('Y-m-d', strtotime($_POST['mailer_date']));
     $content = $db->quote($_POST['mailer_content']);
     $today = date('Y-m-d');
     if(strtotime($date) > strtotime($today)) {
          $status = 2;
     }
     if(strtotime($date) <= strtotime($today)) {
          $status = 3;
     }
     
     $db->exec("UPDATE tbl_mailings SET mailing_subject = ". $subject .", mailing_date = '$date', mailing_list_id = '$list', mailing_status = '$status', mailing_content = ". $content ." WHERE m_id = $_POST[mailer_id]");     
     switch($status) {
          case 0:
               echo 'Mailer changed to Draft';
               break;
          case 3:
               echo 'Mailer has been Published and will be sent shortly';
               break;
          case 2:
               echo 'Mailer has been scheduled to be published and sent on '. date('M j Y', strtotime($_POST['mailer_date'])) .' successfully';
               break;
          default:
               break;
     }
}

if(isset($_POST['delete_mailer'])) {
     $db->exec("UPDATE tbl_mailings SET mailing_status = 9 WHERE m_id = $_POST[mailer_id]");
}

if(isset($_POST['list_settings'])) {
     $set = $db->query("SELECT * FROM tbl_mailing_settings WHERE mailer_list_id = $_POST[list_id]");
     $st = $set->fetch(PDO::FETCH_ASSOC);
     ?>
     <form>
     <input type="hidden" name="setting_id" id="setting_id" value="<?php echo $st['m_id'] ?>" />
     <input type="hidden" name="list_id" id="list_id" value="<?php echo $st['mailer_list_id'] ?>" />
     <div class="md-form">
     <b>Sent From Address</b><br />
     <input type="email" class="form-control" name="fromaddr" id="fromaddr" value="<?php echo $st['mailer_from_address'] ?>" />
     <small class="form-text text-muted">This should be a dummy address which cannot be replied to.</small>
     </div>
     <div class="md-form">
     <b>Real Reply-to Address</b>
     <input type="email" class="form-control" name="replyto" id="replyto" value="<?php echo $st['mailer_reply_to_address'] ?>" />
     <small class="form-text text-muted">Should a user reply to the email, this will be the address their reply will be sent to.  You can use a REAL email address or the "from" address if you won't be accepting replies.</small>     
     </div>
     <div class="md-form">
     <b>Text to append to the Subject</b><br />
     <input type="text" class="form-control" name="subappend" id="subappend" value="<?php echo $st['mailer_append_subject'] ?>" />
     <small class="form-text text-muted">Helpful for categorizing the type of emails being sent (!IMPORTANT!, Confidential, etc.)</small>
     </div>
     <div class="md-form">
     <b>Text to append to the Content</b><br />
     <textarea name="conappend" id="conappend" class="form-control" rows="4" cols="100%"><?php echo stripslashes($st['mailer_append_content']) ?></textarea>
     <small class="form-text text-muted">BRIEF text or paragraph for special reasons (introduction, explanation, etc.)</small>
     </div>
     <div class="md-form">
     <b>Text to append to the Footer</b><br />
     <textarea name="footappend" id="footappend" class="form-control" rows="4" cols="100%"><?php echo stripslashes($st['mailer_append_footer']) ?></textarea>
     <small class="form-text text-muted">BRIEF text or paragraph for special reasons (why person is receiving email, information about the church, etc.)</small>     
     </div>
     <div class="md-form">
     <b>Unsubscribe Paragraph</b><br />
     <textarea name="unsctext" id="unsctext" class="form-control" rows="4" cols="100%"><?php echo stripslashes($st['mailer_unsubscribe_text']) ?></textarea>
     <small class="form-text text-muted">REQUIRED!  Enter instructions for unsubscribing, and include HTML if necessary.</small>
     </div>
     <div class="md-form">
     <b>Required Unsubscribe Link</b><br />
     <input type="url" class="form-control" name="unslink" id="unslink" value="<?php echo $st['mailer_unsubscribe_link'] ?>" />
     <small class="form-text text-muted">All mailing list/group emails MUST include an unsubscribe method/link.</small>
     </div>
     <div class="form-check">
     <input class="form-check-input" type="checkbox" name="listprv" id="listprv" value="1" <?php if($st['mailer_list_privacy'] == 1) { echo 'checked="checked"';} ?> />
     <label class="form-check-label" for="listprv">Private List?</label>
     <small class="form-text text-muted">A Private List does not allow public users to subscribe but can still be used for emailing.</small>
     </div>          
     </form>
     <?php
}

if(isset($_POST['save_list_settings'])) {
     $db->exec("UPDATE tbl_mailing_settings SET mailer_list_privacy = '$_POST[mailer_list_privacy]', mailer_from_address = '$_POST[from_address]', mailer_reply_to_address = '$_POST[reply_address]', mailer_append_subject = ". $db->quote($_POST['subj_append']) .", mailer_append_content = ". $db->quote($_POST['cont_append']) .", mailer_append_footer = ". $db->quote($_POST['foot_append']) .", mailer_unsubscribe_text = ". $db->quote($_POST['unsub_text']) .", mailer_unsubscribe_link = '$_POST[unsub_link]' WHERE m_id = '$_POST[s_id]'");
     $db->exec("UPDATE tbl_mailing_lists SET list_privacy = '$_POST[mailer_list_privacy]' WHERE l_id = $_POST[l_id]");
     echo 'Settings for this List have been updated';
}

if(isset($_POST['unsubscribeeverything'])) {
     $db->exec("UPDATE tbl_mailing_subscribers SET subscriber_status = 0, unsubscribe_date = now() WHERE subscriber_email = '$_POST[emailaddress]'");
     $db->exec("UPDATE tbl_calendars_subscribers SET subscriber_status = 0, unsubscribe_date = now() WHERE subscriber_email = '$_POST[emailaddress]'");
     echo '<div class="card-header"><h4 class="card-title">Success!</h4></div>
     <div class="card-body">You have been unsubscribed from ALL lists!</div>';     
}

if(isset($_POST['unsubscribeselect'])) {
     if(in_array('9999', $_POST['mylist'])) {
          $db->exec("UPDATE tbl_calendars_subscribers SET subscriber_status = 0, unsubscribe_date = now() WHERE subscriber_email = '$_POST[emailaddress]'");
     }
     $sql = $db->query("SELECT s_id FROM tbl_mailing_subscribers WHERE subscriber_email = '$_POST[emailaddress]'");
     if($sql->rowCount() < 1) {
          echo '<div class="card-header"><h4 class="card-title">Notice...</h4></div>
          <div class="card-body">Your email address is not subscribed to any lists.</div>';
          die;
     }
     foreach($_POST['mylist'] AS $val) {
          $db->exec("UPDATE tbl_mailing_subscribers SET subscriber_status = 0, unsubscribe_date = now() WHERE subscriber_email = '$_POST[emailaddress]' AND subscriber_list_id = $val");
     }
     echo '<div class="card-header"><h4 class="card-title">Success!</h4></div>
     <div class="card-body">You have been unsubscribed from the selected list(s).</div>';
}

if(isset($_POST['subscribeme'])) {
     $ipaddress = $_SERVER['REMOTE_ADDR'];
     if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $fwdip = $_SERVER['HTTP_X_FORWARDED_FOR'];
     } else {
          $fwdip = '0';
     }
     $metadata = $_SERVER['HTTP_USER_AGENT'] .'/'. $_SERVER['REMOTE_ADDR'] .'/'. $_SERVER['HTTP_REFERER'];  
     $answer = 17;
     unset($_POST['subscribeme']);
     unset($_POST['subscribebutton']);
     if($_POST['myanswer'] != $answer) {
          echo '<div class="alert alert-danger">You gave the WRONG answer.  Refresh your screen and try again!</div>';
          die;
     }
     unset($_POST['myanswer']);
     if(!isset($_POST['mylist'])) {
          echo '<div class="alert alert-danger">You need to select AT LEAST one list from the list to subscribe to.  Please try again</div>';
          die;
     }     
     for($i=0;$i<count($_POST['mylist']);$i++) {
          if($_POST['mylist'][$i] == 9999) {
               $sql = $db->query("SELECT s_id FROM tbl_calendars_subscribers WHERE subscriber_email = '$_POST[myemail]' AND subscriber_status = 1");
               if($sql->rowCount() == 0) {
                    $db->exec("INSERT INTO tbl_calendars_subscribers (subscriber_email, subscriber_date, subscriber_ip, subscriber_fwd_addr, subscriber_meta, subscriber_name) VALUES ('$_POST[myemail]', now(), '$ipaddress', '$fwdip', '$metadata', ". $db->quote($_POST['myname']) .")");
               }
          } else {
               $sql = $db->query("SELECT s_id FROM tbl_mailing_subscribers WHERE subscriber_list_id = '". $_POST['mylist'][$i] ."' AND subscriber_email = '$_POST[myemail]'");
               $cnt = $sql->rowCount();
               if($cnt > 0) {
                    $db->exec("UPDATE tbl_mailing_subscribers SET subscriber_status = 1 WHERE subscriber_list_id = ". $_POST['mylist'][$i] ." AND subscriber_email = '$_POST[myemail]'");
               } else {
                    $db->exec("INSERT INTO tbl_mailing_subscribers (subscriber_name, subscriber_email, subscriber_list_id, subscriber_status, subscriber_ip, subscriber_metadata, subscriber_fwd_ip, subscriber_date) VALUES (". $db->quote($_POST['myname']) .", '$_POST[myemail]', '". $_POST['mylist'][$i] ."', '1', '$ipaddress', '$metadata', '$fwdip', now())");
               }
          }
     }
     echo '<br /><br /><div class="alert alert-success">You have been subscribed to your selected lists.</div>'."\n";     
}

function sendMailer($subs, $sets, $post)
{
     $set      = $sets->fetch(PDO::FETCH_ASSOC);
     $list     = $set['mailer_list_id'];
     $subject  = $set['mailer_append_subject'] .": ";
     $subject .= stripslashes($post['m_subject']);

     $content  = "<html><body>";
     $content .= "<p>$set[mailer_append_content]</p>";
     $content .= "<p>". stripslashes($post['m_content']) ."</p>";
     $content .= "$set[mailer_append_footer]";
     $content .= "<p>$set[mailer_unsubscribe_text]</p>";
     $headers  = "From: " . strip_tags($set['mailer_from_address']) . "\r\n";
     $headers .= "Reply-To: ". strip_tags($set['mailer_reply_to_address']) . "\r\n";
     $headers .= "MIME-Version: 1.0\r\n";
     $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
     
     while($sub = $subs->fetch(PDO::FETCH_ASSOC)) {
          $content2 = "$set[mailer_unsubscribe_link]";
          $content2 .= "</body></html>";          
          $to = strip_tags($sub['subscriber_email']);
          mail($to, $subject, $content . $content2, $headers);
          unset($to);
          unset($content2);
     }
     return true;
}
?>