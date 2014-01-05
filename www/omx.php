<?php

$command = $_REQUEST['command'];
$resource = $_REQUEST['resource'];

$hdmi = true;

switch($command){
	case "play":
		exec('pgrep omxplayer.bin', $pid);
		if ( empty($pid) ) {
			$opts = ($hdmi?"-o hdmi":"-o local");
			$cmd = "omxplayer $opts \"$resource\" < omxFifo &";
			$launchPlayer = "sleep 1 && echo -n . > omxFifo &";
			exec($cmd." ".$launchPlayer);
			echo "playing: ".$resource;
		} else {
			echo "omxplayer is already runnning (".$pid[0].")";
		}
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
