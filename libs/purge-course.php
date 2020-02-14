<?php
include_once"../config.php";
$result_t=$db->Execute("select * from content where lessons_ID='".$_GET["cid"]."'");

while(!$result_t->EOF)
{
$objectives = $db->Execute("select * from scorm_sequencing_objectives where content_ID='".$result_t->fields[id]."'");		 
while(!$objectives->EOF)
{
    $db->Execute("delete from scorm_sequencing_shared_data where objective_ID='".$objectives->fields[objective_ID]."'");
    $db->Execute("delete from scorm_sequencing_shared_data_not_g where objective_ID='".$objectives->fields[objective_ID]."'");

$objectives->moveNext();	
}
$seq = $db->Execute("select * from scorm_sequencing_rules where content_ID='".$result_t->fields[id]."'");
while(!$seq->EOF)
{
$db->Execute("delete from scorm_sequencing_rule where scorm_sequencing_rules_ID='".$seq->fields[id]."'");
$seq->moveNext();	
}
$db->Execute("delete from scorm_sequencing_objectives where content_ID='".$result_t->fields[id]."'");
$db->Execute("delete from scorm_sequencing_rules where content_ID='".$result_t->fields[id]."'");
$rullups = $db->Execute("select * from scorm_sequencing_rollup_rules where content_ID='".$result_t->fields[id]."'");
while(!$rullups->EOF)
{
$db->Execute("delete from scorm_sequencing_rollup_rule where scorm_sequencing_rollup_rules_ID='".$rullup->fields[id]."'");	
$rullups->moveNext();	
}
  $db->Execute("delete from scorm_sequencing_rollup_rules where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_rollup_controls where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_rollup_considerations where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_organizations where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_objectives where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_objective_progress_information_all where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_objective_progress_information where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_maps_info where lessons_ID='".$_GET["cid"]."'");
  $db->Execute("delete from scorm_sequencing_maps where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_map_info where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_limit_conditions where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_learner_preferences where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_interactions where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_hide_lms_ui where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_global_state_information where lessons_ID='".$id."'");
  $db->Execute("delete from scorm_sequencing_delivery_controls where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_control_mode where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_content_to_organization where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_constrained_choice where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_completion_threshold where content_ID='".$result_t->fields[id]."'");

  $db->Execute("delete from scorm_sequencing_comments_from_lms where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_comments_from_learner where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_adlseq_map_info where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_activity_state_information where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_sequencing_activity_progress_information where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from scorm_data_2004 where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from rules where content_ID='".$result_t->fields[id]."'");
  $db->Execute("delete from content where id='".$result_t->fields[id]."'");
$result_t->moveNext();
}
if(trim($_GET["type"]) == 'lesson'){
  $db->Execute("update lessons set lesson_status='processing' where lessoncode ='".$_GET["cid"]."'");
  // header("Location: ../dashboards/application/courses.php?msg=M_9");
  header("Location: ".LIVE_APP_PATH."/user/lessons?course_id=".$_GET["course_id"]."&e=purge");
} else {
  $db->Execute("update courses set course_status='processing' where coursecode ='".$_GET["cid"]."'");
  // header("Location: ../dashboards/application/courses.php?msg=M_9");
  header("Location: ".LIVE_APP_PATH."/user/courses?e=purge");
}

?>
