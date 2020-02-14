<?php
include_once "../config.php";
$validate->VALIDATE();
$GLOBALS['db']->Execute("delete FROM tblevents where  id='".$_POST["id"]."'");

?>