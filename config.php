<?php
 session_start();
	if (ini_get('zlib.output_compression')){
		ob_start();
	}elseif (function_exists('ob_gzhandler')){
		ob_start('ob_gzhandler');
	}else{
		ob_start();
	}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// $cloud_servername = "localhost";
// $cloud_username = "root";
// $cloud_password = "";
// $cloud_dbname = "rad_lmsfreshlivedb";

// // Create connection
// $cloud_conn = new mysqli($cloud_servername, $cloud_username, $cloud_password, $cloud_dbname);
// // Check connection
// if ($cloud_conn->connect_error) {
//     die("Connection failed: " . $cloud_conn->connect_error);
// } 

// $cloud_sql = "select * from cloud where cloud_domain='".trim($_SERVER['HTTP_HOST'])."'";
// $cloud_result = $cloud_conn->query($cloud_sql);

// if ($cloud_result->num_rows > 0) {
//     // output data of each row
//     while($cloud_row = $cloud_result->fetch_assoc()) {
        
 
define('CLOUD_DOMAIN', 'companydemo.in/dev/vidyakosh/');
define('CLOUD_ID', 'localhost');
define('CLOUD_DB_HOST','localhost');
define('CLOUD_DB_USER','dev_vidyakosh');
define('CLOUD_DB_PASS','#adg@123#');
define('CLOUD_DB','dev_vidyakosh');

// define('APP_URL', trim($cloud_row["cloud_url"]));
// define('APP_HASH', trim($cloud_row["cloud_hash"]));		
// $_SESSION["lic"]=APP_HASH;	
//     }
// } else {
//     echo "0 results";
// }
// $cloud_conn->close();
define('APP_NAME',	'LMS');
define('APP_PATH',	realpath(dirname(__FILE__)));
define('LIVE_APP_PATH',	'http://companydemo.in/dev/vidyakosh/public');

define('ABS_PATH',realpath(dirname(__FILE__)).'/');
include APP_PATH."/database.php";
// include APP_PATH."/classes/Errors.php";
include APP_PATH."/classes/Users.php";
// include APP_PATH."/classes/Learners.php";
// include APP_PATH."/classes/Enroll.php";
// include APP_PATH."/classes/Utility.php";
// include APP_PATH."/classes/Validation.php";
include APP_PATH."/classes/Courses.php";
// include APP_PATH."/libs/Urlcrypt.php";
// $LOAD_SITE=$GLOBALS['db']->Execute("SELECT * FROM configuration where id='1'");
// define('SITE_EMAIL', trim($LOAD_SITE->fields[contact_email]));	
// define('SITE_TITLE', trim($LOAD_SITE->fields[contact_site_name]));	
// define('SITE_BACKGROUND', trim($LOAD_SITE->fields[contact_var2]));	
// define('SITE_CONTACT_NAME', trim($LOAD_SITE->fields[contact_full_name]));	
// define('SITE_CONTACT_ADDRESS', trim($LOAD_SITE->fields[contact_address]));	
// define('SITE_COLLABORATION', trim($LOAD_SITE->fields[contact_collaboration]));	
// define('SITE_CDN', trim($LOAD_SITE->fields[contact_var1]));	
// define('APP_NAME',	SITE_TITLE);
	
// $erros    = new Errors;
// $utility = new Utility();
$user = new Users();
// $validate= new Validation();
$course= new Courses();
// $uuid=new uuid();
// $enroll = new Enroll();
?>