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
<title>LMSTimeOut</title>
<link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/ext-all.css">
<link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/<?=$_SESSION["skinID"]?>/interstitial.css"><!-- Ext JS UI -->

<script type="text/javascript" src="skins/extjs/adapter/yui/yui-utilities.js">
<![CDATA[]]>
</script>
<script type="text/javascript" src="skins/extjs/adapter/yui/ext-yui-adapter.js">
<![CDATA[]]>
</script><!--script type="text/javascript" src="skins/extjs/adapter/ext/ext-base.js"><![CDATA[]]></script-->

<script type="text/javascript" src="skins/extjs/ext-all.js">
<![CDATA[]]>
</script>
<!-- Page Script -->
<script type="text/javascript" language="JavaScript">
//<![CDATA[
function doLoad(){
	if(window.opener){
		window.document.title = "<?=$PAGE_TIMEOUT_TITLE?>";
	}
	else if(window.parent){
    	try{
			parent.document.title = "<?=$PAGE_TIMEOUT_TITLE?>";
			parent.doComboDisable();
			parent.doExpandRegion("west", false);//collapse the menu
			parent.doShowHideMenu(false);
    	}
    	catch(e){}
	}
}
//]]>
</script>

</head>
<body onload="doLoad();">
<h3><?=$PAGE_TIMEOUT_TITLE?>
</h3>
    <p>
        <br>
    </p>
    <p>
        <?=$PAGE_TIMEOUT_MSG_0?>
    </p>
<div class="col">
<div class="block" id="userMessageDiv">
<div class="block-body">
<table>
	<tr>
		<td valign="top"><img
			src="skins/extjs/resources/images/<?=$_SESSION["skinID"]?>/activelms/timeout_48.gif"
			alt="alt message"
			width="48" height="48" /></td>
		<td>&nbsp;</td>
		<td valign="top" width="100%">
		<?=$PAGE_TIMEOUT_MSG_1?>&nbsp;<?=$Session.Timeout?>&nbsp;<?=$PAGE_TIMEOUT_MSG_2?>

		</td>
	</tr>
</table>
</div>
</div>
</div>
</body>
</html>
