<?php
error_reporting(E_ERROR);
session_start();
include_once "languages/ApplicationErrors.php";
include_once "languages/ApplicationResources.php";
include_once "languages/ApplicationResources_en_US.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>LMSEnd</title>
<link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/<?=$_SESSION["skinID"]?>/interstitial.css"/>

<!-- Ext JS UI -->
<script type="text/javascript" src="skins/extjs/adapter/yui/yui-utilities.js"><![CDATA[]]></script>
<script type="text/javascript" src="skins/extjs/adapter/yui/ext-yui-adapter.js"><![CDATA[]]></script>
<!--script type="text/javascript" src="skins/extjs/adapter/ext/ext-base.js"><![CDATA[]]></script-->
<script type="text/javascript" src="skins/extjs/ext-all.js"><![CDATA[]]></script>

<!-- Page Script -->
<script type="text/javascript" language="JavaScript">
//<![CDATA[
function doLoad(){
//parent.document.title = "<?=$PAGE_END_TITLE?>";

// make menu available and controls available?
parent.doDisableControls(true);
parent.doShowHideMenu(true);


//if(!parent.ICN_MODEL.get("isDisabledForSuspendAll")){
var b_IsDisabledForSuspendAll = true;
if(!b_IsDisabledForSuspendAll){
var obj_El = Ext.get("suspendAll");
obj_El.setVisible(true);
}
else{
var obj_El = Ext.get("suspendAll");
obj_El.remove();
}

//if(!parent.ICN_MODEL.get("isDisabledForAbandonAll")){
var b_IsDisabledForAbandonAll = true;
if(!b_IsDisabledForAbandonAll){
var obj_El = Ext.get("abandonAll");
obj_El.setVisible(true);
}
else{
var obj_El = Ext.get("abandonAll");
obj_El.remove();
}
}

function doExitAll(){
parent.doExitAll();
}

function doSuspendAll(){
parent.doSuspendAll();
}

function doAbandonAll(){
parent.doAbandonAll();
}

function doChoice(){
doExpandToChildren(parent.obj_TreePanel.getRootNode());
parent.doExpandRegion("west", true);
parent.doHighlightMenu();
}

function doExpandToChildren(obj_Node){
var arr_ChildNodes = obj_Node.childNodes;
if(arr_ChildNodes && arr_ChildNodes.length && arr_ChildNodes.length >0){
obj_Node.expand(false, true); 
}
}

function doExpandToFirstLeaf(obj_Node){

var arr_ChildNodes = obj_Node.childNodes;
if(arr_ChildNodes && arr_ChildNodes.length && arr_ChildNodes.length >0){
obj_Node.expand(false, true);
var int_Count = arr_ChildNodes.length;
for(var i=0; i<int_Count; i++){
var b_Leaf = doExpandToFirstLeaf(arr_ChildNodes[i]);
if(b_Leaf){
break;
}
}
}
else{
return true;
}
}

//]]>
</script>
</head>
<body onload="doLoad();">
<h3><?=$PAGE_END_TITLE?></h3>
<p><br /></p>
<p><?=$PAGE_END_MSG_0?></p>
<div class="col">
<div class="block" id="exitAll">
<div class="block-body">
<table>
<tr>
<td>
<div class="buttonExitAll">
<a href="#" onclick="doExitAll();return false;">
<span><?=$EXIT_ALL?></span>
</a>
</div>
</td>
<td>&nbsp;</td>
<td>
<span class="bold"><?=$EXIT_ALL?></span>. <?=$EXIT_ALL_TOOLTIP?>
</td>
</tr>
</table>
</div>
</div>
<div class="block" id="choice">
<div class="block-body">
<table>
<tr>
<td>
<div class="buttonChoice">
<a href="#" onclick="doChoice();">
<span><b><?=$CHOICE?></b></span>
</a>
</div>
</td>
<td>&nbsp;</td>
<td>
<span class="bold"><?=$CHOICE?></span>. <?=$CHOICE_TOOLTIP?>
</td>
</tr>
</table>
</div>
</div>
<div class="block" id="suspendAll" style="visibility: hidden;">
<div class="block-body">
<table>
<tr>
<td>
<div class="buttonSuspendAll">
<a href="#" onclick="doSuspendAll();return false;">
<span><?=$SUSPEND_ALL?></span>
</a>
</div>
</td>
<td>&nbsp;</td>
<td class="disabled">
<span class="bold"><?=$SUSPEND_ALL?></span>. <?=$SUSPEND_ALL_TOOLTIP?>
</td>
</tr>
</table>
</div>
</div>
<div class="block" id="abandonAll" style="visibility: hidden;">
<div class="block-body">
<table>
<tr>
<td>
<div class="buttonAbandonAll">
<a href="#" onclick="doAbandonAll();return false;">
<span><?=$ABANDON_ALL?></span>
</a>
</div>
</td>
<td>&nbsp;</td>
<td class="disabled">
<span class="bold"><?=$ABANDON_ALL?></span>. <?=$ABANDON_ALL_TOOLTIP?>
</td>
</tr>
</table>
</div>
</div>
</div>
</body>
</html>

