<?php
include_once "../config.php";
$validate->VALIDATE();
if($_REQUEST["method"]=="students")
{
$RS=$GLOBALS['db']->Execute("SELECT * FROM users where user_type='learner' and user_active='1' and user_name like '%".$_GET['name']."%'");
}

if($_REQUEST["method"]=="teachers")
{
$RS=$GLOBALS['db']->Execute("SELECT * FROM users where user_type='teacher' and user_active='1' and user_name like '%".$_GET['name']."%'");
}

	while (!$RS->EOF) {
      	$rows['id']=$RS->fields["user_uname"];
        $rows['text']=$RS->fields["user_name"];
        $rows2[]=$rows;
		$RS->MoveNext();

    }
    print json_encode($rows2);