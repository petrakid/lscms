<?php
if(isset($head) && $head == 1) {
     ?>
     <script type="text/javascript">
          var _paq = _paq || [];
          _paq.push(["setCookieDomain", "*.www.stpaulsmilaca.org"]);
          _paq.push(['trackPageView']);
          _paq.push(['enableLinkTracking']);
          (function() {
               var u="//analytics.luthersites.net/";
               _paq.push(['setTrackerUrl', u+'piwik.php']);
               _paq.push(['setSiteId', '2']);
               var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
               g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
          })
     ();
     </script>
     <?php
     unset($head);
} else {
     ?>
     <iframe id="iframe" src="https://analytics.luthersites.net/index.php?module=Widgetize&action=iframe&moduleToWidgetize=Dashboard&actionToWidgetize=index&idSite=2&period=week&date=yesterday" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="1400" seamless="seamless"></iframe>
     <style>
     #autopanel {
          height: 1500px;
     }
     </style>
     <?php
}
?>
