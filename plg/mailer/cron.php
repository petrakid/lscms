<?php
$sqlm = $db->query("SELECT * FROM tbl_mailings WHERE mailing_status = 3 AND DATE(mailing_date) = CURDATE()");
while($ml = $sqlm->fetch(PDO::FETCH_ASSOC)) {
     $lst = $db->query("SELECT s_id, subscriber_name, subscriber_email FROM tbl_mailing_subscribers WHERE subscriber_status = 1 AND subscriber_list_id = $ml[mailing_list_id]");
     $set = $db->query("SELECT * FROM tbl_mailing_settings WHERE mailer_list_id = $ml[mailing_list_id]");
     if(sendMailer($lst, $set, $ml)) {
          $db->exec("UPDATE tbl_mailings SET mailing_status = 1 WHERE m_id = $ml[m_id]");
     }
}

function sendMailer($subs, $sets, $cont)
{
     $set      = $sets->fetch(PDO::FETCH_ASSOC);
     $list     = $set['mailer_list_id'];
     $subject  = $set['mailer_append_subject'] .": ";
     $subject .= stripslashes($cont['mailing_subject']);
     
     $content  = "<html><body>";
     $content .= "<p>$set[mailer_append_content]</p>";
     $content .= "<p>". stripslashes($cont['mailing_content']) ."</p>";
     $content .= "$set[mailer_append_footer]";
     $content .= "<p>$set[mailer_unsubscribe_text]</p>";

     $headers  = "From: " . strip_tags($set['mailer_from_address']) . "\r\n";
     $headers .= "Reply-To: ". strip_tags($set['mailer_reply_to_address']) . "\r\n";
     $headers .= "MIME-Version: 1.0\r\n";
     $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
     
     while($sub = $subs->fetch(PDO::FETCH_ASSOC)) {
          $content2 = "$set[mailer_unsubscribe_link]?unsubscribe=1&lid=". $list ."&subid=". $sub['s_id'];
          $content2 .= "</body></html>";          
          $to = strip_tags($sub['subscriber_email']);
          mail($to, $subject, $content . $content2, $headers);
          unset($to);
          unset($content2);
     }
     return true;
}
