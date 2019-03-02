<?php
session_start();
if(isset($_SESSION['isLoggedIn'])) {
     header("location:index.php");
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
    
     $sql = $db->prepare("SELECT password, salt FROM $_SESSION[prefix]_users WHERE username = ? AND account_status = ?");
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
     $sql = $db->query("SELECT * FROM $_SESSION[prefix]_users WHERE username = '$user'");
     $row = $sql->fetch(PDO::FETCH_ASSOC);
     $_SESSION['user'] = $row;   
     $_SESSION['isLoggedIn'] = 1;
     $_SESSION['upload_year'] = date("Y");
     echo 'You are logged in!<br />';
     echo '<button type="button" class="btn btn-large btn-success btn-block" onclick="window.location.href = \''. $_SESSION['sitevars']['site_url'] .'/Home\'">Continue...</button>';          
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Maintenance :-(</title>
</head>
<body>
<h2 style="text-align: center;">We are down for maintenance, but we'll be back up soon.</h2>
<h4 style="text-align: center;">Check back in a couple of hours.  Thank you.</h4>
<p style="text-align: center;">(Admins, you know what to do to log in!!)</p>
</body>
</html>
<?php
if(isset($_GET['lg']) && $_GET['lg'] == 9) {
     ?>
     <form method="POST" action="">
     <b>Your Username/Email Address</b><br />
     <input type="email" name="user_id" id="user_id" required="required" /><br /><br />
     
     <b>Your Password</b><br />
     <input type="password" name="password" id="password" required="required" /><br /><br />
     
     <input type="submit" name="logmein" value="Login" />
     </form>
     <?php
}