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
<title>LMSInit</title>
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
</script><!-- Page Script -->

<script type="text/javascript" language="JavaScript">
//<![CDATA[
function doLoad(){

    var str_ScoID = parent.ICN_MODEL.get("itemID");
    if(str_ScoID){
        var obj_ActivityTree = parent.ICN_MODEL.get("activityTree");
	    var obj_Target = obj_ActivityTree.findByName(str_ScoID);
	    if(obj_Target){
            parent.doChoice(str_ScoID);
        }
        else{
            if(!parent.ICN_MODEL.get("isDisabledForResumeAll")){
                parent.doResumeAll();
            }
            else{
                parent.doStart();
            }
        }
    }   
    else{
        // make text available
        var obj_El = Ext.get("page.title");
        obj_El.setVisible(true);
    
        obj_El = Ext.get("page.msg");
        obj_El.setVisible(true);
    
        // make buttons available
        if(!parent.ICN_MODEL.get("isDisabledForResumeAll")){
            obj_El = Ext.get("resumeAll");
            obj_El.setVisible(true);
        }
        else{
            obj_El = Ext.get("resumeAll");
            obj_El.remove();
        }

        if(!parent.ICN_MODEL.get("isDisabledForStart")){
            obj_El = Ext.get("start");
            obj_El.setVisible(true);
        }
        else{
            obj_El = Ext.get("start");
            obj_El.remove();
        }

        if(!parent.ICN_MODEL.get("isDisabledForMenu")){
            obj_El = Ext.get("choice");
            obj_El.setVisible(true);
        }
        else{
            obj_El = Ext.get("choice");
            obj_El.remove();
        }
    }
}

function doStart(){
    parent.doStart();
}

function doResumeAll(){
    parent.doResumeAll();
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
<h3 id="page.title" style="visibility:hidden;"><?=$PAGE_INIT_TITLE?></h3>
<p><br/></p>
<p id="page.msg" style="visibility:hidden;"><?=$PAGE_INIT_MSG_0?></p>
<div class="col">
<div class="block" id="resumeAll" style="visibility: hidden;">
<div class="block-body">
<table cellpadding="10">
<tr>
<td>
<div class="buttonResumeAll"><a href="#" onclick="doResumeAll();return false;"><span><?=$RESUME?></span></a></div>
</td>
<td>&nbsp;</td>
<td><span class="bold"><?=$RESUME?></span>. <?=$RESUME_TOOLTIP?></td>
</tr>
</table>
</div>
</div>
<div class="block" id="start" style="visibility: hidden;">
<div class="block-body">
<table>
<tr>
<td>
<div class="buttonStart"><a href="#" onclick="doStart();return false;"><span><?=$START?></span></a></div>
</td>
<td>&nbsp;</td>
<td><span class="bold"><?=$START?></span>. <?=$START_TOOLTIP?></td>
</tr>
</table>
</div>
</div>
<div class="block" id="choice" style="visibility: hidden;">
<div class="block-body">
<table>
<tr>
<td>
<div class="buttonChoice"><a href="#" onclick="doChoice();"><span><b><?=$CHOICE?></b></span></a></div>
</td>
<td>&nbsp;</td>
<td><span class="bold"><?=$CHOICE?></span>. <?=$CHOICE_TOOLTIP?></td>
</tr>
</table>
</div>
</div>
</div>
</body>
</html>
