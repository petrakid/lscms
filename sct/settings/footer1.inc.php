<?php
$fts = $db->query("SELECT * FROM $_SESSION[prefix]_footer WHERE f_id = 1");
$ft = $fts->fetch(PDO::FETCH_ASSOC);
?>
<div class="col-xs-3">
<div class="well well-sm">
<h4>Left Footer Type</h4>
<p class="help-block">If you select the "Company Information" option, the left footer will automatically populate and format with your organizations information.  Alternatively, you may select a "custom" footer, where you can add your own text, images, videos, etc.</p>
<input type="radio" name="lfootertype" id="lfootertype" onchange="submitForm('lfootertype', 6, this.value)" value="O" <?php if($ft['left_footer_type'] == 'O') { echo 'checked="checked"';} ?> /> Company Information<br />
<input type="radio" name="lfootertype" id="lfootertype" onchange="submitForm('lfootertype', 6, this.value)" value="C" <?php if($ft['left_footer_type'] == 'C') { echo 'checked="checked"';} ?> /> Custom Left Footer<br />
<input type="radio" name="lfootertype" id="lfootertype" onchange="submitForm('lfootertype', 6, this.value)" value="S" <?php if($ft['left_footer_type'] == 'S') { echo 'checked="checked"';} ?> /> Social Bar
</div>
</div>

<div class="col-xs-9">
<div class="well well-sm">
<h4>Custom Left Footer Content</h4>
<p class="help-block">If you selected Custom Footer for your left footer, you can use this WYSIWYG editer to provide your custom content.  Click the "Save" button when you're done.</p>
<textarea name="lfootercustomcontent" id="lfootercustomcontent"><?php echo $ft['left_footer_content'] ?></textarea>
<script>
var editor = CKEDITOR.replace('lfootercustomcontent');
editor.on('blur', function(evt) {
    var edited = evt.editor.getData();
    submitForm('lfootercontent', 6, edited);
});
</script>
</div>
</div>
