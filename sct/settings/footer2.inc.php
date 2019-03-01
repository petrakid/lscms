<div class="col-xs-3">
<div class="well well-sm">
<h4>Center Footer Type</h4>
<p class="help-block">If you select the "Company Information" option, the center footer will automatically populate and format with your organizations information.  Alternatively, you may select a "custom" footer, where you can add your own text, images, videos, etc.</p>
<input type="radio" name="cfootertype" id="cfootertype" onchange="submitForm('cfootertype', 7, this.value)" value="O" <?php if($ft['center_footer_type'] == 'O') { echo 'checked="checked"';} ?> /> Company Information<br />
<input type="radio" name="cfootertype" id="cfootertype" onchange="submitForm('cfootertype', 7, this.value)" value="C" <?php if($ft['center_footer_type'] == 'C') { echo 'checked="checked"';} ?> /> Custom Center Footer<br />
<input type="radio" name="cfootertype" id="cfootertype" onchange="submitForm('cfootertype', 7, this.value)" value="A" <?php if($ft['center_footer_type'] == 'A') { echo 'checked="checked"';} ?> /> Calendar (link or embed)
</div>
</div>

<div class="col-xs-9">
<div class="well well-sm">
<h4>Custom Center Footer Content</h4>
<p class="help-block">If you selected Custom Footer for your center footer, you can use this WYSIWYG editer to provide your custom content.  Data is saved as you type.</p>
<textarea name="cfootercustomcontent" id="cfootercustomcontent"><?php echo $ft['center_footer_content'] ?></textarea>
<script>
var editor = CKEDITOR.replace('cfootercustomcontent');
editor.on('blur', function(evt) {
    var edited = evt.editor.getData();
    submitForm('cfootercontent', 7, edited);
});
</script>
</div>
</div>
