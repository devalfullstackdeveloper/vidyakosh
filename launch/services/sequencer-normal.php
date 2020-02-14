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
        $manifest      = $dom->createElementNS('http://www.activelms.com/services/ss', 'manifest', '');
        $manifest      = $dom->appendChild($manifest);
        $organizations = $dom->createElement('organizations', '');
        $organizations = $manifest->appendChild($organizations);
		$this->Activity($dom, 'identifiers', $organizations, '', array(
                                'domainID' => trim($this->domainID($post)),
                                'learnerID' => trim($this->learnerID($post)),
                                'courseID' => trim($this->courseID($post)),
                                'orgID' => $GET_ORG_ID->fields["identifier"],
                                'sessionID' => trim($this->sessionID($post))
                            ));
							
		if ($this->GetRequestType($post)=="Deliver")
		{
		$tagArrayPost   = $this->parsePostManifest($postdoc); 
		$total_fields = array();
		foreach ($tagArrayPost as $key => $value) {
            $fields = array();
            switch ($value['tag']) {
                	case 'ORGANIZATION':
                   	$item_key = $key;
					$total_fields[$key]['IDENTIFIER']=$value['attributes']['IDENTIFIER'];
					$total_fields[$key]['ACTIVE']=$value['attributes']['ACTIVE'];
					break;
					case 'ITEM':
                  	$item_key = $key;
					$total_fields[$key]['IDENTIFIER']=$value['attributes']['IDENTIFIER'];
					$total_fields[$key]['ACTIVE']=$value['attributes']['ACTIVE'];
					break;
					case 'ACTIVITYPROGRESSINFO':
                	$cur                        = $value['parent_index'];
					$total_fields[$cur]['PROGRESSSTATUS']=$value['attributes']['PROGRESSSTATUS'];
					$total_fields[$cur]['ATTEMPTCOUNT']=$value['attributes']['ATTEMPTCOUNT'];
					break;
					case 'ATTEMPTPROGRESSINFO':
                  	$cur                        = $value['parent_index'];
					$total_fields[$cur]['RECORDEDINPRIORATTEMPT']=$value['attributes']['RECORDEDINPRIORATTEMPT'];
					$total_fields[$cur]['PROGRESSSTATUS']=$value['attributes']['PROGRESSSTATUS'];
					$total_fields[$cur]['COMPLETIONSTATUS']=$value['attributes']['COMPLETIONSTATUS'];
					$total_fields[$cur]['COMPLETIONAMOUNT']=$value['attributes']['COMPLETIONAMOUNT'];
					break;
					 case 'IMSSS:SEQUENCING':
                    $item_key = $value['parent_index'];
                    break;
					case 'IMSSS:PRIMARYOBJECTIVE':
                    $obj_key                                                = $key;
                    $objective_ID                                           = $value['attributes']['OBJECTIVEID'];
                    $objective[$item_key][$obj_key]['is_primary']           = '1';
                    $objective[$item_key][$obj_key]['satisfied_by_measure'] = $value['attributes']['SATISFIEDBYMEASURE'];
                    /*
                    if($objective_ID == '') {
                    $objective_ID = 'empty_obj_id';
                    }
                    */
                    $objective[$item_key][$obj_key]['objective_ID']         = $objective_ID;
                    //pr($objective);
                    break;
                	case 'IMSSS:OBJECTIVE':
                    $obj_key                                                = $key;
                    $objective_ID                                           = $value['attributes']['OBJECTIVEID'];
                    $objective[$item_key][$obj_key]['is_primary']           = '0';
                    $objective[$item_key][$obj_key]['satisfied_by_measure'] = $value['attributes']['SATISFIEDBYMEASURE'];
                    $objective[$item_key][$obj_key]['objective_ID']         = $value['attributes']['OBJECTIVEID'];
                    break;
                	case 'IMSSS:MINNORMALIZEDMEASURE':
                    $objective[$item_key][$obj_key]['min_normalized_measure'] = $value['value'];
                    break;
                	
                	case 'ADLSEQ:OBJECTIVE':
                    $objective_ID = $value['attributes']['OBJECTIVEID'];
                    break;
					
					case 'ICN:OBJECTIVEPROGRESSINFO':
					$cur                        = $value['parent_index'];
                    $objective[$item_key][$obj_key]['PROGRESSSTATUS'] = $value['attributes']['PROGRESSSTATUS'];
					$objective[$item_key][$obj_key]['SATISFIEDSTATUS'] = $value['attributes']['SATISFIEDSTATUS'];
					$objective[$item_key][$obj_key]['MEASURESTATUS'] = $value['attributes']['MEASURESTATUS'];
					$objective[$item_key][$obj_key]['NORMALIZEDMEASURE'] = $value['attributes']['NORMALIZEDMEASURE'];
					$objective[$item_key][$obj_key]['RECORDEDINPRIORATTEMPT'] = $value['attributes']['RECORDEDINPRIORATTEMPT'];
                    break;
					
					
			}
		}
	//	print_r($objective);
		foreach($total_fields as $key2 => $value2 )
		{
			 
			$GET_ID = $GLOBALS['db']->Execute("select * from content where lessons_ID='" . $PK . "' and identifier='".$value2["IDENTIFIER"]."'");			
			$ndata = array();
			$activestate = array();
			$activestate["lessons_ID"]=trim($PK);
			$activestate["content_ID"]=trim($GET_ID->fields["id"]);
			$activestate["users_LOGIN"]=trim($_SESSION["learnerID"]);
			$activestate["is_active"]=trim($value2["ACTIVE"]);
			$ndata["content_ID"]=trim($GET_ID->fields["id"]);
			$ndata["users_LOGIN"]=trim($_SESSION["learnerID"]);
			$ndata["activity_progress_status"]=trim($value2["PROGRESSSTATUS"]);
			$ndata["activity_attempt_count"]=trim($value2["ATTEMPTCOUNT"]);
			
			ActiveinsertOrupdateTableData("scorm_sequencing_activity_state_information",$activestate," content_ID='" . $ndata["content_ID"] . "' and lessons_ID='".$activestate["lessons_ID"]."' and users_LOGIN='".$_SESSION["learnerID"]."' ");
			ActiveupdateTableData("scorm_sequencing_activity_progress_information",$ndata," content_ID='" . $ndata["content_ID"] . "' and users_LOGIN='".$_SESSION["learnerID"]."' ");
		
		foreach ($objective[$key2] as $key1 => $value1) {
		 	
			if($value1["objective_ID"]!="")
			{
			 
					
					
			$objvalues=array();
			$objvalues["content_ID"]=trim($activestate["content_ID"]);
			$objvalues["objective_ID"]=trim($value1["objective_ID"]);
			$objvalues["users_LOGIN"]=trim($_SESSION["learnerID"]);
			$objvalues["objective_progress_status"]=trim($value1["PROGRESSSTATUS"]);
			$objvalues["objective_satisfied_status"]=trim($value1["SATISFIEDSTATUS"]);
			$objvalues["objective_measure_status"]=trim($value1["MEASURESTATUS"]);
			$objvalues["objective_normalized_measure"]=trim($value1["NORMALIZEDMEASURE"]);
			$objvalues["activity_attempt_count"]=trim($value2["ATTEMPTCOUNT"]);
			$objvalues["description"]=trim($value1["is_primary"]);
			$objvalues["attempt_progress_status"]=trim($value2["PROGRESSSTATUS"]);
			$objvalues["attempt_completion_amount_status"]=trim($value2["COMPLETIONSTATUS"]);
			$objvalues["attempt_completion_amount"]=trim($value2["COMPLETIONAMOUNT"]);
			$objvalues["attempt_completion_status"]=trim($value2["ACTIVE"]);
			
			$objvalues["attempt"]=trim($value1["RECORDEDINPRIORATTEMPT"]);
			
			
			ActiveinsertOrupdateTableData("scorm_sequencing_objective_progress_information",$objvalues," content_ID='" . $objvalues["content_ID"] . "' and objective_ID='".$objvalues["objective_ID"]."' and users_LOGIN='".$_SESSION["learnerID"]."' ");

			}
			
 
		  
			
		}
			
		}
		}
		if($this->GetRequestType($post)=="Create")
		{
        $this->GenerateManfist('0', $organizations);
       	$GET_CONTENT_SEQ_COLLECTION = $GLOBALS['db']->Execute("select * from content where lessons_ID='" . $PK . "' and parent_content_ID='0'");
        if ($GET_CONTENT_SEQ_COLLECTION->fields["seqcollection"] != "") {
            $f = $dom->createDocumentFragment();
            $f->appendXML(trim($GET_CONTENT_SEQ_COLLECTION->fields["seqcollection"]));
            $dom->documentElement->appendChild($f);
        } //$GET_CONTENT_SEQ_COLLECTION->fields["seqcollection"] != ""
        $GlobalObjectiveAppend = $this->Activity($dom, 'globalObjectives', $manifest, '', '');
        if ($_SESSION["GlobalObjectives"] != null) {
            $CurentObjective = array_unique($_SESSION["GlobalObjectives"]);
            if ($CurentObjective != null) {
                foreach ($CurentObjective as $CurentOneObject) {
                    $CurentOne = $this->Activity($dom, 'objective', $GlobalObjectiveAppend, '', array(
                        'objectiveID' => $CurentOneObject
                    ));
                    $this->CreateObjectiveProgressInfoNOns($CurentOne);
                } //$CurentObjective as $CurentOneObject
            } //$CurentObjective != null
        } //$_SESSION["GlobalObjectives"] != null
        
		}
		
		$navRequest              = $dom->createElement('navRequest', $this->GetnavRequest($post));
        $navRequest              = $manifest->appendChild($navRequest);
        $syncClientServer        = $dom->createElement('syncClientServer', $this->GetSyncClientServer($post));
        $syncClientServer        = $manifest->appendChild($syncClientServer);
        $modeManifest            = $dom->createElement('mode', $this->GetLessonMode($post));
        $modeManifest            = $manifest->appendChild($modeManifest);
		
        $xml                     = new DOMDocument();
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput       = false;
		$xml->encoding = 'utf-8';
        $SoapOutput              = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body>';
        $SoapOutput .= $dom->saveHTML();
        $SoapOutput .= '</soap:Body></soap:Envelope>';
        $xml->loadXML($SoapOutput);
        return $xml->saveXML();
    }
    public function LMSnavigation($navdata, $element)
    {
        global $dom;
        $NAV_RS = $GLOBALS['db']->Execute("select * from scorm_sequencing_hide_lms_ui where content_ID='" . $navdata . "'  ");
        if (!$NAV_RS->EOF) {
            $DataArray  = unserialize(trim($NAV_RS->fields["options"]));
            $DataArray2 = unserialize(trim($NAV_RS->fields["options"]));
            $NavExist   = false;
            reset($DataArray);
            reset($DataArray2);
            while (list($key, $val) = each($DataArray)) {
                if ($key != "is_visible" and $key != "choice") {
                    $NavExist = true;
                    break;
                } //$key != "is_visible" and $key != "choice"
            } //list($key, $val) = each($DataArray)
            if ($NavExist) {
                $presentation  = $dom->createElementNS('http://www.adlnet.org/xsd/adlnav_v1p3', 'adlnav:presentation', '');
                $presentation  = $element->appendChild($presentation);
                $ADLNavigation = $this->Activity($dom, 'adlnav:navigationInterface', $presentation, '', '');
                while (list($key2, $val2) = each($DataArray2)) {
                    if ($key2 != "is_visible" and $key2 != "choice") {
                        $this->Activity($dom, 'adlnav:hideLMSUI', $ADLNavigation, trim($key2), '');
                    } //$key2 != "is_visible" and $key2 != "choice"
                } //list($key2, $val2) = each($DataArray2)
            } //$NavExist
        } //!$NAV_RS->EOF
    }
    public function createSeqCollection()
    {
        global $dom;
        global $doc;
        global $manifest;
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
            $manifest->appendChild($dom->importNode($seqInfo, true));
        } //$sequencingC
    }
    public function GenerateManfist($parent_content_ID, $parent_dom)
    {
        //this prevents printing 'ul' if we don't have subcategories for this category  
        $has_childs = false;
        //use global array variable instead of a local variable to lower stack memory requierment    
        global $dom;
        global $domManifest;
        global $PK;
        global $post;
        global $mode;
        foreach ($domManifest as $key => $value) {
            if ($value['parent_content_ID'] == $parent_content_ID) {
                //if this is the first child print '<ul>'                         
                if ($has_childs === false) {
                    //don't print '<ul>' multiple times                               
                    $has_childs = true;
                } //$has_childs === false
                if ($value['organization'] == "1") {
                    if ($_SESSION["od"] == 1) {
                        if ($value['parent_content_ID'] == 0) {
                            $GET_DEFAULT_ORGANIZATION = $GLOBALS['db']->Execute("select * from scorm_sequencing_organizations where lessons_ID='" . $PK . "' and content_ID='" . $value["id"] . "'  ");
                            $isDefault                = "true";
                        } //$value['parent_content_ID'] == 0
                        else {
                            $isDefault = null;
                        }
						
                        $elment = $this->Activity($dom, 'organization', $parent_dom, '', array(
                            
							'current' => 'false',
                            'resumable' => 'false',
                            'identifier' => trim($value['identifier']),
                            'isvisible' => trim($value['is_visible']),
                            'objectivesGlobalToSystem' => trim($GET_DEFAULT_ORGANIZATION->fields["objectives_global_to_system"]),
                            'schemaVersion' => trim($value['scorm_version']),
                            'isDefault' => trim($isDefault)
                        ));
                        
                        $this->Activity($dom, 'title', $elment, trim($value['name']), '');
                        $this->activityProgressInfo($value, $elment);
                        $this->CreateAttemptProgressInfo($elment);
                        $this->GenerateManfist($key, $elment);
                        $this->IMSSequencing($value['id'], $elment);
						 $this->Activity($dom, 'schema', $elment, 'ADL SCORM', '');
						 
                        //$_SESSION["od"]=0;
                    } //$_SESSION["od"] == 1
                } //$value['organization'] == "1"
                else {
					
                    $elment = $this->Activity($dom, 'item', $parent_dom, '', array(
						 
                        'current' => 'false',
                        'resumable' => 'false',
                        'isvisible' => $value['is_visible'],
                        'identifier' => $value['identifier']
                    ));
                    $this->Activity($dom, 'title', $elment, $value['name'], '');
                    $this->ItemOtherData($value['id'], $elment);
                    if ($value["identifierref"] != "") {
                        $this->Activity($dom, 'resource', $elment, '', array(
                            'scormType' => $value['scormtype'],
                            'type' => $value['reftype'],
                            'href' => $value['identifierref'],
                            'xml:base' => $value['base']
                        ));
                    } //$value["identifierref"] != ""
                    //<resource scormType="sco" type="webcontent" href="SCO-2.html"></resource>
                    $this->activityProgressInfo($value,$elment);
                    $this->CreateAttemptProgressInfo($elment);
                    $this->GenerateManfist($key, $elment);
                    $this->IMSSequencing($value['id'], $elment);
                    $this->LMSnavigation($value['id'], $elment);
                }
                //call function again to generate nested list for subcategories belonging to this category  
            } //$value['parent_content_ID'] == $parent_content_ID
        } //$domManifest as $key => $value
        if ($has_childs === true);
    }
    public function IMSSequencing($sid, $element)
    {
        global $dom;
        global $domManifest;
        global $PK;
        global $post;
        global $mode;
        global $GlobalObjectives;
		global $ScormVersion;
        $ITEM_SEQ_DATA = $GLOBALS['db']->Execute("select * from scorm_sequencing_content_to_organization where content_ID='" . trim($sid) . "' and lessons_ID='" . $PK . "'");
        if (!$ITEM_SEQ_DATA->EOF) {
            $seqroot               = $dom->createElementNS('http://www.imsglobal.org/xsd/imsss', 'imsss:sequencing', '');
            $seqroot               = $element->appendChild($seqroot);
            $ITEM_SEQ_CONTROL_MODE = $GLOBALS['db']->Execute("select * from scorm_sequencing_control_mode where content_ID='" . trim($sid) . "' ");
            if (!$ITEM_SEQ_CONTROL_MODE->EOF) {
				if($ScormVersion < 2004)
				{
                $this->Activity($dom, 'imsss:controlMode', $seqroot, '', array(
                  
                    'flow' => "true"
                    
                ));
				}
				else
				{
					$this->Activity($dom, 'imsss:controlMode', $seqroot, '', array(
                    'choice' => $ITEM_SEQ_CONTROL_MODE->fields["choice"],
                    'choiceExit' => $ITEM_SEQ_CONTROL_MODE->fields["choice_exit"],
                    'flow' => $ITEM_SEQ_CONTROL_MODE->fields["flow"],
                    'forwardOnly' => $ITEM_SEQ_CONTROL_MODE->fields["forward_only"],
                    'useCurrentAttemptObjectiveInfo' => $ITEM_SEQ_CONTROL_MODE->fields["use_current_attempt_objective_info"],
                    'useCurrentAttemptProgressInfo' => $ITEM_SEQ_CONTROL_MODE->fields["use_current_attempt_progress_info"]
                ));
				}
				 
            } //!$ITEM_SEQ_CONTROL_MODE->EOF
            $ITEM_SEQ_RULES = $GLOBALS['db']->Execute("select * from scorm_sequencing_rules where content_ID='" . trim($sid) . "' ");
            if (!$ITEM_SEQ_RULES->EOF) {
                while (!$ITEM_SEQ_RULES->EOF) {
                    $seqencingRules = $this->Activity($dom, 'imsss:seqencingRules', $seqroot, '', '');
                    if ($ITEM_SEQ_RULES->fields["rule_type"] == "0") {
                        $PrePostExitConditionRule = $this->Activity($dom, 'imsss:preConditionRule', $seqencingRules, '', '');
                        $ConditionRule            = $this->Activity($dom, 'imsss:ruleConditions', $PrePostExitConditionRule, '', array(
                            'conditionCombination' => $ITEM_SEQ_RULES->fields["condition_combination"]
                        ));
                    } //$ITEM_SEQ_RULES->fields["rule_type"] == "0"
                    if ($ITEM_SEQ_RULES->fields["rule_type"] == "1") {
                        $PrePostExitConditionRule = $this->Activity($dom, 'imsss:postConditionRule', $seqencingRules, '', '');
                        $ConditionRule            = $this->Activity($dom, 'imsss:ruleConditions', $PrePostExitConditionRule, '', array(
                            'conditionCombination' => $ITEM_SEQ_RULES->fields["condition_combination"]
                        ));
                    } //$ITEM_SEQ_RULES->fields["rule_type"] == "1"
                    if ($ITEM_SEQ_RULES->fields["rule_type"] == "2") {
                        $PrePostExitConditionRule = $this->Activity($dom, 'imsss:exitConditionRule', $seqencingRules, '', '');
                        $ConditionRule            = $this->Activity($dom, 'imsss:ruleConditions', $PrePostExitConditionRule, '', array(
                            'conditionCombination' => $ITEM_SEQ_RULES->fields["condition_combination"]
                        ));
                    } //$ITEM_SEQ_RULES->fields["rule_type"] == "2"
                    $ITEM_SEQ_RULES_RULE = $GLOBALS['db']->Execute("select * from scorm_sequencing_rule where scorm_sequencing_rules_ID='" . $ITEM_SEQ_RULES->fields["id"] . "' ");
                    if (!$ITEM_SEQ_RULES_RULE->EOF) {
                        $ConditionRuleRule = $this->Activity($dom, 'imsss:ruleCondition', $ConditionRule, '', array(
                            'operator' => $ITEM_SEQ_RULES_RULE->fields["operator"],
                            'referencedObjective' => $ITEM_SEQ_RULES_RULE->fields["referenced_objective"],
                            'condition' => $ITEM_SEQ_RULES_RULE->fields["rule_condition"],
                            'measureThreshold' => $ITEM_SEQ_RULES_RULE->fields["measure_threshold"]
                        ));
                    } //!$ITEM_SEQ_RULES_RULE->EOF
                    $this->Activity($dom, 'imsss:ruleAction', $PrePostExitConditionRule, '', array(
                        'action' => $ITEM_SEQ_RULES->fields["rule_action"]
                    ));
                    $ITEM_SEQ_RULES->MoveNext();
                } //!$ITEM_SEQ_RULES->EOF
            } //!$ITEM_SEQ_RULES->EOF
            $ITEM_SEQ_LIMIT_COND = $GLOBALS['db']->Execute("select * from scorm_sequencing_limit_conditions where content_ID='" . trim($sid) . "' ");
            if (!$ITEM_SEQ_LIMIT_COND->EOF) {
                $this->Activity($dom, 'imsss:limitConditions', $seqroot, '', array(
                    'attemptLimit' => $ITEM_SEQ_LIMIT_COND->fields["attempt_limit"],
                    'attemptAbsoluteDurationLimit' => $ITEM_SEQ_LIMIT_COND->fields["attempt_absolute_duration_limit"]
                ));
            } //!$ITEM_SEQ_LIMIT_COND->EOF
            $ITEM_SEQ_ROLLUPS = $GLOBALS['db']->Execute("select * from scorm_sequencing_rollup_controls where content_ID='" . trim($sid) . "' ");
            if (!$ITEM_SEQ_ROLLUPS->EOF) {
                $this->Activity($dom, 'imsss:rollupRules', $seqroot, '', array(
                    'rollupObjectiveSatisfied' => $ITEM_SEQ_ROLLUPS->fields["rollup_objective_satisfied"],
                    'rollupProgressCompletion' => $ITEM_SEQ_ROLLUPS->fields["rollup_progress_completion"],
                    'objectiveMeasureWeight' => $ITEM_SEQ_ROLLUPS->fields["rollup_objective_measure_weight"]
                ));
				 
            } //!$ITEM_SEQ_ROLLUPS->EOF
            $objectives          = $this->Activity($dom, 'imsss:objectives', $seqroot, '', '');
            $ITEM_SEQ_OBJECTIVES = $GLOBALS['db']->Execute("select * from scorm_sequencing_objectives where content_ID='" . trim($sid) . "' ");
            if (!$ITEM_SEQ_OBJECTIVES->EOF) {
                while (!$ITEM_SEQ_OBJECTIVES->EOF) {
                    $ITEM_SEQ_OBJECTIVES_MAP = $GLOBALS['db']->Execute("select * from scorm_sequencing_map_info where content_ID='" . trim($sid) . "' and objective_ID='" . $ITEM_SEQ_OBJECTIVES->fields["objective_ID"] . "' ");
                    if ($ITEM_SEQ_OBJECTIVES->fields["is_primary"] == 1) {
                        $objective = $this->Activity($dom, 'imsss:primaryObjective', $objectives, '', array(
                            'objectiveID' => $ITEM_SEQ_OBJECTIVES->fields["objective_ID"],
                            'satisfiedByMeasure' => $ITEM_SEQ_OBJECTIVES->fields["satisfied_by_measure"]
                        ));
                        $this->Activity($dom, 'imsss:minNormalizedMeasure', $objective, trim($ITEM_SEQ_OBJECTIVES->fields["min_normalized_measure"]), '');
                    } //$ITEM_SEQ_OBJECTIVES->fields["is_primary"] == 1
                    else {
                        $objective = $this->Activity($dom, 'imsss:objective', $objectives, '', array(
                            'objectiveID' => $ITEM_SEQ_OBJECTIVES->fields["objective_ID"],
                            'satisfiedByMeasure' => $ITEM_SEQ_OBJECTIVES->fields["satisfied_by_measure"]
                        ));
                        $this->Activity($dom, 'imsss:minNormalizedMeasure', $objective, trim($ITEM_SEQ_OBJECTIVES->fields["min_normalized_measure"]), '');
                    }
                    if (!$ITEM_SEQ_OBJECTIVES_MAP->EOF) {
                        $GlobalObjectives[] = $ITEM_SEQ_OBJECTIVES_MAP->fields["target_objective_ID"];
                        $this->Activity($dom, 'imsss:mapInfo', $objective, '', array(
                            'targetObjectiveID' => $ITEM_SEQ_OBJECTIVES_MAP->fields["target_objective_ID"],
                            'readNormalizedMeasure' => $ITEM_SEQ_OBJECTIVES_MAP->fields["read_normalized_measure"],
                            'readSatisfiedStatus' => $ITEM_SEQ_OBJECTIVES_MAP->fields["read_satisfied_status"],
                            'writeSatisfiedStatus' => $ITEM_SEQ_OBJECTIVES_MAP->fields["satisfied_by_measure"],
                            'writeNormalizedMeasure' => $ITEM_SEQ_OBJECTIVES_MAP->fields["write_normalized_measure"]
                        ));
                    } //!$ITEM_SEQ_OBJECTIVES_MAP->EOF
                    $this->CreateObjectiveProgressInfo($objective);
                    $ITEM_SEQ_OBJECTIVES->MoveNext();
                } //!$ITEM_SEQ_OBJECTIVES->EOF
            } //!$ITEM_SEQ_OBJECTIVES->EOF
            $ITEM_SEQ_MAP_CONSIDER = $GLOBALS['db']->Execute("select * from scorm_sequencing_rollup_considerations where content_ID='" . trim($sid) . "' ");
            if (!$ITEM_SEQ_MAP_CONSIDER->EOF) {
               $seq_map_con = $dom->createElementNS('http://www.adlnet.org/xsd/adlseq_v1p3', 'adlseq:rollupConsiderations', '');
                $seq_map_con->setAttribute("requiredForSatisfied", $ITEM_SEQ_MAP_CONSIDER->fields["required_for_satisfied"]);
                $seq_map_con->setAttribute("requiredForNotSatisfied", $ITEM_SEQ_MAP_CONSIDER->fields["required_for_not_satisfied"]);
                $seq_map_con->setAttribute("requiredForCompleted", $ITEM_SEQ_MAP_CONSIDER->fields["required_for_completed"]);
                $seq_map_con->setAttribute("requiredForIncomplete", $ITEM_SEQ_MAP_CONSIDER->fields["required_for_incomplete"]);
                $seq_map_con->setAttribute("measureSatisfactionIfActive", $ITEM_SEQ_MAP_CONSIDER->fields["measure_satisfaction_if_active"]);
                $seq_map_con = $seqroot->appendChild($seq_map_con);
				 
            } //!$ITEM_SEQ_MAP_CONSIDER->EOF
            $_SESSION["GlobalObjectives"] = $GlobalObjectives;
        } //!$ITEM_SEQ_DATA->EOF
    }
    public function ItemOtherData($sid, $element)
    {
        global $dom;
        global $domManifest;
        global $PK;
        global $post;
        global $mode;
        $ITEM_OTHER_DATA = $GLOBALS['db']->Execute("select * from scorm_data_2004 where content_ID='" . trim($sid) . "' and users_LOGIN='MASTER-LOGIN'");
        if ($ITEM_OTHER_DATA->fields["datafromlms"] != null) {
            $this->Activity($dom, 'dataFromLMS', $element, $ITEM_OTHER_DATA->fields["datafromlms"], '');
        } //$ITEM_OTHER_DATA->fields["datafromlms"] != null
        if ($ITEM_OTHER_DATA->fields["maxtimeallowed"] != null) {
            $this->Activity($dom, 'maxtimeallowed', $element, $ITEM_OTHER_DATA->fields["maxtimeallowed"], '');
        } //$ITEM_OTHER_DATA->fields["maxtimeallowed"] != null
        if ($ITEM_OTHER_DATA->fields["masteryscore"] != null) {
            $this->Activity($dom, 'masteryscore', $element, $ITEM_OTHER_DATA->fields["masteryscore"], '');
        } //$ITEM_OTHER_DATA->fields["masteryscore"] != null
        if ($ITEM_OTHER_DATA->fields["timelimitaction"] != null) {
            $this->Activity($dom, 'timeLimitAction', $element, $ITEM_OTHER_DATA->fields["timelimitaction"], '');
        } //$ITEM_OTHER_DATA->fields["timelimitaction"] != null
        $ITEM_OTHER_THRESH = $GLOBALS['db']->Execute("select * from scorm_sequencing_completion_threshold where content_ID='" . trim($sid) . "' ");
        if ($ITEM_OTHER_THRESH->fields["threshinside"] != null) {
            $this->Activity($dom, 'completionThreshold', $element, $ITEM_OTHER_THRESH->fields["threshinside"], array(
                'completedByMeasure' => $ITEM_OTHER_THRESH->fields["completed_by_measure"],
                'minProgressMeasure' => $ITEM_OTHER_THRESH->fields["min_progress_measure"],
                'progressWeight' => $ITEM_OTHER_THRESH->fields["progress_weight"]
            ));
        } //$ITEM_OTHER_THRESH->fields["threshinside"] != null
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
    public function activityProgressInfo($value, $element)
    {
        global $dom;
		
	
	$GET_ACT_INFO = $GLOBALS['db']->Execute("select * from scorm_sequencing_activity_progress_information where content_ID='" . $value["id"] . "' and users_LOGIN='".$_SESSION["learnerID"]."'");
	$arrayF=array();
	$arrayF["content_ID"]=$value["id"];
	$arrayF["users_LOGIN"]=$_SESSION["learnerID"];
	$arrayF["activity_progress_status"]="true";
	if($GET_ACT_INFO->fields["activity_attempt_count"]==null)
	{
	$arrayF["activity_attempt_count"]="0";
	}
	else
	{
	$arrayF["activity_attempt_count"]=$GET_ACT_INFO->fields["activity_attempt_count"];	
	}
	if($GET_ACT_INFO->EOF)
	{
	ActiveinsertTableData('scorm_sequencing_activity_progress_information',$arrayF);
	}
        $this->Activity($dom, 'activityProgressInfo', $element, '', array(
            'progressStatus' => $arrayF["activity_progress_status"],
            'attemptCount' => $arrayF["activity_attempt_count"]
        ));
    }
    public function domainID($post)
    {
        global $doc;
        global $post;
        $domainID = $post->getElementsByTagName('organizations')->item(0)->getElementsByTagName('identifiers')->item(0)->getAttribute('domainID');
        return $domainID;
    }
    public function learnerID($post)
    {
        global $doc;
        global $post;
        $learnerID = $post->getElementsByTagName('organizations')->item(0)->getElementsByTagName('identifiers')->item(0)->getAttribute('learnerID');
        return $learnerID;
    }
    public function courseID($post)
    {
        global $doc;
        global $post;
        $courseID = $post->getElementsByTagName('organizations')->item(0)->getElementsByTagName('identifiers')->item(0)->getAttribute('courseID');
        return $courseID;
    }
    public function sessionID($post)
    {
        global $doc;
        global $post;
        $sessionID = $post->getElementsByTagName('organizations')->item(0)->getElementsByTagName('identifiers')->item(0)->getAttribute('sessionID');
        return $sessionID;
    }
    public function GetRequestType($post)
    {
        global $doc;
        global $post;
        $Deliver   = $post->getElementsByTagName("Deliver")->item(0);
        $Create    = $post->getElementsByTagName("Create")->item(0);
        $Resume    = $post->getElementsByTagName("Resume")->item(0);
        $Terminate = $post->getElementsByTagName("Terminate")->item(0);
        if ($Resume) {
            $GetRequestType = "Resume";
            return $GetRequestType;
        } //$Resume
        if ($Create) {
            $GetRequestType = "Create";
            return $GetRequestType;
        } //$Create
        if ($Deliver) {
            $GetRequestType = "Deliver";
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
    public function CreateObjectiveProgressInfoNOns($element)
    {
        global $dom;
        $objectiveProgressInfo = $dom->createElement('objectiveProgressInfo', '');
        $objectiveProgressInfo->setAttribute('progressStatus', 'false');
        $objectiveProgressInfo->setAttribute('satisfiedStatus', 'false');
        $objectiveProgressInfo->setAttribute('measureStatus', 'false');
        $objectiveProgressInfo->setAttribute('normalizedMeasure', '0.0');
        $objectiveProgressInfo->setAttribute('recordedInPriorAttempt', 'false');
        $element->appendChild($objectiveProgressInfo);
        return $element;
    }
    public function CreateObjectiveProgressInfo($element)
    {
        global $dom;
        $icn_objectiveProgressInfo = $dom->createElementNS('http://www.activelms.com/services/ss', 'icn:objectiveProgressInfo', '');
        $icn_objectiveProgressInfo->setAttribute('progressStatus', 'false');
        $icn_objectiveProgressInfo->setAttribute('satisfiedStatus', 'false');
        $icn_objectiveProgressInfo->setAttribute('measureStatus', 'false');
        $icn_objectiveProgressInfo->setAttribute('normalizedMeasure', '0.0');
        $icn_objectiveProgressInfo->setAttribute('recordedInPriorAttempt', 'false');
        $element->appendChild($icn_objectiveProgressInfo);
        return $element;
    }
    public function CreateAttemptProgressInfo($element)
    {
        global $dom;
        $this->Activity($dom, 'attemptProgressInfo', $element, '', array(
            'recordedInPriorAttempt' => 'false',
            'progressStatus' => 'false',
            'completionStatus' => 'false',
            'completionAmount' => '0'
        ));
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