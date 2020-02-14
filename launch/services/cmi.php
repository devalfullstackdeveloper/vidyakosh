<?php
include_once "../../config.php";
$_SESSION["GlobalObjectives"]="";
$post = file_get_contents("php://input");
$post=str_replace("'", '', $post);


$PK=$_SESSION["coursePK"];
$MODE=$_SESSION["mode"];
global $domManifest;

if($MODE=="browse")
{
include_once "cmi-browse.php";
}
if($MODE=="normal")
{
include_once "cmi-normal.php";
}
$reader = new ScormReader();
$out    = $reader->SequenceReader($domManifest, $PK, $post, $MODE);
header("Content-Type:text/xml");
$out=str_replace("'", '', $out);
function utf8_for_xml($string)
  {
  return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
  }
echo utf8_for_xml($out);
?>