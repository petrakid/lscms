
<div class="row">
<div class="col-lg-12">
<div class="card-body">

<div class="jumbotron" id="hidelast">You have opted to UNsubscribe from a mailing list.  Enter your Email Address and select the list or lists you wish to unsubscribe from.</div>
<div class="row" id="hidelast2">
<div class="col-sm-6">
<div class="card">
<div class="card-header"><h4 class="card-title">Unsubscribe</h4></div>
<div class="card-body">
<form>
<input type="hidden" name="unsubscribeselect" value="1" />
<small class="form-text">I wish to UNSUBSCRIBE from the following list(s) so that I no longer receive related emails.</small>
<?php
$lsts = $db->query("SELECT l_id, list_name FROM tbl_mailing_lists WHERE list_status = 1 ORDER BY l_id ASC");
while($lst = $lsts->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <div class="form-check">
     <input class="form-check-input" type="checkbox" name="mylist[]" id="mylist_<?php echo $lst['l_id'] ?>" value="<?php echo $lst['l_id'] ?>" />
     <label class="form-check-label" for="mylist_<?php echo $lst['l_id'] ?>"><?php echo stripslashes($lst['list_name']) ?></label>
     </div>
     
     <?php
}
$plg = $db->query("SELECT pl_id FROM tbl_plugins WHERE plugin_file = 'calendars' and plugin_status = 1");
if($plg->rowCount() == 1) {
     ?>
     <div class="form-check">
     <input class="form-check-input" type="checkbox" name="mylist[]" id="mylist_9999" value="9999" />
     <label class="form-check-label" for="mylist_9999">Event Reminders</label>
     </div>
     
     <?php
}
?>
<div class="md-form">
<input type="email" name="emailaddress" id="emailaddress" class="form-control" placeholder="some@email.com" /><br />     
<label for="emailaddress" class="active">My Email Address</label>
</div>

<button type="button" onclick="unSubscribeS()" class="btn btn-warning btn-block">Unsubscribe</button>
</form>
</div>
</div>
</div>

<div class="col-sm-6">
<div class="card">
<div class="card-header"><h4 class="card-title">Unsubscribe from ALL LISTS</h4></div>
<div class="card-body">
<small class="form-text">I wish to UNSUBSCRIBE from ALL lists on this website.</small>
<div class="md-form">
<input type="email" name="emailaddress2" id="emailaddress2" class="form-control" placeholder="some@email.com" />
<label for="emailaddress2" class="active">My Email Address</label>
</div>

<button type="button" onclick="unSubscribeE()" class="btn btn-danger btn-block">Unsubscribe From All</button>          
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12">
<div class="card" id="unsResults" style="display: none;">

</div>
</div>
</div>     

</div>
</div>
</div>

<script>
function unSubscribeE()
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          data: {
               'unsubscribeeverything':true,
               'email': document.getElementById('emailaddress2').value
          },
          success: function(data) {
               document.getElementById('hidelast').style.display = "none";
               document.getElementById('hidelast2').style.display = "none";               
               document.getElementById('unsResults').style.display = "inline";
               document.getElementById('unsResults').innerHTML = data;               
          }
     });      
}
function unSubscribeS()
{
     var data = $("form").serialize();
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
          type: 'POST',
          async: true,
          cache: false,
          data: data,
          success: function(data) {
               document.getElementById('hidelast').style.display = "none";
               document.getElementById('hidelast2').style.display = "none";               
               document.getElementById('unsResults').style.display = "inline";
               document.getElementById('unsResults').innerHTML = data;               
          }
     });      
}
</script>