<?php
include_once "../config.php";
$validate->VALIDATE();
if ($validate->user_type=="admin")
{
	$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where UNIX_TIMESTAMP(eventfrom) between ".$_REQUEST["start"]." and ".$_REQUEST["end"]."   order by id desc");
	
}else if($validate->user_type=="learner"){
	
	$RS=$GLOBALS['db']->Execute("SELECT tblevents.id, tblevents.eventfrom, tblevents.eventto, tblevents.numericid, tblevents.eventtype, tblevents.eventsubject, tblevents.eventdescription,  tblevents.courseid, enroll.learner_id FROM enroll INNER JOIN  tblevents ON enroll.course_id = tblevents.courseid  WHERE     (enroll.learner_id = '".$validate->user_uname."') AND (tblevents.numericid in (".$_SESSION["TeacherID"].")) ORDER BY tblevents.eventfrom DESC");
	
}else if($validate->user_type=="teacher"){
		$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where numericid='".$validate->user_uname."' AND eventtype = 'teacher' order by id desc limit 15");
}
 

	while (!$RS->EOF) {
      	$rows['id']=$RS->fields["id"];
        $rows['title']=$RS->fields["eventsubject"];
		 
		 $rows['start']=$RS->fields["eventfrom"];
		 
		  $rows['end']=$RS->fields["eventto"];
		   If ($RS->fields["eventtype"]=="admin")
		   {
			  $rows['backgroundColor']="red";
		   }
             If ($RS->fields["eventtype"]=="personal")
		   {
			  $rows['backgroundColor']="blue";
		   }
 If ($RS->fields["eventtype"]=="course")
		   {
			  $rows['backgroundColor']="orange";
		   }
		   
		    If ($RS->fields["eventtype"]=="teacher")
		   {
			  $rows['backgroundColor']="black";
		   }
         
        $rows2[]=$rows;
		$RS->MoveNext();

    }
	if($validate->user_type=="learner"){
	$RS_ADMIN=$GLOBALS['db']->Execute("SELECT * from tblevents where eventtype='admin' ORDER BY eventfrom DESC");
	while (!$RS_ADMIN->EOF) {
      	$rows['id']=$RS_ADMIN->fields["id"];
        $rows['title']=$RS_ADMIN->fields["eventsubject"];
		 
		 $rows['start']=$RS_ADMIN->fields["eventfrom"];
		 
		  $rows['end']=$RS_ADMIN->fields["eventto"];
		     $rows['backgroundColor']="red";
		   
         
        $rows2[]=$rows;
		$RS_ADMIN->MoveNext();

    }
	$RS_PERSONAL=$GLOBALS['db']->Execute("SELECT * from tblevents where numericid='".$validate->user_uname."' and eventtype='personal' ORDER BY eventfrom DESC");
	while (!$RS_PERSONAL->EOF) {
      	$rows['id']=$RS_PERSONAL->fields["id"];
        $rows['title']=$RS_PERSONAL->fields["eventsubject"];
		 
		 $rows['start']=$RS_PERSONAL->fields["eventfrom"];
		 
		  $rows['end']=$RS_PERSONAL->fields["eventto"];
		     $rows['backgroundColor']="blue";
		   
         
        $rows2[]=$rows;
		$RS_PERSONAL->MoveNext();

    }
	}
	if($validate->user_type=="teacher"){
	$RS_ADMIN=$GLOBALS['db']->Execute("SELECT * from tblevents where eventtype='admin' ORDER BY eventfrom DESC");
	while (!$RS_ADMIN->EOF) {
      	$rows['id']=$RS_ADMIN->fields["id"];
        $rows['title']=$RS_ADMIN->fields["eventsubject"];
		 
		 $rows['start']=$RS_ADMIN->fields["eventfrom"];
		 
		  $rows['end']=$RS_ADMIN->fields["eventto"];
		     $rows['backgroundColor']="red";
		   
         
        $rows2[]=$rows;
		$RS_ADMIN->MoveNext();

    }
	$RS_PERSONAL=$GLOBALS['db']->Execute("SELECT * from tblevents where numericid='".$validate->user_uname."'  and eventtype='personal' ORDER BY eventfrom DESC");
	while (!$RS_PERSONAL->EOF) {
      	$rows['id']=$RS_PERSONAL->fields["id"];
        $rows['title']=$RS_PERSONAL->fields["eventsubject"];
		 
		 $rows['start']=$RS_PERSONAL->fields["eventfrom"];
		 
		  $rows['end']=$RS_PERSONAL->fields["eventto"];
		     $rows['backgroundColor']="blue";
		   
         
        $rows2[]=$rows;
		$RS_PERSONAL->MoveNext();

    }
	}
    print json_encode($rows2);