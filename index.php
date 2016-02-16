<?php
?>
<?php

$pid = `ps aux|grep mocaEngine.pl|grep -v grep`;
if($pid){
	print "Moca Engine is currently running.  Please try again in a few minutes.";
	exit;
}
?>

<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/config.inc.php");
?>

<?php 
include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/functions.inc.php"); 
?>

<HTML>

<HEAD>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/head.inc.php"); ?>
</HEAD>

<TITLE>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/title.inc.php"); ?>
</TITLE>
<BR>

<BODY ID="body">

<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/logo.inc.php"); ?>

<BR><BR>
<CENTER><H2>Note: If you move and/or remove an ap, inform networking.</H2></CENTER><BR>
<TABLE WIDTH="50%" ALIGN="CENTER" STYLE="font-size:12px">
<TR>
<TD WIDTH="100%">
<SPAN STYLE="background-color:f08080">&nbsp;&nbsp;&nbsp;&nbsp;</SPAN>&nbsp;&nbsp;AP was unreachable&nbsp;&nbsp;&nbsp;&nbsp;
<SPAN STYLE="background-color:yellow">&nbsp;&nbsp;&nbsp;&nbsp;</SPAN>&nbsp;&nbsp;Too many CPE's
</TD>
</TR>
</TABLE>
<TABLE CLASS="sortable" WIDTH="50%" ALIGN="CENTER" STYLE="font-size:12px;border-style:solid;border-width:1px;border-color:black">
<?php

print "\t\t<TR STYLE=\"font-weight:bold\">\n";
$columnHeaders = array("IP","Devices (Room) (Signal)","Location","Frequency","Actions");
$widths = array(20,30,15,15,20);
for($i=0;$i<count($columnHeaders);$i++){
	print "<TH WIDTH=\"" . $widths[$i] . "\">".$columnHeaders[$i]."</TH>";
}
print "\t\t</TR>\n";

$data = file_get_contents($STATUS_FILE);
$sdata = explode("\n",$data);
$data1 = file_get_contents("/home/tang/moca/rooms2.csv");
$sdata1 = explode("\n",$data1);
$totalCount = 0;
for($i=0; $i < count($sdata); $i++){
	$dataArr = explode(",",$sdata[$i]);
	$tmpDevices = explode("|",$dataArr[3]);
	$tmpValues = explode("|",$dataArr[5]);
	$numDevices = count($tmpDevices);	

	// data
	if($numDevices > 7){
		print "\t\t<TR BGCOLOR=\"yellow\" onmouseover='this.style.backgroundColor=\"bcbcbc\"' onmouseout='this.style.backgroundColor=\"yellow\"'>\n";
	}
	else{
		print "\t\t<TR BGCOLOR=\"white\" onmouseover='this.style.backgroundColor=\"bcbcbc\"' onmouseout='this.style.backgroundColor=\"FFFFFF\"'>\n";
	}
	//print "\t\t\t<TD ALIGN=\"CENTER\"><IMG SRC=\"images/status_" . (($dataArr[1] == 0) ? "green.png":"red.png") . "\"></TD>\n";
	//print "\t\t\t<TD ID=\"ip_".$i."\" ALIGN=\"CENTER\">" . $dataArr[0] . "</TD>\n";
	if($dataArr[1] == 0){
		#print "\t\t\t<TD ID=\"ip_".$i."\" ALIGN=\"CENTER\">" . $dataArr[0] . "</TD>\n";
		#print "\t\t<TR BGCOLOR=\"white\" onmouseover='this.style.backgroundColor=\"bcbcbc\"' onmouseout='this.style.backgroundColor=\"yellow\"'>\n";
	}
	else{
		#print "\t\t\t<TD ID=\"ip_".$i."\" BGCOLOR=\"#F08080\" ALIGN=\"CENTER\">" . $dataArr[0] . "</TD>\n";
		print "\t\t<TR BGCOLOR=\"#F08080\" onmouseover='this.style.backgroundColor=\"bcbcbc\"' onmouseout='this.style.backgroundColor=\"f08080\"'>\n";
	}
		
	print "\t\t\t<TD ID=\"ip_".$i."\" ALIGN=\"CENTER\">" . $dataArr[0] . "</TD>\n";
	print "\t\t\t<TD ID=\"devices_".$i."\" ALIGN=\"CENTER\" STYLE=\"font-size:10px;\">";
	//if(count($tmpDevices) > 3){
	for($j=0; $j < count($tmpDevices); $j++){
		$totalCount++;
		//if(($j+1) % 4 == 0){ print "<BR>"; }
		//print $tmpDevices[$j] . "&nbsp;&nbsp;&nbsp;&nbsp;";
		//if(strlen($tmpDevices[$j]) < 8){next;}
		//if(strcmp($tmpDevices[$j],"None")==0){next;}
		print $tmpDevices[$j] . "&nbsp;";
	
		for($e=0;$e<count($sdata1);$e++){
			//print "sdata1 is " . $sdata1[$e] . "<BR>\n";
			$adata1="";
			$adata1=explode(",",$sdata1[$e]);
			if(count($adata1)<2){continue;}
			if(strlen($adata1[1])<3){continue;}
			if(strlen($tmpDevices[$j]) < 3){continue;}
			//print "len is " . strlen($tmpDevices[$j]);
			//print "adata1 is " . $adata1[0] . "<BR>\n";
			//print "comparing " . $tmpDevices[$j] . " and " . $adata1[1] . "<BR>\n";
			//$tmpmac = "".$tmpDevices[$j].".*"; rtrim($tmpmac," ");rtrim($adata1[1]," ");
			$tmpmac = "/".$tmpDevices[$j].".*/";
			if(preg_match($tmpmac,$adata1[1])){
				//print "matched " . $tmpmac . " and " . $adata[1] . "<BR>";
				print "(".$adata1[0].")&nbsp;";
				break;
			}
		}
	
		if( $tmpValues[$j] > 240000000 && $tmpValues[$j] < 260000000){
			print "(<SPAN STYLE=\"color:green\">Strong</SPAN>)<BR>";
		}
		else if( $tmpValues[$j] <= 240000000 && $tmpValues[$j] > 180000000){
			print "(<SPAN STYLE=\"color:orange\">Medium</SPAN>)<BR>";
		}
		else if( $tmpValues[$j] <= 180000000 && $tmpValues[$j] > 100000000){
			print "(<SPAN STYLE=\"color:gold\">Weak</SPAN>)<BR>";
		}
		else if( $tmpValues[$j] <= 100000000 && $tmpValues[$j] > 0){
			print "(<SPAN STYLE=\"color:LightCoral\">Horrible</SPAN>)<BR>";
		}
		else{
			if(strlen($tmpDevices[$j]) < 3 || strcmp($tmpDevices[$j],"None") == 0){}
			else{
				print "(Unknown)<BR>";
			}
		}
	}
	print "\t\t\t</TD>";
	//}
	//else{
	//	print "\t\t\t<TD ID=\"devices_".$i."\" ALIGN=\"CENTER\">" . $dataArr[3] . "</TD>\n";
	//}
	print "\t\t\t<TD ID=\"location_".$i."\" ALIGN=\"CENTER\">" . $dataArr[2] . "</TD>\n";
	print "\t\t\t<TD ID=\"frequency_".$i."\" ALIGN=\"CENTER\">" . $dataArr[4] . "</TD>\n";
	
	// actions
	print "\t\t\t<TD ALIGN=\"CENTER\">\n";
	print "<SPAN ID=\"actions_".$i."\">";
	print "<IMG SRC=\"images/ping1.png\" ALT=\"Ping\" TITLE=\"Ping\" WIDTH=\"20px\" HEIGHT=\"20px\" onClick=\"receiverAction('".$i."','ping','".$dataArr[0]."')\">&nbsp;";
	print "<SPAN onClick=\"window.open('getInfo.php?r=".$dataArr[0]."','newWindow','width=400,height=650,scrollbars=1')\"><IMG SRC=\"images/info.png\" ALT=\"Get information on the device\" TITLE=\"Get information on the device\"></SPAN>&nbsp;";
	//if($dataArr[0] == "10.89.44.69" || $dataArr[0] == "10.89.44.70"){}
	//else{
	print "<IMG SRC=\"images/restartstream.png\" ALT=\"Reset device configuration\" TITLE=\"Reset device configuration\" WIDTH=\"20px\" HEIGHT=\"20px\" onClick=\"receiverAction('".$i."','restart','".$dataArr[0]."')\">";
	//}
	print "<IMG SRC=\"images/reboot.png\" ALT=\"Reboot device\" TITLE=\"Reboot device\" WIDTH=\"20px\" HEIGHT=\"20px\" onClick=\"receiverAction('".$i."','reboot','".$dataArr[0] . "')\"></SPAN></TD>\n";
	print "\t\t</TR>\n";
}
print "\t</TABLE>\n";

print "<BR>\n";
print "<CENTER><INPUT TYPE=\"button\" VALUE=\"Start Moca Engine\" onClick=\"startMocaEngine()\"></CENTER>";
?>

</TABLE>
<BR>
<CENTER>

<BR>

</BODY>
</HTML>
