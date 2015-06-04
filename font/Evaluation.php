<?php
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
session_start(); 
//check if it is login user
if (isset($_SESSION['UserID']) AND isset($_SESSION['Role'])){
	if($_SESSION['UserID']=="" OR $_SESSION['Role']=="") {
		header("location: ../logout.php");
	}
}else{
	header("location: ../logout.php");
}	
	
//check if access right is correct
if(($_SESSION['Role']=="MOE" OR $_SESSION['Role']=="MCYS") OR $_SESSION['Role']=="Administrator") {
}else{
	header('Location: ../noaccess.html');
}

if (isset($_REQUEST['type'])){
	$prev_type = $_REQUEST['type'];
}else{
	if($_SESSION['Role']=="MOE" OR $_SESSION['Role']=="Administrator") {
		if (!($_SESSION["SelectPStype"]=="")){
			$prev_type=$_SESSION["SelectPStype"];
		}else{
			$prev_type = "Kindergarten";
		}
	}else{
		$prev_type = "Childcare";
	}
}
if (isset($_REQUEST['status'])){
	$prev_status = $_REQUEST['status'];
}else{
	if (!($_SESSION["SelectStatus"]=="")){
		$prev_status=$_SESSION["SelectStatus"];
	}else{
		$prev_status = "InProgress";
	}	
}
if (isset($_REQUEST['prev_psid'])){
	$prev_psid = $_REQUEST['prev_psid'];
	if ($prev_psid=='' || $prev_psid=='0')
	{ $prev_psid = "0"; }
}else{
	$prev_psid = "0";
}
if ($prev_psid=="0"){
	if (!($_SESSION["SelectPSID"]=="0" OR $_SESSION["SelectPSID"]=="")){
		$prev_psid=$_SESSION["SelectPSID"];
	}
}

include("../db/config.php");
include("../db/mysql.lib.php");
$obj=new connect;
$obj->query("SET NAMES 'UTF8'"); 
$obj2=new connect;
$obj2->query("SET NAMES 'UTF8'"); 
include("../db/escapesequence.php");

// get the lates submit id or the selected status submit id
$sqlchk = "select cri7submission.*, cri7journal.JLID, cri7journal.Remarks from cri7submission left outer join cri7journal on (cri7journal.SubmitID=cri7submission.SubmitID and EvalFlag=1) where cri7submission.PSID='$prev_psid' ". ($prev_status=="All"?"":"and cri7submission.Status='$prev_status'") . " order by DateStart desc limit 0,1";
$obj->query($sqlchk);
$subid = "0";
$xstatusx="";
$msgcmtx = "";
$xcompleteelx = "0";
$jlidx = "0";
$evadate = "";
$evaname = "";
if ($row=$obj->query_fetch(0)) {
	$subid = $row["SubmitID"];
	$xstatusx=$row["Status"];
	$jlidx = ($row["JLID"]==null?"":$row["JLID"]);
	$xcompleteelx = ($row["CompletedEvaluation"]==null?"0":$row["CompletedEvaluation"]);
	$msgcmtx = (htmlspecialchars_decode($row["Remarks"]));
	$evadate = ($row["DateEva"]==null?"":date('d-m-Y h:i a',strtotime($row["DateEva"])));
	$evaname = $row["EvaName"];
}
$sqlhead = "Select cri7evaluationlist.*, cri7evaluatelistref.SubHeaderNo, cri7evaluatelistref.SubHeader, cri7evaluatelistref.ItemNo, cri7evaluatelistref.ItemDescription from cri7evaluationlist left outer join cri7evaluatelistref on cri7evaluatelistref.ELRID=cri7evaluationlist.ELRID where cri7evaluationlist.SubmitID='$subid' AND cri7evaluationlist.PSID='$prev_psid' group by SubHeaderNo order by SubHeaderNo*1.0 asc, SubHeaderNo asc, ItemNo*1.0 asc, ItemNo asc";

$sqlitem = "Select cri7evaluationlist.*, cri7evaluatelistref.SubHeaderNo, cri7evaluatelistref.SubHeader, cri7evaluatelistref.ItemNo, cri7evaluatelistref.ItemDescription from cri7evaluationlist left outer join cri7evaluatelistref on cri7evaluatelistref.ELRID=cri7evaluationlist.ELRID where cri7evaluationlist.SubmitID='$subid' AND cri7evaluationlist.PSID='$prev_psid' order by SubHeaderNo*1.0 asc, SubHeaderNo asc, ItemNo*1.0 asc, ItemNo asc";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPARK</title>
<link rel="stylesheet" type="text/css" media="screen" href="../jquery/css/custom-theme/jquery-ui-1.8.18.custom.css" />
<script src="../jquery/js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="../jquery/development-bundle/ui/jquery-ui-1.8.18.custom.js" type="text/javascript"></script>
<script src="../jquery/ckeditor/ckeditor.js" type="text/javascript"></script>
<link rel="stylesheet" href="uploadify.css" type="text/css" />
<script type="text/javascript" src="../jquery/js/jquery.uploadify.js"></script>

<style type="text/css">
<!--

body {
	background:url(../images/main_02.gif) no-repeat;
	background-color: #ffffff;
	bgproperties: fixed;
	font-family: Trebuchet MS;
	font-size: 90%;
}
.ui-jqgrid tr.jqgrow td {
    white-space: normal !important;
    height:auto;
    vertical-align:text-top;
    padding-top:2px;
} 
.postf1c {
	padding: 10px;
	overflow: visible;
	position: absolute;
	height: 33px;
	width: 846px;
	left: 0px;
	top: 0px;	/*right: 500px;*/	/*bottom: 408px;*/	/*background: url(images/img08.gif) repeat-y;*/
}
.postf2c {
	padding: 10px;
	overflow: visible;
	position: absolute;
	height: 385px;
	width: 239px;
	left: 0px;
	top: 48px;	/*right: 500px;*/	/*bottom: 408px;*/	/*background: url(images/img08.gif) repeat-y;*/
}

a.noshowhover:link, a.noshowhover:visited {
	color			: #2861a4;
	font-size		: 11px;
	font-family: Arial,sans-serif;
	text-decoration:none;
}
a.noshowhover:hover {
	color			: #2861a4;
	font-family: Arial,sans-serif;
	text-decoration:none;
}

.sessions2 {
	border-collapse: collapse;
	margin: 10px 0px;
	width: 960px;
}
.sessions2 p {
	margin: 0px;
}
.sessions2 th, .sessions2 td{
	border: 1px solid #fff;
}

.sessions2 th, .sessions2 td.footer{
	background-color: #a0008b;
	color: #fff;
}

.sessions2 th {
	padding: 5px;
}
.sessions2 td {
	background-color: #f9d8e4;
	padding: 5px;
}
.sessions2 td.links {
	background-color: #fff;
	font: 10px Arial;
	padding: 3px;
}
.sessions2 td.links a:link, .sessions2 td.links a:visited {
	color: #666;
	text-decoration: none;
	font-size: 10px;
}

.sessions2 a:link, .sessions2 a:visited {
	color: #a0008b;
	text-decoration: none;
	font-size: 12px;
	font-weight: bold;
}
.sessions2 a:hover {
	color: #ff0000;
	text-decoration: none;
	font-size: 12px;
}

.sessions2 ul {
	list-style-type: none;
}

div.editable
{
	border: solid 1px Transparent;
	padding-left: 3px;
	padding-right: 3px;
}

.expt, a.expt:link, a.expt:visited {
    display:block; /* or inline-block */
    width: 105px; padding: 7px 0; text-align:center;    
    background:#880000; border-bottom:1px solid #ddd;color:#fff;
	text-decoration: none;
	font-weight:550;
}	
a.expt:hover {
	background:#cc0000;
	text-decoration: none;
}

.sessions3 th, .sessions3 td {
	border: 1px solid #f9d8e4;
}

-->
</style>
<script type="text/javascript">
<!--
var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera",
			versionSearch: "Version"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			   string: navigator.userAgent,
			   subString: "iPad",
			   identity: "iPad"
	    },
		{
			   string: navigator.userAgent,
			   subString: "Android 2.",
			   identity: "Android 2"
	    },
		{
			   string: navigator.userAgent,
			   subString: "Android 3.",
			   identity: "Android 3"
	    },
		{
			   string: navigator.userAgent,
			   subString: "Android 4.",
			   identity: "Android 4"
	    },
		{
			   string: navigator.userAgent,
			   subString: "Android",
			   identity: "Android"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
-->
</script>
<script type= "text/javascript">
/*<![CDATA[*/
var editor1;
$(document).ready(function(){
<?php if ($xstatusx=="InProgress" AND ($_SESSION['Role']=="MOE" OR $_SESSION['Role']=="Administrator") AND ($_SESSION['PSType']=="OfficerC1-C7" OR $_SESSION['PSType']=="OfficerC7")  ) {
		$obj2->query($sqlhead);
		$have_upload=0;
		if ($row2=$obj2->query_fetch(0)) {
			$have_upload=1;
		}
		if	($have_upload==1){
 ?>   
		// initialise first then replace with real number
		var queueSize11 = 0;
		BrowserDetect.init();
		if (BrowserDetect.OS == 'Mac' || BrowserDetect.OS == 'Windows' || BrowserDetect.OS == 'Linux' || BrowserDetect.OS == 'Android 3' || BrowserDetect.OS == 'Android 4'){
			queueSize11 = 0;
			$('#fileUpload11').fileUpload({ 
				'uploader': 'uploader.swf',
				'cancelImg': 'cancel.png',
				'script': 'uploadfileTeacherP.php',
				'folder': 'uploads',
				'fileDesc': 'Excel Files',
				'fileExt': '*.xls',
				'multi': false,
				'buttonText': 'Upload File',
				'auto': true,
				'scriptData':{'id':'<?php echo $prev_psid; ?>'},
				onComplete: function (event, ID, fileObj, response, data) {			
					queueSize11 --;
					ajax1Call('importel.php','psid=<?php echo $prev_psid; ?>&subid=<?php echo $subid; ?>&file='+response,'forAjax',response);  
				}
			});
		}else{
			$('#fileUpload11').html("This OS/Browser does not support file upload.");
		}	  
		
<?php 	}
	} ?>

  	// update the chkbox of the completion of evaluation
	$('input[name=elchk]').attr('checked', <?php echo ($xcompleteelx=="0"?"false":"true"); ?>);

});/*]]>*/


function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function ajaxCall(urlx,datax,divx) {
	// do something then refresh selection settings
	$.ajax({
		type:	'POST',
		url:	urlx,
		data:	datax,
		dataType:	'html',
		timeout:	550000,
		success: function(data){
			$("#"+divx).html(data);
			},
		error: function(o,s,e){
			//window.location = urlx;
			}
	});
};

function ajax1Call(urlx,datax,divx,filex) {
	// do something then refresh selection settings
	$.ajax({
		type:	'POST',
		url:	urlx,
		data:	datax,
		dataType:	'html',
		timeout:	550000,
		success: function(data){
			if(data=="OK"){
				// remove file after importing and updating data
				ajaxCall('removefile.php',"file="+filex,'')
				// also to reload screen with new data
				refresh_grid();
			}else{
				// remove file after importing and updating data
				ajaxCall('removefile.php',"file="+filex,'')
				$("#"+divx).html(data);
			}	
		},
		error: function(o,s,e){
			//window.location = urlx;
		}
	});
};

function ajax3Call(urlx,datax,divx) {
	// do something then refresh selection settings
	$.ajax({
		type:	'POST',
		url:	urlx,
		data:	datax,
		dataType:	'html',
		timeout:	550000,
		success: function(data){
			$("#"+divx).html(data);
			},
		error: function(o,s,e){
			//window.location = urlx;
			}
	});
};
function ajax4Call(urlx,datax,divx) {
	// do something then refresh selection settings
	$.ajax({
		type:	'POST',
		url:	urlx,
		data:	datax,
		dataType:	'html',
		timeout:	550000,
		success: function(data){
			$("#"+divx).html(data);
				ajax3Call("Feedbacklog.php","mode=EL&psid=<?php echo $prev_psid; ?>&subid="+<?php echo $subid; ?>,"forLog");
				addContent("Log","1");
			},
		error: function(o,s,e){
			//window.location = urlx;
			}
	});
};

function init_table() {
	var type="<?php echo $prev_type; ?>";
	var status="<?php echo $prev_status; ?>";
	var prev_psid="<?php echo $prev_psid; ?>";
	ajaxCall("SearchPS.php","type="+type+"&status="+status+"&prev_psid="+prev_psid,"showTable1");
	ajax3Call("Feedbacklog.php","mode=EL&psid="+prev_psid+"&subid="+<?php echo $subid; ?>,"forLog");
}

function togglechkbx(ax,bx,idx){
	if (bx=="1"){
		$('input[name=chk'+ax+'2]').attr('checked', false);
		$('input[name=chk'+ax+'3]').attr('checked', false);
	}else{
		if (bx=="2"){
			$('input[name=chk'+ax+'1]').attr('checked', false);
			$('input[name=chk'+ax+'3]').attr('checked', false);
		}else{
			if (bx=="3"){
				$('input[name=chk'+ax+'1]').attr('checked', false);
				$('input[name=chk'+ax+'2]').attr('checked', false);
			}	
		}	
	}	
	saveinfo('chk',idx,ax);
	
}

function saveinfo(typex,idx,ref){
	var chk1=""
	if (document.getElementById("chk"+ref+"1")){
		if (document.getElementById("chk"+ref+"1").checked==true) chk1="null";
	}
	if (document.getElementById("chk"+ref+"2")){
		if (document.getElementById("chk"+ref+"2").checked==true) chk1="1";
	}
	if (document.getElementById("chk"+ref+"3")){
		if (document.getElementById("chk"+ref+"3").checked==true) chk1="0";
	}

	var xidx = "";
	if (document.getElementById("idnox")){
		xidx=document.getElementById("idnox").value;
	}

	var gotmsg="0";
	var msg="";
	if (typex=="rmk"){
		if ( editor2 ){
			// hack way of checking that the save button is the same as the open editor
			// bec open editor will have <span id="cke_ appearing always
			//alert(document.getElementById( 'div'+ref ).innerHTML);
			//if (document.getElementById( 'div'+ref ).innerHTML.substring(0,14)=='<SPAN style="W' || document.getElementById( 'div'+ref ).innerHTML.substring(0,14)=='<span id="cke_'){
			if (parseInt(xidx)==parseInt(ref)){
				msg = editor2.getData();
				gotmsg = "1";
				document.getElementById( 'div'+xidx ).innerHTML = msg;
				if(CKEDITOR.instances[editor2]) delete CKEDITOR.instances[editor2]; 
				editor2 = null;
				$("#idnox").val('');
				// hide previous save button
				if (document.getElementById('hid'+xidx )){
					document.getElementById( 'hid'+xidx ).style.display = "none";
				}
			}else{
				alert("Cannot save. Corresponding editor is not open.");
				return false;
			}
		}	
		
		if (gotmsg=="1"){
			msg=encodeURIComponent(msg);
		}
	}

	ajaxCall("Evaluationdb.php","mode=off&type="+typex+"&id="+idx+"&chk1="+chk1+"&gotmsg="+gotmsg+"&msg="+msg,"forAjax");
}

function saveel(){
	if (document.getElementById("elchk")){
		elchk=document.getElementById("elchk").checked;
	}

	ajax1Call("Evaluationdb.php","mode=cel&pid=<?php echo $prev_psid; ?>&sid=<?php echo $subid; ?>&elchk="+elchk,"forAjax")
}

function savecmt(jlidx){
	var gotmsg="0";
	var msg="";
	if ( editor1 ){
		msg = editor1.getData();
		gotmsg = "1";
	}	
	
	if (gotmsg=="1"){
		msg=encodeURIComponent(msg);
	}

	ajaxCall("Evaluationdb.php","mode=cmt&id="+jlidx+"&sid=<?php echo $subid; ?>&pid=<?php echo $prev_psid; ?>&msg="+msg,"forAjax");
}

function savecfm(jlidx){
	ajaxCall("Evaluationdb.php","mode=cfm&id="+jlidx+"&sid=<?php echo $subid; ?>&pid=<?php echo $prev_psid; ?>","forAjax");
}

function update2x(modex,idx,sidx){
	if (modex=="Cancel"){
		addContent('Log','1');
	}else{
		var message
		if ( editor ){
			message = editor.getData();
		}	
		if (message=="") {
			alert("Please specify the Feedback.");
			return false;
		}
		message=encodeURIComponent(message);
	
		ajax4Call("Feedbackdb.php","mode=EL&psid="+idx+"&sid="+sidx+"&msg="+message,"forAjax");
	}	
}

var editor2;
var editor1;
var editor;

function createEditor(idx)
{
	var xidx = "";
	if (document.getElementById("idnox")){
		xidx=document.getElementById("idnox").value;
	}
	
	if ( editor2 ){
		if (!xidx==""){
			document.getElementById( 'div'+xidx ).innerHTML = editor2.getData();
			if(CKEDITOR.instances[editor2]) delete CKEDITOR.instances[editor2]; 
		}
	}	

	//hide previous save button
	if (document.getElementById('hid'+xidx )){
		document.getElementById( 'hid'+xidx ).style.display = "none";
	}
	
	// only show the relevant safe button
	if (document.getElementById('hid'+idx )){
		document.getElementById( 'hid'+idx ).style.display = "block";
	}
	
	var html = document.getElementById( 'div'+idx ).innerHTML;

	// Create a new editor inside the <div id="div"nox>, setting its value to html
	var config = {
			toolbar :
			[
				['Maximize']
			],
			width : '250px'
		};
	document.getElementById( 'div'+idx ).innerHTML = '';
	editor2 = CKEDITOR.appendTo( 'div'+idx, config, html );
	$("#idnox").val(idx);

}


function exportel() {
	window.open("exportel.php?mode=list&psid=<?php echo $prev_psid; ?>&subid=<?php echo $subid; ?>","mywindow","menu=0,location=0,status=0,scrollbars=0,width=100,height=100");
}

function refresh_grid(){
	var type="";
	var status="";
	var prev_psid="0";
	if (document.getElementById("preschool")){
		prev_psid=document.getElementById("preschool").value;
	}
	if (document.getElementById("status")){
		status=document.getElementById("status").value;
	}
	if (document.getElementById("type")){
		type=document.getElementById("type").value;
	}
	//ajax0Call("HCIweakresultget.php","type="+type+"&status="+status+"&prev_psid="+prev_psid,"showTable2");
	location.href = "Evaluation.php?type="+type+"&status="+status+"&prev_psid="+prev_psid;
}

function refresh_data() {
	var type="";
	var status="";
	var prev_psid="0";
	if (document.getElementById("preschool")){
		prev_psid=document.getElementById("preschool").value;
	}
	if (document.getElementById("status")){
		status=document.getElementById("status").value;
	}
	if (document.getElementById("type")){
		type=document.getElementById("type").value;
	}
	ajaxCall("SearchPS.php","mode=list&type="+type+"&status="+status+"&prev_psid="+prev_psid,"showTable1");
	$("#showTable2").html('');
}

function addContent(fieldx,nox) {
	if (fieldx=="Log"){
		$("#ed1").show();
		if ( editor ){
			if(CKEDITOR.instances[editor]) delete CKEDITOR.instances[editor]; 
		}	
		
		if (nox=="0"){
			$("#forAjax").html("<font size='2'>&nbsp;</font>");
			$("#shownew2").show();
			var config = {
					toolbar :
					[
						['Maximize']
					],
					width : '750px'
				};
			document.getElementById( 'div_ed' ).innerHTML = '';
			var html = '';
			editor = CKEDITOR.appendTo( 'div_ed', config, html );
			
		}else{
			$("#shownew2").hide();
		}
	}
}

function getPDF(){
	var type="";
	var status="";
	var prev_psid="0";
	if (document.getElementById("preschool")){
		prev_psid=document.getElementById("preschool").value;
	}
	if (document.getElementById("status")){
		status=document.getElementById("status").value;
	}
	if (document.getElementById("type")){
		type=document.getElementById("type").value;
	}
	window.open("Evaluationpdf.php?mode=getpdf&type="+type+"&status="+status+"&prev_psid="+prev_psid);
}

</script>
</head>

<body onload="init_table(); MM_preloadImages('../images/save_icon.gif');" >

<div id="showTable1" class="postf1c"></div>

<div id="showTable2" class="postf2c">
<div id='forAjax' style="width:500px"><font size='2'>&nbsp;</font></div>
<?php 
if (!($prev_psid=="0" OR $prev_psid=="" OR $prev_psid==null)){
 	echo " <font size='2' color='#000000'>Download:&nbsp;&nbsp;</font>&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='getPDF()' title='Download to PDF'><img src='../images/pdf.gif' height='20' width='20' border='0'/></a>&nbsp;&nbsp;&nbsp;&nbsp;";
?>
  <table width="940" class="sessions2">
<?php
	$obj2->query($sqlhead);
	$nox = 10;
	while ($row2=$obj2->query_fetch(0)) {
		$header=$row2["SubHeader"];
?>	
		<tr>
          <th width="390" colspan="2" rowspan='2' align='left' class="code"><p align="left"><font face="Arial" size="2"><?php echo $header; ?></font></p></th>
          <th width="175" colspan="3" align='center' class="code"><p align="center"><font face="Arial" size="2">Meet Criteria</font></p></th>
          <th width="285" rowspan='2' align='center' class="code"><p align="center"><font face="Arial" size="2">Remarks<input type='hidden' id='idnox' name='idnox' /></font></p></th>
<?php    if (($_SESSION['Role']=="MOE" AND ($_SESSION['PSType']=="OfficerC1-C7" OR $_SESSION['PSType']=="OfficerC7")) OR $_SESSION['Role']=="Administrator"){ ?>
          <th width="20" rowspan='2' align='center' class="code"><p align="center"><font face="Arial" size="2">&nbsp; </font></p></th>
<?php } ?>          
</tr>
		<tr>
          <th width="65" align='center' class="code"><p align="center"><font face="Arial" size="2">Pending</font></p></th>
          <th width="55" align='center' class="code"><p align="center"><font face="Arial" size="2">Yes</font></p></th>
          <th width="55" align='center' class="code"><p align="center"><font face="Arial" size="2">No</font></p></th>
   	</tr>
<?php
		$obj->query($sqlitem);
		while ($row=$obj->query_fetch(0)) {
			$header2=$row["SubHeader"];
			if ($header2===$header){
				$nox = $nox + 1;
				$ansx = $row["ANS"];
				echo "<tr>";
				echo "    <td align='center' width='20'><p><font face='Arial' size='2'>".$row["ItemNo"]."</font></p></td>";
				echo "    <td width='370'><div id='".$nox."'><p><font face='Arial' size='2' class='ttips' >";
				echo (htmlspecialchars_decode($row["ItemDescription"]));
				echo "</font></p></div><img id='loadingDiv".$nox."'  style='display:none' src='loading.gif' /></td>";
				$enableflag = "disabled"; // for checkbox and remarks, only non applicant can edit
				if (($_SESSION['Role']=="MOE" AND ($_SESSION['PSType']=="OfficerC1-C7" OR $_SESSION['PSType']=="OfficerC7")) OR $_SESSION['Role']=="Administrator"){
					$enableflag = "";
				}
	
				echo "    <td align='center'><p><font face='Arial' size='2'><input type='checkbox' id='chk".$nox."1' name='chk".$nox."1' ".($ansx==null?"checked":"")." $enableflag onclick=\"togglechkbx('".$nox."','1','".$row["ELID"]."')\" /></font></p></td>";
				echo "    <td align='center'><p><font face='Arial' size='2'><input type='checkbox' id='chk".$nox."2' name='chk".$nox."2' ".($ansx=="1"?"checked":"")." $enableflag onclick=\"togglechkbx('".$nox."','2','".$row["ELID"]."')\" /></font></p></td>";
				echo "    <td align='center'><p><font face='Arial' size='2'><input type='checkbox' id='chk".$nox."3' name='chk".$nox."3' ".($ansx=="0"?"checked":"")." $enableflag onclick=\"togglechkbx('".$nox."','3','".$row["ELID"]."')\" /></font></p></td>";
	
				echo "    <td align='left'><div id='div".$nox."' class='editable'>".(htmlspecialchars_decode($row["Remarks"]))."</div></td>";
				
				if (($_SESSION['Role']=="MOE" AND ($_SESSION['PSType']=="OfficerC1-C7" OR $_SESSION['PSType']=="OfficerC7")) OR $_SESSION['Role']=="Administrator"){
					echo "    <td align='center'><a href='#' onmouseout='MM_swapImgRestore()' onmouseover=\"MM_swapImage('imga".$nox."','','../images/edit-dn.gif',1)\"><img src='../images/edit.gif' alt='Edit' name='imga".$nox."' width='18' height='18' border='0' id='imga".$nox."' onclick=\"createEditor('".$nox."')\"/></a>&nbsp;<div id='hid".$nox."' name='hid".$nox."' style='display:none'><a href='#' onmouseout='MM_swapImgRestore()' onmouseover=\"MM_swapImage('img".$nox."','','../images/save_icon.gif',1)\"><img src='../images/save.gif' alt='Save' name='img".$nox."' width='16' height='16' border='0' id='img".$nox."' onclick=\"saveinfo('rmk','".$row["ELID"]."','".$nox."')\"/></a></div></td>";
				}
				echo "</tr>";
			}	
		}
	}	
?>
  </table>
    
<?php if ($xstatusx=="InProgress" AND ($_SESSION['Role']=="MOE" OR $_SESSION['Role']=="Administrator") AND ($_SESSION['PSType']=="OfficerC1-C7" OR $_SESSION['PSType']=="OfficerC7")  ) { 
		if ($nox>10){
		// show export import only if evaluation list has been assigned
?>   
        <table width="940" class="sessions2">
        <tr>
        <td width="141" valign="top"><br/>
        <a href="#" onclick="exportel()" class="expt">Export file</a>
        <div id='sampleFile'><div id='fileUpload11'>Either there is a problem with your javascript<br/>or your browser do not support file upload</div></div>    </td><br/>
        <a href="#" onclick="savecfm('<?php echo $jlidx; ?>')" class="expt">Confirm</a>
        </td>
        <td width="779"><p><font size="2">Comment:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id='svchkbx' <?php  if ($_SESSION['PSType']=="Viewer" OR $_SESSION['Role']=="MCYS" ) echo "style='display:none'"; ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' id='elchk' name='elchk' onclick='saveel()'/>&nbsp;Completed Evaluation</p></font></span><br/> <textarea cols="40" id="msgcmt" name="msgcmt" rows="5"><?php echo $msgcmtx; ?></textarea></font></p></td>
        <td width="20" align="center"><a href='#' onmouseout='MM_swapImgRestore()' onmouseover="MM_swapImage('sav1','','../images/save_icon.gif',1)"><img src='../images/save.gif' alt='Save' name='sav1' width='16' height='16' border='0' id='sav1' onclick="savecmt('<?php echo $jlidx; ?>')"/></a></td>
        </table>
    <script type= "text/javascript">
        editor1 = CKEDITOR.replace('msgcmt',
            {
                toolbar :
                [
                    ['Bold', 'Italic', 'Underline','-', 'Maximize']
                ],
                width : '770px'
            });
    
     </script>  
<?php 
		}
	}else{
		if (!$prev_psid=="0"){ ?>    
            <table width="940" class="sessions2">
            <tr>
            <td width="141" valign="top">
            </td>
            <td width="779"><p><font size="2"><?php echo $msgcmtx; ?></font></p></td>
            <td width="20" align="center"></td>
            </table>
	
<?php 	}
	} ?>    

<?php if (strlen(trim($evaname))>0){
	echo "<table width='940' class='sessions2'><tr><td>Last confirmation by: $evaname - $evadate </td></tr></table>";
	}
?>	

	<?php	if ((($_SESSION['PSType']=="OfficerC1-C7" OR $_SESSION['PSType']=="OfficerC7") AND $_SESSION['Role']=="MOE") OR $_SESSION['Role']=="Administrator"){ ?>
  	<table width="800" >
    <tr>
    <td width=100% align="center">
    	<fieldset><legend><font size='2' color='#000000'><b>Add Feedback&nbsp;<a href="#" class='noshowhover' onclick="addContent('Log','0'); return false;" title="Click to add new feedback">[+]</a></b></font></legend>
        <span id='shownew2' style="display:none">
    	<table width="500">
			<tr>
				<td colspan'4'><div id='ed1' style="display:none"><div id='div_ed' class='editable'></div></div></td>
            </tr>
            <tr><td colspan'4'>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center"><input type='button' id='it2add' value='Add' onclick="update2x('Add','<?php echo $prev_psid; ?>','<?php echo $subid; ?>')" /><input type='button' id='it2cancel' value='Cancel' onclick="update2x('Cancel','0','0')"/></td>
            </tr>
        </table>
        </span>
        </fieldset>
    </td>
    </table>
	<?php } ?>  
	<div id='forLog'></div>

<?php } ?>
</div>
<br/>
</body>
</html>
