<?php
if(isset($head) && $head == 1) {
     if($gbl['analytics_id'] > 0) {
          $url = preg_replace('#^https?://#', '', rtrim($gbl['site_url'], '/'));
          ?>
          <script type="text/javascript">
               var _paq = _paq || [];
               _paq.push(["setCookieDomain", "*.<?php echo $url ?>"]);
               _paq.push(['trackPageView']);
               _paq.push(['enableLinkTracking']);
               (function() {
                    var u="//analytics.luthersites.net/";
                    _paq.push(['setTrackerUrl', u+'piwik.php']);
                    _paq.push(['setSiteId', '<?php echo $gbl['analytics_id'] ?>']);
                    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
               })
          ();
          </script>
          <?php
          unset($head);
     } else {
          unset($head);
     }
} else {
     if($gbl['analytics_id'] > 0) {
          ?>
          <iframe id="iframe" src="https://analytics.luthersites.net/index.php?module=Widgetize&action=iframe&moduleToWidgetize=Dashboard&actionToWidgetize=index&idSite=<?php echo $gbl['analytics_id'] ?>&period=week&date=yesterday" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="1400" seamless="seamless"></iframe>
          <style>
          #autopanel {
               height: 1500px;
          }
          </style>
          <?php
     } else {
          ?>
          <p>It doesn't look like you've set up your site analytics just yet.  Not a problem!  Find your site in the dropdown box below, select it, and save.  Your analytics 
          will begin working immediately.  If you don't see your site, contact the Webmaster and request it be added to the Analytics system.  The easiest way to do this
          is by submitting a Support Ticket at <a href="https://www.luthersites.net" target="_blank">Luthersites</a>.</p>
          <?php
          $ma_host  = 'localhost';
          $ma_db    = 'lutherh_mamoto';
          $ma_user  = 'lutherh_conn1';
          $ma_pass  = ')EyMb1w?#uK&';
          
          $mdsn = "mysql:host=$ma_host;dbname=$ma_db;charset=utf8mb4";
          try {
               // create a PDO connection with the configuration data
               $mdb = new PDO($mdsn, $ma_user, $ma_pass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
               if($db) {
                    //print "Connected to the <strong>$db_db</strong> database successfully!";
               }
          $mdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $m) {
               // report error message
               echo $m->getMessage();
          }
          ?>
          <div class="row">
          <div class="col-5">
          <select name="mam_sites" id="mam_sites" class="mdb-select">
          <option selected disabled>Select a Site</option>
          <?php
          $anal = $mdb->query("SELECT idsite, name, main_url FROM mt_site ORDER BY name");
          while($an = $anal->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <option value="<?php echo $an['idsite'] ?>"><?php echo $an['name'] ?> / <?php echo $an['main_url'] ?></option>
               
               <?php
          }
          ?>
          </select>
          </div>
          <div class="col-3">
          <button type="button" class="btn btn-success btn-block" onclick="addSite()">Save</button>
          </div>
          <div class="col-4" id="siteres">
          
          </div>
          </div>
          <script>
          function addSite()
          {
               if(confirm("Are you SURE you want to add this site?  This cannot be undone!")) {
                    $.ajax({
                         url: '<?php echo $gbl['site_url'] ?>/plg/analytics/ajax.php',
                         type: 'POST',
                         data: {
                              'add_site': 1,
                              'site_id': $('select[name="mam_sites"]').val()
                         },
                         success: function(data) {
                              $('#siteres').html(data);
                              setTimeout(function() {
                                   window.location.reload()
                              }, 1500);
                         }
                    })
               }
          }
          </script>
          <?php
     }
}
?>
