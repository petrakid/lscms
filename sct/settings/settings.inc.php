<div class="row">
<div class="col-12">
<div class="card-deck">


<div class="card mb-4">
<div class="card-body">
<small class="form-text">Maintenance Mode</small>
<div class="form-check">
<input class="form-check-input" type="radio" onchange="submitForm('mmode', 1, this.value)" name="mmode" id="mmode0" <?php if($gbl['maintenance_mode'] == 0) { echo 'checked="checked"';} ?> value="0" />
<label class="form-check-label" for="mmode0">Off</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" onchange="submitForm('mmode', 1, this.value)" name="mmode" id="mmode1" <?php if($gbl['maintenance_mode'] == 1) { echo 'checked="checked"';} ?> value="1" />
<label class="form-check-label" for="mmode1">On</label>
</div>
</div>
</div>

<div class="card mb-4">
<div class="card-body">
<small class="form-text">Secure Site</small>
<div class="form-check">
<input class="form-check-input" type="radio" onchange="submitForm('ssl', 1, this.value)" name="ssl" id="ssl0" <?php if($gbl['ssl'] == 0) { echo 'checked="checked"';} ?> value="0" />
<label class="form-check-label" for="ssl0">Non-Secure (http:// only)</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" onchange="submitForm('ssl', 1, this.value)" name="ssl" id="ssl1" <?php if($gbl['ssl'] == 1) { echo 'checked="checked"';} ?> value="1" />
<label class="form-check-label" for="ssl1">Secure (https://)</label>
</div>
<small class="form-text text-muted">This option must be enabled by your web hosting company.  Leave Insecure if you are unsure.</small>
</div>
</div>

<div class="card mb-4">
<div class="card-body">
<small class="form-text">Document Root (CHANGE AT YOUR OWN RISK!!</small>
<div class="md-form">
<input type="text" onchange="submitForm('docroot', 1, this.value)" name="docroot" id="docroot" value="<?php echo $gbl['doc_root'] ?>" class="form-control" />
<label for="docroot">DocRoot</label>
</div>
</div>
</div>

<div class="card mb-4">
<div class="card-body">
<small class="form-text">Site Plugins</small>
<table class="table table-striped table-sm">
<thead>
<tr>
<th colspan="3">Enabled?</th>
<th>Yes</th>
<th>No</th>
<td></td>
</tr>
</thead>
<tbody>
<?php
$pg = $db->query("SELECT * FROM $_SESSION[prefix]_plugins ORDER BY pl_id ASC");
while($plg = $pg->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <tr>
     <td><input class="form-check-input" type="radio" onchange="submitForm('plugin', 1, this.value)" name="plugin|<?php echo $plg['pl_id'] ?>" id="<?php echo $plg['pl_id'] ?>" value="<?php echo $plg['pl_id'] ?>,1" <?php if($plg['plugin_status'] == 1) { echo 'checked="checked"';} ?> /></td>
     <td><input class="form-check-input" type="radio" onchange="submitForm('plugin', 1, this.value)" name="plugin|<?php echo $plg['pl_id'] ?>" id="<?php echo $plg['pl_id'] ?>" value="<?php echo $plg['pl_id'] ?>,0" <?php if($plg['plugin_status'] == 0) { echo 'checked="checked"';} ?> /></td>
     <td><?php echo $plg['plugin_name'] ?></td>
     </tr>
     <?php
}
?>
</tbody>
</table>
</div>
</div>