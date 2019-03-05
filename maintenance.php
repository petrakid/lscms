<?php
session_start();
if(isset($_SESSION['isLoggedIn'])) {
     header("location:home");
     die;
}

if(isset($_POST['logmein'])) {
     include 'ld/db.inc.php';
     include 'ld/globals.inc.php';

     if($_POST['user_id'] == '' || $_POST['password'] == '') {
          echo 'You failed to provide your email address and/or password.  Please try again';
          die;
     }
     $password = $_POST['password'];
     $user = $_POST['user_id'];
    
     $sql = $db->prepare("SELECT password, salt, security FROM tbl_users WHERE username = ? AND account_status = ?");
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
     if($usr['security'] < 2) {
          echo 'You have an account, but your security level is too low.  You cannot log in while the site is in maintenance.';
          die;
     }
     // Making it this far means that the user information is correct; we can log the user in
     unset($usr['salt']);
     unset($usr['password']);
     $sql = $db->query("SELECT * FROM tbl_users WHERE username = '$user'");
     $row = $sql->fetch(PDO::FETCH_ASSOC);
     $_SESSION['user'] = $row;   
     $_SESSION['isLoggedIn'] = 1;
     $_SESSION['upload_year'] = date("Y");         
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Maintenance :-(</title>
<style>
body {
     background: url('ast/site/maintenanceback.jpg');
     background-size: cover;
}
.adminloginbutton {
     position: absolute;
     top: 65%;
     left: 62%;
}
.adminloginform {
     position: absolute;
     top: 65%;
     left: 62%;
}
input[type=submit], input[type=button] {
     width: 200px;
     height: 45px;
     font-size: 18px;
}
input[type=text], input[type=email], input[type=password] {
     width: 200px;
     height: 30px;
     font-size: 16px;
}
.loginresult {
     position: absolute;
     top: 65%;
     left: 62%;
}
</style>
</head>
<body>
<?php
if(isset($_GET['lg']) && $_GET['lg'] == 9) {
     ?>
     <div class="adminloginform">
     <form method="POST" action="" class="adminloginformform">
     <b>Your Username/Email Address</b><br />
     <input type="email" name="user_id" id="user_id" required="required" /><br /><br />
     
     <b>Your Password</b><br />
     <input type="password" name="password" id="password" required="required" /><br /><br />
     
     <input type="submit" name="logmein" value="Login" />
     </form>
     </div>
     <?php
}
else if(isset($_SESSION['user'])) {
     ?>
     <div class="loginresult">
     You are logged in!<br />
     <button type="button" class="btn btn-large btn-success btn-block" onclick="window.location.href = '<?php echo $gbl['site_url'] ?>/Home')">Continue...</button>
     </div>
     <?php
} else {
     ?>
     <div class="adminloginbutton">
     <form method="GET" action="" class="adminloginbuttonform">
     <input type="hidden" name="lg" value="9" />
     <input type="submit" name="login" value="Admin Login" />
     </form>
     </div>
     <?php     
}
?>
</body>
</html>
