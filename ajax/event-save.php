<?php
include_once "../config.php";
$validate->VALIDATE();


if(trim($_REQUEST["from"])!="" && trim($_REQUEST["to"]) !='' && trim($_REQUEST["subject"])!=''  && trim($_REQUEST["description"]) !='' && trim($_REQUEST["id"]) !='' ){
	$records = array();
	$records["eventfrom"]=$utility->SANITIZE_STRING($_REQUEST["from"]);
	$records["eventto"]=$utility->SANITIZE_STRING($_REQUEST["to"]);
	$records["eventsubject"]=$utility->SANITIZE_STRING($_REQUEST["subject"]);
	$records["eventdescription"]=$utility->SANITIZE_STRING($_REQUEST["description"]);    
    ActiveupdateTableData('tblevents', $records, "id='" . $_REQUEST["id"] . "'");
	echo "Event Saved!";
}else{
    echo "Please Enter All Required Fields!";
}
	?>
