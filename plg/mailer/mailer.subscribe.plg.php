<div class="row">
<div class="col-lg-12">
<div class="panel-body">
<div class="panel-heading" id="hidelast">Subscribe to one or more of our Mailing Lists!</div>

<form id="subscribeform" name="subscribeform" autocomplete="false">
<div class="row" id="hidelast2">
<div class="col-sm-6">
<div class="panel">
<div class="panel-heading"><h3>Available Lists</h3></div>
<div class="panel-body">
<p>Select the List(s) you would like to subscribe to.</p>
<?php
$lsts = $db->query("SELECT l_id, list_name FROM tbl_mailing_lists WHERE list_status = 1 AND list_privacy = 0 ORDER BY l_id ASC");
while($lst = $lsts->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <div class="form-check">
     <input class="form-check-input" type="checkbox" name="mylist[]" value="<?php echo $lst['l_id'] ?>" id="mylist_<?php echo $lst['l_id'] ?>" />
     <label for="mylist_<?php echo $lst['l_id'] ?>" class="form-check-label"><?php echo stripslashes($lst['list_name']) ?></label>
     </div>
     
     <?php
}

$plg = $db->query("SELECT pl_id FROM tbl_plugins WHERE plugin_file = 'calendars' AND plugin_status = 1");
if($plg->rowCount() > 0) {
     ?>
     <hr />
     <div class="panel-heading"><h3>Event Calendar Reminders</h3></div>
     <p>Receive timely reminders in your email of upcoming special events!</p>
     <div class="form-check">
     <input class="form-check-input" type="checkbox" name="mylist[]" value="9999" id="mylist_9999" />
     <label for="mylist_9999">Receive Timely Reminders</label>
     </div>
     
     <?php
}

?>
</div>
</div>
</div>
<div class="col-sm-6">
<div class="card">
<div class="card-body">
<h3 class="card-title">Your Information</h3>
<p>Enter your Name and Email Address.  Before clicking "Subscribe", be sure to solve the simple, anti-spam puzzle.</p>
<input autocomplete="false" placeholder="First and Last Name" type="text" name="myname" id="myname" class="form-control" /><br /><br />

<input autocomplete="false" placeholder="Email Address" type="email" name="myemail" id="myemail" class="form-control" /><br /><br />

<b>What is the answer:</b><br />
<p class="help-block">What is seVEn plus(+) 10?</p>
<input autocomplete="false" type="num" name="myanswer" id="myanswer" min="1" max="99" maxlength="2" class="form-control" style="width: 55px;" /><br /><br />
<input type="hidden" name="subscribeme" id="subscribeme" value="1" />
<input type="button" id="subscribebutton" name="subscribebutton" class="btn btn-success btn-block" value="Subscribe!" />
          
</div>
</div>
</div>
</div>
</form>

<div class="row">
<div class="col-lg-12">
<div class="card" id="subResults" style="display: none;">

</div>
</div>
</div>

</div>
</div>
</div>
<script>
$(function() {
     $('#subscribebutton').on('click', function(e){
          $('#subscribebutton').hide();
          e.preventDefault();
          var form = $('#subscribeform')[0];
          var fData = new FormData(form);
          $.ajax({
               processData: false,
               contentType: false,          
               url: '<?php echo $gbl['site_url'] ?>/plg/mailer/ajax.php',
               type: 'POST',
               data: fData,
               success: function(data) {              
                    document.getElementById('subResults').style.display = "inline";
                    document.getElementById('subResults').innerHTML = data;
               }
          })      
     })
});
</script>