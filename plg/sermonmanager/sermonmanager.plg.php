<script type="text/javascript" src="/js/jquery.jplayer.js"></script>
<link type="text/css" href="/css/jplayer.blue.monday.css" rel="stylesheet" /> 
<?php
ini_set("extension","php_openssl.dll");
ini_set("allow_url_fopen", "On");

if(isset($_GET['selected_id'])) {
     $sm = $db->query("SELECT * FROM tbl_sermons WHERE s_id = $_GET[selected_id]");
     if($sm->rowCount() == 0) {
          echo 'No available sermon selected';
     } else {
          $smn = $sm->fetch(PDO::FETCH_ASSOC);
          ?>
          
          <div class="row">
          <div class="col-md-7">
          <img class="img-fluid hoverable" src="<?php echo $gbl['site_url'] .'/ast/sermons/'. $smn['sermon_image'] ?>" style="max-height: 450px" />
          <h2 class="h2-responsive"><?php echo $smn['sermon_title'] ?></h2>
          <h5 class="h5-responsive"><?php echo $smn['sermon_desc'] ?></h5>
          <h6 class="h6-responsive"><?php echo $smn['sermon_preacher'] ?></h6>
          <h6 class="h6-responsive"><?php echo date('F j Y', strtotime($smn['sermon_date'])) ?></h6>
          <button onclick="window.history.back();" type="button" class="btn btn-warning">Go Back to List</button>
          <?php
          if(isset($_SESSION['isLoggedIn'])) {
               ?>
               <button type="button" class="btn btn-unique get_data" data-id="<?php echo $smn['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal">Edit</button>
               <button type="button" class="btn btn-danger get_datad" data-id="<?php echo $smn['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal">Delete</button><br /><br />
               <?php
          }          
          if($smn['sermon_text'] > '') {
               ?>
               <div class="card-heading panel-heading-custom" data-toggle="collapse" data-target="#autopanel"><h4 class="panel-title panel-title-custom">Click to read</h4></div>
               <div class="card-body collapse out" id="autopanel"><?php echo $smn['sermon_text'] ?></div>               
               <?php
          }
          if($smn['sermon_audio_file'] > '') {
               ?>
               <br />
               <div class="card-heading card-heading-custom"><h4 class="card-title card-title-custom">Listen to Audio (click the play button below)</h4></div>
               <div class="card-body">               
               <script type="text/javascript">
               $(document).ready(function(){
                   $("#jquery_jplayer_<?php echo $smn['s_id'] ?>").jPlayer({
                         ready: function () {
                              $(this).jPlayer("setMedia", {
                                   mp3: '<?php echo $gbl['site_url'] ?>/ast/sermons/<?php echo $smn['sermon_audio_file'] ?>'
                              });
                         },
                         cssSelectorAncestor: "#jp_container_<?php echo $smn['s_id'] ?>",
                         swfPath: "<?php echo $gbl['site_url'] ?>/plg/sermonmanager",
                         supplied: "mp3",
                         useStateClassSkin: true,
                         autoBlur: false,
                         smoothPlayBar: true,
                         keyEnabled: true,
                         remainingDuration: true,
                         toggleDuration: true,
                    });
               });
               </script>
               <div id="jquery_jplayer_<?php echo $smn['s_id'] ?>" class="jp-jplayer"></div>
               <div id="jp_container_<?php echo $smn['s_id'] ?>" class="jp-audio" role="application" aria-label="media player">
               <div class="jp-type-single">
               <div class="jp-gui jp-interface">
               <div class="jp-volume-controls">
               <button class="jp-mute" role="button" tabindex="0">mute</button>
               <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
               <div class="jp-volume-bar">
               <div class="jp-volume-bar-value"></div>
               </div>
               </div>
               <div class="jp-controls-holder">
               <div class="jp-controls">
               <button class="jp-play" role="button" tabindex="0">play</button>
               <button class="jp-stop" role="button" tabindex="0">stop</button>
               </div>
               <div class="jp-progress">
               <div class="jp-seek-bar">
               <div class="jp-play-bar"></div>
               </div>
               </div>
               <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
               <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
               <div class="jp-toggles">
               <button class="jp-repeat" role="button" tabindex="0">repeat</button>
               </div>
               </div>
               </div>
               <div class="jp-details">
               <div class="jp-title" aria-label="title"><a href="<?php echo $gbl['site_url'] ?>/ast/sermons/<?php echo $smn['sermon_audio_file'] ?>" target="_blank" data-tooltip="Right-click to Download" data-toggle="tooltip"><?php echo $smn['sermon_title'] ?> - Download</a></div>
               </div>
               <div class="jp-no-solution">
               <span>Update Required</span>
               To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
               </div>
               </div>
               </div>
               </div>               
               <?php
          }
          if($smn['sermon_pdf_file'] > '') {
               ?>
               <br />
               <a href="<?php echo $gbl['site_url'] .'/ast/sermons/'. $smn['sermon_pdf_file'] ?>" target="_blank">
               <div class="card-heading card-heading-custom"><h4 class="card-title card-title-custom">Download the PDF</h4></div></a>               
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
          <div class="col-md-5">
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
     <div class="row">
     <div class="card-deck">
     
     <?php
     $r = 1;
     $smn = $db->query("SELECT s_id, sermon_title, sermon_date, sermon_preacher, sermon_image, sermon_desc FROM tbl_sermons WHERE sermon_status = 1 ORDER BY sermon_date DESC LIMIT 20");
     if($ss['layout_type'] == 1) {      
          while($sm = $smn->fetch(PDO::FETCH_ASSOC)) {
               if($sm['sermon_image'] == '') {
                    $sermonimage = $gbl['site_url'] .'/ast/sermons/defaultimage.jpg';
               } else {
                    $sermonimage = $gbl['site_url'] .'/ast/sermons/'. $sm['sermon_image'];
               }
               ?>
               <div class="card mb-4">
               <div class="view overlay">
               <img class="card-img-top" src="<?php echo $sermonimage ?>" alt="<?php echo $sm['sermon_title'] ?>" />
               <a><div class="mask rgba-white-slight"></div></a>
               </div>
                              
               <div class="card-body">
               <h4 class="font-weight-bold card-title"><?php echo $sm['sermon_title'] ?></h4>
               <h6 class="card-subtitle mb-2 text-muted"><?php echo date('F j Y', strtotime($sm['sermon_date'])) ?></h6>
               <p class="card-text"><?php echo $sm['sermon_desc'] ?></p>
               <a href="<?php echo $gbl['site_url'] .'/'. $parent .'/Sermon/&selected_id='. $sm['s_id'] ?>" class="black-text d-flex justify-content-end btn-md"><h5>See More <i class="fa fa-angle-double-right"></i></h5></a>
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
               if($r >= 5) {
                    echo '</div><div class="card-deck">';
                    $r = 1;
               }
          }
     }
     ?>
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
}
?>

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

<?php
if($gbl['social_sites'] == 1) {
     ?>
     <script type="text/javascript">
     window.addEventListener("hashchange", function () {
          addthis.layers.refresh();
     });
     </script>
     <?php
}
?>