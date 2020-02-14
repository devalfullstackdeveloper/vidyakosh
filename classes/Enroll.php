<?php

class Enroll

{
 
	
	
	public $id;
	public $course_id;
	public $learner_id;
 
	public $date_created;
	public $client_id;
 
 
	
	
	
	
	public function ENROLLMENT($cid,$data)
	{
	 
	foreach ($data as $id)
	{
 
	$CHECK_ENROLL = $GLOBALS['db']->Execute("select * from enroll where course_id='" . trim($cid) . "' and learner_id='" . $id . "'");
	if($CHECK_ENROLL->EOF)
	{
		$record=array();
		$record["course_id"]=$cid;
		$record["learner_id"]=$id;
		 
		ActiveinsertTableData("enroll",$record);
		 
		
	}
	
	 
	}
	 
	header("Location: enroll.php?cid=".$cid."&msg=M_10");	
	}
	public function ENROLLMENT_EMBED($cid,$id)
	{
	 
 
	$CHECK_ENROLL = $GLOBALS['db']->Execute("select * from enroll where course_id='" . trim($cid) . "' and learner_id='" . $id . "'");
	if($CHECK_ENROLL->EOF)
	{
		$record=array();
		$record["course_id"]=$cid;
		$record["learner_id"]=$id;
		 
		ActiveinsertTableData("enroll",$record);
		 
		
	 
	
	 
	}
	 
	 
	}
	public function UNENROLLMENT($cid,$data)
	{
	 
	foreach ($data as $id)
	{
 
	$CHECK_ENROLL = $GLOBALS['db']->Execute("select * from enroll where course_id='" . trim($cid) . "' and learner_id='" . $id . "'");
	if(!$CHECK_ENROLL->EOF)
	{
		$GLOBALS['db']->Execute("delete  from enroll where course_id='" . trim($cid) . "' and learner_id='" . $id . "'");
		 
		
	}
	}
	 
	header("Location: enroll.php?cid=".$cid."&msg=M_11");	
	}
	
}
?>