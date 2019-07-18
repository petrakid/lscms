<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
?>

<div class="modal fade" id="edit_account_modal" tabindex="-1" role="dialog" aria-labelledby="accountModal" aria-hidden="true">
<div class="modal-dialog modal-sm" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="accountModal">Edit Account</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body" id="account_data_body">
Please wait...<i class="fa fa-spinner fa-spin"></i>
</div>
<div class="modal-footer">
<button type="button" id="asavebutton" class="btn btn-success" onclick="saveAccount()">Save</button>
<button type="button" id="aclosebutton" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>  

<div class="row">
<div class="col-3">
<div class="card">
<div class="card-body">
<h5 class="card-title">Add New User</h5>
<form id="add_user" name="add_user">
<input type="hidden" name="account_status" id="account_status" value="0" />
<input type="hidden" name="security" id="security" value="0" />
<input type="hidden" name="adduser" id="adduser" value="1" /> 
<small class="form-text text-muted">The new user will be emailed with the login information.</small>
<div class="md-form">
<input type="email" name="username" id="username" required="required" class="form-control" />
<label for="username">Email Address</label>
</div>
<div class="md-form">
<input type="text" name="first_name" id="first_name" required="required" class="form-control" />
<label for="first_name">First Name</label>
</div>
<div class="md-form">
<input type="text" name="last_name" id="last_name" required="required" class="form-control" />
<label for="last_name">Last Name</label>
</div>
<div class="md-form">
<input type="text" name="title" id="title" required="required" class="form-control" />
<label for="title">Title</label>
</div>

<button type="button" class="btn btn-success" onclick="addUser()">Add User</button>
</form>
<div id="usrRes"></div>
</div>
</div>
</div>

<div class="col-6">
<div class="card">
<div class="card-body">
<h5 class="card-title">Manage Current Users</h5>
<table class="table table-hover table-striped table-sm">
<thead>
<tr>
<th>Name</th>
<th>Username</th>
<th>Status</th>
<th></th>
</tr>
</thead>
<tbody>
<?php
$usr = $db->query("SELECT * FROM tbl_users WHERE account_status != 9 ORDER BY last_name ASC");
while($us = $usr->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <tr id="userRow<?php echo $us['username'] ?>">
     <td><?php echo $us['first_name'] .' '. $us['last_name'] ?></td>
     <td><?php echo $us['username'] ?><br />
     <div id="updateRes_<?php echo $us['username'] ?>"></div>
     </td>
     <td id="statusRow<?php echo $us['username'] ?>">
     <?php
     if($us['account_status'] == 0) {
          echo 'Inactive/Pending';
     }
     if($us['account_status'] == 1) {
          echo 'Active';
     }
     if($us['account_status'] == 9) {
          echo 'Removed/Banned';
     }
     ?>
     </td>
     <td>
     <button data-toggle="modal" data-target="#edit_account_modal" class="btn btn-sm btn-unique" title="Edit Account" onclick="editAccount('<?php echo $us['username'] ?>')"><i class="fas fa-pencil-alt"></i></button>
     <button href="#" title="Reset Password" id="reset_button<?php echo $us['username'] ?>" class="btn btn-sm btn-warning" onclick="resetPass('<?php echo $us['username'] ?>')"><i class="fas fa-key"></i></button>
     <button title="Remove Account" class="btn btn-sm btn-danger" onclick="deleteAccount('<?php echo $us['username'] ?>')"><i class="fas fa-trash"></i></button>
     </td>
     </tr>
     <?php
}
?>
</tbody>
</table>
<small class="form-text text-muted">The user will receive an email with the new account password should you reset their password.</small>
</div>
</div>
</div>

<div class="col-3">
<div class="card">
<div class="card-body">
<h5 class="card-title">Manage Security Roles</h5>
<form name="secroles" id="secroles">
<input type="hidden" name="update_security" id="update_security" />
<?php
$sec = $db->query("SELECT * FROM tbl_security_roles ORDER BY s_id ASC");
while($sc = $sec->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <div class="md-form">
     <input type="text" name="role[<?php echo $sc['s_id'] ?>]" id="role_<?php echo $sc['s_id'] ?>" value="<?php echo $sc['role_name'] ?>" class="form-control" />
     </div>
     <?php
}
?>
<div class="md-form">
<input type="text" name="newrole" id="newrole" class="form-control" />
<label for="newrole">+ New Role</label>
</div>
<button type="button" class="btn btn-unique" onclick="updateSecurity()">Update Security Roles</button>
<div id="secRes"></div>
</form>
</div>
</div>
</div>
</div>

<script>
function addUser()
{
     var data = $("#add_user").serialize();
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/users/ajax.php',
          type: 'POST',
          async: true,
          cache: false,
          data: data,
          success: function(data) {
               $('#add_user').trigger("reset");
               document.getElementById('usrRes').innerHTML = data;
          }
     });      
}
function editAccount(user)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/users/ajax.php',
          type: 'POST',
          data: {
               'edit_account':true,
               'username': user
          },
          success: function(data) {
               document.getElementById("account_data_body").innerHTML = data;
               document.getElementById('asavebutton').style.display = "inline";
               document.getElementById('aclosebutton').innerHTML = "Cancel";
               $(document).ready(function() {
                    $('.mdb-select').materialSelect();
               });               
          }
     });   
}
function saveAccount()
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/users/ajax.php',
          type: 'POST',
          data: {
               'save_account':true,
               'username': document.getElementById('edituser').value,
               'emailaddress': document.getElementById('username').value,
               'firstname': document.getElementById('first_name').value,
               'lastname': document.getElementById('last_name').value,
               'title': document.getElementById('title').value,
               'status': document.getElementById('account_status').value,
               'security': document.getElementById('security').value

          },
          success: function(data) {
               document.getElementById('account_data_body').innerHTML = data;
               document.getElementById('asavebutton').style.display = "none";
               document.getElementById('aclosebutton').innerHTML = "Close";
               document.getElementById('aclosebutton').addEventListener("click", reloadscreen());
          }
     });
}
function reloadscreen()
{
     window.location.reload();
}
function resetPass(user)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/users/ajax.php',
          type: 'POST',
          data: {
               'reset_pass':true,
               'username': user

          },
          success: function(data) {
               document.getElementById('reset_button'+user).style.display = "none";
               document.getElementById('updateRes_'+user).innerHTML = data;
          }
     });   
}
function deleteAccount(user)
{
     if(confirm("Are you SURE you want to remove this account?")) {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/users/ajax.php',
               type: 'POST',
               data: {
                    'delete_account':true,
                    'username': user
     
               },
               success: function(data) {
                    document.getElementById('statusRow'+user).innerHTML = "Removed/Banned";
                    document.getElementById('updateRes_'+user).innerHTML = data;
               }
          });           
     }
}
function updateSecurity()
{
     var data = $("#secroles").serialize();
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/users/ajax.php',
          type: 'POST',
          async: true,
          cache: false,
          data: data,
          success: function(data) {
               document.getElementById('secRes').innerHTML = data;
          }
     });      
}
</script>