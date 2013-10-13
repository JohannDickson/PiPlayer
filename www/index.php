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

		function omxStop(){
			$.ajax("omx.php",
			{
				type: "POST",
				data: {
					command: "stop"
				}
			});
		}
	</script>

</head>
<body>
	<h1>Raspberry Player</h1>

	<a href="#omxStop" onclick="omxStop()">Stop playing</a>

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
</body>
</html>
