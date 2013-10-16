<?php

$command = $_REQUEST['command'];
$resource = $_REQUEST['resource'];

switch($command){
	case "play":
		$cmd = 'omxplayer -o hdmi "'.$resource.'"';
		exec($cmd." < omxFifo &");
		exec("sleep 1; echo -n . > omxFifo");
		break;

	case "pause":
		exec("echo -n \"p\" > omxFifo");
		break;

	case "stop":
		exec("echo -n \"q\" > omxFifo");
		break;

	case "vol+":
		exec("echo -n \"+\" > omxFifo");
		break;

	case "vol-":
		exec("echo -n \"-\" > omxFifo");
		break;

	case "t+30":
		exec("echo -n \"\x1b\x5b\x43\" > omxFifo");
		break;

	case "t-30":
		exec("echo -n \"\x1b\x5b\x44\" > omxFifo");
		break;

	case "t+600":
		exec("echo -n \"\x1b\x5b\x41\" > omxFifo");
		break;

	case "t-600":
		exec("echo -n \"\x1b\x5b\x42\" > omxFifo");
		break;

}

?>
