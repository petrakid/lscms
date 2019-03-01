<?php
include 'lo/head.inc.php';

$plx = $db->query("SELECT * FROM tbl_parallax_settings WHERE px_p_id = $pg[p_id] AND px_status = 1");
$px = $plx->fetch(PDO::FETCH_ASSOC);

if($px['px_hide_menu'] == 0) {
     include 'lo/top_menu.inc.php';
} 

?>
<main>

<?php
$pxs = $db->query("SELECT * FROM tbl_parallax_data WHERE ps_px_id = $px[px_id] ORDER BY ps_order");
while($ps = $pxs->fetch(PDO::FETCH_ASSOC)) {
     echo $ps['ps_data'] ."\r\n";
}
?>

</main>
  
<?php
if($px['px_hide_footer']  == 0) {
     include 'lo/foot.inc.php';
}
?>

<script src="js/mdb.js"></script>
<script>
objectFitImages();
jarallax(document.querySelectorAll('.jarallax'));
jarallax(document.querySelectorAll('.jarallax-keep-img'), {
     keepImg: true,
});
</script>
