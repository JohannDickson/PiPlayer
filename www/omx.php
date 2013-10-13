<?php

$command = $_REQUEST['command'];
$resource = $_REQUEST['resource'];

switch($command){
	case "play":
		$cmd = 'omxplayer -o hdmi "'.$resource.'"';
		exec($cmd);
		break;

	case "stop":
		$out = shell_exec("ps aux |grep omxplayer.bin |grep -v grep").trim();
		$vars = preg_split("/\s+/", $out);
		echo shell_exec("kill ".$vars[1]);
		break;
}
?>
