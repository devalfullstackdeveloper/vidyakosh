<?php
// var_dump('abc');
// die();
include "../config.php";
require_once("scorm.php");

if(trim($_GET["type"]) == 'lesson'){
    $GET_DB_COURSE_COURSE = $GLOBALS['db']->Execute("select * from lessons where lessoncode='" . trim($_GET["cid"]) . "'");
    $lesson_id=$GET_DB_COURSE_COURSE->fields["lesson_id"];
    $id=$GET_DB_COURSE_COURSE->fields["lessoncode"];
    $lesson_license_id=$id;
    $GET_DB_COURSE          = $GLOBALS['db']->Execute("select * from content where lessons_ID='" . trim($id) . "'");
    if ($GET_DB_COURSE->EOF) {
        $builder        = new ActiveScorm();
        $builder->import($id, "/var/www/vhosts/companydemo.in/httpdocs/dev/vidyakosh/public/storage/uploads/scrom/".$lesson_license_id."/" . $lesson_id . "/imsmanifest.xml");
        $GET_DB_SQ_C              = $GLOBALS['db']->Execute("select * from content where lessons_ID='" . $id . "' and parent_content_ID='0'");
        $records                  = array();
        $records["seqcollection"] = createSeqCollectionLesson($lesson_license_id,$lesson_id);
        $updateSQL                = $GLOBALS['db']->GetUpdateSQL($GET_DB_SQ_C, $records);
        if ($records["seqcollection"]) {
            $GLOBALS['db']->Execute($updateSQL); # Update the record in the database
        } //$records["seqcollection"]
        $GLOBALS['db']->Execute("update lessons set lesson_status='ready' where lessoncode ='".$id."'");

        //////////// identifierref column update
        $GET_DB_COURSE2          = $GLOBALS['db']->Execute("select * from content where lessons_ID='" . trim($id) . "'");
        //////////// identifierref column update
        while (!$GET_DB_COURSE2->EOF) {
            if ($GET_DB_COURSE2->fields['scorm_version'] == '1.2' && $GET_DB_COURSE2->fields['identifierref'] !=''){
                $compURL = LIVE_APP_PATH.'/public/storage/uploads/scrom/' .$lesson_license_id. '/' .$lesson_id. '/'.$GET_DB_COURSE2->fields['identifierref'];
                $GLOBALS['db']->Execute("update content set identifierref='".$compURL."' where lessons_ID='" . trim($id) . "'");
            }   
            $GET_DB_COURSE2->MoveNext();
        }
        $GET_DB_COURSE2->Close();
        //////////// identifierref column update
        
        //  header("Location: ../dashboards/application/lessons.php?msg=M_12");
        header("Location: ".LIVE_APP_PATH."/user/lessons?course_id=".$GET_DB_COURSE_COURSE->fields["course_id"]."&e=success");
    } //$GET_DB_COURSE->EOF
    else
    {
        $GLOBALS['db']->Execute("update lessons set lesson_status='ready' where coursecode ='".$id."'");
        $GET_DB_COURSE2          = $GLOBALS['db']->Execute("select * from content where lessons_ID='" . trim($id) . "'");
        //////////// identifierref column update
        while (!$GET_DB_COURSE2->EOF) {
            if ($GET_DB_COURSE2->fields['scorm_version'] == '1.2' && $GET_DB_COURSE2->fields['identifierref'] !=''){
                $compURL = LIVE_APP_PATH.'/public/storage/uploads/scrom/' .$lesson_license_id. '/' .$lesson_id. '/'.$GET_DB_COURSE2->fields['identifierref'];
                $GLOBALS['db']->Execute("update content set identifierref='".$compURL."' where lessons_ID='" . trim($id) . "'");
            }   
            $GET_DB_COURSE2->MoveNext();
        }
        $GET_DB_COURSE2->Close();
        //////////// identifierref column update
            
        header("Location: ".LIVE_APP_PATH."/user/lessons?course_id=".$GET_DB_COURSE_COURSE->fields["course_id"]."&e=exist");
    }
}
else
{  
    $GET_DB_COURSE_COURSE = $GLOBALS['db']->Execute("select * from courses where coursecode='" . trim($_GET["cid"]) . "'");
    $course_id=$GET_DB_COURSE_COURSE->fields["course_id"];
    $id=$GET_DB_COURSE_COURSE->fields["coursecode"];
    $course_license_id=$id;
    $GET_DB_COURSE          = $GLOBALS['db']->Execute("select * from content where lessons_ID='" . trim($id) . "'");
    if ($GET_DB_COURSE->EOF) {
        $builder        = new ActiveScorm();
        $builder->import($id, "/var/www/vhosts/companydemo.in/httpdocs/dev/vidyakosh/public/storage/uploads/scrom/".$course_license_id."/" . $course_id . "/imsmanifest.xml");
        $GET_DB_SQ_C              = $GLOBALS['db']->Execute("select * from content where lessons_ID='" . $id . "' and parent_content_ID='0'");
        $records                  = array();
        $records["seqcollection"] = createSeqCollection($course_license_id,$course_id);
        $updateSQL                = $GLOBALS['db']->GetUpdateSQL($GET_DB_SQ_C, $records);
        if ($records["seqcollection"]) {
            $GLOBALS['db']->Execute($updateSQL); # Update the record in the database
        } //$records["seqcollection"]
        $GLOBALS['db']->Execute("update courses set course_status='ready' where coursecode ='".$id."'");

        //////////// identifierref column update
        $GET_DB_COURSE2          = $GLOBALS['db']->Execute("select * from content where lessons_ID='" . trim($id) . "'");
        //////////// identifierref column update
        while (!$GET_DB_COURSE2->EOF) {
            if ($GET_DB_COURSE2->fields['scorm_version'] == '1.2' && $GET_DB_COURSE2->fields['identifierref'] !=''){
                $compURL = LIVE_APP_PATH.'/public/storage/uploads/scrom/' .$course_license_id. '/' .$course_id. '/'.$GET_DB_COURSE2->fields['identifierref'];
                $GLOBALS['db']->Execute("update content set identifierref='".$compURL."' where lessons_ID='" . trim($id) . "'");
            }   
            $GET_DB_COURSE2->MoveNext();
        }
        $GET_DB_COURSE2->Close();
        //////////// identifierref column update
        
        //  header("Location: ../dashboards/application/courses.php?msg=M_12");
        header("Location: ".LIVE_APP_PATH."/user/courses?e=success");
    } //$GET_DB_COURSE->EOF
    else
    {
        $GLOBALS['db']->Execute("update courses set course_status='ready' where coursecode ='".$id."'");
        $GET_DB_COURSE2          = $GLOBALS['db']->Execute("select * from content where lessons_ID='" . trim($id) . "'");
        //////////// identifierref column update
        while (!$GET_DB_COURSE2->EOF) {
            if ($GET_DB_COURSE2->fields['scorm_version'] == '1.2' && $GET_DB_COURSE2->fields['identifierref'] !=''){
                $compURL = LIVE_APP_PATH.'/public/storage/uploads/scrom/' .$course_license_id. '/' .$course_id. '/'.$GET_DB_COURSE2->fields['identifierref'];
                $GLOBALS['db']->Execute("update content set identifierref='".$compURL."' where lessons_ID='" . trim($id) . "'");
            }   
            $GET_DB_COURSE2->MoveNext();
        }
        $GET_DB_COURSE2->Close();
        //////////// identifierref column update
            
        header("Location: ".LIVE_APP_PATH."/user/courses?e=exist");
    }
}


function createSeqCollection($course_license_id,$course_id)
{
    $dom                     = new DOMDocument;
    $doc                     = new DomDocument();
    $dom->preserveWhiteSpace = false;
    $doc->load("/var/www/vhosts/companydemo.in/httpdocs/dev/vidyakosh/public/storage/uploads/scrom/".$course_license_id."/" . $course_id . "/imsmanifest.xml");
    //get all sequencing nodes in collections
    $sequencing  = $doc->getElementsByTagName("sequencingCollection");
    $sequencingC = $doc->getElementsByTagName("sequencingCollection")->item(0);
    if ($sequencingC) {
        //lookup the matching sequencing element
        foreach ($sequencing as $element) {
            $seqGlobal = $element;
        } //$sequencing as $element
        //clone the global node
        $seqInfo = $seqGlobal->cloneNode(TRUE);
        $dom->appendChild($dom->importNode($seqInfo, true));
        $IN = $dom->saveHTML();
        
        return trim($IN);
    } //$sequencingC
}

function createSeqCollectionLesson($lesson_license_id,$lesson_id)
{
    $dom                     = new DOMDocument;
    $doc                     = new DomDocument();
    $dom->preserveWhiteSpace = false;
    $doc->load("/var/www/vhosts/companydemo.in/httpdocs/dev/vidyakosh/public/storage/uploads/scrom/".$lesson_license_id."/" . $lesson_id . "/imsmanifest.xml");
    //get all sequencing nodes in collections
    $sequencing  = $doc->getElementsByTagName("sequencingCollection");
    $sequencingC = $doc->getElementsByTagName("sequencingCollection")->item(0);
    if ($sequencingC) {
        //lookup the matching sequencing element
        foreach ($sequencing as $element) {
            $seqGlobal = $element;
        } //$sequencing as $element
        //clone the global node
        $seqInfo = $seqGlobal->cloneNode(TRUE);
        $dom->appendChild($dom->importNode($seqInfo, true));
        $IN = $dom->saveHTML();
        
        return trim($IN);
    } //$sequencingC
}

?>