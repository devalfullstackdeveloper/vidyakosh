<?php
include_once "../config.php";
$validate->VALIDATE();
if ($_GET["scope"]=="all")
{
$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where numericid='".$_SESSION["user_uname"]."' OR eventtype='course' order by id desc limit 15");
}

if ($_GET["scope"]=="my")
{
$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where numericid='".$_SESSION["user_uname"]."' order by id desc limit 15");
}


if ($_GET["scope"]=="course")
{
$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where eventtype='course' order by id desc limit 15");
}
while (!$RS->EOF) {
	
	?>
    <li id="<?=$RS->fields["id"]?>">
  <div class="task-title"> <span class="task-title-sp"><strong><?=$RS->fields["eventsubject"]?></strong> <br> <i class="icon-calendar"></i> <?=$RS->fields["eventfrom"]?> <i class="icon-calendar"></i> <?=$RS->fields["eventto"]?> </span> </div>
  <div class="task-config">
 
    <div class="task-config-btn btn-group"> <a class="btn mini blue" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">More <i class="icon-angle-down"></i></a>
      <ul class="dropdown-menu pull-right">
        <li><a class="event_manager" data-id="<?=$RS->fields["id"]?>" href="javascript:;"><i class="icon-edit"></i> Edit</a></li>
        <li><a href="javascript:;" class="ajax_delete_event"><i class="icon-minus"></i> Delete</a></li>
        <li><a class="vieweventfront" data-id="<?=$RS->fields["id"]?>" href="javascript:;"><i class="icon-eye-open"></i> View</a></li>
      </ul>
    </div>

    
  </div>
</li>
    
     <?php
		$RS->MoveNext();

    }
    
?>