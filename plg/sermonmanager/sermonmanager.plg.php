
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
<link rel="stylesheet" href="css/audio-player.css" />
 
<?php
ini_set("extension","php_openssl.dll");
ini_set("allow_url_fopen", "On");

if(isset($_GET['selected_id'])) {    
     if(isset($_SESSION['sermon_viewed'])) {
          if($_SESSION['sermon_viewed'] != $_GET['selected_id']) {
               if(!preg_match('/(abot|dbot|ebot|hbot|kbot|lbot|mbot|nbot|obot|pbot|rbot|sbot|tbot|vbot|ybot|zbot|bot\.|bot\/|_bot|\.bot|\/bot|\-bot|\:bot|\(bot|crawl|slurp|spider|seek|accoona|acoon|adressendeutschland|ah\-ha\.com|ahoy|altavista|ananzi|anthill|appie|arachnophilia|arale|araneo|aranha|architext|aretha|arks|asterias|atlocal|atn|atomz|augurfind|backrub|bannana_bot|baypup|bdfetch|big brother|biglotron|bjaaland|blackwidow|blaiz|blog|blo\.|bloodhound|boitho|booch|bradley|butterfly|calif|cassandra|ccubee|cfetch|charlotte|churl|cienciaficcion|cmc|collective|comagent|combine|computingsite|csci|curl|cusco|daumoa|deepindex|delorie|depspid|deweb|die blinde kuh|digger|ditto|dmoz|docomo|download express|dtaagent|dwcp|ebiness|ebingbong|e\-collector|ejupiter|emacs\-w3 search engine|esther|evliya celebi|ezresult|falcon|felix ide|ferret|fetchrover|fido|findlinks|fireball|fish search|fouineur|funnelweb|gazz|gcreep|genieknows|getterroboplus|geturl|glx|goforit|golem|grabber|grapnel|gralon|griffon|gromit|grub|gulliver|hamahakki|harvest|havindex|helix|heritrix|hku www octopus|homerweb|htdig|html index|html_analyzer|htmlgobble|hubater|hyper\-decontextualizer|ia_archiver|ibm_planetwide|ichiro|iconsurf|iltrovatore|image\.kapsi\.net|imagelock|incywincy|indexer|infobee|informant|ingrid|inktomisearch\.com|inspector web|intelliagent|internet shinchakubin|ip3000|iron33|israeli\-search|ivia|jack|jakarta|javabee|jetbot|jumpstation|katipo|kdd\-explorer|kilroy|knowledge|kototoi|kretrieve|labelgrabber|lachesis|larbin|legs|libwww|linkalarm|link validator|linkscan|lockon|lwp|lycos|magpie|mantraagent|mapoftheinternet|marvin\/|mattie|mediafox|mediapartners|mercator|merzscope|microsoft url control|minirank|miva|mj12|mnogosearch|moget|monster|moose|motor|multitext|muncher|muscatferret|mwd\.search|myweb|najdi|nameprotect|nationaldirectory|nazilla|ncsa beta|nec\-meshexplorer|nederland\.zoek|netcarta webmap engine|netmechanic|netresearchserver|netscoop|newscan\-online|nhse|nokia6682\/|nomad|noyona|nutch|nzexplorer|objectssearch|occam|omni|open text|openfind|openintelligencedata|orb search|osis\-project|pack rat|pageboy|pagebull|page_verifier|panscient|parasite|partnersite|patric|pear\.|pegasus|peregrinator|pgp key agent|phantom|phpdig|picosearch|piltdownman|pimptrain|pinpoint|pioneer|piranha|plumtreewebaccessor|pogodak|poirot|pompos|poppelsdorf|poppi|popular iconoclast|psycheclone|publisher|python|rambler|raven search|roach|road runner|roadhouse|robbie|robofox|robozilla|rules|salty|sbider|scooter|scoutjet|scrubby|search\.|searchprocess|semanticdiscovery|senrigan|sg\-scout|shai\'hulud|shark|shopwiki|sidewinder|sift|silk|simmany|site searcher|site valet|sitetech\-rover|skymob\.com|sleek|smartwit|sna\-|snappy|snooper|sohu|speedfind|sphere|sphider|spinner|spyder|steeler\/|suke|suntek|supersnooper|surfnomore|sven|sygol|szukacz|tach black widow|tarantula|templeton|\/teoma|t\-h\-u\-n\-d\-e\-r\-s\-t\-o\-n\-e|theophrastus|titan|titin|tkwww|toutatis|t\-rex|tutorgig|twiceler|twisted|ucsd|udmsearch|url check|updated|vagabondo|valkyrie|verticrawl|victoria|vision\-search|volcano|voyager\/|voyager\-hc|w3c_validator|w3m2|w3mir|walker|wallpaper|wanderer|wauuu|wavefire|web core|web hopper|web wombat|webbandit|webcatcher|webcopy|webfoot|weblayers|weblinker|weblog monitor|webmirror|webmonkey|webquest|webreaper|websitepulse|websnarf|webstolperer|webvac|webwalk|webwatch|webwombat|webzinger|wget|whizbang|whowhere|wild ferret|worldlight|wwwc|wwwster|xenu|xget|xift|xirq|yandex|yanga|yeti|yodao|zao\/|zippp|zyborg|\.\.\.\.)/i', $_SERVER['HTTP_USER_AGENT'])) {
                    $db->exec("UPDATE tbl_sermons SET sermon_views = sermon_views + 1 WHERE s_id = $_GET[selected_id]");
               }
          }
     } else {
          if(!preg_match('/(abot|dbot|ebot|hbot|kbot|lbot|mbot|nbot|obot|pbot|rbot|sbot|tbot|vbot|ybot|zbot|bot\.|bot\/|_bot|\.bot|\/bot|\-bot|\:bot|\(bot|crawl|slurp|spider|seek|accoona|acoon|adressendeutschland|ah\-ha\.com|ahoy|altavista|ananzi|anthill|appie|arachnophilia|arale|araneo|aranha|architext|aretha|arks|asterias|atlocal|atn|atomz|augurfind|backrub|bannana_bot|baypup|bdfetch|big brother|biglotron|bjaaland|blackwidow|blaiz|blog|blo\.|bloodhound|boitho|booch|bradley|butterfly|calif|cassandra|ccubee|cfetch|charlotte|churl|cienciaficcion|cmc|collective|comagent|combine|computingsite|csci|curl|cusco|daumoa|deepindex|delorie|depspid|deweb|die blinde kuh|digger|ditto|dmoz|docomo|download express|dtaagent|dwcp|ebiness|ebingbong|e\-collector|ejupiter|emacs\-w3 search engine|esther|evliya celebi|ezresult|falcon|felix ide|ferret|fetchrover|fido|findlinks|fireball|fish search|fouineur|funnelweb|gazz|gcreep|genieknows|getterroboplus|geturl|glx|goforit|golem|grabber|grapnel|gralon|griffon|gromit|grub|gulliver|hamahakki|harvest|havindex|helix|heritrix|hku www octopus|homerweb|htdig|html index|html_analyzer|htmlgobble|hubater|hyper\-decontextualizer|ia_archiver|ibm_planetwide|ichiro|iconsurf|iltrovatore|image\.kapsi\.net|imagelock|incywincy|indexer|infobee|informant|ingrid|inktomisearch\.com|inspector web|intelliagent|internet shinchakubin|ip3000|iron33|israeli\-search|ivia|jack|jakarta|javabee|jetbot|jumpstation|katipo|kdd\-explorer|kilroy|knowledge|kototoi|kretrieve|labelgrabber|lachesis|larbin|legs|libwww|linkalarm|link validator|linkscan|lockon|lwp|lycos|magpie|mantraagent|mapoftheinternet|marvin\/|mattie|mediafox|mediapartners|mercator|merzscope|microsoft url control|minirank|miva|mj12|mnogosearch|moget|monster|moose|motor|multitext|muncher|muscatferret|mwd\.search|myweb|najdi|nameprotect|nationaldirectory|nazilla|ncsa beta|nec\-meshexplorer|nederland\.zoek|netcarta webmap engine|netmechanic|netresearchserver|netscoop|newscan\-online|nhse|nokia6682\/|nomad|noyona|nutch|nzexplorer|objectssearch|occam|omni|open text|openfind|openintelligencedata|orb search|osis\-project|pack rat|pageboy|pagebull|page_verifier|panscient|parasite|partnersite|patric|pear\.|pegasus|peregrinator|pgp key agent|phantom|phpdig|picosearch|piltdownman|pimptrain|pinpoint|pioneer|piranha|plumtreewebaccessor|pogodak|poirot|pompos|poppelsdorf|poppi|popular iconoclast|psycheclone|publisher|python|rambler|raven search|roach|road runner|roadhouse|robbie|robofox|robozilla|rules|salty|sbider|scooter|scoutjet|scrubby|search\.|searchprocess|semanticdiscovery|senrigan|sg\-scout|shai\'hulud|shark|shopwiki|sidewinder|sift|silk|simmany|site searcher|site valet|sitetech\-rover|skymob\.com|sleek|smartwit|sna\-|snappy|snooper|sohu|speedfind|sphere|sphider|spinner|spyder|steeler\/|suke|suntek|supersnooper|surfnomore|sven|sygol|szukacz|tach black widow|tarantula|templeton|\/teoma|t\-h\-u\-n\-d\-e\-r\-s\-t\-o\-n\-e|theophrastus|titan|titin|tkwww|toutatis|t\-rex|tutorgig|twiceler|twisted|ucsd|udmsearch|url check|updated|vagabondo|valkyrie|verticrawl|victoria|vision\-search|volcano|voyager\/|voyager\-hc|w3c_validator|w3m2|w3mir|walker|wallpaper|wanderer|wauuu|wavefire|web core|web hopper|web wombat|webbandit|webcatcher|webcopy|webfoot|weblayers|weblinker|weblog monitor|webmirror|webmonkey|webquest|webreaper|websitepulse|websnarf|webstolperer|webvac|webwalk|webwatch|webwombat|webzinger|wget|whizbang|whowhere|wild ferret|worldlight|wwwc|wwwster|xenu|xget|xift|xirq|yandex|yanga|yeti|yodao|zao\/|zippp|zyborg|\.\.\.\.)/i', $_SERVER['HTTP_USER_AGENT'])) {
               $db->exec("UPDATE tbl_sermons SET sermon_views = sermon_views + 1 WHERE s_id = $_GET[selected_id]");
               $_SESSION['sermon_viewed'] = $_GET['selected_id'];
          }       
     }
     $sm = $db->query("SELECT * FROM tbl_sermons WHERE s_id = $_GET[selected_id]");
     if($sm->rowCount() == 0) {
          echo 'No available sermon selected';
     } else {
          $smn = $sm->fetch(PDO::FETCH_ASSOC);
          ?>
          
          <div class="row">
          <div class="col-md-4">
          <div class="row">
          <div class="col-12">
          <h1 class="h2-responsive"><?php echo $smn['sermon_title'] ?></h1>
          <h4 class="h5-responsive"><?php echo $smn['sermon_desc'] ?></h4>
          <h5 class="h6-responsive"><?php echo $smn['sermon_preacher'] ?></h5>
          <h6 class="h6-responsive"><?php echo date('F jS Y', strtotime($smn['sermon_date'])) ?> (Views: <?php echo $smn['sermon_views'] ?>)</h6>  
          </div>

          </div>
          <div class="row">
          <div class="col-12">          
          <?php
          $text = stripslashes($smn['sermon_text']);
          if($smn['sermon_text'] == '') {
               $text = 'To read the sermon text, click the Download the PDF button.<br /><hr />';
          }
          echo mb_strimwidth($text, 0, 500, "...");
          if($smn['sermon_text'] > '') {
               ?>
               <br />
               <hr />
               <a class="btn btn-unique" data-target="#text_modal" data-toggle="modal" onclick="getSermonText(<?php echo $smn['s_id'] ?>)"><i class="fas fa-paragraph"></i> Read Text</a>
               <?php
               if($smn['sermon_pdf_file'] > '') {
                    ?>
                    <button onclick="window.history.back();" type="button" class="btn btn-warning"><i class="fa fa-angle-double-left mr-1"></i> Go Back to List</button>                    
                    <a href="<?php echo $gbl['site_url'] .'/ast/sermons/'. $smn['sermon_pdf_file'] ?>" target="_blank" class="btn btn-pink"><i class="far fa-file-pdf"></i> Download the PDF</a>
                                   
                    <?php
               }                 
          } else {
               if($smn['sermon_pdf_file'] > '') {
                    ?>
                    <br />
                    <button onclick="window.history.back();" type="button" class="btn btn-warning"><i class="fa fa-angle-double-left mr-1"></i> Go Back to List</button>                    
                    <a href="<?php echo $gbl['site_url'] .'/ast/sermons/'. $smn['sermon_pdf_file'] ?>" target="_blank" class="btn btn-pink"><i class="far fa-file-pdf"></i> Download the PDF</a>
                                   
                    <?php
               }                
          }
          if(isset($_SESSION['isLoggedIn'])) {
               ?>
               <br />
               <button type="button" class="btn btn-unique get_data" data-id="<?php echo $smn['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal">Edit</button>
               <button type="button" class="btn btn-danger get_datad" data-id="<?php echo $smn['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal">Delete</button><br /><br />
               <?php
          }
          ?>
            
          </div>
          </div>
          </div>
          <div class="col-md-4">
          <?php       
          if($smn['sermon_audio_file'] > '') {
               ?>
               <div class="row">
               <div class="col-md-12">
               <section class="audio-player card">
               <div class="card">
               <div class="card-body">
               <h2 class="card-title col text-center audio-title"><?php echo stripslashes($smn['sermon_title']) ?></h2>
               <div class="row aling-items-center mt-4 mb-3 mx-0">
               <i id="play-button" class="material-icons play-pause text-primary mr-2" aria-hidden="true" style="cursor: pointer;">play_circle_outline</i>
               <i id="pause-button" class="material-icons play-pause d-none text-primary mr-2" aria-hidden="true" style="cursor: pointer;">pause_circle_outline</i>
               <i id="next-button" class="material-icons text-primary ml-2 mr-3" aria-hidden="true" style="cursor: pointer;">skip_next</i>
               <div class="col ml-auto border border-primary p-1">
               <img id="thumbnail" class="img-fluid hoverable" src="<?php echo $gbl['site_url'] ?>/ast/sermons/<?php echo $smn['sermon_image'] ?>" />
               </div>
               </div>
               <div class="p-0 m-0" id="now-playing">
               <p class="font-italic mb-0">Now Playing: </p>
               <p class="lead" id="title"><?php echo $smn['sermon_title'] ?></p>
               </div>
               <div class="progress-bar progress col-12 mb-3"></div>
               </div>
               <h6 class="col h6">Related Sermons</h6>
               <ul class="playlist list-group list-group-flush">
               <?php
               $list = $db->query("SELECT s_id, sermon_audio_file, sermon_title, sermon_date, sermon_image FROM tbl_sermons WHERE MATCH(sermon_keywords, sermon_desc) AGAINST ('$smn[sermon_title]' IN NATURAL LANGUAGE MODE) ORDER BY sermon_date DESC LIMIT 8");
               while($ls = $list->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    
                    <li class="<?php if($ls['s_id'] == $smn['s_id']) { echo 'active';} ?> list-group-item playlist-item" audio_title="<?php echo $ls['sermon_title'] ?>" audio_url="<?php echo $gbl['site_url'] ?>/ast/sermons/<?php echo $ls['sermon_audio_file'] ?>" img_url="<?php echo $gbl['site_url'] ?>/ast/sermons/<?php echo $ls['sermon_image'] ?>"><?php echo stripslashes($ls['sermon_title']) ?> (<?php echo date('F jS, Y', strtotime($ls['sermon_date'])) ?>)</li>
                    
                    
                    <?php
               }
               ?>
               </ul>
               </div>
               <audio id="audio-player" class="d-none" src="<?php echo $gbl['site_url'] ?>/ast/sermons/<?php echo $smn['sermon_audio_file'] ?>" type="audio/mp3" controls="controls"></audio>
               </section>
               </div>
               </div>
               
               <?php
          }
          if($smn['sermon_embed_url'] > '') {
               ?>
               <br />
               <div class="card-heading card-heading-custom"><h4 class="panel-title panel-title-custom">Watch the Video</h4></div>
               <div class="card-body">
               <iframe width="560" height="315" src="<?php echo $smn['sermon_embed_url'] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
               </div>               
               <?php
          }                              
          ?>
          </div>
          <div class="col-md-4">
          <?php
          $sset = $db->query("SELECT esv_api FROM tbl_sermon_settings WHERE ss_id = 1");
          $api = $sset->fetch(PDO::FETCH_ASSOC);
          if($api['esv_api'] > '') {
               $scripture = str_replace(" ","+", $smn['sermon_scripture']);
               $scripture = htmlentities($scripture);
               $token = $api['esv_api'];
               $url   = 'https://api.esv.org/v3/passage/html/?q=';
               
               $headr = array();
               $headr[] = 'Content-length: 0';
               $headr[] = 'Content-type: application/json';
               $headr[] = 'Authorization: Token '.$token;               
               
               $ch = curl_init();
               curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);               
               curl_setopt($ch, CURLOPT_URL, $url . $scripture);
               curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
               curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
               curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
               
               $response = curl_exec($ch);
               curl_close($ch);
               $decoded = json_decode($response, true);
               foreach($decoded['passages'] AS $passage) {
                    echo $passage;
               }
          } else {
               // There is no bible api to make this work so it won't show up
          }
          ?>          
          </div>
          </div>
          <script src="js/jquery-ui-slider.js"></script>          
          <script src="js/audioPlayer.js"></script>
          
          <?php         
     }    
} else {
     $parentx = explode("/", $_SESSION['fullpage']);
     $parent = $parentx[0];
     $sset = $db->query("SELECT * FROM tbl_sermon_settings WHERE ss_id = 1");
     $ss = $sset->fetch(PDO::FETCH_ASSOC);
     if(isset($_SESSION['isLoggedIn'])) {
          ?> 
          <section class="mb-3">
          <div class="row">
          <div class="col-12">
          <div class="card">
          <div class="card-body">
          <h5 class="card-title">Settings</h5>
          <div class="row">
          <div class="col-3">
          <div class="form-check">
          <input class="form-check-input" onclick="changeLayout()" id="layout_typeb" type="radio" name="layout_type" value="1" <?php if($ss['layout_type'] == 1) { echo 'checked="checked"';} ?> />
          <label class="form-check-label" for="layout_typeb">Block Layout</label>
          </div>
          <div class="form-check">
          <input class="form-check-input" onclick="changeLayout()" id="layout_typet" type="radio" name="layout_type" value="2" <?php if($ss['layout_type'] == 2) { echo 'checked="checked"';} ?> />
          <label class="form-check-label" for="layout_typet">Table Layout</label>
          </div>
          </div>
          
          <div class="col-3">
          <div class="md-form">
          <input onblur="changeSpp()" id="sermons_per_page" type="number" name="sermons_per_page" value="<?php echo $ss['sermons_per_page'] ?>" class="form-control" />
          <label for="sermons_per_page">Rows per Page (Table Layout)</label>
          </div>
          </div>
          
          <div class="col-6 mb-2">
          <div class="md-form">
          <input onblur="change_api()" id="esv_api" type="text" name="esv_api" value="<?php echo $ss['esv_api'] ?>" class="form-control" />
          <label for="esv_api">ESV Bible API</label>
          <small class="form-text text-muted">(Must register for a key at the <a href="https://api.esv.org/" target="_blank">ESV Website</a>)</small>
          </div>
          </div>
          </div>
          <button type="button" class="btn btn-warning btn-block new_sermon" data-toggle="modal" data-target="#add_sermon_model">Add New Sermon</button>          
          </div>
          </div>
          </div>
          </div>
          </section>
          <?php        
     }
     ?>
     <div class="row justify-content-end">
     <div class="col-12">
     <form class="form-inline justify-content-end">
     <div class="active-cyan-3 active-cyan-4 mb-1 md-form" style="width: 400px;">
     <input class="form-control" type="text" id="searchBox" placeholder="Search Sermons by date, title, passage or description" aria-label="Search" onkeyup="searchSermons(this.value)" style="width: 100%;" />
     </div>
     <button type="button" class="btn btn-unique mb-0" onclick="resetSermons()">Reset</button>    
     </div>
     </form> 
     </div>
     <div id="sermonSearchRes">
     <div class="row">
     <div class="col-md-12">
     <div class="card-deck">
    
     <?php
     $r = 1;
     $smn = $db->query("SELECT s_id, sermon_title, sermon_date, sermon_preacher, sermon_image, sermon_desc FROM tbl_sermons WHERE sermon_status = 1 ORDER BY sermon_date DESC LIMIT 20");
     if($ss['layout_type'] == 1) {      
          while($sm = $smn->fetch(PDO::FETCH_ASSOC)) {
               if($r >= 5) {
                    echo '</div><div class="card-deck">';
                    $r = 1;
               }               
               if($sm['sermon_image'] == '') {
                    $sermonimage = $gbl['site_url'] .'/ast/sermons/defaultimage.jpg';
               } else {
                    $sermonimage = $gbl['site_url'] .'/ast/sermons/'. $sm['sermon_image'];
               }
               ?>
               <div class="card mb-4 col-3">
               <div class="view overlay">
               <img class="card-img-top hoverable mt-2" src="<?php echo $sermonimage ?>" alt="<?php echo $sm['sermon_title'] ?>" />
               <a href="#!"><div class="mask flex-center rgba-stylish-strong"></div></a>
               </div>
                              
               <div class="card-body">
               <h4 class="font-weight-bold card-title"><?php echo $sm['sermon_title'] ?></h4>
               <h6 class="card-subtitle mb-2 text-muted"><?php echo date('F j Y', strtotime($sm['sermon_date'])) ?></h6>
               <p class="card-text"><?php echo $sm['sermon_desc'] ?></p>
               <a href="<?php echo $gbl['site_url'] .'/'. $parent .'/Sermon/&selected_id='. $sm['s_id'] ?>" class="btn btn-elegant justify-content-end z-depth-2">See More <i class="fa fa-angle-double-right"></i></a>
               <?php
               if(isset($_SESSION['isLoggedIn'])) {
                    ?>
                    <button type="button" class="btn btn-info btn-sm get_data" data-id="<?php echo $sm['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm get_datad" data-id="<?php echo $sm['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal">Delete</button>
                    <?php
               }
               ?>
               </div>
               </div>
               <?php
               $r++;
          }
     }
     ?>
     </div>
     </div>
     </div>
     
     <?php
     if($ss['layout_type'] == 2) {
          ?>
          <div class="row">
          <div class="col-md-12">
          <div class="table-responsive pt-3" style="background-color: white;">
          <table class="table table-hover table-striped" id="sortable">
          <thead>
          <tr>
          <?php if(isset($_SESSION['isLoggedIn'])) { echo '<th></th>'; } ?>
          <th>Date</th>
          <th>Title</th>
          <th>Preacher</th>
          <th>Description</th>
          <th></th>
          </tr>
          </thead>
         
          <tfoot>
          <tr>
          <?php if(isset($_SESSION['isLoggedIn'])) { echo '<th></th>'; } ?>
          <th>Date</th>
          <th>Title</th>
          <th>Preacher</th>
          <th>Description</th>
          <th></th>
          </tr>
          </tfoot>
     
          <tbody>          
          <?php
          while($sm = $smn->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <tr>
               <?php
               if(isset($_SESSION['isLoggedIn'])) {
                    ?>
                    <td>
                    <div class="btn-group" role="group" aria-label="Controls">
                    <button title="Edit Sermon" data-toggle="tooltip" type="button" class="btn btn-sm btn-default get_data" data-id="<?php echo $sm['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal"><i class="fa fa-pencil"></i></button>
                    <button title="Delete Sermon" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger get_datad" data-id="<?php echo $sm['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal"><i class="fa fa-trash"></i></button>
                    </div>
                    </td>
                    <?php
               }
               ?>
               <td data-order="<?php echo date('Ymd', strtotime($sm['sermon_date'])) ?>"><?php echo date('M j Y', strtotime($sm['sermon_date'])) ?></td>
               <td><?php echo stripslashes($sm['sermon_title']) ?></td>
               <td><?php echo stripslashes($sm['sermon_preacher']) ?></td>
               <td><?php echo stripslashes($sm['sermon_desc']) ?></td>
               <td><a href="<?php echo $gbl['site_url'] .'/'. $parent .'/Sermon/&selected_id='. $sm['s_id'] ?>" class="btn btn-sm btn-primary">Read More</a></td>
               </tr>
               <?php               
          }
          ?>
          </tbody>
          </table>
          </div>
          </div>
          </div>
          <?php
     }
     ?>
     </div>
     
     <?php
}
?>
<div class="modal fade" id="text_modal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-fluid" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Sermon Text</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body" id="text_modal_body">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>


<div class="modal fade" id="add_sermon_model" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">New Sermon</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body" id="add_sermon_modal_body">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload()">Close</button>
</div>
</div>
</div>
</div>


<div class="modal fade" id="sermon_editor_modal" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Sermon Editor</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body" id="sermon_editor_modal_body">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<script>
function searchSermons(term)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/sermonmanager/ajax.php',
          type: 'POST',
          data: {
               'search_sermons': 1,
               'search_data': term
          },
          success: function(data) {
               $('#sermonSearchRes').html(data);
          }
     })
}
function resetSermons()
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/sermonmanager/ajax.php',
          type: 'POST',
          data: {
               'reset_sermons': 1,
          },
          success: function(data) {
               $('#sermonSearchRes').html(data);
               $('#searchBox').val('');
          }
     })     
}
$(function() {
     $('#sortable').DataTable();
});
$('#sermon_editor_modal').on('hidden.bs.modal', function () {
    window.location.reload();
});
$(function() {
     $('#add_sermon_model').on('show.bs.modal', function() {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/sermonmanager/ajax.php',
               type: 'POST',
               data: {
                    'new_sermon': 1
               },
               success: function(data) {
                    $('#add_sermon_modal_body').html(data);
                    $('#sermonscripture').autocomplete({
                         appendTo: '.ui-front',
                         delay: 500,
                         minLength: 2,
                         source: ['Genesis', 'Exodus', 'Leviticus', 'Numbers', 'Deuteronomy', 'Joshua', 'Judges', 'Ruth', '1 Samuel', '2 Samuel', '1 Kings', '2 Kings', '1 Chronicles', '2 Chronicles', 'Ezra', 'Nehemiah', 'Esther', 'Job', 'Psalms', 'Proverbs', 'Song of Solomon', 'Ecclesiastes', 'Isaiah', 'Jeremiah', 'Lamentations', 'Ezekiel', 'Daniel', 'Hosea', 'Joel', 'Amos', 'Obadiah', 'Jonah', 'Micah', 'Nahum', 'Habakkuk', 'Zephaniah', 'Haggai', 'Zechariah', 'Malachi', 'Matthew', 'Mark', 'Luke', 'John', 'Acts', 'Romans', '1 Corinthians', '2 Corinthians', 'Galatians', 'Ephesians', 'Colossians', 'Philippians', '1 Thessalonians', '2 Thessalonians', '1 Timothy', '2 Timothy', 'Titus', 'Philemon', 'Hebrews', 'James', '1 Peter', '2 Peter', '1 John', '2 John', '3 John', 'Jude', 'Revelation']
                    });                      
                    $(function() {
                         $('#new_sermon').submit(function(e) {
                              e.preventDefault();
                              var form = $('#new_sermon')[0];
                              $('#add_new').prop('disabled', true);
                              $('#add_new').val('Please Wait...');          
                              var formData = new FormData(form);
                              $.ajax({
                                   xhr: function() {
                                        var xhr = new window.XMLHttpRequest();
                                        xhr.upload.addEventListener("progress", function(evt) {
                                             if(evt.lengthComputable) {
                                                  var percentComplete = evt.loaded / evt.total;
                                                  percentComplete = parseInt(percentComplete * 100);
                                                  $('#progressbar').progressbar({ value: percentComplete });
                                                  if(percentComplete === 100) {
                                                       // do something here someday
                                                  }
                                             }
                                        }, false);
                                        return xhr;
                                   },                                   
                                   url: '<?php echo $gbl['site_url'] ?>/plg/sermonmanager/ajax.php',
                                   type: "POST",
                                   data: formData,
                                   processData: false,
                                   contentType: false,
                                   success: function(data) {
                                        $('#add_sermon_modal_body').html(data);          
                                   }
                              }) 
                         })
                    })                    
               }
          })
     })
});
function getSermonText(sermonid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/sermonmanager/ajax.php',
          type: "POST",
          data: {
               'view_sermon_text': 1,
               's_id': sermonid,
          },
          success: function(data) {
               $('#text_modal_body').html(data);          
          }
     })      
}
function changeLayout()
{
     var lvalue = $("input[name='layout_type']:checked").val();
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/sermonmanager/ajax.php',
          type: "POST",
          data: {
               'change_layout': 1,
               'lvalue': lvalue
          },
          success: function(data) {
               location.reload();          
          }
     });
}
function changeSpp()
{
     spp = document.getElementById('sermons_per_page').value;
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/sermonmanager/ajax.php',
          type: "POST",
          data: {
               'sermons_per_page': 1,
               'spp': spp
          },
          success: function(data) {
               location.reload();          
          }
     });     
     
}
function change_api()
{
     api = document.getElementById('esv_api').value;
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/sermonmanager/ajax.php',
          type: "POST",
          data: {
               'change_api': 1,
               'esv_api': api
          },
          success: function(data) {
               location.reload();          
          }
     });         
}
$(function() {
     $(document).on("click",".get_data", function(){
          var sermonid = $(this).attr("data-id");    
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/sermonmanager/ajax.php',
               type: "POST",
               data: {
                    's_id': sermonid,
                    'edit': '1'
               },
               success: function(data) {
                    $('#sermon_editor_modal_body').html(data);
                    $('#sermonscripture').autocomplete({
                         appendTo: '.ui-front',
                         delay: 500,
                         minLength: 2,
                         source: ['Genesis', 'Exodus', 'Leviticus', 'Numbers', 'Deuteronomy', 'Joshua', 'Judges', 'Ruth', '1 Samuel', '2 Samuel', '1 Kings', '2 Kings', '1 Chronicles', '2 Chronicles', 'Ezra', 'Nehemiah', 'Esther', 'Job', 'Psalms', 'Proverbs', 'Song of Solomon', 'Ecclesiastes', 'Isaiah', 'Jeremiah', 'Lamentations', 'Ezekiel', 'Daniel', 'Hosea', 'Joel', 'Amos', 'Obadiah', 'Jonah', 'Micah', 'Nahum', 'Habakkuk', 'Zephaniah', 'Haggai', 'Zechariah', 'Malachi', 'Matthew', 'Mark', 'Luke', 'John', 'Acts', 'Romans', '1 Corinthians', '2 Corinthians', 'Galatians', 'Ephesians', 'Colossians', 'Philippians', '1 Thessalonians', '2 Thessalonians', '1 Timothy', '2 Timothy', 'Titus', 'Philemon', 'Hebrews', 'James', '1 Peter', '2 Peter', '1 John', '2 John', '3 John', 'Jude', 'Revelation']
                    });                    
                    $(function() {
                         $('#sermon_update').submit(function(e) {
                              e.preventDefault();
                              var form = $('#sermon_update')[0];
                              $('#editsermonbutton').prop('disabled', true);
                              $('#editsermonbutton').val('Please Wait...');          
                              var formData = new FormData(form);
                              $.ajax({
                                   xhr: function() {
                                        var xhr = new window.XMLHttpRequest();
                                        xhr.upload.addEventListener("progress", function(evt) {
                                             if(evt.lengthComputable) {
                                                  var percentComplete = evt.loaded / evt.total;
                                                  percentComplete = parseInt(percentComplete * 100);
                                                  $('#progressbar').progressbar({ value: percentComplete });
                                                  if(percentComplete === 100) {
                                                       // do something here someday
                                                  }
                                             }
                                        }, false);
                                        return xhr;
                                   },                                   
                                   url: '<?php echo $gbl['site_url'] ?>/plg/sermonmanager/ajax.php',
                                   type: "POST",
                                   data: formData,
                                   processData: false,
                                   contentType: false,
                                   success: function(data) {
                                        $('#sermon_editor_modal_body').html(data);          
                                   }
                              }) 
                         })
                    })
               }
          }) 
     })
});
$(function() {
     $(document).on("click",".get_datad", function(){
          var sermonid = $(this).attr("data-id");    
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/sermonmanager/ajax.php',
               type: "POST",
               data: {
                    's_id': sermonid,
                    'del': '1'
               },
               success: function(data) {
                    $('#sermon_editor_modal_body').html(data);          
               }
          }) 
     })
});
$(function() {
     $(document).on("click",".get_datar", function(){
          var sermonid = $(this).attr("data-id");    
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/sermonmanager/ajax.php',
               type: "POST",
               data: {
                    's_id': sermonid,
                    'res': '1'
               },
               success: function(data) {
                    $('#sermon_editor_modal_body').html(data);          
               }
          }) 
     })
});
function findUrl(text)
{
     var source = (text || '').toString();
     var urlArray = [];
     var url;
     var matchArray;
     var regexToken = /(((ftp|https?):\/\/)[\-\w@:%_\+.~#?,&\/\/=]+)|((mailto:)?[_.\w-]+@([\w][\w\-]+\.)+[a-zA-Z]{2,3})/g;
     while((matchArray = regexToken.exec( source )) !== null) {
          var token = matchArray[0];
          urlArray.push(token);
     }
     $('#embedurl').val(urlArray);
} 
</script>


<script type="text/javascript">
window.addEventListener("hashchange", function () {
     addthis.layers.refresh();
});
</script>
