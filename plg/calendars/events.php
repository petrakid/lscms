<?php
session_start();

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

$out = array();
$sql = $db->query("SELECT * FROM tbl_calendars_events WHERE event_status = 1");
while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $out[] = array(
        'id' => $row['e_id'],
        'title' => stripslashes($row['event_title']),
        'url' => $gbl['site_url'] .'/events/read-more/&eventid='. $row['e_id'],
        'start' => strtotime($row['event_start_date'] .' '. $row['event_start_time']) . '000',
        'end' => strtotime($row['event_end_date'] .' '. $row['event_end_time']) .'000',
        'color' => $row['event_color'],
        'font_color' => $row['event_font_color']
    );
}
echo json_encode(array('success' => 1, 'result' => $out));
exit;
?>