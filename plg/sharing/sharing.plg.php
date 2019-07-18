<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
$seo = $db->query("SELECT * FROM tbl_seo WHERE seo = 1");
$s = $seo->fetch(PDO::FETCH_ASSOC);

$meta = $db->query("SELECT * FROM tbl_meta_tags ORDER BY meta_tag_order ASC");

$share = $db->query("SELECT * FROM tbl_sharing WHERE sh = 1");
$sh = $share->fetch(PDO::FETCH_ASSOC);
?>
<div class="row">
<div class="col-sm-12">
<div class="card-deck">
<div class="card mb-4">
<div class="card-body">
<h5 class="card-title h5">Site Submissions</h5>
<p class="card-text">In order for search engine sites like Google or Bing to properly crawl the website a verification process must be run.  You can add or remove search engine
optimization and crawling access from the site by adding or removing the verification code provided by each major search engine's "Webmaster Tools" areas.  Use the links below
each field to access the search engine's webmaster area, create an account, and get the code.</p>

<div class="md-form">
<input type="text" class="form-control" aria-describedby="bing_wm_tools_id_res" name="bing_wm_tools_id" id="bing_wm_tools_id" onblur="updateSeo('bing_wm_tools_id', this.value)" value="<?php echo htmlentities($s['bing_wm_tools_id']) ?>" />
<label for="bing_wm_tools_id">Bing Webmaster Tools</label>
<small class="form-text text-muted" id="bing_wm_tools_id_res">Access Bing Webmaster Tools by going <a href="https://www.bing.com/toolbox/webmaster/" target="_blank">HERE</a>.  Once you complete registration,
copy the Meta Tag option and paste it here. You may need to return to the Bing page and click "Verify" to complete the process.</small>
</div>

<div class="md-form">
<input type="text" class="form-control" aria-describedby="google_wm_tools_id_res" name="google_wm_tools_id" id="google_wm_tools_id" onblur="updateSeo('google_wm_tools_id', this.value)" value="<?php echo htmlentities($s['google_wm_tools_id']) ?>" />
<label for="google_wm_tools_id">Google Webmaster Tools</label>
<small class="form-text text-muted" id="google_wm_tools_id_res">Access Google Console by going <a href="https://www.google.com/webmasters/tools/dashboard" target="_blank">HERE</a>.  Once you complete registration,
copy the Meta Tag option and paste it here.  You may need to return to the Google page and click "Verify" to complete the process.</small>
</div>

<div class="md-form">
<input type="text" class="form-control" aria-describedby="yandex_wm_tools_id_res" name="yandex_wm_tools_id" id="yandex_wm_tools_id" onblur="updateSeo('yandex_wm_tools_id', this.value)" value="<?php echo htmlentities($s['yandex_wm_tools_id']) ?>" />
<label for="yandex_wm_tools_id">Yandex Webmaster Tools</label>
<small class="form-text text-muted" id="yandex_wm_tools_id_res">Access Yandex Tools by going <a href="https://webmaster.yandex.com/" target="_blank">HERE</a>.  Once you complete registration,
copy the Meta Tag option and paste it here.  You may need to return to the Yandex page and click "Verify" to complete the process.</small>
</div>

</div>
</div>

<div class="card mb-4">
<div class="card-body">
<h5 class="card-title h5">Meta Tags</h5>
<p class="card-text">You may add or remove Meta Tags here.  Some meta tags are essential for the operation of the site and could cause your site to malfunction if removed.
DO NOT remove the "base href" tag unless you know what you are doing!</p>

<?php
while($m = $meta->fetch(PDO::FETCH_ASSOC)) {
     ?>
     
     <div class="md-form">
     <input type="text" name="meta_tag_<?php echo $m['meta_tag_order'] ?>" id="meta_tag_<?php echo $m['meta_tag_order'] ?>" onblur="updateTag('<?php echo $m['m_id'] ?>', this.value)" class="form-control" value="<?php echo htmlentities($m['meta_tag']) ?>" />
     <small class="form-text text-muted" id="<?php echo $m['m_id'] ?>_res"></small>
     </div>
     
     <?php
}
?>
</div>
</div>

<div class="card mb-4">
<div class="card-body">
<h5 class="card-title h5">Social Media Configuration</h5>
<p class="card-text">Control your Social Media and content sharing features below.</p>
<div class="md-form">
<textarea id="sharing_api" name="sharing_api" class="md-textarea form-control" rows="3" onblur="updateSharing('sharing_api', this.value)"><?php echo htmlentities($sh['sharing_api']) ?></textarea>
<label for="sharing_api">Content Sharing Provider API Script</label>
<small class="form-text text-muted" id="sharing_api_res">There are several providers available.  <a href="https://addthis.com" target="_blank">AddThis</a> is the most known and used.  There is also <a href="https://www.sharethis.com" target="_blank">ShareThis</a>, <a href="https://addtoany.com" target="_blank">AddtoAny</a>, <a href="https://getsocial.io" target="_blank">Getsocial.io</a>, and many others.
Each provides a block of Javascript code which must be copied and pasted here.  You may also need to create an account on their website and configure the sharing features.</small>
</div>

<small class="form-text" id="sharing_status_res">Sharing API's Status</small>
<div class="form-check">
<input class="form-check-input" type="radio" name="sharing_status" id="sharing_status1" onclick="updateSharing('sharing_status', '1')" <?php if($sh['sharing_status'] == 1) { echo 'checked="checked"'; } ?> />
<label for="sharing_status1" class="form-check-label">Enabled</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="sharing_status" id="sharing_status0" onclick="updateSharing('sharing_status', '0')" <?php if($sh['sharing_status'] == 0) { echo 'checked="checked"'; } ?> />
<label for="sharing_status0" class="form-check-label">Disabled</label>
</div>
<hr />

<h6 class="card-text h6">The following settings are related to the Social Media buttons near the bottom of the Footer.</h6>
<small class="form-text" id="subscribe_bar_res">Show Subscribe Button Row?</small>
<div class="form-check">
<input class="form-check-input" type="radio" name="subscribe_bar" id="subscribe_bar1" onclick="updateSharing('subscribe_bar', '1')" <?php if($sh['subscribe_bar'] == 1) { echo 'checked="checked"'; } ?> />
<label for="subscribe_bar1" class="form-check-label">Show</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="subscribe_bar" id="subscribe_bar0" onclick="updateSharing('subscribe_bar', '0')" <?php if($sh['subscribe_bar'] == 0) { echo 'checked="checked"'; } ?> />
<label for="subscribe_bar0" class="form-check-label">Hide</label>
</div>

<small class="form-text" id="social_buttons_bar_res">Show Social Buttons Row?</small>
<div class="form-check">
<input class="form-check-input" type="radio" name="social_buttons_bar" id="social_buttons_bar1" onclick="updateSharing('social_buttons_bar', '1')" <?php if($sh['social_buttons_bar'] == 1) { echo 'checked="checked"'; } ?> />
<label for="social_buttons_bar1" class="form-check-label">Show</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="social_buttons_bar" id="social_buttons_bar0" onclick="updateSharing('social_buttons_bar', '0')" <?php if($sh['social_buttons_bar'] == 0) { echo 'checked="checked"'; } ?> />
<label for="social_buttons_bar0" class="form-check-label">Hide</label>
</div>

<small class="form-text text-muted">The Luthersites CMS provides several common Social Media sites with its sharing features.  If you wish to add additional sites, contact us.
For each of the sites you wish to use, you will need to create an account on their respective pages before they'll be useful to you.  Once you create the account,
access your page on the site (the public page), copy the URL and paste it in the corresponding field below.</small>
<div class="md-form">
<i class="fab fa-facebook prefix"></i>
<input type="url" name="facebook_id" id="facebook_id" onblur="updateSharing('facebook_id', this.value)" value="<?php echo $sh['facebook_id'] ?>" class="form-control" />
<label for="facebook_id" id="facebook_id_res">Facebook Page URL</label> 
</div>

<div class="md-form">
<i class="fab fa-twitter prefix"></i>
<input type="url" name="twitter_id" id="twitter_id" onblur="updateSharing('twitter_id', this.value)" value="<?php echo $sh['twitter_id'] ?>" class="form-control" />
<label for="twitter_id" id="twitter_id_res">Twitter Page URL</label> 
</div>

<div class="md-form">
<i class="fab fa-instagram prefix"></i>
<input type="url" name="instagram_id" id="instagram_id" onblur="updateSharing('instagram_id', this.value)" value="<?php echo $sh['instagram_id'] ?>" class="form-control" />
<label for="instagram_id" id="instagram_id_res">Instagram Page URL</label> 
</div>

<div class="md-form">
<i class="fab fa-pinterest prefix"></i>
<input type="url" name="pinterest_id" id="pinterest_id" onblur="updateSharing('pinterest_id', this.value)" value="<?php echo $sh['pinterest_id'] ?>" class="form-control" />
<label for="pinterest_id" id="pinterest_id_res">Pinterest Page URL</label> 
</div>

<div class="md-form">
<i class="fab fa-linkedin prefix"></i>
<input type="url" name="linkedin_id" id="linkedin_id" onblur="updateSharing('linkedin_id', this.value)" value="<?php echo $sh['linkedin_id'] ?>" class="form-control" />
<label for="linkedin_id" id="linkedin_id_res">Linkedin Page URL</label> 
</div>

<div class="md-form">
<i class="fab fa-tumblr prefix"></i>
<input type="url" name="tumblr_id" id="tumblr_id" onblur="updateSharing('tumblr_id', this.value)" value="<?php echo $sh['tumblr_id'] ?>" class="form-control" />
<label for="tumblr_id" id="tumblr_id_res">Tumblr Page URL</label> 
</div>

<div class="md-form">
<i class="fab fa-flipboard prefix"></i>
<input type="url" name="flipboard_id" id="flipboard_id" onblur="updateSharing('flipboard_id', this.value)" value="<?php echo $sh['flipboard_id'] ?>" class="form-control" />
<label for="flipboard_id" id="flipboard_id_res">Flipboard Page URL</label> 
</div>

<div class="md-form">
<i class="fab fa-google-plus prefix"></i>
<input type="url" name="google_id" id="google_id" onblur="updateSharing('google_id', this.value)" value="<?php echo $sh['google_id'] ?>" class="form-control" />
<label for="google_id" id="google_id_res">Google+ Page URL</label> 
</div>

<div class="md-form">
<i class="fab fa-reddit prefix"></i>
<input type="url" name="reddit_id" id="reddit_id" onblur="updateSharing('reddit_id', this.value)" value="<?php echo $sh['reddit_id'] ?>" class="form-control" />
<label for="reddit_id" id="reddit_id_res">Reddit Page URL</label> 
</div>

<div class="md-form">
<i class="fab fa-microsoft prefix"></i>
<input type="url" name="yammer_id" id="yammer_id" onblur="updateSharing('yammer_id', this.value)" value="<?php echo $sh['yammer_id'] ?>" class="form-control" />
<label for="yammer_id" id="yammer_id_res">Yammer Page URL</label> 
</div>

<small class="form-text" id="social_buttons_bar_res">Show Newsletter Subscribe Button?</small>
<div class="form-check">
<input class="form-check-input" type="radio" name="show_subscribe" id="show_subscribe1" onclick="updateSharing('show_subscribe', '1')" <?php if($sh['show_subscribe'] == 1) { echo 'checked="checked"'; } ?> />
<label for="show_subscribe1" class="form-check-label">Show</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="show_subscribe" id="show_subscribe0" onclick="updateSharing('show_subscribe', '0')" <?php if($sh['show_subscribe'] == 0) { echo 'checked="checked"'; } ?> />
<label for="show_subscribe0" class="form-check-label">Hide</label>
</div>

<small class="form-text" id="social_buttons_bar_res">Show LCMS Button?</small>
<div class="form-check">
<input class="form-check-input" type="radio" name="show_lcms" id="show_lcms1" onclick="updateSharing('show_lcms', '1')" <?php if($sh['show_lcms'] == 1) { echo 'checked="checked"'; } ?> />
<label for="show_lcms1" class="form-check-label">Show</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="show_lcms" id="show_lcms0" onclick="updateSharing('show_lcms', '0')" <?php if($sh['show_lcms'] == 0) { echo 'checked="checked"'; } ?> />
<label for="show_lcms0" class="form-check-label">Hide</label>
</div>

</div>
</div>
</div>
</div>
</div>

<script>
function updateSeo(f, v)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/sharing/ajax.php',
          type: 'POST',
          data: {
               'update_seo': 1,
               'field': f,
               'value': v
          },
          success: function(data) {
               $('#'+f+'_res').html(data);
          }
     })
}
function updateTag(tid, v)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/sharing/ajax.php',
          type: 'POST',
          data: {
               'update_tag': 1,
               'm_id': tid,
               'value': v
          },
          success: function(data) {
               $('#'+tid+'_res').html(data);
          }
     })     
}
function updateSharing(f, v)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/sharing/ajax.php',
          type: 'POST',
          data: {
               'update_sharing': 1,
               'field': f,
               'value': v
          },
          success: function(data) {
               switch(f) {
                    case 'subscribe_bar':
                         if(v == 0) {
                              $('#ecta').hide();
                              $('#'+f+'_res').html(data);
                         }
                         if(v == 1) {
                              $('#ecta').show();
                              $('#'+f+'_res').html(data);
                         }
                         break;
                    case 'social_buttons_bar':
                         if(v == 0) {
                              $('#esoc').hide();
                              $('#'+f+'_res').html(data);
                         }
                         if(v == 1) {
                              $('#esoc').show();
                              $('#'+f+'_res').html(data);                              
                         }
                         break;
                    case 'show_subscribe':
                         if(v == 0) {
                              $('#subbtn').hide();
                         }
                         if(v == 1) {
                              $('#subbtn').show();
                         }
                         break;
                    case 'show_lcms':
                         if(v == 0) {
                              $('#lcmsbtn').hide();
                         }
                         if(v == 1) {
                              $('#lcmsbtn').show();
                         }
                         break;                         
                    default:
                         $('#'+f+'_res').html(data);
                         break;                    
               }
          }
     })       
}
</script>