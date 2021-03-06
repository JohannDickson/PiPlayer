<?php

$db = "./db.json";
$handler = fopen($db, 'r');
$raw = json_decode(fgets($handler), true);
fclose($handler);


$videoPath = '';
function list_files($tree){
	global $videoPath;
	$myPath = $videoPath;

	echo "<ul>";
	foreach ($tree as $key => $val){

		if ($key == "files"){
			foreach ($val as $file){
				$filePath = "$myPath/$file";
				echo "<li class=\"file\"><a href=\"#$file\" onclick=\"omxPlay('".addslashes($filePath)."')\">${file}<br /></a></li>";
			}
		} else {
			echo "<li class=\"directory\">".
				  "<span onclick=\"toggleChildren($(this).parent())\"><u>+</u></span>&nbsp;".
				  "<b>${key}</b>";

			$videoPath .= "/$key";

			list_files($val);

			echo "</li>";
		}
		$videoPath = $myPath;
	}
	echo "</ul>";
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
	<script type="text/javascript" src="/js/omx.js"></script>
	<script type="text/javascript">
		function toggleChildren(obj){
			$(obj).children("ul").each(function(){
				if ($(this).css('display') == 'none'){
					$(this).css('display','');
				} else {
					$(this).css('display', 'none');
				}
			});
		}

		$(document).ready(function(){
			toggleChildren($(".directory:not(:first)"));

			// Prevent streaming from loading page
			$('#stream_form').on("submit", function(e){
				e.preventDefault();

				form = $(this);
				f = form.context;

				$.ajax({
					url: f.action,
					method: f.method,
					data: form.serialize(),
				});
			});
		});
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

		<form id="stream_form" action="omx.php" method="GET" class="omxCmd">
			<input type="hidden" name="command" value="stream"></input>
			<input type="text" name="resource"></input>
			<input type="submit" value="Stream" />
		</form>
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
