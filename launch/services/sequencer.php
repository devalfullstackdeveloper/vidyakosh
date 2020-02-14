<?php
include_once "../../config.php";
$_SESSION["GlobalObjectives"]="";
$post = file_get_contents("php://input");
$post=str_replace("'", '', $post);
$PK=$_SESSION["coursePK"];
$MODE=$_SESSION["mode"];
$GET_CONTENT            = $GLOBALS['db']->Execute("select * from content where lessons_ID='" . $PK . "'");
global $domManifest;
while (!$GET_CONTENT->EOF) {
    $domManifest[$GET_CONTENT->fields["id"]] = array(
        'id' => $GET_CONTENT->fields["id"],
		'is_visible' => $GET_CONTENT->fields["is_visible"],
		'name' => $GET_CONTENT->fields["name"],
        'data' => $GET_CONTENT->fields["data"],
        'parent_content_ID' => $GET_CONTENT->fields["parent_content_ID"],
        'lessons_ID' => $GET_CONTENT->fields["lessons_ID"],
        'timestamp' => $GET_CONTENT->fields["timestamp"],
        'ctg_type' => $GET_CONTENT->fields["ctg_type"],
        'active' => $GET_CONTENT->fields["active"],
        'previous_content_ID' => $GET_CONTENT->fields["previous_content_ID"],
        'options' => $GET_CONTENT->fields["options"],
        'scorm_version' => $GET_CONTENT->fields["scorm_version"],
        'identifier' => $GET_CONTENT->fields["identifier"],
        'identifierref' => $GET_CONTENT->fields["identifierref"],
		'scormtype' => $GET_CONTENT->fields["scormtype"],
        'base' => $GET_CONTENT->fields["base"],
        'params' => $GET_CONTENT->fields["params"],
        'reftype' => $GET_CONTENT->fields["reftype"],
        'organization' => $GET_CONTENT->fields["organization"],
        'seqcollection' => $GET_CONTENT->fields["seqcollection"],
        'itemendseq' => $GET_CONTENT->fields["itemendseq"],
        'orgendseq' => $GET_CONTENT->fields["orgendseq"],
        'iteminseq' => $GET_CONTENT->fields["iteminseq"],
        'presentation' => $GET_CONTENT->fields["presentation"]
    );
    $GET_CONTENT->MoveNext();
} //!$GET_CONTENT->EOF
$GET_CONTENT->Close();
if($MODE=="browse")
{
include_once "sequencer-browse.php";
}
if($MODE=="normal")
{
include_once "sequencer-normal.php";
}
$reader = new ScormReader();
$out    = $reader->SequenceReader($domManifest, $PK, $post, $MODE);
$out=str_replace("'", '', $out);
header("Content-Type:text/xml");
function utf8_for_xml($string)
  {
  return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
  }
echo utf8_for_xml($out);
?>