var NO_ERROR_1p2 = 0;
var NOT_INITIALIZED_1p2 = 301;

// If the API Call is translated and passed on to the LMS for processing, then
// the internal error code should be API_CALLED_PASSED_TO_LMS
var API_CALL_PASSED_TO_LMS = 0;

// If the API Call is translated and processed by the API Wrapper, then
// the internal error code should be API_CALLED_NOT_PASSED_TO_LMS
var API_CALL_NOT_PASSED_TO_LMS = 1;

// Local variable definitions
var _InternalErrorCode = API_CALL_PASSED_TO_LMS;
var activelms_hours = 0;
var activelms_minutes = 0;
var activelms_seconds = 0;

var activelms_statusRequest = null;
var activelms_objectivesFlag = "";
var activelms_objectivesStatusRequestArr = new Array();
var activelms_elementRequestArr = new Array();
var activelms_keyList = new Array(25);
var activelms_valueList = new Array(25);
var activelms_keyWordList = new Array(3);

/******************************************************************************
**
** Function: fillKeyWordList()
** Inputs:  None
** Return:  None
**
** Description:
** fillKeyWorldList is called upon initiation of the file and populates a list array
** of reserverd key words.
**
******************************************************************************/ 
function fillKeyWordList(){
	activelms_keyWordList[0] = "_version";
	activelms_keyWordList[1] = "_children";
	activelms_keyWordList[2] = "_count";
}

/******************************************************************************
**
** Function: fillKeyList()
** Inputs:  None
** Return:  None
**
** Description:
** fillKeyList is called upon initiation of the file and populates a list array
** used in the getNewValue function. The finished list contains the conformant
** SCORM 1.2 data model elements that may need converted to SCORM 2004.  
**
******************************************************************************/ 
function fillKeyList()
{
   // Fill the list of keys (old data model elements)
   activelms_keyList[0] = "cmi.core.student_id";
   activelms_keyList[1] = "cmi.core.student_name";
   activelms_keyList[2] = "cmi.core.lesson_location";
   activelms_keyList[3] = "cmi.core.credit";
   activelms_keyList[4] = "cmi.core.entry";
   activelms_keyList[5] = "cmi.core.score.raw";
   activelms_keyList[6] = "cmi.core.score.max";
   activelms_keyList[7] = "cmi.core.score.min";
   activelms_keyList[8] = "cmi.core.total_time";
   activelms_keyList[9] = "cmi.core.lesson_mode";
   activelms_keyList[10] = "cmi.core.exit";
   activelms_keyList[11] = "cmi.core.session_time";
   activelms_keyList[12] = "cmi.core.score._children";
   activelms_keyList[13] = "cmi.student_preference._children";
   activelms_keyList[14] = "cmi.student_preference.audio";
   activelms_keyList[15] = "cmi.student_preference.language";
   activelms_keyList[16] = "cmi.student_preference.speed";
   activelms_keyList[17] = "cmi.student_preference.text";
   activelms_keyList[18] = "cmi.student_data.mastery_score";
   activelms_keyList[19] = "cmi.student_data.max_time_allowed";
   activelms_keyList[20] = "cmi.student_data.time_limit_action";
   activelms_keyList[21] = "cmi.comments_from_lms";
   activelms_keyList[22] = "cmi.comments";
}

/******************************************************************************
**
** Function: fillValueList()
** Inputs:  None
** Return:  None 
**
** Description:
** fillValueList is called upon initiation of the file and populates a list array
** used in the getNewValue function. This finished list contains the appropriate
** updated SCORM 2004 data model elements.
**
******************************************************************************/   
function fillValueList()
{
   // Fill the list of values (new data model elements)
   activelms_valueList[0] = "cmi.learner_id";
   activelms_valueList[1] = "cmi.learner_name";
   activelms_valueList[2] = "cmi.location";
   activelms_valueList[3] = "cmi.credit";
   activelms_valueList[4] = "cmi.entry";
   activelms_valueList[5] = "cmi.score.raw";
   activelms_valueList[6] = "cmi.score.max";
   activelms_valueList[7] = "cmi.score.min";
   activelms_valueList[8] = "cmi.total_time";
   activelms_valueList[9] = "cmi.mode";
   activelms_valueList[10] = "cmi.exit";
   activelms_valueList[11] = "cmi.session_time";
   activelms_valueList[12] = "cmi.score._children";
   activelms_valueList[13] = "cmi.learner_preference._children";
   activelms_valueList[14] = "cmi.learner_preference.audio_level";
   activelms_valueList[15] = "cmi.learner_preference.language";
   activelms_valueList[16] = "cmi.learner_preference.delivery_speed";
   activelms_valueList[17] = "cmi.learner_preference.audio_captioning";
   activelms_valueList[18] = "cmi.scaled_passing_score";
   activelms_valueList[19] = "cmi.max_time_allowed";
   activelms_valueList[20] = "cmi.time_limit_action";
   activelms_valueList[21] = "cmi.comments_from_lms.0.comment";
   activelms_valueList[22] = "cmi.comments_from_learner.0.comment";
}

/******************************************************************************
**
** Function: fillErrorList()
** Inputs:  None
** Return:  None 
**
** Description:
** fillErrorList creates a list array of the SCORM 1.2 error codes
** This array is used in converting the error codes.
**
******************************************************************************/ 
var errorList = new Array(25);
var errorStringList = new Array(25);
var newErrorList = new Array(25);
var errorcodeList = new Array(25);

function fillErrorList()
{
   // Fill the list of erorrs (old error codes)
   errorList[0] = "0";
   errorList[1] = "101";
   errorList[2] = "101";
   errorList[3] = "101";
   errorList[4] = "101";
   errorList[5] = "101";
   errorList[6] = "301";
   errorList[7] = "101";
   errorList[8] = "301";// updated, was 122
   errorList[9] = "101";
   errorList[10] = "301";
   errorList[11] = "101";
   errorList[12] = "301";
   errorList[13] = "143";
   errorList[14] = "201";
   errorList[15] = "201";// updated, was 101
   errorList[16] = "201";// updated, was 101
   errorList[17] = "201";// updated, was 101
   errorList[18] = "401";// could be 201, but that fails conformance test
   errorList[19] = "401";
   errorList[20] = "301";
   errorList[21] = "403";
   errorList[22] = "404";
   errorList[23] = "405";
   errorList[24] = "405";
   errorList[25] = "405";
}

/******************************************************************************
**
** Function: fillnewErrorList()
** Inputs:  None
** Return:  None
**
** Description:
** fillnewErrorList creates a list array containing the SCORM 2004 error codes
** This array is used in converting the error codes.
**
******************************************************************************/   
function fillnewErrorList()
{
   // Fill the list of values (new error codes)
   newErrorList[0] = "0";
   newErrorList[1] = "101";
   newErrorList[2] = "102";
   newErrorList[3] = "103";
   newErrorList[4] = "104";
   newErrorList[5] = "111";
   newErrorList[6] = "112";
   newErrorList[7] = "113";
   newErrorList[8] = "122";
   newErrorList[9] = "123";
   newErrorList[10] = "132";
   newErrorList[11] = "133";
   newErrorList[12] = "142";
   newErrorList[13] = "143";
   newErrorList[14] = "201";
   newErrorList[15] = "301";
   newErrorList[16] = "351";
   newErrorList[17] = "391";
   newErrorList[18] = "401";
   newErrorList[19] = "402";
   newErrorList[20] = "403";
   newErrorList[21] = "404";
   newErrorList[22] = "405";
   newErrorList[23] = "406";
   newErrorList[24] = "407";
   newErrorList[25] = "408";
}

/******************************************************************************
**
** Function: fillErrorStringList()
** Inputs: none
** Return: none
**
** Description:
** fillErrorStringList creates a list array with SCORM 1.2 error strings.
**
******************************************************************************/
function fillErrorStringList()
{
   // Fill the list of 1.2 erorr strings
   errorStringList[0] = "No error";
   errorStringList[1] = "General Exception";
   errorStringList[2] = "Invalid argument error";
   errorStringList[3] = "Element cannot have children";
   errorStringList[4] = "Element not an array - cannot have count";
   errorStringList[5] = "Not Initialized";
   errorStringList[6] = "Not implemented error";
   errorStringList[7] = "Invalid set value, element is a keyword";
   errorStringList[8] = "Element is read only";
   errorStringList[9] = "Element is write only";
   errorStringList[10] = "Incorrect Data Type";
}   


/******************************************************************************
**
** Function: fillErrorCodeList()
** Inputs: none 
** Return: none 
**
** Description:
** fillErrorCodeList creates a list array with the SCORM 1.2 error codes
** to create a mapping to the error codes with the errorStrings.
**
******************************************************************************/   
function fillErrorCodeList()
{
   // Fill the list of 1.2 erorr codes
   errorcodeList[0] = "0";
   errorcodeList[1] = "101";
   errorcodeList[2] = "201";
   errorcodeList[3] = "202";
   errorcodeList[4] = "203";
   errorcodeList[5] = "301";
   errorcodeList[6] = "401";
   errorcodeList[7] = "402";
   errorcodeList[8] = "403";
   errorcodeList[9] = "404";
   errorcodeList[10] = "405";
} 

/******************************************************************************
**
** Function: initializeConversionTables()
** Inputs: none 
** Return: none 
**
** Description:
** initializeConversionTables calls all the functions that create the list
** arrays that provide the information for the conversions between SCORM 1.2
** and SCORM 2004 data model elements and errorcodes.
**
******************************************************************************/ 
function initializeConversionTables(){
   fillKeyList();
   fillValueList();
   fillErrorList();
   fillnewErrorList();
   fillErrorCodeList();
   fillErrorStringList();
   fillKeyWordList();
}

/*******************************************************************************
**
** Function childrenGetRequest(name, activelms_elementRequestArr)
** Inputs:  element name and the elemntRequestArr variable
** Return:  Returns the list of children to the 1.2 SCO
**
** Description:
** The Wrapper acts alone and returns the 1.2 conformant list of children for
** the particular element.
*******************************************************************************/ 
function childrenGetRequest(name, activelms_elementRequestArr)
{
   var childrenListing = "";
   
   if ( name == "cmi.core._children" )
   {
      childrenListing = "student_id,student_name,lesson_location,credit," 
      + "lesson_status,entry, score,total_time,lesson_mode," 
      + "exit,session_time";
   }
   else if ( name == "cmi.core.score._children" )
   {
      childrenListing = "raw,min,max";
   }
   else if ( name == "cmi.student_data._children" )
   {
      childrenListing = "mastery_score,max_time_allowed,time_limit_action";
   }
   else if ( name == "cmi.objectives._children" )
   {
      childrenListing = "id,score,status";
   }
   else if ( name == "cmi.student_preference._children" )
   {
      childrenListing = "audio,language,speed,text";
   }
   else if ( name == "cmi.interactions._children" )
   {
      childrenListing = "id,objectives,time,type,correct_responses,weighting," +
                        "student_response,result,latency";
   }
   else if ( name == "cmi.objectives." + activelms_elementRequestArr[2] + ".score._children" )
   {
      childrenListing = "raw,min,max";
   }
   else{
   		// Unexpected data model element
   }

   return childrenListing;
}

/******************************************************************************
**
** Function: translateDataModelElement()
** Inputs: SCORM 1.2 datamodel element name 
** Return: The value of the element retrieving
**
** Description:
** translateDataModelElement take in the name of the SCORM 1.2 datamodel 
** element and converts the element to conformant SCORM 2004 syntax before 
** initiating the actuall communication to the SCORM 2004 LMS. The return value
** is then sent back to the SCORM 1.2 calling sco. Three special cases exist for
** elements that require additional more complicated conversions, they are for
** core elements, objective and interactions.
**
******************************************************************************/ 
function translateDataModelElement(name, api)
{
   var DataModelElementReturnVal = "";

   var updatedName = "";
   arrayOfComponents = name.split(".");

   switch ( arrayOfComponents[1] )
   {
   case "core":
      { 
         DataModelElementReturnVal = convertCore(name, arrayOfComponents, api);
         return DataModelElementReturnVal;  
      }
   case "comments":
      {
         updatedName = getNewValue(name);
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         DataModelElementReturnVal = api.GetValue(updatedName);
      }
   case "comments_from_lms":
      {
         updatedName = getNewValue(name);
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         DataModelElementReturnVal = api.GetValue(updatedName);
      }
   case "objectives":
      {
         DataModelElementReturnVal = convertObjectives(name,arrayOfComponents,api);
         return DataModelElementReturnVal;      
      }
   case "student_data":
      {
         updatedName = getNewValue(name);
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         DataModelElementReturnVal = api.GetValue(updatedName);
		 
		 // Added by activelms
		 if(updatedName == "cmi.scaled_passing_score"){
		 	var float_Score = parseFloat(DataModelElementReturnVal);
			return Math.round(float_Score * 100);
		 }
      }
   case "student_preference":
      {
         updatedName = getNewValue(name);
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         DataModelElementReturnVal = api.GetValue(updatedName);
      }
   case "suspend_data":
      {
         updatedName = getNewValue(name);
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         DataModelElementReturnVal = api.GetValue(updatedName);
      }
   case "launch_data":
      {
         updatedName = getNewValue(name);
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         DataModelElementReturnVal = api.GetValue(updatedName);
      }
   case "interactions":
      {
         DataModelElementReturnVal = convertInteractions(name,arrayOfComponents,api);
         return DataModelElementReturnVal;  
      }
   }

   return DataModelElementReturnVal;
}

/******************************************************************************
**
** Function: convertCore()
** Inputs: core element name  
** Return: the value of the element retrieving
**
** Description: Special Case 1 of 3 for GetValue
** ConvertCore accepts a SCORM 1.2 datamodel element and then converts the
** element to valid SCORM 2004 syntax before passing on the call to the SCORM
** 2004 LMS. The function then returns the result to the calling function.
**
******************************************************************************/
function convertCore(name, arrayOfComponents, api)
{
   var coreReturnValue = "";
   var updatedName = getNewValue(name);
   
   // Special "core" case for lesson_status
   //if (updatedName == "cmi.core.lesson_status" )
   if (name == "cmi.core.lesson_status" ){
      if (activelms_statusRequest == null )
      {
      	// Get the SCORM 2004 values and determine: passed/failed has precedence over completed/incomplete
      	var str_2004SuccessStatus = api.GetValue("cmi.success_status");
      	var str_2004CompletionStatus = api.GetValue("cmi.completion_status");
      	if(str_2004SuccessStatus == "unknown"){
      		if(str_2004CompletionStatus == "unknown"){
         		coreReturnValue = "not attempted";
      		} 
      		else{
         		coreReturnValue = str_2004CompletionStatus;
      		}     		
      	}
      	else{
        	coreReturnValue = str_2004SuccessStatus;
      	}
      	
         _InternalErrorCode = API_CALL_PASSED_TO_LMS; 
         // The cmi.core.lesson_status was never set by the SCO.  
         // Return the default value of not attempted
         //_InternalErrorCode = 1;
         //coreReturnValue = "not attempted";
         //return coreReturnValue;
      }
      else if (activelms_statusRequest == "browsed" )

      {
         _InternalErrorCode = API_CALL_NOT_PASSED_TO_LMS;
         coreReturnValue = "browsed";
         //return coreReturnValue;
      }
      else
      {
         _InternalErrorCode = API_CALL_PASSED_TO_LMS; 
         coreReturnValue = api.GetValue(activelms_statusRequest);
         //return coreReturnValue;
      }
   }
   else
   {
      _InternalErrorCode = API_CALL_PASSED_TO_LMS; 
      coreReturnValue = api.GetValue(updatedName);
	  
	  if(name == "cmi.core.total_time"){
	  	coreReturnValue = durationToCMITimespan(coreReturnValue);
	  }
   }

   return coreReturnValue;
}

/*
* Added by activelms
*/
function durationToCMITimespan(str_Duration){

	var PT = "PT";
	var H = "H";
	var M = "M";
	var S = "S";
	var POINT = ".";
	var COLON = ":";
	
	var int_Start = -1;
	var int_End = -1;
	
	var str_LeadingZeros = new Array(5);
	str_LeadingZeros[0] = "";
	str_LeadingZeros[1] = "0";
	str_LeadingZeros[2] = "00";
	str_LeadingZeros[3] = "000";
	str_LeadingZeros[4] = "0000";
	
	var str_Hour = "0000";
	var str_Min = "00";
	var str_Sec = "00";
	var str_Milli = "00";
	
	// Strip off PT
	int_Start = str_Duration.indexOf(PT);
	str_Duration = str_Duration.substring(int_Start+PT.length, str_Duration.length);
	
	// Hours
	int_Start = 0;
	int_End = str_Duration.indexOf(H);
	if(int_End != -1){
		str_Hour = str_Duration.substring(int_Start, int_End);
		if(str_Hour.length <= 4){
			str_Hour = str_LeadingZeros[4-str_Hour.length].concat(str_Hour);
		}
	}

	// Minutes
	int_Start = str_Duration.indexOf(H);
	int_End = str_Duration.indexOf(M);
	if(int_End != -1){
		str_Min = str_Duration.substring(int_Start+H.length, int_End);
		if(str_Min.length <= 2){
			str_Min= str_LeadingZeros[2-str_Min.length].concat(str_Min);
		}
	}
	
	// Seconds
	int_Start = str_Duration.indexOf(M);
	int_End = str_Duration.indexOf(S);
	if(int_End != -1){
		str_Sec = str_Duration.substring(int_Start+M.length, int_End);
	}
	
	// Millisec
	int_End = str_Sec.indexOf(POINT);
	if(int_End != -1){
		str_Milli = str_Sec.substring(int_End+1, str_Sec.length);
		str_Sec = str_Sec.substring(0, int_End);
	}
	
	if(str_Sec.length <= 2){
		str_Sec = str_LeadingZeros[2-str_Sec.length].concat(str_Sec);
	}
	
	
	var str_CMITimeSpan = new String();
	str_CMITimeSpan += str_Hour;
	str_CMITimeSpan += COLON;
	str_CMITimeSpan += str_Min;
	str_CMITimeSpan += COLON;
	str_CMITimeSpan += str_Sec;
	str_CMITimeSpan += POINT;
	str_CMITimeSpan += str_Milli;
	
	return str_CMITimeSpan;
}

/******************************************************************************
**
** Function: convertObjectives()
** Inputs: objectives element name 
** Return: the value of the element retrieving
**
** Description: Special Case 2 of 3 for GetValue
** convertObjectives accepts a SCORM 1.2 datamodel element and then converts the
** element to valid SCORM 2004 syntax before passing on the call to the SCORM
** 2004 LMS. The function then returns the result to the calling function.
******************************************************************************/
function convertObjectives(name, arrayOfComponents, api)
{
   var objReturnValue = "";
   var updatedName = getNewValue(name);

   if ( arrayOfComponents[3] == "status" )
   {
      if ( activelms_objectivesStatusRequestArr[arrayOfComponents[2]] == null )
      {
         _InternalErrorCode = 1;
         objReturnValue = "not attempted"; 
      }
      else if ( activelms_objectivesFlag == "browsed")
      {
         _InternalErrorCode = API_CALL_NOT_PASSED_TO_LMS;
         objReturnValue = "browsed";
      }
      else
      {
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         objReturnValue = api.GetValue(
                              activelms_objectivesStatusRequestArr[arrayOfComponents[2]]); 
      }
   }
   else
   {
      updatedName = getNewValue(name);
      _InternalErrorCode = API_CALL_PASSED_TO_LMS;
      objReturnValue = api.GetValue(updatedName);
   }
   
   return objReturnValue;
}

/******************************************************************************
**
** Function: convertInteractions()
** Inputs: interactions data model name 
** Return: the value of the element retrieving
**
** Description: Special Case 3 of 3 for GetValue
** convertInteractions accepts a SCORM 1.2 datamodel element and then converts 
** the element to valid SCORM 2004 syntax before passing on the call to the 
** SCORM 2004 LMS. The function then returns the result to the calling function.
******************************************************************************/
function convertInteractions(name,arrayOfComponents, api)
{
   var interReturnValue = "";
   var updatedName = getNewValue(name);
   
   // activelms Customer Support Case# 00001244, JIRA JAVATWO-150
   // The following are SCORM 1.2 read only:
   //.latency, .result, .student_response, .weighting, .type, .time, .id
   switch(arrayOfComponents[3]){
        case "latency":
        api.errorCode = "405";//Data Model Element Is Write Only (405)
        return "";
        case "result":
        api.errorCode = "405";//Data Model Element Is Write Only (405)
        return "";
        case "student_response":
        api.errorCode = "405";//Data Model Element Is Write Only (405)
        return "";
        case "weighting":
        api.errorCode = "405";//Data Model Element Is Write Only (405)
        return "";
        case "type":
        api.errorCode = "405";//Data Model Element Is Write Only (405)
        return "";
        case "time":
        api.errorCode = "405";//Data Model Element Is Write Only (405)
        return "";
        case "id":
        api.errorCode = "405";//Data Model Element Is Write Only (405)
        return "";
   }

   if ( arrayOfComponents[3] == "time" )
   {
      // Make appropriate call
      InternalErrorCode = API_CALL_PASSED_TO_LMS;
      var result1 = api.GetValue("cmi.interactions." + 
                                           arrayOfComponents[2] + ".timestamp");
      
      // Convert 2004 format to 1.2 format
      newtimeArray = result1.split("T");
      
      // Position 0 is thrown out 
      interReturnValue = newtimeArray[1];
   }
   else if ( arrayOfComponents[3] == "result" )
   {
      _InternalErrorCode = API_CALL_PASSED_TO_LMS;
      interReturnValue = api.GetValue(name);

      // Check for a return value of "incorrect" can convert to "wrong"
      if ( interReturnValue == "incorrect" )
      {
         interReturnValue = "wrong";
      }
   }
   else
   {
      updatedName = getNewValue(name);
      _InternalErrorCode = API_CALL_PASSED_TO_LMS;
      interReturnValue = api.GetValue(updatedName);
   }
   
   return interReturnValue;
}

/******************************************************************************
**
** Function: getNewValue()
** Inputs: SCORM 1.2 data model element 
** Return: corresponding SCORM 2004 data model element
**
** Description:
** getNewValue take in the old SCORM 1.2 datamodel element and by using the 
** previously set list arrays returns the corresponding SCORM 2004 data model
** element.
**
******************************************************************************/   
function getNewValue( key )
{
   var keyResult = key;
   
   // Check to see if result is cmi.interactions
   var checkValue = keyResult.substring(0,16);
   
   if ( checkValue == "cmi.interactions" )
   {
      // Get substing after cmi.interactions.
      var str_Substring = key.substring(17, key.length);
      // Get the index of the . after n
      var int_Index = str_Substring.indexOf(".");
      // Get the substring after the . after n
      var str_Token = str_Substring.substring(int_Index+1, str_Substring.length);
      
      // Check for cmi.interactions.n.time     
      if (str_Token == "time" )
      {
         // Return cmi.interactions.n.timestamp
         keyResult = key.split("time").join("timestamp");
      }
      else if (str_Token == "student_response" )
      {
         // Return cmi.interactions.n.learner_response
         keyResult = key.split("student_response").join("learner_response");
      }
   }

   for ( i=0; i < activelms_keyList.length; i++ )
   {
      if ( activelms_keyList[i] == key )
      {
         keyResult = activelms_valueList[i];
         break;
      }
   }   
   
   return keyResult;
}

/******************************************************************************
**
** Function: dmElementSetFunction()
** Inputs: data model element name to set and the value attempting to set
** Return: boolean value true or false if the value was correctly set
**
** Description:
** dmElementSetFunction takes in the name of the SCORM 1.2 datamodel 
** element and the desired value to set the element equal to. Prior to calling
** the SetValue call to the LMS the function converts the element to conformant
** SCORM 2004 syntax and in some cases formats the value data to meet SCORM 2004
** standards.  Upon calling the SetValue call the return value of true or false 
** is returned to the originating calling line.Three special cases exist for
** elements that require additional more complicated conversions, they are for
** core elements, objective and interactions. All other normal calls fall into
** the default case.
**
******************************************************************************/ 
function dmElementSetFunction(name, value, api)
{
   var setReturnValue = "false";

   var setNameUpdate = getNewValue(name); 
   arrayOfComponents = name.split(".");

   switch ( arrayOfComponents[1] )
   {
   case "core":
      {
         setReturnValue = setConvertCore(name, value, arrayOfComponents, api);
         return setReturnValue;
      }
   case "objectives":
      {
         setReturnValue = setConvertObjectives(name, value, arrayOfComponents, api);
         return setReturnValue; 
      }    
   case "interactions":
      {
         setReturnValue = setConvertInteractions(name, value, arrayOfComponents, api);
         return setReturnValue; 
      }
   case "comments":
      {
	  	// SCORM 1.2 concentates comments
		var str_Scorm2004Name = getNewValue(name);
		var str_ReturnValue = api.GetValue(str_Scorm2004Name);
		value = str_ReturnValue.concat(value);
		
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
		setReturnValue = api.SetValue(str_Scorm2004Name, value);
        return setReturnValue; 
      }
   default:
      {
         // Normal setValue() Call
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         setReturnValue = api.SetValue(setNameUpdate, value);
		 return setReturnValue;
      }
   }

   //return setReturnValue;
}

/******************************************************************************
**
** Function: setConvertCore()
** Inputs: core data model element 
** Return: boolean true or false depending on success or failure of the call
**
** Description: Special Case 1 of 3 for SetValue
** setConvertCore accepts a valid SCORM 1.2 element and value and converts the 
** call into conformant SCORM 2004 syntax. Upon making the conversion the 
** SetValue call is made to the LMS and returns a boolean value upon the the 
** sucess or failure of the call.
**
******************************************************************************/
function setConvertCore(name, value, arrayOfComponents, api)
{
   var coreReturnValue = "false";
   var coreUpdatedName = getNewValue(name);

   if ( name == "cmi.core.lesson_status" )
   {
   	  // For reporting purposes we can use a legacy data type element in the IEEE 1484.11.3 and set the value
		var legacyReturnValue = api.SetValue("icn.lesson_status", value);

      // Check setNameUpdate and determine which element to set
      if ( (value == "completed") || (value == "incomplete") || (value == "not attempted") )
      {
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         activelms_statusRequest = "cmi.completion_status";
		 
		 if(value == "not attempted"){
		 	return coreReturnValue;
		 }
		 
         coreReturnValue = api.SetValue("cmi.completion_status", value);
         return coreReturnValue;
      }
      else if ( (value == "passed") || (value == "failed") )
      {
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         coreReturnValue = api.SetValue("cmi.success_status", value);
         activelms_statusRequest = "cmi.success_status";
         return coreReturnValue;
      }
      else if (value == "browsed")
      {
         _InternalErrorCode = API_CALL_NOT_PASSED_TO_LMS;
		 var str_Mode = api.GetValue("cmi.mode");
    	 if (typeof(str_Mode) != "undefined" && str_Mode != null) {
		 	if(str_Mode == "browse"){
				coreReturnValue = "true";
			}
		 }
         activelms_statusRequest = "browsed";
		 coreReturnValue = "true";// added for conformance suite
         return coreReturnValue;
      }
	  else{
	  	// Invalid data type
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         coreReturnValue = api.SetValue("cmi.success_status", value);
         activelms_statusRequest = "cmi.success_status";
         return coreReturnValue;
	  }
   }
   else if ( name == "cmi.core.session_time" )
   {
      timeArray = new Array(4);
      timeArray = value.split(":");
      
      activelms_hours = timeArray[0];
      activelms_minutes = timeArray[1];
      activelms_seconds = timeArray[2];
      
      var newvalue = "PT" + activelms_hours + "H" + activelms_minutes + "M" + activelms_seconds + "S";
      _InternalErrorCode = API_CALL_PASSED_TO_LMS;
      coreReturnValue = api.SetValue(coreUpdatedName, newvalue);
      return coreReturnValue;      
   }
   else
   { // Normal core set value call
      // Normal setValue() Call         
      _InternalErrorCode = API_CALL_PASSED_TO_LMS;
      coreReturnValue = api.SetValue(coreUpdatedName, value);
      return coreReturnValue;
   }
   
   //return coreReturnValue;
}

/******************************************************************************
**
** Function: setConvertObjectives()
** Inputs: objectives data model element 
** Return: boolean true or false depending on success or failure of the call
**
** Description: Special Case 2 of 3 for SetValue
** setConvertObjectives accepts a valid SCORM 1.2 element and value and converts  
** the call into conformant SCORM 2004 syntax. Upon making the conversion the 
** SetValue call is made to the LMS and returns a boolean value upon the the 
** sucess or failure of the call.
**
******************************************************************************/
function setConvertObjectives(name, value, arrayOfComponents, api)
{
   var objReturnValue = "false";
   var objUpdatedName = getNewValue(name);

   if ( arrayOfComponents[3] == "status" )
   {
      if ( (value == "passed") || (value == "failed") )
      {
         // Reset Objectives Flag
         activelms_objectivesFlag = "";
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         objReturnValue = api.SetValue("cmi.objectives." + 
                               arrayOfComponents[2] + ".success_status", value);
         activelms_objectivesStatusRequestArr[arrayOfComponents[2]] = "cmi.objectives." + 
                                       arrayOfComponents[2] + ".success_status";
         return objReturnValue;
      }
      else if ( (value == "completed") || (value == "incomplete") || 
                (value == "not attempted") )
      {
         // Reset Objectives Flag
         activelms_objectivesFlag = "";
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         objReturnValue = api.SetValue("cmi.objectives." + arrayOfComponents[2]+ 
                                       ".completion_status", value);
         activelms_objectivesStatusRequestArr[arrayOfComponents[2]] = "cmi.objectives." + 
                                    arrayOfComponents[2] + ".completion_status";
         return objReturnValue;       
      }
      else if ( value == "browsed")
      {
        _InternalErrorCode = API_CALL_NOT_PASSED_TO_LMS;
        // Set objectives flag
        activelms_objectivesFlag = "browsed";
        objReturnValue = true;
        return objReturnValue;
      }
      else{
        // Invalid vocab
        objReturnValue = false;
        return objReturnValue;
      }
   }
   else
   { // Normal set objective call
      // Normal setValue() Call
      _InternalErrorCode = API_CALL_PASSED_TO_LMS;          
      objReturnValue = api.SetValue(objUpdatedName, value);
      return objReturnValue;
   }
   
   //return objReturnValue;
}

/******************************************************************************
**
** Function: setConvertInteractions()
** Inputs: interactions data model element 
** Return: boolean true or false depending on success or failure of the call
**
** Description: Special Case 3 of 3 for SetValue
** setConvertInteractions accepts a valid SCORM 1.2 element and value and   
** converts the call into conformant SCORM 2004 syntax. Upon making the  
** conversion the SetValue call is made to the LMS and returns a boolean value  
** upon the the sucess or failure of the call.
**
******************************************************************************/
function setConvertInteractions(name, value, arrayOfComponents, api)
{
    /*
	// SCORM 1.2 can set an n interactions element before n-1 is set?
	var int_Count = api.GetValue("cmi.interactions._count");
	// Check to see if we are jumping ahead more than an increment
	var int_N = arrayOfComponents[2];
	var int_Difference = int_N - int_Count;
	if((int_Difference)>1){
	    // Need to fill in interactions so there is a sequential array of interactions
	    var int_Start = int_Count;
	    var int_End = int_N;
	    for(var n=int_Start; n<int_End; n++){
	        api.SetValue("cmi.interactions." + n +".type","other");
	    }
	}
	*/	
	
   var interReturnValue = "false";
   var interUpdatedName = getNewValue(name);
      
   var str_NewValue = value;

	// Get the id and type
	var str_CmiName = "cmi.interactions." + arrayOfComponents[2] +".id" ;// cmi.interactions.n.id
	var str_Id = api.GetValue(str_CmiName);
	var str_ErrorCode = new String(api.errorCode);
	var str_Type = null;
		
	if(str_ErrorCode == "0"){
		str_CmiName = "cmi.interactions." + arrayOfComponents[2] +".type" ;// cmi.interactions.n.type
		str_Type = api.GetValue(str_CmiName);

		if (typeof(str_Type) != "undefined" || str_Type != null) {
			
			if(str_Type == "true-false"){
   				if(value == "f" || value == "0"){str_NewValue = "false";}
   				if(value == "t" || value == "1"){str_NewValue = "true";}
   				if(name.indexOf("weighting")!= -1){return "true";}
			}
			else if(str_Type == "performance"){
				if(arrayOfComponents[5]=="pattern" || arrayOfComponents[3]=="student_response"){
					str_NewValue = "[.]" + value;
				}
			}
			else if(str_Type == "likert"){
				if(arrayOfComponents[5]=="pattern"){
					if(value == null || value == new String() || typeof(value) != "undefined"){
						str_NewValue = "undefined";
					}
				}
			}
		}
	}

   if ( arrayOfComponents[3] == "latency" )
   {
      timeArray = new Array(4);
      timeArray = value.split(":");
      
      activelms_hours = timeArray[0];
      activelms_minutes = timeArray[1];
      activelms_seconds = timeArray[2];
      
      str_NewValue = "PT" + activelms_hours + "H" + activelms_minutes + "M" + activelms_seconds + "S"; 
      _InternalErrorCode = API_CALL_PASSED_TO_LMS;        
      interReturnValue = api.SetValue(name, str_NewValue);
      return interReturnValue;     
   }
   else if ( arrayOfComponents[3] == "correct_responses" &&  arrayOfComponents[5]=="pattern")
   {
      	_InternalErrorCode = API_CALL_PASSED_TO_LMS;        
      	interReturnValue = api.SetValue(name, str_NewValue);
      	return interReturnValue; 
   }
   
   else if ( arrayOfComponents[3] == "time" )
   {
      // Convert the time format to correct format
      var now = new Date();
      var year = now.getYear();
      // See support Case 00001374 and JIRA NET-309
      // var month = now.getMonth();
      var month = now.getMonth() + 1;
      
      if ( month <= 9 )
      {
         month = "0" + month;
      }

      // See support Case 00001374 and JIRA NET-309
      //var day = now.getDay() + 1;
      var day = now.getDate();
      
      if ( day <= 9 )
      {
         day = "0" + day;
      }

      var str_NewValue = year + "-" + month + "-" + day + "T" + value;
      
      // Setting interactions.timestamp to updated 2004 time format
      _InternalErrorCode = API_CALL_PASSED_TO_LMS;
      var result1 = api.SetValue("cmi.interactions." + arrayOfComponents[2] + 
                                 ".timestamp", str_NewValue);
      return result1;
   }
   else if ( arrayOfComponents[3] == "result" )
   {
      // Check Value sending in to set
      if ( value == "wrong" )
      {
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         interReturnValue = api.SetValue(interUpdatedName, "incorrect");
         return interReturnValue;
      }
      else
      {
         _InternalErrorCode = API_CALL_PASSED_TO_LMS;
         interReturnValue = api.SetValue(interUpdatedName, str_NewValue);
         return interReturnValue;
      }
   }
   else
   { // Normal core set value call
      // Normal setValue() Call         
      _InternalErrorCode = API_CALL_PASSED_TO_LMS;
      interReturnValue = api.SetValue(interUpdatedName, str_NewValue);
      return interReturnValue;
   }
   
   //return interReturnValue;
}

/******************************************************************************
**
** Function: getNewErrorValue()
** Inputs: SCORM 1.2 error code 
** Return: SCORM 2004 Error code
**
** Description:
** getNewErrorValue accepts a SCORM 1.2 error code and using the the key and 
** value list arrays converts the SCORM 1.2 call into a valid SCORM 2004 error
** code
**
******************************************************************************/  
function getNewErrorValue( error )
{
   var result = error;
   
   for ( i=0; i < errorList.length; i++ )
   {
      if ( errorList[i] == error )
      {
         result = newErrorList[i];
         break;
      }
   }
   return result;
}

/******************************************************************************
**
** Function: getOldErrorValue()
** Inputs:  SCORM 2004 error code 
** Return:  SCORM 1.2 error code
**
** Description: Function to retrieve the 1.2 error code
** getOldErrorValue accepts a SCORM 2004 error code and returns the 
** corresponding SCORM 1.2 error code.
**
******************************************************************************/ 
function getOldErrorValue(str_ErrorCode, str_CurrentSetName, str_CurrentGetName){

   var str_Result = str_ErrorCode;
   
   for ( i=0; i < newErrorList.length; i++ ){
      if (newErrorList[i] == str_ErrorCode){
         str_Result = errorList[i];

		 // Adjust for special cases
		 if(str_ErrorCode == "403"){
		 	if(str_CurrentGetName == "cmi.core.lesson_location"){
				str_Result = "0"; // SCORM 1.2: Return "" and no error code
			}
		 }
		 else if(str_ErrorCode == "404"){
		 	if(isReservedKeyWord(str_CurrentSetName)){
				str_Result = "402"; // SCORM 1.2: Invalid set value, element is a keyword
			}
		 }
		 
         break;
      }
   }
   return str_Result;
}

function isReservedKeyWord(str_Name){
	var boolean_KeyWord = false;
   	for (i=0; i < activelms_keyWordList.length; i++ ){
		if(str_Name != null){
			if(str_Name.indexOf(activelms_keyWordList[i]) != -1){
				boolean_KeyWord = true;
				break;
			}
		}
   	}
	
	return boolean_KeyWord;
}

/******************************************************************************
**
** Function: getErrorString()
** Inputs: error code 
** Return: appropriate SCORM 1.2 error string
**
** Description: Function to retrieve the 1.2 error string
** getErrorString accepts an error code value and returns the coresponding 
** SCORM 1.2 error string.
**
******************************************************************************/    
function getErrorString(int_Code)
{
   var str_Code = new String(int_Code);
   var str_Result = str_Code;
   
   for ( i=0; i < errorcodeList.length; i++ ){
      if ( errorcodeList[i] == str_Code){
         str_Result = errorStringList[i];
         break;
      }
   }
   return str_Result;
}

function isCMITimeValid(str_Value){

    if (typeof(str_Value) != "undefined" && str_Value != null) {
	
      var arr_HHHH_MM_SSpSS = str_Value.split(":");
	  if(arr_HHHH_MM_SSpSS.length != 3){
	  	// must have H, M and S
	  	return false;
	  }
	  
	  // Hours
	  var str_Hours = arr_HHHH_MM_SSpSS[0];
	  if(isNaN(parseInt(str_Hours))){
	  	// Hours must be an intger
	  	return false;
	  }
	  
	  if(str_Hours.length != 2){
	  	// Hours must have min 2 and max 2 digits
		return false;
	  }
	  
	  // Minutes
	  var str_Min = arr_HHHH_MM_SSpSS[1];
	  if(isNaN(parseInt(str_Min))){
	  	// Minutes must be an intger
	  	return false;
	  }
	  
	  if(str_Min.length != 2){
	  	// Minutes must have excatly 2 digits
		return false;
	  }
	  
	  // Seconds and Milliseconds
	  var str_Secs = arr_HHHH_MM_SSpSS[2];
	  var str_Millis = undefined;
	  if(str_Secs.indexOf(".") != -1){
	  		var arr_SecsAndMillis = str_Secs.split(".");
			str_Secs = arr_SecsAndMillis[0];
			str_Millis = arr_SecsAndMillis[1];
	  }
	  
	  // Seconds
	  if(isNaN(parseFloat(str_Secs))){
	  	// Seconds must be a number
	  	return false;
	  }
	  
	  if(str_Secs.length != 2){
	  	// Seconds must have 2 digits
		return false;
	  }
	  
	  	// Milliseconds
	  if(typeof(str_Millis) != "undefined"){
	  	if(isNaN(parseFloat(str_Millis))){
	  		// Milliseconds must be a number
	  		return false;
	  	}
	  
	  	if(str_Millis.length > 2){
	  		// Milliseconds must have 2 digits
			return false;
	  	}
	  }
	  
	  return true;
	}
	return false;
}
	
function isCMITimespanValid(str_Value){

    if (typeof(str_Value) != "undefined" && str_Value != null) {
	
      var arr_HHHH_MM_SSpSS = str_Value.split(":");
	  if(arr_HHHH_MM_SSpSS.length != 3){
	  	// must have H, M and S
	  	return false;
	  }
	  
	  // Hours
	  var str_Hours = arr_HHHH_MM_SSpSS[0];
	  if(isNaN(parseInt(str_Hours))){
	  	// Hours must be an intger
	  	return false;
	  }
	  
	  if(str_Hours.length < 2 || str_Hours.length > 4){
	  	// Hours must have min 2 and max 4 digits
		return false;
	  }
	  
	  // Minutes
	  var str_Min = arr_HHHH_MM_SSpSS[1];
	  if(isNaN(parseInt(str_Min))){
	  	// Minutes must be an intger
	  	return false;
	  }
	  
	  if(str_Min.length != 2){
	  	// Minutes must have excatly 2 digits
		return false;
	  }
	  
	  // Seconds and Milliseconds
	  var str_Secs = arr_HHHH_MM_SSpSS[2];
	  var str_Millis = undefined;
	  if(str_Secs.indexOf(".") != -1){
	  		var arr_SecsAndMillis = str_Secs.split(".");
			str_Secs = arr_SecsAndMillis[0];
			str_Millis = arr_SecsAndMillis[1];
	  }
	  
	  // Seconds
	  if(isNaN(parseFloat(str_Secs))){
	  	// Seconds must be a number
	  	return false;
	  }
	  
	  if(str_Secs.length != 2){
	  	// Seconds must have 2 digits
		return false;
	  }
	  
	  	// Milliseconds
	  if(typeof(str_Millis) != "undefined"){
	  	if(isNaN(parseFloat(str_Millis))){
	  		// Milliseconds must be a number
	  		return false;
	  	}
	  
	  	if(str_Millis.length > 2){
	  		// Milliseconds must have 2 digits
			return false;
	  	}
	  }
	  
	  return true;
	}
	return false;
}

function isCMIString255Valid(str_Value){
	var boolean_Valid = false;
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		if(str_Value.length <= 255){
			boolean_Valid = true;
		}
	}
	return boolean_Valid;
}

function isCMIString4096Valid(str_Value){
	var boolean_Valid = false;
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		if(str_Value.length <= 4096){
			boolean_Valid = true;
		}
	}
	return boolean_Valid;
}

function isCMIIdentifierValid(str_Value){

    if (typeof(str_Value) != "undefined" && str_Value != null) {
		// 255 characters
		if(!isCMIString255Valid(str_Value)){
			return false;
		}

		// any white space
		var reg = new RegExp("\\s");
		if (reg.test(str_Value)){
			return false;
		}
		
		// any non-word character [^A-Za-z0-9]
		reg = new RegExp("\\W");
		if (reg.test(str_Value)){
			return false;
		}
		return true;
	}
	return false;
}

function isCMIDecimalValid(str_Value){
	var boolean_Valid = false;
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		var float_Decimal = parseFloat(str_Value);
		if(!isNaN(float_Decimal)){
			boolean_Valid = true;
		}
	}
	return boolean_Valid;
}

function isCMIBlankValid(str_Value){
	var boolean_Valid = false;
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		if(str_Value == new String()){
			boolean_Valid = true;
		}
	}
	return boolean_Valid;
}

function isScoreChild(str_Value){
	var boolean_Valid = false;
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		if(str_Value.indexOf("score.raw") != -1){boolean_Valid = true;}
		else if(str_Value.indexOf("score.max") != -1){boolean_Valid = true;}
		else if(str_Value.indexOf("score.min") != -1){boolean_Valid = true;}
	}
	return boolean_Valid;
}

function isStudentDataChild(str_Value){
	var boolean_Valid = false;
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		if(str_Value.indexOf("cmi.student_data.") != -1){boolean_Valid = true;}
	}
	return boolean_Valid;
}

function isLaunchData(str_Value){
	var boolean_Valid = false;
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		if(str_Value == "cmi.launch_data"){boolean_Valid = true;}
	}
	return boolean_Valid;
}

function isSuspendData(str_Value){
	var boolean_Valid = false;
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		if(str_Value == "cmi.suspend_data"){boolean_Valid = true;}
	}
	return boolean_Valid;
}

function isComments(str_Value){
	var boolean_Valid = false;
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		if(str_Value == "cmi.comments"){boolean_Valid = true;}
		if(str_Value == "cmi.comments_from_lms"){boolean_Valid = true;}
	}
	return boolean_Valid;
}

function isInteractions(str_Value){
	var boolean_Valid = false;
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		if(str_Value.indexOf("cmi.interactions") != -1 ){boolean_Valid = true;}
	}
	return boolean_Valid;
}

function isKeyWordCount(str_Value){
	var boolean_Valid = false;
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		if(str_Value.indexOf("_count") != -1 ){boolean_Valid = true;}
	}
	return boolean_Valid;
}

function isKeyWordChildren(str_Value){
	var boolean_Valid = false;
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		if(str_Value.indexOf("_children") != -1 ){boolean_Valid = true;}
	}
	return boolean_Valid;
}

function isNotImplemented(str_Value){
	var boolean_Valid = false;

	// Student language is not supported
    if (typeof(str_Value) != "undefined" && str_Value != null) {
		if(str_Value.indexOf("cmi.student_preference") != -1){boolean_Valid = true;}
	}

	return boolean_Valid;
}


// Begin API Adapter Code
function activelms_4JS_APIAdapter(scorm2004APIAdapter){
	this.TRUE = "true";
	this.FALSE = "false";
	this.onAPIEvent = null;
	this.isNavRequestValid = false;
	this.soapAddressLocation = null;
	this.api = scorm2004APIAdapter;
	this.DEBUG = scorm2004APIAdapter.DEBUG;
	
	this.errorCode = 0;
	this.str_CurrentGetName = null;
	this.str_CurrentSetName = null;
	this.str_CurrentSetValue = null;
}

// Execution state
function activelms_LMSInitialize(str_Param){

    log.v1p2("API LMSInitialize: " + str_Param);

   	initializeConversionTables();
   	
   // activelms JIRA issue #JAVATWO-125
   activelms_statusRequest = null;
   
   // Further initialization?
    activelms_objectivesFlag = "";

	//_InternalErrorCode = API_CALL_NOT_PASSED_TO_LMS;
	_InternalErrorCode = API_CALL_PASSED_TO_LMS;
	var result = this.api.Initialize(str_Param);
	
	var str_ErrorCode = new String().concat(this.LMSGetLastError());
	if(result != this.TRUE && str_ErrorCode != "0"){
		if(this.DEBUG){
			determineError(this);
		}
	}
	
    log.v1p2("API LMSInitialize return: " + result);
	
    return result;
}

function activelms_LMSFinish(str_Param){

    log.v1p2("API LMSFinish: " + str_Param);

   	initializeConversionTables();
	
	var str_LessonStatus = this.LMSGetValue("cmi.core.lesson_status");
	var str_MasteryScore = this.LMSGetValue("cmi.student_data.mastery_score");
	var str_RawScore = this.LMSGetValue("cmi.core.score.raw");
	var str_Credit = this.LMSGetValue("cmi.core.credit");
	
	// SCORM 1.2 processing
	if(str_LessonStatus == "not attempted"){
		// If lesson_status has not been set, then the LMS must set to completed.
		this.LMSSetValue("cmi.core.lesson_status", "completed");
		// this sets SCORM 2004 completion_status = completed in scorm2004.js
	}
	
	var masteryScore = parseFloat(str_MasteryScore);
	var rawScore = parseFloat(str_RawScore);
	
	if(!isNaN(masteryScore) && !isNaN(rawScore) && str_Credit=="credit"){
		
		if(rawScore >= masteryScore){
			this.LMSSetValue("cmi.core.lesson_status", "passed");
			// this sets SCORM 2004 success_status = passed in scorm2004.js
		}
		else{
			this.LMSSetValue("cmi.core.lesson_status", "failed");
			// this sets SCORM 2004 success_status = failed in scorm2004.js
		}
	}
	else{
	}
	
	//_InternalErrorCode = API_CALL_NOT_PASSED_TO_LMS;
	_InternalErrorCode = API_CALL_PASSED_TO_LMS;
	var result = this.api.Terminate(str_Param);
	
	var str_ErrorCode = new String().concat(this.LMSGetLastError());
	if(result != this.TRUE && str_ErrorCode != "0"){
		if(this.DEBUG){
			determineError(this);
		}
	}
	
	log.v1p2("API LMSFinish return: " + result);
	
    return result;
}

// Data Transfer
function activelms_LMSCommit(str_Param){

    log.v1p2("API LMSCommit: " + str_Param);

   	initializeConversionTables();

	//_InternalErrorCode = API_CALL_NOT_PASSED_TO_LMS;
	_InternalErrorCode = API_CALL_PASSED_TO_LMS;
	var result = this.api.Commit(str_Param);
	
	var str_ErrorCode = new String().concat(this.LMSGetLastError());
	if(result != this.TRUE && str_ErrorCode != "0"){
		if(this.DEBUG){
			determineError(this);
		}
	}
	
    log.v1p2("API LMSCommit: " + result);
	
    return result;
}

function activelms_LMSGetValue(name){

    log.v1p2("API LMSGetValue: " + name);

   	initializeConversionTables();
	
	this.str_CurrentGetName = name;
	this.errorCode = 0;
   
   	// The value currently being stored by the LMS for the data model element
   	var getValueReturn = "";

   	// Spilt the name value on '.'
   	activelms_elementRequestArr = name.split(".");
   
   	// First check is using SCORM cmi datamodel
   	if ( activelms_elementRequestArr[0] == "cmi" ){
		// Check to see if the data model element is supported
		if(isNotImplemented(this.str_CurrentGetName)){
				this.errorCode = 401; // not implemented
				return getValueReturn;
		}
	
      	// Check if call is requesting any children elements
      	var tempArrCount = activelms_elementRequestArr.length - 1;   
     	if ( activelms_elementRequestArr[tempArrCount] == "_children" ){
         	getValueReturn = childrenGetRequest(name, activelms_elementRequestArr);
         	_InternalErrorCode = API_CALL_NOT_PASSED_TO_LMS;
			if(getValueReturn == ""){
				getValueReturn = translateDataModelElement(name, this.api);
			}
      	}
      	else{
         	getValueReturn = translateDataModelElement(name, this.api);
			
			/*
			if(isNaN(getValueReturn)){
				getValueReturn = "";
			}
			*/
		}

		var str_SCORM2004Error = new String(this.api.errorCode);

		// Check for "Not initialized" in SCORM 2004, that is no error in SCORM 1.2
		if(str_SCORM2004Error == "403"){
			if(
				isScoreChild(this.str_CurrentGetName)
				||
				isLaunchData(this.str_CurrentGetName)
				||
				isStudentDataChild(this.str_CurrentGetName)
				||
				isSuspendData(this.str_CurrentGetName)
			){
				// Override the 403
				this.api.errorCode = 0;
				getValueReturn = "";
			}
		}
		// Check for "General Get Failure"  in SCORM 2004, that is no error in SCORM 1.2
		else if(str_SCORM2004Error == "301"){
			if(isComments(this.str_CurrentGetName)){
				this.api.errorCode = 0;				// Override the 301
				getValueReturn = "";
			}
			else if(isInteractions(this.str_CurrentGetName)){
				if(!isReservedKeyWord(this.str_CurrentGetName)){
					this.errorCode = 404;			// Override the 301 with read only
				}
			}
		}
		// Check for "Not defined as a valid element name in the SCORM 2004 RTE specification" 
		else if(str_SCORM2004Error == "401"){
			if(isKeyWordChildren(this.str_CurrentGetName)){
				this.errorCode = 202;			// Override the 401 with 202 cannot have children
			}
			else if(isKeyWordCount(this.str_CurrentGetName)){
				this.errorCode = 203;			// Override the 401 with 203 cannot have count
			}
			else if(isReservedKeyWord(this.str_CurrentGetName)){
				this.errorCode = 201;
			}
		}
	}
   	else{ // send call through using a different data model
      	// Normal getValue() Call
      	_InternalErrorCode = API_CALL_PASSED_TO_LMS;
      	getValueReturn = this.api.GetValue(updatedName);
   	}
	
	// Any error, and just return an empty string
	var str_ErrorCode = new String(this.LMSGetLastError());
	if(str_ErrorCode != "0"){
		getValueReturn = "";
	}
	
	log.v1p2("API LMSGetValue: " + getValueReturn);

   	return getValueReturn;
}

function activelms_LMSSetValue(name, value){

    log.v1p2("API LMSSetValue: " + name + "=" + value);

	// Always convert to a string
	value = value + "";
	
   	initializeConversionTables();
	
	this.str_CurrentSetName = name;
	this.str_CurrentSetValue = value;
	this.errorCode = 0;
	
   	var setValueReturn = "false";
	
	// Check to see if the data model element is supported
	if(isNotImplemented(this.str_CurrentSetName)){
			this.errorCode = 401; // not implemented
			log.v1p2("API LMSSetValue return: " + setValueReturn);
			return setValueReturn;
	}
	
	// Check CMI data type validity
	if(this.str_CurrentSetName == "cmi.core.lesson_location"){
		if(!isCMIString255Valid(this.str_CurrentSetValue)){
			this.errorCode = 405;
			log.v1p2("API LMSSetValue return: false");
			return this.FALSE;
		}
	}
	else if(this.str_CurrentSetName == "cmi.core.session_time"){
		if(!isCMITimespanValid(this.str_CurrentSetValue)){
			this.errorCode = 405;
			log.v1p2("API LMSSetValue return: false");
			return this.FALSE;
		}
	}
	else if(this.str_CurrentSetName.indexOf(".id") != -1){
		if(!isCMIIdentifierValid(this.str_CurrentSetValue)){
			this.errorCode = 405;
			log.v1p2("API LMSSetValue return: false");
			return this.FALSE;
		}
	}
	else if(this.str_CurrentSetName.indexOf(".time") != -1){
		if (this.str_CurrentSetName != "cmi.student_data.time_limit_action"){
			if(!isCMITimeValid(this.str_CurrentSetValue)){
				this.errorCode = 405;
			    log.v1p2("API LMSSetValue return: false");
				return this.FALSE;
			}
		}
	}
	else if(
		this.str_CurrentSetName == "cmi.suspend_data"
		||
		this.str_CurrentSetName == "cmi.comments"
		){
		if(!isCMIString4096Valid(this.str_CurrentSetValue)){
			this.errorCode = 405;
			log.v1p2("API LMSSetValue return: false");
			return this.FALSE;
		}
	}
	else if(isScoreChild(this.str_CurrentSetName)){
		if(!isCMIBlankValid(this.str_CurrentSetValue) && !isCMIDecimalValid(this.str_CurrentSetValue)){
			this.errorCode = 405;
			log.v1p2("API LMSSetValue return: false");
			return this.FALSE;
		}
		if(isCMIDecimalValid(this.str_CurrentSetValue)){
			var float_Decimal = parseFloat(value);
			if(float_Decimal<0 || float_Decimal>100){
				this.errorCode = 405;
			    log.v1p2("API LMSSetValue return: false");
				return this.FALSE;
			}
		}
	}
	// SCORM 1.2 SCO cannot set not attempted for status
	else if(this.str_CurrentSetName == "cmi.core.lesson_status"){
		if(this.str_CurrentSetValue == "not attempted"){
			this.errorCode = 405; //or 201
			log.v1p2("API LMSSetValue return: false");
			return this.FALSE;
		}
	}
	// SCORM 1.2 SCO cannot set cmi.student_data.time_limit_action
	else if(this.str_CurrentSetName == "cmi.student_data.time_limit_action"){
			this.errorCode = 403; // the translation to set cmi.time_limit_action in SCORM 2004 returns a 405
			log.v1p2("API LMSSetValue return: false");
			return this.FALSE;
	}
   
   	// Spilt the name value on '.'
   	var activelms_elementRequestArr = name.split(".");
   
   	// 1st Check is using SCORM cmi datamodel
   	if ( activelms_elementRequestArr[0] == "cmi" ){
		setValueReturn = dmElementSetFunction(name, value, this.api);
		
   		// In SCORM 1.2. it is allowed to set an empty string for .raw, .min, .max, 
		if(name.indexOf(".score.") != -1){
	  		// Override return value and error code
	  		if(value == ""){
				setValueReturn = this.TRUE;
				this.errorCode = 0; // scorm 1.2
				this.api.errorCode = 0; //override scorm 2004
			}
  	 	}
   		// In SCORM 1.2. it is NOT allowed to set an empty string for .id  of .type(error expected is 405)
		else if(name.indexOf(".id") != -1 
		|| 
		name.indexOf(".type") != -1
		){
	  		// Override return value and error code
	  		if(value == ""){
				setValueReturn = this.FALSE;
				this.errorCode = 405; // scorm 1.2
				this.api.errorCode = 405; //override scorm 2004
			}
  	 	}
   		// In SCORM 1.2. it is NOT allowed to set invalid vocab for .status(error expected is 405)
		else if(name.indexOf(".status") != -1){
	  		// Override return value and error code
	  		if(
	  		(value == "passed")
	  		||(value == "completed")
	  		||(value == "failed")
	  		||(value == "incomplete")
	  		||(value == "failed")
	  		||(value == "browsed")
	  		||(value == "not attempted")
	  		){
	  		    // Valid vocab
			}
			else{
			    // Invalid vocab
				setValueReturn = this.FALSE;
				this.errorCode = 405; // scorm 1.2
				this.api.errorCode = 405; //override scorm 2004
			}
  	 	}
   	}
   	else {
		// Normal setValue() Call
      	_InternalErrorCode = API_CALL_PASSED_TO_LMS;
      	setValueReturn = this.api.SetValue(updatedName, value);
   	}
   	
	log.v1p2("API LMSSetValue return: " + setValueReturn);
	
   	return setValueReturn;
}

// State Management
function activelms_LMSGetLastError(){

	log.v1p2("API LMSGetLastError");   

   	if ( _InternalErrorCode == API_CALL_NOT_PASSED_TO_LMS  && this.errorCode === 0 ){
      	// There is no error the APIWrapper caught the last call and did not
      	// comunicate with the LMS
      	return  NO_ERROR_1p2;
   	}
	
	// An error code has been set
	if(this.errorCode != 0){
		return this.errorCode;
	}

    var str_ErrorCode2004 = new String(this.api.GetLastError());
    var str_Result = getOldErrorValue(str_ErrorCode2004, this.str_CurrentSetName, this.str_CurrentGetName); 
       
	log.v1p2("API LMSGetLastError return: " + str_Result);     
	return str_Result; 
}

function activelms_LMSGetErrorString(int_Code){
   var errString = getErrorString(int_Code);
   return errString;
}

function activelms_LMSGetDiagnostic(int_Code){
   var errString = getErrorString(int_Code);
   return errString;
}

function activelms_LMSToString(){
	return "activelms Player SCORM 1.2 API Adapter";
}

function determineError(obj_API){
 	var str_Message = "SCORM 1.2 API Error";

	var int_ErrorCode = obj_API.LMSGetLastError();
	var str_LastError = obj_API.LMSGetErrorString(int_ErrorCode);
	var str_Diagnostic = obj_API.LMSGetDiagnostic(int_ErrorCode);
	
	str_Message += "\n" + int_ErrorCode;
	str_Message += "\n" + str_LastError;
	str_Message += "\n" + str_Diagnostic;
	
	//alert(str_Message);
}

// Execution state
//activelms_4JS_APIAdapter.prototype.Initialize = activelms_LMSInitialize;
activelms_4JS_APIAdapter.prototype.LMSInitialize = activelms_LMSInitialize;
activelms_4JS_APIAdapter.prototype.LMSFinish = activelms_LMSFinish;

// Data Transfer
activelms_4JS_APIAdapter.prototype.LMSCommit = activelms_LMSCommit;
activelms_4JS_APIAdapter.prototype.LMSGetValue = activelms_LMSGetValue;
activelms_4JS_APIAdapter.prototype.LMSSetValue = activelms_LMSSetValue;

// State Management
activelms_4JS_APIAdapter.prototype.LMSGetLastError = activelms_LMSGetLastError;
activelms_4JS_APIAdapter.prototype.LMSGetErrorString = activelms_LMSGetErrorString;
activelms_4JS_APIAdapter.prototype.LMSGetDiagnostic = activelms_LMSGetDiagnostic;

// General Object utiities
activelms_4JS_APIAdapter.prototype.toString = activelms_LMSToString;




