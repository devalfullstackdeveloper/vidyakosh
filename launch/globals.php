<?php
include_once "../config.php";
$course->GET_COURSE_OR_LESSON_BY_ID(trim($_GET["cid"]),trim($_GET["type"]));
if ($course->id=="")
{
echo "Invalid Course ID";
exit();
}

if ($user->GET_USER_NAME(trim($_GET["lid"]))=="")
{
echo "Invalid Learner ID";
exit();
}
$_SESSION['lic'] = $course->coursecode;
//mysql_select_db($dbName);
global $skinID;
global $isSetToLaunch;
global $isSetToStyleDialogs;
global $isSetToTerminate;
global $uiOrgs;
global $uiBack;
global $uiNext;
global $uiExit;
global $uiAbandon;
global $uiAbandonAll;
global $uiAbout;
global $uiPrint;
global $uiToolbar;
global $uiTree;
global $uiBlank;
global $uiMinimal;
global $playerTitle;
global $ajaxLogLevel;
global $domainID;
global $learnerID;
global $learnerName;
global $orgID;
global $itemID;
global $sessionID;
global $courseID;
global $itemID;
global $culture;
global $mode;
global $endPointCMIRun;
global $endPointSSRun;
global $endPointLCMS;
global $resourceResolverUrl;
global $viewInitUrl;
global $viewEndUrl;
global $viewRootUrl;
global $viewUnloaderUrl;
global $viewTimeOutUrl;
global $ajaxErrorUrl;
global $syncClientServer;
global $isBeforeUnloadPromptEnabled;
global $isTimeoutEnabled;
global $isDebugAjax;
global $isSetToLaunch;
global $skinDirID;
global $sessionMonitorUrl;
global $maxInactiveInterval;
global $context;
global $isAsyncAjax;
global $DEFAULT_ORGANIZATION;
global $DEFAULT_ORGANIZATION_TITLE;
global $SCHEMA_VERSION;
global $COURSE_PK;
$skinID="default";
$_SESSION["skinID"]=$skinID;
$isSetToLaunch="true";
$isSetToStyleDialogs="false";
$isSetToTerminate="false";
$uiOrgs="false";
$uiBack="true";
$uiNext="true";
$uiExit="true";
$uiAbandon="false";
$uiAbandonAll="false";
$uiAbout="false";
$uiPrint="false";
$uiToolbar="true";
$uiTree="false";
$uiBlank="false";
$uiMinimal="false";
$playerTitle=trim($course->course_id);
$ajaxLogLevel="NONE";
$domainID="DOMAIN_".trim($_SESSION["lic"]);
$learnerID=trim($_GET["lid"]);
$learnerName=$user->GET_USER_NAME(trim($_GET["lid"]));
$courseID=trim($course->course_id);
$coursePK=trim($_GET["cid"]);
$_SESSION["domainIDR"]=trim($_SESSION["lic"]);
$_SESSION["domainID"]=$domainID;
$_SESSION["learnerID"]=$learnerID;
$_SESSION["learnerName"]=$learnerName;
$_SESSION["courseID"]=$courseID;
$_SESSION["coursePK"]=$coursePK;
$_SESSION["coursecoderesolver"]=trim($_GET["cid"]);
$orgID="";
$itemID="";
$sessionID="ActiveCloudSession";
$_SESSION["sessionID"]=$sessionID;
$itemID="";
$culture="en-US";
$mode=trim($course->course_mode);
$_SESSION["mode"]=$mode;
$endPointCMIRun="http://".CLOUD_DOMAIN."/launch/services/cmi.php";
$endPointSSRun="http://".CLOUD_DOMAIN."/launch/services/sequencer.php";
$endPointLCMS="http://".CLOUD_DOMAIN."/project/public/storage/uploads/scrom/".$_SESSION["lic"]."/";
$resourceResolverUrl="http://".CLOUD_DOMAIN."/launch/ResourceResolver.php";
$viewInitUrl="init.php";
$viewEndUrl="end.php";
$viewRootUrl="root.php";
$viewUnloaderUrl="unloader.php";
$viewTimeOutUrl="timeout.php";
$ajaxErrorUrl="AjaxError.php";
$syncClientServer="differential";
$isBeforeUnloadPromptEnabled="false";
$isTimeoutEnabled="true";
$isDebugAjax="true";
$isSetToLaunch="true";
$skinDirID="skins";
$sessionMonitorUrl="session.html";
$maxInactiveInterval="1200";
$context="http://".CLOUD_DOMAIN."/launch/";
$isAsyncAjax="false";
?>