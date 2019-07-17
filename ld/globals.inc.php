<?php
// error log info
error_reporting(E_ALL);
ini_set("log_errors" , "1");
ini_set("error_log" , $_SERVER['DOCUMENT_ROOT'] ."/err/error_log.txt");
ini_set("display_errors" , "1");

// set timezone
date_default_timezone_set('America/Chicago');

$gsql = $db->query("SELECT * FROM tbl_globals WHERE id = 1");
$gbl = $gsql->fetch(PDO::FETCH_ASSOC);
$_SESSION['doc_root'] = $gbl['doc_root'];
$_SESSION['site_url'] = $gbl['site_url'];

// Site functions
function formatPhone($phone)
{
     if(!isset($phone{3})) { return ''; } 
     $phone = preg_replace("/[^0-9]/", "", $phone);
     $length = strlen($phone);
     switch($length) {
          case 7:
               return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
               break;
          case 10:
               return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
               break;
          case 11:
               return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1($2) $3-$4", $phone);
               break;
          default:
               return $phone;
               break;
     }
}

function selectStates($curr)
{
     $us_state_abbrevs_names = array(
     	'AL'=>'ALABAMA',
     	'AK'=>'ALASKA',
     	'AS'=>'AMERICAN SAMOA',
     	'AZ'=>'ARIZONA',
     	'AR'=>'ARKANSAS',
     	'CA'=>'CALIFORNIA',
     	'CO'=>'COLORADO',
     	'CT'=>'CONNECTICUT',
     	'DE'=>'DELAWARE',
     	'DC'=>'DISTRICT OF COLUMBIA',
     	'FM'=>'FEDERATED STATES OF MICRONESIA',
     	'FL'=>'FLORIDA',
     	'GA'=>'GEORGIA',
     	'GU'=>'GUAM GU',
     	'HI'=>'HAWAII',
     	'ID'=>'IDAHO',
     	'IL'=>'ILLINOIS',
     	'IN'=>'INDIANA',
     	'IA'=>'IOWA',
     	'KS'=>'KANSAS',
     	'KY'=>'KENTUCKY',
     	'LA'=>'LOUISIANA',
     	'ME'=>'MAINE',
     	'MH'=>'MARSHALL ISLANDS',
     	'MD'=>'MARYLAND',
     	'MA'=>'MASSACHUSETTS',
     	'MI'=>'MICHIGAN',
     	'MN'=>'MINNESOTA',
     	'MS'=>'MISSISSIPPI',
     	'MO'=>'MISSOURI',
     	'MT'=>'MONTANA',
     	'NE'=>'NEBRASKA',
     	'NV'=>'NEVADA',
     	'NH'=>'NEW HAMPSHIRE',
     	'NJ'=>'NEW JERSEY',
     	'NM'=>'NEW MEXICO',
     	'NY'=>'NEW YORK',
     	'NC'=>'NORTH CAROLINA',
     	'ND'=>'NORTH DAKOTA',
     	'MP'=>'NORTHERN MARIANA ISLANDS',
     	'OH'=>'OHIO',
     	'OK'=>'OKLAHOMA',
     	'OR'=>'OREGON',
     	'PW'=>'PALAU',
     	'PA'=>'PENNSYLVANIA',
     	'PR'=>'PUERTO RICO',
     	'RI'=>'RHODE ISLAND',
     	'SC'=>'SOUTH CAROLINA',
     	'SD'=>'SOUTH DAKOTA',
     	'TN'=>'TENNESSEE',
     	'TX'=>'TEXAS',
     	'UT'=>'UTAH',
     	'VT'=>'VERMONT',
     	'VI'=>'VIRGIN ISLANDS',
     	'VA'=>'VIRGINIA',
     	'WA'=>'WASHINGTON',
     	'WV'=>'WEST VIRGINIA',
     	'WI'=>'WISCONSIN',
     	'WY'=>'WYOMING',
     	'AE'=>'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
     	'AA'=>'ARMED FORCES AMERICA (EXCEPT CANADA)',
     	'AP'=>'ARMED FORCES PACIFIC'
     );
     foreach($us_state_abbrevs_names AS $abv => $name) {
          if($abv == $curr) {
               echo '<option selected="selected" value="'. $abv.'">'. ucwords(strtolower($name)) .'</option>'."\n";
          } else {
               echo '<option value="'. $abv.'">'. ucwords(strtolower($name)) .'</option>'."\n";
          }
     }     
}

function selectStatesFull($curr)
{
     $us_state_abbrevs_names = array(
     	'AL'=>'ALABAMA',
     	'AK'=>'ALASKA',
     	'AS'=>'AMERICAN SAMOA',
     	'AZ'=>'ARIZONA',
     	'AR'=>'ARKANSAS',
     	'CA'=>'CALIFORNIA',
     	'CO'=>'COLORADO',
     	'CT'=>'CONNECTICUT',
     	'DE'=>'DELAWARE',
     	'DC'=>'DISTRICT OF COLUMBIA',
     	'FM'=>'FEDERATED STATES OF MICRONESIA',
     	'FL'=>'FLORIDA',
     	'GA'=>'GEORGIA',
     	'GU'=>'GUAM GU',
     	'HI'=>'HAWAII',
     	'ID'=>'IDAHO',
     	'IL'=>'ILLINOIS',
     	'IN'=>'INDIANA',
     	'IA'=>'IOWA',
     	'KS'=>'KANSAS',
     	'KY'=>'KENTUCKY',
     	'LA'=>'LOUISIANA',
     	'ME'=>'MAINE',
     	'MH'=>'MARSHALL ISLANDS',
     	'MD'=>'MARYLAND',
     	'MA'=>'MASSACHUSETTS',
     	'MI'=>'MICHIGAN',
     	'MN'=>'MINNESOTA',
     	'MS'=>'MISSISSIPPI',
     	'MO'=>'MISSOURI',
     	'MT'=>'MONTANA',
     	'NE'=>'NEBRASKA',
     	'NV'=>'NEVADA',
     	'NH'=>'NEW HAMPSHIRE',
     	'NJ'=>'NEW JERSEY',
     	'NM'=>'NEW MEXICO',
     	'NY'=>'NEW YORK',
     	'NC'=>'NORTH CAROLINA',
     	'ND'=>'NORTH DAKOTA',
     	'MP'=>'NORTHERN MARIANA ISLANDS',
     	'OH'=>'OHIO',
     	'OK'=>'OKLAHOMA',
     	'OR'=>'OREGON',
     	'PW'=>'PALAU',
     	'PA'=>'PENNSYLVANIA',
     	'PR'=>'PUERTO RICO',
     	'RI'=>'RHODE ISLAND',
     	'SC'=>'SOUTH CAROLINA',
     	'SD'=>'SOUTH DAKOTA',
     	'TN'=>'TENNESSEE',
     	'TX'=>'TEXAS',
     	'UT'=>'UTAH',
     	'VT'=>'VERMONT',
     	'VI'=>'VIRGIN ISLANDS',
     	'VA'=>'VIRGINIA',
     	'WA'=>'WASHINGTON',
     	'WV'=>'WEST VIRGINIA',
     	'WI'=>'WISCONSIN',
     	'WY'=>'WYOMING',
     	'AE'=>'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
     	'AA'=>'ARMED FORCES AMERICA (EXCEPT CANADA)',
     	'AP'=>'ARMED FORCES PACIFIC'
     );
     foreach($us_state_abbrevs_names AS $abv => $name) {
          $name = ucwords(strtolower($name));
          if($name == $curr) {
               echo '<option selected="selected" value="'. $name.'">'. $name .'</option>'."\n";
          } else {
               echo '<option value="'. $name.'">'. $name .'</option>'."\n";
          }
     }     
}

function getRealIpAddr()
{
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ip = $_SERVER['HTTP_CLIENT_IP'];
     }
     elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
     } else {
          $ip = $_SERVER['REMOTE_ADDR'];
     }
     return $ip;
}

function checkPassword($pwd)
{
     $error = '';
     if(strlen($pwd) < 8) {
          $error = "TooShort";
     }
     if(preg_match("/\\s/", $pwd)) {
          $error = "NotSecure";
     }
     if(!preg_match("#[0-9]+#", $pwd)) {
     	$error = "NotSecure";
     }
     if(!preg_match("#[a-z]+#", $pwd)) {
     	$error = "NotSecure";
     }
     if(!preg_match("#[A-Z]+#", $pwd)) {
     	$error = "NotSecure";
     }
     if(!preg_match("#\W+#", $pwd)) {
     	$error = "NotSecure";
     }
     if($error > '') {
          return($error);
     } else {
          return("Secure");
     }
}

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}
?>