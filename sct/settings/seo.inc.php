<?php
$sqla = $db->query("SELECT * FROM $_SESSION[prefix]_seo WHERE s_id = 1");
$anlt = $sqla->fetch(PDO::FETCH_ASSOC);
?>

<div class="col-xs-3">
<div class="well well-sm">
<h4>Google Analytics Site Code</h4>
<input type="text" name="ganalytics" onchange="submitForm('ganal', 2, this.value)" id="ganalytics" value="<?php echo $anlt['google_analytics'] ?>" class="form-control" />
<h4>Google API Key (for integrated analytics)</h4>
<input type="text" name="ganalyticsapi" onchange="submitForm('ganalapi', 2, this.value)" id="ganalyticsapi" value="<?php echo $anlt['google_id'] ?>" class="form-control" />
<input type="radio" name="apiselected" onchange="submitForm('apisel', 2, this.value)" id="apiselected" <?php if($anlt['api_selected'] == 'G') { echo 'checked="checked"';} ?> value="G" /> Use this API
<p class="help-block">The API is the on-site analytics data displayed when you select the Dashboard on the main menu.</p>
</div>
</div>

<div class="col-xs-3">
<div class="well well-sm">
<h4>Bing Analytics Site Code</h4>
<input type="text" name="banalytics" onchange="submitForm('banal', 2, this.value)" id="banalytics" value="<?php echo $anlt['bing_analytics'] ?>" class="form-control" />
<h4>Bing API Key (for integrated analytics)</h4>
<input type="text" name="banalyticsapi" onchange="submitForm('banalapi', 2, this.value)" id="banalyticsapi" value="<?php echo $anlt['bing_id'] ?>" class="form-control" />
<input type="radio" name="apiselected" onchange="submitForm('apisel', 2, this.value)" id="apiselected" <?php if($anlt['api_selected'] == 'B') { echo 'checked="checked"';} ?> value="B" /> Use this API
<p class="help-block">The API is the on-site analytics data displayed when you select the Dashboard on the main menu.</p>
</div>
</div>

<div class="col-xs-3">
<div class="well well-sm">
<h4>Yahoo Analytics Site Code</h4>
<input type="text" name="yanalytics" onchange="submitForm('yanal', 2, this.value)" id="yanalytics" value="<?php echo $anlt['yahoo_analytics'] ?>" class="form-control" />
<h4>Yahoo API Key (for integrated analytics)</h4>
<input type="text" name="yanalyticsapi" onchange="submitForm('yanalapi', 2, this.value)" id="yanalyticsapi" value="<?php echo $anlt['yahoo_id'] ?>" class="form-control" />
<input type="radio" name="apiselected" onchange="submitForm('apisel', 2, this.value)" id="apiselected" <?php if($anlt['api_selected'] == 'Y') { echo 'checked="checked"';} ?> value="Y" /> Use this API
<p class="help-block">The API is the on-site analytics data displayed when you select the Dashboard on the main menu.</p>
</div>
</div>

<div class="col-xs-3">
<div class="well well-sm">
<h4>Piwik (in house) Analytics ID</h4>
<input type="text" name="panalytics" onchange="submitForm('panal', 2, this.value)" id="panalytics" value="<?php echo $anlt['piwik_id'] ?>" class="form-control" />
<input type="radio" name="apiselected" onchange="submitForm('apisel', 2, this.value)" id="apiselected" <?php if($anlt['api_selected'] == 'P') { echo 'checked="checked"';} ?> value="P" /> Use this API
<p class="help-block">The API is the on-site analytics data displayed when you select "Analytics" from the admin menu.</p>
</div>
</div>

<div class="col-xs-12">
<div class="well well-sm">
<h4>Meta Keywords</h4>
<p class="help-block">Meta Keywords help search engines find and index your site.  Enter each keyword followed by a comma.  About 10 to 12 keywords is recommended.</p>
<input type="text" name="keywords" id="keywords" onchange="submitForm('keywords', 2, this.value)" value="<?php echo $gbl['keywords'] ?>" class="form-control" />
</div>
</div>

<div class="col-xs-12">
<div class="well well-sm">
<h4>Meta Description</h4>
<p class="help-block">The Meta Description is essential for search engines to find, crawl, and index your site.  Keep the description at 150 characters or less.</p>
<textarea name="description" id="description" onchange="submitForm('description', 2, this.value)" class="form-control" maxlength="150" rows="5"><?php echo $gbl['meta_description'] ?></textarea>
</div>
</div>