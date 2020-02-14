/**
 * @fileoverview Utility Classes
 * @author activelms Ltd mailto:sales@activelms.com
 * @license activelms Software Licence
 * @version 1.0
 */
 
var activelms;
if(!activelms)activelms = {};
else if(typeof activelms != "object")throw new Error("namepsace activelms exists");
 
 // Logging
if(activelms.Logger)throw new Error("namepsace activelms.Logger exists");

/**
 * Sets a status message in a progress dialog
 * and returns the message.
 * @param {String} str_Message The message
 * @return The status message
 */
function toStatus(str_Message, int_Percent){
	if(window.doUpdateProgress){
		doUpdateProgress(str_Message, int_Percent);
	}
	return str_Message;
}

/**
 * Provides a progress indicator while waiting for
 * the callback from an XML HTTP request.
 */
var ICN_TIMER_ID = 0;
var ICN_TIMER_PREFIX = "";
var ICN_PERCENT_COMPLETE = 0;

function updateTimer(){
    if(ICN_TIMER_ID){
        clearTimeout(ICN_TIMER_ID);
        ICN_TIMER_ID = 0;
     }
     
    if(ICN_PERCENT_COMPLETE<100){
    	var f_Decimal = Math.random(); //0-1
    	var int_Increment = Math.round(f_Decimal*5);//0-5
        ICN_PERCENT_COMPLETE += int_Increment;
        if(ICN_PERCENT_COMPLETE > 100){
        	ICN_PERCENT_COMPLETE = 100;
        }
        var str_Message = ICN_TIMER_PREFIX + " " + ICN_PERCENT_COMPLETE + "%";
        toStatus(str_Message, ICN_PERCENT_COMPLETE);
        ICN_TIMER_ID = setTimeout("updateTimer()", (f_Decimal*400));
    }
    else{
    	ICN_PERCENT_COMPLETE = 0;
   		//ICN_TIMER_ID = setTimeout("updateTimer()", 500);
    }    
}

function startTimer(str_Prefix){
	stopTimer();
	ICN_TIMER_PREFIX = str_Prefix;
   	//ICN_TIMER_ID = setTimeout("updateTimer()", 50);
   	ICN_TIMER_ID = setTimeout("updateTimer()", 1);
}

function stopTimer(){
   	ICN_PERCENT_COMPLETE = 0;
	ICN_TIMER_PREFIX = "";
   	if(ICN_TIMER_ID) {
      	clearTimeout(ICN_TIMER_ID);
      	ICN_TIMER_ID = 0;
   	}
}
 
/**
 * Construct a new Logger class.
 * 
 * @class This class represents an instance of Logger.
 * @constructor
 * @param {Number} int_Level The priority level of this log event
 * @param {activelms.Logger} log_Type The originating {@link activelms.Logger} object.
 * @return A new instance of Logger
 */	
activelms.Logger = function(int_Level, int_Type){
	this.level = int_Level;
	this.type = int_Type;
	this.logDocument = undefined;
	this.logWindow = undefined;
	this.blocked = false;
	
	/**
 	 * Public instance method to log an event with priority of "debug"
 	 * @param {String} str_Message The log message
 	 * @param {Object} obj_Object The instance whose properties are to be displayed
 	 */
	this.debug = function(str_Message, obj_Object){
		if(this.level <= activelms.Logger.DEBUG){
			this.initLog();
   			var str_Color = "black";
			var str_Prefix = "DEBUG:";
			this.writeLogEntry(str_Prefix, str_Message, str_Color);
		}
	};
	
	/**
 	 * Public instance method to log an event with priority of "info"
 	 * @param {String} str_Message The log message
 	 * @param {Object} obj_Object The instance whose properties are to be displayed
 	 */
	this.info = function(str_Message, obj_Object){
		if(this.level <= activelms.Logger.INFO){
			this.initLog();
			var str_Color = "blue";
			var str_Prefix = "INFO:";
			this.writeLogEntry(str_Prefix, str_Message, str_Color);
		}
		
	};
	
	/**
 	 * Public instance method to log an event with priority of "V2004"
 	 * @param {String} str_Message The log message
 	 * @param {Object} obj_Object The instance whose properties are to be displayed
 	 */
	this.v2004 = function(str_Message, obj_Object){
		if(this.level <= activelms.Logger.V2004){
			this.initLog();
			var str_Color = "green";
			var str_Prefix = "SCORM 2004:";
			this.writeLogEntry(str_Prefix, str_Message, str_Color);
		}
	};
	
	/**
 	 * Public instance method to log an event with priority of "V1P2"
 	 * @param {String} str_Message The log message
 	 * @param {Object} obj_Object The instance whose properties are to be displayed
 	 */
	this.v1p2 = function(str_Message, obj_Object){
		if(this.level <= activelms.Logger.V1P2){
			this.initLog();
			var str_Color = "green";
			var str_Prefix = "SCORM 1.2:";
			this.writeLogEntry(str_Prefix, str_Message, str_Color);
		}
	};
	
	/**
 	 * Public instance method to log an event with priority of "error"
 	 * @param {String} str_Message The log message
 	 * @param {Object} obj_Object The instance whose properties are to be displayed
 	 */
	this.error = function(str_Message, obj_Object){
		if(this.level <= activelms.Logger.ERROR){
			this.initLog();
			var str_Color = "red";
			var str_Prefix = "ERROR:";
			this.writeLogEntry(str_Prefix, str_Message, str_Color);
		}
	};
	
	
	this.writeLogEntry = function(str_Prefix, str_Message, str_Color){
		
       if(this.logDocument){
   			var div_Logger = this.logDocument.getElementById("logger");
   			var div_Span = this.logDocument.createElement("div");
   			div_Span.style.color = str_Color;
   			var obj_TimeStamp = new Date();
   			str_Prefix = obj_TimeStamp.toUTCString().concat(" " + str_Prefix + " ");
	
			// Log message
			div_Logger.appendChild(div_Span);
   			div_Span.appendChild(this.logDocument.createTextNode(str_Prefix.concat(str_Message)));
       }
	};
	
	this.initLog = function(){
		if(typeof(this.logDocument) != "undefined"){
			//this.logWindow.focus();
			return;
		}
		
		switch(this.type){
			case activelms.Logger.POPUP_LOGGER:
			
				if(this.blocked){return;}
			
    			var obj_Temp = new Object();
    			if (!obj_Temp.win) {
					obj_Temp.win = window.open(
		    			'',
		    			'LoggerWindow',
		    			'width=480,height=600,scrollbars=1,status=0,toolbars=0,resizable=1'
					);
					
					if(!obj_Temp.win || !obj_Temp.win.document){
					    // popup blocker?
					    alert("Logger cannot run - browser may be blocking popup windows");
					    this.blocked = true;
					    return;
					}
					
					if (!obj_Temp.win.document.getElementById('logger')) {
						obj_Temp.win.document.writeln(
						"<h3 style='font:bold 12px tahoma, arial, helvetica, sans-serif;'>activelms Logger</h3>"
						+ "<div id='logger' style='font:normal 11px tahoma, arial, helvetica, sans-serif;'></div>"
						);
            			obj_Temp.win.document.close();
            			obj_Temp.win.document.title = "activelms Logger";
       				}

            		this.logDocument = obj_Temp.win.document;
            		this.logWindow = obj_Temp.win;
    			}
			break;

			case activelms.Logger.PAGE_LOGGER:
			//
			break;
		}
	};
}

activelms.Logger.DEBUG = 1;
activelms.Logger.INFO = 2;//does not include DEBUG messages
activelms.Logger.V2004 = 3;//does not include INFO messages
activelms.Logger.V1P2 = 4;//does not include V2004 message
activelms.Logger.WARN = 5;
activelms.Logger.ERROR = 6;
activelms.Logger.FATAL = 7;
activelms.Logger.NONE = 8;

activelms.Logger.POPUP_LOGGER = 1;
activelms.Logger.PAGE_LOGGER = 2;


