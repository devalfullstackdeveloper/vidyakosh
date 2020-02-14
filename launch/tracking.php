<?php
error_reporting(E_ERROR);
session_start();
include_once "languages/ApplicationErrors.php";
include_once "languages/ApplicationResources.php";
include_once "languages/ApplicationResources_en_US.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!--
 * Copyright 2006 All Rights Reserved
 *
 * You may not make or distribute copies of this Software, or 
 * electronically transfer the Software from one computer to 
 * another or over a network. 
 *
 * You may not alter, merge, modify, adapt or translate this Software, 
 * or decompile, reverse engineer, disassemble, or otherwise reduce this Software.
 *
 * activelms Ltd 
 * St Johns Innovation Centre
 * Cowley Road
 * Cambridge 
 * CB4 0WS
 * England
 * 
 * Registered in England and Wales No: 5068195
 * sales@activelms.com
 *
 * See Legal Terms, Conditions and License in 
 * legal/activelms_PLAYER_LICENSE.txt
 *
//-->
<html>
    <head>
        <title>LMSTracking</title>
	    <link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/ext-all.css" />
    	<link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/<?=$_SESSION["skinID"]?>/interstitial.css"/>
        <style>
            .element{padding-left:20px;}
            .name{font-weight:normal; color:blue;}
            .value{font-weight:normal;}
        </style>
    	
		<!-- Sarissa -->
		<script type="text/javascript" language="JavaScript" src="js/sarissa.js"><![CDATA[]]></script>

		<!-- activelms RTE -->
        <script type="text/javascript" language="JavaScript" src="js/engine.js"><![CDATA[]]></script>	
        <script type="text/javascript" language="JavaScript" src="js/main.js"><![CDATA[]]></script>
	    <script type="text/javascript" language="JavaScript" src="js/utils.js"><![CDATA[]]></script>
		<script type="text/javascript" language="JavaScript" src="js/master.js"><![CDATA[]]></script>

		<!-- Page Script -->
		<script type="text/javascript" language="JavaScript">
        	//<![CDATA[
            var obj_Client = undefined;
        
		    log = new activelms.Logger(
			    activelms.Logger.NONE, 
			    activelms.Logger.POPUP_LOGGER);
			    
			function doLoad(){
				parent.document.title = "<?=$PAGE_ROOT_TITLE?>";
				parent.doShowHideMenu(false); 
			}
			    
			function doServiceCall(){
			
			    // Get the properties from the model
	            var str_CMIRunEndPoint = parent.ICN_MODEL.get("CMIRunEndPoint");
	            var str_LearnerID = parent.ICN_MODEL.get("learnerID");
	            var str_DomainID = parent.ICN_MODEL.get("domainID");
	            var str_CourseID = parent.ICN_MODEL.get("courseID");
	            var str_OrgID = parent.ICN_MODEL.get("orgID");
	            var str_ScoID = parent.ICN_MODEL.get("mostRecentScoID");
	            var str_SessionID = parent.ICN_MODEL.get("sessionID");
	            
	            /*
	            alert(str_CMIRunEndPoint
	            + "\n" + str_LearnerID
	            + "\n" + str_DomainID
	            + "\n" + str_CourseID       
		        + "\n" + str_OrgID
		        + "\n" + str_ScoID
		        + "\n" + str_SessionID
	            );
	            */
			
                // Define the properties of the AJAX client
	            var str_HttpAction = "POST";
	            var str_ServiceEndPoint = str_CMIRunEndPoint;
	            var b_Async = true;
	        
	            // Create the AJAX client
                obj_Client = new activelms.CmiServiceClient(
                    str_HttpAction,
                    str_ServiceEndPoint,
                    b_Async);
                    
                // Add some properties to the client for the context of the call
                obj_Client.setDomainID(str_DomainID);
                obj_Client.setLearnerID(str_LearnerID);
                obj_Client.setCourseID(str_CourseID);
                obj_Client.setOrgID(str_OrgID);
                obj_Client.setScoID(str_ScoID);
                obj_Client.setSessionID(str_SessionID);
                obj_Client.setPrimaryKey("1");
            
                // Define an operation to invoke and a method to callback to
                var str_OperationName = "Read";
                var fn_CallBack = serviceResponse;
            
        	    // Invoke a named web service operation, and name a function to recieve the response
        	    obj_Client.invoke(str_OperationName, fn_CallBack);  
			}
			
            function serviceResponse(){
        
                // Get the output DIV
                var obj_OutDiv = document.getElementById("out");
                
                // Display the contextual information
                var obj_TextNode = document.createTextNode("Course: " + parent.ICN_MODEL.get("courseID"));
                var obj_Para = document.createElement("p");
                obj_Para.appendChild(obj_TextNode);
                obj_OutDiv.appendChild(obj_Para);
                
                obj_TextNode = document.createTextNode("Organization: " + parent.ICN_MODEL.get("orgID"));
                obj_Para = document.createElement("p");
                obj_Para.appendChild(obj_TextNode);
                obj_OutDiv.appendChild(obj_Para);
                
                obj_TextNode = document.createTextNode("Activity: " + parent.ICN_MODEL.get("mostRecentScoID"));
                obj_Para = document.createElement("p");
                obj_Para.appendChild(obj_TextNode);
                obj_OutDiv.appendChild(obj_Para);
                
                obj_Para = document.createElement("p");
                obj_Para.appendChild(document.createElement("br"));
                obj_OutDiv.appendChild(obj_Para);
                
                // Get the root element
                var obj_Root = obj_Client.getResponseXml().documentElement;
                
                // Display the root
                var obj_Div = document.createElement("div");
                obj_Div.className = "element";
                var obj_Span = document.createElement("span");
                obj_Span.className = "name";
                var obj_NameTextNode = document.createTextNode(obj_Root.nodeName + ": ");
                obj_Span.appendChild(obj_NameTextNode);
                obj_Div.appendChild(obj_Span);
                
                // Traverse the DOM tree
                obj_Div.appendChild(doTraverse(obj_Root));
                
                // Add the footer
                var obj_Footer = document.createElement("p");
                var obj_Break = document.createElement("br");
                obj_Footer.appendChild(obj_Break);
                
                obj_OutDiv.appendChild(obj_Div);
                obj_OutDiv.appendChild(obj_Footer);
                obj_OutDiv.style.visibility="visible";
            }
            
            function doTraverse(obj_Element, str_Indent){
        
                var doc_Page = window.document;
                var obj_Div = doc_Page.createElement("div");
                obj_Div.className = "element";
            
                for(var i=0; i<obj_Element.childNodes.length; i++){
            
                    if(obj_Element.childNodes[i].nodeType==3){continue;}
                    var name = obj_Element.childNodes[i].nodeName;
                    var value = "";
                    if(obj_Element.childNodes[i].firstChild 
                    && 
                    obj_Element.childNodes[i].firstChild.nodeType == 3){
                        value = obj_Element.childNodes[i].firstChild.nodeValue;
                    }
                
                    var obj_ChildDiv = doc_Page.createElement("div");
                    obj_Div.className = "element";
                
                    var obj_Span = doc_Page.createElement("span");
                    obj_Span.className = "name";
                    var obj_NameTextNode = doc_Page.createTextNode(name + ": ");
                    obj_Span.appendChild(obj_NameTextNode);
                    obj_ChildDiv.appendChild(obj_Span);
                
                    obj_Span = doc_Page.createElement("span");
                    obj_Span.className = "value";
                    var obj_ValueTextNode = doc_Page.createTextNode(value);
                    obj_Span.appendChild(obj_ValueTextNode);
                    obj_ChildDiv.appendChild(obj_Span);

                    if(obj_Element.childNodes[i].hasChildNodes()){
                        if(obj_Element.childNodes[i].nodeType==1){
                            obj_ChildDiv.appendChild(doTraverse(obj_Element.childNodes[i]));
                        }
                    }
                    obj_Div.appendChild(obj_ChildDiv);
                }

                return obj_Div;
            }
			
			function doClose(){
				top.close();
				parent.opener.focus();
			}
        	//]]>
        </script>
    </head>
    <body onload="doLoad();">
        <h3>SCORM Tracking Data</h3>
        <p><br /></p>
        <p>The activelms SCORM Player manages <span class="bold">SCORM tracking data</span> through calls to a <span class="bold">document style SOAP web service</span>.<br />&nbsp;<br /></p>
        <p>The web service exchanges documents according to the <span class="bold">IEEE 1484.11.3 schema</span> for <span class="bold">Content Object Communication Datamodel</span>.<br />&nbsp;<br /></p>
    	<div class="col">
        	<div class="block" id="callService" style="visibility: visible;">
        		<div class="block-body">
					<table>
						<tr>
							<td>
                                <div class="buttonServiceCall">
                                    <a href="#" onclick="doServiceCall();return false;">
                                        <span>Call web service</span>
                                    </a>
                                </div>
							</td>
							<td>&nbsp;</td>
							<td>
								<span class="bold">Download</span>. Click to call the web service to return the tracking data as an XML document.
							</td>
						</tr>
					</table>
        		</div>
        	</div>
        </div>
    	<div class="col">
        	<div class="block" id="closeWindow" style="visibility: visible;">
        		<div class="block-body">
					<table>
						<tr>
							<td>
                                <div class="buttonWindowClose">
                                    <a href="#" onclick="doClose();return false;">
                                        <span><?=$CLOSE?></span>
                                    </a>
                                </div>
							</td>
							<td>&nbsp;</td>
							<td>
								<span class="bold"><?=$CLOSE?></span>. <?=$CLOSE_TOOLTIP?>
							</td>
						</tr>
					</table>
        		</div>
        	</div>
        </div>
        <div style="position:absolute; top:240px; left:20px;" id="out"></div>
    </body>
</html>
