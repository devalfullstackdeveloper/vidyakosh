<?php
include_once "../config.php";
$row = $GLOBALS['db']->Execute("select * from content where lessons_ID='".$_SESSION["coursePK"]."' and identifierref='".trim($_GET["uri"])."'");
header("Location: http://".CLOUD_DOMAIN."/project/public/storage/uploads/scrom/".$_SESSION["coursecoderesolver"]."/".$_GET["courseID"]."/".$_GET["uri"].$row->fields["params"]);
?>