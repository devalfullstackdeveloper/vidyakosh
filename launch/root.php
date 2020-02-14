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
    <title>LMSEnd</title>
    <link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/ext-all.css">
    <link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/<?=$_SESSION["skinID"]?>/interstitial.css">
    <!-- Page Script -->

    <script type="text/javascript" language="JavaScript">
//<![CDATA[
function doLoad(){
	if(window.opener){
		window.document.title = "<?=$PAGE_ROOT_TITLE?>";
		doDivHideShow("closeWindow", true);
	}
	else if(window.parent){
    	doDivHideShow("closeWindow", false);
    	try{
			parent.doComboDisable();
			parent.doExpandRegion("west", false);//collapse the menu
			parent.doShowHideMenu(false);
    	}
    	catch(e){}
	}
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

function doClose(){
top.close();
//parent.opener.focus();
}
//]]>
    </script>

</head>
<body onload="doLoad();">
    <h3>
        <?=$PAGE_ROOT_TITLE?>
    </h3>
    <p>
        <br>
    </p>
    <p>
        <?=$PAGE_ROOT_MSG_0?>
    </p>
    <div class="col">
        <div class="block" id="closeWindow" style="visibility: hidden;">
            <div class="block-body">
                <table>
                    <tr>
                        <td>
                            <div class="buttonWindowClose">
                                <a href="#" onclick="doClose();return false;"><span>
                                    <?=$CLOSE?>
                                </span></a>
                            </div>
                        </td>
                        <td>&nbsp;
                            </td>
                        <td>
                            <span class="bold">
                                <?=$CLOSE?>
                            </span>.
                            <?=$CLOSE_TOOLTIP?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
