<?php

$videoRoot = "/home/user/Public/Videos";
$db = "./db.json";
$handler = fopen($db, 'r');
$raw = json_decode(fgets($handler));
fclose($handler);

$indent = 0;
$videoPath = $videoRoot;
$base_dir = "base_dir";		// Use same as in listVideos.py

function list_files($tree){
	global $indent, $videoPath, $base_dir;
	$myIndent = $indent;
	$myPath = $videoPath;

	$idt = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $myIndent);
	foreach ($tree as $key => $val){
		if ($key == "files"){
			foreach ($val as $file){
				$filePath = "$myPath/$file";
				$filePath = str_replace("$base_dir/", '', $filePath);
				echo $idt."<a href=\"#$file\" onclick=\"omxPlay('".addslashes($filePath)."')\">$file</a><br />";
			}
		} else {
			echo "<p>".(($key == $base_dir)?'':"<b>${idt}${key}</b><br />");
			$indent++;
			$videoPath .= "/$key";
			list_files($val);
			echo "</p>";
		}
		$videoPath = $myPath;
		$indent = $myIndent;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/screen.css" media="screen"/>

	<title>Raspberry Player</title>

	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
		function omxPlay(resource){
			$.ajax("omx.php",
			{
				type: "POST",
				data: {
					command: "play",
					resource: resource
				}
			});
		}

		function omxCmd(cmd){
			$.ajax("omx.php",
			{
				type: "POST",
				data: {
					command: cmd
				}
			});
		}
	</script>

</head>
<body>
	<div id="omxControls">
		<a href="#omxPause" onclick="omxCmd('pause')" class="omxCmd">
			<img src="img/pause.png" class="invert vertCenter"/>
			Pause
		</a>
		<a href="#omxStop" onclick="omxCmd('stop')" class="omxCmd">
			<img src="img/stop.png" class="invert vertCenter"/>
			Stop
		</a>

		<a href="#omxVol-" onclick="omxCmd('vol-')" class="omxCmd">
			<img src="img/vol-.png" class="invert vertCenter"/>
			vol-
		</a>
		<a href="#omxVol+" onclick="omxCmd('vol+')" class="omxCmd">
			<img src="img/vol+.png" class="invert vertCenter"/>
			vol+
		</a>

		<a href="#omxT-30" onclick="omxCmd('t-30')" class="omxCmd">
			<img src="img/rwd.png" class="invert vertCenter"/>
			t-30
		</a>
		<a href="#omxT+30" onclick="omxCmd('t+30')" class="omxCmd">
			<img src="img/fwd.png" class="invert vertCenter"/>
			t+30
		</a>

		<a href="#omxT-600" onclick="omxCmd('t-600')" class="omxCmd">
			<img src="img/rrwd.png" class="invert vertCenter"/>
			t-600
		</a>
		<a href="#omxT+600" onclick="omxCmd('t+600')" class="omxCmd">
			<img src="img/ffwd.png" class="invert vertCenter"/>
			t+600
		</a>
	</div>

	<div id="content">
		<h1>Raspberry Player</h1>
		<hr />

		<?php
		list_files($raw);
		?>
	</div>
</body>
</html>
