<?php
$music_file_name = "Faure-Introitus1.xml";

$myfile = fopen($music_file_name, "w") or die("Unable to open file!");

$txt = file_get_contents('http://localhost:8080/exist/rest/db/music/'.$music_file_name);

fwrite($myfile, $txt);

fclose($myfile);

shell_exec('LilyPond.app/Contents/Resources/bin/musicxml2ly '.$music_file_name);

shell_exec('LilyPond.app/Contents/Resources/bin/lilypond '.substr($music_file_name,0,-3)."ly");

?>
