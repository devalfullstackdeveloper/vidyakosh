<?php
include_once "../config.php";

$coursesc = new Courses();
$coursesc->GET_COURSE_BY_ID(trim($_GET["cid"]));
 
if ($coursesc->id=="")
{
echo "Invalid Course ID";
exit();
}

$user = new Users();
$user->GET_USER_BY_NAME(trim($_GET["lid"]));

$utility = new Utility();
$uuid=new uuid();

if($user->id=="")
{
	$record                  = array();
	 
    $record["user_name"]="LMS User";
	$record["user_uname"]=trim($_GET["lid"]);
	$record["user_active"]="1";
	$record["user_hash"]=$uuid->v4();
	$record["user_type"]="learner";
	$record["user_token"]=$uuid->v4();

	 
	$record["user_password"]=$utility->SANITIZE_STRING(md5(trim($_GET["lid"])));
	 
	ActiveinsertTableData("users", $record);
}

  				
            $GET_USER = $GLOBALS['db']->Execute("select * from users where user_uname='" . trim($_GET["lid"]) . "'");

				$_SESSION["id"]        = trim($GET_USER->fields["id"]);
                $_SESSION["user_hash"] = trim($GET_USER->fields["user_hash"]);
                $_SESSION["user_type"] = trim($GET_USER->fields["user_type"]);
				$_SESSION["user_uname"] = trim($GET_USER->fields["user_uname"]);
				$_SESSION["user_type"] = trim($GET_USER->fields["user_type"]);
				
				$enroll = new Enroll;
				$enroll->ENROLLMENT_EMBED($_GET["cid"],$GET_USER->fields["user_uname"]);
				$stime=time();
				$records["lastlogin"]=$stime;
				ActiveupdateTableData('users', $records, "id='" . $_SESSION["id"] . "'");
				$array=array();
				$_SESSION["csession"] =$stime;
				$array["numericid"]=trim($GET_USER->fields["user_uname"]);
				$array["datein"]=$stime;
				$array["dateout"]=$stime;
				$array["tminutes"]="1";
				$array["thits"]="1";
				$array["csession"]=$_SESSION["csession"];
				ActiveinsertTableData("attendance", $array);
				header("Location: index.php?cid=".$_GET["cid"]."&lid=".$GET_USER->fields["user_uname"]."");
				exit();
				
?>
