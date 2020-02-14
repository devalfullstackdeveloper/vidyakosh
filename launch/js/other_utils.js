var win_Target = null;
function getChildWindow(win_Parent, str_WinName){
	var arr_Frames = win_Parent.frames;
	
	var i = arr_Frames.length-1;
	do {
		var win_Child = arr_Frames[i];
		if(win_Child && win_Child.name == str_WinName){
			win_Target = win_Child;
			break;
		}
		if(win_Child.frames && win_Child.frames.length > 0){
			getChildWindow(win_Child, str_WinName);
		}
		--i;
	}
	while (i>=0);

	return win_Target;
}

function findChildWindow(str_WinName){
	return getChildWindow(window.top, str_WinName);
}

function resizeFramesetCols(str_FramesetID, str_Args){
	 window.top.document.getElementById(str_FramesetID).setAttribute("cols", str_Args);
}

function getBlankPage(win_Frame){
	var str_Color = null;
	if(!win_Frame){
		try{win_Frame = findChildWindow("TitleFrame");}
		catch(error){str_Color = "ThreedFace";}
	}
	else{
		try{
			var el_Body = win_Frame.document.getElementsByTagName("body").item(0);
			str_Color = el_Body.style['backgroundColor'];
			if(str_Color == null || str_Color.length == 0){
				str_Color = document.bgColor;
			}
		}
		catch(error){str_Color = "ThreedFace";}
	}
	if(str_Color == null){
		str_Color = "ThreedFace";
	}
	
	var str_BlankPage = '<html><body style="background-color:' + str_Color + ';"></body></html>';
	return str_BlankPage;
}

function getWindowAttributes(int_Width, int_Height, boolean_Resize, boolean_Status){

	var int_Left = (screen.width/2) - (int_Width/2);
	var int_Top = (screen.height/2) - (int_Height/2);
	
	var str_Attributes = 'width=' + int_Width + ",";
	str_Attributes += 'height=' + int_Height + ",";
	str_Attributes += 'left=' + int_Left + ",";
	str_Attributes += 'top=' + int_Top + ",";
	str_Attributes += 'screenX=' + int_Left + ",";
	str_Attributes += 'screenY=' + int_Top + ",";
	str_Attributes += 'toolbar=no,';
	if(boolean_Resize)str_Attributes += 'resizable=yes,';
	else str_Attributes += 'resizable=no,';
	str_Attributes += 'scrollbars=no,';
	str_Attributes += 'location=no,';
	str_Attributes += 'directories=no,';
	if(boolean_Status)str_Attributes += 'status=yes,';
	else str_Attributes += 'status=no,';
	str_Attributes += 'menubar=no,';
	str_Attributes += 'copyhistory=yes';

	return str_Attributes;
}

function getModalDialogAttributes(int_Width, int_Height, boolean_Resize, boolean_Status){
	
	var int_Left = (screen.width/2) - (int_Width/2);
	var int_Top = (screen.height/2) - (int_Height/2);
	
	var str_Attributes = "dialogWidth: " + int_Width + "px;";
	str_Attributes += "dialogHeight: " + int_Height + "px;";
	str_Attributes += "dialogLeft: " + int_Left + "px;";
	str_Attributes += "dialogTop: " + int_Top + "px;";
	if(boolean_Resize)str_Attributes += "resizable: yes;";
	else str_Attributes += "resizable: no;";
	str_Attributes += "scroll: no;";
	str_Attributes += "help: no;";
	if(boolean_Status)str_Attributes += "status: yes;";
	else str_Attributes += "status: no;";

	return str_Attributes;
}

function openDialog(str_Url, int_Width, int_Height, boolean_Modal){
	var str_Name = "activelmsPlayerDialog";
	
	if(document.all && boolean_Modal){
		var str_Attributes = getModalDialogAttributes(int_Width, int_Height, false, false);
		return window.showModalDialog(str_Url, str_Name, str_Attributes);
	}
	else{
		var str_Attributes = getWindowAttributes(int_Width, int_Height, false, false);
		var win_Dialog = window.open(str_Url,str_Name,str_Attributes);
		win_Dialog.focus();
		return win_Dialog;
	}
}

var win_Player = null;
function openWindow(str_Url, int_Width, int_Height, boolean_Modal){

	if(!int_Width || int_Width==null || int_Width==0 || int_Width=="undefined"){
		int_Width = 800;
		int_Height = 600;
	}
	
	// Overide for full size
 	int_Width = screen.availWidth-50
	int_Height = screen.availHeight-100;
	
	var str_Name = "activelmsPlayer";
	var str_Attributes = getWindowAttributes(int_Width, int_Height, true, true);
	win_Player = window.open(str_Url,str_Name,str_Attributes);
	win_Player.focus();
}

function maximizeWindow(){
	window.moveTo(0,0);
	if (document.all) {
 		top.window.resizeTo(screen.availWidth,screen.availHeight);
	} 
	else if (document.layers|| document.getElementById) {
 		if (top.window.outerHeight < screen.availHeight || top.window.outerWidth < screen.availWidth){
  			top.window.outerHeight = screen.availHeight;
  			top.window.outerWidth = screen.availWidth;
 		}
	}
}

function getHeight(){
 	if (window.innerHeight) {
  		return window.innerHeight;
 	}
	if(document.body && document.body.offsetHeight){
		return document.body.offsetHeight;
	}
}



function divWrite(str_DivId, str_ParentDivId, str_Text) {

	try{
    	if (window.document.all) {
        	window.document.all[str_DivId].innerHTML = str_Text;
    	}
    	else if (window.document.layers) {
       		var obj_Layer;
       		if(str_ParentDivId){
         		obj_Layer = eval('document.' + str_ParentDivId + '.document.' + str_DivId + '.document');
       		}
       		else{
         		obj_Layer = window.document.layers[str_DivId].document;
       		}
       		obj_Layer.open();
       		obj_Layer.write(str_Text);
       		obj_Layer.close();
     	}
     	else if (parseInt(navigator.appVersion)>=5&&navigator.appName=="Netscape") {
       		window.document.getElementById(str_DivId).innerHTML = str_Text;
     	}
	}
	catch(error){
		// Div not found
	}
}

function hideShowDiv(str_DivId, boolean_Show){

	try{
		var str_State = "hidden";
		if(boolean_Show){
			str_State = "visible";
		}

		if (document.getElementById) { // DOM3 = IE5, NS6
			document.getElementById(str_DivId).style.visibility = str_State;
		}
		else if (document.layers){
			// Netscape 4
			eval("document." + str_DivId + ".visibility = '" + str_State +"'");
		}
		else if(document.all){ // IE 4
			eval("document.all." + str_DivId + ".style.visibility = ''" + str_State +"'");
		}
	}
	catch(error){
		// Div not found
	}
}

function doTrimLabel(str_Label, int_MaxCharacters){

    // Trim the label
	if(str_Label.length > int_MaxCharacters){
		str_Label = str_Label.substring(0,int_MaxCharacters);
		str_Label += "...";
	}
	
	// Ensure that spaces do not break - do this in a style sheet...
	/*
    var regExpr_Space = / /g;
    str_Label = str_Label.replace(regExpr_Space, "&nbsp;");
	*/
    
	return str_Label;
}

function replaceLiteral(str, str_Target, str_Replacement){
	return str.split(str_Target).join(str_Replacement);
}

function classChange(str_Style, obj_Element){
	if(obj_Element){
		obj_Element.className = str_Style;
	}
}

/*
 * Adds an event handler. 
 * For event type remove the "on" so that "onunload" is passed as "unload"
 */
function addEvent(obj_EventSrc, str_EventType, fn ) {
	if (obj_EventSrc.attachEvent ) {
		obj_EventSrc['e'+ str_EventType + fn] = fn;
		obj_EventSrc[str_EventType + fn] = function(){obj_EventSrc['e'+ str_EventType + fn]( window.event );}
		obj_EventSrc.attachEvent( 'on'+ str_EventType, obj_EventSrc[str_EventType + fn] );
	} 
	else{
		obj_EventSrc.addEventListener(str_EventType, fn, false);
	}
}

/*
 * Removes an event handler. 
 * For event type remove the "on" so that "onunload" is passed as "unload"
 */	
function removeEvent(obj_EventSrc, str_EventType, fn ) {
	if (obj_EventSrc.detachEvent ) {
		obj_EventSrc.detachEvent( 'on'+ str_EventType, obj_EventSrc[str_EventType + fn] );
		obj_EventSrc[str_EventType + fn] = null;
	} 
	else{
		obj_EventSrc.removeEventListener(str_EventType, fn, false);
	}
}

/*
var message="Right Mouse click is disabled.\n";
function clickIE4(){
    if (window.event.button==2){
    alert(message);
    return false;
    }
}

function clickNS4(e){
    if (window.document.layers||window.document.getElementById&&!document.all){
        if (e.which==2||e.which==3){
            alert(message);
            return false;
        }
    }
}

if (window.document.all && !window.document.getElementById){
    window.document.onmousedown=clickIE4;
}
else if (window.document.layers){
    window.document.captureEvents(Event.MOUSEDOWN);
    window.document.onmousedown=clickNS4;
}

window.document.oncontextmenu=new Function("alert(message);return false");
*/