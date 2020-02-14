// Confirm dialog messages
var ICN_CONFIRM_ABANDON = "";
var ICN_CONFIRM_SUSPEND_ALL = "";
var ICN_CONFIRM_ABANDON_ALL = "";

// Window events
var ICN_WINDOW_CLOSED_EVT = false;


//window.onbeforeunload = doUnloadMain;
window.onunload = doUnloadMain;

function doUnloadMain(){
    if(ICN_WINDOW_CLOSED_EVT){return;}
    try {
    	if (typeof(ICN_API) != "undefined" && ICN_API != null) {
		
            ICN_WINDOW_CLOSED_EVT = true;
            
            // Assume it is the responsibility of the SCO to terminate, unless overidden
            if(b_IsSetToTerminate){
            
                // Get the properties currently held by the model
	            var str_ScormType = ICN_MODEL.get("scormType");

			    // Invoke CMI Data Model Service, if SCO was last resource type AND unterminated
			    if(str_ScormType==ICN_SCORM_TYPE_SCO){
			        if(!ICN_API.isTerminated){
				        if(API_1484_11 && API_1484_11.Terminate){
                            API_1484_11.Terminate("");
                        }
                        else if(API && API.LMSFinish){
                            API.LMSFinish("");
                        }
                    }
			    }
		    }

			// Invoke the Sequencing Service, if the sequencing session is not finished.
			if(!activelms.SequencingBehaviour.isSequencingFinished){
                doExecuteAction(activelms.SequencingEngine.EXIT_ALL, null, exitMvcCallback);
            }
		} 
	}
	catch (obj_Error) {
		if(ICN_API && ICN_API.DEBUG){
			//log.error(obj_Error.message);
		}
	}
}

// Called after the UI is built for the first time
function doInit(){
    doExecuteAction(activelms.SequencingEngine.INIT, null, initMvcCallback);
}

// Session intialize events
function doOrganizations(str_TargetOrgID){

    // Cache the orgID for any callback
    ICN_PENDING_ORG_REQUEST = str_TargetOrgID;

    // See if the sequencing session has begun
    var str_ScoID = ICN_MODEL.get("scoID");
    
    if(isUndefined(str_ScoID)){
          // Sequencing session not started, just start
          var obj_ModelAndView = new activelms.ModelAndView(ICN_MODEL);
          orgMvcCallback(obj_ModelAndView);
    }
    else{
        // Sequencing session started, EXIT_ALL, and then call back.
        doExecuteAction(activelms.SequencingEngine.EXIT_ALL, undefined, orgMvcCallback);	
    }
}

function doStart(){	
    doExecuteAction(activelms.SequencingEngine.START, undefined, mvcCallback);   
}

function doCurrent(){	
    // target the current activity with a choice navigation request
    var str_ScoID = ICN_MODEL.get("mostRecentScoID"); 
    doChoice(str_ScoID);  
}
	
function doResumeAll(){	
    doExecuteAction(activelms.SequencingEngine.RESUME_ALL, undefined, mvcCallback);   
}
	
// Session run events
function doPrevious(){	
    ICN_API.adlNavRequest = activelms.SequencingEngine.PREVIOUS; 
    doUnload();  
}
	
function doContinue(){	
    ICN_API.adlNavRequest = activelms.SequencingEngine.CONTINUE;   
    doUnload();   
}

function doChoice(str_ScoID){	
    //"{target=intro}choice";  
    ICN_API.adlNavRequest = ICN_ADL_NAV_TARGET_STRING + str_ScoID + ICN_ADL_NAV_TARGET_STRING_CLOSE;
    doUnload();   
}

function doJump(str_ScoID){	
    //"{target=intro}choice";  
    ICN_API.adlNavRequest = ICN_ADL_NAV_TARGET_STRING + str_ScoID + ICN_ADL_NAV_TARGET_STRING_CLOSE_JUMP;
    doUnload();   
}
	
function doExit(){	
    ICN_PENDING_NAV_REQUEST = activelms.SequencingEngine.EXIT;
    doUnload();  
}
	
function doAbandon(b_Confirm){	

    if(isUndefined(b_Confirm)){
	    var str_Title = ICN_MODEL.get("title");
	    var str_Message = ICN_CONFIRM_ABANDON + ": " + str_Title + "?"
        doConfirm(str_Message, doAbandon);
    }
    else if(b_Confirm==true){
        ICN_PENDING_NAV_REQUEST = activelms.SequencingEngine.ABANDON;
        doUnload();
    }
}

// Session expiration events
function doExpireAll(){
    if(!activelms.SequencingBehaviour.isSequencingFinished){
        ICN_PENDING_NAV_REQUEST = activelms.SequencingEngine.EXPIRE_ALL;
        doUnload();  
    }
    else{
        expireMvcCallback();
    }
}
	
// Session end events
function doExitAll(){
    ICN_PENDING_NAV_REQUEST = activelms.SequencingEngine.EXIT_ALL;
    doUnload();  
}

function doSuspendAll(b_Confirm){	 
    if(isUndefined(b_Confirm)){
	    var str_Title = ICN_MODEL.get("title");
	    var str_Message = ICN_CONFIRM_SUSPEND_ALL + ": " + str_Title + "?";
        doConfirm(str_Message, doSuspendAll);
    }
    else if(b_Confirm==true){
        doExecuteAction(activelms.SequencingEngine.SUSPEND_ALL, undefined, mvcCallback);
    }
}
    
function doAbandonAll(b_Confirm){
    if(isUndefined(b_Confirm)){
	    var str_Message = ICN_CONFIRM_ABANDON_ALL +"?"
        doConfirm(str_Message, doAbandonAll);
    }
    else if(b_Confirm==true){
        doExecuteAction(activelms.SequencingEngine.ABANDON_ALL, undefined, mvcCallback);	 
    }
}

function doServiceCall(b_Confirm){
    if(isUndefined(b_Confirm)){
	    var str_Message = "Would you like to see SCORM tracking data for your session?"
        doConfirm(str_Message, doServiceCall);
    }
    else if(b_Confirm==true){
        // Update the frame
	    var obj_Main = document.getElementById("main");
	    obj_Main.style.visibility="visible";
	    obj_Main.src  = "tracking.php";
    }
}

function doUnload(){

	doDisableControls(true);
	var obj_Main = document.getElementById("main");
	var str_Url = ICN_MODEL.get("viewUnloaderUrl"); 
	str_Url += "?skinID=";
	str_Url += ICN_MODEL.get("skinID");
	str_Url += "&culture=";
	str_Url += ICN_MODEL.get("culture");
	obj_Main.src  = str_Url;
	//obj_Main.src  = "LMSWait.html";

	//obj_Main.style.visibility="hidden";
    //doUpdateView("LMSUnloader.aspx");
}

// Called by LMSUnloader.aspx
function doTerminate(){

    // Model values
    var str_ScormType = ICN_MODEL.get("scormType");

    switch(str_ScormType){
        
        case ICN_SCORM_TYPE_ASSET:
            onSCOTerminated();
        break;
        
        case ICN_SCORM_TYPE_SCO:
		    if(!ICN_API.isTerminated){
			    var str_Result = ICN_API.Terminate(ICN_EMPTY_STR);
			    if(str_Result == ICN_FALSE){
				    onSCOTerminated();
			    }
            }
            else{
                onSCOTerminated();
            }
        break;
        
		default:
            doAjaxError("Unrecognised scorm type: " + str_ScormType);
    }
}

function onAPIEvent(str_Code, str_Action, str_ScoID, str_AdlNavRequest, str_Exit) {

    if (str_Action == ICN_INITIALIZE) {
        if (str_Code == ICN_NO_ERROR) {
            onSCOInitialized(str_ScoID);
        } else {
            var str_ErrorMsg = "Error on initialize with SCO: " + str_ScoID + ", Error code: " + str_Code;
            doAjaxError(new Error(str_ErrorMsg));
        }
    } else if (str_Action == ICN_COMMIT) {
        if (str_Code == ICN_NO_ERROR) {
            onSCOCommitted(str_ScoID);
        } else {
            var str_ErrorMsg  = "Error on commit with SCO: " + str_ScoID + ", Error code: " + str_Code;
            doAjaxError(new Error(str_ErrorMsg));
        }
    } else if (str_Action == ICN_TERMINATE) {
        if (str_Code == ICN_NO_ERROR) {
            onSCOTerminated(str_ScoID,str_Exit);
        }   
		else {
            var str_ErrorMsg  = "Error on terminate with SCO: " + str_ScoID + ", Error code: " + str_Code;
            doAjaxError(new Error(str_ErrorMsg));
        }
    }
}

function isValidURI(str_Identifier){

    // String properties
    if(typeof(str_Identifier) == "undefined"){return false;}
    if(str_Identifier == "undefined"){return false;}
    if(str_Identifier === null){return false;}
    if(str_Identifier.length === 0){return false;}
    if(str_Identifier.length > 4000){return false;}
    
	// Any white space
	var reg = new RegExp("\\s");
	if (reg.test(str_Identifier)){return false;}
		
	// Any non-word character [^A-Za-z0-9] fails for "gObj-OB14a-1"
	//reg = new RegExp("\\W");
	//if (reg.test(str_Identifier)){return false;}
	
	return true;
}

/**
 * This method includes the way in which LMS intializes the SCOs
 * cmi.objectives data model elements found in the activities 
 * tracking data. See 4.9.2. Content Delivery Environment Process.
 */
function onSCOInitialized(str_ScoID){

    // Get the model propertes from the activity tree
    var f_CompletionThreshold = ICN_MODEL.get("completionThreshold");
    var str_LaunchData = ICN_MODEL.get("launchData");
    var str_MaxTimeAllowed = ICN_MODEL.get("maxTimeAllowed");
    var f_ScaledPassingScore = ICN_MODEL.get("scaledPassingScore");
    var str_TimeLimitAction = ICN_MODEL.get("timeLimitAction");
    var b_Tracked = ICN_MODEL.get("tracked");
    var str_LessonMode = ICN_MODEL.get("mode");
    var int_AttemptCount = ICN_MODEL.get("attemptCount");
    
    // The SCO will also need to update the state of the tree...
	if(str_LessonMode!="browse"){
        var str_CompletionStatus = globalAdapter.getElementText(globalAdapter.cocd, "completionStatus");
        var b_ProgressStatus = false;
        var b_CompletionStatus = false;
        switch(str_CompletionStatus){
            case "unknown":
            b_ProgressStatus = false;
            b_CompletionStatus = false;
            break;
            case "not attempted":
            b_ProgressStatus = false;
            b_CompletionStatus = false;
            break;
            case "incomplete":
            b_ProgressStatus = true;
            b_CompletionStatus = false;
            break;
            case "completed":
            b_ProgressStatus = true;
            b_CompletionStatus = true;
            break;
        }
        
        // Not strictly SCORM, but helpful to users
        if(int_AttemptCount > 1){
            b_ProgressStatus = true;
        }
        window.doSetCompletionStatus(str_ScoID, b_ProgressStatus, b_CompletionStatus);
    }
    

    // Update the API Adapter with activity tree properties
	if(!isUndefined(f_CompletionThreshold)){
        globalAdapter.setElementText(globalAdapter.cocd, "completionThreshold", f_CompletionThreshold.toString());
    }
    globalAdapter.setElementText(globalAdapter.cocd, "launchData", str_LaunchData);
    globalAdapter.setElementText(globalAdapter.cocd, "mode", str_LessonMode);
    globalAdapter.setElementText(globalAdapter.cocd, "maxTimeAllowed", str_MaxTimeAllowed);
	if(!isUndefined(f_ScaledPassingScore)){
        globalAdapter.setElementText(globalAdapter.cocd, "scaledPassingScore", f_ScaledPassingScore.toString());
    }
    globalAdapter.setElementText(globalAdapter.cocd, "timeLimitAction", str_TimeLimitAction);
        
    // Do not initialize tracking data for a new attempt if browse or review?
    //if(str_LessonMode != "normal"){return;}
    
    // The cmi.objectives.n. 
    var cmi_Objectives = globalAdapter.getElement(globalAdapter.cocd, "objectives");
    //var cmi_Objective = undefined;
    //var cmi_Score = undefined;
    //var cmi_Scaled = undefined;
    
    // The sequencing tracking model
    var arr_ObjectiveSet = ICN_MODEL.get("objectiveSet");

    var int_Count = arr_ObjectiveSet.length;
    var str_ObjectiveID = undefined;
    var obj_ObjProgressInfo = undefined;
    var str_SuccessStatus = "unknown";
    var f_ScoreScaled = undefined;
    var b_SatisfiedStatusReadMap = false;
    var b_NormalizedMeasureReadMap = false;
    
    for(var i=0; i<int_Count; i++){
    
        // cmi.objectives.n.id
        str_ObjectiveID = arr_ObjectiveSet[i].getObjectiveID();
        b_SatisfiedStatusReadMap = arr_ObjectiveSet[i].hasSatisfiedStatusReadMap();
        b_NormalizedMeasureReadMap = arr_ObjectiveSet[i].hasNormalizedMeasureReadMap();
        
        // Only initialize objectives for valid IDs
        if(!isValidURI(str_ObjectiveID)){
            continue;
        }

        obj_ObjProgressInfo = arr_ObjectiveSet[i].getObjectiveProgressInfo();
        
        // cmi.objectives.n.success_status
        str_SuccessStatus = "unknown";
        if(obj_ObjProgressInfo.getProgressStatus()){
            str_SuccessStatus = "failed";
            if(obj_ObjProgressInfo.getSatisfiedStatus()){
                str_SuccessStatus = "passed";
            }
        }
        
        // cmi.objectives.n.score.scaled
        f_ScoreScaled = undefined;
        if(obj_ObjProgressInfo.getMeasureStatus()){
            f_ScoreScaled = obj_ObjProgressInfo.getNormalizedMeasure();
            if((f_ScoreScaled < -1.0) || (f_ScoreScaled > 1.0)){
                f_ScoreScaled = undefined;
            }
        }
        
        // The find the cmi.objectives.n...
        var cmi_Objective = globalAdapter.findObjectiveById(cmi_Objectives, str_ObjectiveID);

        // Or create
        if(typeof(cmi_Objective) == "undefined" || cmi_Objective===null){
            cmi_Objective = globalAdapter.newElement("objective");
            cmi_Objectives.appendChild(cmi_Objective);
            globalAdapter.setElementText(cmi_Objective, "identifier", str_ObjectiveID);
            globalAdapter.setElementText(cmi_Objective, "successStatus", "unknown");
            globalAdapter.setElementText(cmi_Objective, "completionStatus", "unknown");
        }
        
        /*
        * S & N
        * The LMS will return "unknown" for all status evaluations on the "not
        * tracked" activity. However, if a "read" Objective Map exists then 
        * the information will be used to initialize the SCO’s Run-Time 
        * Environment cmi.objectives collection 
        * (refer to Section 4.2.17: Objectives found in the Run-Time Environment book).
        */
        
        /*
        * The SCO’s objective data model elements shall be initialized even if the SCO’s
        * associated activity is not tracked (tracked = False). In these cases, 
        * "read" objective maps shall be applied to initialize objective state. 
        * When no "read" objective maps are defined, the initialized 
        * objectives shall have default (unknown)state.
        */
        
        /*
        * activelms interpretation is PSEUDO code
        * IF (activity.tracked==true)
        *   THEN initialze with state from the activity tree
        * IF (activity.tracked==false && objective.hasReadMaps)
            IF the state form the activity tree is NOT unknown
        *       THEN initialze with state from the activity tree
        * ELSE
        *   //THEN initialze with default state
        */
        
        /*
        alert("Objective=" + str_ObjectiveID
        + ", b_Tracked=" + b_Tracked
        + ", b_SatisfiedStatusReadMap=" + b_SatisfiedStatusReadMap
        + ", b_NormalizedMeasureReadMap=" + b_NormalizedMeasureReadMap
        );
        */

        if(b_Tracked==true){
            globalAdapter.setElementText(cmi_Objective, "successStatus", str_SuccessStatus);
        }
        else if(b_Tracked==false && b_SatisfiedStatusReadMap){
            if(str_SuccessStatus != "unknown"){
                globalAdapter.setElementText(cmi_Objective, "successStatus", str_SuccessStatus);
            }
        }
        else{
            //globalAdapter.setElementText(cmi_Objective, "successStatus", "unknown");
        }

        if(typeof(f_ScoreScaled) != "undefined"){

            var cmi_Score = globalAdapter.getElement(cmi_Objective, "score");
            if(typeof(cmi_Score) == "undefined" || cmi_Score===null){
                cmi_Score = globalAdapter.newElement("score");
                cmi_Objective.appendChild(cmi_Score);
                
                var cmi_Scaled = globalAdapter.getElement(cmi_Score, "scaled");
                if(typeof(cmi_Scaled) == "undefined" || cmi_Scaled===null){
                    cmi_Scaled = globalAdapter.newElement("scaled");
                    cmi_Score.appendChild(cmi_Scaled);
                }
             }

            if(b_Tracked==true){
                globalAdapter.setElementText(cmi_Score, "scaled", f_ScoreScaled.toString());
            }
            else if(b_Tracked==false && b_NormalizedMeasureReadMap){
                if(typeof(f_ScoreScaled) != "undefined"){
                    globalAdapter.setElementText(cmi_Score, "scaled", f_ScoreScaled.toString());
                }
            }
            else{
                //undefined
            }
         }
    }
}

function onSCOCommitted(str_ScoID){
}

function onSCOTerminated(str_ScoID,str_Exit){

    if(typeof(ICN_API)=="undefined" 
        || 
        ICN_API==null){
        return;
    }
    

	if(window.API_1484_11){
        obj_Cocd = window.API_1484_11.cocd;
        // Map cocd state to activity tree for caching until end attempt process for SCORM 2004 only
        ICN_MODEL.put("cocd", window.API_1484_11.cocd);
	}
	else if(window.API){
        // in SCORM 1.2, the tracking model is not used to influence sequencing, but we need acces to exit
        ICN_MODEL.put("cocd", window.ICN_API.cocd);
	}

	// Get the pending navigation request and target, could have been set by the SCO
	var str_AdlNavChoiceTarget = ICN_API.adlNavChoiceTarget;
	var str_AdlNavRequest = ICN_API.adlNavRequest;
	
	if(window.API){
	    // In SCORM 1.2, user has logged out from within the SCO, and so control is passed to the LMS
	    if(str_Exit == ICN_LOGOUT){str_AdlNavRequest = activelms.SequencingEngine.EXIT;}
	}

	if(str_AdlNavRequest.indexOf(ICN_ADL_NAV_TARGET_STRING) != -1){
		str_AdlNavChoiceTarget = getAdlNavChoiceTarget(str_AdlNavRequest);
		str_AdlNavRequest = activelms.SequencingEngine.CHOICE;
	}
	
	if(typeof(ICN_PENDING_NAV_REQUEST) != "undefined"){
		str_AdlNavRequest = ICN_PENDING_NAV_REQUEST;
		ICN_PENDING_NAV_REQUEST = undefined;
	}
	
	var b_Valid = isNavRequestSyntaxValid(str_AdlNavRequest);
	if(b_Valid){
	    if(str_AdlNavRequest == activelms.SequencingEngine.EXPIRE_ALL){
		    doExecuteAction(activelms.SequencingEngine.EXIT_ALL, undefined, expireMvcCallback);
	    }
	    else{
		    doExecuteAction(str_AdlNavRequest, str_AdlNavChoiceTarget, mvcCallback);
		}
	}
}

function isNavRequestSyntaxValid(str_AdlNavRequest) {
    if (str_AdlNavRequest == activelms.SequencingEngine.INIT){return true;}
    else if (str_AdlNavRequest == activelms.SequencingEngine.START){return true;}
    else if (str_AdlNavRequest == activelms.SequencingEngine.CONTINUE){return true;}
    else if (str_AdlNavRequest == activelms.SequencingEngine.PREVIOUS){return true;}
	else if (str_AdlNavRequest == activelms.SequencingEngine.CHOICE){return true;}
	else if (str_AdlNavRequest == activelms.SequencingEngine.ABANDON){return true;}
	else if (str_AdlNavRequest == activelms.SequencingEngine.EXIT){return true;}
    else if (str_AdlNavRequest == activelms.SequencingEngine.EXIT_ALL){return true;}
    else if (str_AdlNavRequest == activelms.SequencingEngine.EXPIRE_ALL){return true;}
    else if (str_AdlNavRequest == activelms.SequencingEngine.RESUME_ALL){return true;}
	else if (str_AdlNavRequest == activelms.SequencingEngine.SUSPEND_ALL){return true;}
	else if (str_AdlNavRequest == activelms.SequencingEngine.ABANDON_ALL){return true;}
    return false;
}

function getAdlNavChoiceTarget(str_AdlNavRequest){
	return str_AdlNavRequest.substring(
		str_AdlNavRequest.indexOf("=")+1, 
		str_AdlNavRequest.indexOf("}")
	);
}

/**
 * Main entry point to the MVC.
 * 
 * @param {String} str_Action the action to me invoked by the controller
 * @param {String} str_AdlNavChoiceTarget the activity identifier for a "choice" action
 * @param {Function} fn_Callback the function name that the controller will call back to
 */  
function doExecuteAction(str_Action, str_AdlNavChoiceTarget, fn_Callback){

	try{
	    // Always disable controls at the start of a request
	    doDisableControls(true);
	    
	    // Show the progress indicator
        doShowProgress();
	   
	    // Invoke an MVC action
	    activelms.Controller.execute(
	        str_Action, 
	        str_AdlNavChoiceTarget, 
	        window.ICN_MODEL, 
	        fn_Callback);
    }
	catch(error){
	    doAjaxError(error);
	}	
}

/**
 * Function called after an MVC action to invoke the ActivityTreeAcessor 
 * operation on the sequencing service. The call to the sequencing service
 * populates some values in the model and this method then updates
 * the SCORM API Adapter.
 *
 * @param {activelms.ModelAndView} obj_ModelAndView the updated model and view
 */
function initMvcCallback(obj_ModelAndView){

    // Action called back, so execution by MVC is over
    ICN_ACTION_EXECUTED = false;
    
    var obj_Error = obj_ModelAndView.get("error");
    if(!isUndefined(obj_Error)){
        doAjaxError(obj_Error)
    }
    else{
        var obj_ActivityTree = obj_ModelAndView.get("activityTree");
	    var float_ScormVersion = obj_ActivityTree.getScormVersion();
	    var b_IsDebugAjax = obj_ModelAndView.get("isDebugAjax");
	    var str_SoapAddressLocation = obj_ModelAndView.get("CMIRunEndPoint");
	    var str_Mode = obj_ModelAndView.get("mode");

	    // Instantiate the API Adapter ready for any SCO
	    createAPIAdapter(float_ScormVersion, b_IsDebugAjax, str_SoapAddressLocation, str_Mode);

	    // Add properties to the API Adapter
	    ICN_API.learnerName = obj_ModelAndView.get("learnerName");
	    ICN_API.learnerId = obj_ModelAndView.get("learnerID");
    	ICN_API.courseId = obj_ModelAndView.get("courseID");
  	    ICN_API.orgId = obj_ModelAndView.get("orgID");// from service tree build
        ICN_API.sessionId = obj_ModelAndView.get("sessionID");
        ICN_API.domainId = obj_ModelAndView.get("domainID");
        ICN_API.rteSchemaVersion = obj_ModelAndView.get("schemaVersion");
        ICN_API.boolean_Async = obj_ModelAndView.get("isAsyncAjax");
	    ICN_API.onAPIEvent = onAPIEvent;
	    ICN_API.isNavRequestValid = isNavRequestValid;// required for SCO based navigation!
	    // scoID is added in mvcCallback
	    
        mvcCallback(obj_ModelAndView);
    }
}

/**
 * Function called after an MVC action to invoke sequencing engine. 
 *
 * @param {activelms.ModelAndView} obj_ModelAndView the updated model and view
 */
function mvcCallback(obj_ModelAndView){

    // Action called back, so execution by MVC is over
    ICN_ACTION_EXECUTED = false;

    // Update the model and view in page scope
    ICN_MODEL = obj_ModelAndView.getModel();
    ICN_VIEW = obj_ModelAndView.getView();
        
    var obj_Error = obj_ModelAndView.get("error");
    if(!isUndefined(obj_Error)){
        doAjaxError(obj_Error);
    }
    else{
        // Update the API Adapter with sequencing engine properties
        ICN_API.scoId = obj_ModelAndView.get("scoID");
        ICN_ADAPTER_GLOBAL_STATE.scoId = obj_ModelAndView.get("scoID");
        doRenderView();
    }
}

/**
 * Function called after switching organizations
 *
 * @param {activelms.ModelAndView} obj_ModelAndView the updated model and view
 */
function orgMvcCallback(obj_ModelAndView){

    // Action called back, so execution by MVC is over
    ICN_ACTION_EXECUTED = false;

    ICN_MODEL = obj_ModelAndView.getModel();

    // Update the model
    ICN_MODEL.put("orgID", ICN_PENDING_ORG_REQUEST);
    ICN_MODEL.put("actvityTree", undefined);
    // Update the SCORM adapter
  	ICN_API.orgId = ICN_PENDING_ORG_REQUEST;
  	// Start or Resume
    doExecuteAction(activelms.SequencingEngine.INIT, null, initMvcCallback);
}

function expireMvcCallback(obj_ModelAndView){
    // TODO replace with common value for .NET and JAVA
    top.location = "timeout.do";
}

/**
 * Function called after an unexpected window close event
 *
 * @param {activelms.ModelAndView} obj_ModelAndView the updated model and view
 */
function exitMvcCallback(obj_ModelAndView){

    // Action called back, so execution by MVC is over
    ICN_ACTION_EXECUTED = false;

	// Hide the progress indicator
    //doHideProgress();
    ICN_WINDOW_CLOSED_EVT = true;
}

function doRenderView(){

    // Response over, hide progress
    //doHideProgress();

    // Get properties
	var arr_Organizations = ICN_MODEL.get("organizations");
	var obj_ActivityTree = ICN_MODEL.get("activityTree");
	var str_LCMSEndPoint = ICN_MODEL.get("LCMSEndPoint");
	var str_CourseID = ICN_MODEL.get("courseID");
	var str_OrgID = ICN_MODEL.get("orgID");
	var str_ScoID = ICN_MODEL.get("scoID");
	var str_Title = ICN_MODEL.get("title");
	
	// Update window title
	if(!isUndefined(str_Title)){
	    document.title = str_Title;
	}
	
	if(!activelms.SequencingBehaviour.isSequencingFinished){
        // Update Organizations combo box
        buildOrganizationsView(arr_Organizations, str_OrgID)

	    // Update TOC, which will callback to update the view
	    var str_ContentRoot = str_LCMSEndPoint;
	    str_ContentRoot += "/";
	    str_ContentRoot += str_CourseID;
        buildTreeView(obj_ActivityTree.getRoot(), str_ContentRoot);
    }
    else{
	    // Usually called back from processing at buildTreeView
        doUpdateView(ICN_VIEW); 
        doHideProgress();
    }
}

function doUpdateView(str_Url){

    if(isUndefined(str_Url)){
        // cannot update the view
        return;
    }

    // Update the frame
	var obj_Main = document.getElementById("main");
	obj_Main.style.visibility="visible";
	obj_Main.src  = str_Url;

	var b_DisablePrevious = false;
	if(ICN_MODEL.get("isDisabledForPrevious") || ICN_MODEL.get("isHiddenForPrevious")){
        b_DisablePrevious = true;
	}
	
	var b_DisableContinue = false;
	if(ICN_MODEL.get("isDisabledForContinue") || ICN_MODEL.get("isHiddenForContinue")){
	    b_DisableContinue = true;
	}
	    
	// Manage the controls
    doDisableControlName("previous", b_DisablePrevious);
    doDisableControlName("continue", b_DisableContinue);
    doDisableControlName("exit", ICN_MODEL.get("isDisabledForExit"));
    doDisableControlName("treeView", ICN_MODEL.get("isDisabledForMenu"));  
    
    // Now tree is built, show it
	window.doShowHideMenu(true);
    doHideProgress();
}

function doDisableControls(b_Disabled){
    // Manage the controls
    doDisableControlName("previous", b_Disabled);
    doDisableControlName("continue", b_Disabled);
    doDisableControlName("exit", b_Disabled);  
    doDisableControlName("treeView", b_Disabled);
}

/*
 * Required for SCO base navigation
 */
function isNavRequestValid(scoId, str_AdlNavRequest) {

    //var obj_Current = ICN_MODEL.get("currentActivity");
    //var b_PreviousOK = obj_Current.canSequence(activelms.SequencingEngine.PREVIOUS);
    //var b_ContinueOK = obj_Current.canSequence(activelms.SequencingEngine.CONTINUE);
    
    var b_PreviousOK = ICN_MODEL.get("canSequenceForPrevious");
    var b_ContinueOK = ICN_MODEL.get("canSequenceForContinue");
    
    // If there is an activity with for the identifier in the "choice.{target=", then test
    var int_Index = str_AdlNavRequest.indexOf("choice.{target=");
    if(int_Index == 0){
        var int_StartIndex = "choice.{target=".length;
        var int_EndIndex = str_AdlNavRequest.lastIndexOf("}");
        var str_Identifier = str_AdlNavRequest.substring(int_StartIndex, int_EndIndex);
        var obj_ActivityTree = ICN_MODEL.get("activityTree");
        var obj_Activity = obj_ActivityTree.findByName(str_Identifier);
        if(obj_Activity){
            if(obj_Activity.isHiddenForChoice() || obj_Activity.isDisabledForChoice()){
                return false;
            }
            return true;
        }
    }

	if (str_AdlNavRequest == activelms.SequencingEngine.EXIT) {return true;}
	else if (str_AdlNavRequest == activelms.SequencingEngine.ABANDON) {return true;}
    else if (str_AdlNavRequest == activelms.SequencingEngine.EXIT_ALL){return true;}
	else if (str_AdlNavRequest == activelms.SequencingEngine.SUSPEND_ALL){return true;}
	else if (str_AdlNavRequest == activelms.SequencingEngine.ABANDON_ALL){return true;}
    else if (str_AdlNavRequest == activelms.SequencingEngine.PREVIOUS) {return b_PreviousOK;}
    else if (str_AdlNavRequest == activelms.SequencingEngine.CONTINUE) {return b_ContinueOK;}
	else if (str_AdlNavRequest == activelms.SequencingEngine.CHOICE) {return true;}
    //else if (str_AdlNavRequest == activelms.SequencingEngine.START){return true;}
    //else if (str_AdlNavRequest == ICN_RESUME_ALL){return true;}

    return false;
}


function doAjaxError(obj_Error){

    // Action called back, so execution by MVC is over
    ICN_ACTION_EXECUTED = false;

	// Hide the progress indicator
    doHideProgress();

    var str_Url = ICN_MODEL.get("ajaxErrorUrl");
    
    var str_Description = obj_Error.description;
    if(str_Description && str_Description!= null && str_Description.length > 500){
        str_Description = str_Description.substring(0,500);
    }
    
    var str_Stack = obj_Error.stack;
    if(str_Stack && str_Stack!= null && str_Stack.length > 500){
        str_Stack = str_Stack.substring(0,500);
    }

    str_Url += "?skinID=" + ICN_MODEL.get("skinID");
    str_Url += "&errorDescription=" + str_Description;
    str_Url += "&errorFileName=" + obj_Error.fileName;
    str_Url += "&errorLineNumber=" + obj_Error.lineNumber;
    str_Url += "&errorMessage=" + obj_Error.message;
    str_Url += "&errorName=" + obj_Error.name;
    str_Url += "&errorNumber=" + obj_Error.number;
    str_Url += "&errorStack=" + str_Stack;
    
    doUpdateView(str_Url);
}

function createAPIAdapter(float_ScormVersion, b_IsDebugAjax, str_SoapAddressLocation, str_Mode){

    var obj_Adapter2004 = undefined;
	if (window.XMLHttpRequest) {
		obj_Adapter2004 = new activelms_APIAdapter(null, b_IsDebugAjax, str_SoapAddressLocation, str_Mode);
	}
	else if (window.ActiveXObject) {
		var msXmlObj = getMsXmlObj();
		if(msXmlObj != null){
			obj_Adapter2004 = new activelms_APIAdapter(msXmlObj, b_IsDebugAjax, str_SoapAddressLocation, str_Mode);
		}
	}
	else{
		throw new activelms.ApplicationError("Could not instantiate a SCORM 2004 API Adapter");
	}

    // Common adapter
    ICN_API = obj_Adapter2004;

	if(float_ScormVersion < 2004){
	    // SCORM 1.2 adapter
	    API = new activelms_4JS_APIAdapter(obj_Adapter2004);
    }
    else{
        // SCORM 2004 adapter
	    API_1484_11 = obj_Adapter2004;
    }
}

function getMsXmlObj(){
	var msxmlProgId = null;	
    try {
        var msxmlActiveXObj = new ActiveXObject("Msxml2.DOMDocument.4.0");
      	msxmlProgId = "Msxml2.DOMDocument.4.0";
     } 
	catch (e) {
    	try {
        	var msxmlActiveXObj = new ActiveXObject("Msxml2.DOMDocument.3.0");
           	msxmlProgId = "Msxml2.DOMDocument.3.0";
        } 
       	catch (innerExc) {
       			msxmlProgId = null;
       	}
	}
    return msxmlProgId;
}






