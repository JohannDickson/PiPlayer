<?php

$command = $_REQUEST['command'];
$resource = $_REQUEST['resource'];

$omxFifo = "omxFifo";

$hdmi = true;
$noGhostBox = true;
$backgroundBlank = true;


function createFifo(){
	global $omxFifo;
	posix_mkfifo($omxFifo, 0644);
}

function checkFifo(){
	global $omxFifo;
	if (file_exists($omxFifo)){
		system("test -p ${omxFifo}\n", $isFifo);
		if ($isFifo != 0){
			unlink($omxFifo);
			createFifo();
		}
	} else {
		createFifo();
	}
}

function play($resource){
	global $omxFifo, $hdmi, $noGhostBox, $backgroundBlank;

	exec('pgrep omxplayer.bin', $pid);
	if ( empty($pid) ) {
		checkFifo();
		$opts = (
			($hdmi?"-o hdmi":"-o local").
			' '.
			($noGhostBox?"--no-ghost-box":'').
			' '.
			($backgroundBlank?"-b":'').
			' '
			);
		$cmd = "omxplayer ${opts} \"${resource}\" < ${omxFifo} &";
		$launchPlayer = "sleep 1 && echo -n . > ${omxFifo} &";
		exec($cmd." ".$launchPlayer);
		echo "playing: ".$resource;
	} else {
		echo "omxplayer is already runnning (".$pid[0].")";
	}
}

switch($command){
	case "stream":
		echo "Streaming resource ${resource}";
		$cmd = "youtube-dl -g ${resource}";
		$stream_url = exec($cmd);
		echo "STREAM: ${stream_url}";
		play($stream_url);
		break;

	case "play":
		play($resource);
		break;

	case "pause":
		exec("echo -n \"p\" > ${omxFifo}");
		break;

	case "stop":
		exec("echo -n \"q\" > ${omxFifo}");
		exec("rm ${omxFifo}");
		break;

	case "vol+":
		exec("echo -n \"+\" > ${omxFifo}");
		break;

	case "vol-":
		exec("echo -n \"-\" > ${omxFifo}");
		break;

	case "t+30":
		exec("echo -n \"\x1b\x5b\x43\" > ${omxFifo}");
		break;

	case "t-30":
		exec("echo -n \"\x1b\x5b\x44\" > ${omxFifo}");
		break;

	case "t+600":
		exec("echo -n \"\x1b\x5b\x41\" > ${omxFifo}");
		break;

	case "t-600":
		exec("echo -n \"\x1b\x5b\x42\" > ${omxFifo}");
		break;

}

?>
