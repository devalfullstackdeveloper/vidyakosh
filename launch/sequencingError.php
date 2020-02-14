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
    <title>LMSSequencingError</title>
    <link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/ext-all.css" />
    <link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/<?=$_SESSION["skinID"]?>/interstitial.css" />

    <!-- Page Script -->

    <script type="text/javascript" language="JavaScript">
    //<![CDATA[
        function doLoad(){
    
            //parent.document.title = "SCORM Player | <?=$errorMessage?>";
	    // make menu available and controls available?
        try{parent.doDisableControls(true);}
        catch(error){}                 
        try{parent.getEl('loading').remove();}
        catch(error){}
	    parent.doShowHideMenu(true);
	    parent.doDisableControlName("previous", false);
	    parent.doDisableControlName("exit", false);
    }

    function doDivHideShow(str_Id, b_Visible){
        var obj_El = document.getElementById(str_Id);
        if(b_Visible){
            obj_El.style.visibility = "visible";
        }
        else{
            obj_El.style.visibility = "hidden";
        }
    }

    function doStart(){
        parent.doInit();
    }
    
    function doCurrent(){
        parent.doCurrent();
    }
    
    function doExitAll(){
        parent.doExitAll();
    }
    
    function doReStart(){
        parent.doInit();
    }
    
    function doPrevious(){
        parent.doPrevious();
    }

    function doClose(){
        top.close();
    }
    
    var b_Visible = false;
    function doHideShowDetails(){
        if(b_Visible){b_Visible = false;}
        else{b_Visible = true;}
        
        doDivHideShow("error", b_Visible);
    }
//]]>
    </script>

</head>
<body onload="doLoad();">
    <h3>
        <?=$errorMessage?>
    </h3>
    <p><br /></p>
    <div class="col">
        <div class="block" id="current">
            <div class="block-body">
                <table cellpadding="10">
                    <tr>
                        <td>
                            <div class="buttonCurrent">
                                <a href="#" onclick="doCurrent();return false;"><span>
                                    <?=$CURRENT?>
                                </span></a>
                            </div>
                        </td>
                        <td>&nbsp;
                            </td>
                        <td>
                            <span class="bold">
                                <?=$CURRENT?>.
                            </span>
                            <?=$CURRENT_TOOLTIP?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="block" id="previous">
            <div class="block-body">
                <table cellpadding="10">
                    <tr>
                        <td>
                            <div class="buttonPrevious">
                                <a href="#" onclick="doPrevious();return false;"><span>
                                    <?=$BACK?>
                                </span></a>
                            </div>
                        </td>
                        <td>&nbsp;
                            </td>
                        <td>
                            <span class="bold">
                                <?=$BACK?>.
                            </span>
                            <?=$BACK_TOOLTIP?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="block" id="exitAll">
            <div class="block-body">
                <table>
                    <tr>
                        <td>
                            <div class="buttonExitAll">
                                <a href="#" onclick="doExitAll();return false;"><span>
                                    <?=$EXIT_ALL?>
                                </span></a>
                            </div>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <span class="bold">
                                <?=$EXIT_ALL?>.
                            </span>
                            <?=$EXIT_ALL_TOOLTIP?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="block" id="reStart">
            <div class="block-body">
                <table>
                    <tr>
                        <td>
                            <div class="buttonStart">
                                <a href="#" onclick="doReStart();return false;"><span>
                                    <?=$START?>
                                </span></a>
                            </div>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <span class="bold">
                                <?=$START?>.
                            </span>
                            <?=$START_TOOLTIP?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <p><br />
        <img src="extjs/resources/images/<?=$_SESSION["skinID"]?>/activelms/about_16.gif" width="16" height="16" alt="Lang.Text(LanguageTerm.ABOUT?>"/>
        <a href="#" onclick="doHideShowDetails();return false;"><?=$ABOUT?></a>&nbsp;"<?=$errorMessage?>..."<br /><br /></p>
        <div id="error" style="visibility: hidden;">
        <table border="0" width="640">
            <tr>
                <td nowrap="nowrap" valign="top"><b>Description:</b></td>
                <td>&nbsp;</td>
                <td><?=$errorDescription?></td>
            </tr>
            <tr>
                <td nowrap="nowrap" valign="top"><b>File Name:</b></td>
                <td>&nbsp;</td>
                <td><?=$errorFileName?></td>
            </tr>
            <tr>
                <td nowrap="nowrap" valign="top"><b>Line:</b></td>
                <td>&nbsp;</td>
                <td><?=$errorLineNumber?></td>
            </tr>
            <tr>
                <td nowrap="nowrap" valign="top"><b>Error Message:</b></td>
                <td>&nbsp;</td>
                <td><?=$errorMessage?></td>
            </tr>
            <tr>
                <td nowrap="nowrap" valign="top"><b>Error Type:</b></td>
                <td>&nbsp;</td>
                <td><?=$errorName?></td>
            </tr>
            <tr>
                <td nowrap="nowrap" valign="top"><b>Error Number:</b></td>
                <td>&nbsp;</td>
                <td><?=$errorNumber?></td>
            </tr>
            <tr>
                <td nowrap="nowrap" valign="top"><b>Trace:</b></td>
                <td>&nbsp;</td>
                <td><?=$errorStack?></td>
            </tr>
        </table>
        </div>
    </div>
</body>
</html>
