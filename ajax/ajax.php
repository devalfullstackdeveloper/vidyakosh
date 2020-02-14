<?php
include_once "../config.php";
$validate->VALIDATE();
if($validate->user_type=="admin")
{
  if ($_GET["scope"]=="all")
	{
	$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents order by id desc limit 15");
	}else if ($_GET["scope"]=="my")
	{
	$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where numericid='".$validate->user_uname."'  AND eventtype = 'persoanl' order by id desc limit 15");
	}else if ($_GET["scope"]=="admin")
	{
	$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where eventtype='admin' order by id desc limit 15");
	}else if ($_GET["scope"]=="teacher")
	{
	$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where eventtype='teacher' order by id desc limit 15");
	}else if ($_GET["scope"]=="course")
	{
	$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where eventtype='course' order by id desc limit 15");
	}
	
}else if($validate->user_type=="learner")
{
	if ($_GET["scope"]=="all")
	{
	$RS=$GLOBALS['db']->Execute("SELECT tblevents.id, tblevents.eventfrom, tblevents.eventto, tblevents.numericid, tblevents.eventtype, tblevents.eventsubject, tblevents.eventdescription,  tblevents.courseid, enroll.learner_id FROM enroll INNER JOIN  tblevents ON enroll.course_id = tblevents.courseid  WHERE     (enroll.learner_id = '".$validate->user_uname."') AND (tblevents.numericid in (".$_SESSION["TeacherID"].")) ORDER BY tblevents.eventfrom DESC");
	}else if ($_GET["scope"]=="my")
	{
	$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where numericid='".$validate->user_uname."'  AND eventtype = 'persoanl' order by id desc limit 15");
	}else if ($_GET["scope"]=="admin")
	{
	$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where eventtype='admin' order by id desc limit 15");
	}else if ($_GET["scope"]=="course")
	{
	$RS=$GLOBALS['db']->Execute("SELECT tblevents.id, tblevents.eventfrom, tblevents.eventto, tblevents.numericid, tblevents.eventtype, tblevents.eventsubject, tblevents.eventdescription,  tblevents.courseid, enroll.learner_id FROM enroll INNER JOIN  tblevents ON enroll.course_id = tblevents.courseid  WHERE     (enroll.learner_id = '".$validate->user_uname."') AND (tblevents.numericid in (".$_SESSION["TeacherID"].")) ORDER BY tblevents.eventfrom DESC");
	}
}

if($validate->user_type=="teacher")
{
	if ($_GET["scope"]=="all")
	{
	$RS=$GLOBALS['db']->Execute("SELECT * from tblevents where numericid = '".$_SESSION["user_uname"]."' order by id DESC LIMIT 15");
	}else if ($_GET["scope"]=="my")
	{
	$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where numericid='".$validate->user_uname."' AND eventtype = 'persoanl' order by id desc limit 15");
	}else if ($_GET["scope"]=="admin")
	{
	$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where eventtype='admin' order by id desc limit 15");
	}
}


while (!$RS->EOF) {
	
	?>
    <li id="<?=$RS->fields["id"]?>">
  <div class="task-title"> <span class="task-title-sp"><strong><?=$RS->fields["eventsubject"]?></strong> <br> <i class="icon-calendar"></i> <?=$RS->fields["eventfrom"]?> <i class="icon-calendar"></i> <?=$RS->fields["eventto"]?> </span> </div>
  <div class="task-config">
 
    <div class="task-config-btn btn-group"> <a class="btn mini blue" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">More <i class="icon-angle-down"></i></a>
      <ul class="dropdown-menu pull-right">
      <?php if($validate->user_type=="admin" || $validate->user_uname==$RS->fields["numericid"]){ ?>
        <li><a class="event_manager" data-id="<?=$RS->fields["id"]?>" href="javascript:;"><i class="icon-edit"></i> Edit</a></li>
        <li><a href="javascript:;" class="ajax_delete_event"><i class="icon-minus"></i> Delete</a></li>
        <?php } ?>
        <li><a class="vieweventfront" data-id="<?=$RS->fields["id"]?>" href="javascript:;"><i class="icon-eye-open"></i> View</a></li>
      </ul>
    </div>

    
  </div>
</li>
    
     <?php
		$RS->MoveNext();

    }
    
?>