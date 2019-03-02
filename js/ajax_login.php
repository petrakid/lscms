<?php
session_start();

include '../ld/db.inc.php';
include '../ld/globals.inc.php';

if(isset($_POST['login_user'])) {
     if($_POST['user_id'] == '' || $_POST['password'] == '') {
          echo 'You failed to provide your email address and/or password.  Please try again';
          die;
     }
     $password = $_POST['password'];
     $user = $_POST['user_id'];
    
     $sql = $db->prepare("SELECT password, salt FROM tbl_users WHERE username = ? AND account_status = ?");
     $sql->execute(array($user, 1));
     $usr = $sql->fetch(PDO::FETCH_ASSOC);
     $cnt = $sql->rowCount();
     if($cnt == 0) {
          echo 'No such user exists in the database or the account is inactive.  Please try again or Register';
          die;
     }
     $hpw = hash('sha256', $password . $usr['salt']);
     if($hpw != $usr['password']) {
          echo 'Your password is wrong.  Please try again.';
          die;
     }
     // Making it this far means that the user information is correct; we can log the user in
     unset($usr['salt']);
     unset($usr['password']);
     $sql = $db->query("SELECT * FROM tbl_users WHERE username = '$user'");
     $row = $sql->fetch(PDO::FETCH_ASSOC);
     if($row['security'] <= 1) {
          $row['security'] == 0;
     }
     if(isset($_POST['rememberme']) && $_POST['rememberme'] > '') {
          $length = time() + (86400 * 30); // 30 days, can become a DB option
          $cookiehash = md5(sha1($row['username'] . $row['salt']));
          $db->exec("UPDATE tbl_users SET cookie_hash = '$cookiehash' WHERE username = '$row[username]'");
          setcookie('remlog', $cookiehash, $length, "/");
     }
     $_SESSION['user'] = $row;   
     $_SESSION['isLoggedIn'] = 1;
     $_SESSION['upload_year'] = date("Y");
     $_SESSION['currentip'] = getRealIpAddr();
     $loginip = getRealIpAddr();
     $db->exec("UPDATE tbl_users SET last_login = now(), last_login_ip = '$loginip' WHERE username = '$row[username]'");
     echo 'You are logged in.  Welcome!';  
}

if(isset($_POST['forgot_pass'])) {
     ?>
     <p class="font-small dark-grey-text text-right d-flex justify-content-center mb-3 pt-2">If you forgot your password, enter your email address below and click "Reset".  If it is a valid, registered email address, you will receive a new password in your email.</p>
     <div class="md-form mb-5">
     <input type="email" name="pwrusername" id="pwrusername" class="form-control" autofocus="autofocus" autocomplete="no" />
     <label for="pwrusername">Email Address</label>
     </div>
     
     <div class="text-center mb-3">
     <button type="button" onclick="doReset()" class="btn tempting-azure-gradient btn-block btn-rounded z-depth-1a">Reset</button>
     </div>     
     <?php
}

if(isset($_POST['reset_pass'])) {
     $pws = $db->query("SELECT username FROM tbl_users WHERE username = '$_POST[pwrusername]'");
     if($pws->rowCount() > 0) {
          $pw = $pws->fetch(PDO::FETCH_ASSOC);
          $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
          $newpass = randomPassword();
          $password = hash('sha256', $newpass . $salt);
          $db->exec("UPDATE tbl_users SET password = '$password', salt = '$salt' WHERE username = '$pw[username]'");
          $to = $pw['username'];
          $subject = 'Password Reset ('. $gbl['site_name'] .')';
          $message = 'Your password has been reset.  Please log in with your username (email address) and<blockquote>'. $newpass .'</blockquote>as your password.';
          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
          $headers .= 'From: <'. $gbl['admin_email'] .'>' . "\r\n";
          mail($to, $subject, $message, $headers);
     }
     echo 'Completed.  If your email address was valid you should receive a new password soon.';         
}

if(isset($_POST['logout_user'])) {
     $db->exec("UPDATE tbl_users SET cookie_hash = '' WHERE username = '". $_SESSION['user']['username'] ."'");
     setcookie('remlog', '', time() - 1, "/");
     session_destroy();
     $_SESSION = array();
     exit;
}

if(isset($_POST['my_account'])) {
     $sql = $db->query("SELECT * FROM tbl_users WHERE username = '". $_SESSION['user']['username'] ."'");
     $usr = $sql->fetch(PDO::FETCH_ASSOC);
     ?>
     <small class="form-text text-muted m-2">Make your changes and click "Save".  These changes will not be reflected until you log out and back in again.</small>
     <form>
     <div class="md-form">
     <label for="username">Username (Your email address)</label>
     <div class="input-group-addon"><i class="fe fe-envelope"></i></div>
     <input type="email" name="username" id="username" value="<?php echo $usr['username'] ?>" class="form-control" required="required" />
     </div>
    
     <div class="md-form">
     <label for="password">Password</label>
     <div onmouseover="mouseoverPass()" onmouseout="mouseoutPass()" class="input-group-addon"><i class="glyphicon glyphicon-eye-open"></i></div>
     <input type="password" name="password" id="password" class="form-control" placeholder="Only enter if changing" />
     </div>

     <div class="md-form">
     <label for="first_name">First Name</label>
     <div class="input-group-addon"><b>F</b></div>
     <input type="text" name="first_name" id="first_name" value="<?php echo $usr['first_name'] ?>" class="form-control" required="required" />
     </div>

     <div class="md-form">
     <label for="last_name">Last Name</label>
     <div class="input-group-addon"><b>L</b></div>
     <input type="text" name="last_name" id="last_name" value="<?php echo $usr['last_name'] ?>" class="form-control" required="required" />
     </div>

     <div class="md-form">
     <label for="title">Title/Occupation</label>
     <div class="input-group-addon"><i class="glyphicon glyphicon-knight"></i></div>
     <input type="text" name="title" id="title" value="<?php echo $usr['title'] ?>" class="form-control" required="required" />
     </div>
     </form>
     <?php
}

if(isset($_POST['save_account'])) {
     if($_POST['password'] > '') {
          $pwc = checkPassword2($_POST['password']);
          if($pwc != 'Secure') {
               echo $pwc;
               die;                              
          }          
     }
     $usn = checkEmail($_POST['username']);
     if($usn != true) {
          echo 'The email address you provided as a username is invalid.';
          die;
     }
     if($_POST['password'] > '') {
          $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
          $password = hash('sha256', $_POST['password'] . $salt);
          $db->exec("UPDATE tbl_users SET username = '$_POST[username]', password = '$password', salt = '$salt', first_name = '$_POST[first_name]', last_name = '$_POST[last_name]', title = '$_POST[title]' WHERE username = '". $_SESSION['user']['username'] ."'");
          echo 'Account Updated.  You should log off for changes to take effect';
     } else {
          $db->exec("UPDATE tbl_users SET username = '$_POST[username]', first_name = '$_POST[first_name]', last_name = '$_POST[last_name]', title = '$_POST[title]' WHERE username = '". $_SESSION['user']['username'] ."'");
          echo 'Account Updated.  You should log off for changes to take effect';          
     }
}

if(isset($_POST['reguser'])) {
     // first check the security image
     $secanswer = strtolower($_POST['secchk']);
     if($secanswer != 'tiger') {
          echo 'You did not enter the correct answer for the Security Image.  Refresh and try again.<br />';
          die;
     }
     // check for valid email address
     if(checkEmail($_POST['emailaddress']) === false) {
          echo 'You must enter a valid, working Email Address to register.  Refresh and try again.<br />';
          die;
     }
     // verify the passwords are the same
     if($_POST['password1'] != $_POST['password2']) {
          echo 'Your Passwords did not match.  Refresh and try again.<br />';
          die;
     }
     // check password length and strength
     $pwc = checkPassword2($_POST['password1']);
     if($pwc != 'Secure') {
          echo $pwc;
          die;
     }
     // check to make sure the email address isn't already being used
     $sql = $db->query("SELECT username FROM tbl_users WHERE username = '$_POST[emailaddress]' AND account_status > 0");
     if($sql->rowCount() > 0) {
          echo 'This email address is already being used.  Either log into your account from the homepage or contact an administrator for assistance.<br />';
          die;
     } else {
          // if we make it to here, we register the user but set the account as inactive until approved by admin
     
          // create the salt
          $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
          // create the hashed password
          $password = hash('sha256', $_POST['password1'] . $salt);
     
          // add user to the database
          $sql = $db->exec("INSERT INTO tbl_users (`username`, `password`, `salt`, `account_status`) VALUES ('$_POST[emailaddress]', '$password', '$salt', 0)");
     
          $to = $gbl['admin_email'];
          $subject = "New User Account Created (". $gbl['site_url'] .")";
          $message = "A New User has been created on the ". $gbl['site_url'] ." website.  To approve this user, click <a href='". $_SESSION['sitevars']['site_url'] ."/register.php?approveuser=1&user=". $_POST['emailaddress'] ."'>HERE</a>";
          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
          $headers .= 'From: <'. $_POST['emailaddress'] .'>' . "\r\n";
     
          if(mail($to, $subject, $message, $headers)) {
               echo 'The user has been created and the Administrator has been notified.  Once active, you will be able to log into the site.';
               die;
          }
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

function checkPassword2($pwd)
{
     $error = '';
     if(strlen($pwd) < 8) {
          $error = "Your password must be at least 8 characters long!<br />";
     }
     if(preg_match(" ", $pwd)) {
          $error .= "You cannot use spaces in your password!<br />";
     }
     if(!preg_match("#[0-9]+#", $pwd)) {
     	$error .= "Password must include at least one number!<br />";
     }
     if(!preg_match("#[a-z]+#", $pwd)) {
     	$error .= "Password must include at least one letter!<br />";
     }
     if(!preg_match("#[A-Z]+#", $pwd)) {
     	$error .= "Password must include at least one CAPS!<br />";
     }
     if(!preg_match("#\W+#", $pwd)) {
     	$error .= "Password must include at least one symbol!";
     }
     if($error > '') {
          return($error);
     } else {
          return("Secure");
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