<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/config.inc.php"); ?>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/functions.inc.php"); ?>

<HTML>

<HEAD>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/head.inc.php"); ?>
</HEAD>

<BODY ID="body">

<?php
if(isset($_GET["r"])){
	$receiver = $_GET["r"];
}
else{
	print "Could not determine ip address"; exit;
}
if(isset($_GET["submit"])){
        $submit = $_GET["submit"];
}

if($submit == 1){
	$patterns[0] = "/\r\n/";
	$patterns[1] = "/,/";
	$patterns[2] = "/</";
	$patterns[3] = "/>/";
	$replacements[0] = "<BR>";
	$replacements[1] = "&#44";
	$replacements[2] = "&lt;";
	$replacements[3] = "&gt;";
	$data = $_POST["newRecordText"];
	$data1 = preg_replace($patterns,$replacements,$data);

	$date = `date`;
	$date1 = rtrim($date,"\x00..\x1F");

	$handle = fopen("/var/www/html/moca/logs/" . $receiver . ".log","a+");
	$buf = $date1 . "," . $data1 . "\n";
	fwrite($handle,$buf);
}


$info = system($EXEC_DIR . "getSystemInfo.pl " . $receiver);

print "<BR><BR>\n";
print "History:<BR>\n";

$data = file_get_contents("/var/www/html/moca/logs/" . $receiver . ".log");

$lines = explode("\n",$data);

for($i=0;$i<count($lines)-1;$i++){
	$tokens = explode(",",$lines[$i]);
	$stringTokens = explode("<BR>",$tokens[1]);
	
	print "&nbsp;&nbsp;&nbsp;&nbsp;<U>Entry " . ($i+1) . " was entered on " . $tokens[0] . "</U><BR>\n";
	for($j=0;$j<count($stringTokens);$j++){
		print $stringTokens[$j] . "<BR>";
	}
	print "<BR><BR>\n";
}

if(count($lines)-1 == 0){
	print "No entries to display<BR>\n";
}
else{
	print "<BR><HR>\n";
}
print "<BR>\n";
print "<FORM NAME=\"input\" ACTION=\"getInfo.php?r=" . $receiver . "&submit=1\" METHOD=\"post\">";
print "Add new entry:<BR>\n";
print "<TEXTAREA ROWS=\"12\" COLS=\"45\" ID=\"newRecordText\" name=\"newRecordText\"></TEXTAREA><BR>\n";
print "<INPUT TYPE=\"submit\" VALUE=\"Submit\">\n<BR>";
print "</FORM>\n";

?>


