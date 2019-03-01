<?php header('Content-type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'."\n";

include 'ld/db.inc.php';
include 'ld/globals.inc.php';

?>
<url>
<loc><?php echo $gbl['site_url'] ?></loc>
<priority>1.00</priority>
</url>

<?php
$site = $db->query("SELECT menu_link, p_id FROM tbl_pages WHERE parent_id = 0 AND menu_status = 1 ORDER BY menu_order");
while($s = $site->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <url>
          <loc><?php echo $gbl['site_url'] ?>/<?php echo $s['menu_link'] ?></loc>
          <changefreq>weekly</changefreq>
          <priority>0.5</priority>
     </url>
     
     <?php
     $menu = $db->query("SELECT menu_link FROM tbl_pages WHERE parent_id = $s[p_id] AND menu_status = 1 ORDER BY menu_order");
     if($menu->rowCount() > 0) {
          while($m = $menu->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <url>
                    <loc><?php echo $gbl['site_url'] ?>/<?php echo $s['menu_link'] ?>/<?php echo $m['menu_link'] ?></loc>
                    <changefreq>weekly</changefreq>
                    <priority>0.5</priority>
               </url>
                              
               <?php
          }
     }
}
?>
</urlset>