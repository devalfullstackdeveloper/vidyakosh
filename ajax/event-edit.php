<?php
include_once "../config.php";
$validate->VALIDATE();
$RS=$GLOBALS['db']->Execute("SELECT * FROM tblevents where id='".$_REQUEST["id"]."'");
 
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  <h3>Edit Event</h3>
</div>
<div class="modal-body">
<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
<form class="horizontal-form" style="margin:0;" action="/ajax/event-save.php" name="event-save"  id="event-save">
  <div class="row-fluid">
    <div class="span6 ">
      <div class="control-group">
        <label for="submmittedby" class="control-label">Submitted By</label>
        <div class="controls"> <?=$user->GET_USER_NAME($RS->fields[numericid])?></div>
      </div>
    </div>
    <!--/span-->
    <div class="span6 ">
      <div class="control-group">
        <label for="In" class="control-label">For</label>
        <div class="controls">
          <?php 
if( $RS->fields['courseid'] == "") {
    echo "Personal Event";
}else{
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
        <label for="from" class="control-label">From (*)</label>

<div class="controls">
          <div class="input-append date form_datetime"  >
            <input type="text"   class="m-wrap span12" id="from" name="from" value="<?=$RS->fields[eventfrom]?>">
            <span class="add-on"><i class="icon-remove"></i></span> <span class="add-on"><i class="icon-calendar"></i></span> </div>
        </div>
      </div>
    </div>
    <!--/span-->
    <div class="span6 ">
      <div class="control-group">
        <label for="to" class="control-label">To (*)</label>

<div class="controls">
          <div class="input-append date form_datetime" >
            <input type="text"   class="m-wrap span12" id="to" name="to" value="<?=$RS->fields[eventto]?>">
            <span class="add-on"><i class="icon-remove"></i></span> <span class="add-on"><i class="icon-calendar"></i></span> </div>
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
        <label class="control-label">Subject (*)</label>

<div class="controls">
          <input id="subjecte" name="subject" value="<?=$RS->fields[eventsubject]?>" type="text" class="m-wrap span12">
        </div>
      </div>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span12 ">
      <div class="control-group">
        <label class="control-label">Description (*)</label>

<div class="controls">
          <textarea id="description" name="description" class="m-wrap span12"><?=$RS->fields[eventdescription]?></textarea>
          <input type="hidden" name="id" id="id" value="<?=$RS->fields[id]?>" />
        </div>
      </div>
    </div>
  </div>
</form>

  </div>
  </div>
  </div>
  <div class="modal-footer"> <a id="submit" class="btn green" href="javascript:;" onclick="ajax_submit('event-save')">Update</a>
    <button type="button" data-dismiss="modal" class="btn">Close</button>
  </div>
