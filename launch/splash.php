<?php
error_reporting(E_ERROR);
session_start();
include_once "languages/ApplicationErrors.php";
include_once "languages/ApplicationResources.php";
include_once "languages/ApplicationResources_en_US.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=US-ASCII" />
    <title>SCORM Player</title>
    <link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/ext-all.css" />
    <link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/<?=$_SESSION["skinID"]?>/interstitial.css" />
    <link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/ytheme-<?=$_SESSION["skinID"]?>.css" />
    <style type="text/css">
                html, body {
            margin:0;
            padding:0;
            border:0 none;
            overflow:hidden;
            height:100%;
        }
    </style>

    <script type="text/javascript">
        // Ensure the loading indicator is available immediately
        if(document.images){
            var img_Loading = new Image(16,16);
            img_Loading.src = "skins/extjs/resources/images/<?=$_SESSION["skinID"]?>/activelms/loading.gif";
            var img_Spash = new Image(480,320);
            img_Spash.src = "skins/extjs/resources/images/<?=$_SESSION["skinID"]?>/activelms/splash_480_320.gif";
        }

        function doEscape(str_Target){
            str_Target = str_Target.split("'").join("\'");
            return str_Target.split("%27").join("\'");
        }
        
        var XML_HTTP_REQ = undefined;
        var ICN_XML_HTTP_STATUS_0 = doEscape("Service request uninitialized, opening...");
        var ICN_XML_HTTP_STATUS_1 = doEscape("Service request loading, service not yet called...");
        var ICN_XML_HTTP_STATUS_2 = doEscape("Service request loaded, service called, headers available...");
        var ICN_XML_HTTP_STATUS_3 = doEscape("Service request interactive, response partially available...");
        var ICN_XML_HTTP_STATUS_4 = doEscape("Service request completed, response available.");

   	    function xmlHttpStatusToMessage(int_Code){
		    switch(int_Code){
			case 0: return ICN_XML_HTTP_STATUS_0;
			case 1: return ICN_XML_HTTP_STATUS_1;
			case 2: return ICN_XML_HTTP_STATUS_2;
			case 3: return ICN_XML_HTTP_STATUS_3;
			case 4: return ICN_XML_HTTP_STATUS_4;
			default: return ICN_XML_HTTP_STATUS_0;
			}
		}
  
        function updateLabel(str_ID, str_Message){
            var obj_El = document.getElementById(str_ID);
            obj_El.innerHTML = str_Message;
        }

        function readZipFile(str_CourseID){
            var url = "ZipResolver.php?courseID=" + str_CourseID;
            postRequest(url);
        }
                                
        function createXmlHttp(){
            // Cross browser from Sarissa, but can fail when called from an iFrame (?)
            if(window.XMLHttpRequest){
                // Mozilla, Safari and Sarrissa
                XML_HTTP_REQ = new XMLHttpRequest();
             }
             else if (typeof ActiveXObject != "undefined"){
                // IE
                var ICN_XMLHTTP_PROGID = undefined;
                var ICN_XMLHTTP_PROGID_LIST = [
                        "Msxml2.XMLHTTP.5.0", 
                        "Msxml2.XMLHTTP.4.0", 
                        "MSXML2.XMLHTTP.3.0", 
                        "MSXML2.XMLHTTP", 
                        "Microsoft.XMLHTTP"];
                var int_Count = ICN_XMLHTTP_PROGID_LIST.length;
                var b_Found = false;
                for(var i=0; i < int_Count && !b_Found; i++){
                    try{
                         var obj_X = new ActiveXObject(ICN_XMLHTTP_PROGID_LIST[i]);
                         ICN_XMLHTTP_PROGID = ICN_XMLHTTP_PROGID_LIST[i];
                         bFound = true;
                      }
                      catch (obj_Exception){alert("Cannot load XML HTTP Request Object");}
                 }
                 if (!b_Found) {alert("Failed to load XML HTTP Request Object");}
                 XML_HTTP_REQ = new ActiveXObject(ICN_XMLHTTP_PROGID);
             }
             return XML_HTTP_REQ;
         }

         function postRequest(url){
            createXmlHttp();
           updateLabel("statusMessage","Creating request...");
            // 'true' specifies that it's a async call
            XML_HTTP_REQ.open("GET", url, true);
           updateLabel("statusMessage","Opening request...");
            // Register a callback for the call
            XML_HTTP_REQ.onreadystatechange = function (){
                updateLabel("statusMessage",xmlHttpStatusToMessage(XML_HTTP_REQ.readyState));
                if (XML_HTTP_REQ.readyState == 4){
                    var int_StatusCode = XML_HTTP_REQ.status;
                    updateLabel("statusMessage","Response status " + int_StatusCode);
                    if(int_StatusCode == 200){
                        updateLabel("installMessage", "<?=$remoteFileName?> installed OK");
                    }
                    else{
                        updateLabel("installMessage", "Error installing <?=$remoteFileName?>");
                    }
                    var str_CourseID = XML_HTTP_REQ.responseText;
                    var obj_Form = document.playerForm;
                    obj_Form.elements['courseID'].value = str_CourseID;
                    obj_Form.action = "index.php";
                    obj_Form.method = "POST";
                    var a = window.setTimeout("document.playerForm.submit();",1000); 
                 }
             }                        
             // Send the actual request
             updateLabel("statusMessage","Sending request...");
             XML_HTTP_REQ.send("");
             updateLabel("statusMessage","Sent request...");
          }
                                

    </script>

</head>
<body scroll="no" onload="readZipFile('<?=$courseID?>');">
    <!-- The splash screen. Include everything after the splash screen -->
    <div id="splash" align="center">
        <table width="480" border="0" cellpadding="2" cellspacing="2">
            <tr>
                <td colspan="3">&nbsp;
                    </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;
                    </td>
            </tr>
            <tr>
                <td width="100"></td>
                <td width="50" align="right" class="splashBold" valign="top">
                    <img src="skins/extjs/resources/images/<?=$_SESSION["skinID"]?>/activelms/loading.gif" width="16" height="16"
                        alt="" />&nbsp;
                </td>
                <td width="330" align="left" class="splashBold" valign="top">
                    activelms SCORM Player</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;
                    </td>
            </tr>
            <tr>
                <td></td>
                <td align="left" class="splashBold" valign="top">
                    Installing:&nbsp;</td>
                <td align="left" class="splashNormal" valign="top">
                    <span id="installMessage">
                        <?=$remoteFileName?>...
                    </span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td align="left" class="splashBold" valign="top">
                    Downloading:&nbsp;</td>
                <td align="left" class="splashNormal" valign="top">
                    <span id="Span1">
                        <?=$remoteFileSize?> KB
                    </span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td align="left" class="splashBold" valign="top">
                    Status:&nbsp;</td>
                <td align="left" class="splashNormal" valign="top">
                    <span id="statusMessage">
                        <?=$LOADING?>...</span>
                </td>
            </tr>
        </table>
        <div>
            <form id="playerForm" name="playerForm" action="">
                <input type="hidden" name="domainID" value="<?=$domainID?>">
                <input type="hidden" name="courseID" value="SCORM Detective 2004">
                <input type="hidden" name="learnerID" value="<?=$learnerID?>"></form>
        </div>
</body>
</html>
