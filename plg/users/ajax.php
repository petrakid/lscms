<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['adduser'])) {
     unset($_POST['adduser']);

     // check for valid email address
     if(checkEmail($_POST['username']) === false) {
          echo '<div class="alert alert-danger">You must enter a valid, working Email Address to create an account.  Try again.</div>';
          die;
     }
     // check to make sure the email address isn't already being used
     $sql = $db->query("SELECT username FROM tbl_users WHERE username = '$_POST[username]'");
     if($sql->rowCount() > 0) {
          echo '<div class="alert alert-warning">This email address is already being used.  Either log into your account from the homepage or contact an administrator for assistance.</div>';
          die;
     }

     // create the salt
     $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
     $temprand = randomPassword();
     // create the hashed password
     $password = hash('sha256', $temprand . $salt);
     
     $sql = $db->exec("INSERT INTO tbl_users (`username`, first_name, last_name, title, `password`, `salt`, `account_status`, `security`) VALUES ('$_POST[username]', '$_POST[first_name]', '$_POST[last_name]', '$_POST[title]', '$password', '$salt', 0, 0)");

     $to = $_POST['username'];
     $subject = "Account Created (". $gbl['site_name'] .")";
     $message = "An account has been created for you on the ". $gbl['site_name'] ." website.  To login, click <a href='". $gbl['site_url'] ."'>HERE</a>, then click the login button <i class='fa fa-sign-in'></i> just to the left of the site's name at the top.<br /><br />\r\n";
     $message .= "Your password is: $temprand<br /><br />Once logged in, click the &equiv; symbol at the top and edit your account and update your password.\r\n";  
     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= 'From: <'. $gbl['admin_email'] .'>' . "\r\n";

     if(mail($to, $subject, $message, $headers)) {
          echo '<div class="alert alert-success">The user has been created.  You need to refresh this page and set the user\'s security level.</div>';
          die;
     }               
}

if(isset($_POST['edit_account'])) {
     $act = $db->query("SELECT * FROM  tbl_users WHERE username = '$_POST[username]'");
     $ac = $act->fetch(PDO::FETCH_ASSOC);
     ?>
     <form id="edit_user" name="edit_user">
     <input type="hidden" name="edituser" id="edituser" value="<?php echo $ac['username'] ?>" /> 
     
     <div class="md-form">
     <input type="email" name="username" id="username" value="<?php echo $ac['username'] ?>" required="required" class="form-control" />
     <label for="username">Username</label>
     </div>
     
     <div class="md-form">    
     <input type="text" name="first_name" id="first_name" value="<?php echo $ac['first_name'] ?>" required="required" class="form-control" />
     <label for="first_name">First Name</label>
     </div>
     
     <div class="md-form">
     <input type="text" name="last_name" id="last_name" value="<?php echo $ac['last_name'] ?>" required="required" class="form-control" />
     <label for="last_name">Last Name</label>
     </div>
     
     <div class="md-form">     
     <input type="text" name="title" id="title" value="<?php echo $ac['title'] ?>" required="required" class="form-control" />
     <label for="title">Title</label>
     </div>
     
     <small class="form-text text-muted mb-1">Account Status</small>
     <select name="account_status" id="account_status" class="mdb-select md-form mt-1">
     <option value="1" <?php if($ac['account_status'] == 1) { echo 'selected="selected"'; } ?>>Active</option>
     <option value="0" <?php if($ac['account_status'] == 0) { echo 'selected="selected"'; } ?>>Inactive/Pending</option>
     <option value="9" <?php if($ac['account_status'] == 9) { echo 'selected="selected"'; } ?>>Removed/Banned</option>          
     </select>
     
     
     <small class="form-text text-muted mb-1">Security Role</small>
     <select name="security" id="security" class="mdb-select md-form mt-1">
     <option value="" disabled>Select</option>
     <?php
     $sec = $db->query("SELECT * FROM tbl_security_roles WHERE role_status = 1 ORDER BY s_id ASC");
     while($sc = $sec->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <option value="<?php echo $sc['s_id'] ?>" <?php if($ac['security'] == $sc['s_id']) { echo 'selected="selected"'; } ?>><?php echo $sc['role_name'] ?></option>
          <?php
     }
     ?>
     </select>
     <div class="form-check">
     <input class="form-check-input" type="checkbox" name="show_bio" id="show_bio" <?php if($ac['show_bio'] == 1) { echo 'checked="checked"';} ?> value="1" />
     <label for="show_bio" class="form-check-label">Show Biography</label>
     </div>
     </form>     
     <?php
}

if(isset($_POST['save_account'] )) {
     if($_POST['username'] != $_POST['emailaddress']) {
          $em = $db->query("SELECT username FROM tbl_users WHERE username = '$_POST[emailaddress]'");
          if($em->rowCount() > 0) {
               echo '<div class="alert alert-warning">This Email Address is already being used.  Please try another.</div>';
               die;
          }
     }
     if(checkEmail($_POST['emailaddress']) === false) {
          echo '<div class="alert alert-danger">The text you entered as the "Username" should be an email address.  You entered '. $_POST['emailaddress'] .' which is NOT a valid email address.</div>';
          die;
     }
     if($_POST['show_bio'] == 1) {
          $showbio = 1;
     } else {
          $showbio = 0;
     }
     $db->exec("UPDATE tbl_users SET username = '$_POST[emailaddress]', first_name = '$_POST[firstname]', last_name = '$_POST[lastname]', account_status = '$_POST[status]', title = '$_POST[title]', security = '$_POST[security]', show_bio = $showbio WHERE username = '$_POST[username]'");
     echo '<div class="alert alert-success">User has been updated</div>';     
}

if(isset($_POST['reset_pass'])) {
     // create the salt
     $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
     $temprand = randomPassword();
     // create the hashed password
     $password = hash('sha256', $temprand . $salt);
     
     $db->exec("UPDATE tbl_users SET password = '$password', salt = '$salt' WHERE username = '$_POST[username]'");

     $to = $_POST['username'];
     $subject = "Account Password reset (". $gbl['site_name'] .")";
     $message = "A password reset was performed on the ". $gbl['site_name'] ." website.  You must now log in with the new password by going <a href='". $gbl['site_url'] ."'>HERE</a><br /><br />\r\n";
     $message .= "When asked, enter the following NEW password: $temprand<br /><br />\r\n  You should then edit your account and change your password.";  
     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     $headers .= 'From: <'. $gbl['admin_email'] .'>' . "\r\n";

     mail($to, $subject, $message, $headers);
     echo '<div class="alert alert-primary">Password Reset Completed</div>';
}

if(isset($_POST['delete_account'])) {
     $username = str_replace("@", "_", $_POST['username']);
     $db->exec("UPDATE tbl_users SET account_status = 9, username = '$username' WHERE username = '$_POST[username]'");
     echo '<div class="alert alert-info">Account Removed</div>';
}

if(isset($_POST['update_security'])) {
     if($_POST['newrole'] > '') {
          $db->exec("INSERT INTO tbl_security_roles (role_name, role_status) VALUES ('$_POST[newrole]', 1)");
     }
     foreach($_POST['role'] AS $key => $val) {
          $db->exec("UPDATE tbl_security_roles SET role_name = '$val' WHERE s_id = $key");
     }
     echo '<div class="alert alert-success">Roles Updated</div>';
}
if(isset($_POST['update_user'])) {
     if($_POST['field'] == 'email_2') {
          if(checkEmail($_POST['value']) === false) {
               echo 'error_2';
               die;
          }
     }
     if($_POST['field'] == 'biography') {
          $_POST['value'] = addslashes($_POST['value']);
     }
     if($_POST['field'] == 'favorite_quote') {
          $_POST['value'] = addslashes($_POST['value']);
     }
     if($_POST['field'] == 'favorite_verse') {
          $_POST['value'] = addslashes($_POST['value']);
     }
     if($_POST['field'] == 'phone_1' || $_POST['field'] == 'phone_2') {
          $_POST['value'] = preg_replace("/[^0-9]/", "", str_replace(" ","", $_POST['value']));
     }
     $db->exec("UPDATE tbl_users SET `$_POST[field]` = '$_POST[value]' WHERE username = '". $_SESSION['user']['username'] ."'");
}

if(isset($_POST['update_image'])) {
     if(!empty($_FILES['profile_image'])) {
          $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
          $filename = date('ymdhis') . rand(1,5) .'.'. $ext;
          if(move_uploaded_file($_FILES['profile_image']['tmp_name'], $gbl['doc_root'] .'ast/users/'. $filename)) {
               $db->exec("UPDATE tbl_users SET profile_image = '$filename' WHERE username = '". $_SESSION['user']['username'] ."'");
               echo $filename;
          }
     }
}

if(isset($_POST['check_password'])) {
     $password = $_POST['old_pass'];
     $sql = $db->prepare("SELECT password, salt FROM tbl_users WHERE username = ? AND account_status = ?");
     $sql->execute(array($_SESSION['user']['username'], 1));
     $usr = $sql->fetch(PDO::FETCH_ASSOC);
     $hpw = hash('sha256', $password . $usr['salt']);
     if($hpw != $usr['password']) {
          echo 'wrong';
          die;
     }
}
if(isset($_POST['try_reset'])) {
     $password1 = $_POST['new_pass1'];
     $password2 = $_POST['new_pass2'];
     if($password1 != $password2) {
          echo 'wrong1';
          die;
     }
     $pwc = checkPassword($password1);
     if($pwc == 'TooShort') {
          echo 'wrong2';
          die;
     }
     if($pwc == 'NotSecure') {
          echo 'wrong3';
          die;
     }
     if($pwc == 'Secure') {
          echo 'right';
          $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
          $hashed = hash('sha256', $password1 . $salt);
          $db->exec("UPDATE tbl_users SET password = '$hashed', salt = '$salt' WHERE username = '". $_SESSION['user']['username'] ."'");
          die;
     }
}
function checkEmail($email)
{
     if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          return false;
     } else {
          return true;
     }
}

function randomPassword() {
    $alphabet = 'abcdefghjklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789!$@';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}