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
