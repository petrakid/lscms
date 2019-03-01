<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

<div class="col-xs-12">
<div class="well well-sm">
<h4>Social Bars</h4>
<p class="help-block">You may enable or add as many social bars as you'd like.  Be mindful, however of WHERE the social bar is placed.  If you place it at the TOP of the site, only two of your enabled social bars will display.  If you place it at the bottom, all will display below the Contact Us section (if enabled).  You can also place in both sections.<br />
Note: If you want to allow users to share page content on social media sites, there is a plugin called "Sharing" that must be enabled.  Settings are located in the administrative page for that plugin.</p>
</div>
</div>

<div class="col-sm-9">
<div class="well well-sm">
<h4>Available Bars</h4>
<table class="table table-responsive table-striped">
<thead>
<tr>
<th>URL</th>
<th>Text</th>
<th>Glyph/Fontawsome Icon (<a href="http://fontawesome.io/cheatsheet/" target="_blank"><i class="fa fa-question-circle"></i></a>)</th>
<th>Status</th>
</tr>
</thead>

<tfoot>
<tr>
<th>URL</th>
<th>Text</th>
<th>Glyph/Fontawsome Icon (<a href="http://fontawesome.io/cheatsheet/" target="_blank"><i class="fa fa-question-circle"></i></a>)</th>
<th>Status</th>
</tr>
</tfoot>

<tbody>
<?php
$socary = array("arrows","bitbucket","digg","dropbox","facebook","flickr","foursquare","github","google","google-plus","instagram","jsfiddle","linkedin","pinterest","reddit","skype","soundcloud","spotify","stack-exchange","stack-overflow","steam","stumbleupon","tumblr","twitter","vimeo-square","vine","windows","wordpress","yahoo","youtube");
$ssql = $db->query("SELECT * FROM $_SESSION[prefix]_social_sites ORDER BY social_order ASC");
while($bar = $ssql->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <tr>
     <td><input type="text" name="barurl<?php echo $bar['s_id'] ?>" id="barurl" onchange="submitForm('barurl', 5, '<?php echo $bar['s_id'] ?>,'+this.value)" value="<?php echo $bar['social_url'] ?>" /></td>
     <td><input type="text" name="bartext<?php echo $bar['s_id'] ?>" id="bartext" onchange="submitForm('bartext', 5, '<?php echo $bar['s_id'] ?>,'+this.value)" value="<?php echo $bar['social_text'] ?>" /></td>
     <td>
     <select name="baricon<?php echo $bar['s_id'] ?>" id="baricon" onchange="submitForm('baricon', 5, this.options[this.selectedIndex].value)">
     <option selected="selected" value="<?php echo $bar['s_id'] ?>,<?php echo $bar['social_icon'] ?>"><?php echo ucfirst($bar['social_icon']) ?></option>
     <?php
     foreach($socary AS $sval) {
          ?>
          <option value="<?php echo $bar['s_id'] ?>,<?php echo $sval ?>"><?php echo ucfirst($sval) ?></option>
          <?php
     }
     ?>
     </select>
     </td>
     <td>
     <input type="radio" name="barstatus<?php echo $bar['s_id'] ?>" id="barstatus" onchange="submitForm('barstatus', 5, this.value)" value="<?php echo $bar['s_id'] ?>,1" <?php if($bar['social_status'] == 1) { echo 'checked="checked"';} ?> /> On<br />
     <input type="radio" name="barstatus<?php echo $bar['s_id'] ?>" id="barstatus" onchange="submitForm('barstatus', 5, this.value)" value="<?php echo $bar['s_id'] ?>,0" <?php if($bar['social_status'] == 0) { echo 'checked="checked"';} ?> /> Off
     </td>
     </tr>
     <?php
}
?>
</tbody>
</table>
<p class="help-block">If you need additional Social Bar rows, ask the Administrator to add additional empty rows to the database.  Otherwise use these and modify as needed.</p>
</div>
</div>

<div class="col-sm-3">
<div class="well well-sm">
<h4>Bars Location</h4>
<input type="radio" name="barsloc" id="barsloc" onchange="submitForm('barloc', 5, this.value)" value="T" <?php if($gbl['social_bar_location'] == 'T') { echo 'checked="checked"'; } ?> /> Top<br />
<input type="radio" name="barsloc" id="barsloc" onchange="submitForm('barloc', 5, this.value)" value="B" <?php if($gbl['social_bar_location'] == 'B') { echo 'checked="checked"'; } ?> /> Bottom<br />
<input type="radio" name="barsloc" id="barsloc" onchange="submitForm('barloc', 5, this.value)" value="O" <?php if($gbl['social_bar_location'] == 'O') { echo 'checked="checked"'; } ?> /> Both<br />
<input type="radio" name="barsloc" id="barsloc" onchange="submitForm('barloc', 5, this.value)" value="D" <?php if($gbl['social_bar_location'] == 'D') { echo 'checked="checked"'; } ?> /> Disabled
</div>

</div>
