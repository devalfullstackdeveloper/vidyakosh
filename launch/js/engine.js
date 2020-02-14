var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(activelms.DefinitionType){throw new Error("namepsace activelms.DefinitionType exists");}
if(activelms.HashTable){throw new Error("namepsace activelms.HashTable exists");}
if(activelms.vVP){throw new Error("namepsace activelms.Element exists");}
function doErrorHandler(FCr,nah){
var osF="An application error has occured:\n\n";
osF+="Name: "+FCr.name+"\n";
osF+="Message: "+FCr.message+"\n";
osF+="Description: "+FCr.description+"\n";
osF+="String: "+FCr.toString()+"\n";
osF+="Comment: "+nah+"\n";
alert(osF);
}
function doTestHandler(FCr,nah,kjd,psW){
var osF="An application error has occured:\n\n";
osF+="Name: "+FCr.name+"\n";
osF+="Message: "+FCr.message+"\n";
osF+="Description: "+FCr.description+"\n";
osF+="String: "+FCr.toString()+"\n";
osF+="Comment: "+nah+"\n";
osF+="Expected: "+kjd+"\n";
osF+="Actual: "+psW+"\n";
alert(osF);
}
function isUndefined(knB){
if(typeof(knB)==TEQ){return true;}
return false;
}
function browserType(){
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
function doCreateNewDocument(UUZ,ZrR){
if(UUZ&&ZrR){
return Sarissa.getDomDocument(ZrR,UUZ);
}
else if(UUZ){
return Sarissa.getDomDocument("",UUZ);
}
else{
return Sarissa.getDomDocument();
}
}
function doCreateNewDocumentFromString(DCP){
if(!isUndefined(DCP)&&DCP!==null){
var Shb=doCreateNewDocument();
Shb=(new DOMParser()).parseFromString(DCP,"text/xml");
return Shb;
}
}
function doSerialize(sBs){
if(!isUndefined(sBs)&&sBs!==null){
return new XMLSerializer().serializeToString(sBs);
}
}
function doCreateNewElement(UUZ,ZrR,AoJ){
var dBx=null;
var rVw=browserType();
if(rVw=="IE"){
if(ZrR){
dBx=AoJ.createNode(1,UUZ,ZrR);
}else{
dBx=AoJ.createNode(1,UUZ,"");
}
}else{
if(ZrR){
dBx=AoJ.createElementNS(ZrR,UUZ);
}else{
dBx=AoJ.createElementNS("",UUZ);
}
}
return dBx;
}
function doSetAttribute(dBx,NFe,oeQ){
if(dBx){
if(NFe){
if(oeQ){
dBx.setAttribute(NFe,oeQ);
}else{
}
}
}
}
activelms.vVP=function(IfN,GTx){
this.key=IfN;
this.value=GTx;
};
activelms.HashTable=function(){
this.mda=[];
var AiH="icn_";
var rmT=function(CKt){
if(isUndefined(CKt)){return AiH.concat("undefined");}
if(CKt==null){return AiH.concat("null");}
var wuP=parseInt(CKt);
if(isNaN(wuP)){return CKt;}
else{return AiH.concat(wuP);}
var PgW=parseFloat(CKt);
if(isNaN(PgW)){return CKt;}
else{return AiH.concat(PgW);}
};
var tAF=function(IfN){
return IfN.substring(AiH.length,IfN.length);
};
this.get=function(IfN){
IfN=rmT(IfN);
var Psd=this.mda[IfN];
if(Psd){
return Psd.value;
}
};
this.remove=function(IfN){
IfN=rmT(IfN);
var hsc;
var PaW=this.mda.length;
if(PaW==0){return;}
for(var SRI=0;SRI<PaW;SRI++){
if(this.mda[SRI].key==IfN){
hsc=SRI;
break;
}
}
if(!isUndefined(hsc)){
this.mda[IfN]=undefined;
var ovD=this.mda.splice(hsc,1);
return ovD[0].value;
}
};
this.contains=function(IfN){
IfN=rmT(IfN);
var PaW=this.mda.length;
if(PaW==0){return false;}
for(var SRI=0;SRI<PaW;SRI++){
if(this.mda[SRI].key==IfN){
return true;
}
}
return false;
}
this.put=function(IfN,GTx){
IfN=rmT(IfN);
this.remove(IfN);
this.mda.push(new activelms.vVP(IfN,GTx));
var PaW=this.mda.length;
for(var SRI=0;SRI<PaW;SRI++){
this.mda[this.mda[SRI].key]=this.mda[SRI];
}
return PaW-1;
};
this.size=function(){
return this.mda.length;
};
this.xjJ=function(hsc){
return this.elements()[hsc];
}
this.elements=function(){
var QbX=[];
var PaW=this.mda.length;
for(var SRI=0;SRI<PaW;SRI++){
QbX.push(this.mda[SRI].value);
}
return QbX;
};
this.keySet=function(){
var NXd=[];
var PaW=this.mda.length;
var IfN=undefined;
for(var SRI=0;SRI<PaW;SRI++){
IfN=this.mda[SRI].key
if(IfN.indexOf(AiH)!=-1){
IfN=tAF(IfN);
}
NXd.push(IfN);
}
return NXd;
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="length: "+this.mda.length+"\n";
return cZn;
};
};
var TEQ="undefined";
var aEK="string";
var SsC="boolean";
var vMU="number";
var cUw="object";
var jSt="true";
var GlX="false";
activelms.DefinitionType=function(dIX){
this.dJC=":";
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="node name: "+dIX.nodeName+"\n";
cZn+="node type: "+dIX.nodeType+"\n";
return cZn;
};
this.getElement=function(){
return dIX;
};
this.IoN=function(){
return dIX.ownerDocument;
};
this.qSg=function(HZE){
var hsc=HZE.indexOf(this.dJC);
if(hsc<0){return HZE;}
return HZE.substring(hsc+1,HZE.length);
};
this.HJf=function(sBs,InX){
if(!sBs){return;}
var tJr=undefined;
this.AIh=undefined;
if(sBs.hasChildNodes()){
var PaW=sBs.childNodes.length
for(var SRI=0;SRI<PaW;SRI++){
tJr=sBs.childNodes[SRI];
if(tJr.nodeType==1){
if(this.qSg(tJr.nodeName)==InX){
this.AIh=tJr;
break;
}
else if(tJr.hasChildNodes()){
this.HJf(tJr,InX);
}
}
}
}
return this.AIh;
};
this.cgt=function(InX,SdN,JVb){
if(!dIX){return;}
var iaf=dIX.childNodes;
var LVE=iaf.length;
if(iaf.length!=0){
var SRI=LVE-1;
var tJr=undefined;
var blY=undefined;
do{
tJr=iaf[SRI];
if(tJr.nodeType==1){
if(this.qSg(tJr.nodeName)==InX){
if(isUndefined(SdN)){
return tJr;
}
else{
blY=tJr.getAttribute(SdN);
if(!isUndefined(blY)){
if(blY==JVb){
return tJr;
}
}
}
}
}--SRI;
}
while(SRI>=0);
}
};
this.eoW=function(InX){
if(!dIX){return;}
var mJn=[];
var iaf=dIX.childNodes;
var LVE=iaf.length;
if(iaf.length!=0){
var tJr=undefined;
for(var SRI=0;SRI<LVE;SRI++){
tJr=iaf[SRI];
if(tJr.nodeType==1){
if(this.qSg(tJr.nodeName)==InX){
mJn.push(tJr);
}
}
}
}
if(mJn.length===0){
return;
}
return mJn;
};
this.getElementText=function(san){
if(san&&san.firstChild&&san.firstChild.nodeType==3){
return san.firstChild.nodeValue;
}
};
this.getAttribute=function(san,SdN){
if(san&&san.nodeType==Node.ELEMENT_NODE){
if(san.hasAttribute(SdN)){
var Kio=san.getAttributeNode(SdN);
if(!isUndefined(Kio)){
return Kio;
}
}
}
};
this.Ebk=function(san,GTx){
if(!isUndefined(san)){
if(san&&san.nodeType==1){
var blY=undefined;
switch(typeof(GTx)){
case SsC:
if(GTx){
blY="true";
}
else{
blY="false";
}
break;
default:

blY=GTx.toString();
}
if(san.firstChild&&san.firstChild.nodeType==3){
san.firstChild.nodeValue=blY;
}
else{
var EcY=san.ownerDocument.createTextNode(blY);
san.appendChild(EcY);
}
}
}
};
this.tht=function(san,SdN,GTx){
SdN.toLowerCase();
if(!isUndefined(san)){
if(san&&san.nodeType==1){
switch(typeof(GTx)){
case SsC:
if(GTx){
san.setAttribute(SdN,"true");
}
else{
san.setAttribute(SdN,"false");
}
break;
default:

san.setAttribute(SdN,GTx.toString());
}
}
}
};
this.getValue=function(SdN,CmW){
var blY=undefined;
if(dIX&&dIX.nodeType==1){
var Kio=dIX.getAttributeNode(SdN);
if(Kio){blY=Kio.value;}
}
if(isUndefined(blY)){return CmW;}
try{
switch(typeof(CmW)){
case cUw:
return blY;
case TEQ:
return blY;
case aEK:
return blY;
case vMU:
if(blY.indexOf(".")!=-1){
var kpY=parseFloat(blY);
if(isNaN(kpY)){
return CmW;
}
else{
return kpY;
}
}
else{
var sMR=parseInt(blY,10);
if(isNaN(sMR)){
return CmW;
}
else{
return sMR;
}
}
break;
case SsC:
if(blY.toLowerCase()==jSt){
return true;
}
return false;
default:
return CmW;
}
}
catch(FCr){
return CmW;
}
};
};
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(activelms.srp){throw new Error("namepsace activelms.BehaviourType exists");}
activelms.srp=function(){
var xYu=new activelms.xYu();
var RLG=new activelms.RLG();
this.TfM=1;
this.UBt=2;
this.hTs=undefined;
this.MDv=false;
this.cjg=function(hTs){
this.hTs=hTs;
};
this.mVC=function(QZl){
this.MDv=QZl;
};
this.sVX=function(LpN,dJD,DgX,VQr,xNh,kIA,cVJ){
var hEr=LpN.getActivityProgressInfo();
var FOP=LpN.getAttemptProgressInfo();
var Mwd=LpN.Noq().IEV();
var IvD=LpN.Noq().nBU();
var SAX=dJD.Vik();
var rrr=dJD.jrb();
var KZN=xYu.VxA;
var Ltd=[];
var PaW=SAX.length;
var VNs=undefined;
var bRj=undefined;
for(var SRI=0;SRI<PaW;SRI++){
VNs=SAX[SRI];
bRj=
this.KsE(Mwd,VNs,DgX);
var AtF=
VNs.evaluate(LpN,bRj,VQr,xNh,kIA,cVJ);
if(VNs.qBU()==RLG.FVA){
if(AtF==xYu.RBX){
AtF=xYu.TnY;
}
else if(AtF==xYu.TnY){
AtF=xYu.RBX;
}
}
Ltd.push(AtF);
}
if(Ltd.length===0){
return xYu.VxA;
}
if(rrr==xYu.CcC){
KZN=this.Clb(Ltd);
}else if(rrr==xYu.uFA){
KZN=this.NmV(Ltd);
}
return KZN;
};
this.Clb=function(Ltd){
var Gnt=Ltd[0];
var ArI=Ltd.length;
for(var SRI=1;SRI<ArI;SRI++){
var Krn=Ltd[SRI];
Gnt=this.GLA(Gnt,Krn);
}
return Gnt;
};
this.NmV=function(Ltd){
var Gnt=Ltd[0];
var ArI=Ltd.length;
for(var SRI=1;SRI<ArI;SRI++){
var Krn=Ltd[SRI];
Gnt=this.QTh(Gnt,Krn);
}
return Gnt;
};
this.GLA=function(Gnt,Krn){
var gPp=xYu.VxA;
switch(Gnt){
case xYu.RBX:
gPp=Krn;
break;
case xYu.TnY:
gPp=xYu.TnY;
break;
case xYu.VxA:
if(Krn==xYu.RBX){
gPp=xYu.VxA;}
else if(Krn==xYu.TnY){
gPp=xYu.TnY;}
else if(Krn==xYu.VxA){
gPp=xYu.VxA;}
break;
default:
gPp=xYu.VxA;
}
return gPp;
};
this.QTh=function(Gnt,Krn){
var gPp=xYu.VxA;
switch(Gnt){
case xYu.RBX:
gPp=xYu.RBX;
break;
case xYu.TnY:
gPp=Krn;
break;
case xYu.VxA:
if(Krn==xYu.RBX){
gPp=xYu.RBX;}
else if(Krn==xYu.TnY){
gPp=xYu.VxA;}
else if(Krn==xYu.VxA){
gPp=xYu.VxA;}
break;
default:
gPp=xYu.VxA;
}
return gPp;
};
this.KsE=function(Mwd,VNs,DgX){
var bRj;
switch(DgX){
case this.TfM:
var Qks=VNs.ZMM();
if(!isUndefined(Qks)&&Qks!==""){
bRj=Mwd.KsE(Qks);
}
break;
case this.UBt:
bRj=Mwd.Rth();
break;
default:
throw new activelms.ApplicationError("Unrecognised behaviour type");
}
if(isUndefined(bRj)||bRj===null){
bRj=Mwd.Bqt();
}
return bRj;
};
this.add=function(waq,Iew){
var RqI=waq+Iew;
return RqI;
};
this.KXT=function(waq,Iew){
var RqI=waq-Iew;
return RqI;
};
this.pgM=function(waq,Iew){
var RqI=waq*Iew;
return RqI;
};
this.UNG=function(waq,Iew){
var RqI=waq/Iew;
return RqI;
};
this.UxL=function(drd){
if(drd>0){
return true;
}
return false;
};
this.Bna=function(drd,gNC){
if(drd>=gNC){
return true;
}
return false;
};
};
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(activelms.GDZ){throw new Error("namespace activelms.SequencingCollection exists");}
if(activelms.Epw){throw new Error("namepsace activelms.Sequencing exists");}
if(activelms.soH){throw new Error("namepsace activelms.ControlMode exists");}
if(activelms.pGj){throw new Error("namepsace activelms.DeliveryControls exists");}
if(activelms.wUb){throw new Error("namepsace activelms.ConstrainedChoiceConsiderations exists");}
if(activelms.JQi){throw new Error("namepsace activelms.RollupConsiderations exists");}
if(activelms.xYu){throw new Error("namepsace activelms.Rule exists");}
if(activelms.nER){throw new Error("namepsace activelms.Rules exists");}
if(activelms.Mdd){throw new Error("namepsace activelms.RollupRules exists");}
if(activelms.tXE){throw new Error("namepsace activelms.SequencingRules exists");}
if(activelms.icx){throw new Error("namepsace activelms.SequencingRule exists");}
if(activelms.weG){throw new Error("namepsace activelms.RollupRule exists");}
if(activelms.RLG){throw new Error("namepsace activelms.Condition exists");}
activelms.GDZ=function(dIX){
activelms.DefinitionType.call(this,dIX);
this.nQo="sequencing";
var Nqv=undefined;
this.OrS=function(){
if(isUndefined(Nqv)){
Nqv=new activelms.HashTable();
var tvu;
var WrJ=this.eoW(this.nQo);
if(!isUndefined(WrJ)){
var PaW=WrJ.length;
for(var SRI=0;SRI<PaW;SRI++){
tvu=new activelms.Epw(WrJ[SRI]);
Nqv.put(tvu.getID(),tvu);
}
}
}
return Nqv;
};
this.Noq=function(fOf){
return this.OrS().get(fOf);
}
this.size=function(){
return this.OrS().size();
}
this.elements=function(){
return this.OrS().elements();
}
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="size: "+this.OrS().size()+"\n";
return cZn;
};
};
activelms.GDZ.prototype=new activelms.DefinitionType();
delete activelms.GDZ.prototype.dIX;
activelms.GDZ.prototype.constructor=activelms.GDZ;
activelms.Epw=function(dIX,LpN){
var xYu=new activelms.xYu();
var weG=new activelms.weG();
var icx=new activelms.icx();
var RLG=new activelms.RLG();
this.KqU="controlMode";
this.PkW="deliveryControls";
this.Cpq="objectives";
this.VPt="sequencingRules";
this.pvo="rollupRules";
this.GnH="rollupConsiderations";
this.VBf="limitConditions";
this.Xnt="randomizationControls";
this.wSV="auxiliaryResources";
this.wxQ="constrainedChoiceConsiderations";
activelms.DefinitionType.call(this,dIX);
var tpY=undefined;
var tbe=undefined;
var ELR=undefined;
var Mwd=undefined;
var IvD=undefined;
var wxm=undefined;
var aku=undefined;
var Ukl;
this.getID=function(){
return this.getValue("ID",undefined);
};
this.Jdf=function(){
return this.getValue("IDRef",undefined);
};
this.ftb=function(uGw,NGe){
var nrE=this.cgt(NGe);
var Lpw=undefined;
var LdZ=false;
var Wrq=false;
if(isUndefined(nrE)||nrE==null){
var INn=this.Jdf();
if(INn!=null&&!isUndefined(activelms.pQT)){
var tvu=activelms.pQT.Noq(INn);
Lpw=tvu.cgt(NGe);
if(!isUndefined(Lpw)&&Lpw!=null){
Wrq=true;
}
}
}
else{LdZ=true;}
if(LdZ){
return uGw.factory(nrE);
}
else if(!LdZ&&Wrq){
return uGw.factory(Lpw);
}
return uGw.factory();
};
this.YYI=function(){
if(isUndefined(tpY)){
tpY=this.ftb(activelms.soH,this.KqU);
}
return tpY;
};
this.LVt=function(){
if(isUndefined(ELR)){
ELR=this.ftb(activelms.pGj,this.PkW);
}
return ELR;
};
this.mJl=function(){
if(isUndefined(Ukl)){
Ukl=this.ftb(activelms.JQi,this.GnH);
}
return Ukl;
};
this.JeZ=function(){
if(isUndefined(aku)){
aku=this.ftb(activelms.Mdd,this.pvo);
}
return aku;
};
this.auo=function(){
if(isUndefined(wxm)){
wxm=this.ftb(activelms.tXE,this.VPt);
}
return wxm;
};
this.sRm=function(){
if(isUndefined(tbe)){
tbe=this.ftb(activelms.wUb,this.wxQ);
}
return tbe;
};
this.IEV=function(){
var kWC=false;
var kIA=this.LVt().SPO();
var UjA=
this.mJl().KRi();
if(isUndefined(Mwd)){
var nrE=this.cgt(this.Cpq);
var Lpw=undefined;
var LdZ=false;
var Wrq=false;
if(isUndefined(nrE)||nrE==null){
var INn=this.Jdf();
if(INn!=null&&!isUndefined(activelms.pQT)){
var tvu=activelms.pQT.Noq(INn);
Lpw=tvu.cgt(this.Cpq);
if(!isUndefined(Lpw)&&Lpw!=null){
Wrq=true;
}
}
}
else{LdZ=true;}
if(LdZ){
Mwd=new activelms.MMf(nrE,kWC,undefined,kIA,LpN);
}
else if(!LdZ&&Wrq){
Mwd=new activelms.MMf(Lpw,kWC,undefined,kIA,LpN);
}
else{
Mwd=new activelms.MMf(undefined,kWC,undefined,kIA,LpN);
}
}
return Mwd;
};
this.nBU=function(){
if(isUndefined(IvD)){
IvD=this.ftb(activelms.WoX,this.VBf);
}
return IvD;
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="ID: "+this.getID()+"\n";
cZn+="IDRef: "+this.Jdf()+"\n";
return cZn;
};
};
activelms.Epw.prototype=new activelms.DefinitionType();
delete activelms.Epw.prototype.dIX;
activelms.Epw.prototype.constructor=activelms.Epw;
activelms.soH=function(dIX){
activelms.DefinitionType.call(this,dIX);
this.sWL=true;
this.dJO=true;
this.RfD=false;
this.vsA=false;
this.YAI=true;
this.aEW=true;
var Jek=undefined;
var Dfi=undefined;
var ouu=undefined;
var ScE=undefined;
var vHU=undefined;
var cZq=undefined;
this.XGi=function(){
if(isUndefined(Jek)){
Jek=this.getValue("choice",this.sWL);
}
return Jek;
};
this.TZp=function(){
if(isUndefined(Dfi)){
Dfi=this.getValue("choiceExit",this.dJO);
}
return Dfi;
};
this.axs=function(){
if(isUndefined(ouu)){
ouu=this.getValue("flow",this.RfD);
}
return ouu;
};
this.Opk=function(){
if(isUndefined(ScE)){
ScE=this.getValue("forwardOnly",this.vsA);
}
return ScE;
};
this.wnD=function(){
if(isUndefined(vHU)){
vHU=
this.getValue("useCurrentAttemptObjectiveInfo",this.YAI);
}
return vHU;
};
this.Rto=function(){
if(isUndefined(cZq)){
cZq=
this.getValue("useCurrentAttemptProgressInfo",this.aEW);
}
return cZq;
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="choice: "+this.XGi()+"\n";
cZn+="choiceExit: "+this.TZp()+"\n";
cZn+="flow: "+this.axs()+"\n";
cZn+="forwardOnly: "+this.Opk()+"\n";
return cZn;
};
};
activelms.soH.prototype=new activelms.DefinitionType();
delete activelms.soH.prototype.dIX;
activelms.soH.prototype.constructor=activelms.soH;
activelms.soH.factory=function(sBs){return new activelms.soH(sBs);};
activelms.pGj=function(dIX){
activelms.DefinitionType.call(this,dIX);
this.msd=true;
this.pnB=false;
this.MKF=false;
var kIA=undefined;
var CMB=undefined;
var gWY=undefined;
this.SPO=function(){
if(isUndefined(kIA)){
kIA=this.getValue("tracked",this.msd);
}
return kIA;
};
this.Jsn=function(){
if(isUndefined(CMB)){
CMB=
this.getValue("completionSetByContent",this.pnB);
}
return CMB;
};
this.gHh=function(){
if(isUndefined(gWY)){
gWY=
this.getValue("objectiveSetByContent",this.MKF);
}
return gWY;
};
};
activelms.pGj.prototype=new activelms.DefinitionType();
delete activelms.pGj.prototype.dIX;
activelms.pGj.prototype.constructor=activelms.pGj;
activelms.pGj.factory=function(sBs){return new activelms.pGj(sBs);};
activelms.wUb=function(dIX){
activelms.DefinitionType.call(this,dIX);
this.Rls=false;
this.uVT=false;
var Mwi=undefined;
var Sbk=undefined;
this.fVo=function(){
if(!Mwi){
Mwi=
this.getValue("constrainChoice",this.Rls);
}
return Mwi;
};
this.FnQ=function(){
if(!Sbk){
Sbk=
this.getValue("preventActivation",this.uVT);
}
return Sbk;
};
};
activelms.wUb.prototype=new activelms.DefinitionType();
delete activelms.wUb.prototype.dIX;
activelms.wUb.prototype.constructor=activelms.wUb;
activelms.wUb.factory=function(sBs){return new activelms.wUb(sBs);};
activelms.JQi=function(dIX){
activelms.DefinitionType.call(this,dIX);
this.jUF="measureSatisfactionIfActive";
this.JXR="requiredForSatisfied";
this.wal="requiredForNotSatisfied";
this.PmA="requiredForCompleted";
this.LpQ="requiredForIncomplete";
this.hZR="always";
this.wie="ifNotSuspended";
this.pmK="ifAttempted";
this.dNU="ifNotSkipped";
this.lfE=true;
this.UBT=this.hZR;
this.CTv=this.hZR;
this.vnE=this.hZR;
this.rSr=this.hZR;
var UjA=undefined;
var fiH=undefined;
var mxG=undefined;
var PUh=undefined;
var ocr=undefined;
this.KRi=function(){
if(isUndefined(UjA)){
UjA=
this.getValue(this.jUF,this.lfE);
}
return UjA;
};
this.wSv=function(){
return this.getValue(this.JXR,this.UBT);
};
this.aCb=function(){
return this.getValue(this.wal,this.CTv);
};
this.nEJ=function(){
return this.getValue(this.PmA,this.vnE);
};
this.OlX=function(){
return this.getValue(this.LpQ,this.rSr);
};
};
activelms.JQi.prototype=new activelms.DefinitionType();
delete activelms.JQi.prototype.dIX;
activelms.JQi.prototype.constructor=activelms.JQi;
activelms.JQi.factory=function(sBs){return new activelms.JQi(sBs);};
activelms.xYu=function(dIX){
this.VxA=2;
this.TnY=3;
this.RBX=4;
this.TsQ=5;
this.iDr=6;
this.HDh="preConditionRule";
this.eZC="postConditionRule";
this.vgu="exitConditionRule";
this.lGV=[
this.HDh,this.eZC,this.vgu];
this.RZq="rollupRule";
this.CcC="all";
this.uFA="any";
this.sdS=this.CcC;
this.TTu=this.uFA;
activelms.DefinitionType.call(this,dIX);
this.getType=function(){
throw new ApplicationError("Not Implemented");
};
this.Hxv=function(){
return this.qSg(dIX.nodeName);
};
this.mpP=function(){
throw new ApplicationError("Not Implemented");
};
this.jrb=function(){
throw new ApplicationError("Not Implemented");
};
this.Vik=function(){
throw new ApplicationError("Not Implemented");
};
this.Kgw=function(){
throw new ApplicationError("Not Implemented");
};
this.Nqr=function(){
throw new ApplicationError("Not Implemented");
};
this.Qcw=function(){
throw new ApplicationError("Not Implemented");
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="rule type: "+this.getType()+"\n";
cZn+="conditions: "+this.Vik()+"\n";
cZn+="action: "+this.mpP()+"\n";
return cZn;
};
};
activelms.xYu.prototype=new activelms.DefinitionType();
delete activelms.xYu.prototype.dIX;
activelms.xYu.prototype.constructor=activelms.xYu;
activelms.icx=function(dIX){
this.bxm=3;
this.dLJ=4;
this.KQK=5;
this.MpS="skip";
this.uDj="disabled";
this.MlO="hiddenFromChoice";
this.YLI="stopForwardTraversal";
this.duM="ignore";
this.KLM=[
this.MpS,this.uDj,this.MlO,this.YLI,this.duM];
this.qQP=[this.MlO];
this.jVA=[this.MpS];
this.qPn=[this.YLI];
this.Ato="exitParent";
this.gnH="exitAll";
this.TpQ="retry";
this.Qea="retryAll";
this.tYl="continue";
this.VDG="previous";
this.TSj=[
this.Ato,this.gnH,this.TpQ,this.Qea,this.tYl,this.VDG,this.duM];
this.lgp="exit";
this.xMr=[
this.lgp,this.duM];
this.MqH=this.duM;
activelms.xYu.call(this,dIX);
this.getType=function(){
return this.TsQ;
};
this.mpP=function(){
var HZE="ruleAction";
var SdN="action";
var tJr=this.cgt(HZE);
var Kio=tJr.getAttributeNode(SdN);
if(Kio){
return Kio.value;
}
return this.MqH;
};
this.jrb=function(){
var HZE="ruleConditions";
var SdN="conditionCombination";
var tJr=this.cgt(HZE);
var Kio=tJr.getAttributeNode(SdN);
if(Kio){
return Kio.value;
}
return this.sdS;
};
this.Vik=function(){
var SAX=[];
var HZE="ruleConditions";
var JCJ=this.cgt(HZE);
if(JCJ){
var WrJ=JCJ.childNodes;
if(WrJ.length!=0){
HZE="ruleCondition";
var PaW=WrJ.length;
var VNs=undefined;
var sBs=undefined;
var WVc=this.getType();
for(var SRI=0;SRI<PaW;SRI++){
sBs=WrJ[SRI];
if(sBs.nodeName.indexOf(HZE)!=-1){
VNs=new activelms.RLG(sBs,WVc);
SAX.push(VNs);
}
}
}
}
return SAX;
};
};
activelms.icx.prototype=new activelms.xYu();
delete activelms.icx.prototype.dIX;
activelms.icx.prototype.constructor=activelms.icx;
activelms.weG=function(dIX){
this.dvQ="rollupAction";
this.qqI="action";
this.Bvj="satisfied";
this.oJB="notSatisfied";
this.Yff="completed";
this.QgD="incomplete";
this.hHX=this.Bvj;
this.FMs="childActivitySet";
this.dOY="minimumCount";
this.YiR="minimumPercent";
this.CcC="all";
this.uFA="any";
this.bLM="none";
this.NIb="atLeastCount";
this.Gkm="atLeastPercent";
this.pqZ=this.CcC;
this.aMP=0;
this.jEN=0.0000;
activelms.xYu.call(this,dIX);
this.getType=function(){
return this.iDr;
};
this.Kgw=function(){
return this.getValue(this.FMs,this.pqZ);
};
this.Nqr=function(){
return this.getValue(this.dOY,this.aMP);
};
this.Qcw=function(){
return this.getValue(this.YiR,this.jEN);
};
this.mpP=function(){
var HZE="rollupAction";
var SdN="action";
var tJr=this.cgt(HZE);
var Kio=tJr.getAttributeNode(SdN);
if(Kio){
return Kio.value;
}
return this.hHX;
};
this.jrb=function(){
var HZE="rollupConditions";
var SdN="conditionCombination";
var tJr=this.cgt(HZE);
var Kio=tJr.getAttributeNode(SdN);
if(Kio){
return Kio.value;
}
return this.TTu;
};
this.Vik=function(){
var SAX=[];
var HZE="rollupConditions";
var JCJ=this.cgt(HZE);
if(JCJ){
var WrJ=JCJ.childNodes;
if(WrJ.length!=0){
HZE="rollupCondition";
var PaW=WrJ.length;
var VNs=undefined;
var sBs=undefined;
var WVc=this.getType();
for(var SRI=0;SRI<PaW;SRI++){
sBs=WrJ[SRI];
if(sBs.nodeName.indexOf(HZE)!=-1){
VNs=new activelms.RLG(sBs,WVc);
SAX.push(VNs);
}
}
}
}
return SAX;
};
};
activelms.weG.prototype=new activelms.xYu();
delete activelms.weG.prototype.dIX;
activelms.weG.prototype.constructor=activelms.weG;
activelms.RLG=function(dIX,HqL){
var xYu=new activelms.xYu();
this.lFR="ruleConditions";
this.oTh="rollupConditions";
this.mqX="ruleCondition";
this.cKn="rollupCondition";
this.ISh="conditionCombination";
this.CcC="all";
this.uFA="any";
this.sdS=this.CcC;
this.TTu=this.uFA;
this.gDf="referencedObjective";
this.NuL="measureThreshold";
this.flE="operator";
this.lak="condition";
this.VFP="noOp";
this.FVA="not";
this.Bvj="satisfied";
this.vnF="objectiveStatusKnown";
this.DaX="objectiveMeasureKnown";
this.dJG="objectiveMeasureGreaterThan";
this.Est="objectiveMeasureLessThan";
this.Yff="completed";
this.BwB="activityProgressKnown";
this.fAH="attempted";
this.LUF="attemptLimitExceeded";
this.hGs="timeLimitExceeded";
this.JvB="outsideAvailableTimeRange";
this.CqV="never";
this.hZR="always";
this.fAH="attempted";
this.Suu=undefined;
this.rEN=0.0000;
this.dlU=this.VFP;
this.qKv=this.CqV;
this.ueF=this.hZR;
activelms.DefinitionType.call(this,dIX);
var VLu=function(Wbb,LpN,iDM){
if(iDM){
var hoT=LpN.isActive();
var Ukl=LpN.Noq().mJl();
var UjA=Ukl.KRi();
if(LpN.isActive()&!UjA){
return xYu.VxA;
}
}
var bgp=xYu.VxA;
if(Wbb.getProgressStatus()){
bgp=xYu.TnY;
if(Wbb.getSatisfiedStatus()){
bgp=xYu.RBX;
}
}
return bgp;
};
var cSw=function(Wbb,LpN,iDM){
if(iDM){
var hoT=LpN.isActive();
var Ukl=LpN.Noq().mJl();
var UjA=Ukl.KRi();
if(LpN.isActive()&!UjA){
return xYu.TnY;
}
}
if(Wbb.getProgressStatus()){
return xYu.RBX;
}
else{
return xYu.TnY;
}
};
var UPH=function(Wbb){
if(Wbb.getMeasureStatus()){
return xYu.RBX;
}
else{
return xYu.TnY;
}
};
var cKm=function(Wbb,nGL){
var bgp=xYu.VxA;
if(Wbb.getMeasureStatus()){
bgp=xYu.TnY;
if(Wbb.getNormalizedMeasure()>nGL){
bgp=xYu.RBX;
}
}
return bgp;
};
var Drv=function(Wbb,nGL){
var bgp=xYu.VxA;
if(Wbb.getMeasureStatus()){
bgp=xYu.TnY;
if(Wbb.getNormalizedMeasure()<nGL){
bgp=xYu.RBX;
}
}
return bgp;
};
var KcB=function(FOP){
var bgp=xYu.VxA;
if(FOP.getProgressStatus()){
bgp=xYu.TnY;
if(FOP.getCompletionStatus()){
bgp=xYu.RBX;
}
}
return bgp;
};
var rVg=function(hEr,FOP){
if(hEr.getProgressStatus()&&FOP.getProgressStatus()){
return xYu.RBX;
}
else{
return xYu.TnY;
}
};
var UYw=function(hEr){
if(hEr.getProgressStatus()&&hEr.getAttemptCount()>0){
return xYu.RBX;
}
else{
return xYu.TnY;
}
};
var hvk=function(hEr,IvD){
if(hEr.getProgressStatus()&&IvD.sKZ()&&hEr.getAttemptCount()>=
IvD.ZID()){
return xYu.RBX;
}
else{
return xYu.TnY;
}
};
this.evaluate=function(LpN,bRj,VQr,xNh,kIA,cVJ){
var AtF=xYu.VxA;
var hEr=LpN.getActivityProgressInfo();
var FOP=LpN.getAttemptProgressInfo();
var Wbb=bRj.getObjectiveProgressInfo();
var IvD=LpN.Noq().nBU();
var iDM=bRj.RKU();
if(!kIA&&cVJ>=2004.31){
Wbb=
new activelms.ObjectiveProgressInfo();
FOP=
new activelms.AttemptProgressInfo();
}
if(!VQr){
Wbb=
new activelms.ObjectiveProgressInfo();
}
if(!xNh){
FOP=
new activelms.AttemptProgressInfo();
}
switch(this.fRE()){
case this.Bvj:
return VLu(Wbb,LpN,iDM);
case this.vnF:
return cSw(Wbb,LpN,iDM);
case this.DaX:
return UPH(Wbb);
case this.dJG:
return cKm(Wbb,this.tRe());
case this.Est:
return Drv(Wbb,this.tRe());
case this.Yff:
return KcB(FOP);
case this.BwB:
return rVg(hEr,FOP);
case this.fAH:
return UYw(hEr);
case this.LUF:
return hvk(hEr,IvD);
case this.hZR:
return xYu.RBX;
default:
return xYu.VxA;
}
};
this.fRE=function(){
if(HqL==xYu.iDr){
return this.getValue("condition",this.qKv);
}
else{
return this.getValue("condition",this.ueF);
}
};
this.qBU=function(){
return this.getValue("operator",this.dlU);
};
this.ZMM=function(){
return this.getValue("referencedObjective",this.Suu);
};
this.tRe=function(){
return this.getValue("measureThreshold",this.rEN);
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="condition: "+this.fRE()+"\n";
cZn+="operator: "+this.qBU()+"\n";
cZn+="referencedObjectiveID: "+this.ZMM()+"\n";
cZn+="measureThreshold: "+this.tRe()+"\n";
return cZn;
};
};
activelms.RLG.prototype=new activelms.DefinitionType();
delete activelms.RLG.prototype.dIX;
activelms.RLG.prototype.constructor=activelms.RLG;
activelms.nER=function(dIX){
activelms.DefinitionType.call(this,dIX);
var xYu=new activelms.xYu();
var icx=new activelms.icx();
var weG=new activelms.weG();
var RLG=new activelms.RLG();
this.dMM=function(POn,YsU,dbj){
var ULH=[];
var afJ=true;
var bTG=true;
if(!isUndefined(dbj)){
if(dbj&&dbj.hasChildNodes()){
var PaW=dbj.childNodes.length;
var tJr;
for(var SRI=0;SRI<PaW;SRI++){
var dJD=undefined;
tJr=dbj.childNodes[SRI];
if(tJr.nodeType==Node.ELEMENT_NODE){
var CMd=this.qSg(tJr.nodeName);
if(CMd==xYu.RZq){
if(POn==xYu.iDr){
dJD=new activelms.weG(tJr,POn);
}
}
else{
for(var olg=0;olg<icx.lGV.length;olg++){
if(CMd==icx.lGV[olg]){
if(POn==xYu.TsQ){
dJD=new activelms.icx(tJr,POn);
}
break;
}
}
}
}
if(isUndefined(dJD)){
continue;
}
ULH.push(dJD);
}
var OSV=ULH.length;
var ZGX=null;
var wdm=null;
for(var itM=0;itM<OSV;itM++){
ZGX=ULH[itM];
if(ZGX.getType()==xYu.iDr){
wdm=ZGX.mpP();
if((wdm==weG.Bvj)||(wdm==weG.oJB)){
afJ=false;
break;
}
}
}
for(var itM=0;itM<OSV;itM++){
ZGX=ULH[itM];
if(ZGX.getType()==xYu.iDr){
wdm=ZGX.mpP();
if((wdm==weG.Yff)||(wdm==weG.QgD)){
bTG=false;
break;
}
}
}
}
}
if(POn==xYu.iDr){
if(afJ){
this.hdo(ULH,YsU);
}
if(bTG){
this.QIE(ULH,YsU);
}
}
var kEr=[];
if(isUndefined(YsU)||YsU===null||(YsU instanceof Array)===false){
kEr=ULH;
}
else{
var hmH=YsU.length;
var LJv;
var qMj=ULH.length;
for(var EIf=0;EIf<hmH;EIf++){
LJv=YsU[EIf];
for(var olg=0;olg<qMj;olg++){
if(LJv==ULH[olg].mpP()){
kEr.push(ULH[olg]);
}
}
}
}
if(POn==xYu.TsQ){
if(kEr.length!==0){
return kEr;
}
}
else if(POn==xYu.iDr){
return kEr;
}
};
var fPS=function(YsU,iKT){
if(isUndefined(YsU)||YsU===null||(YsU instanceof Array)===false){
return true;
}
var hmH=YsU.length;
var LJv;
for(var EIf=0;EIf<hmH;EIf++){
LJv=YsU[EIf];
if(LJv==iKT){
return true;
}
}
return false;
}
this.hdo=function(ULH,YsU){
if(fPS(YsU,weG.oJB)){
ULH.push(this.tJv(new Array(RLG.fAH,RLG.Bvj),new Array(RLG.VFP,RLG.FVA),weG.oJB,weG.CcC));
}
if(fPS(YsU,weG.Bvj)){
ULH.push(this.tJv(new Array(RLG.Bvj),new Array(RLG.VFP),weG.Bvj,weG.CcC));
}
};
this.QIE=function(ULH,YsU){
if(fPS(YsU,weG.QgD)){
ULH.push(this.tJv([RLG.fAH,RLG.Yff],[RLG.VFP,RLG.FVA],weG.QgD,weG.CcC));
}
if(fPS(YsU,weG.Yff)){
ULH.push(this.tJv([RLG.Yff],[RLG.VFP],weG.Yff,weG.CcC));
}
};
this.tJv=function(SAX,IvL,wdm,iGs){
var pht="";
var Shb=doCreateNewDocument(xYu.RZq,pht);
var ShH=Shb.documentElement;
var bDk=doCreateNewElement(RLG.oTh,pht,Shb);
doSetAttribute(bDk,RLG.ISh,RLG.TTu);
for(var SRI=0;SRI<SAX.length;SRI++){
var KLR=doCreateNewElement(RLG.cKn,pht,Shb);
doSetAttribute(KLR,RLG.flE,IvL[SRI]);
doSetAttribute(KLR,RLG.lak,SAX[SRI]);
bDk.appendChild(KLR);
}
var ZpD=doCreateNewElement(weG.dvQ,pht,Shb);
doSetAttribute(ZpD,weG.qqI,wdm);
doSetAttribute(ShH,weG.FMs,iGs);
ShH.appendChild(bDk);
ShH.appendChild(ZpD);
return new activelms.weG(ShH);
};
};
activelms.nER.prototype=new activelms.DefinitionType();
delete activelms.nER.prototype.dIX;
activelms.nER.prototype.constructor=activelms.nER;
activelms.Mdd=function(dIX){
activelms.nER.call(this,dIX);
var xYu=new activelms.xYu();
this.VCd="rollupObjectiveSatisfied";
this.Ekq="rollupProgressCompletion";
this.nte="objectiveMeasureWeight";
this.bXi=true;
this.GQw=true;
this.cUL=1.0000;
var FZc=undefined;
var iPa=undefined;
var GUv=undefined;
this.QsW=function(){
if(isUndefined(FZc)){
FZc=this.getValue(this.VCd,this.bXi);
}
return FZc;
};
this.IME=function(){
if(isUndefined(iPa)){
iPa=this.getValue(this.Ekq,this.GQw);
}
return iPa;
};
this.uYX=function(){
if(isUndefined(GUv)){
GUv=this.getValue(this.nte,this.cUL);
}
return GUv;
};
this.maK=function(YsU){
return this.dMM(xYu.iDr,YsU,dIX);
};
};
activelms.Mdd.prototype=new activelms.nER();
delete activelms.Mdd.prototype.dIX;
activelms.Mdd.prototype.constructor=activelms.Mdd;
activelms.Mdd.factory=function(sBs){return new activelms.Mdd(sBs);};
activelms.tXE=function(dIX){
activelms.nER.call(this,dIX);
var xYu=new activelms.xYu();
var icx=new activelms.icx();
this.maK=function(YsU){
return this.dMM(xYu.TsQ,YsU,dIX);
};
this.twJ=function(hkZ,YsU){
var ULH=this.dMM(xYu.TsQ,YsU,dIX);
var Kpw=[];
if(!isUndefined(ULH)&&ULH.length&&ULH.length>0){
var PaW=ULH.length;
var dJD;
var Mjw;
switch(hkZ){
case icx.bxm:
Mjw=icx.HDh;
break;
case icx.dLJ:
Mjw=icx.eZC;
break;
case icx.KQK:
Mjw=icx.vgu;
break;
default:
throw new activelms.ApplicationError("Unrecognised sequencing rule type");
}
for(var SRI=0;SRI<PaW;SRI++){
dJD=ULH[SRI];
if(dJD.Hxv()==Mjw){
Kpw.push(dJD);
}
}
}
if(Kpw.length!==0){
return Kpw;
}
};
};
activelms.tXE.prototype=new activelms.nER();
delete activelms.tXE.prototype.dIX;
activelms.tXE.prototype.constructor=activelms.tXE;
activelms.tXE.factory=function(sBs){return new activelms.tXE(sBs);};
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}


if(!activelms.ksP){activelms.ksP={};}
else if(typeof activelms.ksP!="object"){
throw new Error("namepsace activelms.DeliveryBehaviour exists");}
activelms.ksP.invoke=function(hTs,cdH,xbh){
activelms.ksP.JNJ(hTs,cdH,xbh);
activelms.ksP.Ewd(hTs,cdH,xbh);
};
activelms.ksP.JNJ=function(hTs,LpN,MDv){
if(!LpN.isLeaf()){
throw activelms.SequencingBehaviourError.KlB;
}
var otW=hTs.getDescendingActivityPath(hTs.getRoot(),LpN);
if(isUndefined(otW)||!otW.length||otW.length===0){
throw activelms.SequencingBehaviourError.jmR;
}
var PaW=otW.length;
var rgh=new activelms.XuO();
rgh.cjg(hTs);
rgh.mVC(MDv);
var IDM=false;
for(var SRI=0;SRI<PaW;SRI++){
IDM=rgh.Ihh(otW[SRI]);
if(IDM){
throw activelms.SequencingBehaviourError.ddt;
}
}
};
activelms.ksP.Ewd=function(hTs,LpN,MDv){
if(LpN.isActive()){
throw activelms.SequencingBehaviourError.gvo;
}
var rCF=hTs.getSuspendedActivity();
if(!LpN.TRT(rCF)){

activelms.ksP.QWi(hTs,LpN,MDv);
}
var Epw=new activelms.Epw();
var rgh=new activelms.XuO();
rgh.cjg(hTs);
rgh.wIN(LpN);
var IHk=hTs.getDescendingActivityPath(hTs.getRoot(),LpN);
var PaW=IHk.length;
var jja;
var hEr;
var FOP;
var Wbb;
var tpY;
for(var SRI=0;SRI<PaW;SRI++){
jja=IHk[SRI];
if(!jja.isActive()){
var kIA=jja.Noq().LVt().SPO();
if(kIA){
if(jja.arb()){
jja.VYR(false);
}
else{

hEr=
jja.getActivityProgressInfo();
var cPk=
hEr.cJr();
if(cPk==1){
hEr.jbE(true);
}
log.debug("DB.2.5.1.1.2.1");
log.debug("Deliver activity="+jja.getIdentifier()+", attempt count="+cPk);
if(!jja.isLeaf()){
tpY=jja.Noq().YYI();
if(tpY.wnD()){
rgh.oOc(jja);
}
if(tpY.Rto()){
rgh.SFK(jja);
}
}

Wbb=
jja.getObjectiveProgressInfo();
Wbb.init();
FOP=
jja.getAttemptProgressInfo();
FOP.init();
}
}
jja.setActive(true);
}
}
hTs.setCurrentActivity(LpN);
hTs.xXj(undefined);
var kIA=LpN.Noq().LVt().SPO();
if(!kIA){
}
};
activelms.ksP.QWi=function(hTs,LpN,MDv){
var xhF=hTs.getSuspendedActivity();
if(!isUndefined(xhF)&&xhF!==null){
var CQx=hTs.YrQ(LpN,xhF);

var XNk=hTs.getDescendingActivityPath(CQx,xhF);
var PaW=XNk.length;
var Yem;
var Zas;
var cuU;
for(var SRI=0;SRI<PaW;SRI++){
if(XNk[SRI].isLeaf()){
XNk[SRI].VYR(false);
}
else{
cuU=false;
Zas=XNk[SRI].getAvailableChildren();
Yem=Zas.length;
for(var olg=0;olg<Yem;olg++){
if(Zas[olg].arb()){
cuU=true;
break;
}
}
if(!cuU){
XNk[SRI].VYR(false);
}
}
}
hTs.xXj(undefined);
}
};
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(!activelms.EngineFactory){activelms.EngineFactory={};}
else if(typeof activelms.EngineFactory!="object"){throw new Error("namepsace activelms.EngineFactory exists");}
if(activelms.SequencingEngine){throw new Error("namepsace activelms.SequencingEngine exists");}
activelms.EngineFactory.instance=function(hTs,kVj){
return new activelms.SequencingEngine(hTs,false);
};
activelms.SequencingEngine=function(hTs,kVj){
var Xru;
var Zxb;
this.hTs=hTs;
this.setNavType=function(ujl,SnD,MDv){
var dXp=this.rlb(ujl,SnD,MDv);
};
this.getActivityTree=function(){
return this.hTs;
}
this.mhA=function(){
return Xru;
};
this.rlb=function(ujl,SnD,MDv){
if(!isUndefined(ujl)){
activelms.NavigationBehaviour.invoke(this.hTs,ujl,SnD,kVj);
}
var CpT=
activelms.NavigationBehaviour.terminationRequest;
var qAU=
activelms.NavigationBehaviour.sequencingRequest;
if(!isUndefined(CpT)){
activelms.TerminationBehaviour.invoke(this.hTs,CpT);
if(!isUndefined(activelms.TerminationBehaviour.sequencingRequest)){
qAU=
activelms.TerminationBehaviour.sequencingRequest;
}
}
if(!isUndefined(qAU)){
if(qAU!=activelms.SequencingEngine.qPH){
if(CpT==activelms.SequencingEngine.EXIT_ALL||CpT==activelms.SequencingEngine.SUSPEND_ALL||CpT==activelms.SequencingEngine.ABANDON_ALL){
this.hTs.setCurrentActivity(undefined);
return undefined;
}
}
activelms.SequencingBehaviour.invoke(this.hTs,qAU,SnD,kVj);
}
if(activelms.SequencingBehaviour.isSequencingFinished){
this.hTs.setCurrentActivity(undefined);
return undefined;
}
if(!isUndefined(activelms.SequencingBehaviour.deliveryRequest)){
activelms.ksP.invoke(this.hTs,activelms.SequencingBehaviour.deliveryRequest,MDv);
return this.hTs.getCurrentActivity();
}
};
};
activelms.SequencingEngine.INIT="init";
activelms.SequencingEngine.START="start";
activelms.SequencingEngine.RESUME_ALL="resumeAll";
activelms.SequencingEngine.CONTINUE="continue";
activelms.SequencingEngine.PREVIOUS="previous";
activelms.SequencingEngine.mUt="forward";
activelms.SequencingEngine.XIx="backward";
activelms.SequencingEngine.CHOICE="choice";
activelms.SequencingEngine.aKc="jump";
activelms.SequencingEngine.qPH="retry";
activelms.SequencingEngine.EXIT="exit";
activelms.SequencingEngine.EXIT_ALL="exitAll";
activelms.SequencingEngine.EXPIRE_ALL="expireAll";
activelms.SequencingEngine.ABANDON="abandon";
activelms.SequencingEngine.ABANDON_ALL="abandonAll";
activelms.SequencingEngine.SUSPEND="suspend";
activelms.SequencingEngine.SUSPEND_ALL="suspendAll";
activelms.SequencingEngine.NONE="_none_";
activelms.SequencingEngine.UNDEFINED="_undefined_";
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(activelms.ApplicationError){throw new Error("namepsace activelms.ApplicationError exists");}
if(activelms.SequencingBehaviourError){throw new Error("namepsace activelms.SequencingBehaviourError exists");}
if(activelms.Fgk){throw new Error("namepsace activelms.SequencingExceptions exists");}
activelms.ApplicationError=function(TWT,nKd,wYT){
Error.call(this,nKd);
this.description=TWT;
this.name=wYT;
this.message=nKd;
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="description: "+this.description+"\n";
cZn+="message: "+this.message+"\n";
cZn+="name: "+this.name+"\n";
return cZn;
};
};
activelms.ApplicationError.prototype=new Error();
activelms.ApplicationError.prototype.constructor=activelms.ApplicationError;
activelms.ApplicationError.xrC=
new activelms.ApplicationError("Not implemented");
activelms.SequencingBehaviourError=function(hsc,fSR,voG,nKd){
Error.call(this,nKd);
this.name="SequencingBehaviourError";
this.index=hsc;
this.code=fSR;
this.WUM=voG;
this.message=nKd;
this.description="Type="+"activelms.SequencingBehaviourError"+" \n";
this.description+="Index="+hsc+" \n";
this.description+="Code="+fSR+" \n";
this.description+="Message="+nKd+" \n";
this.toString=function(){
return this.description;
};
};
activelms.Fgk=[];
activelms.SequencingBehaviourError.prototype=new activelms.ApplicationError();
delete activelms.SequencingBehaviourError.prototype.message;
activelms.SequencingBehaviourError.prototype.constructor=activelms.SequencingBehaviourError;
activelms.SequencingBehaviourError.TvQ=
new activelms.SequencingBehaviourError(1,"NB.2.1-1","","Current activity is already defined / Sequencing session has already begun");
activelms.Fgk[activelms.SequencingBehaviourError.TvQ.index]=
activelms.SequencingBehaviourError.TvQ;
activelms.SequencingBehaviourError.Zbd=
new activelms.SequencingBehaviourError(2,"NB.2.1-2","","Current activity is not defined / Sequencing session has not begun");
activelms.Fgk[activelms.SequencingBehaviourError.Zbd.index]=
activelms.SequencingBehaviourError.Zbd;
activelms.SequencingBehaviourError.NcO=
new activelms.SequencingBehaviourError(3,"NB.2.1-3","","Suspended activity is not defined");
activelms.Fgk[activelms.SequencingBehaviourError.NcO.index]=
activelms.SequencingBehaviourError.NcO;
activelms.SequencingBehaviourError.iIA=
new activelms.SequencingBehaviourError(4,"NB.2.1-4","","Flow sequencing control mode violation");
activelms.Fgk[activelms.SequencingBehaviourError.iIA.index]=
activelms.SequencingBehaviourError.iIA;
activelms.SequencingBehaviourError.FXM=
new activelms.SequencingBehaviourError(5,"NB.2.1-5","","Flow or forward only sequencing control mode violation");
activelms.Fgk[activelms.SequencingBehaviourError.FXM.index]=
activelms.SequencingBehaviourError.FXM;
activelms.SequencingBehaviourError.Ieb=
new activelms.SequencingBehaviourError(6,"NB.2.1-6","","No activity is previous to the root");
activelms.SequencingBehaviourError.YDl=
new activelms.SequencingBehaviourError(7,"NB.2.1-7","","Unsupported navigation request");
activelms.Fgk[activelms.SequencingBehaviourError.YDl.index]=
activelms.SequencingBehaviourError.YDl;
activelms.SequencingBehaviourError.Smw=
new activelms.SequencingBehaviourError(8,"NB.2.1-8","","Choice exit sequencing control mode violation");
activelms.Fgk[activelms.SequencingBehaviourError.Smw.index]=
activelms.SequencingBehaviourError.Smw;
activelms.SequencingBehaviourError.GLU=
new activelms.SequencingBehaviourError(9,"NB.2.1-9","","No activities to consider");
activelms.Fgk[activelms.SequencingBehaviourError.GLU.index]=
activelms.SequencingBehaviourError.GLU;
activelms.SequencingBehaviourError.lFJ=
new activelms.SequencingBehaviourError(10,"NB.2.1-10","","Choice sequencing control mode violation");
activelms.Fgk[activelms.SequencingBehaviourError.lFJ.index]=
activelms.SequencingBehaviourError.lFJ;
activelms.SequencingBehaviourError.jrf=
new activelms.SequencingBehaviourError(11,"NB.2.1-11","","Target activity does not exist");
activelms.Fgk[activelms.SequencingBehaviourError.jrf.index]=
activelms.SequencingBehaviourError.jrf;
activelms.SequencingBehaviourError.XJe=
new activelms.SequencingBehaviourError(12,"NB.2.1-12","","Current activity already terminated");
activelms.SequencingBehaviourError.VDm=
new activelms.SequencingBehaviourError(13,"NB.2.1-13","","Undefined navigation request");
activelms.Fgk[activelms.SequencingBehaviourError.VDm.index]=
activelms.SequencingBehaviourError.VDm;
activelms.SequencingBehaviourError.QnZ=
new activelms.SequencingBehaviourError(14,"TB.2.3-1","","Current activity is not defined / Sequencing session has not begun");
activelms.Fgk[activelms.SequencingBehaviourError.QnZ.index]=
activelms.SequencingBehaviourError.QnZ;
activelms.SequencingBehaviourError.Npl=
new activelms.SequencingBehaviourError(15,"TB.2.3-2","","Current activity already terminated");
activelms.Fgk[activelms.SequencingBehaviourError.Npl.index]=
activelms.SequencingBehaviourError.Npl;
activelms.SequencingBehaviourError.gwp=
new activelms.SequencingBehaviourError(16,"TB.2.3-3","","Cannot suspend an inactive root");
activelms.Fgk[activelms.SequencingBehaviourError.gwp.index]=
activelms.SequencingBehaviourError.gwp;
activelms.SequencingBehaviourError.WEf=
new activelms.SequencingBehaviourError(17,"TB.2.3-4","","Activity tree root has no parent");
activelms.Fgk[activelms.SequencingBehaviourError.WEf.index]=
activelms.SequencingBehaviourError.WEf;
activelms.SequencingBehaviourError.roH=
new activelms.SequencingBehaviourError(18,"TB.2.3-5","","Nothing to suspend; no active activities");
activelms.Fgk[activelms.SequencingBehaviourError.roH.index]=
activelms.SequencingBehaviourError.roH;
activelms.SequencingBehaviourError.VNC=
new activelms.SequencingBehaviourError(19,"TB.2.3-6","","Nothing to abandon; no active activities");
activelms.Fgk[activelms.SequencingBehaviourError.VNC.index]=
activelms.SequencingBehaviourError.VNC;
activelms.SequencingBehaviourError.Dhr=
new activelms.SequencingBehaviourError(20,"TB.2.3-7","","Undefined termination request");
activelms.Fgk[activelms.SequencingBehaviourError.Dhr.index]=
activelms.SequencingBehaviourError.Dhr;
activelms.SequencingBehaviourError.scX=
new activelms.SequencingBehaviourError(21,"SB.2.1-1","","Last activity in the tree");
activelms.Fgk[activelms.SequencingBehaviourError.scX.index]=
activelms.SequencingBehaviourError.scX;
activelms.SequencingBehaviourError.sWt=
new activelms.SequencingBehaviourError(22,"SB.2.1-2","","Cluster has no available children");
activelms.Fgk[activelms.SequencingBehaviourError.sWt.index]=
activelms.SequencingBehaviourError.sWt;
activelms.SequencingBehaviourError.vkD=
new activelms.SequencingBehaviourError(23,"SB.2.1-3","","No activity is previous to the root");
activelms.Fgk[activelms.SequencingBehaviourError.vkD.index]=
activelms.SequencingBehaviourError.vkD;
activelms.SequencingBehaviourError.WZA=
new activelms.SequencingBehaviourError(24,"SB.2.1-4","","Forward only sequencing control mode violation");
activelms.Fgk[activelms.SequencingBehaviourError.WZA.index]=
activelms.SequencingBehaviourError.WZA;
activelms.SequencingBehaviourError.xrT=
new activelms.SequencingBehaviourError(25,"SB.2.2-1","","Flow sequencing control mode violation");
activelms.Fgk[activelms.SequencingBehaviourError.xrT.index]=
activelms.SequencingBehaviourError.xrT;
activelms.SequencingBehaviourError.gPB=
new activelms.SequencingBehaviourError(26,"SB.2.2-2","","Target activity unavailable");
activelms.Fgk[activelms.SequencingBehaviourError.gPB.index]=
activelms.SequencingBehaviourError.gPB;
activelms.SequencingBehaviourError.Dvq=
new activelms.SequencingBehaviourError(27,"SB.2.4-1","","Forward traversal blocked");
activelms.Fgk[activelms.SequencingBehaviourError.Dvq.index]=
activelms.SequencingBehaviourError.Dvq;
activelms.SequencingBehaviourError.Qiw=
new activelms.SequencingBehaviourError(28,"SB.2.4-2","","Forward only sequencing control mode violation");
activelms.Fgk[activelms.SequencingBehaviourError.Qiw.index]=
activelms.SequencingBehaviourError.Qiw;
activelms.SequencingBehaviourError.qhG=
new activelms.SequencingBehaviourError(29,"SB.2.4-3","","No activity is previous to the root");
activelms.Fgk[activelms.SequencingBehaviourError.qhG.index]=
activelms.SequencingBehaviourError.qhG;
activelms.SequencingBehaviourError.wFm=
new activelms.SequencingBehaviourError(30,"SB.2.5-1","","Current activity is defined / Sequencing session already begun");
activelms.Fgk[activelms.SequencingBehaviourError.wFm.index]=
activelms.SequencingBehaviourError.wFm;
activelms.SequencingBehaviourError.FWe=
new activelms.SequencingBehaviourError(31,"SB.2.6-1","","Current activity is defined / Sequencing session already begun");
activelms.Fgk[activelms.SequencingBehaviourError.FWe.index]=
activelms.SequencingBehaviourError.FWe;
activelms.SequencingBehaviourError.qGI=
new activelms.SequencingBehaviourError(32,"SB.2.6-2","","No suspended activity defined");
activelms.Fgk[activelms.SequencingBehaviourError.qGI.index]=
activelms.SequencingBehaviourError.qGI;
activelms.SequencingBehaviourError.cDL=
new activelms.SequencingBehaviourError(33,"SB.2.7-1","","Current activity is not defined / Sequencing session has not begun");
activelms.Fgk[activelms.SequencingBehaviourError.cDL.index]=
activelms.SequencingBehaviourError.cDL;
activelms.SequencingBehaviourError.tmc=
new activelms.SequencingBehaviourError(34,"SB.2.7-2","","Flow sequencing control mode violation");
activelms.Fgk[activelms.SequencingBehaviourError.tmc.index]=
activelms.SequencingBehaviourError.tmc;
activelms.SequencingBehaviourError.RTA=
new activelms.SequencingBehaviourError(35,"SB.2.8-1","","Current activity is not defined / Sequencing session has not begun");
activelms.Fgk[activelms.SequencingBehaviourError.RTA.index]=
activelms.SequencingBehaviourError.RTA;
activelms.SequencingBehaviourError.jCx=
new activelms.SequencingBehaviourError(36,"SB.2.8-2","","Flow sequencing control mode violation");
activelms.Fgk[activelms.SequencingBehaviourError.jCx.index]=
activelms.SequencingBehaviourError.jCx;
activelms.SequencingBehaviourError.leb=
new activelms.SequencingBehaviourError(37,"SB.2.9-1","","No target for choice");
activelms.Fgk[activelms.SequencingBehaviourError.leb.index]=
activelms.SequencingBehaviourError.leb;
activelms.SequencingBehaviourError.Rge=
new activelms.SequencingBehaviourError(38,"SB.2.9-2","","Target activity does not exist or is unavailable");
activelms.Fgk[activelms.SequencingBehaviourError.Rge.index]=
activelms.SequencingBehaviourError.Rge;
activelms.SequencingBehaviourError.kBk=
new activelms.SequencingBehaviourError(39,"SB.2.9-3","","Target activity hidden from choice");
activelms.Fgk[activelms.SequencingBehaviourError.kBk.index]=
activelms.SequencingBehaviourError.kBk;
activelms.SequencingBehaviourError.dEG=
new activelms.SequencingBehaviourError(40,"SB.2.9-4","","Choice sequencing control mode violation");
activelms.Fgk[activelms.SequencingBehaviourError.dEG.index]=
activelms.SequencingBehaviourError.dEG;
activelms.SequencingBehaviourError.VNW=
new activelms.SequencingBehaviourError(41,"SB.2.9-5","","No activities to consider");
activelms.Fgk[activelms.SequencingBehaviourError.VNW.index]=
activelms.SequencingBehaviourError.VNW;
activelms.SequencingBehaviourError.OkD=
new activelms.SequencingBehaviourError(42,"SB.2.9-6","","Unable to choose target activity; target is not a child of the current activity");
activelms.Fgk[activelms.SequencingBehaviourError.OkD.index]=
activelms.SequencingBehaviourError.OkD;
activelms.SequencingBehaviourError.dfa=
new activelms.SequencingBehaviourError(43,"SB.2.9-7","","Choice exit sequencing control mode violation");
activelms.Fgk[activelms.SequencingBehaviourError.dfa.index]=
activelms.SequencingBehaviourError.dfa;
activelms.SequencingBehaviourError.BPQ=
new activelms.SequencingBehaviourError(44,"SB.2.9-8","","Unable to choose target activity - constrained choice");
activelms.Fgk[activelms.SequencingBehaviourError.BPQ.index]=
activelms.SequencingBehaviourError.BPQ;
activelms.SequencingBehaviourError.CEH=
new activelms.SequencingBehaviourError(45,"SB.2.9-9","","Choice request prevented by flow-only activity");
activelms.Fgk[activelms.SequencingBehaviourError.CEH.index]=
activelms.SequencingBehaviourError.CEH;
activelms.SequencingBehaviourError.xiD=
new activelms.SequencingBehaviourError(46,"SB.2.10-1","","Current activity is not defined/Sequencing session has not begun");
activelms.Fgk[activelms.SequencingBehaviourError.xiD.index]=
activelms.SequencingBehaviourError.xiD;
activelms.SequencingBehaviourError.FaK=
new activelms.SequencingBehaviourError(47,"SB.2.10-2","","Current activity is active or suspended");
activelms.Fgk[activelms.SequencingBehaviourError.FaK.index]=
activelms.SequencingBehaviourError.FaK;
activelms.SequencingBehaviourError.lxB=
new activelms.SequencingBehaviourError(48,"SB.2.10-3","","Flow sequencing control mode violation");
activelms.Fgk[activelms.SequencingBehaviourError.lxB.index]=
activelms.SequencingBehaviourError.lxB;
activelms.SequencingBehaviourError.wuo=
new activelms.SequencingBehaviourError(49,"SB.2.11-1","","Current activity is not defined / Sequencing session has not begun");
activelms.Fgk[activelms.SequencingBehaviourError.wuo.index]=
activelms.SequencingBehaviourError.wuo;
activelms.SequencingBehaviourError.cRK=
new activelms.SequencingBehaviourError(50,"SB.2.11-2","","Current activity has not been terminated");
activelms.Fgk[activelms.SequencingBehaviourError.cRK.index]=
activelms.SequencingBehaviourError.cRK;
activelms.SequencingBehaviourError.RRp=
new activelms.SequencingBehaviourError(51,"SB.2.12-1","","Undefined sequencing request");
activelms.Fgk[activelms.SequencingBehaviourError.RRp.index]=
activelms.SequencingBehaviourError.RRp;
activelms.SequencingBehaviourError.KlB=
new activelms.SequencingBehaviourError(52,"DB.1.1-1","","Cannot deliver a non-leaf activity");
activelms.Fgk[activelms.SequencingBehaviourError.KlB.index]=
activelms.SequencingBehaviourError.KlB;
activelms.SequencingBehaviourError.jmR=
new activelms.SequencingBehaviourError(53,"DB.1.1-2","","Nothing to deliver");
activelms.Fgk[activelms.SequencingBehaviourError.jmR.index]=
activelms.SequencingBehaviourError.jmR;
activelms.SequencingBehaviourError.ddt=
new activelms.SequencingBehaviourError(54,"DB.1.1-3","","Target activity unavailable");
activelms.Fgk[activelms.SequencingBehaviourError.ddt.index]=
activelms.SequencingBehaviourError.ddt;
activelms.SequencingBehaviourError.gvo=
new activelms.SequencingBehaviourError(55,"DB.2-1","","Identified activity is already active");
activelms.Fgk[activelms.SequencingBehaviourError.gvo.index]=
activelms.SequencingBehaviourError.gvo;
activelms.SequencingBehaviourError.tOe=
new activelms.SequencingBehaviourError(56,"SB.2.13-1","","Current activity is not defined/Sequencing session has not begun");
activelms.Fgk[activelms.SequencingBehaviourError.tOe.index]=
activelms.SequencingBehaviourError.tOe;
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(activelms.WoX){throw new Error("namepsace activelms.LimitConditions exists");}
activelms.WoX=function(dIX){
this.vjx="attemptLimit";
this.aIq="attemptAbsoluteDurationLimit";
this.pEC="attemptExperiencedDurationLimit";
this.DQc="activityAbsoluteDurationLimit";
this.tqd="activityExperiencedDurationLimit";
this.TaI="beginTimeLimit";
this.qaF="endTimeLimit";
activelms.DefinitionType.call(this,dIX);
var fKk=undefined;
var uZD=undefined;
var vMH=undefined;
this.sKZ=function(){
if(isUndefined(fKk)){
if(!dIX){
fKk=false;
}
else{
var Kio=dIX.getAttributeNode(this.vjx);
if(Kio){fKk=true;}
else{fKk=false;}
}
}
return fKk;
};
this.ZID=function(){
if(!this.sKZ()){return;}
if(isUndefined(uZD)){
uZD=this.getValue(this.vjx,0);
}
return uZD;
};
this.wso=function(){
if(isUndefined(vMH)){
vMH=
this.getValue(this.aIq,"");
}
return vMH;
}
this.evaluate=function(hEr,FOP,Wbb){
var uZD=this.ZID();
if(!isUndefined(uZD)){
if(hEr.getProgressStatus()&&(hEr.getAttemptCount()>=uZD)){
return true;
}
}







return false;
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="attemptLimit: "+this.ZID()+"\n";
return cZn;
};
};
activelms.WoX.prototype=new activelms.DefinitionType();
delete activelms.WoX.prototype.dIX;
activelms.WoX.prototype.constructor=activelms.WoX;
activelms.WoX.factory=function(sBs){return new activelms.WoX(sBs);};
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(!activelms.NavigationBehaviour){activelms.NavigationBehaviour={};}
else if(typeof activelms.NavigationBehaviour!="object"){throw new Error("namepsace activelms.NavigationBehaviour exists");}
activelms.NavigationBehaviour.terminationRequest=undefined;
activelms.NavigationBehaviour.sequencingRequest=undefined;
activelms.NavigationBehaviour.lastRequestTimestamp=undefined;
activelms.NavigationBehaviour.invoke=
function(hTs,ujl,SnD,kVj){
activelms.NavigationBehaviour.terminationRequest=undefined;
activelms.NavigationBehaviour.sequencingRequest=undefined;
var BGn=hTs.getCurrentActivity();
var Xub=false;
if(BGn){Xub=true;}
var rCF=hTs.getSuspendedActivity();
var rwc=false;
if(rCF){rwc=true;}
switch(ujl){
case activelms.SequencingEngine.NONE:
return;
break;
case activelms.SequencingEngine.START:
if(!Xub){
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.START;
return;
}
else{
throw activelms.SequencingBehaviourError.TvQ;
}
break;
case activelms.SequencingEngine.RESUME_ALL:
if(!Xub){
if(rwc){
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.RESUME_ALL;
return;
}
else{
throw activelms.SequencingBehaviourError.NcO;
}
}
else{
throw activelms.SequencingBehaviourError.TvQ;
}
break;
case activelms.SequencingEngine.CONTINUE:
if(!Xub){
throw activelms.SequencingBehaviourError.Zbd;
}
if(!BGn.isRoot()&&BGn.getParent().Noq().YYI().axs()){
if(BGn.isActive()){
log.debug("NB.2.1.3.2.1.1");
activelms.NavigationBehaviour.terminationRequest=
activelms.SequencingEngine.EXIT;
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.CONTINUE;
return;
}
else{
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.CONTINUE;
return;
}
}
else{
throw activelms.SequencingBehaviourError.iIA;
}
break;
case activelms.SequencingEngine.PREVIOUS:
if(!Xub){
throw activelms.SequencingBehaviourError.Zbd;
}
if(!BGn.isRoot()){
var FhY=BGn.getParent();
var ouu=FhY.Noq().YYI().axs();
var DcA=FhY.Noq().YYI().Opk();
if(ouu&&!DcA){
if(BGn.isActive()){
activelms.NavigationBehaviour.terminationRequest=
activelms.SequencingEngine.EXIT;
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.PREVIOUS;
return;
}
else{
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.PREVIOUS;
return;
}
}
else{
throw activelms.SequencingBehaviourError.FXM;
}
}
else{
throw activelms.SequencingBehaviourError.Ieb;
}
break;
case activelms.SequencingEngine.mUt:
throw activelms.SequencingBehaviourError.YDl;
case activelms.SequencingEngine.XIx:
throw activelms.SequencingBehaviourError.YDl;
case activelms.SequencingEngine.CHOICE:
var eUH=hTs.findByName(SnD);
if(eUH){
if(eUH.isRoot()||eUH.getParent().Noq().YYI().XGi()){
log.debug("NB.2.1.7.1.1");
if(!Xub){
log.debug("NB.2.1.7.1.1.1");
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.CHOICE;
return;
}
log.debug("NB.2.1.7.1.2");
if(!eUH.OmU(BGn)){
var CQx=
hTs.YrQ(BGn,eUH);
var IHk=
hTs.WLw(BGn,CQx);
var ArI=IHk.length;
if(ArI>1){
ArI=ArI-1;
}
if(ArI!=0){
var jja;
for(var SRI=0;SRI<ArI;SRI++){
jja=IHk[SRI];
if(jja.isActive()&&!jja.Noq().YYI().TZp()){
throw activelms.SequencingBehaviourError.Smw;
}
}
}
else{
throw activelms.SequencingBehaviourError.GLU;
}
}


log.debug("NB.2.1.7.1.3");
if(BGn.isActive()&&!BGn.Noq().YYI().TZp()){
throw activelms.SequencingBehaviourError.Smw;
}
log.debug("NB.2.1.7.1.4");
if(BGn.isActive()){
activelms.NavigationBehaviour.terminationRequest=
activelms.SequencingEngine.EXIT;
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.CHOICE;
return;
}
else{
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.CHOICE;
return;
}
}
else{
throw activelms.SequencingBehaviourError.lFJ;
}
}
else{
throw activelms.SequencingBehaviourError.jrf;
}
break;
case activelms.SequencingEngine.EXIT:
if(Xub){
if(BGn.isActive()){
activelms.NavigationBehaviour.terminationRequest=
activelms.SequencingEngine.EXIT;
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.EXIT;
return;
}
else{
throw activelms.SequencingBehaviourError.XJe;
}
}
break;
case activelms.SequencingEngine.ABANDON:
if(Xub){
if(BGn.isActive()){
activelms.NavigationBehaviour.terminationRequest=
activelms.SequencingEngine.ABANDON;
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.EXIT;
return;
}
else{
throw activelms.SequencingBehaviourError.XJe;
}
}
else{
throw activelms.SequencingBehaviourError.Zbd;
}
break;
case activelms.SequencingEngine.EXIT_ALL:
if(Xub){
activelms.NavigationBehaviour.terminationRequest=
activelms.SequencingEngine.EXIT_ALL;
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.EXIT;
return;
}
else{
throw activelms.SequencingBehaviourError.Zbd;
}
break;
case activelms.SequencingEngine.SUSPEND_ALL:
if(Xub){
activelms.NavigationBehaviour.terminationRequest=
activelms.SequencingEngine.SUSPEND_ALL;
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.EXIT;
return;
}
else{
throw activelms.SequencingBehaviourError.Zbd;
}
break;
case activelms.SequencingEngine.ABANDON_ALL:
if(Xub){
activelms.NavigationBehaviour.terminationRequest=
activelms.SequencingEngine.ABANDON_ALL;
activelms.NavigationBehaviour.sequencingRequest=
activelms.SequencingEngine.EXIT;
return;
}
else{
throw activelms.SequencingBehaviourError.Zbd;
}
break;
default:
throw new activelms.ApplicationError("Unrecognised ADL navigation request type: "+ujl);
}
};
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(activelms.LpO){throw new Error("namepsace activelms.RollupBehaviour exists");}
activelms.LpO=function(){
var Epw=new activelms.Epw();
var xYu=new activelms.xYu();
var weG=new activelms.weG();
var JQi=new activelms.JQi();
var icx=new activelms.icx();
var pGj=new activelms.pGj();
this.RBX=xYu.RBX;
this.TnY=xYu.TnY;
this.VxA=xYu.VxA;





this.dvQ=weG.dvQ;
this.qqI=weG.qqI;
this.Bvj=weG.Bvj;
this.oJB=weG.oJB;
this.Yff=weG.Yff;
this.QgD=weG.QgD;
this.hHX=this.Bvj;
this.MpS=icx.MpS;
this.dvQ=weG.dvQ;
this.qqI=weG.qqI;
this.Bvj=weG.Bvj;
this.oJB=weG.oJB;
this.Yff=weG.Yff;
this.QgD=weG.QgD;
activelms.srp.call(this);
this.ikv=function(LpN){
var DKF=0.0;
var FJi=0.0;
var Wbb=undefined;
var cnZ=undefined;
var HTg=false;
var Qtb=this.woZ(LpN);
if(!isUndefined(Qtb)&&Qtb){
var GKg=null;
var Yem=0;
var mJn=LpN.getAvailableChildren();
var DaD=LpN.hasAvailableChildren();
if(DaD){Yem=mJn.length;}
for(var SRI=0;SRI<Yem;SRI++){
GKg=mJn[SRI];
var kIA=GKg.Noq().LVt().SPO();
var FZc=
GKg.Noq().JeZ().QsW();
if(kIA&&FZc){
var DLu=this.woZ(GKg);
if(!isUndefined(DLu)&&DLu){
var YGW=
GKg.Noq().JeZ().uYX();
FJi=this.add(FJi,YGW);
Wbb=DLu.getObjectiveProgressInfo();
if(Wbb.getMeasureStatus()){
cnZ=Wbb.getNormalizedMeasure();
var XWV=this.pgM(cnZ,YGW);
DKF=this.add(DKF,XWV);
HTg=true;
}
}else{
return;
}
}
}
Wbb=Qtb.getObjectiveProgressInfo();
if(HTg===false){
Wbb.Kxe(false);
}
else{
if(this.UxL(FJi)){
cnZ=this.UNG(DKF,FJi);
Wbb.Kxe(true);
Wbb.Qpt(cnZ);
}
else{
Wbb.Kxe(false);
}
}
}
};
this.NOr=function(LpN){
var Qtb=this.woZ(LpN);
if(!isUndefined(Qtb)&&Qtb){
if(Qtb.RKU()){
var Wbb=
Qtb.getObjectiveProgressInfo();
if(!Wbb.getMeasureStatus()){
Wbb.jbE(false);
}
else{
var hoT=LpN.isActive();
var Ukl=LpN.Noq().mJl();
var UjA=Ukl.KRi();
if((hoT===false)||(hoT===true&&UjA===true)){
var cnZ=Wbb.getNormalizedMeasure();
var TuV=Qtb.cnV();
var oeO=this.Bna(cnZ,TuV);
if(oeO){
Wbb.jbE(true);
Wbb.Tkn(true);
}
else{
Wbb.jbE(true);
Wbb.Tkn(false);
}
}
else{
Wbb.jbE(false);
}
}
}
return;
}else{
return;
}
};
this.XOU=function(LpN){
var Qtb=this.woZ(LpN);
if(!isUndefined(Qtb)&&Qtb){
var ERN=this.qtd(LpN,this.oJB);
if(ERN){
var Wbb=
Qtb.getObjectiveProgressInfo();
Wbb.jbE(true);
Wbb.Tkn(false);
}
ERN=this.qtd(LpN,this.Bvj);
if(ERN){
var Wbb=
Qtb.getObjectiveProgressInfo();
Wbb.jbE(true);
Wbb.Tkn(true);
}
}
};
this.BBu=function(LpN){
var FOP=undefined;
var ERN=this.qtd(LpN,this.QgD);
if(ERN){
FOP=LpN.getAttemptProgressInfo();
FOP.jbE(true);
FOP.PRS(false);
}
ERN=this.qtd(LpN,this.Yff);
if(ERN){
FOP=LpN.getAttemptProgressInfo();
FOP.jbE(true);
FOP.PRS(true);
}
};
this.qtd=function(LpN,wdm){
var tvu=LpN.Noq();
var YsU=[];
YsU[0]=wdm;
var ULH=tvu.JeZ().maK(YsU);
if(!isUndefined(ULH)&&ULH&&ULH.length>0){
var wxX=null;
var cqi=ULH.length;
var vXs=[];
var GKg=null;
var Yem=0;
var mJn=LpN.getAvailableChildren();
var DaD=LpN.hasAvailableChildren();
if(DaD){Yem=mJn.length;}
var vHU=
tvu.YYI().wnD();
var Wbb;
var RIY=true;
var cZq=
tvu.YYI().Rto();
var FOP;
var hdg=true;
for(var SRI=0;SRI<cqi;SRI++){
if(DaD){
wxX=ULH[SRI];
vXs=new Array();
for(var olg=0;olg<Yem;olg++){
GKg=mJn[olg];
RIY=true;
hdg=true;
var kIA=GKg.Noq().LVt().SPO();
if(kIA){
var BOA=
this.VnE(GKg,wdm);
if(BOA){
Wbb=GKg.getObjectiveProgressInfo();
if(Wbb.epa()&&vHU){
RIY=false;
}
FOP=GKg.getAttemptProgressInfo();
if(FOP.epa()&&cZq){
hdg=false;
}
var AtF=
this.wKP(GKg,wxX,RIY,hdg,kIA);
switch(AtF){
case xYu.VxA:
vXs.push(xYu.VxA);
break;
case xYu.RBX:
vXs.push(xYu.RBX);
break;
case xYu.TnY:
vXs.push(xYu.TnY);
break;
default:
vXs.push(xYu.VxA);
}
}
}
else{
var cVJ=this.hTs.getScormVersion();
if(cVJ>=2004.31){
var AtF=this.wKP(GKg,wxX,RIY,hdg,kIA);
switch(AtF){
case xYu.VxA:
vXs.push(xYu.VxA);
break;
case xYu.RBX:
vXs.push(xYu.RBX);
break;
case xYu.TnY:
vXs.push(xYu.TnY);
break;
default:
vXs.push(xYu.VxA);
}
}
}
}
}
var ERN=this.JZv(vXs,wxX);
if(ERN){return true;}
}
}
return false;
};
this.JZv=function(vXs,wxX){
var PaW=vXs.length;
if(PaW==0){return false;}
var odv=false;
var aBT=0;
var WHA=wxX.Kgw();
switch(WHA){
case weG.CcC:
var qth=false;
for(var SRI=0;SRI<PaW;SRI++){
var value=vXs[SRI];
if(value==xYu.TnY||value==xYu.VxA){
qth=true;
break;
}
}
if(!qth){
odv=true;
}
break;
case weG.uFA:
var Daj=false;
for(var SRI=0;SRI<PaW;SRI++){
var value=vXs[SRI];
if(value==xYu.RBX){
Daj=true;
break;
}
}
if(Daj){odv=true;}
break;
case weG.bLM:
var aMi=false;
for(var SRI=0;SRI<PaW;SRI++){
var value=vXs[SRI];
if(value==xYu.RBX||value==xYu.VxA){
aMi=true;
break;
}
}
if(!aMi){odv=true;}
break;
case weG.NIb:
for(var SRI=0;SRI<PaW;SRI++){
var value=vXs[SRI];
if(value==xYu.RBX){
aBT++;
}
}
var HIn=wxX.Nqr();
if(aBT>=HIn){
odv=true;
}
break;
case weG.Gkm:
for(var SRI=0;SRI<PaW;SRI++){
var value=vXs[SRI];
if(value==xYu.RBX){
aBT++;
}
}
var TOT=parseFloat(aBT);
var FFv=parseFloat(PaW);
var oiZ=this.UNG(TOT,FFv);
var UkW=wxX.Qcw();
if(this.Bna(oiZ,UkW)){
odv=true;
}
break;
}
return odv;
};
this.woZ=function(LpN){
var Mwd=LpN.Noq().IEV();
return Mwd.Rth();
};
this.wKP=function(LpN,wxX,VQr,xNh,kIA){
var AtF=this.sVX(LpN,wxX,this.UBt,VQr,xNh,kIA,this.hTs.getScormVersion());
return AtF;
};
this.VnE=function(LpN,QqX){
var BOA=false;

var hEr=LpN.getActivityProgressInfo();
var TeK=hEr.getProgressStatus();
var cPk=hEr.getAttemptCount();
var tvu=LpN.Noq();
if(QqX==this.Bvj||QqX==this.oJB)
{
var btf=tvu.JeZ().QsW();
if(btf){
BOA=true;
var abr=
tvu.mJl().wSv();
var Wna=
tvu.mJl().aCb();
if((QqX==this.Bvj&&abr==JQi.wie)||(QqX==this.oJB&&Wna==JQi.wie)){
if(TeK===false||(cPk>0&&LpN.getSuspended())){
BOA=false;
}
}
else{
if((QqX==this.Bvj&&abr==JQi.pmK)||(QqX==this.oJB&&Wna==JQi.pmK)){
if(TeK===false||cPk===0){
BOA=false;
}
}
else{
if((QqX==this.Bvj&&abr==JQi.dNU)||(QqX==this.oJB&&Wna==JQi.dNU)){
var rgh=new activelms.XuO();
rgh.cjg(this.hTs);
var OfH=[this.MpS];
var wdm=rgh.axA(LpN,OfH);
if(!isUndefined(wdm)){
BOA=false;
}
}
}
}
}
}
if(QqX==this.Yff||QqX==this.QgD)
{
log.debug("RB.1.4.2.3");
var iPa=tvu.JeZ().IME();
if(iPa){
log.debug("RB.1.4.2.3.1");
BOA=true;
var wnS=
tvu.mJl().nEJ();
var dFD=
tvu.mJl().OlX();
if((QqX==this.Yff&&wnS==JQi.wie)||(QqX==this.QgD&&dFD==JQi.wie)){
if(TeK===false||(cPk>0&&LpN.getSuspended())){
log.debug("RB.1.4.2.3.1.2.1.1");
BOA=false;
}
}
else{
if((QqX==this.Yff&&wnS==JQi.pmK)||(QqX==this.QgD&&dFD==JQi.pmK)){
if(TeK===false||cPk===0){
log.debug("RB.1.4.2.3.1.3.1.1.1");
BOA=false;
}
}
else{
if((QqX==this.Yff&&wnS==JQi.dNU)||(QqX==this.QgD&&Wna==JQi.dNU)){
log.debug("RB.1.4.2.2.1.3.2.1.1");
var OfH=[this.MpS];
var rgh=new activelms.XuO();
rgh.cjg(this.hTs);
var wdm=rgh.axA(LpN,OfH);
if(!isUndefined(wdm)){
log.debug("RB.1.4.2.3.1.3.2.1.2.1");
BOA=false;
}
}
}
}
}
}
return BOA;
};
this.JMQ=function(LpN){
if(isUndefined(this.hTs)||this.hTs===null){
throw new activelms.ApplicationError("Activity tree not defined for rollup.");
}
var otW=this.hTs.WLw(LpN,this.hTs.getRoot());
var PaW=otW.length;
if(PaW===0){
return;
}
for(var SRI=0;SRI<PaW;SRI++){
var jja=otW[SRI];

if(jja.hasAvailableChildren()){
this.ikv(jja);
}
var cVJ=this.hTs.getScormVersion();
if(cVJ<2004){
var Png=jja.IrM();
if(!isUndefined(Png)){
var Qtb=this.woZ(LpN);
if(!isUndefined(Qtb)&&Qtb){
var Wbb=
Qtb.getObjectiveProgressInfo();
if(!Wbb.getMeasureStatus()){
Wbb.jbE(false);
}
}
}
}
var DLu=jja.Bqt();
if(DLu.RKU()){
this.NOr(jja);
}
else{
this.XOU(jja);
}
this.BBu(jja);
}
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
return cZn;
};
};
activelms.LpO.prototype=new activelms.srp();
activelms.LpO.prototype.constructor=activelms.LpO;
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(!activelms.SequencingBehaviour){activelms.SequencingBehaviour={};}
else if(typeof activelms.SequencingBehaviour!="object"){throw new Error("namepsace activelms.SequencingBehaviour exists");}
activelms.SequencingBehaviour.crC=1;
activelms.SequencingBehaviour.PhO=-1;
activelms.SequencingBehaviour.fRq=undefined;

activelms.SequencingBehaviour.isSequencingFinished=false;
activelms.SequencingBehaviour.deliveryRequest=undefined;
activelms.SrP=function(eEv,TWR,EQd){
this.mPf=function(){return eEv;};
this.xGx=function(){return TWR;};
this.isSequencingFinished=function(){return EQd;};
};
activelms.Fwo=function(eEv,lTK,EQd){
this.mPf=function(){return eEv;};
this.XpC=function(){return lTK;};
this.isSequencingFinished=function(){return EQd;};
};
activelms.SequencingBehaviour.invoke=
function(hTs,ujl,SnD,kVj){
activelms.SequencingBehaviour.isSequencingFinished=false;
activelms.SequencingBehaviour.deliveryRequest=undefined;
switch(ujl){
case activelms.SequencingEngine.START:
activelms.SequencingBehaviour.deliveryRequest=
activelms.SequencingBehaviour.Jeg(hTs,kVj);
return;
case activelms.SequencingEngine.RESUME_ALL:
activelms.SequencingBehaviour.deliveryRequest=
activelms.SequencingBehaviour.irw(hTs,kVj);
return;
case activelms.SequencingEngine.EXIT:
activelms.SequencingBehaviour.isSequencingFinished=
activelms.SequencingBehaviour.HmD(hTs,kVj);
return;
case activelms.SequencingEngine.qPH:
activelms.SequencingBehaviour.deliveryRequest=
activelms.SequencingBehaviour.mYB(hTs,kVj);
return;
case activelms.SequencingEngine.CONTINUE:
activelms.SequencingBehaviour.deliveryRequest=
activelms.SequencingBehaviour.gQX(hTs,kVj);
return;
case activelms.SequencingEngine.PREVIOUS:
activelms.SequencingBehaviour.deliveryRequest=
activelms.SequencingBehaviour.DlI(hTs,kVj);
return;
case activelms.SequencingEngine.CHOICE:
var kTK=hTs.findByName(SnD);
activelms.SequencingBehaviour.deliveryRequest=
activelms.SequencingBehaviour.Dng(hTs,kTK,kVj);
return;
case activelms.SequencingEngine.aKc:
var kTK=hTs.findByName(SnD);
activelms.SequencingBehaviour.deliveryRequest=
activelms.SequencingBehaviour.OGW(hTs,kTK,kVj);
return;
default:
throw activelms.SequencingBehaviourError.RRp;
}
};
activelms.SequencingBehaviour.vSx=function(hTs,LpN,Juk,aBK,DmQ){
activelms.SequencingBehaviour.fRq=false;
if((!isUndefined(DmQ)&&DmQ==activelms.SequencingBehaviour.PhO)&&LpN.hoP()){
log.debug("SB.2.1.2");
Juk=activelms.SequencingBehaviour.PhO;
LpN=LpN.getParent().tnx();
activelms.SequencingBehaviour.fRq=true;
}
if(Juk==activelms.SequencingBehaviour.crC){
log.debug("SB.2.1.3");
var JBk=hTs.getAvailableActivityList();
var DSu=JBk[JBk.length-1];
if(LpN.TRT(DSu)||(LpN.isRoot()&&aBK===false)){
log.debug("SB.2.1.3.1");
var rgh=new activelms.XuO();
rgh.cjg(hTs);
rgh.wIN(hTs.getRoot());
rgh.VsJ(hTs.getRoot());
log.debug("SB.2.1.3.1.2");
var EQd=true;
return new activelms.SrP(undefined,Juk,EQd);
}
else if(LpN.isLeaf()||aBK===false){
log.debug("SB.2.1.3.2");
if(LpN.hoP()){
log.debug("SB.2.1.3.2.1.2");
return activelms.SequencingBehaviour.vSx(hTs,LpN.getParent(),activelms.SequencingBehaviour.crC,false,undefined);
}
else{
var mJn=LpN.getParent().getAvailableChildren();
var PaW=mJn.length;
var FEA;
var LxY;
for(var SRI=0;SRI<PaW;SRI++){
FEA=mJn[SRI];
if(FEA.TRT(LpN)){
LxY=mJn[SRI+1];
break;
}
}
log.debug("SB.2.1.3.2.2.2");
return new activelms.SrP(LxY,Juk,false);
}
}
else{
log.debug("SB.2.1.3.3");
var mJn=LpN.getAvailableChildren();
if(!isUndefined(mJn)&&mJn.length!==0){
log.debug("SB.2.1.3.3.1");
return new activelms.SrP(mJn[0],Juk,false);
}
else{
log.debug("SB.2.1.3.3.2");
throw activelms.SequencingBehaviourError.sWt;
}
}
}

else if(Juk==activelms.SequencingBehaviour.PhO){
log.debug("SB.2.1.4");
if(LpN.isRoot()){
throw activelms.SequencingBehaviourError.vkD;
}
if(LpN.isLeaf()||aBK===false){
log.debug("SB.2.1.4.2");
if(!activelms.SequencingBehaviour.fRq){
var DcA=LpN.getParent().Noq().YYI().Opk();
if(DcA){
throw activelms.SequencingBehaviourError.WZA;
}
}
if(LpN.JTH()){
log.debug("SB.2.1.4.2.2.2");
return activelms.SequencingBehaviour.vSx(hTs,LpN.getParent(),activelms.SequencingBehaviour.PhO,false,undefined);
}
else{
log.debug("SB.2.1.4.2.3.1");
var mJn=LpN.getParent().getAvailableChildren();
var SRI=mJn.length-1;
var FEA;
var xXq;
do{
FEA=mJn[SRI];
if(FEA.TRT(LpN)){
xXq=mJn[SRI-1];
break;
}--SRI;
}
while(SRI>=0);
log.debug("SB.2.1.4.3.2");
return new activelms.SrP(xXq,Juk,false);
}
}
else{
if(LpN.hasAvailableChildren()){
var mJn=LpN.getAvailableChildren();
var DcA=LpN.Noq().YYI().Opk();
if(DcA){
log.debug("SB.2.1.4.3.1.1.1");
return new activelms.SrP(mJn[0],activelms.SequencingBehaviour.crC,false);
}
else{
log.debug("SB.2.1.4.3.1.2.1");
return new activelms.SrP(mJn[mJn.length-1],activelms.SequencingBehaviour.PhO,false);
}
}
else{
}
}
}
};
activelms.SequencingBehaviour.DXP=function(hTs,LpN,Juk,DmQ){
var icx=new activelms.icx();
var tvu=LpN.getParent().Noq();
var ouu=tvu.YYI().axs();
if(!ouu){
throw activelms.SequencingBehaviourError.xrT;
}
var rgh=new activelms.XuO();
rgh.cjg(hTs);
log.debug("SB.2.2.2");
var wdm=rgh.axA(LpN,icx.jVA);
if(!isUndefined(wdm)){
log.debug("SB.2.2.3.1");
var wpb=
activelms.SequencingBehaviour.vSx(hTs,LpN,Juk,false,DmQ);
var eEv=wpb.mPf();
var TWR=wpb.xGx();
var EQd=wpb.isSequencingFinished();
if(isUndefined(eEv)){
log.debug("SB.2.2.3.2.1");
return new activelms.Fwo(LpN,false,EQd);
}
else{
if(DmQ==activelms.SequencingBehaviour.PhO&&TWR==activelms.SequencingBehaviour.PhO){
log.debug("SB.2.2.3.1.1");
return activelms.SequencingBehaviour.DXP(hTs,eEv,TWR,undefined);
}
else{
log.debug("SB.2.2.3.2.1");
return activelms.SequencingBehaviour.DXP(hTs,eEv,Juk,DmQ);
}
}
}
log.debug("SB.2.2.4");
var gkD=rgh.Ihh(LpN);
if(gkD){
throw activelms.SequencingBehaviourError.gPB;
}
if(!LpN.isLeaf()){
log.debug("SB.2.2.6.1");
var wpb=
activelms.SequencingBehaviour.vSx(hTs,LpN,Juk,true,undefined);
var eEv=wpb.mPf();
var TWR=wpb.xGx();
var EQd=wpb.isSequencingFinished();
if(isUndefined(eEv)){
log.debug("SB.2.2.6.2.1");
return new activelms.Fwo(LpN,false,EQd);
}
else{
if(Juk==activelms.SequencingBehaviour.PhO&&TWR==activelms.SequencingBehaviour.crC){
log.debug("SB.2.2.6.3.1.1");
return activelms.SequencingBehaviour.DXP(hTs,eEv,activelms.SequencingBehaviour.crC,activelms.SequencingBehaviour.PhO);
}
else{
log.debug("SB.2.2.6.3.2.1");
return activelms.SequencingBehaviour.DXP(hTs,eEv,Juk,undefined);
}
}
}

log.debug("SB.2.2.7");
return new activelms.Fwo(LpN,true,false);
};
activelms.SequencingBehaviour.GDQ=function(hTs,LpN,Juk,aBK){
var DmQ=undefined;
var wpb=
activelms.SequencingBehaviour.vSx(hTs,LpN,Juk,aBK,DmQ);
var eEv=wpb.mPf();
var TWR=wpb.xGx();
var EQd=wpb.isSequencingFinished();
if(isUndefined(eEv)){
return new activelms.Fwo(LpN,false,EQd);
}
var nFt=
activelms.SequencingBehaviour.DXP(hTs,eEv,Juk,DmQ);
log.debug("SB.2.3.4.3");
return nFt;
};
activelms.SequencingBehaviour.MIq=function(hTs,LpN,Juk){
var icx=new activelms.icx();
if(Juk==activelms.SequencingBehaviour.crC){
var rgh=new activelms.XuO();
rgh.cjg(hTs);
log.debug("SB.2.4.1.1");
var wdm=rgh.axA(LpN,icx.qPn);
if(!isUndefined(wdm)){
log.debug("SB.2.4.1.2.1");
throw activelms.SequencingBehaviourError.Dvq;
}
return true;
}
if(Juk==activelms.SequencingBehaviour.PhO){
if(!LpN.isRoot()){
log.debug("SB.2.4.2.1");
var DcA=LpN.getParent().Noq().YYI().Opk();
log.debug("SB.2.4.2.1.1");
if(DcA){
throw activelms.SequencingBehaviourError.Qiw;
}
}
else{
throw activelms.SequencingBehaviourError.qhG;
}
return true;
}
};
activelms.SequencingBehaviour.Jeg=
function(hTs,kVj){
var BGn=hTs.getCurrentActivity();
if(!isUndefined(BGn)){
throw activelms.SequencingBehaviourError.wFm;
}
var aJP=hTs.getRoot();
if(aJP.isLeaf()){return;}
var aBK=true;
var nFt=activelms.SequencingBehaviour.GDQ(hTs,aJP,activelms.SequencingBehaviour.crC,aBK);
var eEv=nFt.mPf();
var lTK=nFt.XpC();
var EQd=nFt.isSequencingFinished();
return eEv;
};
activelms.SequencingBehaviour.irw=
function(hTs,kVj){
var BGn=hTs.getCurrentActivity();
if(!isUndefined(BGn)){
log.debug("SB.2.6.1.1");
throw activelms.SequencingBehaviourError.FWe;
}
var IUA=hTs.getSuspendedActivity();
if(isUndefined(IUA)){
log.debug("SB.2.6.2.1");
throw activelms.SequencingBehaviourError.qGI;
}

IUA.Lst(false);
hTs.xXj(undefined);
return IUA;
};
activelms.SequencingBehaviour.gQX=
function(hTs,kVj){
var BGn=hTs.getCurrentActivity();
if(isUndefined(BGn)){
throw activelms.SequencingBehaviourError.cDL;
}
if(!BGn.isRoot()){
var tvu=BGn.getParent().Noq();
var ouu=tvu.YYI().axs();
if(!ouu){
throw activelms.SequencingBehaviourError.tmc;
}
}
log.debug("SB.2.7.3");
var nFt=activelms.SequencingBehaviour.GDQ(hTs,BGn,activelms.SequencingBehaviour.crC,false);
var eEv=nFt.mPf();
var lTK=nFt.XpC();
var EQd=nFt.isSequencingFinished();
log.debug("SB.2.7.4");
if(!lTK||isUndefined(eEv)){
activelms.SequencingBehaviour.isSequencingFinished=
EQd;
log.debug("SB.2.7.4.1");
return;
}
else{
log.debug("SB.2.7.5.1");
return eEv;
}
};
activelms.SequencingBehaviour.DlI=
function(hTs,kVj){
var BGn=hTs.getCurrentActivity();
if(isUndefined(BGn)){
throw activelms.SequencingBehaviourError.RTA;
}
if(!BGn.isRoot()){
var tvu=BGn.getParent().Noq();
var ouu=tvu.YYI().axs();
if(!ouu){
throw activelms.SequencingBehaviourError.jCx;
}
}
log.debug("SB.2.8.3");
var nFt=activelms.SequencingBehaviour.GDQ(hTs,BGn,activelms.SequencingBehaviour.PhO,false);
var eEv=nFt.mPf();
var lTK=nFt.XpC();
var EQd=nFt.isSequencingFinished();
if(!lTK||isUndefined(eEv)){
activelms.SequencingBehaviour.isSequencingFinished=
EQd;
log.debug("SB.2.8.4.1");
return;
}
else{
log.debug("SB.2.8.5.1");
return eEv;
}
};
activelms.SequencingBehaviour.OGO=
function(hTs,kTK){
var icx=new activelms.icx();
var rgh=new activelms.XuO();
rgh.cjg(hTs);
var XNk=
hTs.getDescendingActivityPath(hTs.getRoot(),kTK);
var PaW=XNk.length;
var jja;
var wdm;
log.debug("SB.2.9.2");
for(var SRI=0;SRI<PaW;SRI++){
jja=XNk[SRI];
if(!jja.isRoot()){
if(!jja.dXY()){
throw activelms.SequencingBehaviourError.Rge;
}
}

log.debug("SB.2.9.3.2");
wdm=rgh.axA(jja,icx.qQP);
if(wdm){
log.debug("SB.2.4.1.2.1");
throw activelms.SequencingBehaviourError.kBk;
}
}
};
activelms.SequencingBehaviour.Dng=
function(hTs,kTK,kVj){
if(isUndefined(kTK)||kTK===null){
throw activelms.SequencingBehaviourError.leb;
}
activelms.SequencingBehaviour.OGO(hTs,kTK);

if(!kTK.isRoot()){
var tvu=kTK.getParent().Noq();
var Jek=tvu.YYI().XGi();
if(!Jek){
throw activelms.SequencingBehaviourError.dEG;
}
}
var WYp;
var BGn=hTs.getCurrentActivity();
if(!isUndefined(BGn)){
WYp=hTs.YrQ(BGn,kTK);
}
else{
WYp=hTs.getRoot();
}
var csk=0;
if(kTK.TRT(BGn)){csk=1;}
else if(kTK.OmU(BGn)){csk=2;}
else if(WYp.TRT(BGn)||isUndefined(BGn)){csk=3;}
else if(WYp.TRT(kTK)){csk=4;}
else if(kTK.Xao(WYp)){csk=5;}
switch(csk){
case 1:
activelms.SequencingBehaviour.dCd();
break;
case 2:
activelms.SequencingBehaviour.Pxi(hTs,BGn,kTK)
break;
case 3:
activelms.SequencingBehaviour.RoB(hTs,WYp,kTK);
break;
case 4:
activelms.SequencingBehaviour.BGM(hTs,WYp,BGn);
break;
case 5:
activelms.SequencingBehaviour.Jsj(hTs,WYp,BGn,kTK);
break;
default:
throw new activelms.ApplicationError("Undefined choice type request process");
}
if(kTK.isLeaf()){
return kTK;
}
log.debug("SB.2.9.13");
var nFt=activelms.SequencingBehaviour.GDQ(hTs,kTK,activelms.SequencingBehaviour.crC,true);
var eEv=nFt.mPf();
var lTK=nFt.XpC();
if(!lTK){
rgh.wIN(WYp);
rgh.VsJ(WYp);
hTs.setCurrentActivity(eEv);
throw activelms.SequencingBehaviourError.CEH;
}
else{
log.debug("SB.2.9.15");
return eEv;
}
};
activelms.SequencingBehaviour.dCd=function(){
return;
};
activelms.SequencingBehaviour.Pxi=function(hTs,BGn,kTK){
var Ysd=BGn.getParent().getAvailableChildren();
var PaW=Ysd.length;
var esd;
var NJk;
var Juk;
var IHk=[];
for(var SRI=0;SRI<PaW;SRI++){
if(Ysd[SRI].TRT(BGn)){
esd=SRI;
}
else if(Ysd[SRI].TRT(kTK)){
NJk=SRI;
}
}
if(NJk>esd){
IHk=Ysd.slice(esd,NJk);
Juk=activelms.SequencingBehaviour.crC;
}
else{
IHk=Ysd.slice(NJk+1,esd+1);
Juk=activelms.SequencingBehaviour.PhO;
}
PaW=IHk.length;
if(PaW===0){
throw activelms.SequencingBehaviourError.VNW;
}
var mQP=false;
for(var SRI=0;SRI<PaW;SRI++){
mQP=activelms.SequencingBehaviour.MIq(hTs,IHk[SRI],Juk);
}
};
activelms.SequencingBehaviour.RoB=function(hTs,WYp,kTK){
var IHk=hTs.getDescendingActivityPath(WYp,kTK);
if(WYp.isRoot()&&kTK.isRoot()){
}
else{
IHk.pop();
}
var PaW=IHk.length;
if(PaW===0){
throw activelms.SequencingBehaviourError.VNW;
}
var mQP=false;
for(var SRI=0;SRI<PaW;SRI++){
mQP=activelms.SequencingBehaviour.MIq(hTs,IHk[SRI],activelms.SequencingBehaviour.crC);
if(!IHk[SRI].isActive()&&(!IHk[SRI].TRT(WYp)&&IHk[SRI].Noq().sRm().FnQ())){
throw activelms.SequencingBehaviourError.OkD;
}
}
};
activelms.SequencingBehaviour.BGM=function(hTs,WYp,BGn){
var IHk=hTs.WLw(BGn,WYp);
if(IHk.length===0){
throw activelms.SequencingBehaviourError.VNW;
}
var PaW=IHk.length;
var qRd=PaW-1;
for(var SRI=0;SRI<PaW;SRI++){
if(SRI!=qRd){
if(!IHk[SRI].Noq().YYI().TZp()){
throw activelms.SequencingBehaviourError.dfa;
}
}
}
};
activelms.SequencingBehaviour.Jsj=function(hTs,WYp,BGn,kTK){
var IHk=hTs.WLw(BGn,WYp);
IHk.pop();
var PaW=IHk.length;
if(PaW===0){
throw activelms.SequencingBehaviourError.VNW;
}
var PbM;
for(var SRI=0;SRI<PaW;SRI++){
if(!IHk[SRI].Noq().YYI().TZp()){
throw activelms.SequencingBehaviourError.dfa;
}
if(isUndefined(PbM)){
if(IHk[SRI].isCurrent()){
continue;
}
if(IHk[SRI].Noq().sRm().fVo()){
log.debug("SB.2.9.11.4.2.1");
PbM=IHk[SRI];
break;
}
}
}
var wms=false;
if(!isUndefined(PbM)){
var Juk=undefined;
wms=hTs.kZX(kTK,PbM);
if(wms){
Juk=activelms.SequencingBehaviour.crC;
}
else{
Juk=activelms.SequencingBehaviour.PhO;
}
var wGW=
activelms.SequencingBehaviour.eOB(hTs,PbM,Juk);
var CLx=kTK.Xao(wGW);
var sKf=kTK.TRT(wGW);
var Don=kTK.TRT(PbM);
if(!CLx&&!sKf&&!Don){
throw activelms.SequencingBehaviourError.BPQ;
}
}
IHk=hTs.getDescendingActivityPath(WYp,kTK);
IHk.pop();
PaW=IHk.length;
if(PaW===0){
throw activelms.SequencingBehaviourError.VNW;
}
wms=hTs.kZX(kTK,BGn);
if(wms){
var mQP=false;
for(var SRI=0;SRI<PaW;SRI++){
mQP=activelms.SequencingBehaviour.MIq(hTs,IHk[SRI],activelms.SequencingBehaviour.crC);
if(!IHk[SRI].isActive()&&(!IHk[SRI].TRT(WYp)&&IHk[SRI].Noq().sRm().FnQ())){
throw activelms.SequencingBehaviourError.OkD;
}
}
}
};
activelms.SequencingBehaviour.eOB=function(hTs,LpN,Juk){
var GAC=activelms.SequencingBehaviour.fTs(hTs,LpN,Juk);
if(isUndefined(GAC)){
return LpN;
}
return GAC;
};
activelms.SequencingBehaviour.fTs=function(hTs,LpN,Juk){
if(Juk==activelms.SequencingBehaviour.crC)
{
if(hTs.QDl().TRT(LpN)||hTs.getRoot().TRT(LpN)){
log.debug("SB.2.9.2.1.1");
return undefined;
}
if(LpN.hoP()){
log.debug("SB.2.9.2.1.2");
return activelms.SequencingBehaviour.fTs(LpN.getParent(),activelms.SequencingBehaviour.crC);
}
else{
var mJn=LpN.getParent().getAvailableChildren();
var PaW=mJn.length;
var gSu=undefined;
for(var SRI=0;SRI<PaW;SRI++){
if(mJn[SRI].TRT(LpN)){
gSu=SRI+1;
break;
}
}
log.debug("SB.2.9.2.1.3");
return mJn[gSu];
}
}
else if(Juk==activelms.SequencingBehaviour.PhO)
{
if(hTs.getRoot().TRT(LpN)){
log.debug("SB.2.9.2.2.1");
return undefined;
}
if(LpN.JTH()){
log.debug("SB.2.9.2.2.2");
return activelms.SequencingBehaviour.fTs(LpN.getParent(),activelms.SequencingBehaviour.PhO);
}
else{
var mJn=LpN.getParent().getAvailableChildren();
var PaW=mJn.length;
var gSu=undefined;
for(var SRI=0;SRI<PaW;SRI++){
if(mJn[SRI].TRT(LpN)){
gSu=SRI-1;
break;
}
}
log.debug("SB.2.9.2.2.3");
return mJn[gSu];
}
}
};
activelms.SequencingBehaviour.mYB=function(hTs,kVj){
var BGn=hTs.getCurrentActivity();
if(isUndefined(BGn)){
throw activelms.SequencingBehaviourError.xiD;
}
if(BGn.isActive()||BGn.arb()){
throw activelms.SequencingBehaviourError.FaK;
}
if(!BGn.isLeaf()){
log.debug("SB.2.10.3.1");
var nFt=activelms.SequencingBehaviour.GDQ(hTs,BGn,activelms.SequencingBehaviour.crC,true);
var eEv=nFt.mPf();
var lTK=nFt.XpC();
if(!lTK){
log.debug("SB.2.10.3.2");
throw activelms.SequencingBehaviourError.lxB;
}
else{
log.debug("SB.2.10.3.3");
return eEv;
}
}
else{
log.debug("SB.2.10.4");
return BGn;
}
};
activelms.SequencingBehaviour.HmD=
function(hTs,kVj){
var BGn=hTs.getCurrentActivity();
if(isUndefined(BGn)){
log.debug("SB.2.11.1");
return true;
}
if(BGn.isActive()){
log.debug("SB.2.11.2");
throw activelms.SequencingBehaviourError.cRK;
}
if(BGn.isRoot()){
log.debug("SB.2.11.3");
return true;
}
log.debug("SB.2.11.4");
return false;
};
activelms.SequencingBehaviour.OGW=
function(hTs,kTK,kVj){
var BGn=hTs.getCurrentActivity();
if(isUndefined(BGn)){
log.debug("SB.2.13.1");
throw activelms.SequencingBehaviourError.tOe;
}
if(isUndefined(kTK)||kTK===null){
throw activelms.SequencingBehaviourError.leb;
}
return kTK;
};
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(activelms.RunTimeDataModel){throw new Error("namespace activelms.RunTimeDataModel exists");}
if(activelms.Activity){throw new Error("namespace activelms.Activity exists");}
if(activelms.nco){throw new Error("namespace activelms.Presentation exists");}
if(activelms.jHo){throw new Error("namespace activelms.NavigationInterface exists");}
if(activelms.ActivityTree){throw new Error("namespace activelms.ActivityTree exists");}
if(activelms.Resource){throw new Error("namespace activelms.Resource exists");}
if(activelms.Organizations){throw new Error("namespace activelms.Organizations exists");}
if(activelms.pQT){throw new Error("namespace activelms.GlobalSequencing exists");}
if(activelms.GlobalObjectives){throw new Error("namespace activelms.GlobalObjectives exists");}
activelms.nco=function(dIX){
activelms.DefinitionType.call(this,dIX);
this.MdR="navigationInterface";
var Jxo=undefined;
this.mKG=function(){
if(!Jxo){
var sBs=this.cgt(this.MdR);
Jxo=new activelms.jHo(sBs);
}
return Jxo;
};
};
activelms.nco.prototype=new activelms.DefinitionType();
delete activelms.nco.prototype.dIX;
activelms.nco.prototype.constructor=activelms.nco;
activelms.jHo=function(dIX){
activelms.DefinitionType.call(this,dIX);
this.Ypo="hideLMSUI";
var BhG=undefined;
this.Kec=function(){
if(!BhG){
BhG=[];
var WrJ=this.eoW(this.Ypo);
if(WrJ){
var PaW=WrJ.length;
for(var SRI=0;SRI<PaW;SRI++){
FXs=this.getElementText(WrJ[SRI]);
BhG[FXs]=true;
}
}
}
return BhG;
};
};
activelms.jHo.prototype=new activelms.DefinitionType();
delete activelms.jHo.prototype.dIX;
activelms.jHo.prototype.constructor=activelms.jHo;
activelms.RunTimeDataModel=function(dIX,vkC){
activelms.DefinitionType.call(this,dIX);
this.BgH=function(){
var WbY=
this.getElementText(this.cgt("exit"));
return WbY;
};
this.nxd=function(LpN){
var TUd=
this.getElementText(this.cgt("successStatus"));

var CHC=
new com.activelms.SuccessStatusSupport(LpN.getScaledPassingScore(),this.RxE(),TUd);
return CHC.evaluate();
};
this.dmv=function(LpN){
var xgd=
this.getElementText(this.cgt("completionStatus"));
if(xgd=="not_attempted"){
xgd="not attempted";
}

var vfg=
new com.activelms.CompletionStatusSupport(LpN.getCompletionThreshold(),this.TjL(),xgd);
return vfg.evaluate();
};
this.RxE=function(){
var bQb=this.cgt("score");
if(!isUndefined(bQb)){
var CrS=new activelms.DefinitionType(bQb);
var rMu=undefined;
if(vkC<2004){

var bwJ=CrS.getElementText(CrS.cgt("raw"));
var dYa=parseFloat(bwJ);
if(isNaN(dYa)){
rMu=undefined;
}
else{
var fGZ=CrS.getElementText(CrS.cgt("min"));
var YtW=parseFloat(fGZ);
if(isNaN(YtW)||YtW<0){
YtW=0;
}
var Kum=CrS.getElementText(CrS.cgt("max"));
var oIM=parseFloat(Kum);
if(isNaN(oIM)||oIM>100){
oIM=100;
}
rMu=dYa/(oIM-YtW);
}
}
else{
var otF=CrS.getElementText(CrS.cgt("scaled"));
rMu=parseFloat(otF);
}
if(isNaN(rMu)){
return undefined;
}
return rMu;
}
return undefined;
};
this.TjL=function(){
return this.getElementText(this.cgt("progressMeasure"));
}
this.aYJ=function(){
var Vtu=this.cgt("objectives");
if(!isUndefined(Vtu)&&Vtu.hasChildNodes&&Vtu.hasChildNodes()){
return Vtu.childNodes.length;
}
return 0;
};
this.getObjectiveID=function(PLR){
var Vtu=this.cgt("objectives");
if(!isUndefined(Vtu)&&Vtu.hasChildNodes&&Vtu.hasChildNodes()){
var TSC=new activelms.DefinitionType(Vtu.childNodes[PLR]);
return TSC.getElementText(TSC.cgt("identifier"));
}
};
this.bDV=function(PLR){
var Vtu=this.cgt("objectives");
var TSC=new activelms.DefinitionType(Vtu.childNodes[PLR]);
return TSC.getElementText(TSC.cgt("successStatus"));
}
this.lBk=function(PLR){
var Vtu=this.cgt("objectives");
var TSC=new activelms.DefinitionType(Vtu.childNodes[PLR]);
var bQb=TSC.cgt("score");
if(!isUndefined(bQb)&&bQb!=null){
var CrS=new activelms.DefinitionType(bQb);
var PxB=CrS.cgt("scaled");
if(!isUndefined(PxB)&&PxB!=null){
var otF=CrS.getElementText(PxB);
var rMu=parseFloat(otF);
if(isNaN(rMu)){
return undefined;
}
return rMu;
}
}
return undefined;
};
this.GQH=function(LpN,hTs){
log.debug("activelms.RunTimeDataModel.updateActivityState with Activity ID="+LpN.getIdentifier());
var PaW=this.aYJ();
var fMQ=undefined;
var TUd=undefined;
var xgd=undefined;
var bRj=undefined;
var vPF=undefined;
var JiU=LpN.Noq().IEV().Bqt();
var SPP=JiU.getObjectiveID();
var eRC="unknown";
var xfp=undefined;
for(var PLR=0;PLR<PaW;PLR++){
fMQ=this.getObjectiveID(PLR);
TUd=this.bDV(PLR);
bRj=
LpN.Noq().IEV().KsE(fMQ);
if(!isUndefined(bRj)){
switch(TUd){
case "unknown":
bRj.getObjectiveProgressInfo().jbE(false);
bRj.getObjectiveProgressInfo().Tkn(false);
break;
case "failed":
bRj.getObjectiveProgressInfo().jbE(true);
bRj.getObjectiveProgressInfo().Tkn(false);
break;
case "passed":
bRj.getObjectiveProgressInfo().jbE(true);
bRj.getObjectiveProgressInfo().Tkn(true);
break;
}
log.debug("#1 cmi.objectives."+PLR+".success_status="+TUd);
if(fMQ==SPP){
eRC=TUd;
}
}
}
for(var PLR=0;PLR<PaW;PLR++){
fMQ=this.getObjectiveID(PLR);
vPF=this.lBk(PLR);
bRj=
LpN.Noq().IEV().KsE(fMQ);
if(!isUndefined(bRj)){
if(isUndefined(vPF)){
bRj.getObjectiveProgressInfo().Kxe(false);
bRj.getObjectiveProgressInfo().Qpt(0.0);
}
else{
if(vPF>=-1.0&&vPF<=1.0){
bRj.getObjectiveProgressInfo().Kxe(true);
bRj.getObjectiveProgressInfo().Qpt(vPF);
}
}
log.debug("#2 cmi.objectives."+PLR+".score.scaled="+vPF);
if(fMQ==SPP){
xfp=vPF;
}
}
}
TUd=this.nxd(LpN);
if(TUd=="unknown"){
TUd=eRC;
}
switch(TUd){
case "unknown":
LpN.getObjectiveProgressInfo().jbE(false);
LpN.getObjectiveProgressInfo().Tkn(false);
break;
case "failed":
LpN.getObjectiveProgressInfo().jbE(true);
LpN.getObjectiveProgressInfo().Tkn(false);
break;
case "passed":
LpN.getObjectiveProgressInfo().jbE(true);
LpN.getObjectiveProgressInfo().Tkn(true);
break;
}
log.debug("#3 cmi.success_status="+TUd);
vPF=this.RxE();
if(isUndefined(vPF)){
vPF=xfp
}
if(isUndefined(vPF)){
LpN.getObjectiveProgressInfo().Kxe(false);
LpN.getObjectiveProgressInfo().Qpt(0.0);
}
else{
if(vPF>=-1.0&&vPF<=1.0){
LpN.getObjectiveProgressInfo().Kxe(true);
LpN.getObjectiveProgressInfo().Qpt(vPF);
}
}
log.debug("#4 cmi.score.scaled="+vPF);
xgd=this.dmv(LpN);
switch(xgd){
case "unknown":
LpN.getAttemptProgressInfo().jbE(false);
LpN.getAttemptProgressInfo().PRS(false);
break;
case "incomplete":
LpN.getAttemptProgressInfo().jbE(true);
LpN.getAttemptProgressInfo().PRS(false);
break;
case "completed":
LpN.getAttemptProgressInfo().jbE(true);
LpN.getAttemptProgressInfo().PRS(true);
break;
case "not attempted":
LpN.getAttemptProgressInfo().jbE(true);
LpN.getAttemptProgressInfo().PRS(false);
break;
}
log.debug("#5 cmi.completion_status="+xgd);
var WbY=this.BgH();
if(WbY=="suspend"){
LpN.VYR(true);
hTs.xXj(LpN);
}
log.debug("#6 cmi.exit="+WbY);
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="Name: activelms.RunTimeDataModel"+"\n";
return cZn;
};
};
activelms.RunTimeDataModel.prototype=new activelms.DefinitionType();
delete activelms.RunTimeDataModel.prototype.dIX;
activelms.RunTimeDataModel.prototype.constructor=activelms.RunTimeDataModel;
activelms.BRH=function(dIX){
activelms.DefinitionType.call(this,dIX);
this.identifier;
this.title;
this.hSc=true;


var asm;
this.getIdentifier=function(){
if(!this.identifier){
this.identifier=this.getValue("identifier",undefined);
if(typeof(this.identifier)!="string"){
this.identifier=String(this.identifier);
}
}
return this.identifier;
};
this.getObjectivesGlobalToSystem=function(){
if(isUndefined(asm)){
asm=this.getValue("objectivesGlobalToSystem",this.hSc);
}
return asm;
};
this.getTitle=function(){
if(!this.title){
var vIs=this.cgt("title");
this.title=this.getElementText(vIs);
if(isUndefined(this.title)||this.title==null){
this.title=new String("");
}
this.title=edm(this.title);
}
return this.title;
};
var iSR=function(mWO){
var mTN=undefined;
try{
mTN=escape(encodeURIComponent(mWO));
}
catch(IZH){
try{
mTN=escape(mWO);
}
catch(XPd){
mTN=mWO;
}
}
return mTN;
}
var edm=function(mWO){
var BrJ=mWO;
try{
BrJ=decodeURIComponent(unescape(mWO));
}
catch(IZH){
try{
BrJ=unescape(mWO);
}
catch(XPd){
BrJ=mWO;
}
}
return BrJ;
}
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="title: "+this.getTitle()+"\n";
cZn+="identifier: "+this.getIdentifier()+"\n";
return cZn;
};
}
activelms.BRH.prototype=new activelms.DefinitionType();
delete activelms.BRH.prototype.dIX;
activelms.BRH.prototype.constructor=activelms.BRH;
activelms.Activity=function(dIX,vNc,lDl,jDF,vbF){
var ijl=undefined;
var hEr=undefined;
var FOP=undefined;
var foa=undefined;
var QeS=undefined;
var KWr=undefined;
var ZCX=undefined;
var Tfo=undefined;
var tvu=undefined;
var BhG=undefined;
var oqt=undefined;
var ZAx=undefined;
var pCY=undefined;
var hoT;
var Xub;
var rwc;
var Erw;
var MgS;
activelms.BRH.call(this,dIX);
this.tDM=undefined;
this.Cvn=[];
this.getDepth=function(){
return lDl;
};
this.Jrf=function(){
return vbF;
}

this.setRunTimeDataModel=function(MZt){
this.tDM=MZt;
};
this.CTx=function(hTs){
if(!isUndefined(this.tDM)){
this.tDM.GQH(this,hTs);
this.tDM=undefined;
}
};
this.Zdb=function(){
var tvu=this.Noq();
var wxm=tvu.cgt("sequencingRules");
if(wxm){
return true;
}
return false;
}
this.Fgl=function(QZl){
if(typeof(QZl)=="boolean"){
this.tht(dIX,"updated",QZl);
}
};
this.WLw=function(){
var Dqs=
jDF.WLw(this,jDF.getRoot());
return Dqs;
};
this.ogQ=function(){
var JBk=this.WLw();
var SRI=JBk.length-1;
do{
JBk[SRI].Fgl(true);--SRI;
}
while(SRI>=0)
}
this.isCurrent=function(){
if(isUndefined(Xub)){
Xub=this.getValue("current",false);
}
return Xub;
};
this.Bmv=function(QZl){
if(typeof(QZl)=="boolean"){
this.tht(dIX,"current",QZl);
this.ogQ();
Xub=QZl;
}
};
this.GTs=function(){
if(isUndefined(Erw)){
Erw=this.getValue("resumable",false);
}
return Erw;
};
this.Lst=function(QZl){
if(typeof(QZl)=="boolean"){
this.tht(dIX,"resumable",QZl);
this.ogQ();
Erw=QZl;
}
};
this.arb=function(){
if(isUndefined(rwc)){
rwc=this.getValue("suspended",false);
}
return rwc;
};
this.VYR=function(QZl){
if(typeof(QZl)=="boolean"){
this.tht(dIX,"suspended",QZl);
this.ogQ();
rwc=QZl;
}
};
this.isActive=function(){
if(isUndefined(hoT)){
hoT=this.getValue("active",false);
}
return hoT;
};
this.setActive=function(QZl){
if(typeof(QZl)=="boolean"){
this.tht(dIX,"active",QZl);
this.ogQ();
hoT=QZl;
}
};
this.isTracked=function(){
return this.Noq().LVt().SPO();
};
this.isVisible=function(){
if(isUndefined(pCY)){
pCY=this.getValue("isvisible",true);
}
return pCY;
};
this.Isq=function(){
if(!oqt){
var SGB=this.cgt("presentation");
oqt=new activelms.nco(SGB);
}
return oqt;
};
this.getActivityProgressInfo=function(){
if(isUndefined(hEr)){
var owj=this.cgt("activityProgressInfo");
var kIA=this.Noq().LVt().SPO();
hEr=
new activelms.ActivityProgressInfo(owj,kIA,this);
}
return hEr;
};
this.getAttemptProgressInfo=function(){
if(isUndefined(FOP)){
var gHK=this.cgt("attemptProgressInfo");
var kIA=this.Noq().LVt().SPO();
FOP=
new activelms.AttemptProgressInfo(gHK,kIA,this);
}
return FOP;
};
this.getObjectiveSet=function(){
return this.Noq().IEV().getObjectiveSet();
};
this.Bqt=function(){
return this.Noq().IEV().Bqt();
};
this.getObjectiveProgressInfo=function(){
return this.Noq().IEV().Bqt().getObjectiveProgressInfo();
};
this.woI=function(){
if(isUndefined(ijl)){
ijl=this.getValue("parameters","");
}
return ijl;
};
this.getLaunchData=function(){
if(isUndefined(foa)){
var jFk=this.cgt("dataFromLMS");
foa=this.getElementText(jFk);
}
return foa;
};
this.getCompletionThreshold=function(){
var cVJ=jDF.getScormVersion();
if(isUndefined(QeS)){
if(cVJ<2004.4){
var jFk=this.cgt("completionThreshold");
var blY=this.getElementText(jFk);
QeS=parseFloat(blY);
}
else{
var dIX=
this.cgt("completionThreshold");
var blY=undefined;
if(dIX&&dIX.nodeType==1){
var Kio=dIX.getAttributeNode("completedByMeasure");
if(Kio){
var tdU=Kio.value;
if(tdU&&tdU=="true"){
var Kio=dIX.getAttributeNode("minProgressMeasure");
if(Kio){
blY=Kio.value;
}
}
}
}
QeS=parseFloat(blY);
}
}
if(isNaN(QeS)){
return undefined;
}
return QeS;
};
this.getTimeLimitAction=function(){
if(isUndefined(Tfo)){
var jFk=this.cgt("timeLimitAction");
Tfo=this.getElementText(jFk);
if(isUndefined(Tfo)||Tfo.length===0){
Tfo="continue,no message";
}
}
return Tfo;
};
this.getMaxTimeAllowed=function(cVJ){
if(isUndefined(KWr)){
if(cVJ<2004){
var jFk=this.cgt("maxtimeallowed");
KWr=this.getElementText(jFk);
}
else{
KWr=this.Noq().nBU().wso();
}
}
return KWr;
};
this.IrM=function(){
var jFk=this.cgt("masteryscore");
var blY=this.getElementText(jFk);
var drd=parseFloat(blY);
if(isNaN(drd)){
return undefined;
}
else{
return drd/100;
}
};
this.setScaledPassingScore=function(OfU,cVJ){
if(cVJ>1.2){
var JiU=this.Noq().IEV().Bqt();
var iDM=JiU.RKU();
JiU.setSatisfiedByMeasure(true);
JiU.setMinNormalizedMeasure(OfU);
}
ZCX=OfU;
};
this.getScaledPassingScore=function(cVJ){
if(isUndefined(ZCX)){
if(cVJ<2004){
ZCX=this.IrM();
}
else{
var JiU=this.Noq().IEV().Bqt();
var iDM=JiU.RKU();
var OfU=JiU.cnV();
if(iDM){
if(isUndefined(OfU)){
ZCX=1.0;
}
else{
ZCX=OfU;
}
}
else{
ZCX=undefined;
}
}
}
return ZCX;
};
this.getResource=function(){
var hej=this.cgt("resource");
var bMr=this.woI();
var cVJ=undefined
if(jDF){
cVJ=jDF.getScormVersion();
}
return new activelms.Resource(hej,bMr,cVJ);
};
this.Noq=function(){
if(isUndefined(tvu)){
var csj=this.cgt("sequencing");
if(isUndefined(csj)){
tvu=new activelms.Epw(undefined,this);
}
else{
tvu=new activelms.Epw(csj,this);
}
}
return tvu;
};
this.isLeaf=function(){
var iaf=this.eoW("item");
if(isUndefined(iaf)||iaf.length===0){
return true;
}
return false;
};
this.isSco=function(){
if(this.getResource()&&this.getResource().getScormType().toLowerCase()=="sco"){
return true;
}
return false;
};
this.isRoot=function(){
if(isUndefined(this.getParent())){
return true;
}
return false;
};
this.LfJ=function(LpN){
this.Cvn.push(LpN);
};
this.Xao=function(LpN){
var gRR=LpN.sSS(this.getIdentifier());
if(this.TRT(gRR)){
return true;
}
return false;
};
this.ICD=function(LpN){
if(!LpN){return false;}
if(this.Jrf()>LpN.Jrf()){
return true;
}
return false;
};
this.FNo=function(LpN){
if(!LpN){return false;}
if(this.Jrf()<LpN.Jrf()){
return true;
}
return false;
};
this.OmU=function(LpN){
if(isUndefined(LpN)){
return false;
}
if(LpN.isRoot()){
return false;
}
var Ysd=LpN.getParent().getAvailableChildren();
var SRI=Ysd.length-1;
var MOT;
do{
MOT=Ysd [SRI];
if(MOT.TRT(this)){
return true;
}--SRI;
}
while(SRI>=0);
return false;
};
this.dXY=function(){
if(this.isRoot()){return false;}
var FhY=this.getParent();
if(FhY.hasAvailableChildren()){
var mJn=FhY.getAvailableChildren();
var PaW=mJn.length;
for(var SRI=0;SRI<PaW;SRI++){
if(this.TRT(mJn[SRI])){
return true;
}
}
}
return false;
};
this.JTH=function(){
if(this.isRoot()){return false;}
var FhY=this.getParent();
if(FhY.hasAvailableChildren()){
var mJn=FhY.getAvailableChildren();
if(this.TRT(mJn[0])){
return true;
}
}
return false;
};
this.hoP=function(){
if(this.isRoot()){return false;}
var FhY=this.getParent();
if(FhY.hasAvailableChildren()){
var mJn=FhY.getAvailableChildren();
if(this.TRT(mJn[mJn.length-1])){
return true;
}
}
return false;
};
this.getParent=function(){
return vNc;
};
this.hasAvailableChildren=function(){
var mJn=this.getAvailableChildren();
if(!isUndefined(mJn)&&mJn&&mJn.length>0){
return true;
}
return false;
};
this.tnx=function(){
if(this.hasAvailableChildren()){
var mJn=this.getAvailableChildren();
return mJn[0];
}
};
this.getAvailableChildren=function(){
if(this.Cvn.length===0){
return;
}
return this.Cvn;
};
var Xse;
this.aaZ=function(){
if(!Xse){
Xse=[];
this.wBK(this,undefined,Xse);
}
return Xse;
}
this.sSS=function(sVZ){
return this.wBK(this,sVZ);
};
this.wBK=function(LpN,sVZ,JBk){
if(typeof(JBk)!="undefined"){
JBk.push(LpN);
}
if(LpN.getIdentifier()==sVZ){
return LpN;
}
var mJn=LpN.getAvailableChildren();
if(!isUndefined(mJn)){
var PLR=mJn.length;
for(var SRI=0;SRI<PLR;SRI++){
var eUH=this.wBK(mJn[SRI],sVZ,JBk);
if(!isUndefined(eUH)){
return eUH;
}
}
}
};
this.TRT=function(LpN){
if(isUndefined(LpN)){return false;}
if(LpN===null){return false;}
if(typeof(LpN)=="object"){
return this.getIdentifier()==LpN.getIdentifier();
}
return false;
};
this.LbT=function(LpN){
while(!LpN.isRoot()){
LpN=LpN.getParent();
}
return LpN;
};
this.isDisabledForPrevious=function(){
if(!this.isRoot()){
var FhY=this.getParent();
if(!FhY.Noq().YYI().axs()){
return true;
}
if(FhY.Noq().YYI().Opk()){
return true;
}
}
else{
return true;
}
var qAN=this.canSequence(activelms.SequencingEngine.PREVIOUS);
if(!qAN){
return true;
}
return false;
};
this.isDisabledForContinue=function(){

if(!this.isRoot()){
var FhY=this.getParent();
if(!FhY.Noq().YYI().axs()){
return true;
}
}

var qAN=this.canSequence(activelms.SequencingEngine.CONTINUE);
if(!qAN){
return true;
}
return false;
};
this.isDisabledForChoice=function(){
var JBk=this.WLw();
var SRI=JBk.length-1;
var tvu=undefined;
var jTK=false;
var rNe=false;
var jXx=false;
do{
tvu=JBk[SRI].Noq();
if(!isUndefined(tvu.auo())){
jTK=true;
break;
}
if(!isUndefined(tvu.nBU())){
rNe=true;
break;
}
if(tvu.YYI().XGi()==false){
jXx=true;
break;
}--SRI;
}
while(SRI>=0);
if(jTK==false&&rNe==false&&jXx==false){
return false;
}
if(this.isLeaf()){
if(!this.getParent().Noq().YYI().XGi()){
return true;
}
if(this.HYt()){
return true;
}
return false;
}
else{
if(!this.isRoot()){
if(!this.getParent().Noq().YYI().XGi()){
return true;
}
}
if(this.HYt()){
return true;
}
}
return false;
};
this.HYt=function(){

var rgh=new activelms.XuO();
rgh.cjg(jDF);
var xeQ=false;
try{
xeQ=
rgh.Ihh(this);
if(xeQ){
return true;
}
}
catch(IZH){
return true;
}
var BGn=jDF.getCurrentActivity();
if(this.FNo(BGn)){
if(this.OmU(BGn)){
if(this.getParent().Noq().YYI().Opk()){
return true;
}
}
}
var ULH=new activelms.icx().qPn;
if(this.ICD(BGn)){
if(this.OmU(BGn)){
var wdm=rgh.axA(this,ULH);
if(wdm){
return true;
}
}
}
try{
activelms.NavigationBehaviour.invoke(jDF,activelms.SequencingEngine.CHOICE,this.getIdentifier(),false);
}
catch(IZH){
if(IZH.code){
if(IZH.code=="NB.2.1-8"){
return true;
}
}
}
if(BGn){
var WYp=
jDF.YrQ(BGn,this);
var kTK=this;
try{
var csk=0;
if(kTK.TRT(BGn)){csk=1;}
else if(kTK.OmU(BGn)){csk=2;}
else if(WYp.TRT(BGn)||isUndefined(BGn)){csk=3;}
else if(WYp.TRT(kTK)){csk=4;}
else if(kTK.Xao(WYp)){csk=5;}
switch(csk){
case 1:
activelms.SequencingBehaviour.dCd();
break;
case 2:
activelms.SequencingBehaviour.Pxi(jDF,BGn,kTK)
break;
case 3:
activelms.SequencingBehaviour.RoB(jDF,WYp,kTK);
break;
case 4:
activelms.SequencingBehaviour.BGM(jDF,WYp,BGn);
break;
case 5:
activelms.SequencingBehaviour.Jsj(jDF,WYp,BGn,kTK);
break;
}
}
catch(IZH){
if(IZH.code){
if(IZH.code=="SB.2.2-1"){
return true;
}
if(IZH.code=="SB.2.9-7"){
return true;
}
if(IZH.code=="SB.2.9-8"){
return true;
}
if(IZH.code=="SB.2.4-1"){
return true;
}
if(IZH.code=="SB.2.4-2"){
return true;
}
}
}
}
try{
var eEv;
if(this.isLeaf()){
eEv=this;
}
else{
var nFt=activelms.SequencingBehaviour.GDQ(jDF,this,activelms.SequencingBehaviour.crC,true);
eEv=nFt.mPf();
}
activelms.ksP.JNJ(jDF,eEv,false);
}
catch(IZH){
if(IZH.code){
if(IZH.code=="SB.2.2-1"){
return true;
}
if(IZH.code=="SB.2.2-2"){
return true;
}
if(IZH.code=="DB.1.1-3"){
return true;
}
}
}
return false;
};

this.eBl=function(){
if(this.isLeaf()){
var FhY=this.getParent();
var KZc=FhY.isActive();
var Sbk=
FhY.Noq().sRm().FnQ();
if(!KZc&&Sbk){
return true;
}
}
else{
if(!this.isActive()&&this.Noq().sRm().FnQ()){
return true;
}
}

if(!this.isActive()){
try{
activelms.NavigationBehaviour.invoke(jDF,activelms.SequencingEngine.CHOICE,this.getIdentifier(),false);
}
catch(IZH){
if(IZH.code&&IZH.code=="NB.2.1-8"){
return true;
}
}
}
if(!jDF.Zdb()){
return false;
}
try{
activelms.SequencingBehaviour.OGO(jDF,this);
}
catch(IZH){
return true;
}
return false;
};
this.canSequence=function(ReP){
var Qaf=jDF.ZKU();
var DdK=
activelms.EngineFactory.instance(Qaf,false);
if(isUndefined(Qaf.getCurrentActivity())){
return false;
}
try{
activelms.NavigationBehaviour.invoke(Qaf,ReP,undefined,false);
if(ReP==activelms.SequencingEngine.PREVIOUS){
activelms.SequencingBehaviour.DlI(Qaf,false);
}
}
catch(IZH){
return false;
}
return true;
};
this.isHiddenForPrevious=function(){
return this.PHx("previous");
};
this.isHiddenForContinue=function(){
return this.PHx("continue");
};
this.isHiddenForExit=function(){
return this.PHx("exit");
};
this.isHiddenForChoice=function(){
if(!this.isVisible()){
return true;
}
if(this.eBl()){
return true;
}
return false;
};
this.PHx=function(uIv){
var oqt=this.Isq();
if(!BhG){
BhG=oqt.mKG().Kec();
}
if(BhG[uIv]){
return true;
}
return false;
};
this.tZd=function(){
if(isUndefined(ZAx)){
ZAx=[];
var RKH=this.Noq().IEV().getObjectiveSet();
var PaW=RKH.length;
var lBU=undefined;
var umP=0;
var LNS=[];
for(var SRI=0;SRI<PaW;SRI++){
LNS=RKH[SRI].ITP();
umP=LNS.length;
for(var olg=0;olg<umP;olg++){
lBU=LNS[olg];
ZAx.push(lBU.njR());
}
}
}
return ZAx;
};
this.NiE=function(wrv){
var RKH=this.Noq().IEV().getObjectiveSet();
var PaW=RKH.length;
var lBU=undefined;
var umP=0;
var cPn=[];
for(var SRI=0;SRI<PaW;SRI++){
cPn=RKH[SRI].INf();
umP=cPn.length;
for(var olg=0;olg<umP;olg++){
lBU=cPn[olg];
if(lBU.njR()==wrv){
return true;
}
}
}
return false;
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="title: "+this.getTitle()+"\n";
cZn+="identifier: "+this.getIdentifier()+"\n";
cZn+="isvisible: "+this.isVisible()+"\n";
cZn+="leaf: "+this.isLeaf()+"\n";
cZn+="active: "+this.isActive()+"\n";
cZn+="root: "+this.isRoot()+"\n";
return cZn;
};
};
activelms.Activity.prototype=new activelms.BRH();
delete activelms.Activity.prototype.dIX;
activelms.Activity.prototype.constructor=activelms.Activity;
activelms.ActivityTree=function(KDV,FaU,HxP){
this.FaU=FaU;
this.OQi=undefined;

var aJP;
var Psd;
var viW;
var dIX;
var mfV;
var asm=true;
var HCd=false;
var skI="sequencingCollection";
var AkT="globalObjectives";
var hsN="organizations";
var jpF="identifiers";
var SLF="organization";
var MVs="orgID";
var VJN="sessionID";
var VPX="schemaVersion";
var lct="objectivesGlobalToSystem";
var mVL="1.1";
var Ypx="1.2";
var WqZ="CAM 1.3";
var sWT="2004 3rd Edition";
var SQP="2004 4th Edition";
var hhb=Ypx;
var hSc=true;
var DLV=true;
if(KDV.nodeType==9){

Psd=KDV.documentElement;
}
else if(KDV.nodeType==1){

Psd=KDV;
}
else{
throw new Error("Unsupported object type in activity tree constructor: "+KDV);
}
if(Psd.tagName.indexOf("Envelope")!=-1){
var NAv=new activelms.DefinitionType(Psd);
var dDA=NAv.cgt("Body");
var wjf=new activelms.DefinitionType(dDA);

var WfL=wjf.HJf(dDA,"manifest");
viW=new activelms.DefinitionType(WfL);
}
else if(Psd.tagName.indexOf("manifest")!=-1){
viW=new activelms.DefinitionType(Psd);
}
else if(Psd.tagName.indexOf("organization")!=-1){
dIX=Psd;
}
else{
throw new Error("Unsupported element in activity tree constructor: "+Psd.tagName);
}
var kPI=undefined;
var Hgl=undefined;
if(!isUndefined(viW)){
var kPI=viW.cgt(hsN);
var Hgl=new activelms.DefinitionType(kPI);
if(isUndefined(this.FaU)){
var Uxm=Hgl.cgt(jpF);
var Kio=Uxm.getAttributeNode(MVs);
if(Kio){
this.FaU=Kio.value;
}
Kio=Uxm.getAttributeNode(VJN);
if(Kio){
this.OQi=Kio.value;
}
}
}
if(isUndefined(dIX)){
var slV=Hgl.eoW(SLF);
if(isUndefined(slV)||!slV.length||slV.length==0){
DLV=false;
}
if(DLV){
var PaW=slV.length;
activelms.Organizations=[PaW];
var RtH;
var dIX;
for(var SRI=0;SRI<PaW;SRI++){
RtH=new activelms.BRH(slV[SRI]);
activelms.Organizations[SRI]=RtH;
if(RtH.getIdentifier()==this.FaU){
dIX=slV[SRI];
asm=RtH.getObjectivesGlobalToSystem();
}
}
if(isUndefined(RtH)){
DLV=false;
}
else{
if(isUndefined(HxP)||!HxP){

var FTR=viW.cgt(AkT);
var kWC=true;
activelms.GlobalObjectives=new activelms.MMf(FTR,kWC,this);

var SEG=viW.cgt(skI);
if(!SEG){
activelms.pQT=new activelms.GDZ();
}
else{
activelms.pQT=new activelms.GDZ(SEG);
}
}
}
}
}
activelms.DefinitionType.call(this,dIX);
var vbF=0;
var MUJ=function(LpN,ObE,hTs){
if(!HCd){
if(LpN.Zdb()){
HCd=true;
}
}
mfV.push(LpN);
var iaf=LpN.eoW("item");
if(!iaf||iaf.length===0){
return;
}
ObE=ObE+1;
var PaW=iaf.length;
var GKg;
for(var SRI=0;SRI<PaW;SRI++){
vbF++;

GKg=new activelms.Activity(iaf[SRI],LpN,ObE,hTs,vbF);
LpN.LfJ(GKg);
MUJ(GKg,ObE,hTs);
}
};
if(DLV){


aJP=new activelms.Activity(dIX,undefined,0,this,0);
mfV=[];
MUJ(aJP,0,this);
}
this.getOrgID=function(){
return this.FaU;
}
this.SkK=function(){
return this.OQi;
}
this.ZKU=function(){
return new activelms.ActivityTree(dIX.cloneNode(true),this.getRoot().getIdentifier(),true);
};
this.Zdb=function(){
return HCd;
}
this.setNavigationRequestType=function(Zth){
if(isUndefined(viW)){
throw new Error("No manifest element defined");
}
var MSV=viW.cgt("navRequest");
if(MSV){
while(MSV.hasChildNodes()){
MSV.removeChild(MSV.firstChild);
}
if(KDV.nodeType==9){
var Njk=KDV.createTextNode(Zth)
MSV.appendChild(Njk);
}
}
}
this.Hdt=function(VcW){
if(isUndefined(viW)){
throw new Error("No manifest element defined");
}
var Vpp=viW.cgt("syncClientServer");
if(Vpp){
while(Vpp.hasChildNodes()){
Vpp.removeChild(Vpp.firstChild);
}
if(KDV.nodeType==9){
var Njk=KDV.createTextNode(VcW)
Vpp.appendChild(Njk);
}
}
}
this.setCurrentActivity=function(LpN){
var JBk=this.getAvailableActivityList();
var SRI=JBk.length-1;
do{
if(JBk[SRI].isCurrent()){
JBk[SRI].Bmv(false);
break;
}--SRI;
}
while(SRI>=0);
if(LpN&&LpN!==null){
LpN.Bmv(true);
}
};
this.getCurrentActivity=function(){
var BGn;
var JBk=this.getAvailableActivityList();
var SRI=JBk.length-1;
do{
if(JBk[SRI].isCurrent()){
BGn=JBk[SRI];
break;
}--SRI;
}
while(SRI>=0);
if(!isUndefined(BGn)&&BGn!==null){
return BGn;
}
return undefined;
};
this.xXj=function(LpN){
var JBk=this.getAvailableActivityList();
var SRI=JBk.length-1;
do{
if(JBk[SRI].GTs()){
JBk[SRI].Lst(false);
break;
}--SRI;
}
while(SRI>=0);
if(isUndefined(LpN)||LpN===null){
return;
}
LpN.Lst(true);
LpN.VYR(true);
};
this.getSuspendedActivity=function(){
var IUA;
var JBk=this.getAvailableActivityList();
var SRI=JBk.length-1;
do{
if(JBk[SRI].GTs()){
IUA=JBk[SRI];
break;
}--SRI;
}
while(SRI>=0);
return IUA;
};
this.QDl=function(){
var hLG=this.getAvailableActivityList().length;
return this.getAvailableActivityList()[hLG-1];
};
this.getSchemaVersion=function(){
return this.getValue(VPX,hhb);
};
this.getScormVersion=function(){
var gFg=this.getSchemaVersion();
if(gFg==mVL){
return 1.1;
}
else if(gFg==WqZ){
return 2004.2;
}
else if(gFg==sWT){
return 2004.310;
}
else if(gFg==SQP){
return 2004.411;
}
return 1.2;
};
this.getObjectivesGlobalToSystem=function(){
return asm;
};
this.getGlobalObjectives=function(){
if(activelms.GlobalObjectives){
return activelms.GlobalObjectives;
}
};
this.getID=function(){
return this.getValue("pk",undefined);
};
this.getRoot=function(){
return aJP;
};
this.getAvailableActivityList=function(){
return mfV;
};
this.WLw=function(gRR,CQx){
var hWU=[];
if((isUndefined(gRR))||(isUndefined(CQx))){
return hWU;
}
if((null===gRR)||(null===gRR)){
return hWU;
}
if(gRR.TRT(CQx)){
hWU.push(gRR);
return hWU;
}
hWU.push(gRR);
while(!isUndefined(gRR.getParent())){
gRR=gRR.getParent();
hWU.push(gRR);
if(gRR.TRT(CQx)){
break;
}
}
return hWU;
};
this.getDescendingActivityPath=function(CQx,gRR){
var hWU=this.WLw(gRR,CQx);
return hWU.reverse();
};
this.YrQ=function(Qrc,SPV){
if(isUndefined(Qrc)||isUndefined(SPV)){return;}
if(null===Qrc||null===SPV){return;}
if(Qrc.isRoot()||SPV.isRoot()){return this.getRoot();}
if(Qrc.TRT(SPV)){return Qrc.getParent();}
var QMn=this.getDescendingActivityPath(this.getRoot(),Qrc);
var PaW=QMn.length;
var BmZ=this.getDescendingActivityPath(this.getRoot(),SPV);
var MMm=QMn.length;
if(MMm<PaW){
PaW=MMm;
}
for(var SRI=0;SRI<PaW;SRI++){
if(!QMn[SRI].TRT(BmZ[SRI])){
return QMn[SRI].getParent();
}
}
if(PaW==MMm){
return SPV.getParent();
}
return Qrc.getParent();
};
this.kZX=function(Qrc,SPV){
if(isUndefined(Qrc)||isUndefined(SPV)){return false;}
if(null===Qrc||null===SPV){return false;}
if(Qrc.TRT(SPV)){return false;}
var JBk=this.getAvailableActivityList();
var PaW=JBk.length;
var XBC=undefined;
var RTv=undefined;
for(var SRI=0;SRI<PaW;SRI++){
if(JBk[SRI].TRT(Qrc)){
XBC=SRI;
}
else if(JBk[SRI].TRT(SPV)){
RTv=SRI;
}
if(!isUndefined(XBC)&&!isUndefined(RTv)){
break;
}
}
if(XBC>RTv){
return true;
}
return false;
};
this.findByName=function(SnD){

var DVo=this.getAvailableActivityList();
var SRI=DVo.length-1;
do{
if(DVo[SRI].getIdentifier()==SnD){
return DVo[SRI];
}--SRI;
}
while(SRI>=0);
};
this.getSourceDocumentElement=function(){
return KDV;
};
this.iDK=function(){
return new String(doSerialize(KDV));
};
this.pJn=function(){
var PZF=new activelms.HashTable();
var BGn=this.getCurrentActivity();
if(isUndefined(BGn)){
return PZF;
}
PZF.put(BGn.getIdentifier(),BGn);
var JkD=BGn.tZd();
var SRI=JkD.length-1;
var wrv=undefined;
var pOI=this.getAvailableActivityList();
var IIu=pOI.length;
var OcD=undefined;
var SnD=undefined;
do{
wrv=JkD[SRI];
for(var olg=0;olg<IIu;olg++){
if(pOI[olg].NiE(wrv)){
if(!pOI[olg].isRoot()){
OcD=pOI[olg].getParent();
SnD=OcD.getIdentifier();
if(!PZF.contains(SnD)){
PZF.put(SnD,OcD);
}
}
}
}--SRI;
}
while(SRI>=0);
return PZF;
};
this.ThI=false;
this.MWk=function(){
this.ThI=true;
var CFA=this.pJn();
var boh=new activelms.LpO();
boh.cjg(this);
var ICo=undefined;
while(CFA.size()!=0){
ICo=VBd(CFA,this);
boh.JMQ(ICo);
CFA.remove(ICo.getIdentifier());
break;
}
this.ThI=false;
};
var VBd=function(DbQ,hTs){
var HTp=DbQ.elements();
var SRI=HTp.length-1;
var LpN=undefined;
var wrv=undefined;
var pOI=hTs.getAvailableActivityList();
var IIu=pOI.length;
var ICo=HTp[SRI];
do{
LpN=HTp[SRI];
if(LpN.getDepth()>ICo.getDepth()){
ICo=LpN;
}--SRI;
}
while(SRI>=0);
return ICo;
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="title: "+this.getRoot().getTitle()+"\n";
cZn+="identifier: "+this.getRoot().getIdentifier()+"\n";
cZn+="objectivesGlobalToSystem: "+this.getObjectivesGlobalToSystem()+"\n";
cZn+="schemaVersion: "+this.getSchemaVersion()+"\n";
return cZn;
};
};
activelms.ActivityTree.prototype=new activelms.DefinitionType();
delete activelms.ActivityTree.prototype.dIX;
activelms.ActivityTree.prototype.constructor=activelms.ActivityTree;

activelms.Resource=function(dIX,ijl,cVJ){
activelms.DefinitionType.call(this,dIX);
var rqR=function(wdc,bMr){
if(isUndefined(bMr)||bMr===null||bMr.length===0){
return wdc;
}
var dsf=bMr.substring(0,1);
if(cVJ&&cVJ<2004){
if(dsf=="?"||dsf=="#"){
wdc+=bMr;
}
return wdc;
}
var dsf=bMr.substring(0,1);
while(dsf=="?"||dsf=="&"){
bMr=bMr.substring(1,bMr.length);
dsf=bMr.substring(0,1);
}
if(bMr.substring(0,1)=="#"){
if(wdc.indexOf("#")!==0){
bMr=undefined;
}
else{
wdc+=bMr;
}
return wdc;
}
if(wdc.indexOf("?")!=-1){
wdc+="&";
}
else{
wdc+="?";
}
wdc+=bMr;
return wdc;
};
this.getURI=function(){
var wdc=this.buG();
wdc=rqR(wdc,ijl);
var XnI=this.lDK();
if(isUndefined(XnI)){
return wdc;
}
return XnI.concat(wdc);
};
this.getType=function(){
return this.getValue("type",undefined);
};
this.buG=function(){
return this.getValue("href","");
};
this.woI=function(){
return ijl;
};
this.getScormType=function(){
return this.getValue("scormType","asset");
};
this.lDK=function(){
return this.getValue("xmlBase","");
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="href: "+this.buG()+"\n";
cZn+="type: "+this.getType()+"\n";
cZn+="scormType: "+this.getScormType()+"\n";
cZn+="xmlBase: "+this.lDK()+"\n";
cZn+="parameters: "+this.woI()+"\n";
cZn+="URI: "+this.getURI()+"\n";
return cZn;
};
};
activelms.Resource.prototype=new activelms.DefinitionType();
delete activelms.Resource.prototype.dIX;
activelms.Resource.prototype.constructor=activelms.Resource;
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(!activelms.TerminationBehaviour){activelms.TerminationBehaviour={};}
else if(typeof activelms.TerminationBehaviour!="object"){
throw new Error("namepsace activelms.TerminationBehaviour exists");}
activelms.TerminationBehaviour.terminationRequest=undefined;
activelms.TerminationBehaviour.sequencingRequest=undefined;
activelms.TerminationBehaviour.invoke=
function(hTs,ujl){
activelms.TerminationBehaviour.terminationRequest=undefined;
activelms.TerminationBehaviour.sequencingRequest=undefined;
activelms.TerminationBehaviour.fOT(hTs,ujl);
};
activelms.TerminationBehaviour.kdk=
function(hTs,BGn){
var icx=new activelms.icx();
var CQx=hTs.getRoot();
var xWb=BGn.getParent();
var SWm=undefined;
var rgh=new activelms.XuO();
rgh.cjg(hTs);
var XNk=hTs.getDescendingActivityPath(CQx,xWb);
var PaW=XNk.length;
var wdm=undefined;
for(var SRI=0;SRI<PaW;SRI++){
wdm=rgh.axA(XNk[SRI],icx.xMr);
if(!isUndefined(wdm)){
SWm=XNk[SRI];
break;
}
}
if(!isUndefined(SWm)){
rgh.wIN(SWm);
rgh.VsJ(SWm);
hTs.setCurrentActivity(SWm);
}
};
activelms.TerminationBehaviour.IKG=
function(hTs,BGn){
var icx=new activelms.icx();
activelms.TerminationBehaviour.terminationRequest=undefined;
if(BGn.arb()){return;}
var rgh=new activelms.XuO();
rgh.cjg(hTs);
log.debug("TB.2.2.2");
var wdm=rgh.axA(BGn,icx.TSj);
if(!isUndefined(wdm)){
log.debug("TB.2.2.3");
if(wdm==icx.TpQ||wdm==icx.tYl||wdm==icx.VDG){
if(wdm==icx.TpQ){
activelms.TerminationBehaviour.GEO(BGn,rgh);
}
activelms.TerminationBehaviour.sequencingRequest=wdm;
return;
}
if(wdm==icx.Ato||wdm==icx.gnH){
activelms.TerminationBehaviour.terminationRequest=wdm;
return;
}
if(wdm==icx.Qea){
activelms.TerminationBehaviour.terminationRequest=
icx.gnH;
activelms.TerminationBehaviour.sequencingRequest=
icx.TpQ;
return;
}
}
};
activelms.TerminationBehaviour.GEO=function(LpN,rgh){
var tpY=LpN.Noq().YYI();
if(tpY.wnD()){
rgh.oOc(LpN);
}
if(tpY.Rto()){
rgh.SFK(LpN);
}
}
activelms.TerminationBehaviour.fOT=
function(hTs,ujl){
var BGn=hTs.getCurrentActivity();
var Xub=false;
if(!isUndefined(BGn)){Xub=true;}
var rCF=hTs.getSuspendedActivity();
var rwc=false;
if(!isUndefined(rCF)){rwc=true;}
if(!Xub){
throw activelms.SequencingBehaviourError.QnZ;
}
var SEH=false;
if(ujl==activelms.SequencingEngine.EXIT||ujl==activelms.SequencingEngine.ABANDON){
SEH=true;
}
if(SEH&&(!BGn.isActive())){
throw activelms.SequencingBehaviourError.Npl;
}
switch(ujl){
case activelms.SequencingEngine.EXIT:
activelms.TerminationBehaviour.Xei(hTs,BGn);
break;
case activelms.SequencingEngine.ABANDON:
activelms.TerminationBehaviour.Zpc(hTs,BGn);
break;
case activelms.SequencingEngine.EXIT_ALL:
activelms.TerminationBehaviour.hIW(hTs,BGn);
break;
case activelms.SequencingEngine.SUSPEND_ALL:
activelms.TerminationBehaviour.MYf(hTs,BGn);
break;
case activelms.SequencingEngine.ABANDON_ALL:
activelms.TerminationBehaviour.GOA(hTs,BGn);
break;
default:
throw activelms.SequencingBehaviourError.Dhr;
}
if(ujl==activelms.SequencingEngine.EXIT_ALL||ujl==activelms.SequencingEngine.SUSPEND_ALL||ujl==activelms.SequencingEngine.ABANDON_ALL){
if(activelms.TerminationBehaviour.sequencingRequest==activelms.SequencingEngine.EXIT){
hTs.setCurrentActivity(undefined);
}
}
};
activelms.TerminationBehaviour.Xei=
function(hTs,BGn){
var icx=new activelms.icx();
var rgh=new activelms.XuO();
rgh.cjg(hTs);
log.debug("TB.2.3.3.1");
rgh.VsJ(BGn);
log.debug("TB.2.3.3.2");
activelms.TerminationBehaviour.kdk(hTs,BGn);
BGn=hTs.getCurrentActivity();
var KMx=false;
do{
KMx=false;
activelms.TerminationBehaviour.IKG(hTs,BGn);
if(activelms.TerminationBehaviour.terminationRequest==
icx.gnH){
activelms.TerminationBehaviour.hIW(hTs,BGn);
break;
}
if(activelms.TerminationBehaviour.terminationRequest==
icx.Ato){
if(!BGn.isRoot()){
BGn=BGn.getParent();
hTs.setCurrentActivity(BGn);
rgh.VsJ(BGn);
KMx=true;
}
else{
throw activelms.SequencingBehaviourError.WEf;
}
}
else{
if(BGn.isRoot()&&(activelms.TerminationBehaviour.sequencingRequest!=
icx.TpQ)){
log.debug("TB.2.3.3.3.5.1.1");
activelms.TerminationBehaviour.sequencingRequest=
activelms.SequencingEngine.EXIT;

activelms.SequencingBehaviour.isSequencingFinished=true;
hTs.setCurrentActivity(undefined);
}
}
}
while(KMx);
};
activelms.TerminationBehaviour.Zpc=
function(hTs,BGn){
BGn.setActive(false);
return;
};
activelms.TerminationBehaviour.hIW=
function(hTs,BGn){
var rgh=new activelms.XuO();
rgh.cjg(hTs);
if(BGn.isActive()){
rgh.VsJ(BGn);
}
var aJP=hTs.getRoot();
rgh.wIN(aJP);
rgh.VsJ(aJP);
hTs.setCurrentActivity(aJP);
if(isUndefined(activelms.TerminationBehaviour.sequencingRequest)){
activelms.TerminationBehaviour.sequencingRequest=
activelms.SequencingEngine.EXIT;
}
};
activelms.TerminationBehaviour.MYf=
function(hTs,BGn){
if(BGn.isActive()||BGn.arb()){
var boh=new activelms.LpO();
boh.cjg(hTs);
boh.JMQ(BGn);


}
else{
if(!BGn.isRoot()){
BGn.getParent().VYR(true);
hTs.xXj(BGn.getParent());
}
else{
throw activelms.SequencingBehaviourError.gwp;
}
}

BGn.VYR(true);
hTs.xXj(BGn);
var xWb=hTs.getSuspendedActivity();
var CQx=hTs.getRoot();
var IHk=
hTs.WLw(xWb,CQx);
var PaW=IHk.length;
if(PaW===0){
throw activelms.SequencingBehaviourError.roH;
}
for(var SRI=0;SRI<PaW;SRI++){
IHk[SRI].setActive(false);
IHk[SRI].VYR(true);
}
hTs.setCurrentActivity(hTs.getRoot());
activelms.TerminationBehaviour.sequencingRequest=activelms.SequencingEngine.EXIT;
};
activelms.TerminationBehaviour.GOA=
function(hTs,BGn){
var aJP=hTs.getRoot();
var IHk=hTs.WLw(BGn,aJP);
var PaW=IHk.length;
if(PaW===0){
throw activelms.SequencingBehaviourError.VNC;
}
for(var SRI=0;SRI<PaW;SRI++){
IHk[SRI].setActive(false);
}
hTs.setCurrentActivity(aJP);
activelms.TerminationBehaviour.sequencingRequest=
activelms.SequencingEngine.EXIT;
};
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(activelms.MMf){throw new Error("namespace activelms.Objectives");}
if(activelms.Objective){throw new Error("namespace activelms.Objective");}
if(activelms.Qxf){throw new Error("namespace activelms.MapInfo");}
if(activelms.ActivityProgressInfo){throw new Error("namespace activelms.ActivityProgressInfo exists");}
if(activelms.AttemptProgressInfo){throw new Error("namespace activelms.AttemptProgressInfo exists");}
if(activelms.ObjectiveProgressInfo){throw new Error("namespace activelms.ObjectiveProgressInfo exists");}
if(activelms.pWu){throw new Error("namespace activelms.GlobalObjectiveProgressInfo");}
activelms.MMf=function(dIX,kWC,hTs,kIA,LpN){
this.isg="primaryObjective";
this.rBU="objective";
var JiU=undefined;
activelms.DefinitionType.call(this,dIX);
this.iDK=function(){
return doSerialize(dIX);
};
this.eLQ=function(){
var Nqv=new activelms.HashTable();
var bRj=undefined;
var WrJ=this.eoW(this.rBU);
if(!isUndefined(WrJ)){
var PaW=WrJ.length;
for(var SRI=0;SRI<PaW;SRI++){
bRj=new activelms.Objective(WrJ[SRI],false,kWC,kIA,LpN);
Nqv.put(bRj.getObjectiveID(),bRj);
}
}
var vAc=this.Bqt();
if(!isUndefined(vAc)){
Nqv.put(vAc.getObjectiveID(),vAc);
}
return Nqv;
};
this.MWk=function(){
if(!isUndefined(hTs)&!hTs.ThI){
hTs.MWk();
}
};
this.KsE=function(fMQ){
return this.eLQ().get(fMQ);
};
this.getObjectiveSet=function(){
return this.eLQ().elements();
};
this.Rth=function(){
return this.Bqt();
};
this.Bqt=function(){
if(isUndefined(JiU)){
var tJr=this.cgt(this.isg);
if(!isUndefined(tJr)&&tJr!==null){
JiU=
new activelms.Objective(tJr,true,false,kIA,LpN);
}
}
return JiU;
};
this.getObjectiveIfWrittenToBySuspendedActivity=function(wrv)
{
var bRj=this.KsE(wrv);
if(isUndefined(bRj)){return undefined;}
if(!bRj.txf()){return undefined;}
var JBk=hTs.getAvailableActivityList();
var PaW=JBk.length;
var HfH=0;
var bNs=undefined;
var ujq=0;
var mAT=undefined;
var nhi=undefined;
for(var SRI=0;SRI<PaW;SRI++)
{
if(!JBk[SRI].arb()){
continue;
}
bNs=
JBk[SRI].Noq().IEV().getObjectiveSet();
HfH=bNs.length;
for(var olg=0;olg<HfH;olg++)
{
mAT=bNs[olg].ITP();
ujq=mAT.length;
for(var EIf=0;EIf<ujq;EIf++)
{
nhi=mAT[EIf].njR();
if(nhi==wrv){
return bRj;
}
}
}
}
return undefined;
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
return cZn;
};
};
activelms.MMf.prototype=new activelms.DefinitionType();
delete activelms.MMf.prototype.dIX;
activelms.MMf.prototype.constructor=activelms.MMf;
activelms.MMf.factory=function(sBs){return new activelms.MMf(sBs);};
activelms.Objective=function(dIX,kpo,kWC,kIA,LpN){
this.jOU="objectiveID";
this.ODR="objectiveProgressInfo";
this.IaW="mapInfo";
this.vsa=undefined;
this.qxK=false;
var YRp=false;
var fMQ=undefined;
var iDM=undefined;
var OfU=undefined;
var Wbb=undefined;
var AGY=undefined;
var YoV=undefined;
var iRq=undefined;
var LCX=undefined;
var CEX=undefined;
var LfD=[];
var Nbm=[];
activelms.DefinitionType.call(this,dIX);
this.getObjectiveID=function(){
if(!fMQ&&!YRp){
fMQ=this.getValue(this.jOU,this.vsa);
YRp=true;
}
return fMQ;
};
this.bwu=function(){
return kpo;
};
this.txf=function(){
return kWC;
};
this.RKU=function(){
if(isUndefined(iDM)){
iDM=this.getValue("satisfiedByMeasure",this.qxK);
}
return iDM;
};


this.xIt=function(){
return kpo;
};
this.getObjectiveProgressInfo=function(){
if(!Wbb){
var tJr=this.cgt(this.ODR);
if(kWC){
Wbb=
new activelms.pWu(tJr);
}
else{
this.QiU(false);
Wbb=new activelms.ObjectiveProgressInfo(tJr,LCX,CEX,LfD,Nbm,this.cnV(),this.RKU(),kIA,LpN);
}
}
return Wbb;
};
this.QiU=function(){
if(!AGY){
AGY=[];
var lBU=undefined;
var rvq=undefined;
var WrJ=this.eoW(this.IaW);
if(!isUndefined(WrJ)&&WrJ.length!==0){
var PaW=WrJ.length;
for(var SRI=0;SRI<PaW;SRI++){
lBU=new activelms.Qxf(WrJ[SRI]);
rvq=EmP(lBU);
if(lBU.cTs()){
LCX=rvq;
}
if(lBU.crS()){
CEX=rvq;
}
if(lBU.twX()){
LfD.push(rvq);
}
if(lBU.WHY()){
Nbm.push(rvq);
}
AGY.push(lBU);
}
}
}
return AGY;
};
this.ITP=function(){
if(!YoV){
YoV=[];
var qEw=this.QiU();
var PaW=qEw.length;
for(var SRI=0;SRI<PaW;SRI++){
if(qEw[SRI].twX()||qEw[SRI].WHY()){
YoV.push(qEw[SRI]);
}
}
}
return YoV;
};
this.INf=function(){
if(!iRq){
iRq=[];
var qEw=this.QiU();
var PaW=qEw.length;
for(var SRI=0;SRI<PaW;SRI++){
if(qEw[SRI].cTs()||qEw[SRI].crS()){
iRq.push(qEw[SRI]);
}
}
}
return iRq;
};
this.hasSatisfiedStatusReadMap=function(){
var bMZ=this.INf();
var PaW=bMZ.length
if(PaW==0){
return false;
}
else{
for(var SRI=0;SRI<PaW;SRI++){
if(bMZ[SRI].cTs()){
return true;
}
}
}
return false;
};
this.hasNormalizedMeasureReadMap=function(){
var bMZ=this.INf();
var PaW=bMZ.length
if(PaW==0){
return false;
}
else{
for(var SRI=0;SRI<PaW;SRI++){
if(bMZ[SRI].crS()){
return true;
}
}
}
return false;
};
var EmP=function(lBU){
var nhi=lBU.njR();
var bRj=activelms.GlobalObjectives.KsE(nhi);
if(!bRj){
var Shb=lBU.IoN();
var Qrg=doCreateNewElement("objective","http://www.activelms.com/services/ss",Shb);
doSetAttribute(Qrg,"objectiveID",nhi);
var pxE=doCreateNewElement("objectiveProgressInfo","http://www.activelms.com/services/ss",Shb);
doSetAttribute(pxE,"progressStatus","false");
doSetAttribute(pxE,"satisfiedStatus","false");
doSetAttribute(pxE,"measureStatus","false");
doSetAttribute(pxE,"normalizedMeasure","0.0");
Qrg.appendChild(pxE);
activelms.GlobalObjectives.getElement().appendChild(Qrg);
bRj=activelms.GlobalObjectives.KsE(nhi);
}
return bRj;
};
this.cnV=function(){
if(isUndefined(OfU)){
var NUo=this.cgt("minNormalizedMeasure");
var blY=this.getElementText(NUo);
OfU=parseFloat(blY);
}
if(isNaN(OfU)){
return undefined;
}
return OfU;
};

this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="objectiveID: "+this.getObjectiveID()+"\n";
cZn+="primary objective: "+kpo+"\n";
cZn+="global objective: "+kWC+"\n";
return cZn;
};
};
activelms.Objective.prototype=new activelms.DefinitionType();
delete activelms.Objective.prototype.dIX;
activelms.Objective.prototype.constructor=activelms.Objective;
activelms.Qxf=function(dIX){
this.QOK="targetObjectiveID";
this.oZg="readSatisfiedStatus";
this.Hvc="readNormalizedMeasure";
this.mTk="writeSatisfiedStatus";
this.ZNx="writeNormalizedMeasure";
this.qOB=undefined;
this.QSx=true;
this.suQ=true;
this.VjW=false;
this.vmN=false;
var nhi=undefined;
var ZXn=undefined;
var ASL=undefined;
var bev=undefined;
var YfJ=undefined;
activelms.DefinitionType.call(this,dIX);
this.njR=function(){
if(!nhi){
nhi=this.getValue(this.QOK,this.qOB);
}
return nhi;
};
this.cTs=function(){
if(isUndefined(ZXn)){
ZXn=this.getValue(this.oZg,this.QSx);
}
return ZXn;
};
this.crS=function(){
if(isUndefined(ASL)){
ASL=this.getValue(this.Hvc,this.suQ);
}
return ASL;
};
this.twX=function(){
if(isUndefined(bev)){
bev=this.getValue(this.mTk,this.VjW);
}
return bev;
};
this.WHY=function(){
if(isUndefined(YfJ)){
YfJ=this.getValue(this.ZNx,this.vmN);
}
return YfJ;
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="targetObjectiveID: "+this.njR()+"\n";
cZn+="readSatisfiedStatus: "+this.cTs()+"\n";
cZn+="readNormalizedMeasure: "+this.crS()+"\n";
cZn+="writeSatisfiedStatus: "+this.twX()+"\n";
cZn+="writeNormalizedMeasure: "+this.WHY()+"\n";
return cZn;
};
};
activelms.Qxf.prototype=new activelms.DefinitionType();
delete activelms.Qxf.prototype.dIX;
activelms.Qxf.prototype.constructor=activelms.Qxf;
activelms.pWu=function(dIX){
activelms.DefinitionType.call(this,dIX);
this.init=function(){
this.jbE(false);
this.Tkn(false);
this.Kxe(false);
this.Qpt(0.0000);
}
this.qxK=false;
this.vwg=false;
this.dEt=false;
this.dYJ=false;
this.ROf=0.0;
this.ibS="progressStatus";
this.cjH="satisfiedStatus";
this.tkO="measureStatus";
this.gYT="normalizedMeasure";
this.getProgressStatus=function(){
if(!dIX){return this.vwg;}
return this.getValue(this.ibS,this.vwg);
};
this.jbE=function(VqE){
if(!dIX){return;}
if(typeof(VqE)=="boolean"){
this.tht(dIX,this.ibS,VqE);
}
};
this.getSatisfiedStatus=function(){
if(!dIX){return this.dEt;}
return this.getValue(this.cjH,this.dEt);
};
this.Tkn=function(VqE){
if(!dIX){return;}
if(typeof(VqE)=="boolean"){
this.tht(dIX,this.cjH,VqE);
}
};
this.getMeasureStatus=function(){
if(!dIX){return this.dYJ;}
return this.getValue(this.tkO,this.dYJ);
};
this.Kxe=function(VqE){
if(!dIX){return;}
if(typeof(VqE)=="boolean"){
this.tht(dIX,this.tkO,VqE);
}
};
this.getNormalizedMeasure=function(){
if(!dIX){return this.ROf;}
var x=this.getValue(this.gYT,this.ROf);
return x;
};
this.Qpt=function(rMu){
if(!dIX){return;}
if(isNaN(rMu)){return;}
this.tht(dIX,this.gYT,rMu);
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="progressStatus: "+this.getProgressStatus()+"\n";
cZn+="satisfiedStatus: "+this.getSatisfiedStatus()+"\n";
cZn+="measureStatus: "+this.getMeasureStatus()+"\n";
cZn+="normalizedMeasure: "+this.getNormalizedMeasure()+"\n";
return cZn;
};
};
activelms.pWu.prototype=new activelms.DefinitionType();
delete activelms.pWu.prototype.dIX;
activelms.pWu.prototype.constructor=activelms.pWu;
activelms.ObjectiveProgressInfo=function(dIX,LCX,CEX,LfD,Nbm,OfU,iDM,kIA,LpN){
activelms.DefinitionType.call(this,dIX);
this.vwg=false;
this.dEt=false;
this.dYJ=false;
this.ROf=0.0;
this.ibS="progressStatus";
this.cjH="satisfiedStatus";
this.tkO="measureStatus";
this.gYT="normalizedMeasure";
this.DKD="boolean";
this.CSK=4;
this.init=function(){
this.Jkq(this.vwg);
this.BbO(this.dEt);
this.VrA(this.dYJ);
this.Zxv(this.ROf);
this.tBo(false);
}
this.toC=function(){
return this.getValue(this.ibS,this.vwg);
};
this.QUB=function(){
return this.getValue(this.cjH,this.dEt);
};
this.PVR=function(){
return this.getValue(this.tkO,this.dYJ);
};
this.KZG=function(){
return this.getValue(this.gYT,this.ROf);
};
this.Jkq=function(VqE){
if(typeof(VqE)==this.DKD){
this.tht(dIX,this.ibS,VqE);
}
};
this.BbO=function(VqE){
if(typeof(VqE)==this.DKD){
this.tht(dIX,this.cjH,VqE);
}
};
this.VrA=function(VqE){
if(typeof(VqE)==this.DKD){
this.tht(dIX,this.tkO,VqE);
}
};
this.Zxv=function(tIe){
if(!isNaN(tIe)){

this.tht(dIX,this.gYT,tIe);
}
};
this.getProgressStatus=function(){
var XNF=false;
if(iDM){
var UDa=this.getMeasureStatus();
var tIe=this.getNormalizedMeasure();
var CpO=false;
if(tIe>=OfU){
CpO=true;
}
if(UDa&&CpO){
XNF=true;
}
else if(UDa&&!CpO){
XNF=true;
}
else if(!UDa){
XNF=false;
}
}
else{
XNF=this.toC();
if(!XNF){
if(!isUndefined(LCX)){
XNF=
LCX.getObjectiveProgressInfo().getProgressStatus();
}
}
}
return XNF;
};
this.jbE=function(VqE){
if(!kIA){return;}
if(typeof(VqE)==this.DKD){
this.Jkq(VqE);
if(iDM){
var UDa=this.PVR();
var tIe=this.KZG();
var CpO=false;
if(tIe>=OfU){
CpO=true;
}
if(UDa&&CpO){
VqE=true;
}
else if(!UDa&&CpO){
VqE=true;
}
else if(!UDa){
VqE=false;
}
if(UDa){
var BJU=LfD.length;
var Wbb=undefined;
for(var SRI=0;SRI<BJU;SRI++){
Wbb=LfD[SRI].getObjectiveProgressInfo();
Wbb.jbE(VqE);
}
}
}
else{
if(VqE){
var BJU=LfD.length;
var Wbb=undefined;
for(var SRI=0;SRI<BJU;SRI++){
Wbb=LfD[SRI].getObjectiveProgressInfo();
Wbb.jbE(VqE);
}
}
}
}
};
this.getSatisfiedStatus=function(){
var XNF=false;
if(iDM){
var UDa=this.getMeasureStatus();
var tIe=this.getNormalizedMeasure();
var CpO=false;
if(tIe>=OfU){
CpO=true;
}
if(UDa&&CpO){
XNF=true;
}
else if(!UDa&&CpO){
XNF=false;
}
else if(!UDa){
XNF=false;
}
}
else{
if(!isUndefined(LCX)){
var Wbb=LCX.getObjectiveProgressInfo();
var BSL=Wbb.getProgressStatus();
if(BSL){
XNF=Wbb.getSatisfiedStatus();
}
else{
XNF=this.QUB();
}
}
else{
XNF=this.QUB();
}
}
return XNF;
};
this.Tkn=function(VqE){
if(!kIA){return;}
if(typeof(VqE)==this.DKD){
this.BbO(VqE);
if(iDM){
var UDa=this.getMeasureStatus();
var tIe=this.getNormalizedMeasure();

var CpO=false;
if(tIe>=OfU){
CpO=true;
}
if(UDa&&CpO){
VqE=true;
}
else if(!UDa&&CpO){
VqE=false;
}
else if(!UDa){
VqE=false;
}
if(UDa){
var BJU=LfD.length;
var Wbb=undefined;
for(var SRI=0;SRI<BJU;SRI++){
Wbb=LfD[SRI].getObjectiveProgressInfo();
Wbb.Tkn(VqE);
}
}
}
else{
var TST=this.toC();
if(TST){
var BJU=LfD.length;
var Wbb=undefined;
for(var SRI=0;SRI<BJU;SRI++){
Wbb=LfD[SRI].getObjectiveProgressInfo();
Wbb.Tkn(VqE);
}
}
}
}
};
this.getMeasureStatus=function(){
var XNF=this.PVR();
if(!XNF){
if(!isUndefined(CEX)){
XNF=
CEX.getObjectiveProgressInfo().getMeasureStatus();
}
}
return XNF;
};
this.Kxe=function(VqE){
if(!kIA){return;}
if(typeof(VqE)==this.DKD){
this.VrA(VqE);
if(VqE){
var TfH=Nbm.length;
for(var SRI=0;SRI<TfH;SRI++){
Wbb=Nbm[SRI].getObjectiveProgressInfo();
Wbb.Kxe(VqE);
}
}
}
};
this.getNormalizedMeasure=function(){
var tIe=0.0;
if(!isUndefined(CEX)){
var Wbb=
CEX.getObjectiveProgressInfo();
var nFw=Wbb.getMeasureStatus();
if(nFw){
tIe=Wbb.getNormalizedMeasure();
}
else{
tIe=this.KZG();
}
}
else{
tIe=this.KZG();
}
tIe=parseFloat(tIe);
return tIe;
};
this.Qpt=function(tIe){
if(!kIA){return;}
if(!isNaN(tIe)){
this.Zxv(tIe);
var UDa=this.PVR();
if(UDa){
var TfH=Nbm.length;
for(var SRI=0;SRI<TfH;SRI++){
Wbb=Nbm[SRI].getObjectiveProgressInfo();
Wbb.Qpt(tIe);
}
}

var CpO=false;
if(tIe>=OfU){
CpO=true;
}
if(iDM){
if(UDa&&CpO){
this.jbE(true);
this.Tkn(true);
}
else if(UDa&&!CpO){
this.jbE(true);
this.Tkn(false);
}
else if(!UDa){
this.jbE(false);
this.Tkn(false);
}
}
}
};
this.Tvx=function(){
var TST=this.toC();
var IHc=this.QUB();
var jnE=this.PVR();
var QaO=this.KZG();
var kYt=false;
if(iDM){
var CpO=false;
if(QaO>=OfU){
CpO=true;
}
if(jnE&&CpO){
TST=true;
IHc=true;
}
else if(jnE&&!CpO){
TST=true;
IHc=false;
}
else if(!jnE){
TST=false;
IHc=false;
}
}
if(TST){
var BJU=LfD.length;
var Wbb=undefined;
for(var SRI=0;SRI<BJU;SRI++){
Wbb=LfD[SRI].getObjectiveProgressInfo();
Wbb.jbE(TST);
Wbb.Tkn(IHc);
}
if(BJU>0){
kYt=true;
}
}
if(jnE){
var TfH=Nbm.length;
for(var SRI=0;SRI<TfH;SRI++){
Wbb=Nbm[SRI].getObjectiveProgressInfo();
Wbb.Kxe(jnE);
Wbb.Qpt(QaO);
}
if(TfH>0){
kYt=true;
}
}
if(kYt){
activelms.GlobalObjectives.MWk();
}
};
this.tBo=function(VqE){
if(isUndefined(dIX)){return;}
if(typeof(VqE)=="boolean"){
this.tht(dIX,"recordedInPriorAttempt",VqE);
}
}
this.epa=function(){
if(isUndefined(dIX)){return false;}
return this.getValue("recordedInPriorAttempt",false);
}
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="progressStatus: "+this.getProgressStatus()+"\n";
cZn+="satisfiedStatus: "+this.getSatisfiedStatus()+"\n";
cZn+="measureStatus: "+this.getMeasureStatus()+"\n";
cZn+="normalizedMeasure: "+this.getNormalizedMeasure()+"\n";
return cZn;
};
};
activelms.ObjectiveProgressInfo.prototype=new activelms.DefinitionType();
delete activelms.ObjectiveProgressInfo.prototype.dIX;
activelms.ObjectiveProgressInfo.prototype.constructor=activelms.ObjectiveProgressInfo;
activelms.ActivityProgressInfo=function(dIX,kIA,LpN){
activelms.DefinitionType.call(this,dIX);
this.getProgressStatus=function(){
return this.getValue("progressStatus",false);
};
this.jbE=function(VqE){
if(!kIA){return;}
if(typeof(VqE)=="boolean"){
this.tht(dIX,"progressStatus",VqE);
}
};
this.getAttemptCount=function(){
return this.getValue("attemptCount",0);
};
this.cJr=function(){
if(!kIA){return;}
var PaW=this.getAttemptCount();
if(isNaN(PaW)){
throw new ApplicationException("Current attempt count is undefined");
}
PaW=PaW+1;
this.tht(dIX,"attemptCount",PaW);
LpN.ogQ();
return PaW;
};
this.DGO=function(){
return "";
};
this.ctm=function(){
return "";
};
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="progressStatus: "+this.getProgressStatus()+"\n";
cZn+="attemptCount: "+this.getAttemptCount()+"\n";
cZn+="experiencedDuration: "+this.DGO()+"\n";
cZn+="absoluteDuration: "+this.ctm()+"\n";
return cZn;
};
};
activelms.ActivityProgressInfo.prototype=new activelms.DefinitionType();
delete activelms.ActivityProgressInfo.prototype.dIX;
activelms.ActivityProgressInfo.prototype.constructor=activelms.ActivityProgressInfo;
activelms.AttemptProgressInfo=function(dIX,kIA,LpN){
activelms.DefinitionType.call(this,dIX);
this.init=function(){
this.jbE(false);
this.PRS(false);
this.WSJ(0.0);
this.tBo(false);
};
this.getProgressStatus=function(){
if(!dIX){return false;}
return this.getValue("progressStatus",false);
};
this.jbE=function(VqE){
if(!kIA){return;}
if(!dIX){return;}
if(typeof(VqE)=="boolean"){
this.tht(dIX,"progressStatus",VqE);
}
};
this.getCompletionStatus=function(){
if(!dIX){return false;}
return this.getValue("completionStatus",false);
};
this.PRS=function(VqE){
if(!kIA){return;}
if(!dIX){return;}
if(typeof(VqE)=="boolean"){
this.tht(dIX,"completionStatus",VqE);
}
};
this.puG=function(){
if(!dIX){return 0.0;}
return this.getValue("completionAmount",0.0);
};
this.WSJ=function(rMu){
if(!kIA){return;}
if(!dIX){return;}
if(isNaN(rMu)){return;}
this.tht(dIX,"completionAmount",rMu);
};
this.tBo=function(VqE){
if(!dIX){return;}
if(typeof(VqE)=="boolean"){
this.tht(dIX,"recordedInPriorAttempt",VqE);
}
}
this.epa=function(){
if(!dIX){return false;}
return this.getValue("recordedInPriorAttempt",false);
}
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
cZn+="progressStatus: "+this.getProgressStatus()+"\n";
cZn+="completionStatus: "+this.getCompletionStatus()+"\n";
cZn+="completionAmount: "+this.puG()+"\n";
return cZn;
};
};
activelms.AttemptProgressInfo.prototype=new activelms.DefinitionType();
delete activelms.AttemptProgressInfo.prototype.dIX;
activelms.AttemptProgressInfo.prototype.constructor=activelms.AttemptProgressInfo;
var activelms;
if(!activelms){activelms={};}
else if(typeof activelms!="object"){throw new Error("namepsace activelms exists");}
if(activelms.XuO){throw new Error("namepsace activelms.UtilityBehaviour exists");}
activelms.XuO=function(){
var Epw=new activelms.Epw();
var srp=new activelms.srp();
var xYu=new activelms.xYu();
var icx=new activelms.icx();
activelms.srp.call(this);
this.lSP=function(LpN){
if(isUndefined(this.hTs)||this.hTs===null){
throw new ApplicationException("Activity tree not defined for limit conditions check.");
}
log.debug("UP.1.1");
var kIA=LpN.Noq().LVt().SPO();
if(!kIA){
log.debug("UP.1.1.1");
return false;
}
if(LpN.isActive()||LpN.arb()){
log.debug("UP.1.2.1");
return false;
}
var hEr=LpN.getActivityProgressInfo();
var FOP=LpN.getAttemptProgressInfo();
var JiU=LpN.Noq().IEV().Bqt();
var Wbb=JiU.getObjectiveProgressInfo();
var IvD=LpN.Noq().nBU();
log.debug("UP.1.3.1.1");
var IDM=IvD.evaluate(hEr,FOP,Wbb);
return IDM;
};
this.axA=function(LpN,SOK){
if(this.MDv){return;}
var wdm;
var ULH=
LpN.Noq().auo().maK(SOK);
if(!isUndefined(ULH)&&ULH.length&&ULH.length>0){
log.debug("UP.2.1.1");
var EVZ=undefined;
var PaW=ULH.length;
for(var SRI=0;SRI<PaW;SRI++){
EVZ=this.EeJ(LpN,ULH[SRI]);
if(EVZ==icx.RBX){
wdm=ULH[SRI].mpP();
break;
}
}
}
log.debug("UP.2.2");
return wdm;
};
this.EeJ=
function(LpN,Heh){
var VQr=true;
var xNh=true;
var tvu=LpN.Noq();
var kIA=tvu.LVt().SPO();
return this.sVX(LpN,Heh,srp.TfM,VQr,xNh,kIA,this.hTs.getScormVersion());
};
this.wIN=function(LpN){
if(isUndefined(this.hTs)||this.hTs===null){
throw new ApplicationException("Activity tree not defined for terminate descendent attempts.");
}
var BGn=this.hTs.getCurrentActivity();
var CQx=this.hTs.YrQ(BGn,LpN);
var otW=this.hTs.WLw(BGn,CQx);
if(!isUndefined(otW)&&otW.length&&otW.length>0){
if(otW.length>0){
otW.shift();
}
if(otW.length>0){
otW.pop();
}
var PaW=otW.length;
if(PaW>0){
for(var SRI=0;SRI<PaW;SRI++){
this.VsJ(otW[SRI]);
}
}
}
};
this.VsJ=function(LpN){
var tvu=LpN.Noq();
var kIA=tvu.LVt().SPO();
if(LpN.isSco()){
if(kIA){
LpN.CTx(this.hTs);
}
}
if(LpN.isLeaf()){
log.debug("UP.4.1.1");
if(kIA){
if(!LpN.arb()){
var nro=
tvu.LVt().Jsn();
if(!nro){
log.debug("UP.4.1.1.1.1");
var FOP=
LpN.getAttemptProgressInfo();
if(!FOP.getProgressStatus()){
FOP.jbE(true);
FOP.PRS(true);
}
}

var DqV=
tvu.LVt().gHh();
if(!DqV){
log.debug("UP.4.1.1.1.2");
var Mwd=tvu.IEV();
var RKH=Mwd.getObjectiveSet();
var SRI=RKH.length-1;
var bRj;
var Wbb;
do{
bRj=RKH[SRI];
if(bRj.xIt()){
Wbb=
bRj.getObjectiveProgressInfo();
if(!Wbb.getProgressStatus()){
Wbb.jbE(true);
Wbb.Tkn(true);
}
}--SRI;
}
while(SRI>=0);
}
}
}
}
else{
var ACF=false;
var Zas=LpN.getAvailableChildren();
var SRI=Zas.length-1;
var GKg;
do{
GKg=Zas[SRI];
if(GKg.arb()){
ACF=true;
break;
}--SRI;
}
while(SRI>=0);
LpN.VYR(ACF);
}
LpN.setActive(false);
log.debug("UP.4.4");
if(kIA){
var RKH=tvu.IEV().getObjectiveSet();
var PaW=RKH.length;
var Wbb=undefined;
for(var SRI=0;SRI<PaW;SRI++){
var dYw=undefined;
Wbb=RKH[SRI].getObjectiveProgressInfo();
Wbb.Tvx(dYw);
}
}
var boh=new activelms.LpO();
boh.cjg(this.hTs);
boh.JMQ(LpN);
};
this.Ihh=function(LpN){
var SOK=[icx.uDj];
log.debug("UP.5.1");
var Vjj=this.axA(LpN,SOK,this.MDv);
if(!isUndefined(Vjj)){
log.debug("UP.5.2.1");
return true;
}
log.debug("UP.5.3");
var IDM=this.lSP(LpN);
if(IDM){
log.debug("UP.5.4.1");
return true;
}
log.debug("UP.5.5");
return false;
};
this.oOc=function(LpN){
if(LpN.hasAvailableChildren()){
var mJn=LpN.getAvailableChildren();
var PaW=mJn.length;
var Wbb;
for(var SRI=0;SRI<PaW;SRI++){
Wbb=mJn[SRI].getObjectiveProgressInfo();
Wbb.tBo(true);
}
}
}
this.SFK=function(LpN){
if(LpN.hasAvailableChildren()){
var mJn=LpN.getAvailableChildren();
var PaW=mJn.length;
var GiF;
for(var SRI=0;SRI<PaW;SRI++){
GiF=mJn[SRI].getAttemptProgressInfo();
GiF.tBo(true);
}
}
}
this.toString=function(){
var cZn="Type: "+typeof(this)+"\n";
return cZn;
};
};
activelms.XuO.prototype=new activelms.srp();
activelms.XuO.prototype.constructor=activelms.XuO;
