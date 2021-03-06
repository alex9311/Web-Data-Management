<?php
function convert($music_file_name){
	$file_name = 'scoretmp';

	$myfile = fopen($file_name.'.xml', "w+") or die("Unable to open file!");
        
	$txt = file_get_contents('http://localhost:8080/exist/rest/db/music/'.$music_file_name);

	fwrite($myfile, $txt);

	fclose($myfile);

	shell_exec('musicxml2ly '.$file_name.'.xml');

	shell_exec('lilypond '.$file_name.".ly");

	$file = $file_name.".pdf";
	$filename = 'score.pdf';
	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="' . $filename . '"');
	header('Content-Transfer-Encoding: binary');
	header('Accept-Ranges: bytes');
	@readfile($file);

	echo "finished converting";
}
?>
