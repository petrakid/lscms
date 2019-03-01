<div class="col-xs-3">
<div class="well well-sm">
<h4>Right Footer Type</h4>
<p class="help-block">If you select the "Company Information" option, the right footer will automatically populate and format with your organizations information.  Alternatively, you may select a "custom" footer, where you can add your own text, images, videos, etc.</p>
<input type="radio" name="rfootertype" id="rfootertype" onchange="submitForm('rfootertype', 8, this.value)" value="O" <?php if($ft['right_footer_type'] == 'O') { echo 'checked="checked"';} ?> /> Company Information<br />
<input type="radio" name="rfootertype" id="rfootertype" onchange="submitForm('rfootertype', 8, this.value)" value="C" <?php if($ft['right_footer_type'] == 'C') { echo 'checked="checked"';} ?> /> Custom Right Footer<br />
<input type="radio" name="rfootertype" id="rfootertype" onchange="submitForm('rfootertype', 8, this.value)" value="S" <?php if($ft['right_footer_type'] == 'S') { echo 'checked="checked"';} ?> /> Social Bar
</div>
</div>

<div class="col-xs-9">
<div class="well well-sm">
<h4>Custom Right Footer Content</h4>
<p class="help-block">If you selected Custom Footer for your right footer, you can use this WYSIWYG editer to provide your custom content.  Data is saved as you type.</p>
<textarea name="rfootercustomcontent" id="rfootercustomcontent"><?php echo $ft['right_footer_content'] ?></textarea>
<script>
var editor = CKEDITOR.replace('rfootercustomcontent');
editor.on('blur', function(evt) {
    var edited = evt.editor.getData();
    submitForm('rfootercontent', 8, edited);
});
</script>
</div>
</div>
