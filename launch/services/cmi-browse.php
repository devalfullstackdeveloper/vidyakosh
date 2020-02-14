<?php
class ScormReader
{
    public function SequenceReader($domManifest, $PK, $postdoc, $mode)
    {
        global $dom;
        global $domManifest;
        global $PK;
        global $post;
        global $mode;
        global $topOrg;
        global $GlobalObjectives;
		global $ScormVersion;
		
		
	
		
		$GET_ORG_ID           = $GLOBALS['db']->Execute("select * from content where lessons_ID='" . $PK . "' and parent_content_ID='0'");
		$ScormVersion=$this->GetScormVersionFromSchemaVersion($GET_ORG_ID->fields["scorm_version"]);
        $_SESSION["od"] = 1;
        $dom            = new DOMDocument();
		$dom->encoding = 'utf-8';
        $post           = new DOMDocument();
        $post->loadXML($postdoc);
       
		 
		
		$RteDataModel      = $dom->createElementNS('http://www.activelms.com/services/cmi', 'RteDataModel', '');
		$RteDataModel->setAttribute("action", trim($this->action($post)));
		$RteDataModel->setAttribute("domain", trim($this->domain($post)));
		$RteDataModel->setAttribute("learnerName", trim($this->learnerName($post)));
		$RteDataModel->setAttribute("learner", trim($this->learner($post)));
		$RteDataModel->setAttribute("course", trim($this->course($post)));
		$RteDataModel->setAttribute("sco", trim($this->sco($post)));
		$RteDataModel->setAttribute("session", trim($this->session($post)));
		$RteDataModel->setAttribute("rteSchemaVersion", trim($this->rteSchemaVersion($post)));
		$RteDataModel->setAttribute("adlNavRequest", trim($this->adlNavRequest($post)));
		$RteDataModel      = $dom->appendChild($RteDataModel);
		
		$appendxml='<cocd xmlns="http://ltsc.ieee.org/xsd/1484_11_3"><commentsFromLearner></commentsFromLearner><commentsFromLMS></commentsFromLMS><completionStatus>unknown</completionStatus><credit>credit</credit><dataModelVersion>1.0</dataModelVersion><entry>ab_initio</entry><exit>normal</exit><interactions></interactions><learnerId>'.trim($this->learner($post)).'</learnerId><learnerName>'.trim($this->learnerName($post)).'</learnerName><learnerPreferenceData><audioLevel>1</audioLevel><language></language><deliverySpeed>1</deliverySpeed><audioCaptioning>no_change</audioCaptioning></learnerPreferenceData><lessonStatus>not_attempted</lessonStatus><location></location><mode>browse</mode><objectives></objectives><score></score><successStatus>unknown</successStatus><timeLimitAction>continue_no_message</timeLimitAction><totalTime>PT0H0M0S</totalTime></cocd>';
		$ff = $dom->createDocumentFragment();
        $ff->appendXML(trim($appendxml));
        $cocd=$dom->documentElement->appendChild($ff);
	
	
		 
		
		
        $xml                     = new DOMDocument();
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput       = false;
		$xml->encoding = 'utf-8';
        $SoapOutput              = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body>';
        $SoapOutput .= $dom->saveHTML();
        $SoapOutput .= '</soap:Body></soap:Envelope>';
        $xml->loadXML($SoapOutput);
        return $xml->saveXML();
	   
	/*   return '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><RteDataModel action="Initialize" domain="sqlserver" pk="0" learnerName="Learner,Mary" learner="alphanumeric255" course="WWII_Sample" org="SC" sco="SC-Lesson" session="generatedByLMS" rteSchemaVersion="CAM 1.3" xmlns="http://www.activelms.com/services/cmi"><cocd xmlns="http://ltsc.ieee.org/xsd/1484_11_3"><commentsFromLearner /><commentsFromLMS /><completionStatus>unknown</completionStatus><credit>credit</credit><dataModelVersion>1.0</dataModelVersion><entry>ab_initio</entry><exit>normal</exit><interactions /><learnerId>alphanumeric255</learnerId><learnerName>Learner,Mary</learnerName><learnerPreferenceData><audioLevel>1</audioLevel><language /><deliverySpeed>1</deliverySpeed><audioCaptioning>no_change</audioCaptioning></learnerPreferenceData><lessonStatus>not_attempted</lessonStatus><mode>browse</mode><objectives /><score /><successStatus>unknown</successStatus><timeLimitAction>continue_no_message</timeLimitAction><totalTime>PT0H0M0S</totalTime></cocd></RteDataModel></soap:Body></soap:Envelope>';
	*/
    }
	
	
   function createCOCD($post)
{
    
	global $post;
	$ndom                     = new DOMDocument;
 
    $ndom->preserveWhiteSpace = false;
    
    //get all sequencing nodes in collections
    $cocda  = $post->getElementsByTagName("cocd");
    $cocdaC = $post->getElementsByTagName("cocd")->item(0);
    if ($cocdaC) {
        //lookup the matching sequencing element
        foreach ($cocda as $element) {
            $cocdGlobal = $element;
        } //$sequencing as $element
        //clone the global node
        $cocdInfo = $cocdGlobal->cloneNode(TRUE);
        $ndom->appendChild($ndom->importNode($cocdInfo, true));
        $IN = $ndom->saveHTML();
        $IN=str_replace("default:","",$IN);
		$IN=str_replace("xmlns:default","xmlns",$IN);
		$IN=str_replace('xmlns="http://www.activelms.com/services/cmi"',"",$IN);
		$IN=str_replace('xmlns="http://ltsc.ieee.org/xsd/1484_11_3"',"",$IN);
		$IN=str_replace('<cocd >','<cocd xmlns="http://ltsc.ieee.org/xsd/1484_11_3">',$IN);
		
		
		
        return trim($IN);
    } //$sequencingC
}
    public function Activity($domObj, $tag_name, $ParentElement, $value = NULL, $attributes = NULL)
    {
		
        $element = ($value != NULL) ? $domObj->createElement($tag_name, $value) : $domObj->createElement($tag_name);
        if ($attributes != NULL) {
            foreach ($attributes as $attr => $val) {
                if (trim($val) != "") {
                    $element->setAttribute($attr, $val);
                } //isset($val)
            } //$attributes as $attr => $val
        } //$attributes != NULL
        if ($ParentElement != "") {
            $ParentElement->appendChild($element);
        } //$ParentElement != ""
        else {
            $domObj->appendChild($element);
        }
        return $element;
    }
   
    public function learnerName($post)
    {
        global $doc;
        global $post;
        $learnerName = $post->getElementsByTagName('RteDataModel')->item(0)->getAttribute('learnerName');
        return $learnerName;
    }
	
	public function learner($post)
    {
        global $doc;
        global $post;
        $learner = $post->getElementsByTagName('RteDataModel')->item(0)->getAttribute('learner');
        return $learner;
    }
	
	public function course($post)
    {
        global $doc;
        global $post;
        $course = $post->getElementsByTagName('RteDataModel')->item(0)->getAttribute('course');
        return $course;
    }
	
	
	public function org($post)
    {
        global $doc;
        global $post;
        $org = $post->getElementsByTagName('RteDataModel')->item(0)->getAttribute('org');
        return $org;
    }
		public function totalTime($post)
    {
        global $doc;
        global $post;
        $totalTime = $post->getElementsByTagName('RteDataModel')->item(0)->getAttribute('totalTime');
        return $totalTime;
    }
	
	public function sco($post)
    {
        global $doc;
        global $post;
        $sco = $post->getElementsByTagName('RteDataModel')->item(0)->getAttribute('sco');
        return $sco;
    }
	
	public function session($post)
    {
        global $doc;
        global $post;
        $session = $post->getElementsByTagName('RteDataModel')->item(0)->getAttribute('session');
        return $session;
    }
	
	public function domain($post)
    {
        global $doc;
        global $post;
        $domain = $post->getElementsByTagName('RteDataModel')->item(0)->getAttribute('domain');
        return $domain;
    }
	
		public function rteSchemaVersion($post)
    {
        global $doc;
        global $post;
        $rteSchemaVersion = $post->getElementsByTagName('RteDataModel')->item(0)->getAttribute('rteSchemaVersion');
        return $rteSchemaVersion;
    }
	
		public function adlNavRequest($post)
    {
        global $doc;
        global $post;
        $adlNavRequest = $post->getElementsByTagName('RteDataModel')->item(0)->getAttribute('adlNavRequest');
        return $adlNavRequest;
    }
	
    public function action($post)
    {
        global $doc;
        global $post;
        $action = $post->getElementsByTagName('RteDataModel')->item(0)->getAttribute('action');
        return $action;
    }    
	
	public function GetRequestType($post)
    {
        global $doc;
        global $post;
        $Commit   = $post->getElementsByTagName("Commit")->item(0);
        $Initialize    = $post->getElementsByTagName("Initialize")->item(0);
        $Read    = $post->getElementsByTagName("Read")->item(0);
        $Terminate = $post->getElementsByTagName("Terminate")->item(0);
        if ($Commit) {
            $GetRequestType = "Commit";
            return $GetRequestType;
        } //$Resume
        if ($Initialize) {
            $GetRequestType = "Initialize";
            return $GetRequestType;
        } //$Create
        if ($Read) {
            $GetRequestType = "Read";
            return $GetRequestType;
        } //$Deliver
        if ($Terminate) {
            $GetRequestType = "Terminate";
            return $GetRequestType;
        } //$Terminate
    }
    public function GetLessonMode($post)
    {
        global $doc;
        global $post;
        $GetLessonMode = $post->getElementsByTagName("manifest")->item(0);
        $GetLessonMode = $post->getElementsByTagName('mode')->item(0)->nodeValue;
        if ($GetLessonMode == "") {
            $GetLessonMode = "normal";
        } //$GetLessonMode == ""
        return $GetLessonMode;
    }
    public function GetSyncClientServer($post)
    {
        global $doc;
        global $post;
        $GetSyncClientServer = $post->getElementsByTagName("manifest")->item(0);
        $GetSyncClientServer = $post->getElementsByTagName('syncClientServer')->item(0)->nodeValue;
        if ($GetSyncClientServer == "") {
            $GetSyncClientServer = "differential";
        } //$GetSyncClientServer == ""
        return $GetSyncClientServer;
    }
    public function GetnavRequest($post)
    {
        global $doc;
        global $post;
        $GetnavRequest = $post->getElementsByTagName("manifest")->item(0);
        $GetnavRequest = $post->getElementsByTagName('navRequest')->item(0)->nodeValue;
        return $GetnavRequest;
    }
   
    public function GetScormVersionFromSchemaVersion($version)
    {
        if ($version == "") {
            $GetScormVersionFromSchemaVersion = "1.2";
        } //$version == ""
        if ($version == "1.2") {
            $GetScormVersionFromSchemaVersion = "1.2";
        } //$version == "1.2"
        if ($version == "2004 3rd Edition") {
            $GetScormVersionFromSchemaVersion = "2004.31";
        } //$version == "2004 3rd Edition"
		if ($version == "2004 4th Edition") {
            $GetScormVersionFromSchemaVersion = "2004.4";
        } //$version == "2004 3rd Edition"
        if ($version == "CAM 1.3") {
            $GetScormVersionFromSchemaVersion = "2004.2";
        } //$version == "CAM 1.3"
        return $GetScormVersionFromSchemaVersion;
    }
	public function parsePostManifest($data)
    {
        //We don't use SimpleXML, due to memory and other issues with this iterator class
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $data, $tagContents, $tags);
        xml_parser_free($parser);

        $currentParent = array(
            0 => 0
        );
        for ($i = 0; $i < sizeof($tagContents); $i++) {
            if ($tagContents[$i]['type'] != 'close') {
                $tagArray[$i] = array(
                    'parent_index' => end($currentParent),
                    'tag' => $tagContents[$i]['tag'],
                    'value' => isset($tagContents[$i]['value']) ? $tagContents[$i]['value'] : null,
                    'attributes' => isset($tagContents[$i]['attributes']) ? $tagContents[$i]['attributes'] : null,
                    'children' => array()
                );
                array_push($tagArray[end($currentParent)]['children'], $i);
            } //$tagContents[$i]['type'] != 'close'
            if ($tagContents[$i]['type'] == 'open') {
                array_push($currentParent, $i);
            } //$tagContents[$i]['type'] == 'open'
            else if ($tagContents[$i]['type'] == 'close') {
                array_pop($currentParent);
            } //$tagContents[$i]['type'] == 'close'
        } //$i = 0; $i < sizeof($tagContents); $i++
        return $tagArray;
    }
}
?>