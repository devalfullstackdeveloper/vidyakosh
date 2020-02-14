<?php

class Courses

{
 
	
	
	public $id;
	public $course_id;
	public $course_license_id;
	public $course_ip;
	public $course_status;
	public $course_version;
	public $course_schema;
	public $course_filename;
	public $file_size;
	public $uploaded_bytes;
	public $uploaded_time;
	public $course_mode;
	public $coursecode;
 
	
	
	
	
	public function GET_COURSE_OR_LESSON_BY_ID($id,$type)
	{
    	 if($type == 'lesson'){
        	$GET_COURSE = $GLOBALS['db']->Execute("select * from lessons where lessoncode='" . $id."'");
        	$this->id=trim($GET_COURSE->fields["id"]);
        	$this->course_id=trim($GET_COURSE->fields["lesson_id"]);
        	$this->course_license_id=trim($GET_COURSE->fields["lesson_license_id"]);
        	$this->course_ip=trim($GET_COURSE->fields["lesson_ip"]);
        	$this->course_status=trim($GET_COURSE->fields["lesson_status"]);
        	$this->course_version=trim($GET_COURSE->fields["lesson_version"]);
        	$this->course_filename=trim($GET_COURSE->fields["lesson_filename"]);
        	$this->file_size=trim($GET_COURSE->fields["file_size"]);
         	$this->uploaded_bytes=trim($GET_COURSE->fields["uploaded_bytes"]);
        	$this->uploaded_time=trim($GET_COURSE->fields["uploaded_time"]);
        	$this->course_mode=trim($GET_COURSE->fields["lesson_mode"]);
        	$this->coursecode=trim($GET_COURSE->fields["lessoncode"]);
    	 } else {
        	$GET_COURSE = $GLOBALS['db']->Execute("select * from courses where coursecode='" . $id."'");
        	$this->id=trim($GET_COURSE->fields["id"]);
        	$this->course_id=trim($GET_COURSE->fields["course_id"]);
        	$this->course_license_id=trim($GET_COURSE->fields["course_license_id"]);
        	$this->course_ip=trim($GET_COURSE->fields["course_ip"]);
        	$this->course_status=trim($GET_COURSE->fields["course_status"]);
        	$this->course_version=trim($GET_COURSE->fields["course_version"]);
        	$this->course_filename=trim($GET_COURSE->fields["course_filename"]);
        	$this->file_size=trim($GET_COURSE->fields["file_size"]);
         	$this->uploaded_bytes=trim($GET_COURSE->fields["uploaded_bytes"]);
        	$this->uploaded_time=trim($GET_COURSE->fields["uploaded_time"]);
        	$this->course_mode=trim($GET_COURSE->fields["course_mode"]);
        	$this->coursecode=trim($GET_COURSE->fields["coursecode"]);
    	 }
    	return $this;
	}
	
	public function GET_COURSE_BY_ID($id)
	{
	 
	$GET_COURSE = $GLOBALS['db']->Execute("select * from courses where coursecode='" . $id."'");
	$this->id=trim($GET_COURSE->fields["id"]);
	$this->course_id=trim($GET_COURSE->fields["course_id"]);
	$this->course_license_id=trim($GET_COURSE->fields["course_license_id"]);
	$this->course_ip=trim($GET_COURSE->fields["course_ip"]);
	$this->course_status=trim($GET_COURSE->fields["course_status"]);
	$this->course_version=trim($GET_COURSE->fields["course_version"]);
	$this->course_filename=trim($GET_COURSE->fields["course_filename"]);
	$this->file_size=trim($GET_COURSE->fields["file_size"]);
 	$this->uploaded_bytes=trim($GET_COURSE->fields["uploaded_bytes"]);
	$this->uploaded_time=trim($GET_COURSE->fields["uploaded_time"]);
	$this->course_mode=trim($GET_COURSE->fields["course_mode"]);
	$this->coursecode=trim($GET_COURSE->fields["coursecode"]);
	
 
	

  
	return $this;
	 
		
	}
	
	public function GET_COURSE_NAME($id)
	{
	 
	$GET_COURSE_NAME_RS = $GLOBALS['db']->Execute("select * from courses where coursecode='" . $id."'");
 
	
 
	

  
	return $GET_COURSE_NAME_RS->fields["course_id"];
	 
		
	}
	
	
	
}
?>