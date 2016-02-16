<?php 

include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/config.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/functions.inc.php");

if(isset($_GET["r"])){
	$receiver = $_GET["r"];
}
else{
	print "Could not determine ip address"; exit;
}
if(!verifyIPAddress($receiver)){print "The ip address format is incorrect";exit;}

$info = "";
$octets = explode(".",$receiver);
if($octets[3] > 20 && $octets[3] < 61){
	$info = system($EXEC_DIR . "sendVlan.pl " . $receiver . " 201 650 650 651");
}
if($octets[3] > 60 && $octets[3] < 101){
	$info = system($EXEC_DIR . "sendVlan.pl " . $receiver . " 203 650 650 651");
}
if($octets[3] > 100 && $octets[3] < 141){
	$info = system($EXEC_DIR . "sendVlan.pl " . $receiver . " 202 650 650 651");
}
		
?>
