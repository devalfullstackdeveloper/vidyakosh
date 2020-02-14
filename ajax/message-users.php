<?php
include_once "../config.php";
$validate->VALIDATE();
if ($_GET['method']=="admin")
{
$RS=$GLOBALS['db']->Execute("SELECT * FROM users where user_name like '%".$_GET['name']."%' or user_uname like '%".$_GET['name']."%'");

	while (!$RS->EOF) {
      	$rows['id']="single_".$RS->fields["user_uname"];
        $rows['text']=$RS->fields["user_name"];
        $rows2[]=$rows;
		$RS->MoveNext();

    }
	
$RS_COURSE=$GLOBALS['db']->Execute("SELECT * FROM courses where course_id like '%".$_GET['name']."%'");

	while (!$RS_COURSE->EOF) {
      	$rows3['id']="course_".$RS_COURSE->fields["coursecode"];
        $rows3['text']=$RS_COURSE->fields["course_id"]." : Students";
        $rows2[]=$rows3;
		$RS_COURSE->MoveNext();

    }
$RS_TEACHER=$GLOBALS['db']->Execute("SELECT * FROM users where user_type='teacher' and user_name like '%".$_GET['name']."%' or user_uname like '%".$_GET['name']."%'");

	while (!$RS_TEACHER->EOF) {
      	$rows4['id']="teacher_".$RS_TEACHER->fields["user_uname"];
        $rows4['text']=$RS_TEACHER->fields["user_name"]." : Students";
        $rows2[]=$rows4;
		$RS_TEACHER->MoveNext();

    }
	
}
    
	if ($_GET['method']=="learner")
{
$RS=$GLOBALS['db']->Execute("SELECT * FROM users where user_type='admin' and user_name like '%".$_GET['name']."%' or user_uname like '%".$_GET['name']."%'");

	while (!$RS->EOF) {
      	$rows['id']="single_".$RS->fields["user_uname"];
        $rows['text']=$RS->fields["user_name"];
        $rows2[]=$rows;
		$RS->MoveNext();

    }
	
 
	
}
	if ($_GET['method']=="teacher")
{
$RS=$GLOBALS['db']->Execute("SELECT * FROM users where user_name like '%".$_GET['name']."%' or user_uname like '%".$_GET['name']."%'");

	while (!$RS->EOF) {
      	$rows['id']="single_".$RS->fields["user_uname"];
        $rows['text']=$RS->fields["user_name"];
        $rows2[]=$rows;
		$RS->MoveNext();

    }
	
 
	
}
	print json_encode($rows2);