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
 * $LastChangedDate: 2009-02-28 15:39:31 +0000 (Sat, 28 Feb 2009) $
 * $LastChangedRevision: 1252 $
//-->
<html>
    <head>
        <title>LMSAjaxError</title>
		<!-- Page Script -->
		<script type="text/javascript" language="JavaScript">
        	//<![CDATA[
			function doLoad(){
			
			    try{parent.doDisableControls(true);}
                catch(error){}
			
			    try{parent.getEl('loading').remove();}
                catch(error){}
                
                //parent.document.title = "SCORM Player Error | <?=$errorMessage?>";
			}
        	//]]>
        </script>
    </head>
    <body onload="doLoad();">
        <p><b>SCORM Player Error</b></p>
        <p>Click <a href="#" onclick="parent.doExitAll();return false">here</a> to conclude this session.</p>
        <p>An application error has occured with the description:</p>
        <p><i><?=$_GET["errorDescription"]?></i></p>
        <p>The error details are:</p>
        <table border="1" width="640">
            <tr>
                <td nowrap="nowrap"><b>File Name</b></td><td><?=$_GET["errorFileName"]?></td>
            </tr>
            <tr>
                <td nowrap="nowrap"><b>Line</b></td><td><?=$_GET["errorLineNumber"]?></td>
            </tr>
            <tr>
                <td nowrap="nowrap"><b>Error Message</b></td><td><?=$_GET["errorMessage"]?></td>
            </tr>
            <tr>
                <td nowrap="nowrap"><b>Error Type</b></td><td><?=$_GET["errorName"]?></td>
            </tr>
            <tr>
                <td nowrap="nowrap"><b>Error Number</b></td><td><?=$_GET["errorNumber"]?></td>
            </tr>
            <tr>
                <td><b>Trace</b></td><td><?=$_GET["errorStack"]?></td>
            </tr>
        </table>
        <p></p>
        <p>Click <a href="#" onclick="parent.doExitAll();return false">here</a> to conclude this session.</p>
    </body>
</html>