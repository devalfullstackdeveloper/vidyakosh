/**
 * @fileoverview Classes for ActiveScorm Cloud Player
 * @author activelms Ltd mailto:sales@activelms.com
 * @license activelms Software Licence
 * @version 1.0
 */
var com;
if(!com)com = {};
else if(typeof com != "object")throw new Error("namepsace com exists");
if(!com.activelms)com.activelms = {};
else if(typeof com.activelms != "object")throw new Error("namepsace com.activelms exists");
 
if(com.activelms.SupportType)throw new Error("namepsace com.activelms.SupportType exists");
if(com.activelms.DurationType)throw new Error("namepsace com.activelms.DurationType exists");
if(com.activelms.SuccessStatusSupport)throw new Error("namepsace com.activelms.SuccessStatusSupport exists");
if(com.activelms.CompletionStatusSupport)throw new Error("namepsace CompletionStatusSupport exists");
if(com.activelms.ScormVersionSupport)throw new Error("namepsace ScormVersionSupport exists");

/**
 * Construct a new Duration type class that is used to manage translation
 * from Duration types to milliseconds
 * 
 * @class This class represents an instance of DurationType.
 * @constructor
 * @param {String} str_Duration
 * @return A new instance of DefintionType
 */	
com.activelms.DurationType = function(){

/*
 * Parse Time Interval Function re-written by activelms as JS class method
 * @param {String} str_Duration the interval
 * @return time in milliseconds
 * @throws Error if there is a format error in the sting
 */	
	this.parseTimeIntervalIntoMillis = function(str_Duration){

		// Do validation checks
    	if (str_Duration  == null 
			|| str_Duration  == "" 
			|| str_Duration.length < 3
			|| typeof(str_Duration)=="undefined"
			|| typeof(str_Duration)!="string"
			|| str_Duration.indexOf("T") == (str_Duration.length-1)
			|| str_Duration.indexOf("P") == -1
			){
			throw new Error("Invalid SCORM 2004 time duration format");
		}

		// Default zero
    	if (str_Duration == "PT0H0M0S"){return 0;}
	
		var int_T_Index = str_Duration.indexOf("T");
		var str_Date;
		var str_Time;
	
		var str_Years = "0";
		var str_Months = "0";
		var str_Days = "0";
		var str_Hours = "0";
		var str_Mins = "0";
		var str_Secs = "0";

		if(int_T_Index != -1){
			str_Date = str_Duration.substring(0,int_T_Index);
			str_Time = str_Duration.substring(int_T_Index, str_Duration.length);
			int_T_Index = str_Time.indexOf("T");
		}
		else{
			str_Date = str_Duration;
			if(
				str_Date.indexOf("H")!= -1
				|| 
				str_Date.indexOf("S")!= -1
			){
				throw new Error("No T delimiter with H or S present");
			}
			
			var int_M_Index = str_Date.indexOf("M");
			var int_D_Index = str_Date.indexOf("D");
			
			// M occurs twice without T
			if(str_Date.indexOf("M", int_M_Index+1) != -1){
				throw new Error("No T delimiter with M (minutes) present");
			}
			
			// M occurs after D, but without T
			if(int_D_Index != -1 && int_M_Index != -1){
				if(int_M_Index > int_D_Index){
				throw new Error("No T delimiter with M (minutes) present");
				}
			}
		}

		int_P_Index = str_Date.indexOf("P");
	
		//alert("str_Time=" + str_Time);
		//alert("str_Date=" + str_Date);
	
		if(str_Date.length > 1){
	
			// Work on the date part
			var b_Years = false;
			var b_Months = false;
			var b_Days = false;
		
			var int_Y_Index = str_Date.indexOf("Y");
			var int_M_Index = str_Date.indexOf("M");
			var int_D_Index = str_Date.indexOf("D");
		
			if(int_Y_Index != -1){b_Years = true;}
			if(int_M_Index != -1){b_Months = true;}
			if(int_D_Index != -1){b_Days = true;}
		
			if(b_Years){
				str_Years = this.getIntValue(str_Date, int_P_Index, int_Y_Index);
			}
			if(b_Months){
				if(b_Years){
                	str_Months = this.getIntValue(str_Date, int_Y_Index, int_M_Index);
				}
				else{
               	 	str_Months = this.getIntValue(str_Date, int_P_Index, int_M_Index);
				}
			}
			if(b_Days){
				if(b_Years && b_Months){
					str_Days = this.getIntValue(str_Date, int_M_Index, int_D_Index);
				}
				if(b_Years && !b_Months){
					str_Days = this.getIntValue(str_Date, int_Y_Index, int_D_Index);
				}
				if(!b_Years && b_Months){
					str_Days = this.getIntValue(str_Date, int_M_Index, int_D_Index);
				}
				if(!b_Years && !b_Months){
					str_Days = this.getIntValue(str_Date, int_P_Index, int_D_Index);
				}
			}
		}

		if(typeof(str_Time)!="undefined"){

			// Work on the time part
			var b_Hours = false;
			var b_Mins = false;
			var b_Secs = false;
		
			var int_H_Index = str_Time.indexOf("H");
			var int_M_Index = str_Time.indexOf("M");
			var int_S_Index = str_Time.indexOf("S");
		
			if(int_H_Index != -1){b_Hours = true;}
			if(int_M_Index != -1){b_Mins = true;}
			if(int_S_Index != -1){b_Secs = true;}
			
			if(b_Hours){
				str_Hours = this.getIntValue(str_Time, int_T_Index, int_H_Index);
			}
			if(b_Mins){
				if(b_Hours){
                	str_Mins = this.getIntValue(str_Time, int_H_Index, int_M_Index);
				}
				else{
                	str_Mins = this.getIntValue(str_Time, int_T_Index, int_M_Index);
				}
			}
			if(b_Secs){
				if(b_Hours && b_Mins){
					str_Secs = this.getFloatValue(str_Time, int_M_Index, int_S_Index);
				}
				else if(b_Hours && !b_Mins){
					str_Secs = this.getFloatValue(str_Time, int_H_Index, int_S_Index);
				}
				else if(!b_Hours && b_Mins){
					str_Secs = this.getFloatValue(str_Time, int_M_Index, int_S_Index);
				}
				else if(!b_Hours && !b_Mins){
					str_Secs = this.getFloatValue(str_Time, int_T_Index, int_S_Index);
				}
			}
		}
			/*
			alert("Result for: " 
			+ str_Duration 
			+"\n\nYears: " + str_Years 
			+"\nMonths: " + str_Months
			+"\nDays: " + str_Days 
			+"\nHours: " + str_Hours 
			+"\nMins: " + str_Mins 
			+"\nSecs: " + str_Secs);
			*/
		var int_Years = parseInt(str_Years);
		var int_Months = parseInt(str_Months);
		var int_Days = parseInt(str_Days);
		var int_Hours = parseInt(str_Hours);
		var int_Mins = parseInt(str_Mins);
		var float_Secs = parseFloat(str_Secs);

		var float_Total = 0;
		float_Total += (int_Years*31536000);
		float_Total += (int_Months*2628029);
		float_Total += (int_Days*86400);
		float_Total += (int_Hours*3600);
		float_Total += (int_Mins*60);
		float_Total += float_Secs;
		return Math.floor(float_Total * 1000);
	}
	
	this.getIntValue = function(str, int_Start, int_End){
		var str_Substring = str.substring(int_Start+1, int_End);
    	if(isNaN(parseInt(str_Substring))){
			throw new Error("Number format exception: " + str_Substring);
		}
		return new Number(str_Substring);
	}

	this.getFloatValue = function(str, int_Start, int_End){
		var str_Substring = str.substring(int_Start+1, int_End);
    	if(isNaN(parseFloat(str_Substring))){
			throw new Error("Number format exception: " + str_Substring);
		}
		return new Number(str_Substring);
	}
}

/**
 * Construct a new Base Support type class that is used to manage 
 * various detetminations for SCORM RTE.
 * 
 * @class This class represents an instance of SupportType.
 * @constructor
 */	
com.activelms.SupportType = function(){
	
	this.UNKNOWN = "unknown";
	
	/*
 	 * Evaluate the string to a floating point decimal.
 	 * 
 	 * @param {String} str_Value number as string
 	 * @param {Number} int_Precision number of significant digits
 	 * @param {Number} float_Min lower bounds
 	 * @param {Number} float_Max upper bounds
 	 * @return floating point decimal
 	 * @type Number
 	 * @throws Error if there is a format error in the string
 	 */	
	this.getStringAsFloat = function(		
		str_Value, 
		int_Precision,
		float_Min,
		float_Max){
		
		if(typeof(str_Value)=="undefined"){
			throw new Error("Number format exception: number is undefined");
		}
		
		var float_Raw = parseFloat(str_Value);	
		if(isNaN(float_Raw)){
			throw new Error("Number format exception: " + str_Value)
		}
		
		if(float_Raw.toFixed){
			float_Raw.toFixed(int_Precision);
		}
		
		if(
			(float_Raw < float_Min)
			||
			(float_Raw > float_Max)
			){
			throw new Error("Number range exception:" + str_Value)
		}	
		
		return float_Raw;
	}
	
	/*
 	 * Check string is defined in vocabulary.
 	 * 
 	 * @param {String} str_Token
 	 * @param {Array} arr_Tokens
 	 * @return is defined
 	 * @type Boolean
 	 */	
	this.isVocabulary = function(str_Token, arr_Tokens){

		var int_Count = arr_Tokens.length;
		for(var i=0; i<int_Count; i++){
			if(str_Token == arr_Tokens[i]){
				return true;
			}
		}
		return false;
	}
	
	this.evaluate = function(){
		throw new Error("Not implemented in base class");
	}
}

/**
 * Construct a new SuccessStatusSupport type class that is used to manage 
 * success status determination
 * 
 * @class This class represents an instance of SuccessStatusSupport.
 * @constructor
 * @extends com.activelms.SupportType
 * @param {String} str_ScaledPassingScore scaled passing score
 * @param {String} str_ScaledScore scaled score
 * @param {String} str_SuccessStatus success status
 */	
com.activelms.SuccessStatusSupport = function(
	str_ScaledPassingScore, 
	str_ScaledScore, 
	str_SuccessStatus){
	
	/**
	 * Method to call the superclass.
	 */
	com.activelms.SupportType.call(this);
	
	this.FAILED = "failed";
	this.PASSED = "passed";
	
	this.float_ScaledPassingScore;
	this.float_ScaledScore;
	this.ARR_TOKENS = new Array(this.UNKNOWN, this.FAILED, this.PASSED);
	
	// Validation checks
	try{
		this.float_ScaledPassingScore = 
			this.getStringAsFloat(str_ScaledPassingScore,7,-1.0,1.0);
	}
	catch(e){this.float_ScaledPassingScore = undefined;}
	
	try{
		this.float_ScaledScore = 
			this.getStringAsFloat(str_ScaledScore,7,-1.0,1.0);
	}
	catch(e){this.float_ScaledScore = undefined;}
	
	var b_ScaledPassingScore = false;
	var b_ScaledScore = false;
	var b_SuccessStatus = false;
	
	if(typeof(this.float_ScaledPassingScore)=="number"){
		b_ScaledPassingScore = true;
	}
	if(typeof(this.float_ScaledScore)=="number"){
		b_ScaledScore = true;
	}

	if(this.isVocabulary(str_SuccessStatus, this.ARR_TOKENS)){
		b_SuccessStatus = true;
	}
	
	/*
	alert("Status:"
		+ "\n scaled passing score: " + b_ScaledPassingScore
		+ "\n scaled score: " + b_ScaledScore
		+ "\n success status: " + b_SuccessStatus
	);
	*/

	/*
 	 * Evaluate the overridden success status determination,
 	 * @return success status
 	 * @type String
 	 */	
	this.evaluate = function(){
		
		//#1
		if(!b_ScaledPassingScore && !b_ScaledScore &&  !b_SuccessStatus){
			return this.UNKNOWN;
		}
		
		//#2
		if(!b_ScaledPassingScore && !b_ScaledScore &&  b_SuccessStatus){
			return str_SuccessStatus;
		}
		
		//#3
		if(!b_ScaledPassingScore && b_ScaledScore &&  b_SuccessStatus){
			return str_SuccessStatus;
		}
		
		//#4 & #5
		if(b_ScaledPassingScore && b_ScaledScore &&  b_SuccessStatus){
			if(this.float_ScaledScore < this.float_ScaledPassingScore){
				return this.FAILED;
			}
			if(this.float_ScaledScore >= this.float_ScaledPassingScore){
				return this.PASSED;
			}
		}
		
		//#6
		if(b_ScaledPassingScore && !b_ScaledScore &&  b_SuccessStatus){
			return this.UNKNOWN;
		}
		
		//#7 & #8
		if(b_ScaledPassingScore && b_ScaledScore &&  !b_SuccessStatus){
			if(this.float_ScaledScore < this.float_ScaledPassingScore){

				return this.FAILED;
			}
			if(this.float_ScaledScore >= this.float_ScaledPassingScore){
				
				return this.PASSED;
			}
		}
		
		//#9
		if(!b_ScaledPassingScore && b_ScaledScore &&  !b_SuccessStatus){
			return this.UNKNOWN;
		}
		
		//#10
		if(b_ScaledPassingScore && !b_ScaledScore &&  b_SuccessStatus){
			return this.UNKNOWN;
		}
	}
}
com.activelms.SuccessStatusSupport.prototype = new com.activelms.SupportType();
com.activelms.SuccessStatusSupport.prototype.constructor = com.activelms.SuccessStatusSupport;

/**
 * Construct a new CompletionStatusSupport type class that is used to manage 
 * completion status determination
 * 
 * @class This class represents an instance of CompletionStatusSupport.
 * @constructor
 * @extends com.activelms.SupportType
 * @param {String} str_CompletionThreshold completion threshold
 * @param {String} str_ProgressMeasure progress measure
 * @param {String} str_CompletionStatus completion status
 */	
com.activelms.CompletionStatusSupport = function(
	str_CompletionThreshold, 
	str_ProgressMeasure, 
	str_CompletionStatus){
	
	/**
	 * Method to call the superclass.
	 */
	com.activelms.SupportType.call(this);
	
	this.NOT_ATTEMPTED = "not attempted";
	this.INCOMPLETE = "incomplete";
	this.COMPLETED = "completed";
	
	this.ARR_TOKENS = new Array(
		this.UNKNOWN, 
		this.NOT_ATTEMPTED, 
		this.INCOMPLETE,
		this.COMPLETED
		);
	
	this.float_CompletionThreshold;
	this.float_ProgressMeasure;

	// Validation checks
	try{
		this.float_CompletionThreshold = 
			this.getStringAsFloat(str_CompletionThreshold,7,0.0,1.0);
	}
	catch(e){this.float_CompletionThreshold = undefined;}
	
	try{
		this.float_ProgressMeasure = 
			this.getStringAsFloat(str_ProgressMeasure,7,0.0,1.0);
	}
	catch(e){this.float_ProgressMeasure = undefined;}
	
	var b_CompletionThreshold = false;
	var b_ProgressMeasure = false;
	var b_CompletionStatus = false;
	
	if(typeof(this.float_CompletionThreshold)=="number"){
		b_CompletionThreshold = true;
	}
	if(typeof(this.float_ProgressMeasure)=="number"){
		b_ProgressMeasure = true;
	}

	if(this.isVocabulary(str_CompletionStatus, this.ARR_TOKENS)){
		b_CompletionStatus = true;
	}
	
	/*
	alert("Status:"
		+ "\n completion threshold: " + b_CompletionThreshold
		+ "\n progress measrue: " + b_ProgressMeasure
		+ "\n completion status: " + b_CompletionStatus
	);
	*/

	/*
 	 * Evaluate the overridden completion status determination,
 	 * @return success status
 	 * @type String
 	 */	
	this.evaluate = function(){
		
		//#1
		if(!b_CompletionThreshold && !b_ProgressMeasure &&  !b_CompletionStatus){
			return this.UNKNOWN;
		}
		
		//#2
		if(!b_CompletionThreshold && !b_ProgressMeasure &&  b_CompletionStatus){
			return str_CompletionStatus;
		}
		
		//#3
		if(!b_CompletionThreshold  && b_ProgressMeasure &&  b_CompletionStatus){
			return str_CompletionStatus;
		}
		
		//#4 & #5
		if(b_CompletionThreshold  && b_ProgressMeasure &&  b_CompletionStatus){
			if(this.float_ProgressMeasure < this.float_CompletionThreshold){
				return this.INCOMPLETE;
			}
			if(this.float_ProgressMeasure >= this.float_CompletionThreshold){
				return this.COMPLETED;
			}
		}
		
		//#6
		if(b_CompletionThreshold  && !b_ProgressMeasure &&  !b_CompletionStatus){
			return this.UNKNOWN;
		}
		
		//#7 & #8
		if(b_CompletionThreshold  && b_ProgressMeasure &&  !b_CompletionStatus){
			if(this.float_ProgressMeasure < this.float_CompletionThreshold){
				return this.INCOMPLETE;
			}
			if(this.float_ProgressMeasure >= this.float_CompletionThreshold){
				return this.COMPLETED;
			}
		}
		
		//#9
		if(!b_CompletionThreshold  && b_ProgressMeasure &&  !b_CompletionStatus){
			return this.UNKNOWN;
		}
		
		//#10
		if(b_CompletionThreshold  && !b_ProgressMeasure &&  b_CompletionStatus){
			return this.UNKNOWN;
		}
	}
}
com.activelms.CompletionStatusSupport.prototype = new com.activelms.SupportType();
com.activelms.CompletionStatusSupport.prototype.constructor = com.activelms.CompletionStatusSupport;

/**
 * Construct a new ScormVersionSupport type class that is used to manage 
 * scorm version determination
 * 
 * @class This class represents an instance of CompletionStatusSupport.
 * @constructor
 * @extends com.activelms.SupportType
 * @param {String} str_CompletionThreshold completion threshold
 * @param {String} str_ProgressMeasure progress measure
 * @param {String} str_CompletionStatus completion status
 */	
com.activelms.ScormVersionSupport = function(
	str_SchemaVersion){
	
	/**
	 * Method to call the superclass.
	 */
	com.activelms.SupportType.call(this);
	
	var SCHEMA_SCORM_1p1 = "1.1";
	var SCHEMA_SCORM_1p2 = "1.2";
	var SCHEMA_SCORM_2004_2_Ed = "CAM 1.3";
	var SCHEMA_SCORM_2004_3_Ed_v1 = "2004 3rd Edition";
	var SCHEMA_SCORM_2004_4_Ed_v1 = "2004 4th Edition";
	var SCHEMAVERSION_DEFAULT_VALUE = SCHEMA_SCORM_1p2;
	
	this.evaluate = function(){

		if(str_SchemaVersion == SCHEMA_SCORM_1p1){
			return 1.1;
		}
		else if(str_SchemaVersion == SCHEMA_SCORM_2004_2_Ed){
			return 2004.2;
		}
		else if(str_SchemaVersion == SCHEMA_SCORM_2004_3_Ed_v1){
			return 2004.310;
		}
		else if(str_SchemaVersion == SCHEMA_SCORM_2004_4_Ed_v1){
			return 2004.411;
		}
		
		return 1.2;
	}
}
com.activelms.ScormVersionSupport.prototype = new com.activelms.SupportType();
com.activelms.ScormVersionSupport.prototype.constructor = com.activelms.ScormVersionSupport;

