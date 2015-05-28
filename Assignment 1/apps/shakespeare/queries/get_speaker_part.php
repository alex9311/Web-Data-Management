<?php
require_once("query_helpers.php");
function get_speaker_part($title,$act,$scene,$speaker){
	$query = 'http://localhost:8080/exist/rest/db/shakespeare/plays?_query=';
	$query .= 'let $scene := //PLAY [TITLE = "'.$title.'"]/ACT['.$act.']/SCENE['.$scene.'],';
	$query .= '$speaker:= "'.$speaker.'",';
	$query .= '$title:= "'.$title.'",';
	$query .= '$actno:= "'.$act.'",';
	$query .= '$sceneno:= "'.$scene.'"';
	$xquery=<<<'XQUERY'
	return
		<div class="speeches">
		<h3>Parts of {$speaker} in {$title} - Act {$actno}, Scene {$sceneno} </h3>
			{for $speech in $scene/SPEECH return 
				if ($speech/SPEAKER=$speaker)
				then
					<div class="speech" style="background-color:rgb(51, 204, 255)">
					{$speech/SPEAKER/node()}: { for $line in $speech/LINE return string-join($line/node()," ")}</div>
				else
					<div class="speech">
					{$speech/SPEAKER/node()}: { for $line in $speech/LINE return  string-join($line/node()," ")}</div>
				}
		</div>
XQUERY;
	return execute_query($query.$xquery);
}
?>
