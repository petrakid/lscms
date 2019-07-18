<?php
$evt = $db->query("SELECT e_id FROM tbl_calendars_events WHERE email_event = 1 AND email_sent = 0 AND (event_start_date > CURDATE() AND event_start_date <= (NOW() + INTERVAL 7 DAY))");
if($evt->rowCount() > 0) {
     while($e = $evt->fetch(PDO::FETCH_ASSOC)) {
          $send = $db->query("SELECT * FROM tbl_calendars_events WHERE e_id = $e[e_id]");
          $s = $send->fetch(PDO::FETCH_ASSOC);
          $diff = count_days_in_range(date('Y-m-d'), $s['event_start_date']);
          if($diff == $s['email_advance']) {
               $subs = $db->query("SELECT subscriber_email FROM tbl_calendars_subscribers WHERE subscriber_status = 1 ORDER BY subscriber_email");
               if(sendReminder($subs, $s, $gbl) === true) {
                    $db->exec("UPDATE tbl_calendars_events SET email_sent = 1 WHERE e_id = $s[e_id]");
               } else {
                    echo 'Error in Cron';
               }
          }
     }
}


function count_days_in_range($date1, $date2) {

     $date1      = date_create($date1);
     $date2      = date_create($date2);
     
     $interval   = date_diff($date1, $date2);
     $days       = $interval->days;
     
     return $days;
}

function sendReminder($subs, $post, $gbl)
{
     $subject = 'Reminder: '. stripslashes($post['event_title']);

     $content  = "<html><body>";
     $content .= "<p>". stripslashes($post['event_subtitle']) ."</p>";
     $content .= "<p><strong>Date and Time: ". date('M j Y, h:i a', strtotime($post['event_start_date'] .' '. $post['event_start_time'])) ."</strong></p>";
     $content .= "<p>". stripslashes($post['event_detail']) ."</p>";
     $content .= "<p><small>You received this reminder because you subscribed to the Event Reminders on the $gbl[site_name] website.  To remove yourself from this or other mailing lists, visit <a href='$gbl[site_url]/Unsubscribe' target='_blank'>$gbl[site_url]/Unsubscribe</a></small></p>";
     $headers  = "From: " . $gbl['email_address'] . "\r\n";
     $headers .= "Reply-To: ". $gbl['email_address'] . "\r\n";
     $headers .= "MIME-Version: 1.0\r\n";
     $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
     
     while($sub = $subs->fetch(PDO::FETCH_ASSOC)) {
          $content2 = "</body></html>";          
          $to = $sub['subscriber_email'];
          mail($to, $subject, $content . $content2, $headers);
          unset($to);
          unset($content2);
     }
     return true;
}
?>