<?php
session_start();
if(isset($_SESSION['isLoggedIn'])) {
     echo 'A logged-in user cannot register or use the registration form.';
     die;
}
include 'ld/db.inc.php';
include 'ld/globals.inc.php';
?>
<!doctype html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel="stylesheet" href="css/themes/<?php echo $gbl['theme'] ?>/themestyle.css" />
<link rel="stylesheet" href="css/themes/style.php" />

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script> 
function submitReg()
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/js/ajax_login.php',
          type: 'POST',
          data: {
               'reguser': 1,
               'emailaddress': document.getElementById('emailaddress').value,
               'password1': document.getElementById('password1').value,
               'password2': document.getElementById('password2').value,
               'secchk': document.getElementById('secchk').value
          },
          success: function(data) {
               document.getElementById('regbutton').disabled = true;
               document.getElementById('regres').style.display = "block";
               document.getElementById('regres').innerHTML = data;
          }
     });
}
</script>

</head>
<body>
<?php

if(isset($_GET['approveuser'])) {
     $sql = $db->exec("UPDATE $_SESSION[prefix]_users SET account_status = 1 WHERE username = '$_GET[user]'");
     echo 'The account has been activated.  Click <a href="'. $gbl['site_url'] .'">HERE</a> to go to the main website.';
} else {
     ?>
     <div class="container">
     <div class="row">
     <div class="col-md-8">
     <h2 class="header">Register for a New Account</h2>
     <p>Fill in the following fields to register your new account.  At the end, before submitting, you will 
     also have to answer a simple security question.  This is to keep spammers and bots from using this page.</p>
     <form autocomplete="off">
     
     <div class="row">
     <div class="col-md-5">
     <label for="emailaddress">Email Address</label><br />
     <input type="text" name="emailaddress" id="emailaddress" class="form-control" placeholder="Your Email Address" required="required" /><br /><br />
     </div>
     </div>
     
     <div class="row">
     <div class="col-md-5">
     <label for="password1">Password</label><br />
     <input type="password" name="password1" id="password1" class="form-control" placeholder="Enter a Password" required="required" /><br /><br />
     </div></div>

     <div class="row">
     <div class="col-md-5">
     <label for="password2">Password (again)</label><br />
     <input type="password" name="password2" id="password2" class="form-control" placeholder="Enter it again" required="required" /><br /><br />
     </div>
     </div>

     <div class="row">
     <div class="col-md-8">
     <label for="secchk">Name the Animal you see in this photograph</label><br />
     <img src="ast/site/secpic.jpg" width="125" style="float: left; margin-right: 8px; margin-bottom: 8px;" />
     <input type="text" name="secchk" id="secchk" class="form-control inline" required="required" placeholder="What is it?" /><br /><br />
     </div>
     </div>
     
     <div class="row">
     <div class="col-md-5">
     <button type="button" class="btn btn-success" id="regbutton" onclick="submitReg()">Register</button>
     </div>
     </div>
     
     </form>
     </div>
     </div>
     <div class="row">
     <div class="col-md-8">
     <div class="alert alert-info" id="regres" style="display: none;"></div>
     </div>
     </div>
     </div>
     <?php
}
?>
</body>
</html>
<?php

function checkEmail($email)
{
     if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          return false;
     } else {
          return true;
     }
}

function checkPassword($pwd)
{
     $error = '';
     if(strlen($pwd) < 8) {
          $error = "Your password must be at least 8 characters long!<br />";
     }
     if(preg_match(" ", $pwd)) {
          $error .= "You cannot use spaces in your password!!<br />";
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
?>