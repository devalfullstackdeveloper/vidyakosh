/**
 * @fileoverview Classes for ActiveScorm Cloud Player
 * @author activelms Ltd mailto:sales@activelms.com
 * @version 1.0
 */
var activelms;
if(!activelms){activelms = {};}
else if(typeof activelms != "object"){throw new Error("namepsace activelms exists");}

var ICN_ADAPTER = undefined;
var ICN_WINDOW_CLOSED_EVT = undefined;




/**
 * Utility Method that checks whether a URL is absolute (true) or not
 * and returns a boolean flag. See Case00001275 and JIRA JAVATWO-157.
 * @param {String} str_Url The url
 * @return The boolean flag
 */
var isAbsoluteUrl = function(str_Url){
    if(typeof(str_Url) == "undefined"){return false;}
    if(str_Url == null){return false;}
    if(str_Url.length == 0){return false;}
    
    var regExp_Matcher = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    return regExp_Matcher.test(str_Url);
};


/**
 * Construct a new PlayerUI class.
 * 
 * @class This class represents an instance of an Player User Interface
 * @constructor
 * @param {window} win_Sequencer
 * @param {HTMLElement} a <div/> element for progress callback
 * @return A new instance of activelms.PlayerUI
 */	
activelms.PlayerUI = function(win_Sequencer, el_Progress){
	
	/*
	 * @private
	 */
	var f_Progress = 0.0;
	var b_TreeRendered = false;
	var b_Loaded = false;
   	var map_TreeNodes;

	/**
	 */
	this.confirmUnload = function(){
	
	    // Make the AJAX calls synchronous for CMI service
        changeAjaxToSynchronous();
        ICN_WINDOW_CLOSED_EVT = true;
        
        // Get the properties currently held by the model
	    var str_ScormType = win_Sequencer.ICN_MODEL.get("scormType");
		// Invoke CMI Data Model Service, if SCO was last resource type
		if(str_ScormType=="sco"){
            // Set up some properties for when onSCOTerminated runs
            ICN_ADAPTER.adlNavRequest = activelms.SequencingEngine.EXIT_ALL;
        }
        
		var b_IsBeforeUnloadPromptEnabled = win_Sequencer.ICN_MODEL.get("isBeforeUnloadPromptEnabled");
		if(b_IsBeforeUnloadPromptEnabled){
		    // Prompt if the sequencing session is not finished
    	    var obj_ActivityTree = win_Sequencer.ICN_MODEL.get("activityTree");
    	    if(obj_ActivityTree.getCurrentActivity()){
    		    if(!activelms.SequencingBehaviour.isSequencingFinished){
   				    if(window.event){window.event.returnValue = ICN_CONFIRM_UNLOAD;} // IE
   				    else {return ICN_CONFIRM_UNLOAD;} // FX
   				}
    		}
      	}
	};
	
	var changeAjaxToSynchronous = function(){
	    
	    // Make the CMI Data Model Synchronous
	    win_Sequencer.ICN_MODEL.put("isAsyncAjax",false);
    	if (ICN_ADAPTER){
    	    ICN_ADAPTER.boolean_Async = false;
    	}
	};
	
	/**
	 * @param {Object} obj_View window, frame or iframe
	 * @param {String} the document.location or frame src to be displayed
	 */
	this.updateUI = function(obj_View, str_Url){	
    	// Get properties
		var arr_Organizations = win_Sequencer.ICN_MODEL.get("organizations");
		var obj_ActivityTree = win_Sequencer.ICN_MODEL.get("activityTree");
		var str_LCMSEndPoint = win_Sequencer.ICN_MODEL.get("LCMSEndPoint");
		var str_CourseID = win_Sequencer.ICN_MODEL.get("courseID");
		var str_OrgID = win_Sequencer.ICN_MODEL.get("orgID");
		var str_ScoID = win_Sequencer.ICN_MODEL.get("scoID");
		var str_Title = win_Sequencer.ICN_MODEL.get("title");
	    var f_ScormVersion = obj_ActivityTree.getScormVersion();
	
		var b_DisablePrevious = false;
		if(win_Sequencer.ICN_MODEL.get("isDisabledForPrevious") 
			|| win_Sequencer.ICN_MODEL.get("isHiddenForPrevious")){
			b_DisablePrevious = true;
		}
		var b_DisableContinue = false;
		if(win_Sequencer.ICN_MODEL.get("isDisabledForContinue") 
			|| win_Sequencer.ICN_MODEL.get("isHiddenForContinue")){
	    	b_DisableContinue = true;
		}
		
		/*
	 	* Toolbar text support added for Master Teacher UI
	 	* See Case # 00001628 and JIRA issue JAVATWO-176
	 	*/
		if(typeof(obj_ToolbarTextItem) != "undefined"){
			if(activelms.SequencingBehaviour.isSequencingFinished){
				this.doSetToolbarText(" ");
				obj_ToolbarTextItem.disable();
			}
			else{
				var arr_LeafActivities = this.getAvailableLeafItems(obj_ActivityTree);
				var obj_CurrentActivity = obj_ActivityTree.getCurrentActivity();
				var index = this.getCurrentActivityIndex(arr_LeafActivities, obj_CurrentActivity) + 1;
				var str_ToolbarText = String.format(str_ToolbarLabel, index, arr_LeafActivities.length);
				this.doSetToolbarText(str_ToolbarText);
				obj_ToolbarTextItem.enable();
			}
		}	
		    
		// Manage the controls
    	this.doDisableControlName("previous", b_DisablePrevious);
    	this.doDisableControlName("continue", b_DisableContinue);
    	this.doDisableControlName("exit", win_Sequencer.ICN_MODEL.get("isDisabledForExit"));
    	this.doDisableControlName("treeView", win_Sequencer.ICN_MODEL.get("isDisabledForMenu"));  

		if(!activelms.SequencingBehaviour.isSequencingFinished){
        	// Update Organizations combo box
       	 	buildOrganizationsView(arr_Organizations, str_OrgID);

            if(typeof(obj_TreePanel) != "undefined"){
	    		// Update TOC, which will callback to update the view
	    		var str_ContentRoot = str_LCMSEndPoint;
	    		str_ContentRoot += "/";
	    		str_ContentRoot += str_CourseID;
        		buildTreeView(obj_ActivityTree.getRoot(), str_ContentRoot, f_ScormVersion);
       			this.showMenu(true);
			}
    	}
    	
		this.showView(obj_View, str_Url);
	};
	
		/*
	 	* Toolbar text support added for Master Teacher UI
	 	* See Case # 00001628 and JIRA issue JAVATWO-176
	 	*/
	this.getAvailableLeafItems = function(obj_ActivityTree){
		var arr_LeafActivities = new Array();
		if(obj_ActivityTree){
			var arr_Activities = obj_ActivityTree.getAvailableActivityList();
			var count = arr_Activities.length;
			for(var i=0; i<count; i++){
				obj_Activity = arr_Activities[i];
				if(obj_Activity.isLeaf()){
					arr_LeafActivities.push(arr_Activities[i]);
				}
			}
		}
		return arr_LeafActivities;
	};
	
		/*
	 	* Toolbar text support added for Master Teacher UI
	 	* See Case # 00001628 and JIRA issue JAVATWO-176
	 	*/
	this.getCurrentActivityIndex = function(arr_LeafActivities, obj_CurrentActivity){
		if(obj_CurrentActivity){
			var count = arr_LeafActivities.length;
			var obj_Activity = null;
			for(var i=0; i<count; i++){
				obj_Activity = arr_LeafActivities[i];
				if(obj_CurrentActivity.getIdentifier() == obj_Activity.getIdentifier()){
					return i;
				}
			}
		}
		return -1;
	};
	
	/*
	 * Toolbar text support added for Master Teacher UI
	 * See Case # 00001628 and JIRA issue JAVATWO-176
	 * See http://blog.coderlab.us/2006/04/18/the-textcontent-and-innertext-properties/
	 */
	this.doSetToolbarText = function(str_Text){
		if(str_Text){
			var htmlEl = obj_ToolbarTextItem.getEl();
            if(htmlEl){
            	htmlEl.innerHTML = str_Text;
            }
       	}
	};
	
	/*
	 * @param {Object} obj_View window, frame or iframe
	 * @param {String} the document.location or frame src to be displayed
	 */
	this.showView = function(obj_View, str_Url){
    	if(obj_View 
    	&& obj_View.tagName 
    	&& obj_View.tagName.toLowerCase() == "iframe"){
    		// HTML IFrame
    		obj_View.style.visibility="visible";
			obj_View.src  = str_Url;
    	}
    	else if(obj_View && !obj_View.closed){
    		// Window or HTML Frame
    		obj_View.location = str_Url;
    		obj_View.focus();
    	}
    	// Always hide progress when a view is shown
       	this.showProgress(false);
	};
	
	/**
	 * @public
	 */
	this.disableControls = function(b_Disable){
    	// Manage the controls
    	doDisableControlName("previous", b_Disable);
    	doDisableControlName("continue", b_Disable);
    	doDisableControlName("exit", b_Disable);  
    	doDisableControlName("treeView", b_Disable);
    	
    	// For Master Teacher ToolBar Item
		if(typeof(obj_ToolbarTextItem) != "undefined"){
			obj_ToolbarTextItem.disable();
		}
	};
	
    this.doDisableControlName = function(str_ControlName, b_Disable){
		switch(str_ControlName){
			case "previous":
            if(typeof(obj_ButtonPrevious) != "undefined"){
            	if(b_UIBack){
           			if(b_Disable){obj_ButtonPrevious.disable();}
                	else{obj_ButtonPrevious.enable();}
            	}
             }
             break;
             case "continue":
            if(typeof(obj_ButtonContinue) != "undefined"){
            	if(b_UINext){
             		if(b_Disable){obj_ButtonContinue.disable();}
                	else{obj_ButtonContinue.enable();}
            	}
            }break;
            case "exit":
            if(typeof(obj_ButtonExit) != "undefined"){
            	if(b_UIExit){
					if(b_Disable){obj_ButtonExit.disable();}
                	else{obj_ButtonExit.enable();}
            	}
            }break;
            default:
         }
	};
	

	
	/**
	 * @public
	 */
	this.highlightMenu = function(){
  		var el_TreePanel = Ext.get("treePanel");
		el_TreePanel.highlight();
	};
	
	/**
	 * @public
	 */
	this.expandRegion = function(str_RegionID, b_Expand){
 		var obj_Region = layout.getRegion(str_RegionID);
        if(obj_Region){
        	if(b_Expand){obj_Region.show();obj_Region.expand();}
            else{obj_Region.collapse();}
        }
	};
	
	/**
	 */
	this.showMenu = function(b_Show){
		var obj_TreePanelDiv = win_Sequencer.document.getElementById("treePanel");
		if(obj_TreePanelDiv){
        	if(b_Show){obj_TreePanelDiv.style.visibility="visible";}
        	else{obj_TreePanelDiv.style.visibility="hidden";}
		}
	};
	
	/**
	 * 
	 */
    this.showConfirm = function(str_Message, fn_Callback){
		if(b_IsSetToStyleDialogs){
        	Ext.Msg.confirm(ICN_CONFIRM_TITLE, str_Message, function(obj_Button){
            if (obj_Button == 'yes'){fn_Callback.call(this, true);}
            else{fn_Callback.call(this, false);}});
         }
         else{
         	var b_Yes = confirm(str_Message);
            if (b_Yes){fn_Callback.call(this, true);}
            else{fn_Callback.call(this, false);}
        }
    };
	  
	/**
	 * 
	 */  
    this.showAbout = function(){
    	obj_AboutDlg.show(obj_ButtonAbout.dom);
    };
	
	/**
	 * @public
	 */
	this.showProgress = function(b_Show){
		if(b_Show){
			if(el_Progress){
				el_Progress.style.visibility = "visible";
			}
			else{
       			Ext.Msg.show({
        			title: ICN_PROGRESS_TITLE,
            		msg: ICN_PROGRESS_TITLE,
            		width:380,
            		progress:true,
            		closable:false
       			});
			}
		}
		else{
			if(el_Progress){el_Progress.style.visibility = "hidden";}
			else{Ext.Msg.hide();}
		}
	};
	
	/**
	 * @public
	 */
	this.updateProgress = function(str_Message, int_Percent){
		if(int_Percent){f_Progress = (int_Percent/100);}
        else{
        	f_Progress += 0.1;
            if(f_Progress > 1.0){f_Progress = 0.1;}
        }
		if(el_Progress){
			//el_Progress.innerHTML = (str_Message);
		}
		else{Ext.Msg.updateProgress(f_Progress, str_Message);}
	};
	
	/**
	 * @public
	 */
	this.writeWindowTitle = function(str_Title){
		if(!str_Title){return;}
    	if(obj_View 
    	&& obj_View.tagName 
    	&& obj_View.tagName.toLowerCase() == "iframe"){
			obj_View.parent.document = str_Title;
    	}
    	else if(obj_View && !obj_View.closed){
    		// Window or HTML Frame
    		obj_View.document = str_Title;
    	}
	};
	
	/**
	 * @public
	 */
	this.comboDisable = function(){
		if(!b_UIOrgs){return;}
        obj_OrgCombo.collapse();
        obj_OrgCombo.setDisabled(true);
	};
	
	/*
	 * @public
	 */
	this.onComboSelect = function(obj_Combo, obj_Record, int_Index){
 		if(!b_UIOrgs){return;}
	    var str_TargetOrgID = obj_Record.get('identifier');
	    var str_Title = obj_Record.get('title');
        var str_OrgID = ICN_MODEL.get("orgID");
        obj_Combo.collapse();
        // No need to support a self-reference
        if(str_OrgID == str_TargetOrgID){return;}
	        
        // Confirm
        var str_Text = ICN_CONFIRM_TITLE;
        var str_Message = ICN_CONFIRM_MSG_0;
        str_Message += ": " + doEscape(str_Title) + "?";
            
            if(b_IsSetToStyleDialogs){
                Ext.Msg.confirm(
                    ICN_CONFIRM_TITLE,
                    str_Message,
                    function(obj_Button){
                        if (obj_Button == 'yes'){
                            // Add the target idenfifier to the model, and call the doInit method
                            doComboDisable();
                            doOrganizations(str_TargetOrgID);
                        }
                        else{
                            obj_Combo.collapse();
                            win_Sequencer.focus();
                        }
                    });
	        }
	        else{
                var b_Yes = confirm(str_Message);
                if (b_Yes){
                    doComboDisable();
                    doOrganizations(str_TargetOrgID);
                }
                else{
                   obj_Combo.collapse();
                   win_Sequencer.focus();
                }
	        }
	   }
	
	/**
	 * @private
	 */
	var buildOrganizationsView = function(arr_Organizations, str_OrgID){
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
         obj_OrgCombo.setDisabled(false);
		 obj_OrgCombo.collapse();
	}
	
	/**
	 * Builds the table of contents as a tree view.
	 * @private
	 * @param {activelms.Activity} the root activity of the activity tree
	 * @param {String} the resolved URL to the content root directory
	 * @param {Number} SCORM version
	 */
	var buildTreeView = function(obj_RootActivity, str_ContentRoot, f_ScormVersion){
       b_Loaded = false;
	   // Do not build a tree view if the UI is blank
	   if(b_UIBlank){
	   	//TODO
	   }
	   // Remove any existing organization
	   var obj_TreePanelRootNode = obj_TreePanel.getRootNode();
	   var obj_RootNode = obj_TreePanelRootNode.childNodes[0];
	   if(obj_RootNode){
	   		obj_TreePanelRootNode.removeChild(obj_RootNode);
	   }
       // Minimal view in .NET edition? if(b_UIMinimal){}
	        
	   // Create a new organization root
	   obj_RootNode = doBuildNode(obj_RootActivity); 
	   // Add the event handlers to the root nodw
       obj_RootNode.addListener("click", onClusterNodeClick);
       // Add the organization root to the tree panel root
       obj_TreePanelRootNode.appendChild(obj_RootNode);
		// Move to after child nodes are added
       if(!b_TreeRendered){obj_TreePanel.render();b_TreeRendered = true;}
       
       // Set the properties of the root node
	   var obj_TreePanelRootNode = obj_TreePanel.getRootNode();
       obj_TreePanelRootNode.expand();
       var obj_RootNode = obj_TreePanelRootNode.childNodes[0];
       var b_DisabledForChoice = obj_RootActivity.isDisabledForChoice();
       if(!b_DisabledForChoice){obj_RootNode.enable();}
       
       // Add the root to the list
       map_TreeNodes = new activelms.HashTable();
       map_TreeNodes.put(obj_RootNode.id, obj_RootNode);
           
       // Recursively add the descendents, and build a list of root, child and active activities
       doAddChildNodes(obj_RootNode, obj_RootActivity, str_ContentRoot);
       obj_RootNode.expand(false, false);
           
       // Update the state for hidden and disabled
       doEvaluateHiddenAndDisabled(f_ScormVersion);
	};
	
	/**
	 * Function to recursively add descendent nodes to the tree.
	 * @private
	 * @param {Ext.tree.TreeNode} a parent activity of the activity tree
	 * @param {activelms.Activity} the root activity of the activity tree
	 * @param {String} the resolved URL to the content root directory
	 * @param {Array} a list of the tree nodes
	 */
    var doAddChildNodes = function(obj_ParentNode, obj_Activity, str_ContentRoot) {
    	var arr_Children = obj_Activity.getAvailableChildren();
		var b_ActiveParent = obj_Activity.isActive();
		var b_ParentIsRoot = obj_Activity.isRoot();
		var int_Count = arr_Children.length;
        var obj_ChildNode = undefined;
            
		for (var i=0; i<int_Count; i++ ) {
			obj_ChildNode = doBuildNode(arr_Children[i]);
            obj_ParentNode.appendChild(obj_ChildNode);
           	// Add to the list if child of root or parent is active
            if(b_ParentIsRoot || b_ActiveParent){
            	map_TreeNodes.put(obj_ChildNode.id, obj_ChildNode);
            }
	        // Recurse
			if(arr_Children[i].hasAvailableChildren()){
				doAddChildNodes(obj_ChildNode, arr_Children[i], str_ContentRoot);
                obj_ChildNode.addListener("click", onClusterNodeClick);
			}
			else{obj_ChildNode.addListener("click", onLeafNodeClick);}
        }
	};
	
	/**
	 * Function to build a tree node from an activity.
	 * @private
	 * @param {activelms.Activity} the activity from the activity tree
	 * @return The tree mode
	 * @type Ext.tree.TreeNode
	 */
	var doBuildNode = function(obj_Activity){
		var str_Class = undefined;
        var b_Leaf = obj_Activity.isLeaf();
		var str_Mode = win_Sequencer.ICN_MODEL.get("mode");
		var b_IsSetToShowCompletion = win_Sequencer.ICN_MODEL.get("isSetToShowCompletion");

        if(b_Leaf){
        	if(str_Mode=="normal" && b_IsSetToShowCompletion){
                
		    	var obj_ActivityProgressInfo = obj_Activity.getActivityProgressInfo();
		        var obj_AttemptProgressInfo = obj_Activity.getAttemptProgressInfo();
		        var b_ProgressStatus = false;
		        var b_CompletionStatus = false;
		            
		        // break the SCORM Model?
		        if(obj_ActivityProgressInfo.getAttemptCount()>0){b_ProgressStatus = true;}
		        if(obj_AttemptProgressInfo.getProgressStatus()){b_ProgressStatus = true;}
		        if(obj_AttemptProgressInfo.getCompletionStatus()){b_CompletionStatus = true;}
		        if(b_ProgressStatus == false){str_Class = 'not-attempted-node';}
                else {
                	str_Class = 'incomplete-node';
                    if(b_CompletionStatus == true){str_Class = 'completed-node';}
                }
            }
            else{str_Class = 'not-attempted-node';}
       }

      	// Disable by default and then enable as required
        var obj_Node = {
        	id: obj_Activity.getIdentifier(),
            depth: obj_Activity.getDepth(),
            text: obj_Activity.getTitle(),
            cls: str_Class,
			qtip: obj_Activity.getTitle(),
			current: obj_Activity.isCurrent(),
			active: obj_Activity.isActive(),
            disabled: false,
			hidden: false,
			state: 0,
			activity: obj_Activity
        };
       	return new Ext.tree.TreeNode(obj_Node);
	};
	
	/*
	 * @param {Ext.tree.TreeNode} obj_TreeNode a tree node
	 */
    this.onBeforeClusterNodeExpand = function(obj_TreeNode){
    	// Only process nodes for which we have not already determined state
        if(obj_TreeNode.attributes["state"] == 0){
        	obj_TreeNode.attributes["state"] = 1;
            //doShowProgress();
    	   	map_TreeNodes = new activelms.HashTable();
    	    var arr_ChildNodes = obj_TreeNode.childNodes;
    	    var int_Children = arr_ChildNodes.length;
    	    for(var i=0; i<int_Children; i++){
            	map_TreeNodes.put(arr_ChildNodes[i].id, arr_ChildNodes[i]);
    	    }
            // Update the state for hidden and disabled
			var obj_ActivityTree = win_Sequencer.ICN_MODEL.get("activityTree");
			var f_ScormVersion = obj_ActivityTree.getScormVersion();
            doEvaluateHiddenAndDisabled(f_ScormVersion);
        }
   	};

	/**
	 * Function to run when a cluster node is clicked. The function
	 * invokes a choice navigation event for the sequencing
	 * engine and expands the child nodes of this node.
	 * @param {Ext.tree.TreeNode} obj_TreeNode a tree node
	 */  
    this.onClusterNodeClick = function(obj_TreeNode){
		if(!obj_TreeNode.disabled){doChoice(obj_TreeNode.id);}
    };
    
	/**
	 * Function to run when a leaf node is clicked. The function
	 * invokes a choice navigation event for the sequencing
	 * engine.
	 * @param {Ext.tree.TreeNode} a tree node
	 */        
    this.onLeafNodeClick = function(obj_TreeNode){
    	if(!obj_TreeNode.disabled){doChoice(obj_TreeNode.id);}
    };
    
	var n = 0;
	var k = 0;
	var ICN_DELAY = 1;
	
    /*
     * Updates the visible state of the tree nodes
     * @private
	 * @param {Array} the array of tree nodes 
     */
	this.doEvaluateHiddenAndDisabled = function(f_ScormVersion){
		n = map_TreeNodes.size();k = 0;
		// Do not evaluate sequencing rules for SCORM 1.2
		if(f_ScormVersion < 2004){
			k = n;
			// Update the state for current and active
			doEvaluateCurrentAndActive();
            doEvaluateCompletionStatus();
		}
		//f_Percent = 0.0;
		this.doEvaluateHidden();
	};
	
	/**
	 */
	this.doEvaluateHidden = function(){
		if(k<n){
			var obj_TreeNode = map_TreeNodes.elements()[k];
		    var obj_Activity = obj_TreeNode.attributes["activity"];
		    
		    // Update progress indicator
		    var f_Percent = k/n;
		    var str_Percent = (f_Percent * 100).toFixed(0);
            this.updateProgress(ICN_LOADING_MSG + ": " + obj_TreeNode.text + "..." + str_Percent + "%", (f_Percent * 100));
		        
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
            doEvaluateCompletionStatus();
		    // call back
		    if(!b_Loaded){
		    	b_Loaded = true;
		    	//TODO
                //doUpdateView(ICN_VIEW);
            }
		}
	};
	
	/**
	 */
	this.doEvaluateDisabled = function(){
        var obj_TreeNode = map_TreeNodes.elements()[k];
		if(obj_TreeNode && obj_TreeNode.attributes){
		    var obj_Activity = obj_TreeNode.attributes["activity"];
		    // Disabled
		    var b_DisabledForChoice = obj_Activity.isDisabledForChoice();
		    if(b_DisabledForChoice){obj_TreeNode.disable();}
		}

		k++;
		var str_FunctionName = "doEvaluateHidden()";
		setTimeout(str_FunctionName, ICN_DELAY);  
	};
	
	/**
	 */
	var doRemoveDescendentsFromMap = function(obj_TreeNode){
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
	};
	
	/**
	 */
	this.doEvaluateCurrentAndActive = function(){
		var int_Count = map_TreeNodes.size();
		var obj_Activity;var obj_TreeNode;
		for(var i=0; i<int_Count; i++){
			obj_TreeNode = map_TreeNodes.elements()[i];
		    obj_Activity = obj_TreeNode.attributes["activity"];
		    //Current
            if(obj_Activity.isCurrent()){obj_TreeNode.select();}
            else{obj_TreeNode.unselect();}
            // Active
            if(obj_Activity.isActive()){if(!obj_TreeNode.isLeaf()){obj_TreeNode.expand();}}
            // Now that the evaluation is done, add an event handler
            obj_TreeNode.addListener("beforeexpand", onBeforeClusterNodeExpand);
		}
	};
	
	/**
	 * This function is called during evaluation of all activities in the
	 * activity tree
	 */
	this.doEvaluateCompletionStatus = function(){
		// Only update for mode="normal"
		var str_Mode = win_Sequencer.ICN_MODEL.get("mode");
		if(str_Mode=="browse"){return;} if(str_Mode=="review"){return;}
		
		
		// Only manage the completion status if configured
		var b_IsSetToShowCompletion = win_Sequencer.ICN_MODEL.get("isSetToShowCompletion");
		if(!b_IsSetToShowCompletion){return;}
		
		var int_Count = map_TreeNodes.size();
		var obj_Activity;
		var obj_TreeNode;
		for(var i=0; i<int_Count; i++){
		   obj_TreeNode = map_TreeNodes.elements()[i];
		   obj_Activity = obj_TreeNode.attributes["activity"];
		   if(obj_Activity.isLeaf()){
		   
		        if(obj_Activity.isCurrent()){
		            if(obj_Activity.getResource().getScormType().toLowerCase() == "sco"){
		                // in 2.03 do not override status set by onSCOInitialized for the current activity  
		                //alert("*** continure for activity: " + obj_Activity.getTitle());
		                continue;
		           }
		       	}
		       	
		   		var obj_ActivityProgressInfo = obj_Activity.getActivityProgressInfo();
		        var obj_AttemptProgressInfo = obj_Activity.getAttemptProgressInfo();
		        var b_ProgressStatus = false;
		        var b_CompletionStatus = false;

		        /*
		         * Comment from vendor: We're interested only in the 
		         * "Not Attempted ever" information. The status for activity 
		         * should show 'Incomplete', if learner has started the 
		         * activity in previous session but not completed. 
		         * If he/she has completed it in previous session then 
		         * it should show 'Completed'.
		         * 
		         * So we need to work with ActivityProgressInfo, not
		         * Attempt Progress Info. Available fields are
		         * 
		         * ActivityProgressInfo.progressStatus (true when 1st attempt begins)
		         * ActivityProgressInfo.attemptCount (1 or greater means attempt is 
		         * either is in progress or finished).
		         * 
		         * If we want to use completion status from a previous session
		         * the SCO must suspend/resume
		         */
		         
		        if(obj_ActivityProgressInfo.getAttemptCount()>0){b_ProgressStatus = true;}
		        if(obj_AttemptProgressInfo.getProgressStatus()){b_ProgressStatus = true;}
		        if(obj_AttemptProgressInfo.getCompletionStatus()){b_CompletionStatus = true;}

		        obj_TreeNode.ui.removeClass('not-attempted-node');
		        obj_TreeNode.ui.removeClass('incomplete-node');
		        obj_TreeNode.ui.removeClass('completed-node');
		        
		        //alert("doEvaluateCompletion for activity: " + obj_Activity.getTitle() + ", completed=" + b_CompletionStatus);
		            
		        if(!b_ProgressStatus){obj_TreeNode.ui.addClass('not-attempted-node');}
                else {
                    if(b_CompletionStatus){obj_TreeNode.ui.addClass('completed-node');}
                    else{obj_TreeNode.ui.addClass('incomplete-node');}
                }
		    }
		}
	};
	
    /**
     * This function is called for a particular SCO on SCO initialized
     */
	this.doSetCompletionStatus = function(str_Identifier, b_ProgressStatus, b_CompletionStatus){
		// Only manage the completion status if configured
		var b_IsSetToShowCompletion = win_Sequencer.ICN_MODEL.get("isSetToShowCompletion");
		if(!b_IsSetToShowCompletion){return;}
		var int_Count = map_TreeNodes.size();
		var obj_Activity;
		var obj_TreeNode;

		// can be reverse loop
		for(var i=0; i<int_Count; i++){
		   obj_TreeNode = map_TreeNodes.elements()[i];
		   obj_Activity = obj_TreeNode.attributes["activity"];
		   if(obj_Activity.isLeaf() && obj_TreeNode.id==str_Identifier){
		   
				obj_TreeNode.ui.removeClass('not-attempted-node');
		        obj_TreeNode.ui.removeClass('incomplete-node');
		        obj_TreeNode.ui.removeClass('completed-node');
		        
		        // make sure the node is expanded before setting the class, so that class is applied
		        obj_TreeNode.ensureVisible();
  
		        if(!b_ProgressStatus){obj_TreeNode.ui.addClass('not-attempted-node');}
                else{
                    if(b_CompletionStatus){obj_TreeNode.ui.addClass('completed-node');}
                    else{obj_TreeNode.ui.addClass('incomplete-node');}
               	}
               	break;
		    }
		} 
	};

	/*
	 * @private
	 */  
    this.doAjaxError = function(obj_View, obj_Error){
    	//alert(obj_Error);
    	var str_Description = obj_Error.description;
    	if(str_Description && str_Description!= null && str_Description.length > 400){
        	str_Description = str_Description.substring(0,400);
    	}
    	/*
    	else{
			str_Description = "No description available";
    	}
    	*/
    	
    	var str_Stack = obj_Error.stack;
    	if(str_Stack && str_Stack!= null && str_Stack.length > 400){
        	str_Stack = str_Stack.substring(0,400);
    	}
   		var str_Url = win_Sequencer.ICN_MODEL.get("ajaxErrorUrl");
    	str_Url += "&skinID=" + win_Sequencer.ICN_MODEL.get("skinID");
    	str_Url += "&culture=" + win_Sequencer.ICN_MODEL.get("culture");
    	str_Url += "&errorDescription=" + str_Description;
    	str_Url += "&errorFileName=" + obj_Error.fileName;
    	str_Url += "&errorLineNumber=" + obj_Error.lineNumber;
    	str_Url += "&errorMessage=" + obj_Error.message;
    	str_Url += "&errorName=" + obj_Error.name;
    	str_Url += "&errorNumber=" + obj_Error.number;
    	str_Url += "&errorStack=" + str_Stack;

		// changed for 2.03
    	this.updateUI(obj_View, str_Url);
    	//doShowView(obj_View, str_Url);
    };
};

/**
 * Construct a new Player class.
 * 
 * @class This class represents an instance of an Player
 * @constructor
 * @param {window} win_Sequencer
 * @param {window} win_Api
 * @param {object} obj_View
 * @param {activelms.PlayerUI} obj_UI
 * @return A new instance of activelms.Player
 */	
activelms.Player = function(win_Sequencer, win_Api, obj_View, obj_PlayerUI, b_NewWindow){
	
	/*
	 * @private
	 */ 

	var str_NewWindowName = "activelmsPlayerActivityWindow";
	var str_SequencerWindowName = "activelmsPlayerSequencerWindow";
	var str_PendingAdlNavRequest = undefined;
	var str_PendingOrgIdRequest = undefined;
	win_Sequencer.onunload = doUnloadMain;


	/*
	 * Method reference for a callback when
	 * the Player recieves a response from the
	 * Sequencing Service after an "init"
	 * sequencing request.
	 * 
	 * @public
	 */
	this.onPlayerInit = undefined;
	
	/*
	 * @private
	 */
	var initSessionExpiration  = function(){
		// Set the timestamp & add the timer
        activelms.NavigationBehaviour.lastRequestTimestamp = new Date();
	    var obj_SessionFrame = win_Sequencer.document.getElementById("session");
	    //obj_SessionFrame.src  = "session.html";// see #00001514
	    obj_SessionFrame.src  = win_Sequencer.ICN_MODEL.get("sessionMonitorUrl");
	    
	};
	
	/*
	 * @public
	 */
	this.checkSessionExpiration = function(){
		var b_IsTimeoutEnabled = win_Sequencer.ICN_MODEL.get("isTimeoutEnabled");
		var date_Now = new Date();
		var str_MaxInactiveInterval = win_Sequencer.ICN_MODEL.get("maxInactiveInterval");
		var int_MaxInactiveInterval = parseInt(str_MaxInactiveInterval);
		var int_IntervalMillis = int_MaxInactiveInterval * 1000;
		if(activelms.NavigationBehaviour.lastRequestTimestamp){
			var int_LastRequest = activelms.NavigationBehaviour.lastRequestTimestamp.getTime();
			if((date_Now.getTime() - int_LastRequest) > int_IntervalMillis){
				runSessionExpiration();
			}
		}
	};
	
	/*
	 * @private
	 */
	var runSessionExpiration  = function(){
		// Delete the timestamp
	    activelms.NavigationBehaviour.lastRequestTimestamp = undefined;
		// Remove the timer
	    var obj_SessionFrame = document.getElementById("session");
	    obj_SessionFrame.src  = "empty.html";
	    // Run ExpireAll
	    doExpireAll();
	};
	
	/**
	 * @public
	 */
	this.doOrganizations = function(str_TargetOrgID){
    	// Cache the orgID for callback
    	str_PendingOrgIdRequest = str_TargetOrgID;
    	// See if the sequencing session has begun
    	var str_ScoID = win_Sequencer.ICN_MODEL.get("scoID");
    	if(!str_ScoID){
          // Sequencing session not started, just start
          var obj_ModelAndView = new activelms.ModelAndView(win_Sequencer.ICN_MODEL);
          orgMvcCallback(obj_ModelAndView);
    	}
    	else{
        	// Sequencing session started, EXIT_ALL, and then call back.
        	doExecuteAction(activelms.SequencingEngine.EXIT_ALL, undefined, orgMvcCallback);	
    	}
	};
	
	/**
	 * Initial call with an "init"
	 * sequencing request.
	 */
    this.doInit = function(){
    	// Initialize the expiration management,, if enabled
		var b_IsTimeoutEnabled = win_Sequencer.ICN_MODEL.get("isTimeoutEnabled");
		if(b_IsTimeoutEnabled){
			initSessionExpiration();
		}
		// Alaways Initialize the onbeforeunload
		if(window.body){
			    window.body.onbeforeunload = obj_PlayerUI.confirmUnload;
		} // IE
		else{
			    window.onbeforeunload = obj_PlayerUI.confirmUnload;
		} // FX
    	// Invoke an MVC action
	   	doExecuteAction(
			activelms.SequencingEngine.INIT, 
	        null, 
	        initMvcCallback);
    };
    
    /**
     * 
     */
    this.doStart = function(){
    	doExecuteAction(activelms.SequencingEngine.START, undefined, mvcCallback);   
    };
    
    /**
     * 
     */
    this.doResumeAll = function(){
    	doExecuteAction(activelms.SequencingEngine.RESUME_ALL, undefined, mvcCallback);  
    };
    
    /**
     * Target the current activity with a choice navigation request
     */
	this.doCurrent = function(){
    	var str_ScoID = win_Sequencer.ICN_MODEL.get("mostRecentScoID"); 
   	 	this.doChoice(str_ScoID);  
	}
	
	/**
	 * 
	 */
    this.doChoice = function(str_ScoID){
    	//"{target=intro}choice"; 
    	
    	// changed for 2.03 for sequencing behaviour errors
    	if(typeof(ICN_ADAPTER) == "undefined"){
    	    // A sequecing behaviour error, such as a resume of a suspended disabled acvtivity
    	    doExecuteAction(activelms.SequencingEngine.CHOICE, str_ScoID, initMvcCallback);  
    	}
    	else{
   		    ICN_ADAPTER.adlNavRequest = "{target=" + str_ScoID + "}choice";
    	    doUnloadCurrentActivity();  
    	} 
    };
    
	/**
	 * Added for SCORM 2004 4th ED
	 */
    this.doJump = function(str_ScoID){
    	//"{target=intro}jump"; 
  
    	if(typeof(ICN_ADAPTER) == "undefined"){
    	    // A sequecing behaviour error, such as a resume of a suspended disabled acvtivity
    	    doExecuteAction(activelms.SequencingEngine.JUMP, str_ScoID, initMvcCallback);  
    	}
    	else{
   		    ICN_ADAPTER.adlNavRequest = "{target=" + str_ScoID + "}jump";
    	    doUnloadCurrentActivity();  
    	} 
    };
 
 	/**
 	 * 
 	 */
	this.doPrevious = function(){	
    	ICN_ADAPTER.adlNavRequest = activelms.SequencingEngine.PREVIOUS; 
    	doUnloadCurrentActivity();   
	};
	
	/**
	 * 
	 */
	this.doContinue = function(){	
    	ICN_ADAPTER.adlNavRequest = activelms.SequencingEngine.CONTINUE;
    	doUnloadCurrentActivity();   
	};

	/**
	 * 
	 */
	this.doExit = function(){	
    	str_PendingAdlNavRequest = activelms.SequencingEngine.EXIT;
    	doUnloadCurrentActivity();   
	}
	
	/**
	 * 
	 */
	this.doAbandon = function(b_Confirm){	
    	if(!b_Confirm){
	    	var str_Title = win_Sequencer.ICN_MODEL.get("title");
	    	var str_Message = ICN_CONFIRM_ABANDON + ": " + str_Title + "?"
        	obj_PlayerUI.showConfirm(str_Message, doAbandon);
    	}
    	else {
        	str_PendingAdlNavRequest = activelms.SequencingEngine.ABANDON;
        	doUnloadCurrentActivity(); 
    	}
	};
    
    /**
     * 
     */
    this.doExitAll = function(){
    	str_PendingAdlNavRequest = activelms.SequencingEngine.EXIT_ALL;
    	doUnloadCurrentActivity();   
    };
    
    /**
     * 
     */
	this.doSuspendAll = function(b_Confirm){	 
    	if(!b_Confirm){
	    	var str_Title = ICN_MODEL.get("title");
	    	var str_Message = ICN_CONFIRM_SUSPEND_ALL + ": " + str_Title + "?";
        	obj_PlayerUI.showConfirm(str_Message, doSuspendAll);
    	}
    	else{
        	doExecuteAction(activelms.SequencingEngine.SUSPEND_ALL, undefined, mvcCallback);
    	}
    };

    /**
     * 
     */
	this.doAbandonAll = function(b_Confirm){
    	if(!b_Confirm){
	    	var str_Message = ICN_CONFIRM_ABANDON_ALL +"?"
        	obj_PlayerUI.showConfirm(str_Message, doAbandonAll);
    	}
    	else{
        	doExecuteAction(activelms.SequencingEngine.ABANDON_ALL, undefined, mvcCallback);	 
    	}
	};
	

	this.windowClosingUnload = function(){
        doUnloadCurrentActivity(); 
	};

	/**
	 * 
	 */
	this.doServiceCall = function(b_Confirm){
    	if(!b_Confirm){
	    	var str_Message = "Would you like to see SCORM tracking data for your session?"
        	obj_PlayerUI.showConfirm(str_Message, doServiceCall);
    	}
    	else{
	    	obj_PlayerUI.showView(obj_View, "tracking.php");
    	}
	};
	
    /*
     * @private
     */
    var doExpireAll = function(){  
    	var obj_ActivityTree = win_Sequencer.ICN_MODEL.get("activityTree");
    	if(obj_ActivityTree.getCurrentActivity()){
    		if(!activelms.SequencingBehaviour.isSequencingFinished){
    			// The sequencing session has started but not finished
        		str_PendingAdlNavRequest = activelms.SequencingEngine.EXPIRE_ALL;
        		doUnloadCurrentActivity(); 
    		}
    	}
    	else{
    		// The user has not viewed any SCOs, so a view may be undefined;
    		//TODO  needs to move to Player UI?
    		if(!obj_View){obj_View = win_Sequencer;}
        	expireMvcCallback();
    	}
    };

    this.doTerminate = function(){
    	// Model values
    	var str_ScormType = win_Sequencer.ICN_MODEL.get("scormType");
        log.debug("doTerminate running fro scorm type=" + str_ScormType);
    	switch(str_ScormType){
        	case "asset":onSCOTerminated();break;
        	case "sco":
		    if(!ICN_ADAPTER.isTerminated){
		        var str_Result = "false";
		        if(window.API_1484_11 && window.API_1484_11.Terminate){
                    log.debug("doTerminate running API.Terminate");
				    str_Result = window.API_1484_11.Terminate("");
                }
                else if(window.API && window.API.LMSFinish){
                    log.debug("doTerminate running API.LMSFinish");
                    str_Result = window.API.LMSFinish("");
                }
			    //var str_Result = ICN_ADAPTER.Terminate("");
			    if(str_Result == "false"){onSCOTerminated();}
            }
            else{onSCOTerminated();}break; 
			default: 
			str_PendingAdlNavRequest = activelms.SequencingEngine.EXIT_ALL;
			onSCOTerminated();
    		//var str_ErrorMsg  = "Unrecognised scorm type: " + str_ScormType;
            //obj_PlayerUI.doAjaxError(obj_View, new Error(str_ErrorMsg));
    	}
    };
     
	/*
	 * @private
	 */  
	var doExecuteAction = function(str_Action, str_AdlNavChoiceTarget, fn_Callback, b_Async){
		try{
	    	obj_PlayerUI.disableControls(true);
        	obj_PlayerUI.showProgress(true);
        	
        	// Default AJAX is async
        	if(typeof(b_Async) == "undefined"){b_Async = true;}
        	
	    	// Invoke an MVC action
	    	activelms.Controller.execute(
	        	str_Action, 
	        	str_AdlNavChoiceTarget, 
	        	win_Sequencer.ICN_MODEL, 
	        	fn_Callback,
	        	b_Async);
    	}
		catch(error){
	    	obj_PlayerUI.doAjaxError(obj_View, error);
		}	
	};
      
	/*
	 * @private
	 */  
    var initMvcCallback = function(obj_ModelAndView){
    	
        var obj_Model = obj_ModelAndView.getModel();
        if(obj_Model.get("error")){
        	obj_PlayerUI.doAjaxError(obj_View, obj_Model.get("error"));
        	return;
        }
        
        // Instantiate the API Adapter
        var obj_ActivityTree = obj_Model.get("activityTree");
	    var float_ScormVersion = obj_ActivityTree.getScormVersion();
	    var b_IsDebugAjax = obj_Model.get("isDebugAjax");
	    var str_SoapAddressLocation = obj_Model.get("CMIRunEndPoint");
	    var str_Mode = obj_Model.get("mode");

	    // Instantiate the API Adapter ready for any SCO
	    try{
	    	ICN_ADAPTER = createAPIAdapter(
	    		float_ScormVersion, b_IsDebugAjax, str_SoapAddressLocation, str_Mode);
	    }
	    catch(obj_Error){
        	obj_PlayerUI.doAjaxError(obj_View, obj_Error);
        	return;
	    }
	    
	    // Add properties to the API Adapter
	    ICN_ADAPTER.learnerName = obj_Model.get("learnerName");
	    ICN_ADAPTER.learnerId = obj_Model.get("learnerID");
    	ICN_ADAPTER.courseId = obj_Model.get("courseID");
  	    ICN_ADAPTER.orgId = obj_Model.get("orgID");// from service tree build
  	    ICN_ADAPTER.scoId = obj_Model.get("scoID");
        ICN_ADAPTER.sessionId = obj_Model.get("sessionID");
        ICN_ADAPTER.domainId = obj_Model.get("domainID");
        ICN_ADAPTER.rteSchemaVersion = obj_Model.get("schemaVersion");
        ICN_ADAPTER.boolean_Async = obj_Model.get("isAsyncAjax");
	    ICN_ADAPTER.onAPIEvent = onAPIEvent;
	    ICN_ADAPTER.isNavRequestValid = isNavRequestValid;// req for SCO based navigation

        // Call back to complete any custom UI set up on the page
        win_Sequencer.onPlayerInit(obj_View, obj_ModelAndView.getView());
    };
      
	/*
	 * @private
	 */  
    var mvcCallback = function(obj_ModelAndView){
        var obj_Model = obj_ModelAndView.getModel();
        if(obj_Model.get("error")){
        	obj_PlayerUI.doAjaxError(obj_View, obj_Model.get("error"));
        	return;
        }
        
		var str_ScoID = obj_Model.get("scoID");
		if(!activelms.SequencingBehaviour.isSequencingFinished){
			if(str_ScoID){
				ICN_ADAPTER.scoId = str_ScoID;
				obj_PlayerUI.updateUI(obj_View, obj_ModelAndView.getView());
			}
			else{
				var obj_Error = new Error("Cannot update UI when scoID is not defined");
				obj_PlayerUI.doAjaxError(obj_View, obj_Error);
			}
		}
		else{
			// Sequencing session finished - show the root page
			obj_PlayerUI.updateUI(obj_View, obj_ModelAndView.getView());
		}
    };
    
    /*
     * @private
     */
    var orgMvcCallback = function(obj_ModelAndView){
    	// Update the model
    	win_Sequencer.ICN_MODEL.put("orgID", str_PendingOrgIdRequest);
   		win_Sequencer.ICN_MODEL.put("actvityTree", undefined);
    	// Update the SCORM adapter
  		ICN_ADAPTER.orgId = str_PendingOrgIdRequest;
  		// Start or Resume
    	doExecuteAction(activelms.SequencingEngine.INIT, null, initMvcCallback);
    };
    
    /*
     * @private
     */
    var expireMvcCallback = function(obj_ModelAndView){
    	
    	// For Master Teacher case # 00001628
		if(typeof(obj_ToolbarTextItem) != "undefined"){
			obj_PlayerUI.doSetToolbarText(" ");
			obj_ToolbarTextItem.disable();
		}
    	
		var str_Url = win_Sequencer.ICN_MODEL.get("viewTimeOutUrl");
		var str_SkinID = win_Sequencer.ICN_MODEL.get("skinID");
		var str_Culture = win_Sequencer.ICN_MODEL.get("culture");
		str_Url += "?skinID=" + str_SkinID;
		str_Url += "&culture="+str_Culture;
		obj_PlayerUI.showView(obj_View, str_Url);
    	if(b_NewWindow){
    		win_Sequencer.location = str_Url;
    	}
    };
    
    /*
     * @private
     */
    var exitAllMvcCallback = function(obj_ModelAndView){
    	
    	// For Master Teacher case # 00001628
		if(typeof(obj_ToolbarTextItem) != "undefined"){
			obj_PlayerUI.doSetToolbarText(" ");
			obj_ToolbarTextItem.disable();
		}
    	
		var str_Url = win_Sequencer.ICN_MODEL.get("viewRootUrl");
		var str_SkinID = win_Sequencer.ICN_MODEL.get("skinID");
		var str_Culture = win_Sequencer.ICN_MODEL.get("culture");
		str_Url += "?skinID=" + str_SkinID;
		str_Url += "&culture=" + str_Culture;
    	obj_PlayerUI.showView(obj_View, str_Url);
    	if(b_NewWindow){
    		win_Sequencer.location = str_Url;
    	}
    };
    
    /*
     * @private
     */
     var isNavRequestValid = function(scoId, str_AdlNavRequest){

        // If there is an activity with for the identifier in the "choice.{target=", then test
        var int_Index = str_AdlNavRequest.indexOf("choice.{target=");
        if(int_Index == 0){
            var int_StartIndex = "choice.{target=".length;
            var int_EndIndex = str_AdlNavRequest.lastIndexOf("}");
            var str_Identifier = str_AdlNavRequest.substring(int_StartIndex, int_EndIndex);
            var obj_ActivityTree = win_Sequencer.ICN_MODEL.get("activityTree");
            var obj_Activity = obj_ActivityTree.findByName(str_Identifier);
            if(obj_Activity){
                if(obj_Activity.isHiddenForChoice() || obj_Activity.isDisabledForChoice()){
                    return false;
                }
                return true;
            }
        }
        
        // If there is an activity with for the identifier in the "jump.{target=", then test
        int_Index = str_AdlNavRequest.indexOf("jump.{target=");
        if(int_Index == 0){
            var int_StartIndex = "jump.{target=".length;
            var int_EndIndex = str_AdlNavRequest.lastIndexOf("}");
            var str_Identifier = str_AdlNavRequest.substring(int_StartIndex, int_EndIndex);
            var obj_ActivityTree = win_Sequencer.ICN_MODEL.get("activityTree");
            var obj_Activity = obj_ActivityTree.findByName(str_Identifier);
            if(obj_Activity){
                return true;
            }
        }

        var b_PreviousOK = win_Sequencer.ICN_MODEL.get("canSequenceForPrevious");
        var b_ContinueOK = win_Sequencer.ICN_MODEL.get("canSequenceForContinue");
        
     	switch(str_AdlNavRequest){
     		case activelms.SequencingEngine.EXIT:
     		return true;
     		case activelms.SequencingEngine.ABANDON:
     		return true;
     		case activelms.SequencingEngine.EXIT_ALL:
     		return true;
     		case activelms.SequencingEngine.SUSPEND_ALL:
     		return true;
     		case activelms.SequencingEngine.ABANDON_ALL:
     		return true;
     		case activelms.SequencingEngine.PREVIOUS:
            return b_PreviousOK;
     		case activelms.SequencingEngine.CONTINUE:
            return b_ContinueOK;
     		case activelms.SequencingEngine.CHOICE:
     		return true;
     		case activelms.SequencingEngine.JUMP:
     		return true;
     		default:
     		return false;
     	}
     };
    
	/*
	 * @private
	 */ 
	var onAPIEvent = function(str_Code, str_Action, str_ScoID, str_AdlNavRequest, str_Exit) {

    	if (str_Code == "0") {
    		switch(str_Action){
    			case "Initialize":
    			onSCOInitialized(str_ScoID);
    			break;
    			case "Commit":
    			onSCOCommitted(str_ScoID);
    			break;
    			case "Terminate":
    			onSCOTerminated(str_ScoID,str_Exit);
    			break;
    			default:
    			var str_ErrorMsg  = "Unknown API event on " + str_Action ;
            	obj_PlayerUI.doAjaxError(obj_View,new Error(str_ErrorMsg));
    		}
    	}
    	else{
    		var str_ErrorMsg  = "Error on " + str_Action + " with SCO: " + str_ScoID + ", Error code: " + str_Code;
            obj_PlayerUI.doAjaxError(obj_View,new Error(str_ErrorMsg));
    	}
    };
    
    var onSCOInitialized = function(str_ScoID){

    	// Get the model propertes from the activity tree
    	var f_CompletionThreshold = win_Sequencer.ICN_MODEL.get("completionThreshold");
    	var str_LaunchData = win_Sequencer.ICN_MODEL.get("launchData");
    	var str_MaxTimeAllowed = win_Sequencer.ICN_MODEL.get("maxTimeAllowed");
    	var f_ScaledPassingScore = win_Sequencer.ICN_MODEL.get("scaledPassingScore");
    	var str_TimeLimitAction = win_Sequencer.ICN_MODEL.get("timeLimitAction");
    	var b_Tracked = win_Sequencer.ICN_MODEL.get("tracked");
    	var str_LessonMode = win_Sequencer.ICN_MODEL.get("mode");
    	var int_AttemptCount = win_Sequencer.ICN_MODEL.get("attemptCount");
    
    	// The SCO will also need to update the state of the tree...
		if(str_LessonMode!="browse"){
        	//var str_CompletionStatus = globalAdapter.getElementText(globalAdapter.cocd, "completionStatus");
        	var str_CompletionStatus = 
        		ICN_ADAPTER.getElementText(ICN_ADAPTER.cocd, "completionStatus");
        	var b_ProgressStatus = false;
        	var b_CompletionStatus = false;
        	switch(str_CompletionStatus){
            	case "unknown":
            	b_ProgressStatus = false;
            	b_CompletionStatus = false;
            	break;
            	case "not attempted":
            	b_ProgressStatus = false;
            	b_CompletionStatus = false;
            	break;
            	case "incomplete":
            	b_ProgressStatus = true;
            	b_CompletionStatus = false;
            	break;
            	case "completed":
            	b_ProgressStatus = true;
            	b_CompletionStatus = true;
            	break;
        	}
        
        	// Not strictly SCORM, but helpful to users
        	if(int_AttemptCount > 1){b_ProgressStatus = true;}
        	// TODO Global function required?
        	obj_PlayerUI.doSetCompletionStatus(str_ScoID, b_ProgressStatus, b_CompletionStatus);
    	}
    	
    	// Update the API Adapter with activity tree properties
		if(f_CompletionThreshold){
        	ICN_ADAPTER.setElementText(ICN_ADAPTER.cocd, "completionThreshold", f_CompletionThreshold.toString());
    	}
    	ICN_ADAPTER.setElementText(ICN_ADAPTER.cocd, "launchData", str_LaunchData);
    	ICN_ADAPTER.setElementText(ICN_ADAPTER.cocd, "mode", str_LessonMode);
    	ICN_ADAPTER.setElementText(ICN_ADAPTER.cocd, "maxTimeAllowed", str_MaxTimeAllowed);
		if(f_ScaledPassingScore){
        	ICN_ADAPTER.setElementText(ICN_ADAPTER.cocd, "scaledPassingScore", f_ScaledPassingScore.toString());
    	}
    	ICN_ADAPTER.setElementText(ICN_ADAPTER.cocd, "timeLimitAction", str_TimeLimitAction);
    	// The cmi.objectives.n. 
    	var cmi_Objectives = ICN_ADAPTER.getElement(ICN_ADAPTER.cocd, "objectives");
    	// The sequencing tracking model
    	var arr_ObjectiveSet = win_Sequencer.ICN_MODEL.get("objectiveSet");

    	var int_Count = arr_ObjectiveSet.length;
    	var str_ObjectiveID = undefined;
    	var obj_ObjProgressInfo = undefined;
    	var str_SuccessStatus = "unknown";
   	 	var f_ScoreScaled = undefined;
    	var b_SatisfiedStatusReadMap = false;
    	var b_NormalizedMeasureReadMap = false;
    	
    	for(var i=0; i<int_Count; i++){
    
        	// cmi.objectives.n.id
        	str_ObjectiveID = arr_ObjectiveSet[i].getObjectiveID();
        	b_SatisfiedStatusReadMap = arr_ObjectiveSet[i].hasSatisfiedStatusReadMap();
        	b_NormalizedMeasureReadMap = arr_ObjectiveSet[i].hasNormalizedMeasureReadMap();
        
        	// Only initialize objectives for valid IDs
        	if(!isValidURI(str_ObjectiveID)){continue;}

        	obj_ObjProgressInfo = arr_ObjectiveSet[i].getObjectiveProgressInfo();
        
        	// cmi.objectives.n.success_status
        	str_SuccessStatus = "unknown";
        	if(obj_ObjProgressInfo.getProgressStatus()){
            	str_SuccessStatus = "failed";
            	if(obj_ObjProgressInfo.getSatisfiedStatus()){
                	str_SuccessStatus = "passed";
            	}
        	}
        
        	// cmi.objectives.n.score.scaled
        	f_ScoreScaled = undefined;
        	if(obj_ObjProgressInfo.getMeasureStatus()){
            	f_ScoreScaled = obj_ObjProgressInfo.getNormalizedMeasure();
            	if((f_ScoreScaled < -1.0) || (f_ScoreScaled > 1.0)){
                	f_ScoreScaled = undefined;
            	}
        	}
        
        	// The find the cmi.objectives.n...
        	var cmi_Objective = ICN_ADAPTER.findObjectiveById(cmi_Objectives, str_ObjectiveID);

        	// Or create
        	if(typeof(cmi_Objective) == "undefined" || cmi_Objective===null){
            	cmi_Objective = ICN_ADAPTER.newElement("objective");
            	cmi_Objectives.appendChild(cmi_Objective);
            	ICN_ADAPTER.setElementText(cmi_Objective, "identifier", str_ObjectiveID);
            	ICN_ADAPTER.setElementText(cmi_Objective, "successStatus", "unknown");
            	ICN_ADAPTER.setElementText(cmi_Objective, "completionStatus", "unknown");
        	}

        	if(b_Tracked==true){
            	ICN_ADAPTER.setElementText(cmi_Objective, "successStatus", str_SuccessStatus);
        	}
        	else if(b_Tracked==false && b_SatisfiedStatusReadMap){
            	if(str_SuccessStatus != "unknown"){
                	ICN_ADAPTER.setElementText(cmi_Objective, "successStatus", str_SuccessStatus);
            	}
        	}
        	else{
            	//globalAdapter.setElementText(cmi_Objective, "successStatus", "unknown");
        	}

        	if(typeof(f_ScoreScaled) != "undefined"){

            	var cmi_Score = ICN_ADAPTER.getElement(cmi_Objective, "score");
            	if(typeof(cmi_Score) == "undefined" || cmi_Score===null){
                	cmi_Score = ICN_ADAPTER.newElement("score");
                	cmi_Objective.appendChild(cmi_Score);
                
                	var cmi_Scaled = ICN_ADAPTER.getElement(cmi_Score, "scaled");
                	if(typeof(cmi_Scaled) == "undefined" || cmi_Scaled===null){
                    	cmi_Scaled = ICN_ADAPTER.newElement("scaled");
                    	cmi_Score.appendChild(cmi_Scaled);
                	}
             	}

            	if(b_Tracked==true){
                	ICN_ADAPTER.setElementText(cmi_Score, "scaled", f_ScoreScaled.toString());
            	}
            	else if(b_Tracked==false && b_NormalizedMeasureReadMap){
                	if(typeof(f_ScoreScaled) != "undefined"){
                    	ICN_ADAPTER.setElementText(cmi_Score, "scaled", f_ScoreScaled.toString());
                	}
            	}
            	else{
                	//undefined
                	 //TODO check
            	}
         	}
    	}
    };
    
    var onSCOCommitted = function(str_ScoID){
		// empty method stub, no implementation on commit event
    };
    
    var onSCOTerminated = function(str_ScoID, str_Exit){
    
    	if(ICN_ADAPTER){


            ICN_MODEL.put("cocd",ICN_ADAPTER.cocd);
        
		    // Get the pending navigation request and target, could have been set by the SCO
		    var str_AdlNavChoiceTarget = ICN_ADAPTER.adlNavChoiceTarget;
		    var str_AdlNavRequest = ICN_ADAPTER.adlNavRequest;

	        if(str_Exit == "timeout"){str_AdlNavRequest = activelms.SequencingEngine.EXIT_ALL;}
		    if(win_Api.API){
	    	    // In SCORM 1.2, user has logged out from within the SCO, and so control is passed to the LMS
	    	    if(str_Exit == "logout"){str_AdlNavRequest = activelms.SequencingEngine.EXIT;}
		    }

		
		    if(str_AdlNavRequest.indexOf("{target=") != -1){
			    // There is a choice or jump navigation request, so get the target scoID
			    str_AdlNavChoiceTarget = getAdlNavChoiceOrJumpTarget(str_AdlNavRequest);
			    //str_AdlNavRequest = activelms.SequencingEngine.CHOICE;
			    // replaced in SCORM 2004 4th ED
			    str_AdlNavRequest = getAdlNavChoiceOrJumpRequest(str_AdlNavRequest);
		    }
    	}
		
		if(!ICN_WINDOW_CLOSED_EVT){
		    // Only use a pending nav request if the window is not closing...
		    if(str_PendingAdlNavRequest){
			    // There is a pending ADL navigation reqyest
			    str_AdlNavRequest = str_PendingAdlNavRequest;
			    str_PendingAdlNavRequest = undefined;
			}
		}
		
		// Invoke the MVC controller
	    if(str_AdlNavRequest == activelms.SequencingEngine.EXPIRE_ALL){
		    doExecuteAction(activelms.SequencingEngine.EXIT_ALL, undefined, expireMvcCallback);
	    }
	    else if(str_AdlNavRequest==activelms.SequencingEngine.EXIT_ALL){
    		var obj_ActivityTree = win_Sequencer.ICN_MODEL.get("activityTree");
    		if(obj_ActivityTree && obj_ActivityTree.getCurrentActivity()){
    			if(!activelms.SequencingBehaviour.isSequencingFinished){
    			    // If this called because window close, make Sequencing Service calls synchronous
    			    var b_Async = true;
                    if(ICN_WINDOW_CLOSED_EVT){b_Async = false;}
		    		doExecuteAction(activelms.SequencingEngine.EXIT_ALL, undefined, exitAllMvcCallback,b_Async);
    			}
    		}
    		else{
    			exitAllMvcCallback();
    		}
	    }
	    else{
	    	if(str_AdlNavRequest && (str_AdlNavRequest!=activelms.SequencingEngine.NONE)){
		    	doExecuteAction(str_AdlNavRequest, str_AdlNavChoiceTarget, mvcCallback);
	    	}
		}
    };
    
	/*
	 * @private
	 */ 
	var doUnloadCurrentActivity = function(){

        log.debug("run doUnloadCurrentActivity");
    	/*
    	 * Pseudo Code
    	 * 
    	 * IF view is undefined THEN open a window
    	 * ELSE IF view is a window (catch IE error)
    	 * 	IF the window is closed, open it
    	 * 	ELSE write to the window to unload its content
    	 */
    	 
    	 if(!obj_View){
    		if(b_NewWindow){
    			//obj_View = window.open("",str_NewWindowName);
    			obj_View = openWindow("",str_NewWindowName);
				obj_View.focus();
    			doTerminate();
    		}
    	 }
    	 else{
    	 	try{
    	 		var test = obj_View.window;
    	 		test = obj_View.closed;
    	 	}
    	 	catch(e){
    	 		// IE gives an error if we call closed on a closed window
    			if(b_NewWindow){
    			 	obj_View = null;
    				//obj_View = window.open("",str_NewWindowName);
    				obj_View = openWindow("",str_NewWindowName);
					obj_View.focus();
    				doTerminate();
    				return;
    			}
    	 	}
    	 	if(obj_View && obj_View.closed){
    	 		// Do not test for obj_View.window in Safari
    			//obj_View = window.open("",str_NewWindowName);
    			obj_View = openWindow("",str_NewWindowName);
				obj_View.focus();
    			doTerminate();
    	 	}
    	 	else{
				var str_Url = win_Sequencer.ICN_MODEL.get("viewUnloaderUrl"); 
				str_Url += "?skinID=";
				str_Url += win_Sequencer.ICN_MODEL.get("skinID");
				str_Url += "&culture=";
				str_Url += win_Sequencer.ICN_MODEL.get("culture");
                log.debug("run doUnloadCurrentActivity with view="+str_Url);
				obj_PlayerUI.showView(obj_View, str_Url);
    	 	}
    	 }
	};
	
	var openWindow = function(str_Url, str_Name){
				
		//var int_Width = screen.availWidth-50
		//var int_Height = screen.availHeight-100;
		var int_Width = 1048;
		var int_Height = 768;
		var int_Left = (screen.width/2) - (int_Width/2);
		var int_Top = (screen.height/2) - (int_Height/2);
	
		var str_Attributes = 'width=' + int_Width + ",";
		str_Attributes += 'height=' + int_Height + ",";
		str_Attributes += 'left=' + int_Left + ",";
		str_Attributes += 'top=' + int_Top + ",";
		str_Attributes += 'screenX=' + int_Left + ",";
		str_Attributes += 'screenY=' + int_Top + ",";
		str_Attributes += 'toolbar=no,';
		str_Attributes += 'resizable=yes,';
		str_Attributes += 'scrollbars=no,';
		str_Attributes += 'location=no,';
		str_Attributes += 'directories=no,';
		str_Attributes += 'status=yes,';
		str_Attributes += 'menubar=no,';
		str_Attributes += 'copyhistory=yes';
	
		var win = window.open(str_Url,str_Name,str_Attributes);
		return win;
	};
	
	/*
	 * @private
	 */  
    var createAPIAdapter = function(
    	float_ScormVersion, 
    	b_IsDebugAjax, 
    	str_SoapAddressLocation, 
    	str_Mode){
    	
    	var obj_Adapter2004 = undefined;
		if (window.XMLHttpRequest) {
			obj_Adapter2004 = new activelms_APIAdapter(
				null, b_IsDebugAjax, str_SoapAddressLocation, str_Mode);
		}
		else if (window.ActiveXObject) {
			var msXmlObj = getMsXmlObj();
			if(msXmlObj != null){
				obj_Adapter2004 = new activelms_APIAdapter(
					msXmlObj, b_IsDebugAjax, str_SoapAddressLocation, str_Mode);
			}
		}
		else{
			throw new activelms.ApplicationError("Could not instantiate a SCORM 2004 API Adapter");
		}
		
		if(float_ScormVersion < 2004){
	   	 	// SCORM 1.2 adapter
	    	win_Api.API = new activelms_4JS_APIAdapter(obj_Adapter2004);
    	}
    	else{
        	// SCORM 2004 adapter
	    	win_Api.API_1484_11 = obj_Adapter2004;
    	}
    	return obj_Adapter2004;
    };
    
    /*
     * @private
     */
	var getMsXmlObj = function(){
		var msxmlProgId = null;	
    	try {
        	var msxmlActiveXObj = new ActiveXObject("Msxml2.DOMDocument.4.0");
      		msxmlProgId = "Msxml2.DOMDocument.4.0";
     	} 
		catch (e) {
    		try {
        		var msxmlActiveXObj = new ActiveXObject("Msxml2.DOMDocument.3.0");
           		msxmlProgId = "Msxml2.DOMDocument.3.0";
        	} 
       		catch (innerExc) {
       			msxmlProgId = null;
       		}
		}
    	return msxmlProgId;
	};
    
    /*
     * private
     * returns the target for the choice ot jump sequencing request
     */
	var getAdlNavChoiceOrJumpTarget = function(str_AdlNavRequest){
		return str_AdlNavRequest.substring(
			str_AdlNavRequest.indexOf("=")+1, 
			str_AdlNavRequest.indexOf("}"));
	};
	
    /*
     * private
     * returns the request for the choice ot jump sequencing request
     */
	var getAdlNavChoiceOrJumpRequest = function(str_AdlNavRequest){
		var requestType = str_AdlNavRequest.substring(
			str_AdlNavRequest.indexOf("}")+ 1,
			str_AdlNavRequest.length);

		switch(requestType){
		    case "choice": return activelms.SequencingEngine.CHOICE;
		    case "jump": return activelms.SequencingEngine.JUMP;
		    default: return activelms.SequencingEngine.UNDEFINED;
		}
	};
	
	/*
	 * Called from onSCOInitialized to test objective ID
	 * @private
	 */
	var isValidURI = function(str_Identifier){
    	// String properties
    	if(typeof(str_Identifier) == "undefined"){return false;}
    	if(str_Identifier == "undefined"){return false;}
    	if(str_Identifier === null){return false;}
    	if(str_Identifier.length === 0){return false;}
    	if(str_Identifier.length > 4000){return false;}
    
		// Any white space
		var reg = new RegExp("\\s");
		if (reg.test(str_Identifier)){return false;}
		
		// Any non-word character [^A-Za-z0-9] fails for "gObj-OB14a-1"
		//reg = new RegExp("\\W");
		//if (reg.test(str_Identifier)){return false;}
	
		return true;
	};
	
	/*
	 * @public
	 */
	this.unloadMain = function(){
	
	    // Required for Safari, which does not support onbeforeunload event handler
        ICN_WINDOW_CLOSED_EVT = true;
        if(ICN_ADAPTER){
            ICN_ADAPTER.adlNavRequest = activelms.SequencingEngine.EXIT_ALL;
        }
        
	    // Make the CMI Data Model Synchronous
	    win_Sequencer.ICN_MODEL.put("isAsyncAjax",false);
	    if(ICN_ADAPTER){
    	    ICN_ADAPTER.boolean_Async = false;
    	}

    	try {
	        var str_ScormType = win_Sequencer.ICN_MODEL.get("scormType");
	        log.debug("unloadMain run onunload event handler, last resource scorm type=" + str_ScormType);
			// If SCO was last resource type AND initialized
			var b_RunTerminateOnScoUnload = false;
			if(str_ScormType=="sco"){
			    var str_Initialized = ICN_ADAPTER.isInitialized();
			    var b_Initialized = stringToBoolean(str_Initialized);
                log.debug("API isInitialized=" + b_Initialized);
                log.debug("API isTerminated=" + ICN_ADAPTER.isTerminated);
			    if(b_Initialized){
			        if(!ICN_ADAPTER.isTerminated){
			            // Allow the initialized and unterminates sco to unload and trigger its own onunload
			            b_RunTerminateOnScoUnload = true;
			        }
                }
			}
	        
		    if(!b_RunTerminateOnScoUnload){
			    if(!activelms.SequencingBehaviour.isSequencingFinished){	
	                log.debug("unloadMain run ExitAll navigation request for isSequencingFinished=" 
	                    + activelms.SequencingBehaviour.isSequencingFinished);    
                    // Invoke the Sequencing Service, if the sequencing session is not finished.
        	        doExecuteAction(activelms.SequencingEngine.EXIT_ALL, undefined, mvcCallback, false);
        	     }
			}
		}
		catch (obj_Error) {}
	};
	
	/*
	 * @private
	 */
    var stringToBoolean = function(string){
        switch(string.toLowerCase()){
                case "true": case "yes": case "1": return true;
                case "false": case "no": case "0": case null: return false;
                default: return Boolean(string);
        }
    };
};





