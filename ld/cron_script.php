<?php
// include plugin CRON scripts
$crn = $db->query("SELECT plugin_file FROM $_SESSION[prefix]_plugins WHERE plugin_use_cron = 1 AND plugin_status = 1");
while($cr = $crn->fetch(PDO::FETCH_ASSOC)) {
     include 'plg/'. $cr['plugin_file'] .'/cron.php';
}

// include other/system CRON scripts


?>

