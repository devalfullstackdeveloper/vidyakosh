<?php

class Learners

{
 
	
	
	public $id;
	public $learner_name;
	public $learner_email;
	public $learner_parent;
	public $learner_phone;
	public $learner_user;
	public $learner_password;
	public $learner_active;
	public $learner_date;
 
	
	
	
	
	public function GET_LEARNER_BY_ID($id)
	{
	 
	$GET_USER = $GLOBALS['db']->Execute("select * from learners where id='" . $id."'");
	$this->id=trim($GET_USER->fields["id"]);
	$this->learner_name=trim($GET_USER->fields["learner_name"]);
	$this->learner_email=trim($GET_USER->fields["learner_email"]);
	$this->learner_parent=trim($GET_USER->fields["learner_parent"]);
	$this->learner_phone=trim($GET_USER->fields["learner_phone"]);
	$this->learner_user=trim($GET_USER->fields["learner_user"]);
	$this->learner_password=trim($GET_USER->fields["learner_password"]);
	$this->learner_active=trim($GET_USER->fields["learner_active"]);
 	$this->learner_date=trim($GET_USER->fields["learner_date"]);
 
	

  
	return $this;
	 
		
	}
	
	public function CREATE_LEARNER($mode, $array)
	{
	 
	$CHECK_USER = $GLOBALS['db']->Execute("select * from learners where learner_user='".$array["learner_user"]."' ");
	if($CHECK_USER->EOF)
	{
	ActiveinsertTableData("learners",$array);	
	header("Location: learners-add-edit.php?mode=".$mode."&cid=".$array["learner_parent"]."&msg=M_6");
	}
	else
	{
	header("Location: learners-add-edit.php?mode=".$mode."&cid=".$array["learner_parent"]."&msg=M_7");
	}
	 
		
	}
	public function UPDATE_LEARNER($mode, $array)
	{
	 
	$CHECK_USER = $GLOBALS['db']->Execute("select * from learners where learner_user='".$array["learner_user"]."' and id <> '".$array["id"]."' ");
	
 
	if($CHECK_USER->EOF)
	{
	 
	
    ActiveupdateTableData('learners',$array,"id='".$array["id"]."'");
	header("Location: learners-add-edit.php?mode=".$mode."&id=".$array["id"]."&msg=M_4");
	}
	else
	{
	header("Location: learners-add-edit.php?mode=".$mode."&id=".$array["id"]."&msg=M_7");
	}
	 
		
	}
	
}
?>