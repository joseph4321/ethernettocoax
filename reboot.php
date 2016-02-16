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

$result = system("\"" . $EXEC_DIR . "reboot.pl\" " . $receiver);
if(preg_match("/rebooting/",$result)){
}
else{
	print "[-] There was an error rebooting the device";
}

?>
