<?php 

include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/config.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/moca/inc/functions.inc.php");

$pid = shell_exec( $EXEC_DIR . "startMocaEngine.sh &> /dev/null &");
print "Moca engine was restarted";
?>
