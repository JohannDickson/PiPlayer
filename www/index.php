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
		$videoRoot = "/home/user/Public/Videos";
		$db = "./db.json";
		$handler = fopen($db, 'r');
		$raw = json_decode(fgets($handler));
		fclose($handler);
		foreach ($raw as $path => $files) {
			echo "<p><h3>$path</h3>";
			foreach ($files as $file) {
				$filePath = $videoRoot.$path."/".$file;
				echo "<a href=\"#$file\" onclick=\"omxPlay('".$filePath."')\">$file</a><br />";
			}
			echo "</p>";
		}
		?>
	</div>
</body>
</html>
