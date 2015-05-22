<?php
function convert($music_file_name){
	$myfile = fopen($music_file_name, "w+") or die("Unable to open file!");
        
	$txt = file_get_contents('http://localhost:8080/exist/rest/db/music/'.$music_file_name);

	fwrite($myfile, $txt);

	fclose($myfile);

	shell_exec('musicxml2ly '.$music_file_name);

	shell_exec('lilypond '.substr($music_file_name,0,-3)."ly");

	$file = substr($music_file_name,0,-3)."pdf";
	$filename = 'score.pdf';
	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="' . $filename . '"');
	header('Content-Transfer-Encoding: binary');
	header('Accept-Ranges: bytes');
	@readfile($file);

	echo "finished converting";
}
?>
