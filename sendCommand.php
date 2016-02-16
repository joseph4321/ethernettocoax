<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/config.inc.php"); ?>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/functions.inc.php"); ?>
<?php

if(isset($_GET["r"])){
	$receiver = $_GET["r"];
}
else{
	print "Could not determine ip address"; exit;
}
if(!verifyIPAddress($receiver)){print "The ip address format is incorrect";exit;}
if(isset($_GET["p1"]){
	$port1 = $_GET["p1"];
	if($port1 < 2 || $port1 > 4000 || $port1 == 12){print "Vlan configuration for port 1 is wrong";exit;}
}
if(isset($_GET["p2"]){
	$port1 = $_GET["p2"];
	if($port1 < 2 || $port1 > 4000 || $port1 == 12){print "Vlan configuration for port 2 is wrong";exit;}
}
if(isset($_GET["p3"]){
	$port1 = $_GET["p3"];
	if($port1 < 2 || $port1 > 4000 || $port1 == 12){print "Vlan configuration for port 3 is wrong";exit;}
}
if(isset($_GET["p4"]){
	$port1 = $_GET["p4"];
	if($port1 < 2 || $port1 > 4000 || $port1 == 12){print "Vlan configuration for port 4 is wrong";exit;}
}

$result = exec("\"" . $EXEC_DIR . "sendCommand.pl\" " . $receiver . " " . $port1 . " " . $port2 . " " . $port3 . " " . $port4);

print $result;

?>