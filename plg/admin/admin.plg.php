<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
?>

<ul class="nav nav-tabs nav-justified md-tabs indigo" id="adminTabs" role="tablist">
<li class="nav-item">
<a class="nav-link active" id="main" data-toggle="tab" href="#main-1" role="tab" aria-controls="main-1" aria-selected="true">Main Settings</a>
</li>
<li class="nav-item">
<a class="nav-link" id="org" data-toggle="tab" href="#org-2" role="tab" aria-controls="org-2" aria-selected="false">Organization</a>
</li>
<li class="nav-item">
<a class="nav-link" id="features" data-toggle="tab" href="#features-3" role="tab" aria-controls="features-3" aria-selected="false">Features</a>
</li>
<li class="nav-item">
<a class="nav-link" id="misc" data-toggle="tab" href="#misc-4" role="tab" aria-controls="misc-4" aria-selected="false">Misc</a>
</li>
</ul>

<div class="tab-content card pt-5" id="adminTabs">
<div class="tab-pane fade show active" id="main-1" role="tabpanel" aria-labelledby="main-1-tab">

<div class="card-deck">
<div class="card">
<div class="card-body">
<h4 class="card-title">Site</h4>
<div class="md-form">
<input onblur="changeVal('site_name', this.value)" class="form-control" type="text" name="site_name" id="site_name" value="<?php echo $gbl['site_name'] ?>" />
<label for="site_name">Site/Organization Name</label>
</div>
<div class="md-form">
<input onblur="changeVal('site_url', this.value)" class="form-control" type="text" name="site_url" id="site_url" <?php if($_SESSION['user']['security'] < 5) { echo 'readonly="readonly"'; } ?> value="<?php echo $gbl['site_url'] ?>" />
<label for="site_url">Site URL</label>
<small class="form-text text-muted">Best not to change this unless you know what you are doing.</small>
</div>
<div class="md-form">
<input class="form-control text-red" type="text" name="doc_root" id="doc_root" value="<?php echo $gbl['doc_root'] ?>" readonly="readonly" />
<label for="doc_root">Site Install Path</label>
<small class="form-text text-muted">This cannot be changed.</small>
</div>
</div>
</div>

<div class="card">
<div class="card-body">
<h4 class="card-title">Configuration Information</h4>
<div class="md-form">
<input class="form-control" type="text" id="server_os" readonly="readonly" value="<?php echo $_SERVER['SERVER_SOFTWARE'] ?>" />
<label for="server_os">Server</label>
</div>
<div class="md-form">
<input class="form-control" type="text" id="php_version" readonly="readonly" value="<?php echo phpversion() ?>" />
<label for="php_version">Php Version</label>
</div>
<div class="md-form">
<input class="form-control" type="text" id="mysql_version" readonly="readonly" value="<?php echo $db->getAttribute(constant("PDO::ATTR_SERVER_VERSION")) ?>" />
<label for="mysql_version">Mysql Version</label>
</div>
<div class="md-form">
<input class="form-control" type="text" id="server_ip" readonly="readonly" value="<?php echo $_SERVER['SERVER_ADDR'] ?>" />
<label for="server_ip">Shared IP Address</label>
</div>
<div class="md-form">
<input class="form-control" type="text" id="home_dir" readonly="readonly" value="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>" />
<label for="home_dir">Account Home Directory</label>
</div>
<?php
$dnshost = $_SERVER['SERVER_NAME'];
$dns = dns_get_record("$dnshost", DNS_ALL);
?>
<div class="md-form">
<input class="form-control" type="text" id="dns_servers" readonly="readonly" value="<?php echo $dns[1]['target'] .', '. $dns[2]['target'] ?>" />
<label for="dns_servers">Host DNS Servers</label>
</div>
<div class="md-form">
<input class="form-control" type="text" id="mx_records" readonly="readonly" value="<?php echo $dns[5]['target'] ?>" />
<label for="mx_records">Current MX (email) Setting(s)</label>
</div>
<?php
$ver = $db->query("SELECT * FROM tbl_version_info ORDER BY v_id DESC LIMIT 1");
$v = $ver->fetch(PDO::FETCH_ASSOC);
?>
<div class="md-form">
<input class="form-control" type="text" id="site_version" readonly="readonly" value="<?php echo 'Version '. $v['version'] .' rev. '. $v['revision'] ?>" />
<label for="site_version">CMS/Site Version</label>
<small class="form-text text-muted"><a href="javascript:void()" data-target="#versiondetails" data-toggle="modal">Read Version Details</a></small>
</div>
<div class="modal fade" id="versiondetails" tabindex="-1" role="dialog" aria-labelledby="versiondetails" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title w-100" id="versiondetails">CMS Version Details</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<?php echo stripslashes($v['version_text']) ?>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

</div>
</div>  

<div class="card">
<div class="card-body">
<h4 class="card-title">Maintenance Mode Config</h4>
<p class="card-body">With Maintenace Mode, you can enable a nice looking "Down for Maintenance" page should you be doing major updates to the site or if you don't
want visitors on your site.  This will also stop all web crawlers from visiting your site.  Authenticated users who are a security level of Editor or above will still
have access to the site using the login form on the maintenance screen.</p>
<div class="form-check">
<input onclick="changeVal('maintenance_mode', 0)" class="form-check-input" type="radio" name="maintenance_mode" id="maintenance0" value="0" <?php if($gbl['maintenance_mode'] == 0) { echo 'checked="checked"'; } ?> />
<label for="maintenance0" class="form-check-label">Disabled (Site is Active)</label> 
</div>
<div class="form-check">
<input onclick="changeVal('maintenance_mode', 1)" class="form-check-input" type="radio" name="maintenance_mode" id="maintenance1" value="1" <?php if($gbl['maintenance_mode'] == 1) { echo 'checked="checked"'; } ?> />
<label for="maintenance1">Enabled (Site is offline)</label>
</div>
<?php
if($gbl['maintenance_mode'] == 0) {
     echo '<div class="alert alert-success" id="maintenance_alert">Site is ACTIVE!</div>';
}
if($gbl['maintenance_mode'] == 1) {
     echo '<div class="alert alert-danger" id="maintenance_alert">Site is in MAINTENANCE MODE</div>';
}
?>
</div>
</div>
</div>

</div>
<div class="tab-pane fade" id="org-2" role="tabpanel" aria-labelledby="org-2-tab">
<div class="card-deck">
<div class="card">
<div class="card-body">
<h4 class="card-title">Location</h4>

</div>
</div>
<div class="card">
<div class="card-body">
<h4 class="card-title">Phone</h4>
</div>
</div>
<div class="card">
<div class="card-body">
<h4 class="card-title">Email</h4>

</div>
</div>
</div>
</div>
<div class="tab-pane fade" id="features-3" role="tabpanel" aria-labelledby="features-3-tab">
<div class="card-deck">
<div class="card">
<div class="card-body">
<h4 class="card-title">Homepage</h4>

</div>
</div>
<div class="card">
<div class="card-body">
<h4 class="card-title">Privacy Policy</h4>

</div>
</div>
<div class="card">
<div class="card-body">
<h4 class="card-title">Terms of Service</h4>

</div>
</div>
</div>
</div>
<div class="tab-pane fade" id="misc-4" role="tabpanel" aria-labelledby="misc-4-tab">
<div class="card-deck">
<div class="card">
<div class="card-body">
<h4 class="card-title">Scripts</h4>

</div>
</div>
<div class="card">
<div class="card-body">
<h4 class="card-title">Stylesheets</h4>

</div>
</div>
<div class="card">
<div class="card-body">
<h4 class="card-title">Analytics</h4>

</div>
</div>
</div>

</div>  
</div>

<script>
function changeVal(field, value)
{
     if(field == 'maintenance_mode') {
          if(value == 1) {
               $('#maintenance_alert').removeClass('alert-success');
               $('#maintenance_alert').html('Site is in MAINTENANCE MODE');
               $('#maintenance_alert').addClass('alert-danger');
          }
          if(value == 0){
               $('#maintenance_alert').removeClass('alert-danger');
               $('#maintenance_alert').html('Site is ACTIVE!');
               $('#maintenance_alert').addClass('alert-success');               
          }
     }
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/admin/ajax.php',
          type: 'POST',
          data: {
               'change_settings': 1,
               'f': field,
               'v': value
          },
          success: function(data) {
               toastr.success("Item updated successfully!", "Success")
          }
     })
}
</script>