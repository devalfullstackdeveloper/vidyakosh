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
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<title><?=APP_NAME?></title>
<link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/ext-all.css">
<link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/<?=$_SESSION["skinID"]?>/interstitial.css">
<link rel="stylesheet" type="text/css" href="skins/extjs/resources/css/ytheme-<?=$_SESSION["skinID"]?>.css">
<style type="text/css">
                html, body {
            margin:0;
            padding:0;
            border:0 none;
            overflow:hidden;
            height:100%;
        }
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
<script type="text/javascript" language="JavaScript" src="js/main.js">
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
</script>
<script type="text/javascript" language="JavaScript" src="js/cmi.js">
<![CDATA[]]>
</script>
<script type="text/javascript" language="JavaScript" src="js/scorm2004.js">
<![CDATA[]]>
</script>
<script type="text/javascript" language="JavaScript" src="js/scorm1p2.js">
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
                
        // Declare constants
        var ICN_ACTION_EXECUTED = false;
 
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
                    var str_Mode = doEscape(<?=$mode?>); 
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
                    str_Text = doEscape(<?=$playerTitle?>);
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
            
       var f_Progress = 0.0;
       function doShowProgress(){
            if(b_UIMinimal){return;}
            str_Text = doEscape("<?=$PROGRESS_TITLE?>");
            str_Tooltip = doEscape("<?=$PROGRESS_MSG_0?>");
            
            Ext.Msg.show({
                title: str_Text,
                msg: str_Tooltip,
                width:380,
                progress:true,
                closable:false
                });
                
            str_Tooltip = doEscape("<?=$PROGRESS_MSG_1?>");
            doUpdateProgress(str_Tooltip);
        }
            
        function doUpdateProgress(str_Message, int_Percent){
            if(b_UIMinimal){return;}
            if(int_Percent){f_Progress = (int_Percent/100);}
            else{
                f_Progress += 0.1;
                if(f_Progress > 1.0){f_Progress = 0.1;}
            }
            Ext.Msg.updateProgress(f_Progress, str_Message);
        }

        function doHideProgress(){
            if(b_UIMinimal){return;}
            f_Progress = 0.9;
            str_Tooltip = doEscape("<?=$PROGRESS_MSG_2?>");
            doUpdateProgress(str_Tooltip);
            Ext.Msg.hide();
        }
        
        function doShowHideMenu(b_Show){
                var obj_TreePanelDiv = document.getElementById("treePanel");
            if(b_Show){
                //var obj_TreePanelRootNode = obj_TreePanel.getRootNode();
                //obj_TreePanelRootNode.expand();
                obj_TreePanelDiv.style.visibility="visible";
            }
            else{
                obj_TreePanelDiv.style.visibility="hidden";
                //var obj_TreePanelRootNode = obj_TreePanel.getRootNode();
                //obj_TreePanelRootNode.collapse();

            }
        }

        function doHighlightMenu(){
            var el_TreePanel = Ext.get("treePanel");
                        el_TreePanel.highlight();
        }
        
        function doExpandRegion(str_RegionID, b_Expand){
            var obj_Region = layout.getRegion(str_RegionID);
            if(obj_Region){
                if(b_Expand){
                    obj_Region.show();
                    obj_Region.expand();
                }
                else{
                    obj_Region.collapse();
                }
            }
        }
        
        function doConfirm(str_Message, fn_Callback){

            if(b_IsSetToStyleDialogs){
                str_Text = doEscape("<?=$CONFIRM_TITLE?>");
                Ext.Msg.confirm(str_Text, str_Message, function(obj_Button){
                    if (obj_Button == 'yes'){
                        fn_Callback.call(this, true);
                    }
                    else{
                        fn_Callback.call(this, false);
                    }
                });
            }
            else{
                var b_Yes = confirm(str_Message);
                if (b_Yes){
                    fn_Callback.call(this, true);
                }
                else{
                    fn_Callback.call(this, false);
                }
            }
        }

            /**
             * Builds the drop down list of organizations
             * 
             * @param {Array} arr_Organizations the list of organizations
             * @param {String} str_OrgID the target organization
             */
        function buildOrganizationsView(arr_Organizations, str_OrgID){
        
            if(!b_UIOrgs){return;}
            
            obj_OrgCombo.setDisabled(true);
            var int_Count = arr_Organizations.length;
            var arr_Data = [int_Count];
            var obj_Organization;
            var str_Value;
            for(var i=0; i<int_Count; i++){
                obj_Organization = arr_Organizations[i];
                arr_Data[i] = [obj_Organization.getIdentifier(),obj_Organization.getTitle()];
                if(str_OrgID == obj_Organization.getIdentifier()){
                    str_Value = obj_Organization.getTitle();
                }
            }
           
                    obj_OrgCombo.store.removeAll();
                    obj_OrgCombo.store.loadData(arr_Data);
            obj_OrgCombo.setValue(str_Value);
            obj_OrgCombo.collapse();
            obj_OrgCombo.setDisabled(false);
        }
        
            function doComboDisable(){
            if(!b_UIOrgs){return;}
                obj_OrgCombo.collapse();
            obj_OrgCombo.setDisabled(true);
            }
        
            function onComboFocus(){
                //var obj_Main = document.getElementById("main");
                //obj_Main.style.visibility="hidden";
            }
            
            function onComboBlur(){
                //var obj_Main = document.getElementById("main");
                //obj_Main.style.visibility="visible";
            }
            
            function onComboSelect(obj_Combo, obj_Record, int_Index){

            if(!b_UIOrgs){return;}
                var str_TargetOrgID = obj_Record.get('identifier');
                var str_Title = obj_Record.get('title');
            var str_OrgID = ICN_MODEL.get("orgID");
            
            obj_Combo.collapse();
            if(str_OrgID == str_TargetOrgID){return;}
                
            // Confirm
            str_Text = doEscape("<?=$CONFIRM_TITLE?>");
            var str_Message = doEscape("<?=$CONFIRM_MSG_0?>");
            str_Message += ": " + doEscape(str_Title) + "?";
            
            if(b_IsSetToStyleDialogs){
                Ext.Msg.confirm(
                    str_Text,
                    str_Message,
                    function(obj_Button){
                        if (obj_Button == 'yes'){
                            // Add the target idenfifier to the model, and call the doInit method
                            doComboDisable();
                            window.doOrganizations(str_TargetOrgID);
                        }
                        else{
                            obj_Combo.collapse();
                            window.focus();
                        }
                    });
                }
                else{
                var b_Yes = confirm(str_Message);
                if (b_Yes){
                    doComboDisable();
                    window.doOrganizations(str_TargetOrgID);
                }
                else{
                   obj_Combo.collapse();
                   window.focus();
                }
                }
           }


            /**
             * Function to run when a toolbar button is clicked.
             * 
             * @param {Ext.Toolbar.Button} a toolbar button.
             */ 
        function onButtonClick(obj_Button){
            switch(obj_Button.id){
                case "previous":
                    doPrevious();
                break;
                case "continue":
                    doContinue();
                break;
                case "exit":
                    if(b_IsSetToLaunch){
                        doExitAll();
                    }
                    else{
                        doExit();
                    }
                break;
                default:
            }
        }
        
            /**
             * Function to run when a cluster node is clicked. The function
             * invokes a choice navigation event for the sequencing
             * engine and expands the child nodes of this node.
             * 
             * @param {Ext.tree.TreeNode} obj_TreeNode a tree node
             */  
        function onClusterNodeClick(obj_TreeNode){
           if(!obj_TreeNode.disabled){
                doChoice(obj_TreeNode.id);
            }
        }
                
            /**
             * Function to run when a leaf node is clicked. The function
             * invokes a choice navigation event for the sequencing
             * engine.
             * 
             * @param {Ext.tree.TreeNode} a tree node
             */        
        function onLeafNodeClick(obj_TreeNode){
            if(!obj_TreeNode.disabled){
                doChoice(obj_TreeNode.id);
            }
        }
        
        function onBeforeClusterNodeExpand(obj_TreeNode){
        
            // Only process nodes for which we have no already determined state
            if(obj_TreeNode.attributes["state"] == 0){
                        obj_TreeNode.attributes["state"] = 1;
                doShowProgress();
                map_TreeNodes = new activelms.HashTable();

                var arr_ChildNodes = obj_TreeNode.childNodes;
                var int_Children = arr_ChildNodes.length;
                for(var i=0; i<int_Children; i++){
                    map_TreeNodes.put(arr_ChildNodes[i].id, arr_ChildNodes[i]);
                }
            
                // Update the state for hidden and disabled
                doEvaluateHiddenAndDisabled();
            }
        }
        
            /**
             * Builds the table of contents as a tree view.
             * 
             * @param {activelms.Activity} the root activity of the activity tree
             * @param {String} the resolved URL to the content root directory
             * @param {Number} SCORM version
             */
            var b_Rendered = false;
            var b_Loaded = false;
        var map_TreeNodes;
            function buildTreeView(obj_RootActivity, str_ContentRoot, f_ScormVersion){
            
            b_Loaded = false;
            
                // Do not build a tree view if the UI is blank
                if(b_UIBlank){
                    if(!b_Loaded){
                       b_Loaded = true;
                       doUpdateView(ICN_VIEW);
                    }
                    return;
                }
                
                // Minimal view
                if(b_UIMinimal){
                    
                    // IF one link in 
                    // THEN remove all navigation, and only show the content.
                    // ELSE IF more than one link in the package/tree
                    // THEN (a) Show Back and Next without the collapse button on the upper right
                    // and (b) Remove the Tree completely, do not show the collapse button either
                    
                    var arr_Children = obj_RootActivity.getAvailableChildren();
                    if(arr_Children.length > 1){
                        // show the tool bar if there is > 1 one link
                        var obj_Region = layout.getRegion("north");
                        obj_Region.show();
                    }
                }
                
                // Remove any existing organization
                var obj_TreePanelRootNode = obj_TreePanel.getRootNode();
                var obj_RootNode = obj_TreePanelRootNode.childNodes[0];
                if(obj_RootNode){
                    obj_TreePanelRootNode.removeChild(obj_RootNode);
                }
                
               // Create a new organization root
               obj_RootNode = doBuildNode(obj_RootActivity);
                
               // Add the event handlers to the root nodw
           obj_RootNode.addListener("click", onClusterNodeClick);
  
           // Add the organization root to the tree panel root
           obj_TreePanelRootNode.appendChild(obj_RootNode);
           
           if(b_Rendered == false){
               obj_TreePanel.render();
               b_Rendered = true;
           }
            
           // Set the properties of the root node
               var obj_TreePanelRootNode = obj_TreePanel.getRootNode();
           obj_TreePanelRootNode.expand();
           var obj_RootNode = obj_TreePanelRootNode.childNodes[0];
           
           var b_DisabledForChoice = obj_RootActivity.isDisabledForChoice();
           if(!b_DisabledForChoice){
                obj_RootNode.enable();
           }
           
           // add the root to the list
           map_TreeNodes = new activelms.HashTable();
           map_TreeNodes.put(obj_RootNode.id, obj_RootNode);
           
           // Recursively add the descendents, and build a list of root, child and active activities
           doAddChildNodes(obj_RootNode, obj_RootActivity, str_ContentRoot);
           obj_RootNode.expand(false, false);
           
           // Update the state for hidden and disabled
           doEvaluateHiddenAndDisabled(f_ScormVersion);
                }
                
                function doEvaluateCurrentAndActive(){

                   var int_Count = map_TreeNodes.size();
                   var obj_Activity;
                   var obj_TreeNode;

                   // can be reverse loop
                   for(var i=0; i<int_Count; i++){
                   
                        obj_TreeNode = map_TreeNodes.elements()[i];
                        obj_Activity = obj_TreeNode.attributes["activity"];
                
                        // Current
                if(obj_Activity.isCurrent()){
                    obj_TreeNode.select();
                }
                else{
                    obj_TreeNode.unselect();
                }
            
                // Active
                if(obj_Activity.isActive()){
                    if(!obj_TreeNode.isLeaf()){
                        obj_TreeNode.expand();
                    }
                }
                
                // Now that the evaluation is done, add an event handler
                obj_TreeNode.addListener("beforeexpand", onBeforeClusterNodeExpand);
                    }
                }
                
        /**
         * Function to build a tree node from an activity.
         *
         * @param {activelms.Activity} the activity from the activity tree
         * @return The tree mode
         * @type Ext.tree.TreeNode
         */
                function doBuildNode(obj_Activity){

            var str_Icon = undefined;
            var b_Leaf = obj_Activity.isLeaf();
            if(b_Leaf){
                str_Icon = 'skins/extjs/resources/images/<?=$_SESSION["skinID"]?>/activelms/activity_16.gif';
            }

            // Disable by default and then enable as required
            var obj_Node = {
                id: obj_Activity.getIdentifier(),
                depth: obj_Activity.getDepth(),
                text: obj_Activity.getTitle(),
                                qtip: obj_Activity.getTitle(),
                                icon: str_Icon,
                                current: obj_Activity.isCurrent(),
                                active: obj_Activity.isActive(),
                disabled: false,
                                hidden: false,
                                state: 0,
                                activity: obj_Activity
            };
               
            return new Ext.tree.TreeNode(obj_Node);
                }

        /**
         * Function to recursively add descendent nodes to the tree.
         *
         * @param {Ext.tree.TreeNode} a parent activity of the activity tree
         * @param {activelms.Activity} the root activity of the activity tree
         * @param {String} the resolved URL to the content root directory
         * @param {Array} a list of the tree nodes
         */
        function doAddChildNodes(obj_ParentNode, obj_Activity, str_ContentRoot) {
        
                        var arr_Children = obj_Activity.getAvailableChildren();
                        var b_ActiveParent = obj_Activity.isActive();
                        var b_ParentIsRoot = obj_Activity.isRoot();
                        var int_Count = arr_Children.length;
            var obj_ChildNode = undefined;
            
                        for (var i=0; i<int_Count; i++ ) {
                                // Make the node
                    obj_ChildNode = doBuildNode(arr_Children[i]);
                // Append to parent
                obj_ParentNode.appendChild(obj_ChildNode);
                // Add to the list if child of root or oarent is active
                if(b_ParentIsRoot || b_ActiveParent){
                    map_TreeNodes.put(obj_ChildNode.id, obj_ChildNode);
                }
                    // Recurse
                                if(arr_Children[i].hasAvailableChildren()){
                                        doAddChildNodes(obj_ChildNode, arr_Children[i], str_ContentRoot);
                    obj_ChildNode.addListener("click", onClusterNodeClick);
                                }
                                else{
                    obj_ChildNode.addListener("click", onLeafNodeClick);
                                }
                }
                }
                
            /**
             * Updates the visible state of the tree nodes 
             * 
             * @param {Array} the array of tree nodes 
             */
            var n = 0;
            var k = 0;
            var ICN_DELAY = 1;

                function doEvaluateHiddenAndDisabled(f_ScormVersion){
                    n = map_TreeNodes.size();
                    k = 0;
                    if(f_ScormVersion < 2004){
                        // do not evaluate sequencing rules
                        k = n;
                    }
                    f_Percent = 0.0;
                    doEvaluateHidden();
                }
                
                function doEvaluateHidden(){

                    if(k<n){

                        var obj_TreeNode = map_TreeNodes.elements()[k];
                        var obj_Activity = obj_TreeNode.attributes["activity"];
                    
                        // Update progress indicator
                        var f_Percent = k/n;
                        var str_Percent = (f_Percent * 100).toFixed(0);
                        var str_Loading = doEscape("<?=$LOADING?>");
                        //Ext.Msg.updateProgress();
                        doUpdateProgress(str_Loading + ": " + obj_TreeNode.text + "..." + str_Percent + "%", (f_Percent * 100));
                        
                // Manage hidden for choice
                        var b_HiddenForChoice = obj_Activity.isHiddenForChoice();
                        if(b_HiddenForChoice){
                        
                            // If Hidden, remove from the parent and continue
                            var obj_Parent = obj_TreeNode.parentNode;
                    obj_Parent.removeChild(obj_TreeNode);
                    
                    // Remove the node from the array and all descendents
                    doRemoveDescendentsFromMap(obj_TreeNode);

                            // Recalculate length
                            n = map_TreeNodes.size();

                            var str_FunctionName = "doEvaluateHidden()";
                            setTimeout(str_FunctionName, ICN_DELAY);  
                        }
                        else {
                            var str_FunctionName = "doEvaluateDisabled()";
                            setTimeout(str_FunctionName, ICN_DELAY); 
                        }
                    }
                    else{
                // Update the state for current and active
                doEvaluateCurrentAndActive();
                
                        // call back
                        if(!b_Loaded){
                            b_Loaded = true;
                    doUpdateView(ICN_VIEW);
                }
                //Ext.Msg.hide();
                doHideProgress();
                    }
                }
                
                function doEvaluateDisabled(){
                   var obj_TreeNode = map_TreeNodes.elements()[k];
                   if(obj_TreeNode && obj_TreeNode.attributes){
                        var obj_Activity = obj_TreeNode.attributes["activity"];
                    
                        // Disabled
                        var b_DisabledForChoice = obj_Activity.isDisabledForChoice();
                        if(b_DisabledForChoice){
                            obj_TreeNode.disable();
                        }
                    }

                    k++;
                    var str_FunctionName = "doEvaluateHidden()";
                    setTimeout(str_FunctionName, ICN_DELAY);  
                }
                
                function doRemoveDescendentsFromMap(obj_TreeNode){
                
                    map_TreeNodes.remove(obj_TreeNode.id);
                    
                    var arr_ChildNodes = obj_TreeNode.childNodes;
            var int_Children = arr_ChildNodes.length;
            for(var i=0; i<int_Children; i++){
                if(arr_ChildNodes[i].childNodes.length != 0){
                    doRemoveDescendentsFromMap(arr_ChildNodes[i]);
                }
                else{
                    map_TreeNodes.remove(arr_ChildNodes[i].id);
                }
            }
                }

        function doDisableControlName(str_ControlName, b_Disable){
            switch(str_ControlName){
                case "previous":
                    if(obj_ButtonPrevious && b_UIBack){
                        if(b_Disable){obj_ButtonPrevious.disable();}
                        else{obj_ButtonPrevious.enable();}
                    }
                break;
                case "continue":
                    if(obj_ButtonContinue && b_UINext){
                        if(b_Disable){obj_ButtonContinue.disable();}
                        else{obj_ButtonContinue.enable();}
                    }
                break;
                case "exit":
                    if(obj_ButtonExit && b_UIExit){
                        if(b_Disable){obj_ButtonExit.disable();}
                        else{obj_ButtonExit.enable();}
                    }
                break;
                default:
                    //alert("disable: " + str_ControlName);
            }
            }

            // The SCORM API Adapters for 1p2 and 2004
                        var API;
                        var API_1484_11;

                        // Declare variables with page scope
                        var ICN_API;
                        var ICN_MODEL;
                        var ICN_VIEW;
                        var ICN_PENDING_NAV_REQUEST;
                        var ICN_PENDING_ORG_REQUEST;
                        var log;
                        
                        // Declare constants
            var ICN_SCORM_TYPE_ASSET = "asset";
            var ICN_SCORM_TYPE_SCO = "sco";
            var ICN_EMPTY_STR = "";
            var ICN_TRUE = "true";
            var ICN_FALSE = "false";
            var ICN_NO_ERROR = "0";
            var ICN_ADL_NAV_TARGET_STRING = "{target=";
            var ICN_ADL_NAV_TARGET_STRING_CLOSE = "}choice";
            var ICN_ADL_NAV_TARGET_STRING_CLOSE_JUMP = "}jump";
            
            var ICN_INITIALIZE = "Initialize";
            var ICN_COMMIT = "Commit";
            var ICN_TERMINATE = "Terminate";
            var ICN_LOGOUT = "logout";
            
                        // XML Http Request
                ICN_XML_HTTP_REQ = new XMLHttpRequest();
        
                        // Logging level - set in configuration web.config;
                        log = new activelms.Logger(
                                activelms.Logger.<?=$ajaxLogLevel?>, 
                                activelms.Logger.POPUP_LOGGER);
                                
                // Add values to the model from the host LMS
                ICN_MODEL = new activelms.Model();
                
                // Mandatory parameters
                ICN_MODEL.put("domainID", <?=$domainID?>);
                ICN_MODEL.put("learnerID", <?=$learnerID?>);
                ICN_MODEL.put("courseID", <?=$courseID?>);
                
                // Optional parameters
                ICN_MODEL.put("learnerName", <?=$learnerName?>);
                ICN_MODEL.put("orgID", <?=$orgID?>);
                ICN_MODEL.put("sessionID", <?=$sessionID?>);
                ICN_MODEL.put("skinID", "<?=$_SESSION["skinID"]?>");
                ICN_MODEL.put("culture", <?=$culture?>);
                ICN_MODEL.put("mode", <?=$mode?>);
        
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
                ICN_MODEL.put("ajaxErrorUrl","<?=$ajaxErrorUrl?>");
                
                // Add values to the model from the configuration files
                ICN_MODEL.put("syncClientServer", "<?=$syncClientServer?>");
                ICN_MODEL.put("isDebugAjax", Boolean(<?=$isDebugAjax?>));
                ICN_MODEL.put("isAsyncAjax",Boolean(<?=$isAsyncAjax?>));
                ICN_MODEL.put("isSetToLaunch",Boolean(<?=$isSetToLaunch?>));
                ICN_MODEL.put("skinDirID", "<?=$skinDirID?>");
                
                // Add values to the model from the server and request
                ICN_MODEL.put("context", "<?=$context?>");
                
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
<iframe src="" name="main" id="main" style="visibility:hidden;"></iframe>
</body>
</html>
