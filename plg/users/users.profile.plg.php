<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
$usr = $db->query("SELECT * FROM tbl_users WHERE username = '". $_SESSION['user']['username'] ."'");
$u = $usr->fetch(PDO::FETCH_ASSOC);
?>

<div class="row">
<div class="col-md-10">
<form>
<div class="card-deck">
<div class="card testimonial-card mb-4">
<div class="card-up teal lighten-2"></div>
<div class="avatar mx-auto white">
<img id="profile_img" class="rounded-circle img-fluid" src="<?php echo $gbl['site_url'] ?>/ast/users/<?php echo $u['profile_image'] ?>" />
</div>
<div class="card-body">
<h4 class="card-title mt-0 mb-1"><?php echo $u['prefix'] .' '. $u['first_name'] .' '. $u['last_name'] .' '. $u['suffix'] ?></h4>
<h5 class="mt-0"><?php echo $u['title'] ?></h5>
<hr />

<div id="usernamec" class="md-form">
<input type="email" id="username" name="username" readonly="readonly" value="<?php echo $u['username'] ?>" class="form-control" />
<label for="username">Username</label>
</div>
<div id="titlec" class="md-form">
<input type="text" name="title" id="title" value="<?php echo $u['title'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="title">Title/Position</label>
</div>
<div id="prefixc" class="md-form">
<input type="text" name="prefix" id="prefix" value="<?php echo $u['prefix'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="prefix">Prefix</label>
</div>
<div id="first_namec" class="md-form">
<input type="text" id="first_name" name="first_name" value="<?php echo $u['first_name'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="first_name">First Name</label>
</div>
<div id="last_namec" class="md-form">
<input type="text" id="last_name" name="last_name" value="<?php echo $u['last_name'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="last_name">Last Name</label>
</div>
<div id="suffixc" class="md-form">
<input type="text" id="suffix" name="suffix" value="<?php echo $u['suffix'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="suffix">Suffix</label>
</div>
<div id="address_1c" class="md-form">
<input type="text" id="address_1" name="address_1" value="<?php echo $u['address_1'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="address_1">Address</label>
</div>
<div id="address_2c" class="md-form">
<input type="text" id="address_2" name="address_2" value="<?php echo $u['address_2'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="address_2">Address (cont.)</label>
</div>
<div id="cityc" class="md-form">
<input type="text" id="city" id="city" value="<?php echo $u['city'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="city">City/Town</label>
</div>
<select name="state" id="state" class="md-form mdb-select" onchange="updateField(this.id, this.value)">
<option value="" selected disabled>State</option>
<?php
echo selectStates($u['state']);
?>
</select>
<div id="zipcodec" class="md-form">
<input type="text" name="zipcode" id="zipcode" value="<?php echo $u['zipcode'] ?>" class="form-control" maxlength="5" onblur="updateField(this.id, this.value)" />
<label for="zipcode">Zip Code</label>
</div>
<div id="phone_1c" class="md-form">
<input type="text" name="phone_1" id="phone_1" value="<?php echo $u['phone_1'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="phone_1">Primary Phone</label>
</div>
<div id="phone_2c" class="md-form">
<input type="text" name="phone_2" id="phone_2" value="<?php echo $u['phone_2'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="phone_2">Altername Phone</label>
</div>
<div id="email_2c" class="md-form">
<input type="email" id="email_2" name="email_2" value="<?php echo $u['email_2'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="email_2">Alternate Email</label>
</div>

</div>
</div>
<div class="card mb-4">
<div class="card-body">
<div id="biographyc" class="md-form">
<textarea class="md-textarea form-control" name="biography" id="biography" rows="4" cols="100%" onblur="updateField(this.id, this.value)"><?php echo $u['biography'] ?></textarea>
<label for="biography">Biography</label>
<small class="form-text text-muted">HTML is acceptable</small>
</div>
<div id="profile_tagsc" class="md-form">
<input type="text" name="profile_tags" id="profile_tags" value="<?php echo $u['profile_tags'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="profile_tags">Profile Tags</label>
<small class="form-text text-muted">Used in the Search feature.</small>
</div>
<div class="form-text">Social Media Profile Links</div>
<div id="facebook_profilec" class="md-form">
<i class="fab fa-facebook-f prefix"></i>
<input type="url" name="facebook_profile" id="facebook_profile" value="<?php echo $u['facebook_profile'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="facebook_profile">Facebook Profile URL</label>
<small class="form-text text-muted">Enter the entire URL (https://www.facebook.com/...etc.)</small>
</div>
<div id="twitter_handlec" class="md-form">
<i class="fab fa-twitter prefix"></i>
<input type="url" name="twitter_handle" id="twitter_handle" value="<?php echo $u['twitter_handle'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="twitter_handle">Facebook Profile URL</label>
<small class="form-text text-muted">Enter the entire URL (https://www.twitter.com/...etc.)</small>
</div>
<div id="instagram_namec" class="md-form">
<i class="fab fa-instagram prefix"></i>
<input type="url" name="instagram_name" id="instagram_name" value="<?php echo $u['instagram_name'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="instagram_name">Instagram Profile URL</label>
<small class="form-text text-muted">Enter the entire URL (https://www.instagram.com/...etc.)</small>
</div>
<div id="tumblr_idc" class="md-form">
<i class="fab fa-tumblr prefix"></i>
<input type="url" name="tumblr_id" id="tumblr_id" value="<?php echo $u['tumblr_id'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="tumblr_id">Tumblr Profile URL</label>
<small class="form-text text-muted">Enter the entire URL (https://www.tumblr.com/...etc.)</small>
</div>
<div id="pinterest_idc" class="md-form">
<i class="fab fa-pinterest prefix"></i>
<input type="url" name="pinterest_id" id="pinterest_id" value="<?php echo $u['pinterest_id'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="pinterest_id">Pinterest Profile URL</label>
<small class="form-text text-muted">Enter the entire URL (https://www.pinterest.com/...etc.)</small>
</div>
<div id="linkedin_idc" class="md-form">
<i class="fab fa-linkedin prefix"></i>
<input type="url" name="linkedin_id" id="linkedin_id" value="<?php echo $u['linkedin_id'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="linkedin_id">Linkedin Profile URL</label>
<small class="form-text text-muted">Enter the entire URL (https://www.linkedin.com/...etc.)</small>
</div>
<div id="lcms_roster_idc" class="md-form">
<i class="fas fa-arrows-alt prefix"></i>
<input type="url" name="lcms_roster_id" id="lcms_roster_id" value="<?php echo $u['lcms_roster_id'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="lcms_roster_id">LCMS Roster Profile URL</label>
<small class="form-text text-muted">Enter the entire URL (https://locator.lcms.org/nworkers_frm/...etc.)</small>
</div>
<div id="favorite_quotec" class="md-form">
<input type="text" name="favorite_quote" id="favorite_quote" value="<?php echo $u['favorite_quote'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="favorite_quote">Favorite Quote</label>
</div>
<div id="favorite_versec" class="md-form">
<input type="text" name="favorite_verse" id="favorite_verse" value="<?php echo $u['favorite_verse'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="favorite_verse">Favorite Scripture Passage</label>
<small class="form-text text-muted">Enter the entire passage, not just the reference</small>
</div>

</div>
</div>
<div class="card mb-4">
<div class="card-body">
<div id="security_question_1c" class="md-form">
<input type="text" name="security_question_1" id="security_question_1" value="<?php echo $u['security_question_1'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="security_question_1">First Security Question</label>
</div>
<div id="security_answer_1c" class="md-form">
<input type="text" name="security_answer_1" id="security_answer_1" value="<?php echo $u['security_answer_1'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="security_answer_1">Answer to First Security Question</label>
</div>
<div id="security_question_2c" class="md-form">
<input type="text" name="security_question_2" id="security_question_2" value="<?php echo $u['security_question_2'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="security_question_2">Second Security Question</label>
</div>
<div id="security_answer_2c" class="md-form">
<input type="text" name="security_answer_2" id="security_answer_2" value="<?php echo $u['security_answer_2'] ?>" class="form-control" onblur="updateField(this.id, this.value)" />
<label for="security_answer_2">Answer to Second Security Question</label>
</div>
<small class="form-text">Biography Position (for Biography page)</small>
<select name="bio_position" id="bio_position" class="md-form mdb-select" onchange="updateField('bio_position', this.value)">
<option value="" disabled selected>Select a Positon</option>
<option value="pastor">Pastor</option>
<option value="elders">Elder</option>
<option value="council">Council</option>
<option value="musicians">Musician</option>
<option value="staff">Staff</option>
</select>

<div class="form-check" id="show_bio_res">
<input class="form-check-input" type="checkbox" name="show_bio" id="show_bio" onclick="updateField('show_bio', this.checked)" value="1" <?php if($u['show_bio'] == 1) { echo 'checked="checked"'; } ?> />
<label class="form-check-label" for="show_bio">Show Biography Publically</label>
<small class="form-text text-muted">If enabled, your biographical information will appear on whatever page has the [bio ...] short tag.</small>
</div>
<hr />

<small class="form-text">Cookie Security Hash: <?php echo $u['cookie_hash'] ?></small>
<small class="form-text">Last Login: <?php echo date('m j Y h:i a', strtotime($u['last_login'])) ?>, IP: <?php echo $u['last_login_ip'] ?></small>

</div>
</div>

</div>
</form>
</div>

<div class="col-md-2">
<button class="btn btn-block btn-unique" data-toggle="modal" data-target="#changePasswordModal"><i class="fa fa-lock"></i> Change Password</button><br />
<button class="btn btn-block btn-mdb-color" data-toggle="modal" data-target="#profileImageModal"><i class="fa fa-image"></i> Change Profile Image</button><br />

</div>
</div>
<div class="modal fade right" id="profileImageModal" tabindex="-1" role="dialog" aria-labelledby="profileImageModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="profileImageModalLabel">Change Profile Image</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<form class="md-form">
<div class="file-field">
<div class="btn btn-unique btn-sm float-left">
<span>Choose new image</span>
<input type="file" name="profile_image" id="profile_image" accept="image/*" />
</div>
<div class="file-path-wrapper">
<input class="file-path validate" type="text" placeholder="Upload new profile image" readonly="readonly" />
</div>
</div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal" id="prof_cancel_btn">Cancel</button>
<button type="button" class="btn btn-primary" onclick="changeImage()" id="prof_save_btn">Save</button>
</div>
</div>
</div>
</div>

<div class="modal fade right" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<form autocomplete="off">
<div class="md-form" id="old_res">
<input type="password" name="old_pws" id="old_pws" class="form-control" autocomplete="off" />
<label for="old_password">Enter your CURRENT Password</label>
<small class="form-text white-text" id="old_resp"></small>
</div>
<div class="md-form" id="new_res1">
<input type="password" name="new_pws1" id="new_pws1" class="form-control" autocomplete="off" disabled="disabled" />
<label for="new_pws1">Enter a NEW Password</label>
</div>
<div class="md-form" id="new_res2">
<input type="password" name="new_pws2" id="new_pws2" class="form-control" autocomplete="off" disabled="disabled" />
<label for="new_pws2">Enter NEW Password again</label>
<small class="form-text text-muted">Password strength rules enforced.</small>
</div>
</form>
<div id="resetResp"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal" id="pass_cancel_btn">Cancel</button>
<button type="button" class="btn btn-primary" onclick="updatePassword()" id="pass_save_btn">Save</button>
</div>
</div>
</div>
</div>
<script>
$(function(){
     $("#zipcode").mask("99999");
     $("#zipcode").on("blur", function() {
          var last = $(this).val().substr($(this).val().indexOf("-") + 1);
          if(last.length == 3) {
               var move = $(this).val().substr( $(this).val().indexOf("-") - 1, 1);
               var lastfour = move + last;
               var first = $(this).val().substr(0, 9);
               $(this).val(first + '-' + lastfour);
          }
     });
     $("#phone_1").mask("(999)999-9999");
     $("#phone_1").on("blur", function() {
          var last = $(this).val().substr($(this).val().indexOf("-") + 1);
          if(last.length == 3) {
               var move = $(this).val().substr( $(this).val().indexOf("-") - 1, 1);
               var lastfour = move + last;
               var first = $(this).val().substr(0, 9);
               $(this).val(first + '-' + lastfour);
          }
     });
     $("#phone_2").mask("(999)999-9999");
     $("#phone_2").on("blur", function() {
          var last = $(this).val().substr($(this).val().indexOf("-") + 1);
          if(last.length == 3) {
               var move = $(this).val().substr( $(this).val().indexOf("-") - 1, 1);
               var lastfour = move + last;
               var first = $(this).val().substr(0, 9);
               $(this).val(first + '-' + lastfour);
          }
     });
     $('#old_pws').on('click', function() {
          $('#old_pws').val('');
     })
     $('#old_pws').on('blur', function() {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/users/ajax.php',
               type: 'POST',
               data: {
                    'check_password': 1,
                    'old_pass': $('#old_pws').val()
               },
               success: function(data) {
                    if(data == 'wrong') {
                         $('#old_res').animate({backgroundColor: '#ff4444'}, 'slow');
                         $('#old_resp').html('Your current password is incorrect.  Please try again.');
                         $('#new_pws1').prop('disabled', 'disabled');
                         $('#new_pws2').prop('disabled', 'disabled');
                    } else {
                         $('#old_res').animate({backgroundColor: '#2BBBAD'}, 'slow');
                         $('#old_resp').removeClass('red-text');
                         $('#old_resp').addClass('green-text');
                         $('#old_resp').html('Confirmed');
                         $('#new_pws1').prop('disabled', '');
                         $('#new_pws2').prop('disabled', '');
                         $('#old_pws').prop('disabled', 'disabled');                         
                    }
               }
          })
     })
})
function updatePassword()
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/users/ajax.php',
          type: 'POST',
          data: {
               'try_reset': 1,
               'new_pass1': $('#new_pws1').val(),
               'new_pass2': $('#new_pws2').val()
          },
          success: function(data) {
               if(data == 'wrong1') {
                    $('#resetResp').removeClass('alert alert-danger');                    
                    $('#resetResp').addClass('alert alert-danger');
                    $('#resetResp').html('Your new passwords do not match!');
               }
               else if(data == 'wrong2') {
                    $('#resetResp').removeClass('alert alert-danger');                    
                    $('#resetResp').addClass('alert alert-danger');
                    $('#resetResp').html('Your new password is too short! 8 characters minimum!');                    
               }
               else if(data == 'wrong3') {
                    $('#resetResp').removeClass('alert alert-danger');                    
                    $('#resetResp').addClass('alert alert-danger');
                    $('#resetResp').html('Your new password is not strong enough.  It MUST include both a capital and lowercase letter, a number, and a symbol.');                    
               }
               else if(data == 'right') {
                    $('#resetResp').removeClass('alert alert-danger');
                    $('#resetResp').addClass('alert alert-success');
                    $('#resetResp').html('Your password has been changed successfully.  You will now be logged off.');                    
                    setTimeout(function() {
                         window.location.href = '<?php echo $gbl['site_url'] ?>/Admin/log-out';
                    }, 2000);
               }
          }
     })
}
function updateField(f, v)
{
     if(f == 'show_bio') {
          if(v == false) {
               v = 0;
          }
          if(v == true) {
               v = 1;
          }
     }
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/users/ajax.php',
          type: 'POST',
          data: {
               'update_user': 1,
               'field': f,
               'value': v
          },
          success: function(data) {
               if(data == 'error_2') {
                    $('#'+f+'c').animate({backgroundColor: ''}, 'slow');
                    $('#'+f).val('This is NOT a valid Email Address! Update failed.');
                    setTimeout(function(){
                         $('#'+f+'c').animate({backgroundColor: 'inherit'}, 'slow');
                         $('#'+f).val(v);
                    }, 2000);                    
               } else {
                    $('#'+f+'c').animate({backgroundColor: '#2BBBAD'}, 'slow');
                    setTimeout(function(){
                         $('#'+f+'c').animate({backgroundColor: 'inherit'}, 'slow');
                    }, 2000);
               }
          }
     })
}
function changeImage()
{
     $('#prof_save_btn').hide();
     $('#prof_cancel_btn').hide();
     var formdata = new FormData();
     formdata.append('profile_image', $('#profile_image')[0].files[0]);
     formdata.append('update_image', '1');
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/users/ajax.php',
          type: 'POST',
          processData: false,
          contentType: false,
          data: formdata,
          success: function(data) {
               $('#profileImageModal').modal('hide');
               $('#profile_img').prop('src', '<?php echo $gbl['site_url'] ?>/ast/users/'+ data);
               $('#prof_save_btn').show();
               $('#prof_cancel_btn').show();               
          }          
     })
}
</script>