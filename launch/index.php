<?php
include_once "globals.php";
include_once "languages/ApplicationErrors.php";
include_once "languages/ApplicationResources.php";
include_once "languages/ApplicationResources_en_US.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<!-- Mimic Internet Explorer 8 -->
<meta http-equiv="X-UA-Compatible" content="IE=8" >
<meta http-equiv="Content-Type" content="text/html; charset=US-ASCII">
<title><?=APP_NAME?></title>
<link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/ext-all.css">
<link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/<?=$_SESSION["skinID"]?>/interstitial.css">
<?php if ($skinID != "default"){ ?>
<link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/ytheme-<?=$_SESSION["skinID"]?>.css">
<?php } ?>
<style type="text/css">
html,body {
        margin: 0;
        padding: 0;
        border: 0 none;
        overflow: hidden;
        height: 100%;
}

.not-attempted-node .x-tree-node-icon{background:url('skins/extjs/resources/images/<?=$_SESSION["skinID"]?>/activelms/activity_16.gif') no-repeat;}
.incomplete-node .x-tree-node-icon{background:url('skins/extjs/resources/images/<?=$_SESSION["skinID"]?>/activelms/activity_incomplete_16.gif') no-repeat;}
.completed-node .x-tree-node-icon{background:url('skins/extjs/resources/images/<?=$_SESSION["skinID"]?>/activelms/activity_completed_16.gif') no-repeat;}

</style>
<!-- Sarissa -->
<script type="text/javascript" language="JavaScript" src="js/sarissa.js">
<![CDATA[]]>
</script>

<!-- webtoolkit-->
<script type="text/javascript" language="JavaScript" src="js/webtoolkit.base64.js">
<![CDATA[]]>
</script>

<!-- activelms RTE -->
<script type="text/javascript" language="JavaScript" src="js/other_utils.js">
<![CDATA[]]>
</script>
<script type="text/javascript" language="JavaScript" src="js/main_203.js">
<![CDATA[]]>
</script>
<script type="text/javascript" language="JavaScript" src="js/utils.js">
<![CDATA[]]>
</script>
<script type="text/javascript" language="JavaScript" src="js/master.js">
<![CDATA[]]>
</script>
<script type="text/javascript" language="JavaScript" src="js/engine.js">
<![CDATA[]]>
</script><!-- Ext JS UI -->

<script type="text/javascript" src="skins/extjs/adapter/yui/yui-utilities.js">
<![CDATA[]]>
</script>
<script type="text/javascript" src="skins/extjs/adapter/yui/ext-yui-adapter.js">
<![CDATA[]]>
</script><!--script type="text/javascript" src="skins/extjs/adapter/ext/ext-base.js"><![CDATA[]]></script-->

<script type="text/javascript" src="skins/extjs/ext-all.js">
<![CDATA[]]>
</script>
<script type="text/javascript">
 
        var str_Text = undefined;
        var str_Tooltip = undefined;
                
        function doEscape(str_Target){
            str_Target = str_Target.split("'").join("\'");
            return str_Target.split("%27").join("\'");
        }
        
        // Declare the UI widgets
        var obj_ToolBar = undefined;
        var obj_ButtonPrevious = undefined;
        var obj_ButtonContinue = undefined;
        var obj_ButtonExit = undefined;
        var obj_ButtonAbout = undefined;
        var obj_OrgCombo  = undefined;
        var obj_TreePanel  = undefined;
        var obj_AboutDlg  = undefined;
        var layout = undefined;
        
        // UI
        var b_IsSetToLaunch = <?=$isSetToLaunch?>;
        var b_IsSetToStyleDialogs = <?=$isSetToStyleDialogs?>;
        var b_IsSetToTerminate = <?=$isSetToTerminate?>;
        var b_UIOrgs = <?=$uiOrgs?>;
        var b_UIBack = <?=$uiBack?>;
        var b_UINext = <?=$uiNext?>;
        var b_UIExit = <?=$uiExit?>;
        var b_UIAbandon = <?=$uiAbandon?>;
        var b_UIAbandonAll = <?=$uiAbandonAll?>;
        var b_UIAbout = <?=$uiAbout?>;
        var b_UIPrint = <?=$uiPrint?>;
        var b_UIToolbar = <?=$uiToolbar?>;
        var b_UITree = <?=$uiTree?>;
        var b_UIBlank = <?=$uiBlank?>;
        var b_UIMinimal = <?=$uiMinimal?>;
                
        var b_ToolbarCollapsed = true;
        if(b_UIToolbar){b_ToolbarCollapsed = false;}
        var b_TreeCollapsed = true;
        if(b_UITree){b_TreeCollapsed = false;}
        var b_TreeHidden = false;
        var b_ToolbarHidden = false;
        var b_ToolbarTitlebar = true;
        var int_ToolBarSize = 50;
        if(b_UIMinimal){
            b_TreeHidden = true;
            b_ToolbarHidden = true;
            b_ToolbarTitlebar = false;
            int_ToolBarSize = 0;
        }
                
        // Build the UI
        var Player = function(){
            return {
                init : function(){
                    // Required for tool tips
                    Ext.QuickTips.init();
                    if(b_UIBlank){
                        layout = new Ext.BorderLayout(document.body, {
                            center: {
                                autoScroll: false,
                                fitToFrame:true
                            }
                        });
                    }
                    else{
                        layout = new Ext.BorderLayout(document.body, {
                            north: {
                                hidden: b_ToolbarHidden,
                                split:false,
                                initialSize: int_ToolBarSize,
                                titlebar: b_ToolbarTitlebar,
                                collapsible: true,
                                collapsed: b_ToolbarCollapsed
                            },
                            west: {
                                hidden: b_TreeHidden,
                                split:true,
                                initialSize: 200,
                                titlebar: true,
                                collapsible: true,
                                autoScroll: true,
                                collapsed: b_TreeCollapsed,
                                minSize: 100,
                                maxSize: 400
                            },
                            center: {
                                autoScroll: false,
                                fitToFrame:true
                            }
                        });
                    }
                    layout.beginUpdate();
                        
                    // Start the toolbar
                    obj_ToolBar = new Ext.Toolbar('toolBar');
                    // Previous Button
                    str_Text = doEscape("<?=$BACK?>");
                    str_Tooltip = doEscape("<?=$BACK_TOOLTIP?>");
                    var obj_Button = {
                        id: 'previous',
                        icon: 'skins/extjs/resources/images/<?=$_SESSION["skinID"]?>/activelms/nav_left_16.gif',
                        cls: 'x-btn-text-icon',
                        text: str_Text,
                        tooltip: str_Tooltip,
                        disabled: false,
                        minWidth: 65,
                        handler: onButtonClick
                    };
                    obj_ButtonPrevious = new Ext.Toolbar.Button(obj_Button);
                    // Next Button
                    str_Text = doEscape("<?=$NEXT?>");
                    str_Tooltip = doEscape("<?=$NEXT_TOOLTIP?>");
                    obj_Button = {
                        id: 'continue',
                        icon: 'skins/extjs/resources/images/<?=$_SESSION["skinID"]?>/activelms/nav_right_16.gif',
                        cls: 'x-btn-text-icon',
                        text: str_Text,
                        tooltip: str_Tooltip,
                        disabled: false,
                        minWidth: 65,
                        handler: onButtonClick
                    };
                    obj_ButtonContinue = new Ext.Toolbar.Button(obj_Button);
                    // Exit Button
                    str_Text = doEscape("<?=$EXIT?>");
                    str_Tooltip = doEscape("<?=$EXIT_TOOLTIP?>");
                    obj_Button = {
                        id: 'exit',
                        icon: 'skins/extjs/resources/images/<?=$_SESSION["skinID"]?>/activelms/nav_exit_16.gif',
                        cls: 'x-btn-text-icon',
                        text: str_Text,
                        tooltip: str_Tooltip,
                        disabled: false,
                        minWidth: 65,
                        handler: onButtonClick
                     };
                     obj_ButtonExit = new Ext.Toolbar.Button(obj_Button);

                     // Combobox for multiple organizations
                     var arr_Data = [];
                     var store = new Ext.data.SimpleStore({
                        fields: ['identifier', 'title'],
                        data : arr_Data
                     });
                        
                    str_Text = doEscape("<?=$LOADING?>...");
                    obj_OrgCombo = new Ext.form.ComboBox({
                        id: 'organizations',
                        store: store,
                        valueField:'identifier',
                        displayField: 'title',
                        typeAhead: true,
                        mode: 'local',
                        triggerAction: 'all',
                        emptyText: str_Text,
                         selectOnFocus: true,
                        forceSelection: true,
                        grow: true,
                        shadow: "frame"
                    });
                    obj_OrgCombo.addListener("focus", onComboFocus);
                    obj_OrgCombo.addListener("blur", onComboBlur);
                    obj_OrgCombo.addListener("select", onComboSelect);
                    // Build the tool bar
                    obj_ToolBar.add('-');         
                    if(b_UIOrgs){
                        obj_ToolBar.addField(obj_OrgCombo);
                        obj_ToolBar.add('-'); 
                    }       
                    if(b_UIBack){obj_ToolBar.add(obj_ButtonPrevious);}
                    if(b_UINext){obj_ToolBar.add(obj_ButtonContinue);}
                    if(b_UIExit){obj_ToolBar.add(obj_ButtonExit);}
                    obj_ToolBar.add('-'); 
                    var str_Mode = doEscape("<?=$mode?>"); 
                    if(str_Mode != "normal"){
                        var obj_TextItemMode = new Ext.Toolbar.TextItem("  Lesson Mode: "  + str_Mode);
                        obj_ToolBar.add(obj_TextItemMode); 
                    }
                    
                    // Start the tree panel
                    obj_TreePanel = new Ext.tree.TreePanel('treePanel', {
                        animate:false, 
                        enableDD:false,
                        containerScroll:true,
                        rootVisible:false
                    });
                    // Add a root we can append and remove trees to
                    var obj_Node = {};
                    obj_TreePanel.setRootNode(new Ext.tree.TreeNode(obj_Node));
                    // Add the toolbar to the north panel
                    str_Text = doEscape("<?=$playerTitle?>");
                    // Add the north and west panels only when blank is false;
                    if(!b_UIBlank){
                        // Add the toolbar to the north panel 
                        layout.add(
                            'north', 
                             new Ext.ContentPanel('header', {
                             title: str_Text, 
                             toolbar: obj_ToolBar}));             
                        // Add the tree menu to the west panel  
                        layout.add(
                            'west', 
                            new Ext.ContentPanel('course', {}));
                     }        
                     // Add the main iFrame to the centre panel
                     center = layout.getRegion('center');
                     center.add(new Ext.ContentPanel('main', {fitToFrame:true}));
                     layout.restoreState();
                     layout.endUpdate();
                     // Make the content frame visible
                     var obj_Main = document.getElementById("main");
                     obj_Main.style.visibility="visible";

                     // Remove the loading indicator 
                     var obj_Loading = Ext.get('loading');
                     if(obj_Loading){obj_Loading.remove();}
                     
                                        // All UI is now built, so invoke the sequencing and services
                    window.doInit();
                    }
                };
            }();

            Ext.EventManager.onDocumentReady(Player.init, Player, true);
            
        function onButtonClick(obj_Button){
                switch(obj_Button.id){
                        case "previous":doPrevious();break;
            case "continue":doContinue();break;
            case "exit":doExitAll();break;
            default:
        }
    }
        
        var obj_Player;
        var obj_PlayerUI;
        function doInit(){
                if(Ext.isIE || Ext.isGecko || Ext.isSafari){
                        obj_PlayerUI = new activelms.PlayerUI(this.window);
                        obj_Player = new activelms.Player(
                                this.window, 
                                this.window, 
                                document.getElementById("main"),
                                obj_PlayerUI,
                                false); 
                        obj_Player.onPlayerInit = window.onPlayerInit;
                        obj_Player.doInit();
                }
                else{
                        this.location = "browserError.html";
                }
        }
        
        // Player UI
        function onPlayerInit(obj_View,str_Url){obj_PlayerUI.updateUI(obj_View,str_Url);}
        function doExpandRegion(str_RegionName, b_Expand){obj_PlayerUI.expandRegion(str_RegionName, b_Expand);}
        function doHighlightMenu(){obj_PlayerUI.highlightMenu();}
        function doEvaluateCurrentAndActive(){obj_PlayerUI.doEvaluateCurrentAndActive();}
        function doEvaluateCompletionStatus(){obj_PlayerUI.doEvaluateCompletionStatus();}
        function doEvaluateHidden(){obj_PlayerUI.doEvaluateHidden();}
        function doEvaluateDisabled(){obj_PlayerUI.doEvaluateDisabled();}
        function doEvaluateHiddenAndDisabled(f_ScormVersion){obj_PlayerUI.doEvaluateHiddenAndDisabled(f_ScormVersion);}
        function doDisableControls(b_Disable){obj_PlayerUI.disableControls(b_Disable);}
        function doDisableControlName(str_ControlName, b_Disable){obj_PlayerUI.doDisableControlName(str_ControlName, b_Disable);}
        function doSetCompletionStatus(str_Identifier, b_ProgressStatus, b_CompletionStatus){
            obj_PlayerUI.doSetCompletionStatus(str_Identifier, b_ProgressStatus, b_CompletionStatus);}
        function doShowHideMenu(b_Show){obj_PlayerUI.showMenu(b_Show);}
        function doShowView(obj_View, str_Url){obj_PlayerUI.showView(obj_View, str_Url);}
        function doUpdateProgress(str_Message, int_Percent){obj_PlayerUI.updateProgress(str_Message, int_Percent);}
        function onClusterNodeClick(obj_TreeNode){obj_PlayerUI.onClusterNodeClick(obj_TreeNode);}
        function onLeafNodeClick(obj_TreeNode){obj_PlayerUI.onLeafNodeClick(obj_TreeNode);}
        function onBeforeClusterNodeExpand(obj_TreeNode){obj_PlayerUI.onBeforeClusterNodeExpand(obj_TreeNode);}
        function doComboDisable(){obj_PlayerUI.comboDisable();}
        function onComboSelect(obj_Combo, obj_Record, int_Index){obj_PlayerUI.onComboSelect(obj_Combo, obj_Record, int_Index);}
        function onComboFocus(obj_TreeNode){}
        function onComboBlur(){} 
        
        // Player MVC
        function checkSessionExpiration(){obj_Player.checkSessionExpiration();}
        function doTerminate(){obj_Player.doTerminate();}
        function doOrganizations(str_TargetOrgID){obj_Player.doOrganizations(str_TargetOrgID);}
        function doStart(){obj_Player.doStart();}
        function doPrevious(){obj_Player.doPrevious();}
        function doContinue(){obj_Player.doContinue();}
        function doCurrent(){obj_Player.doCurrent();}
        function doChoice(str_ScoID){obj_Player.doChoice(str_ScoID);}
        function doJump(str_ScoID){obj_Player.doJump(str_ScoID);}
        function doExit(){obj_Player.doExit();}
        function doAbandon(){obj_Player.doAbandon();}
        function doAbandonAll(){obj_Player.doAbandonAll();}
        function doResumeAll(){obj_Player.doResumeAll();}
        function doSuspendAll(){obj_Player.doSuspendAll();}
        function doExitAll(){obj_Player.doExitAll();}
        function doUnloadMain(){obj_Player.unloadMain();}
        function doTerminate(){obj_Player.doTerminate();}
            
            
    // Messages for activelms.AjaxClient
    ICN_XML_HTTP_STATUS_0 = doEscape("<?=$XML_HTTP_STATUS_0?>");
    ICN_XML_HTTP_STATUS_1 = doEscape("<?=$XML_HTTP_STATUS_1?>");
    ICN_XML_HTTP_STATUS_2 = doEscape("<?=$XML_HTTP_STATUS_2?>");
    ICN_XML_HTTP_STATUS_3 = doEscape("<?=$XML_HTTP_STATUS_3?>");
    ICN_XML_HTTP_STATUS_4 = doEscape("<?=$XML_HTTP_STATUS_4?>");
    ICN_XML_HTTP_STATUS_5 = doEscape("<?=$XML_HTTP_STATUS_5?>");
        
    // Mesages for confirm dialog
    ICN_CONFIRM_ABANDON = doEscape("<?=$CONFIRM_MSG_1?>");
    ICN_CONFIRM_SUSPEND_ALL = doEscape("<?=$CONFIRM_MSG_2?>");
    ICN_CONFIRM_ABANDON_ALL = doEscape("<?=$CONFIRM_MSG_3?>");
        ICN_CONFIRM_UNLOAD = doEscape("<?=$CONFIRM_UNLOAD?>");
        ICN_CONFIRM_TITLE = doEscape("<?=$CONFIRM_TITLE?>");
        ICN_CONFIRM_MSG_0 = doEscape("<?=$CONFIRM_MSG_0?>");
    ICN_PROGRESS_TITLE = doEscape("<?=$PROGRESS_TITLE?>");
        ICN_PROGRESS_MSG_0 = doEscape("<?=$PROGRESS_MSG_0?>"); 
        ICN_PROGRESS_MSG_1 = doEscape("<?=$PROGRESS_MSG_1?>");
        ICN_PROGRESS_MSG_2 = doEscape("<?=$PROGRESS_MSG_2?>");
        ICN_LOADING_MSG = doEscape("<?=$LOADING?>");
        
	Console.WriteLine(<?=$PROGRESS_MSG_1?>);
	
        // XML Http Request
    ICN_XML_HTTP_REQ = new XMLHttpRequest();
    
    // Logging level - set in configuration web.config;
    var log = new activelms.Logger(activelms.Logger.<?=$ajaxLogLevel?>, activelms.Logger.POPUP_LOGGER);
        
    // Add values to the model from the host LMS
    ICN_MODEL = new activelms.Model();

                // Mandatory parameters
                ICN_MODEL.put("domainID", "<?=$domainID?>");
                ICN_MODEL.put("learnerID", "<?=$learnerID?>");
                ICN_MODEL.put("courseID", "<?=$courseID?>");
                
                // Optional parameters
                ICN_MODEL.put("learnerName", "<?=$learnerName?>");
                ICN_MODEL.put("orgID", "<?=$orgID?>");
                 ICN_MODEL.put("itemID", "<?=$itemID?>");
                ICN_MODEL.put("sessionID", "<?=$sessionID?>");
                ICN_MODEL.put("skinID", "<?=$_SESSION["skinID"]?>");
                ICN_MODEL.put("culture", "<?=$culture?>");
                ICN_MODEL.put("mode", "<?=$mode?>");
        
     // Add values to the model from the configuration files
     ICN_MODEL.put("CMIRunEndPoint","<?=$endPointCMIRun?>");
     ICN_MODEL.put("SSRunEndPoint","<?=$endPointSSRun?>");
     ICN_MODEL.put("LCMSEndPoint","<?=$endPointLCMS?>");
     
     // Additional elements to support Java and .NET Edition
     ICN_MODEL.put("resourceResolverUrl","<?=$resourceResolverUrl?>");
     ICN_MODEL.put("viewInitUrl","<?=$viewInitUrl?>");
     ICN_MODEL.put("viewEndUrl","<?=$viewEndUrl?>");
     ICN_MODEL.put("viewRootUrl","<?=$viewRootUrl?>");
     ICN_MODEL.put("viewUnloaderUrl","<?=$viewUnloaderUrl?>");
     ICN_MODEL.put("viewTimeOutUrl","<?=$viewTimeOutUrl?>");
     ICN_MODEL.put("ajaxErrorUrl","<?=$ajaxErrorUrl?>?");
     
     // Add values to the model from the configuration files
     ICN_MODEL.put("syncClientServer", "<?=$syncClientServer?>");
     ICN_MODEL.put("isBeforeUnloadPromptEnabled", Boolean(<?=$isBeforeUnloadPromptEnabled?>));
     ICN_MODEL.put("isTimeoutEnabled", Boolean(<?=$isTimeoutEnabled?>));
     ICN_MODEL.put("isDebugAjax", Boolean(<?=$isDebugAjax?>));
     ICN_MODEL.put("isAsyncAjax",Boolean(<?=$isAsyncAjax?>));
     ICN_MODEL.put("isSetToLaunch",Boolean(<?=$isSetToLaunch?>));
     ICN_MODEL.put("skinDirID", "<?=$skinDirID?>");
     ICN_MODEL.put("sessionMonitorUrl", "<?=$sessionMonitorUrl?>");
                
     // Add values to the model from the server and request
     ICN_MODEL.put("maxInactiveInterval","<?=$maxInactiveInterval?>");
     ICN_MODEL.put("context", "<?=$context?>");
     
     // Support for CHOICE navigation request
     if(ICN_MODEL.get("itemID") != ""){
        ICN_MODEL.put("isSetToLaunch",false);
     }
     
     Ext.BLANK_IMAGE_URL = "skins/extjs/resources/s.gif";
     
</script>
</head>
<body scroll="no" style="background-color:Gray">
<!-- The splash screen. Include everything after the splash screen -->
<div id="loading">
<div class="loading-indicator"><span id="loading-message"><?=$LOADING?>...</span></div>
</div>
<!-- Header, North -->
<div id="header" class="x-layout-inactive-content">
<div id="toolBar"></div>
</div>
<!-- Course, West -->
<div id="course" class="x-layout-inactive-content">
<div id="treePanel" style="visibility: hidden;"></div>
</div>
<!-- Content, Center -->
<iframe src="" name="main" id="main" style="visibility:hidden;"></iframe> <!-- Hidden session expiration frame -->
<iframe src="" name="session" id="session" style="visibility: hidden; width: 1px; height: 1px;"></iframe> <script type="text/javascript" language="JavaScript" src="js/cmi.js">
<![CDATA[]]>
</script><script type="text/javascript" language="JavaScript" src="js/scorm2004.js">
<![CDATA[]]>
</script><script type="text/javascript" language="JavaScript" src="js/scorm1p2.js">
<![CDATA[]]>
</script>
</body>
</html>
 <?php
 ob_end_flush();
 ?>