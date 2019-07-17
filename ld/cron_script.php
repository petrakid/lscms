<?php
$crn = $db->query("SELECT plugin_file FROM tbl_plugins WHERE plugin_use_cron = 1 AND plugin_status = 1");
while($cr = $crn->fetch(PDO::FETCH_ASSOC)) {
     include 'plg/'. $cr['plugin_file'] .'/cron.php';
}
?>