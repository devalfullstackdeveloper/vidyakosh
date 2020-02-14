<?php
error_reporting(E_ERROR);
session_start();
include_once "Urlcrypt.php";
$id=Urlcrypt::decode($_GET["h"]);
$course_id=Urlcrypt::decode($_GET["g"]);
$course_license_id=Urlcrypt::decode($_GET["f"]);
$user_db=Urlcrypt::decode($_GET["a"]);
$user_db_host=Urlcrypt::decode($_GET["b"]);
$user_db_user=Urlcrypt::decode($_GET["c"]);
$user_db_pass=Urlcrypt::decode($_GET["d"]);
$user_db_port=Urlcrypt::decode($_GET["e"]);
$_SESSION["sessionpurge"]=true;
$_SESSION["sessionpurgeid"]=$id;
mysql_connect($user_db_host, $user_db_user, $user_db_pass);
$dbName = $user_db;
mysql_select_db($dbName);
$result_t = mysql_query("SHOW TABLES");
while($row = mysql_fetch_assoc($result_t))
{
   mysql_query("TRUNCATE " . $row['Tables_in_' . $dbName]);
}

header("Location: http://192.168.1.17/dashboards/application/courses.php");
?>