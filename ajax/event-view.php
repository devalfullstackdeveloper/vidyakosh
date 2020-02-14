<?php
include_once "../config.php";
 $validate->VALIDATE();
$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where id='".$_REQUEST["id"]."'");
 
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  <h3>View Event</h3>
</div>
<div class="modal-body">
<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
<div class="row-fluid">
  <div class="span6 ">
    <div class="control-group">
      <strong>
      <label for="submmittedby" class="control-label"><strong>Submitted By</strong></label>
      </strong>
      <div class="controls"> <?=$user->GET_USER_NAME($RS->fields["numericid"])?> </div>
      </div>
    </div>
  <!--/span-->
  <div class="span6 ">
    <div class="control-group">
      <label for="In" class="control-label"><strong>For</strong></label>
      <div class="controls">
      <?php
	  if($RS->fields["courseid"]=="")
	  {
		 echo "Personal Event";
	  }
	  else
	  {
		 echo $course->GET_COURSE_NAME($RS->fields["courseid"]);
	  }
	  ?>
       
        </div>
      </div>
    </div>
  <!--/span-->
</div>
  <div class="row-fluid">
    <div class="span6 ">
      <div class="control-group">
        <label for="from" class="control-label"><strong>From</strong></label>
        <div class="controls">
 <?=$RS->fields["eventfrom"]?>
    </div>
        </div>
      </div>
    <!--/span-->
    <div class="span6 ">
      <div class="control-group">
        <label for="to" class="control-label"><strong>To</strong></label>

  <div class="controls">
<?=$RS->fields["eventto"]?>
    </div>
        </div>
      </div>
    <!--/span-->
  </div>
  <!--/row-->

  <!--/row-->

  <!--/row-->

  <div class="row-fluid">
    <div class="span12 ">
      <div class="control-group">
        <label class="control-label"><strong>Subject</strong></label>

  <div class="controls">
    <?=$RS->fields["eventsubject"]?>
    </div>
        </div>
      </div>
  </div>
  <div class="row-fluid">
    <div class="span12 ">
      <div class="control-group">
        <label class="control-label"><strong>Description</strong></label>

  <div class="controls">
    <?=$RS->fields["eventdescription"]?>

    </div>
        </div>
      </div>
  </div>

  </div>
  </div>
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn">Close</button>
  </div>
