<?php
class Users
{
    public $id;
    public $user_name;
    public $user_email;
    public $user_hash;
    public $user_active;
    public $user_token;
    public $user_db;
    public $user_db_host;
    public $user_db_pass;
    public $user_db_port;
    public $user_password;
    public $user_type;
    public $user_phone;
    public $user_country;
    public $user_state;
    
    
    function LOGIN($username, $password)
    {
         
            $GET_USER = $GLOBALS['db']->Execute("select * from users where user_uname='" . trim($username) . "' and user_password='" . md5(($password)) . "'");
            if (!$GET_USER->EOF) {
                $_SESSION["id"]        = trim($GET_USER->fields["id"]);
                $_SESSION["user_hash"] = trim($GET_USER->fields["user_hash"]);
                $_SESSION["user_type"] = trim($GET_USER->fields["user_type"]);
				$_SESSION["user_email"] = trim($GET_USER->fields["user_email"]);
				$_SESSION["user_uname"] = trim($GET_USER->fields["user_uname"]);
				$records=array();
				$stime=time();
				$records["lastlogin"]=$stime;
				ActiveupdateTableData('users', $records, "id='" . $_SESSION["id"] . "'");
				$array=array();
				$_SESSION["csession"] =$stime;
				$array["numericid"]=trim($username);
				$array["datein"]=$stime;
				$array["dateout"]=$stime;
				$array["tminutes"]="1";
				$array["thits"]="1";
				$array["csession"]=$_SESSION["csession"];
				ActiveinsertTableData("attendance", $array);
				
                header("Location: dashboards/application/dashboard.php");
            } //!$GET_USER->EOF
            else {
                header("Location: index.php?msg=M_1");
            }
         
         
    }
    
    public function GET_TEACHER($course_id, $student_id)
{

	$GET_TEACHER_RS=$GLOBALS['db']->Execute("SELECT
users.user_name,
teacherstudent.teacher_id
FROM
teacherstudent
INNER JOIN users ON teacherstudent.teacher_id = users.user_uname
WHERE
teacherstudent.student_id = '".$student_id."' AND
teacherstudent.course_id = '".$course_id."'");
$teacherinfo=array();
$teacherinfo["teacherid"]=$GET_TEACHER_RS->fields[teacher_id];
$teacherinfo["teachername"]=$GET_TEACHER_RS->fields[user_name];
return $teacherinfo;
}
    
	public function PROCESS_INS_DATA($text)
	{
$DATA=$GLOBALS['db']->Execute("SELECT * FROM configuration where id='1'");	 
$text = str_replace("%contact_address%", $DATA->fields[contact_address], $text);
$text = str_replace("%contact_full_name%", $DATA->fields[contact_full_name], $text);
$text = str_replace("%contact_site_name%", $DATA->fields[contact_site_name], $text);
$text = str_replace("%contact_email%", $DATA->fields[contact_email], $text);
$text = str_replace("%APP_URL%", APP_URL, $text);

return $text;
	}
	
	public function PROCESS_USER_DATA($text, $user_uname)
	{
$DATA=$GLOBALS['db']->Execute("SELECT * FROM users where user_uname='".$user_uname."'");	 
$text = str_replace("%user_name%", $DATA->fields[user_name], $text);
$text = str_replace("%user_uname%", $DATA->fields[user_uname], $text);
$text = str_replace("%user_password%", $DATA->fields[user_uname], $text);
return $text;
	}
	
	public function PROCESS_TEACHER_DATA($text, $user_uname)
	{
$DATA=$GLOBALS['db']->Execute("SELECT * FROM users where user_uname='".$user_uname."'");	 
$text = str_replace("%teacher%", $DATA->fields[user_name], $text);

return $text;
	}
	
		public function PROCESS_STUDENT_DATA($text, $user_uname)
	{
$DATA=$GLOBALS['db']->Execute("SELECT * FROM users where user_uname='".$user_uname."'");	 
$text = str_replace("%student%", $DATA->fields[user_name], $text);

return $text;
	}
		public function PROCESS_COURSE_DATA($text, $coursecode)
	{
$DATA=$GLOBALS['db']->Execute("SELECT * FROM courses where coursecode='".$coursecode."'");	 
$text = str_replace("%course_id%", $DATA->fields[course_id], $text);
 
return $text;
	}
	
	public function PROCESS_MAIL($body,$subject,$from,$from_name,$to,$to_name)
	{
	$mail = new PHPMailer;
 
$mail->isSMTP();
 
$mail->SMTPDebug = 0;
 
$mail->Debugoutput = 'html';
 
$mail->Host = "247-api.com";
 
$mail->Port = 25;
 
$mail->SMTPAuth = true;
 
$mail->Username = "api@247-api.com";
 
$mail->Password = "rFbNTC6qHBPf";
 
$mail->setFrom($from, $from_name);
 
$mail->addReplyTo($from, $from_name);
 
$mail->addAddress($to, $to_name);
 
$mail->Subject = $subject;
 
$mail->msgHTML($body);
//Replace the plain text body with one created manually
$mail->AltBody = $body;
$mail->send() ;
	}
	public function PROCESS_INTERNAL_EMAIL($body,$subject,$from,$to)
	{
	$fields=array();
	$fields["messagefrom"]=$from;
	$fields["messageto"]=$to;

	$fields["messagesubject"]=$subject;
	$fields["messagebody"]=$body;
	$fields["messagestatus"]='1';
	$fields["messsagedate"]=date("Y-m-d H:i:s");
	$fields["messagetype"]='notification';
	$fields["messagepriority"]="Low";
	ActiveinsertTableData('messagecenter',$fields);
	$this->PROCESS_MAIL($body,$subject,SITE_EMAIL,SITE_CONTACT_NAME,$this->GET_USER_EMAIL($to),$this->GET_USER_NAME($to));
	}
	public function PROCESS_EMAIL($template,$from,$to,$data,$teacher,$student)
	{
		 
$LOAD_DATA=$GLOBALS['db']->Execute("SELECT * FROM templates where eid='".$template."'");
switch ($template) {
    case "EM001":
      
	  $body=$LOAD_DATA->fields[body];
	  $subject=$LOAD_DATA->fields[subject];
	  $body=$this->PROCESS_INS_DATA($body);
	  $subject=$this->PROCESS_INS_DATA($subject);
	  $body=$this->PROCESS_USER_DATA($body,$to);
	  $subject=$this->PROCESS_USER_DATA($subject,$to);
	  $body=$this->PROCESS_USER_DATA($body,$to);
	  $subject=$this->PROCESS_TEACHER_DATA($subject,$teacher);
	  $body=$this->PROCESS_TEACHER_DATA($body,$teacher);
	  $subject=$this->PROCESS_STUDENT_DATA($subject,$student);
	  $body=$this->PROCESS_STUDENT_DATA($body,$student);
	  $subject=$this->PROCESS_USER_DATA($subject,$to);
	  $body=$this->PROCESS_COURSE_DATA($body,$data);
	  $subject=$this->PROCESS_COURSE_DATA($subject,$data);
	  
	  
	  $this->PROCESS_INTERNAL_EMAIL($body,$subject,$from,$to);
		        break;
    case "EM002":
       
	 	  $body=$LOAD_DATA->fields[body];
	  $subject=$LOAD_DATA->fields[subject];
	  $body=$this->PROCESS_INS_DATA($body);
	  $subject=$this->PROCESS_INS_DATA($subject);
	  $body=$this->PROCESS_USER_DATA($body,$to);
	  $subject=$this->PROCESS_USER_DATA($subject,$to);
	  $body=$this->PROCESS_USER_DATA($body,$to);
	  $subject=$this->PROCESS_TEACHER_DATA($subject,$teacher);
	  $body=$this->PROCESS_TEACHER_DATA($body,$teacher);
	  $subject=$this->PROCESS_STUDENT_DATA($subject,$student);
	  $body=$this->PROCESS_STUDENT_DATA($body,$student);
	  $subject=$this->PROCESS_USER_DATA($subject,$to);
	   $body=$this->PROCESS_COURSE_DATA($body,$data);
	  $subject=$this->PROCESS_COURSE_DATA($subject,$data);
	  $this->PROCESS_INTERNAL_EMAIL($body,$subject,$from,$to);
		 break;
       
    case "EM003":
      	  $body=$LOAD_DATA->fields[body];
	  $subject=$LOAD_DATA->fields[subject];
	  $body=$this->PROCESS_INS_DATA($body);
	  $subject=$this->PROCESS_INS_DATA($subject);
	  $body=$this->PROCESS_USER_DATA($body,$to);
	  $subject=$this->PROCESS_USER_DATA($subject,$to);
	  $body=$this->PROCESS_USER_DATA($body,$to);
	  $subject=$this->PROCESS_TEACHER_DATA($subject,$teacher);
	  $body=$this->PROCESS_TEACHER_DATA($body,$teacher);
	  $subject=$this->PROCESS_STUDENT_DATA($subject,$student);
	  $body=$this->PROCESS_STUDENT_DATA($body,$student);
	  $subject=$this->PROCESS_USER_DATA($subject,$to);
	   $body=$this->PROCESS_COURSE_DATA($body,$data);
	  $subject=$this->PROCESS_COURSE_DATA($subject,$data);
	  $this->PROCESS_INTERNAL_EMAIL($body,$subject,$from,$to);
		 break;
    case "EM004":
             	  $body=$LOAD_DATA->fields[body];
	  $subject=$LOAD_DATA->fields[subject];
	  $body=$this->PROCESS_INS_DATA($body);
	  $subject=$this->PROCESS_INS_DATA($subject);
	  $body=$this->PROCESS_USER_DATA($body,$to);
	  $subject=$this->PROCESS_USER_DATA($subject,$to);
	  $body=$this->PROCESS_USER_DATA($body,$to);
	  $subject=$this->PROCESS_TEACHER_DATA($subject,$teacher);
	  $body=$this->PROCESS_TEACHER_DATA($body,$teacher);
	  $subject=$this->PROCESS_STUDENT_DATA($subject,$student);
	  $body=$this->PROCESS_STUDENT_DATA($body,$student);
	  $subject=$this->PROCESS_USER_DATA($subject,$to);
	   $body=$this->PROCESS_COURSE_DATA($body,$data);
	  $subject=$this->PROCESS_COURSE_DATA($subject,$data);
	  $this->PROCESS_INTERNAL_EMAIL($body,$subject,$from,$to);
		 break;

    
}
	}
    public function UPDATE_USER($mode, $records)
    {
        
       
            
            ActiveupdateTableData('users', $records, "id='" . $records["id"] . "'");
            
            
            
            header("Location: users-add-edit.php?mode=" . $mode . "&msg=M_4&id=" . $records["id"] . "");
        
        
        
    }
    public function GET_USER_BY_ID($id)
    {
        
        $GET_USER = $GLOBALS['db']->Execute("select * from users where id='" . $id . "'");
        
        $this->id            = trim($GET_USER->fields["id"]);
        $this->user_name     = trim($GET_USER->fields["user_name"]);
        $this->user_email    = trim($GET_USER->fields["user_email"]);
        $this->user_phone    = trim($GET_USER->fields["user_phone"]);
        $this->user_state    = trim($GET_USER->fields["user_state"]);
        $this->user_country  = trim($GET_USER->fields["user_country"]);
        $this->user_zip      = trim($GET_USER->fields["user_zip"]);
        $this->user_active   = trim($GET_USER->fields["user_active"]);
        $this->user_hash     = trim($GET_USER->fields["user_hash"]);
        $this->user_type     = trim($GET_USER->fields["user_type"]);
        $this->user_token    = trim($GET_USER->fields["user_token"]);
		$this->user_uname    = trim($GET_USER->fields["user_uname"]);

        $this->user_password = trim($GET_USER->fields["user_password"]);
        
        
        
        
        return $this;
        
        
    }
	
	public function GET_USER_NAME($id)
    {
        
        $GET_USER_NAME_RS = $GLOBALS['db']->Execute("select * from users where id='" . $id . "'");
      
        
        
        
        return $GET_USER_NAME_RS->fields["first_name"]." ".$GET_USER_NAME_RS->fields["last_name"];
        
        
    }
	
		public function GET_USER_EMAIL($id)
    {
        
        $GET_USER_EMAIL_RS = $GLOBALS['db']->Execute("select * from users where user_uname='" . $id . "'");
      
        
        
        
        return $GET_USER_EMAIL_RS->fields["user_email"];
        
        
    }
	
	 public function GET_USER_BY_NAME($id)
    {
        
        $GET_USER = $GLOBALS['db']->Execute("select * from users where user_uname='" . $id . "'");
        
        $this->id            = trim($GET_USER->fields["id"]);
        $this->user_name     = trim($GET_USER->fields["user_name"]);
        $this->user_email    = trim($GET_USER->fields["user_email"]);
        $this->user_phone    = trim($GET_USER->fields["user_phone"]);
        $this->user_state    = trim($GET_USER->fields["user_state"]);
        $this->user_country  = trim($GET_USER->fields["user_country"]);
        $this->user_zip      = trim($GET_USER->fields["user_zip"]);
        $this->user_active   = trim($GET_USER->fields["user_active"]);
        $this->user_hash     = trim($GET_USER->fields["user_hash"]);
        $this->user_type     = trim($GET_USER->fields["user_type"]);
        $this->user_token    = trim($GET_USER->fields["user_token"]);
		$this->user_uname    = trim($GET_USER->fields["user_uname"]);

        $this->user_password = trim($GET_USER->fields["user_password"]);
        
        
        
        
        return $this;
        
        
    }
    public function DELETE_USER_BY_ID($id)
    {
        
        $GET_USER = $GLOBALS['db']->Execute("select * from users where id='" . trim($id) . "'");
      //  $GLOBALS['db']->Execute("drop database " . $GET_USER->fields["user_db"] . "");
        $GLOBALS['db']->Execute("delete from enroll where client_id='" . trim($id) . "'");
        $GLOBALS['db']->Execute("delete from learners where learner_parent='" . trim($id) . "'");
        $GLOBALS['db']->Execute("delete from courses where course_license_id='" . trim($GET_USER->fields["user_hash"]) . "'");
        $GLOBALS['db']->Execute("delete from users where id='" . trim($id) . "'");
        
        
        header("Location: users.php");
    }
    
    public function CREATE_USER($mode, $array)
    {
        
    
            ActiveinsertTableData("users", $array);
     //       $db = "CREATE DATABASE `" . $array["user_db"] . "` CHARACTER SET 'utf8'  COLLATE 'utf8_general_ci';";
    //        $GLOBALS['db']->Execute($db);
            
       //     $NewDBConnection = mysqli_connect("localhost", "root", "", $array["user_db"]);
       //     $this->RUN_SQL_FILE($NewDBConnection, APP_PATH . "/db/db");
            
            
           
            header("Location: users.php?msg=M_6");
         
        
        
        
    }
    
    
    
    
    
    public function RUN_SQL_FILE($connection, $location)
    {
        //load file
        $commands = file_get_contents($location);
        
        //delete comments
        $lines    = explode("\n", $commands);
        $commands = '';
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line && !$this->startsWith($line, '--')) {
                $commands .= $line . "\n";
            } //$line && !$this->startsWith($line, '--')
        } //$lines as $line
        
        //convert to array
        $commands = explode(";", $commands);
        
        //run commands
        $total = $success = 0;
        foreach ($commands as $command) {
            if (trim($command)) {
                $success += (@mysqli_query($connection, $command) == false ? 0 : 1);
                $total += 1;
            } //trim($command)
        } //$commands as $command
        
        //return number of successful queries and total number of queries found
        return array(
            "success" => $success,
            "total" => $total
        );
    }
    
    
    // Here's a startsWith function
    public function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
    
}
?>