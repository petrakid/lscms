<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>

<title>Luthersites CMS Installer</title>

<style>
body {
     background-color: azure;
     font-family: sans-serif;
}
#logodiv {
     margin: 0 auto;
     width: 40%;
     padding: 0;
}

.logo {
     width: 100%;
     
}
#datadiv {
     display: flex;
     align-items: center;
     justify-content: center;
     height: 100%;
     background: white;
     width: 40%;
     margin: 0 auto;
     border: 2px inset gray;
     border-radius: 15px;
}

#innerdiv {
     padding: 8px; 
}
#datadiv h3 {
     font-size: 25px;
     background-color: aliceblue;
     padding: 10px;
     border-radius: 10px;
}
#sharingdiv {
     height: 45px;
     width: 100%;
     text-align: center;
     padding-top: 10px;
}
label {
     font-weight: bold;
     display: block;
     position: relative;
     margin-bottom: 8px;
}
input[type=text] {
     height: 25px;
     width: 80%;
     font-size: 16px;
     border-radius: 2px;
}
input[type=submit] {
     height: 30px;
     min-width: 30%;
     background-color: green;
     color: white;
     font-size: 16px;
     border-radius: 8px;
}
.sharelink {
     text-decoration: none;
     margin-right: 8px;
}
.shareicon {
     width: 30px;
     height: 30px;
     border-radius: 20px;
}
</style>
</head>

<body>
<div id="datadiv">
<div id="innerdiv">
<div id="logodiv"><img src="inst/logo.jpg" class="logo" /></div>
<h3 style="text-align: center">Luthersites CMS Installer</h3>
<?php
error_reporting(E_ALL);
ini_set("log_errors" , "1");
ini_set("error_log" , $_SERVER['DOCUMENT_ROOT'] ."/err/error_log.txt");
ini_set("display_errors" , "1");
if(empty($_POST)) {
     ?>
     <p>Welcome to the Luthersites CMS Installer!</p>
     <p>This installer will setup your database and your administrative user account.  But before you can continue, please enter the passphrase that was 
     emailed to you when you first setup your hosting with Luthersites.  If you aren't sure where to find this passphrase, submit a support request at
     <a href="https://www.luthersites.net/submitticket.php?step=2&deptid=3" target="_blank">Luthersites</a>.  You will need to be logged in to submit a ticket.</p>
     <hr />
     <form method="POST" action="" autocomplete="false">
     <input type="hidden" name="check_passphrase" id="check_passphrase" value="1" />
     <label for="my_password">Enter your Passphrase</label>
     <input type="text" name="my_password" id="my_password" autocomplete="false" /><br /><br />
     <input type="submit" name="check" value="Submit" />
     </form>
     <?php
}
if(isset($_POST['check_passphrase'])) {
     if(checkPassword($_POST['my_password']) === true) {
          ?>
          <span style="color: green;">&check; - Passphrase Verified!</span><br /><br />
          
          <p>Congratulations!  The passphrase has been verified.  Now we can proceed.</p>
          <?php
          $a = explode("/", $_SERVER['DOCUMENT_ROOT']);
          ?>
          <p>Your Account Name is <b><?php echo $a[2] ?></b>, and it is in this folder that your website's filesystem is stored.  We will use this
          account name to create your database.  Click "Create Database" to continue.</p>
          <form method="POST" action="">
          <input type="hidden" name="create_db" id="creat_db" value="<?php echo $a[2] ?>" />
          <input type="submit" name="createdb" value="Create Database" />
          </form>
          <?php
     } else {
          ?>
          <p>The Passphrase you entered does not appear correct.  It must be correct, including capital letters, spaces, and special characters.  Please try again.</p>
          <form method="POST" action="">
          <input type="hidden" name="check_passphrase" id="check_passphrase" value="1" />
          <label for="my_password">Enter your Passphrase</label>
          <input type="text" name="my_password" id="my_password" /><br /><br />
          <input type="submit" name="check" value="Submit" />
          </form>          
          <?php
     }
}
if(isset($_POST['create_db'])) {
     $servername = "localhost";
     $username = "root";
     $password = "Melanchthon13__";
     $newdb = $_POST['create_db'] .'_db1';
     $newuser = $_POST['create_db'] .'_conn1';
     $newpass = createPassword();
     
     try {
          $conn = new PDO("mysql:host=$servername", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $conn->exec("DROP DATABASE IF EXISTS $newdb");
          $sql = "CREATE DATABASE $newdb";
          $conn->exec($sql);
          $conn->exec("DROP USER IF EXISTS '$newuser'@'localhost'");
          $adduser = "CREATE USER '$newuser'@'localhost' IDENTIFIED BY '$newpass'";
          $conn->exec($adduser);
          $assignuser = "GRANT ALL ON $newdb.* TO '$newuser'@'localhost'";
          $conn->exec($assignuser);
          $conn->exec("DROP USER IF EXISTS '$newuser'@'68.66.210.54'");
          $adduser = "CREATE USER '$newuser'@'68.66.210.54' IDENTIFIED BY '$newpass'";
          $conn->exec($adduser);          
          $assignuser = "GRANT ALL ON $newdb.* TO '$newuser'@'68.66.210.54'";
          $conn->exec($assignuser);
          $conn->exec("DROP USER IF EXISTS '$newuser'@'server.luthersites.net'");
          $adduser = "CREATE USER '$newuser'@'server.luthersites.net' IDENTIFIED BY '$newpass'";
          $conn->exec($adduser);          
          $assignuser = "GRANT ALL ON $newdb.* TO '$newuser'@'server.luthersites.net'";
          $conn->exec($assignuser);
          ?>
          <span style="color: green;">&check; - Passphrase Verified!</span><br />
          <span style="color: green;">&check; - Database Created and Configured!</span><br /><br />                    
          <p>Great!  Your new database has been created.  But there is no data in the database.  We're not done yet!  Next we will add the database tables 
          and populate the database with default data for your website.  To do this, click "Add Data".</p>
          <form method="POST" action="">
          <input type="hidden" name="add_data" id="add_data" value="1" />
          <input type="hidden" name="dbdb" id="dbdb" value="<?php echo $newdb ?>" />
          <input type="hidden" name="dbuser" id="dbuser" value="<?php echo $newuser ?>" />
          <input type="hidden" name="dbpass" id="dbpass" value="<?php echo $newpass ?>" />
          <input type="submit" name="adddata" value="Add Data" />
          </form>
          <?php
     }
     catch(PDOException $e) {
          echo $sql . "<br />" . $e->getMessage();
     }
     $conn = null;     
}
if(isset($_POST['add_data'])) {
     $servername = 'localhost';
     $username = $_POST['dbuser'];
     $password = $_POST['dbpass'];
     $database = $_POST['dbdb'];
     exec("mysqldump -u'root' -p'Melanchthon13__' lutherho_install | mysql -u ". $username ." --password='". $password ."' ". $database)
     ?>
     <span style="color: green;">&check; - Passphrase Verified!</span><br />
     <span style="color: green;">&check; - Database Created and Configured!</span><br />
     <span style="color: green;">&check; - Database Populated with Default Data!</span><br /><br />           
     <p>Awesome!  We're almost done!  There are a couple of things in your new database that need
     fixin' and then we need to secure up your website.</p>
     <p>First things first...We need to set a few things up in your Global settings.  Fill out the following and click "Submit".</p>
     <form method="POST" action="">
     <input type="hidden" name="update_globals" id="update_globals" value="1" />
     <input type="hidden" name="dbdb" id="dbdb" value="<?php echo $database ?>" />
     <input type="hidden" name="dbuser" id="dbuser" value="<?php echo $username ?>" />
     <input type="hidden" name="dbpass" id="dbpass" value="<?php echo $password ?>" />          
     <label for="site_name">Your Church or Organization's Name</label>
     <input type="text" name="site_name" id="site_name" style="width: 90%;" /><br /><br />
     
     <label for="site_url">Your Website's URL (make SURE it's got the "https://www." at the beginning!!</label>
     <input type="url" name="site_url" id="site_url" value="<?php echo $_SERVER['HTTP_HOST'] ?>" style="width: 90%;" /><br /><br />
     
     <label for="doc_root">Site's Root Folder (Doc Root)</label>
     <input type="text" name="doc_root" id="doc_root" value="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>/" style="width:  90%;" /><br /><br />
     
     <input type="submit" name="updateglobals" value="Submit" />
     </form>
     <script>
     
     </script>
     <?php
}
if(isset($_POST['update_globals'])) {
     $db_host  = 'localhost';
     $db_db    = $_POST['dbdb'];
     $db_user  = $_POST['dbuser'];
     $db_pass  = $_POST['dbpass'];
     
     $dsn = "mysql:host=$db_host;dbname=$db_db;charset=utf8mb4";
     try {
          $conn = new PDO($dsn, $db_user, $db_pass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch(PDOException $e) {
          echo $e->getMessage();
     }
     $url = str_replace("www.", "", $_POST['site_url']);
     $url = str_replace("http://", "", $url);
     $url = str_replace("https://", "", $url);
     $_POST['site_url'] = 'https://www.'. $url;
     $conn->exec("UPDATE tbl_globals SET site_name = '$_POST[site_name]', site_url = '$_POST[site_url]', doc_root = '$_POST[doc_root]', maintenance_mode = 1 WHERE id = 1");
     $conn->exec("INSERT INTO tbl_meta_tags (meta_tag, meta_tag_status, meta_tag_order) VALUES ('<base href=\"$_POST[site_url]\" />', 1,1)");
     ?>
     <span style="color: green;">&check; - Passphrase Verified!</span><br />
     <span style="color: green;">&check; - Database Created and Configured!</span><br />
     <span style="color: green;">&check; - Database Populated with Default Data!</span><br />
     <span style="color: green;">&check; - Global settings set!</span><br /><br />     
     <p>Done.  Now you need to create your account on the website so you can administrate it.  Enter your Email Address and a Password and click "Create Account".</p>
     <form method="POST" action="">
     <input type="hidden" name="create_account" value="1" />
     <input type="hidden" name="dbdb" id="dbdb" value="<?php echo $db_db ?>" />
     <input type="hidden" name="dbuser" id="dbuser" value="<?php echo $db_user ?>" />
     <input type="hidden" name="dbpass" id="dbpass" value="<?php echo $db_pass ?>" />
     <label for="username">Email Address</label>
     <input type="email" name="username" id="username" /><br /><br />
     
     <label for="password1">Enter a strong password</label>
     <input type="password" name="password1" id="password1" /><br />
     <label for="password2">Enter the password again</label>
     <input type="password" name="password2" id="password2" /><br /><br />
     
     <input type="submit" name="createaccount" value="Create Account" />      
     </form>
     <?php
}
if(isset($_POST['create_account'])) {
     $db_host  = 'localhost';
     $db_db    = $_POST['dbdb'];
     $db_user  = $_POST['dbuser'];
     $db_pass  = $_POST['dbpass'];
     
     $dsn = "mysql:host=$db_host;dbname=$db_db;charset=utf8mb4";
     try {
          $conn = new PDO($dsn, $db_user, $db_pass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch(PDOException $e) {
          echo $e->getMessage();
     }
     $chk = $conn->query("SELECT username FROM tbl_users WHERE username = '$_POST[username]'");
     if($chk->rowCount() > 0) {
          ?>
          <p>Um, the email address you entered is already in use on this website.  Enter a different email address and try again.</p>
          <form method="POST" action="">
          <input type="hidden" name="create_account" value="1" />
          <input type="hidden" name="dbdb" id="dbdb" value="<?php echo $db_db ?>" />
          <input type="hidden" name="dbuser" id="dbuser" value="<?php echo $db_user ?>" />
          <input type="hidden" name="dbpass" id="dbpass" value="<?php echo $db_pass ?>" />
          <label for="username">Email Address</label>
          <input type="email" name="username" id="username" /><br /><br />
          
          <label for="password1">Enter a strong password</label>
          <input type="password" name="password1" id="password1" value="<?php echo $_POST['password1'] ?>" /><br />
          <label for="password2">Enter the password again</label>
          <input type="password" name="password2" id="password2" value="<?php echo $_POST['password2'] ?>" /><br /><br />
          
          <input type="submit" name="createaccount" value="Create Account" />      
          </form>          
          <?php
          die;
     }
     if($_POST['password1'] != $_POST['password2']) {
          ?>
          <p>Your passwords do not match.  Try again.</p>
          <form method="POST" action="">
          <input type="hidden" name="create_account" value="1" />
          <input type="hidden" name="dbdb" id="dbdb" value="<?php echo $db_db ?>" />
          <input type="hidden" name="dbuser" id="dbuser" value="<?php echo $db_user ?>" />
          <input type="hidden" name="dbpass" id="dbpass" value="<?php echo $db_pass ?>" />
          <label for="username">Email Address</label>
          <input type="email" name="username" id="username" value="<?php echo $_POST['username'] ?>" /><br /><br />
          
          <label for="password1">Enter a strong password</label>
          <input type="password" name="password1" id="password1" value="<?php echo $_POST['password1'] ?>" /><br />
          <label for="password2">Enter the password again</label>
          <input type="password" name="password2" id="password2" value="<?php echo $_POST['password2'] ?>" /><br /><br />
          
          <input type="submit" name="createaccount" value="Create Account" />      
          </form>            
          <?php
          die;
     }
     if(checkPassword2($_POST['password1']) != 'Secure') {
          ?>
          <p>Nope, you have to use a SECURE password!  Look at the error and try again.</p>
          <p><?php echo checkPassword2($_POST['password1']) ?></p>
          <form method="POST" action="">
          <input type="hidden" name="create_account" value="1" />
          <input type="hidden" name="dbdb" id="dbdb" value="<?php echo $db_db ?>" />
          <input type="hidden" name="dbuser" id="dbuser" value="<?php echo $db_user ?>" />
          <input type="hidden" name="dbpass" id="dbpass" value="<?php echo $db_pass ?>" />
          <label for="username">Email Address</label>
          <input type="email" name="username" id="username" value="<?php echo $_POST['username'] ?>" /><br /><br />
          
          <label for="password1">Enter a strong password</label>
          <input type="password" name="password1" id="password1" value="" /><br />
          <label for="password2">Enter the password again</label>
          <input type="password" name="password2" id="password2" value="" /><br /><br />
          
          <input type="submit" name="createaccount" value="Create Account" />      
          </form>          
          <?php
          die;
     }
     $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
     $password = hash('sha256', $_POST['password1'] . $salt);
     $conn->exec("INSERT INTO tbl_users (username, password, salt, security, account_status) VALUES ('$_POST[username]', '$password', '$salt', 9, 1)");
     $_SESSION['user']['username'] = $_POST['username'];
     $_SESSION['user']['security'] = 9;
     $_SESSION['user']['account_status'] = 1;
     $_SESSION['isLoggedIn'] = 1;
     $_SESSION['firstTime'] = 1;
     ?>
     <span style="color: green;">&check; - Passphrase Verified!</span><br />
     <span style="color: green;">&check; - Database Created and Configured!</span><br />
     <span style="color: green;">&check; - Database Populated with Default Data!</span><br />
     <span style="color: green;">&check; - Global settings set!</span><br />
     <span style="color: green;">&check; - Administrative Account Created (<?php echo $_POST['username'] ?> / <?php echo substr_replace($_POST['password1'], '*****', 0,5) ?>)!</span><br /><br />     
     <p>Great news!  Your account has been created and activated.  Now let's create the database connection script so that your website will work.  Click "Create Script".</p>
     <form method="POST" action="">
     <input type="hidden" name="create_script" value="1" />
     <input type="hidden" name="dbdb" id="dbdb" value="<?php echo $db_db ?>" />
     <input type="hidden" name="dbuser" id="dbuser" value="<?php echo $db_user ?>" />
     <input type="hidden" name="dbpass" id="dbpass" value="<?php echo $db_pass ?>" />
     <input type="submit" name="createscript" value="Create Script" />     
     </form>
     <?php     
}
if(isset($_POST['create_script'])) {
     $contents = '<?php
$db_host  = "localhost";
$db_db    = "'. $_POST['dbdb'] .'";
$db_user  = "'. $_POST['dbuser'] .'";
$db_pass  = "'. $_POST['dbpass'] .'";

$dsn = "mysql:host=$db_host;dbname=$db_db;charset=utf8mb4";
try {
     $db = new PDO($dsn, $db_user, $db_pass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
     echo $e->getMessage();
}
?>';
     $file = fopen($_SERVER['DOCUMENT_ROOT'] ."/ld/db.inc.php", "w");
     fwrite($file, $contents);
     fclose($file);
     ?>
     <span style="color: green;">&check; - Passphrase Verified!</span><br />
     <span style="color: green;">&check; - Database Created and Configured!</span><br />
     <span style="color: green;">&check; - Database Populated with Default Data!</span><br />
     <span style="color: green;">&check; - Global settings set!</span><br />
     <span style="color: green;">&check; - Administrative Account Created!</span><br />
     <span style="color: green;">&check; - Database Connection Script Written!</span><br /><br />          
     <p>Yay!  Database connection script is written.  Just two more things.  First let's setup your site's .htaccess file, a VERY important file for making things work.  
     Click "Setup htacess" to continue</p>
     <form method="POST" action="">
     <input type="hidden" name="create_htaccess" value="1" />
     <input type="submit" name="createhtaccess" value="Create htaccess" />     
     </form>
     <?php
}
if(isset($_POST['create_htaccess'])) {
     $url = str_replace("www.", "", $_SERVER['HTTP_HOST']);
     $url = str_replace("http://", "", $url);
     $url = str_replace("https://", "", $url);    
     $contents = 'Options All -Indexes
Options +FollowSymLinks

<IfModule mod_headers.c>
   SetEnvIf Origin "http(s)?://(www\.)?('. $url .')$" AccessControlAllowOrigin=$0$1
   Header add Access-Control-Allow-Origin %{AccessControlAllowOrigin}e env=AccessControlAllowOrigin
   Header set Access-Control-Allow-Credentials true
</IfModule>

RewriteEngine On

RewriteRule ^sitemap\.xml$ sitemap.php [L]

# add www to url
RewriteCond %{HTTP_HOST} ^[^.]+\.[^.]+$
RewriteRule ^(.*)$ https://www.%{HTTP_HOST}/$1 [L,R=301]

RewriteCond %{HTTPS} !=on
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

RewriteCond %{REQUEST_FILENAME} !-f [NC]
RewriteCond %{REQUEST_FILENAME} !-d [NC,OR]
RewriteCond %{REQUEST_URI} ^/$ 
RewriteRule ^(.*)$ /index.php?page=$1 [L]

# php -- BEGIN cPanel-generated handler, do not edit
# Set the “ea-php72” package as the default “PHP” programming language.
<IfModule mime_module>
  AddType application/x-httpd-ea-php72 .php .php7 .phtml
</IfModule>
# php -- END cPanel-generated handler, do not edit

# BEGIN cPanel-generated php ini directives, do not edit
# Manual editing of this file may result in unexpected behavior.
# To make changes to this file, use the cPanel MultiPHP INI Editor (Home >> Software >> MultiPHP INI Editor)
# For more information, read our documentation (https://go.cpanel.net/EA4ModifyINI)
<IfModule php7_module>
   php_value always_populate_raw_post_data -1
   php_flag display_errors On
   php_value max_execution_time 300
   php_value max_input_time -1
   php_value max_input_vars 1000
   php_value memory_limit 128M
   php_value post_max_size 40M
   php_value session.gc_maxlifetime 1440
   php_value session.save_path "/var/cpanel/php/sessions/ea-php70"
   php_value upload_max_filesize 40M
   php_flag zlib.output_compression Off
</IfModule>
# END cPanel-generated php ini directives, do not edit     
     ';
     $file = fopen('htaccess.txt', 'w+');
     fwrite($file, $contents);
     fclose($file);
     rename('htaccess.txt', '.htaccess');
     ?>
     <span style="color: green;">&check; - Passphrase Verified!</span><br />
     <span style="color: green;">&check; - Database Created and Configured!</span><br />
     <span style="color: green;">&check; - Database Populated with Default Data!</span><br />
     <span style="color: green;">&check; - Global settings set!</span><br />
     <span style="color: green;">&check; - Administrative Account Created!</span><br />
     <span style="color: green;">&check; - Database Connection Script Written!</span><br />
     <span style="color: green;">&check; - htaccess File Written!</span><br /><br />          
     <p>Got it! But, guess what?  ONE MORE STEP and we're done!  The install folder and its contents needs to be deleted to keep your site safe.  Click "Finish"
     and once this step is complete you will be forwarded to your new website.</p>
     <form method="POST" action="">
     <input type="hidden" name="delete_install" value="1" />
     <input type="submit" name="deleteinstall" value="Finish" />     
     </form>
     <?php     
}
if(isset($_POST['delete_install'])) {
     ?>
     <span style="color: green;">&check; - Passphrase Verified!</span><br />
     <span style="color: green;">&check; - Database Created and Configured!</span><br />
     <span style="color: green;">&check; - Database Populated with Default Data!</span><br />
     <span style="color: green;">&check; - Global settings set!</span><br />
     <span style="color: green;">&check; - Administrative Account Created!</span><br />
     <span style="color: green;">&check; - Database Connection Script Written!</span><br />
     <span style="color: green;">&check; - htaccess File Written!</span><br />
     <span style="color: green;">&check; - Install Completed!</span><br /><br />          
     <?php     
     if(deleteFiles('inst/')) {
          if(rmdir('inst')) {
               ?>
               <p>That's it!  You will now be forwarded to your website.  God's blessings on your day!</p>               
               <meta http-equiv="refresh" content="4;url: index.php" />               
               <?php
          }
     } else {
          ?>
          <p>There was a problem deleting the install scripts.  No worries.  We changed the name of the file and cleared its contents.  You may want to let the admin know that it failed so he can
          remove the files.  You will now be forwarded to your website.  God's blessings on your day!</p>
          <meta http-equiv="refresh" content="4;url: index.php" /> 
          <?php          
          $destroy = fopen('inst/install.php', 'w');
          fwrite($destroy, '...');
          fclose($destroy);
          rename('inst/install.php', 'inst/install._');
     }
     die;
}
?>
<hr />
<div id="sharingdiv">
<a class="sharelink" href="https://www.luthersites.net" target="_blank"><img src="inst/lsshare.png" class="shareicon" title="Luthersites" /></a>
<a class="sharelink" href="https://www.facebook.com/Luthersites-Hosting-1055328941304854/" target="_blank"><img src="inst/fbshare.png" class="shareicon" title="Facebook" /></a>
<a class="sharelink" href="mailto:luthersites1@outlook.com" target="_blank"><img src="inst/emailshare.png" class="shareicon" title="Email" /></a>
</div>
</div>
</div>
</body>
</html>

<?php
function checkPassword($pass)
{
     $hasharray = array('D1EB72E0B7D4DDB7477D473EBF72B71D01FD29102E753A7D21CE2C1C6B3A2791',
                        '13C82BC0EF9DCC24E3EE18C3818631E831117C2347B56D22071E769B617C6DDF',
                        'BF2293DA0BF192785FC2D8EBA11C9FC830211FA7493107739511598044EEDC44',
                        'E34BE39BCC96CC12D9CB37343C4CD47BDD508451DB42077683AA9390BC54581C',
                        'D54D1B62BC3E097617AE1950A48979169428A89C62F2CA61F327E3D7215E9188',
                        'ECE375B2A24C380644A866C824B668E6664E2F156DCDDCC51630DB36D7CEF497');
     $pass = strtoupper(hash('sha256', $pass));
     if(in_array($pass, $hasharray)) {
          return true;
     } else {
          return false;
     }
}

function createPassword()
{
     $alphabet = 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789';
     $pass = array(); //remember to declare $pass as an array
     $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
     for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
     }
     return implode($pass); //turn the array into a string     
}

function checkPassword2($pwd)
{
     $error = '';
     if(strlen($pwd) < 8) {
          $error .= "Your password is TOO SHORT! You need at least 8 characters.<br />";
     }
     if(preg_match("/\s/", $pwd)) {
          $error .= "You cannot have spaces in your password.<br />";
     }
     if(!preg_match("#[0-9]+#", $pwd)) {
     	$error .= "You must have at least 1 number in your password.<br />";
     }
     if(!preg_match("#[a-z]+#", $pwd)) {
     	$error .= "You must have at least one lowercase letter in your password.<br />";
     }
     if(!preg_match("#[A-Z]+#", $pwd)) {
     	$error .= "You must have at least one UPPERCASE letter in your password.<br />";
     }
     if(!preg_match("#\W+#", $pwd)) {
     	$error .= "You must have at least one special character in your password.<br />";
     }
     if($error > '') {
          return($error);
     } else {
          return("Secure");
     }
}

function deleteFiles($dir)
{
     foreach(glob($dir . '/*') as $file) {
          if(is_file($file)) {
               unlink($file);
        }
    }
}
?>