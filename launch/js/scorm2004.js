var IEEE_1484_11_3_NS = "http://ltsc.ieee.org/xsd/1484_11_3";
var activelms_NS = "http://www.activelms.com/services/cmi";
var SOAP_ENVELOPE_NS = "http://schemas.xmlsoap.org/soap/envelope/";
var XSI_NS = "http://www.w3.org/2001/XMLSchema-instance";
var XSD_NS = "http://www.w3.org/2001/XMLSchema";
var SOAPENV_ENVELOPE = "soapenv:Envelope";
var SOAPENV_BODY = "soapenv:Body";
var SOAPENV_FAULT = "soapenv:Fault";
var RTE_DATA_MODEL_TYPE = "icn:RteDataModel";
var NO_ERROR = "0";
var GENERAL_EXCEPTION = "101";
var GENERAL_INITIALIZATION_FAILURE = "102";
var ALREADY_INITIALIZED = "103";
var CONTENT_INSTANCE_TERMINATED = "104";
var GENERAL_TERMINATION_FAILURE = "111";
var TERMINATION_BEFORE_INITIALIZATION = "112";
var TERMINATION_AFTER_TERMINATION = "113";
var RETRIEVE_DATA_BEFORE_INITIALIZATION = "122";
var RETRIEVE_DATA_AFTER_TERMINATION = "123";
var STORE_DATA_BEFORE_INITIALIZATION = "132";
var STORE_DATA_AFTER_TERMINATION = "133";
var COMMIT_BEFORE_INITIALIZATION = "142";
var COMMIT_AFTER_TERMINATION = "143";
var GENERAL_ARGUMENT_ERROR = "201";
var GENERAL_GET_FAILURE = "301";
var GENERAL_SET_FAILURE = "351";
var GENERAL_COMMIT_FAILURE = "391";
var UNDEFINED = "401";
var UNIMPLEMENTED = "402";
var NOT_INITIALIZED = "403";
var READ_ONLY = "404";
var WRITE_ONLY = "405";
var TYPE_MISMATCH = "406";
var OUT_OF_RANGE = "407";
var DEPENDENCY_NOT_EST = "408";
var _NONE_ = "_none_";
var ADLNAV_REQUEST_VALID = "adl.nav.request_valid.";
var ADLNAV_REQUEST = "adl.nav.request";
var ADLNAV = new Array(_NONE_,"continue","previous","choice","jump","abandon","exit","exitAll","suspendAll","abandonAll");
var INVALID_TIME_INTERVAL = -1;
var MILLIS_IN_SEC = 1000;
var TRUE = "true";
var FALSE = "false";
var EMPTY = "";
var VERSION = "1.0";
var VERSION_SCORM_1p2 = "1.2";
var VERSION_SCORM_2004_2_Ed = "CAM 1.3";
var VERSION_SCORM_2004_3_Ed = "2004 3rd Edition";
var VERSION_SCORM_2004_4_Ed = "2004 4th Edition";
var SET_DELIM = "[,]";
var MAX_LOG_LENGTH = 10000;
var ICN_ADAPTER_GLOBAL_STATE = new Object();

// Functions handle the conversion to/from the IEEE 1484_11_3 XML binding values

function cmiExitToXML(str_Exit){
    return (str_Exit == "time-out") ? "timeout" : str_Exit;
}
function cmiNoOpFromXML(value) {
    return value;
}
function cmiNoOpToXML(value) {
    return value;
}
function cmiCreditFromXML(credit) {
    return (credit == "no_credit") ? "no-credit" : credit;
}
function cmiEntryFromXML(entry) {
    return (entry == "ab_initio") ? "ab-initio" : entry;
}
function cmiCompletionStatusToXML(status) {
    return (status == "not attempted") ? "not_attempted": status;
}
function cmiCompletionStatusFromXML(status) {
    return (status == "not_attempted") ? "not attempted": status;
}
function cmiTimeLimitActionFromXML(tla) {
    if (tla == "exit_message") {return "exit,message";} 
    if (tla == "continue_message") {return "continue,message";} 
    if (tla == "exit_no_message") {return "exit,no message";} 
    if (tla == "continue_no_message") {return "continue,no message";} 
    return tla;
}
function cmiTimeLimitActionToXML(tla) {
    if (tla == "exit,message") {return "exit_message";} 
    if (tla == "continue,message") {return "continue_message";} 
    if (tla == "exit,no message") {return "exit_no_message";} 
    if (tla == "continue,no message") {return "continue_no_message";} 
    return tla;
}

// Added by activelms
function cmiIxTypeToXML(type) {
    if (type) {
		if(type=="true-false")return "true_false";
		if(type=="choice")return "multiple_choice";
		if(type=="fill-in")return "fill_in";
		if(type=="long-fill-in")return "long_fill_in";
		if(type=="matching")return "matching";
		if(type=="performance")return "performance";
		if(type=="sequencing")return "sequencing";
		if(type=="likert")return "likert";
		if(type=="numeric")return "numeric";
		if(type=="other")return "other";
    } else {
        return null;
    }
}
// Added by activelms
function cmiIxTypeFromXML(type) {
    if (type) {
		if(type=="true_false")return "true-false";
		if(type=="multiple_choice")return "choice";
		if(type=="fill_in")return "fill-in";
		if(type=="long_fill_in")return "long-fill-in";
		if(type=="matching")return "matching";
		if(type=="performance")return "performance";
		if(type=="sequencing")return "sequencing";
		if(type=="likert")return "likert";
		if(type=="numeric")return "numeric";
		if(type=="other")return "other";
    } else {
        return null;
    }
}

function cmiAudioCaptioningToXML(ac) {
    if (ac == "-1") {
        return "off";
    } else if (ac == "0") {
        return "no_change";
    } else if (ac == "1") {
        return "on";
    } else {
        return ac;
    }
}
function cmiAudioCaptioningFromXML(ac) {
    if (ac == "off") {
        return "-1";
    } else if (ac == "no_change") {
        return "0";
    } else if (ac == "on") {
        return "1";
    } else {
        return ac;
    }
}

function activelms_Def(canRead, canWrite, validator, xmlName, toXML, fromXML) {
    this.canRead = canRead;
    this.canWrite = canWrite;
    this.validator = validator;
    this.xmlName = xmlName;
    this.toXML = (toXML) ? toXML : cmiNoOpToXML;
    this.fromXML = (fromXML) ? fromXML : cmiNoOpFromXML;
}

var CMI_DEF = new Array();
CMI_DEF["comments_from_learner"] = new activelms_Def(false, false, null, "commentsFromLearner");
CMI_DEF["comments_from_lms"] = new activelms_Def(false, false, null, "commentsFromLMS");
CMI_DEF["completion_status"] = new activelms_Def(true, true, "VocabCompletionStatus", "completionStatus", cmiCompletionStatusToXML, cmiCompletionStatusFromXML);
CMI_DEF["completion_threshold"] = new activelms_Def(true, false, "VocabCompletionStatus", "completionThreshold");
CMI_DEF["credit"] = new activelms_Def(true, false, null, "credit", null, cmiCreditFromXML);
CMI_DEF["entry"] = new activelms_Def(true, false, null, "entry", null, cmiEntryFromXML);
CMI_DEF["exit"] = new activelms_Def(false, true, "VocabExit", "exit");
CMI_DEF["interactions"] = new activelms_Def(false, false, null, "interactions");
CMI_DEF["launch_data"] = new activelms_Def(true, false, null, "launchData");
CMI_DEF["learner_id"] = new activelms_Def(true, false, null, "learnerId");
CMI_DEF["learner_name"] = new activelms_Def(true, false, null, "learnerName");
CMI_DEF["learner_preference"] = new activelms_Def(false, false, null, "learnerPreferenceData");
CMI_DEF["location"] = new activelms_Def(true, true, "Str1000", "location");
CMI_DEF["max_time_allowed"] = new activelms_Def(true, false, null, "maxTimeAllowed");
CMI_DEF["mode"] = new activelms_Def(true, false, null, "mode");
CMI_DEF["objectives"] = new activelms_Def(false, false, null, "objectives");
CMI_DEF["progress_measure"] = new activelms_Def(true, true, "Decimal021", "progressMeasure");
CMI_DEF["scaled_passing_score"] = new activelms_Def(true, false, null, "scaledPassingScore");
CMI_DEF["score"] = new activelms_Def(false, false, null, "score");
CMI_DEF["session_time"] = new activelms_Def(false, true, "TimeInterval", "sessionTime");
CMI_DEF["success_status"] = new activelms_Def(true, true, "VocabSuccessStatus", "successStatus");
CMI_DEF["suspend_data"] = new activelms_Def(true, true, "Str4000", "suspendData");
CMI_DEF["time_limit_action"] = new activelms_Def(true, false, null, "timeLimitAction", null, cmiTimeLimitActionFromXML);
CMI_DEF["total_time"] = new activelms_Def(true, false, null, "totalTime");
var CMI_IX_DEF = new Array();
CMI_IX_DEF["id"] = new activelms_Def(true, true, "Id", "identifier");
CMI_IX_DEF["type"] = new activelms_Def(true, true, "VocabType", "type", cmiIxTypeToXML, cmiIxTypeFromXML);
CMI_IX_DEF["timestamp"] = new activelms_Def(true, true, "Time", "timeStamp");
CMI_IX_DEF["weighting"] = new activelms_Def(true, true, "Decimal", "weighting");
CMI_IX_DEF["learner_response"] = new activelms_Def(true, true, null, "learnerResponse");
CMI_IX_DEF["result"] = new activelms_Def(true, true, "Result", "result");
CMI_IX_DEF["latency"] = new activelms_Def(true, true, "TimeInterval", "latency");
CMI_IX_DEF["description"] = new activelms_Def(true, true, "Description", "description");
CMI_IX_DEF["correct_responses"] = new activelms_Def(false, false, null, "correctResponses");
CMI_IX_DEF["objectives"] = new activelms_Def(false, false, null, "objectiveIds");
var CMI_OBJ_DEF = new Array();
CMI_OBJ_DEF["id"] = new activelms_Def(true, true, "Id", "identifier");
CMI_OBJ_DEF["score"] = new activelms_Def(false, false, null, "score");
CMI_OBJ_DEF["progress_measure"] = new activelms_Def(true, true, "Decimal021", "progressMeasure");
CMI_OBJ_DEF["success_status"] = new activelms_Def(true, true, "VocabSuccessStatus", "successStatus");
CMI_OBJ_DEF["completion_status"] = new activelms_Def(true, true, "VocabCompletionStatus", "completionStatus", cmiCompletionStatusToXML, cmiCompletionStatusFromXML);
CMI_OBJ_DEF["description"] = new activelms_Def(true, true, "Description", "description");
var CMI_LEARNER_PREFERENCE_DEF = new Array();
CMI_LEARNER_PREFERENCE_DEF["audio_level"] = new activelms_Def(true, true, null, "audioLevel");
CMI_LEARNER_PREFERENCE_DEF["language"] = new activelms_Def(true, true, null, "language");
CMI_LEARNER_PREFERENCE_DEF["delivery_speed"] = new activelms_Def(true, true, null, "deliverySpeed");
CMI_LEARNER_PREFERENCE_DEF["audio_captioning"] = new activelms_Def(true, true, null, "audioCaptioning", cmiAudioCaptioningToXML, cmiAudioCaptioningFromXML);
var CMI_SCORE_DEF = new Array();
CMI_SCORE_DEF["raw"] = new activelms_Def(true, true, "Score", "raw");
CMI_SCORE_DEF["min"] = new activelms_Def(true, true, "Score", "min");
CMI_SCORE_DEF["max"] = new activelms_Def(true, true, "Score", "max");
CMI_SCORE_DEF["scaled"] = new activelms_Def(true, true, "ScaledScore", "scaled");
var CMI_CMNTLMS_DEF = new Array();
CMI_CMNTLMS_DEF["comment"] = new activelms_Def(true, false, null, "comment");
CMI_CMNTLMS_DEF["location"] = new activelms_Def(true, false, null, "location");
CMI_CMNTLMS_DEF["timestamp"] = new activelms_Def(true, false, null, "timeStamp");
var CMI_CMNTLNR_DEF = new Array();
CMI_CMNTLNR_DEF["comment"] = new activelms_Def(true, true, "Description", "comment");
CMI_CMNTLNR_DEF["location"] = new activelms_Def(true, true, "Str250", "location");
CMI_CMNTLNR_DEF["timestamp"] = new activelms_Def(true, true, "Time", "timeStamp");
var VOCAB = new Array();
VOCAB["credit"] = Array("credit","no-credit");
VOCAB["entry"] = Array("ab-initio","resume","");
VOCAB["mode"] = Array("browse","normal","review");
VOCAB["completion_status"] = Array("completed","incomplete","not attempted","unknown");
VOCAB["success_status"] = Array("passed","failed","unknown");
VOCAB["exit"] = Array("time-out","suspend","logout","normal","");
VOCAB["result"] = Array("correct","incorrect","unanticipated","neutral");
VOCAB["type"] = Array("true-false","choice","fill-in","long-fill-in","matching","performance","sequencing","likert","numeric","other");
var ISO_639_1 = new Array("AA","AB","AE","AF","AK","AM","AN","AR","AS","AV","AY","AZ","BA","BE","BG","BH","BI","BM","BN","BO","BR","BS","NB","CA","CH","CE","NY","CO","CS","CY","DA","DE","DZ","EL","EN","EO","ES","ET","EU","FA","FI","FJ","FO","FR","FY","GA","GD","GL","GN","GU","HA","HI","HR","HU","HY","IA","IE","IK","IN","IS","IT","IW","JA","JI","JW","KA","KK","KL","KM","KN","KO","KS","KU","KY","LA","LN","LO","LT","LV","MG","MI","MK","ML","MN","MO","MR","MS","MT","MY","NA","NE","NL","NO","OC","OM","OR","PA","PL","PS","PT","QU","RM","RN","RO","RU","RW","SA","SD","SG","SH","SI","SK","SL","SM","SN","SO","SQ","SR","SS","ST","SU","SV","SW","TA","TE","TG","TH","TI","TK","TL","TN","TO","TR","TS","TT","TW","UK","UR","UZ","VI","VO","WO","XH","YO","ZH","ZU","EE","FF","LG","KI","HT","HE","HZ","HO","IO","IG","ID","IU","JV","KR","KV","KG","KJ","LB","LI","LU","GV","MH","NV","ND","NG","NR","SE","NN","OJ","OS","PI","SC","II","TY","UG","VE","WA","YI","ZA","CU","CV","KW","CR","DV");

/*
 * Added by activelms 
 * {lang=scn}
 */
var ISO_639_2 = new Array("FIL","MWL","WLN","KBD","ADY","ARG","ABK","ACE","ACH","ADA","AAR","AFH","AFR","AFA","AKA","AKK","ALB","SQI","ALE","ALG","TUT","AMH","APA","ARA","ARC","ARP","ARN","ARW","ARM","HYE","ART","ASM","ATH","MAP","AVA","AVE","AWA","AYM","AZE","NAH","BAN","BAT","BAL","BAM","BAI","BAD","BNT","BAS","BAK","BAQ","EUS","BEJ","BEM","BEN","BER","BHO","BIH","BIK","BIN","BIS","BRA","BRE","BUG","BUL","BUA","BUR","MYA","BEL","CAD","CAR","CAT","CAU","CEB","CEL","CAI","CHG","CHA","CHE","CHR","CHY","CHB","CHI","ZHO","CHN","CHO","CHU","CHV","COP","COR","COS","CRE","MUS","CRP","CPE","CPF","CPP","CUS","CES","CZE","DAK","DAN","DEL","DIN","DIV","DOI","DRA","DUA","DUT","NLA","DUM","DYU","DZO","EFI","EGY","EKA","ELX","ENG","ENM","ANG","ESK","EPO","EST","EWE","EWO","FAN","FAT","FAO","FIJ","FIN","FIU","FON","FRA","FRE","FRM","FRO","FRY","FUL","GAA","GAE","GDH","GLG","LUG","GAY","GEZ","GEO","KAT","DEU","GER","GMH","GOH","GEM","GIL","GON","GOT","GRB","GRC","ELL","GRE","KAL","GRN","GUJ","HAI","HAU","HAW","HEB","HER","HIL","HIM","HIN","HMO","HUN","HUP","IBA","ICE","ISL","IBO","IJO","ILO","INC","INE","IND","INA","INE","IKU","IPK","IRA","GAI","IRI","SGA","MGA","IRO","ITA","JPN","JAV","JAW","JRB","JPR","KAB","KAC","KAM","KAN","KAU","KAA","KAR","KAS","KAW","KAZ","KHA","KHM","KHI","KHO","KIK","KIN","KIR","KOM","KON","KOK","KOR","KPE","KRO","KUA","KUM","KUR","KRU","KUS","KUT","LAD","LAH","LAM","OCI","LAO","LAT","LAV","LTZ","LEZ","LIN","LIT","LOZ","LUB","LUI","LUN","LUO","MAC","MAK","MAD","MAG","MAI","MAK","MLG","MAY","MSA","MAL","MLT","MAN","MNI","MNO","MAX","MAO","MRI","MAR","CHM","MAH","MWR","MAS","MYN","MEN","MIC","MIN","MIS","MOH","MOL","MKH","LOL","MON","MOS","MUL","MUN","NAU","NAV","NDE","NBL","NDO","NEP","NEW","NIC","SSA","NIU","NON","NAI","NOR","NNO","NUB","NYM","NYA","NYN","NYO","NZI","OJI","ORI","ORM","OSA","OSS","OTO","PAL","PAU","PLI","PAM","PAG","PAN","PAP","PAA","FAS","PER","PEO","PHN","POL","PON","POR","PRA","PRO","PUS","QUE","ROH","RAJ","RAR","ROA","RON","RUM","ROM","RUN","RUS","SAL","SAM","SMI","SMO","SAD","SAG","SAN","SRD","SCO","SEL","SEM","SCR","SRR","SHN","SNA","SID","BLA","SND","SIN","SIT","SIO","SLA","SSW","SLK","SLO","SLV","SOG","SOM","SON","WEN","NSO","SOT","SAI","ESL","SPA","SUK","SUX","SUN","SUS","SWA","SSW","SVE","SWE","SYR","TGL","TAH","TGK","TMH","TAM","TAT","TEL","TER","THA","BOD","TIB","TIG","TIR","TEM","TIV","TLI","TOG","TON","TRU","TSI","TSO","TSN","TUM","TUR","OTA","TUK","TYV","TWI","UGA","UIG","UKR","UMB","UND","URD","UZB","VAI","VEN","VIE","VOL","VOT","WAK","WAL","WAR","WAS","CYM","WEL","WOL","XHO","SAH","YAO","YAP","YID","YOR","ZAP","ZEN","ZHA","ZUL","ZUN","AST","AUS","BTK","BYN","NOB","BOS","CMC","CHP","CHK","NWC","CRH","HRV","DAR","DAY","DGR","NLD","MYV","FUR","GLA","GBA","GOR","NDS","GWI","HAT","HIT","HMN","IDO","SMN","INH","ILE","GLE","XAL","KRC","CSB","KMB","KOS","LIM","JBO","DSB","LUA","SMJ","LUS","MKD","MNC","MDR","GLV","MDF","NAP","NIA","NOG","SME","PHI","RAP","SAT","SAS","SCC","SRP","III","SGN","SMS","DEN","SNK","SMA","TAI","TET","TLH","TPI","TKL","TUP","TVL","UDM","HSB","YPK","ZND","SCN");

var HOURS_PER_DAY = 24;
var MINUTES_PER_HOUR = 60;
var SECONDS_PER_MINUTE = 60;
var MILLISECONDS_PER_SECOND = 1000;
function fromMillis(timestamp) {

    var ts = parseInt(timestamp,10);
    var parts = new Array(6);
    parts[0] = parts[1] = parts[2] = parts[3] = parts[4] = parts[5] = 0;
    if (ts < 1000) {
        parts[6] = ts;
    } else {
		// Math.round() to Math.floor() chnaged by activelms
        parts[6]=Math.floor(ts%MILLISECONDS_PER_SECOND);
        ts/=MILLISECONDS_PER_SECOND;
		
        parts[5]=Math.floor(ts%SECONDS_PER_MINUTE);
        ts/=SECONDS_PER_MINUTE;
		
        parts[4]=Math.floor(ts%MINUTES_PER_HOUR);
        ts/=MINUTES_PER_HOUR;
		
        parts[3]=Math.floor(ts%HOURS_PER_DAY);
        parts[2]=Math.floor(ts/HOURS_PER_DAY);
        parts[1]=0;
        parts[0]=0;
    }
    if ((parts[0]+parts[1]+parts[2]+parts[3]+parts[4]+parts[5]+parts[6]) == 0) {
        return "PT0H0M0S";
    } else {
        var sb = ("P");
        if (parts[0] > 0) sb += (parts[0])+('Y');
        if (parts[1] > 0) sb += (parts[1])+('M');
        if (parts[2] > 0) sb += (parts[2])+('D');
        if (parts[3] > 0 || parts[4] > 0 || parts[5] > 0 || parts[6] > 0) {
            sb += ('T');
            if (parts[3] > 0) sb += ((parts[3])+('H'));
            if (parts[4] > 0) sb += ((parts[4])+('M'));

            if (parts[5] > 0) {
                var fracs = parts[6]/10;
				fracs = Math.round(fracs);//added by activelms
				var str_Millis = fracs.toString();
				if(str_Millis.length > 2){
					str_Millis = str_Millis.substr(0,2);
				}
                sb += (fracs > 0) ? ((parts[5])+('.')+(str_Millis)+('S')) : ((parts[5])+('S'));
            } else {
                var fracs = parts[6]/10;
				fracs = Math.round(fracs);//added by activelms
				var str_Millis = fracs.toString();
				if(str_Millis.length > 2){
					str_Millis = str_Millis.substr(0,2);
				}
                if (fracs > 0) {
                	sb += (("0.")+(str_Millis)+('S'));
                }
            }
        }
        return sb;
    }
}

function countDots(val) {
    if (val == null || val.length == 0) return 0;
    var dot = val.indexOf(".");
    if (dot == -1) return 0;
    var fromIndex = 0;
    var count = 0;
    do {
        ++count;
        fromIndex = (dot+1); // skip over the current dot
        dot = (fromIndex < val.length) ? val.indexOf(".",fromIndex) : -1;
    } while (dot != -1);
    return count;
}
function isCMIId(val) {
    if (val.length == 0) return false;
    if (val == "urn:") return false;
    var len = val.length;
    var c,ch;
    for (c=0; c<len; c++) {
        ch = val.charAt(c);
        if (ch == ' ' || ch == '\t' || ch == '\n' || ch == '\r') return false;
    }
    return true;
}
function isCMIShortId(val) {
    if (val == "urn:") return false;
    var len = val.length;
    var c,ch;
    for (c=0; c<len; c++) {
        ch = val.charAt(c);
        if (ch == ' ' || ch == '\t' || ch == '\n' || ch == '\r') return false;
    }
    if (val.indexOf("[.]") != -1) return false;
    return true;
}
function isCMIStr250(val){return true;}
function isCMIStr4000(val){return true;}
function isCMIStr1000(val){return true;}
function isCMIInt(val) {
    if (!isCMIDigits(val)) return false;
    var iVal = parseInt(val);
    return (!isNaN(iVal) && (iVal >= 0) && (iVal <= 65536));
}
function isCMIDescription(val) {
    if (val.length == 0) return true;
    //if (val.length > 4000) return false;
    if (val.indexOf("{lang=") == 0) {
        var brIdx = val.indexOf("}",6);
        if (brIdx == -1 || brIdx == 6) {
            return false; // empty lang not valid
        } else {
            return isCMILanguage(val.substring(6,brIdx));
        }
    }
    return true; // no lang info, assume valid
}
function isCMILanguageCode(val) {
    if (val.length == 1) {
        return (val == "i" || val == "x"); // if length is 1, must be i or x
    } else if (val.length == 2) {
        var valUpper = val.toUpperCase();
        for (var i=0; i<ISO_639_1.length; i++) {
            if (ISO_639_1[i] == valUpper) return true;
        }
        return false;
    } else if (val.length == 3) {
        var valUpper = val.toUpperCase();
        for (var i=0; i<ISO_639_2.length; i++) {
            if (ISO_639_2[i] == valUpper) return true;
        }
        return false;
    } else {
        return false;
    }
}
function isCMILanguage(val) {
    if (val.length == 0) return true;
    var dash = val.indexOf("-");
    if (dash != -1) {
        if (isCMILanguageCode(val.substring(0,dash))) {
            var subc = val.substr(dash+1);
            if (subc.length < 2) return false;
            dash = subc.indexOf("-");
            if (dash != -1) {
                if (subc.substring(0,dash) == "US") return false; // nothing after en-US
            }
            return true;
        } else {
            return false;
        }
    } else {
        return isCMILanguageCode(val);
    }
}
function isCMISInt(val) {
    if (!isCMIDigits(val)) return false;
    var iVal = parseInt(val);
    return (!isNaN(iVal) && (iVal >= -32768) && (iVal <= 32768));
}
function isCMIScore(val) {
    if (countDots(val) > 1) return false;
    if (val.charAt(0) == '-') return false;
    for (var i=0; i<val.length; i++) {
        var chCode = val.charCodeAt(i);
        if ((chCode < 48 || chCode > 57) && (chCode != 46)) return false;
    }
    return !isNaN(parseFloat(val));
}
function isCMIScaledScore(val) {
    if (countDots(val) > 1) return false;
    var i = (val.charAt(0) == '-') ? 1 : 0;
    for (; i<val.length; i++) {
        var chCode = val.charCodeAt(i);
        if ((chCode < 48 || chCode > 57) && (chCode != 46)) return false;
    }
    var floatVal = parseFloat(val);
    if (isNaN(floatVal)) return false;
    return (floatVal >= -1.0 && floatVal <= 1.0);
}
function isCMIDecimal(val) {
    if (val.length == 0) return false;
    if (countDots(val) > 1) return false;
    var i = (val.charAt(0) == '-') ? 1 : 0;
    for (; i<val.length; i++) {
        var chCode = val.charCodeAt(i);
        if ((chCode < 48 || chCode > 57) && (chCode != 46)) return false;
    }
    return isNaN(parseFloat(val)) ? false : true;
}
function isCMIDecimal021(val) {
    if (val.length == 0) return false;
    if (countDots(val) > 1) return false;
    var i = (val.charAt(0) == '-') ? 1 : 0;
    for (; i<val.length; i++) {
        var chCode = val.charCodeAt(i);
        if ((chCode < 48 || chCode > 57) && (chCode != 46)) return false;
    }
    var flVal = parseFloat(val);
    return isNaN(flVal) ? false : (flVal >= 0 && flVal <= 1);
}
function isCMIVocabCompletionStatus(val){return isCMIVocab("completion_status",val);}
function isCMIVocabSuccessStatus(val){return isCMIVocab("success_status",val);}
function isCMIVocabExit(val){return isCMIVocab("exit",val);}
function isCMIVocabType(val){return isCMIVocab("type",val);}
function isCMIResult(val) {return isCMIVocab("result",val) || isCMIDecimal(val);}
function isCMIVocab(vocab,val) {
    for (var i=0; i<VOCAB[vocab].length; i++) if (VOCAB[vocab][i] == val) return true;
    return false;
}
function isADLNav(nav) {
    if (nav == null || nav.length == 0) return false;
    for (var i=0; i<ADLNAV.length; i++) if (ADLNAV[i] == nav) return true;
    return false;
}
function isCMIDigits(num) {
    if (num == null || num.length == 0) return false;
    var i = (num.charAt(0) == '-') ? 1 : 0;
    for (; i<num.length; i++) {
        var chCode = num.charCodeAt(i);
        if (chCode < 48 || chCode > 57) return false;
    }
    return true;
}
function isCMITime(time) {
    if (time == null) return false;
    if (time.length == 0) return false;
    var idx = time.indexOf("T");
    return (idx != -1) ? isCMIDateTime(time.substring(0,idx),time.substr(idx+1)) : isCMIDateOnly(time);
}
function isCMIDateTime(date, time) {
    if (!isCMIDateOnly(date)) return false;
    var tz = null;
    var tzd = time.indexOf("-");
    if (tzd == -1) {
        tzd = time.indexOf("+");
        if (tzd == -1) {
            tzd = time.indexOf("Z");
            if (tzd == (time.length-1)) {
                tz = "Z";
                time = time.substring(0,tzd);
            }
        } else {
            tz = time.substr((tzd+1));
            time = time.substring(0,tzd);
        }
    } else {
        tz = time.substr((tzd+1));
        time = time.substring(0,tzd);
    }
    if (time.length == 0) return false;
    var aSplit = time.split(":");
    if (aSplit.length > 3) return false; // too much stuff
    if (aSplit.length >= 1) {
        if (aSplit[0].length != 2) return false;
        if (!isCMIDigits(aSplit[0])) return false;
        var hours = parseInt(aSplit[0],10);
        if (isNaN(hours)) return false;
        if (hours < 0 || hours > 23) return false;
        if (aSplit.length == 1 && tz != null) return false; // can't have timezone on there
        if (aSplit.length >= 2) {
            if (aSplit[1].length != 2) return false;
            if (!isCMIDigits(aSplit[1])) return false;
            var mins = parseInt(aSplit[1],10);
            if (isNaN(mins)) return false;
            if (mins < 0 || mins > 59) return false;
            if (aSplit.length == 2 && tz != null) return false; // can't have timezone on there
            if (aSplit.length == 3) {
                var secs = 0;
                var millis = 0;
                var dot = aSplit[2].indexOf(".");
                if (dot != -1) {
                    var secsStr = aSplit[2].substring(0, dot);
                    if (secsStr.length != 2 || !isCMIDigits(secsStr)) return false;
                    secs = parseInt(secsStr,10);
                    if (isNaN(secs)) return false;
                    if (secs < 0 || secs > 59) return false;
                    var milsStr = aSplit[2].substr(dot+1);
                    if (!isCMIDigits(milsStr) || milsStr.length > 2) return false;
                    if (milsStr.length == 1) {
                        millis = parseInt(milsStr,10);
                        if (isNaN(millis)) {
                            return false;
                        } else {
                            millis = millis*100;
                        }
                    } else {
                        millis = parseInt(milsStr,10);
                        if (isNaN(millis)) {
                            return false;
                        } else {
                            millis = millis*10;
                        }
                    }
                    // can only have a timezone if fully specified ...
                    if (tz == null || tz == "Z") return true;
                    if (tz.length > 5) return false;
                    var colon = tz.indexOf(":");
                    if (colon == -1) {
                        if (tz.length != 2) return false;
                        if (!isCMIDigits(tz) || parseInt(tz)>23) return false;
                        return true;
                    } else if (colon == 2) {
                        var tzHours = tz.substring(0,2);
                        var tzMins = tz.substr(3);
                        if (tzHours.length != 2 || !isCMIDigits(tzHours) || parseInt(tzHours)>23) return false;
                        if (tzMins.length != 2 || !isCMIDigits(tzMins) || parseInt(tzMins)>59) return false;
                        return true;
                    } else {
                        // either missing or at position 2 or invalid
                        return false;
                    }
                } else {
                    if (aSplit[2].length != 2) return false;
                    if (!isCMIDigits(aSplit[2])) return false;
                    secs = parseInt(aSplit[2],10);
                    if (isNaN(secs)) return false;
                    if (secs < 0 || secs > 59) return false;
                    millis = 0;
                    if (tz != null && tz != "") return false; // cannot have a timezone without millis ...
                }
                millis = ((hours*3600*1000)+(mins*60*1000)+(secs*1000)+millis);
                return (!isNaN(millis) && millis >= 0);
            }
        }
    }
    return true;
}
function isCMIDateOnly(date) {
    var parts = date.split("-");
    if (parts.length < 1 || parts.length > 3) return false;
    // year
    if (parts[0].length != 4) return false;
    if (!isCMIDigits(parts[0])) return false;
    var year = parseInt(parts[0],10);
    if (isNaN(year) || year < 1970 || year > 2038) return false;
    if (parts.length > 1) {
        // month
        if (parts[1].length != 2) return false;
        if (!isCMIDigits(parts[1])) return false;
        var month = parseInt(parts[1],10);
        if (isNaN(month) || month < 1 || month > 12) return false;
        if (parts.length == 3) {
            // day
            if (parts[2].length != 2) return false;
            if (!isCMIDigits(parts[2])) return false;
            var day = parseInt(parts[2],10);
            if (isNaN(day) || day < 1 || day > 31) return false;
        }
    }
    return true;
}
function isCMITimeInterval(val) {
    return (parseTimeIntervalIntoMillis(val) != INVALID_TIME_INTERVAL);
}
function isCMILocalizedString(val) {
    if (val.length == 0) return true;
    var i = val.indexOf("{lang=");
    if (i == 0) {
        var j = val.indexOf("}",i+6);
        if (j == -1) return false; // missing brace
        if (j == (i+6)) return false; // empty lang code
        return isCMILanguage(val.substring(i+6,j));
    }
    return true;
}
function trim(s) {
    if (s == undefined || s == null || s.length == 0) return "";
    // left trim ...
    while (s.length > 0) {
        var ch = s.charAt(0);
        if (ch == ' ' || ch == '\n' || ch == '\r' || ch == '\t' || ch == '\b' || ch == '\f') {
            if (s.length == 1) {
                s = "";
            } else {
                s = s.substr(1);
            }
        } else {
            break; // leading char is no longer whitespace ... done with left trim
        }
    }
    // right trim ...
    while (s.length > 0) {
        var ch = s.charAt(s.length-1);
        if (ch == ' ' || ch == '\n' || ch == '\r' || ch == '\t' || ch == '\b' || ch == '\f') {
            if (s.length == 1) {
                s = "";
            } else {
                s = s.substring(0,s.length-1);
            }
        } else {
            break; // leading char is no longer whitespace ... done with right trim
        }
    }
    return s;
}
function inSet(set,val) {
    for (var i=0; i<set.length; i++) if (set[i] == val) return true;
    return false;
}
function parsePerformanceElement(elm) {
    if (elm.length == 0) return false;
    var j = elm.indexOf("[.]");
    if (j == -1) return false;
    var stepName = (j > 0) ? elm.substring(0,j) : "";
    if (stepName.length > 0 && stepName.indexOf("[.]") != -1) return false;
    var stepAnswer = ((j+3) < (elm.length-1)) ? elm.substr(j+3) : "";
    if (stepAnswer.length > 0 && stepAnswer.indexOf("[.]") != -1) return false;
    var k = (stepAnswer.length > 0) ? stepAnswer.indexOf("[:]") : -1;
    if (k != -1) {
        var min = (k > 0) ? stepAnswer.substring(0,k) : null;
        var max = ((k+3) < (stepAnswer.length-1)) ? stepAnswer.substr(k+3) : null;
        if (min != null && max != null) {
            var fMin = parseFloat(min);
            var fMax = parseFloat(max);
            if (isNaN(fMin) || isNaN(fMax) || (fMin > fMax)) return false;
        } else {
            if (min != null && isNaN(min)) return false;
            if (max != null && isNaN(max)) return false;
        }
    }
    return true;
}
function parsePerformanceResponse(elm) {
    if (elm.length == 0) return false;
    if (elm == "[.]") return false;
    var j = elm.indexOf("[.]");
    if (j == -1) return false;
    var stepName = (j > 0) ? elm.substring(0,j) : "";
    if (stepName.length > 0 && stepName.indexOf("[.]") != -1) return false;
    var stepAnswer = ((j+3) < (elm.length-1)) ? elm.substr(j+3) : "";
    if (stepAnswer.length > 0 && stepAnswer.indexOf("[.]") != -1) return false;
    return true;
}
function parseSetOfId(delim,i,val,unique) {
    var set = new Array();
    var fi = 0;
    var id = null;
    do {
        id = val.substring(fi,i);
        if (unique && inSet(set,id)) return false;
        if (!isCMIShortId(id)) return false;
        set.push(id);
        fi = i+3;
        i = val.indexOf(delim,fi);
        if (i == -1) {
            id = val.substr(fi);
            if (unique && inSet(set,id)) return false;
            if (!isCMIShortId(id)) return false;
            set.push(id);
        }
    } while (i != -1);
    return true;
}
function parseSetOfLocalizedString(delim,val,unique) {
    var i = val.indexOf(delim);
    if (i == -1) {
        // only 1 in the set ... still must a localized string though
        return isCMILocalizedString(val);
    }
    var set = new Array();
    var fi = 0;
    var ls = null;
    do {
        ls = val.substring(fi,i);
        if (unique && inSet(set,ls)) return false;
        if (!isCMILocalizedString(ls)) return false;
        set.push(ls);
        fi = i+3;
        i = val.indexOf(delim,fi);
        if (i == -1) {
            ls = val.substr(fi);
            if (unique && inSet(set,ls)) return false;
            if (!isCMILocalizedString(ls)) return false;
            set.push(ls);
        }
    } while (i != -1);
    return true; // if we get here ... then all good
}
function parseMatters(val) {
    var pos = -1;
    var i = val.indexOf("{order_matters=");
    if (i==0) {
        // val startsWith order_matters
        var j = val.indexOf("}",i+15);
        if (j == -1) return -1; // malformed order_matters
        var om = val.substring(15,j);
        if (om != "true" && om != "false") return -1; // invalid order_matters
        i = val.indexOf("{case_matters=",j+1);
        if (i == (j+1)) {
            // only process the case_matters that comes right after the order_matters
            j = val.indexOf("}",i+14);
            if (j == -1) return -1; // malformed case_matters
            var cm = val.substring(i+14,j);
            if (cm != "true" && cm != "false") return -1; // invalid case_matters
        }
        pos = j+1;
    } else {
        i = val.indexOf("{case_matters=");
        if (i == 0) {
            // val startsWith case_matters
            var j = val.indexOf("}",i+14);
            if (j == -1) return -1; // malformed case_matters
            var cm = val.substring(14,j);
            if (cm != "true" && cm != "false") return -1; // invalid case_matters
            i = val.indexOf("{order_matters=",j+1);
            if (i == (j+1)) {
                j = val.indexOf("}",i+15);
                if (j == -1) return -1; // malformed order_matters
                var om = val.substring(i+15,j);
                if (om != "true" && om != "false") return -1; // invalid order_matters
            }
            pos = j+1;
        } else {
            // doesn't start with order_matters or case_matters
            pos = 0;
        }
    }
    return pos;
}
function parseCaseMatters(val) {
    var pos = 0;
    if (val.indexOf("{case_matters=") == 0) {
        // val startsWith case_matters
        var j = val.indexOf("}", 14);
        if (j == -1) return -1; // malformed case_matters
        var cm = val.substring(14,j);
        if (cm != "true" && cm != "false") return -1; // invalid case_matters
        pos = j+1;
    }
    return pos;
}
function parseOrderMatters(val) {
    var pos = 0;
    if (val.indexOf("{order_matters=") == 0) {
        // val startsWith order_matters
        var j = val.indexOf("}", 15);
        if (j == -1) return -1; // malformed order_matters
        var cm = val.substring(15,j);
        if (cm != "true" && cm != "false") return -1; // invalid order_matters
        pos = j+1;
    }
    return pos;
}
function parseTimeIntervalIntoMillis(str_Duration) {
	
	var obj_Duration = new com.activelms.DurationType();
	try{
		var int_Millis = 
			obj_Duration.parseTimeIntervalIntoMillis(str_Duration);
		return int_Millis;
	}
	catch(error){
    	return INVALID_TIME_INTERVAL;
	}
}

function browserSniff() {
    if (document.layers) return "NS";
    if (document.all) {
        var agt=navigator.userAgent.toLowerCase();
        var is_opera = (agt.indexOf("opera") != -1);
        var is_konq = (agt.indexOf("konqueror") != -1);
        if (is_opera) {
            return "OPR";
        } else {
            return (is_konq) ? "KONQ" : "IE";
        }
    }
    if (document.getElementById) {
        var agt=navigator.userAgent.toLowerCase();
        return (agt.indexOf("safari") != -1) ? "SFR" : "MOZ";
    }
    return "OTHER";
}

function getInternetExplorerVersion()
// Returns the version of Internet Explorer or a -1
// (indicating the use of another browser).
{
  var rv = -1; // Return value assumes failure.
  if (navigator.appName == 'Microsoft Internet Explorer')
  {
    var ua = navigator.userAgent;
    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
  }
  return rv;
}

function activelms_APIAdapter(msxmlProgId, isDebugEnabled, soapAddressLocation, mode) {
	
    this.browserType = browserSniff();

    if (msxmlProgId) {
        this.msxmlProgId = new String(msxmlProgId);
        this.msxmlHttpProgId = (this.msxmlProgId == "Msxml2.DOMDocument.4.0") ? "Msxml2.XMLHTTP.4.0" : "Msxml2.XMLHTTP.3.0";
    } else {
		var version = getInternetExplorerVersion();
		if(this.browserType =="IE" && version<7){
			// For IE 6, refactored for support case 0001757 to only use the ActiveObject for AJAX calls below IE 7
        	this.msxmlProgId = "Msxml2.DOMDocument.4.0"
        	this.msxmlHttpProgId = "Microsoft.XMLHTTP";
		}
		else{
        	this.msxmlProgId = null;
        	this.msxmlHttpProgId = null;
		}
    }
    if (isDebugEnabled) {
        this.DEBUG = isDebugEnabled;
    } else {
        this.DEBUG = false;
    }
    if (soapAddressLocation) {
        this.soapAddressLocation = String(soapAddressLocation);
        // Convert to absolute URL for Sarafi
        if (this.browserType == "SFR") {
            var int_Index = this.soapAddressLocation.indexOf("../");
            if(int_Index != -1){
                this.soapAddressLocation = 
                    this.soapAddressLocation.substring(int_Index+ "../".length, this.soapAddressLocation.length);
                var str_Location = window.document.location.href;
                str_Location = str_Location.substring(0, str_Location.indexOf("/skins/"));
                this.soapAddressLocation = str_Location + "/" + this.soapAddressLocation;
                log.debug("For Safari convert to absolute URL: " + this.soapAddressLocation);
            }
        }
        
    } else {
        this.soapAddressLocation = "activelms_soap";
    }
    
    this.mode = mode;
    
    this.version = VERSION;
	
    this.learnerName = null;
    this.learnerId = null;
    this.courseId = null;
	this.orgId = null;
    this.scoId = null;
    this.sessionId = null;
	this.pk = null;
	this.domainId = null;
	this.rteSchemaVersion = null;
	
    this.doc = null;
    this.rteDataModel = null;
    this.cocd = null;
    this.initializedAt = null;
    this.isTerminated = false;
    this.errorCode = NO_ERROR;
    this.errorDiag = null;
    this._trace = null;
    this.adlNavRequest = _NONE_;
    this.adlNavChoiceTarget = null;
    this.onAPIEvent = null;
    this.isNavRequestValid = null;
    this.fromQuitHandler = false;
    this.errorMsgs = new Array();
    this.errorMsgs[NO_ERROR] = "No Error";
    this.errorMsgs[GENERAL_EXCEPTION] = "General Exception (101)";
    this.errorMsgs[GENERAL_INITIALIZATION_FAILURE] = "General Initialization Failure (102)";
    this.errorMsgs[ALREADY_INITIALIZED] = "Already Initialized (103)";
    this.errorMsgs[CONTENT_INSTANCE_TERMINATED] = "Content Instance Terminated (104)";
    this.errorMsgs[GENERAL_TERMINATION_FAILURE] = "General Termination Failure (111)";
    this.errorMsgs[TERMINATION_BEFORE_INITIALIZATION] = "Termination Before Initialization (112)";
    this.errorMsgs[TERMINATION_AFTER_TERMINATION] = "Termination After Termination (113)";
    this.errorMsgs[RETRIEVE_DATA_BEFORE_INITIALIZATION] = "Retrieve Data Before Initialization (122)";
    this.errorMsgs[RETRIEVE_DATA_AFTER_TERMINATION] = "Retrieve Data After Termination (123)";
    this.errorMsgs[STORE_DATA_BEFORE_INITIALIZATION] = "Store Data Before Initialization (132)";
    this.errorMsgs[STORE_DATA_AFTER_TERMINATION] = "Store Data After Termination (133)";
    this.errorMsgs[COMMIT_BEFORE_INITIALIZATION] = "Commit Before Initialization (142)";
    this.errorMsgs[COMMIT_AFTER_TERMINATION] = "Commit After Termination (143)";
    this.errorMsgs[GENERAL_ARGUMENT_ERROR] = "General Argument Error (201)";
    this.errorMsgs[GENERAL_GET_FAILURE] = "General Get Failure (301)";
    this.errorMsgs[GENERAL_SET_FAILURE] = "General Set Failure (351)";
    this.errorMsgs[GENERAL_COMMIT_FAILURE] = "General Commit Failure (391)";
    this.errorMsgs[UNDEFINED] = "Undefined Data Model Element (401)";
    this.errorMsgs[UNIMPLEMENTED] = "Unimplemented Data Model Element (402)";
    this.errorMsgs[NOT_INITIALIZED] = "Data Model Element Value Not Initialized (403)";
    this.errorMsgs[READ_ONLY] = "Data Model Element Is Read Only (404)";
    this.errorMsgs[WRITE_ONLY] = "Data Model Element Is Write Only (405)";
    this.errorMsgs[TYPE_MISMATCH] = "Data Model Element Type Mismatch (406)";
    this.errorMsgs[OUT_OF_RANGE] = "Data Model Element Value Out Of Range (407)";
    this.errorMsgs[DEPENDENCY_NOT_EST] = "Data Model Dependency Not Established (408)";
    this.sendRequest = activelms_sendRequest;
    this.apiEventCallback = activelms_invokeCallback;
    this.isInitialized = activelms_isInitialized;
    this.serializeXML = activelms_serializeXML;
    this.Initialize = activelms_Initialize;
    this.Terminate = activelms_Terminate;
    this.GetValue = activelms_GetValue;
    this.SetValue = activelms_SetValue;
    this.Commit = activelms_Commit;
    this.GetLastError = activelms_GetLastError;
    this.GetErrorString = activelms_GetErrorString;
    this.GetDiagnostic = activelms_GetDiagnostic;
    this.toString = activelms_toString;
    this.debug = activelms_debug;
    this.enter = activelms_enter;
    this.exit = activelms_exit;
    this.error = activelms_error;
    this.setCourseId = activelms_setCourseId;
	this.setOrgId = activelms_setOrgId;
    this.setScoId = activelms_setScoId;
    this.setLearnerId = activelms_setLearnerId;
    this.trace = activelms_trace;
    this.isValid = activelms_isValid;
    this.joinKeys = activelms_joinKeys;
    this.newDocument = activelms_newDocument;
    this.newElement = activelms_newElement;
    this.getElement = activelms_getElement;
    this.setAttribute = activelms_setAttribute;
    this.getElementText = activelms_getElementText;
    this.setElementText = activelms_setElementText;
    this.setNumericPattern = activelms_setNumericPattern;
    this.setElementLangString = activelms_setElementLangString;
    this.removeChildren = activelms_removeChildren;
    this.getElementFloat = activelms_getElementFloat;
    this.getElementCount = activelms_getElementCount;
    this.getElementAtIndex = activelms_getElementAtIndex;
    this.getElementForSet = activelms_getElementForSet;
    this.getCDataText = activelms_getCDataText;
    this.getCmiValue = activelms_getCmiValue;
    this.getCommentsFromLearnerValue = activelms_getCommentsFromLearnerValue;
    this.getCommentsFromLMSValue = activelms_getCommentsFromLMSValue;
    this.getScoreValue = activelms_getScoreValue;
    this.getInteractionValue = activelms_getInteractionValue;
    this.getIxObjRefValue = activelms_getIxObjRefValue;
    this.getIxCorrectResponseValue = activelms_getIxCorrectResponseValue;
    this.getObjectiveValue = activelms_getObjectiveValue;
    this.getObjectiveScoreValue = activelms_getObjectiveScoreValue;
    this.getLearnerPreferenceValue = activelms_getLearnerPreferenceValue;
    this.setCmiValue = activelms_setCmiValue;
    this.setCommentsFromLearnerValue = activelms_setCommentsFromLearnerValue;
    this.setCommentsFromLMSValue = activelms_setCommentsFromLMSValue;
    this.setScoreValue = activelms_setScoreValue;
    this.setObjectivesValue = activelms_setObjectivesValue;
    this.setLearnerPreferenceValue = activelms_setLearnerPreferenceValue;
    this.setInteractionsValue = activelms_setInteractionsValue;
    this.addStep = activelms_addStep;
    this.addRespStep = activelms_addRespStep;
    this.validatePattern = activelms_validatePattern;
    this.validateResponse = activelms_validateResponse;
    this.isValidMatchingPattern = activelms_isValidMatchingPattern;
    this.isValidPerformancePattern = activelms_isValidPerformancePattern;
    this.assertIsOnlyPattern = activelms_assertIsOnlyPattern;
    this.isLeaf = activelms_isLeaf;
    this.READ_ONLY = activelms_READ_ONLY;
    this.WRITE_ONLY = activelms_WRITE_ONLY;
    this.NOT_INITIALIZED = activelms_NOT_INITIALIZED;
    this.SET_BAD_NAME = activelms_SET_BAD_NAME;
    this.GET_BAD_NAME = activelms_GET_BAD_NAME;
    this.NULL_VALUE = activelms_NULL_VALUE;
    this.UNDEFINED = activelms_UNDEFINED;
    this.GENERAL_GET_FAILURE = activelms_GENERAL_GET_FAILURE;
    this.OUT_OF_RANGE = activelms_OUT_OF_RANGE;
    this.TYPE_MISMATCH = activelms_TYPE_MISMATCH;
    this.INDEX_OUT_OF_BOUNDS = activelms_INDEX_OUT_OF_BOUNDS;
    this.INVALID_INDEX = activelms_INVALID_INDEX;
    this.NO_CHILDREN = activelms_NO_CHILDREN;
    this.NO_COUNT = activelms_NO_COUNT;
    this.SET_INDEX_OUT_OF_BOUNDS = activelms_SET_INDEX_OUT_OF_BOUNDS;
    this.SET_INVALID_INDEX = activelms_SET_INVALID_INDEX;
    this.DEPENDENCY_NOT_EST = activelms_DEPENDENCY_NOT_EST;
    this.UNIQUE_ID_CONSTRAINT_VIOLATED = activelms_UNIQUE_ID_CONSTRAINT_VIOLATED;
    this.INVALID_PATTERN = activelms_INVALID_PATTERN;
    this.GENERAL_SET_PATTERN_FAILURE = activelms_GENERAL_SET_PATTERN_FAILURE;
    this.NOT_VOCAB = activelms_NOT_VOCAB;
    
    // Added by activelms
	this.confirmLogout = activelms_confirmLogout;
	this.findObjectiveById = activelms_findObjectiveById;
	this.isDuplicateId = activelms_isDuplicateId;
	this.isDuplicateInteractionsId = activelms_isDuplicateInteractionsId;
    this.sendRequestInitialize = activelms_sendRequestInitialize;
    this.initializeCallback = activelms_initializeCallback;//call back from XML HTTP req
    //this.preInitializeCallback = null;//call back to UI
    this.getScormVersion = activelms_getScormVersion;
    
    this.sendRequestCommit = activelms_sendRequestCommit;
    
    this.terminatePreProcess = activelms_terminatePreProcess;
    this.sendRequestTerminate = activelms_sendRequestTerminate;
    this.terminateCallback = activelms_terminateCallback;//call back from XML HTTP req
    //this.postTerminateCallback = null;//call back to UI
    this.boolean_Async = false;
    this.xmlHttpReq = null;
    this.obj_Node = null;
    
}

//var globalAdapter = null;

function activelms_getScormVersion(str_SchemaVersion){

	try{
		var obj_Support = 
			new com.activelms.ScormVersionSupport(str_SchemaVersion);
		return obj_Support.evaluate();
	}
	catch(error){
    	return 1.2;
	}	
}

function activelms_READ_ONLY(name) {
    this.errorCode = READ_ONLY;
    this.errorDiag = name+" is read-only.";
    return FALSE;
}

function activelms_WRITE_ONLY(name) {
    this.errorCode = WRITE_ONLY;
    this.errorDiag = name+" is write-only.";
    return EMPTY;
}

function activelms_NOT_INITIALIZED(name) {
    this.errorCode = NOT_INITIALIZED;
    this.errorDiag = name+" is not initialized; must call SetValue for this element first.";
    return EMPTY;
}

function activelms_SET_BAD_NAME(name) {
    this.errorCode = UNDEFINED; 
	
	// Added by activelms for Conformance Test Content Object 3
	try{
		if(name.length==0){
			this.errorCode = GENERAL_SET_FAILURE;
		}
	}
	catch(error){
		this.errorCode = UNDEFINED;
	}
	
    this.errorDiag = "Unrecognized element name '"+name+"' passed to SetValue.";
    return FALSE;
}

function activelms_GET_BAD_NAME(name) {
    this.errorCode = UNDEFINED;
    this.errorDiag = "Unrecognized element name '"+name+"' passed to GetValue.";
    return EMPTY;
}

function activelms_NULL_VALUE(name) {
    this.errorCode = TYPE_MISMATCH;
    this.errorDiag = "Value for '"+name+"' cannot be null.";
    return FALSE;
}

function activelms_UNDEFINED(name) {
    this.errorCode = UNDEFINED;
    this.errorDiag = name+" is not defined as a valid element name in the SCORM 2004 RTE specification.";
    return EMPTY;
}

function activelms_UNDEFINED(name, value) {
    this.errorCode = UNDEFINED;
    this.errorDiag = name+" is not defined as a valid element name in the SCORM 2004 RTE specification.";
    return FALSE;
}

function activelms_OUT_OF_RANGE(name, value) {
    this.errorCode = OUT_OF_RANGE;
    this.errorDiag = "Value '"+value+"' is outside the range of valid values for '"+name+"'";
    return FALSE;
}

function activelms_TYPE_MISMATCH(name, value) {
    this.errorCode = TYPE_MISMATCH;
    this.errorDiag = "Value '"+value+"' does not conform to the SCORM 2004 RTE defined format for element '"+name+"'";
    return FALSE;
}

function activelms_INDEX_OUT_OF_BOUNDS(name, idx) {
    this.errorCode = GENERAL_GET_FAILURE;
    this.errorDiag = "Index '"+idx+"' is not valid for "+name;
    return EMPTY;
}

function activelms_INVALID_INDEX(name, idx) {
    this.errorCode = GENERAL_GET_FAILURE;
    this.errorDiag = "Index '"+idx+"' is not valid for "+name;
    return EMPTY;
}

function activelms_GENERAL_GET_FAILURE(name) {
    this.errorCode = GENERAL_GET_FAILURE;
    this.errorDiag = "Failed to get value for "+name;
    return EMPTY;
}

function activelms_NO_CHILDREN(name) {
    if (name.indexOf("._children") != -1) name = name.substring(0,name.indexOf("._children"));
    this.errorCode = GENERAL_GET_FAILURE;
    this.errorDiag = name+" does not have children.";
    return EMPTY;
}

function activelms_NO_COUNT(name) {
    if (name.indexOf("._count") != -1) name = name.substring(0,name.indexOf("._count"));
    this.errorCode = GENERAL_GET_FAILURE;
    this.errorDiag = name+" does not have a count.";
    return EMPTY;
}

function activelms_SET_INDEX_OUT_OF_BOUNDS(name, idx) {
    this.errorCode = GENERAL_SET_FAILURE;
    this.errorDiag = "Index '"+idx+"' is not valid for "+name;
    return FALSE;
}

function activelms_SET_INVALID_INDEX(name, idx) {
    this.errorCode = GENERAL_SET_FAILURE;
    this.errorDiag = "Index '"+idx+"' is not valid for "+name;
    return FALSE;
}

function activelms_DEPENDENCY_NOT_EST(name, dep) {
    this.errorCode = DEPENDENCY_NOT_EST;
    this.errorDiag = "Dependency not established; cannot SetValue for '"+name+"' until value for '"+dep+"' is set.";
    return FALSE;
}

function activelms_UNIQUE_ID_CONSTRAINT_VIOLATED(name, id, existingIndex) {
    this.errorCode = GENERAL_SET_FAILURE;
    this.errorDiag = "Identifier '"+id+"' already exists at index '"+existingIndex+"' for '"+name+"'; cannot set duplicate identifier.";
    return FALSE;
}

function activelms_INVALID_PATTERN(name, value, expected) {
    this.errorCode = TYPE_MISMATCH;
    this.errorDiag = "Value '"+value+"' does not conform to pattern '"+expected+"' for '"+name+"'.";
    return FALSE;
}

function activelms_GENERAL_SET_PATTERN_FAILURE(name, value, expected) {
    this.errorCode = GENERAL_SET_FAILURE;
    this.errorDiag = "Value '"+value+"' does not conform to pattern '"+expected+"' for '"+name+"'.";
    return FALSE;
}

function activelms_NOT_VOCAB(name, value, expected) {
    this.errorCode = TYPE_MISMATCH;
    this.errorDiag = "Value '"+value+"' is not an allowed value of '"+name+"'; expected one of "+expected;
    return FALSE;
}

function activelms_isInitialized() {
    return (this.cocd != null && !this.isTerminated) ? "true" : "false";
}

function activelms_invokeCallback(code, action, scoId, arg, exit) {

    if (this.onAPIEvent) {
        try {
            this.onAPIEvent(code, action, scoId, arg, exit);
        } catch (inerr) {
            if (inerr.message) {
                this.error(action, "", "Exception in "+action+" event listener: "+inerr.message);
            } else {
                this.error(action, "", "Exception in "+action+" event listener: "+inerr.toString());
            }
        }
    }
}

function activelms_initializeCallback(){


	/*
    if (globalAdapter && globalAdapter.xmlHttpReq.readyState == 4) {
	
		globalAdapter.errorCode = NO_ERROR;
    
		if(globalAdapter.DEBUG){
		    log.debug("RESPONSE SOAP Envelope for INITIALIZE is:\n\n " 
		    + globalAdapter.xmlHttpReq.responseText);
		}
	
        var respDoc = globalAdapter.xmlHttpReq.responseXML;
        log.debug("HTTP status=" + globalAdapter.xmlHttpReq.status);
        log.debug("location=" + window.document.location);
        log.debug("response=" + globalAdapter.xmlHttpReq.responseText);
        
        var soapBodyElm = globalAdapter.getElement(respDoc.documentElement, SOAPENV_BODY);
        var soapFaultElm = globalAdapter.getElement(soapBodyElm, SOAPENV_FAULT);
        
        if (soapFaultElm == null) {

			globalAdapter.doc = respDoc; // need a reference to the owner DOM Document

            globalAdapter.rteDataModel = globalAdapter.getElement(soapBodyElm, "RteDataModel");
			if(globalAdapter.rteDataModel == null){
				globalAdapter.rteDataModel = globalAdapter.getElement(soapBodyElm, "InitializeReturn");
			}
			
            var attrNode = globalAdapter.rteDataModel.getAttributeNode("session");
            if (attrNode != null) globalAdapter.sessionId = String(attrNode.nodeValue);
			
            attrNode = globalAdapter.rteDataModel.getAttributeNode("sco");
            if (attrNode != null) globalAdapter.scoId = String(attrNode.nodeValue);
			
            attrNode = globalAdapter.rteDataModel.getAttributeNode("course");
            if (attrNode != null) globalAdapter.courseId = String(attrNode.nodeValue);
			
            attrNode = globalAdapter.rteDataModel.getAttributeNode("learner");
            if (attrNode != null) globalAdapter.learnerId = String(attrNode.nodeValue);
            
            attrNode = globalAdapter.rteDataModel.getAttributeNode("learnerName");
            if (attrNode != null) globalAdapter.learnerName = String(attrNode.nodeValue);

            attrNode = globalAdapter.rteDataModel.getAttributeNode("pk");
            if (attrNode != null) globalAdapter.pk = String(attrNode.nodeValue);
            
            attrNode = globalAdapter.rteDataModel.getAttributeNode("domain");
            if (attrNode != null) globalAdapter.domainId = String(attrNode.nodeValue);
            
            attrNode = globalAdapter.rteDataModel.getAttributeNode("rteSchemaVersion");
            if (attrNode != null) globalAdapter.rteSchemaVersion = String(attrNode.nodeValue);
			
            globalAdapter.cocd = globalAdapter.getElement(globalAdapter.rteDataModel, "cocd");

            if (globalAdapter.cocd != null) {
                if(globalAdapter.boolean_Async){
                	//globalAdapter.preInitializeCallback();// call back to UI
                }
           	} 
           	else {
            	globalAdapter.errorCode = GENERAL_INITIALIZATION_FAILURE;
                globalAdapter.errorDiag = "Initialize request failed; response from server: "+globalAdapter.xmlHttpReq.responseText;
            }
        } 
        else {
            globalAdapter.errorCode = globalAdapter.getElementText(soapFaultElm, "faultcode");
			
			// chnaged es4js: to icn:
            if (globalAdapter.errorCode.indexOf("icn:") == 0) {
                globalAdapter.errorCode = globalAdapter.errorCode.substring(4);
            }
            globalAdapter.errorDiag = globalAdapter.getElementText(soapFaultElm, "faultstring");
        }
   	}
   	*/
}

function activelms_sendRequestInitialize(param) {
	
	// Reset the request time stamp for session management
	activelms.NavigationBehaviour.lastRequestTimestamp = new Date();

	//  Get a global reference to the Adapter
    //globalAdapter = this;

	// Create the SOAP Envelope
	var reqDoc = Sarissa.getDomDocument("http://schemas.xmlsoap.org/soap/envelope/","soap:Envelope");
	var elm_Document = reqDoc.documentElement;
	this.setAttribute(elm_Document, "xmlns:xsi", "http://www.w3.org/1999/XMLSchema-instance");
	this.setAttribute(elm_Document, "xmlns:xsd", "http://www.w3.org/1999/XMLSchema");
	if (this.browserType == "SFR"){
		   this.setAttribute(elm_Document, "xmlns:soap", "http://schemas.xmlsoap.org/soap/envelope/");
	}
	
	// Add the SOAP Body
	var elm_Body = this.newElement("soap:Body", "http://schemas.xmlsoap.org/soap/envelope/", reqDoc);
	elm_Document.appendChild(elm_Body);
	
    // Add the document wrapper
	var wrapperElm = this.newElement("icn:Initialize", activelms_NS, reqDoc);
    elm_Body.appendChild(wrapperElm);
	
	// Add contextual information to the wrapper
    if (this.courseId || this.scoId || this.learnerId) {
    	var rteDataModelElement = this.newElement(RTE_DATA_MODEL_TYPE, activelms_NS, reqDoc);

		this.setAttribute(rteDataModelElement, "action", "Initialize");
		this.setAttribute(rteDataModelElement, "learnerName", this.learnerName);
		this.setAttribute(rteDataModelElement, "learner", this.learnerId);
       	this.setAttribute(rteDataModelElement, "course", this.courseId);
       	this.setAttribute(rteDataModelElement, "org", this.orgId);
		this.setAttribute(rteDataModelElement, "sco", this.scoId);
		this.setAttribute(rteDataModelElement, "session", this.sessionId);
		this.setAttribute(rteDataModelElement, "pk", this.pk);
		this.setAttribute(rteDataModelElement, "domain", this.domainId);
		this.setAttribute(rteDataModelElement, "rteSchemaVersion", this.rteSchemaVersion);

		// Added by activelms to support the use of "lesson_mode"
		var elm_Cocd = this.newElement("cocd", "http://ltsc.ieee.org/xsd/1484_11_3", reqDoc);
		var elm_Mode = this.newElement("mode", "http://ltsc.ieee.org/xsd/1484_11_3", reqDoc);
		var node_Text = reqDoc.createTextNode(this.mode);
		elm_Mode.appendChild(node_Text);
		elm_Cocd.appendChild(elm_Mode);
		rteDataModelElement.appendChild(elm_Cocd);
		
        wrapperElm.appendChild(rteDataModelElement);
    }
    
	if(this.DEBUG){
	    log.debug("REQUEST SOAP Envelope for INITIALIZE is:\n\n " + reqDoc);
	}
	
    var xmlHttpReq  = (this.msxmlHttpProgId != null) ? new ActiveXObject(this.msxmlHttpProgId) : new XMLHttpRequest();

    //this.xmlHttpReq.open("POST", this.soapAddressLocation, this.boolean_Async);
    
    // Always make Initialize synchronous
    var boolean_LocalAsync = false;
    xmlHttpReq.open("POST", this.soapAddressLocation, boolean_LocalAsync);
    xmlHttpReq.setRequestHeader('Content-Type', 'text/xml; charset=utf-8');
    xmlHttpReq.setRequestHeader('SOAPAction', '"http://www.activelms.com/services/cmi/Initialize"');
    
    //log.debug("Preparing to send with async: " + this.boolean_Async);
    log.debug("Preparing to send with soapAddressLocation: " + this.soapAddressLocation);
    
    /*
    if(this.boolean_Async){
		globalAdapter.boolean_Async = true;
    	globalAdapter.preInitializeCallback = this.preInitializeCallback;
    	this.xmlHttpReq.onreadystatechange = this.initializeCallback;
    }
    */

    /*
    if (this.browserType == "SFR") {
        var xmlBuf = new activelms_XMLBuf();
        var xmlStr = xmlBuf.xml2str(reqDoc);
        this.xmlHttpReq.send(xmlStr);
    } else {
        this.xmlHttpReq.send(reqDoc);
    }
    */
    

    // if async = false, will lock up here until response
    // Reset the request time stamp for session management
    xmlHttpReq.send(reqDoc);
    /*
	if(xmlHttpReq.readyState == 4){
        var respDoc = xmlHttpReq.responseXML;
        var soapBodyElm = this.getElement(respDoc.documentElement, SOAPENV_BODY);
        var soapFaultElm = this.getElement(soapBodyElm, SOAPENV_FAULT);
        if (soapFaultElm != null) {
            this.errorCode = GENERAL_INITIALIZATION_FAILURE;
            this.errorDiag = xmlHttpReq.responseText;
        }
	}
	*/
	
    if (xmlHttpReq.readyState == 4){
        var respDoc = xmlHttpReq.responseXML;
        this.doc = respDoc;
        var soapBodyElm = this.getElement(respDoc.documentElement, SOAPENV_BODY);
        var soapFaultElm = this.getElement(soapBodyElm, SOAPENV_FAULT);
        if (soapFaultElm == null) {
        	this.errorCode = NO_ERROR; // no SOAP fault means success
            this.rteDataModel = this.getElement(soapBodyElm, "RteDataModel");
			if(this.rteDataModel == null){
				this.rteDataModel = this.getElement(soapBodyElm, "InitializeReturn");
			}
            var attrNode = this.rteDataModel.getAttributeNode("session");
            if (attrNode != null) this.sessionId = String(attrNode.nodeValue);
			
            attrNode = this.rteDataModel.getAttributeNode("sco");
            if (attrNode != null) this.scoId = String(attrNode.nodeValue);
			
            attrNode = this.rteDataModel.getAttributeNode("course");
            if (attrNode != null) this.courseId = String(attrNode.nodeValue);
			
            attrNode = this.rteDataModel.getAttributeNode("learner");
            if (attrNode != null) this.learnerId = String(attrNode.nodeValue);
            
            attrNode = this.rteDataModel.getAttributeNode("learnerName");
            if (attrNode != null) this.learnerName = String(attrNode.nodeValue);

            attrNode = this.rteDataModel.getAttributeNode("pk");
            if (attrNode != null) this.pk = String(attrNode.nodeValue);
            
            attrNode = this.rteDataModel.getAttributeNode("domain");
            if (attrNode != null) this.domainId = String(attrNode.nodeValue);
            
            attrNode = this.rteDataModel.getAttributeNode("rteSchemaVersion");
            if (attrNode != null) this.rteSchemaVersion = String(attrNode.nodeValue);
			
            this.cocd = this.getElement(this.rteDataModel, "cocd");
        } 
        else {
            this.errorCode = this.getElementText(soapFaultElm, "faultcode");
            if (this.errorCode.indexOf("icn:") == 0) {
                this.errorCode = this.errorCode.substring(4);
            }
            this.errorDiag = this.getElementText(soapFaultElm, "faultstring");
        }
    } 
    else {
        this.errorCode = GENERAL_INITIALIZATION_FAILURE;
        this.errorDiag = xmlHttpReq.statusText;
    }

    
    //log.debug("Sent with POST");
    
    //if(!this.boolean_Async){
    	//this.initializeCallback();
    //}

    return this.errorCode;
}

function activelms_sendRequestCommit(param) {
	
	// Reset the request time stamp for session management
	activelms.NavigationBehaviour.lastRequestTimestamp = new Date();

	var action = "Commit";
	
	this.rteDataModel = this.rteDataModel.parentNode.removeChild(this.rteDataModel);
	
    // Add the document wrapper
	var wrapperElm = this.newElement("icn:Commit", activelms_NS, reqDoc);
    wrapperElm.appendChild(this.rteDataModel);

	//var commitElm = this.newElement("icn:Commit", activelms_NS);
    //commitElm.appendChild(this.rteDataModel);
    
   	var soapBodyElm = this.getElement(this.doc.documentElement, SOAPENV_BODY);
   	this.removeChildren(soapBodyElm);
    soapBodyElm.appendChild(wrapperElm);
	
	this.setAttribute(this.rteDataModel, "action", action);
    this.setAttribute(this.rteDataModel, "learnerName", this.learnerName);
    this.setAttribute(this.rteDataModel, "learner", this.learnerId);
    this.setAttribute(this.rteDataModel, "course", this.courseId);
    this.setAttribute(this.rteDataModel, "org", this.orgId);
    this.setAttribute(this.rteDataModel, "sco", this.scoId);
    this.setAttribute(this.rteDataModel, "session", this.sessionId);
	this.setAttribute(this.rteDataModel, "pk", this.pk);
	this.setAttribute(this.rteDataModel, "domain", this.domainId);
	this.setAttribute(this.rteDataModel, "rteSchemaVersion", this.rteSchemaVersion);
    this.setAttribute(this.rteDataModel, "adlNavRequest", null);

    var reqDoc = this.doc;
	
	if(this.DEBUG){
	    log.debug("REQUEST SOAP Envelope for COMMIT is:\n\n " + reqDoc);
	}
    
    var xmlHttpReq = (this.msxmlHttpProgId != null) ? new ActiveXObject(this.msxmlHttpProgId) : new XMLHttpRequest();
    var boolean_LocalAsync = false;
    xmlHttpReq.open("POST", this.soapAddressLocation, boolean_LocalAsync);
    xmlHttpReq.setRequestHeader('Content-Type', 'text/xml; charset=utf-8');
    xmlHttpReq.setRequestHeader('SOAPAction', '"http://www.activelms.com/services/cmi/Commit"');
    
    /*
    if (this.browserType == "SFR") {
        var xmlBuf = new activelms_XMLBuf();
        var xmlStr = xmlBuf.xml2str(reqDoc);
        xmlHttpReq.send(xmlStr);
    } else {
        xmlHttpReq.send(reqDoc);
    }
    */
    
    xmlHttpReq.send(reqDoc);
    if (xmlHttpReq.readyState == 4) {
        var respDoc = xmlHttpReq.responseXML;
        var soapBodyElm = this.getElement(respDoc.documentElement, SOAPENV_BODY);
        var soapFaultElm = this.getElement(soapBodyElm, SOAPENV_FAULT);
        if (soapFaultElm == null) {
        	this.errorCode = NO_ERROR; // no SOAP fault means success
        } 
        else {
            this.errorCode = this.getElementText(soapFaultElm, "faultcode");
            if (this.errorCode.indexOf("icn:") == 0) {
                this.errorCode = this.errorCode.substring(4);
            }
            this.errorDiag = this.getElementText(soapFaultElm, "faultstring");
        }
    } 
    else {
        this.errorCode = GENERAL_COMMIT_FAILURE;
        this.errorDiag = xmlHttpReq.statusText;
    }
    return this.errorCode;
}

function activelms_terminateCallback(){
    /*
	var action = "Terminate";
	
    if (globalAdapter.xmlHttpReq.readyState == 4) {
	
		if(globalAdapter.DEBUG){
		    log.debug("RESPONSE SOAP Envelope TERMINATE is:\n\n " + globalAdapter.xmlHttpReq.responseText);
		}
		
        var respDoc = globalAdapter.xmlHttpReq.responseXML;
        
        var soapBodyElm = globalAdapter.getElement(respDoc.documentElement, SOAPENV_BODY);
        var soapFaultElm = globalAdapter.getElement(soapBodyElm, SOAPENV_FAULT);
		
        if (soapFaultElm == null) {
        	globalAdapter.errorCode = NO_ERROR; // no SOAP fault means success
            if(globalAdapter.boolean_Async){
            	globalAdapter.postTerminateCallback();// call back to UI
           }
        } 
        else {
            globalAdapter.errorCode = globalAdapter.getElementText(soapFaultElm, "faultcode");
            if (globalAdapter.errorCode.indexOf("icn:") == 0) {
                globalAdapter.errorCode = globalAdapter.errorCode.substring(4);
            }
            globalAdapter.errorDiag = globalAdapter.getElementText(soapFaultElm, "faultstring");
			if(globalAdapter.DEBUG){
            	//alert(globalAdapter.errorDiag);
			}
            if(globalAdapter.boolean_Async){
            	globalAdapter.postTerminateCallback();// call back to UI with an error
             }
        }
    } 
    */
}

function activelms_sendRequestTerminate(param, b_WindowCloseEvent) {

	/*
	 * Code added by activelms when a sequencing fault occurs
	 * and exitAll is called by the Fault JSP Page
	 */
	 /*
    if (this.isTerminated) {
        this.errorCode = TERMINATION_AFTER_TERMINATION;
        return this.errorCode;
    }
	*/

	// Reset the request time stamp for session management
	activelms.NavigationBehaviour.lastRequestTimestamp = new Date();
	
	var action = "Terminate";

	this.rteDataModel = this.rteDataModel.parentNode.removeChild(this.rteDataModel);
	
    // Add the document wrapper
	var wrapperElm = this.newElement("icn:Terminate", activelms_NS);
    wrapperElm.appendChild(this.rteDataModel);
	
	//var terminateElm = this.newElement("icn:Terminate", activelms_NS);
    //terminateElm.appendChild(this.rteDataModel);
    
    var soapBodyElm = this.getElement(this.doc.documentElement, SOAPENV_BODY);
    this.removeChildren(soapBodyElm);
    soapBodyElm.appendChild(wrapperElm);
	
	// Get totalTime, as the milliseconds value is not deserialized as a duration
	var str_TotalTime = this.getElementText(this.cocd, "totalTime");
	
	this.setAttribute(this.rteDataModel, "action", action);
    this.setAttribute(this.rteDataModel, "learnerName", this.learnerName);
    this.setAttribute(this.rteDataModel, "learner", this.learnerId);
    this.setAttribute(this.rteDataModel, "course", this.courseId);
    this.setAttribute(this.rteDataModel, "org", this.orgId);
    this.setAttribute(this.rteDataModel, "sco", this.scoId);
    this.setAttribute(this.rteDataModel, "session", this.sessionId);
	this.setAttribute(this.rteDataModel, "pk", this.pk);
	this.setAttribute(this.rteDataModel, "domain", this.domainId);
	this.setAttribute(this.rteDataModel, "rteSchemaVersion", this.rteSchemaVersion);
    this.setAttribute(this.rteDataModel, "adlNavRequest", this.adlNavRequest);
    this.setAttribute(this.rteDataModel, "totalTime", str_TotalTime);

    var reqDoc = this.doc;
	if(this.DEBUG){
	    log.debug("REQUEST SOAP Envelope for TERMINATE is:\n\n " + reqDoc);
	    }

    var xmlHttpReq  = (this.msxmlHttpProgId != null) ? new ActiveXObject(this.msxmlHttpProgId) : new XMLHttpRequest();
    
    /*
    this.xmlHttpReq.setRequestHeader('Content-Type', 'text/xml; charset=utf-8');
    this.xmlHttpReq.setRequestHeader('SOAPAction', '"http://www.activelms.com/services/cmi/Terminate"');

    if(b_WindowCloseEvent == true){
        // the window is closing, make a synchronous call
        this.xmlHttpReq.open("POST", this.soapAddressLocation, false);
        this.xmlHttpReq.send(reqDoc);
        return;
    }
    */
    
    var boolean_LocalAsync = false;
    //this.xmlHttpReq.open("POST", this.soapAddressLocation, this.boolean_Async);
    xmlHttpReq.open("POST", this.soapAddressLocation, boolean_LocalAsync);
    xmlHttpReq.setRequestHeader('Content-Type', 'text/xml; charset=utf-8');
    xmlHttpReq.setRequestHeader('SOAPAction', '"http://www.activelms.com/services/cmi/Terminate"');
    
    //globalAdapter = this;
	
	/*
    if(this.boolean_Async){
    	globalAdapter.postTerminateCallback = this.postTerminateCallback;//UI call back
    	this.xmlHttpReq.onreadystatechange = this.terminateCallback;// XML HTTP call back
    }
    */

    /*
    if (this.browserType == "SFR") {
        var xmlBuf = new activelms_XMLBuf();
        var xmlStr = xmlBuf.xml2str(reqDoc);
        this.xmlHttpReq.send(xmlStr);
    } 
    else {
        this.xmlHttpReq.send(reqDoc);
    }
    */
    
   //this.xmlHttpReq.send(reqDoc);
    xmlHttpReq.send(reqDoc);
    if (xmlHttpReq.readyState == 4) {
        var respDoc = xmlHttpReq.responseXML;
        var soapBodyElm = this.getElement(respDoc.documentElement, SOAPENV_BODY);
        var soapFaultElm = this.getElement(soapBodyElm, SOAPENV_FAULT);
        if (soapFaultElm == null) {
        	this.errorCode = NO_ERROR; // no SOAP fault means success
        } 
        else {
            this.errorCode = this.getElementText(soapFaultElm, "faultcode");
            if (this.errorCode.indexOf("icn:") == 0) {
                this.errorCode = this.errorCode.substring(4);
            }
            this.errorDiag = this.getElementText(soapFaultElm, "faultstring");
        }
    } 
    else {
        this.errorCode = GENERAL_TERMINATION_FAILURE;
        this.errorDiag = xmlHttpReq.statusText;
    }
    
    /*
    //if(!this.boolean_Async){
    	this.terminateCallback();
    	this.errorCode =  globalAdapter.errorCode;
    	this.errorDiag =  globalAdapter.errorDiag;
    	globalAdapter = null;
    //}
    */

    return this.errorCode;
}

function activelms_sendRequest(action, param) {

    if (action == "Initialize") {
    	this.sendRequestInitialize(param);
    } 
    else if (action == "Terminate") {
    	this.sendRequestTerminate(param);
    } 
    else if (action == "Commit") {
		this.sendRequestCommit(param);
    }

    return this.errorCode;
}

function activelms_Initialize(param) {
	
    log.v2004("API Initialize: " + param);

    this.errorCode = NO_ERROR;
    this.errorDiag = null;
    this.adlNavRequest = _NONE_;
    this.adlNavChoiceTarget = null;

    if(this.initializedAt != null){
        this.errorCode = ALREADY_INITIALIZED;
    	log.v2004("API Initialize return: false. Error:" + ALREADY_INITIALIZED);
        return FALSE;
    }
    
    //if (param != undefined && param != null && param != "" && param != "\"\"" && param != "PRELOAD") {
    if (param != "") {
        this.errorCode = GENERAL_ARGUMENT_ERROR;
    	log.v2004("API Initialize return: false. Error:" + GENERAL_ARGUMENT_ERROR);
        return FALSE;
    }
    
    var result = FALSE;
    if(typeof(this.scoId) == "undefined" || this.scoId == null){
        this.scoId = ICN_ADAPTER_GLOBAL_STATE.scoId;
    }

    try {
        this.errorCode = this.sendRequest("Initialize", param);
    }
    catch (error) {
        this.errorCode = GENERAL_INITIALIZATION_FAILURE;
        this.errorDiag = trim((error instanceof Error && error.message) ? error.message : error.toString());
        this.apiEventCallback(this.errorCode, "Initialize", "", trim(this.errorDiag), "");
    }

   	if(this.errorCode == NO_ERROR){
   	    result = TRUE;
        this.isTerminated = false;
		this.initializedAt = new Date();
       	this.apiEventCallback(this.errorCode, "Initialize", this.scoId, trim(this.errorDiag), "");
    }
    else{
        result = FALSE;
        this.rteDataModel = null;
        this.cocd = null;
        this.doc = null;
        this.initializedAt = null;
        this.adlNavRequest = _NONE_;
        this.adlNavChoiceTarget = null;
    }
    
    log.v2004("API Initialize return: " + result);
    
    return result;
}

function activelms_Commit(param) {
	
    log.v2004("API Commit: " + param);
    
    this.errorCode = NO_ERROR;
    this.errorDiag = null;
    if (this.initializedAt == null) {
        this.errorCode = COMMIT_BEFORE_INITIALIZATION;
    	log.v2004("API Commit return: false. Error:" + COMMIT_BEFORE_INITIALIZATION);
        return FALSE;
    }
    if (this.isTerminated) {
        this.errorCode = COMMIT_AFTER_TERMINATION;
        return FALSE;
    }
    
    //if (param != undefined && param != null && param != "" && param != "\"\"") {/
    if (param != "") {
        this.errorCode = GENERAL_ARGUMENT_ERROR;
    	log.v2004("API Commit return: false. Error:" + GENERAL_ARGUMENT_ERROR);
        return FALSE;
    }

    var result = FALSE;
    
    try {

		// Adjusted by activelms
    	var str_Mode = this.getElementText(this.cocd, "mode");
    	var exit = this.getElementText(this.cocd, "exit");
    	var timeLimitAction = this.getElementText(this.cocd, "timeLimitAction");

        // Added by activelms for IEEE mapping
        timeLimitAction = cmiTimeLimitActionToXML(timeLimitAction);
		this.setElementText(this.cocd, "timeLimitAction", timeLimitAction);
			
		// Added by Icodoen for IEEE mapping
        exit = cmiExitToXML(exit);
        this.setElementText(this.cocd, "exit", exit);
    	
        //if (this.sendRequest("Commit", param) == NO_ERROR) {result = TRUE;}
        //this.apiEventCallback(this.errorCode, "Commit", this.scoId, trim(this.errorDiag), "");
        this.errorCode = this.sendRequest("Commit", param);
        
   	    if(this.errorCode == NO_ERROR){
   	        result = TRUE;
            this.apiEventCallback(this.errorCode, "Commit", this.scoId, trim(this.errorDiag), "");
        }
        else{
            result = FALSE;
        }
    } 
    catch (error) {
        this.errorCode = GENERAL_COMMIT_FAILURE;
        this.errorDiag = (error instanceof Error && error.message) ? error.message : error.toString();
        this.apiEventCallback(this.errorCode, "Commit", this.scoId, trim(this.errorDiag), "");
    }
    
    log.v2004("API Commit return: " + result);

    return result;
}

function activelms_terminatePreProcess(){

	var float_ScormVersion = this.getScormVersion(this.rteSchemaVersion);
    var mode = this.getElementText(this.cocd, "mode");
    var exit = this.getElementText(this.cocd, "exit");
    var timeLimitAction = this.getElementText(this.cocd, "timeLimitAction");
    // Added by activelms for IEEE mapping
    timeLimitAction = cmiTimeLimitActionToXML(timeLimitAction);
	this.setElementText(this.cocd, "timeLimitAction", timeLimitAction);
	// Added by activelms for SCORM 2004 3rd Edition
	if(this.adlNavRequest == "suspendAll"){
    	exit = "suspend";
	}
	
    if (mode == "normal") {
    // For SCORM 1.2 support, if lesson_status has not been set, then the LMS must set to completed.
	if(float_ScormVersion < 2004){
	    var str_LessonStatus = this.getElementText(this.cocd, "lessonStatus");
        if(str_LessonStatus == "not_attempted"){
            // Update the legacy lessonStatus
			this.setElementText(this.cocd, "lessonStatus", "completed");
			// Update the SCORM 2004 equivalent
			this.setElementText(this.cocd, "completionStatus", "completed");
        }
        else if(str_LessonStatus == "incomplete"){
		    // Update the SCORM 2004 equivalent NET-271
			this.setElementText(this.cocd, "completionStatus", "incomplete");
        }
        else if(str_LessonStatus == "completed"){
		    // Update the SCORM 2004 equivalent NET-271
			this.setElementText(this.cocd, "completionStatus", "completed");
        }
	}
	else{
        var fProgressMeasure = this.getElementFloat(this.cocd, "progressMeasure");
        if (fProgressMeasure != null) {
            if (fProgressMeasure == 0) {
                this.setElementText(this.cocd, "completionStatus", "not_attempted");
            } 
            else if (fProgressMeasure == 1) {
                this.setElementText(this.cocd, "completionStatus", "completed");
            } 
            else {
                var fCompletionThreshold = this.getElementFloat(this.cocd, "completionThreshold");
                if (fCompletionThreshold != null) {
                    if (fProgressMeasure >= fCompletionThreshold) {
                        this.setElementText(this.cocd, "completionStatus", "completed");
                     } 
                     else {
                        this.setElementText(this.cocd, "completionStatus", "incomplete");
                     }
                  }
              }
          }
       }
            
       // For SCORM 1.2 support
		if(float_ScormVersion < 2004){
            // setting of cmi.core.lesson_status=passed from adlcp:masteryscore managed in scorm1p2.js
            var str_LessonStatus = this.getElementText(this.cocd, "lessonStatus");
            if(str_LessonStatus == "failed"){
			// Update the SCORM 2004 equivalent
			    this.setElementText(this.cocd, "successStatus", "failed");//NET-271
            }
            else if(str_LessonStatus == "passed"){
                // Update the SCORM 2004 equivalent
			    this.setElementText(this.cocd, "successStatus", "passed");//NET-271
            }
            	/*
            	// To keep consistent reporting in CMI Persistence & Event APIs and Sequencing Information Model
                var score = this.getElement(this.cocd, "score");
                if (score != null) {
                    // The score.raw is scaled 0-100 in SCORM 1.2
                    var f_Raw = this.getElementFloat(score, "raw");
                    if(f_Raw != null){
                        // Equivalent to score.scaled in SCORM 2004, 0.0 to 1.0
                        f_Raw = f_Raw/100;
                        // Update the SCORM 2004 equivalent
                        this.setElementText(score, "scaled", f_Raw.toString());//NET-273
                     }
                 }
                 */
		}
		else{
            var fScaledPassingScore = this.getElementFloat(this.cocd, "scaledPassingScore");
            if (fScaledPassingScore != null) {
                var score = this.getElement(this.cocd, "score");
                if (score != null) {
                    var fScaled = this.getElementFloat(score, "scaled");
                    if (fScaled == null) {
                        this.setElementText(this.cocd, "successStatus", "unknown");
                    } else {
                        this.setElementText(this.cocd, "successStatus", ((fScaled >= fScaledPassingScore)?"passed":"failed"));
                    }
                }
            }
        }

        var sessionMillis = 0;
        var sessionTimeNode = this.getElement(this.cocd, "sessionTime");
        if (sessionTimeNode != null) {
            sessionMillis = parseTimeIntervalIntoMillis(this.getElementText(sessionTimeNode));
            if (sessionMillis < 0) sessionMillis = 0;
        } 
        else {
            sessionMillis = (((new Date()).getTime()-this.initializedAt.getTime()));
            this.setElementText(this.cocd, "sessionTime", fromMillis(sessionMillis));
        }     
			
		// Total time
		var totalMillis = parseTimeIntervalIntoMillis(this.getElementText(this.cocd, "totalTime"));
        this.setElementText(this.cocd, "totalTime", fromMillis(totalMillis+sessionMillis));

			/*
            // Added by activelms for IEEE mapping
            timeLimitAction = cmiTimeLimitActionToXML(timeLimitAction);
			this.setElementText(this.cocd, "timeLimitAction", timeLimitAction);
			*/
			
			// Added by Icodoen for IEEE mapping
        exit = cmiExitToXML(exit);
        this.setElementText(this.cocd, "exit", exit);
        if (exit == null) {
            exit = "";
            this.setElementText(this.cocd, "exit", exit);
        }
        var entry = ((exit=="suspend"||exit=="logout")?"resume":"");
        this.setElementText(this.cocd, "entry", entry);
   } 
   else {
       // not in normal mode ... so not really tracking ...
       this.setElementText(this.cocd, "exit", "");
       this.setElementText(this.cocd, "entry", "");
   }
   return exit;
}

function activelms_Terminate(param) {
	
    log.v2004("API Terminate: " + param);

    this.errorCode = NO_ERROR;
    this.errorDiag = null;
    
    if (this.initializedAt == null) {
        this.errorCode = TERMINATION_BEFORE_INITIALIZATION;
    	log.v2004("API Terminate return: false. Error:" + TERMINATION_BEFORE_INITIALIZATION);
        return FALSE;
    }
    if (this.isTerminated) {
        this.errorCode = TERMINATION_AFTER_TERMINATION;
    	log.v2004("API Terminate return: false. Error:" + TERMINATION_AFTER_TERMINATION);
        return FALSE;
    }
    
    //if (param != undefined && param != null && param != "" && param != "\"\"") {
    if (param != "") {
        this.errorCode = GENERAL_ARGUMENT_ERROR;
    	log.v2004("API Terminate return: false. Error:" + GENERAL_ARGUMENT_ERROR);
        return FALSE;
    }

    var result = FALSE;
    
    try {
        var exit = this.terminatePreProcess();
        
		//if(!this.boolean_Async){
		
			var err = this.sendRequest("Terminate", param);
        	if (err == NO_ERROR) {
            	result = TRUE;
            	//if (!this.fromQuitHandler) {
                	var theNavRequest = _NONE_;
                	if (this.getElementText(this.cocd, "mode") == "normal") {
                    	theNavRequest = ((exit=="suspend"||exit=="logout")?_NONE_:this.adlNavRequest);
                	} 
                	else {
                    	if (
                    		this.adlNavRequest == "continue" 
                    		|| 
                    		this.adlNavRequest == "previous"
                    		|| 
                    		this.adlNavRequest == "exit"
                    		|| 
                    		this.adlNavRequest == "abandon"
                    		) {
                        	theNavRequest = _NONE_;
                    	} 
                    	else {
                        	theNavRequest = this.adlNavRequest;
                    	}
                	}

                	this.apiEventCallback(NO_ERROR, "Terminate", this.scoId, theNavRequest, exit);
            	//}
        	}

    		//this.doc = null; changed form nullify to support Ajax ENGINE
    		//this.rteDataModel = null; changed form nullify to support Ajax ENGINE
    		//this.cocd = null; changed form nullify to support Ajax ENGINE
    		this.scoId = null; 
    		this.initializedAt = null;
    		this.isTerminated = true;
    		this.adlNavRequest = _NONE_;
    		this.adlNavChoiceTarget = null;
    		//this.fromQuitHandler = false;
        //}
        /*
        else{
        	result = TRUE;
    		this.initializedAt = null;
    		this.isTerminated = true;
    		//this.fromQuitHandler = false;
        	this.apiEventCallback(NO_ERROR, "Terminate", this.scoId, _NONE_, exit);
        }
        */
    } catch (error) {

        this.errorCode = GENERAL_TERMINATION_FAILURE;
        this.errorDiag = (error instanceof Error && error.message) ? error.message : error.toString();
        this.apiEventCallback(this.errorCode, "Terminate", this.scoId, trim(this.errorDiag), exit);
    	//this.doc = null;
    	//this.rteDataModel = null;
    	//this.cocd = null;
    	this.scoId = null;
    	this.initializedAt = null;
    	this.isTerminated = true;
    	this.adlNavRequest = _NONE_;
    	this.adlNavChoiceTarget = null;
    	//this.fromQuitHandler = false;
    }
    
    log.v2004("API Terminate return: " + result);
    return result;
}

function activelms_GetValue(name) {

    log.v2004("API GetValue: " + name);

    this.errorCode = NO_ERROR;
    //if (this.doc == null) {
    if (this.initializedAt == null) {
        this.errorCode = RETRIEVE_DATA_BEFORE_INITIALIZATION;
    	log.v2004("API GetValue return: ''. Error:" + RETRIEVE_DATA_BEFORE_INITIALIZATION);
        return EMPTY;
    }
    if (this.isTerminated) {
        this.errorCode = RETRIEVE_DATA_AFTER_TERMINATION;
    	log.v2004("API GetValue return: ''. Error:" + RETRIEVE_DATA_AFTER_TERMINATION);
        return EMPTY;
    }
    if (name == null) return this.GET_BAD_NAME("null");
    if (name.length == 0) return this.GENERAL_GET_FAILURE("");
    if (name.length < 8) return this.GET_BAD_NAME(name);
	
    if (name.indexOf("cmi.") != 0) {
        if (name.indexOf(ADLNAV_REQUEST_VALID) == 0) {
            var navType = name.substr(ADLNAV_REQUEST_VALID.length);
            if (
            	navType == "continue" 
            	|| 
            	navType == "previous" 
            	|| 
            	(navType.indexOf("choice.{target=")==0 && 
				navType.charAt(navType.length-1)=='}')
            	|| 
            	(navType.indexOf("jump.{target=")==0 && 
				navType.charAt(navType.length-1)=='}')
            	) {
                if (this.isNavRequestValid) {
                    str_Result = this.isNavRequestValid(this.scoId, navType) ? TRUE : FALSE;
    				log.v2004("API GetValue return: " + str_Result);
    				return str_Result;
                } else {
    				log.v2004("API GetValue return: true");
                    return TRUE;
                }
            } else {
                return this.GET_BAD_NAME(name);
            }
        } else if (name == ADLNAV_REQUEST) {
            return (this.adlNavRequest != null)?this.adlNavRequest:_NONE_;
        } else {
            return this.GET_BAD_NAME(name);
        }
    }
    var result = EMPTY;
    var dotIdx = name.indexOf(".", 4);
    if (dotIdx != -1) {
        var cmiName = name.substring(4,dotIdx);
        if (cmiName == "comments_from_learner") {
            result = this.getCommentsFromLearnerValue(name.substr(dotIdx+1));
        } else if (cmiName == "comments_from_lms") {
            result = this.getCommentsFromLMSValue(name.substr(dotIdx+1));
        } else if (cmiName == "interactions") {
            result = this.getInteractionValue(name.substr(dotIdx+1));
        } else if (cmiName == "objectives") {
            result = this.getObjectiveValue(name.substr(dotIdx+1));
        } else if (cmiName == "learner_preference") {
            result = this.getLearnerPreferenceValue(name.substr(dotIdx+1));
        } else {
            result = this.getCmiValue(name.substr(4));
        }
    } else {
        result = this.getCmiValue(name.substr(4));
        
		var float_ScormVersion = this.getScormVersion(this.rteSchemaVersion);
        
        // 2004 3rd Ed, every get success_status, completion_status checked
        if(float_ScormVersion >= 2004.3){
        	if(name == "cmi.success_status"){

        		var elm;
        		var str_ScaledPassingScore;
        		elm = this.getElement(this.cocd, CMI_DEF["scaled_passing_score"].xmlName);
        		if (elm != null) {
                	str_ScaledPassingScore = this.getElementText(elm);
        		}
        		
				var str_ScoreScaled;
        		var score = this.getElement(this.cocd, "score");
        		if (score != null) {
           			elm = this.getElement(score, "scaled");
            		if (elm != null){
            			str_ScoreScaled = this.getElementText(elm);
            		}
        		}
				
				var obj_SuccessStatusSupport = 
					new com.activelms.SuccessStatusSupport(
						str_ScaledPassingScore,
						str_ScoreScaled,
						result);
					
				// Get the overridden result and update the state
				var str_Overriden = obj_SuccessStatusSupport.evaluate();
				result = str_Overriden;
				this.SetValue("cmi.success_status",result);
			}
        	else if(name == "cmi.completion_status"){
        		
        		var elm;
        		var str_CompletionThreshold;
        		elm = this.getElement(this.cocd, CMI_DEF["completion_threshold"].xmlName);
        		if (elm != null) {
					str_CompletionThreshold = this.getElementText(elm);
        		}
        		
        		var str_ProgressMeasure;
        		elm = this.getElement(this.cocd, CMI_DEF["progress_measure"].xmlName);
        		if (elm != null) {
					str_ProgressMeasure = this.getElementText(elm);
        		}
        	
				var obj_CompletionStatusSupport = 
					new com.activelms.CompletionStatusSupport(
						str_CompletionThreshold,
						str_ProgressMeasure,
						result);
					
				// Get the overridden result and update the state
				var str_Overriden = obj_CompletionStatusSupport.evaluate();
				result = str_Overriden;
				this.SetValue("cmi.completion_status",result);
			}
        }
    }

    if (result == null) result = EMPTY;
    if (this.errorCode == 0 && this.DEBUG) this.exit("GetValue", name, result);
    
    log.v2004("API GetValue return: " + result);

    return result;
}

function activelms_confirmLogout(str_Value){

	/*
	var bool_Logout = confirm(
		"The current activity has automatically requested to exit and log out." +
		"\n\n" +
		"Press \'OK\' to automatically log out." +
		"\n\n" +
		"Press \'Cancel\' to return to continue your session."
	);

	if(bool_Logout){
		return "logout";
	}
	else{
		return "";
	}
	*/
	
	return str_Value;

}

function activelms_SetValue(name, value) {

	// Always convert to a string
	value = value + "";
    log.v2004("API SetValue: " + name + "=" + value);
    
	if(value=="logout"){
		value = this.confirmLogout(value);
	}
	
    this.errorCode = NO_ERROR;

    //if (this.doc == null) {
    if (this.initializedAt == null) {
        this.errorCode = STORE_DATA_BEFORE_INITIALIZATION;
        return FALSE;
    }
    if (this.isTerminated) {
        this.errorCode = STORE_DATA_AFTER_TERMINATION;
        return FALSE;
    }
    if (name == null) return this.SET_BAD_NAME("null");
    if (name.length < 8) return this.SET_BAD_NAME(name);
    
    // 	if the mode is not normal or browse, we cannot set any value
    var str_LessonMode = this.getElementText(this.cocd, "mode");

    if (name.indexOf("cmi.") != 0) {
        if (name.indexOf(ADLNAV_REQUEST_VALID) == 0) {
            return this.READ_ONLY(name);
        } 
		else if (name == ADLNAV_REQUEST) {
            this.adlNavRequest = _NONE_;
            this.adlNavChoiceTarget = null;
            if (isADLNav(value)) {
                this.adlNavRequest = value;
                this.adlNavChoiceTarget = null;
                return TRUE;
            } else {
                if (value != null) {
					
                    if (value.indexOf("{target=")==0){
						if (value.indexOf("}choice") == (value.length - 7)) {
							this.adlNavChoiceTarget = value.substring(8, (value.length - 7));
						}
						else if (value.indexOf("}jump") == (value.length - 5)) {
							this.adlNavChoiceTarget = value.substring(8, (value.length - 5));
						}
						
                        if (this.adlNavChoiceTarget.length > 0) {
                            this.adlNavRequest = value;
                            log.v2004("API SetValue return: true");
                            return TRUE;
                        } else {
                            this.adlNavRequest = _NONE_;
                            this.adlNavChoiceTarget = null;
                            return this.TYPE_MISMATCH(name,value);
                        }
                    } else {
                        return this.TYPE_MISMATCH(name,value);
                    }
                } else {
                    return this.TYPE_MISMATCH(name,value);
                }
            }
        } 
		else if(name.indexOf("icn.") != -1){
			// Setting a data model element from the activelms namespace
			if(name == "icn.lesson_status" && str_LessonMode != "review"){
				// Support persistence of SCORM 1.2 cmi.core.lesson_status as a legacy datamodel element
				
				// Validation
				if(value != "not attempted"){
					if(
					value == "passed"
					||
					value == "completed"
					||
					value == "failed"
					||
					value == "incomplete"
					||
					value == "browsed"
					){
						this.setElementText(this.cocd, "lessonStatus", value);
					}
				}
			}
		}
		else {
            return this.SET_BAD_NAME(name);
        }
    }
    if (name.indexOf("._version") != -1 || name.indexOf("._count") != -1 || name.indexOf("._children") != -1) return this.READ_ONLY(name);

    if (typeof(value) == "undefined" || value == null) return this.NULL_VALUE(name);
    // only set data for mode="browse" or "review"
    if(str_LessonMode == "review"){return TRUE;}
    
    if (typeof(value) != "string") value = value.toString(); // questionable?
    var result = TRUE;
    var dotIdx = name.indexOf(".", 4);
    if (dotIdx != -1) {
        var cmiName = name.substring(4, dotIdx);
        if (cmiName == "comments_from_learner") {
            result = this.setCommentsFromLearnerValue(name,name.substr(dotIdx+1),value);
        } else if (cmiName == "comments_from_lms") {
            result = this.setCommentsFromLMSValue(name,name.substr(dotIdx+1),value);
        } else if (cmiName == "interactions") {
            result = this.setInteractionsValue(name,name.substr(dotIdx+1),value);
        } else if (cmiName == "objectives") {
            result = this.setObjectivesValue(name,name.substr(dotIdx+1),value);
        } else if (cmiName == "learner_preference") {
            result = this.setLearnerPreferenceValue(name,name.substr(dotIdx+1),value);
        } else {
            result = this.setCmiValue(name,value);
        }
    } else {
        result = this.setCmiValue(name,value);
        //
    }
    if (this.errorCode == 0 && this.DEBUG) {
		var debugArgs = null;
        this.exit("SetValue", debugArgs, result);
    }
    
    log.v2004("API SetValue return:" + result);
    
    return result;
}

function activelms_getCmiValue(cmiName) {

    var dotIdx = cmiName.indexOf(".");
	
    if (dotIdx != -1){
		if(cmiName.substring(0,dotIdx) == "score"){
			return this.getScoreValue(cmiName.substr(dotIdx+1));
		}
		else{
			return this.UNDEFINED("cmi."+cmiName);
		}
	}

    if (cmiName == "launch_data") {
        var ld = this.getElement(this.cocd, "launchData");
        if (ld != null) {
            return this.getCDataText(ld);
        } else {
            return this.NOT_INITIALIZED("cmi.launch_data");
        }
    } 
	// Added by activelms
	else if (cmiName == "location") {
        var loc = this.getElement(this.cocd, "location");
        if (loc != null) {
            return this.getCDataText(loc);
        } else {
            return this.NOT_INITIALIZED("cmi.location");
        }
    } 
	// Added by activelms
	else if (cmiName == "max_time_allowed") {
        var mta = this.getElement(this.cocd, "maxTimeAllowed");
        if (mta != null) {
            var str_MaxTimeAllowed = this.getCDataText(mta);
			if(str_MaxTimeAllowed=="" || str_MaxTimeAllowed=="PT0S" || str_MaxTimeAllowed=="PT0H0M0S"){
            	return this.NOT_INITIALIZED("cmi.max_time_allowed");
			}
			return str_MaxTimeAllowed;
        } else {
            return this.NOT_INITIALIZED("cmi.max_time_allowed");
        }
    } 
	else if (cmiName == "suspend_data") {
        var sd = this.getElement(this.cocd, "suspendData");
        if (sd != null) {
        	// Added to support Articulate Quizmaker 9
            var str_SuspendData = this.getCDataText(sd);
			if(sd.getAttribute("encoding") == "base64"){
				str_SuspendData = decodeBase64(str_SuspendData);
			}
			else{
				str_SuspendData = decodeUtf8(str_SuspendData);
			}
            return str_SuspendData;
        } else {
            return this.NOT_INITIALIZED("cmi.suspend_data");
        }
    } 
	else {
        if ("_version" == cmiName) {
            return "1.0";
        } else if ("_children" == cmiName) {
            return this.joinKeys(CMI_DEF);
        } else if ("_count" == cmiName) {
            return this.NO_COUNT("cmi."+cmiName);
        } else if ("exit" == cmiName) {
            return this.WRITE_ONLY("cmi.exit");
        } else if ("session_time" == cmiName) {
            return this.WRITE_ONLY("cmi.session_time");
        } else if ("total_time" == cmiName) {
			var elm = this.getElement(this.cocd, CMI_DEF[cmiName].xmlName);
            var str_TotalTime = CMI_DEF[cmiName].fromXML(this.getElementText(elm));
            // Need to remove any trailing zeros from milliseconds
            var int_Point = str_TotalTime.indexOf(".");
            var int_S = str_TotalTime.indexOf("S");
            if(int_Point != -1 && int_S != -1){
				var str_Millis = str_TotalTime.substring(int_Point+1, int_S);
				if(str_Millis.length > 2){
					str_Millis = str_Millis.substring(0,2);
				}
				str_TotalTime = str_TotalTime.substring(0,int_Point+1).concat(str_Millis).concat("S");
            }
			return str_TotalTime;
        }
        if (!this.isLeaf(cmiName,CMI_DEF)) return EMPTY;
        var elm = this.getElement(this.cocd, CMI_DEF[cmiName].xmlName);
        if (elm != null) {
            if (CMI_DEF[cmiName].canRead) {
                return CMI_DEF[cmiName].fromXML(this.getElementText(elm));
            } else {
                return this.WRITE_ONLY("cmi."+cmiName);
            }
        } else {
            return this.NOT_INITIALIZED("cmi."+cmiName);
        }
    }
}

function activelms_getScoreValue(scoreName) {
    if (scoreName == "_version") {
        return VERSION;
    } else if (scoreName == "_children") {
        return this.joinKeys(CMI_SCORE_DEF);
    } else if (scoreName == "_count") {
        return this.NO_COUNT("cmi.score."+scoreName);
    } else {
        if (!this.isLeaf(scoreName,CMI_SCORE_DEF)) return EMPTY;
        var score = this.getElement(this.cocd, "score");
        if (score != null) {
            var elm = this.getElement(score, scoreName);
            return (elm != null) ? this.getElementText(elm) : this.NOT_INITIALIZED("cmi.score."+scoreName);
        } else {
            return this.NOT_INITIALIZED("cmi.score."+scoreName);
        }
    }
}

function activelms_getCommentsFromLMSValue(comName) {
    if (comName == "_count") {
        return this.getElementCount(this.getElement(this.cocd, "commentsFromLMS"), "commentFromLMS");
    } else if (comName == "_children") {
        return this.joinKeys(CMI_CMNTLMS_DEF);
    } else if (comName == "_version") {
        return VERSION;
    } else {
        var dotIdx = comName.indexOf(".");
        if (dotIdx == -1) return this.UNDEFINED("cmi.comments_from_lms."+comName);
        var index = parseInt(comName.substring(0, dotIdx),10);
        if (isNaN(index)) return this.INVALID_INDEX("cmi.comments_from_lms."+comName, comName.substring(0, dotIdx));
        var cmnts = this.getElement(this.cocd, "commentsFromLMS");
        var _count = this.getElementCount(cmnts, "commentFromLMS");
        if (index < 0 || index >= _count) return this.INDEX_OUT_OF_BOUNDS("cmi.comments_from_lms."+comName, String(index));
        var nextDotIdx = comName.indexOf(".", dotIdx+1);
        var childName = (nextDotIdx != -1) ? comName.substring(dotIdx+1, nextDotIdx) : comName.substr(dotIdx+1);
        if (!this.isLeaf(childName,CMI_CMNTLMS_DEF)) return EMPTY;

        var cmnt = this.getElementAtIndex(cmnts,index);
        if (childName == "comment") {
            var elm = this.getElement(cmnt, childName);
            if (elm != null) {
                var commentText = this.getElementText(elm);
                var langNode = elm.getAttributeNode("lang");
                if (langNode != null) {
                    commentText = "{lang="+langNode.nodeValue+"}"+commentText;
                }
                return commentText;
            } else {
                return this.NOT_INITIALIZED("cmi.comments_from_lms."+comName);
            }
        } else if (childName == "timestamp") {
            var elm = this.getElement(cmnt, "timeStamp");
            return (elm != null) ? this.getElementText(elm) : this.NOT_INITIALIZED("cmi.comments_from_learner."+comName);
        } else {
            var elm = this.getElement(cmnt, childName);
            return (elm != null) ? this.getElementText(elm) : this.NOT_INITIALIZED("cmi.comments_from_lms."+comName);
        }
    }
}

function activelms_getCommentsFromLearnerValue(comName) {
    if (comName == "_count") {
        return this.getElementCount(this.getElement(this.cocd, "commentsFromLearner"), "commentFromLearner");
    } else if (comName == "_children") {
        return this.joinKeys(CMI_CMNTLNR_DEF);
    } else if (comName == "_version") {
        return VERSION;
    } else {
        var dotIdx = comName.indexOf(".");
        if (dotIdx == -1) return this.UNDEFINED("cmi.comments_from_learner."+comName);
        var index = parseInt(comName.substring(0, dotIdx),10);
        if (isNaN(index)) return this.INVALID_INDEX("cmi.comments_from_learner."+comName, comName.substring(0, dotIdx));
        
        var cmnts = this.getElement(this.cocd, "commentsFromLearner");
        var _count = this.getElementCount(cmnts, "commentFromLearner");
        if (index < 0 || index >= _count) return this.INDEX_OUT_OF_BOUNDS("cmi.comments_from_learner."+comName, String(index));
        var nextDotIdx = comName.indexOf(".", dotIdx+1);
        var childName = (nextDotIdx != -1) ? comName.substring(dotIdx+1, nextDotIdx) : comName.substr(dotIdx+1);
        if (!this.isLeaf(childName,CMI_CMNTLNR_DEF)) return EMPTY;
        var cmnt = this.getElementAtIndex(cmnts,index);
        if (childName == "comment") {
            var elm = this.getElement(cmnt, childName);
            if (elm != null) {
                var commentText = this.getElementText(elm);
                var langNode = elm.getAttributeNode("lang");
                if (langNode != null) {
                    commentText = "{lang="+langNode.nodeValue+"}"+commentText;
                }
                return commentText;
            } else {
                return this.NOT_INITIALIZED("cmi.comments_from_learner."+comName);
            }
        } else {
            var elm = this.getElement(cmnt, CMI_CMNTLNR_DEF[childName].xmlName);
            return (elm != null) ? this.getElementText(elm) : this.NOT_INITIALIZED("cmi.comments_from_learner."+comName);
        }
    }
}

function activelms_getObjectiveValue(objName) {
    if (objName == "_count") {
        return this.getElementCount(this.getElement(this.cocd, "objectives"), "objective");
    } else if (objName == "_children") {
        return this.joinKeys(CMI_OBJ_DEF);
    } else if (objName == "_version") {
        return VERSION;
    } else {
        var dotIdx = objName.indexOf(".");
        if (dotIdx == -1) return this.UNDEFINED("cmi.objectives."+objName);
        var index = parseInt(objName.substring(0, dotIdx),10);
        if (isNaN(index)) return this.INVALID_INDEX("cmi.objectives."+objName, objName.substring(0, dotIdx));
        var objs = this.getElement(this.cocd, "objectives");
        var _count = this.getElementCount(objs, "objective");
        if (index < 0 || index >= _count) return this.INDEX_OUT_OF_BOUNDS("cmi.objectives."+objName, String(index));
        var nextDotIdx = objName.indexOf(".", dotIdx+1);
        var childName = (nextDotIdx != -1) ? objName.substring(dotIdx+1, nextDotIdx) : objName.substr(dotIdx+1);
        if (childName == "score") {
            var obj = this.getElementAtIndex(objs,index);
            return this.getObjectiveScoreValue(obj, index, objName.substring(nextDotIdx+1));
        } else {
            if (!this.isLeaf(childName,CMI_OBJ_DEF)) return EMPTY;
            var obj = this.getElementAtIndex(objs,index);
            if (childName == "description") {
                var desc = this.getElement(obj, "description");
                if (desc != null) {
                    var descrText = this.getElementText(desc);
                    var langNode = desc.getAttributeNode("lang");
                    if (langNode != null) {
                        descrText = "{lang="+langNode.nodeValue+"}"+descrText;
                    }
                    return descrText;
                } else {
                    return this.NOT_INITIALIZED("cmi.objectives."+objName);
                }
            } else {
                var elm = this.getElement(obj, CMI_OBJ_DEF[childName].xmlName);
                return (elm != null) ? CMI_OBJ_DEF[childName].fromXML(this.getElementText(elm)) : this.NOT_INITIALIZED("cmi.objectives."+objName);
            }
        }
    }
}

function activelms_getObjectiveScoreValue(obj,idx,scoreName) {
    if (scoreName == "_version") {
        return VERSION;
    } else if (scoreName == "_children") {
        return this.joinKeys(CMI_SCORE_DEF);
    } else if (scoreName == "_count") {
        return this.NO_COUNT("cmi.objectives."+idx+".score."+scoreName);
    } else {
        if (!this.isLeaf(scoreName,CMI_SCORE_DEF)) return EMPTY;
        var score = this.getElement(obj, "score");
        if (score != null) {
            var elm = this.getElement(score, scoreName);
            return (elm != null) ? this.getElementText(elm) : this.NOT_INITIALIZED("cmi.objectives."+idx+".score."+scoreName);
        } else {
            return this.NOT_INITIALIZED("cmi.objectives."+idx+".score."+scoreName);
        }
    }
}

function activelms_getLearnerPreferenceValue(lpName) {
    if (lpName == "_version") {
        return VERSION;
    } else if (lpName == "_children") {
        return this.joinKeys(CMI_LEARNER_PREFERENCE_DEF);
    } else if (lpName == "_count") {
        return this.NO_COUNT("cmi.learner_preference");
    } else {
        if (!this.isLeaf(lpName,CMI_LEARNER_PREFERENCE_DEF)) return EMPTY;
        var lpElm = this.getElement(this.cocd, "learnerPreferenceData");
        if (lpElm != null) {
            if (lpName == "audio_level") {
                var elm = this.getElement(lpElm, "audioLevel");
                return (elm != null) ? this.getElementText(elm) : "1";
            } else if (lpName == "language") {
                var elm = this.getElement(lpElm, "language");
                return (elm != null) ? this.getElementText(elm) : "";
            } else if (lpName == "delivery_speed") {
                var elm = this.getElement(lpElm, "deliverySpeed");
                return (elm != null) ? this.getElementText(elm) : "1";
            } else if (lpName == "audio_captioning") {
                var elm = this.getElement(lpElm, "audioCaptioning");
                return (elm != null) ? CMI_LEARNER_PREFERENCE_DEF[lpName].fromXML(this.getElementText(elm)) : "0";
            }
        } else {
            if (lpName == "audio_level") {
                return "1";
            } else if (lpName == "language") {
                return "";
            } else if (lpName == "delivery_speed") {
                return "1";
            } else if (lpName == "audio_captioning") {
                return "0";
            }
        }
    }
}

function activelms_getInteractionValue(ixName) {
    if (ixName == "_count") {
        return this.getElementCount(this.getElement(this.cocd, "interactions"), "interaction");
    } else if (ixName == "_children") {
        return this.joinKeys(CMI_IX_DEF);
    } else if (ixName == "_version") {
        return VERSION;
    } else {
        var dotIdx = ixName.indexOf(".");
        if (dotIdx == -1) return this.UNDEFINED("cmi.interactions."+ixName);
        var index = parseInt(ixName.substring(0, dotIdx),10);
        if (isNaN(index)) return this.INVALID_INDEX("cmi.interactions."+ixName,ixName.substring(0, dotIdx));
        var ixs = this.getElement(this.cocd, "interactions");
        var _count = this.getElementCount(ixs, "interaction")
        if (index < 0 || index >= _count) return this.INDEX_OUT_OF_BOUNDS("cmi.interactions."+ixName, String(index));
        var nextDotIdx = ixName.indexOf(".", dotIdx+1);
        var childName = (nextDotIdx != -1) ? ixName.substring(dotIdx+1, nextDotIdx) : ixName.substr(dotIdx+1);
        if (childName == "correct_responses") {
            return this.getIxCorrectResponseValue(this.getElementAtIndex(ixs,index), index, ixName.substring(nextDotIdx+1));
        } else if (childName == "objectives") {
            return this.getIxObjRefValue(this.getElementAtIndex(ixs,index), index, ixName.substring(nextDotIdx+1));
        } else {
            if (!this.isLeaf(childName,CMI_IX_DEF)) return EMPTY;
            var ix = this.getElementAtIndex(ixs,index);
            if (childName == "description") {
                var desc = this.getElement(ix, "description");
                if (desc != null) {
                    var descrText = this.getElementText(desc);
                    var langNode = desc.getAttributeNode("lang");
                    if (langNode != null) {
                        descrText = "{lang="+langNode.nodeValue+"}"+descrText;
                    }
                    return descrText;
                } else {
                    return this.NOT_INITIALIZED("cmi.interactions."+ixName);
                }
            } else if (childName == "learner_response") {
                var learnerResp = this.getElement(ix, "learnerResponse");
                if (learnerResp != null) {
                    var ixType = cmiIxTypeFromXML(this.getElementText(ix, "type"));
                    if (ixType == "true-false") {
                        return this.getElementText(learnerResp, "trueOrFalse");
                    } else if (ixType == "choice") {
                        var choices = "";
                        var choicesElm = this.getElement(learnerResp, "choices");
                        if (choicesElm != null) {
                            for (var i=0; i < choicesElm.childNodes.length; i++) {
                                if (i > 0) choices += SET_DELIM;
                                var choiceText = this.getElementText(choicesElm.childNodes[i]);
                                if (choiceText != null) choices += choiceText;
                            }
                        }
                        return choices;
                    } else if (ixType == "fill-in") {
                        var fillIn = "";
                        for (var i=0; i < learnerResp.childNodes.length; i++) {
                            if (i > 0) fillIn += SET_DELIM;
                            var lang = learnerResp.childNodes[i].getAttribute("lang");
                            if (lang != null && lang != "") fillIn += "{lang="+lang+"}";
                            var fillInText = this.getElementText(learnerResp.childNodes[i]);
                            if (fillInText != null) fillIn += fillInText;
                        }
                        return fillIn;
                    } else if (ixType == "long-fill-in") {
                        var longFillString = this.getElement(learnerResp, "longFillString");
                        if (longFillString != null) {
                            var longFillIn = "";
                            var lang = longFillString.getAttribute("lang");
                            if (lang != null && lang != "") longFillIn += "{lang="+lang+"}";
                            var theString = this.getElementText(longFillString);
                            if (theString != null) longFillIn += theString;
                            return longFillIn;
                        } else {
                            return EMPTY; // ?
                        }
                    } else if (ixType == "likert") {
                        return this.getElementText(learnerResp, "choice");
                    } else if (ixType == "numeric") {
                        return this.getElementText(learnerResp, "number");
                    } else if (ixType == "other") {
                        return this.getElementText(learnerResp, "responseOther");
                    } else if (ixType == "sequencing") {
                        var seq = "";
                        var steps = this.getElement(learnerResp, "steps");
                        if (steps != null) {
                            for (var z=0; z < steps.childNodes.length; z++) {
                                if (z > 0) seq += SET_DELIM;
                                seq += this.getElementText(steps.childNodes[z]);
                            }
                        }
                        return seq;
                    } else if (ixType == "matching") {
                        var matching = "";
                        var matchPattern = this.getElement(learnerResp, "matchPattern");
                        if (matchPattern != null) {
                            for (var z=0; z < matchPattern.childNodes.length; z++) {
                                if (z > 0) matching += SET_DELIM;
                                var source = this.getElementText(matchPattern.childNodes[z], "source");
                                var target = this.getElementText(matchPattern.childNodes[z], "target");
                                matching += (source+"[.]"+target);
                            }
                        }
                        return matching;
                    } else if (ixType == "performance") {
                        var performance = "";
                        for (var z=0; z < learnerResp.childNodes.length; z++) {
                            if (z > 0) performance += SET_DELIM;
                            var stepName = this.getElementText(learnerResp.childNodes[z], "stepName");
                            performance += (stepName+"[.]");
                            var stepAnsElm = this.getElement(learnerResp.childNodes[z], "stepAnswer");
                            if (stepAnsElm != null) {
                                var stepAnswer = this.getElementText(stepAnsElm, "numeric");
                                if (stepAnswer == null) {
                                    stepAnswer = this.getElementText(stepAnsElm, "literal");
                                }
                                if (stepAnswer != null) performance += stepAnswer;
                            }
                        }
                        return performance;
                    } else {
                        return this.getCDataText(learnerResp);
                    }
                } else {
                    return this.NOT_INITIALIZED("cmi.interactions."+ixName);
                }
            } else {
                var elm = this.getElement(ix, CMI_IX_DEF[childName].xmlName);
                return (elm != null) ? CMI_IX_DEF[childName].fromXML(this.getElementText(elm)) : this.NOT_INITIALIZED("cmi.interactions."+ixName);
            }
        }
    }
}

function activelms_getIxCorrectResponseValue(ix,idx,childName) {
    var dotIdx = childName.indexOf(".");
    if (dotIdx != -1) {
        var index = parseInt(childName.substring(0, dotIdx),10);
        if (isNaN(index)) return this.INVALID_INDEX("cmi.interactions."+idx+".correct_responses."+childName,childName.substring(0, dotIdx));
        var crs = this.getElement(ix, "correctResponses");
        var _count = (crs != null) ? crs.childNodes.length : 0;
        if (index < 0 || index >= _count) return this.INDEX_OUT_OF_BOUNDS("cmi.interactions."+idx+".correct_responses."+childName, String(index));
        var crName = childName.substr(dotIdx+1);
        if (crName == "pattern") {
            var ixType = cmiIxTypeFromXML(this.getElementText(ix, "type"));
            if (ixType == "true-false") {
                return this.getElementText(this.getElementAtIndex(crs,index));
            } else if (ixType == "choice") {
                var choices = "";
                var pattern = this.getElementAtIndex(crs,index);
                for (var i=0; i < pattern.childNodes.length; i++) {
                    if (i > 0) choices += SET_DELIM;
                    var choiceText = this.getElementText(pattern.childNodes[i]);
                    if (choiceText != null) choices += choiceText;
                }
                return choices;
            } else if (ixType == "fill-in") {
                var pattern = this.getElementAtIndex(crs,index);
                var fillIn = "";
                var orderMatters = pattern.getAttribute("orderMatters");
                if (orderMatters != null && orderMatters != "")
                    fillIn += ("{order_matters="+orderMatters+"}");
                var caseMatters = pattern.getAttribute("caseMatters");
                if (caseMatters != null && caseMatters != "")
                    fillIn += ("{case_matters="+caseMatters+"}");
                for (var i=0; i < pattern.childNodes.length; i++) {
                    if (i > 0) fillIn += SET_DELIM;
                    var lang = pattern.childNodes[i].getAttribute("lang");
                    if (lang != null && lang != "") fillIn += "{lang="+lang+"}";
                    var fillInText = this.getElementText(pattern.childNodes[i]);
                    if (fillInText != null) fillIn += fillInText;
                }
                return fillIn;
            } else if (ixType == "numeric") {
                if (index == 0) {
                    var min = this.getElementText(crs, "min");
                    if (min == null) min = "";
                    var max = this.getElementText(crs, "max");
                    if (max == null) max = "";
                    return min+"[:]"+max;
                } else {
                    return this.INVALID_INDEX("cmi.interactions."+idx+".correct_responses."+childName,childName.substring(0, dotIdx));
                }
            } else if (ixType == "likert") {
                return this.getElementText(crs, "choice");
            } else if (ixType == "long-fill-in") {
                var pattern = this.getElementAtIndex(crs,index);
                var fillIn = "";
                var caseMatters = pattern.getAttribute("caseMatters");
                if (caseMatters != null && caseMatters != "") fillIn += ("{case_matters="+caseMatters+"}");
                var lang = pattern.getAttribute("lang");
                if (lang != null && lang != "") fillIn += "{lang="+lang+"}";
                var fillInText = this.getElementText(pattern);
                if (fillInText != null) fillIn += fillInText;
                return fillIn;
            } else if (ixType == "sequencing") {
                var seq = "";
                var steps = this.getElementAtIndex(crs,index);
                if (steps != null) {
                    for (var z=0; z < steps.childNodes.length; z++) {
                        if (z > 0) seq += SET_DELIM;
                        seq += this.getElementText(steps.childNodes[z]);
                    }
                }
                return seq;
            } else if (ixType == "matching") {
                var matching = "";
                var matchPattern = this.getElementAtIndex(crs,index);
                if (matchPattern != null) {
                    for (var z=0; z < matchPattern.childNodes.length; z++) {
                        if (z > 0) matching += SET_DELIM;
                        var source = this.getElementText(matchPattern.childNodes[z], "source");
                        var target = this.getElementText(matchPattern.childNodes[z], "target");
                        matching += (source+"[.]"+target);
                    }
                }
                return matching;
            } else if (ixType == "performance") {
                var performance = "";
                var perfPattern = this.getElementAtIndex(crs,index);
                if (perfPattern != null) {
                    for (var z=0; z < perfPattern.childNodes.length; z++) {
                        if (z > 0) performance += SET_DELIM;
                        var stepName = this.getElementText(perfPattern.childNodes[z], "stepName");
                        performance += (stepName+"[.]");
                        var stepAnsElm = this.getElement(perfPattern.childNodes[z], "stepAnswer");
                        if (stepAnsElm != null) {
                            var stepAnswer = null;
                            var numericElm = this.getElement(stepAnsElm, "numeric");
                            if (numericElm != null) {
                                var min = numericElm.getAttribute("min");
                                var max = numericElm.getAttribute("max");
                                if (min == null) min = "";
                                if (max == null) max = "";
                                stepAnswer = min+"[:]"+max;
                            } else {
                                stepAnswer = this.getElementText(stepAnsElm, "literal");
                            }
                            if (stepAnswer != null) performance += stepAnswer;
                        }
                    }
                    var orderMatters = perfPattern.getAttribute("orderMatters");
                    if (orderMatters != null && orderMatters != "") {
                        performance = "{order_matters="+orderMatters+"}"+performance;
                    }
                }
                return performance;
            } else {
                return this.getCDataText(this.getElementAtIndex(crs,index));
            }
        } else {
            return this.UNDEFINED("cmi.interactions."+idx+".correct_responses."+childName);
        }
    } else {
        if (childName == "_version") {
            return VERSION;
        } else if (childName == "_children") {
            return "pattern";
        } else if (childName == "_count") {
            var crs = this.getElement(ix, "correctResponses");
            return (crs != null) ? String(crs.childNodes.length) : "0";
        } else {
            return this.UNDEFINED("cmi.interactions."+idx+".correct_responses."+childName);
        }
    }
}

function activelms_getIxObjRefValue(ix,idx,childName) {
    var dotIdx = childName.indexOf(".");
    if (dotIdx != -1) {
        var index = parseInt(childName.substring(0, dotIdx),10);
        if (isNaN(index)) return this.INVALID_INDEX("cmi.interactions."+idx+".objectives."+childName,childName.substring(0, dotIdx));
        var objRefs = this.getElement(ix, "objectiveIds");
        var _count = (objRefs != null) ? objRefs.childNodes.length : 0;
        if (index < 0 || index >= _count) return this.INDEX_OUT_OF_BOUNDS("cmi.interactions."+idx+".objectives."+childName, String(index));
        if (childName.substr(dotIdx+1) == "id") {
            var objref = this.getElementAtIndex(objRefs,index);
            return (objref != null) ? this.getElementText(objref) : this.NOT_INITIALIZED("cmi.interactions."+idx+".objectives."+childName);
        } else {
            return this.UNDEFINED("cmi.interactions."+idx+".objectives."+childName);
        }
    } else {
        if (childName == "_version") {
            return VERSION;
        } else if (childName == "_children") {
            return "id";
        } else if (childName == "_count") {
            var objRefs = this.getElement(ix, "objectiveIds");
            return (objRefs != null) ? String(objRefs.childNodes.length) : "0";
        } else {
            return this.UNDEFINED("cmi.interactions."+idx+".objectives."+childName);
        }
    }
}

function activelms_setCmiValue(name,val) {
    var nm = name.substr(4); // name is fully qualified name ...
    var dotIdx = nm.indexOf(".");
    if (dotIdx != -1) {
        return (nm.substring(0,dotIdx) == "score") ?
            this.setScoreValue(name,nm.substr(dotIdx+1),val) : this.UNDEFINED(name,val);
    } else {
        if (nm == "progress_measure") {
            if (val.length == 0) return this.TYPE_MISMATCH(name,val);
            if (countDots(val) > 1) return this.TYPE_MISMATCH(name,val);
            var i = (val.charAt(0) == '-') ? 1 : 0;
            for (; i<val.length; i++) {
                var chCode = val.charCodeAt(i);
                if ((chCode < 48 || chCode > 57) && (chCode != 46))
                    return this.TYPE_MISMATCH(name,val);
            }
            var flVal = parseFloat(val);
            if (isNaN(flVal)) return this.TYPE_MISMATCH(name,val);
            if (flVal < 0 || flVal > 1) return this.OUT_OF_RANGE(name,val);
            return this.setElementText(this.cocd, "progressMeasure", val);
        } else {
            return (this.isValid(name,val,CMI_DEF[nm]))?this.setElementText(this.cocd,CMI_DEF[nm].xmlName,CMI_DEF[nm].toXML(val)):FALSE;
        }
    }
}

function activelms_setScoreValue(name,nm,val) {
    if (nm == "scaled") {
        if (val.length == 0) return this.TYPE_MISMATCH(name,val);
        if (countDots(val) > 1) return this.TYPE_MISMATCH(name,val);
        var i = (val.charAt(0) == '-') ? 1 : 0;
        for (; i<val.length; i++) {
            var chCode = val.charCodeAt(i);
            if ((chCode < 48 || chCode > 57) && (chCode != 46))
                return this.TYPE_MISMATCH(name,val);
        }
        var flVal = parseFloat(val);
        if (isNaN(flVal)) return this.TYPE_MISMATCH(name,val);
        if (flVal < -1 || flVal > 1) return this.OUT_OF_RANGE(name,val);
        var score = this.getElement(this.cocd, "score");
        if (score == null) {
            score = this.newElement("score");
            this.cocd.appendChild(score);
        }
        return this.setElementText(score, nm, val);
    } else if (this.isValid(name,val,CMI_SCORE_DEF[nm])) {
        var score = this.getElement(this.cocd, "score");
        if (score == null) {
            score = this.newElement("score");
            this.cocd.appendChild(score);
        }
        return this.setElementText(score, nm, val);
    } else {
        return FALSE;
    }
}

function activelms_setLearnerPreferenceValue(name,nm,val) {
    if (nm == "audio_level" || nm == "delivery_speed") {
        if (val.length == 0) return this.TYPE_MISMATCH(name,val);
        if (val.charAt(0) == '-') return this.OUT_OF_RANGE(name,val);
        if (!isCMIDecimal(val)) return this.TYPE_MISMATCH(name,val);
        var flVal = parseFloat(val);
        if (isNaN(flVal)) return this.TYPE_MISMATCH(name,val);
        if (flVal < 0) return this.OUT_OF_RANGE(name,val);
    } else if (nm == "audio_captioning") {
        if (isNaN(parseInt(val))) return this.TYPE_MISMATCH(name,val);
        if (val != "-1" && val != "0" && val != "1")
            return this.NOT_VOCAB(name,val,"-1|0|1");
    } else if (nm == "language") {
        if (!isCMILanguage(val)) return this.TYPE_MISMATCH(name,val);
    } else {
        return this.UNDEFINED(name,val);
    }
    var pref = this.getElement(this.cocd, "learnerPreferenceData");
    if (pref == null) {
        pref = this.newElement("learnerPreferenceData");
        this.cocd.appendChild(pref);
    }
    return this.setElementText(pref,CMI_LEARNER_PREFERENCE_DEF[nm].xmlName,CMI_LEARNER_PREFERENCE_DEF[nm].toXML(val));
}

function activelms_setObjectivesValue(name,nm,val) {

    var dotIdx = nm.indexOf(".");
    if (dotIdx == -1) return this.UNDEFINED(name,val);
    var objIndex = nm.substring(0,dotIdx);
    
	var float_ScormVersion = this.getScormVersion(this.rteSchemaVersion);
	
    if (!isCMIDigits(objIndex)) return this.SET_INVALID_INDEX(name,objIndex);
    var objIdx = parseInt(objIndex,10);
    if (isNaN(objIdx) || objIdx < 0) return this.SET_INVALID_INDEX(name,objIndex);
	
    var objs = this.getElement(this.cocd, "objectives");
    if (objs == null) {
        objs = this.newElement("objectives");
        this.cocd.appendChild(objs);
    }
    var objCount = objs.childNodes.length;

    if (objIdx > objCount) return this.SET_INDEX_OUT_OF_BOUNDS(name,objIndex);
    nm = nm.substr(dotIdx+1);
    dotIdx = nm.indexOf(".");
    if (dotIdx != -1) {
        var objElm = this.getElementAtIndex(objs,objIdx);
        if (objElm == null || this.getElementText(objElm, "identifier")==null){
        	if(float_ScormVersion > 1.2){
				// SCORM 2004 must set ID first
            	return this.DEPENDENCY_NOT_EST(name,"id"); 
        	}
			else{
				// For SCORM 1.2, can set other elements before ID element
        		objElm = this.newElement("objective");
        		objs.appendChild(objElm);
        		this.setElementText(objElm, "successStatus", "unknown");
        		this.setElementText(objElm, "completionStatus", "unknown");
			}
		}
        if (nm.substring(0,dotIdx) != "score") return this.UNDEFINED(name,val);
        nm = nm.substr(dotIdx+1);
        if (nm == "scaled") {
            if (val.length == 0) return this.TYPE_MISMATCH(name,val);
            if (countDots(val) > 1) return this.TYPE_MISMATCH(name,val);
            var i = (val.charAt(0) == '-') ? 1 : 0;
            for (; i<val.length; i++) {
                var chCode = val.charCodeAt(i);
                if ((chCode < 48 || chCode > 57) && (chCode != 46)) return this.TYPE_MISMATCH(name,val);
            }
            var flVal = parseFloat(val);
            if (isNaN(flVal)) return this.TYPE_MISMATCH(name,val);
            if (flVal < -1.0 || flVal > 1.0) return this.OUT_OF_RANGE(name,val);
        } else {
            if (!this.isValid(name,val,CMI_SCORE_DEF[nm])) return FALSE;
        }

        var score = this.getElement(objElm, "score");
        if (score == null) {
            score = this.newElement("score");
            objElm.appendChild(score);
        }

        return this.setElementText(score, nm, val);
    }
	
    // Check validity
    if (nm == "id" && (val.length == 0 || !isCMIId(val)))
        return this.TYPE_MISMATCH(name,val); // id cannot be empty
    if (nm == "progress_measure") {
        if (val.length == 0) return this.TYPE_MISMATCH(name,val);
        if (countDots(val) > 1) return this.TYPE_MISMATCH(name,val);
        var i = (val.charAt(0) == '-') ? 1 : 0;
        for (; i<val.length; i++) {
            var chCode = val.charCodeAt(i);
            if ((chCode < 48 || chCode > 57) && (chCode != 46))
                return this.TYPE_MISMATCH(name,val);
        }
        var flVal = parseFloat(val);
        if (isNaN(flVal)) return this.TYPE_MISMATCH(name,val);
        if (flVal < 0 || flVal > 1) return this.OUT_OF_RANGE(name,val);
    } else {
        if (!this.isValid(name,val,CMI_OBJ_DEF[nm]))
            return FALSE;
    }
	
	 // Extra check added by activelms to stop setting of duplicate ID elements
	 // objs=objectives element, val=candidate ID, objIdx=candidate index 
	 if (nm == "id"){
	 	var int_ExistingIndex = this.isDuplicateId(objs, val, objIdx, "identifier", false, this.rteSchemaVersion);
	 	if(int_ExistingIndex != -1){
	 		return this.UNIQUE_ID_CONSTRAINT_VIOLATED(name, val, int_ExistingIndex);
		}
	 }

    // Don't create the element until all validation passes in SCORM 2004
    if (objIdx == objCount) {
        if (nm != "id") {
        	if(float_ScormVersion > 1.2){
				return this.DEPENDENCY_NOT_EST(name,"id"); // must set ID first
        	}
		}
        var obj = this.newElement("objective");
        objs.appendChild(obj);
        this.setElementText(obj, "identifier", val);
        this.setElementText(obj, "successStatus", "unknown");
        this.setElementText(obj, "completionStatus", "unknown");
        return TRUE;
    }
    var objElm = this.getElementAtIndex(objs, objIdx);
    if (this.getElementText(objElm, "identifier")==null){
        return this.DEPENDENCY_NOT_EST(name, "identifier");
	}
    if (nm == "description") {
        this.setElementLangString(this.getElementForSet(objElm,nm), val);
    } else {
        this.setElementText(objElm, CMI_OBJ_DEF[nm].xmlName, CMI_OBJ_DEF[nm].toXML(val));
    }
    return TRUE;
}

function activelms_findObjectiveById(obj_Objectives, str_TargetObjectiveID){

    if(obj_Objectives && obj_Objectives.childNodes && obj_Objectives.childNodes.length){

	    var int_Count = obj_Objectives.childNodes.length;
	    var obj_Element = null;
	    var str_ObjectiveID = null;
	
	    for(var i=0; i<int_Count; i++){
		    obj_Element = this.getElementAtIndex(obj_Objectives, i);
		    str_ObjectiveID = this.getElementText(obj_Element, "identifier");
		    if(str_ObjectiveID == str_TargetObjectiveID){
		        return obj_Element;
		    }
		}
	}
}

/**
 * objs=objectives element 
 * str_NewID=candidate ID 
 * int_Index=candidate index 
 */
function activelms_isDuplicateId(
	objs, 
	str_NewID, 
	int_Index, 
	str_ElementName, 
	b_Interaction, 
	str_RteSchemaVersion){
	
	var int_ExistingIndex = -1;
	var obj_Element = null;
	var str_ObjectiveID = null;
	var int_Count = objs.childNodes.length;
	var float_ScormVersion = this.getScormVersion(str_RteSchemaVersion);
	
	if(int_Count==0){return int_ExistingIndex;}

	for(var i=0; i<int_Count; i++){
		obj_Element = this.getElementAtIndex(objs, i);
		
		if(b_Interaction){
			if(obj_Element.nodeName != str_ElementName){
				i++;
				continue;
			}
			str_ObjectiveID = obj_Element.firstChild.nodeValue
		}
		else{
			str_ObjectiveID = this.getElementText(obj_Element, str_ElementName);
		}

		
		if(b_Interaction){
			// At same index position, can set the same ID, AND can change ID for interaction.n.objective.id
			if(i == int_Index){
				break;
			}
		}
		else if(float_ScormVersion >= 2004.3){
			// 2004 3ED At same index position, can set the same ID
			// SCORM 2004 3rd Edition: BUT cannot change ID for objective.id
			if(i == int_Index){
				if(str_ObjectiveID == str_NewID){
					break;
				}
				else{
					int_ExistingIndex = i;
					break;
				}
			}
		}
		else{
			// At same index position, can set the same ID
			// SCORM 2004 2nd Edition: AND can change ID for objective.id
			if(i == int_Index){
				break;
			}
		}
		
		// At different index position, cannot set the same ID
		if(str_ObjectiveID == str_NewID){
			int_ExistingIndex = i;
			break;
		}
	}
	return int_ExistingIndex;
}

/*
* The conformance test seems to indicate that a SCO is allowed to set
* duplicate interaction IDs. Only a recommendation.
*
* It is recommended that a SCO not alter (set) existing interaction ids 
* during a learner attempt. If the SCO alters an cmi.interactions.n.id 
* during a learner attempt, this could corrupt interaction data that 
* has been collected in previous learner sessions and provide inconsistent 
* information about the interaction.
*/
function activelms_isDuplicateInteractionsId(interactions, str_NewID, int_Index){

	/*
	var int_ExistingIndex = -1;

	var obj_Element = null;
	var str_InteractionID = null;
	var int_Count = interactions.childNodes.length;
	if(int_Count==0)return int_ExistingIndex;

	var i = int_Count-1;
	do {
		obj_Element = this.getElementAtIndex(interactions, i);
		str_InteractionID = this.getElementText(obj_Element, "identifier");
		if(i == int_Index){
			--i;
			continue;//can reset/overwrite at index
		}
		if(str_InteractionID == str_NewID){
			int_ExistingIndex = i;
			break;
		}
		--i;
	}
	while (i>=0);

	return int_ExistingIndex;
	*/
	return -1;
}

function activelms_setCommentsFromLearnerValue(name,nm,val) {

    var dotIdx = nm.indexOf(".");
    if (dotIdx == -1) return this.UNDEFINED(name,val);
    var cmtIndex = nm.substring(0,dotIdx);
    if (!isCMIDigits(cmtIndex)) return this.SET_INVALID_INDEX(name,cmtIndex);
    var cmtIdx = parseInt(cmtIndex,10);
    if (isNaN(cmtIdx) || cmtIdx < 0) return this.SET_INVALID_INDEX(name,cmtIndex);
    var cmts = this.getElement(this.cocd, "commentsFromLearner");
    if (cmts == null) {
        cmts = this.newElement("commentsFromLearner");
        this.cocd.appendChild(cmts);
    }
    var cmtCount = cmts.childNodes.length;
    if (cmtIdx > cmtCount) return this.SET_INDEX_OUT_OF_BOUNDS(name,cmtIndex);
    nm = nm.substr(dotIdx+1);
    dotIdx = nm.indexOf(".");
    if (dotIdx != -1) return this.UNDEFINED(name,val);
    if (!this.isValid(name,val,CMI_CMNTLNR_DEF[nm])) return FALSE;
    if (cmtIdx == cmtCount) {
        var cmt = this.newElement("commentFromLearner");
        cmts.appendChild(cmt);
    }
    if (nm == "comment") {
        return this.setElementLangString(this.getElementForSet(this.getElementAtIndex(cmts, cmtIdx), "comment"), val);
    } else {
        return this.setElementText(this.getElementAtIndex(cmts, cmtIdx), CMI_CMNTLNR_DEF[nm].xmlName, val);
    }
}

function activelms_setCommentsFromLMSValue(name,nm,val) {
    return this.READ_ONLY(name);
    /*
    var dotIdx = nm.indexOf(".");
    if (dotIdx == -1) return this.UNDEFINED(name,val);
    var cmtIndex = nm.substring(0,dotIdx);
    if (!isCMIDigits(cmtIndex)) return this.SET_INVALID_INDEX(name,cmtIndex);
    var cmtIdx = parseInt(cmtIndex,10);
    if (isNaN(cmtIdx) || cmtIdx < 0) return this.SET_INVALID_INDEX(name,cmtIndex);
    var cmts = this.getElement(this.cocd, "comments_from_lms");
    var cmtCount = (cmts != null) ? parseInt(this.getAttribute(cmts,"_count","0"),10) : 0;
    if (cmtIdx > cmtCount) return this.SET_INDEX_OUT_OF_BOUNDS(name,cmtIndex);
    if (!this.isValid(name,val,CMI_CMNTLMS_DEF[nm])) return FALSE;
    */
}

function activelms_addStep(crElm, step) {
    var stepElm = this.newElement("step");
    crElm.appendChild(stepElm);
    var split = step.indexOf("[.]");
    this.setElementText(stepElm, "stepName", step.substring(0, split));
    var stepAnswer = step.substring(split+3);
    if (stepAnswer.length > 0) {
        var stepAnsElm = this.newElement("stepAnswer");
        stepElm.appendChild(stepAnsElm);
        var findColon = stepAnswer.indexOf("[:]");
        if (findColon != -1) {
            var min = null;
            var max = null;
            if (findColon == 0) {
                max = stepAnswer.substring(findColon+3);
            } else {
                min = stepAnswer.substring(0, findColon);
                if ((findColon+3) < stepAnswer.length) {
                    max = stepAnswer.substring(findColon+3);
                }
            }
            var numElm = this.newElement("numeric");
            stepAnsElm.appendChild(numElm);
            this.setAttribute(numElm, "min", min);
            this.setAttribute(numElm, "max", max);
        } else {
            this.setElementText(stepAnsElm, "literal", stepAnswer);
        }
    }
}

function activelms_addRespStep(lrElm, step) {
    var stepElm = this.newElement("step");
    lrElm.appendChild(stepElm);
    var split = step.indexOf("[.]");
    this.setElementText(stepElm, "stepName", step.substring(0, split));
    var stepAnswer = step.substring(split+3);
    if (stepAnswer.length > 0) {
        var stepAnsElm = this.newElement("stepAnswer");
        stepElm.appendChild(stepAnsElm);
        // trouble: we really should try to match the stepName in the
        // pattern to determine it is a numeric or literal
        /*
        if (isNaN(parseFloat(stepAnswer))) {
            this.setElementText(stepAnsElm, "literal", stepAnswer);
        } else {
            this.setElementText(stepAnsElm, "numeric", stepAnswer);
        }
        */
        // NOTE: parseFloat will parse the first number, and accept trailing string characters
        var obj_Number = Number(stepAnswer);
        if (isNaN(obj_Number)) {
            this.setElementText(stepAnsElm, "literal", stepAnswer);
        } else {
            this.setElementText(stepAnsElm, "numeric", stepAnswer);
        }
    }
}

function activelms_setInteractionsValue(name,nm,val) {

    //log.debug("SetInteractionsValue: " + name + nm + "=" + val);

    var dotIdx = nm.indexOf(".");
    if (dotIdx == -1) return this.UNDEFINED(name,val);
    
	var float_ScormVersion = this.getScormVersion(this.rteSchemaVersion);
    var ixIndex = nm.substring(0,dotIdx);
    nm = nm.substr(dotIdx+1);
    
    if (!isCMIDigits(ixIndex)) return this.SET_INVALID_INDEX(name,ixIndex);
    var ixIdx = parseInt(ixIndex,10);
    if (isNaN(ixIdx) || ixIdx < 0) return this.SET_INVALID_INDEX(name,ixIndex);
    var ixs = this.getElement(this.cocd, "interactions");
    if (ixs == null) {
        ixs = this.newElement("interactions");
        this.cocd.appendChild(ixs);
    }
    var ixCount = ixs.childNodes.length;
    if (ixIdx > ixCount) return this.SET_INDEX_OUT_OF_BOUNDS(name,ixIndex);
    
	// Extra check added by activelms to stop setting of duplicate ID elements
	// ixs=interactions element, val=candidate ID, ixIdx=candidate index 
	var int_IndexOfObjectives = name.indexOf("objectives");
	if(int_IndexOfObjectives == -1){
		var int_ExistingIndex = this.isDuplicateInteractionsId(ixs, val, ixIdx);
		if(int_ExistingIndex != -1){
	 		return this.UNIQUE_ID_CONSTRAINT_VIOLATED(name, val, int_ExistingIndex);
		}
	}

    if (ixIdx == ixCount) {
        if (nm != "id") {
        	if(float_ScormVersion > 1.2){
        		// SCORM 2004 MUST set the identifier first
        		return this.DEPENDENCY_NOT_EST(name,"id"); // must set ID first
        	}
        }
        
        if (val.length == 0 || !isCMIId(val)) return this.TYPE_MISMATCH(name,val); // id cannot be empty

        var ix = this.newElement("interaction");
        ixs.appendChild(ix);
        // See issue # JAVA-15: for SCORM 1.2, type is not mandatory, but it is required for the CMI service
        if(float_ScormVersion < 2004){
            this.setElementText(ix, "type", "other");
        }
        // See issue # NET-279 and Support Case #00001117
        if(nm == "id"){
            return this.setElementText(ix, "identifier", val);
        }
    }
    
    var ixElm = this.getElementAtIndex(ixs,ixIdx);
    if (this.getElementText(ixElm, "identifier")==null){
    	if(float_ScormVersion > 1.2){
        	return this.DEPENDENCY_NOT_EST(name,"id"); // must set ID first
    	}
    }
    dotIdx = nm.indexOf(".");
    
    //log.debug("SetInteractionsValue: 1");
    
    if (dotIdx != -1) {
        var ixChild = nm.substring(0,dotIdx);
        if (ixChild == "correct_responses") {
            nm = nm.substr(dotIdx+1);
            dotIdx = nm.indexOf("."); // expecting an index here ...
            if (dotIdx == -1) return this.UNDEFINED(name,val);
            var crIndex = nm.substring(0,dotIdx);
            if (!isCMIDigits(crIndex)) return this.SET_INVALID_INDEX(name,crIndex);
            var crIdx = parseInt(crIndex,10);
            if (isNaN(crIdx) || crIdx < 0) return this.SET_INVALID_INDEX(name,crIndex);
            nm = nm.substr(dotIdx+1);
            if (nm != "pattern") return this.UNDEFINED(name,val);
            var crs = this.getElement(ixElm, "correctResponses");
            if (crs == null) {
                crs = this.newElement("correctResponses");
                ixElm.appendChild(crs);
            }
            var crCount = crs.childNodes.length;
            if (crIdx > crCount) return this.SET_INDEX_OUT_OF_BOUNDS(name,crIndex);
            var ixType = cmiIxTypeFromXML(this.getElementText(ixElm, "type"));
            if (ixType == null) return this.DEPENDENCY_NOT_EST(name,"type");
            if (crIdx > 0) {
                if (ixType == "true-false" || ixType == "likert" || ixType == "numeric")
                    return this.GENERAL_SET_PATTERN_FAILURE(name,val,"can be only one pattern for "+ixType);
                if (ixType == "choice" || ixType == "likert" || ixType == "sequencing" || ixType == "other") {
                    if (!this.assertIsOnlyPattern(ixElm,ixIdx,val,crIdx))
                        return this.GENERAL_SET_PATTERN_FAILURE(name,val,"duplicate pattern not allowed for "+ixType);
                }
            }
            if (!this.validatePattern(name,val,ixElm,ixType,crIdx)) return this.INVALID_PATTERN(name,val,ixType);

            //log.debug("SetInteractionsValue: 2");

            var crElm = null;
            if (crIdx == crCount) {
                if (ixType == "true-false") {
                    crElm = this.newElement("trueOrFalse");
                } else if (ixType == "choice") {
                    crElm = this.newElement("choices");
                } else if (ixType == "fill-in") {
                    crElm = this.newElement("fillMatches");
                } else if (ixType == "long-fill-in") {
                    crElm = this.newElement("matchText");
                } else if (ixType == "sequencing") {
                    crElm = this.newElement("stepSequence");
                } else if (ixType == "matching") {
                    crElm = this.newElement("matchPattern");
                } else if (ixType == "performance") {
                    crElm = this.newElement("performancePattern");
                } else if (ixType == "numeric") {
                    // numeric is goofy because there is only one group of min/max
                    return this.setNumericPattern(crs, val);
                } else if (ixType == "likert") {
                    crElm = this.newElement("choice");
                } else if (ixType == "other") {
                    crElm = this.newElement("correctOther");
                } else {
                    crElm = this.newElement("pattern");
                }
                crs.appendChild(crElm);
            } else {
                if (ixType == "numeric") {
                    // numeric is goofy because there is only one group of min/max
                    return this.setNumericPattern(crs, val);
                } else {
                    crElm = this.getElementAtIndex(crs,crIdx);
                    this.removeChildren(crElm);
                }
            }

            if (ixType == "true-false") {
                this.setElementText(crElm, null, val);
            } else if (ixType == "choice") {
            
                //log.debug("SetInteractionsValue: 3");
                var set = new Array();
                var fi = 0;
                var i = val.indexOf(SET_DELIM);
                if (i != -1) {
                    do {
                        set.push(val.substring(fi,i));
                        fi = i+3;
                        i = val.indexOf(SET_DELIM,fi);
                        if (i == -1) set.push(val.substr(fi));
                    } while (i != -1);
                } else {
                    set.push(val);
                }
                for (var z=0; z < set.length; z++) {
                    var choiceElm = this.newElement("choice");
                    this.setElementText(choiceElm, null, set[z]);
                    crElm.appendChild(choiceElm);
                }
                //log.debug("SetInteractionsValue: 4");
            } else if (ixType == "fill-in") {
                var pos = parseMatters(val);
                if (pos > 0) {
                    var m = val.indexOf("{case_matters=");
                    if (m != -1) {
                        // ok ... we found it, but it may come after the {lang=} or the first [,]
                        var isRightSpot = true;
                        var lx = val.indexOf("{lang=");
                        if (lx != -1) {
                            if (m > lx) {
                                // this {case_matters= is after a {lang= so it's not a real setting
                                isRightSpot = false;
                            } else {
                                // there was a lang, but the m came before it ... how about first [,]
                                lx = val.indexOf(SET_DELIM);
                                if (lx != -1) {
                                    if (m > lx) {
                                        // this {case_matters= is after a [,] so it's not a real setting
                                        isRightSpot = false;
                                    }
                                }
                            }
                        } else {
                            lx = val.indexOf(SET_DELIM);
                            if (lx != -1) {
                                if (m > lx) {
                                    // this {case_matters= is after a [,] so it's not a real setting
                                    isRightSpot = false;
                                }
                            }
                        }
                        if (isRightSpot) {
                            var offset = m+"{case_matters=".length;
                            this.setAttribute(crElm, "caseMatters", val.substring(offset, val.indexOf("}",offset)));
                        } else {
                            crElm.removeAttribute("caseMatters");
                        }
                    } else {
                        crElm.removeAttribute("caseMatters");
                    }
                    m = val.indexOf("{order_matters=");
                    if (m != -1) {
                        var isRightSpot = true;
                        var lx = val.indexOf("{lang=");
                        if (lx != -1) {
                            if (m > lx) {
                                // this {order_matters= is after a {lang= so it's not a real setting
                                isRightSpot = false;
                            } else {
                                lx = val.indexOf(SET_DELIM);
                                if (lx != -1) {
                                    if (m > lx) {
                                        // this {order_matters= is after a [,] so it's not a real setting
                                        isRightSpot = false;
                                    }
                                }
                            }
                        } else {
                            lx = val.indexOf(SET_DELIM);
                            if (lx != -1) {
                                if (m > lx) {
                                    // this {order_matters= is after a [,] so it's not a real setting
                                    isRightSpot = false;
                                }
                            }
                        }
                        if (isRightSpot) {
                            var offset = m+"{order_matters=".length;
                            this.setAttribute(crElm, "orderMatters", val.substring(offset, val.indexOf("}",offset)));
                        } else {
                            crElm.removeAttribute("orderMatters");
                        }
                    } else {
                        crElm.removeAttribute("orderMatters");
                    }
                    val = val.substr(pos);
                } else {
                    // no matters here ...
                    crElm.removeAttribute("caseMatters");
                    crElm.removeAttribute("orderMatters");
                }
                var set = new Array();
                var i = val.indexOf(SET_DELIM);
                var fi = 0;
                if (i != -1) {
                    do {
                        set.push(val.substring(fi,i));
                        fi = i+3;
                        i = val.indexOf(SET_DELIM,fi);
                        if (i == -1) set.push(val.substr(fi));
                    } while (i != -1);
                } else {
                    set.push(val);
                }
                for (var z=0; z < set.length; z++) {
                    var mtElm = this.newElement("matchText");
                    if (set[z].indexOf("{lang=") == 0) {
                        var j = set[z].indexOf("}",6);
                        mtElm.setAttribute("lang", set[z].substring(6,j));
                        this.setElementText(mtElm, null, set[z].substr(j+1));
                    } else {
                        mtElm.removeAttribute("lang");
                        this.setElementText(mtElm, null, set[z]);
                    }
                    crElm.appendChild(mtElm);
                }
            } else if (ixType == "long-fill-in") {
                var m = val.indexOf("{case_matters=");
                if (m == 0) {
                    var offset = "{case_matters=".length;
                    var endBrace = val.indexOf("}",offset);
                    this.setAttribute(crElm, "caseMatters", val.substring(offset, endBrace));
                    val = val.substr(endBrace+1);
                } else {
                    crElm.removeAttribute("caseMatters");
                }
                if (val.indexOf("{lang=") == 0) {
                    var j = val.indexOf("}",6);
                    this.setAttribute(crElm, "lang", val.substring(6,j));
                    this.setElementText(crElm, null, val.substr(j+1));
                } else {
                    crElm.removeAttribute("lang");
                    this.setElementText(crElm, null, val);
                }
            } else if (ixType == "sequencing") {
                var set = new Array();
                var fi = 0;
                var i = val.indexOf(SET_DELIM);
                if (i != -1) {
                    do {
                        set.push(val.substring(fi,i));
                        fi = i+3;
                        i = val.indexOf(SET_DELIM,fi);
                        if (i == -1) set.push(val.substr(fi));
                    } while (i != -1);
                } else {
                    set.push(val);
                }
                for (var z=0; z < set.length; z++) {
                    var stepElm = this.newElement("step");
                    this.setElementText(stepElm, null, set[z]);
                    crElm.appendChild(stepElm);
                }
            } else if (ixType == "matching") {
                var fi = 0;
                var i = val.indexOf(SET_DELIM);
                if (i != -1) {
                    do {
                        var pairVal = val.substring(fi,i);
                        var pair = this.newElement("pair");
                        var dot = pairVal.indexOf("[.]");
                        this.setElementText(pair, "source", pairVal.substring(0, dot));
                        this.setElementText(pair, "target", pairVal.substr(dot+3));
                        crElm.appendChild(pair);

                        fi = i+3;
                        i = val.indexOf(SET_DELIM,fi);
                        if (i == -1) {
                            pairVal = val.substr(fi);
                            pair = this.newElement("pair");
                            dot = pairVal.indexOf("[.]");
                            this.setElementText(pair, "source", pairVal.substring(0, dot));
                            this.setElementText(pair, "target", pairVal.substr(dot+3));
                            crElm.appendChild(pair);
                        }
                    } while (i != -1);
                } else {
                    var pair = this.newElement("pair");
                    var dot = val.indexOf("[.]");
                    this.setElementText(pair, "source", val.substring(0, dot));
                    this.setElementText(pair, "target", val.substr(dot+3));
                    crElm.appendChild(pair);
                }
            } else if (ixType == "performance") {
                var orderMatters = null;
                var orderMattersEnd = -1;
                var find = val.indexOf("{order_matters=");
                if (find != -1) {
                    var valuePos = (find+"{order_matters=".length);
                    var end = val.indexOf("}", valuePos);
                    orderMatters = val.substring(valuePos, end);
                    orderMattersEnd = end+1;
                } else {
                    orderMattersEnd = 0;
                }
                this.setAttribute(crElm, "orderMatters", orderMatters);
                find = val.indexOf(SET_DELIM, orderMattersEnd);
                if (find != -1) {
                    var fromIndex = orderMattersEnd;
                    do {
                        this.addStep(crElm, val.substring(fromIndex, find));
                        fromIndex = find+3;
                        find = val.indexOf(SET_DELIM, fromIndex);
                        if (find == -1) this.addStep(crElm, val.substring(fromIndex));
                    } while (find != -1);
                } else {
                    this.addStep(crElm, val.substring(orderMattersEnd));
                }
            } else {
                this.setElementText(crElm, null, val);
            }

            return TRUE;
        } else if (ixChild == "objectives") {
            nm = nm.substr(dotIdx+1);
            dotIdx = nm.indexOf("."); // expecting an index here ...
            if (dotIdx == -1) return this.UNDEFINED(name,val);
            var objIndex = nm.substring(0,dotIdx);
            if (!isCMIDigits(objIndex)) return this.SET_INVALID_INDEX(name,objIndex);
            var objIdx = parseInt(objIndex,10);
            if (isNaN(objIdx) || objIdx < 0) return this.SET_INVALID_INDEX(name,objIndex);
            nm = nm.substr(dotIdx+1);
            if (nm != "id") return this.UNDEFINED(name,val);
            if (val.length == 0 || !isCMIId(val)) return this.TYPE_MISMATCH(name,val); // id cannot be empty
            var objs = this.getElement(ixElm, "objectiveIds");
            if (objs == null) {
                objs = this.newElement("objectiveIds");
                ixElm.appendChild(objs);
            }
            var objCount = objs.childNodes.length;
            if (objIdx > objCount) return this.SET_INDEX_OUT_OF_BOUNDS(name,objIndex);
            
	 		// Extra check added by activelms to stop setting of duplicate ID elements
	 		// objs=objectives element, val=candidate ID, objIdx=candidate index 
	 		if(nm == "id"){
	 			var int_ExistingIndex = this.isDuplicateId(objs, val, objIdx, "objectiveId", true, this.rteSchemaVersion);
	 			if(int_ExistingIndex != -1){
	 				return this.UNIQUE_ID_CONSTRAINT_VIOLATED(name, val, int_ExistingIndex);
	 			}
	 		}
            
            if (objIdx == objCount) {
            	// activelms: But only set if not a duplicate ID
                var obj = this.newElement("objectiveId");
                objs.appendChild(obj);
            }
            var objElm = this.getElementAtIndex(objs,objIdx);
            return this.setElementText(objElm, null, val);
        } else {
            return this.UNDEFINED(name,val);
        }
    }
    if (!this.isValid(name,val,CMI_IX_DEF[nm])) return FALSE;
    if (nm == "description") {
        this.setElementLangString(this.getElementForSet(ixElm,nm),val);
    } else if (nm == "learner_response") {
        var ixType = cmiIxTypeFromXML(this.getElementText(ixElm, "type"));
        if (ixType == null) return this.DEPENDENCY_NOT_EST(name,"type");
        if (!this.validateResponse(name,val,ixElm,ixType)) return this.INVALID_PATTERN(name,val,ixType);
        var elm = this.getElementForSet(ixElm,"learnerResponse");
        if (ixType == "true-false") {
            this.setElementText(elm, "trueOrFalse", val);
        } else if (ixType == "choice") {
            var choicesElm = this.newElement("choices");
            elm.appendChild(choicesElm);
            var set = new Array();
            var fi = 0;
            var i = val.indexOf(SET_DELIM);
            if (i != -1) {
                do {
                    set.push(val.substring(fi,i));
                    fi = i+3;
                    i = val.indexOf(SET_DELIM,fi);
                    if (i == -1) set.push(val.substr(fi));
                } while (i != -1);
            } else {
                set.push(val);
            }
            for (var z=0; z < set.length; z++) {
                var choiceElm = this.newElement("choice");
                this.setElementText(choiceElm, null, set[z]);
                choicesElm.appendChild(choiceElm);
            }
        } else if (ixType == "fill-in") {
            var set = new Array();
            var fi = 0;
            var i = val.indexOf(SET_DELIM);
            if (i != -1) {
                do {
                    set.push(val.substring(fi,i));
                    fi = i+3;
                    i = val.indexOf(SET_DELIM,fi);
                    if (i == -1) set.push(val.substr(fi));
                } while (i != -1);
            } else {
                set.push(val);
            }
            for (var z=0; z < set.length; z++) {
                var fillStrElm = this.newElement("fillString");
                if (set[z].indexOf("{lang=") == 0) {
                    var j = set[z].indexOf("}",6);
                    fillStrElm.setAttribute("lang", set[z].substring(6,j));
                    this.setElementText(fillStrElm, null, set[z].substr(j+1));
                } else {
                    fillStrElm.removeAttribute("lang");
                    this.setElementText(fillStrElm, null, set[z]);
                }
                elm.appendChild(fillStrElm);
            }
        } else if (ixType == "long-fill-in") {
            var fillStrElm = this.newElement("longFillString");
            if (val.indexOf("{lang=") == 0) {
                var j = val.indexOf("}",6);
                fillStrElm.setAttribute("lang", val.substring(6,j));
                this.setElementText(fillStrElm, null, val.substr(j+1));
            } else {
                fillStrElm.removeAttribute("lang");
                this.setElementText(fillStrElm, null, val);
            }
            elm.appendChild(fillStrElm);
        } else if (ixType == "likert") {
            this.setElementText(elm, "choice", val);
        } else if (ixType == "numeric") {
            this.setElementText(elm, "number", val);
        } else if (ixType == "other") {
            this.setElementText(elm, "responseOther", val);
        } else if (ixType == "sequencing") {
            var set = new Array();
            var fi = 0;
            var i = val.indexOf(SET_DELIM);
            if (i != -1) {
                do {
                    set.push(val.substring(fi,i));
                    fi = i+3;
                    i = val.indexOf(SET_DELIM,fi);
                    if (i == -1) set.push(val.substr(fi));
                } while (i != -1);
            } else {
                set.push(val);
            }
            var stepsElm = this.newElement("steps");
            elm.appendChild(stepsElm);
            for (var z=0; z < set.length; z++) {
                var stepElm = this.newElement("step");
                this.setElementText(stepElm, null, set[z]);
                stepsElm.appendChild(stepElm);
            }
        } else if (ixType == "matching") {
            var matchPatternElm = this.newElement("matchPattern");
            elm.appendChild(matchPatternElm);
            var fi = 0;
            var i = val.indexOf(SET_DELIM);
            if (i != -1) {
                do {
                    var pairVal = val.substring(fi,i);
                    var pair = this.newElement("pair");
                    var dot = pairVal.indexOf("[.]");
                    this.setElementText(pair, "source", pairVal.substring(0, dot));
                    this.setElementText(pair, "target", pairVal.substr(dot+3));
                    matchPatternElm.appendChild(pair);

                    fi = i+3;
                    i = val.indexOf(SET_DELIM,fi);
                    if (i == -1) {
                        pairVal = val.substr(fi);
                        pair = this.newElement("pair");
                        dot = pairVal.indexOf("[.]");
                        this.setElementText(pair, "source", pairVal.substring(0, dot));
                        this.setElementText(pair, "target", pairVal.substr(dot+3));
                        matchPatternElm.appendChild(pair);
                    }
                } while (i != -1);
            } else {
                var pair = this.newElement("pair");
                var dot = val.indexOf("[.]");
                this.setElementText(pair, "source", val.substring(0, dot));
                this.setElementText(pair, "target", val.substr(dot+3));
                matchPatternElm.appendChild(pair);
            }
        } else if (ixType == "performance") {
            find = val.indexOf(SET_DELIM);
            if (find != -1) {
                var fromIndex = 0;
                do {
                    this.addRespStep(elm, val.substring(fromIndex, find));
                    fromIndex = find+3;
                    find = val.indexOf(SET_DELIM, fromIndex);
                    if (find == -1) this.addRespStep(elm, val.substring(fromIndex));
                } while (find != -1);
            } else {
                this.addRespStep(elm, val);
            }
        } else {
            elm.appendChild(this.doc.createCDATASection(val));
        }
    } else {
        this.setElementText(ixElm, CMI_IX_DEF[nm].xmlName, CMI_IX_DEF[nm].toXML(val));
    }
    return TRUE;
}

function activelms_setNumericPattern(crs, val) {
    // numeric is goofy because there is only one group of min/max
    this.removeChildren(crs);
    var delim = val.indexOf("[:]");
    if (delim == 0) {
        // no min
        var maxElm = this.newElement("max");
        this.setElementText(maxElm, null, val.substr(3));
        crs.appendChild(maxElm);
    } else {
        if (delim == (val.length-3)) {
            // no max
            var minElm = this.newElement("min");
            this.setElementText(minElm, null, val.substring(0, delim));
            crs.appendChild(minElm);
        } else {
            // has both
            var minElm = this.newElement("min");
            this.setElementText(minElm, null, val.substring(0, delim));
            crs.appendChild(minElm);
            var maxElm = this.newElement("max");
            this.setElementText(maxElm, null, val.substr(delim+3));
            crs.appendChild(maxElm);
        }
    }
    return TRUE;
}

function activelms_assertIsOnlyPattern(ixElm,ixIdx,val,crIdx) {
    var crsElm = this.getElement(ixElm,"correctResponses");
    for (var n=0; n<crsElm.childNodes.length; n++) {
        if (crIdx != n) {
            var pattern = this.getIxCorrectResponseValue(ixElm,ixIdx,n+".pattern");
            if (pattern == val) {
                return false; // found this same pattern in a different element
            }
        }
    }
    return true;
}

function activelms_isValidMatchingPattern(val) {
    if (val.length == 0) return false;
    if (val == SET_DELIM || val == "[.]" || val == "{}{[]}{}{[]}{}") return false;
    if (val.indexOf(SET_DELIM) == 0 || val.indexOf("[.]") == 0) return false;
    var endsWith = (val.length > 3) ? val.substr(val.length-3) : "";
    if (endsWith == SET_DELIM || endsWith == "[.]") return false;
    var i = val.indexOf(SET_DELIM);
    if (i != -1) {
        var fi = 0;
        do {
            var elm = val.substring(fi,i);
            if (elm.length == 0) return false;
            var j = elm.indexOf("[.]");
            if (j == -1) return false; // no source[.]target delimiter
            if (j == 0) return false; // source is empty
            if (j == (elm.length-3)) return false; // target is empty
            if (!isCMIShortId(elm.substring(0,j))) return false;
            if (!isCMIShortId(elm.substr(j+3))) return false;
            fi = i+3;
            i = val.indexOf(SET_DELIM,fi);
            if (i == -1) {
                elm = val.substr(fi);
                if (elm.length == 0) return false;
                j = elm.indexOf("[.]");
                if (j == -1) return false; // no source[.]target delimiter
                if (j == 0) return false; // source is empty
                if (j == (elm.length-3)) return false; // target is empty
                if (!isCMIShortId(elm.substring(0,j))) return false;
                if (!isCMIShortId(elm.substr(j+3))) return false;
            }
        } while (i != -1);
    } else {
        var j = val.indexOf("[.]");
        if (j == -1) return false; // no source[.]target delimiter
        if (j == 0) return false; // source is empty
        if (j == (val.length-3)) return false; // target is empty
        if (!isCMIShortId(val.substring(0,j))) return false;
        if (!isCMIShortId(val.substr(j+3))) return false;
    }
    return true; // if we get to here ... assume true
}

function activelms_isValidPerformancePattern(val) {
    if (val.length == 0) return false;
    if (val == SET_DELIM || val == "[.]" || val == "{}{[]}{}{[]}{}") return false;
    if (val.indexOf(SET_DELIM)==0) return false;
    var endsWith = (val.length > 3) ? val.substr(val.length-3) : "";
    if (endsWith == SET_DELIM) return false;
    var i = parseOrderMatters(val);
    if (i == -1) return false; // invalid order_matters
    var pattern = (i == 0) ? val : val.substr(i);
    i = pattern.indexOf(SET_DELIM);
    if (i != -1) {
        var fi = 0;
        var elm = null;
        do {
            elm = pattern.substring(fi,i);
            if (!parsePerformanceElement(elm)) return false;
            fi = i+3;
            i = pattern.indexOf(SET_DELIM,fi);
            if (i == -1) {
                elm = pattern.substr(fi);
                if (!parsePerformanceElement(elm)) return false;
            }
        } while (i != -1);
    } else {
        if (!parsePerformanceElement(pattern)) return false;
    }
    return true; // if we get to here ... assume true
}

function activelms_validatePattern(name,val,ixElm,ixType,crIdx) {
	
	// Added after activelms Customer Support Case # 00001142
	var float_ScormVersion = this.getScormVersion(this.rteSchemaVersion);
	
    if (ixType == "true-false") {
        return (val == "true" || val == "false");
    } else if (ixType == "choice") {
        if (val.length == 0) return true;
        if (val == SET_DELIM || val == "{}{[]}{}{[]}{}") return false;
        var i = val.indexOf(SET_DELIM);
        if (i == 0) return false; // can't start with the delimiter
        if (i != -1) {
            if (!parseSetOfId(SET_DELIM,i,val,true)) return false;
        }
        return true;
    } else if (ixType == "fill-in") {
        if (val.length == 0) return true;
        var i = parseMatters(val);
        if (i == -1) return false; // invalid order_matters or case_matters
        var pattern = (i == 0) ? val : val.substr(i);
        return (pattern != SET_DELIM) ? parseSetOfLocalizedString(SET_DELIM,pattern,false) : true;
    } else if (ixType == "long-fill-in") {
        if (val.length == 0) return true;
        var i = parseCaseMatters(val);
        if (i == -1) return false; // invalid order_matters or case_matters
        return isCMILocalizedString(((i==0)?val:val.substr(i)));
    } else if (ixType == "likert") {
        if (val.length == 0) return false;
        if (val == "{}{[]}{}{[]}{}") return false;
        if (val.indexOf(SET_DELIM) != -1 || !isCMIShortId(val)) return false;
        return true;
    } else if (ixType == "matching") {
        return this.isValidMatchingPattern(val);
    } else if (ixType == "performance") {
        return this.isValidPerformancePattern(val);
    } else if (ixType == "sequencing") {
        if (val.length == 0) return false;
        if (trim(val).length == 0) return false;
        if (val == SET_DELIM || val == "[.]" || val == "{}{[]}{}{[]}{}") return false;
        if (val.indexOf(SET_DELIM)==0 && val.length > 3) return false;
        var i = val.indexOf(SET_DELIM);
        if (i == 0) return false; // can't start with the delimiter
        if (i != -1) {
            if (!parseSetOfId(SET_DELIM,i,val,false)) return false;
        } else {
            if (!isCMIShortId(val)) return false;
        }
        return true;
    } else if (ixType == "numeric") {
        if (val.length == 0) return false;
        if (val == "[:]") return true;
        var i = val.indexOf("[:]");
        if(float_ScormVersion > 1.2){
            // see activelms Customer Support Case # 00001142
            if (i == -1) {return false;}
        }
        var min = (i > 0) ? val.substring(0,i) : null;
        var max = ((i+3) < (val.length-1)) ? val.substr(i+3) : null;
        if (min != null && max != null) {
            var fMin = parseFloat(min);
            var fMax = parseFloat(max);
            if (isNaN(fMin) || isNaN(fMax) || (fMin > fMax)) return false;
        } else {
            if (min != null && isNaN(min)) return false;
            if (max != null && isNaN(max)) return false;
        }
        return true; // if we get to here ... assume true
    } else if (ixType == "other") {
        return true;
    } else {
        return false; // unknown type ... assume false
    }
}

function activelms_validateResponse(name,val,ixElm,ixType) {
    if (ixType == "true-false") {
        return (val == "true" || val == "false");
    } else if (ixType == "choice") {
        if (val.length == 0) return true;
        if (val == SET_DELIM || val == "{}{[]}{}{[]}{}") return false;
        var i = val.indexOf(SET_DELIM);
        if (i==0) return false; // can't start with the delimiter
        if (i != -1) return parseSetOfId(SET_DELIM,i,val,true);
        return true;
    } else if (ixType == "fill-in") {
        if (val.length == 0) return true;
        if (val == SET_DELIM || val == "{}{[]}{}{[]}{}") return true;
        return parseSetOfLocalizedString(SET_DELIM,val,false);
    } else if (ixType == "long-fill-in") {
        return isCMILocalizedString(val);
    } else if (ixType == "likert") {
        if (val.length == 0) return false;
        if (val == "{}{[]}{}{[]}{}") return false;
        if (val.indexOf(SET_DELIM) != -1) return false;
        return isCMIShortId(val);
    } else if (ixType == "matching") {
        return this.isValidMatchingPattern(val);
    } else if (ixType == "performance") {
        if (val.length == 0) return false;
        if (val == SET_DELIM || val == "[.]" || val == "{}{[]}{}{[]}{}") return false;
        if (val.indexOf(SET_DELIM)==0) return false;
        var endsWith = (val.length > 3) ? val.substr(val.length-3) : "";
        if (endsWith == SET_DELIM) return false;
        var i = val.indexOf(SET_DELIM);
        if (i != -1) {
            var fi = 0;
            var elm = null;
            do {
                elm = val.substring(fi,i);
                if (!parsePerformanceResponse(elm)) return false;
                fi = i+3;
                i = val.indexOf(SET_DELIM,fi);
                if (i == -1) {
                    elm = val.substr(fi);
                    if (!parsePerformanceResponse(elm)) return false;
                }
            } while (i != -1);
        } else {
            if (!parsePerformanceResponse(val)) return false;
        }
        return true; // if we get to here ... assume true
    } else if (ixType == "sequencing") {
        if (val.length == 0) return false;
        if (trim(val).length == 0) return false;
        if (val == SET_DELIM || val == "[.]" || val == "{}{[]}{}{[]}{}") return false;
        if (val.indexOf(SET_DELIM)==0 && val.length > 3) return false;
        var i = val.indexOf(SET_DELIM);
        if (i == 0) return false; // can't start with the delimiter
        return (i != -1) ? parseSetOfId(SET_DELIM,i,val,false) : isCMIShortId(val);
    } else if (ixType == "numeric") {
        return isCMIDecimal(val) && !isNaN(parseFloat(val));
    } else if (ixType == "other") {
        return true; // no validation possible on other type
    } else {
        return false; // unknown type ... assume false
    }
}

function activelms_GetLastError() {
    return this.errorCode;
}

function activelms_GetErrorString(code) {
    if (typeof(code) != "undefined" && code != null && code != "" && code != "\"\"") {
        return (this.errorMsgs[code]) ? this.errorMsgs[code] : "";
    } else {
        return "";
    }
}
function activelms_GetDiagnostic(code) {
    if (typeof(code) != "undefined" && code != null && code != "" && code != "\"\"") {
        if (this.errorCode == code) {
            return (this.errorDiag != null) ? this.errorDiag : this.GetErrorString(code);
        } else {
            return this.GetErrorString(code);
        }
    } else {
        return "";
    }
}
function activelms_toString() {
    return (this.doc != null) ?
        "RTE Data Model API Adapter (RTE 1.3) for LMS ["+this.soapAddressLocation+"] Initialized at ["+this.initializedAt+"]: "+this.doc :
        "RTE Data Model API Adapter (RTE 1.3) for LMS ["+this.soapAddressLocation+"] Not Initialized to LMS";
}
function activelms_debug(func, args, msg) {
    if (this.DEBUG) {
        var debugMsg = "   RTE Data Model." + func + "(";
        if (args != null) debugMsg += args;
        debugMsg += ") :: ";
        debugMsg += msg;
        this.trace(debugMsg);
    }
}
function activelms_error(func, args, msg) {
	/*
    var debugMsg = "   RTE Data Model." + func + "(";
    if (args != null) debugMsg += args;
    debugMsg += ") :: ERROR: ";
    debugMsg += msg;
    this.trace(debugMsg);
    */
}
function activelms_enter(func, args) {
	/*
    var debugMsg = ">> RTE Data Model." + func + "(";
    if (args != null) debugMsg += args;
    debugMsg += ")";
    this.trace(debugMsg);
    */
}
function activelms_exit(func, args, retVal) {
	/*
    var debugMsg = "<< RTE Data Model." + func + "(";
    if (args != null) debugMsg += args;
    if (typeof(retVal) != "undefined") {
        debugMsg += ") :: return \""+retVal+"\"";
    } else {
        debugMsg += ") :: return {void}";
    }
    debugMsg += "; errorCode="+this.errorCode;
    if (this.errorDiag != null) {
        debugMsg += "; errorDiag="+this.errorDiag;
    }
    this.trace(debugMsg);
    */
}
function activelms_trace(msg) {
	/*
    if (this._trace != null) {
        // trim to avoid really large logs bogging down the env
        if (this._trace.value.length > MAX_LOG_LENGTH) this._trace.value = "";
        this._trace.value += msg+'\n';
    }
    */
}

function activelms_joinKeys(arr) {

    var keys = new Array();
    for (var key in arr) {
        // keys word filter added by activelms
        if(key == "remove"||key == "indexOf"){continue;}
        keys.push(key);
   }
    return keys.join(",");
}

/**
 * This method re-written by activelms following issues
 * with IE 7 upgrade and Automation Server can't create object
 * errors.
 */
function activelms_newDocument(rootName) {
    // we only create SOAP documents ...
    var nsUri = SOAP_ENVELOPE_NS;
    //var domDoc = null;
	try{
		var xDoc = null;
		if(document.implementation && document.implementation.createDocument){
			xDoc = document.implementation.createDocument(nsUri,rootName,null);
            // looks like safari does not create the root element for some unknown reason
            if(xDoc && !xDoc.documentElement){
                var rootElm = this.newElement(rootName, nsUri, xDoc);
                rootElm.setAttribute("xmlns:soapenv", nsUri);
                xDoc.appendChild(rootElm);
            }
		}
		else if(typeof ActiveXObject != "undefined"){
			var msXmlAx = null;
			try{
				msXmlAx = new ActiveXObject("Msxml2.DOMDocument");
			}
			catch(error){
				msXmlAx = new ActiveXObject("Msxml.DOMDocument");
			}
			xDoc = msXmlAx;
        	var rootElm = this.newElement(rootName, nsUri, xDoc);

        	rootElm.setAttribute("xmlns:soapenv", nsUri);
        	xDoc.appendChild(rootElm);
		}
        else if (typeof(DOMParser) != "undefined") {
            var domParser = new DOMParser();
            xDoc = domParser.parseFromString("<"+rootName+" xmlns:soapenv='"+nsUri+"' />", "text/xml");
		}
		
		/*
		if(xDoc==null || typeof xDoc.load=="undefined"){
			//var str_Error = "Cannot create DOM Document implementation in this browser";
			//alert(str_Error);
			//throw new Error(str_Error);
			// added to support safari
			xDoc = document.implementation.createDocument(nsUri,rootName,null);
            var rootElm = this.newElement(rootName, nsUri, xDoc);
	        this.setAttribute(rootElm, "xmlns:soapenv", nsUri);
            xDoc.appendChild(rootElm);
		}
		*/
	}
	catch(error){
		throw new Error(error.message);
	}
	return xDoc;
}

/*
function activelms_newDocument(rootName) {
    // we only create SOAP documents ...
    var nsUri = SOAP_ENVELOPE_NS;
    var domDoc = null;
    if (this.msxmlProgId) {
        domDoc = new ActiveXObject(this.msxmlProgId);
        var rootElm = this.newElement(rootName, nsUri, domDoc);
        rootElm.setAttribute("xmlns:soapenv", nsUri);
        domDoc.appendChild(rootElm);
    } else {
        if (typeof(DOMParser) != "undefined") {
            var domParser = new DOMParser();
            domDoc = domParser.parseFromString("<"+rootName+" xmlns:soapenv='"+nsUri+"' />", "text/xml");
        } else {
            domDoc = document.implementation.createDocument(nsUri,rootName,null);
            var rootElm = this.newElement(rootName, nsUri, domDoc);
            rootElm.setAttribute("xmlns:soapenv", nsUri);
            domDoc.appendChild(rootElm);
        }
    }
    return domDoc;
}
*/



function activelms_serializeXML(domDoc) {
    if (domDoc.xml) {
        return trim(domDoc.xml);
    } else {
        var toXML = new XMLSerializer();
        return trim(toXML.serializeToString(domDoc));
    }
}

// returns a float value or null if not available or not valid
function activelms_getElementFloat(domElm, childName) {
    var elmFloat = null;
    var text = this.getElementText(domElm, childName);
    if (text != null) {
        elmFloat = parseFloat(text);
        if (isNaN(elmFloat)) elmFloat = null;
    }
    return elmFloat;
}

var encodeBase64 = function(str_S){
		if(!str_S || str_S==''|| str_S==null) {
			return str_S;
		}
		try{
			// we are using eval because the Base64 object is not
			// available during JSLint parsing
			str_S =  eval('Base64.encode(str_S)');
			return str_S.replace(/\+/g, " ");
		}
		catch(e){
			return str_S;
		}
}

var decodeBase64 = function(str_S){
		if(!str_S || str_S==''|| str_S==null) {
			return str_S;
		}
		try{
			// we are using eval because the Base64 object is not
			// available during JSLint parsing
			str_S = str_S.replace(/ /g, "+");
			return  eval('Base64.decode(str_S)');
		}
		catch(e){
			return str_S;
		}	
}

// Added by activelms to resolve issues with Articulate Quizmaker 9
var encodeUtf8 = function(str_S){
	var str_Encoded = undefined;
	try{
		str_Encoded = escape( encodeURIComponent(str_S));
	}
	catch(obj_Error){
		try{
			str_Encoded = escape(str_S);
		}
		catch(obj_Error2){
			str_Encoded = str_S;
		}
	}
	return str_Encoded;
}
	
// Added by activelms to resolve issues with Articulate Quizmaker 9
var decodeUtf8 = function(str_S){
	var str_Decoded = str_S;
	try{
		str_Decoded = decodeURIComponent(unescape(str_S));
	}
	catch(obj_Error){
		try{
			str_Decoded = unescape(str_S);
		}
		catch(obj_Error2){
			str_Decoded = str_S;
		}
	}
	return str_Decoded;
}

// returns a String value or null if not available
function activelms_getElementText(domElm, childName) {
    var elmText = null;
    if (domElm) {
        if (childName) {
            var childElm = this.getElement(domElm, childName);
            if (childElm && childElm.firstChild) {
                elmText = childElm.firstChild.nodeValue;
            }
        } else {
            if (domElm.firstChild) {
                elmText = domElm.firstChild.nodeValue;
            }
        }
    }
    return elmText;
}

function activelms_setElementText(domElm, childName, text) {
	if(childName == "suspendData"){
		// required for Articulate Quiz Maker 9
		//text = encodeUtf8(text);
		text = encodeBase64(text);
	}
    if (domElm) {
        if (childName) {
            var childElm = this.getElement(domElm, childName);
            if (childElm) {
                this.removeChildren(childElm);
                if (text != null) {
                    childElm.appendChild(this.doc.createTextNode(text));
					if(childName == "suspendData"){
						childElm.setAttribute("encoding","base64");
					}
                }
            } else {
                childElm = this.newElement(childName);
                if (text != null) {
                    childElm.appendChild(this.doc.createTextNode(text));
					if(childName == "suspendData"){
						childElm.setAttribute("encoding","base64");
					}
                }
                domElm.appendChild(childElm);
            }
        } else {
            this.removeChildren(domElm);
            if (text != null) {
                domElm.appendChild(this.doc.createTextNode(text));
            }
        }
    }
    return TRUE;
}

function activelms_removeChildren(elm) {
    if (elm) {
        while (elm.hasChildNodes()) elm.removeChild(elm.firstChild);
    }
}

function activelms_getElementCount(p,t) {
    var _count = 0;
	
	// Script ammended by activelms
	var str_delim = ":";
	var int_Index = t.indexOf(str_delim);
	var str_TargetLocalName = t.substring(int_Index+1, t.length);

    if (p && t) {
        for (var i=0; i<p.childNodes.length; i++) {
            if (p.childNodes[i].nodeType == 1){
				var str_NodeName = p.childNodes[i].nodeName;
				int_Index = str_NodeName.indexOf(str_delim);
				var str_LocalName = str_NodeName.substring(int_Index+1, str_NodeName.length);
				
            		if(str_LocalName == str_TargetLocalName) {
                        ++(_count);
                	}
				
				//&& p.childNodes[i].nodeName == t) ++(_count);
				
            } 
        }
    }
    return _count;
}

function activelms_getElement(p,t) {

	// Script ammended by activelms
    /*
    if (p && p.hasChildNodes()) {
        for (var i=0; i<p.childNodes.length; i++) {
            if (p.childNodes[i].nodeType == 1 && p.childNodes[i].nodeName == t) {
                return p.childNodes[i];
            }
            if(p.hasChildNodes()){
            	return this.getElement(p.childNodes[i], t);
            }
        }
    }
    return null;
    */
    
	this.obj_Node = null;
	var str_delim = ":";
	var int_Index = t.indexOf(str_delim);
	var str_TargetLocalName = t.substring(int_Index+1, t.length);

    if (p && p.hasChildNodes()) {
        var int_Count = p.childNodes.length
        for (var i=0; i<int_Count; i++) {
        
        	try{
            	if (p.childNodes[i].nodeType == 1){
            
					var str_NodeName = p.childNodes[i].nodeName;
					int_Index = str_NodeName.indexOf(str_delim);
					var str_LocalName = str_NodeName.substring(int_Index+1, str_NodeName.length);

            		if(str_LocalName == str_TargetLocalName) {
                		this.obj_Node = p.childNodes[i];
                		break;
                	}
            	}
            	if(p.childNodes[i].hasChildNodes()){
            		this.getElement(p.childNodes[i], str_TargetLocalName);
            	}
        	}
        	catch(e){
        		return null;
        	}
        }
    }
    return this.obj_Node;
}

function activelms_getElementForSet(p,nm) {
    var elm = this.getElement(p, nm);
    if (elm != null) {
        this.removeChildren(elm);
    } else {
        elm = this.newElement(nm);
        p.appendChild(elm);
    }
    return elm;
}

function activelms_getElementAtIndex(p,x) {
    if (p) if (x >= 0 && x < p.childNodes.length) return p.childNodes[x];
    return null;
}

/*
function activelms_newElement(elmName, nsUri, domDoc) {
    if (!(domDoc)) domDoc = this.doc;
    var elm = null;
    if (this.msxmlHttpProgId != null) {
		alert("this.msxmlHttpProgId=" + this.msxmlHttpProgId);
        if (nsUri) {
			alert("domDoc.createNode nsUri + domDoc" + domDoc);
            elm = domDoc.createNode(1, elmName, nsUri);
			alert("domDoc.createNode nsUri + elm=" + elm);
        } else {
            elm = domDoc.createNode(1, elmName, IEEE_1484_11_3_NS);
        }
    } else {
        if (nsUri) {
            elm = domDoc.createElementNS(nsUri, elmName);
        } else {
            elm = domDoc.createElementNS(IEEE_1484_11_3_NS, elmName);
        }
    }
    
	alert("elm=" + elm);

    if (nsUri == activelms_NS) {
        if (this.browserType == "OPR" || this.browserType == "SFR") {
            elm.setAttribute("xmlns:icn", activelms_NS);
        }
    }
    
    return elm;
}
*/

/*
* Refactored to support case 00001757 to remove dependence
* on switching on the this.msxmlHttpProgId value
*/
function activelms_newElement(elmName, nsUri, domDoc) {
    if (!(domDoc)) domDoc = this.doc;
    var elm = null;
	if(typeof domDoc == 'object'){
		if(typeof domDoc.createElement == 'unknown'){
			if (nsUri) {
				elm = domDoc.createNode(1, elmName, nsUri);
			} else {
				elm = domDoc.createNode(1, elmName, IEEE_1484_11_3_NS);
			}
		}
		else{
			if (nsUri) {
				elm = domDoc.createElementNS(nsUri, elmName);
			} else {
				elm = domDoc.createElementNS(IEEE_1484_11_3_NS, elmName);
			}
		}
	}
	
    if (nsUri == activelms_NS) {
        if (this.browserType == "OPR" || this.browserType == "SFR") {
            elm.setAttribute("xmlns:icn", activelms_NS);
        }
    }
    
    return elm;
}

function activelms_getCDataText(p) {
    if (p != null) {
        for (var i=0; i<p.childNodes.length; i++) {
            if (p.childNodes[i].nodeType == 4 || p.childNodes[i].nodeType == 3) {
                return p.childNodes[i].nodeValue;
            }
        }
    }
    return EMPTY;
}

function activelms_setElementLangString(elm, val) {
    var lang = null;
    if (val.indexOf("{lang=")==0) {
        var idx = val.indexOf("}");
        if (idx > 6) {
            lang = val.substring(6,idx);
            val = val.substr(idx+1);
        }
    }
    if (lang != null) {
        elm.setAttribute("lang", lang);
    } else {
        elm.removeAttribute("lang");
    }
    elm.appendChild(this.doc.createTextNode(val));
    return TRUE;
}

function activelms_setAttribute(elm, attrName, attrValue) {
    if (elm) {
        if (attrName) {
            if (attrValue) {
                elm.setAttribute(attrName, attrValue);
            } else {
                elm.removeAttribute(attrName);
            }
        }
    }
}

function activelms_isValid(nm, val, def) {
    if (def) {
        if (!def.canWrite && !def.canRead) {
            // if both are false, then its a parent, such as cmi.comments_from_learner
            // and is thus undefined ...
            this.UNDEFINED(nm,val);
            return false;
        }
        if (!def.canWrite) {
            this.READ_ONLY(nm);
            return false;
        }
        //var func = (def.validator != null) ? eval("isCMI"+def.validator) : null;
		// replaced by activelms
		var func = null;
		if(def.validator != null){
			func = eval("isCMI"+def.validator);
		}
        if (func != null) {
            if (!func(val)) {
                this.TYPE_MISMATCH(nm,val);
                return false;
            }
        }
        return true;
    } else {
        this.UNDEFINED(nm,val);
        return false;
    }
}
function activelms_isLeaf(nm,def) {
    var dotIdx = nm.indexOf(".");
    if (dotIdx != -1) {
        var tmp = nm.substring(0,dotIdx);
        if (def[tmp]) {
            tmp = nm.substr(dotIdx+1);
            if (tmp == "_children") {
                this.NO_CHILDREN(nm);
            } else if (tmp == "_count") {
                this.NO_COUNT(nm);
            } else {
                this.UNDEFINED(nm);
            }
        } else {
            this.UNDEFINED(nm);
        }
        return false;
    } else {
        if (def[nm]) {
            if (!def[nm].canWrite && !def[nm].canRead) {
                this.UNDEFINED(nm);
                return false; // parent has false && false
            } else {
                return true;
            }
        } else {
            this.UNDEFINED(nm);
            return false;
        }
    }
}

function activelms_setLearnerName(learnerName) {this.learnerName = learnerName;}
function activelms_setLearnerId(learnerId) {this.learnerId = learnerId;}
function activelms_setCourseId(courseId) {this.courseId = courseId;}
function activelms_setOrgId(orgId) {this.orgId = orgId;}
function activelms_setScoId(scoId) {this.scoId = scoId;}
function activelms_setSessionId(sessionId) {this.sessionId = sessionId;}
function activelms_setPk(pk) {this.pk = pk;}
function activelms_setDomainId(domainId) {this.domainId = domainId;}

function activelms_setRteSchemaVersion(rteSchemaVersion) {this.rteSchemaVersion = rteSchemaVersion;}

// this is an implementation of a very rudimentary XML serializer that
// is needed for Safari because the default serializer provided does
// not handle attributes correctly, especially the xmlns: ones
function activelms_XMLBuf() {
    this.aStr = new Array();
    this.ptr = -1;
};
var XMLBufPrototype = activelms_XMLBuf.prototype;
XMLBufPrototype.xml2str = function(domDoc) {
    this.ptr = -1;
    this.aStr.length = 0;
    this.writeNode(domDoc.documentElement);
    var fromIndex = this.ptr+1;
    this.aStr.splice(fromIndex, (this.aStr.length-fromIndex));
    var str = this.aStr.join('');
    this.aStr.length = 0;
    this.ptr = -1;
    return str;
};
XMLBufPrototype.append = function(str) {
    if (str) {
        if (++this.ptr == this.aStr.length)
            this.aStr.length = this.aStr.length+50;
        this.aStr[this.ptr] = str;
    }    
    return this;
};
XMLBufPrototype.writeNode = function(n) {
    switch (n.nodeType) {
        case 1:
            this.append("<").append(n.nodeName);
            if (n.attributes) {
                for (var a=0; a < n.attributes.length; a++) {
                    this.append(" ");
                    if (n.attributes[a].nodeName == "soapenv") {
                        this.append("xmlns:soapenv");
                    } else if (n.attributes[a].nodeName == "icn") {
                        this.append("xmlns:icn");
                    } else {
                        this.append(n.attributes[a].nodeName);
                    }
                    this.append("='").append(this.escape(n.attributes[a].value)).append("'");
                }
            }
            if (n.hasChildNodes()) {
                this.append(">");
                for (var c=0; c < n.childNodes.length; c++)
                    this.writeNode(n.childNodes[c]);
                this.append("</").append(n.nodeName).append(">");
            } else {
                this.append("/>");
            }
            break;
        case 3:
            this.append(this.escape(n.nodeValue));
            break;
    }
};
XMLBufPrototype.escape = function(val) {
    return val.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&apos;");
};



