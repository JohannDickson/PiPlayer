<?php

$command = $_REQUEST['command'];
$resource = $_REQUEST['resource'];

switch($command){
	case "play":
		$cmd = 'omxplayer -o hdmi "'.$resource.'"';
		shell_exec($cmd." < omxFifo &");
		shell_exec("sleep 1; echo -n . > omxFifo &");
		break;

	case "pause":
		shell_exec("echo -n \"p\" > omxFifo");
		break;

	case "stop":
		shell_exec("echo -n \"q\" > omxFifo");
		break;
}

?>
