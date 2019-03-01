<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}

// error log info
ini_set("log_errors" , "1");
ini_set("error_log" , $_SERVER['DOCUMENT_ROOT'] ."/err/error_log.txt");
ini_set("display_errors" , "1");

include '../ld/db.inc.php';
include '../ld/globals.inc.php';

if(isset($_POST['gfimport'])) {
     $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
     $res = $thm->fetch(PDO::FETCH_ASSOC);     
     $db->exec("UPDATE tbl_style SET `googlefontimport` = '$_POST[googlefontimport]' WHERE `style_name` = '$res[theme]'");
     echo 'Font Updated';
}

if(isset($_POST['field'])) {
     switch($_POST['field']) {
          case 'sitename':
               $sql = "UPDATE tbl_globals SET `site_name` = '$_POST[value]' WHERE id = 1";
               $resp = "Site Name Updated";
               break;
          case 'address':
               $sql = "UPDATE tbl_globals SET `address` = '$_POST[value]' WHERE id = 1";
               $resp = "Address Updated";
               break;
          case 'city':
               $sql = "UPDATE tbl_globals SET `city` = '$_POST[value]' WHERE id = 1";
               $resp = "City Updated";
               break;
          case 'state':
               $sql = "UPDATE tbl_globals SET `state` = '$_POST[value]' WHERE id = 1";
               $resp = "State Updated";
               break;
          case 'zipcode':
               $sql = "UPDATE tbl_globals SET `zip_code` = '$_POST[value]' WHERE id = 1";
               $resp = "Zipcode Updated";
               break;
          case 'phone':
               $phone = preg_replace("/[^0-9]/", "", $_POST['value']);
               $sql = "UPDATE tbl_globals SET `phone` = '$phone' WHERE id = 1";
               $resp = "Phone Number Updated";
               break;
          case 'email':
               $sql = "UPDATE tbl_globals SET `email_address` = '$_POST[value]' WHERE id = 1";
               $resp = "Email Address Updated";
               break;
          case 'emailtext':
               $sql = "UPDATE tbl_globals SET `email_text` = '$_POST[value]' WHERE id = 1";
               $resp = "Email Text Updated";
               break;
          case 'embeddedmap':
               $sql = "UPDATE tbl_globals SET `location_map` = ". $db->quote($_POST['value']) ." WHERE id = 1";
               $resp = "Map Code Updated";
               break;
          case 'mmode':
               $sql = "UPDATE tbl_globals SET `maintenance_mode` = '$_POST[value]' WHERE id = 1";
               $resp = "Maintenance Mode Updated.  You will not see changes until you log out.";
               break;
          case 'ssl':
               $sql = "UPDATE tbl_globals SET `ssl` = '$_POST[value]' WHERE id = 1";
               $resp = "SSL Updated.  You will need to close and reopen your browser for changes to take effect";
               break;
          case 'docroot':
               $sql = "UPDATE tbl_globals SET `doc_root` = '$_POST[value]' WHERE id = 1";
               $resp = "Document Root changed.  You may have just broke your website.  If you cannot load the site after closing and reopening your browser, contact the Admistrator!";
               break;
          case 'plugin':
               $plgin = explode(",", $_POST['value']);
               $pid = $plgin[0];
               $pval = $plgin[1];
               $sql = "UPDATE tbl_plugins SET `plugin_status` = $pval WHERE pl_id = $pid";
               $resp = "Updated";
               break;
          case 'ganal':
               $sql = "UPDATE tbl_seo SET `google_analytics` = '$_POST[value]' WHERE s_id = 1";
               $resp = "Google Analytics Site Code updated.";
               break;
          case 'ganalapi':
               $sql = "UPDATE tbl_seo SET `google_id` = '$_POST[value]' WHERE s_id = 1";
               $resp = "Google API Code updated.";
               break;
          case 'banal':
               $sql = "UPDATE tbl_seo SET `bing_analytics` = '$_POST[value]' WHERE s_id = 1";
               $resp = "Bing Analytics Site Code updated.";
               break;
          case 'banalapi':
               $sql = "UPDATE tbl_seo SET `bing_id` = '$_POST[value]' WHERE s_id = 1";
               $resp = "Bing API Code updated.";
               break;
          case 'yanal':
               $sql = "UPDATE tbl_seo SET `yahoo_analytics` = '$_POST[value]' WHERE s_id = 1";
               $resp = "Yahoo Analytics Site Code updated.";
               break;
          case 'panal':
               $sql = "UPDATE tbl_seo SET `piwik_id` = '$_POST[value]' WHERE s_id = 1";
               $resp = "Piwik ID Code updated.";
               break;               
          case 'yanalapi':
               $sql = "UPDATE tbl_seo SET `yahoo_id` = '$_POST[value]' WHERE s_id = 1";
               $resp = "Yahoo API Code updated.";
               break;
          case 'apisel':
               $sql = "UPDATE tbl_seo SET `api_selected` = '$_POST[value]' WHERE s_id = 1";
               $resp = "Chosen API framework changed.";
               break;
          case 'keywords':
               $sql = "UPDATE tbl_globals SET `keywords` = ". $db->quote($_POST['value']) ." WHERE id = 1";
               $resp = "Keywords Updated.";
               break;
          case 'description':
               $sql = "UPDATE tbl_globals SET `meta_description` = ". $db->quote($_POST['value']) ." WHERE id = 1";
               $resp = "Description Updated.  You will need to log out and back in again to see this change.";
               break;
          case 'alogo':
               $db->exec("UPDATE tbl_logos SET `logo_status` = 0 WHERE logo_status = 1");
               $db->exec("UPDATE tbl_logos SET `logo_status` = 1 WHERE l_id = '$_POST[value]'");
               $resp = "Selected Logo is now the active logo.  You will need to log out to see the change.";
               break;
          case 'logotext':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);          
               $sql = "UPDATE tbl_style SET `logotext` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Logo/Text option changed successfully";
               break;
          case 'headingtext':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);          
               $sql = "UPDATE tbl_style SET `headingtext` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Heading Text Updated.  Be sure to select the 'Use Text and Not Logo' option for this to work.";
               break;               
          case 'slogan':
               $sql = "UPDATE tbl_globals SET `site_slogan` = ". $db->quote($_POST['value']) ." WHERE id = 1";
               $resp = "Slogan Updated.  To change style-related features, check out the Styles section below.";
               break;
          case 'share_links':
               $sql = "UPDATE tbl_globals SET social_sites = '$_POST[value]' WHERE id = 1";
               $resp = "Sharing Links Settings changed.";
               break;
          case 'barurl':
               $exp = explode(",", $_POST['value']);
               $row = $exp[0];
               $val = $exp[1];
               $sql = "UPDATE tbl_social_sites SET `social_url` = '$val' WHERE s_id = '$row'";
               $resp = "URL Updated";
               break;
          case 'bartext':
               $exp = explode(",", $_POST['value']);
               $row = $exp[0];
               $val = $db->quote($exp[1]);
               $sql = "UPDATE tbl_social_sites SET `social_text` = $val WHERE `s_id` = '$row'";
               $resp = "Text Updated";
               break;
          case 'baricon':
               $exp = explode(",", $_POST['value']);
               $row = $exp[0];
               $val = $exp[1];
               $sql = "UPDATE tbl_social_sites SET `social_icon` = '$val' WHERE s_id = '$row'";
               $resp = "Icon Updated";
               break;
          case 'barstatus':
               $exp = explode(",", $_POST['value']);
               $row = $exp[0];
               $val = $exp[1];
               $sql = "UPDATE tbl_social_sites SET `social_status` = '$val' WHERE s_id = '$row'";
               $resp = "Status Updated";
               break;
          case 'barloc':
               $sql = "UPDATE tbl_globals SET `social_bar_location` = '$_POST[value]' WHERE id = 1";
               $resp = "Location Updated.  You will also need to modify the Footer that you'd like the bar to be display (if you selected 'Bottom')";
               break;
          case 'lfootertype':
               $sql = "UPDATE tbl_footer SET `left_footer_type` = '$_POST[value]' WHERE f_id = 1";
               $resp = "Footer Type Updated.  Be sure to modify the Right Footer so you don't have repeated data.";
               break;               
          case 'lfootercontent':
               $sql = "UPDATE tbl_footer SET `left_footer_content` = ". $db->quote($_POST['value']) ." WHERE f_id = 1";
               $resp = "Content Updated";
               break;
          case 'cfootertype':
               $sql = "UPDATE tbl_footer SET `center_footer_type` = '$_POST[value]' WHERE f_id = 1";
               $resp = "Footer Type Updated.  Be sure to modify the other footer zones so you don't have repeated data.";
               break;               
          case 'cfootercontent':
               $sql = "UPDATE tbl_footer SET `center_footer_content` = ". $db->quote($_POST['value']) ." WHERE f_id = 1";
               $resp = "Content Updated";
               break;               
          case 'rfootertype':
               $sql = "UPDATE tbl_footer SET `right_footer_type` = '$_POST[value]' WHERE f_id = 1";
               $resp = "Footer Type Updated.  Be sure to modify the Left Footer so you don't have repeated data.";
               break;               
          case 'rfootercontent':
               $sql = "UPDATE tbl_footer SET `right_footer_content` = ". $db->quote($_POST['value']) ." WHERE f_id = 1";
               $resp = "Content Updated";
               break;
          case 'theme':
               if($_POST['value'] == 'NEW_THEME') {
                    $tfolder = strtolower(str_replace(" ", "-", $_POST['value']));
                    mkdir('../css/themes/'. $tfolder);
                    mkdir('../css/themes/'. $tfolder .'/images/');
                    $newcss = fopen("../css/themes/". $tfolder ."/themestyle.css", "w");
                    $firstline = "/*Add your CSS data below*/";
                    fwrite($newcss, $firstline);
                    $sql = "INSERT INTO tbl_themes (theme_name, theme_folder) VALUES ('$_POST[value]', '$tfolder')";
                    $db->query("INSERT INTO tbl_style (style_name) VALUE ('$tfolder')");
                    echo 'New Theme created.  Change the theme\'s name to something more friendly before continuing';
               } else {
                    $sql = "UPDATE tbl_globals SET `theme` = '$_POST[value]' WHERE id = 1";
                    unset($gbl['theme']);
                    $gbl['theme'] = $_POST['value'];
                    $resp = "Theme Changed to $_POST[value] successfully (reload page to see theme change).";
               }
               break;
          case 'themename':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $oldfld = '../css/themes/'. $res['theme'];
               $newfld = '../css/themes/'. strtolower(str_replace(" ", "-", $_POST['value']));
               rename($oldfld, $newfld);          
               $newname = strtolower(str_replace(" ", "-", $_POST['value']));
               $sql = "UPDATE tbl_style S1, tbl_globals G1, tbl_themes T1 SET S1.style_name = '$newname', G1.theme = '$newname', T1.theme_folder = '$newname', T1.theme_name = '$_POST[value]' WHERE S1.style_name = '$res[theme]' AND G1.id = 1 AND T1.theme_folder = '$res[theme]'";
               echo 'Theme Name updated';
               break;
          case 'widthtype':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `widthtype` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'sitewidth':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `sitewidth` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'carouselheight':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `carouselheight` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'carouselwidth':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `carouselwidth` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'bcolorimage':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               if($_POST['value'] == 1) {
                    $sql = "UPDATE tbl_style SET `backgroundcolorshow` = 1, `backgroundimageshow` = 0 WHERE `style_name` = '$res[theme]'";
               }
               if($_POST['value'] == 2) {
                    $sql = "UPDATE tbl_style SET `backgroundcolorshow` = 0, `backgroundimageshow` = 1 WHERE `style_name` = '$res[theme]'";                    
               }
               $resp = "Updated";
               break;                
          case 'backgroundcolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `backgroundcolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'backgroundimage':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `backgroundimage` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'hcolorimage':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               if($_POST['value'] == 1) {
                    $sql = "UPDATE tbl_style SET `headbackgroundcolorshow` = 1, `headbackgroundimageshow` = 0 WHERE `style_name` = '$res[theme]'";
               }
               if($_POST['value'] == 2) {
                    $sql = "UPDATE tbl_style SET `headbackgroundcolorshow` = 0, `headbackgroundimageshow` = 1 WHERE `style_name` = '$res[theme]'";                    
               }
               $resp = "Updated";
               break; 
          case 'headbackgroundcolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `headbackgroundcolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'headbackgroundimage':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `headbackgroundimage` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'rcolorimage':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               if($_POST['value'] == 1) {
                    $sql = "UPDATE tbl_style SET `rowheadcolorshow` = 1, `rowheadimageshow` = 0 WHERE `style_name` = '$res[theme]'";
               }
               if($_POST['value'] == 2) {
                    $sql = "UPDATE tbl_style SET `rowheadcolorshow` = 0, `rowheadimageshow` = 1 WHERE `style_name` = '$res[theme]'";                    
               }
               $resp = "Updated";
               break;                
          case 'rowheadcolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `rowheadcolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'rowheadimage':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `rowheadimage` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'blcolorimage':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               if($_POST['value'] == 1) {
                    $sql = "UPDATE tbl_style SET `blcolorshow` = 1, `blimageshow` = 0 WHERE `style_name` = '$res[theme]'";
               }
               if($_POST['value'] == 2) {
                    $sql = "UPDATE tbl_style SET `blcolorshow` = 0, `blimageshow` = 1 WHERE `style_name` = '$res[theme]'";                    
               }
               $resp = "Updated";
               break;
          case 'blcolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `blcolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'blimage':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `blimage` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'menucolorimage':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               if($_POST['value'] == 1) {
                    $sql = "UPDATE tbl_style SET `menucolorshow` = 1, `menuimageshow` = 0 WHERE `style_name` = '$res[theme]'";
               }
               if($_POST['value'] == 2) {
                    $sql = "UPDATE tbl_style SET `menucolorshow` = 0, `menuimageshow` = 1 WHERE `style_name` = '$res[theme]'";                    
               }
               $resp = "Updated";
               break;          
          case 'menuimage':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `menuimage` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;          
          case 'menucolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `menucolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;          
          case 'fcolorimage':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               if($_POST['value'] == 1) {
                    $sql = "UPDATE tbl_style SET `footercolorshow` = 1, `footerimageshow` = 0 WHERE `style_name` = '$res[theme]'";
               }
               if($_POST['value'] == 2) {
                    $sql = "UPDATE tbl_style SET `footercolorshow` = 0, `footerimageshow` = 1 WHERE `style_name` = '$res[theme]'";                    
               }
               $resp = "Updated";
               break;                
          case 'footercolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `footercolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'footerimage':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `footerimage` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'breadcrumbbartrans':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);               
               if($_POST['value'] == 1) {
                    $sql = "UPDATE tbl_style SET `breadcrumbbartrans` = 1 WHERE `style_name` = '$res[theme]'";                    
               }
               if($_POST['value'] == 0) {
                    $sql = "UPDATE tbl_style SET `breadcrumbbartrans` = 0 WHERE `style_name` = '$res[theme]'";                    
               }
               $resp = 'Updated';
               break;
          case 'breadcrumbbarcolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `breadcrumbbarcolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'breadcrumbbarfontcolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `breadcrumbbarfontcolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;          
          case 'googlefontimport':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `googlefontimport` = ". $db->quote($_POST['value']) ." WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'defaultfont':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `defaultfont` = ". $db->quote($_POST['value']) ." WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'h1font':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `h1font` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'h2font':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `h2font` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'h3font':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `h3font` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'h4font':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `h4font` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "H4 Font Updated";
               break;
          case 'primaryfontcolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `primaryfontcolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Primary Font Color Updated";
               break;
          case 'headingfontcolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `headingfontcolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Heading Font Color Updated";
               break;
          case 'footerfontcolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `footerfontcolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Footer Font Color Updated";
               break;
          case 'menufontcolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `menufontcolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Menu Font Color Updated";
               break;                                                                            
          case 'headerheight':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `headerheight` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'footerheight':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `footerheight` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Updated";
               break;
          case 'grid1width':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);          
               $sql = "UPDATE tbl_style SET `grid1width` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = 'Grid 1 Width updated';
               break;
          case 'grid2width':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);          
               $sql = "UPDATE tbl_style SET `grid2width` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = 'Grid 2 Width updated';
               break;
          case 'grid3width':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);          
               $sql = "UPDATE tbl_style SET `grid3width` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = 'Grid 3 Width updated';
               break;
          case 'htextstyle':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);          
               $sql = "UPDATE tbl_style SET `fonteffect` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = 'Heading Style Updated';
               break;
          case 'headingtextfontsize':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);          
               $sql = "UPDATE tbl_style SET `headingtextfontsize` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = 'Heading Font Size Updated';
               break;                         
          case 'sloganfontcolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `sloganfontcolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Slogan Font Color Updated";
               break;
          case 'rowheadfontcolor':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `rowheadfontcolor` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Row Head Font Color Updated";
               break;
          case 'menulocation':
               $thm = $db->query("SELECT `theme` FROM tbl_globals WHERE id = 1");
               $res = $thm->fetch(PDO::FETCH_ASSOC);
               $sql = "UPDATE tbl_style SET `menu_location` = '$_POST[value]' WHERE `style_name` = '$res[theme]'";
               $resp = "Menu Location changed";
               break;
          default:
               break;
     }
     if(isset($sql)) {
          $db->exec($sql);
     }
     echo $resp;
}

if(isset($_FILES['logo_image'])) {
     $error = $_FILES["logo_image"]["error"];
     echo $error;
     $output_dir = $gbl['doc_root'] .'/ast/site/';
     $filename = date('mjy_his');
     $ext = pathinfo($_FILES['logo_image']['name'], PATHINFO_EXTENSION);
     $extary = array('jpg', 'jpeg', 'png');
     if(!in_array($ext, $extary)) {
          echo 'This does not appear to be a valid jpg or png image file.  Try again';
          die;
     }
     $newfilename = $filename .'.'. $ext;
     if(move_uploaded_file($_FILES["logo_image"]["tmp_name"], $output_dir . $newfilename)) {
          $db->exec("INSERT INTO tbl_logos (logo_file, logo_status, logo_width, logo_height) VALUES ('$newfilename', 0, 390, 90)");
          echo 'Logo File Uploaded.  Click "Refresh"';
     } else {
          echo 'There was a problem uploading the new image file.';
          die;
     }
}

if(isset($_POST['reloadlogos'])) {
     $asql = $db->query("SELECT * FROM tbl_logos ORDER BY l_id");
     while($alg = $asql->fetch(PDO::FETCH_ASSOC)) {
          if($alg['logo_status'] == 1) {
               $style = ' style="border: 2px solid red;" ';
          } else {
               $style = ' ';
          }
          ?>
          <img<?php echo $style ?>onclick="submitForm('alogo', 3, <?php echo $alg['l_id'] ?>); document.getElementById('curlogo').src = '<?php echo $gbl['site_url'] ?>/ast/site/<?php echo $alg['logo_file'] ?>';" src="../ast/site/<?php echo $alg['logo_file'] ?>" width="<?php echo $alg['logo_width'] ?>" height="<?php echo $alg['logo_height'] ?>" />
     <?php
     if($alg['logo_status'] == 0) {
          ?>
          <button type="button" class="btn btn-warning" onclick="deleteLogo(<?php echo $alg['l_id'] ?>)"><i class="glyphicon glyphicon-delete"></i> Delete</button>
          <?php
     }
     ?><br /><br />
     <?php
     }     
}

if(isset($_POST['deletelogo'])) {
     $db->exec("DELETE FROM tbl_logos WHERE l_id = $_POST[logoid]");
}

if(isset($_POST['theme'])) {
     $sql = $db->query("SELECT * FROM tbl_style WHERE style_name = '$_POST[theme]'");
     $thmr = $sql->fetch(PDO::FETCH_ASSOC);
     ?>
     <div class="col-xs-3">
     <div class="well well-sm">
     <p class="help-block">General Theme Options</p>
     <b>Width Type</b><br />
     <input onchange="submitForm('widthtype', 8, this.value);" type="radio" name="widthtype" id="widthtype" value="container" <?php if($thmr['widthtype'] == 'container') { echo 'checked="checked"';} ?> /> Fixed Width (set width below)<br />
     <input onchange="submitForm('widthtype', 8, this.value);" type="radio" name="widthtype" id="widthtype" value="container-fluid" <?php if($thmr['widthtype'] == 'container-fluid') { echo 'checked="checked"';} ?> /> Fluid Width<br /><br />
     
     <b>Site Width (if Fixed)</b><br />
     <input onchange="submitForm('sitewidth', 8, this.value);" type="number" min="100" max="1500" name="sitewidth" id="sitewidth" value="<?php echo $thmr['sitewidth'] ?>" class="form-control" /><br /><br />
     
     <b>Carousel Height</b><br />
     <input onchange="submitForm('carouselheight', 8, this.value);" type="number" min="100" max="1500" name="carouselheight" id="carouselheight" value="<?php echo $thmr['carouselheight'] ?>" class="form-control" /><br />
     <b>Carousel Width</b><br />
     <input onchange="submitForm('carouselwidth', 8, this.value);" type="number" min="100" max="1500" name="carouselwidth" id="carouselwidth" value="<?php echo $thmr['carouselwidth'] ?>" class="form-control" />     
     <p class="help-block">The Carousel width should always be wider than the height.  Don't make it too wide or you'll have to produce specially-shot images to fill it.  Don't make it too high or your users won't see page content.  Default size is 800 W by 450 H.</p>
     <b>Site Background Color</b><br />
     <input onchange="submitForm('backgroundcolor', 8, this.value);" type="color" name="backgroundcolor" id="backgroundcolor" value="<?php echo $thmr['backgroundcolor'] ?>" class="form-control" /><br />
     <b>Background Overlay Image</b><br />
     <input onchange="submitForm('backgroundimage', 8, this.value);" type="text" name="backgroundimage" id="backgroundimage" value="<?php echo $thmr['backgroundimage'] ?>" class="form-control" />
     <p class="help-block">You will need to upload this image to the themes/<?php echo $thmr['style_name'] ?>/images folder using an FTP client.</p>
     </div>
     </div>
     
     <div class="col-xs-3">
     <div class="well well-sm">
     <p class="help-block">Feature Colors</p>
     <b>Row/Block Heading Color</b><br />
     <input onchange="submitForm('rowheadcolor', 8, this.value);" type="color" name="rowheadcolor" id="rowheadcolor" value="<?php echo $thmr['rowheadcolor'] ?>" class="form-control" /><br />
     <b>Row/Block Heading Overlay Image</b><br />
     <input onchange="submitForm('rowheadimage', 8, this.value);" type="text" name="rowheadimage" id="rowheadimage" value="<?php echo $thmr['rowheadimage'] ?>" class="form-control" />     
     <p class="help-block">You will need to upload this image to the themes/<?php echo $thmr['style_name'] ?>/images folder using an FTP client.</p>     
     <b>Footer Color</b><br />
     <input onchange="submitForm('footercolor', 8, this.value);" type="color" name="footercolor" id="footercolor" value="<?php echo $thmr['footercolor'] ?>" class="form-control" /><br />
     <b>Footer Overlay Image</b><br />
     <input onchange="submitForm('footerimage', 8, this.value);" type="text" name="footerimage" id="footerimage" value="<?php echo $thmr['footerimage'] ?>" class="form-control" />     
     <p class="help-block">You will need to upload this image to the themes/<?php echo $thmr['style_name'] ?>/images folder using an FTP client.</p>  
     </div>
     </div>
     
     <div class="col-xs-3">
     <div class="well well-sm">
     <div class="help-block">Site Fonts</div>
     <b>Google Fonts CSS Import String</b><br />
     <input onchange="submitForm('googlefontimport', 8, this.value);" type="text" name="googlefontimport" id="googlefontimport" value="<?php echo $thmr['googlefontimport'] ?>" class="form-control" />
     <p class="help-block">You can go to <a href="http://fonts.google.com" target="_blank">Google Fonts</a> and create a font library.  When finished, select the "Import" option, then copy and paste everything between the &lt;style&gt;&lt;/style&gt; tags into this field.  Doing this incorrectly could cause problems.</p>
     <b>Default Site Font</b><br />
     <input onchange="submitForm('defaultfont', 8, this.value);" type="text" name="defaultfont" id="defaultfont" value="<?php echo $thmr['defaultfont'] ?>" class="form-control" />
     <p class="help-block">From the same Google Fonts screen copy and paste the correct "font-family:" rule.  You only need to paste the font itself (everything after the ':'), and only ONE font family if you created more than one.</p>
     <b>Heading 1 Font</b><br />
     <input onchange="submitForm('h1font', 8, this.value);" type="text" name="h1font" id="h1font" value="<?php echo $thmr['h1font'] ?>" class="form-control" />
     <p class="help-block">Enter the full style class for Heading 1.  The property MUST be declared as follows: font-style, font-variant, font-weight, font-size/line-height, font-family;.  If you aren't sure how to do this, leave it blank and the global theme will manage this.</p>
     <b>Heading 2 Font</b><br />
     <input onchange="submitForm('h2font', 8, this.value);" type="text" name="h2font" id="h2font" value="<?php echo $thmr['h2font'] ?>" class="form-control" />
     <p class="help-block">Enter the full style class for Heading 2.  The property MUST be declared as follows: font-style, font-variant, font-weight, font-size/line-height, font-family;.  If you aren't sure how to do this, leave it blank and the global theme will manage this.</p>     
     <b>Heading 3 Font</b><br />
     <input onchange="submitForm('h3font', 8, this.value);" type="text" name="h3font" id="h3font" value="<?php echo $thmr['h3font'] ?>" class="form-control" />
     <p class="help-block">Enter the full style class for Heading 3.  The property MUST be declared as follows: font-style, font-variant, font-weight, font-size/line-height, font-family;.  If you aren't sure how to do this, leave it blank and the global theme will manage this.</p>
     <b>Heading 4 Font</b><br />
     <input onchange="submitForm('h4font', 8, this.value);" type="text" name="h4font" id="h4font" value="<?php echo $thmr['h4font'] ?>" class="form-control" />
     <p class="help-block">Enter the full style class for Heading 4.  The property MUST be declared as follows: font-style, font-variant, font-weight, font-size/line-height, font-family;.  If you aren't sure how to do this, leave it blank and the global theme will manage this.</p>     
     </div>
     </div>
     
     <div class="col-xs-3">
     <div class="well well-sm">
     <div class="help-block">Header/Footer Layout</div>
     <b>Header Height</b><br />
     <input onchange="submitForm('headerheight', 8, this.value);" type="text" name="headerheight" id="headerheight" value="<?php echo $thmr['headerheight'] ?>" class="form-control" />     
     <b>Footer Height</b><br />
     <input onchange="submitForm('footerheight', 8, this.value);" type="text" name="footerheight" id="footerheight" value="<?php echo $thmr['footerheight'] ?>" class="form-control" />
     <p class="help-block">Both the header and footer height is the MINIMUM height.  Don't set this too high!  The header should be about 1/4 the height of the footer or less.</p>     
     </div>
     </div>
     <?php
}

if(isset($_POST['addmenu'])) {
     $url = '';
     $menuname = str_replace(" ", "_", $_POST['menuname']);
     $sqlc = $db->query("SELECT menu_name FROM tbl_pages WHERE menu_name = '$_POST[menuname]'");
     if($sqlc->rowCount() > 0) {
          echo 'This Menu Name already exists on the site.  Please enter a different Menu Name';
          die;
     } else {
          $db->exec("INSERT INTO tbl_pages (`total_hits`, `menu_name`, `menu_status`, `menu_order`, `page_content`, `show_slider`, `page_title`, `menu_type`) VALUES (0, '$menuname', 0, 0, 'New Page', 0, '$menuname', 1)");
          echo 'Menu Added Successfully.';
     }
}

if(isset($_POST['menuurl'])) {
     $url = '';
     $sqlc = $db->query("SELECT menu_name FROM tbl_pages WHERE menu_name = '$_POST[menuname]'");
     if($sqlc->rowCount() > 0) {
          echo 'This Menu Name already exists on the site.  Please enter a different Menu Name';
          die;
     } else {
          $db->exec("INSERT INTO tbl_pages (`total_hits`, `menu_name`, `menu_status`, `menu_order`, `page_content`, `show_slider`, `page_title`, `menu_type`, `menu_url`, `menu_target`) VALUES (0, '$_POST[menuname]', 0, 0, 'New Page', 0, '$_POST[menuname]', 1, '$_POST[menuurl]', '$_POST[menutarget]')");
          echo 'Menu Added Successfully.';
     }
}

if(isset($_POST['updatemenu'])) {
     $records = $_POST['recordsArray'];
     $counter = 1;
     foreach($records AS $val) {
          $db->exec("UPDATE tbl_pages SET menu_order = '$counter' WHERE p_id = '$val'");
          $counter = $counter + 1;
     }
     echo 'Menu Order Updated';
}

if(isset($_POST['enablemenu'])) {
     if($_POST['value'] == 'false') {
          $val = 0;
     } else {
          $val = 1;
     }
     $db->exec("UPDATE tbl_pages SET `menu_status` = '$val', `parent_id` = 0 WHERE `p_id` = '$_POST[menuid]'");
     echo 'Menu Status Changed';
}

if(isset($_POST['deletemenu'])) {
     if($_POST['value'] != true) {
          die;
     }
     $db->exec("UPDATE tbl_pages SET `menu_name` = 'Deleted', `menu_status` = 9, `parent_id` = 0 WHERE `p_id` = '$_POST[menuid]'");
     echo 'Menu Deleted (Can be recovered by an Administrator).';
}

if(isset($_POST['makeadmin'])) {
     if($_POST['value'] != true) {
          die;
     }
     $db->exec("UPDATE tbl_pages SET `menu_status` = 3, `parent_id` = 18 WHERE `p_id` = '$_POST[menuid]'");
     echo 'Item added to the Administrative Menu';     
}

if(isset($_POST['tosubmenu'])) {
     if($_POST['parentid'] == 0) {
          $isparent = 0;
     } else {
          $isparent = 1;
     }
     $db->exec("UPDATE tbl_pages SET `parent_id` = '$_POST[parentid]', `is_parent` = '$isparent' WHERE p_id = $_POST[menuid]");
     echo 'Moved to Parent Menu. Refresh screen to see change.';
}

if(isset($_POST['makehomepage'])) {
     $db->exec("UPDATE tbl_globals SET `homepage` = '$_POST[value]' WHERE id = 1");
     $gbl['homepage'] = $_POST['value'];
     echo 'Homepage Changed to '. $_POST['value'];
}

if(isset($_POST['update_carousel'] )){
     $db->exec("UPDATE tbl_carousel_settings SET `interval` = '$_POST[interval]', `hover_pause` = '$_POST[pauseonhover]', `wrapping` = '$_POST[wrapping]', `width` = '$_POST[width]', `height` = '$_POST[height]', caption_animation = '$_POST[captionanimation]', button_animation = '$_POST[buttonanimation]', link_animation = '$_POST[linkanimation]' WHERE cs_id = 1");
     echo 'Settings Updated';
}

if(isset($_POST['update_slide'])) {
     $path = $gbl['doc_root'] .'ast/carousel/';
     $slideid = $_POST['slide_id'];     
     $continue = 0;
     if($_POST['status'] == 9) {
          $img = $db->query("SELECT car_image FROM tbl_carousel WHERE c_id = $slideid");
          $im = $img->fetch(PDO::FETCH_ASSOC);
          if($im['car_image'] > '') {
               unlink($path . $im['car_image']);
          }          
          $db->exec("DELETE FROM tbl_carousel WHERE c_id = $slideid");
          echo 'Slide Deleted';          
     }
      //Check to make sure the file type is correct
     if($_FILES['image']['name'][$slideid] > '') {
          $tempfile = $_FILES['image']['tmp_name'][$slideid];
          $imginfo_array = getimagesize($tempfile);
          if($imginfo_array !== false) {
               $mime_type = $imginfo_array['mime'];
               switch($mime_type) { 
                    case "image/jpeg":
                    case "image/png":
                         $continue = 1;
                         break;
                    default:
                         $continue = 0;
                         echo 'This is not a valid image file';
                         break;
               }
          }
          if($continue == 1) {
               $fileext = pathinfo($_FILES['image']['name'][$slideid], PATHINFO_EXTENSION);
               $filename = date('mdyhis') .'.'. $fileext;          
               $maxdm = $_POST['slidewidth'];
               list($width, $height, $type, $attr) = getimagesize($_FILES['image']['tmp_name'][$slideid]);
               if($width > $maxdm || $height > $maxdm ) {
                    $target_filename = $filename;
                    $fn = $_FILES['image']['tmp_name'][$slideid];
                    $size = getimagesize($fn);
                    $ratio = $size[0] / $size[1];
                    if($ratio > 1) {
                         $width = $maxdm;
                         $height = $maxdm / $ratio;
                    } else {
                         $width = $maxdm * $ratio;
                         $height = $maxdm;
                    }
                    $src = imagecreatefromstring(file_get_contents($fn));
                    $dst = imagecreatetruecolor($width, $height);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
                    imagedestroy($src);
                    imagepng($dst, $filename);
                    imagedestroy($dst);
               }                      
               //Rename the image file
               if(move_uploaded_file($_FILES['image']['tmp_name'][$slideid], $path . $filename)) {
                    unlink($filename);
                    // We need to unlink the old file to save room
                    $img = $db->query("SELECT car_image FROM tbl_carousel WHERE c_id = $slideid");
                    $im = $img->fetch(PDO::FETCH_ASSOC);
                    if($im['car_image'] > '') {
                         unlink($path . $im['car_image']);
                    }
                    // Now we update the database
                    $db->exec("UPDATE tbl_carousel SET car_order = '". $_POST['order'][$slideid] ."', car_image = '$filename', car_status = '". $_POST['status'][$slideid] ."', car_caption = '". $_POST['caption'][$slideid] ."', car_url = '". $_POST['url'][$slideid] ."', car_caption_size = '". $_POST['captionsize'][$slideid] ."' WHERE c_id = $slideid");
                    echo 'Slide Updated';
               }
          } else { 
               echo 'There was a problem with the file';
               die;
          }
     } else {
          $db->exec("UPDATE tbl_carousel SET car_order = $_POST[order], car_status = ". $_POST['status'] .", car_caption = '". $_POST['caption'] ."', car_url = '". $_POST['url'] ."', car_caption_size = '". $_POST['captionsize'] ."' WHERE c_id = $slideid");
          echo 'Slide Updated';
     }
}

if(isset($_POST['create_slide'])) {
     $db->exec("INSERT INTO tbl_carousel (car_status, car_caption, car_url, car_caption_size, car_order) VALUES ('$_POST[slide_status]', '$_POST[slide_caption]', '$_POST[slide_url]', '$_POST[caption_size]', 0)");
     echo 'Slide Created. Click OK to refresh.';
}

//funcion to save image file
function save_image_file($image_type, $canvas, $destination, $quality)
{
    switch(strtolower($image_type)) {
        case 'image/png':
            return imagepng($canvas, $destination); //save png file
        case 'image/jpeg': case 'image/pjpeg':
            return imagejpeg($canvas, $destination, $quality);  //save jpeg file
        default:
            return false;
    }
}

function get_upload_error($err_no)
{
    switch($err_no) {
        case 1 : return 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
        case 2 : return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
        case 3 : return 'The uploaded file was only partially uploaded.';
        case 4 : return 'No file was uploaded.';
        case 5 : return 'Missing a temporary folder. Introduced in PHP 5.0.3';
        case 6 : return 'Failed to write file to disk. Introduced in PHP 5.1.0';
    }
}
?>