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

function getAddin($data)
{
     $exp1 = explode("-", $data);
     $addin = $exp1[1];
     $addin = substr($addin, 0, strpos($addin, "]"));
     $key = get_string_between($data, "]", "[");
     return($addin .','.$key);
}

function get_string_between($string, $start, $end){
     $string = ' ' . $string;
     $ini = strpos($string, $start);
     if ($ini == 0) return '';
     $ini += strlen($start);
     $len = strpos($string, $end, $ini) - $ini;
     return substr($string, $ini, $len);
}
?>