<?php
session_start();

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_SESSION['isLoggedIn'])) {
     if(isset($_POST['new_calendar'])) {
          ?>
          <p>Fill in the following fields and click "Add Calendar"</p>
          <div class="md-form">
          <label for="calendar_title">Name of Calendar</label>
          <input type="text" name="calendar_title" id="calendar_title" class="form-control" />
          </div>
          
          <div class="md-form">
          <label for="calendar_subtitle">Subtitle</label>
          <input type="text" name="calendar_subtitle" id="calendar_subtitle" class="form-control" />
          <small class="form-text text-muted mb-2">A brief description, instructions, or other.</small>
          </div>
          
          <b>Calendar Layout</b>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="calendar_layout_type" value="1" id="calendar_layout_type1" />
          <label class="form-check-label" for="calendar_layout_type1">Calendar</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="calendar_layout_type" value="2" id="calendar_layout_type2" />
          <label class="form-check-label" for="calendar_layout_type2">Agenda</label>
          </div>
          
          <b>First Day of the Week</b>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="calendar_start_day" value="0" id="sun" />
          <label class="form-check-label" for="sun">Sunday</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="calendar_start_day" value="1" id="mon" />
          <label class="form-check-label" for="mon">Monday</label>
          </div>
          
          <b>Time the Day Begins</b>
          <select name="calendar_start_time" id="calendar_start_time" class="mdb-select md-form mb-3 initialized">
          <option disabled selected>Select a Time</option>
          <option value="000000">12:00am</option>
          <?php
          for($t=1;$t<=11;$t++) {
               if(count($t) == 1) {
                    $t = "0$t";
               }
               echo '<option value="'. $t .'0000">'. $t .':00</option>'."\n";
          }
          echo '<option value="120000">12:00pm</option>'."\n";
          for($u=13;$u<=23;$u++) {
               $s = $u - 12;
               echo '<option value="'. $u .'0000">'. $s .':00</option>'."\n";
          }
          ?>
          </select>
          
          <b>Time the Day Ends</b>
          <select name="calendar_end_time" id="calendar_end_time" class="mdb-select md-form mb-3 initialized">
          <option disabled selected>Select a Time</option>
          <option value="000000">12:00am</option>
          <?php
          for($t=1;$t<=11;$t++) {
               if(count($t) == 1) {
                    $t = "0$t";
               }
               echo '<option value="'. $t .'0000">'. $t .':00</option>'."\n";
          }
          echo '<option value="120000">12:00pm</option>'."\n";
          for($u=13;$u<=23;$u++) {
               $s = $u - 12;
               echo '<option value="'. $u .'0000">'. $s .':00</option>'."\n";
          }
          ?>
          </select>          
          <?php
     }
     if(isset($_POST['do_add_calendar'])) {
          unset($_POST['do_add_calendar']);
          $_POST['calendar_title'] = addslashes($_POST['calendar_title']);
          $_POST['calendar_subtitle'] = addslashes($_POST['calendar_subtitle']);
          $sql = "INSERT INTO tbl_calendars (";
          foreach($_POST AS $field => $value) {
               $sql .= "`$field`, ";
          }
          $sql = rtrim($sql, ", ");
          $sql .= ") VALUES (";
          foreach($_POST AS $field => $value) {
               $sql .= "'$value', ";
          }
          $sql = rtrim($sql, ", ");
          $sql .= ")";
          $db->exec($sql);
          echo 'Calendar Added.  Close this Modal to refresh.';
     }
     if(isset($_POST['manage_calendar'])) {
          $cal = $db->query("SELECT * FROM tbl_calendars WHERE c_id = $_POST[c_id]");
          $c = $cal->fetch(PDO::FETCH_ASSOC);
          $st = str_replace(":","",$c['calendar_start_time']);
          $et = str_replace(":","",$c['calendar_end_time']);
          ?>
          <input type="hidden" name="c_id" id="c_id" value="<?php echo $_POST['c_id'] ?>" />
          
          <div class="md-form">
          <label for="calendar_title">Name of Calendar</label>
          <input type="text" name="calendar_title" id="calendar_title" class="form-control" value="<?php echo $c['calendar_title'] ?>" />
          </div>
          
          <div class="md-form">
          <label for="calendar_subtitle">Subtitle</label>
          <input type="text" name="calendar_subtitle" id="calendar_subtitle" class="form-control" value="<?php echo $c['calendar_subtitle'] ?>" />
          <small class="form-text text-muted mb-2">A brief description, instructions, or other.</small>
          </div>
          
          <b>Calendar Layout</b>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="calendar_layout_type" value="1" <?php if($c['calendar_layout_type'] == 1) { echo 'checked="checked"'; } ?> id="calendar_layout_type1" />
          <label class="form-check-label" for="calendar_layout_type1">Calendar</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="calendar_layout_type" value="2" <?php if($c['calendar_layout_type'] == 2) { echo 'checked="checked"'; } ?> id="calendar_layout_type2" />
          <label class="form-check-label" for="calendar_layout_type2">Agenda</label>
          </div>
          
          <b>First Day of the Week</b>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="calendar_start_day" value="0" <?php if($c['calendar_start_day'] == 0) { echo 'checked="checked"'; } ?> id="sun" />
          <label class="form-check-label" for="sun">Sunday</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="calendar_start_day" value="1" <?php if($c['calendar_start_day'] == 1) { echo 'checked="checked"'; } ?> id="mon" />
          <label class="form-check-label" for="mon">Monday</label>
          </div>
          
          <b>Time the Day Begins</b>
          <select name="calendar_start_time" id="calendar_start_time" class="mdb-select md-form mb-2 mt-1 initialized">
          <option disabled>Select a Time</option>
          <option value="000000" <?php if($c['calendar_start_time'] == '000000') { echo 'selected';} ?>>12:00am</option>
          <?php
          for($t=1;$t<=11;$t++) {
               if(count($t) == 1) {
                    $t = "0$t";
               }
               echo '<option value="'. $t .'0000"';
               if($t .'0000' == $c['calendar_start_time']) { echo ' selected';}
               echo '>'. $t .':00</option>'."\n";
          }
          echo '<option value="120000"';
          if($c['calendar_start_time'] == '120000') { echo ' selected';}
          echo '>12:00pm</option>'."\n";
          for($u=13;$u<=23;$u++) {
               $s = $u - 12;
               echo '<option value="'. $u .'0000"';
               if($s .'0000' == $c['calendar_start_time']) { echo ' selected';}
               echo '>'. $s .':00</option>'."\n";
          }
          ?>
          </select>
          
          <b>Time the Day Ends</b>
          <select name="calendar_end_time" id="calendar_end_time" class="mdb-select md-form mb-2 mt-1 initialized">
          <option disabled>Select a Time</option>
          <option value="000000" <?php if($c['calendar_end_time'] == '000000') { echo 'selected';} ?>>12:00am</option>
          <?php
          for($t=1;$t<=11;$t++) {
               if(count($t) == 1) {
                    $t = "0$t";
               }
               echo '<option value="'. $t .'0000"';
               if($t .'0000' == $c['calendar_end_time']) { echo ' selected';}
               echo '>'. $t .':00</option>'."\n";
          }
          echo '<option value="120000"';
          if($c['calendar_end_time'] == '120000') { echo ' selected';}
          echo '>12:00pm</option>'."\n";
          for($u=13;$u<=23;$u++) {
               $s = $u - 12;
               echo '<option value="'. $u .'0000"';
               if($s .'0000' == $c['calendar_end_time']) { echo ' selected';}
               echo '>'. $s .':00</option>'."\n";
          }
          ?>
          </select>
          
          <b>Calendar Status</b>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="calendar_status" id="active" value="1" <?php if($c['calendar_status'] == 1) { echo 'checked="checked"';} ?> />
          <label class="form-check-label" for="active">Active</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="calendar_status" value="0" id="disabled" <?php if($c['calendar_status'] == 0) { echo 'checked="checked"';} ?> />
          <label class="form-check-labe" for="disabled">Disabled</label>
          <?php
     }
     if(isset($_POST['do_save_calendar'])) {
          unset($_POST['do_save_calendar']);
          $calid = $_POST['c_id'];
          unset($_POST['c_id']);
          $_POST['calendar_title'] = addslashes($_POST['calendar_title']);
          $_POST['calendar_subtitle'] = addslashes($_POST['calendar_subtitle']);
          $sql = "UPDATE tbl_calendars SET ";
          foreach($_POST AS $field => $value) {
               $sql .= "`$field` = '$value', ";
          }
          $sql = rtrim($sql, ", ");
          $sql .= "WHERE c_id = $calid";
          $db->exec($sql);
          echo 'Calendar Updated.  Close this Modal to refresh.';
     }
     
     if(isset($_POST['new_event'])) {
          ?>
          <div class="md-form">
          <label for="event_title">Event Title</label>
          <input type="text" name="event_title" id="event_title" class="form-control" />
          </div>
          
          <div class="md-form">
          <label for="event_subtitle">Event Subtitle</label>
          <input type="text" name="event_subtitle" id="event_subtitle" class="form-control" />
          </div>
          
          <label for="event_detail">Event Detail</label>
          <textarea name="event_detail" id="event_detail"></textarea><br />
          
          <div class="form-check">
          <input class="form-check-input" type="checkbox" name="event_pinned" id="event_pinned" value="1" />
          <label class="form-check-label" for="event_pinned"><i class="fa fa-star red-text"></i> Pinned Event?</label>
          </div>          
          
          <small class="form-text text-muted mb-2">Standard images only.  Please keep images under 900kb for good performance.</small>
          <div class="file-field">
          <div class="btn btn-primary btn-sm float-left">
          <span>Choose file</span>
          <input type="file" id="event_image" name="event_image" accept="image/*" />
          </div>
          <div class="file-path-wrapper">
          <input class="file-path validate" type="text" placeholder="Chose Event Image" />
          </div>
          </div><br />
          
          <label for="event_color">Event Color</label>
          <input type="color" name="event_color" id="event_color" class="form-control" /><br />
          
          <label for="event_font_color">Event Font Color</label>
          <input type="color" name="event_font_color" id="event_font_color" class="form-control" /><br />
          
          <label>Allow Signups?</label>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="allow_signup" value="1" id="sign_yes" />
          <label class="form-check-label" for="sign_yes">Yes</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="allow_signup" value="0" id="sign_no" checked />
          <label class="form-check-label" for="sign_no">No (default)</label>
          </div>
          
          <label class="mt-4">Enable Event?</label>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="event_status" value="1" id="event_yes" checked />
          <label class="form-check-label" for="event_yes">Yes (default)</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="event_status" value="0" id="event_no" />
          <label class="form-check-label" for="event_no">No</label>
          </div>
          
          <div class="row mt-4">
          <div class="col-4">
          <label for="event_start_date">Event Start Date</label>
          <input type="date" name="event_start_date" id="event_start_date" class="form-control" /><br />
          
          <label for="event_start_time">Event Start Time</label>
          <input type="time" name="event_start_time" id="event_start_time" class="form-control" /><br />
          </div>
          
          <div class="col-4">
          <label for="event_end_date">Event End Date</label>
          <input type="date" name="event_end_date" id="event_end_date" class="form-control" /><br />
          
          <label for="event_end_time">Event End Time</label>
          <input type="time" name="event_end_time" id="event_end_time" class="form-control" />
          </div>
          </div>
          
          <label>Is this a Recurring Event?</label>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="recurring" value="1" id="repeat_yes" />
          <label class="form-check-label" for="repeat_yes">Yes</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="recurring" value="0" id="repeat_no" checked />
          <label class="form-check-label" for="repeat_no">No (default)</label>
          </div>
          
          <select name="recurring_interval" id="recurring_interval" class="mdb-select md-form mb-3 initialized">
          <option disabled selected>Select Interval</option>
          <option value="1">Daily</option>
          <option value="2">Weekly</option>
          <option value="3">Monthly</option>
          <option value="4">Yearly</option>
          <option value="5">Every Other Week</option>
          </select>                    
          <small class="form-text text-muted mb-2">The event recurrances will end on or before the "Event End Date" above.</small>
          
          <label>Email Event to Subscribers?</label>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="email_event" value="1" id="email_yes" />
          <label for="email_yes" class="form-check-label">Yes</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="email_event" value="0" id="email_no" />
          <label for="email_no" class="form-check-label">No</label>
          </div>
          
          <select name="email_advance" id="email_advance" class="mdb-select md-form mb-3 initialized">
          <option value="0" disabled selected>Select Days</option>
          <option value="1">1 Day Prior</option>
          <option value="2">2 Days Prior</option>
          <option value="3">3 Days Prior</option>
          <option value="5">5 Days Prior</option>
          <option value="7">1 Week Prior</option>
          </select>
          <small class="form-text text-muted mb-2">The Calendar Subscribers will receive an email reminder this many days prior to the event.</small>
          <?php
     }
     if(isset($_POST['do_add_event'])) {
          if(isset($_FILES['event_image']) && $_FILES['event_image']['error'] != 4) {
               $root = $gbl['doc_root'] .'ast/res/'. date('Y', strtotime($_POST['event_start_date'])) .'/';
               $year = date('Y', strtotime($_POST['event_start_date']));
               if(!is_dir($root)) {
                    mkdir($root);
               }
               $filearray = array('jpg', 'jpeg', 'png', 'gif');
               $ext = strtolower(pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION));
               if(!in_array($ext, $filearray)) {
                    echo 'Image not added.  Invalid image type or no image included.<br />';
               } else {
                    $filename = rand(1, 6) . date('Ymdhis').'.'. $ext;
                    move_uploaded_file($_FILES['event_image']['tmp_name'], $root . $filename);
                    $_POST['event_image'] = $year .'/'. $filename;
               }
          } else {
               $_POST['event_image'] = '';
          }
          unset($_POST['do_add_event']);
          $_POST['event_title'] = addslashes($_POST['event_title']);
          $_POST['event_subtitle'] = addslashes($_POST['event_subtitle']);
          $_POST['event_creator'] = $_SESSION['user']['username'];
          $recurring = $_POST['recurring'];
          $interval = $_POST['recurring_interval'];
          unset($_POST['recurring']);
          unset($_POST['recurring_interval']);
          if($recurring == 0) {
               $sql = "INSERT INTO tbl_calendars_events (";
               foreach($_POST AS $field => $value) {
                    $sql .= "`$field`, ";
               }
               $sql = rtrim($sql, ", ");
               $sql .= ") VALUES (";
               foreach($_POST AS $field => $value) {
                    $sql .= "'$value', ";
               }
               $sql = rtrim($sql, ", ");
               $sql .= ")";
               $db->exec($sql);
          } else {
               $start = new DateTime($_POST['event_start_date']);
               $end = new DateTime($_POST['event_end_date']);
               $_POST['event_end_date'] = $_POST['event_start_date'];               
               $numberdays = $start->diff($end);               
               $days = $numberdays->format('%a');
               $months = $numberdays->format('%m');
               $years = $numberdays->format('%y');
               switch($interval) {
                    case 1:  // daily
                         for($i=0;$i<=$days;$i++) {
                              $sql = "INSERT INTO tbl_calendars_events (";
                              foreach($_POST AS $field => $value) {
                                   $sql .= "`$field`, ";
                              }
                              $sql = rtrim($sql, ", ");
                              $sql .= ") VALUES (";
                              foreach($_POST AS $field => $value) {
                                   if($field == 'event_start_date') {
                                        $value = date('Y-m-d', strtotime("+$i day", strtotime($_POST['event_start_date'])));
                                   }
                                   $sql .= "'$value', ";
                              }
                              $sql = rtrim($sql, ", ");
                              $sql .= ")";
                              $db->exec($sql);                              
                         }
                         break;
                    case 2: // weekly                    
                         $weeks = floor($days / 7);
                         for($i=0;$i<=$weeks;$i++) {
                              $sql = "INSERT INTO tbl_calendars_events (";
                              foreach($_POST AS $field => $value) {
                                   $sql .= "`$field`, ";
                              }
                              $sql = rtrim($sql, ", ");
                              $sql .= ") VALUES (";
                              foreach($_POST AS $field => $value) {
                                   if($field == 'event_start_date') {
                                        $value = date('Y-m-d', strtotime("+$i week", strtotime($_POST['event_start_date'])));
                                   }
                                   $sql .= "'$value', ";
                              }
                              $sql = rtrim($sql, ", ");
                              $sql .= ")";
                              $db->exec($sql);                              
                         }
                         break;                    
                    case 3: // monthly                    
                         $weekday = date('l', strtotime($_POST['event_start_date']));
                         $week = getWeeks($_POST['event_start_date']);
                         
                         for($i=0;$i<=$months;$i++) {
                              $sql = "INSERT INTO tbl_calendars_events (";
                              foreach($_POST AS $field => $value) {
                                   $sql .= "`$field`, ";
                              }
                              $sql = rtrim($sql, ", ");
                              $sql .= ") VALUES (";
                              foreach($_POST AS $field => $value) {
                                   if($field == 'event_start_date') {
                                        $tmpdate = date('Y-m-d', strtotime("+$i month", strtotime($_POST['event_start_date'])));
                                        $tmpdate = date('Y-m', strtotime($tmpdate));
                                        $value = date('Y-m-d', strtotime("$week $weekday $tmpdate"));
                                        unset($tmpdate);
                                   }
                                   $sql .= "'$value', ";
                              }
                              $sql = rtrim($sql, ", ");
                              $sql .= ")";
                              $db->exec($sql);                              
                         }
                         break;                     
                    case 4: // yearly                   
                         for($i=0;$i<=$years;$i++) {
                              $sql = "INSERT INTO tbl_calendars_events (";
                              foreach($_POST AS $field => $value) {
                                   $sql .= "`$field`, ";
                              }
                              $sql = rtrim($sql, ", ");
                              $sql .= ") VALUES (";
                              foreach($_POST AS $field => $value) {
                                   if($field == 'event_start_date') {
                                        $value = date('Y-m-d', strtotime("+$i year", strtotime($_POST['event_start_date'])));
                                   }
                                   $sql .= "'$value', ";
                              }
                              $sql = rtrim($sql, ", ");
                              $sql .= ")";
                              $db->exec($sql);                              
                         }
                         break;                    
                    case 5: // every two weeks
                         echo 'Not yet implemented.';
                         break;
                    default:
                         break;
               }
          }
          echo 'Event Added. Click Close to refresh the page';
     }
     if(isset($_POST['edit_event'])) {
          $evt = $db->query("SELECT * FROM tbl_calendars_events WHERE e_id = $_POST[e_id]");
          $e = $evt->fetch(PDO::FETCH_ASSOC);
          ?>
          <div class="md-form">
          <label for="event_title">Event Title</label>
          <input type="text" name="event_title" id="event_title" class="form-control" value="<?php echo $e['event_title'] ?>" />
          </div>
          
          <div class="md-form">
          <label for="event_subtitle">Event Subtitle</label>
          <input type="text" name="event_subtitle" id="event_subtitle" class="form-control" value="<?php echo $e['event_subtitle'] ?>" />
          </div>
          
          <label for="event_detail">Event Detail</label>
          <textarea name="event_detail" id="event_detail"><?php echo $e['event_detail'] ?></textarea><br />
          
          <div class="form-check">
          <input class="form-check-input" type="checkbox" name="event_pinned" id="event_pinned" value="1" <?php if($e['event_pinned'] == 1) { echo 'checked="checked"';} ?> />
          <label class="form-check-label" for="event_pinned"><i class="fa fa-star red-text"></i> Pinned Event?</label>
          </div>
          
          <small class="form-text text-muted mb-2">Standard images only.  Please keep images under 900kb for good performance.</small>
          <div class="file-field">
          <div class="btn btn-primary btn-sm float-left">
          <span>Choose file</span>
          <input type="file" id="event_image" name="event_image" accept="image/*" />
          </div>
          <div class="file-path-wrapper">
          <input class="file-path validate" type="text" placeholder="Chose New Event Image" />
          </div>
          </div><br />
          
          <label for="event_color">Event Color</label>
          <input type="color" name="event_color" id="event_color" class="form-control" value="<?php echo $e['event_color'] ?>" /><br />
          
          <label for="event_font_color">Event Font Color</label>
          <input type="color" name="event_font_color" id="event_font_color" class="form-control" value="<?php echo $e['event_font_color'] ?>" /><br />
          
          <label>Allow Signups?</label>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="allow_signup" value="1" id="sign_yes" <?php if($e['allow_signup'] == 1) { echo 'checked';} ?> />
          <label class="form-check-label" for="sign_yes">Yes</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="allow_signup" value="0" id="sign_no" <?php if($e['allow_signup'] == 0) { echo 'checked';} ?> />
          <label class="form-check-label" for="sign_no">No (default)</label>
          </div>
          
          <label class="mt-4">Enable Event?</label>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="event_status" value="1" id="event_yes" <?php if($e['event_status'] == 1) { echo 'checked';} ?> />
          <label class="form-check-label" for="event_yes">Yes (default)</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="event_status" value="0" id="event_no" <?php if($e['event_status'] == 0) { echo 'checked';} ?> />
          <label class="form-check-label" for="event_no">No</label>
          </div>
          
          <div class="row mt-4">
          <div class="col-4">
          <label for="event_start_date">Event Start Date</label>
          <input type="date" name="event_start_date" id="event_start_date" class="form-control" value="<?php echo $e['event_start_date'] ?>" /><br />
          
          <label for="event_start_time">Event Start Time</label>
          <input type="time" name="event_start_time" id="event_start_time" class="form-control" value="<?php echo $e['event_start_time'] ?>" /><br />
          </div>
          
          <div class="col-4">
          <label for="event_end_date">Event End Date</label>
          <input type="date" name="event_end_date" id="event_end_date" class="form-control" value="<?php echo $e['event_end_date'] ?>" /><br />
          
          <label for="event_end_time">Event End Time</label>
          <input type="time" name="event_end_time" id="event_end_time" class="form-control" value="<?php echo $e['event_end_time'] ?>" />
          </div>
          </div>
          
          <label>Email Event to Subscribers?</label>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="email_event" value="1" id="email_yes" <?php if($e['email_event'] == 1) { echo 'checked="checked"';} ?> />
          <label for="email_yes" class="form-check-label">Yes</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" name="email_event" value="0" id="email_no" <?php if($e['email_event'] == 0) { echo 'checked="checked"';} ?> />
          <label for="email_no" class="form-check-label">No</label>
          </div>
          
          <select name="email_advance" id="email_advance" class="mdb-select md-form mb-3 initialized">
          <option <?php if($e['email_advance'] == 0) { echo 'selected="selected"';} ?> value="0" disabled>Select Days</option>
          <option <?php if($e['email_advance'] == 1) { echo 'selected="selected"';} ?> value="1">1 Day Prior</option>
          <option <?php if($e['email_advance'] == 2) { echo 'selected="selected"';} ?> value="2">2 Days Prior</option>
          <option <?php if($e['email_advance'] == 3) { echo 'selected="selected"';} ?> value="3">3 Days Prior</option>
          <option <?php if($e['email_advance'] == 5) { echo 'selected="selected"';} ?> value="5">5 Days Prior</option>
          <option <?php if($e['email_advance'] == 7) { echo 'selected="selected"';} ?> value="7">1 Week Prior</option>
          </select>
          <small class="form-text text-muted mb-2">Changing the email settings will only effect this event in a series.</small>                    
          <?php
     }
     if(isset($_POST['do_edit_event'])) {
          if(isset($_FILES['event_image'])) {
               if($_FILES['event_image']['error'] != 4 || $_FILES['event_image']['name'] != '') {
                    $root = $gbl['doc_root'] .'ast/res/'. date('Y', strtotime($_POST['event_start_date'])) .'/';
                    $year = date('Y', strtotime($_POST['event_start_date']));
                    if(!is_dir($root)) {
                         mkdir($root);
                    }
                    $filearray = array('jpg', 'jpeg', 'png', 'gif');
                    $ext = strtolower(pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION));
                    if(!in_array($ext, $filearray)) {
                         echo 'Image not updated.  Invalid image type or no image included.<br />';
                         unset($_POST['event_image']);                    
                    } else {
                         $filename = rand(1, 6) . date('Ymdhis').'.'. $ext;
                         move_uploaded_file($_FILES['event_image']['tmp_name'], $root . $filename);
                         $_POST['event_image'] = $year .'/'. $filename;
                    }
               } else {
                    $_POST['event_image'] = '';
                    unset($_POST['event_image']);
               }
          } else {
               $_POST['event_image'] = '';
               unset($_POST['event_image']);               
          }
          if($_POST['event_pinned'] != 1) {
               $_POST['event_pinned'] = 0;
          }
          $eventid = $_POST['e_id'];
          unset($_POST['e_id']);
          unset($_POST['do_edit_event']);
          $_POST['event_title'] = addslashes($_POST['event_title']);
          $_POST['event_subtitle'] = addslashes($_POST['event_subtitle']);
          $sql = "UPDATE tbl_calendars_events SET ";
          foreach($_POST AS $field => $value) {
               $sql .= "`$field` = '$value', ";
          }
          $sql = rtrim($sql, ", ");
          $sql .= "WHERE e_id = $eventid";
          $db->exec($sql);
          echo 'Event Updated. Click Close to refresh the page';          
     }
     if(isset($_POST['do_delete_event'])) {
          $db->exec("DELETE FROM tbl_calendars_events WHERE e_id = $_POST[e_id]");
          echo '<div class="col-md-12">Event Removed</div>';
     }
}
if(isset($_GET['q'])) {
     $hint = "";
     $sql = "SELECT e_id, event_start_date, event_start_time, event_title FROM tbl_calendars_events WHERE event_title LIKE :term AND event_status = 1 AND (event_start_date >= DATE(now()) AND event_start_date <= DATE_SUB(now(), INTERVAL -4 MONTH)) ORDER BY event_start_date DESC, event_start_time ASC"; 
     $stmt = $db->prepare($sql);
     $term = '%'. $_GET['q'] .'%';
     $stmt->bindParam(":term", $term);
     $stmt->execute();
     if($stmt->rowCount() > 0) {
          while($s = $stmt->fetch(PDO::FETCH_ASSOC)) {
               $hint .= '<a href="Events/read-more/&eventid='. $s['e_id'] .'" title="'. stripslashes($s['event_title']) .'"><b>'. stripslashes($s['event_title']) .'</b>, '. date('M j Y', strtotime($s['event_start_date'])) .' at '. date('h:i a', strtotime($s['event_start_time'])) .'</a><hr />';
          }
     } else {
          $hint = "No Matches Found :-(";
     }
     echo $hint;
}
if(isset($_POST['view_calendar'])) {
     $cal = $db->query("SELECT * FROM tbl_calendars WHERE page_id = $_POST[page_id] AND calendar_status = 1");
     $c = $cal->fetch(PDO::FETCH_ASSOC);
     ?>
     <div class="row">
     <div class="col-12">
     <h3 class="mb-12 font-weight-bold dark-grey-text" ><strong><?php echo stripslashes($c['calendar_title']) ?></strong><br />
     <small><?php echo stripslashes($c['calendar_subtitle']) ?></small></h3>
     </div>
     </div>
     <?php
     if($c['calendar_layout_type'] == 1) {
          ?>
          <div class="row">
          <div class="col-12">
          <div class="page-header">
          <div class="pull-right form-inline">
          <div class="btn-group">
          <button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
          <button class="btn btn-default" data-calendar-nav="today">Today</button>
          <button class="btn btn-primary" data-calendar-nav="next">Next >></button>
          </div>
          <div class="btn-group">
          <button class="btn btn-warning" data-calendar-view="year">Year</button>
          <button class="btn btn-warning active" data-calendar-view="month">Month</button>
          <button class="btn btn-warning" data-calendar-view="week">Week</button>
          <button class="btn btn-warning" data-calendar-view="day">Day</button>
          </div>
          </div>
          <h3></h3>
          </div>
          <div class="row">
          <div class="col-md-12">
          <div id="showEventCalendar"></div>
          </div>
          </div>
          </div>
          </div>

          <?php
     }
     if($c['calendar_layout_type'] == 2) {
          ?>
          <div class="row justify-content-end">
          <div class="col-4">
          <div style="text-align: right;" class="d-flex flex-column">
          <input type="text" class="form-control livesearchfield ml-auto p-1" id="search_events" placeholder="Search Events" id="searcher" style="width: 250px;" onkeyup="showResult(this.value)" />
          <div id="livesearch" class="livesearchres p-1"></div>
          </div>
          </div>
          </div>
          <hr />
          <?php
          $evt = $db->query("SELECT * FROM tbl_calendars_events WHERE calendar_id = $c[c_id] AND event_status = 1 AND ((event_start_date >= CURDATE() AND event_start_date <= DATE_SUB(now(), INTERVAL -3 MONTH)) OR event_pinned = 1) ORDER BY event_pinned DESC, event_start_date ASC, event_start_time ASC");
          while($e = $evt->fetch(PDO::FETCH_ASSOC)) {
               if($e['event_pinned'] == 1) {
                    ?>
                    <div class="row" id="event-<?php echo $e['e_id'] ?>" class="display: flex;">
                    <div class="col-lg-7 col-xl-7 pb-3">
                    <a class="" href="<?php echo $gbl['site_url'] ?>/Events/read-more/&eventid=<?php echo $e['e_id'] ?>">
                    <h6 class="font-weight-bold pb-2 pl-2 pt-2" style="background-color: <?php echo $e['event_color'] ?>; color: <?php echo $e['event_font_color'] ?>">
                    <i class="fa fa-star red-text" title="Pinned"></i> <?php echo date('M j Y', strtotime($e['event_start_date'])) ?>
                    </h6>
                    </a>
                    
                    <?php
                    if(isset($_SESSION['isLoggedIn'])) {
                         ?>
                         <br />
                         <button class="btn btn-success btn-sm" onclick="editEvent('<?php echo $e['e_id'] ?>')"><i class="fa fa-edit"></i> Edit Event</button>
                         <button class="btn btn-danger btn-sm" onclick="deleteEvent('<?php echo $e['e_id'] ?>')"><i class="fa fa-trash"></i> Delete Event</button>
                         
                         <?php
                    }
                    ?>               
                    <h3 class="mb-4 font-weight-bold dark-grey-text"><strong><?php echo stripslashes($e['event_title']) ?></strong><br />
                    <small><?php echo stripslashes($e['event_subtitle']) ?></small></h3>
                    <p>Start Time: <?php echo date('h:i a', strtotime($e['event_start_time'])) ?> | End Time: <?php echo date('h:i a', strtotime($e['event_end_time'])) ?></p>
                    <p>
                    <a class="btn btn-red btn-md mb-3 waves-effect waves-light" href="<?php echo $gbl['site_url'] ?>/Events/read-more/&eventid=<?php echo $e['e_id'] ?>">Read more</a>
                    </p>                           
                    </div>
                    
                    <div class="col-lg-5 col-xl-5 mb-5">
                    <div class="view overlay rounded z-depth-2">
                    <img src="<?php echo $gbl['site_url'] ?>/ast/res/<?php echo $e['event_image'] ?>" alt="" class="img-fluid" />
                    <a><div class="mask waves-effect waves-light"></div></a>
                    </div>
                    </div>
                    </div>
                    <hr class="mb-5 mt-4 pb-3" />
                                        
                    <?php
               } else {
                    ?>
                    <div class="row" id="event-<?php echo $e['e_id'] ?>">
                    <div class="col-lg-7 col-xl-7 pb-3">
                    <a class="" href="<?php echo $gbl['site_url'] ?>/Events/read-more/&eventid=<?php echo $e['e_id'] ?>">
                    <h6 class="font-weight-bold pb-2 pl-2 pt-2" style="background-color: <?php echo $e['event_color'] ?>; color: <?php echo $e['event_font_color'] ?>">
                    <?php echo date('M j Y', strtotime($e['event_start_date'])) ?>
                    </h6>
                    </a>
                    
                    <?php
                    if(isset($_SESSION['isLoggedIn'])) {
                         ?>
                         <br />
                         <button class="btn btn-success btn-sm" onclick="editEvent('<?php echo $e['e_id'] ?>')"><i class="fa fa-edit"></i> Edit Event</button>
                         <button class="btn btn-danger btn-sm" onclick="deleteEvent('<?php echo $e['e_id'] ?>')"><i class="fa fa-trash"></i> Delete Event</button>
                         
                         <?php
                    }
                    ?>               
                    <h3 class="mb-4 font-weight-bold dark-grey-text"><strong><?php echo stripslashes($e['event_title']) ?></strong><br />
                    <small><?php echo stripslashes($e['event_subtitle']) ?></small></h3>
                    <p>Start Time: <?php echo date('h:i a', strtotime($e['event_start_time'])) ?> | End Time: <?php echo date('h:i a', strtotime($e['event_end_time'])) ?></p>
                    <p><a class="btn btn-red btn-md mb-3 waves-effect waves-light" href="<?php echo $gbl['site_url'] ?>/Events/read-more/&eventid=<?php echo $e['e_id'] ?>">Read more</a></p>                           
                    </div>
                    
                    <div class="col-lg-5 col-xl-5 mb-5">
                    <div class="view overlay rounded z-depth-2">
                    <img src="<?php echo $gbl['site_url'] ?>/ast/res/<?php echo $e['event_image'] ?>" alt="" class="img-fluid" />
                    <a><div class="mask waves-effect waves-light"></div></a>
                    </div>
                    </div>
                    </div>
                    <hr class="mb-5 mt-4 pb-3" />
                                   
                    <?php
               }
          }
     }
}
if(isset($_POST['view_details'])) {
     $cal = $db->query("SELECT * FROM tbl_calendars_events WHERE e_id = $_POST[event_id]");
     $c = $cal->fetch(PDO::FETCH_ASSOC);
     if(isset($_SESSION['isLoggedIn'])) {
          ?>
          <div class="row">
          <div class="col-12">
          <button class="btn btn-success btn-sm" onclick="editEvent('<?php echo $e['e_id'] ?>')"><i class="fa fa-edit"></i> Edit Event</button>
          <button class="btn btn-danger btn-sm" onclick="deleteEvent('<?php echo $e['e_id'] ?>')"><i class="fa fa-trash"></i> Delete Event</button>
          </div>
          </div>
          <?php
     }
     ?>     
     <div class="row">
     <div class="col-6">
     <div class="view overlay">
     <img class="img-fluid hoverable z-depth-2" src="<?php echo $gbl['site_url'] ?>/ast/res/<?php echo $c['event_image'] ?>" />
     <div class="mask rgba-white-slight waves-effect waves-light"></div>
     </div>
     </div>
     <div class="col-6">
     <div class="card-heading" style="text-align: center"><h3 class="h3"><?php echo stripslashes($c['event_title']) ?></h3>
     <?php echo stripslashes($c['event_subtitle']) ?></div>
     <div class="card-body">
     <strong>Date: </strong><?php echo date('M j Y', strtotime($c['event_start_date'])) ?> to <?php echo date('M j Y', strtotime($c['event_end_date'])) ?><br />
     <strong>Time: </strong><?php echo date('h:i a', strtotime($c['event_start_time'])) ?> until <?php echo date('h:i a', strtotime($c['event_end_time'])) ?>
     <div style="border: 1px solid gray; padding: 7px;" class="img-rounded"><?php echo $c['event_detail'] ?></div><br />
     <a href="javascript:history.go(-1)">Back to Events</a>
     </div>
     </div>
     </div>
     <?php
}

function getWeeks($timestamp)
{
     $month = date("m", strtotime($timestamp));
     $maxday    = date("t",$month);
     $thismonth = getdate(strtotime($timestamp));
     $timeStamp = mktime(0,0,0,$thismonth['mon'],1,$thismonth['year']);    //Create time stamp of the first day from the give date.
     $startday  = date('w',$timeStamp);    //get first day of the given month
     $day = $thismonth['mday'];
     $weeks = 0;
     $week_num = 0;

     for($i=0; $i<($maxday+$startday); $i++) {
          if(($i % 7) == 0){
               $weeks++;
          }
          if($day == ($i - $startday + 1)){
               $week_num = $weeks;
          }
     }
     switch($week_num) {
          case 1:
               return 'first';
               break;
          case 2:
               return 'second';
               break;
          case 3:
               return 'third';
               break;
          case 4:
               return 'fourth';
               break;
          case 5:
               return 'fifth';
               break;
          default:
               return 'none';
               break;
     }     
}
?>