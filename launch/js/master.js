var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(!activelms.AjaxClient){activelms.AjaxClient={};}
else if(typeof activelms.AjaxClient!="object"){throw new Error("namepsace activelms.AjaxClient exists");}
var DsQ=undefined;
var ICN_XML_HTTP_STATUS_0="";
var ICN_XML_HTTP_STATUS_1="";
var ICN_XML_HTTP_STATUS_2="";
var ICN_XML_HTTP_STATUS_3="";
var ICN_XML_HTTP_STATUS_4="";
var ICN_XML_HTTP_STATUS_5="";
var wRd=undefined;
var qiG=function(){
DsQ.send(wRd);
}
activelms.AjaxClient=function(){
this.bUV="SFR";
this.fce="MOZ";
this.rYi="OPR";
this.gHv="IE";
this.LrY="KONQ";
this.OHs="OTHER";
this.TVr="NS";
if(window.XMLHttpRequest){
DsQ=new XMLHttpRequest();
}
else if(typeof ActiveXObject!="undefined"){
var qrE=undefined;
var rNq=[
"Msxml2.XMLHTTP.5.0","Msxml2.XMLHTTP.4.0","MSXML2.XMLHTTP.3.0","MSXML2.XMLHTTP","Microsoft.XMLHTTP"
];
var PaW=rNq.length;
var ieE=false;
for(var SRI=0;SRI<PaW&&!ieE;SRI++){
try{
var wXF=new ActiveXObject(rNq[SRI]);
qrE=rNq[SRI];
ehG=true;
}catch(rul){
log.error(rul.toString())
}
}
if(!ieE){
var TWT="Could not find reference to system Active X(XMLHTTP.x)";
var nKd="Could not create an HTTP XML Request object";
var wYT="Client Error";
var IZH=
new activelms.ApplicationError(TWT,nKd,wYT);
throw IZH;
}
DsQ=new ActiveXObject(qrE);
}
else{
var TWT="window.XMLHttpRequest and ActiveXObject undefined";
var nKd="Could not create an HTTP XML Request object";
var wYT="Client Error";
var IZH=
new activelms.ApplicationError(TWT,nKd,wYT);
throw IZH;
}
var fqB=undefined;
var JUm=undefined;
this.error=undefined;
this.SDI=function(gPg,rJq,EZl,WEv,LsO){
activelms.NavigationBehaviour.lastRequestTimestamp=new Date();
BEr=this;
BEr.error=undefined;
log.info("Service Endpoint: "+rJq);
log.info("SOAP Action Header: "+WEv);
log.info("HTTP request action: "+gPg);
log.debug("XML HTTP request text: "+this.mLh(LsO.documentElement));
var nKd=PPQ(DsQ.readyState);
startTimer(nKd);
DsQ.open(gPg,rJq,EZl);
DsQ.setRequestHeader('Content-Type','text/xml; charset=utf-8');
DsQ.setRequestHeader('SOAPAction','\"'+WEv+'\"');

if((WEv.indexOf("Deliver")!=-1)||(WEv.indexOf("Terminate")!=-1)){
DsQ.onreadystatechange=this.PLi;
}
else{
DsQ.onreadystatechange=this.ZHo;
}
if(navigator.userAgent.indexOf("Firefox")!=-1){
if(EZl){
wRd=LsO;
setTimeout("qiG()",50);
}
else{
DsQ.send(LsO);
}
}
else{
DsQ.send(LsO);
}
}
this.DAN=function(LsO){
alert("Not implemented");
}
this.PLi=function(){
BEr.gpN();
if(DsQ.readyState==2){
stopTimer();
BEr.DAN(undefined);
}
if(DsQ.readyState==4){
BEr.bQH();
}
}
this.ZHo=function(){
BEr.gpN();
if(DsQ.readyState==4){
var usD=BEr.bQH();
if(usD){
toStatus(ICN_XML_HTTP_STATUS_5);
BEr.DAN(DsQ.responseXML);
}
}
}
this.gpN=function(){
stopTimer();
var nKd=PPQ(DsQ.readyState);
startTimer(nKd);
}
this.bQH=function(){
stopTimer();
var nKd=PPQ(DsQ.readyState);
toStatus(nKd);
var UYS=undefined;
var iQb=undefined;
var eMA=undefined;
try{
eMA=DsQ.status;
iQb=DsQ.responseXML;
}
catch(IZH){
UYS=IZH;
eMA=400;
}
log.info("HTTP response status code: "+eMA);
if(eMA===0||eMA==200){
var QWM=Sarissa.getParseErrorText(iQb);
if(QWM==Sarissa.PARSED_OK){
return true;
}
else
{
var TWT=QWM;
var nKd="Document Parsing Error"
var wYT="Document Fault";
var IZH=new activelms.ApplicationError(TWT,nKd,wYT);
BEr.DAN(iQb,IZH);
}
}
else if(eMA==400){
var nKd=undefined;
if(UYS){
nKd=UYS.toString();
}
else{
nKd=""+eMA;
}
log.info("HTTP response status: "+nKd);
log.error("XML HTTP response text: "+DsQ.responseText);
var IZH=new activelms.ApplicationError(DJe(eMA),nKd,"Client Fault");
BEr.DAN(undefined,IZH);
}
else{
var TWT="HTTP Status Code "+eMA;
var nKd=DJe(eMA);
var wYT="Server Fault";
if(iQb&&iQb.documentElement){
var dSj=iQb.documentElement;
var TWT=uiq(dSj,"SOAP Fault: ");
var nKd=DJe(eMA);
var wYT="Server Fault";
log.info("HTTP response status: "+DJe(eMA));
log.error("XML HTTP response text: "+DsQ.responseText);
log.error(nKd);
}
var IZH=new activelms.ApplicationError(TWT,nKd,wYT);
BEr.DAN(undefined,IZH);
}
}
var uiq=function(sBs,nKd){
if(!sBs){return nKd;}
var tJr=undefined;
if(sBs.hasChildNodes()){
var PaW=sBs.childNodes.length
for(var SRI=0;SRI<PaW;SRI++){
tJr=sBs.childNodes[SRI];
if(tJr.nodeType==1){
nKd=uiq(tJr,nKd);
}
else if(tJr.nodeType==3){
nKd+=tJr.nodeValue;
nKd+=": ";
}
}
}
return nKd;
}
var PPQ=function(xpv){
if(isUndefined(xpv)){
return ICN_XML_HTTP_STATUS_0;
}
switch(xpv){

case 0:return ICN_XML_HTTP_STATUS_0;
case 1:return ICN_XML_HTTP_STATUS_1;
case 2:return ICN_XML_HTTP_STATUS_2;
case 3:return ICN_XML_HTTP_STATUS_3;
case 4:return ICN_XML_HTTP_STATUS_4;
default:return ICN_XML_HTTP_STATUS_0;
}
}
var DJe=function(xpv){
switch(xpv){
case 200:
return "HTTP OK";
case 400:
return "HTTP Bad Request";
case 401:
return "HTTP Unauthorized";
case 403:
return "HTTP Forbidden";
case 404:
return "HTTP Not Found";
case 408:
return "HTTP Request Timeout";
case 500:
return "HTTP Internal Server Error";
case 501:
return "HTTP Not Implemented";
case 502:
return "HTTP Bad Gateway";
case 503:
return "HTTP Service Unavailable";
case 504:
return "HTTP Gateway Timeout";
default:
return "HTTP Status "+xpv;
}
}
this.mLh=function(sBs){
if(sBs){
return new XMLSerializer().serializeToString(sBs);
}
}


this.DND=function(Psd,SdN,JVb){
if(Psd){
if(SdN){
if(JVb){
Psd.setAttribute(SdN,JVb);
}
}
}
}
this.Ebk=function(FXs,Psd,Shb){
if(Psd){
this.WkT(Psd);
if(FXs){
Psd.appendChild(Shb.createTextNode(FXs));
}
}
}
this.WkT=function(Psd){
if(Psd){
while(Psd.hasChildNodes()){
Psd.removeChild(Psd.firstChild);
}
}
}
this.ofh=function(HZE,AiH,Shb){
var Psd=null;
var rVw=browserType();
if(rVw==this.gHv){
if(AiH){
Psd=Shb.createNode(1,HZE,AiH);
}else{
Psd=Shb.createNode(1,HZE,"");
}
}else{
if(AiH){
Psd=Shb.createElementNS(AiH,HZE);
}else{
Psd=Shb.createElementNS("",HZE);
}
}
return Psd;
}
this.cjr=function(){
if(isUndefined(JUm)){
JUm=browserType();
}
return JUm;
}
var browserType=function(){
if(document.layers){return "NS";}
if(document.all){
var rKI=navigator.userAgent.toLowerCase();
var bDo=(rKI.indexOf("opera")!=-1);
var IYc=(rKI.indexOf("konqueror")!=-1);
if(bDo){
return "OPR";
}else{
return(IYc)?"KONQ":"IE";
}
}
if(document.getElementById){
var fTW=navigator.userAgent.toLowerCase();
return(fTW.indexOf("safari")!=-1)?"SFR":"MOZ";
}
return "OTHER";
}
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="Class: "+"activelms.AjaxClient"+"\n";
return cZn;
};
};
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(!activelms.CmiServiceClient){activelms.CmiServiceClient={};}
else if(typeof activelms.CmiServiceClient!="object"){throw new Error("namepsace activelms.CmiServiceClient  exists");}
activelms.CmiServiceClient=function(gPg,rJq,EZl){
activelms.AjaxClient.call(this);
var iIc=undefined;
var Ewp=undefined;
var qaR=undefined;
var THM=undefined;
var laM=undefined;
var MTG=undefined;
var xcP=undefined;
var aSx=undefined;
var responseXML=undefined;
var error=undefined;
this.gKf=function(mhg,AiH){
var Shb=Sarissa.getDomDocument("http://schemas.xmlsoap.org/soap/envelope/","Envelope");
var rAH=Shb.documentElement;
this.DND(rAH,"xmlns:xsi","http://www.w3.org/1999/XMLSchema-instance");
this.DND(rAH,"xmlns:xsd","http://www.w3.org/1999/XMLSchema");
var iEk=this.ofh("Body","http://schemas.xmlsoap.org/soap/envelope/",Shb);
rAH.appendChild(iEk);
var EGC=this.ofh(mhg,"http://www.activelms.com/services/cmi",Shb);
iEk.appendChild(EGC);
var LTQ=this.ofh("RteDataModel","http://www.activelms.com/services/cmi",Shb);
EGC.appendChild(LTQ);
this.DND(LTQ,"pk",iIc);
this.DND(LTQ,"domain",Ewp);
this.DND(LTQ,"learner",qaR);
this.DND(LTQ,"course",THM);
this.DND(LTQ,"org",laM);
this.DND(LTQ,"sco",MTG);
this.DND(LTQ,"session",xcP);
return Shb;
}
this.invoke=function(mhg,XBk){
aSx=XBk;
var AiH="http://www.activelms.com/services/cmi";
var VxY="http://www.activelms.com/services/cmi/"+mhg;
var LsO=this.gKf(mhg,AiH);
this.SDI(gPg,rJq,EZl,VxY,LsO);
}
this.DAN=function(iQb,IZH){
responseXML=iQb;
error=IZH;
aSx.call();
}
this.CBi=function(){
return error;
}
this.hBO=function(){
return this.mLh(responseXML);
}
this.getResponseXml=function(){
return responseXML;
}
this.setDomainID=function(cvl){
Ewp=cvl;
}
this.setLearnerID=function(Lle){
qaR=Lle;
}
this.setCourseID=function(Xef){
THM=Xef;
}
this.setOrgID=function(FaU){
laM=FaU;
}
this.setScoID=function(Okt){
MTG=Okt;
}
this.setSessionID=function(OQi){
xcP=OQi;
}
this.setPrimaryKey=function(ZCi){
iIc=ZCi;
}
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="Class: "+"activelms.CmiServiceClient"+"\n";
return cZn;
};
}
activelms.CmiServiceClient.prototype=new activelms.AjaxClient();
activelms.CmiServiceClient.prototype.constructor=activelms.CmiServiceClient;
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(!activelms.YAt){activelms.YAt={};}
else if(typeof activelms.YAt!="object"){throw new Error("namepsace activelms.SequencingServiceClient  exists");}
activelms.YAt=function(hTs,gPg,rJq,EZl,VcW,NAu,Wgx){
activelms.AjaxClient.call(this);
var fQO=hTs;
var Ewp=undefined;
var qaR=undefined;
var THM=undefined;
var laM=undefined;
var xcP=undefined;
var CxA=undefined;
var aSx=undefined;
var responseXML=undefined;
var error=undefined;

this.RxL=function(sBs){
var GKg=sBs.firstChild;
var GIk=undefined;
while(GKg!=null){
var MOT=GKg.nextSibling;
if(GKg.nodeType==1){
GIk=this.qSg(GKg.nodeName);
switch(GIk){
case "organizations":
this.RxL(GKg);
break;
case "organization":
this.RxL(GKg);
break;
case "item":
var blY=GKg.getAttribute("updated");
var eOg=false;
if(isUndefined(blY)||blY!="true"){
eOg=true;
}
if(eOg){
sBs.removeChild(GKg);
}
else{
this.RxL(GKg);
}
break;
}
}
GKg=MOT;
}
};
this.gnP=function(sBs){
sBs.removeAttribute("updated");
var iaf=sBs.childNodes;

var SRI=iaf.length-1;
if(SRI>=0){
do{
if(iaf[SRI].nodeType==1){


this.gnP(iaf[SRI]);
}--SRI;
}
while(SRI>=0);
}
};
this.Wsg=function(sBs){
sBs.removeAttribute("updated");
var GKg=sBs.firstChild;
while(GKg!=null){
var MOT=GKg.nextSibling;
if(GKg.nodeType==1){
GIk=this.qSg(GKg.nodeName);
switch(GIk){
case "organizations":
this.Wsg(GKg);
break;
case "organization":
this.Wsg(GKg);
break;
case "item":
this.Wsg(GKg);
break;
case "sequencing":
this.Wsg(GKg);
break;
case "title":
sBs.removeChild(GKg);
break;
case "resource":
sBs.removeChild(GKg);
break;
case "controlMode":
sBs.removeChild(GKg);
break;
case "sequencingRules":
sBs.removeChild(GKg);
break;
case "rollupRules":
sBs.removeChild(GKg);
break;
case "limitConditions":
sBs.removeChild(GKg);
break;
case "presentation":
sBs.removeChild(GKg);
break;
case "dataFromLMS":
sBs.removeChild(GKg);
break;
case "completionThreshold":
sBs.removeChild(GKg);
break;
case "timeLimitAction":
sBs.removeChild(GKg);
break;
}
}
else if(GKg.nodeType==8){
sBs.removeChild(GKg);
}
GKg=MOT;
}
};
this.qSg=function(HZE){
var hsc=HZE.indexOf(":");
if(hsc<0){return HZE;}
return HZE.substring(hsc+1,HZE.length);
};
this.gKf=function(mhg,AiH,qxN){
var AXs="";
var Shb=undefined;
var rAH=undefined;
var iEk=undefined;
var EGC=undefined;
var ZOA=undefined;
var HZE=undefined;
if(!isUndefined(fQO)){
Shb=fQO.getSourceDocumentElement();
rAH=Shb.documentElement;
fQO.setNavigationRequestType(qxN);
fQO.Hdt(VcW);
var TOc=false;
if(!isUndefined(VcW)&&VcW=="differential"){
TOc=true;
}
if(TOc){
rAH=rAH.cloneNode(true);
this.gnP(fQO.getSourceDocumentElement().documentElement);
}
HZE=mhg;
EGC=this.ofh(HZE,AiH,Shb);
if(this.cjr()==this.bUV){
this.DND(EGC,"xmlns",AiH);
}
iEk=rAH.firstChild;
var uiA=undefined;
var GIk=iEk.firstChild.nodeName;
 
if(GIk.indexOf("manifest")!=-1){
	
uiA=iEk;
ZOA=iEk.firstChild;
}
else{
uiA=iEk.removeChild(iEk.firstChild);
ZOA=uiA.firstChild;
}
var WrJ=uiA.childNodes;
var Yem=WrJ.length;
var tJr=undefined;
for(var SRI=0;SRI<Yem;SRI++){
tJr=uiA.removeChild(WrJ[SRI]);
if(TOc){
if(tJr.nodeName.indexOf("manifest")!=-1){
if(mhg=="Terminate"||mhg=="Deliver"){
this.RxL(tJr);
}
this.Wsg(tJr);
}
}
EGC.appendChild(tJr);
}
ZOA.removeAttribute("xmlns");
iEk.appendChild(EGC);
var xGe=this.mLh(rAH);
return new DOMParser().parseFromString(xGe,"text/xml");
}
Shb=Sarissa.getDomDocument("http://schemas.xmlsoap.org/soap/envelope/","soap:Envelope");
var rAH=Shb.documentElement;
this.DND(rAH,"xmlns:xsi","http://www.w3.org/1999/XMLSchema-instance");
this.DND(rAH,"xmlns:xsd","http://www.w3.org/1999/XMLSchema");
if(this.cjr()==this.bUV){
this.DND(rAH,"xmlns:soap","http://schemas.xmlsoap.org/soap/envelope/");
}
iEk=this.ofh("soap:Body","http://schemas.xmlsoap.org/soap/envelope/",Shb);
rAH.appendChild(iEk);
HZE=mhg;
EGC=this.ofh(HZE,AiH,Shb);
if(this.cjr()==this.bUV){
this.DND(EGC,"xmlns",AiH);
}
iEk.appendChild(EGC);
HZE="manifest";
ZOA=this.ofh(HZE,AiH,Shb);
HZE="organizations";
var Zqf=this.ofh(HZE,AiH,Shb);
ZOA.appendChild(Zqf);
HZE="identifiers";
var ZCd=this.ofh(HZE,AiH,Shb);
Zqf.appendChild(ZCd);
this.DND(ZCd,"domainID",Ewp);
this.DND(ZCd,"learnerID",qaR);
this.DND(ZCd,"courseID",THM);
this.DND(ZCd,"orgID",laM);
this.DND(ZCd,"sessionID",xcP);
HZE="navRequest";
var fds=this.ofh(HZE,AiH,Shb);
this.Ebk("_none_",fds,Shb);
ZOA.appendChild(fds);
HZE="syncClientServer";
var hNH=this.ofh(HZE,AiH,Shb);
this.Ebk(VcW,hNH,Shb);
ZOA.appendChild(hNH);
HZE="mode";
var sfF=this.ofh(HZE,AiH,Shb);
this.Ebk(NAu,sfF,Shb);
ZOA.appendChild(sfF);
if(!isUndefined(Wgx)){
var WXT=Wgx.keySet();
var WBF=WXT.length;
var IuJ=undefined;
var WIT=undefined;
var mxW=this.ofh("overrides",AiH,Shb);
this.DND(mxW,"modelName","minNormalizedMeasure");
for(var SRI=0;SRI<WBF;SRI++){
IuJ=WXT[SRI];
WIT=Wgx.get(IuJ);
WIT=WIT.toString();
var IlW=this.ofh("override",AiH,Shb);
this.DND(IlW,"target",IuJ);
this.DND(IlW,"modelValue",WIT);
mxW.appendChild(IlW);
}
ZOA.appendChild(mxW);
}
EGC.appendChild(ZOA);
return Shb;
}
this.invoke=function(mhg,qxN,XBk){
log.info("activelms.SequencingServiceClient.invoke with WS Operation Name="+mhg);
aSx=XBk;
var AiH="http://www.activelms.com/services/ss";
var VxY="http://www.activelms.com/services/ss/"+mhg;
var LsO=this.gKf(mhg,AiH,qxN);
log.info("Request Type: "+qxN);
this.SDI(gPg,rJq,EZl,VxY,LsO);
}
this.DAN=function(iQb,IZH){
responseXML=iQb;
error=IZH;
if(!error){
log.info("activelms.SequencingServiceClient.response with no error");
}
else{
log.error("activelms.SequencingServiceClient.response with error="+error);
}
aSx.call();
}
this.CBi=function(){
return error;
}
this.hBO=function(){
return this.mLh(responseXML);
}
this.getResponseXml=function(){
return responseXML;
}
this.setDomainID=function(cvl){
Ewp=cvl;
}
this.setLearnerID=function(Lle){
qaR=Lle;
}
this.setCourseID=function(Xef){
THM=Xef;
}
this.setOrgID=function(FaU){
laM=FaU;
}
this.setSessionID=function(OQi){
xcP=OQi;
}
this.XAR=function(uIv){
CxA=uIv;
}
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="Class: "+"activelms.SequencingServiceClient"+"\n";
return cZn;
};
}
activelms.YAt.prototype=new activelms.AjaxClient();
activelms.YAt.prototype.constructor=activelms.YAt;
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(!activelms.Controller){activelms.Controller={};}
else if(typeof activelms.Controller!="object"){throw new Error("namepsace activelms.Controller exists");}
activelms.Controller.Model=undefined;
activelms.Controller.WRr=undefined;
activelms.Controller.Callback=undefined;
activelms.Controller.eSc=undefined;
activelms.Controller.efK=undefined;
activelms.Controller.woM=undefined;
activelms.Controller.esJ=undefined;
activelms.Controller.terminationRequest=undefined;
activelms.Controller.sequencingRequest=undefined;
activelms.Controller.execute=function(qxN,Yof,Mmq,mUM,EZl){
activelms.Controller.WRr=undefined;
activelms.Controller.Callback=undefined;
activelms.Controller.eSc=undefined;
activelms.Controller.efK=undefined;
activelms.Controller.woM=undefined;
activelms.Controller.gfH(Mmq);
var MZt=undefined;
var hTs=Mmq.get("activityTree");
var bnH=(isUndefined(hTs)||isUndefined(hTs.getElement()));
var WbY=undefined;
if(!bnH){
var BGn=hTs.getCurrentActivity();
var vkC=hTs.getScormVersion();
if(!activelms.SequencingBehaviour.isSequencingFinished){
if(!isUndefined(BGn)){
var WaU=Mmq.get("cocd");
MZt=new activelms.RunTimeDataModel(WaU,vkC);
WbY=MZt.BgH();
if(WbY){
switch(WbY){
case "time-out":
qxN=activelms.SequencingEngine.EXIT_ALL;
break;
case "timeout":
qxN=activelms.SequencingEngine.EXIT_ALL;
break;
case "suspend":
BGn.VYR(true);
hTs.xXj(BGn);
break;
case "logout":
qxN=activelms.SequencingEngine.EXIT_ALL;
break;
}
}
}
}
}

switch(qxN){
case activelms.SequencingEngine.INIT:
activelms.Controller.iob(Mmq,mUM,EZl);
break;
case activelms.SequencingEngine.START:
activelms.Controller.pih(Mmq,mUM,EZl);
break;
case activelms.SequencingEngine.RESUME_ALL:
activelms.Controller.sYZ(Mmq,mUM,EZl);
break;
case activelms.SequencingEngine.PREVIOUS:
activelms.Controller.jpT(BGn,MZt);
activelms.Controller.kSM(Mmq,mUM,qxN,Yof,EZl);
break;
case activelms.SequencingEngine.CONTINUE:
activelms.Controller.jpT(BGn,MZt);
activelms.Controller.kSM(Mmq,mUM,qxN,Yof,EZl);
break;
case activelms.SequencingEngine.CHOICE:
activelms.Controller.jpT(BGn,MZt);
activelms.Controller.kSM(Mmq,mUM,qxN,Yof,EZl);
break;
case activelms.SequencingEngine.aKc:
activelms.Controller.jpT(BGn,MZt);
activelms.Controller.kSM(Mmq,mUM,qxN,Yof,EZl);
break;
case activelms.SequencingEngine.EXIT:
activelms.Controller.jpT(BGn,MZt);
activelms.Controller.kZT(Mmq,mUM,EZl);
break;
case activelms.SequencingEngine.ABANDON:

activelms.Controller.UjO(Mmq,mUM,EZl);
break;
case activelms.SequencingEngine.EXIT_ALL:
activelms.Controller.jpT(BGn,MZt);
activelms.Controller.HXI(Mmq,mUM,qxN,EZl);
break;
case activelms.SequencingEngine.SUSPEND_ALL:
activelms.Controller.jpT(BGn,MZt);
activelms.Controller.HXI(Mmq,mUM,qxN,EZl);
break;
case activelms.SequencingEngine.ABANDON_ALL:

activelms.Controller.HXI(Mmq,mUM,qxN,EZl);
break;
default:
throw new activelms.ApplicationError("Unrecognised sequencing request type: "+str_ActionType);
}
};
activelms.Controller.jpT=
function(BGn,MZt){
if(!isUndefined(BGn)){
BGn.setRunTimeDataModel(MZt);
}
}
activelms.Controller.XYh=function(){
var fja;
try{
var nxL=activelms.Controller.efK.CBi();
if(nxL){throw nxL;}
var Shb=activelms.Controller.efK.getResponseXml();
var hTs=new activelms.ActivityTree(Shb);
var OQi=hTs.SkK();
var fZO=activelms.Controller.Model.get("sessionID");
fja=new activelms.ModelAndView(activelms.Controller.Model,activelms.Controller.WRr);
fja.put("activityTree",hTs);
fja.put("organizations",activelms.Organizations);

var bnH=isUndefined(hTs.getElement());
var Xnb=false;
if(!bnH){
if(!isUndefined(hTs.getSuspendedActivity())){
Xnb=true;
}
}
var Rub=activelms.Controller.Model.get("isSetToLaunch");
if(Rub){
if(Xnb){
activelms.Controller.execute(activelms.SequencingEngine.RESUME_ALL,null,activelms.Controller.Model,activelms.Controller.eSc);
}
else{
activelms.Controller.Model.put("orgID",hTs.getOrgID());
activelms.Controller.execute(activelms.SequencingEngine.START,null,activelms.Controller.Model,activelms.Controller.eSc);
}
}
else{
if(Xnb){
fja.put("isDisabledForStart",false);
fja.put("isDisabledForMenu",false);
fja.put("isDisabledForResumeAll",false);
fja.put("orgID",hTs.getRoot().getIdentifier());
fja.put("schemaVersion",hTs.getSchemaVersion());
var BUc=fja.getView();
BUc+="&resumeAll=true&start=true&choice=true";
fja.xMF(BUc);
activelms.Controller.eSc.call(this,fja);
}
else{
activelms.Controller.efK=
activelms.Controller.iYx(undefined,fja.getModel(),true);
activelms.Controller.efK.invoke("Create",activelms.SequencingEngine.NONE,activelms.Controller.OIN);
}
}
}
catch(IZH){
log.error(IZH.message);
fja=new activelms.ModelAndView(activelms.Controller.Model,activelms.Controller.WRr);
fja.put("error",IZH);
activelms.Controller.eSc.call(this,fja);
}
}
activelms.Controller.OIN=function(){
var fja;
try{
var nxL=activelms.Controller.efK.CBi();
if(!isUndefined(nxL)){throw nxL;}
var Shb=activelms.Controller.efK.getResponseXml();
var hTs=new activelms.ActivityTree(Shb);
fja=new activelms.ModelAndView(activelms.Controller.Model,activelms.Controller.WRr);
fja.put("activityTree",hTs);
fja.put("organizations",activelms.Organizations);

fja.put("isDisabledForStart",false);
fja.put("isDisabledForMenu",false);
fja.put("isDisabledForResumeAll",true);
fja.put("orgID",hTs.getRoot().getIdentifier());
fja.put("schemaVersion",hTs.getSchemaVersion());
var BUc=fja.getView();
BUc+="&resumeAll=false&start=true&choice=true";
fja.xMF(BUc);
activelms.Controller.eSc.call(this,fja);
}
catch(IZH){
log.error(IZH.message);
fja=new activelms.ModelAndView(activelms.Controller.Model,activelms.Controller.WRr);
fja.put("error",IZH);
activelms.Controller.eSc.call(this,fja);
}
}
activelms.Controller.kWV=function(){
var fja;
try{
var nxL=activelms.Controller.efK.CBi();
if(!isUndefined(nxL)){throw nxL;}
var Shb=activelms.Controller.efK.getResponseXml();
var hTs=new activelms.ActivityTree(Shb);
fja=new activelms.ModelAndView(activelms.Controller.Model,activelms.Controller.WRr);
fja.put("activityTree",hTs);
fja.put("organizations",activelms.Organizations);

activelms.Controller.NTp(fja,activelms.SequencingEngine.START,undefined,true);
}
catch(IZH){
log.error(IZH.message);
fja=new activelms.ModelAndView(activelms.Controller.Model,activelms.Controller.WRr);
fja.put("error",IZH);
activelms.Controller.eSc.call(this,fja);
}
}
activelms.Controller.NTp=function(fja,qxN,Yof,EZl){
log.info("Navigation request: "+qxN);
activelms.Controller.esJ=qxN;
activelms.Controller.terminationRequest=undefined;
activelms.Controller.sequencingRequest=undefined;
activelms.NavigationBehaviour.terminationRequest=undefined;
activelms.NavigationBehaviour.sequencingRequest=undefined;
var hTs=fja.get("activityTree");
activelms.NavigationBehaviour.invoke(hTs,qxN,Yof,false);
activelms.Controller.Model=fja;
activelms.Controller.woM=Yof;
activelms.Controller.terminationRequest=activelms.NavigationBehaviour.terminationRequest;
activelms.Controller.sequencingRequest=activelms.NavigationBehaviour.sequencingRequest;
if(!isUndefined(activelms.NavigationBehaviour.terminationRequest)){
activelms.Controller.SZx(hTs,activelms.NavigationBehaviour.terminationRequest,EZl);
}
else{
	 
activelms.Controller.Ffb(EZl);
}
}
activelms.Controller.SZx=function(hTs,juh,EZl){
log.info("Termination request: "+juh);

try{
activelms.TerminationBehaviour.invoke(hTs,juh);
if(!isUndefined(activelms.TerminationBehaviour.sequencingRequest)){
activelms.NavigationBehaviour.sequencingRequest=
activelms.TerminationBehaviour.sequencingRequest;
}
activelms.Controller.terminationRequest=activelms.NavigationBehaviour.terminationRequest;
activelms.Controller.sequencingRequest=activelms.NavigationBehaviour.sequencingRequest;
activelms.Controller.XeM(hTs.getObjectivesGlobalToSystem(),juh);

activelms.Controller.efK=activelms.Controller.iYx(hTs,activelms.Controller.Model,EZl);
activelms.Controller.efK.invoke("Terminate",juh,activelms.Controller.Ffb);
}
catch(IZH){
log.error(IZH.message);
fja=new activelms.ModelAndView(activelms.Controller.Model,activelms.Controller.WRr);
fja.put("error",IZH);
activelms.Controller.eSc.call(this,fja);
}
}
activelms.Controller.QPi=function(eoJ){
if(eoJ==activelms.SequencingEngine.CONTINUE||eoJ==activelms.SequencingEngine.PREVIOUS||eoJ==activelms.SequencingEngine.CHOICE||eoJ==activelms.SequencingEngine.EXIT||eoJ==activelms.SequencingEngine.ABANDON){
return true;
}
return false;
}
activelms.Controller.fXV=function(eoJ){
if(eoJ==activelms.SequencingEngine.EXIT_ALL||eoJ==activelms.SequencingEngine.SUSPEND_ALL||eoJ==activelms.SequencingEngine.ABANDON_ALL){
return true;
}
return false;
}
activelms.Controller.Ffb=function(EZl){
try{
if(!isUndefined(activelms.Controller.efK)&&activelms.Controller.efK!=null){
var nxL=activelms.Controller.efK.CBi();
if(!isUndefined(nxL)){throw nxL;}
}
var hTs=activelms.Controller.Model.get("activityTree");
activelms.SequencingBehaviour.isSequencingFinished=false;

if(activelms.Controller.sequencingRequest!=activelms.SequencingEngine.qPH){
if(activelms.Controller.fXV(activelms.Controller.esJ)){
activelms.SequencingBehaviour.isSequencingFinished=true;
}
}
log.info("activelms.Controller.navigationRequest: "+activelms.Controller.esJ);
log.info("activelms.Controller.terminationRequest: "+activelms.Controller.terminationRequest);
log.info("activelms.Controller.sequencingRequest: "+activelms.Controller.sequencingRequest);
if(!activelms.SequencingBehaviour.isSequencingFinished){
activelms.SequencingBehaviour.invoke(hTs,activelms.Controller.sequencingRequest,activelms.Controller.woM,false);
}
if(activelms.SequencingBehaviour.isSequencingFinished){

hTs.setCurrentActivity(undefined);
activelms.Controller.XeM(hTs.getObjectivesGlobalToSystem(),activelms.SequencingEngine.EXIT_ALL);
if(activelms.Controller.sequencingRequest==activelms.SequencingEngine.CONTINUE){
log.debug("Waking off activity tree with request="+activelms.Controller.sequencingRequest);
}
var jKa=activelms.Controller.Model.get("viewRootUrl");
jKa+="?skinID=";
jKa+=activelms.Controller.Model.get("skinID");
jKa+="&culture=";
jKa+=activelms.Controller.Model.get("culture");
activelms.Controller.Model.xMF(jKa);
activelms.Controller.efK=activelms.Controller.iYx(hTs,activelms.Controller.Model,EZl);

activelms.Controller.efK.invoke("Terminate",activelms.Controller.esJ,activelms.Controller.ZQh);
}
else{
activelms.Controller.pSO(activelms.Controller.sequencingRequest);
}
}
catch(IZH){
if(IZH.code&&IZH.code=="SB.2.2-1"){
activelms.Controller.Model.put("isDisabledForStart",true);
activelms.Controller.Model.put("isDisabledForMenu",false);
activelms.Controller.Model.put("isDisabledForResumeAll",true);
activelms.Controller.Model.put("orgID",hTs.getRoot().getIdentifier());
activelms.Controller.Model.put("schemaVersion",hTs.getSchemaVersion());
var BUc=activelms.Controller.Model.getView();
BUc+="&resumeAll=false&start=false&choice=true";
activelms.Controller.Model.xMF(BUc);
activelms.Controller.eSc.call(this,activelms.Controller.Model);
}
else{
log.error(IZH.message);
fja=new activelms.ModelAndView(activelms.Controller.Model,activelms.Controller.WRr);
fja.put("error",IZH);
activelms.Controller.eSc.call(this,activelms.Controller.Model);
}
}
}
activelms.Controller.pSO=function(ioO){
try{
var hTs=activelms.Controller.Model.get("activityTree");
if(!isUndefined(activelms.SequencingBehaviour.deliveryRequest)){
log.info("Delivery request: "+activelms.SequencingBehaviour.deliveryRequest.getIdentifier());
activelms.ksP.invoke(hTs,activelms.SequencingBehaviour.deliveryRequest,false);
var VcW=activelms.Controller.Model.get("syncClientServer");
if(VcW=="session"&&activelms.Controller.QPi(activelms.NavigationBehaviour.sequencingRequest)){
activelms.Controller.ZQh();
}
else{
activelms.Controller.efK=activelms.Controller.iYx(hTs,activelms.Controller.Model,true);
activelms.Controller.efK.invoke("Deliver",ioO,activelms.Controller.ZQh);
}
}
else{
activelms.Controller.ZQh();
}
}
catch(IZH){
log.error(IZH.message);
fja=new activelms.ModelAndView(activelms.Controller.Model,activelms.Controller.WRr);
fja.put("error",IZH);
activelms.Controller.eSc.call(this,fja);
}
}
activelms.Controller.XeM=function(qiX,qxN){
if(!qiX){
if(qxN==activelms.SequencingEngine.EXIT_ALL||qxN==activelms.SequencingEngine.SUSPEND_ALL||qxN==activelms.SequencingEngine.ABANDON_ALL){
var RKH=activelms.GlobalObjectives.getObjectiveSet();
var PaW=RKH.length;
var oHx=undefined;
for(var SRI=0;SRI<PaW;SRI++)
{
oHx=
activelms.GlobalObjectives.getObjectiveIfWrittenToBySuspendedActivity(RKH[SRI].getObjectiveID());
if(isUndefined(oHx)){
RKH[SRI].getObjectiveProgressInfo().init();
}
}
}
}
}
activelms.Controller.ZQh=function(){
try{
var nxL=activelms.Controller.efK.CBi();
if(!isUndefined(nxL)){throw nxL;}
var hTs=activelms.Controller.Model.get("activityTree");
var BGn=hTs.getCurrentActivity();
var rCF=hTs.getSuspendedActivity();
if(!isUndefined(BGn)){
activelms.Controller.akq(hTs,BGn);
if(BGn.isActive()){
activelms.Controller.Model.xMF(activelms.Controller.qql(BGn.getResource()));
}
}
else{
activelms.Controller.Model.remove("activityTree");
}
activelms.Controller.eSc.call(this,activelms.Controller.Model);
}
catch(IZH){
log.error(IZH.message);
fja=new activelms.ModelAndView(activelms.Controller.Model,activelms.Controller.WRr);
fja.put("error",IZH);
activelms.Controller.eSc.call(this,fja);
}
}
activelms.Controller.qql=function(BcX){


var wdc=BcX.getURI();

if(isAbsoluteUrl(wdc)){
return wdc;
}
wdc=wdc.split("?").join("&");

var jKa=activelms.Controller.Model.get("resourceResolverUrl");
jKa+="?courseID="+activelms.Controller.Model.get("courseID");
jKa+="&uri="+wdc;
return jKa;
};


activelms.Controller.akq=function(hTs,BGn){
var cVJ=hTs.getScormVersion();
var BcX=BGn.getResource();
activelms.Controller.Model.put("organizations",activelms.Organizations);
activelms.Controller.Model.put("orgID",hTs.getRoot().getIdentifier());
activelms.Controller.Model.put("schemaVersion",hTs.getSchemaVersion());
activelms.Controller.Model.put("pk",hTs.getID());

activelms.Controller.Model.put("scoID",BGn.getIdentifier());
activelms.Controller.Model.put("mostRecentScoID",BGn.getIdentifier());
activelms.Controller.Model.put("title",BGn.getTitle());
activelms.Controller.Model.put("tracked",BGn.isTracked());
activelms.Controller.Model.put("attemptCount",BGn.getActivityProgressInfo().getAttemptCount());
activelms.Controller.Model.put("completionThreshold",BGn.getCompletionThreshold());
activelms.Controller.Model.put("launchData",BGn.getLaunchData());
activelms.Controller.Model.put("maxTimeAllowed",BGn.getMaxTimeAllowed(cVJ));
activelms.Controller.Model.put("scaledPassingScore",BGn.getScaledPassingScore(cVJ));
activelms.Controller.Model.put("timeLimitAction",BGn.getTimeLimitAction());
activelms.Controller.Model.put("objectiveSet",BGn.getObjectiveSet());
activelms.Controller.Model.put("scormType",BcX.getScormType());
activelms.Controller.Model.put("isDisabledForExit",false);
activelms.Controller.Model.put("isDisabledForAbandon",false);
activelms.Controller.Model.put("isDisabledForMenu",false);
activelms.Controller.Model.put("activityTree",hTs);
activelms.Controller.Model.put("canSequenceForContinue",BGn.canSequence(activelms.SequencingEngine.CONTINUE));
activelms.Controller.Model.put("canSequenceForPrevious",BGn.canSequence(activelms.SequencingEngine.PREVIOUS));
activelms.Controller.Model.put("isDisabledForContinue",BGn.isDisabledForContinue());
activelms.Controller.Model.put("isDisabledForPrevious",BGn.isDisabledForPrevious());
activelms.Controller.Model.put("isDisabledForChoice",BGn.isDisabledForChoice());
activelms.Controller.Model.put("isHiddenForPrevious",BGn.isHiddenForPrevious());
activelms.Controller.Model.put("isHiddenForContinue",BGn.isHiddenForContinue());
activelms.Controller.Model.put("isHiddenForExit",BGn.isHiddenForExit());
activelms.Controller.Model.put("isHiddenForChoice",BGn.isHiddenForChoice());
if(!BGn.isActive()){
activelms.Controller.Model.put("isDisabledForExit",true);
activelms.Controller.Model.put("isDisabledForAbandon",true);
activelms.Controller.Model.put("isDisabledForExitAll",false);
activelms.Controller.Model.put("isDisabledForSuspendAll",false);
activelms.Controller.Model.put("isDisabledForAbandonAll",false);
}
if(cVJ<2004){
activelms.Controller.Model.put("isDisabledForSuspendAll",true);
activelms.Controller.Model.put("isDisabledForAbandonAll",true);
}
activelms.Controller.Model.put("isDisabledForAbandonAll",true);
};
activelms.Controller.gfH=function(Mmq){
Mmq.put("isDisabledForStart",true);
Mmq.put("isDisabledForResumeAll",true);
Mmq.put("isDisabledForPrevious",true);
Mmq.put("isDisabledForContinue",true);
Mmq.put("isDisabledForChoice",true);
Mmq.put("isDisabledForExit",true);
Mmq.put("isDisabledForAbandon",true);
Mmq.put("isDisabledForMenu",true);
Mmq.put("isHiddenForPrevious",true);
Mmq.put("isHiddenForContinue",true);
Mmq.put("isHiddenForChoice",true);
Mmq.put("isDisabledForExitAll",true);
Mmq.put("isDisabledForSuspendAll",true);
Mmq.put("isDisabledForAbandonAll",true);
Mmq.put("scormType","asset");
Mmq.put("scoID",undefined);
Mmq.put("title","");
Mmq.put("tracked",true);
Mmq.put("objectiveSet",[]);
Mmq.put("error",undefined);
}
activelms.Controller.iYx=function(hTs,Mmq,EZl){
var rJq=Mmq.get("SSRunEndPoint");
var jKa=Mmq.get("context");
var VcW=Mmq.get("syncClientServer");
var NMu=Mmq.get("mode");
var Wgx=Mmq.get("minNormalizedMeasure");
if(typeof(EZl)=="undefined"){EZl=true;}
log.info("Context: "+jKa);
log.info("SSRunEndPoint: "+rJq);
log.info("Sync Client Server: "+VcW);
var ogW=new activelms.YAt(hTs,"POST",rJq,EZl,VcW,NMu,Wgx);
ogW.setDomainID(Mmq.get("domainID"));
ogW.setLearnerID(Mmq.get("learnerID"));
ogW.setCourseID(Mmq.get("courseID"));
ogW.setOrgID(Mmq.get("orgID"));
ogW.setSessionID(Mmq.get("sessionID"));
ogW.XAR(activelms.Controller.esJ);
return ogW;
}
activelms.Controller.iob=function(Mmq,mUM,EZl){
activelms.SequencingBehaviour.isSequencingFinished=false;
Mmq.remove("activityTree");
var jKa=Mmq.get("viewInitUrl");
jKa+="?skinID=";
jKa+=Mmq.get("skinID");
jKa+="&culture=";
jKa+=Mmq.get("culture");
activelms.Controller.WRr=jKa;
activelms.Controller.efK=activelms.Controller.iYx(undefined,Mmq,EZl);
activelms.Controller.eSc=mUM;
activelms.Controller.Model=Mmq;
activelms.Controller.QMU=activelms.SequencingEngine.INIT;
activelms.Controller.efK.invoke("Resume",activelms.SequencingEngine.NONE,activelms.Controller.XYh);
};
activelms.Controller.pih=function(Mmq,mUM,EZl){
activelms.SequencingBehaviour.isSequencingFinished=false;
Mmq.remove("activityTree");
var jKa=Mmq.get("viewInitUrl");
jKa+="?skinID=";
jKa+=Mmq.get("skinID");
jKa+="&culture=";
jKa+=Mmq.get("culture");
activelms.Controller.WRr=jKa;
activelms.Controller.efK=activelms.Controller.iYx(undefined,Mmq,EZl);
activelms.Controller.eSc=mUM;
activelms.Controller.Model=Mmq;
activelms.Controller.QMU=activelms.SequencingEngine.START;
activelms.Controller.efK.invoke("Create",activelms.SequencingEngine.START,activelms.Controller.kWV);
};
activelms.Controller.sYZ=function(Mmq,mUM,EZl){
activelms.SequencingBehaviour.isSequencingFinished=false;
var jKa=undefined;
var fja=new activelms.ModelAndView(Mmq,jKa);
activelms.Controller.eSc=mUM;
activelms.Controller.NTp(fja,activelms.SequencingEngine.RESUME_ALL,undefined,EZl);
};
activelms.Controller.kSM=function(Mmq,mUM,qxN,Yof,EZl){
var jKa=undefined;
var fja=new activelms.ModelAndView(Mmq,jKa);
activelms.Controller.eSc=mUM;
activelms.Controller.NTp(fja,qxN,Yof,EZl);
};
activelms.Controller.kZT=function(Mmq,mUM,EZl){
var jKa=Mmq.get("viewEndUrl");
jKa+="?skinID=";
jKa+=Mmq.get("skinID");
jKa+="&culture=";
jKa+=Mmq.get("culture");
var fja=new activelms.ModelAndView(Mmq,jKa);
activelms.Controller.eSc=mUM;
activelms.Controller.NTp(fja,activelms.SequencingEngine.EXIT,undefined,EZl);
};
activelms.Controller.UjO=function(Mmq,mUM,EZl){
var jKa=Mmq.get("viewEndUrl");
jKa+="?skinID=";
jKa+=Mmq.get("skinID");
jKa+="&culture=";
jKa+=Mmq.get("culture");
var fja=new activelms.ModelAndView(Mmq,jKa);
activelms.Controller.eSc=mUM;
activelms.Controller.NTp(fja,activelms.SequencingEngine.ABANDON,undefined,EZl);
};
activelms.Controller.HXI=function(Mmq,mUM,qxN,EZl){
var jKa=Mmq.get("viewRootUrl");
jKa+="?skinID=";
jKa+=Mmq.get("skinID");
jKa+="&culture=";
jKa+=Mmq.get("culture");
var fja=new activelms.ModelAndView(Mmq,jKa);
activelms.Controller.eSc=mUM;
activelms.Controller.NTp(fja,qxN,undefined,EZl);
};
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(activelms.ModelAndView){throw new Error("namepsace activelms.ModelAndView exists");}
if(activelms.Model){throw new Error("namepsace activelms.Model exists");}
if(activelms.Entity){throw new Error("namepsace activelms.Entity exists");}
activelms.Entity=function(IfN,GTx){
this.key=IfN;
this.value=GTx;
this.toString=function(){
return this.key+"="+this.value;
};
};
activelms.Model=function(){
this.model=[];
this.get=function(IfN){
var LDr=this.model[IfN];
if(typeof(LDr)!="undefined"&&LDr!==null){
return LDr.value;
}
};
this.remove=function(IfN){
var PaW=this.model.length;
var hsc;
for(var SRI=0;SRI<PaW;SRI++){
if(this.model[SRI].key==IfN){
hsc=SRI;
break;
}
}
if(!isUndefined(hsc)){
return this.model.splice(hsc,1);
}
};
this.put=function(IfN,GTx){
this.remove(IfN);
this.model.push(new activelms.Entity(IfN,GTx));
var PaW=this.model.length;
for(var SRI=0;SRI<PaW;SRI++){
this.model[this.model[SRI].key]=this.model[SRI];
}
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="length: "+this.model.length+"\n";
for(var SRI=0;SRI<this.model.length;SRI++){
cZn+=this.model[SRI].toString()+"\n";
}
return cZn;
};
};
activelms.ModelAndView=function(Mmq,BUc){
activelms.Model.call(this);
this.model=Mmq.model;
this.getModel=function(){
return Mmq;
};
this.getView=function(){
return BUc;
};
this.xMF=function(PBs){
BUc=PBs;
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="model objects: "+this.getModel().length+"\n";
cZn+="view: "+this.getView()+"\n";
return cZn;
};
};
activelms.ModelAndView.prototype=new activelms.Model();
activelms.ModelAndView.prototype.constructor=activelms.ModelAndView;
